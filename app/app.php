<?php
class App
{
    static public function get_fget($fget = 'faucet')
    {
        if (!empty($_GET['fget']))
        {
            $fget = $_GET['fget'];
        }
        return $fget;
    }

}