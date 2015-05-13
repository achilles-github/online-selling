<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends CI_Controller {

	var $menu_select = array(
		'dashboard' => false,
		'categories' => false,
		'products' => true,
		'featured' => false,
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
		$this->load->view('admin/products/index',$data);
	}
	
	public function pages()
	{
		$data = array();
		$limit = $this->input->get('iDisplayLength');
		$skip = $this->input->get('iDisplayStart');
		$search = $this->input->get('sSearch');
		$sort = $this->input->get('sSortDir_0');
		$column = array("serial_no","categories.cat_name","products.name","products.quantity","products.price","products.created","products.id");
		$colNo = $this->input->get('iSortCol_0');
		$sortCol = $column[$colNo];
		if($search != "")
		{	
			$count = $this->PRODUCT->count_products($search);			
			$data['aaData'] = $this->PRODUCT->search_products($search,$skip,$limit,$sort,$sortCol);
		}
		else
		{
			$count = $this->PRODUCT->count_products();			
			$data['aaData'] = $this->PRODUCT->get_products($skip,$limit,$sort,$sortCol);
		}		
		$data['iTotalRecords'] = $count;
		$data['iTotalDisplayRecords'] = $count;
		$data['sEcho']	= $this->input->post("sEcho");
		$i = 1;
		foreach($data['aaData'] as $key => $val)
		{
			$data['aaData'][$key]['serial_no'] = $i;
			$data['aaData'][$key]['datetime'] = date('Y-m-d h:i A',strtotime($val['created']));
			$data['aaData'][$key]['quantity'] = $val['quantity']." ".$val['units'];
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
		if($product_count > 0)
		{
			$data['status'] = "0";
			$data['message'] = "Order has already been placed on this product.To delete the product you must remove products from the orders first.";
		}
		else
		{
			$update = array('isdeleted' => '1');
			$this->PRODUCT->update($update,$id);
			$data['status'] = "1";
		}
		echo json_encode($data);
		exit;
	}
	public function change_status()
	{
		$data = array();
		$id = $this->input->post("id");
		$product = $this->PRODUCT->product_by_id($id);
		if($product['isenabled'] == "1")
		{
			$update['isenabled'] = "0";
			$data['status'] = "0";
			$this->PRODUCT->update($update,$id);
		}
		else
		{
			$update['isenabled'] = "1";
			$data['status'] = "1";
			$this->PRODUCT->update($update,$id);
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
			$update['name'] = $this->input->post("name");
			$update['category_id'] = $this->input->post("category_id");
			$update['description'] = $this->input->post("description");
			$update['price'] = $this->input->post("price");
			$update['quantity'] = $this->input->post("quantity");
			$update['units'] = $this->input->post("units");
			$update['discount'] = $this->input->post("discount");
			//$update['datetime'] = date('Y-m-d H:i:s');
			//$update['isdeleted'] = "0";
			$img = $this->input->post('old_image');
			$image = Common::upload_image($_FILES['image']['name']);			
			$msg = "";
			if($image['status'] == false)
			{
				//$update['img'] = NULL;
				$msg = $image['error'];
			}
			else
			{
				Common::remove_file(FCPATH."upload/products/",$img);
				Common::remove_file(FCPATH."upload/products/thumb/",$img);
				$update['image'] = $image['status'];
			}
			
			$this->PRODUCT->update($update,$id);
			$this->session->set_flashdata('msg',"Product successfully Updated ".$msg);
			//print_r($_FILES['image']);exit;
			redirect('admin/products', 'refresh');
		}
		$data['categories'] = $this->CATEGORY->all_categories();
		$data['products'] = $this->PRODUCT->product_by_id($id);
		$this->load->view('admin/products/edit',$data);
	}
	public function add()
	{
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		
		if($this->input->post(null))
		{
			$insert['name'] = $this->input->post("name");
			$insert['created'] = date('Y-m-d H:i:s');
			$insert['isdeleted'] = "0";
			$insert['isenabled'] = "1";
			$insert['category_id'] = $this->input->post("category_id");
			$insert['description'] = $this->input->post("description");
			$insert['price'] = $this->input->post("price");
			$insert['quantity'] = $this->input->post("quantity");
			$update['units'] = $this->input->post("units");
			$update['discount'] = $this->input->post("discount");
			$image = Common::upload_image($_FILES['image']['name']);
			
			$msg = "";
			if($image['status'] == false)
			{
				$insert['image'] = NULL;
				$msg = $image['error'];
			}
			else
			{
				$insert['image'] = $image['status'];
			}
			
			$this->PRODUCT->insert($insert);
			$this->session->set_flashdata('msg',"Product successfully Added ".$msg);
			//print_r($_FILES['image']);exit;
			redirect('admin/products', 'refresh');
		}
		$data['categories'] = $this->CATEGORY->all_categories();
		$this->load->view('admin/products/add',$data);
	}
	
}
/* End of file login.php */
/* Location: ./application/controllers/admin/dashboard.php */
