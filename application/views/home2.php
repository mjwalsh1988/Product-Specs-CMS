<div class="container" style="max-width: 1060;">

	<div style="height: 35px;"></div>
	<div class="title">
	
		<h2 style="padding-right:110px;text-transform:uppercase;font-weight:bold;color:#888888;font-family:Montserrat;">Product Search</h2>
		
		<div class="title-sep">
			<div class="title-sep-lines">
			</div>
		</div>
	
	</div>
	
	<?php
	
	if (validation_errors()) {

		echo"<br/><span style='color:red;'>";
		echo validation_errors();
		echo"</span><br/>";

	}
	
	if ($error) {

		echo"<script type='text/javascript'>alert(\"$error\");</script>";

	}

	?>
<div id="show_home" style="margin: 15px 0 0 0;display: none;text-align:center;">
<input type="button" class="button" value="Show Product Images" />
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr><td width="50%" valign="top">

<div style="padding:5px 0;text-align:center;">
<div id="back_button" style="margin: 10px 15px;display: none;cursor: pointer;text-align:center;">
<input type="button" value="<< Go Back" class="button" />
</div>
<div id="product_list">

	<?php
	
	foreach ($familiesfull AS $family) {
	
		echo"
		
			<div data-fcid='".$family->fcid."' class='product_list_item family_icon family_click'>
			
				<img src='".($family->image ? "/uploads/".$family->image : "/images/comingsoon.png")."' title='".$family->label."' style='border:1px solid #ededed;margin-bottom:2px;width:250px;height:250px;' />
				<span style='font-size:13px;line-height:14px;font-weight: bold;'>".$family->label."</span>
			
			</div>
		
		";
	
	}
	
	?>
	<div style="clear:both;"></div>
</div>
</div>

</td></tr>
</table>
<br/><br/>
<div class="tabletoggle">
	<div class="title">
	
		<h2 style="padding-right:150px;font-family:Montserrat;font-weight:bold;">Quick View All Products</h2>
		<div class="title-sep">
			<div class="title-sep-lines">
			</div>
		</div>
	
	</div>
<br/>
<table class="dataTables-files-home cell-border">

<thead>
	<tr>
		<th>Product Name</th>
		<th>Product SKU</th>
		<th>Product Family</th>
		<th>Product Type</th>
		<th>Product Wattage</th>
	</tr>
</thead>

<tbody>

<?php

foreach ($files AS $file) {

	$wattage = explode("W", $file['wattage']);

	echo"
	
		<tr>
		
			<td>".anchor('home/file/'.$file['fid'], $file['name'])."</td>
			<td>".(isset($file['sku']) ? $file['sku'] : "")."</td>
			<td>".(isset($file['family']) ? ucfirst($file['family']) : "")."</td>
			<td>".(isset($file['type']) ? ucfirst($file['type']) : "")."</td>
			<td>".$wattage[0]."</td>
		
		</tr>
	
	";

}

?>

</tbody>

</table>

</div>

<div id="results" style="display:none" title="Multiple products found!">

<?php if (isset($multiple_files)) { ?>

We found multiple products matching your selections, please specify which one you are searching for by clicking on it below..<br/><br/>
	
<table class="dataTables-files cell-border">

<thead>
	<tr>
		<th>Product Name</th>
	</tr>
</thead>

<tbody>

<?php

foreach ($multiple_files AS $dfile) {

	echo"
	
		<tr>
		
			<td>".anchor('home/file/'.$dfile['fid'], $dfile['name'])."</td>
		
		</tr>
	
	";

}

?>

</tbody>

</table>

<?php } ?>

</div>

</div>


<script type="text/javascript">

$(document).ready(function() {

	<?php if (isset($multiple_files)) { ?>
	
	$("#results").dialog({
	
		width: 800,
		height: 500,
		modal: true
	
	});
	
	<?php } ?>
	
	$("#back_button").click(function() {
	
		$("#postfamily").val('');
		$("#posttype").val('');
		$("#postwattage").val('');
		
		window.location="<?php echo site_url('home/newhome'); ?>";
	
	});
	
	$(".family_click").click(function() {
	
		var family = $(this).data('fcid');
		$("#postfamily").val(family);
		
		$("#back_button").show();
		
		$.get( "/ajax/grabTypes/"+family+"/1", function (data) {
		
			$("#product_list").hide();
			$("#product_list").html('');
			setTimeout(function() { $("#product_list").html(data).show().effect("highlight", {}, 750); }, 1000);
		
		});
	
	});
	
	$(".type_click").click(function() {
	
		var type = $(this).data('fcid');
		$("#posttype").val(type);
	
		$.get( "/ajax/grabWattages/"+type+"/1", function (data) {
		
			$("#product_list").hide();
			$("#product_list").html('');
			setTimeout(function() { $("#product_list").html(data).show().effect("highlight", {}, 750); }, 1000);
			
		});
	
	});
	
	$("#product_list").on('click', '.type_icon', function() {
	
		var type = $(this).data('fcid');
		$("#posttype").val(type);
	
		$.get( "/ajax/grabWattages/"+type+"/1", function (data) {
		
			$("#product_list").hide();
			$("#product_list").html('');
			setTimeout(function() { $("#product_list").html(data).show().effect("highlight", {}, 750); }, 1000);
			
		});
	
	});
	
	$("#product_list").on('click', '.wattage_icon', function() {
	
		var wattage = $(this).data('fcid');
		$("#postwattage").val(wattage);
		$("#getItem").submit();
	
	});

});

</script>