<?php
include_once'app/admin/lib/tablas_alap.php';
/*require_once('vendor/autoload.php');
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;*/



ADT::$jog='admin';
ADT::$ikonsor=array('pub','unpub');
ADT::$view_file='app/admin/view/tabla_alap.html';
//ADT::$urlap_file ='app/admin/view/faucet_urlap.html';
ADT::$datatomb_sql="SELECT u.username,t.tarca,t.tarcanev, SUM(p.satoshi) AS egyenleg FROM penztar p INNER JOIN userek u ON p.userid=u.id INNER JOIN tarcak t ON t.id=u.tarcaid  GROUP BY p.userid";
ADT::$ikonsor=array();

ADT::$tablanev='penztar';
ADT::$tabla_szerk =array(
  //  array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
   // array('cim'=>'','mezonev'=>'pub','tipus'=>'pubmezo'),
    //array('cim'=>'Tárcanév','mezonev'=>'id','tipus'=>''),
 array('cim'=>'Usernév','mezonev'=>'username','tipus'=>''),
    array('cim'=>'Tárca név','mezonev'=>'tarcanev','tipus'=>''),
   array('cim'=>'Tárca cím','mezonev'=>'tarca','tipus'=>''),
  // array('cim'=>'Tárca cím','mezonev'=>'tarca','tipus'=>''),
 array('cim'=>'Egyenleg','mezonev'=>'egyenleg','tipus'=>'')
//  array('cim'=>'bejövő','mezonev'=>'uj','tipus'=>'')
   // array('cim'=>'utolsó módosítás','mezonev'=>'ido','tipus'=>'')
);
ADT::$ment_mezok =array(
    array('mezonev'=>'link'),
    //array('mezonev'=>'','postnev'=>'','ell'=>'','tipus'=>''),
    array('mezonev'=>'leiras','tipus'=>'text'),
    array('mezonev'=>'megjegyzes'),
    array('mezonev'=>'perc'),
    array('mezonev'=>'pont'));


class Admin extends AdminBase{


};

if(isset($_POST['sor'])){print_r($_POST['sor']);}

$app=new Admin();
$fn=TASK_S::get_funcnev($app);
//ADT::$datasor_sql="SELECT * FROM faucet WHERE id='".ADT::$id."' ";

$app->$fn();