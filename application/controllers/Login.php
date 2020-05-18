<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
	
		parent::__construct();
		$this->load->library('form_validation');
	
	}
	
	public function index() {
	
		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_login');
		$this->form_validation->set_error_delimiters('', '');
		
		$data['user'] = $this->session->userdata('logged');
		
		if ($this->form_validation->run() == FALSE && !$this->session->userdata('logged')) {
		
			$this->load->view('header', $data);
			$this->load->view('login', $data);
			$this->load->view('footer');
		
		} else {
		
			redirect('home', 'refresh');
			
		}
	
	}
	
	public function login($password) {
	
		$username = $this->input->post('username');
		$result = $this->user->login($username, $password);
		if ($result) {
		
			foreach ($result AS $row) {
		
				$session_array['uid'] = $row->uid;
				$session_array['username'] = $row->username;
				$session_array['admin'] = $row->admin;
				$approved = $row->approved;
			
			}
			
		} else {
		
			$uid = 0;
			$username = NULL;
			$admin = 0;
			$approved = 0;
			
		}
		
		if ($approved == 1) {
			
			$this->session->set_userdata('logged', $session_array);
			$this->user->log($session_array['uid'], 'logged in');
			
			return TRUE;
		
		} elseif (strlen($username) > 0 && $approved == 0) {
		
			$this->form_validation->set_message('login', 'You are not approved to use this system yet.');
			
			return FALSE;
			
		} else {
		
			$this->form_validation->set_message('login', 'Invalid username or password!');
			return FALSE;
			
		}
	
	}
	
	public function register() {
	
		$this->form_validation->set_rules('username', 'Email Address', 'trim|required|matches[confirmusername]|valid_email|is_unique[users.username]');
		$this->form_validation->set_rules('confirmusername', 'Confirm Email Address', 'trim|required|matches[username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[confirmpassword]');
		$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|matches[password]');
		$this->form_validation->set_rules('name', 'Full Name', 'trim');
		$this->form_validation->set_rules('phone', 'Phone Number', 'trim');
		$this->form_validation->set_rules('company', 'Company', 'trim');
		$this->form_validation->set_rules('title', 'Title', 'trim');
		$this->form_validation->set_rules('hear', 'How did you hear about us?', 'trim');
		$this->form_validation->set_rules('other', 'Other', 'trim');
		
		$data['user'] = $this->session->userdata('logged');
		$data['username'] = $this->input->post('username');
		$data['confirmusername'] = $this->input->post('confirmusername');
		$data['password'] = $this->input->post('password');
		$data['confirmpassword'] = $this->input->post('confirmpassword');
		$data['name'] = $this->input->post('name');
		$data['phone'] = $this->input->post('phone');
		$data['company'] = $this->input->post('company');
		$data['title'] = $this->input->post('title');
		$data['hear'] = $this->input->post('hear');
		$data['other'] = $this->input->post('other');
		
		$data['message'] = "";
		
		if ($this->input->post()) {
		
			if ($this->form_validation->run()) {
		
				$uid = $this->user->register($data['username'], $data['password'], $data['name'], $data['phone'], $data['company'], $data['title'], $data['hear'], $data['other']);
				$this->user->login($data['username'], $data['password']);

				$data['message'] = "<b>Thank you, your new account password will be displayed below, and also has been emailed to you, if you have any problems please feel free to contact us at info@neutexworld.com!</b>";
				$data['message'] .= "<br/><br/>Your new account information is below.<br/>--------------------------------------------<br/>";
				$data['message'] .= "<b>Username:</b> ".$data['username']."<br/>";
				$data['message'] .= "<b>Password:</b> ".$data['password']."<br/>";
				$data['message'] .= "--------------------------------------------<br/><br/>Once again, this information will be emailed to you as well, contact us at info@neutexworld.com if you have any problems!";
			
			} else {
		
				$data['message'] = "Registration has failed. Please make sure that your usernames match, your passwords match, and you're not registering with an email that might already be in the system.";
			
			}
			
		}
		
		$this->load->view('header', $data);
		$this->load->view('register', $data);
		$this->load->model('files');
		$footerdata['allSorted'] = $this->files->getAllSorted();
		$this->load->view('footer', $footerdata);
	
	}
	
	public function change_password() {
	
		if ($this->session->userdata('logged')) {
		
			$data['user'] = $this->session->userdata('logged');
			
		} else {
		
			redirect('login', 'refresh');
			
		}
		
		if ($this->input->post('currentpassword')) {
		
			$this->form_validation->set_rules('currentpassword', 'Current Password', 'trim|required');
			$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required');
			$this->form_validation->set_rules('confirmnewpassword', 'Confirm New Password', 'trim|required|matches[newpassword]');
			
		}
		
		$this->form_validation->set_rules('username', 'New Username/Email', 'trim|required');
		$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
		
		
		if ($this->input->post()) {
		
			if ($this->form_validation->run()) {
			
				$userinfo = $this->db->query("SELECT * FROM `users` WHERE `uid` = '".$data['user']['uid']."'")->row();
				if ($this->input->post('currentpassword')) {
				
					if (md5($this->input->post('currentpassword')) == $userinfo->password) {
				
						$this->db->query("UPDATE `users` SET `password` = '".md5($this->input->post('newpassword'))."' WHERE `uid` = '".$data['user']['uid']."'");
						$data['message'] = "Your profile has been updated, the next time you log in you will need to use your new password.";
				
					} else {
				
						$data['message'] = "The current password that you typed in did not match the one that we have on file.";
				
					}
					
				}
				
				$this->db->query("UPDATE `users` SET `username` = '".$this->input->post('username')."', `name` = '".$this->input->post('name')."', `phone` = '".$this->input->post('phone')."', `company` = '".$this->input->post('company')."', `title` = '".$this->input->post('title')."' WHERE `uid` = '".$data['user']['uid']."'");
				
				if (!$data['message']) $data['message'] = "Your profile has been updated successfully!";
			
			} else {
			
				$data['message'] = "Unfortunately the two passwords you inputted do not match each other, or you're missing a required field.";
			
			}
		
		}
		
		$data = $this->user->userInfo($data['user']['uid']);
		$data->user = $this->session->userdata('logged');
		
		$this->load->view('header', $data);
		$this->load->view('change_password', $data);
		$this->load->model('files');
		$footerdata['allSorted'] = $this->files->getAllSorted();
		$this->load->view('footer', $footerdata);
	
	}
	
	public function logout() {
	
		$user = $this->session->userdata('logged');
		$this->user->log($user['uid'], 'logged out');
	
		$this->session->unset_userdata('logged');
		
		redirect('login', 'refresh');
	
	}
	
}