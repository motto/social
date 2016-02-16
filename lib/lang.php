<?php
include 'language/hu.php';
//$uj_lang=['uj_szo'=>'Új szó','uj_szo2'=>'Mégegy szó'];
//LANG::$lang_tomb=array_merge(LANG::$lang_tomb,$uj_lang); új szó hozzáadása a nyelv tömbhöz
// LANG::RET('PASSWORD');  visszatér a password szó nyelvi megfelelőjével
// LANG::ECH(['PASSWORD','N']);  kírja a password szó nyelvi megfelelőjét csupa Nagybetűvel
// LANG::ECH(['PASSWORD','k']);  kírja a password szó nyelvi megfelelőjét csupa kisbetűvel
// LANG::ECH(['PASSWORD','Nk']);  kírja a password szó nyelvi megfelelőjét Nagy kezdőbetűvel
// LANG::ECH(['PASSWORD','Nkk']);  kírja a password szó nyelvi megfelelőjét Nagy kezdő és csupa kisbetűvel
//  LANG::ECH(['R_SZAM','Nk'],[['Szám mező','NAGY']]);   kírja az R_SZAM szó nyelvi megfelelőjét Nagy kezdőbetűvel  és behelyettesíti a 'Szám mező' paramétert csupa nagybetűvel: 'A SZÁM MEZŐ csak szám lehet!(tizedes tört és negatív is' 
class LANG{
    static public $param=array();
    static public $lang_tomb=array();

    static function param_beir($param){//frissíti a paratömböt
        foreach($param as $key=>$value1){
            if(is_array($value1)){
                switch ($value1[1]) {
                    case 'k': $value = strtolower($value1[0]); break;
                    case 'N': $value = strtoupper($value1[0]); break;
                    case'Nk': $value =  ucfirst($value1[0]); break;
                    case'Nkk': $value = ucfirst(strtolower($value1[0])); break;
                }
            }else{$value=$value1;}

            self::$param[$key]=$value;
        }}
    static function cserel($cserelendo,$param=array()){
        foreach($param as $key=>$value1){
            if(is_array($value1)){
                switch ($value1[1]) {
                    case 'k': $value = strtolower($value1[0]); break;
                    case 'N': $value = strtoupper($value1[0]); break;
                    case'Nk': $value =  ucfirst($value1[0]); break;
                    case'Nkk': $value = ucfirst(strtolower($value1[0])); break;
                    default :$value=$value1[0];
                }
            }else{$value=$value1;}
            $cserelendo = str_replace("<<$key>>", $value,$cserelendo);
        }
        return $cserelendo;
    }
    static function RET($szo1,$param=array()){
        if(is_array($szo1)){$szo=$szo1[0];}else{$szo=$szo1;}
        $v= self::$lang_tomb[$szo];
//echo 'vvvvvvvvvv'.$v;
        if($v==''){$v=$szo;}else{if(!empty($param)){$v=self::cserel($v, $param);}}
        if(is_array($szo1)){
//echo 'fffffffff'.$szo1;
            switch ($szo1[1]) {
                case 'k': $v = strtolower($v); break;
                case 'N': $v = strtoupper($v); break;
                case'Nk': $v =  ucfirst($v); break;
                case'Nkk': $v = ucfirst(strtolower($v)); break;
                default :$v=$v;
            }
        }

        return $v;
    }
// a $param lehet associativ vagy sima tömb
    static function ECH($szo,$param=array()){echo self::RET($szo,$param);}
}
