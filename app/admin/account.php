<?php
include_once'app/admin/lib/tablas_alap.php';
ADT::$jog='user'; //csak akkor akkor számít ha TASK_S::get_funcnev-et használunk
ADT::$ikonsor=array();
ADT::$view_file='app/admin/view/tabla_alap.html';
//ADT::$urlap_file ='app/admin/view/faucet_urlap.html';
ADT::$datatomb_sql="SELECT tr_cim,satoshi,megjegyzes,ido   FROM penztar WHERE userid='".GOB::$user['id']."'";
ADT::$ikonsor=array();
ADT::$tablanev='penztar';
ADT::$tabla_szerk =array(
    array('cim'=>'Tranzakcio','mezonev'=>'tr_cim','tipus'=>''),
    array('cim'=>'összeg','mezonev'=>'satoshi','tipus'=>''),
    array('cim'=>'Megjegyzes','mezonev'=>'megjegyzes','tipus'=>''),
    array('cim'=>'Dátum','mezonev'=>'ido','tipus'=>'')

);


class Admin extends AdminBase{

};

$app=new Admin();
//$fn=TASK_S::get_funcnev($app); //jogosutság  miatt kell
if($_SESSION['userid']>0)
{
    $tartalom=$app->alap();
}
else
{
    $tartalom=MOD::login();
}
