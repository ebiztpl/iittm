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
			$response = $this->input->post('g-recaptcha-response', true);
			if($response){
				$secretKey = '6LdHzTQpAAAAAObXspOSoMssTVpaz0zMDeX4a1Tm'; 
             
				        //  Verify the reCAPTCHA response 
				          $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
						   
				          //Decode json data 
				  		 $responseData = json_decode($verifyResponse); 
						   
				  		  if($responseData->success)
				  		  {
			$sts = $this->adminmodel->login($username, $password); 
			if($sts !=0)
			{
				$session= array("admin_id" => $sts['admin_id'], "admin_name" =>  $sts['admin_name'], "role" =>  $sts['role']);
				$this->session->set_userdata($session);

				if(isset($_POST['rememberme']))
				{setcookie('admin_username',$username,time() + (60*60*24*30));
				  setcookie('admin_password',$password,time() + (60*60*24*30));
				
				}else{
				
					setcookie('admin_username',$username,time() - (60*60*24*30));
				  setcookie('admin_password',$password,time() - (60*60*24*30));
				}



				redirect("admin/dashboard");

			}
			else{
				setFlash("loginMsgError", "Please, enter <strong>valid Username and Password</strong>");			
			}	
			
		}else{

			setFlash("loginMsgError", "<strong>Robot verification failed</strong>");
		}




		}else{
		
			setFlash("loginMsgError", "Please, check <strong>Google Recaptcha</strong>");	
		}
	}
		
		$this->load->view($this->folder."login");
	}	

	public function db_session()
	{
		 $dbname = $this->input->post('dbname'); 
		$this->session->set_userdata('dbname', $dbname);
		redirect('admin/report3');
		
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
		$whr = "user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate=0 order by user_master.user_id desc";
		$fields = "*";
		$result = $this->db_lib->fetchRecords($table,$whr,$fields);
		$this->load->view($this->folder."transaction_report",array('result'=>$result));
	}
	
	public function razorpay_transaction()  
	{
		 
		$curl = curl_init();
		  curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.razorpay.com/v1/payments?count=100&skip=0&from=1612310400",
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
		$rr = json_decode($response, true);
		$list = array(); 

		//print_r($rr['items']);

		foreach ($rr['items'] as $key => $value) {
			$data=array();
			$user_id =  substr($value['description'],18);
			$table_paymentid =  $this->db->select('*')->from('user_master')->where('user_id',$user_id)->get()->row('razorpay_trans_id');
			$data['id'] = $value['id'];
			$data['amount'] = $value['amount'];
			$data['userid'] = $user_id;
			$data['email'] = $value['email'];
			$data['contact'] = $value['contact'];
			$data['created_at'] = $value['created_at'];
			$data['status'] = $value['status'];
			$data['method'] = $value['method'];
			$data['description'] = $value['description'];
			$data['error_description'] = $value['error_description'];
			$data['tablepayment_id'] = $table_paymentid;
			$list[] = $data;
		}

		$res = json_encode($list);
		$this->load->view($this->folder."razorpay_transaction",array('result'=>$res));
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
		} else 
		{

			//echo $response;

			$ram = json_decode($response, true);
			$cont = count($ram['items']);
			
			$rs = "";
			for ($i=0; $i < $cont ; $i++) { 
				//$rs += $ram['items'][$i]['amount'];
			}

			$first = 0;
		}



		$curll = curl_init();

		curl_setopt_array($curll, array(
		  CURLOPT_URL => "https://api.razorpay.com/v1/settlements/?count=100&skip=100&from=",
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

		$responses = curl_exec($curll);
		$errr = curl_error($curll);
		
		curl_close($curll);

		if ($errr) {
		  echo "cURL Error #:" . $errr;
		} else 
		{

			$ramm = json_decode($responses, true);
			$contt = count($ramm['items']);
			
			$rss = "";
			for ($ii=0; $ii < $contt; $ii++) { 
				//$rss += $ramm['items'][$ii]['amount'];
			}

			$second = 0;
		}

		$codeA = $first;

		$codeB = $second;


		return $codeA+$codeB;
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

			if($section_id == "study_center_goa")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
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

			if($section_id == "gdpi_center_goa")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1";
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

			if($section_id == "study_center_goa")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
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

			if($section_id == "gdpi_center_goa")
			{
				
				$table='user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
				$whr = "candidate_data.gdpi_center_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and user_master.course_id=$course_id and candidate_data.duplicate !=1";
				$fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
				$result = $this->db_lib->fetchRecords($table,$whr,$fields);

			}


		}

				
		$this->load->view($this->folder."dashboard_filter",array('result'=>$result));

	}
   
   public function update_status()
	{
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}

		$this->load->view($this->folder."update_status");

	}


	public function filter_update()
	{
		$draw = intval($this->input->get("draw"));
      	$start = intval(1);
      	$length = intval(5);

		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  		
		$mobile = $str_arr[0];
		$email = $str_arr[1];
		

		if($mobile !="")
		{
			$query = $this->db->query("SELECT * FROM candidate_data WHERE mobile = $mobile AND duplicate !=1");
		}
		else if($email !="")
		{
			$query = $this->db->query("SELECT * FROM candidate_data WHERE email_id = '$email' AND duplicate !=1");
		}

      $data = [];
      $n=0;
      foreach($query->result() as $r) {

      		$user_data = $this->db->select("*")->from("user_master")->where("user_id = ".$r->mobile_verified_id."")->get()->row();
      		$tranid = $user_data->razorpay_trans_id; $amount=$user_data->amount/100; 

      		if($user_data->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 
			if($user_data->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}

      		$act_btn = "<a class='btn btn-xs btn-success' ng-model='status' onclick='angular.element(this).scope().modalpop($r->mobile_verified_id)'> Update</a>";
      		$n++;
           	$data[] = array(
           		$n,
           		$r->first_name,
                $r->mobile,
                $r->email_id,
                $r->gender,
                $r->category,
                $r->dob,
                $tranid,
                $amount,
                $sts_btn,
                $r->post_date,
               	$act_btn
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


	public function update_transactionId()
	{
		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  
		
		 $tranid = $str_arr[0];
		 $fees = $str_arr[1];
		 $queryid = $str_arr[2];
		 
		 $where = "user_id = '$queryid'";
		 $cate_data = array(
			'razorpay_trans_id' => $tranid,
			'amount' => $fees,
			'login_status' => 2,
			'modified_date' => date("Y-m-d H:i:s")
			);
		$rst = $this->db_lib->update('user_master',$cate_data,$where);
		if($rst>0)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}


	public function getcoursewisedata()
	{
		
		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  		
		$course_id = $str_arr[0];
		$study_center = $str_arr[1];
		$catList []= array('Category','Application');
		$genderList []= array('Gender','Application');
		$religionList []= array('Gender','Application');
		$category =  $this->db->query("SELECT category,count(mobile_verified_id) as cnt from candidate_data where course_name='$course_id' AND study_centre_1='$study_center' group by category");
		if($category->result())
		{
			
			foreach ($category->result() as $row)
			{
			$catList []= array(
				    $row->category,
				    json_decode($row->cnt)
				  ); 
         	}
		}



		$gender =  $this->db->query("SELECT gender,count(mobile_verified_id) as cnt from candidate_data where course_name='$course_id' AND study_centre_1='$study_center' group by gender");
		if($gender->result())
		{
			
			foreach ($gender->result() as $row)
			{
			$genderList []= array(
				    $row->gender,
				    json_decode($row->cnt)
				  ); 
         	}
		}


		$religion =  $this->db->query("SELECT religion,count(mobile_verified_id) as cnt from candidate_data where course_name='$course_id' AND study_centre_1='$study_center' group by religion");
		if($religion->result())
		{
			
			foreach ($religion->result() as $row)
			{
			$religionList []= array(
				    $row->religion,
				    json_decode($row->cnt)
				  ); 
         	}
		}


		$dayQuery =  $this->db->query("SELECT st.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id inner join states st ON st.id = cd.parma_state WHERE cd.duplicate = 0 and course_name='$course_id' AND study_centre_1='$study_center' and um.login_status=2 and um.razorpay_trans_id !='' GROUP by cd.parma_state order by cnt desc"); 
		$statelist = $dayQuery->result();


		$CityQuery =  $this->db->query("SELECT ct.name,count(cd.parma_city) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id inner join cities ct ON ct.id = cd.parma_city WHERE cd.duplicate = 0 AND course_name='$course_id' AND study_centre_1='$study_center' and um.login_status=2 and um.razorpay_trans_id !='' GROUP by cd.parma_city order by cnt desc"); 
		$districtlist = $CityQuery->result();


		$seat []= array('Category','Application','Seat');
		$categorySeat =  $this->db->query("SELECT scm.category_name,sum(scm.seat) as cnt FROM seat_category_metrix scm inner join seat_master st ON st.seat_id = scm.seat_id WHERE st.course_id ='$course_id' and st.study_center='$study_center' GROUP by scm.category_name order by cnt desc");
		if($categorySeat->result())
		{
			
			foreach ($categorySeat->result() as $row)
			{
			$admission = $this->db->select('count(*) as cnt')
			->from('candidate_data')
			->join('user_master um', 'um.user_id = candidate_data.mobile_verified_id')
			->where('candidate_data.duplicate',0)
			->where('um.login_status',2)
			->where('um.razorpay_trans_id !=', '')
			->where('candidate_data.course_name',$course_id)
			->where('candidate_data.category',$row->category_name)
			->where('candidate_data.study_centre_1',$study_center)->get()->row('cnt');	
			$seat []= array(
				    $row->category_name,
				    json_decode($admission),
				    json_decode($row->cnt)
				  ); 
         	}
		}

		$center []= array('Center','Application','Seat');
		$CenterSeat =  $this->db->query("SELECT * FROM seat_master WHERE course_id ='$course_id' GROUP by study_center order by study_center desc");
		if($CenterSeat->result())
		{
			
			foreach ($CenterSeat->result() as $rows)
			{

			$admission = $this->db->select('count(*) as cnt')->from('candidate_data')->where('duplicate',0)->where('course_name',$course_id)->where('study_centre_1',$rows->study_center)->get()->row('cnt');	
				
			$center []= array(
				    $rows->study_center,
				    json_decode($admission),
				    json_decode($rows->total_seat)
				  ); 
         	}
		}


		$q = $this->db->query("SELECT count(*) as total, know_iittm as source FROM candidate_data where study_centre_1 = '".$study_center."' GROUP BY know_iittm order by total desc");
		$data  = $q->result_array();
			
		$output[] = array('source','value');

		foreach($q->result_array() as $row)
		{
		    $output[] = array(
		       $row["source"]??'N/A',
		       $row["total"]
		    );
		}
		$source_data = $output;


		$ram = array('category'=>$catList,'gender'=>$genderList,'religion'=>$religionList,'statelist' =>$statelist,'districtlist'=>$districtlist,'categorybar'=>$seat,'center'=> $center, 'source_data' => $source_data);

		echo json_encode($ram);

	}


	public function admission_graphical()
	{	
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}

		$catList = array(); $genderList = array(); $religionList = array();  $source_chart = array();

		$category =  $this->db->query("SELECT category,count(mobile_verified_id) as cnt from candidate_data where admission=1 group by category");
		if($category->result())
		{
			$catList []= array('Category','Admission');
			foreach ($category->result() as $row)
			{
			$catList []= array(
				    $row->category,
				    json_decode($row->cnt)
				  ); 
         	}
		}


		$gender =  $this->db->query("SELECT gender,count(mobile_verified_id) as cnt from candidate_data where admission=1 group by gender");
		if($gender->result())
		{
			$genderList []= array('Gender','Admission');
			foreach ($gender->result() as $row)
			{
			$genderList []= array(
				    $row->gender,
				    json_decode($row->cnt)
				  ); 
         	}
		}


		$religion =  $this->db->query("SELECT religion,count(mobile_verified_id) as cnt from candidate_data where admission=1 group by religion");
		if($religion->result())
		{
			$religionList []= array('Gender','Admission');
			foreach ($religion->result() as $row)
			{
			$religionList []= array(
				    $row->religion,
				    json_decode($row->cnt)
				  ); 
         	}
		}


		$dayQuery =  $this->db->query("SELECT st.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join states st ON st.id = cd.parma_state WHERE cd.admission=1 and cd.duplicate = 0 GROUP by cd.parma_state order by cnt desc"); 
		$statelist = $dayQuery->result();


		$CityQuery =  $this->db->query("SELECT ct.name,count(cd.parma_city) as cnt FROM candidate_data cd inner join cities ct ON ct.id = cd.parma_city WHERE cd.admission=1 and cd.duplicate = 0 GROUP by cd.parma_city order by cnt desc"); 
		$districtlist = $CityQuery->result();

		$seat []= array('Category','Application','Seat');
		$categorySeat =  $this->db->query("SELECT category_name,sum(seat) as cnt FROM seat_category_metrix GROUP by category_name order by cnt desc");
		if($categorySeat->result())
		{
			
			foreach ($categorySeat->result() as $row)
			{
			$admission = $this->db->select('count(*) as cnt')->from('candidate_data')->where('admission',1)->where('category',$row->category_name)->where('duplicate',0)->get()->row('cnt');	
			$seat []= array(
				    $row->category_name,
				    json_decode($admission),
				    json_decode($row->cnt)
				  ); 
         	}
		}

		$center []= array('Center','Application','Seat');
		$CenterSeat =  $this->db->query("SELECT * FROM seat_master GROUP by study_center order by study_center desc");
		if($CenterSeat->result())
		{
			
			foreach ($CenterSeat->result() as $rows)
			{
			$admission = $this->db->select('count(*) as cnt')->from('candidate_data')->where('admission',1)->where('final_study_center',$rows->study_center)->where('duplicate',0)->get()->row('cnt');	
			$center []= array(
				    $rows->study_center,
				    json_decode($admission),
				    json_decode($rows->total_seat)
				  ); 
         	}
		}

		$q = $this->db->query('SELECT count(*) as total, know_iittm as source FROM candidate_data GROUP BY know_iittm');
		$data  = $q->result_array();
			
		$output[] = array('source','value');

		foreach($q->result_array() as $row)
		{
		    $output[] = array(
		       $row["source"]??'N/A',
		       $row["total"]
		    );
		}
		$source_data = $output;
  	
		//print_r($seat);
		//print_r($gender);

	

		$this->load->view($this->folder."admission_graphical",array('category'=>$catList,'gender'=>$genderList,'religion'=>$religionList,'statelist' =>$statelist,'districtlist'=>$districtlist,'categorybar'=>$seat,'center'=> $center, 'source_chart' => $source_data));

	}

	public function search_by_course()
	{

		$course = $this->input->get('data');
		$query = $this->db->query("SELECT * FROM candidate_data WHERE admission = 1 AND course_name ='$course'");
  		$data = [];
      	$n=0;
      	foreach($query->result() as $candidate_data) {


      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($candidate_data->course_name==1){$course = "BBA";}
				if($candidate_data->course_name==2){$course = "MBA";}

      			if($candidate_data->course_name==1){$fullname = "".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."";}
			
				if($candidate_data->course_name==2){$fullname = "".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name;
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
      		}
      		

      		$n++;
      		
			$draw ="";
			
           $data[] = array(
           		$n,
				'0000'.$candidate_data->mobile_verified_id,
				$course,
           		$fullname,
                $candidate_data->mobile,
                $email,
                $gender,
				$category,
                $dob,
				$candidate_data->father_name,
				$candidate_data->father_mobile,
				$candidate_data->mother_name,
				$candidate_data->mather_mobile,
				$candidate_data->father_email,
				$candidate_data->religion,
				$parma_address,
                $parma_state,
                $parma_city,
				$corre_address,
                $corre_state,
                $corre_city,
				$college,
                $university,
				$academic_year,
				$obt,
				$academic_percentage,
                $study_center1,
				$study_center2,
				$study_center3,
				$study_center4,
				$candidate_data->final_study_center,
                date("d-M-Y", strtotime($candidate_data->post_date))
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


	public function search_by_center()
	{

		$center = $this->input->get('data');
		$query = $this->db->query("SELECT * FROM candidate_data WHERE admission = 1 AND final_study_center ='$center'");
  		$data = [];
      	$n=0;
      	foreach($query->result() as $candidate_data) {


      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($candidate_data->course_name==1){$course = "BBA";}
				if($candidate_data->course_name==2){$course = "MBA";}

      			if($candidate_data->course_name==1){$fullname = "".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."";}
			
				if($candidate_data->course_name==2){$fullname = "".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name;
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
      		}
      		

      		$n++;
      		
			$draw ="";
			
           $data[] = array(
           		$n,
				'0000'.$candidate_data->mobile_verified_id,
				$course,
           		$fullname,
                $candidate_data->mobile,
                $email,
                $gender,
				$category,
                $dob,
				$candidate_data->father_name,
				$candidate_data->father_mobile,
				$candidate_data->mother_name,
				$candidate_data->mather_mobile,
				$candidate_data->father_email,
				$candidate_data->religion,
				$parma_address,
                $parma_state,
                $parma_city,
				$corre_address,
                $corre_state,
                $corre_city,
				$college,
                $university,
				$academic_year,
				$obt,
				$academic_percentage,
                $study_center1,
				$study_center2,
				$study_center3,
				$study_center4,
				$candidate_data->final_study_center,
                date("d-M-Y", strtotime($candidate_data->post_date))
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

	public function default_list()
	{
		$query = $this->db->query("SELECT * FROM candidate_data WHERE admission = 1");
  		$data = [];
      	$n=0;
      	foreach($query->result() as $candidate_data) {


      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($candidate_data->course_name==1){$course = "BBA";}
				if($candidate_data->course_name==2){$course = "MBA";}

      			if($candidate_data->course_name==1){$fullname = "".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."";}
			
				if($candidate_data->course_name==2){$fullname = "".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name;
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
      		}
      		

      		$n++;
      		
			$draw ="";
			
           $data[] = array(
           		$n,
				'0000'.$candidate_data->mobile_verified_id,
				$course,
           		$fullname,
                $candidate_data->mobile,
                $email,
                $gender,
				$category,
                $dob,
				$candidate_data->father_name,
				$candidate_data->father_mobile,
				$candidate_data->mother_name,
				$candidate_data->mather_mobile,
				$candidate_data->father_email,
				$candidate_data->religion,
				$parma_address,
                $parma_state,
                $parma_city,
				$corre_address,
                $corre_state,
                $corre_city,
				$college,
                $university,
				$academic_year,
				$obt,
				$academic_percentage,
                $study_center1,
				$study_center2,
				$study_center3,
				$study_center4,
				$candidate_data->final_study_center,
                date("d-M-Y", strtotime($candidate_data->post_date))
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



	public function getdetails_paymentid($paymentid)  
	{
		 
		$curl = curl_init();
		  curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.razorpay.com/v1/payments/".$paymentid,
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
		$rr = json_decode($response, true);
		$list = array(); 
		return $rr;

	}

	public function server_side()
	{
		$db = get_instance()->db->conn_id;
		$limit = "";
		$tableColumns = array('user_mobile', 'amount', 'created_date');
		$primaryKey = "user_id";

		if (isset($_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
		  $limit = "LIMIT ".mysqli_real_escape_string($db,$_GET['iDisplayStart'] ).", ".
		    mysqli_real_escape_string($db,$_GET['iDisplayLength'] );
		}

		/*
		 * Ordering
		 */
		if ( isset( $_GET['iSortCol_0'] ) )
		{
		  $orderBy = "ORDER BY  ";
		  for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		  {
		    if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
		    {
		      $orderBy .= $tableColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
		        ".mysqli_real_escape_string($db,$_GET['sSortDir_'.$i] ) .", ";
		    }
		  }
		  
		  $orderBy = substr_replace( $orderBy, "", -2 );
		  if ( $orderBy == "ORDER BY" )
		  {
		    $orderBy = "";
		  }
		}


		/* 
		 * Filtering
		 */
		$whereCondition = "";
		if ( $_GET['sSearch'] != "" )
		{
		  $whereCondition = "WHERE (";
		  for ( $i=0 ; $i<count($tableColumns) ; $i++ )
		  {
		    $whereCondition .= $tableColumns[$i]." LIKE '%".mysqli_real_escape_string($db,$_GET['sSearch'] )."%' OR ";
		  }
		  $whereCondition = substr_replace( $whereCondition, "", -3 );
		  $whereCondition .= ')';
		}

		/* Individual column filtering */
		for ( $i=0 ; $i<count($tableColumns) ; $i++ )
		{
		  if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		  {
		    if ( $whereCondition == "" )
		    {
		      $whereCondition = "WHERE ";
		    }
		    else
		    {
		      $whereCondition .= " AND ";
		    }
		    $whereCondition .= $tableColumns[$i]." LIKE '%".mysqli_real_escape_string($db,$_GET['sSearch_'.$i])."%' ";
		  }
		}
		  
		  

		$sql = "SELECT * FROM user_master $whereCondition $orderBy $limit";
		// echo $sql;die;
		$result = $db->query($sql);

		$sql1 = "SELECT count(".$primaryKey.") from user_master";
		$result1 = $db->query($sql1);
		$totalRecord=$result1->fetch_array();

		$data=array();
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
		  $data[] = $row;
		}


		$output = ["sEcho" => intval($_GET['sEcho']),
		          "iTotalRecords" => $totalRecord[0],
		          "iTotalDisplayRecords" => $totalRecord[0],
		          "aaData" => $data ];

		echo json_encode($output);
	}



	public function defaule_tansactions()
	{
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}

		$db = get_instance()->db->conn_id;
		$limit = "";
		$primaryKey = "user_id";
		$tableColumns = array('user_mobile');

		if (isset($_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
		  $limit = "LIMIT ".mysqli_real_escape_string($db,$_GET['iDisplayStart'] ).", ".
		    mysqli_real_escape_string($db,$_GET['iDisplayLength'] );
		}


		$whereCondition = "where login_status = 2 AND razorpay_trans_id !=''";
		if ( $_GET['sSearch'] != "" )
		{
		  $whereCondition = "WHERE (";
		  for ( $i=0 ; $i<count($tableColumns) ; $i++ )
		  {
		    $whereCondition .= $tableColumns[$i]." LIKE '%".mysqli_real_escape_string($db,$_GET['sSearch'] )."%' OR ";
		  }
		  $whereCondition = substr_replace( $whereCondition, "", -3 );
		  $whereCondition .= ')';
		}

		/* Individual column filtering */
		for ( $i=0 ; $i<count($tableColumns) ; $i++ )
		{
		  if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		  {
		    if ( $whereCondition == "" )
		    {
		      $whereCondition = "WHERE ";
		    }
		    else
		    {
		      $whereCondition .= " AND ";
		    }
		    $whereCondition .= $tableColumns[$i]." LIKE '%".mysqli_real_escape_string($db,$_GET['sSearch_'.$i])."%' ";
		  }
		}

		//$sql = "SELECT * FROM user_master $whereCondition $orderBy $limit";
		$query = $this->db->query("SELECT * FROM user_master $whereCondition $limit");

		$sql1 = "SELECT count(".$primaryKey.") from user_master WHERE login_status = 2 and razorpay_trans_id !=''";
		$result1 = $db->query($sql1);
		$totalRecord=$result1->fetch_array();

  		$data = [];	
  		$draw ="";
  			$n=1;
  		foreach($query->result() as $candidate_data) {
  			
  			$raz_details = $this->getdetails_paymentid($candidate_data->razorpay_trans_id);


  			if($candidate_data->course_id==1){$course="BBA";}
  			if($candidate_data->course_id==2){$course="MBA";}

  			$can_date = $this->db->select("email_id,first_name,middle_name,last_name")->from("candidate_data")->where("mobile_verified_id",$candidate_data->user_id)->get()->row();

  			if(isset($raz_details['id']) !=''){$account ="<span style='color:green; font-weight:bold;'>IITTM</span>";} else{$account="<span style='color:red; font-weight:bold;'>e-Biz</span>";}

  			//print_r($raz_details);
  			if(isset($raz_details['created_at']) !=''){$date=date("d-m-Y", $raz_details['created_at']);} else{$date="";}
			if(isset($raz_details['amount']) !=''){$amt=$raz_details['amount']/100;}else{$amt=0;}
			if(isset($raz_details['fee']) !=''){$fee=$raz_details['fee']/100;}else{$fee=0;}
			if(isset($raz_details['tax']) !=''){$tax=$raz_details['tax']/100;}else{$tax=0;}
  			$data[] = array(
           		$n,
           		$course,
           		$can_date->first_name." ".$can_date->middle_name." ".$can_date->last_name,
				$can_date->email_id."".$candidate_data->razorpay_trans_id,
                $candidate_data->user_mobile,
                $account,
                isset($raz_details['id'])?$raz_details['id']:"",
                isset($raz_details['bank'])?$raz_details['bank']:"",
                isset($raz_details['method'])?$raz_details['method']:"",
                $amt,
                $fee,
                $tax,
                isset($raz_details['refund_status'])?$raz_details['refund_status']:"",
                $date,
           );
  			$n++;

  		}

  		$result = array(
  					 "sEcho" =>intval($_GET['sEcho']),
	               	 "draw" => $draw,
	                 "iTotalRecords" =>  $totalRecord[0],
	                 "iTotalDisplayRecords" => $totalRecord[0],
	                 "data" => $data
	      );

	  echo json_encode($result);
      exit();

	}

	public function tansactions()
	{
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}

		
		$this->load->view($this->folder."tansactions");

	}




	public function list_admission()
	{
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}

		$query = $this->db->query("SELECT * FROM candidate_data WHERE admission = 1");
  		$data = [];
      	$n=0;
      	foreach($query->result() as $candidate_data) {


      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($candidate_data->course_name==1){$course = "BBA";}
				if($candidate_data->course_name==2){$course = "MBA";}

      			if($candidate_data->course_name==1){$fullname = "<a href='show_form_bba/$candidate_data->mobile_verified_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($candidate_data->course_name==2){$fullname = "<a href='show_form_mba/$candidate_data->mobile_verified_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name;
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
      		}
      		

      		$n++;
      		
		
			
           $data[] = array(
           		$n,
				'0000'.$candidate_data->mobile_verified_id,
				$course,
           		$fullname,
                $candidate_data->mobile,
                $email,
                $gender,
				$category,
                $dob,
				$candidate_data->father_name,
				$candidate_data->father_mobile,
				$candidate_data->mother_name,
				$candidate_data->mather_mobile,
				$candidate_data->father_email,
				$candidate_data->religion,
				$parma_address,
                $parma_state,
                $parma_city,
				$corre_address,
                $corre_state,
                $corre_city,
				$college,
                $university,
				$academic_year,
				$obt,
				$academic_percentage,
                $study_center1,
				$study_center2,
				$study_center3,
				$study_center4,
				$candidate_data->final_study_center,
                date("d-M-Y", strtotime($candidate_data->post_date))
           );
      }

	      /*$result = array(
	               	 "draw" => $draw,
	                 "recordsTotal" => $query->num_rows(),
	                 "recordsFiltered" => $query->num_rows(),
	                 "data" => $data
	      );*/


      //echo json_encode($result);
     // exit();


		$this->load->view($this->folder."list_admission",array('list'=>$data));
	}


   public function dashboard()
	{	
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
		

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://api.msg91.com/api/balance.php?authkey=322873AxMkWjplhxu5e6a21f3P1&type=4",
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
		$study_center5 = $this->adminmodel->study_center5(''); 

		$gdpi_center_1 = $this->adminmodel->gdpi_center_1('');
		$gdpi_center_2 = $this->adminmodel->gdpi_center_2('');
		$gdpi_center_3 = $this->adminmodel->gdpi_center_3('');
		$gdpi_center_4 = $this->adminmodel->gdpi_center_4('');
		$gdpi_center_5 = $this->adminmodel->gdpi_center_5(''); 

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



			// $q = $this->db->query('SELECT count(*) as total, know_iittm as name FROM candidate_data GROUP BY know_iittm');
			// $data  = $q->result_array();
				
			// $output[] = array('name','value');

			// foreach($q->result_array() as $row)
			// {
			//     $output[] = array(
			//        $row["name"]??'N/A',
			//        $row["total"]
			//     );
			// }
			// $source_data = $output;	




		$g =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Google'")->row('count');

		$n =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Newspaper'")->row('count');

		$s =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Social Media'")->row('count');


		$w =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Word of mouth'")->row('count');

		$c =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Career counselling session'")->row('count');


		$source_data = [['name','value'],
		['Google', json_decode($g)],
		['Newspaper', json_decode($n)], 
		['Social Media', json_decode($s)], 
		['Word of mouth', json_decode($w)], 
		['Career counselling session', json_decode($c)],
		];

		// $source_data[] = array('Google', 'Newspaper', 'Social Media', 'Word of mouth', 'Career counselling session');
		// $source_data[] = array(intval($g), intval($n), intval($s), intval($w), intval($c));



		$ee = $this->adminmodel->candidate('');
		$fee_data = $this->adminmodel->fees('');
		$settelment = $this->get_settelment();



		$this->load->view($this->folder."new_dashboard",array('balance'=>$response,'total_regis'=>$total_regis,'today_candidate'=>$today_candidate,'total_inc'=>$total_inc,'today_inc'=>$today_inc,'total_fee'=>$total_fee,'today_fee'=>$today_fee,'category'=>$category,'gender'=>$gender,'academic'=>$academic,'religion'=>$religion,'study_center1'=>$study_center1,'study_center2'=>$study_center2,'study_center3'=>$study_center3,'study_center4'=>$study_center4,'study_center5'=>$study_center5,'gdpi_center_1'=>$gdpi_center_1,'gdpi_center_2'=>$gdpi_center_2,'gdpi_center_3'=>$gdpi_center_3,'gdpi_center_4'=>$gdpi_center_4,'gdpi_center_5'=>$gdpi_center_5,'Appearing'=>$Appearing,'candidate'=>$ee,'settelment'=>$settelment,'fees'=>$fee_data,'source_chart'=>$source_data));

	}


	public function chartdata_bba()
	{
		$this->load->view($this->folder."chart_graphical_bba",array());
	}

	public function chartdata_mba()
	{
		$this->load->view($this->folder."chart_graphical_mba",array());
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
			$study_center5 = $this->adminmodel->study_center5($course_id); 


			$gdpi_center_1 = $this->adminmodel->gdpi_center_1($course_id);
			$gdpi_center_2 = $this->adminmodel->gdpi_center_2($course_id);
			$gdpi_center_3 = $this->adminmodel->gdpi_center_3($course_id);
			$gdpi_center_4 = $this->adminmodel->gdpi_center_4($course_id);
			$gdpi_center_5 = $this->adminmodel->gdpi_center_5($course_id); 


			$ram = array('total_regis'=>$total_regis,'today_candidate'=>$today_candidate,'total_inc'=>$total_inc,'today_inc'=>$today_inc,'total_fee'=>$total_fee,'today_fee'=>$today_fee,'category'=>$category,'gender'=>$gender,'religion'=>$religion,'academic'=>$academic,'Appearing'=>$Appearing,'study_center1'=>$study_center1,'study_center2'=>$study_center2,'study_center3'=>$study_center3,'study_center4'=>$study_center4,'study_center5'=>$study_center5,'gdpi_center_1'=>$gdpi_center_1,'gdpi_center_2'=>$gdpi_center_2,'gdpi_center_3'=>$gdpi_center_3,'gdpi_center_4'=>$gdpi_center_4,'gdpi_center_5'=>$gdpi_center_5);

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
	
	
	public function final_report()
	{
		$whr = "test_center_status=1";
		$data['centers'] = $this->db_lib->fetchRecords('final_test_center',$whr,'*');
		$this->load->view($this->folder."final_report",$data);
	}

	public function final_report_get()
	{
		$data['list']="";
		$amount = $this->input->get('data');
		if($amount !="")
		{
			$where = "UM.amount = '$amount' and UM.login_status = '2' and UM.razorpay_trans_id !='' and CD.duplicate=0";
			$records = $this->db_lib->fetchRecords('user_master UM INNER JOIN candidate_data CD ON UM.user_id = CD.mobile_verified_id',$where,'CD.first_name,CD.category,CD.study_centre_1,UM.course_id,UM.created_date,UM.user_id');
			$data['list'] = $records;
		}
		
		
		echo json_encode($data);

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
       
		$where = "mobile_verified_id = '$user_id' AND duplicate=0";
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
       
		$where = "mobile_verified_id = '$user_id' AND duplicate=0";
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
		  CURLOPT_URL => "https://api.razorpay.com/v1/payments?count=100&skip=$count&from=1612310400",
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
		  CURLOPT_URL => "https://api.razorpay.com/v1/payments?count=100&skip=$count&from=1612310400",
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


     //$query = $this->db->query("SELECT *,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city FROM user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city WHERE candidate_data.duplicate=0"); 

      $query = $this->db->query("SELECT * FROM user_master order by user_id desc"); 


      $data = [];

      $n=0;
      foreach($query->result() as $r) {

      		$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = ".$r->user_id." AND duplicate = 0")->get()->row(); 

      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
	      	

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$study_center1 = $candidate_data->study_centre_1;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = isset($corre_state_data->name);
				$corre_city = $corre_city_data->name;
      		}
      		

      		$n++;
      		$amount = ($r->amount)/100;
      		$tranid = $r->razorpay_trans_id;

			if($r->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 

			if($r->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}
			
			

           $data[] = array(
           		$n,
           		$fullname,
                $r->user_mobile,
                $email,
                $gender,
                $parma_state,
                $parma_city,
                $corre_state,
                $corre_city,
                $university,
                $appr_center_1,
                $gdpi_center_1,
                $study_center1,
                $category,
                $dob,
                $tranid,
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


   public function filter_mobile()
	{
	  
	  $draw = intval($this->input->get("draw"));
      $start = intval(1);
      $length = intval(5);

	  $mobile = $this->input->get('data');
	  $query = $this->db->query("SELECT * FROM user_master WHERE user_mobile = '$mobile' AND login_status = 2");
		

      $data = [];
      $n=0;
      foreach($query->result() as $r) {

      		$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = ".$r->user_id." AND duplicate = 0")->get()->row(); 

      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($r->course_id==1){$course = "BBA";}
				if($r->course_id==2){$course = "MBA";}

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name;
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
      		}
      		

      		$n++;
      		$amount = ($r->amount)/100;
      		$tranid = $r->razorpay_trans_id;

			if($r->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 

			if($r->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}
			
			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";
			
           $data[] = array(
           		$n,
				'0000'.$r->user_id,
				$course,
           		$fullname,
                $r->user_mobile,
                $email,
                $gender,
				$category,
                $dob,
				$candidate_data->father_name,
				$candidate_data->father_mobile,
				$candidate_data->mother_name,
				$candidate_data->mather_mobile,
				$candidate_data->father_email,
				$candidate_data->religion,
				$parma_address,
                $parma_state,
                $parma_city,
				$corre_address,
                $corre_state,
                $corre_city,
				$college,
                $university,
				$academic_year,
				$obt,
				$academic_percentage,
                $appr_center_1,
				$appr_center_2,
				$appr_center_3,
				$appr_center_4,
                $gdpi_center_1,
				$gdpi_center_2,
				$gdpi_center_3,
				$gdpi_center_4,
                $study_center1,
				$study_center2,
				$study_center3,
				$study_center4,
                $tranid,
                $amount,
                $sts_btn,
				$admit_btn,
				date("d-M-Y", strtotime($r->created_date)),
				date("d-M-Y", strtotime($candidate_data->post_date))
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
		$course = $str_arr[3];

		if($from=="" && $to=="")
		{
			$query = $this->db->query("SELECT * FROM user_master WHERE course_id in ($course) AND login_status = 2");
		}
		else
		{
			
			//$query = $this->db->query("SELECT * FROM user_master WHERE course_id in ($course) AND created_date BETWEEN '$from' AND '$to 23:59:59' and login_status = 2");

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id WHERE um.course_id in ($course) AND ca.post_date BETWEEN '$from' AND '$to 23:59:59' AND um.login_status = 2");
		}


      $data = [];
      $n=0;
      foreach($query->result() as $r) {

      		$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = ".$r->user_id." AND duplicate = 0")->get()->row(); 

      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($r->course_id==1){$course = "BBA";}
				if($r->course_id==2){$course = "MBA";}

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name;
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
      		}
      		

      		$n++;
      		if($r->amount > 0){
      		$amount = ($r->amount)/100;
      		}else{$amount ="";}
      		$tranid = $r->razorpay_trans_id;

			if($r->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 

			if($r->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}
			
			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			
			
           $data[] = array(
           		$n,
				'0000'.$r->user_id,
				$course,
           		$fullname,
                $r->user_mobile,
                $email,
                $gender,
				$category,
                $dob,
				$candidate_data->father_name??'',
				$candidate_data->father_mobile??'',
				$candidate_data->mother_name??'',
				$candidate_data->mather_mobile??'',
				$candidate_data->father_email??'',
				$candidate_data->religion??'',
				$parma_address,
                $parma_state,
                $parma_city,
				$corre_address,
                $corre_state,
                $corre_city,
				$college,
                $university,
				$academic_year,
				$obt,
				$academic_percentage,
                $appr_center_1,
				$appr_center_2,
				$appr_center_3,
				$appr_center_4,
                $gdpi_center_1,
				$gdpi_center_2,
				$gdpi_center_3,
				$gdpi_center_4,
                $study_center1,
				$study_center2,
				$study_center3,
				$study_center4,
                $tranid,
                $amount,
                $sts_btn,
				$admit_btn,
				date("d-M-Y", strtotime($r->created_date??'')),
				date("d-M-Y", strtotime($candidate_data->post_date??''))
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


	public function create_admission()
	{	

		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
		$this->load->view($this->folder."create_admission");
	}



	public function search_admission()
	{
		$draw = intval($this->input->get("draw"));
      	$start = intval(1);
      	$length = intval(5);

		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  		
		$from = $str_arr[0];
		$to = $str_arr[1];
		$statu_get = $str_arr[2];
		$course = $str_arr[3];

		if($from=="" && $to=="")
		{
			$query = $this->db->query("SELECT * FROM user_master WHERE course_id in ($course) AND login_status = 2");
		}
		else
		{
			
			//$query = $this->db->query("SELECT * FROM user_master WHERE course_id in ($course) AND created_date BETWEEN '$from' AND '$to 23:59:59' and login_status = 2");

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id WHERE um.course_id in ($course) AND ca.post_date BETWEEN '$from' AND '$to 23:59:59' AND um.login_status = 2");
		}


      $data = [];
      $n=0;
      foreach($query->result() as $r) {

      		$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = ".$r->user_id." AND duplicate = 0")->get()->row(); 

      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($r->course_id==1){$course = "BBA";}
				if($r->course_id==2){$course = "MBA";}

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name;
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
      		}
      		

      		$n++;
      		$amount = ($r->amount)/100;
      		$tranid = $r->razorpay_trans_id;

			if($r->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 

			if($r->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}
			
			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			if($candidate_data->admission ==1){$check="checked"; $disabled="disabled";} else{$check=""; $disabled="";}

			$chk = "<input type='checkbox' name='check' value='$r->user_id' class='chk_popup' $check  $disabled/>";
			
           $data[] = array(
           		$chk,
           		$n,
				'0000'.$r->user_id,
				$course,
           		$fullname,
                $r->user_mobile,
                $email,
                $gender,
				$category,
                $dob,
				$candidate_data->father_name,
				$candidate_data->father_mobile,
				$candidate_data->mother_name,
				$candidate_data->mather_mobile,
				$candidate_data->father_email,
				$candidate_data->religion,
				$parma_address,
                $parma_state,
                $parma_city,
				$corre_address,
                $corre_state,
                $corre_city,
				$college,
                $university,
				$academic_year,
				$obt,
				$academic_percentage,
                $study_center1,
				$study_center2,
				$study_center3,
				$study_center4,
             	$candidate_data->final_study_center,
				date("d-M-Y", strtotime($candidate_data->post_date))
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


	 public function search_admission_mobile()
	{
	  
	  $draw = intval($this->input->get("draw"));
      $start = intval(1);
      $length = intval(5);

	  $mobile = $this->input->get('data');
	  $query = $this->db->query("SELECT * FROM user_master WHERE user_mobile = '$mobile' AND login_status = 2");
		

      $data = [];
      $n=0;
      foreach($query->result() as $r) {

      		$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = ".$r->user_id." AND duplicate = 0")->get()->row(); 

      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($r->course_id==1){$course = "BBA";}
				if($r->course_id==2){$course = "MBA";}

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name;
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
      		}
      		

      		$n++;
      		$amount = ($r->amount)/100;
      		$tranid = $r->razorpay_trans_id;

			if($r->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 

			if($r->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}

			if($candidate_data->admission ==1){$check="checked"; $disabled="disabled";} else{$check=""; $disabled="";}
			
			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$chk = "<input type='checkbox' name='check' value='$r->user_id' class='chk_popup' $check $disabled/>";

            $data[] = array(
           	$chk,
           		$n,
				'0000'.$r->user_id,
				$course,
           		$fullname,
                $r->user_mobile,
                $email,
                $gender,
				$category,
                $dob,
				$candidate_data->father_name,
				$candidate_data->father_mobile,
				$candidate_data->mother_name,
				$candidate_data->mather_mobile,
				$candidate_data->father_email,
				$candidate_data->religion,
				$parma_address,
                $parma_state,
                $parma_city,
				$corre_address,
                $corre_state,
                $corre_city,
				$college,
                $university,
				$academic_year,
				$obt,
				$academic_percentage,
                $study_center1,
				$study_center2,
				$study_center3,
				$study_center4,
				$candidate_data->final_study_center,
				date("d-M-Y", strtotime($candidate_data->post_date))
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


	public function update_admission()
	{
		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  
		
		 $final_study_center = $str_arr[0];
		 $candidate_id = $str_arr[1];
		

		 $where = "mobile_verified_id = '$candidate_id' and duplicate='0'";
		 $cate_data = array(
			'admission' => 1,
			'final_study_center' => $final_study_center,
			);
		$rst = $this->db_lib->update('candidate_data',$cate_data,$where);
		if($rst>0)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}


	public function form_update_request()
	{
		
		$rst_form_data = $this->db_lib->fetchRecords('update_form','','*');
		$this->load->view($this->folder."form_update_request",array('result'=>$rst_form_data));
	}
	
	public function admit_card()
	{
		
		$rst_form_data = $this->db_lib->fetchRecords('update_form','','*');
		$this->load->view($this->folder."admit_card",array('result'=>$rst_form_data));
	}


	public function test_center_finalization()
	{
		
		$data['center'] = $this->db_lib->fetchRecords('final_test_center','','*');
		$this->load->view($this->folder."test_center_finalization",$data);
	}

	public function test_center_finalization_checked_post()
	{
		$test_center_id = $this->input->get('data');
		$where = "test_center_id = '$test_center_id'";
		$data = array(
			'test_center_status' => 1,
			'post_date' => date("Y-m-d H:i:s")
			);
		$rst = $this->db_lib->update('final_test_center',$data,$where);
		if($rst>0)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}

	}


	public function test_center_finalization_unchecked_post()
	{
		$test_center_id = $this->input->get('data');
		$where = "test_center_id = '$test_center_id'";
		$data = array(
			'test_center_status' => 0,
			'post_date' => date("Y-m-d H:i:s")
			);
		$rst = $this->db_lib->update('final_test_center',$data,$where);
		if($rst>0)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}

	}


	public function align_test_center()
	{
		$whr = "test_center_status=1";
		$data['centers'] = $this->db_lib->fetchRecords('final_test_center',$whr,'*');
		$this->load->view($this->folder."align_test_center",$data);
	}



	public function align_test_center_get()
	{
		
		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  		
		$course_id = $str_arr[0];
		$study_center = $str_arr[1];
		$study_center_id = $str_arr[2];

		if($course_id !="")
		{
			$where = "course_id = '$course_id' and login_status = '2' and razorpay_trans_id !=''";
			$rst = $this->db_lib->fetchRecords('user_master',$where,'count(*) as count');
			$records = $this->db_lib->fetchRecords('user_master UM INNER JOIN candidate_data CD ON UM.user_id = CD.mobile_verified_id',$where,'CD.first_name,CD.study_centre_1,CD.study_centre_2,CD.study_centre_3,CD.study_centre_4,UM.user_id');
			$data['total_application'] = $rst[0]['count'];
			$data['list'] = $records;
		}
		if($study_center !="")
		{

			$where = "UM.razorpay_trans_id !='' and UM.login_status='2' and UM.course_id = '$course_id' and CD.duplicate !=1 AND CD.study_centre_1 ='$study_center'";
			$rst = $this->db_lib->fetchRecords('user_master UM INNER JOIN candidate_data CD ON UM.user_id = CD.mobile_verified_id',$where,'count(*) as count');
			$records = $this->db_lib->fetchRecords('user_master UM INNER JOIN candidate_data CD ON UM.user_id = CD.mobile_verified_id',$where,'CD.first_name,CD.study_centre_1,CD.study_centre_2,CD.study_centre_3,CD.study_centre_4,UM.user_id');
			$data['total_application'] = $rst[0]['count'];
			$data['list'] = $records;

		}

		$where_assign_center = "course_id = '$course_id' and test_center_id = '$study_center_id'";
		$rst_assign_center = $this->db_lib->fetchRecords('test_center_assign_candidate',$where_assign_center,'count(*) as count');
		$arr_assign_center = $this->db_lib->fetchRecords('test_center_assign_candidate',$where_assign_center,'candidate_id');
		$data['total_center'] = $rst_assign_center[0]['count'];

		$ram = array();
		for ($i=0; $i < is_countable($arr_assign_center); $i++) { 
			array_push($ram, $arr_assign_center[$i]['candidate_id']);
		}

		$data['arr_total_center'] = $ram;
		$ram = array('data'=>$data);
		echo json_encode($data);

	}


	public function align_center_post()
	{
		$course_id = $_POST['get_course'];
		$assign_test_center = $_POST['assign_test_center'];
		$count_check = count($_POST['checkAll']);

		$whereDel = "course_id='$course_id' AND test_center_id='$assign_test_center'";
		
		$delete = $this->db_lib->delete("test_center_assign_candidate",$whereDel);

		for($i=0; $i < $count_check; $i++) 
		{ 
			$userData = array(
				'course_id' => $course_id,
				'candidate_id' => $_POST['checkAll'][$i],
				'test_center_id' => $assign_test_center,
				'post_date'=> date("Y-m-d H:i:s"),
			);

			$last_id = $this->db_lib->insert('test_center_assign_candidate',$userData,'');
		}


		if($last_id>0)
		{
			 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-info'></i> Success!</h4>Record Insert Successfully!</div>");
			 redirect("admin/align_test_center");
		}
		else
		{
			setFlash("ViewMsgWarning","<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-info'></i> Failed!</h4>Something went wrong!</div>");
			redirect("admin/align_test_center");
		}


	}


	public function generate_admit_card()
	{
		$user_id = $this->uri->segment(3);
		$whr = "mobile_verified_id='$user_id' AND duplicate !=1";
		$data['data'] = $this->db_lib->fetchRecords('user_master UM INNER JOIN candidate_data CD ON UM.user_id = CD.mobile_verified_id',$whr,'CD.first_name,CD.middle_name,CD.last_name,CD.father_name,CD.mother_name,CD.parma_appertment,CD.parma_colony,CD.study_centre_1,CD.mobile,CD.candidate_photo,UM.course_id');
		$this->load->view($this->folder."generate_admit_card",$data);
	}



	public function yearwiseregistration()
	{


		$secound_db = $this->load->database('2021', TRUE);
		$third_db = $this->load->database('2022', TRUE);
		$four_db = $this->load->database('2023', TRUE);
		$five_db = $this->load->database('2024', TRUE);
		$six_db = $this->load->database('2020', TRUE);



		$first =  $this->db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !=''")->row('count');

		$first_admission =  $this->db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1")->row('count');

		$secound =  $secound_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !=''")->row('count');

		$secound_admission =  $secound_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1")->row('count');

		$third =  $third_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !=''")->row('count');

		$third_admission =  $third_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1")->row('count');

		$four =  $four_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !=''")->row('count');

		$four_admission =  $four_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1")->row('count');

		$five =  $five_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !=''")->row('count');

		$five_admission =  $five_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1")->row('count');

		$six =  $six_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !=''")->row('count');

		$six_admission =  $six_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1")->row('count');
		
				
		$seat[] = array('Year', 'Registration', 'Admission');
		$seat[] = array('2020', intval($six), intval($six_admission));
		$seat[] = array('2021', intval($secound), intval($secound_admission));
		$seat[] = array('2022', intval($third), intval($third_admission));
		$seat[] = array('2023', intval($four), intval($four_admission));
		$seat[] = array('2024', intval($five), intval($five_admission));
		$seat[] = array('2024', intval($first), intval($first_admission));
		
		



		$first_gwalior =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$first_bhu =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$first_noi =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$first_nellor =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$first_goa =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$secound = $this->load->database('2021', TRUE);

		$secound_gwl =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$secound_bhu =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$secound_noi =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$secound_nellor =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$secound_goa =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$third = $this->load->database('2022', TRUE);

		$third_gwl =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$third_bhu =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$third_noi =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$third_nellor =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$third_goa =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$four = $this->load->database('2023', TRUE);

		$four_gwl =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$four_bhu =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$four_noi =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$four_nellor =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$four_goa =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$five = $this->load->database('2024', TRUE);

		$five_gwl =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$five_bhu =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$five_noi =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$five_nellor =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$five_goa =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');



		$six = $this->load->database('2020', TRUE);
		
		$six_gwl =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$six_bhu =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$six_noi =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');

		$six_nellor =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');


		$six_goa =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1")->row('count');



		$city[]= array('City', '2020', '2021' ,'2022', '2023', '2024', '2025');
		$city[]=  array('Gwalior',intval($six_gwl) , intval($secound_gwl), intval($third_gwl), intval($four_gwl), intval($five_gwl), intval($first_gwalior));
		$city[]=  array('Bhubaneswar', intval($six_bhu), intval($secound_bhu), intval($third_bhu), intval($four_bhu), intval($five_bhu), intval($first_bhu));
		$city[]=  array('Noida',intval($six_noi) , intval($secound_noi), intval($third_noi), intval($four_noi), intval($five_noi),intval($first_noi));
		$city[]=  array('Nellore',intval($six_nellor) , intval($secound_nellor), intval($third_nellor), intval($five_nellor), intval($four_nellor),intval($first_nellor));
		$city[]=  array('Goa', intval($six_goa), intval($secound_goa), intval($third_goa), intval($four_goa), intval($five_goa),intval($first_goa));
		
	


		$g25 =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Google'")->row('count');

		$g24 =  $five->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Google'")->row('count');

		$g23 =  $four->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Google'")->row('count');

		


		$n25 =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Newspaper'")->row('count');

		$n24 =  $five->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Newspaper'")->row('count');

		$n23 =  $four->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Newspaper'")->row('count');

	


		$s25 =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Social Media'")->row('count');

		$s24 =  $five->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Social Media'")->row('count');

		$s23 =  $four->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Social Media'")->row('count');

	


		$w25 =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Word of mouth'")->row('count');

		$w24 =  $five->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Word of mouth'")->row('count');

		$w23 =  $four->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Word of mouth'")->row('count');


		$c25 =  $this->db->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Career counselling session'")->row('count');

		$c24 =  $five->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Career counselling session'")->row('count');

		$c23 =  $four->query("SELECT count(*) as count, know_iittm as name FROM candidate_data where know_iittm = 'Career counselling session'")->row('count');

		

		$source[] = array('Source', '2023', '2024', '2025');
		$source[] = array('Google', intval($g23), intval($g24), intval($g25));
		$source[] = array('Newspaper', intval($n23), intval($n24), intval($n25));
		$source[] = array('Social Media', intval($s23), intval($s24), intval($s25));
		$source[] = array('Word of mouth', intval($w23), intval($w24), intval($w25));
		$source[] = array('Career counselling session',intval($c23), intval($c24), intval($c25));
		
		


		
		$this->load->view($this->folder."year_wise_registration",array('chart' => $seat, 'citychart' => $city,'source_chart'=>$source ));
	}

	public function institute_wise_report()
	{
		$uery =  $this->db->query("SELECT academic_intermediate ,count(*) as total, states.name as state,cities.name as city FROM candidate_data LEFT join states on states.id = candidate_data.parma_state LEFT join cities on cities.id = candidate_data.parma_city where academic_intermediate !='' GROUP by academic_intermediate order by states.name"); 
		$list = $uery->result();	
		$this->load->view($this->folder."institute_wise_report",array('districtlist'=>$list));
	}

	public function institute_wise_report_filter()
	{

		$course = $this->input->get('data');
		$uery =  $this->db->query("SELECT academic_intermediate ,count(*) as total, states.name as state,cities.name as city FROM `candidate_data` inner join user_master um on um.user_id = candidate_data.mobile_verified_id LEFT join states on states.id = candidate_data.parma_state LEFT join cities on cities.id = candidate_data.parma_city where academic_intermediate !='' and um.course_id in ($course)  GROUP by academic_intermediate order by states.name"); 
		$list = $uery->result();	
		
		$ram = array('districtlist' => $list);
		echo json_encode($ram);

	}





	public function report2()
	{
		$StateQuery =  $this->db->query("SELECT * FROM states"); 
		$Statelist = $StateQuery->result();	

		$secound = $this->load->database('2021', TRUE);
		$third = $this->load->database('2022', TRUE);
		$four = $this->load->database('2023', TRUE);
		$five = $this->load->database('2024', TRUE);
		$six = $this->load->database('2020', TRUE);
		
		foreach ($Statelist as $key => $State) {

			$r25 = $this->db->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id")->row('cnt');

			$r20 = $six->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id")->row('cnt');

			$r21 = $secound->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id")->row('cnt');

			$r22 = $third->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id")->row('cnt');

			$r23 = $four->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id")->row('cnt');

			$r24 = $five->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id")->row('cnt');
			
				$list[$State->name] = array('id' => $State->id,'name' => $State->name, '2020' => $r20, '2021' => $r21, '2022' => $r22, '2023' => $r23, '2024' => $r24, '2025' => $r25); 
		}

		
		$this->load->view($this->folder."report2",array('districtlist'=>$list));
	}

	public function report2_filter()
	{

		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  		
		$course = $str_arr[0];
		$center = $str_arr[1];

	
		$StateQuery =  $this->db->query("SELECT * FROM states"); 
		$Statelist = $StateQuery->result();	

		$secound = $this->load->database('2021', TRUE);
		$third = $this->load->database('2022', TRUE);
		$four = $this->load->database('2023', TRUE);
		$five = $this->load->database('2024', TRUE);
		$six = $this->load->database('2020', TRUE);
		$whr="";
		if($center !=""){
			$whr = "and cd.study_centre_1 = '$center'";
		}
		
		foreach ($Statelist as $key => $State) {

			$r25 = $this->db->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id and um.course_id in ($course) $whr")->row('cnt');

			$r20 = $six->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id and um.course_id in ($course) $whr")->row('cnt');

			$r21 = $secound->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id and um.course_id in ($course) $whr")->row('cnt');

			$r22 = $third->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id and um.course_id in ($course) $whr")->row('cnt');

			$r23 = $four->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id and um.course_id in ($course) $whr")->row('cnt');

			$r24 = $five->query("SELECT ct.name,count(cd.parma_state) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id 
inner join states ct ON ct.id = cd.parma_state WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_state = $State->id and um.course_id in ($course) $whr")->row('cnt');
			
				$list[$State->name] = array('id' => $State->id,'name' => $State->name, '2020' => $r20, '2021' => $r21, '2022' => $r22, '2023' => $r23, '2024' => $r24, '2025' => $r25); 
		}

		$ram = array('districtlist' => $list);
		echo json_encode($ram);
		
	}


	public function statewisecity()
	{
		$all_data = $this->input->get('data');
		$str_arr = explode ("~", $all_data);  		
		$course = $str_arr[0];
		$id = $str_arr[1];
		$center = $str_arr[2];

		

		$CityQuery =  $this->db->query("SELECT * FROM cities where state_id = $id"); 
		$Citylist = $CityQuery->result();
		$arrayName = [];

		$whr="";
		if($center !=""){
			$whr = "and cd.study_centre_1 = '$center'";
		}
		foreach ($Citylist as $key => $City) {

		

			$r25 = $this->db->query("SELECT ct.name,count(cd.parma_city) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id inner join cities ct ON ct.id = cd.parma_city WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_city = $City->id and um.course_id in ($course) $whr")->row('cnt');

			$db24 = $this->load->database('2024', TRUE);
			$r24 = $db24->query("SELECT ct.name,count(cd.parma_city) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id inner join cities ct ON ct.id = cd.parma_city WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_city = $City->id and um.course_id in ($course) $whr")->row('cnt');

			$db23 = $this->load->database('2023', TRUE);
			$r23 = $db23->query("SELECT ct.name,count(cd.parma_city) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id inner join cities ct ON ct.id = cd.parma_city WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_city = $City->id and um.course_id in ($course) $whr")->row('cnt');

			$db22 = $this->load->database('2022', TRUE);
			$r22 = $db22->query("SELECT ct.name,count(cd.parma_city) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id inner join cities ct ON ct.id = cd.parma_city WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_city = $City->id and um.course_id in ($course) $whr")->row('cnt');

			$db21 = $this->load->database('2021', TRUE);
			$r21 = $db21->query("SELECT ct.name,count(cd.parma_city) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id inner join cities ct ON ct.id = cd.parma_city WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_city = $City->id and um.course_id in ($course) $whr")->row('cnt');

			$db20 = $this->load->database('2020', TRUE);
			$r20 = $db20->query("SELECT ct.name,count(cd.parma_city) as cnt FROM candidate_data cd inner join user_master um on um.user_id=cd.mobile_verified_id inner join cities ct ON ct.id = cd.parma_city WHERE cd.duplicate = 0 and um.login_status=2 and um.razorpay_trans_id !='' and cd.parma_city = $City->id and um.course_id in ($course) $whr")->row('cnt');


			if($r20 !=0 || $r21 !=0 || $r22 !=0 || $r23 !=0 || $r24 !=0 || $r25 !=0){
					
			$arrayName[] =  array('name' => $City->name,'cnt_20'=>$r20,'cnt_21'=>$r21,'cnt_22'=>$r22,'cnt_23'=>$r23,'cnt_24'=>$r24,'cnt_25'=>$r25);
			}
		}	

		
		echo json_encode($arrayName);
		
	}


	public function yearwiseregistration_filter()
	{

		$course = $this->input->get('data');

		$secound_db = $this->load->database('2021', TRUE);
		$third_db = $this->load->database('2022', TRUE);
		$four_db = $this->load->database('2023', TRUE);
		$five_db = $this->load->database('2024', TRUE);
		$six_db = $this->load->database('2020', TRUE);



		$first =  $this->db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !='' AND course_id in ($course)")->row('count');

		$first_admission =  $this->db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1 AND user_master.course_id in ($course)")->row('count');

		$secound =  $secound_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !='' AND course_id in ($course)")->row('count');

		$secound_admission =  $secound_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1 AND user_master.course_id in ($course)")->row('count');

		$third =  $third_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !='' AND course_id in ($course)")->row('count');

		$third_admission =  $third_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1 AND user_master.course_id in ($course)")->row('count');

		$four =  $four_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !='' AND course_id in ($course)")->row('count');

		$four_admission =  $four_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1 AND user_master.course_id in ($course)")->row('count');

		$five =  $five_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !='' AND course_id in ($course)")->row('count');

		$five_admission =  $five_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1 AND user_master.course_id in ($course)")->row('count');

		$six =  $six_db->query("SELECT COUNT(user_id) as count FROM user_master WHERE login_status=2 AND razorpay_trans_id !='' AND course_id in ($course)")->row('count');

		$six_admission =  $six_db->query("SELECT COUNT(user_id) as count FROM user_master 
inner join candidate_data on candidate_data.mobile_verified_id = user_master.user_id
WHERE user_master.login_status=2 AND user_master.razorpay_trans_id !='' AND candidate_data.admission = 1 AND user_master.course_id in ($course)")->row('count');
		
				
		$seat[] = array('Year', 'Registration', 'Admission');
		$seat[] = array('2020', intval($six), intval($six_admission));
		$seat[] = array('2021', intval($secound), intval($secound_admission));
		$seat[] = array('2022', intval($third), intval($third_admission));
		$seat[] = array('2023', intval($four), intval($four_admission));
		$seat[] = array('2024', intval($five), intval($five_admission));
		$seat[] = array('2024', intval($first), intval($first_admission));
		


		$first_gwalior =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$first_bhu =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$first_noi =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$first_nellor =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$first_goa =  $this->db->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$secound = $this->load->database('2021', TRUE);

		$secound_gwl =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$secound_bhu =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$secound_noi =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$secound_nellor =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$secound_goa =  $secound->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$third = $this->load->database('2022', TRUE);

		$third_gwl =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$third_bhu =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$third_noi =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$third_nellor =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$third_goa =  $third->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$four = $this->load->database('2023', TRUE);

		$four_gwl =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$four_bhu =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$four_noi =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$four_nellor =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$four_goa =  $four->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$five = $this->load->database('2024', TRUE);

		$five_gwl =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$five_bhu =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$five_noi =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$five_nellor =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$five_goa =  $five->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$six = $this->load->database('2020', TRUE);
		
		$six_gwl =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$six_bhu =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$six_noi =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');

		$six_nellor =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$six_goa =  $six->query("SELECT count(*) as count from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate !=1 and user_master.course_id in ($course)")->row('count');


		$city[]= array('City', '2020', '2021' ,'2022', '2023', '2024', '2025');
		$city[]=  array('Gwalior',intval($six_gwl) , intval($secound_gwl), intval($third_gwl), intval($four_gwl), intval($five_gwl), intval($first_gwalior));
		$city[]=  array('Bhubaneswar', intval($six_bhu), intval($secound_bhu), intval($third_bhu), intval($four_bhu), intval($five_bhu), intval($first_bhu));
		$city[]=  array('Noida',intval($six_noi) , intval($secound_noi), intval($third_noi), intval($four_noi), intval($five_noi),intval($first_noi));
		$city[]=  array('Nellore',intval($six_nellor) , intval($secound_nellor), intval($third_nellor), intval($five_nellor), intval($four_nellor),intval($first_nellor));
		$city[]=  array('Goa', intval($six_goa), intval($secound_goa), intval($third_goa), intval($four_goa), intval($five_goa),intval($first_goa));






		$g25 =  $this->db->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Google' and user_master.course_id in ($course)")->row('count');

		$g24 =  $five->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Google' and user_master.course_id in ($course)")->row('count');

		$g23 =  $four->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Google' and user_master.course_id in ($course)")->row('count');

		


		$n25 =  $this->db->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Newspaper' and user_master.course_id in ($course)")->row('count');

		$n24 =  $five->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Newspaper' and user_master.course_id in ($course)")->row('count');

		$n23 =  $four->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Newspaper' and user_master.course_id in ($course)")->row('count');

	


		$s25 =  $this->db->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Social Media' and user_master.course_id in ($course)")->row('count');

		$s24 =  $five->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Social Media' and user_master.course_id in ($course)")->row('count');

		$s23 =  $four->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Social Media' and user_master.course_id in ($course)")->row('count');

	

		$w25 =  $this->db->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Word of mouth' and user_master.course_id in ($course)")->row('count');

		$w24 =  $five->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Word of mouth' and user_master.course_id in ($course)")->row('count');

		$w23 =  $four->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Word of mouth' and user_master.course_id in ($course)")->row('count');



		$c25 =  $this->db->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Career counselling session' and user_master.course_id in ($course)")->row('count');

		$c24 =  $five->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Career counselling session' and user_master.course_id in ($course)")->row('count');

		$c23 =  $four->query("SELECT count(*) as count, candidate_data.know_iittm as name FROM candidate_data inner join user_master on user_master.user_id = candidate_data.mobile_verified_id where candidate_data.know_iittm = 'Career counselling session' and user_master.course_id in ($course)")->row('count');

		
		$source[] = array('Source', '2023', '2024', '2025');
		$source[] = array('Google', intval($g23), intval($g24), intval($g25));
		$source[] = array('Newspaper', intval($n23), intval($n24), intval($n25));
		$source[] = array('Social Media', intval($s23), intval($s24), intval($s25));
		$source[] = array('Word of mouth', intval($w23), intval($w24), intval($w25));
		$source[] = array('Career counselling session',intval($c23), intval($c24), intval($c25));



		$ram = array('chart' => $seat, 'citychart' => $city, 'source_chart' => $source);
		echo json_encode($ram);
		
			
	
	}
	


	public function create_users()
	{


		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}


		if(isset($_POST['btnsubmit']))
		{

			$fetch =  $this->db->select('*')->from('admin')->where('admin_name',$_POST['admin_name'])->get()->row();

			
  			if(empty($fetch)){

				$data = array(
				'admin_name' => $_POST['admin_name_f'], 
				'admin_password' => $_POST['admin_password_f'], 
				'admin_email' => $_POST['admin_name']."@gmail.com", 
				'role' => $_POST['role'],
			);

			$last_id = $this->db_lib->insert('admin',$data,'');

			if($last_id>0)
			{
				 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
				 redirect("admin/create_users");
			}
			else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
				redirect("admin/create_users");
			}

			}else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("admin/create_users");
			}	
		}
		

		$arry_data =  $this->db->select('*')->from('admin')->get()->result();


		$rst_form_data = $this->db_lib->fetchRecords('update_form','','*');
		$this->load->view($this->folder."create_users",array('result'=>$arry_data));
	}


	public function delete_user()
	{
		$id = $_POST['id'];
		$where = "admin_id='$id'";
		$delete = $this->db_lib->delete("admin",$where);
		if($delete){

			echo 1;
		}

	}

	public function get_user()
	{
		$id = $_POST['id'];
		$where = "admin_id='$id'";
		$get = $this->db_lib->fetchRecords("admin",$where,'*');
		
		echo json_encode($get);
	}


	public function edit_users()
	{
		$id = $_POST['edit_id'];
		
		$where = "admin_id = '$id'";
		$update_data = array(
			'admin_name' => $_POST['admin_name_edit'],
			'admin_password' => $_POST['admin_password_edit'],
			'role' => $_POST['role_edit'],
			);
		$rst = $this->db_lib->update('admin',$update_data,$where);

		if($rst)
		{
			 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			 redirect("admin/create_users");
		}
	}


	public function report3()
	{	

		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
			
			$this->load->view($this->folder."report3");
			
	
	}


	public function report3_filter()
	{
		
		$where = $this->input->get('data');
		$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $where AND um.login_status = 2");



      $data = [];
      $draw ="";
      $n=0;
      foreach($query->result() as $r) {

      		$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = ".$r->user_id." AND duplicate = 0")->get()->row(); 

      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";


      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($r->course_id==1){$course = "BBA";}
				if($r->course_id==2){$course = "MBA";}

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name;
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
      		}
      		

      		$n++;
      		if($r->amount > 0){
      		$amount = ($r->amount)/100;
      		}else{$amount ="";}
      		$tranid = $r->razorpay_trans_id;

			if($r->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 

			if($r->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}
			
			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			
			
           $data[] = array(
           		$n,
				'0000'.$r->user_id,
				$course,
           		$fullname,
                $r->user_mobile,
                $email,
                $gender,
				$category,
                $dob,
				$candidate_data->father_name??'',
				$candidate_data->father_mobile??'',
				$candidate_data->mother_name??'',
				$candidate_data->mather_mobile??'',
				$candidate_data->father_email??'',
				$candidate_data->religion??'',
				$parma_address,
                $parma_state,
                $parma_city,
				$corre_address,
                $corre_state,
                $corre_city,
				$college,
                $university,
				$academic_year,
				$obt,
				$academic_percentage,
                $appr_center_1,
				$appr_center_2,
				$appr_center_3,
				$appr_center_4,
                $gdpi_center_1,
				$gdpi_center_2,
				$gdpi_center_3,
				$gdpi_center_4,
                $study_center1,
				$study_center2,
				$study_center3,
				$study_center4,
                $tranid,
                $amount,
                $sts_btn,
				$admit_btn,
				date("d-M-Y", strtotime($r->created_date)),
				date("d-M-Y", strtotime($candidate_data->post_date??''))
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
	
	public function date_wise_registration()
	{

		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}

		$data = [];


		$course = $this->input->post('course', true);
		$dbname = $this->input->post('dbnamee', true);
        
		if($dbname == 'iittm_2024'){
			$secound_db = $this->load->database('2024', TRUE);
			$ch_year = '2024';
			$pev_year = '2023';
		}elseif($dbname == 'iittm_2023'){
			$secound_db = $this->load->database('2023', TRUE);
			$ch_year = '2023';
			$pev_year = '2022';
		}elseif($dbname == 'iittm_2022'){
			$secound_db = $this->load->database('2022', TRUE);
			$ch_year = '2022';
			$pev_year = '2021';
		}elseif($dbname == 'iittm_2021'){
			$secound_db = $this->load->database('2021', TRUE);
			$ch_year = '2021';
			$pev_year = '2020';
		}elseif($dbname == 'iittm_2020'){
			$secound_db = $this->load->database('2020', TRUE);
			$ch_year = '2020';
			$pev_year = '2019';
		}else{
			$ch_year = '2025';
			$pev_year = '2024';
		}

    	if($dbname != 'iittm_2025' && $dbname != ''){




			if($course){
			$query1 = $secound_db->query("SELECT  COUNT('*') as count, MONTH(created_date) as `month` FROM  user_master WHERE  course_id = $course AND login_status = 2 AND year(created_date)  = $ch_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
			$query2 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND login_status = 1 AND year(created_date)  = $ch_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
			$query3 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND year(created_date)  = $ch_year  GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();

			$query4 = $secound_db->query("SELECT  COUNT('*') as count, MONTH(created_date) as `month` FROM  user_master WHERE  course_id = $course AND login_status = 2 AND year(created_date)  = $pev_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
			$query5 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND login_status = 1 AND year(created_date)  = $pev_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
			$query6 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND year(created_date)  = $pev_year  GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
			}else{
		    $query1 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  login_status = 2 AND year(created_date)  = $ch_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
			$query2 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  login_status = 1 AND year(created_date)  = $ch_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
			$query3 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE year(created_date)  = $ch_year  GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();


			$query4 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  login_status = 2 AND year(created_date)  = $pev_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
			$query5 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  login_status = 1 AND year(created_date)  = $pev_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
			$query6 = $secound_db->query("SELECT   COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE year(created_date)  = $pev_year  GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();

			}
		}else{

			if($course){
				$query1 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND login_status = 2 AND year(created_date)  = $ch_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
				$query2 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND login_status = 1 AND year(created_date)  = $ch_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
				$query3 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND year(created_date)  = $ch_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();


				$query4 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND login_status = 2 AND year(created_date)  = $pev_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
				$query5 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND login_status = 1 AND year(created_date)  = $pev_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
				$query6 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  course_id = $course AND year(created_date)  = $pev_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();

			}else{
				$query1 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  login_status = 2 AND year(created_date)  = $ch_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
				$query2 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  login_status = 1 AND year(created_date)  = $ch_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
				$query3 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  year(created_date)  = $ch_year   GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();


				$query4 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  login_status = 2 AND year(created_date)  = $pev_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
				$query5 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  login_status = 1 AND year(created_date)  = $pev_year GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();
				$query6 = $this->db->query("SELECT  COUNT('*') as count, MONTH(created_date)  as `month` FROM  user_master WHERE  year(created_date)  = $pev_year   GROUP BY  MONTH(created_date) ORDER BY  MONTH(created_date)")->result();

			}
		}
		
		
		$data['completed'] = $query1 ;
		$data['incompleted'] = $query2 ;
		$data['total'] = $query3 ;


		$data['prevcompleted'] = $query4 ;
		$data['previncompleted'] = $query5 ;
		$data['prevtotal'] = $query6 ;


		$data['course'] = $course ;
		$data['year'] = $dbname ;



		$data['pev_year'] = $pev_year ;
		// echo "<pre>";
		// print_r($query4);


		// echo "<pre>";
		// print_r($query5);die;
	
		

		$this->load->view($this->folder."date_wise_registration",$data);

	}

	public function month_wise_registration($id)
	{
	 $id;
	

	$course = $_GET['course'];
	$dbname = $_GET['year'];

	


	if($dbname == 'iittm_2024'){
		$secound_db = $this->load->database('2024', TRUE);
		$ch_year = '2024';
		$pev_year = '2023';
	}elseif($dbname == 'iittm_2023'){
		$secound_db = $this->load->database('2023', TRUE);
		$ch_year = '2023';
		$pev_year = '2022';
	}elseif($dbname == 'iittm_2022'){
		$secound_db = $this->load->database('2022', TRUE);
		$ch_year = '2022';
		$pev_year = '2021';
	}elseif($dbname == 'iittm_2021'){
		$secound_db = $this->load->database('2021', TRUE);
		$ch_year = '2021';
		$pev_year = '2020';
	}elseif($dbname == 'iittm_2020'){
		$secound_db = $this->load->database('2020', TRUE);
		$ch_year = '2020';
		$pev_year = '2019';
	}else{
		$ch_year = '2025';
		$pev_year = '2024';
	}


	if($dbname != 'iittm_2025' && $dbname != ''){
		if($course){
		$query1 = $secound_db->query("SELECT  *  FROM  user_master WHERE  course_id = $course AND  MONTH(created_date) = $id  AND year(created_date)  = $ch_year ")->result();
		$query2 = $secound_db->query("SELECT  *  FROM  user_master WHERE  course_id = $course AND  MONTH(created_date) = $id  AND year(created_date)  = $pev_year ")->result();


		}else{
		$query1 = $secound_db->query("SELECT   *  FROM  user_master WHERE   AND  MONTH(created_date) = $id  AND year(created_date)  = $ch_year ")->result();	
		$query2 = $secound_db->query("SELECT   *  FROM  user_master WHERE   AND  MONTH(created_date) = $id  AND year(created_date)  = $pev_year ")->result();

		}
	}else{

		if($course){
			$query1 = $this->db->query("SELECT  *   FROM  user_master WHERE  course_id = $course  AND  MONTH(created_date) = $id  AND year(created_date)  = $ch_year ")->result();
			$query2 = $this->db->query("SELECT  *   FROM  user_master WHERE  course_id = $course  AND  MONTH(created_date) = $id  AND year(created_date)  = $pev_year ")->result();

		}else{
			$query1 = $this->db->query("SELECT *   FROM  user_master WHERE   MONTH(created_date) = $id  AND year(created_date)  = $ch_year ")->result();
			$query2 = $this->db->query("SELECT *   FROM  user_master WHERE   MONTH(created_date) = $id  AND year(created_date)  = $pev_year ")->result();

		}
	}



	$monthNum  = $id;
	$dateObj   = DateTime::createFromFormat('!m', $monthNum);
	$monthName = $dateObj->format('F'); // March


	if(isset($_GET['prev'])){
		$result = $query2;
		$data['year'] = $pev_year ;
	}else{

		$result = $query1;
		$data['year'] = $ch_year ;
	}

	$data['result'] = $result ;

	

if($course == 1){
	$data['course'] = 'BBA' ;
}elseif($course == 2)
{	$data['course'] = 'MBA' ;

}else{
	$data['course'] = 'BBA/MBA' ;
}



$data['month'] = $monthName ;




$month = intval($id);
$year = intval($data['year']);

$list = array();
$start_date = "01-".$month."-".$year;
$start_time = strtotime($start_date);

$end_time = strtotime("+1 month", $start_time);

for($i=$start_time; $i<$end_time; $i+=86400)
{
   $list[] = array('date' => date('d-m-Y', $i),
   'day' => date('D', $i),
);
}

$data['dayslist'] = $list ;
$this->load->view($this->folder."month_wise_registration",$data);

	}
	


}	