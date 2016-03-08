<?php
class TaskValaszt
{
    public $task='alap';
    public $task_nev='task';
    public $task_tip=array('post','get');//az utolsó lesz a post

    public function __construct($task_nev='', $task='alap',$task_tip=array('post','get'))
    {
        if($task_nev!=''){$this->task_nev = $task_nev;}
        $this->task = $task;
        $this->task_tip = $task_tip;
    }


    public function result()
    {   $task=$this->task;
        foreach($this->task_tip as $tip) {
            switch ($tip) {
                case 'get':
                    if (isset($_GET[$this->task_nev])) {
                        $ask = $_GET[$this->task_nev];
                    }
                    break;
                case 'post':
                    if (isset($_POST[$this->task_nev])) {
                        $task = $_POST[$this->task_nev];
                    }
                    break;
            }
        }
        return  $task;
    }

}
class ValasztS
{
   static public function Nev($valasztT=array('post','get'))
    {
        $ob=new TaskValaszt('nev','nincs',$valasztT);
        return $ob->result();
    }
    static public function task($task='alap',$valasztT)
    {
        $ob=new TaskValaszt('task',$task,$valasztT);
        return $ob->result();
    }
}
class Task extends TaskADT
{

    public function result()
    {
        $funcnev=$this->get_funcnev();

        $nev=ValasztS::Nev(ADT::$task_valaszt);
        if($nev!='nincs')
        {
            $funcnev='szerk';
            ADT::$nev=$nev;
        }
        if(!method_exists ($this->ob , $funcnev)){$funcnev=ADT::$task;}
        if(!GOB::get_userjog(ADT::$jog))
        {$funcnev='joghiba';}
       return $funcnev;
    }
}

class TaskADT
{
    public $ob=null;
    public $taskvalaszt=null;
    public $funcnev='alap';
    public function __construct($ob)
    {
        $this->ob = $ob;
    }

    public function get_funcnev()
    {
        $funcnev=ValasztS::task(ADT::$task,ADT::$task_valaszt);
        ADT::$task=$funcnev;
        if(isset(ADT::$func_aliasT[$funcnev]))
        {
            $funcnev=ADT::$func_aliasT[$funcnev];
        }
        if(!method_exists ($this->ob , $funcnev)){$funcnev=ADT::$task;}
        if(!GOB::get_userjog(ADT::$jog))
        {$funcnev='joghiba';}
     return $funcnev;
    }

     /*
    public function run_funcnev($taskob,$alap='alap')
    {
        $funcnev=$this->get_funcnev();
        try
        {
            $taskob->$funcnev();


        } catch (exception $e)
        {
            GOB::$hiba['task function'][]=$e->getMessage();
            $taskob->$alap();
        }

    }

    public function feltolt($paramT=array())
    {
        foreach($paramT as $paramnev=>$paramertek)
        {
          $this->$paramnev = $paramertek;
        }
    }*/
}

class TASK_S
{
static public function get_funcnev($ob)
{
    $ob2=new TaskADT($ob);
    return $ob2->get_funcnev();
}
static public function get_nev_funcnev($ob)
{
    $ob2=new Task($ob);
    return $ob2->result();
}
}

class AppS{
    static public function result($task){
        $app=new App($task);
        return $app->result($task);
    }

    static public function all_feltolt($view,$datatomb)
    {
        $view=self::mod_feltolt($view);
        $view=self::db_feltolt($view,$datatomb);
        $view=self::inputmezo_feltolt($view,$datatomb);
        return $view;
    }
    static public function mod_feltolt($view)
    {
        preg_match_all ("/<!--:([^`]*?)-->/",$view , $matches);
        $mezotomb=$matches[1];
        if(is_array($mezotomb))
        {
            foreach($mezotomb as $mezo)
            {
                $view= str_replace('<!--:'.$mezo.'-->', MOD::$mezo(), $view);
            }
        }
        return $view;
    }
    static public function db_feltolt($view,$datatomb)
    {
        preg_match_all ("/<!--x([^`]*?)-->/",$view ,$matches);
        $mezotomb=$matches[1];
        if(is_array($mezotomb))
        {
            foreach($mezotomb as $mezo)
            {
                if(isset($datatomb[$mezo]))
                {
                    $view= str_replace('<!--x'.$mezo.'-->',$datatomb[$mezo], $view);
                }
            }
        }
        return $view;
    }
    static public function inputmezo_feltolt($view,$datatomb)
    {
        $matches=array();
        preg_match_all("/data=\"([^`]*?)\"/",$view,$matches);
        $mezotomb=$matches[1];
        if(is_array($mezotomb))
        {
            foreach($mezotomb as $mezo)
            {   if(isset($datatomb[$mezo]))
                {
                    $view= str_replace('data="'.$mezo.'""',$datatomb[$mezo].'""' , $view);
                }
            }
        }
        return $view;
    }
}

