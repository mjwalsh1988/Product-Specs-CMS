<div class="container">

<div class="title">

	<h2 style="padding-right:350px;font-size:30px;"><b><?php echo $file->name; ?></b></h1>
	<div class="title-sep">
		<div class="title-sep-lines">
		</div>
	</div>

</div>

<table cellspacing="25" cellpadding="10" width="100%" border="0">
<tr>
<?php
	
	echo"<td style='line-height:30px;font-size:14px;' valign='top' align='left' rowspan='2'>".nl2br($file->description)."</td>";
	echo"<td valign='top' align='center' style='width:300px;height:300px;background-image:url(/uploads/".$image->att_value.");background-repeat:no-repeat;'></td>";
	
?>
</tr>
<tr><td><b>SKU:</b> <?php echo $file->sku; ?></td></tr>
</table>

<br/>

<table class="dataTables-downloads cell-border">

<thead>
	<tr>
		<th width='20%'>Downloadable Files</th>
		<th></th>
	</tr>
</thead>

<tbody>

<?php

foreach ($downloads AS $dl) {

	switch ($dl->att_name) {
	
		case "file_ies": 
			$dltype = "IES File"; break;
			
		case "file_spec": 
			$dltype = "Product Spec Sheet"; break;
			
		case "file_info";
			$dltype = "Product Info Sheet"; break;
			
		case "file_family";
			$dltype = "Family Sheet"; break;
			
		case "file_iesextra1": 
			$dltype = "Printed IES Warm White"; break;
			
		case "file_iesextra2": 
			$dltype = "Engineer IES Warm White"; break;
			
		case "file_iesextra3";
			$dltype = "Printed IES Neutral White"; break;
			
		case "file_iesextra4";
			$dltype = "Engineer IES Neutral White"; break;
			
		case "file_iesextra5": 
			$dltype = "Printed IES Cool White"; break;
			
		case "file_iesextra6": 
			$dltype = "Engineer IES Cool White"; break;
			
		case "file_iesextra7";
			$dltype = "Printed IES Bright White"; break;
			
		case "file_iesextra8";
			$dltype = "Engineer IES Bright White"; break;
	
	}

	echo"
	
		<tr>
			<td>".anchor('home/download/'.$dl->faid, 'Download File')."</td>
			<td>".$dltype."</td>
		</tr>
		
	";

}

?>

</tbody>

</table>

</div>