<h1><?php LANG::ECH('USER DATA CHANGE'); ?></h1>

<form action="<?php echo Link::kiszed($_SERVER['REQUEST_URI'],'login'); ?>&login=vment" method="POST">
<table align="left" border="0" cellspacing="0" cellpadding="3">
<tr><td> <?php LANG::ECH('USER NAME'); ?> :</td><td><input type="text" name="username" style="width:250px;" maxlength="100" value="<?php echo ELL::$adatok['username']; ?>"></td><td></td></tr>
<tr><td><?php LANG::ECH('EMAIL');?>:</td><td><input type="text" name="email" style="width:250px;" maxlength="100" value="<?php echo ELL::$adatok['email'];?>"></td><td></td></tr>
<tr><td><?php LANG::ECH('PASSWD');?>:</td><td><input type="password" name="oldpassword" style="width:250px;" maxlength="100" value=""></td><td></td></tr>
<tr><td><?php LANG::ECH('NEW PASSWD');?>:</td><td><input type="password" name="password" style="width:250px;" maxlength="100" value=""></td><td></td></tr>
<tr><td><?php LANG::ECH('NEW PASSWD');?> <?php LANG::ECH('REPEAT');?>:</td><td><input type="password" name="password2" style="width:250px;" maxlength="100" value=""></td><td></td></tr>

<tr><td colspan="2" align="right">
<input type="hidden" name="task2" value="valtoztat">
<input type="hidden" name="valtoztat" value="1">
<input type="submit" value="<?php LANG::ECH('SAVE');?>"></td></tr>
<tr><td colspan="2" align="left"></td></tr>
</table>
</form>