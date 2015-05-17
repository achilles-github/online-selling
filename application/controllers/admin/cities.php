<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cities extends CI_Controller {

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
		'countries' => false,
		'states' => false,
		'cities' => true
	);
	
	//constructor
	public function __construct()
	{
		parent:: __construct();		
		$this->load->model('mcity','CITY',TRUE);
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
		$this->load->view('admin/city/index',$data);
	}
	
	public function pages()
	{
		$data = array();
		$limit = $this->input->get('iDisplayLength');
		$skip = $this->input->get('iDisplayStart');
		$search = $this->input->get('sSearch');
		$sort = $this->input->get('sSortDir_0');
		$column = array("serial_no","states.name","cities.name","cities.id");
		$colNo = $this->input->get('iSortCol_0');
		$sortCol = $column[$colNo];
		if($search != "")
		{	
			$count = $this->CITY->count_cities($search);			
			$data['aaData'] = $this->CITY->search_cities($search,$skip,$limit,$sort,$sortCol);
		}
		else
		{
			$count = $this->CITY->count_cities();			
			$data['aaData'] = $this->CITY->get_cities($skip,$limit,$sort,$sortCol);
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
		$update = array('isdeleted' => '1');
		$this->CITY->update($update,$id);
		$data['status'] = "1";
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
			$update['name'] = $this->input->post("name");
			$update['country_id'] = $this->input->post("country_id");
			$update['state_id'] = $this->input->post("state_id");
			$this->CITY->update($update,$id);
			$this->session->set_flashdata('msg',"City successfully Updated ");
			//print_r($_FILES['image']);exit;
			redirect('admin/cities', 'refresh');
		}
		$data['cities'] = $this->CITY->city_by_id($id);
		$data['countries'] = $this->CITY->all_countries();
		$data['states'] = $this->CITY->states_country_id($data['cities']['country_id']);
		$this->load->view('admin/city/edit',$data);
	}
	public function add()
	{
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		
		if($this->input->post(null))
		{
			$insert['name'] = $this->input->post("name");
			$insert['country_id'] = $this->input->post("country_id");
			$insert['state_id'] = $this->input->post("state_id");
			
			$this->CITY->insert($insert);
			$this->session->set_flashdata('msg',"City successfully Added ");
			//print_r($_FILES['image']);exit;
			redirect('admin/cities', 'refresh');
		}
		$data['countries'] = $this->CITY->all_countries();
		$this->load->view('admin/city/add',$data);
	}
	public function get_states()
	{
		$id = $this->input->post("id");
		$data = $this->CITY->states_country_id($id);
		echo json_encode($data);
		exit;
	}
}
/* End of file login.php */
/* Location: ./application/controllers/admin/dashboard.php */
