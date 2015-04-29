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
		$column = array("serial_no","cat_name","datetime","id");
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
			$data['aaData'][$key]['datetime'] = date('Y-m-d h:i A',strtotime($val['datetime']));
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
		if($product['status'] == "1")
		{
			$update['status'] = "0";
			$data['status'] = "0";
			$this->PRODUCT->update($update,$id);
		}
		else
		{
			$update['status'] = "1";
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
			$update['cat_name'] = $this->input->post("name");
			//$update['datetime'] = date('Y-m-d H:i:s');
			//$update['isdeleted'] = "0";
			$img = $this->input->post('old_image');
			$image = $this->upload_image($_FILES['image']['name']);			
			$msg = "";
			if($image['status'] == false)
			{
				//$update['img'] = NULL;
				$msg = $image['error'];
			}
			else
			{
				$this->remove_file(FCPATH."upload/products/",$img);
				$this->remove_file(FCPATH."upload/products/thumb/",$img);
				$update['img'] = $image['status'];
			}
			
			$this->PRODUCT->update($update,$id);
			$this->session->set_flashdata('msg',"Product successfully Updated ".$msg);
			//print_r($_FILES['image']);exit;
			redirect('admin/products', 'refresh');
		}
		$data['products'] = $this->PRODUCT->product_by_id($id);
		$this->load->view('admin/products/edit',$data);
	}
	public function add()
	{
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		
		if($this->input->post(null))
		{
			$insert['cat_name'] = $this->input->post("name");
			$insert['datetime'] = date('Y-m-d H:i:s');
			$insert['isdeleted'] = "0";
			$image = $this->upload_image($_FILES['image']['name']);
			
			$msg = "";
			if($image['status'] == false)
			{
				$insert['img'] = NULL;
				$msg = $image['error'];
			}
			else
			{
				$insert['img'] = $image['status'];
			}
			
			$this->PRODUCT->insert($insert);
			$this->session->set_flashdata('msg',"Product successfully Added ".$msg);
			//print_r($_FILES['image']);exit;
			redirect('admin/products', 'refresh');
		}
		$this->load->view('admin/products/add',$data);
	}
	private function upload_image($filename = NULL)
	{
		if($filename)
		{
			$image_name = str_replace(" ","",$filename);
			$image_name = time().$image_name;
			$this->load->library('upload');
			$config['upload_path'] = './upload/products/';
			$config['file_name'] = $image_name;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG|GIF';
			$config['max_width'] = '5000';
			$config['max_height'] = '5000';
			//echo (1920*1280)/1024/1024;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload("image")){
				$error = $this->upload->display_errors(); 
				
				return array('error' => "<span class='error_block'>".$error."</span>", 'status' => false);
				//echo $error;
			} 
			else 
			{
				$uploadedDetails    = $this->upload->data();
				$image['image'] = $uploadedDetails['file_name'];
			  
				$this->load->library('image_lib');
				$configThumb = array();  
				$configThumb['maintain_ratio'] = FALSE;
				$configThumb['image_library']   = 'gd2';  
				$configThumb['source_image']    = $uploadedDetails['full_path'];
				$configThumb['quality'] = "100%";	
				$configThumb['new_image'] = "./upload/products/thumb/".$uploadedDetails['file_name'];
				$configThumb['width']           = 150;  
				$configThumb['height']          = 150;  
				$this->image_lib->initialize($configThumb);
				$this->image_lib->resize();
				return array('error' => "", 'status' => $uploadedDetails['file_name']);
			}
		}
		else
		{
			return array('error' => "", 'status' => false);
		}
       }
       private function remove_file($folder,$image_name) 
       { 
		$folder_url = $folder;
		//$rel_url = $folder;
		if(file_exists($folder_url.$image_name)) 
		{
			
			@unlink($folder_url.$image_name);
		}
	}
}
/* End of file login.php */
/* Location: ./application/controllers/admin/dashboard.php */
