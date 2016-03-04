<?php
include_once 'app/admin/lib/table.php';
include_once 'app/admin/lib/admin_func.php';
//htmlben kicseréli a nyelvi elemeket-----------------------


//menüsor beállítása------------------------------------------
if(GOB::get_userjog('admin'))
{
    GOB::$html = file_get_contents('tmpl/flat/admin.html', true);
    $fget='faucet';
}
else
{
    GOB::$html = file_get_contents('tmpl/flat/useradmin.html', true);
    $fget='alap';
}

$task='alap';
if(isset($_GET['task'])){$task=$_GET['task'];}
if(isset($_POST['task'])){$task=$_POST['task'];}

if(isset($_GET['fget'])){$fget=$_GET['fget'];}

//tartalom elősáálítása----------------------
$tartalom="nincs tartalom";

switch ($fget) {
    case 'login'://modulok becsatolása------------
        $tartalom=MOD::login();
        break;
    case 'mas modul':
      //  echo "i equals 1";
        break;
    default:  //file becsatolás-----------
     include_once 'app/admin/'.Admin_base::fget_becsatol($fget).'.php';
     $admin=new Admin();
     $tartalom=$admin->result($task);
}

//lap generálás a tartalommal-----------------------------------------
GOB::$html= str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);
//nyelvi elemek feltöltése---------------------------------
$matches=array();
preg_match_all ("/<!--#([^`]*?)-->/",GOB::$html , $matches);
$lang_cseretomb=$matches[1];;
GOB::$html=LANG::feltolt(GOB::$html,GOB::$LT,$lang_cseretomb);
echo GOB::$html;
?>