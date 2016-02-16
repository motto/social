<?php
class Item extends Gyarthato
{   public $html;
    public $data;
    public function result()
    {
     $html=$this->html;
        foreach ($this->data as $key=>$value){
            $html= str_replace('<!--|'.$key.'|-->',$value, $html);
        }
    return $html;
    }
}
class ItemQuery extends Gyarthato
{   public $html;
    public $query;
    public function result()
    {
        $html=$this->html;
        $data=DB::assoc_sor($this->query);
        foreach ($data as $key=>$value){
            $html= str_replace('<!--|'.$key.'|-->',$value, $html);
        }
        return $html;
    }
}
class ITEM_S {
//adatokkal tölt fel egy html-t pl: a <!--|tartalom|--> elemet kicseréli $data['tartalom']-al
    static public function view($html,$data){
    foreach ($data as $key=>$value){
        $html= str_replace('<!--|'.$key.'|-->',$value, $html);
    }
    return $html;
}
//A $html <!--tartalom--> elemét kicseréli az  $append elemre
    static public function into($html,$append)
    {
        $html= str_replace('|tartalom|', $html,$append);
        return $html;
    }
// into-t adatokkal tölt fel
        static public function view_into($html,$data,$append){
        $html= self::into($html,$append);
        $html= self::view($html,$data);
            return $html;
    }
    //a $html_tomb -ben lévő hteml elemeket egymásba helyezi az első <!--tartalom--> elemét kicseréli a másodikra a második <!--tartalom--> elemét aharmadikra stb..
    static public function dom($html_tomb){
        $html='';
        foreach ( $html_tomb  as $tomb){
            $html= self::into($html,$tomb);
        }
        return $html;
    }
// dom -ot állít elő és  adatokkal töl fel
    static public function view_dom($html_tomb,$data){

        $html= self::dom($html_tomb);
        $html= self::view($html,$data);
        return $html;
    }
}