<?php
class ADT
{
    public static $jog='admin';
    public static $task='alap';
    public static $task_valaszt=array('post','get');
    public static $view='<h3>usernyito</h3>';
    public static $datasor_LT=array();
    public static $lapnev='usernyito';
    public static $tablanev='userek';
    public static $view_file='tmpl/flat/content/nyito.html';
    public static $mezotomb=array();
    // public static $func_aliasT=array();

}


class AppView {

    public static function alap()
    {
        ADT::$view=file_get_contents(ADT::$view_file, true);

    }

}

class Admin {

    public function alap()
    {
        //AppView::alap();

    }

    public function joghiba()
    {
        if($_SESSION['userid']==0)
        {ADT::$view=MOD::login();}
        else
        {ADT::$view='<h2><!--#joghiba--></h2>';}

    }

}

class AppDataS
{

    public static  function datasor_LT($nev)
    {
        $sql="SELECT * FROM ".ADT::$tablanev." WHERE ='".$_SESSION['userid']."'";
        ADT::$datasor_LT =DB::assoc_sor($sql);
        return ADT::$datasor_LT;
    }

}
$app=new Admin();
$fn=Task_S::get_funcnev($app);
$app->$fn();


