<?php
$text='meghfg gh ';
$reg_ex='/^.{5,15}$/';
$d=preg_match($reg_ex,$text);
echo $d;