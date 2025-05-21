<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Model Class
 *
 * @author		ImpelPro Dev Team
 *
**/

class mastersModel extends CI_Model 
{
	private $table;
	private $history_table;
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->table = "admin";		
    }	
	
	// login to authenticate user
	public function login($username, $password)
	{		
		
		$strWhere = "admin_name = '$username' AND admin_password = '$password'";	
		$user = $this->db_lib->fetchRecord('admin',$strWhere,'admin_name,admin_password,admin_id');
		if($user!=0)
		{			
			return $user;			
		}
		return false;
	}
	
	
	// add days count into database
	public function attendance_add_day()
	{
		$userID = $this->usermodel->getUserId();
		$strWhere = "AttUserID = '$userID' ORDER BY AttID DESC LIMIT 1";
		$user_attendance_details = $this->db_lib->fetchRecord('attendance',$strWhere,'AttID,AttLoginDateTime,Date(AttLoginDateTime) as logindate,AttJobHours');
		
		// check already day added to system
		$current_date = date("Y-m-d");
		$strWere = "AttUserID = '$userID' AND DATE(AttLoginDateTime) = '$current_date'";
		$is_exist = $this->db_lib->fetchRecord('attendance',$strWere,'AttID,AttLoginDateTime,Date(AttLoginDateTime) as logindate,COUNT(AttID) as total,AttJobHours');
		
		// check only single attendance count for day
		if($is_exist['total'] == 1)
		{
			// check if month end
			$current_year = date("Y",strtotime($user_attendance_details['logindate']));
			$current_month = date("M",strtotime($user_attendance_details['logindate']));
			$month_field_name = "Att".$current_month;
			$month_days_count = $month_field_name."Days";
			
			// fetch year,month record
			$strWhere = "AttYearUserID = '$userID' AND AttYear = '$current_year'";
			$attendanceDetails = $this->db_lib->fetchRecord('year_attendance',$strWhere
											,'AttYearID,AttJanDays,AttFebDays,AttMarDays,AttAprDays,AttMayDays
											,AttJunDays,AttJulDays,AttAugDays,AttSepDays,AttOctDays,AttNovDays,AttDecDays,AttYearDays,AttEmployeeFirstMonth');
			
											
			// add days count
			if($attendanceDetails != 0)
			{				
				$days_count = $attendanceDetails[$month_days_count];
				$days_increment = $days_count + 1;
				
				$last_month = $attendanceDetails['AttEmployeeFirstMonth'];
				if($month_field_name == $last_month)
				{
					$last_month_days = $attendanceDetails['AttYearDays'] + 1;
				}
				else
				{
					$last_month_days = $attendanceDetails['AttYearDays'] + 1;
				}
				
				$daysData = array(
						'AttEmployeeFirstMonth' => $month_field_name,
						$month_days_count => $days_increment,
						'AttYearDays' => $last_month_days
				);

				$this->db_lib->update('year_attendance',$daysData,$strWhere);  // where
			}
			else
			{
				$days_increment = 1;
				$daysData = array(
						'AttYearUserID' => $userID,
						'AttYear' => $current_year,
						$month_days_count => $days_increment,
						'AttEmployeeFirstMonth' => $month_field_name,
						'AttYearDays' => $days_increment						
				);
				$this->db_lib->insert('year_attendance',$daysData);  // where
			}
		}
	}
	
	
	// store logout details
	public function store_logout_details()
	{
		// fetch logged in record id
		$userID = $this->usermodel->getUserId();
		$strWhere = "AttUserID = '$userID' ORDER BY AttID DESC LIMIT 1";
		$user_attendance_details = $this->db_lib->fetchRecord('attendance',$strWhere,'AttID,AttLoginDateTime,Date(AttLoginDateTime) as logindate,AttJobHours');
		$attendance_id = $user_attendance_details['AttID'];
		
		// fetch sceond last attendance details
		$strWhere = "AttUserID = '$userID' AND  AttID < '$attendance_id' ORDER BY AttID DESC LIMIT 1";
		$previous_user_attendance_details = $this->db_lib->fetchRecord('attendance',$strWhere,'AttID,AttLoginDateTime,Date(AttLoginDateTime) as logindate,AttJobHours');
		$prevous_job_hours = $previous_user_attendance_details['AttJobHours'];
		
		// calculate time between login & logout i.e. working hours
		if($prevous_job_hours != '' && $prevous_job_hours != 0)
		{
			$working_hours = ((strtotime(date("Y-m-d H:i:s")) - strtotime($user_attendance_details['AttLoginDateTime'])) / 3600)+$prevous_job_hours;
			$working_hours = round($working_hours,2);
		}
		else
		{
			$working_hours = (strtotime(date("Y-m-d H:i:s")) - strtotime($user_attendance_details['AttLoginDateTime'])) / 3600;
			$working_hours = round($working_hours,2);
		}
		
		// check if month end		
		if($previous_user_attendance_details != 0)
		{
			$month_end_date = date("Y-m-t", strtotime($previous_user_attendance_details['logindate']));
			$current_year = date("Y",strtotime($previous_user_attendance_details['logindate']));
			$current_month = date("M",strtotime($previous_user_attendance_details['logindate']));
			$month_field_name = "Att".$current_month;
			$month_days_count = $month_field_name."Days";
		}
		else
		{
			$month_end_date = date("Y-m-t", strtotime($user_attendance_details['logindate']));
			$current_year = date("Y",strtotime($user_attendance_details['logindate']));
			$current_month = date("M",strtotime($user_attendance_details['logindate']));
			$month_field_name = "Att".$current_month;
			$month_days_count = $month_field_name."Days";
		}
		
		// fetch year,month record
		$strWhere = "AttYearUserID = '$userID' AND AttYear = '$current_year'";
		$attendanceDetails = $this->db_lib->fetchRecord('year_attendance',$strWhere
										,'AttYearID,AttJanDays,AttFebDays,AttMarDays,AttAprDays,AttMayDays
										,AttJunDays,AttJulDays,AttAugDays,AttSepDays,AttOctDays,AttNovDays,AttDecDays,AttYearHours,AttEmployeeFirstMonth');		
			if($attendanceDetails != 0)
			{	
				$last_month = $attendanceDetails['AttEmployeeFirstMonth'];
				if($month_field_name == $last_month)
				{
					$last_month_attendance = $working_hours;
					$last_month_attendance = round($last_month_attendance,2);
				}
				else
				{
					$last_month_attendance = $attendanceDetails['AttYearHours']+$working_hours;
					$last_month_attendance = round($last_month_attendance,2);
				}
				$monthDetails = array(
							'AttYearHours' => $last_month_attendance,
							$month_field_name => $working_hours
				);				
				$this->db_lib->update('year_attendance',$monthDetails,$strWhere);
			}
			else
			{
				$monthDetails = array(
							'AttYearUserID' => $userID,
							$month_field_name => $working_hours,
							'AttYear' => $current_year,
							'AttYearHours' => $working_hours,
							'AttEmployeeFirstMonth' => $month_field_name
				);
				
				$this->db_lib->insert('year_attendance',$monthDetails);
			}
		
		
		// update attendance record
		$attendance_id = $user_attendance_details['AttID'];
		$attData = array('AttLogoutDateTime' => date("Y-m-d H:i:s"),'AttJobHours' => $working_hours);
		$strWhere = "AttID = '$attendance_id'";		
		$this->db_lib->update('attendance',$attData,$strWhere);
	}
	
	public function forgotPassword($email)
	{
		if (!isset($email))
		{
			return false;
		}
		
		$userEmail = $email;
		$strWhere = "empPersonalEmail = '$userEmail'";
		$result = $this->db_lib->fetchRecord($this->table, $strWhere, "empID");
		
		if($result){
			$randomString = random_string('alnum', 10);
			$emilMessage = "Please click <a href='".site_url()."/account/reset_password?u=$userEmail&a=$randomString' target='_blank'> Here </a>to reset your password ";
			
			$this->load->library('email_manager');
			$EmailParams=array(
				'To'=> $userEmail,
				'BCC'=>'ip200014@gmail.com',
				'Subject'=> 'Forgot Password on '.TITLE,
				'Message'=> $emilMessage,
			);
			if($this->email_manager->send_email($EmailParams))
			{
				$this->db_lib->update($this->table, array("empForgotPassCode"=>$randomString), "empID = ".$result['empID']);
				return true;
			}		
			return 0;
		}		
		return false;
	}
	
	public function resetPassword($userEmail, $forgot)
	{
		$strWhere = "empPersonalEmail = '$userEmail' AND empForgotPassCode = '$forgot'";
		$result = $this->db_lib->fetchRecord($this->table, $strWhere, "empID");
		if($result){
			return true;
		}
		return false;
	}
	
	public function changePassword($userData, $userEmail = null, $forgot = null)
	{
		if(!isset($userEmail)){
			$strWhere = "empID = ".$this->usermodel->getUserId() ;
			$strWhere .= " AND binary empPassword = '".$this->encrypt->sha1($userData['old_password'])."'";
		}
		else if(isset($userEmail) && isset($forgot)){
			$strWhere = "empPersonalEmail = '$userEmail' AND empForgotPassCode = '$forgot'";
		}
		
		$result = $this->db_lib->fetchRecord($this->table, $strWhere, "empID");
		
		if($result){
			$newPassword = $this->encrypt->sha1($userData['password']);
			$arrUpdate = array("empPassword" => $newPassword, "empForgotPassCode" => '');
			$pwd = $this->db_lib->update($this->table, $arrUpdate, $strWhere);
			if($pwd){
				return true;
			}
		}
		return false;
	}
	
	public function view_details($table,$searchname)
	{
		if($table=='employees')
		{			
			if($searchname=='')
			{					
				$this->session->unset_userdata("search");
				$user = $this->db_lib->fetchRecords('employees LEFT JOIN countries ON countries.ID = employees.empCountry',
													'','empID,
													empPersonalEmail,empFirstName,empMiddleName,empLastName,
													empMobileNo,empOfficeEmail,empAddressArea,empAddressLine1,empAddressLine2,empOfficeExtn,empActive,empCity,
													empState,empPinCode,Country_Name,empBirthDate,empCreatedOn,empLastUpdatedBy,empUpdateReason');
			}
			else
			{
					$this->session->set_userdata("search",$searchname);
					if($searchname=='active')
					{
						$strWhere="empActive = '1'";
					}
					else if($searchname=='deactive')
					{	
						$strWhere="empActive = '0'";
					}
					else
					{
					$strWhere="
								empID like '$searchname' OR empMobileNo like '$searchname' OR
								empFirstName like '%$searchname%' OR 
								empLastName like '%$searchname%' OR 
								empPersonalEmail like '$searchname' OR
								empMiddleName like '$searchname'";
					}			
				$user = $this->db_lib->fetchRecords('employees LEFT JOIN countries ON countries.ID = employees.empCountry',
													$strWhere,
													'empID,
													empPersonalEmail,empFirstName,empMiddleName,empLastName,
													empMobileNo,empOfficeEmail,empAddressArea,empAddressLine1,empAddressLine2,empOfficeExtn,empActive,empCity,
													empState,empPinCode,Country_Name,empBirthDate,empCreatedOn,empLastUpdatedBy,empUpdateReason');
			}										
		}
		else if($table=='roles')
		{			
			if($searchname=='')
			{					
				$user = $this->db_lib->fetchRecords('roles','',
													'roleID,roleName,roleDesc');				
			}
			else
			{
				if(is_numeric($searchname))
				{
					$strWhere="roleID = '$searchname'";	
					
				}
				else
				{
					$strWhere="roleName like '%$searchname%'";
				}				
				$user = $this->db_lib->fetchRecords('roles',$strWhere,'roleID,roleName,roleDesc');
			}	
		}
		if($user!=0)
		{			
			return $user;			
		}
		
		return false;	
	}	
	
	// common view details
	function fetch_data($limit,$start,$table_name,$where = null,$fields = null,$searchname = null)
	{
		if($where!=null)
		{						
			if($fields!=null)
			{				
				$data=$this->db_lib->fetchRecords($table_name,$where." LIMIT ".$start.",".$limit,$fields);
			}
			else
			{
				$data=$this->db_lib->fetchRecords($table_name,$where." LIMIT ".$start.",".$limit,'*');
			}			
		}
		else
		{
			$this->session->unset_userdata("search");
			if($fields!=null)
			{	
				$data=$this->db_lib->fetchRecords($table_name." LIMIT ".$start.",".$limit,'',$fields);
			}
			else
			{
				$data=$this->db_lib->fetchRecords($table_name." LIMIT ".$start.",".$limit,'','*');
			}
		}
		
        if ($data!=0) {
            return $data;
        }
        return false;
   }
	
	// fetch details any details
	public function fetch_details($table,$strWhere,$fields = null)
	{
		if($fields != null)
		{
			$result = $this->db_lib->fetchRecord($table,$strWhere,$fields);
		}
		else
		{
			$result = $this->db_lib->fetchRecord($table,$strWhere,'*');
		}
		
		if($result != 0)
		{
			return $result;
		}
		return 0;
	}
	
	// count total records
	function record_count($table_name,$strWhere = null)
	{
		if($strWhere != null)
		{
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		else
		{
			$record_count=$this->db_lib->fetchRecord($table_name,'','count(*) as total_records');
			return $record_count['total_records'];
		}
    }
	
	// fetch countries
	public function fetch_countries()
	{
		$countries_data = $this->db_lib->fetchRecords('countries','','*');
		if($countries_data!=0)
		{
			return $countries_data;
		}
		return false;
	}
	
	// fetch states
	public function fetch_states($country_id)
	{
		$strWhere = "Country_ID = '$country_id'";
		$states_data = $this->db_lib->fetchRecords('states',$strWhere,'*');
		if($states_data!=0)
		{
			return $states_data;
		}
		return false;
	}
	
	// fetch cities
	public function fetch_cities($state_id)
	{
		$strWhere = "State_ID = '$state_id'";
		$cities_data = $this->db_lib->fetchRecords('cities',$strWhere,'*');
		if($cities_data!=0)
		{
			return $cities_data;
		}
		return false;
	}
	
	// edit profile 
	public function edit_profile_data($userData)
	{
		$result = '';
		// upload image
		$imageName = "DP_".date('YmdHis');
		$profileImagePath = "uploads/profile/";
		$profileThumbImagePath = "uploads/profile/thumbnails/";
		$initialize = array(
					'allowed_types' => IMG_FORMAT,
					'upload_path' => $profileImagePath,
					'file_name' => $imageName,
					'max_size' => "80000"
				);
		$this->load->library('upload', $initialize);	// load library to upload image
		if ($this->upload->do_upload('uploadimage')){	// So lets upload image					
			$result = $this->upload->data();
		}
		$this->load->library('image_lib');				// load library to create thumbnail
		
		if($result!='')
		{		
			$image_path = $result['full_path'];	
			$file_name = $result['file_name'];	
			$thumbnail = array(
						'source_image' => $image_path,
						'new_image' => $profileThumbImagePath,
						'create_thumb' => TRUE,
						'maintain_ratio' => TRUE,
						'width' => 150,
						'height' => 150
					);
			$this->image_lib->initialize($thumbnail);
			$this->image_lib->resize();					//	So lets create thumbnail 
			$this->image_lib->clear();
			
			$userData['empImage'] = $file_name;
			$employee_id = $this->usermodel->getUserId();			
			$strWhere = "empID = '$employee_id'";
			$is_updated = $this->db_lib->update('employees',$userData,$strWhere);
		}
		else{	
		
			$employee_id = $this->usermodel->getUserId();			
			$strWhere = "empID = '$employee_id'";
			$is_updated = $this->db_lib->update('employees',$userData,$strWhere);
		}
		if($is_updated!=0)
		{
			return true;
		}
		return false;
	}
	
	// store case deletion
	public function store_case_deletion($caseData,$case_id)
	{
		$strWhere = "loginID = '$case_id'";
		$is_updated = $this->db_lib->update('applicationlogin',$caseData,$strWhere);
		if($is_updated != 0)
		{
			$caseData['loginID'] = $case_id;
			$historyId = $this->db_lib->insert($this->history_table,$caseData);  // store details into history table
			return true;
		}
		return false;
	}
	
	// store menu id into the database
	public function store_menu_state()
	{
		$userID = $this->usermodel->getUserID();
		$strWhere = "empID = '$userID'";
		$menu_id = $this->session->userdata('menu_data');
		
		if($menu_id != '')
		{
			$arrData = array(
						'empMenuID' => $menu_id	
						);
			$this->db_lib->update('employees',$arrData,$strWhere);
		}
		$this->session->unset_userdata('menu_data');		
	}
}