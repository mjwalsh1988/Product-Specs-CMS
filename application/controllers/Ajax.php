<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	
	public function grabTypes ($family, $img = 0) {
	
		$this->load->model("files");
		$family = $this->security->xss_clean($family);
		
		if ($img == 0) echo"<option selected disabled>Select Type</option>";
		
		$query = $this->db->query("SELECT * FROM `files_categories` WHERE `parent` LIKE '%[".$family."]%' AND `type` = 'type' ORDER BY `label` ASC")->result();
		foreach ($query AS $row) {
		
			if ($img == 0) {
			
				echo"<option value='".$row->fcid."'>".$row->label."</option>";
				
			} else {
			
				echo"<div data-fcid='".$row->fcid."' class='product_list_item family_icon type_icon'>";
			
				echo"<img src='".($row->image ? "/uploads/".$row->image : "/images/comingsoon.png")."' title='".$row->label."' style='border:1px solid #ededed;margin-bottom:2px;width:250px;height:250px;' />";
				
				echo"<span style='font-size:13px;line-height:14px;font-weight: bold;'>".$row->label."</span>";
			
				echo"</div>";
			
			}
		
		}
		
		if ($img == 1) echo"<div style='clear:both;'></div>";
	
	}
	
	public function grabWattages ($type, $img = 0) {
	
		$this->load->model("files");
		$family = $this->security->xss_clean($type);
		
		if ($img == 0) echo"<option selected disabled>Select Wattage</option>";
		
		$query = $this->db->query("SELECT * FROM `files_categories` WHERE `parent` LIKE '%[".$type."]%' AND `type` = 'wattage' ORDER BY CAST(`label` AS SIGNED INTEGER) ASC")->result();
		foreach ($query AS $row) {
		
			if ($img == 0) {
			
				echo"<option value='".$row->fcid."'>".$row->label."</option>";
				
			} else {
			
				$image = $this->db->query("SELECT * FROM `files_categories_attributes` WHERE `fcid` = '".$row->fcid."' AND `parent` = '".$type."'")->row();
			
				echo"<div data-fcid='".$row->fcid."' class='product_list_item family_icon wattage_icon'>";
			
				echo"<img src='".($image->content ? "/uploads/".$image->content : "/images/comingsoon.png")."' title='".$row->label."' style='border:1px solid #ededed;margin-bottom:2px;width:250px;height:250px;' />";
				
				echo"<span style='font-size:13px;line-height:14px;font-weight: bold;'>".$row->label."</span>";
			
				echo"</div>";
			
			}
		
		}
		
		if ($img == 1) echo"<div style='clear:both;'></div>";
	
	}
	
	public function grabParents ($type) {
	
		$type = $this->security->xss_clean($type);
		
		if ($type == "type") {
		
			$grab = "family";
			
		} elseif ($type == "wattage") {
		
			$grab = "type";
			
		}
		
		$query = $this->db->query("SELECT * FROM `files_categories` WHERE `type` = '".$grab."' ORDER BY `label` ASC")->result();
		foreach ($query AS $row) {
		
			echo"<option value='".$row->fcid."'>".$row->label."</option>";
		
		}
	
	}
	
}