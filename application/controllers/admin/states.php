<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

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
		'states' => true,
		'cities' => false
	);
	
	//constructor
	public function __construct()
	{
		parent:: __construct();		
		$this->load->model('mstate','STATE',TRUE);
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
		$this->load->view('admin/states/index',$data);
	}
	
	public function pages()
	{
		$data = array();
		$limit = $this->input->get('iDisplayLength');
		$skip = $this->input->get('iDisplayStart');
		$search = $this->input->get('sSearch');
		$sort = $this->input->get('sSortDir_0');
		$column = array("serial_no","states.state_name","states.tax","countries.country_name","states.id");
		$colNo = $this->input->get('iSortCol_0');
		$sortCol = $column[$colNo];
		if($search != "")
		{	
			$count = $this->STATE->count_states($search);			
			$data['aaData'] = $this->STATE->search_states($search,$skip,$limit,$sort,$sortCol);
		}
		else
		{
			$count = $this->STATE->count_states();			
			$data['aaData'] = $this->STATE->get_states($skip,$limit,$sort,$sortCol);
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
		$product_count = $this->STATE->count_cities($id);
		if($product_count > 0)
		{
			$data['status'] = "0";
			$data['message'] = "To delete this state you must first remove all the cities under it.";
		}
		else
		{
			$update = array('isdeleted' => '1');
			$this->STATE->update($update,$id);
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
			$update['state_name'] = $this->input->post("name");
			$update['country_id'] = $this->input->post("country_id");
			$update['tax'] = $this->input->post("tax");
			
			//$update['datetime'] = date('Y-m-d H:i:s');
			//$update['isdeleted'] = "0";
			
			$this->STATE->update($update,$id);
			$this->session->set_flashdata('msg',"State successfully Updated ".$msg);
			//print_r($_FILES['image']);exit;
			redirect('admin/states', 'refresh');
		}
		$data['countries'] = $this->STATE->all_countries();
		$data['states'] = $this->STATE->state_by_id($id);
		$this->load->view('admin/states/edit',$data);
	}
	public function add()
	{
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		
		if($this->input->post(null))
		{
			$insert['state_name'] = $this->input->post("name");
			$insert['isdeleted'] = "0";		
			$insert['country_id'] = $this->input->post("country_id");
			$insert['tax'] = $this->input->post("tax");
			
			
			$this->STATE->insert($insert);
			$this->session->set_flashdata('msg',"State successfully Added ".$msg);
			//print_r($_FILES['image']);exit;
			redirect('admin/states', 'refresh');
		}
		$data['countries'] = $this->STATE->all_countries();
		$this->load->view('admin/states/add',$data);
	}
	
}
/* End of file login.php */
/* Location: ./application/controllers/admin/dashboard.php */
