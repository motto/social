<?php
include_once'app/app_nyito.php';
ADT::$view_file='tmpl/'.GOB::$tmpl.'/content/nyito.html';
ADT::$sql_LT="SELECT nev,".GOB::$lang." FROM lng WHERE lap='nyito'";
ADT::$LT['hu']=array('email'.'Email');
ADT::$LT['en']=array('email'.'Email');
$app=new AppBase();
$fn=TASK_S::get_funcnev($app);
$app->$fn();
ADT::$view=AppS::LT_db_feltolt(ADT::$view,ADT::$datatomb_LT);
//print_r(ADT::$datatomb_LT);



