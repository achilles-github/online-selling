<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Featured_products extends CI_Controller {

	var $menu_select = array(
		'dashboard' => false,
		'categories' => false,
		'products' => false,
		'featured' => true,
		'customers' => false,
		'orders' => false,
		'payments' => false,
		'cms' => false
	);
	
	//constructor
	public function __construct()
	{
		parent:: __construct();		
		$this->load->model('mproduct','PRODUCT',TRUE);
		$this->load->model('mcategory','CATEGORY',TRUE);
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
		$this->load->view('admin/featured_products/index',$data);
	}
	
	public function pages()
	{
		$data = array();
		$limit = $this->input->get('iDisplayLength');
		$skip = $this->input->get('iDisplayStart');
		$search = $this->input->get('sSearch');
		$sort = $this->input->get('sSortDir_0');
		$column = array("serial_no","categories.cat_name","products.name","products.feature_date","products.id");
		$colNo = $this->input->get('iSortCol_0');
		$sortCol = $column[$colNo];
		if($search != "")
		{	
			$count = $this->PRODUCT->count_featured_products($search);			
			$data['aaData'] = $this->PRODUCT->search_featured_products($search,$skip,$limit,$sort,$sortCol);
		}
		else
		{
			$count = $this->PRODUCT->count_featured_products();			
			$data['aaData'] = $this->PRODUCT->get_featured_products($skip,$limit,$sort,$sortCol);
		}		
		$data['iTotalRecords'] = $count;
		$data['iTotalDisplayRecords'] = $count;
		$data['sEcho']	= $this->input->post("sEcho");
		$i = 1;
		foreach($data['aaData'] as $key => $val)
		{
			$data['aaData'][$key]['serial_no'] = $i;
			$data['aaData'][$key]['datetime'] = date('Y-m-d h:i A',strtotime($val['feature_date']));
			$data['aaData'][$key]['status'] = array("id" => $val['id'],"status" => $val['isenabled']);
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
		$product_count = $this->PRODUCT->count_orders($id);
		$update = array('isfeatured' => '0','feature_date' => NULL);
		$this->PRODUCT->update($update,$id);
		$data['status'] = "1";
		echo json_encode($data);
		exit;
	}
	
	public function add()
	{
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;		
		if($this->input->post(null))
		{
			$id = $this->input->post("id");
			$update['isfeatured'] = "1";
			$update['feature_date'] = date('Y-m-d H:i:s');			
			$this->PRODUCT->update($update,$id);
			$this->session->set_flashdata('msg',"Featured Product successfully Added ");
			redirect('admin/featured_products', 'refresh');
		}		
		$this->load->view('admin/featured_products/add',$data);
	}
	public function search_products()
	{
		$search = $this->input->get("term");
		$sortCol = "products.name";
		$sort = "asc";
		$skip = 0;
		$limit = 10;
		$data = array();
		$products = $this->PRODUCT->search_products($search,$skip,$limit,$sort,$sortCol);
		foreach($products as $key => $val)
		{
			$data[] = array( "id" => $val['id'], "label" => $val['name'], "value" => $val['name']);
		}
		echo json_encode($data);
		exit;
	}
}
/* End of file login.php */
/* Location: ./application/controllers/admin/featured_products.php */
