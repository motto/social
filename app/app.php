<?php
class SAPP{

    static public function get_fget($fget = '')
    {
        if (!empty($_GET['fget']))
        {
            $fget = $_GET['fget'];
        }
        if(!in_array($fget,ADT::$allowed_fget))
        {
            $fget='';
        }

        return $fget;
    }
    static public function get_task($task)
    {
        if(isset($_GET['task'])){$task=$_GET['task'];}
        if(isset($_POST['task'])){$task=$_POST['task'];}

        return $task;
    }
}
class View_base
{
    public function __construct()
    {//echo 'tmpl/' . GOB::$tmpl . '/' . ADT::$html_file ;
        if (is_file('tmpl/' . GOB::$tmpl . '/' . ADT::$html_file ))
        {
        ADT::$html = file_get_contents('tmpl/' . GOB::$tmpl . '/' . ADT::$html_file , true);
        } else if (is_file('app/' . GOB::$app . '/view/' . ADT::$html_file ))
        {
        ADT::$html = file_get_contents('app/'.GOB::$app .'/view/'. ADT::$html_file , true);
        }
    }

}
/**
 *becsatolja az fget-et ha van illetve beállítja az ADT::$task-ot
 * tartalmazza (illetve a leszármazottaiban kell definiálni) a task függvényeket;
 */
class App_base
{
    public function __construct()
    {
        if(GOB::get_userjog(ADT::$jog))
        {
            $fget=SAPP::get_fget();
            if($fget!='')
            {
                include_once'app/'.GOB::$app.'/'.$fget.'';
            }
            else
            {
                ADT::$task=SAPP::get_task(ADT::$task);
            }
        }
       else
       {
           ADT::$task='joghiba';
       }
    }

///666Motto@
    public function joghiba()
    {
        ADT::$tartalom='<center><h2>Jogosultság hiba!</h2></center>';
    }
}