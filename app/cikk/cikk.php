<?php
include_once 'app/mod/modul/modul.php';
class Cikk{
//static  public $data=array();
    public static function view(){

        $id=$_GET['id'];
        $query="SELECT cim,kep,text FROM cikk WHERE id='".$id."'";
        $item_html=file_get_contents('tmpl/'.GOB::$tmpl.'/cikk.html', true);
        //$param='query:'.$query.',html:'.$item_html;
        $data['tartalom']=TOOL::item_query(array('query'=>$query,'html'=>$item_html));
        $data['fomenu']=TOOL::fomenu();
        $data['slide']=TOOL::slide();
        $data['head'] =TOOL::head();
        $html2=file_get_contents('tmpl/'.GOB::$tmpl.'/base.html', true);
        $html= ITEM_S::view($html2, $data);
        return $html;
    }
}
GOB::$html= Cikk::view();
?>