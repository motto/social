<?php
defined( '_MOTTO' ) or die( 'Restricted access' );
class Jog
{
    public static function fromGOB(){
        $userid=$_SESSION['userid'];
        if(empty($userid)or $userid==0){$userid='noname';}
                if(!empty($_SESSION['userid']))
                {
                    $userjog[]='user';
                }

                //szerzo jog beállítása-----------
                if(is_array(GOB::$get_userjog['szerzo'])&& in_array($userid,GOB::$get_userjog['szerzo']))
                {
                    $userjog[]='szerzo';
                }
                //moderator jog beállítása-----------
                if(is_array(GOB::$get_userjog['moderator'])&& in_array($userid,GOB::$get_userjog['moderator']))
                {
                    $userjog[]='mod';

                }
                //adminjog beállítása------------
               if(is_array(GOB::$get_userjog['admin'])&& in_array($userid,GOB::$get_userjog['admin']))
               {
                   $userjog[]='admin';
               }
            return $userjog;

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

