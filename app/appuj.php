<?php

class ADT
{
    public static $jog="noname";
    public static $itemid='';
    public static $itemid_tomb='';
    public static $feltolt_func="full_feltolt"; //alapból ez tölti fel a view-t
    public static $view="Nincs tartalom";
    public static $itemview="";
    public static $view_file=array('alap'=>'','lista'=>'','item'=>'');
    public static $sql=array('alap'=>'','lista'=>'','item'=>'','dbLT'=>'');
    public static $datatomb=array('alap'=>'','lista'=>'','item'=>'','dbLT'=>'');
    public static $LT=array();
    /**Taskok összevonása, több taskhoz ugyanaz a datatomb ['view'=>['task'=>'alias','task2'=>'alias']]
     */
    public static $func_aliasT=array();//['view'=>['task1'=>'alias','task2'=>'alias']]
    public static $allowed_funcT=array();//['func1','func2']

}


class ViewBase
{
   static public function alap()
   {
       ADT::$view=file_get_contents(ADT::$view_file['alap'], true);
   }
    static public function lista()
    {
        ADT::$view=file_get_contents(ADT::$view_file['lista'], true);
        ADT::$itemview=file_get_contents(ADT::$view_file['item'], true);

    }
   static public function task_to_view($task)
    {
        ADT::$view=file_get_contents(ADT::$view_file[$task], true);
    }


}
class DataBase{
    static public function alap()
    {
        ADT::$datatomb['alap']=DB::assoc_tomb(ADT::$sql['alap']);
    }

    static public function lista()
    {
        ADT::$datatomb['lista']=DB::assoc_tomb(ADT::$sql['lista']);
    }
    static public function item()
    {
    ADT::$datatomb['item']=DB::assoc_tomb(ADT::$sql['item']);
    }
    static public function lang()
    {
        ADT::$datatomb['dbLT']=DB::assoc_tomb(ADT::$sql['dbLT']);
    }
    static public function task_to_data($task)
    {
        ADT::$datatomb[$task]=DB::assoc_tomb(ADT::$sql[$task]);
    }

}

class AppBase
{

    public function general($task)
    {
        $funcnev='alap';
        if(!GOB::get_userjog(ADT::$jog))
        {
            $funcnev='joghiba';
        }
        else
        {
            //if(in_array($task,ADT::$allowed_funcT))
            //{
                $funcnev=$task;
                if(isset(ADT::$func_aliasT['app'][$task]))
                {
                    $funcnev=ADT::$func_aliasT['app'][$task];
                }

            //}
        }
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
            ViewBase::task_to_view($task) ;
            DataBase::task_to_data($task);
        $feltolt_func=ADT::$feltolt_func;
        $this->$feltolt_func($task);
    }
    public function hun_feltolt($task)
    {
        ADT::$view =AppS::db_feltolt(ADT::$view,ADT::$datatomb[$task]);
        ADT::$view=AppS::inputmezo_feltolt(ADT::$view,ADT::$datatomb[$task]);
    }
    public function full_feltolt($task)
    {
        ADT::$view =AppS::db_feltolt(ADT::$view,ADT::$datatomb[$task]);
        ADT::$view=AppS::inputmezo_feltolt(ADT::$view,ADT::$datatomb[$task]);
        ADT::$view=LANG::LT_feltolt(ADT::$view,ADT::$LT);
       // ADT::$view=AppS::mod_feltolt(ADT::$view);
        ADT::$view=AppS::inputmezo_feltolt(ADT::$view,ADT::$dataT);
    }
    public function result($task)
    {
        $this->general($task);
        return ADT::$view;
    }

    public function joghiba()
    {
        if($_SESSION['userid']==0)
        {ADT::$view=MOD::login();}
        else
        {ADT::$view='<h2><!--#joghiba--></h2>';}

    }

}

class AppS{
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

