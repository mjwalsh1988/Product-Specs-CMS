<?php

Class Files extends CI_Model {

	public function getFiles($select = NULL) {
	
		if ($select == NULL) {
		
			$select = "SELECT * FROM `files`";
			
		}
		$query = $this->db->query($select)->result();
		$i = 0;
		$files = array();
		foreach ($query AS $row) {
		
			$files[$i]['fid'] = $row->fid;
			$files[$i]['sku'] = $row->sku;
			$files[$i]['name'] = $row->name;
			$files[$i]['description'] = $row->description;
			$files[$i]['timestamp'] = $row->timestamp;
			
			$subquery = $this->db->query("SELECT * FROM `files_attributes` WHERE `fid` = '".$row->fid."'")->result();
			foreach ($subquery AS $srow) {
			
				if ($srow->att_name == "type" || $srow->att_name == "wattage" || $srow->att_name == "family") {
				
					$value = "";
					$array = substr($srow->att_value, 1, -1);
					$array = explode("][", $array);
					foreach ($array AS $r) {
					
						$value .= (strlen($r) > 0 && is_numeric($r) ? $this->getCategoryLabel($r) : "").", ";
					
					}
					$return = substr($value, 0, -2);
					
					$files[$i][$srow->att_name] = $return;
					
				} else {
				
					$files[$i][$srow->att_name] = $srow->att_value;
				
				}
			
			}
			
			$i++;
		
		}
		
		return $files;
	
	}
	
	public function searchFiles($search, $category) {
	
		$search = explode(" ", $search);
		$string = array();
		foreach ($search AS $kw) {
		
			$string[] = "`name` LIKE '%".$kw."%'";
			
		}
		
		$string = implode(" OR ", $string);
		
		return $this->db->query("SELECT * FROM `files` WHERE (".$string.") ORDER BY `name` ASC")->result();
	
	}
	
	public function getFile($fid) {
	
		return $this->db->query("SELECT * FROM `files` WHERE `fid` = '".$fid."'")->row();
	
	}
	
	public function getFileImage($fid) {
	
		return $this->db->query("SELECT * FROM `files_attributes` WHERE `fid` = '".$fid."' AND `att_name` = 'image'")->row();
	
	}
	
	public function getDownload($faid) {
	
		return $this->db->query("SELECT * FROM `files_attributes` WHERE `faid` = '".$faid."'")->row();
	
	}
	
	public function getCategoryLabel ($fcid) {
	
		$row = $this->db->query("SELECT `label` FROM `files_categories` WHERE `fcid` = '".$fcid."'")->row();
		
		return (isset($row->label) ? $row->label : "");
	
	}
	
	public function getFamilies () {
	
		$query = $this->db->query("SELECT `fcid`,`label` FROM `files_categories` WHERE `type` = 'family' ORDER BY `label` ASC")->result();
		foreach ($query AS $row) {
		
			$families[$row->fcid] = $row->label;
		
		}
		
		return $families;
	
	}
	
	public function getFamiliesFull() {
	
		return $this->db->query("SELECT * FROM `files_categories` WHERE `type` = 'family' ORDER BY `label` ASC")->result();
	
	}
	
	public function getTypes ($parent = 0) {
	
		$query = $this->db->query("SELECT `fcid`,`label` FROM `files_categories` WHERE `type` = 'type'".($parent > 0 ? " AND `parent` LIKE '%[".$parent."]%'" : "")." ORDER BY `label` ASC")->result();
		foreach ($query AS $row) {
		
			$types[$row->fcid] = $row->label;
		
		}
		
		return $types;
	
	}
	
	public function getAllSorted ($parent = 0) {
	
		$all = array();
		$families = $this->db->query("SELECT * FROM `files_categories` WHERE `type` = 'family' ORDER BY `label` ASC")->result();
		foreach ($families AS $family) {
		
			$all[$family->fcid]["label"] = $family->label;
			$types = $this->db->query("SELECT * FROM `files_categories` WHERE `type` = 'type' AND `parent` LIKE '%[".$family->fcid."]%'")->result();
			foreach ($types AS $type) {
			
				$all[$family->fcid][$type->fcid]["label"] = $type->label;
				$wattages = $this->db->query("SELECT * FROM `files_categories` WHERE `type` = 'wattage' AND `parent` LIKE '%[".$type->fcid."]%' ORDER BY CAST(`label` as SIGNED INTEGER) ASC")->result();
				foreach ($wattages AS $wattage) {
				
					$all[$family->fcid][$type->fcid][$wattage->fcid]["label"] = $wattage->label;
				
				}
			
			}
		
		}
		
		return $all;
	
	}
	
	public function getWattages ($parent = 0) {
	
		$query = $this->db->query("SELECT `fcid`,`label` FROM `files_categories` WHERE `type` = 'wattage'".($parent > 0 ? " AND `parent` LIKE '%[".$parent."]%'" : "")." ORDER BY CAST(`label` AS SIGNED INTEGER) ASC")->result();
		foreach ($query AS $row) {
		
			$wattages[$row->fcid] = $row->label;
		
		}
		
		return $wattages;
	
	}

	public function getDownloads ($fid) {
	
		return $this->db->query("SELECT * FROM `files_attributes` WHERE `fid` = '".$fid."' AND `att_name` LIKE 'file_%'")->result();
	
	}

}

?>