<?php
class LANG{
public static function feltolt($view,$datatomb,$cseretomb)
    {
        //print_r($datatomb);
        if(is_array($cseretomb))
        {
            foreach($cseretomb as $value)
            {   if(isset($datatomb[$value]))
            {
                $csere_str='<!--#'.$value.'-->';
                $view= str_replace($csere_str, $datatomb[$value], $view);
            }

            }
        }
        return $view;
    }
}
