<?php

//include_once 'app/admin/lib/admin_func.php';

//include_once 'lib/ell_conv.php'; //elenőrző convertáló class

if(GOB::get_userjog('admin'))
{
    GOB::$html = file_get_contents('tmpl/flat/admin.html', true);
    $fget='faucet';
}
else
{
    GOB::$html = file_get_contents('tmpl/flat/useradmin.html', true);
    $fget='user_sajat';
}


if(isset($_GET['fget'])){$fget=$_GET['fget'];}
if(isset($_POST['fget'])){$fget=$_POST['fget'];}


$mod='nincs';
if(isset($_GET['mod'])){$mod=$_GET['mod'];}
if(isset($_POST['mod'])){$mod=$_POST['mod'];}
function fget_becsatol($fget){
    include_once 'app/admin/'.$fget.'.php';
    return ADT::$view;
}

switch ($mod) {
    case 'login'://modulok becsatolása------------
        if(GOB::$log_mod){$tartalom=MOD::login();}
        else
        {$tartalom=fget_becsatol($fget);}
        break;
    case 'contact':
        $tartalom=MOD::email();
        break;
    default:  //file becsatolás-----------
        $tartalom=fget_becsatol($fget);
}

//lap generálás a tartalommal-----------------------------------------
GOB::$html= str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);
GOB::$html=FeltoltS::mod(GOB::$html);
GOB::$html=FeltoltS::from_LT(GOB::$html);
GOB::$html= str_replace('<!--refid-->',GOB::$user['id'],GOB::$html);
echo GOB::$html;

?>