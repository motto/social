<?php
GOB::$html=file_get_contents('tmpl/flat/rotator.html', true);
GOB::$html=LANG::LT_feltolt(GOB::$html);
GOB::$html=AppS::mod_feltolt(GOB::$html);
if($_SESSION['userid']==0)
{
        $tartalom=MOD::login();
}
else
{
        $tartalom=MOD::rotator();
}



//lap generálás a tartalommal-----------------------------------------
GOB::$html= str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);
echo GOB::$html;