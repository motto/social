<?php
GOB::$html = file_get_contents('tmpl/flat/admin.html', true);

include_once 'app/admin/lib/table.php';
include_once 'app/admin/lib/admin_func.php';
include_once 'app/admin/'.Admin::fget_becsatol().'.php';
echo ADT::$itemid;
$task='alap';
if(isset($_POST['task'])){$task=$_POST['task'];}
$appview=new AppView();
$appdata=new AppData();
switch ($task) {
    case 'uj':
        $tartalom =$appview->uj();
        break;
    case 'szerk':
        //print_r($appdata->item_feltolt());
        $tartalom =$appview->szerk($appdata->item_feltolt());
        break;
    case 'ment' :
        $appdata->ment();
        $tartalom= $appview->lista($appdata->lista_feltolt());
        break;
    case 'mentuj':
        $appdata->ment();
        $tartalom=$appview->uj();
        break;
    case 'cancel':

        $tartalom= $appview->alap($appdata->lista_feltolt());
    break;
    case 'torol':
        $appdata->torol();
        $tartalom= $appview->lista($appdata->lista_feltolt());
        break;
    case 'pub':
        $appdata->pub();
        $tartalom= $appview->lista($appdata->lista_feltolt());
        break;
    case 'unpub':
        $appdata->unpub();
        $tartalom=$appview->lista($appdata->lista_feltolt());
        break;
    default:
        $tartalom= $appview->alap($appdata->lista_feltolt());
}

GOB::$html = str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);

 echo GOB::$html;


?>