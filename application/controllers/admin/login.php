<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	//constructor
	public function __construct()
	{
		parent:: __construct();		
		$this->load->model('madmin','',TRUE); 		
	}
	
	/**
	 * index page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://yoursitename.com/admin/login
	 *	
	 */
	public function index()
	{
		
		$this->load->view('admin/login');
	}
	
	/* verifying the password and username given is valid or not */
	public function verify(){
		if($this->input->post(null)){
		    if($this->madmin->verify_login()){
		        redirect('admin/dashboard', 'refresh');
		    }else{
		        $this->session->set_flashdata('msg', 'Either username or password is incorrect !');
		        redirect('admin/login', 'refresh');
		    }
		}else{
		    $this->session->set_flashdata('msg', 'Please login to continue !');
		    redirect('admin/login', 'refresh');
		}
	}
    	
    	/* logout of admin section */
	public function logout(){
		$this->session->sess_destroy();
		redirect('admin/login', 'refresh');
	}
	
	/*function to check whether logged in or not */
	private function _check_logged_in(){
		if(!$this->session->userdata('logged_admin')){
		    $this->session->set_flashdata('msg', 'Please login to continue !');
		    redirect('admin/login', 'refresh');
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/admin/login.php */
