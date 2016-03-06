<?php

    ADT::$jog='admin';
    ADT::$dataT_sql=array("alap"=>"SELECT * FROM faucet ORDER BY pont DESC,perc DESC ");
    GAT::$urlap_sqlT=array("szerk"=>"SELECT * FROM faucet WHERE ID='".ADT::$itemid."' ");
    GAT::$tabla='faucet';
    GAT::$urlapfiles =array('uj'=>'app/admin/view/faucet_urlap.html',
                            'szerk'=>'app/admin/view/faucet_urlap.html');
    ADT::$view_fileT=array('alap'=>'app/admin/view/tabla_alap.html');
   // public static $allowed_func=array('uj','szerk','ment','mentuj','cancel','torol','pub','unpub','joghiba');
    //public static $listatomb=array();
   // public static $itemtomb=array();
    /**
     * cim,mezonev,func,tipus
     */
    GAT::$tabla_szerk =array(
array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
array('cim'=>'','mezonev'=>'pub','tipus'=>'pubmezo'),
array('cim'=>'id','mezonev'=>'id','tipus'=>''),
array('cim'=>'Webcím','mezonev'=>'link','tipus'=>''),
array('cim'=>'Megjegyzés','mezonev'=>'megjegyzes','tipus'=>''),
array('cim'=>'Perc','mezonev'=>'perc','tipus'=>''),
array('cim'=>'Pont','mezonev'=>'pont','tipus'=>'')
);
    /**
     * mezonev,postnev,ell,tipus
     */
   GAT::$ment_mezok =array(
    array('mezonev'=>'link'),
    //array('mezonev'=>'','postnev'=>'','ell'=>'','tipus'=>''),
    array('mezonev'=>'leiras','tipus'=>'text'),
    array('mezonev'=>'megjegyzes'),
    array('mezonev'=>'perc'),
    array('mezonev'=>'pont'));


if(isset($_POST['sor'][0]))
{
    ADT::$itemid=$_POST['sor'][0];
   // ADT::$itemidtomb=$_POST['sor'];
}
if(isset($_POST['itemid']))
{
    ADT::$itemid=$_POST['itemid'];
}
class Admin extends AdminBase{
function alap(){
    DataBase::task_to_data('alap');
    ViewAdmin::tabla();
}
};
$task='alap';
if(isset($_GET['task'])){$task=$_GET['task'];}
if(isset($_POST['task'])){$task=$_POST['task'];}

$admin=new Admin();
$admin->general($task);

//class AppEll extends AppEll_base{}



