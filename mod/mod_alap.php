<?php
class Task
{   public $adt='ADT';
    public $ob=null;
    //ADT-be--------------------------
    public $task_nev='motask';//ADT::$alap_func;ADT::tiltott_func
    public $task_tip=array('post','get');//az utolsó lesz a post

    public function __construct($ob,$adt)
    {
        $this->ob = $ob; $this->adt = $adt;
    }


    public function get_funcnev()
    {
        foreach($this->task_tip as $tip) {
            switch ($tip) {
                case 'get':
                    if (isset($_GET[$this->task_nev])) {
                        $funcnev = $_GET[$this->task_nev];
                    }
                    break;
                case 'post':
                    if (isset($_POST[$this->task_nev])) {
                        $funcnev = $_POST[$this->task_nev];
                    }
                    break;
            }
        }
        if(in_array($funcnev ,ADT::tiltott_func )){$funcnev=ADT::$alap_func;}
        if(!method_exists ($this->ob , $funcnev)){$funcnev=ADT::$alap_func;}
        if(!GOB::get_userjog(ADT::$jog)) {$funcnev='joghiba';}
        return $funcnev;
    }

}



class TASK_S
{
    static public function get_funcnev($ob,$adt)
    {
        $ob2=new Task($ob,$adt);
        return $ob2->get_funcnev();
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

        if(is_array($datatomb))
        {
            foreach($datatomb as $mezonev=>$mezoertek)
            {
                if(isset($mezoertek))
                {
                    $view= str_replace('<!--#'.$mezonev.'-->',$mezoertek, $view);
                    $view= str_replace('data="'.$mezonev.'"','value="'.$mezoertek.'"' , $view);
                    $view= str_replace('data="'.$mezonev.'">','>'.$mezoertek , $view);
                }
            }
        }
        return $view;
    }



    public static function LT_db_feltolt($view,$datatomb)
    {
        foreach($datatomb as $datasor)
        {
            $csere_str='<!--##'.$datasor['nev'].'-->';
            $view= str_replace($csere_str,$datasor[GOB::$lang] , $view);
        }
        //}
        return $view;
    }
    public static function LT_feltolt($view,$dataT=array())
    {
        if(empty($dataT)){$dataT=GOB::$LT;}
        // a GOB::LT nagy lehet ne keljen rjatmindig végifutni:
        preg_match_all ("/<!--##([^`]*?)-->/",$view , $matches);
        $cseretomb=$matches[1];

        foreach($cseretomb as $mezonev)
        {
            $csere_str='<!--##'.$mezonev.'-->';
            $view= str_replace($csere_str,$dataT[$mezonev], $view);

        }
        return $view;
    }

}
class  AppEll
{
    /**
     * ez fut le íráskor és frissétéskor ha nincs megadva ell függvény a mezőtömbben
     */
    static public function base(){return true;}
}