<?php 
//defined( '_MOTTO' ) or die( 'Restricted access' );
/**********************************************************
a globális $db objektumot létre kell hozni: $db=DB::connect();
 peldak:
$adatsor=DB::assoc_sor($sql);       $sql='select * from userek'
$adat_tomb=DB::assoc_tomb($sql);
$id=DB::beszur($sql);				$sql='INSERT INTO ajanlasok (domain) VALUES ('ttttjjj')'
DB::torol_sor('ajanlasok ','14') ;   (tabla,id,id_nev='id') 
DB::torol_tobb_sor('ajanlasok',['tjjj','ttgg',],'domain') ;
DB::parancs($sql);					sql parancs aminek nem kell visszatérési érték
ADAT::slashel($input)
$data=ADAT::postbol_datatomb('email,pass1,pass2','user');
ADAT::postbol_datatomb($mezonevek) //a post tömbből csinál adat tömböt nem slashel
ADAT::slashed_datatomb($datatomb,$unslash,$slash) //tetszőleges adattömböt slashel 
ADAT::beszur_tombbol($tabla,$adat_tomb,$mezok='all') //visszatér az id-del
ADAT::frissit_tombbol($tabla,$datatomb,$id,$mezok='all')
*************************************************************/
class TEXT{
static public function text_or_html($text,$tip='text',$long=250){
switch ($tip) {
    case 'html':
    $text = htmlspecialchars($text); //scripteket eltávolítja
        break;
    case 'text':
      $text = htmlspecialchars($text); //scripteket eltávolítja
	  $text = strip_tags($text);		//html elemeket eltávolítja
        break;
	}
if($long!='all'){$text=substr($text, 0, $long);}; 
return $text;	
}	

static public function post_slashel($input){ 	
if (get_magic_quotes_gpc()){$input = stripslashes($input);}  
 $input = mysql_real_escape_string($input);  
 return $input;
}	
}	
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
}

class ADAT{
static public function slashel($input){	
if (get_magic_quotes_gpc()){$input = stripslashes($input);}  
 $input = mysql_real_escape_string($input);  
 return $input;
}
static public function postbol_datatomb($mezok,$data=array()){ //lehet tomb és sztring param
if(is_array($mezok)){$mezotomb=$mezok;}else{$mezotomb=explode(',',$mezok);}
foreach ($mezotomb as $mezo_nev){
	if(!isset($data[$mezo_nev])){$data[$mezo_nev]='';}
	if(isset($_POST[$mezo_nev])){$data[$mezo_nev]=$_POST[$mezo_nev];}
}
return $data;
}

static public function slashed_datatomb($datatomb,$unslash,$slash){ //lehet tomb és sztring param
if(is_array($slash)){$slashtomb=$slashed;}else{$slashtomb=explode(',',$slash);}
if(is_array($unslash)){$unslashtomb=$unslash;}else{$unslashtomb=explode(',',$unslash);}
if(!empty($slash)){
foreach ($slashtomb as $mezo_nev){
$data[$mezo_nev]=self::slashel($datatomb[$mezo_nev]); 
}}
if(!empty($unslash)){
foreach ($unslashtomb as $mezo_nev){
$data[$mezo_nev]=$datatomb[$mezo_nev]; 
}}
return $data;
}
static public function beszur_tombbol($tabla,$adat_tomb,$mezok='all'){
if(is_array($mezok)){$mezotomb=$mezok;}else{$mezotomb=explode(',',$mezok);}
//print_r($adat_tomb);
foreach ($adat_tomb as $key=>$value){
if($mezok=='all'){
$ertek=$ertek."'".$value."',"; 
$clm=$clm.$key.","; 
}else{if(in_array($key,$mezotomb)){
		$ertek=$ertek."'".$value."',"; 
		$clm=$clm.$key.","; }
}
}
$clm2=rtrim($clm,',');
$ertek2=rtrim($ertek,',');
$sql="INSERT INTO $tabla ($clm2) VALUES ($ertek2)";
$id=DB::beszur($sql);
//echo $sql;
return $id;
}


//Feltolt::update_ment('userek','foto,name,pubname,leiras,cimke',$userid);
static public function frissit_tombbol($tabla,$datatomb,$id,$mezok='all'){
if(is_array($mezok)){$mezotomb=$mezok;}else{$mezotomb=explode(',',$mezok);}
foreach ($datatomb as $key=>$value){
	if($mezok=='all'){$setek=$setek.$key."='".$value."', ";
	}else{if(in_array($key,$mezotomb)){$setek=$setek.$key."='".$value."', ";}}
}
$setek2 = substr($setek, 0, -2); 
//$setek2 = rtrim($setek,',');
$sql="UPDATE $tabla SET $setek2 WHERE id='$id'";
echo $sql;
DB::parancs($sql);
}
}
?>