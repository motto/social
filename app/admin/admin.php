<?php
include_once 'app/admin/lib/table.php';
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
//GOB::$html = str_replace('<!--|tartalom|-->',$table ,GOB::$html);

if(!empty($_GET['fget']))
{$fget=$_GET['fget'];}
else
{$fget='faucet';}
include_once 'app/admin/'.$fget.'.php';
 echo GOB::$html;


?>