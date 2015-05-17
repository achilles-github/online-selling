<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mcity extends CI_Model{
    
    function get_cities($skip,$limit,$sort="asc",$sortCol = "cities.name")
    {
    	$cities = $this->db->select('cities.id,cities.name,countries.country_name,states.name as state_name',false)->join('countries',"countries.id = cities.country_id")->join('states',"states.id = cities.state_id")->where('cities.isdeleted','0')->order_by($sortCol,$sort)->limit($limit,$skip)->get('cities');
    	return $cities->result_array();
    }
    function city_by_id($id)
    {
    	$cities = $this->db->select('id,name,country_id,state_id')->where('id',$id)->get('cities');
    	return $cities->row_array();
    }
    function insert($data)
    {
    	$this->db->insert("cities",$data);
    }
    function update($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("cities",$data);
    }
    function search_cities($search,$skip,$limit,$sort="asc",$sortCol = "cities.name")
    {
    	$cities = $this->db->select('cities.id,cities.name,states.name as state_name,countries.country_name')->join('countries',"countries.id = cities.country_id")->join('states',"states.id = cities.state_id")->where('states.isdeleted','0')->like("cities.name",$search,"after")->order_by($sortCol,$sort)->limit($limit,$skip)->get('cities');
    	return $cities->result_array();
    }
    function count_cities($search = "")
    {
    	if($search == "")
    	{
    		$cities = $this->db->select("COUNT(*) AS count",false)->where('isdeleted','0')->get('cities');
    	}
    	else
    	{
    		$cities = $this->db->select("COUNT(*) AS count",false)->like("name",$search,"after")->where('isdeleted','0')->get('cities');
    	}    	
    	$data = $cities->row_array();
    	return $data['count'];
    }
    function all_countries()
    {
    	$countries = $this->db->select("id,country_name",false)->where('isdeleted','0')->get('countries');
    	$data = $countries->result_array();
    	return $data;
    }
    function states_country_id($id)
    {
    	$states = $this->db->select("id,name as state_name",false)->where('country_id',$id)->where('isdeleted','0')->get('states');
    	return $states->result_array();
    }
    
}
