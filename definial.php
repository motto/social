<?php 
//GodMode.{ED7BA470-8E54-465E-825C-99712043E01C}
//állandók--------------------------------
define("DS", "/"); define("PATH_SITE", $_SERVER['DOCUMENT_ROOT']); define("_MOTTO", "igen"); 
//file elérések----------------------------------------------------

define('MEDIA', 'media/');define('USEREK', 'media/');
define('IKONOK', 'media/kepek/');define('KEPEK', 'media/kepek/');
define('SAJAT_MAPPA','lib/');define('LIB','lib/');
define('PLUGINOK_PATH','app/pluginok/');
define('COM_PATH','app/com/');
define('LANG_DIR','language/');
define('MODULOK_PATH','app/modulok/');
define('JOGOK', SAJAT_MAPPA.'jog.php');
define('KERET_PHP',SAJAT_MAPPA.'keret.php');
define('ADATOK_PHP',SAJAT_MAPPA.'adatok.php');
define('DB_FGV',SAJAT_MAPPA.'db_fgv.php');
define('ADMIN_FGV',COM.'/admin/helper/admin_fgv.php');
define('ALTALANOS_FGV',SAJAT_MAPPA.'altalanos_fgv.php');

class MoConfig {

//public static $felhasznalonev = 'pnet354_motto001';
//public static $jelszo = 'motto6814';
//public static $adatbazis = 'pnet354_motto001_oneday';
public static $host = 'localhost';
public static $felhasznalonev = 'root';
public static $jelszo = '';
public static $adatbazis = 'fejleszt';
public static $mailfrom= 'motto001@gmail.com';
public static $fromnev= 'Admin'; 
public static $offline = 'nem'; //igen bekapcsolja az offline módot
public static $offline_message = 'Weblapunk fejlesztés alatt.';
}
/*
GOB::$tmpl['alap']='alap';
GOB::$param['tmpl']['admin']='admin';
GOB::$param['tmpl']['cikk']='szovetseg3';
GOB::$param['title']='infolapok';
GOB::$param['start']='index.php?com=cikk&csid=1&id=10';
GOB::$param['fb']=false; // be van e töltve az alap fb script
GOB::$param['fb_app_id']='218324098211541';
GOB::$param['fb_width']='700';
GOB::$param['fb_num-posts']='10';
*/
//print_r(GOB::$param); fghfgh
		
//GOB::$keret_tomb['sidebar1']=['rss'];
