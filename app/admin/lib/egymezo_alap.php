<?php

class ADT
{
    public static $jog='admin';
    public static $task='alap';
    public static $nev=''; //ha nem üres a task szerkeszt lesz, és ezt a mezőt szerkeszti
    public static $nevT=''; //csak azokat a mezőket veszi figyelembe amik itt szerepelnek
    public static $task_valaszt=array('post','get');
    public static $view='';
    public static $LT=array();
    public static $dataT=array();
    public static $katnev='userid'; //kategoria pl.: user adatoknál userid
    public static $kat='nyito'; //kategoria pl.: user adatoknál userid
    public static $tablanev='lng';
    public static $texturlap='app/admin/view/urlapok/nyitotxt.html';
    public static $inputurlap='app/admin/view/urlapok/nyitoinput.html';
    public static $view_file='tmpl/flat/content/nyito.html';
 // public static $func_aliasT=array();

}


class AppViewS {

    public static function alap()
    {
        ADT::$view=file_get_contents(ADT::$view_file, true);

    }
    public static function textmezo()
    {
        $html=file_get_contents(ADT::$texturlap, true);
        $datasor=AppDataS::datasor_LT(ADT::$nev);
        $html=str_replace('data="nev"', 'value="'.ADT::$nev.'"', $html );
       // $html=str_replace('data="en"', 'value="'.$datasor['en'].'"', $html );
        ADT::$view= $html;
    }
    public static function inputmezo()
    {
        $html=file_get_contents(ADT::$inputurlap, true);
        $datasor=AppDataS::datasor_LT(ADT::$nev);
        $html=str_replace('data="nev"', 'value="'.ADT::$nev.'"', $html );
        ADT::$view= $html;
    }
}

class Admin {

    public function __construct()
    {

    }

    public function alap()
    {
        AppView::alap();
      //  $this->szerk_gomb_beszur();
        AppDataS::datatomb_LT();
        ADT::$view= FeltoltS::LT_fromdb(ADT::$view,ADT::LT);

    }
    public function ment()
    {
        AppDataS::ment();
        $this->alap();
    }
    public function cancel()
    {
        $this->alap();
    }
    public function szerk()
    {
        if(substr(ADT::$nev, 0, 2)=='tx')
        {AppView::textmezo();}
        else
        {AppView::inputmezo();}
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


    public static  function ment()
    {
        if(isset($_POST['nev']))
        {
            $sqlupdate="UPDATE ".ADT::$tablanev." SET nev='".$_POST['nev']."' WHERE ".ADT::$katnev."='".ADT::$kat."' AND nev='".$_POST['mezo']."'";
            // echo $sql;
           if(!DB::parancs($sqlupdate)){
               $sqlinsert="INSERT INTO ".ADT::$tablanev." (".ADT::$katnev.",nev) VALUES ('".ADT::$kat."','".$_POST['nev']."') ";
               DB::parancs($sqlinsert);
           }
        }
    }
    public static  function LT()
    {
        $sql="SELECT nev,".GOB::$lang." FROM ".ADT::$tablanev." WHERE lap='".ADT::$lapnev."'";
        ADT::$LT=DB::assoc_tomb($sql);
        return ADT::$LT;
    }
}
$app=new Admin();
$fn=Task_S::get_nev_funcnev($app);
//echo $fn;
$app->$fn();