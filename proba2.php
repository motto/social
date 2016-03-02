<?php
$str = <<<HTML
<div<!--#rrr --> class="gallery">text to extract here<!--#bbb --></div>
<div class="gallery">text<!--:ssljh als --> to extract from here as well</div>
HTML;
//preg_match_all ("/<div class=\"main\">([^`]*?)<\/div>/", $data, $matches);
preg_match_all ("/<!--#([^`]*?)-->/", $str, $matches);
print_r($matches[1]);