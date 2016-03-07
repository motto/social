<?php
include_once'app/alap.php';
ADT::$view_file='tmpl/'.GOB::$tmpl.'/content/nyito.html';
ADT::$sql_LT="SELECT nev,".GOB::$lang." FROM lng WHERE lap='nyito'";
ADT::$LT['hu']=array('email'.'Email');
ADT::$LT['en']=array('email'.'Email');
$app=new AppBase();
ADT::$view=LANG::db_feltolt(ADT::$view,ADT::$datatomb_LT);
//print_r(ADT::$datatomb_LT);



