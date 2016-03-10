<?php
include_once 'app/admin/lib/table.php';


class GAT
{
    static  public $urlapfiles='';
    static  public $urlap_sql='';
    static  public $urlap_dataT=array();
    static  public $tabla='';  //sql tábla
    static  public $ment_mezok=array();//$mezok: array(array('postnev','mezonev(ha más mit a postnév)','ellenor_func(nem kötelező)'))
    static  public $tabla_szerk=array();//admin tábla
}

class ViewAdmin extends ViewBase
{
    static public function urlap($task)
    {
        ADT::$view=file_get_contents(GAT::$urlapfiles[$task], true);
    }
    static public function tabla()
    {
        ADT::$view=MOD::ikonsor();
        $tabla=MOD::tabla(GAT::$tabla_szerk,ADT::$dataT);
        ADT::$view = str_replace('<!--|tabla|-->', $tabla,ADT::$view);
    }

}
class DataAdmin extends DataBase
{
    static public function urlap($task)
    {
        GAT::$urlap_dataT=DB::assoc_sor(GAT::$urlap_sqlT[$task]);
    }
    /*   static public function enhu_urlap($task)
       {
           GAT::$urlap_dataT=DB::assoc_tomb(GAT::$urlap_sqlT[$task]);
       }**/
    static public function ment_post()
    {
        $result=DB::frissit_postbol(GAT::$tabla,ADT::$itemid,GAT::$ment_mezok);
        return $result;
    }
    static public function beszur_post()
    {
        $result=DB::beszur_postbol(GAT::$tabla,GAT::$ment_mezok);
        return $result;
    }
    static public function torol($id)
    { if(is_array($id))
    {DB::tobb_del(GAT::$tabla,$id);}
    else
    {DB::del(GAT::$tabla,$id);}

    }
    static public function parancs_sql($task)
    {
        $result=DB::parancs(GAT::$urlap_sqlT[$task]);
        return $result;
    }
    static public function pub($id)
    {  if(is_array($id))
    {
        DB::tobb_pub(GAT::$tabla,$id);
    }
    else
    {
        DB::pub(GAT::$tabla,$id);
    }

    }
    static public function unpub($id)
    {
        if(is_array($id))
        {
            DB::tobb_unpub(GAT::$tabla,$id);
        }
        else
        {
            DB::unpub(GAT::$tabla,$id);
        }
    }
}
class AdminBase extends AppBase
{
    public function uj($task)
    {
        ViewAdmin::urlap($task);
    }
    public function szerk()
    {
        ViewAdmin::urlap('szerk');
        DataAdmin::urlap('szerk');
        ADT::$view =FeltoltS::db_feltolt(ADT::$view,GAT::$urlap_dataT);
        ADT::$view=FeltoltS::inputmezo_feltolt(ADT::$view,GAT::$urlap_dataT);
    }
    public function ment()
    {  if(ADT::$itemid=='')
    {
        ADT::$itemid= DataAdmin::beszur_post();
    }
    else
    {
        DataAdmin::ment_post() ;
    }
        $this->alap();
    }
    public function torol()
    {
        DataAdmin::torol($_POST['sor']);
        $this->alap();
    }

    public function pub()
    {
        DataAdmin::pub($_POST['sor']);
        $this->alap();
    }
    public function unpub()
    {   DataAdmin::pub($_POST['sor']);
        $this->alap();
    }

}
class AdminS extends FeltoltS{}

?>