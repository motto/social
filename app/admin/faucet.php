<?php
/*
if (isset($_POST['sor'])) {
    $optionArray = $_POST['sor'];
    for ($i=0; $i<count($optionArray); $i++) {
        echo $optionArray[$i]."<br />";
    }
}*/
$dataszerk=array(
    array('cim'=>'','mezonev'=>'','tipus'=>'checkbox'),
    array('cim'=>'','mezonev'=>'','tipus'=>'pubmezo'),
    array('cim'=>'id','mezonev'=>'id','tipus'=>''),
    array('cim'=>'Webcím','mezonev'=>'cim','tipus'=>''),
    array('cim'=>'Megjegyzés','mezonev'=>'jegyzet','tipus'=>''),

);
$datatomb=array(
    array('id'=>'1','cim'=>'https://mail.google.com/mail/u/0/#inbox','jegyzet'=>'dfh fghfgh fhf fgh hfghfhfgjfgjfgfg','pub'=>'1'),
    array('id'=>'2','cim'=>'https://mail.google.com/mail/u/0/#inbox','jegyzet'=>'dfh fghfgh fhf fgh hfghfhfgjfgjfgfg','pub'=>'0'),
    array('id'=>'3','cim'=>'https://mail.google.com/mail/u/0/#inbox','jegyzet'=>'dfh fghfgh fhf fgh hfghfhfgjfgjfgfg','pub'=>'5'),
    array('id'=>'4','cim'=>'https://mail.google.com/mail/u/0/#inbox','jegyzet'=>'dfh fghfgh fhf fgh hfghfhfgjfgjfgfg','pub'=>'0')
);
$task='';
if(isset($_POST['task'])){$task=$_POST['task'];}
switch ($task) {
    case 'new':
    case 'edit':
        $tartalom = file_get_contents('app/admin/view/faucet_urlap.html', true);
       // $tartalom = str_replace('<!--|tabla|-->', $table, $tartalom);
        break;
    case 'save':
    case 'del':
    case 'pub':
    case 'unpub':
    default:
        $table = new Table($dataszerk, $datatomb);
        $tartalom = file_get_contents('app/admin/view/alap.html', true);
        $tartalom = str_replace('<!--|tabla|-->', $table, $tartalom);
}
GOB::$html = str_replace('<!--|tartalom|-->',$tartalom ,GOB::$html);
//echo $table;
