<div class="container">

<div class="title">

	<h2 style="padding-right:140px;">Register an Account</h1>
	<div class="title-sep">
		<div class="title-sep-lines">
		</div>
	</div>

</div>

<?php 

echo form_open('login/register');

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

	<label for='username'>Email Address</label><br/>
	<?php echo form_input('username', $username, 'style="width:100%;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='confirmusername'>Confirm Email Address</label><br/>
	<?php echo form_input('confirmusername', $confirmusername, 'style="width:100%;"'); ?>

</td></tr><tr><td align="left">

	<label for='password'>Password</label><br/>
	<?php echo form_password('password', $password, 'style="width:100%;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='confirmpassword'>Confirm Password</label><br/>
	<?php echo form_password('confirmpassword', $confirmpassword, 'style="width:100%;"'); ?>

</td></tr><tr><td align="left">

	<label for='name'>Full Name</label><br/>
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

</td></tr><tr><td align="left">

	<label for='hear'>How did you hear about us?</label><br/>
	<?php echo form_dropdown('hear', array('Tradeshow','Referral','Internet Search','Social Media','Other'), '', 'style="width:100%;"'); ?>

</td></tr><tr><td align="left">

	<label for='other'>If other, let us know how!</label><br/>
	<?php echo form_input('other', $other, 'style="width:100%;"'); ?>

</td></tr><tr><td align='center'>

	<?php echo form_submit('submit', 'Submit Registration!'); ?>

</td></tr></table>

</form>

</div>