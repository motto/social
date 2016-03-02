<?php
require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;

class ADT
{
    public static $allowed_fget=array();
    public static $task='alap';
    public static $userid='0';
    public static $html='';
    public static $html_file='nyitotxt.html';
    public static $lang_cseretomb=array();
    public static $lang_db_cseretomb=array();
    public static $lang_dbtomb=array();
}

/**
 * feltölti a lapváltozókat ADT::userid, ADT::lapid;
 */
class Lap
{

    public function __construct()
    {
       ADT::$userid=$_SESSION['userid'];
       ADT::$html=file_get_contents('tmpl/'.GOB::$tmpl.'/'.ADT::$html_file, true);

    }
}

/**
 * Az adattömbök feltöltését végzi ADT:: itemtömb stb
 */
class Adatok
{

    public function __construct()
    {
        $this->lang_dbtomb_feltolt();
       // $this->logol();
    }

    public  function logol()
    {
        $sql1= "DELETE FROM faucet_log WHERE userid = '".ADT::$userid."' AND linkid = '".ADT::$itemid."' ";
        DB::parancs($sql1);
        $sql= "INSERT INTO faucet_log (userid,linkid,mktime)VALUES ('".ADT::$userid."','".ADT::$itemid."','".ADT::$mktime."')";
        DB::beszur($sql);
    }
    public function lang_dbtomb_feltolt()
    {
        $sql="SELECT * FROM faucet WHERE pub='0' ORDER BY pont DESC ";
        $sql_log="SELECT * FROM faucet_log WHERE userid='".ADT::$userid."'" ;
        $linktomb=DB::assoc_tomb($sql);
        $logtomb=DB::assoc_tomb($sql_log);
       // $logtomb_idkulcs=TOMB::mezobol_kulcs($logtomb,'linkid');


    }

}
class View
{
    public $elotag='<!--#';
    public $utotag='-->';


   public function lang_feltolt($view,$datatomb,$cseretomb)
    {
        if(is_array($cseretomb))
        {
            foreach($cseretomb as $value)
            {   if(isset($datatomb[$value]))
                {
                    $csere_str=$this->elotag.$value.$this->utotag;
                    $view= str_replace($csere_str, $datatomb[$value], $view);
                }

            }
        }
        return $view;
    }

    public function mod_feltolt($view,$datatomb,$cseretomb)
    {
        $this->elotag='<!--:';
        $view= $this->lang_feltolt($view,$datatomb,$cseretomb);
        return $view;
    }
}
$apiKey='duqWXbUlCKH8qNg8';
$apiSecret='DE4hteGw1nAzRwpxh4hPVN8dwRBjSBCL';

$configuration =Configuration::apiKey($apiKey, $apiSecret);
$client = Client::create($configuration);
$rates = $client->getExchangeRates('btc');
//echo $rates['rates']['HUF'];
;
$lap=new Lap();
//$adatok=new Adatok();
$matches='';
preg_match_all ("/<!--#([^`]*?)-->/",ADT::$html , $matches);
ADT::$lang_cseretomb=$matches[1];
$view=new View();
ADT::$html=$view->lang_feltolt(ADT::$html,GOB::$LT,ADT::$lang_cseretomb);
ADT::$html = str_replace('<!--:zaszlo-->',MOD::enhu_zaszlo(),ADT::$html );
ADT::$html = str_replace('<!--:usd-->',$rates['rates']['USD'],ADT::$html );
echo ADT::$html;