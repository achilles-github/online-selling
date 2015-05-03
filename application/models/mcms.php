<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mcms extends CI_Model{
    
    
    function get_cms($id)
    {
    	$cms = $this->db->select('*')->where('id',$id)->get('cms');
    	return $cms->row_array();
    }
   
    function update($data,$id)
    {
    	$this->db->where("id",$id) ;
    	$this->db->update("cms",$data);
    }
    
}
