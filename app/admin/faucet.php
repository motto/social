<?php

GOB::$admin_data['tabla']=array(
    array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
    array('cim'=>'','mezonev'=>'pub','tipus'=>'pubmezo'),
    array('cim'=>'id','mezonev'=>'id','tipus'=>''),
    array('cim'=>'Webcím','mezonev'=>'cim','tipus'=>''),
    array('cim'=>'Megjegyzés','mezonev'=>'jegyzet','tipus'=>''),
    array('cim'=>'PR','mezonev'=>'prior','tipus'=>'')
);
//$tabla:faucet--array('postnev','mezonev(ha más mit a postnév)','ellenor_func(nem kötelező)')
GOB::$admin_data['ment']=array(
    array('link','',''),
    array('megjegyzes','',''),
    array('prior','',''),
    array('pub','',''),
);
GOB::$admin_data['id']=$_POST['sor'][0];

class AppEll
{
public static function base($value){return true;}

}
class AppData
{
public static $tabla='faucet';
public static $itemdata=array();
public static $listdata=array();
public static function pub()
{
  DB::tobb_pub(self::$tabla,$_POST['sor']);
}
public static function unpub()
{
  DB::tobb_unpub(self::$tabla,$_POST['sor']);
}
public static function torol()
{
  DB::tobb_del(self::$tabla,$_POST['sor']);
}
public static function ment()
{
 $id= DB::beszur_postbol(self::$tabla,GOB::$admin_data['ment']);
 return $id;
}
public static function frissit()
{
DB::frissit_postbol(self::$tabla,$_POST['id'],GOB::$admin_data['ment']);
}
public static function item()
{   $sql=select_sql(self::$tabla,GOB::$admin_data['id'],'*');
    self::$itemdata=DB::assoc_sor($sql);
}
public static function lista()
{
    $sql="SELECT * FROM ".self::$tabla." ORDER BY prior ASC";
    self::$itemdata=DB::assoc_tomb($sql);
    return true;
}
}
class AppView
{
    public static function alap(){return true;}
    public static function uj(){return true;}
    public static function szerk(){return true;}
    public static function lista(){return true;}
}

$table = new Table($dataszerk, $datatomb);
$tartalom = file_get_contents('app/admin/view/alap.html', true);
$tartalom = str_replace('<!--|tabla|-->', $table, $tartalom);
file_get_contents('app/admin/view/faucet_urlap.html', true);
GOB::$html = str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);
//echo $table;
