<div class="container">


	<div class="title">
	
		<?php
			
			if ($fid > 0) {
				
				echo"<h2>Editing File</h2>";
					
			} else {
				
				echo"<h2 style='padding-right: 110px;'>Adding a New File</h2>";
					
			}
			
		?>
		<div class="title-sep">
			<div class="title-sep-lines">
			</div>
		</div>
	
	</div>

<?php 

if ($fid > 0) { echo"<h2><center>[ ".anchor('admin/file', 'Add a New File')." ]</center></h2>"; }

echo form_open_multipart('admin/file/'.$fid);

if (validation_errors()) {

	echo"<br/><span style='color:red;'>";
	echo validation_errors();
	echo"</span><br/>";

}

if (strlen($upload_error)) {

	echo"<br/><span style='color:red'>";
	echo $upload_error;
	echo"</span><br/>";
	
}

?>
<table width="100%" cellspacing="5" cellpadding="5" border="0">
<tr><td align="left" valign="top" width="50%">

<table width="100%" cellspacing="5" cellpadding="5" border="0">

<tr><td align="left">

	<label for='name'>Product Name</label><br/>
	<?php echo form_input('name', $name, 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='sku'>Product SKU</label><br/>
	<?php echo form_input('sku', $sku, 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='family'>Product Family</label><br/>
	<?php echo form_multiselect('family[]', $families, $family, 'style="width:375px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='type'>Product Type</label><br/>
	<?php echo form_multiselect('type[]', $types, $type, 'style="width:375px;" id="type_dropdown"'); ?>
	
</td></tr><tr><td align="left">

	<label for='wattage'>Product Wattage</label><br/>
	<?php echo form_multiselect('wattage[]', $wattages, $wattage, 'style="width:375px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='image'>Product Image</label><br/>
	<?php echo form_upload('image', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left" colspan="2">

	<label for='description'>Product Description</label><br/>
	<?php echo form_textarea('description', $description, 'style="width:350px;"'); ?>
	
</td></tr></table>

</td><td align="left" valign="top">

<table width="100%" cellspacing="10" cellpadding="3" border="0">

<tr><td align="left">

	<?php
	
	if ($fid > 0) {
	
		echo"<span style='color:red;'><b>Please only select files and product image if you plan on replacing the existing file or image that is already there.</b></span><br/>";
		echo"Click ".anchor('home/file/'.$fid, 'here', 'style="text-decoration:underline;" target="_blank"')." to view the current file & its downloads.<br/><br/>";
	
	}
	
	?>
	<label for='file_family'>Family Sheet</label><br/>
	<?php echo form_upload('file_family', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_info'>Info Sheet</label><br/>
	<?php echo form_upload('file_info', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_spec'>Spec Sheet</label><br/>
	<?php echo form_upload('file_spec', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_ies'>IES File</label><br/>
	<?php echo form_upload('file_ies', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_iesextra1'>Printed IES Warm White</label><br/>
	<?php echo form_upload('file_iesextra1', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_iesextra2'>Engineer IES Warm White</label><br/>
	<?php echo form_upload('file_iesextra2', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_iesextra3'>Printed IES Neutral White</label><br/>
	<?php echo form_upload('file_iesextra3', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_iesextra4'>Engineer IES Neutral White</label><br/>
	<?php echo form_upload('file_iesextra4', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_iesextra5'>Printed IES Cool White</label><br/>
	<?php echo form_upload('file_iesextra5', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_iesextra6'>Engineer IES Cool White</label><br/>
	<?php echo form_upload('file_iesextra6', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_iesextra7'>Printed IES Bright White</label><br/>
	<?php echo form_upload('file_iesextra7', "", 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='file_iesextra8'>Engineer IES Bright White</label><br/>
	<?php echo form_upload('file_iesextra8', "", 'style="width:350px;"'); ?>
	
</td></tr></table>

</td></tr><tr><td align="center" colspan="2">

	<?php echo form_submit('submit', 'Submit File!', 'style="width:100%;"'); ?>

</td></tr></table>

</form><br/><br/>

<table class="dataTables-files cell-border">

<thead>
	<tr>
		<th>File Name</th>
		<th>File SKU</th>
		<th>File Description (shortened)</th>
		<th>File Actions</th>
	</tr>
</thead>

<tbody>

<?php

foreach ($files AS $file) {

	echo"
	
		<tr>
		
			<td>".$file['name']."</td>
			<td>".$file['sku']."</td>
			<td>".(isset($file['description']) ? substr($file['description'], 0, 55) : "").(strlen($file['description']) > 55 ? "[...]" : "")."</td>
			<td align='center'>".anchor('admin/file/'.$file['fid'], 'Edit File', 'title="Edit FIle"')." - ".anchor('admin/deletefile/'.$file['fid'], 'Delete File', 'title="Delete File"')."</td>
		
		</tr>
	
	";

}

?>

</tbody>

</table>

</div>

<script type="text/javascript">

$(document).ready(function() {

	$("select[name=family]").change(function() {
	
		var family = $(this).val();

		$.get( "/ajax/grabTypes/"+family, function (data) {
		
			$("select[name=type]").html(data);
		
		});
	
	});

});

</script>