<?php
session_start();
// TODO: GOB get és set metódusok írása
// GodMode.{ED7BA470-8E54-465E-825C-99712043E01C}    új mappa és erre átnevezni
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//doc megjelenítés: ctrl+q

include_once 'definial.php';

include_once 'lib/lang.php';
include_once 'lib/factory.php';
include_once 'lib/jog.php';
include_once 'lib/html.php';
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
	public static $html_part=array();
	public static $head;//js,css,ogg stb
	public static $bodyhead;//js,css stb
	public static $upload_dir='media/user2';
	public static $tmpl='oneday';
	public static $title='Oneday club';
	public static $app='base';
	public static $user=Array();
	public static $hiba=array();
	public static $param=array();
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




// adatbázis elérés------------------------------------------------------
include_once 'lib/db_fgv.php';  //adatbázis
$db=DB::connect();
include_once 'lib/jog.php'; // azzonosítás jogosultságok

//azonosítás jogok--------------------------------------------------
$azonosit= new Azonosit; //
//$_SESSION['userid']=62;
GOB::set_userjog();

include_once ALTALANOS_FGV;

GOB::$app=session_post_get('app',GOB::$app);
include_once 'app/'.GOB::$app.'/'.GOB::$app.'.php';

?>

