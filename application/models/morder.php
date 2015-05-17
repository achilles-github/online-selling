<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class morder extends CI_Model{
    
    function get_orders($skip,$limit,$sort="asc",$sortCol = "orders.created")
    {
    	$orders = $this->db->select('orders.id,orders.order_no,orders.created,orders.amount,orders.status,orders.isdelivered,customers.name,orders.payment_type',false)->join("customers","customers.id = orders.customer_id")->where('orders.isdeleted','0')->order_by($sortCol,$sort)->limit($limit,$skip)->get('orders');
    	$data = $orders->result_array();   	
    	return $data;
    }
    function order_by_id($id)
    {
    	$orders = $this->db->select('orders.id,orders.order_no,orders.created, orders.status,orders.isdelivered,customers.name as customer_name,orders.amount,orders.tax, shippings.address,states.name as state,cities.name as city, countries.country_name as country, shippings.zip')->join("shippings","shippings.order_id=orders.id")->join("customers","customers.id = orders.customer_id")->join("countries","countries.id=shippings.country")->join("states","states.id=shippings.state")->join("cities","cities.id=shippings.city","left")->where('orders.id',$id)->get('orders');
    	$row = $orders->row_array();
    	if(count($row) > 0)
    	{
    		$order_products = $this->db->select("*")->where("isdeleted","0")->get("order_products");
    		$row['order_products'] = $order_products->result_array();
    		
    	}
    	return $row;
    }
    function insert($data)
    {
    	$this->db->insert("orders",$data);
    }
    function update($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("orders",$data);
    }
    function update_order_product($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("order_products",$data);
    }
    function search_orders($search,$skip,$limit,$sort="asc",$sortCol = "orders.created")
    {
    	$orders = $this->db->select('orders.id,orders.order_no,orders.created,orders.amount,orders.status,orders.isdelivered,customers.name,orders.payment_type',false)->join("customers","customers.id = orders.customer_id")->where('orders.isdeleted','0')->like("orders.order_no",$search,"after")->order_by($sortCol,$sort)->limit($limit,$skip)->get('orders');
    	$data = $orders->result_array();
    	return $data;
    }
    function count_orders($search = "")
    {
    	if($search == "")
    	{
    		$orders = $this->db->select("COUNT(*) AS count",false)->where('isdeleted','0')->get('orders');
    	}
    	else
    	{
    		$orders = $this->db->select("COUNT(*) AS count",false)->join("customers","customers.id = orders.customer_id")->where('orders.isdeleted','0')->like("customers.name",$search,"after")->get('orders');
    	}    	
    	$data = $orders->row_array();
    	return $data['count'];
    }
    function delete_all_products($data,$id)
    {
    	$this->db->where("order_id",$id);
    	$this->db->update("order_products",$data);
    }
    
}
