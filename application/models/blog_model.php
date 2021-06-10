<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {

	public function blog_list()
	{
		$sql = "SELECT id,blog_title,blog_description,image,user_id FROM tbl_blogs ORDER BY id DESC";

		$blog_list_data = $this->db->query($sql)->result_array();

		return $blog_list_data;
	}

	public function single_blog($blog_id=0)
	{
		$sql = "SELECT id,blog_title,blog_description,image,user_id FROM tbl_blogs WHERE id=?";

		$blog_list_data = $this->db->query($sql,array($blog_id))->result_array();

		return $blog_list_data;
	}

	public function delete_blog($blog_id=0){
		$response = array();
		if($blog_id>0){

			$sql = "SELECT user_id FROM tbl_blogs WHERE id=?";

			$blog_data = $this->db->query($sql,array($blog_id))->result_array();

			if($blog_data && $blog_data[0]['user_id']==$this->session->userdata("id")){
				$this->db->delete('tbl_blogs',array('id'=>$blog_id));
				$response['affected_id'] = $this->db->affected_rows();
			}else{
				$this->session->set_flashdata('error_msg', 'Blog does not belongs to you.');
			}
		}else{
			$this->session->set_flashdata('error_msg', 'Error occured,Try again.');
		}
		return $response;

	}

	public function submit_blog($blog_array=array(),$blog_id=0){
		$response = array();
		if($blog_id>0){
			$sql = "SELECT user_id FROM tbl_blogs WHERE id=?";

			$blog_data = $this->db->query($sql,array($blog_id))->result_array();

			if($blog_data && $blog_data[0]['user_id']==$this->session->userdata("id")){
				$blog_array['updated_on'] = date('Y-m-d H:i:s');

				$this->db->update('tbl_blogs',$blog_array,array('id'=>$blog_id));
				$response['affected_id'] = $this->db->affected_rows();
			}
		}else{
			$blog_array['user_id'] = $this->session->userdata("id");
			$this->db->insert('tbl_blogs', $blog_array);
			$response['affected_id'] = $this->db->insert_id();
		}
		return $response;

	}
}
