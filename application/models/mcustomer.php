<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mcustomer extends CI_Model{
    
    function get_customers($skip,$limit,$sort="asc",$sortCol = "customers.created")
    {
    	$customers = $this->db->select('customers.id,customers.name,customers.created,customers.status,customers.address,states.name as state,cities.name as city, countries.country_name as country,customers.zip',false)->join("cities","cities.id = customers.city")->join("states","states.id = customers.state")->join("countries","countries.id = customers.country")->where('customers.isdeleted','0')->order_by($sortCol,$sort)->limit($limit,$skip)->get('customers');
    	$data = $customers->result_array();
    	foreach($data as $key => $val)
    	{
    		$data[$key]["address"] = $val["address"].", ".$val["city"]." - ".$val['zip'].", ".$val['state'].", ".$val['country'];
    	}
    	return $data;
    }
    function product_by_id($id)
    {
    	$customers = $this->db->select('customers.id,customers.name,customers.created,customers.status,customers.address,states.name as state,cities.name as city, countries.country_name as country,customers.zip,customers.phone',false)->join("cities","cities.id = customers.city")->join("states","states.id = customers.state")->join("countries","countries.id = customers.country")->where('customers.id',$id)->get('customers');
    	return $customers->row_array();
    }
    function insert($data)
    {
    	$this->db->insert("customers",$data);
    }
    function update($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("customers",$data);
    }
    function search_customers($search,$skip,$limit,$sort="asc",$sortCol = "customers.created")
    {
    	$customers = $this->db->select('customers.id,customers.name,customers.created,customers.status,customers.address,states.name as state,cities.name as city, countries.country_name as country,customers.zip')->join("cities","cities.id = customers.city")->join("states","states.id = customers.state")->join("countries","countries.id = customers.country")->where('customers.isdeleted','0')->like("customers.name",$search,"after")->order_by($sortCol,$sort)->limit($limit,$skip)->get('customers');
    	$data = $customers->result_array();
    	foreach($data as $key => $val)
    	{
    		$data[$key]["address"] = $val["address"].", ".$val["city"]." - ".$val['zip'].", ".$val['state'].", ".$val['country'];
    	}
    	return $data;
    }
    function count_customers($search = "")
    {
    	if($search == "")
    	{
    		$products = $this->db->select("COUNT(*) AS count",false)->where('isdeleted','0')->get('customers');
    	}
    	else
    	{
    		$products = $this->db->select("COUNT(*) AS count",false)->like("name",$search,"after")->where('isdeleted','0')->get('customers');
    	}    	
    	$data = $products->row_array();
    	return $data['count'];
    }
    function count_orders($id)
    {
    	$count = $this->db->select("COUNT(*) AS count",false)->where('customer_id',$id)->where('isdeleted','0')->get('orders');
    	$data = $count->row_array();
    	return $data['count'];
    }
    
}
