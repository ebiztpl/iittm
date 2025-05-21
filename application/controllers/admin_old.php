<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Controller Class
 *
 * @author		ImpelPro Dev Team
**/

class Admin extends CI_Controller {
	
	public $folder = "admin/";

	function __construct()
	{
		parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('general_helper');
		$this->load->model("adminmodel");
		$this->load->model("usermodel");

		date_default_timezone_set("Asia/Calcutta");
	}
	
	public function index()
	{
		redirect('admin/login');
	}

	// executes when clicked on login
	public function login()
	{	
		
		if(isset($_POST['username']) && isset($_POST['password'])){
			$username = $this->input->post('username', true);
			$password = $this->input->post('password', true);
			$sts = $this->adminmodel->login($username, $password); 
			if($sts !=0)
			{
				$session= array("admin_id" => $sts['admin_id'], "admin_name" =>  $sts['admin_name'], "role" =>  $sts['role']);
				$this->session->set_userdata($session);
				redirect("admin/dashboard");

			}
			else{
				setFlash("loginMsgError", "Please, enter <strong>valid Username and Password</strong>");			
			}			
		}
		
		$this->load->view($this->folder."login");
	}	

	public function get_query_by_id()
	{
		$id = $this->input->get('data');
		$table='query_data';
		$whr = "query_id='$id'";
		$fields = "*";
		$result = $this->db_lib->fetchRecords($table,$whr,$fields);
		echo json_encode($result);

	}

	public function save_query_by_id()
	{
		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  
		
		 $finding = $str_arr[0];
		 $solution = $str_arr[1];
		 $queryid = $str_arr[2];
		 $status = $str_arr[3];

		 $where = "query_id = '$queryid'";
		 $cate_data = array(
			'finding' => $finding,
			'solution' => $solution,
			'status' => $status,
			'solution_datetime' => date("Y-m-d H:i:s")
			);
		$rst = $this->db_lib->update('query_data',$cate_data,$where);
		if($rst>0)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	public function query()
	{

		$table='query_data';
		$whr = "";
		$fields = "*";
		$result = $this->db_lib->fetchRecords($table,$whr,$fields);
		$this->load->view($this->folder."query_report",array('result'=>$result));
	}
	
	public function transaction()
	{

		$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id';
		$whr = "user_master.login_status=2 and user_master.razorpay_trans_id !='' order by user_master.user_id desc";
		$fields = "*";
		$result = $this->db_lib->fetchRecords($table,$whr,$fields);
		$this->load->view($this->folder."transaction_report",array('result'=>$result));
	}
	
	public function razorpay_transaction()  
	{
		 
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.razorpay.com/v1/payments?count=10&skip=0&from=1400826740",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"token\"\r\n\r\nf289c62ae680619b646e8fc0c4284c12\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"batch_id\"\r\n\r\n4\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Basic cnpwX2xpdmVfWG1VZm9YQXA1Z3NZQ0g6aHJsRVlqOXZmUTBxNUh5eElva2hHcENO",
		    "cache-control: no-cache",
		    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
		    "postman-token: d5c6b03f-aa17-38b3-409f-6f7f40693ba3"
		  ),
		));

		$response = curl_exec($curl);
		

			

		$this->load->view($this->folder."razorpay_transaction",array('result'=>$response));
    }
	
	public function get_settelment()  
	{
		 
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.razorpay.com/v1/settlements/?count=100&skip=0&from=",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"token\"\r\n\r\nf289c62ae680619b646e8fc0c4284c12\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"batch_id\"\r\n\r\n4\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Basic cnpwX2xpdmVfWG1VZm9YQXA1Z3NZQ0g6aHJsRVlqOXZmUTBxNUh5eElva2hHcENO",
		    "cache-control: no-cache",
		    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
		    "postman-token: d5c6b03f-aa17-38b3-409f-6f7f40693ba3"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {

			//echo $response;

			$ram = json_decode($response, true);
			$cont = count($ram['items']);
			
			$rs = "";
			for ($i=0; $i < $cont ; $i++) { 
				$rs += $ram['items'][$i]['amount'];
			}

			return $rs;
		}
    }  
	
	public function dashboard_filter()
	{

		$section_id = $this->uri->segment(3);
		$course_id = $this->uri->segment(4);

		if($course_id =="")
		{
			
			if($section_id == "total_regis")
			{
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$whr = "user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);
			}

			if($section_id == "today_regis")
			{
				$today_date = date('Y-m-d');
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "user_master.created_date LIKE '%$today_date%' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);
			}

			if($section_id == "total_inc")
			{
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "user_master.login_status=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


			if($section_id == "today_inc")
			{
				$today_date = date('Y-m-d');
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "user_master.created_date LIKE '%$today_date%' and user_master.login_status=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "total_fee")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "login_status=2 and razorpay_trans_id !=''";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


			if($section_id == "today_fee")
			{
				$today_date = date('Y-m-d');
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "created_date LIKE '%$today_date%' and login_status=2 and razorpay_trans_id !=''";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);
			}


			if($section_id == "study_center_gwalior")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


			if($section_id == "study_center_bhubaneswar")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


			if($section_id == "study_center_noida")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "study_center_nellore")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}



			if($section_id == "gdpi_center_gwalior")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "gdpi_center_bhubaneshwar")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


			if($section_id == "gdpi_center_noida")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "gdpi_center_nellore")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			

		}

		if($course_id !="")
		{
			if($section_id == "total_regis")
			{
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$whr = "user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);
			}

			if($section_id == "today_regis")
			{
				$today_date = date('Y-m-d');
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "user_master.created_date LIKE '%$today_date%' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);
			}

			if($section_id == "total_inc")
			{
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "user_master.login_status=1 and user_master.course_id=$course_id";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "today_inc")
			{
				$today_date = date('Y-m-d');
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "user_master.created_date LIKE '%$today_date%' and user_master.login_status=1 and user_master.course_id=$course_id";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "total_fee")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "login_status=2 and razorpay_trans_id !='' and user_master.course_id=$course_id";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


			if($section_id == "today_fee")
			{
				$today_date = date('Y-m-d');
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "created_date LIKE '%$today_date%' and login_status=2 and razorpay_trans_id !='' and user_master.course_id=$course_id";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "study_center_gwalior")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


			if($section_id == "study_center_bhubaneswar")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


			if($section_id == "study_center_noida")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "study_center_nellore")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "gdpi_center_gwalior")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "gdpi_center_bhubaneshwar")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


			if($section_id == "gdpi_center_noida")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}

			if($section_id == "gdpi_center_nellore")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


		}

				
		$this->load->view($this->folder."dashboard_filter",array('result'=>$result));

	}
   


   public function dashboard()
	{	
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://control.msg91.com/api/balance.php?type=4&authkey=322873AxMkWjplhxu5e6a21f3P1",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		   "cURL Error #:" . $err;
		} else {
		   $response;
		} 	

		$whr = "login_status=2 and razorpay_trans_id !=''";
		$total_regis = $this->adminmodel->record_count('user_master',$whr);
	
		$today_date = date('Y-m-d');
		$whrr = "created_date LIKE '%$today_date%' and login_status=2 and razorpay_trans_id !=''";
		$today_candidate = $this->adminmodel->record_count('user_master',$whrr);


		$whr_inc = "login_status=1";
		$whrr_inc = "created_date LIKE '%$today_date%' and login_status=1";
		$total_inc = $this->adminmodel->record_count('user_master',$whr_inc);
		$today_inc = $this->adminmodel->record_count('user_master',$whrr_inc);

		$total_fee = $this->adminmodel->record_sum('user_master',$whr);
		$today_fee = $this->adminmodel->record_sum('user_master',$whrr);

		$general = $this->adminmodel->general_category('');
		$obc = $this->adminmodel->obc_category('');
		$sc = $this->adminmodel->sc_category('');
		$st = $this->adminmodel->st_category('');
		$pwd = $this->adminmodel->pwd_category('');
		$ews = $this->adminmodel->ews_category('');
		$category  =  [['category', 'value'],['General',json_decode($general)],['OBC',json_decode($obc)],['SC',json_decode($sc)],['ST',json_decode($st)],['EWS',json_decode($ews)]];
		
	

		$male = $this->adminmodel->male('');
		$female = $this->adminmodel->female('');
		$gender  =  [['gender', 'value'],['Male',json_decode($male)],['Female',json_decode($female)]];


		$passed = $this->adminmodel->passed('');
		$apperance = $this->adminmodel->apperance('');
		$academic  =  [['Academic', 'value'],['Appearing',json_decode($apperance)],['Passed',json_decode($passed)]];

		$religion_hindu = $this->adminmodel->religion_hindu('');
		$religion_chris = $this->adminmodel->religion_chris('');
		$religion_Nonreligious = $this->adminmodel->religion_other('');
		$religion_bhudh = $this->adminmodel->religion_bhudh('');
		$religion_Islam = $this->adminmodel->religion_Islam('');
		$religion_Sikhism = $this->adminmodel->religion_Sikhism('');
		$religion = [['Religion', 'value'],['Hinduism',json_decode($religion_hindu)],['Christianity',json_decode($religion_chris)],['Other',json_decode($religion_Nonreligious)],['Islam',json_decode($religion_Islam)],['Sikhism',json_decode($religion_Sikhism)],['Buddhism',json_decode($religion_bhudh)]]; 

		$study_center1 = $this->adminmodel->study_center1('');
		$study_center2 = $this->adminmodel->study_center2('');
		$study_center3 = $this->adminmodel->study_center3('');
		$study_center4 = $this->adminmodel->study_center4(''); 

		$gdpi_center_1 = $this->adminmodel->gdpi_center_1('');
		$gdpi_center_2 = $this->adminmodel->gdpi_center_2('');
		$gdpi_center_3 = $this->adminmodel->gdpi_center_3('');
		$gdpi_center_4 = $this->adminmodel->gdpi_center_4(''); 

		$apr_center1  = $this->adminmodel->appr_center_1('');
		$apr_center2  = $this->adminmodel->appr_center_2('');
		$apr_center3  = $this->adminmodel->appr_center_3('');
		$apr_center4  = $this->adminmodel->appr_center_4('');
		$apr_center5  = $this->adminmodel->appr_center_5('');
		$apr_center6  = $this->adminmodel->appr_center_6('');
		$apr_center7  = $this->adminmodel->appr_center_7('');
		$apr_center8  = $this->adminmodel->appr_center_8('');
		$apr_center9  = $this->adminmodel->appr_center_9('');
		$apr_center10 = $this->adminmodel->appr_center_10('');
		$apr_center11 = $this->adminmodel->appr_center_11('');
		$apr_center12 = $this->adminmodel->appr_center_12('');
		$apr_center13 = $this->adminmodel->appr_center_13('');
		$apr_center14 = $this->adminmodel->appr_center_14('');
		$apr_center15 = $this->adminmodel->appr_center_15('');
		$apr_center16 = $this->adminmodel->appr_center_16('');
		$apr_center17 = $this->adminmodel->appr_center_17('');


		$Appearing = [['Center', 'Values'],['Gwalior', json_decode($apr_center1)],['Bhubaneswar', json_decode($apr_center2)],['Goa', json_decode($apr_center3)],['Noida', json_decode($apr_center4)],['Nellore', json_decode($apr_center5)], ['Hajipur,Bihar', json_decode($apr_center6)],['Jaipur', json_decode($apr_center7)],['Chennai', json_decode($apr_center8)],['Bhopal', json_decode($apr_center9)],['Kolkata', json_decode($apr_center10)],['Lucknow', json_decode($apr_center11)],['Mumbai', json_decode($apr_center12)],['Bengaluru', json_decode($apr_center13)],['Ahmedabad', json_decode($apr_center14)],['Guwahati', json_decode($apr_center15)],['Jammu', json_decode($apr_center16)],['Trivandrum', json_decode($apr_center17)]];



		$ee = $this->adminmodel->candidate('');
		$fee_data = $this->adminmodel->fees('');
		$settelment = $this->get_settelment();



		$this->load->view($this->folder."new_dashboard",array('balance'=>$response,'total_regis'=>$total_regis,'today_candidate'=>$today_candidate,'total_inc'=>$total_inc,'today_inc'=>$today_inc,'total_fee'=>$total_fee,'today_fee'=>$today_fee,'category'=>$category,'gender'=>$gender,'academic'=>$academic,'religion'=>$religion,'study_center1'=>$study_center1,'study_center2'=>$study_center2,'study_center3'=>$study_center3,'study_center4'=>$study_center4,'gdpi_center_1'=>$gdpi_center_1,'gdpi_center_2'=>$gdpi_center_2,'gdpi_center_3'=>$gdpi_center_3,'gdpi_center_4'=>$gdpi_center_4,'Appearing'=>$Appearing,'candidate'=>$ee,'settelment'=>$settelment,'fees'=>$fee_data));

	}

	public function get_course_data()
	{
		$course_id = $this->input->get('data');
		if($course_id != null)
		{
			$whr = "login_status=2 and razorpay_trans_id !='' and course_id='$course_id'";
			$total_regis = $this->adminmodel->record_count('user_master',$whr);

			$today_date = date('Y-m-d');
			$whrr = "created_date LIKE '%$today_date%' and login_status=2 and razorpay_trans_id !='' and course_id='$course_id'";
			$today_candidate = $this->adminmodel->record_count('user_master',$whrr);

			$whr_inc = "login_status=1 and course_id='$course_id'";
			$whrr_inc = "created_date LIKE '%$today_date%' and login_status=1 and course_id='$course_id'";
			$total_inc = $this->adminmodel->record_count('user_master',$whr_inc);
			$today_inc = $this->adminmodel->record_count('user_master',$whrr_inc);

			$total_fee = $this->adminmodel->record_sum('user_master',$whr);
			$today_fee = $this->adminmodel->record_sum('user_master',$whrr);

			$general = $this->adminmodel->general_category($course_id);
			$obc = $this->adminmodel->obc_category($course_id);
			$sc = $this->adminmodel->sc_category($course_id);
			$st = $this->adminmodel->st_category($course_id);
			$pwd = $this->adminmodel->pwd_category($course_id);
			$ews = $this->adminmodel->ews_category($course_id);

			$category  =  [['category', 'value'],['General',json_decode($general)],['OBC',json_decode($obc)],['SC',json_decode($sc)],['ST',json_decode($st)],['EWS',json_decode($ews)]];


			$male = $this->adminmodel->male($course_id);
			$female = $this->adminmodel->female($course_id);
			$gender  =  [['gender', 'value'],['Male',json_decode($male)],['Female',json_decode($female)]];


			$religion_hindu = $this->adminmodel->religion_hindu($course_id);
			$religion_chris = $this->adminmodel->religion_chris($course_id);
			$religion_Nonreligious = $this->adminmodel->religion_other($course_id);
			$religion_bhudh = $this->adminmodel->religion_bhudh($course_id);
			$religion_Islam = $this->adminmodel->religion_Islam($course_id);
			$religion_Sikhism = $this->adminmodel->religion_Sikhism($course_id);
			$religion = [['Religion', 'value'],['Hinduism',json_decode($religion_hindu)],['Christianity',json_decode($religion_chris)],['Other',json_decode($religion_Nonreligious)],['Islam',json_decode($religion_Islam)],['Sikhism',json_decode($religion_Sikhism)],['Buddhism',json_decode($religion_bhudh)]]; 

			$passed = $this->adminmodel->passed($course_id);
			$apperance = $this->adminmodel->apperance($course_id);
			$academic  =  [['Academic', 'value'],['Appearing',json_decode($apperance)],['Passed',json_decode($passed)]];


			$apr_center1  = $this->adminmodel->appr_center_1($course_id);
			$apr_center2  = $this->adminmodel->appr_center_2($course_id);
			$apr_center3  = $this->adminmodel->appr_center_3($course_id);
			$apr_center4  = $this->adminmodel->appr_center_4($course_id);
			$apr_center5  = $this->adminmodel->appr_center_5($course_id);
			$apr_center6  = $this->adminmodel->appr_center_6($course_id);
			$apr_center7  = $this->adminmodel->appr_center_7($course_id);
			$apr_center8  = $this->adminmodel->appr_center_8($course_id);
			$apr_center9  = $this->adminmodel->appr_center_9($course_id);
			$apr_center10 = $this->adminmodel->appr_center_10($course_id);
			$apr_center11 = $this->adminmodel->appr_center_11($course_id);
			$apr_center12 = $this->adminmodel->appr_center_12($course_id);
			$apr_center13 = $this->adminmodel->appr_center_13($course_id);
			$apr_center14 = $this->adminmodel->appr_center_14($course_id);
			$apr_center15 = $this->adminmodel->appr_center_15($course_id);
			$apr_center16 = $this->adminmodel->appr_center_16($course_id);
			$apr_center17 = $this->adminmodel->appr_center_17($course_id);


			$Appearing = [['Center', 'Values'],['Gwalior', json_decode($apr_center1)],['Bhubaneswar', json_decode($apr_center2)],['Goa', json_decode($apr_center3)],['Noida', json_decode($apr_center4)],['Nellore', json_decode($apr_center5)], ['Hajipur,Bihar', json_decode($apr_center6)],['Jaipur', json_decode($apr_center7)],['Chennai', json_decode($apr_center8)],['Bhopal', json_decode($apr_center9)],['Kolkata', json_decode($apr_center10)],['Lucknow', json_decode($apr_center11)],['Mumbai', json_decode($apr_center12)],['Bengaluru', json_decode($apr_center13)],['Ahmedabad', json_decode($apr_center14)],['Guwahati', json_decode($apr_center15)],['Jammu', json_decode($apr_center16)],['Trivandrum', json_decode($apr_center17)]];

			$study_center1 = $this->adminmodel->study_center1($course_id);
			$study_center2 = $this->adminmodel->study_center2($course_id);
			$study_center3 = $this->adminmodel->study_center3($course_id);
			$study_center4 = $this->adminmodel->study_center4($course_id); 


			$gdpi_center_1 = $this->adminmodel->gdpi_center_1($course_id);
			$gdpi_center_2 = $this->adminmodel->gdpi_center_2($course_id);
			$gdpi_center_3 = $this->adminmodel->gdpi_center_3($course_id);
			$gdpi_center_4 = $this->adminmodel->gdpi_center_4($course_id); 


			$ram = array('total_regis'=>$total_regis,'today_candidate'=>$today_candidate,'total_inc'=>$total_inc,'today_inc'=>$today_inc,'total_fee'=>$total_fee,'today_fee'=>$today_fee,'category'=>$category,'gender'=>$gender,'religion'=>$religion,'academic'=>$academic,'Appearing'=>$Appearing,'study_center1'=>$study_center1,'study_center2'=>$study_center2,'study_center3'=>$study_center3,'study_center4'=>$study_center4,'gdpi_center_1'=>$gdpi_center_1,'gdpi_center_2'=>$gdpi_center_2,'gdpi_center_3'=>$gdpi_center_3,'gdpi_center_4'=>$gdpi_center_4);

			echo json_encode($ram);


		}
	}

	public function Dashboard_Details()
	{	

		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
			
			$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
			$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city";
			$limit = 100;			
			$start = 0;
			$whr = "candidate_data.duplicate =0";
			
			
			$result = $this->db_lib->fetchRecords($table,$whr,$fields);
			//$result = $this->dblib->fetch_data($limit,$start,$table,'',$fields);
			$this->load->view($this->folder."Dashboard_Details",array('result'=>$result));
			
	
	}
	
	
	public function maps()
	{

		$total_regis = $this->adminmodel->statewisecan('');
		$this->load->view($this->folder."map_view",array('result'=>$total_regis));
	}


	public function get_map_course()
	{
		$course_id = $this->input->get('data');
		if($course_id != null)
		{
		
			$users = $this->adminmodel->statewisecan($course_id);
				
			$markers = [];
			$infowindow = [];

			foreach($users as $value) {
			  $markers[] = [
				$value->state_name, $value->lat, $value->long
			  ];          
			  $infowindow[] = [
			   "<div class=info_content><b>".$value->state_name."</b><br/>Candidate:".$value->cnt."</div>"
			  ];
			}
			$location['markers'] = json_encode($markers);
			$location['infowindow'] = json_encode($infowindow);
			
			$ram = array('result'=>$location['markers'],'result1'=>$location['infowindow']);
			echo json_encode($ram);
		
			
		}
	}
		
		
	public function get_map_center()
	{
		$course_id = $this->input->get('data');
		if($course_id != null)
		{
		
			$users = $this->adminmodel->getmapcenter($course_id);
				
			$markers = [];
			$infowindow = [];

			foreach($users as $value) {
			  $markers[] = [
				$value->state_name, $value->lat, $value->long
			  ];          
			  $infowindow[] = [
			   "<div class=info_content><b>".$value->state_name."</b><br/>Candidate:".$value->cnt."</div>"
			  ];
			}
			$location['markers'] = json_encode($markers);
			$location['infowindow'] = json_encode($infowindow);
			
			$ram = array('result'=>$location['markers'],'result1'=>$location['infowindow']);
			echo json_encode($ram);
		
			
		}	
	}
	
	public function get_map_both()
	{
		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  
		
		$course_id = $str_arr[0];
		$study_center = $str_arr[1];
		
		
		
		
			$users = $this->adminmodel->getmapboth($course_id,$study_center);
				
			$markers = [];
			$infowindow = [];

			foreach($users as $value) {
			  $markers[] = [
				$value->state_name, $value->lat, $value->long
			  ];          
			  $infowindow[] = [
			   "<div class=info_content><b>".$value->state_name."</b><br/>Candidate:".$value->cnt."</div>"
			  ];
			}
			$location['markers'] = json_encode($markers);
			$location['infowindow'] = json_encode($infowindow);
			
			$ram = array('result'=>$location['markers'],'result1'=>$location['infowindow']);
			echo json_encode($ram);
		
	}



	public function show_form_bba()
    {
		
        $user_id = $this->uri->segment(3);
       
		$where = "mobile_verified_id = '$user_id'";
		$rst = $this->db_lib->fetchRecord('candidate_data',$where,'*');
		
		$this->load->view('admission/user_list',array('users'=>$rst));
        $html = $this->output->get_output();

        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->set_option('isRemoteEnabled', true);
        $this->dompdf->setPaper('A4', 'portrait');

        $this->dompdf->render();
        $this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
        //$output =$this->dompdf->output();
        //file_put_contents($pdfroot,$output);
    }


	public function show_form_mba()
    {
		
        $user_id = $this->uri->segment(3);
       
		$where = "mobile_verified_id = '$user_id'";
		$rst = $this->db_lib->fetchRecord('candidate_data',$where,'*');
		
		$this->load->view('admission/user_list_mba',array('users'=>$rst));
        $html = $this->output->get_output();

        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->set_option('isRemoteEnabled', true);
        $this->dompdf->setPaper('A4', 'portrait');

        $this->dompdf->render();
        $this->dompdf->stream("welcome.pdf", array("Attachment"=>0));
        //$output =$this->dompdf->output();
        //file_put_contents($pdfroot,$output);
    }

	public function logout()
	{
		if($this->usermodel->hasLoggedIn()){
			session_unset();
			session_destroy();
			redirect("admin/login");
		}

	}

	public function seat()
	{

		$this->load->view($this->folder."seat",array('result'=>""));
		
		if(isset($_POST["btnSubmit"])){

			$cid = $this->input->post('course');
			$center = $this->input->post('first_code');
			$where = "course_id = '$cid' and study_center = '$center'";
			$rst = $this->db_lib->fetchRecord('seat_master',$where,'*');
			if($rst>0)
			{
				setFlash("ViewMsgSuccess","<div class='col-sm-12'><div class='alert alert-danger'><strong>Warning!</strong> Study center and course alreay in db!</div></div>");
				redirect("admin/seat");
			}
			else
			{
				$userData = array(
				'study_center' => $this->input->post('first_code',true),
				'course_id' => $this->input->post('course',true),
				'total_seat' => $this->input->post('txt_seat',true),
				'seat_postdate'=> date("Y-m-d H:i:s"),
				);
					
				$last_id = $this->db_lib->insert('seat_master',$userData,'');
	            if($last_id!=0){

	            	$string = $this->input->post('hidden_arry',true);
	            	$cate = $this->input->post('hiddencat',true);
	            	$pers = $this->input->post('hiddenpersentage',true);
	            	$seat = $this->input->post('hiddenseat',true);
	            	$cnt = count($cate);
	            	for($i = 0;$i <= $cnt-1; $i++)
					{

						$cate_data = array(
							'seat_id' => $last_id,
							'category_name' => $cate[$i],
							'percentage' => $pers[$i],
							'seat' => $seat[$i],
							'datetime' => date("Y-m-d H:i:s")
							);
						$this->db_lib->insert('seat_category_metrix',$cate_data,'');
					}
	            }

	            setFlash("ViewMsgSuccess","<div class='col-sm-12'><div class='alert alert-success'><strong>Warning!</strong> Record Insert Successfully!</div></div>");
				redirect("admin/seat");
			}



				

		}

	}


	public function search_seat()
	{
		$this->load->view($this->folder."search_seat",array('result'=>""));
	}

	public function get_data_by_id()
	{
		$id = $this->input->get('data');
		$user_id = substr($id, 4);

		$where = "um.user_id = '$user_id' and cd.duplicate=0";
		$rst = $this->db_lib->fetchRecords('user_master um inner join candidate_data cd on cd.mobile_verified_id=um.user_id',$where,'login_status,razorpay_trans_id,amount,created_date,course_id,first_name,middle_name,last_name,mobile,email_id');		


		$ram = array('result'=>$rst);
		echo json_encode($ram);
	}


	public function get_data_seat()
	{
		
		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  		
		$course_id = $str_arr[0];
		$study_center = $str_arr[1];


		$where = "course_id = '$course_id' and study_center = '$study_center'";
		$rst = $this->db_lib->fetchRecords('seat_master',$where,'*');

		$seat_id = $rst[0]['seat_id'];
		$study_center_get = $this->adminmodel->study_center_get($study_center,$course_id);

		$general_cat = $this->adminmodel->general_cat($seat_id);
		$ews_cat = $this->adminmodel->ews_cat($seat_id);
		$obc_cat = $this->adminmodel->obc_cat($seat_id);

		$sc_cat = $this->adminmodel->sc_cat($seat_id);
		$st_cat = $this->adminmodel->st_cat($seat_id);


		$general_pwd = $this->adminmodel->pwd_cat_application($study_center,$course_id,'General');
		$ews_pwd = $this->adminmodel->pwd_cat_application($study_center,$course_id,'EWS');
		$obc_pwd = $this->adminmodel->pwd_cat_application($study_center,$course_id,'OBC');
		$sc_pwd = $this->adminmodel->pwd_cat_application($study_center,$course_id,'SC');
		$st_pwd = $this->adminmodel->pwd_cat_application($study_center,$course_id,'ST');



		$general_application = $this->adminmodel->general_cat_application($study_center,$course_id,'General');
		$ews_application = $this->adminmodel->general_cat_application($study_center,$course_id,'EWS');
		$obc_application = $this->adminmodel->general_cat_application($study_center,$course_id,'OBC');
		$sc_application = $this->adminmodel->general_cat_application($study_center,$course_id,'SC');
		$st_application = $this->adminmodel->general_cat_application($study_center,$course_id,'ST');




		$ram = array('total_seat'=>$rst[0]['total_seat'],'total_application'=>$study_center_get,'general_cat'=>$general_cat,'ews_cat'=>$ews_cat,'obc_cat'=>$obc_cat,'sc_cat'=>$sc_cat,'st_cat'=>$st_cat,'general_application'=>$general_application,'ews_application'=>$ews_application,'obc_application'=>$obc_application,'sc_application'=>$sc_application,'st_application'=>$st_application,'general_pwd'=>$general_pwd,'ews_pwd'=>$ews_pwd,'obc_pwd'=>$obc_pwd,'sc_pwd'=>$sc_pwd,'st_pwd'=>$st_pwd);
		echo json_encode($ram);


	}

	
	
		public function table_filter_next()
	{
		$count = $this->input->get('data');

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.razorpay.com/v1/payments?count=10&skip=$count&from=1400826740",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"token\"\r\n\r\nf289c62ae680619b646e8fc0c4284c12\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"batch_id\"\r\n\r\n4\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Basic cnpwX2xpdmVfWG1VZm9YQXA1Z3NZQ0g6aHJsRVlqOXZmUTBxNUh5eElva2hHcENO",
		    "cache-control: no-cache",
		    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
		    "postman-token: d5c6b03f-aa17-38b3-409f-6f7f40693ba3"
		  ),
		));

		$response = curl_exec($curl);
		$yummy = json_decode($response, true);
		echo json_encode($yummy['items']);

		//$ram = array('result'=>$response);
		//echo json_encode($ram['items']);

			

		
	}


	public function table_filter_pre()
	{
		$count = $this->input->get('data')-10;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.razorpay.com/v1/payments?count=10&skip=$count&from=1400826740",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"token\"\r\n\r\nf289c62ae680619b646e8fc0c4284c12\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"batch_id\"\r\n\r\n4\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Basic cnpwX2xpdmVfWG1VZm9YQXA1Z3NZQ0g6aHJsRVlqOXZmUTBxNUh5eElva2hHcENO",
		    "cache-control: no-cache",
		    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
		    "postman-token: d5c6b03f-aa17-38b3-409f-6f7f40693ba3"
		  ),
		));

		$response = curl_exec($curl);
		$yummy = json_decode($response, true);
		echo json_encode($yummy['items']);
		
	}

	public function table_filter_search()
	{
		$data = $this->input->get('data');

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.razorpay.com/v1/payments/$data",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"token\"\r\n\r\nf289c62ae680619b646e8fc0c4284c12\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"batch_id\"\r\n\r\n4\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Basic cnpwX2xpdmVfWG1VZm9YQXA1Z3NZQ0g6aHJsRVlqOXZmUTBxNUh5eElva2hHcENO",
		    "cache-control: no-cache",
		    "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
		    "postman-token: d5c6b03f-aa17-38b3-409f-6f7f40693ba3"
		  ),
		));

		$response = curl_exec($curl);
		$yummy = json_decode($response, true);
		echo json_encode([$yummy]);
		
	}
	
	// Execute when user forgot password
	public function forgot_password()
	{
		if($this->usermodel->hasLoggedIn()){
			$user_id=$this->usermodel->getUserId();
			if($this->role_management->check_permission($user_id,ACTIVATE_DEACTIVATE)==true)
			{
				redirect("admin/view_details");
			}
			else
			{
				redirect("account/change_password");
			}
		}
		/*--	Action Section	--*/
		if(isset($_POST['btnforgot'])){
			$email_id = $this->input->post("email",true);
			$result = $this->accountmodel->forgotPassword($email_id);
			if($result){
				
				setFlash("loginMsgSuccess", "Password reset email has been sent to your registered Email address - <strong>{$email_id}</strong>");
				redirect("account/login");
			}
			else{
				setFlash("forgotPasswordError", "The specified Email Address - <strong>{$email_id}</strong> is not registered with CreditRating.");
				redirect("account/forgot_password");
			}
		}
		
		/*--	Page Section	--*/		
		$this->load->view($this->folder."forgot");	
	}
	
	// Execute when user click on activation link
	public function reset_password()
	{
		if(isset($_GET['u']) && isset($_GET['a'])){
			$userEmail = trim($_GET['u']);
			$randomString = trim($_GET['a']);
			if(!$this->accountmodel->resetPassword($userEmail, $randomString)){
				echo "Link has been used already";
				exit();
			}
		}
		
		/*--	Action Section	--*/
		if(isset($_POST['btnReset'])){
			$userData = $this->input->post();
			echo $userEmail = $userData['u'];
			$randomString = $userData['a'];
			$result = $this->accountmodel->changePassword($userData, $userEmail, $randomString);
			if($result){
				setFlash("loginMsgSuccess", "Password has been updated successfully");
				redirect("account/login");
			}
			else{
				setFlash("changePasswordError", "Unable to update password");
				redirect("account/reset_password");
			}
		}
		
		/*--	Head Section	--*/
		$this->template->title = 'Profile';
		$this->template->meta_keywords = '';
		$this->template->meta_description = '';

		/*--	Page Section	--*/	
		$this->load->view($this->folder."resetpassword",array("u"=>$userEmail, "a"=>$randomString));	
	}
	
	// used to change user password
	public function change_password()
	{
		if(!$this->usermodel->hasLoggedIn()){
			redirect("account/login");
		}
		
		/*--	Action Section	--*/
		if(isset($_POST['btnUpdate'])){
			$userData = $this->input->post();		
			$result = $this->accountmodel->changePassword($userData);
			if($result){
				setFlash("changePasswordSuccess", "Password has been updated successfully");
			}
			else{
				setFlash("changePasswordError", "Unable to update the password. Please, verify you have entered your <strong>Old Passwword</strong> correctly.");
			}
		}
		
		/*--	Head Section	--*/
		$this->template->title = 'Profile';
		$this->template->meta_keywords = '';
		$this->template->meta_description = '';

		/*--	Page Section	--*/		
		$this->template->load($this->folder."changepassword");
	}
	
	public function get_items()
   {
      $draw = intval($this->input->get("draw"));
      $start = intval(1);
      $length = intval(5);


     $query = $this->db->query("SELECT *,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city FROM user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city WHERE candidate_data.duplicate=0"); 


      $data = [];

      $n=0;
      foreach($query->result() as $r) {
      	$n++;
      		$amount = ($r->amount)/100;
			if($r->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 
			if($r->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}
			
			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$r->first_name." ".$r->middle_name." ".$r->last_name."</a>";}
			
			if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$r->first_name." ".$r->middle_name." ".$r->last_name."</a>";}

           $data[] = array(
           		$n,
                $fullname,
                $r->user_mobile,
                $r->email_id,
                $r->gender,
                $r->parma_state,
                $r->parma_city,
                $r->corre_state,
                $r->corre_city,
                $r->academic_board,
                $r->appearing_center_1,
                $r->gdpi_center_1,
                $r->study_centre_1,
                $r->category,
                $r->dob,
                $r->razorpay_trans_id,
                $amount,
                $sts_btn,
                $r->created_date
               
           );
      }


      $result = array(
               	 "draw" => $draw,
                 "recordsTotal" => $query->num_rows(),
                 "recordsFiltered" => $query->num_rows(),
                 "data" => $data
            );


      echo json_encode($result);
      exit();
   }


    public function filter_date()
	{
		$draw = intval($this->input->get("draw"));
      	$start = intval(1);
      	$length = intval(5);

		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  		
		$from = $str_arr[0];
		$to = $str_arr[1];
		$statu_get = $str_arr[2];

		
 	
 	   $query = $this->db->query("SELECT *,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city FROM user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city WHERE created_date BETWEEN '$from' AND '$to' and login_status in ($statu_get)"); 


      $data = [];

      $n=0;
      foreach($query->result() as $r) {
      	$n++;
      		$amount = ($r->amount)/100;
			if($r->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 
			if($r->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}

			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$r->first_name." ".$r->middle_name." ".$r->last_name."</a>";}
			
			if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$r->first_name." ".$r->middle_name." ".$r->last_name."</a>";}
			
			
           $data[] = array(
           		$n,
                $fullname,
                $r->user_mobile,
                $r->email_id,
                $r->gender,
                $r->parma_state,
                $r->parma_city,
                $r->corre_state,
                $r->corre_city,
                $r->academic_board,
                $r->appearing_center_1,
                $r->gdpi_center_1,
                $r->study_centre_1,
                $r->category,
                $r->dob,
                $r->razorpay_trans_id,
                $amount,
                $sts_btn,
                $r->created_date
               
           );
      }


	      $result = array(
	               	 "draw" => $draw,
	                 "recordsTotal" => $query->num_rows(),
	                 "recordsFiltered" => $query->num_rows(),
	                 "data" => $data
	      );


      echo json_encode($result);
      exit();


	}
	// edit profile
	
}	