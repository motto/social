<?php
class Zaszlo
{
    public $hu_img ='tmpl/flat/images/hu.png';
    public $en_img = 'tmpl/flat/images/en.png';

    function eng_hu()
    {
        $nyelvcsere = 'hu';
        $img = $this->hu_img;
        if (GOB::$lang == 'hu') {
            $nyelvcsere = 'en';
            $img = $this->en_img;
        }
        $link = LINK::link_cserel('lang=' . $nyelvcsere);
        $result = '<a href="' . $link . '" ><img src="'.$img.'" height="30px;"></a>';
        return $result;
    }

    function eng_hu_link()
    {
        $result='<li>'.$this->eng_hu().'</li>';
        return $result;
    }
}