<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mcountry extends CI_Model{
    
    function get_countries($skip,$limit,$sort="asc",$sortCol = "country_name")
    {
    	$countries = $this->db->select('id,country_name')->where('isdeleted','0')->order_by($sortCol,$sort)->limit($limit,$skip)->get('countries');
    	return $countries->result_array();
    }
    function country_by_id($id)
    {
    	$countries = $this->db->select('id,country_name')->where('id',$id)->get('countries');
    	return $countries->row_array();
    }
    function insert($data)
    {
    	$this->db->insert("countries",$data);
    }
    function update($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("countries",$data);
    }
    function search_countries($search,$skip,$limit,$sort="asc",$sortCol = "country_name")
    {
    	$products = $this->db->select('id,country_name')->where('isdeleted','0')->like("country_name",$search,"after")->order_by($sortCol,$sort)->limit($limit,$skip)->get('countries');
    	return $products->result_array();
    }
    function count_countries($search = "")
    {
    	if($search == "")
    	{
    		$countries = $this->db->select("COUNT(*) AS count",false)->where('isdeleted','0')->get('countries');
    	}
    	else
    	{
    		$countries = $this->db->select("COUNT(*) AS count",false)->like("country_name",$search,"after")->where('isdeleted','0')->get('countries');
    	}    	
    	$data = $countries->row_array();
    	return $data['count'];
    }
    function count_states($id)
    {
    	$count = $this->db->select("COUNT(*) AS count",false)->where('country_id',$id)->where('isdeleted','0')->get('states');
    	$data = $count->row_array();
    	return $data['count'];
    }
    
}
