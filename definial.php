<?php
//állandók--------------------------------
define("DS", "/"); define("PATH_SITE", $_SERVER['DOCUMENT_ROOT']); define("_MOTTO", "igen"); 
//file elérések----------------------------------------------------

class MoConfig {
    /*
    public static $felhasznalonev = 'pnet992_social';
   public static $jelszo = 'Nemmegy111!!!';
    public static $adatbazis = 'pnet992_social_alap';
    public static $host = 'localhost';
    */
    /*
public static $felhasznalonev = 'pnet354_motto001';
public static $jelszo = 'motto6814';
public static $adatbazis = 'pnet354_motto001_oneday';
 */
public static $host = 'localhost';
public static $felhasznalonev = 'root';
public static $jelszo = '';
public static $adatbazis = 'social';
public static $mailfrom= 'motto001@gmail.com';
public static $fromnev= 'Admin'; 
public static $offline = 'nem'; //igen bekapcsolja az offline módot
public static $offline_message = 'Weblapunk fejlesztés alatt.';
}
