<?php

class ADT
{
    public static $jog="noname";
    public static $view="Nincs tartalom";
    public static $view_fileT=array(); //['task'=>'file','task2'=>'file2']
    public static $dataT_sql='';        //['task'=>'sql']
    public static $dataT=array();      //[['mezo2'=>'adat','mezo2'=>'adat2']['mezo2'=>'adat']]
    public static $dbLT_sql='';        //['task'=>'sql']
    public static $dbLT=array();       //[nev=>['hu'=>'adat','en'=>'adat']]
    public static $LT=array();         //[nev=>adat,nev2=>adat2]
    /**Taskok összevonása, több taskhoz ugyanaz a datatomb ['view'=>['task'=>'alias','task2'=>'alias']]
     */
    public static $func_aliasT=array();//['view'=>['task1'=>'alias','task2'=>'alias']]
    public static $allowed_funcT=array();//['func1','func2']
}


class ViewBase
{
    public function __construct($task)
    {
        $this->general($task);
    }
    public function general($task)
    {
        $funcnev= $task;

                if(isset(ADT::$func_aliasT['view'][$task]))
                {
                    $funcnev=ADT::$func_aliasT['view'][$task];
                }

        // StaticClass::{"methodName"}();
        if(1==1)
        {
            $this->$funcnev($task) ;
        }else
        {
            $this->alap($task);
        }

    }

    public function alap($task)
    {
       ADT::$view=file_get_contents(ADT::$view_fileT[$task], true);
    }

    public function result($task)
    {
        $this->general($task);
        return ADT::$view;
    }
}
class DataBase{
    public function __construct($task)
    {
        $this->general($task);
    }
    public function general($task)
    {
        $funcnev= $task;

        if(isset(ADT::$func_aliasT['data'][$task]))
        {
            $funcnev=ADT::$func_aliasT['data'][$task];
        }

        // StaticClass::{"methodName"}();
        if(function_exists(1==1)) //  if(function_exists($this->{$funcnev}))
        {   $this->alap($task);
          $this->$funcnev($task);
            //eval(''.$funcnev.'();');
        }else
        {
            $this->alap($task);
        }


    }

    public function alap($task)
    {
        if(isset(ADT::$dataT_sql[$task]))
        {
            ADT::$dataT=DB::assoc_tomb(ADT::$dataT_sql[$task]);
        }
        if(isset(ADT::$dbLT_sql[$task]))
        {//echo ADT::$dbLT_sql[$task];
            ADT::$dbLT=DB::assoc_tomb(ADT::$dbLT_sql[$task]);
            //print_r(ADT::$dbLT);
        }

    }

}

class AppBase
{
    public function __construct($task)
    {
        $this->general($task);
    }
    public function general($task)
    {
        $funcnev='alap';
        if(!GOB::get_userjog(ADT::$jog))
        {
            $funcnev='joghiba';
        }
        else
        {
            if(in_array($task,ADT::$allowed_funcT))
            {
                $funcnev=$task;
                if(isset(ADT::$func_aliasT['app'][$task]))
                {
                    $funcnev=ADT::$func_aliasT['app'][$task];
                }

            }
        }


       // StaticClass::{"methodName"}();
        if(1==1)
        {
            $this->$funcnev($task) ;
            //echo $funcnev;
        }else
        {
            $this->alap($task);
        }

    }

    public function alap($task)
    {
        ADT::$view =AppS::db_feltolt(ADT::$view,ADT::$dataT);
        ADT::$view=LANG::db_feltolt(ADT::$view,ADT::$dbLT);
        //print_r(ADT::$dbLT);
        ADT::$view=LANG::LT_feltolt(ADT::$view,ADT::$LT);
        //$view=AppS::mod_feltolt(ADT::$view);
       // $view=AppS::inputmezo_feltolt(ADT::$view,ADT::$dataT);

    }
    public function result($task)
    {
        $this->general($task);
        return ADT::$view;
    }

    public function joghiba()
    {
        if($_SESSION['userid']==0)
        {$this->tartalom=MOD::login();}
        else
        {$this->tartalom='<h2><!--#joghiba--></h2>';}

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

