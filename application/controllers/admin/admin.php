<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller {
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('common','',TRUE);
        $this->load->model('madmin','',TRUE); 
        $this->load->model('song','',TRUE); 
        $this->load->model('cms','',TRUE); 
        $this->load->model('user','',TRUE); 
        $this->load->model('hashtag','',TRUE); 
        $this->load->library('Common_functions');
        //$this->load->model('users','',TRUE);
        //$this->layout->placeholder("title", "The Smarter Place");
        //$this->load->spark('markdown-extra/0.0.0');
    }

    private function _check_logged_in(){
        if(!$this->session->userdata('logged_admin')){
            $this->session->set_flashdata('msg', 'Please login to continue !');
            redirect('admin/', 'refresh');
        }
    }
    
    public function dashboard(){
        $this->_check_logged_in();                  #check the authenticity of the admin
        $data = array();
        $data['user_count'] = $this->user->count_users();
        $data['song_count'] = $this->song->count_songs();
        $data['hashtag_count'] = $this->hashtag->count_hashtags();
        $data['creative_count'] = $this->hashtag->count_creative();
        $this->load->view('admin/dashboard',$data);
        
    }    
    /*public function calender(){
        $this->_check_logged_in();                  #check the authenticity of the admin
        $this->load->view('admin/calender');
    }*/
    
    public function users(){
        $this->_check_logged_in();   #check the authenticity of the admin
		/*pagination start*/
		$this->load->library('pagination');
		$config['base_url']         = base_url().'admin/users/';
		$config['total_rows']       = $this->common->count_json_without_isdeleted('users');
		$config['per_page']         = 8;
		$config["uri_segment"]      = 3;
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['cur_tag_open']     = '<span class="active_page">';
		$config['cur_tag_close']    = '</span>';
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		if($this->uri->segment(3)) 
		{ 
			$data['user_arr'] = $this->common->get_json_without_isdeleted('users','',$this->uri->segment(3));
		} 
		else 
		{ 
			$data['user_arr'] = $this->common->get_json_without_isdeleted('users');
		}
		/*pagination ends*/
        $this->load->view('admin/users',$data);  
    }
	
    public function sample_muse() {
        $data['user_arr'] = $this->song->get_sample_muse_without_isdeleted('songs');
        $this->load->view('admin/sample_muse',$data);  
    }
	
    public function edit_sample_muse($id) 
    {
        $this->_check_logged_in();  #check the authenticity of the admin
        if($this->input->post()){
			$muse = array();
			$muse['caption']     = $this->input->post('caption'); 
			$muse['path']        = $this->input->post('song_link');                        
			$muse['description'] = $this->input->post('text'); 
			$muse['tags']        = $this->input->post('tags');
			$muse['status']      = "1";
			$muse['upload_date'] = date('Y-m-d');
			$muse['created']     = date('Y-m-d');
			$muse['muse_type']   = "1";
			if($_FILES['image']['name']) {
				// Remove image
				$image_name = $this->input->post('hidden_image');
				$this->removeFile($image_name,'upload/sample_muse/');
				$this->removeFile($image_name,'upload/thumb/');
				$muse['image_path'] = $this->movoImage($_FILES['image']['name']);
			}
			$this->common->editRecord('songs',$muse,$this->input->post('id'));
			$this->session->set_flashdata('msg', 'Sample Muse edited successfully !');
			redirect('admin/sample_muse');
        } 
        $muse =  $this->common->getById('songs',$id);
        $data['user'] = $muse[0];
        $data['tags'] = $this->common->get_all_without_isdeleted('hashtags','tags');
        //echo '<pre>'; print_r($data);
        //exit;
        $data['id'] =  $id; 
        $this->load->view('admin/edit_sample_muse',$data);  
    }
	
    public function sample_muse_active() {
        $id = $this->input->post('id',true);
        $data['status']     = $this->input->post('status',true);; 
        $this->song->sample_muse_save('songs',$data,$id);
        header('Content-Type: application/json; charset=utf-8');
	    echo json_encode($data);
	    exit;
    }
	
	public function member_muse() {
	    $this->_check_logged_in();  #check the authenticity of the admin
        
        $this->load->library('pagination');
		$config['base_url']         = base_url().'admin/member_muse/';
		$config['total_rows']       = $this->common->count_json_without_isdeleted_musetype('songs');
		$config['per_page']         = 8;
		$config["uri_segment"]      = 3;
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['cur_tag_open']     = '<span class="active_page">';
		$config['cur_tag_close']    = '</span>';
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		if($this->uri->segment(3)) { 
			$data['user_arr'] = $this->common->get_json_without_isdeleted_musetype('songs','',$this->uri->segment(3));
		} else { 
			$data['user_arr'] = $this->common->get_json_without_isdeleted_musetype('songs');
		}
        $this->load->view('admin/member_muse',$data);  
    }
	
    public function edit_member_muse($id) {
        $this->_check_logged_in();  #check the authenticity of the admin
        
        if($this->input->post()){
			$muse = array();
			$museid = $id;
			$muse_detail = $this->common->getById("songs",$museid);
			//$muse['user_id']     = $user_data['id']; 
			$muse['caption']     = $this->input->post('caption'); 
			$muse['path']        = $this->input->post('song_link');  			
			$tags = array();
			$valid_username = array();
			$valid_userid = array();
			$tagged_user = array();
			$user_data['id'] = $muse_detail[0]['user_id'];
			if($muse['caption'] != "")
			{
			    //$strlen = strlen($muse['caption']);
			    $special_character = "/[^A-Za-z0-9\#\@ ]/";
			    //$string = str_split($muse['caption']);
			    //$count = count($string);
			    $caption = preg_replace($special_character," ",$muse['caption']);
			    //$caption = preg_replace('/"/'," ",$caption);
			    $caption = preg_replace("/\\s/"," ",$caption);
			    $caption = str_replace("  "," ",$caption);
			    $words = explode(" ",trim($caption));
			    foreach($words as $w)
			    {
			        $substring = substr($w,0,1);
			        if($substring == "#" && strlen($w) > 1)
			        {
			            $subtag = explode("#",substr($w,1,strlen($w)));
			            if(count($subtag) > 1)
			            {
			                foreach($subtag as $s)
			                {
			                    $tags[] = "#".$s;
			                }
			            }
			            else
			            {
			                $tags[] = $w;
			            }
			        }
			        if($substring == "@" && strlen($w) > 1)
			        {
			            $tagged_user[] = substr($w,1);
			        }
			    }
			}
			
			$muse['all_tags']     = (count($tags) > 0) ? implode(",",$tags) : "";
			//$muse['muse_type']   = '0';
			if(!empty($_FILES['image']['name'])) {
				
				if(isset($muse_detail[0]['image_path']))
				{
				    $image_name = $muse_detail[0]['image_path'];
                    $folder = "upload/member_muse_thumb/";
                    Common_functions::removeFile($image_name,$folder);
                    $folder = "upload/member_muse/";
                    Common_functions::removeFile($image_name,$folder);
				}
				$muse['image_path'] = $this->memberMoveImage($_FILES['image']['name']);
			}
			$this->common->editRecord('songs',$muse,$museid);
			$new_mise_id = $museid;
			//$this->song->checkcounter('hashtags',$t);
			
			if($new_mise_id) {
				//save data in hashtags table
				
				//echo $new_mise_id;
				$alltags = array();
				if(isset($muse_detail[0]['all_tags']) && $muse_detail[0]['all_tags'] != "")
			    {
			        $alltags = explode(",",$muse_detail[0]['all_tags']);
			    }
				foreach($tags as $t)
			    {
			        //print_r($t);
			        $tag['added_by'] = $user_data['id'];
				    $tag['songs_id'] = $new_mise_id;
				    $tag['tags'] = $t;
				    $tag['created']  = date('Y-m-d');
				    
				    if(!in_array($t,$alltags))
				    {
			            $this->song->addNewHastagCheck('hashtags',$tag);
			        }
			        //$in_tags[] = $
			    }
			    foreach($alltags as $cur_tag)
			    {
			        if(!in_array($cur_tag,$tags))
			        {
			            $in_tags['tags'] = $cur_tag;
			            $this->song->deleteNewHastagCheck('hashtags',$in_tags);
			        }
			    }
				$valid_username = array();
				
					foreach($tagged_user as $uname) {
						//save data in song_tagged_user table
						
						$user_detail = $this->user->get_other_user_info_admin($uname,$user_data['id']);
						
						if(count($user_detail) > 0)
						{
						    $user_is_tagged = $this->user->get_tagged_user_admin($new_mise_id,$user_detail[0]['id'],$user_data['id']);
						    if(count($user_is_tagged) <= 0)
						    {
						        $song_tagged_user['user_id']   = $user_detail[0]['id'];
						        $song_tagged_user['song_id']   = $new_mise_id;
						        $song_tagged_user['upload_by'] = '1';
						        $this->common->addRecord('song_tagged_user',$song_tagged_user);
						        
						    }
						    $valid_username[] = "@".$uname;
						    $valid_userid[] = $user_detail[0]['id'];
						}
						
					}
					
				
				if(count($valid_username) > 0)
				{
				    $userlist = implode(",",$valid_username);
				    $useridlist = implode(",",$valid_userid);
				    $record = array();
				    $record['all_username'] = $userlist; 
				    $record['all_userid'] = $useridlist; 
				    //echo $useridlist;
				    if(isset($muse_detail[0]['all_userid']) && $muse_detail[0]['all_userid'] != "")
				    {
				        $current_users = explode(",",$muse_detail[0]['all_userid']);
				        foreach($current_users as $uid)
				        {
				            if(!in_array($uid,$valid_userid))
				            {
				                $this->user->remove_tagged_user($new_mise_id,$uid);
				            }
				        }
				    }
				    
				    $this->common->editRecord("songs",$record,$new_mise_id);
				}
				else
				{
				    $userlist = "";
				    $useridlist = "";
				}
				
			$this->session->set_flashdata('msg', 'Member Muse edited successfully !');
			redirect('admin/member_muse');
			exit;
        } 
        }
        $muse =  $this->common->getById('songs',$id);
        $data['user'] = $muse[0];
        $data['tags'] = $this->common->get_all_without_isdeleted('hashtags','tags');
        //echo '<pre>'; print_r($data);
        //exit;
        $data['id'] =  $id; 
        $this->load->view('admin/edit_member_muse',$data);  
    }
	
	public function hashtags(){
        $this->_check_logged_in();  #check the authenticity of the admin
        $data['hashtags_arr'] = $this->common->get_hashtaglist('hashtags');
        $this->load->view('admin/hashtags',$data);  
    }
    public function creative(){
        $this->_check_logged_in();  #check the authenticity of the admin
       
         $this->load->library('pagination');
		$config['base_url']         = base_url().'admin/creative/';
		$config['total_rows']       = $this->hashtag->count_creative();
		$config['per_page']         = 20;
		$config["uri_segment"]      = 3;
		$config['next_link']        = 'Next';
		$config['prev_link']        = 'Prev';
		$config['cur_tag_open']     = '<span class="active_page">';
		$config['cur_tag_close']    = '</span>';
		$this->pagination->initialize($config);
		$data['links'] = $this->pagination->create_links();
		//echo $this->uri->segment($config["uri_segment"]);
		if($this->uri->segment($config["uri_segment"])) 
		{ 
		    $data['hashtags_arr'] = $this->common->get_creative_hashtaglist('hashtags',"*",$this->uri->segment($config["uri_segment"]),$config['per_page']);
			//$data['user_arr'] = $this->common->get_json_without_isdeleted_musetype('songs','',$this->uri->segment(3));
		} else { 
		    $data['hashtags_arr'] = $this->common->get_creative_hashtaglist('hashtags');
			//$data['user_arr'] = $this->common->get_json_without_isdeleted_musetype('songs');
		}
        $this->load->view('admin/creative',$data);  
    }
	
	public function edit_hashtag($id) {
        $this->_check_logged_in(); #check the authenticity of the admin
		$muse =  $this->common->getById('hashtags',$id);
		$data['hashtags_arr'] = $muse[0];
		
        if($this->input->post()){
			$tag_data['tags'] = $this->input->post('tagname');
			$this->common->editRecord('hashtags',$tag_data,$this->input->post('id'));
			$this->session->set_flashdata('msg', 'Tag Updated successfully !');
			redirect('admin/hashtags');
        }
        $this->load->view('admin/edit_hashtag',$data);  
    }
	
	public function setting(){
        $this->_check_logged_in();  #check the authenticity of the admin
        $data['setting_arr'] = $this->common->get_setting_data();
        $this->load->view('admin/setting',$data);  
    }
	
	public function edit_setting($id) {
        $this->_check_logged_in(); #check the authenticity of the admin
		$muse =  $this->common->getById('admins',$id);
		$data['setting_arr'] = $muse[0];
		
        if($this->input->post()){
			if($_FILES['background_image']['name']!= ''){
				$file_name = $_FILES['background_image']['name'];
				$image_name = str_replace(" ","",$file_name);
				$upload_file = time().$image_name;
				$upload_target_original = './setting/'.$upload_file;
				move_uploaded_file($_FILES['background_image']['tmp_name'],$upload_target_original);
				$setting_data['background_image_name']  = $upload_file;
			} else {
				$setting_data['background_image_name']  = $this->input->post('hidden_background_image');
			}
			$setting_data['audio_path']  = $this->input->post('audio_file');
			$this->common->editRecord('admins',$setting_data,$this->input->post('id'));
			$this->session->set_flashdata('msg', 'Setting Updated successfully !');
			redirect('admin/setting');
        }
        $this->load->view('admin/edit_setting',$data);  
    }
	
    public function users_list_json(){
        $this->_check_logged_in();
        
        $sTable ='users';
        $aColumns = array( 'name', 'email', 'status', 'created', 'id' ); 
        $sIndexColumn = "id";
          //DebugBreak();
       
     /* 
     * Paging
     */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
        $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
            intval( $_GET['iDisplayLength'] );
    }
    
    
    /*
     * Ordering
     */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) )
    {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
        {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
            {
                $sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
                    ($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
            }
        }
        
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" )
        {
            $sOrder = "";
        }
    }
    
    
    /* 
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            $sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
    
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
    
    
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $aColumns))."`
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
        ";
    $rResult = $this->db->query($sQuery);
      // DebugBreak();    
    /* Data set length after filtering */
    
   $iFilteredTotal = $rResult->num_rows();
   
    
    /* Total data set length */
    $sQuery = "
        SELECT `".$sIndexColumn."`
        FROM   $sTable
    ";
    $rResultTotal = $this->db->query( $sQuery);
    $iTotal = $rResultTotal->num_rows();
   
    
    /*
     * Output
     */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
   $j=0; 
    //while ( $aRow = $rResult->result_array() )
    foreach($rResult->result_array() as $aRow)
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
           
                $row[] = $aRow[ $aColumns[$i] ];
          
        }
        $output['aaData'][] = $row;
        $j++;
    }
    
    echo json_encode( $output ); exit;
          
        
       // $this->load->view('admin/users',$data);  
    }
    
    public function index(){   
        $this->load->view('admin/login');
    }
    
    public function verify_login(){
        if($this->input->post(null)){
            if($this->madmin->verify_login()){
                redirect('admin/dashboard', 'refresh');
            }else{
                $this->session->set_flashdata('msg', 'Either username or password is incorrect !');
                redirect('admin/', 'refresh');
            }
        }else{
            $this->session->set_flashdata('msg', 'Please login to continue !');
            redirect('admin/', 'refresh');
        }
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect('admin/', 'refresh');
    }
    
    public function add_user(){
        $this->_check_logged_in(); 
                   //   DebugBreak();
        if($this->input->post()){
                        
                        $user = array();
                        $user['name']   =     $this->input->post('name');
                     
                        $user['email']         = $this->input->post('email');
                        $user['password']     =   $this->input->post('password');
                        $user['created']     =   date('Y-m-d'); 
                        $user['type']     =   $this->input->post('type');
                        $user['phone']     =   $this->input->post('phone');
                        
                        /*$user['phone']      =   $this->input->post('contact_no');
                        $user['created']     =    time();
                        
                        $user_id = $this->common->addRecord('users',$user);
          
                        $business['user_id']     =   $user_id;
                        $business['business_name']     =   $this->input->post('business_name');
                        $business['service_ids']     = implode(', ',$this->input->post('services_id'));
                        
                        $business['service_area']     =   $this->input->post('service_area');
                        $business['operationg_hours']     =   $this->input->post('operationg_hours');
                        $business['license_number']     =   $this->input->post('license_number');
                        $business['license_state']     =   $this->input->post('license_state');
                        $business['license_expiry']     =   $this->input->post('license_expiry');
                        $business['is_free_estimates']     =   $this->input->post('is_free_estimates');
                        $business['is_discount_to_senior']     =   $this->input->post('is_discount_to_senior');
                        $business['in_business_since']     =   $this->input->post('in_business_since');
                        $business['is_free_warranty_on_work']     =   $this->input->post('is_free_warranty_on_work');
                        $business['is_bonded']     =   $this->input->post('is_bonded');
                        
                        
                        $state = explode(':',$this->input->post('state'));
                        $business['state_id']     =   $state[0];
                        $business['state']     =   $state[1];
                        
                        $city = explode(':',$this->input->post('city'));
                        
                        $business['city_id']     =   $city[0];
                        $business['city']     =   $city[1];
                        
                        $business['zip']     =   $this->input->post('zip');
                        
                        $business['video']     =   $this->input->post('video');
                        $business['business_address']     =   $this->input->post('business_address');
                        $business['contact_no'] =   $this->input->post('business_contact_no');
                        $business['fax'] =   $this->input->post('fax');
                        $business['skill_description']     =   $this->input->post('business_skill');
                        $business['primary_category_id']     =   $this->input->post('category_id');
                        $business['business_descriptions']     =   $this->input->post('business_descriptions');
                        
                        
                        
                        if($_FILES['logo']['name']!= ''){
                            $business['logo']  = $this->movoImage();
                        }
                        
                        if($_FILES['business_document']['name']!= ''){
                            $file_name = $_FILES['business_document']['name'];
                            $upload_file = time().$file_name;
                            $upload_target_original = './business_documents/'.$upload_file;
                            move_uploaded_file($_FILES['business_document']['tmp_name'],$upload_target_original);
                            $business['business_document']  = $upload_file;
                        }  */
                        
                        $provider_id = $this->common->addRecord('users',$user);
                        $this->session->set_flashdata('msg', 'User added successfully !');
                        redirect('admin/users/');
                   }                 #check the authenticity of the admin
        
        
        $this->load->view('admin/add_user');  
    }
    
    public function edit_user($id){
        $this->_check_logged_in(); 
                   //   DebugBreak();
        if($this->input->post()){
                        
                        $user = array();
                        $user['name']   =     $this->input->post('name');
                     
                        $user['email']         = $this->input->post('email');
                        $user['password']     =   $this->input->post('password');
                        
                        $user['type']     =   $this->input->post('type'); 
                        $user['phone']     =   $this->input->post('phone');
                       $this->common->editRecord('users',$user,$this->input->post('id'));
                        $this->session->set_flashdata('msg', 'User added successfully !');
                        redirect('admin/users/');
                   }                 #check the authenticity of the admin
        
        $user =  $this->common->getById('users',$id);
        $data['user'] = $user[0];
        //echo '<pre>'; print_r($data);
        $data['id'] =  $id; 
        $this->load->view('admin/edit_user',$data);  
    }
    
	public function user_block() {
        $user_id = $this->input->post('id',true);
        $user['isblocked']     = $this->input->post('isblocked',true);; 
        $this->common->editRecord('users',$user,$user_id);
        header('Content-Type: application/json; charset=utf-8');
	    echo json_encode($user);
	    exit;
	}
     public function user_status() {
        //print_r($_POST);
        $user_id = $this->input->post('id',true);
        $user['status'] = $this->input->post('isblocked',true);
        $data['status'] = "0";
        //echo  $user['status'];
        //exit;
        if($user['status'] == 1)
        {
            $data['status'] = "1";
        }
        $this->common->editRecord('users',$user,$user_id);	
        $users = $this->user->get_user_data($user_id);
        if($data['status'] == "1")
        {
            $email = $users[0]['email'];
        
        
            $bcc = "info@musemeant.com,shovanik.majumdar@appsbee.com,admin@musemeant.com,aehartigan@gmail.com";
	        
	        $subject = "Account Activated";
	        //$encode_uid = base64_encode($uid);
	        //$encode_lid =  base64_encode($lid);
	        //$url = base_url().'change_password';
	        $from = "info@musemeant.com";
	        
	        $body = "Hi ".$users[0]['first_name'].",<br><br>We are excited to announce that you can now sign in to your Musemeant account!<br> Your Username: <strong>".$users[0]['username']."</strong> and Temporary Password: <strong>".$users[0]['password']."</strong>.  The site will be mobile-friendly and the app will launch next week.<br><br>What's your life soundtrack? Make it memorable.<br><br>The Musemeant Team";
	        $from_name = "The Musemeant Team";	
	        Common_functions::send_mail($email,$from,$subject,$body,$from_name,$bcc);
	    }
        header('Content-Type: application/json; charset=utf-8');
		//Common_functions::send_mail();
		
	    echo json_encode($data);
	    exit;
	}
    public function user_delete() {
        $user_id = $this->input->post('id',true);
        $user['isdeleted']     = '1'; 
        $this->common->editRecord('users',$user,$user_id);
        header('Content-Type: application/json; charset=utf-8');
	    echo json_encode($user);
	    exit;
	}
	
	public function sample_muse_delete() {
		$id = $this->input->post('id',true);
        $data['isdeleted']     = '1'; 
        $this->song->sample_muse_save('songs',$data,$id);
        header('Content-Type: application/json; charset=utf-8');
	    echo json_encode($data);
	    exit;
	}
     
	public function cms_list()  {
		$this->_check_logged_in();  #check the authenticity of the admin
        $data['cms_arr'] = $this->cms->get_cms_list('cms',1);
        $this->load->view('admin/cms_list',$data);
	}
	
	public function edit_cms($id) {
        $this->_check_logged_in(); #check the authenticity of the admin
		$cms =  $this->common->getById('cms',$id);
		$data['cms_arr'] = $cms[0];
		
        if($this->input->post()){
			$cms_data['content'] = $this->input->post('content_text');
			$this->common->editRecord('cms',$cms_data,$this->input->post('id'));
			$this->session->set_flashdata('msg', 'Page Updated successfully !');
			redirect('admin/cms_list');
        }
        $this->load->view('admin/edit_cms',$data);  
    }
	
	 /*public function user_active($user_id)
     {
         $user['status']     = '1'; 
         $this->common->editRecord('users',$user,$user_id);
          redirect('admin/users/');
         
     }
     
     public function user_inactive($user_id)
     {
         $user['status']     = '0'; 
         $this->common->editRecord('users',$user,$user_id);
          redirect('admin/users/');
         
     }*/
    function movoImage($filename = NULL){
        if($filename){
			$image_name = str_replace(" ","",$filename);
			$image_name = time().$image_name;
			$this->load->library('upload');
			$config['upload_path'] = './upload/sample_muse/';
			$config['file_name'] = $image_name;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload("image")){
				$error = $this->upload->display_errors(); 
				$this->session->set_flashdata('errormsg', $error);
			} else {
				$uploadedDetails    = $this->upload->data();
				$image['image'] = $uploadedDetails['file_name'];
			  
				$this->load->library('image_lib');
				$configThumb = array();  
				$configThumb['image_library']   = 'gd2';  
				$configThumb['source_image']    = $uploadedDetails['full_path'];
						
				$configThumb['new_image'] = "./upload/thumb/".$uploadedDetails['file_name'];
				$configThumb['width']           = 180;  
				$configThumb['height']          = 250;  
				$this->image_lib->initialize($configThumb);
				$this->image_lib->resize();
				return $uploadedDetails['file_name'];
			}
        }
    }
	
	function memberMoveImage($filename = NULL){
        if($filename){
			$image_name = str_replace(" ","",$filename);
			$image_name = time().$image_name;
			$this->load->library('upload');
			$config['upload_path'] = './upload/member_muse/';
			$config['file_name'] = $image_name;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_width'] = '1920';
			$config['max_height'] = '1280';
			$this->upload->initialize($config);
			if (!$this->upload->do_upload("image")){
				$error = $this->upload->display_errors(); 
				$this->session->set_flashdata('errormsg', $error);
			} else {
				$uploadedDetails    = $this->upload->data();
				$image['image'] = $uploadedDetails['file_name'];
			  
				$this->load->library('image_lib');
				$configThumb = array();  
				$configThumb['image_library']   = 'gd2';  
				$configThumb['source_image']    = $uploadedDetails['full_path'];
						
				$configThumb['new_image'] = "./upload/member_muse_thumb/".$uploadedDetails['file_name'];
				$configThumb['width']           = 286;  
				$configThumb['height']          = 147;  
				$this->image_lib->initialize($configThumb);
				$this->image_lib->resize();
				return $uploadedDetails['file_name'];
			}
        }
    }
	
	function removeFile($image_name,$folder) { 
		$folder_url = base_url().$folder;
		$rel_url = $folder;
		if(file_exists($folder_url.$image_name)) {
			@unlink($folder_url.$image_name);
		}
	}
	function phpinf()
	{
	    echo phpinfo();
	    exit;
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */
