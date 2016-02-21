<?php

interface IF_AppData
{
    public  function pub();
    public  function unpub();
    public  function torol();
    public function ment();
    public  function beszur();
    public  function frissit();
    public  function item();
    public  function lista();
}
interface IF_AppView
{
    public function alap();
    public function uj();
    public function szerk();
    public function lista();
}

class Admin_base
{
    public $appview;
    public $appdata;
    public $allowed_func='';
    public $tartalom='';
    public function __construct($appview,$appdata)
    {
        $this->appview=$appview;
        $this->appdata=$appdata;
    }
public function uj(){$this->tartalom =$this->appview->uj();}
public function szerk(){$this->tartalom =$this->appview->szerk($this->appdata->item_feltolt());}
public function ment(){$this->appdata->ment();
    $this->tartalom= $this->appview->lista($this->appdata->lista_feltolt());}

public function mentuj(){$this->appdata->ment();
    $this->tartalom=$this->appview->uj();}
public function cancel(){$this->tartalom= $this->appview->alap($this->appdata->lista_feltolt());}
public function torol(){$this->appdata->torol();
    $this->tartalom= $this->appview->lista($this->appdata->lista_feltolt());}
public function pub(){$this->appdata->pub();
    $this->tartalom= $this->appview->lista($this->appdata->lista_feltolt());
}
public function unpub(){$this->appdata->unpub();
    $this->tartalom=$this->appview->lista($this->appdata->lista_feltolt());}
public function alap()
{
    $this->tartalom=$this->appview->alap($this->appdata->lista_feltolt());
}
public function joghiba()
    {
        $this->tartalom='<center><h2>Jogosultság hiba!</h2></center>';
    }

    static public function view_feltolt($view,$datatomb,$elotag='<!--',$utotag='-->',$value_elotag='',$value_utotag='')
    {
        $value_str=''; $csere_str='';
    if(is_array($datatomb))
    {
      foreach($datatomb as $key=>$value)
      {
         $csere_str=$elotag.$key.$utotag;

          $value_str=$value_elotag.$value.$value_utotag;
          $view= str_replace($csere_str, $value_str, $view);
      }
    }
        return $view;
    }


    static public function fget_becsatol($fget = 'faucet')
    {
        if (!empty($_GET['fget']))
        {
            $fget = $_GET['fget'];
        }
        return $fget;
    }

}
class AppEll_base
{
    public static function base($value){return true;}

}

class AppData_base
{
    public  function pub()
    {
        DB::tobb_pub(ADT::$tablanev,ADT::$itemidtomb);
    }
    public  function unpub()
    {
        DB::tobb_unpub(ADT::$tablanev,ADT::$itemidtomb);
    }
    public  function torol()
    {//print_r(ADT::$itemidtomb);
        DB::tobb_del(ADT::$tablanev,ADT::$itemidtomb);
    }
    public function beszur()
    {
        $id= DB::beszur_postbol(ADT::$tablanev,ADT::$mentmezok);
        return $id;
    }
    public  function frissit()
    {
        DB::frissit_postbol(ADT::$tablanev,ADT::$itemid,ADT::$mentmezok);
    }
    public  function ment()
    {//echo ADT::$itemid ;
        if(ADT::$itemid >'0')
        {
            $this->frissit();
        }
        else
        {
            $this->beszur();
        }
    }
    public  function item_feltolt()
    {   $sql=DB::select_sql(ADT::$tablanev,ADT::$itemid);
        //ADT::$itemtomb=DB::assoc_sor($sql);
        $itemtomb=DB::assoc_sor($sql);
        return $itemtomb;
    }
    public  function lista_feltolt()
    {
        $sql=ADT::$lista_sql;
       // $sql="SELECT * FROM ".ADT::$lista_sql." ORDER BY prior ASC";
        //ADT::$listatomb=DB::assoc_tomb($sql);
        $listatomb=DB::assoc_tomb($sql);
        return  $listatomb;
    }

}

class AppView_base
{
    public function alap($listatomb)
    {
      $tartalom=$this->lista($listatomb);
       return $tartalom;
    }
    public function uj(){
       $tartalom= file_get_contents(ADT::$ujurlap, true);
        return $tartalom;
    }
    public function szerk($itemtomb)
    {
        $tartalom= $this->uj();
        $tartalom= Admin::view_feltolt($tartalom,$itemtomb,'data="','"','value="','" ');
        return $tartalom;
    }
    public function lista($listatomb)
    {
        $table = new Table(ADT::$tablaszerk,$listatomb);
        $tartalom = file_get_contents(ADT::$alapview, true);
        $tartalom = str_replace('<!--|tabla|-->', $table, $tartalom);
        return $tartalom;
    }
}