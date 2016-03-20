<?php
include_once'app/admin/lib/tablas_alap.php';
require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;

ADT::$jog='admin';
ADT::$ikonsor=array('pub','unpub');
ADT::$view_file='app/admin/view/tabla_alap.html';
ADT::$datatomb_sql="SELECT p.id,p.userid,u.username,u.tarca,p.tr_cim, SUM(p.satoshi) AS egyenleg FROM penztar p INNER JOIN userek u ON p.userid=u.id GROUP BY p.userid";
ADT::$tablanev='penztar';
ADT::$tabla_szerk =array(
    array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
    array('cim'=>'Tárcanév','mezonev'=>'tarcanev','tipus'=>''),
    array('cim'=>'bejövő','mezonev'=>'amount','tipus'=>'')
);

class SDT{
public static $azonok='';
public static $notarcaT=array('BTC Wallet','Base','Deleted base','ggg');
public static $szazalekT=array(14,8,4,2,1,0.4,0.2,0.1);//ref jutalék százalékok
public static $szazalekU=71;//sajat szazalék
public static $utalT=array(); //végrehajtandó utalások adatai
}

class PdataS{
    public static function azonok_to_tomb($azonok)
    {
        $tomb=explode(',',$azonok);
        foreach ($tomb as $sor) {
           $sorT= explode(':',$sor);
           $res[$sorT[0]]=array('sorazon'=>$sorT[0],'balance'=>$sorT[1],'accountid'=>$sorT[2]);

        }
        return $res;
    }

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
            if($balance->getAmount()>0)
            {
                ADT::$datatomb['sor'.$k] =Array('id'=>'sor'.$k,'tarcanev'=>$account->getName() ,'trcim'=>'bejövő','accountid'=>$account->getId() ,'amount'=>$balance->getAmount());
                SDT::$azonok=  SDT::$azonok.'sor'.$k.':'.$balance->getAmount().
            ':'.$account->getId().',';
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
        foreach (SDT::$utalT as $sorid=>$utalT )
        {
            if(!in_array(ADT::$datatomb[$sorid]['tarcanev'],SDT::$notarcaT))
            {
                $eredeti_oszzeg=ADT::$datatomb[$sorid]['amount']/0.00000001;
                $maradek_oszzeg=$eredeti_oszzeg;

                foreach($utalT as $utal)
                { $sql="SELECT tarca FROM tarcak WHERE userid='".$utal['cim']."'";
                    $sor=DB::assoc_sor($sql);
                    $szazalek=$utal['szazalek']/100;
                    $osszeg=$eredeti_oszzeg*$szazalek;
                    $accountid=ADT::$datatomb[$sorid]['accountid'];
                    PdataS::utal($accountid,$osszeg,$sor['tarca']);
                    $maradek_oszzeg=$maradek_oszzeg-$osszeg;
                    $sql="INSERT INTO penztar (userid,tr_cim,satoshi,megjegyzes)VALUES(".$utal['cim'].",'jutalek:".$utal['szazalek']."%','".$osszeg."','kuldo accountid:". $accountid."')";
                  $beszurtid = DB::assoc_tomb($sql);
                }
            }
            $sql="INSERT INTO penztar (userid,tr_cim,satoshi,megjegyzes)VALUES('0','jutalek','".$maradek_oszzeg."','kuldo accountid:". $accountid."')";
               $beszurtid2 = DB::assoc_tomb($sql);
            PdataS::utal($accountid,$osszeg,GOB::$tarcaBase);
        }


    }

}

class Admin extends AdminBase
{

    public function pub()
    {// echo $_POST['azonok'] ;
       // PdataS::ujleker();

        foreach (ADT::$idT as $sorid)
        { $azonT=PdataS::azonok_to_tomb($_POST['azonok']);
           $accountid=$azonT[$sorid]['accountid'];
            //echo $tarcanev.'-----------------';
            $sql="SELECT id,userid,tarca FROM tarcak  WHERE accountid ='".$accountid."'";
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
            //egyenlőre nem csinál semmit ha nem felhasználóé a tárca
            }
        }
       // print_r(SDT::$utalT);

        PdataS::utal_from_utalT();
      //  echo 'Utalás megtörtént';
        $this->alap();
    }


    public function alap()
    {
        PdataS::ujleker();
        ADT::$datatabla=MOD::tabla(ADT::$tabla_szerk,ADT::$datatomb);
        ADT::$view=MOD::ikonsor(ADT::$ikonsor);
        ADT::$view=str_replace('<!--|tabla|-->', ADT::$datatabla, ADT::$view );
        $hidden='<input type="hidden" name="azonok" value="'.SDT::$azonok.'">';
        ADT::$view=str_replace('<!--|hidden|-->', $hidden, ADT::$view );
    }

};

if(isset($_POST['sor'])){//print_r($_POST['sor']);
}

$app=new Admin();
$fn=TASK_S::get_funcnev($app);
//ADT::$datasor_sql="SELECT * FROM faucet WHERE id='".ADT::$id."' ";

$app->$fn();