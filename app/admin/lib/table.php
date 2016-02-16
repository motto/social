<?php
class table
{
    public  $datatomb;
    public  $dataszerk;
    public  $param;
    /**
     * table constructor.
     */
    public function __construct($dataszerk,$datatomb)
    {
        //$dataszerk=array("azonosító"=>"id","azonosító"=>"id");
        $this->dataszerk=$dataszerk;
        $this->datatomb=$datatomb;
    }
    public function mezo($data)
    {
        $html='<td>'.$data.'</td>';
      return $html;
    }
    public function checkbox_mezo($id)
    {   //$checked_tomb = $_POST['sor'];
        $data='<input type="checkbox" name="sor[]" value="'.$id.'" />';
        $html=$this->mezo($data);
        return $html;
    }
    public function sor($sor)
    {
        $html='<tr>';
        foreach($sor as $data)
        {
            $html=$html.$this->mezo($data);
        }
        $html=$html.'</tr>';
        return $html;
    }

}