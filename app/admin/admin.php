<?php

//include_once 'app/admin/lib/admin_func.php';

include_once 'lib/ell_conv.php'; //elenőrző convertáló class

if(GOB::get_userjog('admin'))
{
    GOB::$html = file_get_contents('tmpl/flat/admin.html', true);
    $fget='faucet';
}
else
{
    GOB::$html = file_get_contents('tmpl/flat/useradmin.html', true);
    $fget='usernyito';
}
GOB::$html=FeltoltS::from_LT(GOB::$html);
GOB::$html=FeltoltS::mod(GOB::$html);

if(isset($_GET['fget'])){$fget=$_GET['fget'];}

switch ($fget) {
    case 'login'://modulok becsatolása------------
        $tartalom=MOD::login();
        break;
    case 'contact':
        $tartalom=MOD::email();
        break;
    default:  //file becsatolás-----------
        include_once 'app/admin/'.$fget.'.php';
        $tartalom=ADT::$view;
}

//lap generálás a tartalommal-----------------------------------------
GOB::$html= str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);

echo GOB::$html;

?>