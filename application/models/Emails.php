<?php

class Emails extends CI_Model 
{
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function getAllData() {
    	$sql = "SELECT * FROM email_data";
    	$query = $this->db->query($sql);
    	$result = $query->result_array();
    	return $result;
    }
    function findEmail($email) {
    	$this->db->where('email',$email);
    	$query = $this->db->get('email_data');
    	$result = $query->result();
    	if (count($result) > 0)
    		return TRUE;
    	else
    		return FALSE;
    }
    function addEmail($email, $phone)
    {
        $data = array("phone" => $phone, 'email' => $email);
        $this->db->insert('email_data',$data);
    }
}

?>