<?php
$str = <<<HTML
<div<!--#rrr --> class="gallery">text to extract here<!--#bbb --></div>
<div class="gallery">text<!--:ssljh als --> to extract from here as well</div>
HTML;
//preg_match_all ("/<div class=\"main\">([^`]*?)<\/div>/", $data, $matches);
preg_match_all ("/<!--#([^`]*?)-->/", $str, $matches);
//print_r($matches[1]);

 $db=DB::connect();
//$er=DB::beszur("insert into lng (nev) VALUE ('ffff')");
print_r($tarcat=DB::assoc_sor("SELECT SUM(p.satoshi) AS egyenleg FROM penztar p WHERE userid='16' GROUP BY p.userid"));

class MoConfig {

//public static $felhasznalonev = 'pnet354_motto001';
//public static $jelszo = 'motto6814';
//public static $adatbazis = 'pnet354_motto001_oneday';
    public static $host = 'localhost';
    public static $felhasznalonev = 'root';
    public static $jelszo = '';
    public static $adatbazis = 'social';
    public static $mailfrom= 'motto001@gmail.com';
    public static $fromnev= 'Admin';
    public static $offline = 'nem'; //igen bekapcsolja az offline módot
    public static $offline_message = 'Weblapunk fejlesztés alatt.';
}



class DB
{
    static public function connect()
    {
        try {
            $db = new PDO("mysql:dbname=" . MoConfig::$adatbazis . ";host=" . MoConfig::$host, MoConfig::$felhasznalonev, MoConfig::$jelszo, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            //$db->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        } catch (PDOException $e) {
           echo'hiba';
        }
        return $db;
    }

    static public function parancs($sql)
    {
        $sth = self::alap($sql);
        return $sth;
    }

    static public function alap($sql)
    {
        global $db;$result = true;
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            GOB::$hiba['pdo'][] = $e->getMessage();
            $result = false;
        }

        return $result;
    }


    static public function beszur($sql){

        global $db;$result = false;
        try {
            $stmt = $db->prepare($sql);

            $stmt->execute();
            $result=$db->lastInsertId();

        } catch (PDOException $e) {
         // GOB::$hiba['pdo'][] = $e->getMessage();
            echo $e->getMessage();
        }
        return $result;

    }

    static public function assoc_tomb($sql)
    {
        global $db; $result = array();
        try {
            $stmt = $db->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                $result[] = $row;
            }


        } catch (PDOException $e) {
            //GOB::$hiba['pdo'][] = $e->getMessage();

        }

        return $result;
    }

    static public function assoc_sor($sql)
    {
        global $db;$result = array();
        try {
            $stmt = $db->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            if(!empty($row)){$result =$row;}

        } catch (PDOException $e) {
           // GOB::$hiba['pdo'][] = $e->getMessage();
            $result  = 'hiba';
        }
        return $result;
    }
}