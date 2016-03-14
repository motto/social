<?php
include_once'app/admin/lib/tablas_alap.php';
require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;



ADT::$jog='admin';
ADT::$ikonsor=array('pub','unpub');
ADT::$view_file='app/admin/view/tabla_alap.html';
//ADT::$urlap_file ='app/admin/view/faucet_urlap.html';
ADT::$datatomb_sql="SELECT p.id,p.userid,u.username,u.tarca,p.tr_cim, SUM(p.satoshi) AS egyenleg FROM penztar p INNER JOIN userek u ON p.userid=u.id GROUP BY p.userid";


ADT::$tablanev='penztar';
ADT::$tabla_szerk =array(
    array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
    // array('cim'=>'','mezonev'=>'pub','tipus'=>'pubmezo'),
    array('cim'=>'Tárcanév','mezonev'=>'tarcanev','tipus'=>''),
    // array('cim'=>'Usernév','mezonev'=>'username','tipus'=>''),
    // array('cim'=>'Tranzakio','mezonev'=>'tr_cim','tipus'=>''),
    // array('cim'=>'Tárca cím','mezonev'=>'tarca','tipus'=>''),
    //  array('cim'=>'Egyenleg','mezonev'=>'egyenleg','tipus'=>''),
    array('cim'=>'bejövő','mezonev'=>'amount','tipus'=>'')
    // array('cim'=>'utolsó módosítás','mezonev'=>'ido','tipus'=>'')
);
ADT::$ment_mezok =array(
    array('mezonev'=>'link'),
    //array('mezonev'=>'','postnev'=>'','ell'=>'','tipus'=>''),
    array('mezonev'=>'leiras','tipus'=>'text'),
    array('mezonev'=>'megjegyzes'),
    array('mezonev'=>'perc'),
    array('mezonev'=>'pont'));
class SDT{
public static $notarcaT=array('BTC Wallet','Base','Deleted base','ggg');
public static $szazalekT=array(50,9,8,7,6,5,4,3,2,1);//ref jutalék százalékok szintenként
public static $utalT=array(); //végrehajtandó utalások adatai
//public static $bejovoT=array(); //uj satoshival rendelkező tárcák adatai id nev  osszeg
//public static $jutalekT=array();
}

class PdataS{
public static function refleker($userid)
{
    $sql="SELECT ref FROM userek WHERE id='".$userid."'";
    $res=DB::assoc_sor($sql);
    if(empty($res)){return 0;}else{return $res['ref'];}
}

    public static function ujleker()
    {
        $accounts =GOB::$client->getAccounts();
        $k=1;
        foreach ($accounts as &$account)
        {
            $balance = $account->getBalance();
            // $adressid=$client->getAccountAddresses($account)->getFirstId();
            // $address=$client->getAccountAddress($account,$adressid)->getAddress();
            if($balance->getAmount()>0)
            {
                ADT::$datatomb['sor'.$k] =Array('id'=>'sor'.$k,'tarcanev'=>$account->getName() ,'trcim'=>'bejövő','accountid'=>$account->getId() ,'amount'=>$balance->getAmount());
                //SDT::$bejovoT['']
            }
         $k++;
        }

    }
    public static function utal($accountid,$osszeg,$to_tarca,$uzenet=' ')
    {//echo $accountid;
        $account= GOB::$client->getAccount($accountid);
        $transaction = Transaction::send([
            'toBitcoinAddress' => $to_tarca,
            'amount'           => new Money($osszeg, CurrencyCode::BTC),
            'description'      => $uzenet,
            'fee'              => '0.0001' // only requi..
        ]);
        GOB::$client->createAccountTransaction($account, $transaction);
    }
    public static function utal_from_utalT()
    {
        //$accounts =GOB::$client->getAccounts();
        //$accounts =GOB::$client->getAccounts();
        foreach (SDT::$utalT as $sorid=>$utalT )
        {
            if(!in_array(ADT::$datatomb[$sorid]['tarcanev'],SDT::$notarcaT))
            {   //echo 'sorid:'.$sorid;
               // print_r(ADT::$datatomb[$sorid]);
                $eredeti_oszzeg=ADT::$datatomb[$sorid]['amount']/0.00000001;
                $maradek_oszzeg=ADT::$datatomb[$sorid]['amount']/0.00000001;
               // echo 'utal_oszzeg'. $utal_oszzeg;
                foreach($utalT as $utal)
                { $sql="SELECT tarca FROM tarcak WHERE userid='".$utal['cim']."'";
                    $sor=DB::assoc_sor($sql);

                    $szazalek=$utal['szazalek']/100;
                   // print_r($utal);
                    $osszeg=$eredeti_oszzeg*$szazalek;

                    $accountid=ADT::$datatomb[$sorid]['accountid'];
                    PdataS::utal($accountid,$osszeg,$sor['tarca']);
                    $maradek_oszzeg=$maradek_oszzeg-$osszeg;
                    $sql="INSERT INTO penztar (userid,tr_cim,satoshi,megjegyzes)VALUES(".$utal['cim'].",'jutalek:".$utal['szazalek']."%','".$osszeg."','kuldo accountid:". $accountid."')";    // echo $sql;
                  $beszurtid = DB::assoc_tomb($sql);
                }
            }// print_r($utal);
            $sql="INSERT INTO penztar (userid,tr_cim,satoshi,megjegyzes)VALUES('0','jutalek','".$maradek_oszzeg."','kuldo accountid:". $accountid."')";
               $beszurtid2 = DB::assoc_tomb($sql);
            PdataS::utal($accountid,$osszeg,GOB::$tarcaBase);
        }


    }

}

class Admin extends AdminBase{

    public function pub()
    {
        PdataS::ujleker();
        //utaltomb előállítása---------
        foreach (ADT::$idT as $sorid)
        { //print_r(ADT::$datatomb[$sorid]);
           $tarcanev=ADT::$datatomb[$sorid]['tarcanev'];
            //echo $tarcanev.'-----------------';
            $sql="SELECT id,userid  FROM tarcak  WHERE tarcanev='".$tarcanev."'";
            $tT=DB::assoc_sor($sql);
        // echo $tT['userid'].'-----------------';
            if(isset($tT['userid']))
            {
                $i=1;
            $refid=$tT['userid'];
            SDT::$utalT[$sorid][]=array('cim'=>$tT['userid'],'szazalek'=>SDT::$szazalekT[0]);

                while ($refid>0)
                {
                    $refid =PdataS::refleker($refid);
                    if($refid>0)
                    {
                  SDT::$utalT[$sorid][]=array('cim'=>$refid,'szazalek'=>SDT::$szazalekT[$i]);
                    }
                  $i++;
                }
            }
            else
            {
            //egyenlőre nem csinál semmit hanem felhasználóé a tárca
            }
        }
       // print_r(SDT::$utalT);

        PdataS::utal_from_utalT();
        echo 'Utalás megtörtént';
        $this->alap();
    }


    public function alap()
    {
        PdataS::ujleker();
        ADT::$datatabla=MOD::tabla(ADT::$tabla_szerk,ADT::$datatomb);
        AppView::alap();

    }

};

if(isset($_POST['sor'])){//print_r($_POST['sor']);
}

$app=new Admin();
$fn=TASK_S::get_funcnev($app);
//ADT::$datasor_sql="SELECT * FROM faucet WHERE id='".ADT::$id."' ";

$app->$fn();