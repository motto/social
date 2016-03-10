<?php
include_once'app/app_nyito.php';
//include_once'mod/mod_alap.php';
ADT::$view_file='tmpl/'.GOB::$tmpl.'/content/nyito.html';
ADT::$sql_LT="SELECT nev,".GOB::$lang." FROM lng WHERE lap='nyito'";
ADT::$LT['hu']=array('email'.'Email');
ADT::$LT['en']=array('email'.'Email');
$app=new AppBase();
$fn=Task_S::get_nev_funcnev($app);
$app->$fn();
ADT::$view=FeltoltS::LT_fromdb(ADT::$view,ADT::$datatomb_LT);
//print_r(ADT::$datatomb_LT);



