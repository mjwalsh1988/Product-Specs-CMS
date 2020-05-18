<?php

Class User extends CI_Model {

	public function login ($username, $password) {
	
		$password = md5($password);
		$this->db->select('uid, username, name, phone, company, title, admin, approved');
		$this->db->from('users');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->limit(1);
		$query = $this->db->get();
		$result = $query->row();
		
		$session_array['uid'] = $result->uid;
		$session_array['username'] = $result->username;
		$session_array['name'] = $result->name;
		$session_array['phone'] = $result->phone;
		$session_array['company'] = $result->company;
		$session_array['title'] = $result->title;
		$session_array['admin'] = $result->admin;
		
		if ($result->approved == 1) {
			
			$this->session->set_userdata('logged', $session_array);
			$this->user->log($session_array['uid'], 'logged in');
			
			return TRUE;
		
		} else {
			return FALSE;
			
		}
	
	}
	
	public function register ($username, $password, $name, $phone, $company, $title, $hear, $other) {
	
		if (strlen($password) >= 5) { 

			$password = $password;
			$md5password = md5($password);

		} else {

			$possible_characters = "abcdefghijklmnopqrstuvwxyz0123456789.-+=_,!@$#*%<>[]{}";
	                $password = 0;
	                for ($i=0; $i<8; $i++) {
		                $password .= substr($possible_characters, rand(0, 8-1), 1);
	                }
	                $password = str_shuffle($password);
			$md5password = md5($password);

		}

                $config = array(
			'mailtype' => 'html',
			'protocol' => 'smtp',
			'smtp_host' => 'neutexspecs.com',
			'smtp_user' => 'no-reply@neutexspecs.com',
			'smtp_pass' => 'U[DqoPT]gXhL',
			'smtp_port' => '25'
		);
                $this->load->library('email');
		$this->email->initialize($config);

                $this->email->from('no-reply@neutexspecs.com');
                $this->email->to('info@neutexworld.com');
                $this->email->subject('NeutexSpecs.com - New User Signup!');
                $message = "Hello,<br/><br/>This email is to notify you that a new user has signed up to NeutexSpecs.com. We have included the details of the username below.<br/><br/>";
                $message .= "-----------------------<br/><b>Username:</b> ".$username."<br/><b>Name:</b> ".$name."<br/><b>Phone:</b> ".$phone."<br/><b>Company:</b> ".$company."<br/><b>Title:</b> ".$title."<br/><b>Hear:</b>".$hear."<br/><b>Other: ".$other."<br/>-----------------------";
                $this->email->message($message);
                $this->email->send();

                $this->email->clear();

                $this->email->from('no-reply@neutexspecs.com');
                $this->email->reply_to('info@neutexworld.com');
                $this->email->to($username);
                $this->email->subject('Hello, Welcome to NeutexSpecs!');
                $message = "Hello,<br/><br/>Welcome to Neutex Specs! We have included your new account information below.<br/><br/>";
                $message .= "-----------------------<br/><b>Username:</b> ".$username."<br/><b>Password:</b> ".$password."<br/><b>Name:</b> ".$name."<br/><b>Phone:</b> ".$phone."<br/><b>Company:</b> ".$company."<br/><b>Title:</b> ".$title."<br/><b>Hear:</b>".$hear."<br/><b>Other: ".$other."<br/>-----------------------<br/><br/>";
                $message .= "If you have any questions or comments please feel free to contact us at info@neutexworld.com!";
                $this->email->message($message);
                $this->email->send();

		$this->db->query("INSERT INTO `users` SET `username` = '".$username."', `password` = '".$md5password."', `name` = '".$name."', `phone` = '".$phone."', `company` = '".$company."', `title` = '".$title."', `hear` = '".$other."', `other` = '".$other."'");
		$this->login($username, $password);
		
		$new_user = array('uid' => $this->db->insert_id(), 'password' => $password);
		return $new_user;
	
	}
	
	public function edit ($uid, $username, $password, $name, $phone, $company, $title) {
	
		$this->db->query("UPDATE `users` SET `username` = '".$username."', `name` = '".$name."', `phone` = '".$phone."', `company` = '".$company."', `title` = '".$title."' WHERE `uid` = '".$uid."'");
		if (strlen($password) > 0) {
		
			$this->db->query("UPDATE `users` SET `password` = '".md5($password)."' WHERE `uid` = '".$uid."'");
		
		}
		
		return true;
	
	}
	
	public function log ($uid, $action) {
	
		$this->db->query("INSERT INTO `logs` SET `uid` = '" . $uid . "', `action` = '" . $action . "', `timestamp` = UNIX_TIMESTAMP()");
	
	}
	
	public function userList () {
	
		return $this->db->query("SELECT * FROM `users` ORDER BY `approved`,`username` ASC")->result();
	
	}
	
	public function userInfo ($uid) {
	
		return $this->db->query("SELECT * FROM `users` WHERE `uid` = '".$uid."'")->row();
		
	}

}

?>