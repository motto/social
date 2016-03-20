<?php
include_once'app/admin/lib/tablas_alap.php';
ADT::$jog='admin';
ADT::$view_file='app/admin/view/tabla_alap.html';
ADT::$urlap_file ='app/admin/view/faucet_urlap.html';
ADT::$datatomb_sql="SELECT u.id, u.username,u.ref,u.datum,u.ellenorzott,u.pub,t.tarca FROM userek u INNER JOIN tarcak t on t.id=u.tarcaid ";
ADT::$ikonsor = array('pub','unpub','torol','email');
ADT::$tablanev='userek';
ADT::$tabla_szerk =array(
    array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
    array('cim'=>'','mezonev'=>'pub','tipus'=>'pubmezo'),
    array('cim'=>'id','mezonev'=>'id','tipus'=>''),
    array('cim'=>'Usernev','mezonev'=>'username','tipus'=>''),
    array('cim'=>'Ref','mezonev'=>'ref','tipus'=>''),
    array('cim'=>'Tárca','mezonev'=>'tarca','tipus'=>''),
    array('cim'=>'Reg. Dátum','mezonev'=>'datum','tipus'=>''),
    array('cim'=>'Ellenőrzött?','mezonev'=>'ellenorzott','tipus'=>'')
);
ADT::$ment_mezok =array(
    array('mezonev'=>'tarca'));

class Admin extends AdminBase{
};

$app=new Admin();
$fn=TASK_S::get_funcnev($app);
ADT::$datasor_sql="SELECT * FROM userek WHERE id='".ADT::$id."' ";

$app->$fn();


