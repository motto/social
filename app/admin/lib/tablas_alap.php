<?php
//include_once 'lib/view_feltolt';
class ADT
{//paraméterek------------------------
    public static $jog = 'admin';
    public static $view_file = '';
    public static $urlap_file = '';
    public static $datatomb_sql = '';
    public static $datasor_sql = '';
    public static $tablanev = '';
    public static $task = 'alap';
    public static $ikonsor = array('uj','szerk','pub','unpub','torol','email');
    public static $task_valaszt = array('post', 'get');
    public static $tabla_szerk = array(array('cim' => '', 'mezonev' => '', 'tipus' => 'checkbox'));
    public static $ment_mezok = array(array('mezonev' => '', 'postnev' => '', 'ell' => '', 'tipus' => ''));
    //tárolók-----------------------------------
    public static $id = '';
    public static $idT = '';
    public static $view = '';
    public static $datatomb = array();
    public static $datasor = array();
    // public static $datatomb_LT=array();
    // public static $datasor_LT=array();
    public static $datatabla = ''; //ide kerül a generált táblázat
}

class AppView {

    public static function alap()
    {
        ADT::$view=MOD::ikonsor(ADT::$ikonsor);
        ADT::$view=str_replace('<!--|tabla|-->', ADT::$datatabla, ADT::$view );

    }
    public static function urlap()
    {
        $html=file_get_contents(ADT::$urlap_file, true);

        if(!empty(ADT::$datasor))
        {
            $html=str_replace('data="id"', 'value="'.ADT::$id.'"', $html );
            $html=FeltoltS::fromdb($html,ADT::$datasor);
            //$html=FeltoltS::fromdb($html,ADT::$datasor);
        }

        ADT::$view= $html;
    }
}

class AdminBase {

    public function __construct()
    {
        if(isset($_POST['sor'][0]))
        {
            ADT::$id=$_POST['sor'][0];
            ADT::$idT=$_POST['sor'];
        }
        if(isset($_POST['itemid']))
        {
            ADT::$id=$_POST['itemid'];
        }
        if(isset($_POST['id']))
        {
            ADT::$id=$_POST['id'];
        }

    }

    public function alap()
    {
        AppDataS::datatomb(ADT::$datatomb_sql);
        ADT::$datatabla=MOD::tabla(ADT::$tabla_szerk,ADT::$datatomb);
        AppView::alap();
    }
    public function ment()
    {
      //  echo ADT::$id;
        if(!empty(ADT::$id))
        {
            AppDataS::ment();

        }else
        {
            AppDataS::beszur();
        }
        $this->alap();
    }
    public function mentuj()
    {

        if(!empty(ADT::$id))
        {
            AppDataS::ment();
        }else
        {
            AppDataS::beszur();
        }
        $this->uj();
    }

    public function cancel()
    {
        $this->alap();
    }
    public function uj()
    {
        AppView::urlap();
    }
    public function szerk()
    {
     AppDataS::datasor(ADT::$datasor_sql);
        AppView::urlap();
    }
    public function email()
    {
       ADT::$view='Mailküldes';
    }

    public function torol()
    {
        DB::tobb_del(ADT::$tablanev,ADT::$idT);
        $this->alap();
    }

    public function pub()
    {
        DB::tobb_pub(ADT::$tablanev,ADT::$idT);
        $this->alap();
    }
     public function unpub()
    {
        DB::tobb_unpub(ADT::$tablanev,ADT::$idT);
        $this->alap();
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
       DB::frissit_postbol(ADT::$tablanev,ADT::$id,ADT::$ment_mezok);
    }
    public static  function beszur()
    {
        ADT::$id=DB::beszur_postbol(ADT::$tablanev,ADT::$ment_mezok);
    }
    public static  function datasor($sql)
    {
        ADT::$datasor =DB::assoc_sor($sql);
       // print_r(ADT::$datasor);
       // echo $sql;
        return ADT::$datasor;
    }
    public static  function datatomb($sql)
    {
        ADT::$datatomb =DB::assoc_tomb($sql);
        return ADT::$datatomb;
    }
}