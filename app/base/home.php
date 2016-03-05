<?php

ADT::$view_fileT['alap']='tmpl/'.GOB::$tmpl.'/content/nyito.html';
ADT::$dbLT_sql['alap']="SELECT * FROM lng WHERE lap='nyito' ";
//echo $task;
class Data extends DataBase{} $dt=new Data($task);
class View extends ViewBase{} $vw=new View($task);
class App extends AppBase{


}     $ap=new App($task);
