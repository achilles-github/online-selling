<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mstate extends CI_Model{
    
    function get_states($skip,$limit,$sort="asc",$sortCol = "state_name")
    {
    	$states = $this->db->select('states.id,states.state_name,countries.country_name')->join('countries',"countries.id = states.country_id")->where('states.isdeleted','0')->order_by($sortCol,$sort)->limit($limit,$skip)->get('countries');
    	return $states->result_array();
    }
    function states_by_id($id)
    {
    	$states = $this->db->select('id,country_name,country_id')->where('id',$id)->get('states');
    	return $states->row_array();
    }
    function insert($data)
    {
    	$this->db->insert("states",$data);
    }
    function update($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("countries",$data);
    }
    function search_states($search,$skip,$limit,$sort="asc",$sortCol = "country_name")
    {
    	$states = $this->db->select('states.id,states.state_name,countries.country_name')->join('countries',"countries.id = states.country_id")->where('states.isdeleted','0')->like("states.state_name",$search,"after")->order_by($sortCol,$sort)->limit($limit,$skip)->get('states');
    	return $states->result_array();
    }
    function count_states($search = "")
    {
    	if($search == "")
    	{
    		$states = $this->db->select("COUNT(*) AS count",false)->where('isdeleted','0')->get('states');
    	}
    	else
    	{
    		$states = $this->db->select("COUNT(*) AS count",false)->like("state_name",$search,"after")->where('isdeleted','0')->get('states');
    	}    	
    	$data = $states->row_array();
    	return $data['count'];
    }
    function count_cities($id)
    {
    	$count = $this->db->select("COUNT(*) AS count",false)->where('state_id',$id)->where('isdeleted','0')->get('cities');
    	$data = $count->row_array();
    	return $data['count'];
    }
    
}
