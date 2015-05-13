<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends CI_Controller {

	var $menu_select = array(
		'dashboard' => false,
		'categories' => false,
		'products' => false,
		'featured' => false,
		'customers' => true,
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
		$this->load->model('mproduct','PRODUCT',TRUE);
		$this->load->model('mcustomer','CUSTOMER',TRUE);
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
		$this->load->view('admin/customers/index',$data);
	}
	
	public function pages()
	{
		$data = array();
		$limit = $this->input->get('iDisplayLength');
		$skip = $this->input->get('iDisplayStart');
		$search = $this->input->get('sSearch');
		$sort = $this->input->get('sSortDir_0');
		$column = array("serial_no","customers.email","customers.name","customers.address","customers.created","customers.id");
		$colNo = $this->input->get('iSortCol_0');
		$sortCol = $column[$colNo];
		if($search != "")
		{	
			$count = $this->CUSTOMER->count_customers($search);			
			$data['aaData'] = $this->CUSTOMER->search_customers($search,$skip,$limit,$sort,$sortCol);
		}
		else
		{
			$count = $this->CUSTOMER->count_customers();			
			$data['aaData'] = $this->CUSTOMER->get_customers($skip,$limit,$sort,$sortCol);
		}		
		$data['iTotalRecords'] = $count;
		$data['iTotalDisplayRecords'] = $count;
		$data['sEcho']	= $this->input->post("sEcho");
		$i = 1;
		foreach($data['aaData'] as $key => $val)
		{
			$data['aaData'][$key]['serial_no'] = $i;
			$data['aaData'][$key]["address"] = $val["address"].", ".$val["city"]." - ".$val['zip'].", ".$val['state'].", ".$val['country'];
			$data['aaData'][$key]['datetime'] = date('Y-m-d h:i A',strtotime($val['created']));
			$data['aaData'][$key]['status'] = array("id" => $val['id'],"status" => $val['status']);
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
		$product_count = $this->CUSTOMER->count_orders($id);
		if($product_count > 0)
		{
			$data['status'] = "0";
			$data['message'] = "This customer has orders associated with him.Please delete the orders first to delete the customer.";
		}
		else
		{
			$update = array('isdeleted' => '1');
			$this->CUSTOMER->update($update,$id);
			$data['status'] = "1";
		}
		echo json_encode($data);
		exit;
	}
	public function change_status()
	{
		$data = array();
		$id = $this->input->post("id");
		$product = $this->CUSTOMER->customer_by_id($id);
		if($product['status'] == "1")
		{
			$update['status'] = "0";
			$data['status'] = "0";
			$this->CUSTOMER->update($update,$id);
		}
		else
		{
			$update['status'] = "1";
			$data['status'] = "1";
			$this->CUSTOMER->update($update,$id);
		}
		echo json_encode($data);
		exit;
		
	}
	public function view($id)
	{
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		$data['id'] = $id;		
		$data['customers'] = $this->CUSTOMER->customer_by_id($id);
		$this->load->view('admin/customers/view',$data);
	}
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/admin/customer.php */
