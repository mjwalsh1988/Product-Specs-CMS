<div class="container">


	<div class="title">
	
		<h2 style="padding-right:150px;">Select a File to View</h2>
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

		echo"<br/><span style='color:red;'>";
		echo $error;
		echo"</span><br/>";

	}

	?>

<?php echo form_open('home'); ?>

<table width="100%" cellspacing="5" cellpadding="5" border="0">
<tr><td width="50%" valign="top">

<table width="100%" cellspacing="5" cellpadding="5" border="0">

<tr><td align="left">

	Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.<br/><br/>
	<label for='family'>Select a Product Family</label><br/>
	<?php echo form_dropdown('family', $families, '', 'style="width:100%;"'); ?>
	
</td>
</tr><tr><td align="left">

	<label for='type'>Select a Product Type</label><br/>
	<?php echo form_dropdown('type', '', '', 'style="width:100%;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='wattage'>Select a Product Wattage</label><br/>
	<?php echo form_dropdown('wattage', '', '', 'style="width:100%;"'); ?>
	
</td></tr><tr><td align="left" colspan="2">

	<?php echo form_submit('submit', 'View File!', 'style="width:100%;padding-left:0px;padding-right:0px;"'); ?>

</td></tr></table>
</form>

</td><td valign="top">

<p style="background:#767676;font-size:10px;color:white;text-align:center;margin:0;">Use the below product gallery to locate the light of your choice</p>
<div style="background:#f5f3f4;padding:5px 0;text-align:center;overflow-y:scroll;border-bottom:6px solid #767676;height:320px;">
<div style="width:95%;margin:0px auto;">

	<?php
	
	foreach ($familiesfull AS $family) {
	
		echo"
		
			<div style='float:left;width:110px;height:110px;text-align:center;margin:7px 5px;cursor:pointer;' data-fcid='".$family->fcid."' class='family_icon'>
			
				<img src='".($family->image ? "/uploads/".$family->image : "/images/comingsoon.png")."' title='".$family->label."' style='border:1px solid #cfcdce;margin-bottom:2px;width:110px;height:92px;' />
				<span style='font-size:11px;line-height:12px;'>".$family->label."</span>
			
			</div>
		
		";
	
	}
	
	?>
</div>
</div>

</td></tr>
</table>
<br/><br/>
	<div class="title">
	
		<h2 style="padding-right:150px;">Quick View All Products</h2>
		<div class="title-sep">
			<div class="title-sep-lines">
			</div>
		</div>
	
	</div>
<br/>
<table class="dataTables-files cell-border">

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

	echo"
	
		<tr>
		
			<td>".anchor('home/file/'.$file['fid'], $file['name'])."</td>
			<td>".(isset($file['sku']) ? $file['sku'] : "")."</td>
			<td>".(isset($file['family']) ? ucfirst($file['family']) : "")."</td>
			<td>".(isset($file['type']) ? ucfirst($file['type']) : "")."</td>
			<td>".(isset($file['wattage']) ? ucfirst($file['wattage']) : "")."</td>
		
		</tr>
	
	";

}

?>

</tbody>

</table>

</div>

<div id="results" style="display:none" title="Search Results">

<?php if (isset($multiple_files)) { ?>
	
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


<script type="text/javascript">

$(document).ready(function() {

	<?php if (isset($multiple_files)) { ?>
	
	$("#results").dialog({
	
		width: 800,
		height: 500
	
	});
	
	<?php } ?>

	$("select[name=family]").change(function() {
	
		var family = $(this).val();

		$.get( "/ajax/grabTypes/"+family, function (data) {
		
			$("select[name=type]").html(data).effect("highlight", {}, 750);
			$("select[name=wattage]").html("");
		
		});
	
	});
	
	$("select[name=type]").change(function() {
	
		var type = $(this).val();

		$.get( "/ajax/grabWattages/"+type, function (data) {
		
			$("select[name=wattage]").html(data).effect("highlight", {}, 750);
		
		});
	
	});
	
	$(".family_icon").click(function() {
	
		var family = $(this).data();
		$("select[name=family]").val(family.fcid);
		
		$.get( "/ajax/grabTypes/"+family.fcid, function (data) {
		
			$("select[name=type]").html(data).effect("highlight", {}, 750);
			$("select[name=wattage]").html("");
		
		});
	
	});

});

</script>