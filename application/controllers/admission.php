<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Controller Class
 *
 * @author		ImpelPro Dev Team
**/

class Admission extends CI_Controller {
	
	public $folder = "admission/";

	function __construct()
	{
		parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('general_helper');
        $this->load->model("admissionmodel");
        $this->load->library('session');
		date_default_timezone_set("Asia/Calcutta");
	}
	
	public function index()
	{
		//redirect('admission/criteria');
	}
	
	public function contact()
	{
		$this->load->view($this->folder."contact");
	}
	
	public function ticket()
	{
		
		if(isset($_POST["btnSubmit"]))
		{

			$recaptchaResponse = trim($this->input->post('g-recaptcha-response'));

	        $userIp = $_SERVER["REMOTE_ADDR"];
	     
	        $secret = $this->config->item('google_secret');
	   
	       $url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
	 
	        $ch = curl_init(); 
	        curl_setopt($ch, CURLOPT_URL, $url); 
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	        $output = curl_exec($ch); 
	        curl_close($ch);      
	        $status= json_decode($output, true);
	        if ($status['success']) 
	        {
	           $Filename =  $_FILES['file']['name'];	
				if(!empty($_FILES['file']['name']))
				{
					
	                $path    = "uploads/query/";    
	                $uploadedImageName = $_FILES['file']['name'];
	                
	                if(strlen($uploadedImageName))
	                {
	                	
	                  	$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["file"]["name"]));
	                    $upload_status = move_uploaded_file($_FILES['file']['tmp_name'], $path.$newfilename);
	                    
	                    if($upload_status)
	                    {
	                        $imgName      = time();
	                        $newNamePath  = $path."_".$imgName;
	                     
	                        $userData=array(
								'course_id'=> trim($this->input->post('course',true)),							
								'fname'=> trim($this->input->post('your_fname',true)),
								'emailid'=> trim($this->input->post('your_txt_email',true)),
								'mobile'=> trim($this->input->post('your_father_mobile',true)),
								'register_mobile'=> trim($this->input->post('father_mobile',true)),
								'register_email'=> trim($this->input->post('txt_email',true)),
								'problem'=> trim($this->input->post('problem',true)),
								'file' => $newfilename,
								'form_type'=> trim($this->input->post('form_type',true)),
								'post_date' => date("Y-m-d H:i:s"),
							);
							$last_id = $this->db_lib->insert('query_data',$userData,'');
							setFlash("ViewMsgSuccess","<div class='col-sm-12'><div class='alert alert-success'><strong>Success!</strong> Thanks for contacting us. Your Reference number is $last_id for this query/issue. Kindly use it for further communication.we will get back to you soon.!</div></div>");
							redirect("admission/ticket");	
						}
					}
				}
				else
				{
					$userData=array(
						'course_id'=> trim($this->input->post('course',true)),							
						'fname'=> trim($this->input->post('your_fname',true)),
						'emailid'=> trim($this->input->post('your_txt_email',true)),
						'mobile'=> trim($this->input->post('your_father_mobile',true)),
						'register_mobile'=> trim($this->input->post('father_mobile',true)),
						'register_email'=> trim($this->input->post('txt_email',true)),
						'problem'=> trim($this->input->post('problem',true)),
						'form_type'=> trim($this->input->post('form_type',true)),
						'post_date' => date("Y-m-d H:i:s"),
					);
					$last_id = $this->db_lib->insert('query_data',$userData,'');
					
					setFlash("ViewMsgSuccess","<div class='col-sm-12'><div class='alert alert-success'><strong>Success!</strong> Thanks for contacting us. Your Reference number is $last_id for this query/issue. Kindly use it for further communication.we will get back to you soon.!</div></div>");
					redirect("admission/ticket");	
				}
	        }
	        else
	        {
	        	setFlash("ViewMsgSuccess","<div class='col-sm-12'><div class='alert alert-danger'><strong>warning!</strong>Sorry Google Recaptcha Unsuccessful!</div></div>");
						redirect("admission/ticket");
	         }

		


			

		}
				



		$this->load->view($this->folder."ticket");
	}


	public function messageSent($OTP,$mobile)
 	{
 		
		//Your authentication key
		$authKey = "322873AxMkWjplhxu5e6a21f3P1"; 

		//Multiple mobiles numbers separated by comma
		$mobileNumber = "$mobile";

		//Sender ID,While using route4 sender id should be 6 characters long.
		$senderId = "IITTMA";

		//Your message to send, Add URL encoding here.
		$message = "Your One Time Password: $OTP";
		//Define route 
		$route = "4";
		//Prepare you post parameters
		$postData = array(
		    'authkey' => $authKey,
		    'mobiles' => $mobileNumber,
		    'message' => $message,
		    'sender' => $senderId,
		    'route' => $route
		);

		//API URL
		//$url="";	
		$url="http://sms.ebiztechnocrats.com/api/sendhttp.php";

		// init the resource
		$ch = curl_init();
		curl_setopt_array($ch, array(
		    CURLOPT_URL => $url,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POST => true,
		    CURLOPT_POSTFIELDS => $postData
		    //,CURLOPT_FOLLOWLOCATION => true
		));


		//Ignore SSL certificate verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


		//get response
		$output = curl_exec($ch);

		//Print error if any
		if(curl_errno($ch))
		{
		    //echo 'error:' . curl_error($ch);
		    return 1;
		}
		else
		{
			return 1;
		}

		curl_close($ch);

		//$output;
	
 	}


	public function criteria()
	{	
		if(!$this->admissionmodel->hasLoggedIn()){
			redirect("admission/mobile_verification");
		}
		$user_id = $this->session->userdata('user_id');
		$where = "user_id = '$user_id'";
		$rst = $this->db_lib->fetchRecord('user_master',$where,'download_status,course_id');
		if($rst['download_status']==1)
		{
			$rst['download_status'];
		}

		$this->load->view($this->folder."criteria",array('download_status'=>$rst));
	}


	public function mobile_verification()
	{
		
		$this->session->unset_userdata('user_id');
		$this->load->view($this->folder."mobile_verification");
		//$this->load->view($this->folder."closed");
	}



	public function mobile_number()
	{

		$searchname = $this->input->get('data');
		if($searchname != null)
		{
			$where = "user_mobile = '$searchname'";
			$rst = $this->db_lib->fetchRecord('user_master',$where,'login_status');
			if($rst['login_status']==2)
			{
				echo $rst['login_status'];
			}

			if($rst['login_status']==1)
			{
				$whsere = "user_mobile = '$searchname'";
				$rsst = $this->db_lib->fetchRecord('user_master',$whsere,'user_id');
				$this->session->set_userdata('user_id', $rsst["user_id"]);
				echo $rst['login_status'];
			}

			if($rst==0)
			{
				//$where = "user_mobile = '$searchname'";
				//$this->db_lib->delete("user_master",$where);

				//code for save mobile number and otp in db after send otp to user
				$string = '1234567890';
	   			$string_shuffled = str_shuffle($string);
	    		$OTP = substr($string_shuffled, 1, 6);
				$ip_server = ""; 	
				$date = date("Y-m-d H:i:s");

				
				//when message active uncomment this
				/*if($this->messageSent($OTP,$searchname) == '1')
				{*/
					$userData=array(
					'user_mobile'=> $searchname,
					'mobile_otp'=> $OTP,
					'latitude'=> '26.58',
					'longitude'=> '78.12',
					'ip_address'=> $ip_server,
					'login_status'=> 0,
					'created_date'=> $date
					);
					if($this->admissionmodel->store_user_details_with_otp($userData)==true)
					{	
						$Data['login_status'] = 1;
						$where = "user_mobile = '$searchname'";
						$this->db_lib->update('user_master',$Data,$where);
						
						//when message active remove this from 
						$rst = $this->db_lib->fetchRecord('user_master',$where,'login_status,user_id');
						$this->session->set_userdata('user_id', $rst["user_id"]);
						//when message active remove this to 
						echo "save";
					
					}
					
				/*}
				else
				{
					echo "MsgNotSent";
				}*/
				
			}

		}
	}

	public function verified_number()
	{
		$otp = $this->input->get('data');
		$where = "mobile_otp = '$otp'";
		$rst = $this->db_lib->fetchRecord('user_master',$where,'login_status,user_id');
		
		if($rst==0)
		{
			echo "failed";
		}
		else
		{
			$this->session->set_userdata('user_id', $rst["user_id"]);
			echo "success";
		}

	}

	public function resent_otp()
	{
		$mobile = $this->input->get('data');
		$where = "user_mobile = '$mobile'";
		$rst = $this->db_lib->fetchRecord('user_master',$where,'login_status');
		if($rst['login_status']==1)
		{
			$string = '1234567890';
   			$string_shuffled = str_shuffle($string);
    		$OTP = substr($string_shuffled, 1, 6);
			if($this->messageSent($OTP,$mobile) == '1')
			{
				$Data['mobile_otp'] = $OTP;
				$where = "user_mobile = '$mobile'";
				$this->db_lib->update('user_master',$Data,$where);
				echo "success";
			}
			
		}

	}

	public function admission_form_mba()
	{
		
		/*if(!$this->admissionmodel->hasLoggedIn()){
			redirect("admission/mobile_verification");
		}*/
		
		$user_id = $this->session->userdata('user_id');
		$where = "user_id = '$user_id'";
		$rst = $this->db_lib->fetchRecord('user_master',$where,'user_mobile,course_id');
		
		
		$data = $this->admissionmodel->fetch_all_state();
		$this->template->load($this->folder."admission_form_mba",array('download_status'=>$rst,'state_list'=>$data));

		if(isset($_POST["btnSubmit"])){
		
			//for duplicate record entry
			$wherechk = "mobile_verified_id = '$user_id'";
			$check = $this->db_lib->fetchRecord('candidate_data',$wherechk,'mobile_verified_id');
			if($check>0)
			{
				$upd['duplicate'] = 1;
				$this->db_lib->update('candidate_data',$upd,$wherechk);
			}
		

			$amount = $this->input->post('amt',true);
			$category = $this->input->post('category',true);
			
	

			$Filename =  $_FILES['file']['name'];	
			if(!empty($_FILES['file']['name']))
			{
				
                $path    = "uploads/MBA/";    
                $uploadedImageName = $_FILES['file']['name'];
                $uploadedSignatureName = $_FILES['signature']['name'];
                if(strlen($uploadedImageName) && strlen($uploadedSignatureName))
                {
                	$newsignaturename = date('dmYHis').str_replace(" ", "", basename($_FILES["signature"]["name"]));
                  	$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["file"]["name"]));
                    $upload_status = move_uploaded_file($_FILES['file']['tmp_name'], $path.$newfilename);
                    $upload_signature = move_uploaded_file($_FILES['signature']['tmp_name'], $path.$newsignaturename);
                    if($upload_status && $upload_signature)
                    {
                        $imgName      = time();
                        $newNamePath  = $path."_".$imgName;
                     
                        //Data insert in table
                        $userData=array(
                        	'mobile_verified_id'=>$user_id,
							'course_name'=> trim($this->input->post('course',true)),							
							'first_name'=> trim($this->input->post('fname',true)),
							'middle_name'=> trim($this->input->post('mname',true)),
							'last_name'=> trim($this->input->post('lname',true)),
							'mobile'=> trim($this->input->post('mobile_hidden',true)),
							'email_id'=> trim($this->input->post('txt_email',true)),
							'dob'=> trim($this->input->post('txt_dob',true)),
							'gender'=> trim($this->input->post('gender',true)),
							'father_name'=> trim($this->input->post('fathername',true)),
							'father_mobile'=> trim($this->input->post('father_mobile',true)),
							'mother_name'=> trim($this->input->post('mothername',true)),
							'mather_mobile'=> trim($this->input->post('mother_mobile',true)),							
							'father_email'=>trim($this->input->post('father_email',true)),
							'nationality'=> trim($this->input->post('nationality',true)),
							'religion'=> trim($this->input->post('religion',true)),
							'category'=> trim($this->input->post('category',true)),
							'pwd'=> trim($this->input->post('pwd',true)),
							'parma_appertment'=> trim($this->input->post('parma_apartment',true)),
							'parma_colony'=> trim($this->input->post('parma_colony',true)),
							'parma_area'=> trim($this->input->post('parma_area',true)),
							'parma_resi_phone'=> trim($this->input->post('parma_resi_phone',true)),
							'parma_state'=> trim($this->input->post('parma_state',true)),
							'parma_city'=> trim($this->input->post('parma_city',true)),
							'parma_pincode'=> trim($this->input->post('parma_pincode',true)),
							
							'corre_appertment'=> trim($this->input->post('corre_apartment',true)),
							'corre_colony'=> trim($this->input->post('corre_colony',true)),
							'corre_area'=> trim($this->input->post('corre_area',true)),
							'corre_resi_phone'=> trim($this->input->post('corre_resi_phone',true)),
							'corre_state'=> trim($this->input->post('corre_state',true)),
							'corre_city'=> trim($this->input->post('corre_city',true)),
							'corre_pincode'=> trim($this->input->post('corre_pincode',true)),

							'academic_status'=> trim($this->input->post('academic',true)),
							'academic_intermediate'=> trim($this->input->post('academic_intermediate',true)),
							'academic_board'=> trim($this->input->post('academic_board',true)),
							'academic_year'=> trim($this->input->post('academic_year',true)),
							'academic_mark_obt'=> trim($this->input->post('academic_mark_obt',true)),
							'academic_mark_max'=> trim($this->input->post('academic_mark_max',true)),
							'academic_percentage'=> trim($this->input->post('academic_percentage',true)),

							'appearing_center_1'=> trim($this->input->post('first_center',true)),
							'appearing_center_2'=> trim($this->input->post('second_center',true)),
							'appearing_center_3'=> trim($this->input->post('third_center',true)),
							'appearing_center_4'=> trim($this->input->post('forth_center',true)),

							'gdpi_center_1'=> trim($this->input->post('center_city_first',true)),
							'gdpi_center_2'=> trim($this->input->post('center_city_second',true)),
							'gdpi_center_3'=> trim($this->input->post('center_city_third',true)),
							'gdpi_center_4'=> trim($this->input->post('center_city_four',true)),

							'study_centre_1'=> trim($this->input->post('first_code',true)),
							'study_centre_2'=> trim($this->input->post('second_code',true)),
							'study_centre_3'=> trim($this->input->post('third_code',true)),
							'study_centre_4'=> trim($this->input->post('four_code',true)),

							'candidate_photo'=> $newfilename,
							'candidate_signature'=> $newsignaturename,
							'ip_address'=> '',
							'post_date'=> date("Y-m-d H:i:s"),
						);	

                        $last_id = $this->db_lib->insert('candidate_data',$userData,'');
                        if($last_id!=0){

                        	$where_can = "form_id = '$last_id'";
							$can_rst = $this->db_lib->fetchRecord('candidate_data',$where_can,'mobile_verified_id');
                        	
                        	if(!empty($_POST['score_chek']))
								{
									foreach($_POST['score_chek'] as $selected)
									{
													
										$score = $_POST[$selected."_score"];
										$year = $_POST[$selected."_year"];
										$scoreData=array(
											'candidate_id' => $can_rst['mobile_verified_id'],
											'score_name' => $selected,
											'score_marks' => $score,
											'score_year' => $year
										);

										$score_rst = $this->db_lib->insert('candidate_score_mba',$scoreData,'');
									}
								}


                        	/*$Data['login_status'] = 2;
							$where = "user_id = '$user_id'";
							$this->db_lib->update('user_master',$Data,$where);*/

							$this->session->set_userdata('amount', $amount);	
    						redirect("admission/paymeny_screen");
                        	
						}
                  		
                  	  }
	                   
	                }  
	                	
				}
		}
	}







	public function admission_form()
	{
		
		if(!$this->admissionmodel->hasLoggedIn()){
			redirect("admission/mobile_verification");
		}
		
		$user_id = $this->session->userdata('user_id');
		$where = "user_id = '$user_id'";
		$rst = $this->db_lib->fetchRecord('user_master',$where,'user_mobile,course_id');
		
		$data = $this->admissionmodel->fetch_all_state();
		$this->template->load($this->folder."admission_form",array('download_status'=>$rst,'state_list'=>$data));

		if(isset($_POST["btnSubmit"])){
		
			//for duplicate record entry
			$wherechk = "mobile_verified_id = '$user_id'";
			$check = $this->db_lib->fetchRecord('candidate_data',$wherechk,'mobile_verified_id');
			if($check>0)
			{
				$upd['duplicate'] = 1;
				$this->db_lib->update('candidate_data',$upd,$wherechk);
			}

			$amount = $this->input->post('amt',true);
			$category = $this->input->post('category',true);
			$form_dob = $this->input->post('txt_dob',true);
			$dateOfBirth = date("d-m-Y",strtotime($form_dob));
			$today = date("Y-m-d");
			$diff = date_diff(date_create($dateOfBirth), date_create($today));
			$final_age = $diff->format('%y');
			//if($category !="SC/ST" && $final_age > 22)
			//{
				//setFlash("ViewMsgSuccess","<div class='col-sm-12'><div class='alert alert-danger'><strong>Warning!</strong> Age criteria not matched from guidlines!</div></div>");
				//redirect("admission/admission_form");
			//}
			//else
			//{
				$Filename =  $_FILES['file']['name'];	
				if(!empty($_FILES['file']['name']))
				{
					
	                $path    = "uploads/BBA/";    
	                $uploadedImageName = $_FILES['file']['name'];
	                $uploadedSignatureName = $_FILES['signature']['name'];
	                if(strlen($uploadedImageName) && strlen($uploadedSignatureName))
	                {
	                	$newsignaturename = date('dmYHis').str_replace(" ", "", basename($_FILES["signature"]["name"]));
	                  	$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["file"]["name"]));
	                    $upload_status = move_uploaded_file($_FILES['file']['tmp_name'], $path.$newfilename);
	                    $upload_signature = move_uploaded_file($_FILES['signature']['tmp_name'], $path.$newsignaturename);
	                    if($upload_status && $upload_signature)
	                    {
	                        $imgName      = time();
	                        $newNamePath  = $path."_".$imgName;
	                     
	                        //Data insert in table
	                        $userData=array(
	                        	'mobile_verified_id'=>$user_id,
								'course_name'=> trim($this->input->post('course',true)),							
								'first_name'=> trim($this->input->post('fname',true)),
								'middle_name'=> trim($this->input->post('mname',true)),
								'last_name'=> trim($this->input->post('lname',true)),
								'mobile'=> trim($this->input->post('mobile_hidden',true)),
								'email_id'=> trim($this->input->post('txt_email',true)),
								'dob'=> trim($this->input->post('txt_dob',true)),
								'gender'=> trim($this->input->post('gender',true)),
								'father_name'=> trim($this->input->post('fathername',true)),
								'father_mobile'=> trim($this->input->post('father_mobile',true)),
								'mother_name'=> trim($this->input->post('mothername',true)),
								'mather_mobile'=> trim($this->input->post('mother_mobile',true)),							
								'father_email'=>trim($this->input->post('father_email',true)),
								'nationality'=> trim($this->input->post('nationality',true)),
								'religion'=> trim($this->input->post('religion',true)),
								'category'=> trim($this->input->post('category',true)),
								'pwd'=> trim($this->input->post('pwd',true)),
								'parma_appertment'=> trim($this->input->post('parma_apartment',true)),
								'parma_colony'=> trim($this->input->post('parma_colony',true)),
								'parma_area'=> trim($this->input->post('parma_area',true)),
								'parma_resi_phone'=> trim($this->input->post('parma_resi_phone',true)),
								'parma_state'=> trim($this->input->post('parma_state',true)),
								'parma_city'=> trim($this->input->post('parma_city',true)),
								'parma_pincode'=> trim($this->input->post('parma_pincode',true)),
								
								'corre_appertment'=> trim($this->input->post('corre_apartment',true)),
								'corre_colony'=> trim($this->input->post('corre_colony',true)),
								'corre_area'=> trim($this->input->post('corre_area',true)),
								'corre_resi_phone'=> trim($this->input->post('corre_resi_phone',true)),
								'corre_state'=> trim($this->input->post('corre_state',true)),
								'corre_city'=> trim($this->input->post('corre_city',true)),
								'corre_pincode'=> trim($this->input->post('corre_pincode',true)),

								'academic_status'=> trim($this->input->post('academic',true)),
								'academic_intermediate'=> trim($this->input->post('academic_intermediate',true)),
								'academic_board'=> trim($this->input->post('academic_board',true)),
								'academic_year'=> trim($this->input->post('academic_year',true)),
								'academic_mark_obt'=> trim($this->input->post('academic_mark_obt',true)),
								'academic_mark_max'=> trim($this->input->post('academic_mark_max',true)),
								'academic_percentage'=> trim($this->input->post('academic_percentage',true)),

								'appearing_center_1'=> trim($this->input->post('first_center',true)),
								'appearing_center_2'=> trim($this->input->post('second_center',true)),
								'appearing_center_3'=> trim($this->input->post('third_center',true)),
								'appearing_center_4'=> trim($this->input->post('forth_center',true)),

								'gdpi_center_1'=> trim($this->input->post('center_city_first',true)),
								'gdpi_center_2'=> trim($this->input->post('center_city_second',true)),
								'gdpi_center_3'=> trim($this->input->post('center_city_third',true)),
								'gdpi_center_4'=> trim($this->input->post('center_city_four',true)),

								'study_centre_1'=> trim($this->input->post('first_code',true)),
								'study_centre_2'=> trim($this->input->post('second_code',true)),
								'study_centre_3'=> trim($this->input->post('third_code',true)),
								'study_centre_4'=> trim($this->input->post('four_code',true)),

								'candidate_photo'=> $newfilename,
								'candidate_signature'=> $newsignaturename,
								'ip_address'=> '',
								'post_date'=> date("Y-m-d H:i:s"),
							);	

	                        $data=$this->db_lib->insert('candidate_data',$userData,'');
	                        if($data!=0){
	                        	
	                        	/*$Data['login_status'] = 2;
								$where = "user_id = '$user_id'";
								$this->db_lib->update('user_master',$Data,$where);*/

								$this->session->set_userdata('amount', $amount);	
	    						redirect("admission/paymeny_screen");
	                        	


							}
	                   }
	                   
	                }  
	                	

				}
			//}

		}
	}

	public function city_get()
	{
		$stateid = $this->input->get('data');
		$where = "state_id = $stateid";
		$rst = $this->admissionmodel->fetchcity($where);
		echo json_encode($rst);
	}
	
	public function city_get_new()
	{
		$stateid = $this->input->get('data');
		$where = "state_id = $stateid";
		//$rst = $this->admissionmodel->fetchcity($where);
		//$ram = array('result'=>$rst);


			$table='cities';
			$fields = "*";
		
			$result = $this->db_lib->fetchRecords($table,$where,$fields);

		echo json_encode($result);
	}

	public function paymeny_screen()
	{
		/*if(!$this->admissionmodel->hasLoggedIn()){
			redirect("admission/mobile_verification");
		}*/
		$this->load->view($this->folder."paymeny_screen");
	}

	public function payment_status_without_fee()
	{
		
		$user_id = $this->input->post('user_id');
		$razorpay_payment_id = $this->input->post('razorpay_payment_id');
		$course_id = $this->input->post('course_id');
		$this->session->set_userdata('course_id', $course_id);


    	$data['razorpay_trans_id'] = $razorpay_payment_id;
		$data['amount'] = 0;
		$data['login_status'] = 2;
		$where = "user_id = ".$user_id;
		$this->db_lib->update('user_master',$data,$where);

		

		$data['title'] = 'Razorpay Success | IITTM';
		redirect("Razorpay/success");
        //$this->load->view('admission/success', $data);


	}

	
	
}	