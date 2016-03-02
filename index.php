<?php
session_start();
// GodMode.{ED7BA470-8E54-465E-825C-99712043E01C}    új mappa és erre átnevezni
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//doc megjelenítés: ctrl+q

include_once 'definial.php';
include_once 'lib/db_fgv.php';
//include_once 'lib/factory.php';
include_once 'lib/jog.php';
//include_once 'lib/html.php';
include_once 'lib/altalanos_fgv.php';
include_once 'mod/mod.php';

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
	public static $LT=array(); //nyelvi tömb
	public static $html='';
	public static $admin_data=array();
	public static $html_part=array();//head[],js,css,ogg stb
	public static $upload_dir='media/user2';
	public static $tmpl='flat';
	public static $title='Social';
	public static $app='admin';
	public static $user=Array();
	public static $hiba=array();
	public static $param=array();
	public static $adminok=array(3,4);
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
//adatbázis,azonosítás--------------------
$db=DB::connect();
$azonosit= new Azonosit; //$_SESSION['userid']=62;
GOB::set_userjog();
//nyelv-----------------------------------
if(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)=='hu'){GOB::$lang= 'hu';}
if(isset($_SESSION['lang'])){GOB::$lang=$_SESSION['lang'];}
if(isset($_GET['lang'])){GOB::$lang=$_GET['lang'];$_SESSION['lang']=$_GET['lang'];}
include_once('lang/'.GOB::$lang.'.php');
//applikáció becsatolás-----------------------------
GOB::$app=ADAT::GET_POST_SESS('app',GOB::$app);
include_once 'app/'.GOB::$app.'/'.GOB::$app.'.php';

?>

