<?php
class ADT
{
    public static $itemid='0';
    public static $jog='user';
    public static $itemidtomb=array();
    public static $allowed_func=array('uj','vissza','ment','joghiba');

}
$mktime_most=time();
$mktime=$mktime_most-600;// max10 órával ezelőttieket nézi csak
$sql="SELECT * FROM faucet ORDER BY pont DESC,perc DESC ";
$linktomb=DB::assoc_tomb($sql);

$sql="SELECT * FROM faucet_log WHERE userid ='".$_SESSION['userid']."' AND mktime>'".$mktime."' ORDER BY mktime ";
$logtomb=DB::assoc_tomb($sql);

$logtomb_idkulcs=TOMB::mezobol_kulcs($logtomb,'linkid');
//print_r($logtomb_idkulcs);
$akt_link=array();
$varotomb=array();
if(empty($logtomb))
{
    $akt_link= $linktomb[0] ;
}
else
{
  foreach($linktomb as $link)
  {
      $linkid=$link['id'];
      if(empty($akt_link))
      {
        if(isset($logtomb_idkulcs[$linkid]))
        {
         $logsor=$logtomb_idkulcs[$linkid];
         $lejar=$logsor['mktime']+$link['perc'];//másodpercet számol
            //$lejar=$logsor['mktime']+$link['perc']*60; //percet számol
             if($lejar<$mktime_most)
             {
                 $akt_link=$link;
             }
             else
             {$hatravan=$lejar-$mktime_most;
                 $link['lejar']=$hatravan;
                 $varotomb[]=$link;
             }

        }
        else
        {
          $akt_link=$link;
        }
      }
  }

}
$varolista='';
function varolink($link,$pont,$perc)
{
   $result='<div class="varodiv">
                <div class="varolink">'.parse_url($link, PHP_URL_HOST).'</div>
                <div class="varopont">'.$pont.'</div>
                <div class="varoperc">'.$perc.'</div>
                <div style="clear: both;"></div>
             </div>' ;
    return $result;
}
$varolista='<style>
.varolink{
float: left;
background-color:white ;
width: 150px;
color: #080808;
padding: 2px;
margin: 1px;
overflow: hidden;
}
.varopont{
float: left;
background-color:white ;
width: 40px;
color: #080808;
padding: 2px;
margin: 1px;
}
.varoperc{
float: left;
background-color:red ;
color: yellow;
width: 40px;
padding: 2px;
margin: 1px;

}
</style>';
$varolista= $varolista.'<div id="infoablak" style="position:fixed;top:100px;left:10px;vidth:1000px;z-index: 1000;">';
$varolista= $varolista.'<div class="varodiv">
                <div class="varolink">Link</div>
                <div class="varopont">Pont</div>
                <div class="varopont">perc</div>
                <div style="clear: both;"></div>
             </div>' ;
foreach($varotomb as $varosor)
{
  $varolista= $varolista.varolink($varosor['link'],$varosor['pont'],$varosor['lejar']);
}
$varolista= $varolista.'</div>';
//if(empty($akt_link))
$sql="INSERT INTO faucet_log (userid,linkid,mktime)
VALUES ('".$_SESSION['userid']."','".$akt_link['id']."','".$mktime_most."')";
DB::beszur($sql);
$tartalom='<h5>link</h5>';
$tartalom=$tartalom.TOMB::to_string($akt_link);
$tartalom=$tartalom.'<h5>varotomb</h5>';
$tartalom=$tartalom.$varolista;
$view = file_get_contents('tmpl/'.GOB::$tmpl.'/alap.html', true);
$view = str_replace('<!--|tartalom|-->', $tartalom,$view );
echo $view;