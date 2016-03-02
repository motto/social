
<?php

class MOD{
    static  public function lista($html,$data_tomb){
        include_once 'mod/lista/lista.php';
        return Lista_S::view($html,$data_tomb);
    }
//$html_tomb=array('tip1'=>$html1,'tip2'=>$html2)
//dat_tomb=array('tip1'=>$data,'tip1'=>$data2,'tip2'=>$data3)
    static  public function lista_multi($html_tomb,$data_tomb){
        include_once 'mod/lista/lista.php';
        return Lista_S::multi_view($html_tomb,$data_tomb);
    }
    //$data_tomb=array('toolnev'=>$param,'toolnev2'=>$param2);
    static  public function lista_tool($data_tomb){
        include_once 'mod/lista/lista.php';
        return Lista_S::tool($data_tomb);
    }

    static  public function kereso($html,$data){
        include_once 'mod/modul/modul.php';
        return Item_S::view($html,$data);
    }
    static  public function ads($html,$data){
        include_once 'mod/modul/modul.php';
        return Item_S::view($html,$data);
    }
    static  public function item_s($html,$data){
        include_once 'mod/modul/modul.php';
        return Item_S::view($html,$data);
    }
    static  public function item($param){
        include_once 'mod/modul/modul.php';
        return GYART::result('Item',$param);
    }
    static  public function item_query($param){
        include_once 'mod/modul/modul.php';
        return GYART::result('ItemQuery',$param);
    }
static  public function fomenu(){
        include_once 'mod/fomenu/fomenu.php';
    $fomenu=new Fomenu();
    return $fomenu->result();
}

//head lista ---------------------
static  public function head($tomb=array()){
        include_once 'mod/head/head.php';
    $head=new Head();
    return $head->result($tomb);
}
static  public function slide($param=array()){
 include_once 'mod/slide/slide.php';
    $slide =new Slide();

 return $slide->result();
}
    static  public function scrol($param=array()){
    include_once 'mod/scroll/scroll.php';
    return GYART::result('Scroll');
}

}