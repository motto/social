<?php
require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;

class ADT
{
    public static $jog="";
    public static $view_file="";
    public static $view="";
    public static $sql="";
    public static $datatomb=array();
    public static $allowed_func=array();
    public static $allowed_fget="";
}


ADT::$view_file='tmpl/'.GOB::$tmpl.'/content/nyito.html';


class Data extends DataBase
{

    public function alap($sql)
    {
        $sql="SELECT * FROM lng WHERE lap='nyito'  ";
        ADT::$datatomb= DB::assoc_tomb($sql);
    }
}
class View extends ViewBase{}
class App extends AppBase{}

$rates = GOB::$client->getExchangeRates('btc');
//echo $rates['rates']['HUF'];

GOB::$html = str_replace('<!--:zaszlo-->',MOD::enhu_zaszlo(),GOB::$html );
GOB::$html = str_replace('<!--:usd-->',$rates['rates']['USD'],GOB::$html );
