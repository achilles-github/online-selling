<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mcategory extends CI_Model{
    
    function get_categories($skip,$limit)
    {
    	$categories = $this->db->select('id,cat_name')->where('isdeleted','0')->order_by("id")->limit($limit,$skip)->get('categories');
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
    function search_categories($search,$skip,$limit)
    {
    	$categories = $this->db->select('id,cat_name')->where('isdeleted','0')->like("name",$search,"after")->order_by("id")->limit($limit,$skip)->get('categories');
    	return $categories->result_array();
    }
}
