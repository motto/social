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
        $this->view = $view;
        $this->datatomb = $datatomb;
        $this->mezotomb = $mezotomb;
    }

    public function nyito_zaro_data()
   {
    $this->csere_nyito='data="';
    $this->csere_zaro='"';
   }

    /**
     * $mezotomb=array(mezonev1,mezonev2)
     */
    public function view_feltolt($view,$datatomb,$mezotomb)
    {
        $value_str=''; $csere_str='';
        if(is_array($datatomb))
        {
            foreach($datatomb as $key=>$value)
            {
                if(in_array($key,$mezotomb))
                {
                $csere_str=$this->csere_nyito.$key.$this->csere_zaro;
                $value_str=$this->value_nyito.$value.$this->value_zaro;
                $this->view= str_replace($csere_str, $value_str, $this->view );
                }
            }
        }
        return $view;
    }
    public function __toString()
    {
        $view=$this->view_feltolt( $this->view,$this->datatomb,$this->mezotomb);
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