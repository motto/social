<?phpinclude_once 'app/app.php';GOB::$html=file_get_contents('tmpl/flat/base.html', true);GOB::$html=FeltoltS::from_LT(GOB::$html);GOB::$html=FeltoltS::mod(GOB::$html);$fget='home';if(isset($_GET['fget'])){$fget=$_GET['fget'];}switch ($fget) {case 'login'://modulok becsatolása------------$tartalom=MOD::login();break;case 'contact':$tartalom=MOD::email();break;default:  //file becsatolás-----------include_once 'app/base/'.$fget.'.php';$tartalom=ADT::$view;}//lap generálás a tartalommal-----------------------------------------GOB::$html= str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);echo GOB::$html;