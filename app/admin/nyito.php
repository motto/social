<?php
class ADT
{
    public static $itemid='0';
    public static $jog='admin';
    public static $itemidtomb=array();
    public static $nyito_sql="SELECT * FROM lng WHERE lap='nyito' ";
    public static $tablanev='lng';
    public static $texturlap='app/admin/view/urlapok/nyitotxt.html';
    public static $inputurlap='app/admin/view/urlapok/nyitoinput.html';
    public static $alapview='app/admin/view/nyito.html';
    //public static $allowed_func=array('joghiba','mezokeszit');
   public static $allowed_func=array('ment','cancel','joghiba','udvozles','udvszoveg','hogyan','hogyan1','hogyan2','hogyan3','jobbegyutt','jobbegyutt_txt');


    public static $nyitotomb=array();
    public static $mezotomb=array();
}


class AppView {
   public static function alap()
    {
        $html=file_get_contents(ADT::$alapview, true);
        return $html;
    }
    public static function textmezo()
    {
        $html=file_get_contents(ADT::$texturlap, true);
        $data=AppData::mezotomb($_POST['task']);

        return $html;
    }
    public static function inputmezo()
    {
        $html=file_get_contents(ADT::$inputurlap, true);
        return $html;
    }
}

class Admin {
    public  $tartalom='nincs tartalom';
    public function alap()
    {

    }
    public function textmezo()
    {

    }
    public function inputmezo()
    {

    }
    public function ment()
    {

    }
    public function cancel()
    {

    }
    public function udvozles(){}
    public function udvszoveg(){}
    public function hogyan(){}
    public function hogyan1(){}
    public function hogyan2(){}
    public function hogyan3(){}
    public function jobbegyutt(){}
    public function jobbegyutt_txt(){}

    public  function mezokeszit()
    {
        $html=file_get_contents(ADT::$alapview, true);
        $matches='';
        preg_match_all ("/value=\"([^`]*?)\"/",$html , $matches);

        foreach($matches[1] as $mezonev)
        {//$alowedtask=$alowedtask."'".$mezonev."',";
            //$func=$func.'public function '.$mezonev.'(){}';
            // $sgl="INSERT INTO lng (lap,nev) VALUES ('nyito','".$mezonev."')";
            //DB::parancs($sgl);
        }
        //echo $alowedtask;
        // echo $func;
    }
};

class AppData {

  public static  function nyitotomb()
    {
      $nyitotomb=DB::assoc_tomb(ADT::$nyito_sql);
        return $nyitotomb;
    }
    public static  function mezotomb($nev)
    {   $sql="SELECT * FROM lng WHERE nev='".$nev."'";
        $mezotomb=DB::assoc_sor(ADT::$nyito_sql);
        return $mezotomb;
    }
}


class AppEll extends AppEll_base{}