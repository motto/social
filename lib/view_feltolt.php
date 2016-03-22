<?php

class FeltoltS{
    public static function hibakiir($hibatomb){
        $res='';
        foreach ($hibatomb as $hiba){
            $res =$res.'<h4>'.$hiba.'</h4>';
        }
        return $res;
    }
    static public function mod($view)
    {
        preg_match_all ("/<!--:([^`]*?)-->/",$view , $matches);
        $mezotomb=$matches[1];
        if(is_array($mezotomb))
        {
            foreach($mezotomb as $mezo)
            {
                $view= str_replace('<!--:'.$mezo.'-->', MOD::$mezo(), $view);
            }
        }
        return $view;
    }
    static public function fromdb($view,$datatomb)
    {

        if(is_array($datatomb))
        {
            foreach($datatomb as $mezonev=>$mezoertek)
            {
                if(isset($mezoertek))
                {
                    $view= str_replace('<!--#'.$mezonev.'-->',$mezoertek, $view);
                    $view= str_replace('data="'.$mezonev.'"','value="'.$mezoertek.'"' , $view);
                    $view= str_replace('data="'.$mezonev.'">','>'.$mezoertek , $view);
                }
            }
        }
        return $view;
    }



    public static function LT_fromdb($view,$datatomb)
    {
        foreach($datatomb as $datasor)
        {
            $csere_str='<!--##'.$datasor['nev'].'-->';
            $view= str_replace($csere_str,$datasor[GOB::$lang] , $view);
        }
        //}
        return $view;
    }
    public static function from_LT($view,$LT=array())
    {
        if(empty($LT)){$LT=GOB::$LT;}
        // a GOB::LT nagy lehet ne keljen rjatmindig végifutni:
        preg_match_all ("/<!--##([^`]*?)-->/",$view , $matches);
        $cseretomb=$matches[1];

        foreach($cseretomb as $mezonev)
        {
            if(isset($LT[$mezonev]))
            {
                $csere_str='<!--##'.$mezonev.'-->';
                $view= str_replace($csere_str,$LT[$mezonev], $view);
            }


        }
        return $view;
    }
    public static function from_sajatLT($view,$LTnev)
    {
        preg_match_all ("/<!--##([^`]*?)-->/",$view , $matches);
        $cseretomb=$matches[1];

        //get_object_vars ( object $object )
        $vars = get_class_vars($LTnev);
        foreach($cseretomb as $mezonev)
        {
           // print_r($LTnev::$$mezonev);
            if(  property_exists($LTnev,$mezonev ))
            {   $lt=$vars[$mezonev];
                $csere_str='<!--##'.$mezonev.'-->';
                $view= str_replace($csere_str,$lt[GOB::$lang], $view);
            }


        }
        return $view;
    }



    public static function LT_tisztit($view)
    {
        preg_match_all ("/<!--##([^`]*?)-->/",$view , $matches);
        $cseretomb=$matches[1];

        foreach($cseretomb as $mezonev)
        {

                $csere_str='<!--##'.$mezonev.'-->';
                $view= str_replace($csere_str,'', $view);


        }
        return $view;
    }

}