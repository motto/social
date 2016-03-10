<?php
class REGNUM
{
    /**
     * pozitív vagy negativ szám, tizeds tört is lehet
     */
    static public $szam='/^[-+]?(\d*[.])?\d+$/';//
}
class REGCHAR
{
    static function REG_EX($reg_ex,$text,$parancsazonosíto=''){
        $d=preg_match($reg_ex,$text);
        if($d==false)GOB::$hiba['ELL'][]=$parancsazonosíto.':regexhiba';
        return $d;
    }
    static function SAJAT_REG_EX($reg_ex,$text,$parancsazonosíto=''){
        $d=self::REG_EX(self::$REG_EX_TOMB[$reg_ex],$text);
        return $d;
    }
}

class ELL{
    /**
     * ez fut le íráskor és frissétéskor ha nincs megadva ell függvény a mezőtömbben
     */
    static public function base(){return true;}
}
class CONV{

}








?>
