<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mcontact extends CI_Model{
    
    function get_contacts($skip,$limit,$sort="asc",$sortCol = "created")
    {
    	$contacts = $this->db->select('id,name,contact_no,email,created',false)->where('isdeleted','0')->order_by($sortCol,$sort)->limit($limit,$skip)->get('contacts');
    	$data = $contacts->result_array();
    	
    	return $data;
    }
    function contact_by_id($id)
    {
    	$contacts = $this->db->select('id,name,contact_no,email,created,comment',false)->where('id',$id)->get('contacts');
    	return $contacts->row_array();
    }
    function insert($data)
    {
    	$this->db->insert("contacts",$data);
    }
    function update($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("contacts",$data);
    }
    function search_contacts($search,$skip,$limit,$sort="asc",$sortCol = "created")
    {
    	$contacts = $this->db->select('id,name,contact_no,email,created',false)->where('isdeleted','0')->like("name",$search,"after")->order_by($sortCol,$sort)->limit($limit,$skip)->get('contacts');
    	$data = $contacts->result_array();
    	
    	return $data;
    }
    function count_contacts($search = "")
    {
    	if($search == "")
    	{
    		$contacts = $this->db->select("COUNT(*) AS count",false)->where('isdeleted','0')->get('contacts');
    	}
    	else
    	{
    		$contacts = $this->db->select("COUNT(*) AS count",false)->like("name",$search,"after")->where('isdeleted','0')->get('contacts');
    	}    	
    	$data = $contacts->row_array();
    	return $data['count'];
    }
    
    
}
