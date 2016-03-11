<?php
class ADT
{
    public static $jog='admin';
    public static $task='alap';
    public static $task_valaszt=array('post','get');
    public static $view='';
    public static $datasor_LT=array();
    public static $lapnev='usernyito';
    public static $tablanev='userek';
    public static $view_file='tmpl/flat/content/user_nyitoadmin.html';
}
class Admin{

    public function alap()
    {$sql="SELECT userid, SUM(satoshi) AS total_satoshi FROM penztar GROUP BY userid";
        $dat=DB::assoc_tomb($sql);
        print_r($dat);

        if($_SESSION['userid']>0)
        {
            ADT::$view=file_get_contents(ADT::$view_file, true);
        }
        else
        {
            ADT::$view=MOD::login();
            ;
        }
    }

}
$app=new Admin();
$app->alap();