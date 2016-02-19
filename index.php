<?php
session_start();
// TODO: GOB get és set metódusok írása
// GodMode.{ED7BA470-8E54-465E-825C-99712043E01C}    új mappa és erre átnevezni
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//doc megjelenítés: ctrl+q

include_once 'definial.php';
include_once 'lib/db_fgv.php';
//include_once 'lib/lang.php';
include_once 'lib/factory.php';
include_once 'lib/jog.php';
include_once 'lib/html.php';
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
	public static $html='';
	public static $admin_data=array();
	public static $html_part=array();//head[],js,css,ogg stb
	public static $upload_dir='media/user2';
	public static $tmpl='oneday';
	public static $title='Oneday club';
	public static $app='admin';
	public static $user=Array();
	public static $hiba=array();
	public static $param=array();
	public static $adminok=array(62);
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

$db=DB::connect();

$azonosit= new Azonosit; //$_SESSION['userid']=62;

GOB::set_userjog();

GOB::$app=ADAT::GET_POST_SESS('app',GOB::$app);
include_once 'app/'.GOB::$app.'/'.GOB::$app.'.php';

?>

