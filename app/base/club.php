<?php
class Club{
//static  public $data=array();
    public static function view(){
        $html = file_get_contents('tmpl/'.GOB::$tmpl.'/scroll.html', true);

        $html = str_replace('<!--|header|-->',Tool_S::view('Header') ,$html);
        $html = str_replace('<!--|tartalom|-->',Tool_S::view('Scroll') ,$html);

        return $html;
    }
}
//echo 'hgbkehgkejhgekjgkhehkehkkj';Lap::$html= Scroll::view();
GOB::$html=Club::view();