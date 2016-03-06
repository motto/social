<?php
define('LOGINPATH', 'app'.DS.'login');
$lang_login=array(
'21_data_changed'=>'Az adatok megváltoztak!',
'21 HAVE USER'=>'A <<0>> felhasználó név már foglalt!',
'21_passwd_nomatch'=>'A jelszó nem jó próbálja újra!'
);
LANG::$lang_tomb=array_merge(LANG::$lang_tomb, $lang_login);
//Tomb::kiir([GOB::$hiba]);
$adatok['username']=GOB::get_user('username');
$adatok['mail']=GOB::get_user('mail');
//print_r($adatok);
$adatok=ADAT::postbol_datatomb(array('oldpassword','password','password2','mail','username'),$adatok);
//ELL::$adatok=$adatok;
//print_r($adatok);
//LANG::ECH(['R_SZAM','Nk'],[['Szám medfgdző','NAGY']]); 
//LANG::ECH(['PASSWD','kis']);
//LANG::ECH(['PASSWD','Nkk']); 
//LANG::ech('MEZO=ERTEK',['password2','dghsdfghdg']);
function van_user($adatok,$sajat=''){
//már van ilyen felhasználó ---------------------------------
$sql="SELECT username FROM userek WHERE username='".ELL::$adatok['username']."'";
$van=DB::assoc_sor($sql);
if(!empty($van)){
	if($sajat!=''){if($sajat!=$van['username'] ){GOB::$hiba['ELL'][]=LANG::RET('21 HAVE USER',array(ELL::$adatok['username']));}
	}else{GOB::$hiba['ELL'][]=LANG::RET('21 HAVE USER',array(ELL::$adatok['username']));}
}
}
//adat mentés----------------------

function ment($adatok){
// aliasok a hibaüzeneteknek----------------
$p_alias=LANG::RET('PASSWD'); $p2_alias=LANG::RET('PASSWD').' '.LANG::RET('REPEAT');
$u_alias=LANG::RET('USER NAME');$e_alias=LANG::RET('EMAIL');
// a két jelszó mezőnek egyeznie kell------------------
ELL::SAME_2MEZO('MEZO=ERTEK',array('password',array($p_alias,'Nk')),array('password2',$p2_alias));
//string hosz vizsgálat----------------------------
ELL::TOBB_STR_HOSSZ('R_MIN_MAX',array('password',$p_alias),array('mail',$e_alias,array('username',$u_alias)),6,50);
//mail ellenőrzés-----------------------------
ELL::REG_EX('R_MAIL',array('mail'));
//csak magyar betúk szóközzel---------------------------
ELL::REG_EX('R_HU_TOBB_SZO',array('username',$u_alias));
//kiíratás adatbázis művletek csak jó adatokkal megyünk tovább ha nincs 'R_TOBB_SZO' vagy egyéb tisztító függvény  back slashalni kell-----------------------------
van_user($adatok);
$jelszo = md5(ELL::$adatok['password']);

if(empty(GOB::$hiba['ELL'])){
	$sql="INSERT INTO userek( username,mail,password,registerdate) VALUES ('".ELL::$adatok['username']."','".ELL::$adatok['mail']."','".$jelszo."',NOW())";
	$insert_id=DB::beszur($sql);
		if($insert_id>0){LANG::ECH('REG SUCCESFULL');
		include LOGINPATH.DS.'view'.DS.'belep_form.html';
		}else{
		LANG::ECH('DATA ERROR,REPEAT');
		include LOGINPATH.DS.'view'.DS.'regisztral_form.html';}
	}else{
	include LOGINPATH.DS.'view'.DS.'regisztral_form.html';
	}
}
function vment($adatok){
// aliasok a hibaüzeneteknek----------------
$p_alias=LANG::RET('NEW PASSWD'); $p2_alias=LANG::RET('NEW PASSWD').' '.LANG::RET('REPEAT');
$u_alias=LANG::RET('USER NAME');$e_alias=LANG::RET('EMAIL');
// a két jelszó mezőnek egyeznie kell------------------
if($adatok['password']!=''){ELL::SAME_2MEZO('MEZO=ERTEK',array('password',array($p_alias,'Nk')),array('password2',$p2_alias));}
//string hosz vizsgálat----------------------------
if($adatok['password']!=''){ELL::TOBB_STR_HOSSZ('R_MIN_MAX',array('password',array($p_alias,'Nk')),6,50);}
ELL::TOBB_STR_HOSSZ('R_MIN_MAX',array(array('mail',$e_alias),array('username',$u_alias)),6,50);
//mail ellenőrzés-----------------------------
ELL::REG_EX('R_MAIL','mail');
//csak magyar betúk szóközzel---------------------------
ELL::REG_EX('R_HU_TOBB_SZO',array('username',$u_alias));
//kiíratás adatbázis művletek csak jó adatokkal megyünk tovább ha nincs 'R_TOBB_SZO' vagy egyéb tisztító függvény  back slashalni kell-----------------------------
van_user($adatok,GOB::get_user('username')); //a saját usernevét nem veszi figyelembe
$jelszo = md5(ELL::$adatok['oldpassword']);
$sql="SELECT password FROM userek WHERE username='".GOB::get_user('username')."'";
$dd=DB::assoc_sor($sql);
if($jelszo!=$dd['password']){GOB::$hiba['ELL'][]=LANG::RET('21_passwd_nomatch');}
if(empty(GOB::$hiba['ELL'])){
if($adatok['password']!=''){$uj_jelszo=md5(ELL::$adatok['password']);}else{$uj_jelszo=$jelszo;}
	DB::parancs("UPDATE userek SET username='".ELL::$adatok['username']."',mail='".ELL::$adatok['mail']."',password='".$uj_jelszo."' where id='".GOB::get_user('id')."'");
	LANG::ECH('DATA_CHANGED');
	include LOGINPATH.DS.'view'.DS.'belep_form.html';
	}else{
	Tomb::kiir(GOB::$hiba['ELL']);
	
	include LOGINPATH.DS.'view'.DS.'valtoztat_form.html';
	}
	
}


switch ($_GET['login']){
	case 'reg':
	include LOGINPATH.DS.'view'.DS.'regisztral_form.html';
		break;
	case 'valtoztat':
	include LOGINPATH.DS.'view'.DS.'valtoztat_form.html';
		break;
	case 'vment':
		vment($adatok);
		break;			
	case 'ment':
		ment($adatok);
		break;
	default: 
	if($_SESSION['userid']>0)
		{include LOGINPATH.DS.'view'.DS.'belepve_form.html';}
		else
		{include LOGINPATH.DS.'view'.DS.'belep_form.html';}
	}

//Tomb::kiir(array(GOB::$hiba));
//print_r(GOB::$hiba['ELL']);
?>