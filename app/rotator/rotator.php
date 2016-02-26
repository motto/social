<?php
include_once 'app/rotator/view/view.php';

class ADT
{
    //paraméterek---------------------------
    public static $jog='user';
    public static $allowed_func=array('uj','vissza','ment','joghiba');

    //globális változók---------------------------
    public static $itemid='0';
    public static $userid='0';
    public static $mktime='0';
    public static $itemtomb=array();
    public static $linktomb=array();

}
class Lap
{


    public function __construct()
    {
        ADT::$mktime=time();
        ADT::$userid=$_SESSION['userid'];
       if(isset($_GET['id'])){ADT::$itemid=$_GET['id'];}
    }
}
class Adatok
{

    public function __construct()
    {
        $this->linktomb_feltolt();
        $this->itemtomb_feltolt();
        $this->logol();
    }

    public  function logol()
    {
        $sql1= "DELETE FROM faucet_log WHERE userid = '".ADT::$userid."' AND linkid = '".ADT::$itemid."' ";
        DB::parancs($sql1);
        $sql= "INSERT INTO faucet_log (userid,linkid,mktime)VALUES ('".ADT::$userid."','".ADT::$itemid."','".ADT::$mktime."')";
        DB::beszur($sql);
    }
    public function linktomb_feltolt()
    {
        $sql="SELECT * FROM faucet ORDER BY pont DESC" ;
        $sql_log="SELECT * FROM faucet_log WHERE userid='".ADT::$userid."'" ;
        $linktomb=DB::assoc_tomb($sql);
        $logtomb=DB::assoc_tomb($sql_log);
        $logtomb_idkulcs=TOMB::mezobol_kulcs($logtomb,'linkid');

        foreach($linktomb as $linksor)
        {
            if(isset($logtomb_idkulcs[$linksor['id']]))
            {
                $eltelt=ADT::$mktime-$logtomb_idkulcs[$linksor['id']]['mktime'];
                $linksor['hatravan']=$linksor['perc']-$eltelt;
                if($linksor['hatravan']<1){$linksor['hatravan']=0;}
            }
            else
            {
                $linksor['hatravan']=0;
            }

            ADT::$linktomb[]=$linksor;
        }
    }
    public function itemtomb_feltolt()
    {
        if(ADT::$itemid==0)
        {
          $megvan='';
          foreach(ADT::$linktomb as $link)
          {
              if($link['hatravan']==0 && $megvan=='')
              {
                  ADT::$itemtomb=$link;
                  // print_r(ADT::$linktomb);
                  ADT::$itemid=ADT::$itemtomb['id'];
                  $megvan='ok';
              }

          }

        }
        else
        {
            ADT::$itemtomb=DB::assoc_sor("SELECT * FROM faucet WHERE id='".ADT::$itemid."'");
        }
    }


}
$lap=new Lap();
$adatok=new Adatok();

$tartalom='<div style="width:1500px; position:absolute;top:100px;">'.Rview::varolista();
$tartalom=$tartalom.'<iframe src="'.ADT::$itemtomb['link'].'"  width="1200px" height="1500px"></iframe></div>';
$view = file_get_contents('tmpl/'.GOB::$tmpl.'/alap.html', true);
$view = str_replace('<!--|tartalom|-->', $tartalom,$view );
$view = str_replace('//<!--var_itemid-->','var itemid=\''.ADT::$itemid.'\';',$view );
echo $view;
