<?php
include_once 'lib/appview.php';
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
   public static $allowed_func=array('ment','cancel','joghiba','udvozles','udvszoveg','hogyan','hogyan1','hogyan2','hogyan3','jobbegyutt','jobbegyutt_txt','bitcoin','bitcoin_txt','probalja_ki','szeretne_meg','hirlevel');
    public static $mezotomb=array('udvozles','udvszoveg','hogyan','hogyan1','hogyan2','hogyan3','jobbegyutt','jobbegyutt_txt','bitcoin','bitcoin_txt','probalja_ki','szeretne_meg','hirlevel');

    public static $nyitotomb=array();

}


class AppView {
    public static function alapfeltolt($view,$datatomb,$mezotomb)
    {
        $value_str=''; $csere_str='';
        if(is_array($mezotomb))
        {
            if(is_array($datatomb))
            {
                foreach($datatomb as $datasor)
                {
                    if(in_array($datasor['nev'],$mezotomb))
                    {
                        $csere_str='<!--#'.$datasor['nev'].'-->';
                        $value_str=$datasor['hu'];
                        $view= str_replace($csere_str, $value_str, $view );
                    }
                }
            }
        }
        return $view;
    }

   public static function alap()
    {
        $html=file_get_contents(ADT::$alapview, true);
        //echo $html.'------------';
        $datatomb=AppData::datatomb();
        //print_r($datatomb);
        $html=AppView ::alapfeltolt($html,$datatomb,ADT::$mezotomb);
        return $html;
    }
    public static function textmezo($mezonev)
    {
        $html=file_get_contents(ADT::$texturlap, true);
        $datatomb=AppData::datasor($mezonev);
        $html=str_replace('data="nev"', 'value="'.$mezonev.'"', $html );
        $html=str_replace('<!--#hu-->', $datatomb['hu'], $html );
        $html=str_replace('!--#en-->', $datatomb['en'], $html );

        return $html;
    }
    public static function inputmezo($mezonev)
    {
        $html=file_get_contents(ADT::$inputurlap, true);
        $datatomb=AppData::datasor($mezonev);
        $html=str_replace('data="nev"', 'value="'.$mezonev.'"', $html );
        $html=str_replace('data="hu"', 'value="'.$datatomb['hu'].'"', $html );
        $html=str_replace('data="en"', 'value="'.$datatomb['en'].'"', $html );
        return $html;
    }
}

class Admin {
    public  $tartalom='nincs tartalom';

    public function alap()
    {
        $this->tartalom=AppView::alap();
    }
    public function ment()
    {
        AppData::ment($_POST['nev']);
        $this->tartalom=AppView::alap();
    }
    public function cancel()
    {
        $this->tartalom=AppView::alap();
    }
    public function joghiba()
    {
        $this->tartalom='<h2>Jogosultsághiba!</h2>';
    }
    public function udvozles(){$this->tartalom=AppView::inputmezo('udvozles');}
    public function udvszoveg(){$this->tartalom=AppView::inputmezo('udvszoveg');}
    public function hogyan(){$this->tartalom=AppView::inputmezo('hogyan');}
    public function hogyan1(){$this->tartalom=AppView::textmezo('hogyan1');}
    public function hogyan2(){$this->tartalom=AppView::textmezo('hogyan2');}
    public function hogyan3(){$this->tartalom=AppView::textmezo('hogyan3');}
    public function jobbegyutt(){$this->tartalom=AppView::inputmezo('jobbegyutt');}
    public function jobbegyutt_txt(){$this->tartalom=AppView::textmezo('jobbegyutt_txt');}

    /**
     *  első alakalommal mezők létrehozása a táblában taskok funkciok létrehozása
     */
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
    public static  function ment($mezonev)
    {   $en='';$hu='';
        if(isset($_POST['en'])){$en=$_POST['en'];}
        if(isset($_POST['hu'])){$hu=$_POST['hu'];}

        $sql="UPDATE lng SET en='".$en."', hu='".$hu."' WHERE lap='nyito' AND nev='".$mezonev."'";
        //echo $sql;
        $result=DB::parancs($sql);
        return $result;

    }
    public static  function datasor($nev)
    {
        $sql="SELECT * FROM lng WHERE nev='".$nev."'";
        $mezotomb=DB::assoc_sor($sql);
        return $mezotomb;
    }
    public static  function datatomb()
    {
        $sql="SELECT * FROM lng WHERE lap='nyito'";
        $tomb=DB::assoc_tomb($sql);
        return $tomb;
    }
}


class AppEll extends AppEll_base{}