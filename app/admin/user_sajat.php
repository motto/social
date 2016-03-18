<?php
include_once 'app/admin/lib/usernyito_alap.php';
ADT::$jog='user';
ADT::$texturlap='app/admin/view/urlapok/txt.html';
ADT::$inputurlap='app/admin/view/urlapok/input.html';
class ViewS extends AlapView{}
class DataS extends AlapDataS{

    public static function alap()
    {
ADT::$dataT['usernev']=GOB::$user['username'];
$egyenlegT=DB::assoc_sor("SELECT SUM(p.satoshi) AS egyenleg FROM penztar p WHERE userid='".GOB::$user['id']."' GROUP BY p.userid");
ADT::$dataT['egyenleg']=$egyenlegT['egyenleg'];
$tarcaT=DB::assoc_sor("SELECT t.tarca FROM userek u INNER JOIN tarcak t ON t.id=u.tarcaid WHERE u.id='".GOB::$user['id']."'");
        ADT::$dataT['tarca'] =$tarcaT['tarca'];
        ADT::$dataT['userid']=GOB::$user['id'];
        ADT::$dataT['email']=GOB::$user['email'];
    }
}
class Admin extends AlapAdmin{}
$app=new Admin();
$fn=Task_S::get_nev_funcnev($app);
echo $fn;
$app->$fn();