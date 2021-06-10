<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('session');
	}

	public function user_login()
	{
		$data['title'] = 'Login';
		$this->load->view('user_login',$data);
	}

	public function user_signup()
	{
		$data['title'] = 'Sign up';
		$this->load->view('user_signup',$data);
	}

	public function submit_login(){
		$user_login=array(
			'email'=>$this->input->post('user_email'),
			'password'=>md5($this->input->post('password'))

		);
		$data['users']=$this->user_model->login_user($user_login);

		if($data['users']){
			$this->session->set_userdata('id',$data['users'][0]['id']);
			$this->session->set_userdata('user_email',$data['users'][0]['email']);
			//redirect();
			$response['status'] = true;
			$response['redirect_url'] = base_url();
		}else{
			$data['title'] = 'Login';
        	$this->session->set_flashdata('error_msg', 'Error occured,Try again.');
        	$redirect_url = base_url('user/user_login');
      		//redirect($redirect_url,$data);
      		$response['status'] = false;
			$response['redirect_url'] = $redirect_url;
     	}

     	echo json_encode($response);exit;
     	return $response;
	}

	public function submit_signup(){

		$user=array(
			'fname'=>$this->input->post('fname'),
			'lname'=>$this->input->post('lname'),
			'email'=>$this->input->post('user_email'),
			'password'=>md5($this->input->post('password')),
			'added_on' => date('Y-m-d H:i:s'),
		);

		$email_check=$this->user_model->email_check($user['email']);

		if($email_check){
			$this->user_model->register_user($user);
			$this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');
			//redirect('user/user_login');
			$response['status'] = true;
			$redirect_url = base_url('user/user_login');
			$response['redirect_url'] = $redirect_url;
		}
		else{
			$this->session->set_flashdata('error_msg', 'Error occured,Try again.');
			//redirect('user');
			$response['status'] = false;
			$redirect_url = base_url('user/user_signup');
			$response['redirect_url'] = $redirect_url;
		}
		echo json_encode($response);exit;

	}

	public function user_logout(){

		$this->session->sess_destroy();
		redirect('user/user_login');
	}

}

?>

