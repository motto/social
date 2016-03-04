<?php
class View extends ViewBase{}
class Data extends DataBase{}
class App extends AppBase{}
class ADT
{
public static $jog="";
public static $view_file="";
public static $view="";
public static $sql="";
public static $datatomb="";
public static $allowed_func="";
public static $allowed_fget="";
}
//------------------------------------------------------------
class ViewBase{
    public $view='nincs view';
    /**
     * Taskok összevonása, több taskhoz ugyanaz a view ['task'=>'alias','task2'=>'alias']
     */
    public $func_alias_tomb=array();

    public function alap()
    {
       $this->view=file_get_contents(ADT::$view_file, true);
    }
    public function result($task)
    {
        if(!GOB::get_userjog(ADT::$jog)){$task='joghiba';}
        if(isset($func_alias_tomb[$task]))
        {$task=$func_alias_tomb[$task];}
        if(in_array($task,ADT::$allowed_func))
        {
            if(function_exists($this->$task))
            {$this->$task();}
            else
            {$this->alap();}
        }
        else
        {
            $this->alap();
        }
        return $this->view;
    }


}
class DataBase{

    public $datatomb=array();
    public $sql='';
    /**Taskok összevonása, több taskhoz ugyanaz a datatomb ['task'=>'alias','task2'=>'alias']
     */
    public $func_alias_tomb=array();
    public function lista($sql)
    {
        $this->datatomb=DB::assoc_tomb($sql);
    }
    public function alap($sql)
    {
        $this->datatomb=DB::assoc_sor($sql);
    }
    public function result($task,$sql='')
    {
        if(!GOB::get_userjog(ADT::$jog)){$task='joghiba';}
        if(isset($func_alias_tomb[$task]))
        {$task=$func_alias_tomb[$task];}
        if(in_array($task,ADT::$allowed_func))
        {
            if(function_exists($this->$task))
            {$this->$task($sql);}
            else
            {$this->alap($sql);}
        }
        else
        {
            $this->alap($sql);
        }
        return $this->datatomb;
    }


}

class AppBase
{
    public $tartalom='nincs tartalom';
    public $appview='';
    public $appdata=array();
    /**Taskok összevonása, több taskhoz ugyanaz a datatomb ['task'=>'alias','task2'=>'alias']
     */
    public $func_alias_tomb=array();

    public function result($task)
    {  // $this->appview=ViewS::result($task);
        //$this->appdata=DataS::result($task);
        if(!GOB::get_userjog(ADT::$jog)){$task='joghiba';}
        if(isset($func_alias_tomb[$task]))
        {$task=$func_alias_tomb[$task];}
        if(in_array($task,ADT::$allowed_func))
        {
            if(function_exists($this->$task))
            {$this->$task();}
            else
            {$this->alap();}
        }
        else
        {
            $this->alap();
        }
        return $this->tartalom;
    }
    public function joghiba()
    {
        if($_SESSION['userid']==0)
        {$this->tartalom=MOD::login();}
        else
        {$this->tartalom='<center><h2><!--#joghiba--></h2></center>';}

    }
    public function alap()
    {
        $this->tartalom=AppS::feltolt($this->appview,$this->appdata);
        $this->tartalom=AppS::inputmezo_feltolt($this->appview,$this->appdata);
    }


}

class ViewS
{
    static public function result($task,$alias_tomb=array()){
      $view=new View();
       $view->func_alias_tomb=$alias_tomb;
       return $view->result($task);
    }
}
class DataS
{
    static public function result($task,$sql='',$alias_tomb=array()){
        $data=new Data();
        $data->func_alias_tomb=$alias_tomb;
        return $data->result($task,$sql='');
    }
}

class AppS{
    static public function result($task,$alias_tomb=array()){
        $app=new App();
        $app->func_alias_tomb=$alias_tomb;
        return $app->result($task,$sql='');
    }
    static public function feltolt($view,$datatomb)
    {
        preg_match_all ("/<!--D([^`]*?)-->/",ADT::$html , $matches);
        $mezotomb=$matches[1];
        $value_str=''; $csere_str='';
        if(is_array($mezotomb))
        {
            foreach($mezotomb as $mezo)
            {   if(isset($datatomb[$mezo]))
            {
                $csere_str = '<!--D'.$mezo.'-->';
                $value_str = $datatomb[$mezo];
            }
            }
            $view= str_replace($csere_str, $value_str, $view);

        }
        return $view;
    }
    static public function inputmezo_feltolt($view,$datatomb,$mezotomb=array())
    {
        $matches=array();$value_str=''; $csere_str='';
        if(empty($mezotomb)){preg_match_all("/data=\"([^`]*?)\"/",ADT::$html,$matches);}
        $mezotomb=$matches[1];
        if(is_array($mezotomb))
        {
            foreach($mezotomb as $mezo)
            {   if(isset($datatomb[$mezo]))
            {
                $csere_str = 'data="'.$mezo.'""';
                $value_str = 'value="'.$datatomb[$mezo].'""';
            }
            }
            $view= str_replace($csere_str, $value_str, $view);

        }
        return $view;
    }
}

