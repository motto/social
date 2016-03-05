<?php
class MOD
{
public static function zaszlo()
{
    include_once 'mod/zaszlo/zaszlo.php';
    $zaszlo=new Zaszlo();
    return $zaszlo->eng_hu();
}
public static function btc()
{
    $rates = GOB::$client->getExchangeRates('btc');
    return $rates['rates']['USD'];
}

public static function login()
    {   $func='alap';
        include_once 'mod/login/login.php';
        $login=new Login();
       if(isset($_POST['task'])){ $func=$_POST['task'];}
         $login->$func();
            return $login->tartalom;
    }
}