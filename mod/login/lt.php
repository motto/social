<?php
class ModLT{
  public static $username=array(
      'hu'=>'Usernév',
      'en'=>'Username'
); public static $reg=array(
    'hu'=>'Regisztrálás',
    'en'=>'Registring'
); public static $cancel=array(
    'hu'=>'Mégsem',
    'en'=>'Cancel'
);public static $logout=array(
    'hu'=>'Kilépés',
    'en'=>'Logout'
);public static $login=array(
    'hu'=>'Belépés',
    'en'=>'Login'
);public static $usernamelong_err=array(
     'hu'=>'A felhasználó névnek min 5 max 20 karakternek kell lenni!',
     'en'=>'The username must be min 5 max 20 char long'
);public static $spec_char_error=array(
    'hu'=>'A felhasználó név nem tartalmazhat "különleges karaktereket" ! Csak kis és nagybetűket (ékeztest is), szóközöket és számokat',
    'en'=>'The username is not special char'
);  public static $login_data_nomatch=array(
    'hu'=>'A felhasználónév vagy a jelszó nem jó!',
    'en'=>'Bad username or passwd!'
);  public static $oldpasswd_err=array(
    'hu'=>'A régi jelszó nem jó!',
    'en'=>'The old password no match!'
);  public static $newpasswd_nomatch=array(
    'hu'=>'A két új jelszó nem egyezik!',
    'en'=>'The new passwords no match!'
); public static $username_have=array(
    'hu'=>'Már van ilyen felhasználónév',
    'en'=>'This username is registered!'
); public static $joghiba=array(
    'hu'=>'Jogosultság hiba!',
    'en'=>'Restricted area!'
);
public static $dberror=array(
     'hu'=>'Adatbázis hiba',
     'en'=>'DB error'
 );public static $passwd=array(
    'hu'=>'Jelszó',
    'en'=>'Password'
 );public static $passwd_re=array(
    'hu'=>'Jelszó újra',
    'en'=>'Password again'
);public static $i=array(
    'hu'=>'',
    'en'=>''
);
}