<div class="container">
<div class="title">

	<h2 style="padding-right:120px;">View Website Logs</h1>
	<div class="title-sep">
		<div class="title-sep-lines">
		</div>
	</div>

</div>

<?php

echo form_open('admin/logs');

echo"Select a User: <select name='user'><option>All Users</option>";

foreach ($users AS $user) {

	echo"<option value='".$user->uid."'".($selected_user == $user->uid ? " selected" : "").">".$user->username."</option>";

}

echo"</select> ";

echo form_submit('mysubmit', 'Search Logs');

echo form_close();

?>

	<p style="text-align:right;"><?php echo anchor('admin/deletelogs', 'Clear All Logs'); ?></p>

	<table class="dataTables-logs cell-border">
	<thead>
		<tr>
			<th>User</th>
			<th>Action</th>
			<th>Timestamp</th>
		</tr>
	</thead>
	<tbody>
	<?php

		if (count($logs[0]) > 1) {
		
			foreach ($logs AS $log) {
	
				echo"<tr>";
				echo"<td>".$log['username']."</td>";
				echo"<td>".$log['action']."</td>";
				echo"<td>".$log['timestamp']."</td>";
				echo"</tr>";
		
			}
			
		}

	?>

	</tbody>
	</table><br/>
	
</div>