<?php
//namespace Login;
class LogADT
{
    public static $itemid='0';
    public static $jog='noname';
    public static $tablanev='userek';
    public static $reg_form='mod/login/view/regisztral_form.html';
    public static $belep_form='mod/login/view/belep_form.html';
    public static $belepve_form='mod/login/view/belepve_form.html';
    public static $valtoztat_form='mod/login/view/valtoztat_form.html';
    public static $tiltott_func=array('belep_form','szerk','reg','ment','belep','kilep');

    public static $mentmezok=array
    (
        array('mezonev'=>'username'),
        //array('mezonev'=>'','postnev'=>'','ell'=>'','tipus'=>''),
        array('mezonev'=>'mail'),
        array('mezonev'=>'password'),
        array('mezonev'=>'ref')
    );
}

class Login
{
    public $tartalom='';
   // public function __construct($appview,$appdata){}
    public function belepform()
    {
        $this->tartalom= file_get_contents(LogADT::$belep_form, true);

    }
    public function belep()
    {
        if(MDataStat::belep())
        {
            $tartalom= file_get_contents(LogADT::$belepve_form, true);
        }
        else
        {
            $hiba=MDataStat::hibakiir();
            $view= file_get_contents(LogADT::$belep_form, true);
            $tartalom = str_replace('<!--<h5>hiba</h5>-->', $hiba, $view);
        }
        $this->tartalom=$tartalom;

    }
    public function alap()
    {
        if($_SESSION['userid']>0)
        {
            $tartalom= file_get_contents(LogADT::$belepve_form, true);
        }
        else
        {
            $tartalom= file_get_contents(LogADT::$belep_form, true);
        }
        $this->tartalom=$tartalom;

    }
    public function kilep(){
        $_SESSION['userid']=0;
        $this->alap();
       
    }
    public function szerk()
    {
        $this->tartalom= file_get_contents(LogADT::$valtoztat_form, true);

    }
    public function reg()
    {
        $view=file_get_contents(LogADT::$reg_form, true);
        if(isset($_GET['ref']))
        {
            $view= str_replace('<!--<h5>ref</h5>-->','Referencia:'. $_GET['ref'], $view);
            $view= str_replace('data="ref"','value="'.$_GET['ref'].'"', $view);
        }

        $this->tartalom =  $view;

    }
    public function ment()
    {

        if(MDataStat::ment())
        {
            $this->alap();
        }
        else
        {
            $view= file_get_contents(LogADT::$reg_form, true);
            $hiba=MDataStat::hibakiir();
            $tartalom = str_replace('<!--<h5>hiba</h5>-->', $hiba, $view);
            $this->tartalom=$tartalom;
        }

    }
}
class MData {}
class MDataStat {
    public static function ment()
    {
        $hiba=true;
        $jelszo = md5($_POST['password']);
        $jelszo2 = md5($_POST['password2']);
        $usernev = $_POST['username'];
        if($jelszo!=$jelszo2)
        {
            GOB::$hiba['login'][]='A két jelszó nem egyezik!';
            $hiba=false;
        }
        if(!self::usernev_ell($usernev))
        {
            $hiba=false;
        }

        if($hiba)
        {
            $sql = "SELECT username FROM " .LogADT::$tablanev. " WHERE username='" .$usernev."'";
            $marvan=DB::assoc_sor($sql);
            if($marvan['username']==$usernev)
            {
                GOB::$hiba['login'][]='Már van ilyen felhasználónév';
                $hiba=false;
            }

        }
        if($hiba)
        {
            $beszurtid=DB::beszur_postbol(LogADT::$tablanev,LogADT::$mentmezok);
            if($beszurtid==0)
            {
                GOB::$hiba['login'][]='Adatbázis hiba';
                $hiba=false;
            }
            else
            {
               // $configuration =Configuration::apiKey(Coin::$apiKey, Coin::$apiSecret);
               // $client = Client::create($configuration);
               // $client->enableActiveRecord();
                $account = new Account();
                $account->setName($usernev);
                GOB::$client->createAccount($account);
                $accountid=$account->getId();
                $address = new Address();
                GOB::$client->createAccountAddress($account, $address);
                $adressid=GOB::$client->getAccountAddresses($account)->getFirstId();
                $address=GOB::$client->getAccountAddress($account,$adressid)->getAddress();
                if($address!=''){
                    $ql="UPDATE userek SET tarca='".$address."', tarcaid='".$adressid."', accountid='".$accountid."' WHERE id='".$beszurtid."'";
                    DB::parancs($ql);
                }
                else
                {echo 'nincs address';}

            }
        }
        return $hiba;
    }
    public static function hibakiir()
    {$result='';
        foreach(GOB::$hiba['login'] as $hiba)
        {
            $result=$result.$hiba.'</br>';
        }
        return $result;
    }
    public static function usernev_ell($usernev)
    {
        $result=true;
        $Regex_hu_tobbszo='/^[a-zA-Z\d éáűúőóüöÁÉŰÚŐÓÜÖ]+$/';
        $Regex_minmax='/^.{5,20}$/';
        if(preg_match($Regex_minmax,$usernev)!=1)
        {
            GOB::$hiba['login'][]= 'A felhasználó névnek min 5 max 20 karakternek kell lenni!';
            $result=false;
        }
        if(preg_match($Regex_hu_tobbszo,$usernev)!=1)
        {
            GOB::$hiba['login'][]='A felhasználó név nem tartalmazhat "különleges karaktereket" ! Csak kis és nagybetűket (ékeztest is), szóközöket és számokat ';
            $result=false;
        }
        return $result;
    }
    public static function belep()
    {   $result=true;
        $jelszo = md5($_POST['password']);
        $usernev = $_POST['username'];

        if(self::usernev_ell($usernev))
        {
            $sql="SELECT id,password FROM ".LogADT::$tablanev." WHERE username='".$usernev."'";
            $dd=DB::assoc_sor($sql);
            if($jelszo!=$dd['password'])
            {
                GOB::$hiba['login']='A felhasználónév vagy a jelszó nem jó!';
                $result=false;
            }
            else
            {
                $_SESSION['userid']=$dd['id'];
            }
        }
        return $result;
    }

}
class AppView {


}

