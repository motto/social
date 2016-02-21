<?php
class ADT
{
    public static $itemid='0';
    public static $itemidtomb=array();
    public static $tablanev='tarca';
    public static $lista_sql="SELECT * FROM tarca ORDER BY id ASC";
    public static $ujurlap='app/admin/view/tarca_urlap.html';
    public static $alapview='app/admin/view/tabla_pubnelkul.html';
    public static $tablaszerk=array(
        array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
       // array('cim'=>'','mezonev'=>'pub','tipus'=>'pubmezo'),
        array('cim'=>'id','mezonev'=>'id','tipus'=>''),
        array('cim'=>'tárca cím','mezonev'=>'tarca','tipus'=>''),
        array('cim'=>'Megjegyzés','mezonev'=>'megjegyzes','tipus'=>''),
        array('cim'=>'Kiadva','mezonev'=>'userid','tipus'=>'')
    );
    public static $mentmezok=array(
        array('tarca','',''),
        array('megjegyzes','','')
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

class AppEll extends AppEll_base{}
class AppData extends AppData_base{}
class AppView extends AppView_base{}