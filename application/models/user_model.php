<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function login_user($data=array()){

		$this->db->select('*');
		$this->db->from('tbl_users');

		$this->db->where($data);

		if($query=$this->db->get())
		{
			return $query->result_array();
		}
		else{
			return false;
		}
	}

	public function register_user($user){


		$this->db->insert('tbl_users', $user);

	}


	public function email_check($email){

		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('email',$email);
		$query=$this->db->get();

		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}

	}


}


?>
