<?php
class ADT1
{
    public static $jog='noname';
    public static $referer=true;
    public static $alap_func='alap';
    public static $task_nev='ltask';
    public static $task_tip=array('post','get');
    public static $tiltott_func=array();

}
class ModTask
{
    public function task_valaszt($adt='ADT1')
    {
        $tasknev =$adt::$alap_func;
        foreach ($adt::$task_tip as $tip)
        {
            switch ($tip) {
                case 'get':
                    if (isset($_GET[$adt::$task_nev])) {
                        $tasknev = $_GET[$adt::$task_nev];
                    }
                    break;
                case 'post':
                    if (isset($_POST[$adt::$task_nev])) {
                        $tasknev = $_POST[$adt::$task_nev];
                    }
                    break;
            }
        }
      return $tasknev;
    }
      public function get_funcnev($ob,$adt='ADT1')
    {
        $funcnev=$this->task_valaszt($adt);
        if(in_array($funcnev ,$adt::$tiltott_func )){$funcnev=$adt::$alap_func;}
        if(!method_exists ($ob , $funcnev)){$funcnev=$adt::$alap_func;}
        if(!GOB::get_userjog($adt::$jog)) {$funcnev='joghiba';}
        return $funcnev;
        //return 'ggggggggg';
    }

}
class ModTaskS
{
    static public function get_funcnev($ob,$adt='LogADT')
    {
        $log=new ModTask();
        return $log->get_funcnev($ob,$adt);
    }
    static   public function task_valaszt($adt='LogADT')
    {
        $log=new ModTask();
        return $log->get_funcnev($adt);
    }

}


class  AppEll
{
    /**
     * ez fut le íráskor és frissétéskor ha nincs megadva ell függvény a mezőtömbben
     */
    static public function base(){return true;}
}