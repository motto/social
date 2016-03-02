<?php
class MOD
{
public static function enhu_zaszlo()
{
    include_once 'mod/zaszlo/zaszlo.php';
    $zaszlo=new Zaszlo();
    return $zaszlo->eng_hu()
        ;
}

}