<?php

Class Admin_functions extends CI_Model {

	public function logs ($uid = 0) {
		
		$result = $this->db->query("SELECT * FROM `logs` ".($uid > 0 ? "WHERE `uid` = '".$uid."' " : "")."ORDER BY `lid` DESC");
		if ($result->num_rows() > 0) {
		
			$logs = array();
			foreach ($result->result() AS $log) {
			
				$user = $this->db->query("SELECT * FROM `users` WHERE `uid` = '" . $log->uid . "'")->row();
				array_push($logs, array('username' => $user->username, 'action' => $log->action, 'timestamp' => date('m/d/Y g:i:sa', $log->timestamp)));
				
			}
			
			return $logs;
			
		} else {
		
			return FALSE;
			
		}
	
	}

}

?>