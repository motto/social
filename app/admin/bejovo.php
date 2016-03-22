<?php
include_once'app/admin/lib/tablas_alap.php';
require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
//küldés---------
use Coinbase\Wallet\Enum\CurrencyCode;
use Coinbase\Wallet\Resource\Transaction;
use Coinbase\Wallet\Value\Money;
ADT::$jog='admin';
ADT::$ikonsor=array('pub','unpub');
//ADT::$view_file='app/admin/view/tabla_alap.html';
ADT::$datatomb_sql="SELECT p.id,p.userid,u.username,u.tarca,p.tr_cim, SUM(p.satoshi) AS egyenleg FROM penztar p INNER JOIN userek u ON p.userid=u.id GROUP BY p.userid";
ADT::$tablanev='penztar';
ADT::$tabla_szerk =array(
    array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
    array('cim'=>'Tárcanév','mezonev'=>'tarcanev','tipus'=>''),
    array('cim'=>'bejövő','mezonev'=>'amount','tipus'=>'')
);

class SDT{
    //paraméterek
public static $notarcaT=array('BTC Wallet','Base','Deleted base','ggg');
public static $szazalekT=array(71,14,8,4,2,1,0.4,0.2,0.1);//ref jutalék százalékok
//változók--------------------
public static $satoshi=0;
public static $accuserid=0;
}

class PdataS{

public static function refleker($userid)
{
    $sql="SELECT ref FROM userek WHERE id='".$userid."'";
    $res=DB::assoc_sor($sql);
    if(empty($res)){return 0;}else{return $res['ref'];}
}
    public static function tarca_leker($userid)
    {
        $sql="SELECT id,userid,tarca FROM tarcak  WHERE userid ='".$userid."'";
        $res=DB::assoc_sor($sql);
        if(empty($res)){return 0;}else{return $res['tarca'];}
    }

    public static function ujleker()
    {
        $accounts =GOB::$client->getAccounts();

        foreach ($accounts as &$account)
        {
            $balance = $account->getBalance();
            if($balance->getAmount()>0)
            {
                ADT::$datatomb[] =Array('id'=>$balance->getAmount().
            ':'.$account->getId(),'tarcanev'=>$account->getName() ,'trcim'=>'bejövő','accountid'=>$account->getId() ,'amount'=>$balance->getAmount());

            }

        }

    }
    public static function utal($accountid,$osszeg,$to_tarca,$uzenet=' ')
    {
        $result=true;
        $account= GOB::$client->getAccount($accountid);
        $transaction = Transaction::send([
            'toBitcoinAddress' => $to_tarca,
            'amount'           => new Money($osszeg, CurrencyCode::BTC),
            'description'      => $uzenet,
            'fee'              => '0.0001' // only requi..
        ]);

        try {
            GOB::$client->createAccountTransaction($account, $transaction);
            $response=GOB::$client->decodeLastResponse();
            if(!$response['data']['status'] == 'pending')
            {
                $result=false;
                GOB::$hiba['coin'][]='status hiba történt tranzakció közben! accountid:'.$accountid.', to tarca:'.$to_tarca.', osszeg: '.$osszeg.' uzenet: '.$uzenet;
            }


        } catch (Exception $e)
        {
            GOB::$hiba['coin'][]='1-es szintű hiba történt tranzakció közben!accountid:'.$accountid.', to tarca:'.$to_tarca.', osszeg: '.$osszeg.' uzenet: '.$uzenet;
            $result=false;
        }
        return $result;
    }
    public static function utal_todb($userid,$accountid,$maradek,$i=0)
    {
        $szazalek = SDT::$szazalekT[$i] / 100;
        $osszeg = SDT::$satoshi* $szazalek;
        if($osszeg<=$maradek)
        {
            $maradek = $maradek - $osszeg;
            if($i==0)
            {$megjegyzes='rotator jovairás';
            }
            else
            { $megjegyzes='jutalek:' . $szazalek*100 . '%';}


            $sql = "INSERT INTO penztar (userid,tr_cim,satoshi,megjegyzes)VALUES('" . $userid . "','" .$megjegyzes . "','" . $osszeg . "','kuldo accountid:" . $accountid . "')";
           // echo $sql;
             DB::parancs($sql);
        }
       else
       {
           GOB::$hiba['bejovo'][]='elfogyott a jutalék. összeg:'.$osszeg.',maradék:'.$maradek.'szint:'.$i;
       }

        return $maradek;
    }
    public static function accountid_to_userid($accountid)
    {
        $sql = "SELECT u.id,t.tarca FROM userek u INNER JOIN tarcak t ON u.tarcaid=t.id   WHERE accountid ='".$accountid ."'";
        $userT = DB::assoc_sor($sql);
        if(isset($userT['id']))
        { SDT::$accuserid=$userT['id'];
          return true;
        }
        else
        {
            GOB::$hiba['bejovo'][] = 'ezzel az accountiddel nincs felhasználó';
            return false;
        }
    }
}

class Admin extends AdminBase
{

public function pub()
{
    if (isset($_POST['sor']))
    {
    foreach ($_POST['sor'] as $sor)
    {
        $sorT = explode(':', $sor);
        $accountid = $sorT[1];$amount = $sorT[0];
        SDT::$satoshi=$amount/0.00000001;
        if(PdataS::accountid_to_userid($accountid))
        {
            if(PdataS::utal($accountid, $amount,GOB::$tarcaBase,'bejovo'))
            {
            //user rész elküldése-------------------
            $maradek =PdataS::utal_todb(SDT::$accuserid,$accountid,SDT::$satoshi,0);
            //rfjutalékok leosztása----------------------
            $refid = PdataS::refleker(SDT::$accuserid);
            $i = 1;
                while ($refid > 0)
                {
                    if ($refid > 0)
                    {
                    $maradek = PdataS::utal_todb($refid, $accountid,$maradek, $i);
                    $refid = PdataS::refleker($refid);
                    $i++; if ($i > 8) {$refid = 0;}
                    }
                }

                if ( $maradek> 0)
                {
                DB::parancs("INSERT INTO penztar (userid,tr_cim,satoshi,megjegyzes)VALUES('0','jutalek maradék','" .$maradek . "','kuldo accountid:" . $accountid . "')");
                }
            }
        }
    }
    }

    $this->alap();

}

    public function alap()
    {
        $hiba='';
        PdataS::ujleker();
        ADT::$datatabla=MOD::tabla(ADT::$tabla_szerk,ADT::$datatomb);
        ADT::$view=MOD::ikonsor(ADT::$ikonsor);
        ADT::$view=str_replace('<!--|tabla|-->', ADT::$datatabla, ADT::$view );
        if(isset(GOB::$hiba['belep']))
        {$hiba=FeltoltS::hibakiir(GOB::$hiba['belep']);}
        if(isset(GOB::$hiba['coin']))
        {$hiba=$hiba.FeltoltS::hibakiir(GOB::$hiba['coin']);}
       ADT::$view=str_replace('<!--|hiba|-->', $hiba, ADT::$view );
    }

};

if(isset($_POST['sor'])){//print_r($_POST['sor']);
}

$app=new Admin();
$fn=TASK_S::get_funcnev($app);
//ADT::$datasor_sql="SELECT * FROM faucet WHERE id='".ADT::$id."' ";

$app->$fn();