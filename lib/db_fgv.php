<?php 
//defined( '_MOTTO' ) or die( 'Restricted access' );
/**
 * $db=DB::connect() legyen az indexp.hp-ban
 * DB::parancs($sql);
 * DB::assoc_sor($sql);
 * DB::assoc_tomb($sql);
 * torol_sor($tabla,$id,$id_nev='id')
 * torol_tobb_sor($tabla,$id_tomb=array(),$id_nev='id');
 * beszur_tombbol($tabla,$adat_tomb,$mezok='all')
 * frissit_tombbol($tabla,$datatomb,$id,$mezok='all')
 */
class DB
{
static public function connect(){
try {
				$db = new PDO("mysql:dbname=".MoConfig::$adatbazis.";host=".MoConfig::$host,MoConfig::$felhasznalonev, MoConfig::$jelszo, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
				//$db->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
			} catch (PDOException $e) {
				die(GOB::$hiba['pdo']="Adatbazis kapcsolodasi hiba: ".$e->getMessage());
				return false;
			}
	return $db;		
}
static public function parancs($sql){
$sth =self::alap($sql);
}
static public function alap($sql){
global $db;
$sth = $db->prepare($sql);
$sth->execute();
		//GOB::$hiba][]="assoc_tomb: ".$sth->errorInfo(); nem jó!!!
		//tömbhöz nem lehet hozzáfűzni	stringet!!!!!!!!!!!!!!!!!
		$h=$sth->errorInfo();
		//echo 'ffffffffffffffffffffff:'.$h[2].'</br>';
		if(!empty($h[2])){GOB::$hiba['pdo'][]=$sth->errorInfo();	}

return $sth;
}
static public function assoc_tomb($sql){
$sth =self::alap($sql);
 while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
     $eredmeny_tomb[]= $row;
	//$row= $sth->fetchAll();//sorszámozottan is és associatívan is tárolja a mezőket(duplán)
  }
return $eredmeny_tomb;
}
static public function assoc_sor($sql){
$sth =self::alap($sql);
return $sth->fetch(PDO::FETCH_ASSOC);
}

static public function beszur($sql){
global $db;
$sth =self::alap($sql);
return $db->lastInsertId();

}

static public function torol_sor($tabla,$id,$id_nev='id') 
{
$sql="DELETE FROM $tabla WHERE $id_nev = '$id'";
$sth =self::alap($sql);
}

static public function torol_tobb_sor($tabla,$id_tomb=array(),$id_nev='id') 
{
foreach($id_tomb as $id){self::torol_sor($tabla,$id,$id_nev); }
}
static public function beszur_tombbol($tabla,$adat_tomb,$mezok='all')
	{
		if(is_array($mezok))
		{
			$mezotomb=$mezok;
		}
		else
		{
			$mezotomb=explode(',',$mezok);
		}
		$ertek=''; $clm='';
		foreach ($adat_tomb as $key=>$value)
		{
			if($mezok=='all')
			{
				$ertek=$ertek."'".$value."',";
				$clm=$clm.$key.",";
			}
			else
			{
				if(in_array($key,$mezotomb))
				{
					$ertek=$ertek."'".$value."',";
					$clm=$clm.$key.",";
				}
			}
		}
		$clm2=rtrim($clm,',');
		$ertek2=rtrim($ertek,',');
		$sql="INSERT INTO $tabla ($clm2) VALUES ($ertek2)";
		$id=DB::beszur($sql);
		return $id;
	}
static public function frissit_tombbol($tabla,$datatomb,$id,$mezok='all')
	{
		if(is_array($mezok)){$mezotomb=$mezok;}else{$mezotomb=explode(',',$mezok);}
		foreach ($datatomb as $key=>$value)
		{
			if($mezok=='all')
			{
				$setek='';
				$setek=$setek.$key."='".$value."', ";
			}
			else
			{
				if(in_array($key,$mezotomb))
				{
					$setek=$setek.$key."='".$value."', ";
				}
			}
		}
		$setek2 = substr($setek, 0, -2);
//$setek2 = rtrim($setek,',');
		$sql="UPDATE $tabla SET $setek2 WHERE id='$id'";
		echo $sql;
		DB::parancs($sql);
	}
}

class ADAT
{
	static public function text_or_html($text,$tip='text',$long=250)
	{
		switch ($tip)
		{
			case 'html':
				$text = htmlspecialchars($text); //scripteket eltávolítja
				break;
			case 'text':
				$text = htmlspecialchars($text); //scripteket eltávolítja
				$text = strip_tags($text);		//html elemeket eltávolítja
				break;
		}
		if($long!='all')
		{
			$text=substr($text, 0, $long);
		};
		return $text;
	}

	static public function postbol_datatomb($mezotomb,$data=array())
	{
		foreach ($mezotomb as $mezo_nev)
		{
		$data[$mezo_nev]=$_POST[$mezo_nev];
		}
	return $data;
	}
	/** ha a getben  van ilyen nevű érték akkor azzal tér vissza ha nem akkor a postból ha ott sincs akkor a sessionből veszi ha egyikben sincs akkor az értékkel tér vissza
	 */
	static public function GET_POST_SESS($adatnev,$ertek){
		if(isset($_SESSION[$adatnev])){$ertek=$_SESSION[$adatnev];}
		if(isset($_POST[$adatnev])){$ertek=$_POST[$adatnev];}
		if(isset($_GET[$adatnev])){$ertek=$_GET[$adatnev];}
		return $ertek;
	}
}
?>