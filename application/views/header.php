<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Spec Sheets and IES Photometric files | Neutex Lighting</title>
<meta name="description" content="Neutex Lighting has a secure environment to download Spec Sheets and .IES photometric files for all Neutex branded LED lights.  Set up an account to access Neutex Lighting Spec Sheets and IES Photometric files." />
<link href="/style.css" type="text/css" rel="stylesheet" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<link href="<?php echo base_url(); ?>css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" />
<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">

$(document).ready(function() {

	$("#user_menu").menu();
	$("#user_ul").hover(function() {
	
		$("#user_menu").slideDown();
	
	}, function() {
	
		$("#user_menu").hide();
	
	});

	$(".navwattage").click(function() {
	
		var wattageid = $(this).data('fcid'),
			typeid = $(this).parent().parent().find('.type_click').data('fcid'),
			familyid = $(this).parent().parent().parent().parent().find('.family_click').data('fcid');
			
		$("#postfamily").val(familyid);
		$("#posttype").val(typeid);
		$("#postwattage").val(wattageid);
		
		$("#getItem").submit();
	
	});

	$("#familymenu").menu();
	$("#products_dropdown").mouseover(function() {
	
		$("#familymenu").slideDown();
	
	});
	
	$("#familymenu").mouseleave(function() {
	
		$("#familymenu").hide();
		
	});
	
	$('.jqtip').tooltip({
	
		items: "[data-name],[data-phone],[data-company],[data-title],[data-hear],[data-other]",
		content: function() {
		
			var theReturn = "";
			var element = $(this);
			theReturn += "<b>Name:</b> "+element.data('name')+"<br/>";
			theReturn += "<b>Phone:</b> "+element.data('phone')+"<br/>";
			theReturn += "<b>Company:</b> "+element.data('company')+"<br/>";
			theReturn += "<b>Title:</b> "+element.data('title')+"<br/>";
			theReturn += "<b>Hear:</b> "+element.data('hear')+"<br/>";
			theReturn += "<b>Other:</b> "+element.data('other')+"<br/>";
			
			return theReturn;
		
		}
	
	});

	if ($('.dataTables_filter')) {
	
		$("#show_home").click(function() {
		
			$(".dataTables_filter input").val('');
			$("#searchinput").val('');
			var oTable = $(".dataTables-files").DataTable();
			oTable.search('').draw();
			$(".tabletoggle").hide();
			$("#getItem").slideDown();
			$(".title").first().show();
			$("#show_home").hide();
			$("#product_list").show();
		
		});
	
		$("#search").show();
		$(document).keypress(function(e) {
		
			if (e.which == 13) {
		
				$(".dataTables_filter input").val($('#searchinput').val());
				var oTable = $(".dataTables-files-home").DataTable();
				
				oTable.search($('#searchinput').val()).draw();
				
				if ($('#searchinput').val().length > 0) {
				
					$("#getItem").hide();
					$(".title").first().hide();
					$(".tabletoggle").show();
					$("#show_home").show();
					$("#product_list").hide();
					
				} else {
				
					$("#getItem").show();
					$(".title").first().show();
					$(".tabletoggle").hide();
					$("#show_home").hide();
					$("#product_list").show();
					
				}
			
			}
		
		});
		
		$('#searchsubmit').click(function() {

			$(".dataTables_filter input").val($('#searchinput').val());
			var oTable = $(".dataTables-files").DataTable();
				
			oTable.search($('#searchinput').val()).draw();
				
			if ($('#searchinput').val().length > 0) {
				
				$("#getItem").hide();
				$(".title").first().hide();
				$(".tabletoggle").show();
				$("#show_home").show();
				$("#product_list").hide();
					
			} else {
				
				$("#getItem").show();
				$(".title").first().show();
				$(".tabletoggle").hide();
				$("#show_home").hide();
				$("#product_list").show();
					
			}
			
		});
		
		$("body").on('keyup', '.dataTables_filter input', function() {
		
			$("#searchinput").val($(this).val());
			
			if ($(this).val().length > 0) {
			
				$("#getItem").hide();
				$(".title").first().hide();
				$(".tabletoggle").show();
				$("#show_home").show();
				$("#product_list").hide();
				
			} else {
			
				$("#getItem").show();
				$(".title").first().show();
				$(".tabletoggle").hide();
				$("#show_home").hide();
				$("#product_list").show();
				
			}
			
		});
	
	}

	$('.dataTables').dataTable({
	
		"ordering": true,
		"pageLength": 50,
		"pagingType": "simple_numbers",
		"lengthChange": false,
		"info": false,
		"bFilter": true
	
	});
	
	$('.dataTables-files').dataTable({
	
		"ordering": true,
		"pageLength": 100,
		"pagingType": "simple_numbers",
		"lengthChange": false,
		"info": false,
		"bFilter": true
	
	});
	
	$('.dataTables-files-home').dataTable({
	
		"ordering": true,
		"pageLength": 500,
		"lengthChange": false,
		"info": false,
		"bFilter": true,
		"columnDefs": [
			{ "type": "num", "targets": 4 }
		]
	
	});
	
	$('.dataTables-logs').dataTable({
	
		"ordering": false,
		"pageLength": 15,
		"pagingType": "simple_numbers",
		"lengthChange": false,
		"info": false,
		"bFilter": true,
		"aaSorting": [],
		"order": [],
		"bSort": false
	
	});
	
	$('.dataTables-downloads').dataTable({
	
		"ordering": false,
		"pageLength": 5,
		"paging": false,
		"lengthChange": false,
		"info": false,
		"bFilter": false,
		"aaSorting": [],
		"order": [],
		"bSort": false
	
	});

});

</script>
</head>

<body>

<div id="topbar">

	<div class="container">

		<div class="text">Call Us Today 1.281.227.2208 | info@neutexworld.com</div>
		<div class="right_text">
		
		<?php
			
		if ($user['admin'] == 1) {
	
			echo anchor('admin/file', 'Add/Edit Files', 'title="Manage Files"');
			echo anchor('admin/users', 'Add/Edit Users', 'title="Manage Users"');
			echo anchor('admin/category', 'Add/Edit Categories', 'title="Manage Categories"');
			echo anchor('admin/logs', 'View Logs', 'title="View Logs"');
	
		}
		
		if ($user) {
		
			$name = explode(' ', $user['name']);
			echo"<ul id='user_ul'><li><a href='/login/change_password' id='user_dropdown'>Welcome, ".$name[0]."!</a>";
			echo"
			
				<ul id='user_menu'>
					<li><a href='/login/change_password'>Manage Account</a></li>
					<li><a href='/login/logout'>Log Out</a></li>
				</ul></li></ul>
			";
		
		}
		
		?>
		
		</div>
		<div class="clear"></div>
		
	</div>

</div>

<div id="header">

	<div class="container">
	
		<div id="logo"><a href="/home/newhome" style="display:block;width:100%;height:89px;text-decoration:none;"></a></div>
		
		<div id="navigation">
		
			<a href="/home/newhome">Home</a>
			<?php if ($user) { ?><a href="/home/newhome" id="products_dropdown">Products</a><?php } ?>
			<a href="https://www.neutexled.com/contact" target="_blank">Support</a>
			<div style="clear:both;"></div>
		
		</div>
	
		<div id="search" style="display:none;">
	
		<?php
				echo form_input(array('name' => 'search', 'placeholder' => 'Quick search..', 'id' => 'searchinput', 'value' => $search, 'style' => 'width:60%;'))." ";
	
				echo form_submit(array('name' => 'submit', 'id' => 'searchsubmit', 'value' => 'Search'));
				
		?>
	
		</div>
		
		<div class="clear: both;"></div>
		
	</div>

</div>