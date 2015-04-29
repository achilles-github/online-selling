<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mproduct extends CI_Model{
    
    function get_product($skip,$limit,$sort="asc",$sortCol = "datetime")
    {
    	$products = $this->db->select('id,name,datetime,status')->where('isdeleted','0')->order_by($sortCol,$sort)->limit($limit,$skip)->get('categories');
    	return $products->result_array();
    }
    function product_by_id($id)
    {
    	$products = $this->db->select('id,name,datetime,img,status')->where('id',$id)->get('products');
    	return $products->row_array();
    }
    function insert($data)
    {
    	$this->db->insert("products",$data);
    }
    function update($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("products",$data);
    }
    function search_products($search,$skip,$limit,$sort="asc",$sortCol = "datetime")
    {
    	$products = $this->db->select('id,name,datetime,status')->where('isdeleted','0')->like("name",$search,"after")->order_by($sortCol,$sort)->limit($limit,$skip)->get('products');
    	return $products->result_array();
    }
    function count_products($search = "")
    {
    	if($search == "")
    	{
    		$products = $this->db->select("COUNT(*) AS count",false)->where('isdeleted','0')->get('products');
    	}
    	else
    	{
    		$products = $this->db->select("COUNT(*) AS count",false)->like("name",$search,"after")->where('isdeleted','0')->get('products');
    	}    	
    	$data = $products->row_array();
    	return $data['count'];
    }
    function count_orders($id)
    {
    	$count = $this->db->select("COUNT(*) AS count",false)->where('product_id',$id)->where('isdeleted','0')->get('order_products');
    	$data = $count->row_array();
    	return $data['count'];
    }
}
