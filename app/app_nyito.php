<?php
class ADT
{
    public static $jog="noname";
    public static $task='alap';
    public static $task_valaszt=array('post','get');
    //  public static $feltolt_func="full_feltolt"; //alapból ez tölti fel a view-t
    public static $view="Nincs tartalom";
    public static $view_file='';
    public static $sql='';
    public static $sql_LT='';
    public static $datatomb=array();
    public static $datatomb_LT=array();
    public static $LT=array(); //GOB::LT kibővítése
    public static $func_aliasT=array();//['view'=>['task1'=>'alias','task2'=>'alias']]
    public static $allowed_funcT=array('hiba','alap');//['func1','func2']
}
class ViewBase
{
    static public function alap()
    {
        ADT::$view=file_get_contents(ADT::$view_file, true);
    }
}
class DataBase
{
    static public function alap()
    {
        if(ADT::$sql!=''){ ADT::$datatomb=DB::assoc_tomb(ADT::$sql);}
        if(ADT::$sql_LT!=''){ ADT::$datatomb_LT=DB::assoc_tomb(ADT::$sql_LT);}
    }
}
/**
 * a Task osztály segítségével  akonstruktora lefuttattja a megfelelő taskot
 */
class AppBase
{
    public function __construct()
    {
        // $funcnev=TASK_S::get_funcnev();
        //$this->$funcnev();
    }
    public function alap()
    {
        ViewBase::alap() ;
        DataBase::alap();
    }
    public function joghiba()
    {
        if($_SESSION['userid']==0)
        {ADT::$view=MOD::login();}
        else
        {ADT::$view='<h2><!--#joghiba--></h2>';}
    }
}