<div class="container">

<div class="title">

	<h2 style="padding-right:170px;">Add / Edit Website Users</h1>
	<div class="title-sep">
		<div class="title-sep-lines">
		</div>
	</div>

</div>

<?php 

echo form_open('admin/users/'.$uid);

if (validation_errors()) {

	echo"<br/><span style='color:red;'>";
	echo validation_errors();
	echo"</span><br/>";

}

?>

<table width='50%' border='0' cellspacing='5' cellpadding='5'>

<tr><td align="left">

	<label for='username'>Email Address</label><br/>
	<?php echo form_input('username', $username, 'style="width:95%;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='confirmusername'>Confirm Email Address</label><br/>
	<?php echo form_input('confirmusername', $confirmusername, 'style="width:95%;"'); ?>

</td></tr><tr><td align="left">

	<label for='password'>Password</label><br/>
	<?php echo form_password('password', $password, 'style="width:95%;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='confirmpassword'>Confirm Password</label><br/>
	<?php echo form_password('confirmpassword', $confirmpassword, 'style="width:95%;"'); ?>

</td></tr><tr><td align="left">

	<label for='name'>Full Name</label><br/>
	<?php echo form_input('name', $name, 'style="width:95%;"'); ?>

</td></tr><tr><td align="left">

	<label for='phone'>Phone</label><br/>
	<?php echo form_input('phone', $phone, 'style="width:95%;"'); ?>

</td></tr><tr><td align="left">

	<label for='company'>Company</label><br/>
	<?php echo form_input('company', $company, 'style="width:95%;"'); ?>

</td></tr><tr><td align="left">

	<label for='title'>Title</label><br/>
	<?php echo form_input('title', $title, 'style="width:95%;"'); ?>

</td></tr><tr><td align='center'>

	<?php echo form_submit('submit', 'Submit User!', 'style="width:100%;"'); ?>

</td></tr></table>

</form>

<table class="dataTables cell-border">

<thead>
	<tr>
		<th>Full Name</th>
		<th>Company</th>
		<th>Username</th>
		<th>Approved</th>
		<th>Admin</th>
		<th>User Actions</th>
		<th>Logs</th>
	</tr>
</thead>

<tbody>

<?php

foreach ($users AS $user) {

	$tip = "data-name='".$user->name."'";
	$tip .= " data-phone='".$user->phone."'";
	$tip .= " data-company='".$user->company."'";
	$tip .= " data-title='".$user->title."'";
	$tip .= " data-hear='".$user->hear."'";
	$tip .= " data-other='".$user->other."'";

	echo"
	
		<tr".($user->approved == 1 ? "" : " style='background:#fff9ea;'").($user->admin == 1 ? " style='background:#deedc2;'" : "")." class='jqtip' ".$tip.">
		
			<td>".$user->name."</td>
			<td>".$user->company."</td>
			<td>".$user->username."</td>
			<td>".($user->approved == 1 ? "Yes!" : "<span style='color:red;'>No</span>")."</td>
			<td>".($user->admin == 1 ? "Yes!" : "No")."</td>
			<td align='center'>
				".($user->approved == 1 ? "" : anchor('admin/approveuser/'.$user->uid, 'Approve User')." - ") . 
				($user->admin == 1 ? anchor('admin/removeadmin/'.$user->uid, 'Remove Admin')." - " : anchor('admin/giveadmin/'.$user->uid, 'Give Admin')." - ") . 
				anchor('admin/users/'.$user->uid, 'Edit User')." - ".
				anchor('admin/deleteuser/'.$user->uid, 'Delete User')."
			</td>
			<td align='center'>
	
	";
	
	echo form_open('admin/logs');

	echo"<input type='hidden' name='user' value='".$user->uid."' />";

	echo form_submit('mysubmit', 'View User Logs');

	echo form_close();
	
	echo"
	
			</td>
		
		</tr>
	
	";

}

?>

</tbody>

</table>

</div>