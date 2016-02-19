<?php
GOB::$html = file_get_contents('tmpl/flat/admin.html', true);

include_once 'app/admin/lib/table.php';
include_once 'app/admin/lib/admin_func.php';
include_once 'app/admin/'.Admin::fget_becsatol().'.php';
//$query="SELECT * FROM scroll WHERE pub='1' ";
if(isset($_POST['task'])){$task=$_POST['task'];}
switch ($task) {
    case 'new':
        $tartalom =AppView::uj();
        break;
    case 'edit':
        $tartalom =AppView::szerk();
        break;
    case 'ment':
        AppData::ment();
        $tartalom= AppView::lista();
        break;
    case 'mentuj':
        AppData::ment();
        $tartalom=AppView::uj();
        break;
    case 'cancel':
        $tartalom= AppView::alap();
    break;
    case 'del':
        AppData::torol();
        $tartalom= AppView::lista();
        break;
    case 'pub':
        AppData::pub();
        $tartalom= AppView::lista();
        break;
    case 'unpub':
        AppData::unpub();
        $tartalom=AppView::lista();
        break;
    default:
        $tartalom= AppView::alap();
}

GOB::$html = str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);

 echo GOB::$html;


?>