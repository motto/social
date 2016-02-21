<?php
defined( '_MOTTO' ) or die( 'Restricted access' );
class Jog
{
    public static function fromGOB()
    {
        $userjog=array('noname');
        if(isset($_SESSION['userid']))
        {
        $userid=$_SESSION['userid'];
                if($userid>0)
                {
                    $userjog[]='user';
                }

                //szerzo jog beállítása-----------
                if(in_array($userid,GOB::$adminok))
                {
                    $userjog[]='admin';
                }

            return $userjog;
        }
    }
            public static function fromDB(){

            }
}

/**
 * Class Azonosit
 * session-be írja az useridet vagy nullát
 */
class Azonosit
{
    function __construct()
    {
    $this->alap();
    }

    function alap()
    {
        if(!isset($_SESSION['userid'])) {$_SESSION['userid']=0;}
        if(isset($_POST['belep'])){$this->belep();}
        if(isset($_POST['kilep'])){$this->kilep();}
    }

    function kilep()
    {
    if(isset($_COOKIE['cook_sess_id'])){
             setcookie("cook_sess_id", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
          }
          unset($_SESSION['userid']);
    }
    function belep()
    {

    $jelszo = md5($_POST['passwd']);
    //$username =TEXT::post_slashel($_POST['username']); //db_fgv.php
    $username =$_POST['username'];
     $sql = "SELECT id,password FROM userek WHERE username = '".$username."'";
     $useradat=DB::assoc_sor($sql);
      if($jelszo == $useradat['password']){$_SESSION['userid']= $useradat['id']; }
      else{//GOB::$hiba['ident'][]= LANG::RET('ERR_PASSWD');// LANG::ECH('ERR_PASSWD');
      }
     // return $userid;
    }
	   	   
}

