<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

	var $menu_select = array(
		'dashboard' => false,
		'categories' => false,
		'products' => false,
		'featured' => false,
		'customers' => false,
		'orders' => false,
		'payments' => false,
		'cms' => true,
		'contacts' => false,
		'countries' => false,
		'states' => false,
		'cities' => false
	);
	
	//constructor
	public function __construct()
	{
		parent:: __construct();		
		$this->load->model('mcms','CMS',TRUE); 		
	}
	
	/**
	 * index page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://yoursitename.com/admin/cms
	 *	
	 */
	public function index()
	{
		$this->_check_logged_in();
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		$id = "1";
		if($this->input->post(null))
		{
			$update['about_us'] = $this->input->post("aboutus");
			$update['policies'] = $this->input->post("policy");
			$this->CMS->update($update,$id);
			$this->session->set_flashdata('msg',"CMS successfully Updated ");
			//print_r($_FILES['image']);exit;
			redirect('admin/cms', 'refresh');
		}
		$data['cms'] = $this->CMS->get_cms($id);
		$this->load->view('admin/cms',$data);
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
