<?php

class ADT
{
    public static $jog='admin';
    public static $mezokeszit=false; //elkészíti az adott db mezőt ha még nincs
    public static $mezotorol=false; //törli a fölösleges mezőt a táblából
    public static $task='alap';
    public static $view='';
    public static $datatomb_LT=array();
    public static $datasor_LT=array();
    public static $lapnev='nyito';
    public static $tablanev='lng';
    public static $texturlap='app/admin/view/urlapok/nyitotxt.html';
    public static $inputurlap='app/admin/view/urlapok/nyitoinput.html';
    public static $view_file='app/admin/view/nyito.html';
    public static $mezotomb=array();
    public static $func_aliasT=array();

}


class AppView {

   public static function alap()
    {
        ADT::$view=file_get_contents(ADT::$view_file, true);

    }
    public static function textmezo($mezonev)
    {
        $html=file_get_contents(ADT::$texturlap, true);
        $datatomb=AppData::datasor_LT($mezonev);
        $html=str_replace('data="nev"', 'value="'.$mezonev.'"', $html );
        $html=str_replace('<!--#hu-->', $datatomb['hu'], $html );
        $html=str_replace('!--#en-->', $datatomb['en'], $html );

        ADT::$view= $html;
    }
    public static function inputmezo($mezonev)
    {
        $html=file_get_contents(ADT::$inputurlap, true);
        $datatomb=AppData::datasor_LT($mezonev);
        $html=str_replace('data="nev"', 'value="'.$mezonev.'"', $html );
        $html=str_replace('data="hu"', 'value="'.$datatomb['hu'].'"', $html );
        $html=str_replace('data="en"', 'value="'.$datatomb['en'].'"', $html );
        ADT::$view= $html;
    }
}

class Admin {

    public function __construct()
    {   if(isset($_POST['task']))
        {
            $task=$_POST['task'];
            $inputstring='<!--##'.$task.'-->';
            $szoveg=file_get_contents(ADT::$view_file, true);
            if (strstr($szoveg,$inputstring))
            {}else{ADT::$func_aliasT[$task]='input';}
            $textstring='<!--##'.$task.'-->';
            if (strstr($szoveg,$textstring))
            {}else{ADT::$func_aliasT[$task]='text';}
            print_r(ADT::$func_aliasT);
           echo stristr($szoveg,$inputstring);

        }

    }

    public function alap()
    {
       AppView::alap();
       //$this->mezokeszit();
       $this->szerk_gomb_beszur();
        AppData::datatomb_LT();
       ADT::$view= LANG::db_feltolt(ADT::$view,ADT::$datatomb_LT);
       if(ADT::$mezokeszit)
       {$this->db_mezo_keszit();}
       if(ADT::$mezotorol)
       {$this->db_mezo_torol();}
    }
    public function ment()
    {
        AppData::ment($_POST['nev']);
        AppView::alap();
    }
    public function cancel()
    {
       AppView::alap();
    }

    public function input()
    {
        AppView::inputmezo(ADT::$task);
    }

    public function text()
    {
        AppView::textmezo(ADT::$task);
    }


    /**
     *  első alakalommal mezők létrehozása a táblában taskok funkciok létrehozása
     */
    public  function szerk_gomb_beszur()
    {
        $html=file_get_contents(ADT::$view_file, true);
        $matches='';
        preg_match_all ("/<!--([^`]*?)-->/",$html , $matches);

        foreach($matches[1] as $mezo)
        {

            $gomb='<button class="btkep" type="submit" name="task" value="'.$mezo.'"><img src="res/ico/32/edit.png"/></br>Szerkeszt</button>';
            $cserestring='<!--##'.$mezo.'-->';
            ADT::$view=str_replace($cserestring, $gomb.$cserestring, ADT::$view );
            ADT::$mezotomb[]=$mezo;
        /*
          $mezonevtomb=  explode('_',$elem);
            if( $mezonevtomb[0]=='tx'){ $mezonev=$mezonevtomb[1];
               ADT::$func_aliasT[$mezonev]= 'text';
            } else { $mezonev=$elem;
                ADT::$func_aliasT[$mezonev]= 'input';}*/
        }

    }
    public function joghiba()
    {
        if($_SESSION['userid']==0)
        {ADT::$view=MOD::login();}
        else
        {ADT::$view='<h2><!--#joghiba--></h2>';}

    }

}

class AppData
{

    public function db_mezo_keszit()
    {
        foreach( ADT::$mezotomb as $mezo)
        {
            $sql="SELECT * FROM ".ADT::$tablanev." WHERE nev='".$mezo."' AND lap='".ADT::$lapnev."'";
            $marvan=DB::assoc_sor($sql);
            if(!empty($marvan))
            {
                $sql="INSERT INTO ".ADT::$tablanev." (nev) VALUES ('".$mezo."') ";
                DB::parancs($sql);
            }
        }
    }
    public function db_mezo_torol()
    {
        $sql="SELECT * FROM ".ADT::$tablanev." WHERE  lap='".ADT::$lapnev."'";
        $tomb=DB::assoc_tomb($sql);
        foreach( $tomb as $sor)
        {
            if(!in_array($sor['nev'],ADT::$mezotomb))
            {
                DB::del('lng',$sor['id']);
            }
        }
    }
    public static  function ment($mezonev)
    {   $en='';$hu='';
        if(isset($_POST['en'])){$en=$_POST['en'];}
        if(isset($_POST['hu'])){$hu=$_POST['hu'];}

        $sql="UPDATE ".ADT::$tablanev." SET en='".$en."', hu='".$hu."' WHERE lap='".ADT::$lapnev."' AND nev='".$mezonev."'";
        //echo $sql;
        $result=DB::parancs($sql);
        return $result;

    }
    public static  function datasor_LT($nev)
    {
        $sql="SELECT * FROM ".ADT::$tablanev." WHERE nev='".$nev."'";
        ADT::$datasor_LT =DB::assoc_sor($sql);
        //return $mezotomb;
    }
    public static  function datatomb_LT()
    {
        $sql="SELECT nev,".GOB::$lang." FROM ".ADT::$tablanev." WHERE lap='".ADT::$lapnev."'";
        ADT::$datatomb_LT=DB::assoc_tomb($sql);
        //return $tomb;
    }
}
$app=new Admin();
//$funcnev=TASK_S::get_funcnev($param=array());
//$app->$funcnev(); //nem kezeli a hibát ha nincs ilyen func
TASK_S::run_funcnev($app);