<?php
GOB::$html=file_get_contents('tmpl/'.GOB::$tmpl.'/base.html', true);
$tartalom='<h3>Még nem működik a mail küldés</h3>';;
//echo $tartalom;
GOB::$html= str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);
echo GOB::$html;

