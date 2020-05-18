<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		$this->load->model('admin_functions');
		$this->load->library('form_validation');
		
		if (!$this->session->userdata('logged')) {
		
			redirect('login', 'refresh');
			
		}
	
	}
	
	public function index() {
	
		
	
	}
	
	public function logs() {
	
		if ($this->input->post('user')) {
		
			$lid = $this->db->escape_str($this->input->post('user'));
			
		} else {
		
			$lid = "All";
			
		}
		
		$data['logs'] = $this->admin_functions->logs($lid);
		$data['selected_user'] = $lid;
		$data['user'] = $this->session->userdata('logged');
		$data2['user'] = $this->session->userdata('logged');
		$data['users'] = $this->user->userList();
		
		$this->load->view('header', $data2);
		$this->load->view('admin_logs', $data);
		$this->load->model('files');
		$footerdata['allSorted'] = $this->files->getAllSorted();
		$this->load->view('footer', $footerdata);
	
	}
	
	public function file() {
	
		$fid = $this->uri->segment($this->uri->total_segments());
		
		$data2['user'] = $this->session->userdata('logged');
		
		$this->form_validation->set_rules('name', 'File Name', 'trim|required|xss_clean|required');
		$this->form_validation->set_rules('sku', 'SKU', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'File Description', 'trim|xss_clean|required');
		$this->form_validation->set_rules('family[]', 'Product Family', 'trim|xss_clean|required');
		$this->form_validation->set_rules('type', 'Product Type', 'trim|xss_clean');
		$this->form_validation->set_rules('wattage', 'Wattage', 'trim|xss_clean');
		
		$data['fid'] = $fid;
		if (!is_numeric($fid)) {
		
			$fid = NULL;
			$data['fid'] = NULL;
			
		}
		
		$this->load->model('files');
		$data['files'] = $this->files->getFiles();
		$data['families'] = $this->files->getFamilies();
		$data['types'] = $this->files->getTypes();
		$data['wattages'] = $this->files->getWattages();
		$data['upload_error'] = "";
		
		if ($this->input->post()) {
		
			$data['name'] = $this->db->escape_str($this->security->xss_clean($this->input->post('name')));
			$data['sku'] = $this->db->escape_str($this->security->xss_clean($this->input->post('sku')));
			$data['description'] = $this->db->escape_str($this->security->xss_clean($this->input->post('description')));
			$data['family'] = $this->input->post('family');
			$data['type'] = $this->input->post('type');
			$data['wattage'] = $this->input->post('wattage');
			
		} elseif (!$this->input->post() && $fid > 0) {
		
			$row = $this->db->query("SELECT * FROM `files` WHERE `fid` = '".$fid."'")->row();
			$att_family = $this->db->query("SELECT `att_value` FROM `files_attributes` WHERE `att_name` = 'family' AND `fid` = '".$fid."'")->row();
			$att_type = $this->db->query("SELECT `att_value` FROM `files_attributes` WHERE `att_name` = 'type' AND `fid` = '".$fid."'")->row();
			$att_wattage = $this->db->query("SELECT `att_value` FROM `files_attributes` WHERE `att_name` = 'wattage' AND `fid` = '".$fid."'")->row();
			
			$data['name'] = $row->name;
			$data['sku'] = $row->sku;
			$data['description'] = $row->description;
			if ($att_family->att_value) {
				$newfamily = substr($att_family->att_value, 1, -1);
				$data['family'] = explode("][", $newfamily);
			} else { $data['family'] = array(); }
			if ($att_type->att_value) {
				$newtypes = substr($att_type->att_value, 1, -1);
				$data['type'] = explode("][", $newtypes);
			} else { $data['type'] = array(); }
			if ($att_wattage->att_value) {
				$newwattage = substr($att_wattage->att_value, 1, -1);
				$data['wattage'] = explode("][", $newwattage);
			} else { $data['wattage'] = array(); }
			
		
		} else {
		
			$data['name'] = "";
			$data['sku'] = "";
			$data['description'] = "";
			$data['family'] = "";
			$data['type'] = "";
			$data['wattage'] = "";
			
		}
		
		$config['upload_path'] = './uploads/';
		//$config['allowed_types'] = 'gif|jpg|png|pdf|ies|PDF';
		$config['allowed_types'] = '*';
		$config['encrypt_name'] = TRUE;
		$config['max_size'] = 0;
				
		$this->load->library('upload', $config);
		
		$user = $this->session->userdata('logged');
		
		$this->load->view('header', $data2);
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('admin_file.php', $data);
			
		} else {
		
			if (is_numeric($fid)) {
		
				foreach ($_FILES AS $fieldname => $fileobject) {
				
					if (!empty($fileobject['name'])) {
					
						$this->upload->initialize($config);
						if (!$this->upload->do_upload($fieldname)) {
						
							$data['upload_error'] = $this->upload->display_errors();
						
						} else {
						
							$currentFileQuery = $this->db->query("SELECT * FROM `files_attributes` WHERE `fid` = '".$fid."' AND `att_name` = '".$fieldname."'");
							if ($currentFileQuery->num_rows() > 0) {
							
								$currentFile = $currentFileQuery->row();
								if (file_exists(FCPATH.'uploads/'.$currentFile->att_value)) {
									unlink(FCPATH.'uploads/'.$currentFile->att_value);
								}
								$this->db->query("UPDATE `files_attributes` SET `att_value` = '".$this->upload->data('file_name')."' WHERE `faid` = '".$currentFile->faid."'");
								
							} else {
							
								$this->db->query("INSERT INTO `files_attributes` SET `fid` = '".$fid."', `att_name` = '".$fieldname."', `att_value` = '".$this->upload->data('file_name')."'");
								
							}
						
						}
					
					}
				
				}
				
				$this->db->query("UPDATE `files` SET `name` = '".$data['name']."', `description` = '".$data['description']."', `timestamp` = '".time()."', `sku` = '".$data['sku']."' WHERE `fid` = '".$fid."'");
				
				if ($data['family']) {
				
					if ($this->db->query("SELECT * FROM `files_attributes` WHERE `fid` = '".$fid."' AND `att_name` = 'family'")->num_rows() > 0) {
				
						$typevalue = "";
						foreach ($data['family'] AS $type) {
						
							$typevalue .= "[".$this->db->escape_str($type)."]";
						
						}
						$this->db->query("UPDATE `files_attributes` SET `att_value` = '".$typevalue."' WHERE `fid` = '".$fid."' AND `att_name` = 'family'");
				
					} else {
				
						$typevalue = "";
						foreach ($data['family'] AS $type) {
						
							$typevalue .= "[".$this->db->escape_str($type)."]";
						
						}
						$this->db->query("INSERT INTO `files_attributes` SET `fid` = '".$fid."', `att_name` = 'family', `att_value` = '".$typevalue."'");
				
					}
					
				}
				
				if ($data['type']) {
				
					if ($this->db->query("SELECT * FROM `files_attributes` WHERE `fid` = '".$fid."' AND `att_name` = 'type'")->num_rows() > 0) {
				
						$typevalue = "";
						foreach ($data['type'] AS $type) {
						
							$typevalue .= "[".$this->db->escape_str($type)."]";
						
						}
						$this->db->query("UPDATE `files_attributes` SET `att_value` = '".$typevalue."' WHERE `fid` = '".$fid."' AND `att_name` = 'type'");
				
					} else {
				
						$typevalue = "";
						foreach ($data['type'] AS $type) {
						
							$typevalue .= "[".$this->db->escape_str($type)."]";
						
						}
						$this->db->query("INSERT INTO `files_attributes` SET `fid` = '".$fid."', `att_name` = 'type', `att_value` = '".$typevalue."'");
				
					}
					
				}
				
				if ($data['wattage']) {
				
					if ($this->db->query("SELECT * FROM `files_attributes` WHERE `fid` = '".$fid."' AND `att_name` = 'wattage'")->num_rows() > 0) {
				
						$wattagevalue = "";
						foreach ($data['wattage'] AS $wattage) {
						
							$wattagevalue .= "[".$this->db->escape_str($wattage)."]";
						
						}
						$this->db->query("UPDATE `files_attributes` SET `att_value` = '".$wattagevalue."' WHERE `fid` = '".$fid."' AND `att_name` = 'wattage'");
				
					} else {
				
						$wattagevalue = "";
						foreach ($data['wattage'] AS $wattage) {
						
							$wattagevalue .= "[".$this->db->escape_str($wattage)."]";
						
						}
						$this->db->query("INSERT INTO `files_attributes` SET `fid` = '".$fid."', `att_name` = 'wattage', `att_value` = '".$wattagevalue."'");
				
					}
					
				}
				
				$this->user->log($user['uid'], 'edited a file ('.$data['name'].')');
				redirect('admin/file', 'refresh');
		
			} else {
		
		
				$this->db->query("INSERT INTO `files` set `name` = '".$data['name']."', `description` = '".$data['description']."',  `timestamp` = '".time()."', `sku` = '".$data['sku']."'");
				$newid = $this->db->insert_id();
				
				if ($data['family']) {
				
					$typevalue = "";
					foreach ($data['family'] AS $type) {
						
						$typevalue .= "[".$this->db->escape_str($type)."]";
						
					}
					$this->db->query("INSERT INTO `files_attributes` SET `fid` = '".$newid."', `att_name` = 'family', `att_value` = '".$typevalue."'");
					
				}
				
				if ($data['type']) {
				
					$typevalue = "";
					foreach ($data['type'] AS $type) {
						
						$typevalue .= "[".$this->db->escape_str($type)."]";
						
					}
					$this->db->query("INSERT INTO `files_attributes` SET `fid` = '".$newid."', `att_name` = 'type', `att_value` = '".$typevalue."'");
					
				}
				
				if ($data['wattage']) {
				
					$wattagevalue = "";
					foreach ($data['wattage'] AS $wattage) {
						
						$wattagevalue .= "[".$this->db->escape_str($wattage)."]";
						
					}
					$this->db->query("INSERT INTO `files_attributes` SET `fid` = '".$newid."', `att_name` = 'wattage', `att_value` = '".$wattagevalue."'");
					
				}
				
				foreach ($_FILES AS $fieldname => $fileobject) {
				
					if (!empty($fileobject['name'])) {
					
						$this->upload->initialize($config);
						if (!$this->upload->do_upload($fieldname)) {
						
							$data['upload_error'] = $this->upload->display_errors();
						
						} else {
						
							$this->db->query("INSERT INTO `files_attributes` SET `fid` = '".$newid."', `att_name` = '".$fieldname."', `att_value` = '".$this->upload->data('file_name')."'");
						
						}
					
					}
				
				}
				
				$this->user->log($user['uid'], 'added a new file ('.$data['name'].')');
				redirect('admin/file', 'refresh');
		
			}
			
			$this->load->view('admin_file.php', $data);
			
		}
		
		$this->load->model('files');
		$footerdata['allSorted'] = $this->files->getAllSorted();
		$this->load->view('footer', $footerdata);
	
	}
	
	public function deletefile($fid) {
	
		$fid = $this->security->xss_clean($fid);
		
		$result = $this->db->query("SELECT `name` FROM `files` WHERE `fid` = '".$fid."'")->row();
	
		if (!is_numeric($fid) && !strlen($result->name)) {
		
			$user = $this->session->userdata('logged');
			$this->user->log($user['uid'], 'attempted to delete a file that did not exist');
			redirect('admin/file', 'refresh');
			
		} else {
		
			$this->db->query("DELETE FROM `files` WHERE `fid` = '".$fid."'");
			
			$atts = $this->db->query("SELECT * FROM `files_attributes` WHERE `fid` = '".$fid."'")->result();
			foreach ($atts AS $att) {
			
				if (file_exists(FCPATH.'uploads/'.$att->att_value)) {
					unlink(FCPATH.'uploads/'.$att->att_value);
				}
				$this->db->query("DELETE FROM `files_attributes` WHERE `faid` = '".$att->faid."'");
			
			}
			
			$user = $this->session->userdata('logged');
			$this->user->log($user['uid'], 'deleted a file ('.$result->name.')');
			redirect('admin/file', 'refresh');
		
		}
	
	}
	
	public function users($uid = 0) {
	
		$this->load->model('User');
		$users = $this->User->userList();
		$data['users'] = $users;
		
		if ($uid == 0) {
		
			$this->form_validation->set_rules('username', 'Email Address', 'trim|required|matches[confirmusername]|valid_email|is_unique[users.username]');
			$this->form_validation->set_rules('confirmusername', 'Confirm Email Address', 'trim|required|matches[username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirmpassword]');
			$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|matches[password]');
			$this->form_validation->set_rules('name', 'Full Name', 'trim');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('company', 'Company', 'trim');
			$this->form_validation->set_rules('title', 'Title', 'trim');
			
		} else {
		
			$this->form_validation->set_rules('username', 'Email Address', 'trim|required|matches[confirmusername]|valid_email');
			$this->form_validation->set_rules('confirmusername', 'Confirm Email Address', 'trim|required|matches[username]');
			$this->form_validation->set_rules('password', 'Password', 'trim|matches[confirmpassword]');
			$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|matches[password]');
			$this->form_validation->set_rules('name', 'Full Name', 'trim');
			$this->form_validation->set_rules('phone', 'Phone', 'trim');
			$this->form_validation->set_rules('company', 'Company', 'trim');
			$this->form_validation->set_rules('title', 'Title', 'trim');
		
		}
		
		$data['user'] = $this->session->userdata('logged');
		$data2['user'] = $this->session->userdata('logged');
		
		$user = $this->User->userInfo($uid);
		if ($uid > 0 && strlen($user->username)) {
		
			$data['uid'] = $uid;
			$data['username'] = $user->username;
			$data['confirmusername'] = $user->username;
			$data['password'] = "";
			$data['confirmpassword'] = "";
			$data['name'] = $user->name;
			$data['phone'] = $user->phone;
			$data['company'] = $user->company;
			$data['title'] = $user->title;
			
		} else {
		
			$data['uid'] = 0;
			
		}
		
		if ($this->input->post()) {
		
			$data['username'] = $this->db->escape_str($this->input->post('username'));
			$data['confirmusername'] = $this->db->escape_str($this->input->post('confirmusername'));
			$data['password'] = $this->input->post('password');
			$data['confirmpassword'] = $this->input->post('confirmpassword');
			$data['name'] = $this->input->post('name');
			$data['phone'] = $this->input->post('phone');
			$data['company'] = $this->input->post('company');
			$data['title'] = $this->input->post('title');
		
			if ($this->form_validation->run() == FALSE) {
		
				// uhh yeah it failed.. what to do, hmm?
		
			} else {
				
				if ($uid > 0) {
				
					$this->User->edit($uid, $data['username'], $data['password'], $data['name'], $data['phone'], $data['company'], $data['title']);
					redirect('admin/users', 'refresh');
				
				} else {
				
					$this->User->register($data['username'], $data['password'], $data['name'], $data['phone'], $data['company'], $data['title']);
					redirect('admin/users', 'refresh');
					
				}
			
			}
			
		}
		
		$this->load->view('header', $data2);
		$this->load->view('admin_users.php', $data);
		$this->load->model('files');
		$footerdata['allSorted'] = $this->files->getAllSorted();
		$this->load->view('footer', $footerdata);
	
	}
	
	public function approveuser($uid) {
	
		if (is_numeric($uid)) {
		
			$this->db->query("UPDATE `users` SET `approved` = '1' WHERE `uid` = '".$uid."'");
			$user = $this->session->userdata('logged');
			$getUser = $this->user->userInfo($uid);
			$this->user->log($user['uid'], 'approved a user ('.$getUser->username.')');
		
		}
		
		redirect('admin/users', 'refresh');
	
	}
	
	public function giveadmin($uid) {
	
		if (is_numeric($uid)) {
		
			$this->db->query("UPDATE `users` SET `admin` = '1' WHERE `uid` = '".$uid."'");
			$user = $this->session->userdata('logged');
			$getUser = $this->user->userInfo($uid);
			$this->user->log($user['uid'], 'applied admin privileges ('.$getUser->username.')');
		
		}
		
		redirect('admin/users', 'refresh');
	
	}
	
	public function removeadmin($uid) {
	
		if (is_numeric($uid)) {
		
			$this->db->query("UPDATE `users` SET `admin` = '0' WHERE `uid` = '".$uid."'");
			$user = $this->session->userdata('logged');
			$getUser = $this->user->userInfo($uid);
			$this->user->log($user['uid'], 'revoked admin privileges ('.$getUser->username.')');
		
		}
		
		redirect('admin/users', 'refresh');
	
	}
	
	public function deleteuser($uid) {
	
		if (is_numeric($uid)) {
		
			$user = $this->session->userdata('logged');
			$getUser = $this->user->userInfo($uid);
			$this->db->query("DELETE FROM `users` WHERE `uid` = '".$uid."'");
			$this->db->query("DELETE FROM `logs` WHERE `uid` = '".$uid."'");
			$this->user->log($user['uid'], 'deleted a user ('.$getUser->username.')');
		
		}
		
		redirect('admin/users', 'refresh');
	
	}
	
	public function category($fcid = 0) {
	
		if ($fcid) {
		
			$data['fcid'] = $fcid;
		
		} else {
		
			$data['fcid'] = "";
			
		}
	
		$data2['user'] = $this->session->userdata('logged');
		$data['parents'] = $this->db->query("SELECT * FROM `files_categories` ORDER BY `type` ASC, `label` ASC")->result();
		
		$this->form_validation->set_rules('label', 'Category Label', 'trim|required|xss_clean|required');
		$this->form_validation->set_rules('type', 'Category Type', 'trim|xss_clean|required');
		$this->form_validation->set_rules('parent[]', 'Category Parents', 'trim|xss_clean');
		
		$this->load->model('files');
		
		$user = $this->session->userdata('logged');
		
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['encrypt_name'] = TRUE;
		$config['max_size'] = 0;
				
		$this->load->library('upload', $config);
		
		$this->load->view('header', $data2);
		
		if (!$this->input->post() && $fcid > 0) {
		
			$cr = $this->db->query("SELECT * FROM `files_categories` WHERE `fcid` = '".$fcid."'")->row();
		
			$data['label'] = $this->db->escape_str($cr->label);
			$data['type'] = $this->db->escape_str($cr->type);
			$data['editing_parent_type'] = $cr->type;
			
			$parent_value = substr($cr->parent, 1, -1);
			$data['parent_values'] = explode("][", $parent_value);
			foreach ($data['parent_values'] AS $parentId) {
			
				$parentq = $this->db->query("SELECT * FROM `files_categories` WHERE `fcid` = '".$parentId."'")->row();
				$parents_with_labels[$parentId] = $parentq->label;
			
			}
			
			$data['parents_with_labels'] = $parents_with_labels;
		
		} elseif ($this->input->post()) {
		
			$label = $this->db->escape_str($this->input->post('label'));
			$type = $this->db->escape_str($this->input->post('type'));
		
		} else {
		
			$data['label'] = "";
			$data['type'] = "";
			$data['parent'] = "";
			
		}
		
		if ($this->form_validation->run() == FALSE) {
		
			$this->load->view('admin_category.php', $data);
			
		} else {
		
			if ($fcid) {
			
				$parents_string = "";
				if ($this->input->post('parent')) {
				
					foreach ($this->input->post('parent') AS $parent) {
				
						$parents_string .= "[".$parent."]";
				
					}
					
				}
				
				if ($type != "wattage" && strlen($_FILES['image']['name']) > 0) {
						
					if (!$this->upload->do_upload("image")) {
					
						$data['upload_error'] = $this->upload->display_errors();
						
					} else {
					
						if ($this->upload->data('file_name')) {
					
							$image = $this->upload->data('file_name');
							$catoldimg = $this->db->query("SELECT * FROM `files_categories` WHERE `fcid` = '".$fcid."'")->row();
							if (strlen($catoldimg->image) >= 1) {
			
								if (file_exists(FCPATH.'uploads/'.$catoldimg->image)) {
									unlink(FCPATH.'uploads/'.$catoldimg->image);
								}
			
							}
						
						} else {
					
							$image = NULL;
					
						}
					
					}
						
				} elseif ($type == "wattage") {
					
					foreach ($_FILES AS $field => $file) {

						if ($field == "image") continue;
						$explode = explode('-', $field);
						
						if (!$this->upload->do_upload($field)) {
						
							$data['upload_error'] = $this->upload->display_errors();
						
						} else {
						
							$image = $this->upload->data('file_name');
							$check = $this->db->query("SELECT * FROM `files_categories_attributes` WHERE `fcid` = '".$fcid."' AND `parent` = '".$explode[1]."'")->row();
							if (strlen($check->content) >= 1) {
							
								if (file_exists(FCPATH.'uploads/'.$check->content)) {
									unlink(FCPATH.'uploads/'.$check->content);
								}
								$this->db->query("UPDATE `files_categories_attributes` SET `content` = '".$image."' WHERE `fcid` = '".$fcid."' AND `parent` = '".$explode[1]."'");
							
							} else {
							
								$this->db->query("INSERT INTO `files_categories_attributes` SET `content` = '".$image."', `fcid` = '".$fcid."', `parent` = '".$explode[1]."'");
							
							}
							
						}
					
					}
				
				} else {
				
					$image = NULL;
					
				}
				
				$this->db->query("UPDATE `files_categories` SET `label` = '".$label."', `image` = '".$image."', `type` = '".$type."', `parent` = '".$parents_string."' WHERE `fcid` = '".$fcid."'");
				$this->user->log($user['uid'], 'edited a category ('.$this->input->post('label').')');
				redirect('admin/category', 'refresh');
			
			} else {
			
				$parents_string = "";
				if ($this->input->post('parent')) {
				
					foreach ($this->input->post('parent') AS $parent) {
				
						$parents_string .= "[".$parent."]";
				
					}
					
				}
				
				if ($type == "family" && strlen($_FILES['image']['name']) > 0) {
						
					if (!$this->upload->do_upload("image")) {
					
						$data['upload_error'] = $this->upload->display_errors();
						
					} else {
					
						if ($this->upload->data('file_name')) {
					
							$image = $this->upload->data('file_name');
						
						} else {
					
							$image = NULL;
					
						}
					
					}
						
				} else {
				
					$image = NULL;
				
				}
				
				$this->db->query("INSERT INTO `files_categories` SET `label` = '".$label."', `image` = '".$image."', `type` = '".$type."', `parent` = '".$parents_string."'");
				$this->user->log($user['uid'], 'added a category ('.$this->input->post('label').')');
				redirect('admin/category', 'refresh');
			
			}
		
		}
	
	}
	
	public function deletecategory($fcid) {
	
		if (is_numeric($fcid)) {
		
		
			$category = $this->db->query("SELECT * FROM `files_categories` WHERE `fcid` = '".$fcid."'")->row();
			if ($category->type == "family" && strlen($category->image) >= 1) {
			
				if (file_exists(FCPATH.'uploads/'.$category->image)) {
					unlink(FCPATH.'uploads/'.$category->image);
				}
			
			}
			$this->db->query("DELETE FROM `files_attributes` WHERE `att_name` = '".$category->type."' AND `att_value` = '".$category->fcid."'");
		
			$this->db->query("DELETE FROM `files_categories` WHERE `fcid` = '".$fcid."'");
			$user = $this->session->userdata('logged');
			$this->user->log($user['uid'], 'deleted a category');
		
		}
		
		redirect('admin/category', 'refresh');
	
	}
	
	public function deletelogs() {
	
		$this->db->query("DELETE FROM `logs`");
		$user = $this->session->userdata('logged');
		$this->user->log($user['uid'], 'deleted all logs');
				
		redirect('admin/logs', 'refresh');
	
	}
	
}