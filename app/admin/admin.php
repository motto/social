<?php
$fget='admin';
if(!empty($_GET['fget'])){$fget=$_GET['fget'];}
    include_once 'app/admin/'.$fget.'.php';

    class Admin
    {
    }
$query="SELECT * FROM scroll WHERE pub='1' ";
     switch ($_GET['task'])
     {
                case 'ment':
                    //$tartalom= Tool_S::view('edit');
                    $tartalom=$editview;
                    Admin::ment();
                    break;
                case 'new':
                    //$tartalom= Tool_S::view('new');
                    break;
                default:
                    $tartalom=  Admin::lista();
    }
            $html = file_get_contents('app/admin/view/club.html', true);
            $html = str_replace('<!--|tartalom|-->',$tartalom ,$html);
            return $html;


    GOB::$html=$html;


?>