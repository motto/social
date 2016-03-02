<?php
$str = <<<HTML
<div class="gallery">text to extract here</div>
<div class="gallery">text to extract from here as well</div>
HTML;

$matches = array();
preg_match_all('#<div[^>]*>(.*?)</div>#', $str, $matches);
//var_dump($matches[1]);

preg_match_all ("/<div class=\"main\">([^`]*?)<\/div>/", $data, $matches);




/*
Note the '?' in the regex, so it is "not greedy".

Which will get you :

array
    0 => string 'text to extract here' (length=20)
  1 => string 'text to extract from here as well' (length=33)
*/