<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Model Class
 *
 * @author		ImpelPro Dev Team
 *
**/

class admissionModel extends CI_Model 
{
	private $table;
	private $history_table;
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		//$this->table = "admin";		
    }	
	
    
	public function hasLoggedIn()
	{
		if($this->session->userdata("user_id"))
			return true;
		return false;
	}



	// common view details
	function fetch_data($table_name,$where = null,$fields = null,$searchname = null)
	{

		echo $table_name; exit();

		if($where!=null)
		{						
			if($fields!=null)
			{				
				$data=$this->db_lib->fetchRecords($table_name,$where,$fields);
			}
			else
			{
				$data=$this->db_lib->fetchRecords($table_name,$where,'*');
			}			
		}
		else
		{
			if($fields!=null)
			{	
				$data=$this->db_lib->fetchRecords($table_name,'',$fields);
			}
			else
			{
				$data=$this->db_lib->fetchRecords($table_name,'','*');
			}
		}
		
        if ($data!=0) {
            return $data;
        }
        return false;
   }


   public function store_user_details_with_otp($bankData)
	{
		$bankId = $this->db_lib->insert('user_master',$bankData);  // store details
		if($bankId!=0){
			return true;
		}	
		return false;
	}


	function fetch_all_state()
    {
    	$field_officers_active = $this->db_lib->fetchRecords('states',"",'id,name');
		if($field_officers_active!=0){
			return $field_officers_active;
		}
		return 0;
    }


	public function fetchcity($where)
	{
		$field_officers_active = $this->db_lib->fetchRecords('cities',"$where",'id,name');
		if($field_officers_active!=0){
			return $field_officers_active;
		}
		return 0;
	}

	

	
	
}