<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends CI_Controller {

	var $menu_select = array(
		'dashboard' => false,
		'categories' => false,
		'products' => false,
		'featured' => false,
		'customers' => false,
		'orders' => false,
		'payments' => false,
		'cms' => false,
		'contacts' => true,
		'countries' => false,
		'states' => false,
		'cities' => false
	);
	
	//constructor
	public function __construct()
	{
		parent:: __construct();		
		$this->load->model('mcontact','CONTACT',TRUE);
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
		$this->load->view('admin/contacts/index',$data);
	}
	
	public function pages()
	{
		$data = array();
		$limit = $this->input->get('iDisplayLength');
		$skip = $this->input->get('iDisplayStart');
		$search = $this->input->get('sSearch');
		$sort = $this->input->get('sSortDir_0');
		$column = array("serial_no","email","contact_no","name","created","id");
		$colNo = $this->input->get('iSortCol_0');
		$sortCol = $column[$colNo];
		if($search != "")
		{	
			$count = $this->CONTACT->count_contact($search);			
			$data['aaData'] = $this->CONTACT->search_contacts($search,$skip,$limit,$sort,$sortCol);
		}
		else
		{
			$count = $this->CONTACT->count_contact();			
			$data['aaData'] = $this->CONTACT->get_contacts($skip,$limit,$sort,$sortCol);
		}		
		$data['iTotalRecords'] = $count;
		$data['iTotalDisplayRecords'] = $count;
		$data['sEcho']	= $this->input->post("sEcho");
		$i = 1;
		foreach($data['aaData'] as $key => $val)
		{
			$data['aaData'][$key]['serial_no'] = $i;
			$data['aaData'][$key]['datetime'] = date('Y-m-d h:i A',strtotime($val['created']));
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
		$this->CONTACT->update($update,$id);
		$data['status'] = "1";
		echo json_encode($data);
		exit;
	}
	
	public function view($id)
	{
		$data['logged_admin'] = $this->session->userdata('logged_admin');
		$data['menu_select'] = $this->menu_select;
		$data['id'] = $id;		
		$data['contacts'] = $this->CONTACT->contact_by_id($id);
		$this->load->view('admin/contacts/view',$data);
	}
	
	
}
/* End of file login.php */
/* Location: ./application/controllers/admin/customer.php */
