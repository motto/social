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
static public function parancs($sql,$hibainfo='hibainfo nincs'){
$sth =self::alap($sql,$hibainfo);
	return $sth;
}
static public function alap($sql,$hibainfo='hibainfo nincs'){
global $db;
$sth = $db->prepare($sql);
$sth->execute();
		//GOB::$hiba][]="assoc_tomb: ".$sth->errorInfo(); nem jó!!!
		//tömbhöz nem lehet hozzáfűzni	stringet!!!!!!!!!!!!!!!!!
		$h=$sth->errorInfo();
		if(!empty($h[2])){GOB::$hiba['pdo'][]=array('hibainfo'=>$hibainfo,'sth_error'=>$sth->errorInfo(),'sql'=>$sql);	}
return $sth;
}
static public function assoc_tomb($sql){
	global $db;$eredmeny_tomb=array();
	try {
		$stmt =$db ->prepare($sql);

		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		while ($row = $stmt->fetch()) {
			$eredmeny_tomb[]= $row;
		}

	}
	catch(PDOException $e)
	{
		GOB::$hiba['pdo'][]=$e->getMessage();
	}

/*
$sth =self::alap($sql);
 while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
     $eredmeny_tomb[]= $row; */
	//$row= $sth->fetchAll();//sorszámozottan is és associatívan is tárolja a mezőket(duplán)

return $eredmeny_tomb;
}
static public function assoc_sor($sql){
$sth =self::alap($sql);
return $sth->fetch(PDO::FETCH_ASSOC);
}
static public function beszur($sql){
global $db;
$sth =self::alap($sql);
$h=$sth->errorInfo();
if(empty($h[2])){$result=$db->lastInsertId();}else{$result='0';}
	//echo $result;
return $result;

}
static public function pub ($tabla,$id,$id_nev='id')
{
$sql="UPDATE $tabla SET pub='0' WHERE $id_nev='$id'";
$sth =self::alap($sql);
return $sth;
}
static public function tobb_pub ($tabla,$id_tomb,$id_nev='id')
{
foreach($id_tomb as $id){self::pub($tabla,$id,$id_nev); }
}
static public function unpub ($tabla,$id,$id_nev='id')
{
	$sql="UPDATE $tabla SET pub='1' WHERE $id_nev='$id'";
	$sth =self::alap($sql);
	return $sth;
}
static public function tobb_unpub ($tabla,$id_tomb,$id_nev='id')
{
	foreach($id_tomb as $id){self::unpub($tabla,$id,$id_nev); }
}
static public function del($tabla,$id,$id_nev='id')
	{
		$sql="DELETE FROM $tabla WHERE $id_nev = '".$id."'";
		$sth =self::alap($sql);
		return $sth;
	}
static public function tobb_del($tabla,$id_tomb,$id_nev='id')
{
foreach($id_tomb as $id){self::del($tabla,$id,$id_nev); }
}
/** $mezok: array(array('postnev','mezonev(ha más mit a postnév)','ellenor_func(nem kötelező)'))
 * ha az ellenőr funkció false-al tér vissza azt a mezőt kihagyja,
 * üres mezőt (illetve üres posztot)is felvisz,
 * visszatér a beszurt id-el vagy 0-val ha nem sikerult felvinni

	 */
static public function beszur_postbol($tabla,$mezok=array())
	{
		$ellenor_func='base';
		$value='';
		$value_string='';
		$mezo_string='';
		foreach ($mezok as $mezodata)
		{
			$postnev=$mezodata[0];
			if($mezodata[1]!='')
			{
				$mezonev=$mezodata[1];
			}
			else
			{
				$mezonev=$mezodata[0];
			}
			if($mezodata[2]!=''){$ellenor_func=$mezodata[2];}
				if(isset($_POST[$postnev]))
				{
					$value=$_POST[$postnev];
				}
				else
				{
					$value='';
				}


			if(AppEll::$ellenor_func($value))
			{
			$value_string=$value_string."'".$value."',";
			$mezo_string=$mezo_string.$mezonev.",";
			}
		}
		if($mezo_string!='')
		{
		$mezo_string2=rtrim($mezo_string,',');
		$value_string2=rtrim($value_string,',');
		$sql="INSERT INTO $tabla ($mezo_string2) VALUES ($value_string2)";
		$result=DB::beszur($sql);
		}
		else
		{
		$result='0';
		}
		return $result;
	}
/** $mezok: array(array('postnev','mezonev(ha más mit a postnév)','ellenor_func(nem kötelező)'))
	 * ha az ellenőr funkció false-al tér vissza azt a mezőt kihagyja,
	 * üres mezőt (illetve üres posztot)is felvisz.
	 * @param $tabla
	 * @param $id
	 * @param array $mezok
	 * @return PDOStatement
	 */
static public function frissit_postbol($tabla,$id,$mezok=array())
	{

		$setek='';
		foreach ($mezok as $mezo)
		{
			$value='';
			$postnev=$mezo[0];
			if($mezo[1]!='')
			{
				$mezonev=$mezo[1];
			}
			else
			{
				$mezonev=$mezo[0];
			}
			if($mezo[2]!=''){$ellenor_func=$mezo[2];}

//TODO: ellenőr funkciót beüzemelni!
			if(isset($_POST[$postnev])){$value=$_POST[$postnev];}

				$setek = $setek . $mezonev . "='" . $value . "', ";

		}
		$setek2 = substr($setek, 0, -2);
		$sql="UPDATE $tabla SET $setek2 WHERE id='$id'";
echo $sql;
		$result=DB::parancs($sql);
		return $result;
	}
static public function select_sql($tabla,$id,$mezok='*')
{
$sql="SELECT $mezok FROM $tabla WHERE id='$id'";
	return $sql;
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