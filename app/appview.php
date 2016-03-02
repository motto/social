<?php
class ViewFeltolt
{
    public $view='';
    public $csere_nyito='<!--|';
    public $csere_zaro='|-->';
    public $value_nyito='';
    public $value_zaro='';
    public $datatomb=array();
    public $mezotomb=array();

    /**
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
        $value_str=''; $csere_str='';
        if(is_array($this->datatomb))
        {
            foreach($this->datatomb as $key=>$value)
            {
                if(in_array($key,$this->mezotomb))
                {
                $csere_str=$this->csere_nyito.$key.$this->csere_zaro;
                $value_str=$this->value_nyito.$value.$this->value_zaro;
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