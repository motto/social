<?php
class ADT
{
    public static $itemid='0';
    public static $jog='user';
    public static $itemidtomb=array();
    public static $allowed_func=array('uj','vissza','ment','joghiba');
}
$mktime_most=time();
$mktime=$mktime_most-6000;
$sql="SELECT * FROM faucet ORDER BY pont DESC,perc DESC ";
$linktomb=DB::assoc_tomb($sql);
$sql="SELECT * FROM faucet_log WHERE userid ='".$_SESSION['userid']."' AND mktime>".$mktime."";
$logtomb=DB::assoc_tomb($sql);
if(is_array($logtomb))
{
  $lik= $linktomb[0] ;
}
else
{
  foreach($linktomb as $link)
  {

  }
}
$tartalom = file_get_contents('tmpl/'.GOB::$tmpl.'/alap.html', true);
$tartalom = str_replace('<!--|tartalom|-->', '', $tartalom);
echo $tartalom;