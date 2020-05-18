<div class="container">

<div class="title">

	<h2 style="padding-right:80px;">Manage Account</h1>
	<div class="title-sep">
		<div class="title-sep-lines">
		</div>
	</div>

</div>

<?php 

echo form_open('login/change_password');

if (validation_errors()) {

	echo"<br/><span style='color:red;'>";
	echo validation_errors();
	echo"</span><br/>";

} elseif (strlen($message)) {

	echo"<br/>";
	echo $message;
	echo"<br/>";

}

?>

<table width='50%' border='0' cellspacing='5' cellpadding='5'>

<tr><td align="left">

	<label for='username'>New Username/Email</label><br/>
	<?php echo form_input('username', $username, 'style="width:100%;"'); ?>

</td></tr><tr><td align="left">

	<label for='name'>Name</label><br/>
	<?php echo form_input('name', $name, 'style="width:100%;"'); ?>

</td></tr><tr><td align="left">

	<label for='phone'>Phone Number</label><br/>
	<?php echo form_input('phone', $phone, 'style="width:100%;"'); ?>

</td></tr><tr><td align="left">

	<label for='company'>Company</label><br/>
	<?php echo form_input('company', $company, 'style="width:100%;"'); ?>

</td></tr><tr><td align="left">

	<label for='title'>Title</label><br/>
	<?php echo form_input('title', $title, 'style="width:100%;"'); ?>

</td></tr><tr><td align="center"><small>Only fill in the password fields if you want to change your password.</small></td></tr><tr><td align="left">

	<label for='currentpassword'>Current Password</label><br/>
	<?php echo form_password('currentpassword', $currentpassword, 'style="width:100%;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='newpassword'>New Password</label><br/>
	<?php echo form_password('newpassword', $newpassword, 'style="width:100%;"'); ?>

</td></tr><tr><td align="left">

	<label for='confirmnewpassword'>Confirm New Password</label><br/>
	<?php echo form_password('confirmnewpassword', $confirmnewpassword, 'style="width:100%;"'); ?>

</td></tr><tr><td align='center'>

	<?php echo form_submit('submit', 'Update Profile!'); ?>

</td></tr></table>

</form>

</div>