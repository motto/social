<?php
class ADT
{
    public static $itemid='0';
    public static $jog='admin';
    public static $itemidtomb=array();
    public static $lista_sql="SELECT * FROM faucet ORDER BY prior ASC";
    public static $tablanev='faucet';
    public static $ujurlap='app/admin/view/faucet_urlap.html';
    public static $alapview='app/admin/view/tabla_alap.html';
    public static $allowed_func=array('uj','szerk','ment','mentuj','cancel','torol','pub','unpub','joghiba');
    public static $tablaszerk=array(
array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
array('cim'=>'','mezonev'=>'pub','tipus'=>'pubmezo'),
array('cim'=>'id','mezonev'=>'id','tipus'=>''),
array('cim'=>'Webcím','mezonev'=>'link','tipus'=>''),
array('cim'=>'Megjegyzés','mezonev'=>'megjegyzes','tipus'=>''),
array('cim'=>'PR','mezonev'=>'prior','tipus'=>'')
);
    public static $mentmezok=array(
    array('link','',''),
    array('megjegyzes','',''),
    array('prior','','')
);
    public static $listatomb=array();
    public static $itemtomb=array();
}
if(isset($_POST['sor'][0]))
{
    ADT::$itemid=$_POST['sor'][0];
    ADT::$itemidtomb=$_POST['sor'];
}
if(isset($_POST['itemid']))
{
    ADT::$itemid=$_POST['itemid'];
}
class Admin extends Admin_base{};
class AppEll extends AppEll_base{}
class AppData extends AppData_base{}
class AppView extends AppView_base{}


