<div style="float:left;padding:5px;"> <?php LANG::ECH('HI'); echo ' '.GOB::get_user('username'); ?> ! </div>
<div >
	<form action="<?php echo Link :: kiszed($_SERVER['REQUEST_URI'],'login');?>"  method="POST">
	<input type="hidden" name="kilep" value="1"> <!-- ezzel vezérli az  azonosit osztalyt-->
	<input type="submit" value="<?php LANG::ECH('LOGOUT');?>">
	</form>
</div>

