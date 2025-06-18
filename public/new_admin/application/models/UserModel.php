<?php

class UserModel extends CI_Model{

	public function __construct() {
        parent::__construct();
	}

	function cek_username($username) {
		return $this->db->get_where('user', array('username' => $username))->row();
	}
 
	function register($params) {
		$username = $params['username'];
		$password = $params['password'];
		$idvilla = $params['idvilla'];
		$role_id = $params['roleid'];
		$data_user = array(
			'username'=>$username,
			'password'=>password_hash($password,PASSWORD_DEFAULT),
			'role_id'=>$role_id,
			'villa_id'=>$idvilla
		);		
		if ($this->db->insert('user',$data_user)) {
			return true;
		} else {
			return false;
		}
	}
 
	function login_user($username,$password) {
        $query = $this->db->get_where('user',array('username'=>$username));
        if($query->num_rows() > 0) {
            $data_user = $query->row();
            if (password_verify($password, $data_user->password)) {
				$this->session->set_userdata('id_user', $data_user->id);
                $this->session->set_userdata('username',$username);
				$this->session->set_userdata('villa_id',$data_user->villa_id);
				$this->session->set_userdata('role_id',$data_user->role_id);
				$this->session->set_userdata('is_login',TRUE);
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
	}
	
}