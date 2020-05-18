<div class="container">


	<div class="title">
	
		<?php
			
			if ($fcid > 0) {
				
				echo"<h2 style='padding-right: 125px;'>Editing Categories</h2>";
					
			} else {
				
				echo"<h2 style='padding-right: 150px;'>Adding a New Category</h2>";
					
			}
			
		?>
		<div class="title-sep">
			<div class="title-sep-lines">
			</div>
		</div>
	
	</div>

<?php 

if ($fcid > 0) { echo"<h2><center>[ ".anchor('admin/category', 'Add a New Category')." ]</center></h2>"; }

echo form_open_multipart('admin/category/'.$fcid);

if (validation_errors()) {

	echo"<br/><span style='color:red;'>";
	echo validation_errors();
	echo"</span><br/>";

}

if ($upload_error) {

	echo"<br/><span style='color:red;'>";
	echo $upload_error;
	echo"</span><br/>";

}

?>

<table width="100%" cellspacing="5" cellpadding="5" border="0">
<tr><td valign="top">

<table width="100%" cellspacing="5" cellpadding="5" border="0">

<tr><td align="left">

	<label for='label'>Category Label</label><br/>
	<?php echo form_input('label', $label, 'style="width:350px;"'); ?>
	
</td></tr><tr><td align="left">

	<label for='type'>Category Type</label><br/>
	<?php echo form_dropdown('type', array('family' => 'Product Family', 'type' => 'Product Type', 'wattage' => 'Product Wattage'), $type, 'style="width:375px;"'); ?>
	
</td></tr><tr style="<?php if ($fcid > 0) {} else { echo"display:none;"; } ?>" class="parents_dropdown"><td align="left">

	<label for='parents'>Category Parents</label><br/>
	<?php echo form_multiselect('parent[]', "", "", 'style="width:375px;height:200px;" id="parent_dropdown"'); ?>
	
</td></tr><tr class="family_upload"><td align="left">

	<label for='image'>Category Image (300x300 minimum)</label><br/>
	<?php echo form_upload('image', "", 'style="width:350px;"'); ?><br/>
	<span style='color:red;'><small><i>Please only select an image if you plan on replacing the image that is already there.</i></small></span>
	
</td></tr>

</table>

</td>

<?php
if ($type == "wattage") {

	echo"<td width='50%' valign='top'><table cellspacing='10'>";
	foreach ($parents_with_labels AS $parentId => $parentLabel) {

		echo"<tr><td>";
	
		echo"<strong>".$label." ".$parentLabel." (300x300 minimum)</strong><br/>";
		echo"<input type='file' name='wImage-".$parentId."' /><br/><span style='color:red;'><small><i>Please only select an image if you plan on replacing the image that is already there.</i></small></span>";
	
		echo"</td></tr>";

	}
	echo"</table></td>";
}
?>
</tr>
<tr><td colspan="2" align="left">

	<?php echo form_submit('submit', 'Submit Category!', 'style="width:375px;"'); ?>

</td></tr></table>

</form><br/><br/>

<table class="dataTables-files cell-border">

<thead>
	<tr>
		<th>Category Name</th>
		<th>Type</th>
		<th>Img</th>
		<th>Category Actions</th>
	</tr>
</thead>

<tbody>

<?php

foreach ($parents AS $parent) {

	echo"
	
		<tr>
		
			<td>".$parent->label."</td>
			<td>".ucfirst($parent->type)."</td>
			<td>".(strlen($parent->image) ? "Yes" : "No")."</td>
			<td align='center'>".anchor('admin/category/'.$parent->fcid, 'Edit Category', 'title="Edit Category"')." - ".anchor('admin/deletecategory/'.$parent->fcid, 'Delete Category', 'title="Delete Category"')."</td>
		
		</tr>
	
	";

}

?>

</tbody>

</table>

</div>

<script type="text/javascript">

$(document).ready(function() {

	<?php
	
	if (isset($editing_parent_type)) {
	
		$selected_items = "";
	
		foreach ($parent_values AS $p) {
	
			$selected_items .= $p.",";
		
		}
	
		$selected_items = substr($selected_items, 0, -1);
	
	?>
	
	$.get( "/ajax/grabParents/<?php echo $editing_parent_type; ?>", function (data) {
		
		$("#parent_dropdown").html(data).val([<?php echo $selected_items; ?>]).fadeIn();
		
	});
	
	<?php
	
	}
	
	?>

	$("select[name=type]").change(function() {
	
		var type = $(this).val();
		
		if (type == "type" || type == "wattage") {

			$.get( "/ajax/grabParents/"+type, function (data) {
		
				$("#parent_dropdown").html(data).fadeIn();
		
			});
			
			$(".parents_dropdown").fadeIn();
			
		} else {
		
			$(".parents_dropdown").fadeOut();
		
		}
	
	});

});

</script>