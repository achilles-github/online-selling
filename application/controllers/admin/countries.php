<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Countries extends CI_Controller {

	var $menu_select = array(
		'dashboard' => false,
		'categories' => false,
		'products' => false,
		'featured' => false,
		'customers' => false,
		'orders' => false,
		'payments' => false,
		'cms' => false,
		'contacts' => false,
		'countries' => true,
		'states' => false,
		'cities' => false
	);
	
	//constructor
	public function __construct()
	{
		parent:: __construct();		
		$this->load->model('mcountry','COUNTRY',TRUE);
		$this->load->library('Common'); 		
	}
	
	/**
	 * index page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://yoursitename.com/admin/categories
	 *	
	 */
	public function index()
	{
		$this->_check_logged_in();
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		$this->load->view('admin/countries/index',$data);
	}
	
	public function pages()
	{
		$data = array();
		$limit = $this->input->get('iDisplayLength');
		$skip = $this->input->get('iDisplayStart');
		$search = $this->input->get('sSearch');
		$sort = $this->input->get('sSortDir_0');
		$column = array("serial_no","country_name","id");
		$colNo = $this->input->get('iSortCol_0');
		$sortCol = $column[$colNo];
		if($search != "")
		{	
			$count = $this->COUNTRY->count_countries($search);			
			$data['aaData'] = $this->COUNTRY->search_countries($search,$skip,$limit,$sort,$sortCol);
		}
		else
		{
			$count = $this->COUNTRY->count_countries();			
			$data['aaData'] = $this->COUNTRY->get_countries($skip,$limit,$sort,$sortCol);
		}		
		$data['iTotalRecords'] = $count;
		$data['iTotalDisplayRecords'] = $count;
		$data['sEcho']	= $this->input->post("sEcho");
		$i = 1;
		foreach($data['aaData'] as $key => $val)
		{
			$data['aaData'][$key]['serial_no'] = $i;
			$i++;
		}
		echo json_encode($data);
		exit;
	}
	/*function to check whether logged in or not */
	private function _check_logged_in(){
		if(!$this->session->userdata('logged_admin')){
		    $this->session->set_flashdata('msg', 'Please login to continue !');
		    redirect('admin/login', 'refresh');
		}
	}
	public function delete()
	{
		$data = array();
		$id = $this->input->post("id");
		$state_count = $this->COUNTRY->count_states($id);
		if($state_count > 0)
		{
			$data['status'] = "0";
			$data['message'] = "Country cannot be deleted as it has states present under it.";
		}
		else
		{
			$update = array('isdeleted' => '1');
			$this->COUNTRY->update($update,$id);
			$data['status'] = "1";
		}
		echo json_encode($data);
		exit;
	}
	public function edit($id)
	{
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		$data['id'] = $id;
		if($this->input->post(null))
		{
			$update['country_name'] = $this->input->post("name");
			$this->COUNTRY->update($update,$id);
			$this->session->set_flashdata('msg',"Country successfully Updated");
			//print_r($_FILES['image']);exit;
			redirect('admin/countries', 'refresh');
		}
		$data['countries'] = $this->COUNTRY->country_by_id($id);
		$this->load->view('admin/countries/edit',$data);
	}
	public function add()
	{
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		
		if($this->input->post(null))
		{
			$insert['country_name'] = $this->input->post("name");						
			$this->PRODUCT->insert($insert);
			$this->session->set_flashdata('msg',"Country successfully Added");
			//print_r($_FILES['image']);exit;
			redirect('admin/countries', 'refresh');
		}
		$this->load->view('admin/countries/add',$data);
	}
	
}
/* End of file login.php */
/* Location: ./application/controllers/admin/dashboard.php */
