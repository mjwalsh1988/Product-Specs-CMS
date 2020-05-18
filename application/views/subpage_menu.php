<div id="loginarea" class="subpage">

	<div class="container">
	
		<h2>
		
			<?php 
			
			echo"Welcome <b>".$user['username']."</b>! - ".anchor('login/logout', 'Logout')." - ".anchor('home', 'View Files'); 
			
			if ($user['admin'] == 1) {
	
				echo" - ".anchor('admin/file', 'Add/Edit Files', 'title="Manage Files"')." - ";
				echo anchor('admin/users', 'Add/Edit Users', 'title="Manage Users"')." - ";
				echo anchor('admin/category', 'Add/Edit Categories', 'title="Manage Categories"')." - ";
				echo anchor('admin/logs', 'View Logs', 'title="View Logs"');
	
			}
			
			?>
			
		</h2>
		
	</div>

</div>