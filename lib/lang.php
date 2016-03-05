<?php
class LANG{
public static function db_feltolt($view,$datatomb,$cseretomb=array())
    {
        if(empty($cseretomb))
        {
            preg_match_all ("/<!--##([^`]*?)-->/",$view , $matches);
            $cseretomb=$matches[1];
        }
        //print_r($datatomb);
        if(is_array($cseretomb))
        {
            foreach($datatomb as $value)
            {
                $csere_str='<!--##'.$value['nev'].'-->';
                $view= str_replace($csere_str,$value[GOB::$lang] , $view);
            }
        }
        return $view;
    }
    public static function LT_feltolt($view,$cseretomb=array())
    {
        if(empty($cseretomb))
        {
            preg_match_all ("/<!--#([^`]*?)-->/",$view , $matches);
            $cseretomb=$matches[1];
        }
        //print_r($datatomb);
        if(is_array($cseretomb))
        {
            foreach($cseretomb as $value)
            {   if(isset(GOB::$LT[$value]))
            {
                $csere_str='<!--#'.$value.'-->';
                $view= str_replace($csere_str,GOB::$LT[$value], $view);
            }

            }
        }
        return $view;
    }
}
