<?php
class Home{
//static  public $data=array();
public static function view(){

$html = file_get_contents('tmpl/'.GOB::$tmpl.'/alap.html', true);
$html = str_replace('<!--|head|-->',Tool_S::view('Head') ,$html);
$html = str_replace('<!--|header|-->',Tool_S::view('Header') ,$html);
$html = str_replace('<!--|tartalom|-->',Tool_S::view('Slide') ,$html);
return $html;
}
}
GOB::$html= Home::view();