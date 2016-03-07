<?php

class Task
{
   public $task='alap';
   public $task_nev='task';
   public $task_tip=array('post','get'); //az utolsó marad a a task

    public function __construct($paramT=array())
    {   if(!isset($paramT['task'])){$this->task=ADT::$task;}
        $this->set($paramT);
    }
    public function feltolt($paramT=array())
    {
        foreach($paramT as $paramnev=>$paramertek)
        {
          $this->$paramnev = $paramertek;
        }
    }

    public function set($paramT=array())
    {
        $this->feltolt($paramT);
        foreach($this->task_tip as $tip)
        {
            switch ($tip)
            {
                case 'get':
                    if(isset($_GET[$this->task_nev])){$this->task=$_GET[$this->task_nev];}
                    break;
                case 'post':
                    if(isset($_POST[$this->task_nev])){$this->task=$_POST[$this->task_nev];}
                    break;
            }
            ADT::$task=$this->task;

        }
    }
   public function get_funcnev()
    {
        $funcnev=$this->task;
       // print_r(ADT::$func_aliasT);
        if(isset(ADT::$func_aliasT[$this->task]))
        {
            $funcnev=ADT::$func_aliasT[$this->task];
        }

     return $funcnev;
    }
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
}

class TASK_S
{
static public function get_ob($param=array())
{
$ob=new Task($param);
    return $ob;
}
static public function get_funcnev($param=array())
{
    $ob=new Task($param);
   return $ob->get_funcnev();
}
static public function run_funcnev($taskob,$param=array(),$alap='alap')
{
    $ob=new Task($param);
    $ob->run_funcnev($taskob,$alap);
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

