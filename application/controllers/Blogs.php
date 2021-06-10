<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller {

	public function index()
	{
		$action = $single_blog_row = '';
		$this->load->model('blog_model');
		$data['title'] = 'Blog List';

		$blog_listing = $this->blog_model->blog_list();

		foreach ($blog_listing as $key => $value) {
			$image_tag = '<img src="'.base_url('upload/').$value['image'].'" width="50px" height="50px">';

			if(strlen($value['blog_description'])>100){
				$blog_description_short = substr($value['blog_description'], 0, 100).'...';
			}else{
				$blog_description_short = $value['blog_description'];
			}

			if($this->session->userdata("id")!=NULL && $this->session->userdata("id")==$value['user_id']){
				$encrypted_id = base64_encode($value['id']);
				$edit_url = base_url('blogs/blog_form?id='.$encrypted_id);
				$delete_url = base_url('blogs/delete_blog/?id='.$encrypted_id);
				$action = '<a href="'.$edit_url.'" class="btn btn-primary">Edit</a>&nbsp';
				$action .= '<a href="'.$delete_url.'" class="btn btn-danger">Delete</a>';
			}
			$single_blog_row .= '<tr>
									<th>'.$image_tag.'</th>
									<th>'.$value['blog_title'].'</th>
									<th>'.$value['blog_description'].'</th>
									<th>'.$blog_description_short.'</th>
									<th>'.$action.'</th>
								</tr>';
		}

		$data['blog_listing'] = $single_blog_row;

		$this->load->view('blog_list',$data);
	}

	public function delete_blog() {
		$this->load->model('blog_model');

		if($this->input->get('id')!=''){
			$blog_id = base64_decode($this->input->get('id'));
			$data = $this->blog_model->delete_blog($blog_id);
			if(isset($data['affected_id']) && $data['affected_id']>0){
				$this->session->set_flashdata('success_msg', 'Blog deleted successfully.');
				redirect();
			}
		}else{
			//$this->session->set_flashdata('error_msg', 'Error occured,Try again.');
			redirect();
		}
	}

	public function blog_form()
	{
		$this->load->model('blog_model');

		if($this->input->get('id')!=''){
			$blog_id = base64_decode($this->input->get('id'));
			$blog_detail = $this->blog_model->single_blog($blog_id);

			$data['blog_title'] = $blog_detail[0]['blog_title'];
			$data['blog_description'] = $blog_detail[0]['blog_description'];
			$data['id'] = $blog_detail[0]['id'];
			$data['image'] = $blog_detail[0]['image'];
			$data['user_id'] = $blog_detail[0]['user_id'];
		}else{
			$blog_id = 0;
			$data['blog_title'] = '';
			$data['blog_description'] = '';
			$data['id'] = '';
			$data['image'] = '';
			$data['user_id'] = $this->session->userdata("id");
		}

		$data['title'] = ($blog_id>0)?'Edit Blog':'Add Blog';


		$this->load->view('blog_form',$data);
	}

	public function submit_blog_form(){

		$this->load->model('blog_model');

		$blog_id = $this->input->post('blog_id');
		$blog_array=array(
			'blog_title'=>$this->input->post('blog_title'),
			'blog_description'=>$this->input->post('blog_description'),
			'added_on' => date('Y-m-d H:i:s'),
		);

		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'gif|jpg|png';

		$this->load->library('upload',$config);
		if(isset($_FILES['image'])){
			if(file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])){

				if(!$this->upload->do_upload('image')){
					$this->session->set_flashdata('error_msg',$this->upload->display_errors());
				}else{
					$image_data = array('image_metadata'=>$this->upload->data());
					$blog_array['image'] = $image_data['image_metadata']['file_name'];
				}
			}
		}


		$affected_id=$this->blog_model->submit_blog($blog_array,$blog_id);

		if($affected_id['affected_id']>0){
			$this->session->set_flashdata('success_msg', 'Blog updated successfully.');
			//redirect('user/user_login');
			$response['status'] = true;
			$redirect_url = base_url();
			$response['redirect_url'] = $redirect_url;
		}
		else{
			$this->session->set_flashdata('error_msg', 'Error occured,Try again.');
			//redirect('user');
			$response['status'] = false;
			$redirect_url = base_url();
			$response['redirect_url'] = $redirect_url;
		}
		echo json_encode($response);exit;

	}
}
