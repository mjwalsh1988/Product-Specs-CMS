<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index() {
	
		$this->load->helper('form');
		$this->load->model('files');
		$this->load->library('form_validation');
		
		if ($this->session->userdata('logged')) {
		
			$data['user'] = $this->session->userdata('logged');
			
		} else {
		
			redirect('login', 'refresh');
			
		}
		
		$data['files'] = $this->files->getFiles();
		$data['families'] = array('' => 'Select Product Family') + $this->files->getFamilies();
		$data['familiesfull'] = $this->files->getFamiliesFull();
		$data['error'] = "";
		
		$this->load->view('header', $data);
		
		$this->form_validation->set_rules('family', 'Product Family', 'trim|required|xss_clean|required');
		$this->form_validation->set_rules('type', 'Product Type', 'trim|xss_clean|required');
		$this->form_validation->set_rules('wattage', 'Product Wattage', 'trim|xss_clean|required');
		
		if ($this->form_validation->run() == FALSE) {
		
			
		
		} else {
			
			$query = "SELECT f.* 
				FROM files f
					INNER JOIN files_attributes fa1 ON f.fid = fa1.fid
					INNER JOIN files_attributes fa2 ON f.fid = fa2.fid
					INNER JOIN files_attributes fa3 ON f.fid = fa3.fid
				WHERE 
					fa1.att_name = 'wattage' AND fa1.att_value LIKE '%[".$this->input->post('wattage')."]%' AND 
					fa2.att_name = 'type' AND fa2.att_value LIKE '%[".$this->input->post('type')."]%' AND 
					fa3.att_name = 'family' AND fa3.att_value LIKE '%[".$this->input->post('family')."]%'";
			$file = $this->db->query($query);
					
			if ($file->num_rows() > 1) {
			
				$finfo = $this->files->getFiles($query);
				$data['multiple_files'] = $finfo;
			
			} elseif ($file->num_rows() == 1) {
			
				$finfo = $file->row();
				redirect('home/file/'.$finfo->fid, 'refresh');
			
			} else {
			
				$data['error'] = "No file was found in our database with that criteria, please try selecting another.";
			
			}
		
		}
		
		$this->load->view('home2', $data);
		$footerdata['allSorted'] = $this->files->getAllSorted();
		$this->load->view('footer', $footerdata);
		
	}
	
	public function newhome() {
	
		$this->load->helper('form');
		$this->load->model('files');
		$this->load->library('form_validation');
		
		if ($this->session->userdata('logged')) {
		
			$data['user'] = $this->session->userdata('logged');
			
		} else {
		
			redirect('login', 'refresh');
			
		}
		
		$data['allSorted'] = $this->files->getAllSorted();
		$data['files'] = $this->files->getFiles();
		$data['families'] = array('' => 'Select Product Family') + $this->files->getFamilies();
		$data['familiesfull'] = $this->files->getFamiliesFull();
		$data['error'] = "";
		
		$this->load->view('header', $data);
		
		$this->form_validation->set_rules('family', 'Product Family', 'trim|required|xss_clean|required');
		$this->form_validation->set_rules('type', 'Product Type', 'trim|xss_clean|required');
		$this->form_validation->set_rules('wattage', 'Product Wattage', 'trim|xss_clean|required');
		
		if ($this->form_validation->run() == FALSE) {
		
			
		
		} else {
			
			$query = "SELECT f.* 
				FROM files f
					INNER JOIN files_attributes fa1 ON f.fid = fa1.fid
					INNER JOIN files_attributes fa2 ON f.fid = fa2.fid
					INNER JOIN files_attributes fa3 ON f.fid = fa3.fid
				WHERE 
					fa1.att_name = 'wattage' AND fa1.att_value LIKE '%[".$this->input->post('wattage')."]%' AND 
					fa2.att_name = 'type' AND fa2.att_value LIKE '%[".$this->input->post('type')."]%' AND 
					fa3.att_name = 'family' AND fa3.att_value LIKE '%[".$this->input->post('family')."]%'";
			$file = $this->db->query($query);
					
			if ($file->num_rows() > 1) {
			
				$finfo = $this->files->getFiles($query);
				$data['multiple_files'] = $finfo;
			
			} elseif ($file->num_rows() == 1) {
			
				$finfo = $file->row();
				redirect('home/file/'.$finfo->fid, 'refresh');
			
			} else {
			
				$data['error'] = "No file was found in our database with that criteria, please try selecting another.";
			
			}
		
		}
		
		$this->load->view('home2', $data);
		$footerdata['allSorted'] = $this->files->getAllSorted();
		$this->load->view('footer', $footerdata);
		
	}

	public function file($fid) {
	
		$this->load->helper('form');
		$this->load->model('files');
		$data2['user'] = $this->session->userdata('logged');
		$data['user'] = $this->session->userdata('logged');
		
		if ($this->session->userdata('logged')) {
		
			$data['user'] = $this->session->userdata('logged');
			
		} else {
		
			redirect('login', 'refresh');
			
		}
		
		$data['file'] = $this->files->getFile($fid);
		$data['downloads'] = $this->files->getDownloads($fid);
		$data['image'] = $this->files->getFileImage($fid);
		
		$user = $this->session->userdata('logged');
		$this->user->log($user['uid'], 'viewed a file ('.$data['file']->name.')');
		
		$this->load->view('header', $data2);
		$this->load->view('file', $data);
		$footerdata['allSorted'] = $this->files->getAllSorted();
		$this->load->view('footer', $footerdata);
	
	}
	
	public function download($faid) {
	
		$this->load->helper('download');
		$this->load->model('files');
		
		$download = $this->files->getDownload($faid);
		$file = $this->files->getFile($download->fid);
		
		$user = $this->session->userdata('logged');
		$this->user->log($user['uid'], 'downloaded a file ('.$file->name.')');
		
		$openFile = file_get_contents('./uploads/'.$download->att_value);
		force_download($download->att_value, $openFile);
		
		redirect('home', 'refresh');
	
	}

}