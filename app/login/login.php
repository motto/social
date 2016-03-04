<?php
GOB::$html=file_get_contents('tmpl/'.GOB::$tmpl.'/alap.html', true);
$tartalom=MOD::login();
//echo $tartalom;
GOB::$html= str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);
echo GOB::$html;