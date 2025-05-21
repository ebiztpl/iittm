<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Model Class
 *
 * @author		ImpelPro Dev Team
 *
**/

class adminModel extends CI_Model 
{
	private $table;
	private $history_table;
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }	
	
	
	function candidate($whr)
	{

		if($whr !='')
		{
			$dayQuery =  $this->db->query("SELECT COUNT(user_id) as count,MONTH(created_date) as day_date FROM user_master WHERE login_status=2 AND razorpay_trans_id !='' AND course_id=$whr GROUP BY MONTH(created_date)"); 

      		$dat="";
	  		foreach ($dayQuery->result() as $row){
	        	$dat .= "['".$row->day_date."',".$row->count."],";
	         }
	         return str_replace('"', '', $dat);
		}

		$dayQuery =  $this->db->query("SELECT COUNT(user_id) as count,MONTH(created_date) as day_date FROM user_master WHERE login_status=2 AND razorpay_trans_id !='' GROUP BY MONTH(created_date)"); 

      	$dat="";
  		foreach ($dayQuery->result() as $row){
  			$month_name = date("F", mktime(0, 0, 0, $row->day_date, 10));
        	$dat .= "['".$month_name."',".$row->count."],";
         }
         return str_replace('"', '', $dat);
     
      
	}	

	
		function getmapboth($course_id,$study_center)
	{
		
			$dayQuery =  $this->db->query("SELECT count(mb.mobile_verified_id) as cnt,st.name as state_name,st.lat,st.long FROM candidate_data mb left join states st on st.id=mb.parma_state left join user_master um on um.user_id=mb.mobile_verified_id WHERE um.course_id =$course_id AND  mb.study_centre_1='$study_center' and mb.duplicate !=1 and um.login_status=2 and um.razorpay_trans_id !='' GROUP BY mb.parma_state order by st.name"); 

		
		return $dayQuery->result();
		
	
	}



	function getmapcenter($whr)
	{
		$dayQuery =  $this->db->query("SELECT count(mb.mobile_verified_id) as cnt,st.name as state_name,st.lat,st.long FROM candidate_data mb left join states st on st.id=mb.parma_state left join user_master um on um.user_id=mb.mobile_verified_id WHERE mb.study_centre_1='$whr' and mb.duplicate !=1 and um.login_status=2 and um.razorpay_trans_id !='' GROUP BY mb.parma_state order by st.name"); 
		
		return $dayQuery->result();
	}

	function statewisecan($whr)
	{
		if($whr !='')
		{
			$dayQuery =  $this->db->query("SELECT count(mb.mobile_verified_id) as cnt,st.name as state_name,st.lat,st.long FROM candidate_data mb left join states st on st.id=mb.parma_state left join user_master um on um.user_id=mb.mobile_verified_id WHERE um.course_id =$whr and mb.duplicate !=1 and um.login_status=2 and um.razorpay_trans_id !='' GROUP BY mb.parma_state order by st.name"); 

			return $dayQuery->result();
		
		}
		$dayQuery =  $this->db->query("SELECT count(mb.mobile_verified_id) as cnt,st.name as state_name,st.lat,st.long FROM candidate_data mb left join states st on st.id=mb.parma_state left join user_master um on um.user_id=mb.mobile_verified_id WHERE mb.duplicate !=1 and um.login_status=2 and um.razorpay_trans_id !='' GROUP BY mb.parma_state order by st.name"); 

      	//return $data['day_wise'] = $dayQuery->result();
      	$arr="";
  		foreach ($dayQuery->result() as $row){
  			$arr .= "['<b>".$row->state_name."</b> <br/>Candidate : ".$row->cnt."','".$row->lat."','".$row->long."']".",";
         }

        return $data =  trim($arr, ",");
	}


	
	function fees($whr)
	{

		if($whr !='')
		{
			$dayQuery =  $this->db->query("SELECT sum(amount/100) as count,MONTH(created_date) as day_date FROM user_master WHERE razorpay_trans_id !='' AND course_id='$whr' GROUP BY MONTH(created_date)"); 

      		$dat="";
	  		foreach ($dayQuery->result() as $row){
	        	$dat .= "['".$row->day_date."',".$row->count."],";
	         }
	         return str_replace('"', '', $dat);
		}

		$dayQuery =  $this->db->query("SELECT sum(amount/100) as count,MONTH(created_date) as day_date FROM user_master WHERE razorpay_trans_id !='' GROUP BY MONTH(created_date)"); 

      //return $data['day_wise'] = $dayQuery->result();
      	$dat="";
  		foreach ($dayQuery->result() as $row){
  			$month_name = date("F", mktime(0, 0, 0, $row->day_date, 10));
        $dat .= "['".$month_name."',".$row->count."],";
         }
         return str_replace('"', '', $dat);
        //return $dat;
      
	}
	
	
	// login to authenticate user
	public function login($username, $password)
	{		
		
		$strWhere = "admin_name = '$username' AND admin_password = '$password'";	
		$user = $this->db_lib->fetchRecord('admin',$strWhere,'admin_name,admin_password,admin_id,role');
		if($user!=0)
		{			
			return $user;			
		}
		return false;
	}
	
		function general_category($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.category ='General' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}	

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.category ='General' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function obc_category($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.category ='OBC' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.category ='OBC' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}
	function sc_category($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.category ='SC' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.category ='SC' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];

		
	}

	function st_category($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.category ='ST' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.category ='ST' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];

		
	}

	function pwd_category($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.category ='PWD' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr'";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];

		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.category ='PWD' and um.login_status=2 and um.razorpay_trans_id !=''";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}
	
	function ews_category($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.category ='EWS' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}	

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.category ='EWS' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function male($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.gender ='Male' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.gender ='Male' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function female($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.gender ='Female' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.gender ='Female' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function passed($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.academic_status !='appearance' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.academic_status !='appearance' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function apperance($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.academic_status ='appearance' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.academic_status ='appearance' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function religion_hindu($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.religion ='Hinduism' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.religion ='Hinduism' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function religion_chris($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.religion ='Christianity' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];	
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.religion ='Christianity' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function religion_other($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.religion ='Other' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.religion ='Other' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function religion_bhudh($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.religion ='Buddhism' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.religion ='Buddhism' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function religion_Islam($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.religion ='Islam' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.religion ='Islam' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function religion_Sikhism($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.religion ='Sikhism' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];	
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.religion ='Sikhism' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}


	function study_center1($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.study_centre_1 ='Gwalior' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];	
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.study_centre_1 ='Gwalior' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function study_center2($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.study_centre_1 ='Bhubaneswar' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.study_centre_1 ='Bhubaneswar' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function study_center3($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.study_centre_1 ='Noida' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.study_centre_1 ='Noida' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function study_center4($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.study_centre_1 ='Nellore' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.study_centre_1 ='Nellore' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}


	function gdpi_center_1($whr)
	{
		if($whr !='')
		{	
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.gdpi_center_1 ='Gwalior' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.gdpi_center_1 ='Gwalior' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}


	function gdpi_center_2($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.gdpi_center_1 ='Bhubaneswar' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.gdpi_center_1 ='Bhubaneswar' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}


	function gdpi_center_3($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.gdpi_center_1 ='Noida' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.gdpi_center_1 ='Noida' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function gdpi_center_4($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.gdpi_center_1 ='Nellore' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.gdpi_center_1 ='Nellore' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}


	function appr_center_1($whr)
	{	
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Gwalior' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			 
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Gwalior' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_2($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Bhubaneswar' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Bhubaneswar' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_3($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Goa' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Goa' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_4($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Noida' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Noida' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_5($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Nellore' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Nellore' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_6($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Hajipur,Bihar' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];	
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Hajipur,Bihar' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_7($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Jaipur' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Jaipur' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}


	function appr_center_8($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Chennai' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Chennai' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_9($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Bhopal' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Bhopal' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_10($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Kolkata' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Kolkata' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_11($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Lucknow' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}

		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Lucknow' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_12($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Mumbai' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Mumbai' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_13($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Bengaluru' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Bengaluru' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_14($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Ahmedabad' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];	
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Ahmedabad' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_15($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Guwahati' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Guwahati' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}


	function appr_center_16($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Jammu' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Jammu' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
	}

	function appr_center_17($whr)
	{
		if($whr !='')
		{
			$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
			$strWhere = "cd.appearing_center_1 ='Trivandrum' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$whr' and cd.duplicate !=1";
			
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
			return $record_count['total_records'];
		}
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.appearing_center_1 ='Trivandrum' and um.login_status=2 and um.razorpay_trans_id !='' and cd.duplicate !=1";
		
		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];
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

    function record_sum($table_name,$strWhere = null)
	{
		if($strWhere != null)
		{
			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'sum(amount) as total_records');
			return $record_count['total_records'];
		}
		else
		{
			$record_count=$this->db_lib->fetchRecord($table_name,'','sum(amount) as total_records');
			return $record_count['total_records'];
		}
    }

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
   
   
   function study_center_get($study_center,$course_id)
	{
		
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.study_centre_1 ='$study_center' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$course_id' and cd.duplicate !=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];	
		
	}

	function general_cat($seat_id)
	{
			$table_name = "seat_category_metrix";
			$strWhere = "seat_id='$seat_id' AND category_name='General'";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'seat');
			return $record_count['seat'];
	}


	function ews_cat($seat_id)
	{
			$table_name = "seat_category_metrix";
			$strWhere = "seat_id='$seat_id' AND category_name='EWS'";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'seat');
			return $record_count['seat'];
	}

	function obc_cat($seat_id)
	{
			$table_name = "seat_category_metrix";
			$strWhere = "seat_id='$seat_id' AND category_name='OBC'";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'seat');
			return $record_count['seat'];
	}

	function sc_cat($seat_id)
	{
			$table_name = "seat_category_metrix";
			$strWhere = "seat_id='$seat_id' AND category_name='SC'";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'seat');
			return $record_count['seat'];
	}

	function st_cat($seat_id)
	{
			$table_name = "seat_category_metrix";
			$strWhere = "seat_id='$seat_id' AND category_name='ST'";

			$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'seat');
			return $record_count['seat'];
	}


	function general_cat_application($study_center,$course_id,$category)
	{
		
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.study_centre_1 ='$study_center' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$course_id' and cd.duplicate !=1 and cd.category='$category'";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];	
		
	}


	function pwd_cat_application($study_center,$course_id,$category)
	{
		
		$table_name = "candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id";
		$strWhere = "cd.study_centre_1 ='$study_center' and um.login_status=2 and um.razorpay_trans_id !='' and um.course_id='$course_id' and cd.duplicate !=1 and cd.category='$category' and pwd=1";

		$record_count=$this->db_lib->fetchRecord($table_name,$strWhere,'count(*) as total_records');
		return $record_count['total_records'];	
		
	}

	
	
	
}