<?php

class Phones extends CI_Model 
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getAllData() {
    	$sql = "SELECT * FROM phone_data";
    	$query = $this->db->query($sql);
    	$result = $query->result_array();
    	return $result;
    }
    function findPhoneNumber($number) {
    	$this->db->where('phone_number',$number);
    	$query = $this->db->get('phone_data');
    	$result = $query->result();
    	if (count($result) > 0)
    		return TRUE;
    	else
    		return FALSE;
    }
    function getPhoneId($number) {
    	$this->db->where('phone_number',$number);
    	$query = $this->db->get('phone_data');
    	$result = $query->result();
    	if (count($result) > 0)
    		return $result[0]["id"];
    	else
    		return -1;
    }
}

?>