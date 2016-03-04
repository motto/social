<?php
class ADT
{

    public static $jog='user';
    public static $itemidtomb=array();
    public static $lista_sql="SELECT * FROM faucet ORDER BY pont DESC,perc DESC ";
    public static $tablanev='user';
    public static $ujurlap='app/admin/view/faucet_urlap.html';
    public static $alapview='app/admin/view/tabla_alap.html';
    public static $allowed_func=array('uj','szerk','ment','mentuj','cancel','torol','pub','unpub','joghiba');

    public static $listatomb=array();
    public static $itemtomb=array();
}

class Admin extends Admin_base{
  public  function alap()
  {
      $this->tatalom='alap';
  }
};
class AppEll extends AppEll_base{}
class AppData extends AppData_base{}
class AppView extends AppView_base{}

