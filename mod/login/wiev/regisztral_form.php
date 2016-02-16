

<h1><?php LANG::ECH('REG');?></h1>

<form action="<?php echo Link::kiszed($_SERVER['REQUEST_URI'],'login');?>&login=ment" method="POST">
<table align="left" border="0" cellspacing="0" cellpadding="3">
<tr><td><?php LANG::ECH('USER NAME');?>:</td><td><input type="text" name="username" maxlength="30" value="<?php echo ELL::$adatok['username']; ?>"></td><td></td></tr>
<tr><td>Email:</td><td><input type="text" name="email" maxlength="50" value="<?php echo ELL::$adatok['email']; ?>"></td><td></td></tr>
<tr><td><?php LANG::ECH('PASSWD');?>:</td><td><input type="password" name="password" maxlength="30" value=""></td><td></td></tr>
<tr><td><?php LANG::ECH('PASSWD');?> <?php LANG::ECH('REPEAT');?>:</td><td><input type="password" name="password2" maxlength="30" value=""></td><td></td></tr>

<tr><td colspan="2" align="right">
<input type="submit" value="<?php LANG::ECH('REG');?>"></td></tr>
<!--<tr><td colspan="2" align="left"><a href="main.php">Back to Main</a></td></tr>-->
</table>
</form>