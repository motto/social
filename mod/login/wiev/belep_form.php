
<div class="art-vmenublock clearfix">
	<div class="art-vmenublockheader">
		<h3 class="t"><?php LANG::ECH('LOGIN');?></h3>
	</div>
     <div class="art-vmenublockcontent">
	 <form action="<?php echo Link :: kiszed($_SERVER['REQUEST_URI'],'login');?>" method="POST">
		<table  border="0" cellspacing="0" cellpadding="3">
		<tr><td><?php LANG::ECH('USER NAME');?>:</td><td><input type="text" name="username" size="15" maxlength="30" value=""></td></tr>
		<tr><td><?php LANG::ECH('PASSWD');?>:</td><td><input type="password" name="passwd" size="15" maxlength="30" value=""></td></tr>
		</table>
		<input type="hidden" name="belep" value="1"> <!-- ezzel vezérli az  azonosit osztalyt-->
		<input type="submit" value="Login">
		</form>
		<!--<font size="2"><a href="forgotpass.php">elfelejtett jelszó</a></font>-->
		<a href="<?php echo Link :: kiszed($_SERVER['REQUEST_URI'],'login');?>&login=reg"><?php LANG::ECH('REG');?>!</a>
	 
		<!---<ul class="art-vmenu"><li><a href="home.html" class="active">Home</a><ul class="active"><li><a href="home/new-page.html">Subpage 1</a></li><li><a href="home/new-page-2.html">Subpage 2</a></li><li><a href="home/new-page-3.html">Subpage 3</a></li></ul></li></ul>--->
                
     </div>
</div>