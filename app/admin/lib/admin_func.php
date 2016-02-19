<?php
class Admin
{
   static public function fget_becsatol($fget = 'faucet')
    {
        if (!empty($_GET['fget']))
        {
            $fget = $_GET['fget'];
        }
    return $fget;
    }

}