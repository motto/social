<?php
class ADT
{
    public static $itemid='0';
    public static $jog='admin';
    public static $itemidtomb=array();
    public static $lista_sql="SELECT * FROM userek ORDER BY id ASC";
    public static $tablanev='userek';
    //public static $ujurlap='app/admin/view/faucet_urlap.html';
    public static $alapview='app/admin/view/tabla_userek.html';
    public static $allowed_func=array('cancel','torol','pub','unpub','joghiba','email');
    /**
     * cim,mezonev,func,tipus
     */
    public static $tablaszerk=array(
        array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
        array('cim'=>'','mezonev'=>'pub','tipus'=>'pubmezo'),
        array('cim'=>'id','mezonev'=>'id'),
        array('cim'=>'Usernév','mezonev'=>'username'),
        array('cim'=>'Tárca','mezonev'=>'tarca'),
        array('cim'=>'Refer','mezonev'=>'ref')
    );

    /**
     * mezonev,postnev,ell,tipus
     */
    public static $mentmezok=array(
        array('mezonev'=>'link'),
        //array('mezonev'=>'','postnev'=>'','ell'=>'','tipus'=>''),
        array('mezonev'=>'leiras','tipus'=>'text'),
        array('mezonev'=>'megjegyzes'),
        array('mezonev'=>'perc','tipus'=>'radio'),
        array('mezonev'=>'pont','tipus'=>'radio')
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


