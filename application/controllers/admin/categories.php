<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends CI_Controller {

	var $menu_select = array(
		'dashboard' => false,
		'categories' => true,
		'products' => false,
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
		$this->load->model('mcategory','CATEGORY',TRUE); 		
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
		$this->load->view('admin/categories/index',$data);
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
			$count = $this->CATEGORY->count_categories($search);			
			$data['aaData'] = $this->CATEGORY->search_categories($search,$skip,$limit,$sort,$sortCol);
		}
		else
		{
			$count = $this->CATEGORY->count_categories();			
			$data['aaData'] = $this->CATEGORY->get_categories($skip,$limit,$sort,$sortCol);
		}		
		$data['iTotalRecords'] = $count;
		$data['iTotalDisplayRecords'] = $count;
		$data['sEcho']	= $this->input->post("sEcho");
		$i = 1;
		foreach($data['aaData'] as $key => $val)
		{
			$data['aaData'][$key]['serial_no'] = $i;
			$data['aaData'][$key]['datetime'] = date('Y-m-d h:i A',strtotime($val['datetime']));
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
		$product_count = $this->CATEGORY->count_products($id);
		if($product_count > 0)
		{
			$data['status'] = "0";
			$data['message'] = "To delete the category you must first remove the products under it.";
		}
		else
		{
			$update = array('isdeleted' => '1');
			$this->CATEGORY->update($update,$id);
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
				$this->remove_file(FCPATH."upload/categories/",$img);
				$this->remove_file(FCPATH."upload/categories/thumb/",$img);
				$update['img'] = $image['status'];
			}
			
			$this->CATEGORY->update($update,$id);
			$this->session->set_flashdata('msg',"Categories successfully Updated ".$msg);
			//print_r($_FILES['image']);exit;
			redirect('admin/categories', 'refresh');
		}
		$data['categories'] = $this->CATEGORY->category_by_id($id);
		$this->load->view('admin/categories/edit',$data);
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
			
			$this->CATEGORY->insert($insert);
			$this->session->set_flashdata('msg',"Categories successfully Added ".$msg);
			//print_r($_FILES['image']);exit;
			redirect('admin/categories', 'refresh');
		}
		$this->load->view('admin/categories/add',$data);
	}
	private function upload_image($filename = NULL)
	{
		if($filename)
		{
			$image_name = str_replace(" ","",$filename);
			$image_name = time().$image_name;
			$this->load->library('upload');
			$config['upload_path'] = './upload/categories/';
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
				$configThumb['new_image'] = "./upload/categories/thumb/".$uploadedDetails['file_name'];
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
