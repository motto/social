<?php


    class Admin
    {
    }
//$query="SELECT * FROM scroll WHERE pub='1' ";
    if(isset($_GET['task']))
    {
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
                       // $tartalom=  Admin::lista();
        }
    }
GOB::$html = file_get_contents('tmpl/flat/admin.html', true);



if(!empty($_GET['fget'])){$fget=$_GET['fget'];
include_once 'app/admin/'.$fget.'.php';}
//$html = str_replace('<!--|tartalom|-->',$tartalom ,$html);
//return $html;

 echo GOB::$html;


?>