<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mcategory extends CI_Model{
    
    function get_categories($skip,$limit,$sort="asc",$sortCol = "datetime")
    {
    	$categories = $this->db->select('id,cat_name,datetime')->where('isdeleted','0')->order_by($sortCol,$sort)->limit($limit,$skip)->get('categories');
    	return $categories->result_array();
    }
    function all_categories()
    {
    	$categories = $this->db->select('id,cat_name')->where('isdeleted','0')->order_by("id")->get('categories');
    	return $categories->result_array();
    }
    function category_by_id($id)
    {
    	$categories = $this->db->select('id,cat_name,datetime,img')->where('id',$id)->get('categories');
    	return $categories->row_array();
    }
    function insert($data)
    {
    	$this->db->insert("categories",$data);
    }
    function update($data,$id)
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
    function count_products($cat)
    {
    	$count = $this->db->select("COUNT(*) AS count",false)->where('category_id',$cat)->where('isdeleted','0')->get('products');
    	$data = $count->row_array();
    	return $data['count'];
    }
}
