<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	var $menu_select = array(
		'dashboard' => true,
		'categories' => false,
		'products' => false,
		'featured' => false,
		'customers' => false,
		'orders' => false,
		'payments' => false,
		'cms' => false,
		'contacts' => false,
		'countries' => false,
		'states' => false,
		'cities' => false
	);
	
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
	 * 		http://yoursitename.com/admin/dashboard
	 *	
	 */
	public function index()
	{
		$this->_check_logged_in();
		//print_r($this->menu_select);exit;
		$data['menu_select'] = $this->menu_select;
		$data['profile'] = $this->madmin->get_profile();
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$this->load->view('admin/dashboard',$data);
	}
	/*update the profile information of admin*/
	public function edit_profile()
	{
		if($this->input->post(null))
		{
			$data['firstname'] = $this->input->post("first_name");
			$data['lastname'] = $this->input->post("last_name");
			$data['email'] = $this->input->post("email");
			$data['username'] = $this->input->post("username");
			if($this->input->post("change_password"))
			{
				$data['password'] = $this->input->post("password");
			}
			$id = $this->input->post("user_id");
			$return = $this->madmin->update_profile($data,$id);
		}
		redirect('admin/dashboard', 'refresh');
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
/* Location: ./application/controllers/admin/dashboard.php */
