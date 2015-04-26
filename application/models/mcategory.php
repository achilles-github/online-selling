<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mcategory extends CI_Model{
    
    function get_categories($skip,$limit,$sort="asc",$sortCol = "datetime")
    {
    	$categories = $this->db->select('id,cat_name,datetime')->where('isdeleted','0')->order_by($sortCol,$sort)->limit($limit,$skip)->get('categories');
    	return $categories->result_array();
    }
    function insert_categories($data)
    {
    	$this->db->insert("categories",$data);
    }
    function update_categories($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("categories",$data);
    }
    function search_categories($search,$skip,$limit,$sort="asc",$sortCol = "datetime")
    {
    	$categories = $this->db->select('id,cat_name,datetime')->where('isdeleted','0')->like("cat_name",$search,"after")->order_by($sortCol,$sort)->limit($limit,$skip)->get('categories');
    	return $categories->result_array();
    }
    function count_categories($search = "")
    {
    	if($search == "")
    	{
    		$categories = $this->db->select("COUNT(*) AS count",false)->where('isdeleted','0')->get('categories');
    	}
    	else
    	{
    		$categories = $this->db->select("COUNT(*) AS count",false)->like("cat_name",$search,"after")->where('isdeleted','0')->get('categories');
    	}    	
    	$data = $categories->row_array();
    	return $data['count'];
    }
}
