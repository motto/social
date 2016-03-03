<?php

/**
 * $datatomb lehet $_POST is,vagy sima DB::assoc_tomb()
 * $mezotomb=array(mezonev1,mezonev2)
 */
class ViewFeltolt
{
    public $view='';
    public $csere_nyito='<!--#';
    public $csere_zaro='-->';
    public $value_nyito='';
    public $value_zaro='';
    public $datatomb=array();
    public $mezotomb=array();

    /**
     * $datatomb lehet $_POST is,vagy sima DB::assoc_tomb()
     * $mezotomb=array(mezonev1,mezonev2)
     */
    public function __construct($view,$datatomb,$mezotomb)
    {
        $this->thisfeltolt($view,$datatomb,$mezotomb);
    }
    public function thisfeltolt($view,$datatomb,$mezotomb)
    {
        $this->view = $view;
        $this->datatomb = $datatomb;
        $this->mezotomb = $mezotomb;
    }

    public function nyito_zaro_datara()
   {
       $this->csere_nyito='data="';
       $this->csere_zaro='"';
       $this->value_nyito='data="';
       $this->value_zaro='"';
   }

    /**
     * $mezotomb=array(mezonev1,mezonev2)
     */
    public function view_feltolt()
    {
        $value_str=''; $csere_str='';$view='';
        if(is_array($this->mezotomb))
        {
            foreach($this->mezotomb as $mezonev)
            {
                if(isset($this->datatomb[$mezonev]))
                {
                $csere_str=$this->csere_nyito.$mezonev.$this->csere_zaro;
                $value_str=$this->value_nyito.$this->datatomb[$mezonev].$this->value_zaro;
                $view= str_replace($csere_str, $value_str, $this->view );
                }
            }
        }
        return $view;
    }
    public function __toString()
    {
        $view=$this->view_feltolt();
        return $view;
    }
    /**
     * $mezotomb=array(mezonev1,mezonev2)
     */
    public function view_feltolt_postbol($view,$mezotomb)
    {
        $view=$this->view_feltolt($view,$_POST,$mezotomb);
        return $view;
    }

}
/**
 * $datatomb lehet $_POST is,vagy sima DB::assoc_tomb()
 * $mezotomb=array(mezonev1,mezonev2)
 */
class Sview
{
   static public function feltolt($view,$datatomb,$mezotomb)
    {
        $view=new ViewFeltolt($view,$datatomb,$mezotomb);
        return $view->view_feltolt();
    }
   static public function inputfeltolt($view,$datatomb,$mezotomb)
    {
        $view=new ViewFeltolt($view,$datatomb,$mezotomb);
        $view->nyito_zaro_datara();
        return $view->view_feltolt();
    }
}