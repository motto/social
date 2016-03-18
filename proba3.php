<?php
class AppViewS
{

    public static function alap()
    {
        echo 'appview alap';

    }
}
class AppViewS2
{

    public static function alap()
    {
        echo 'appview alap2';

    }
}

if(method_exists ('AppViewS555', 'alap')){AppViewS2::alap();}else{echo 'nincs';}