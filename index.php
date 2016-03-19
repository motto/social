<?php
session_start();
// GodMode.{ED7BA470-8E54-465E-825C-99712043E01C}    új mappa és erre átnevezni
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//doc megjelenítés: ctrl+q
//nyelv-----------------------------------
if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)=='hu'){GOB::$lang= 'hu';}
if(isset($_SESSION['lang'])){GOB::$lang=$_SESSION['lang'];}
if(isset($_GET['lang'])){GOB::$lang=$_GET['lang'];$_SESSION['lang']=$_GET['lang'];}
include_once('lang/'.GOB::$lang.'.php');
if(isset($_GET['ref'])){$_SESSION['ref']=$_GET['ref'];}
include_once 'definial.php';
include_once 'lib/db_fgv.php';
include_once 'lib/jog.php';
include_once 'lib/altalanos_fgv.php';
include_once 'app/app.php'; //taskválasztó
include_once 'mod/mod.php';
include_once 'mod/login/login.php';
//include_once 'mod/login/lt.php';
//include_once 'mod/mod_alap.php';
include_once 'lib/view_feltolt.php'; //nézet feltöltő függvények
require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use Coinbase\Wallet\Resource\Account;

if(MoConfig::$offline=='igen'){ //offline módban kikapcsolja a weblapot
				if($jogok_gt['stat']!='admin'){die(MoConfig::$offline_message);
				return false;
				}
}
/**
 * Class GOB
 * globális változók
 */
class GOB {
	private static $userjog=Array();
	public static $lang='en';
	public static $log_mod=true;
	public static $LT=array(); //nyelvi tömb
	public static $html='';
	public static $admin_data=array();
	public static $html_part=array();//head[],js,css,ogg stb
	public static $upload_dir='media/user2';
	public static $tmpl='flat';
	public static $title='Social';
	public static $app='base';
	public static $user=Array();
	public static $hiba=array();
	public static $param=array();
	public static $adminok=array(3,4);
	public static $coinKey='duqWXbUlCKH8qNg8';
	public static $coinSecret='DE4hteGw1nAzRwpxh4hPVN8dwRBjSBCL';
	public static $tarcaBase='1FzgRFSFRS6aPxEWXS9yG9o4ZSPuCrvmTR';
	public static $tarcaDelBase='13gc8kS3K1NJcSWXm3yC4Y5pcmrV6QrCaQ';
	public static $client=null;
	/**
	 * @var string
	 * '' (alapértelmezés) az adminok csak saját cikkeiket szerkeszthetik
	 * 'kozos' az adminok egymás cikkeit szerkeszthetik
	 * 'tulajdonos' Az adminok szerkeszthetnek minden cikket
	 */
	public static $admin_mod='';

	public static function get_userjog($jogname){
		if(in_array($jogname,self::$userjog)){return true;}
		else{return false;}
	}

	public static function set_userjog(){
		self::$userjog=Jog::fromGOB();
	}
}
$configuration =Configuration::apiKey(GOB::$coinKey, GOB::$coinSecret);
GOB::$client = Client::create($configuration);
//$client = Client::create($configuration);
//$accounts =$client->getAccount('');
//adatbázis,azonosítás--------------------
$db=DB::connect();
if(isset($_POST['ltask']) && $_POST['ltask']=='belep')
{
if(LogDataS::belep()){GOB::$log_mod=false;}
}
$azonosit= new Azonosit; //$_SESSION['userid']=62;
GOB::set_userjog();
GOB::$user=DB::assoc_sor("SELECT id,kifcim,username,email,password FROM userek WHERE id='".$_SESSION['userid']."'");
//applikáció becsatolás-----------------------------
//GOB::$app=ADAT::GET_POST_SESS('app',GOB::$app); //a session könnyen bekavar!

if(isset($_POST['app'])){GOB::$app=$_POST['app'];}
if(isset($_GET['app'])){GOB::$app=$_GET['app'];}
include_once 'app/'.GOB::$app.'/'.GOB::$app.'.php';

?>

