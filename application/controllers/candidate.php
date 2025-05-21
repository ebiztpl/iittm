<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Controller Class
 *
 * @author		ImpelPro Dev Team
**/

class Candidate extends CI_Controller {
	
	public $folder = "candidate/";

	function __construct()
	{
		parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('general_helper');
        $this->load->model("usermodel");
        $this->load->library('session');
		date_default_timezone_set("Asia/Calcutta");
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
	
	public function index()
	{
		//redirect('admission/criteria');
	}

	public function student_login()
	{
		$this->load->view($this->folder."student_login");
	}



	public function student_login_otp()
	{

		$searchname = $this->input->get('data');
		if($searchname != null)
		{
			$where = "user_mobile = '$searchname' AND login_status = 2";
			$rst = $this->db_lib->fetchRecord('user_master',$where,'*');
			if($rst>0)
			{
				//code for save mobile number and otp in db after send otp to user
				$string = '1234567890';
	   			$string_shuffled = str_shuffle($string);
	    		$OTP = substr($string_shuffled, 1, 6);
				$date = date('Y-m-d h:m:i');

				if($this->messageSent($OTP,$searchname) == '1')
				{
					$Data['mobile_otp'] = $OTP;
					$where = "user_id =".$rst['user_id'];
					if($this->db_lib->update('user_master',$Data,$where))
					{
						echo "save";
					}

				}
				else
				{
					echo "MsgNotSent";
				}
				
			}

		}
	}

	public function verified_candidate_number()
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

	public function resent_candidate_otp()
	{
		$mobile = $this->input->get('data');
		$where = "user_mobile = '$mobile' AND login_status = 2";
		$rst = $this->db_lib->fetchRecord('user_master',$where,'*');
		if($rst>0)
		{
			//code for save mobile number and otp in db after send otp to user
			$string = '1234567890';
   			$string_shuffled = str_shuffle($string);
    		$OTP = substr($string_shuffled, 1, 6);
			$date = date('Y-m-d h:m:i');

			if($this->messageSent($OTP,$mobile) == '1')
			{
				$Data['mobile_otp'] = $OTP;
				$where = "user_id =".$rst['user_id'];
				if($this->db_lib->update('user_master',$Data,$where))
				{
					echo "save";
				}

			}
			else
			{
				echo "MsgNotSent";
			}
			
		}

	}


	public function candidate_dashboard()
	{
		$user_id = $this->session->userdata('user_id');

		$where_user = "user_id = '$user_id'";
		$rst_user = $this->db_lib->fetchRecord('user_master',$where_user,'course_id,user_id');


		$where = "mobile_verified_id = '$user_id'";
		$rst = $this->db_lib->fetchRecord('candidate_data',$where,'first_name,middle_name,last_name');
		$this->load->view($this->folder."candidate_dashboard",array('data'=>$rst,'userdat'=>$rst_user));
	}


	public function update_form ()
	{

		if(isset($_POST["btnSubmit"]))
		{
			$userData=array(
				'user_id'=> trim($this->input->post('user_id',true)),							
				'subject_line'=> trim($this->input->post('subject',true)),
				'form_desc'=> trim($this->input->post('form_desc',true)),
				'status'=> 0,
				'post_date' => date("Y-m-d"),
			);

			$last_id = $this->db_lib->insert('update_form',$userData,'');
			setFlash("ViewMsgSuccess","<div class='col-sm-12'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true' style='color: #fff; opacity: 1;'>×</button><strong>Success!</strong> Thanks for contacting us. we will get back to you soon.!</div></div>");
			redirect("candidate/update_form");
		}


		$user_id = $this->session->userdata('user_id');
		$where_user = "user_id = '$user_id'";
		$rst_user = $this->db_lib->fetchRecord('user_master',$where_user,'course_id,user_id');


		$where = "mobile_verified_id = '$user_id'";
		$rst = $this->db_lib->fetchRecord('candidate_data',$where,'first_name,middle_name,last_name');
		$this->load->view($this->folder."update_form",array('data'=>$rst,'userdat'=>$rst_user));
	}


	public function view_update_form()
	{
		$user_id = $this->session->userdata('user_id');
		$where_user = "user_id = '$user_id'";
		$rst_user = $this->db_lib->fetchRecord('user_master',$where_user,'course_id,user_id');

		$where = "mobile_verified_id = '$user_id'";
		$rst = $this->db_lib->fetchRecord('candidate_data',$where,'first_name,middle_name,last_name');

		$where_form_data = "user_id = '$user_id'";
		$rst_form_data = $this->db_lib->fetchRecords('update_form',$where_form_data,'*');

		$this->load->view($this->folder."view_update_form",array('data'=>$rst,'userdat'=>$rst_user,'result'=>$rst_form_data));
	}


	public function logout()
	{
		session_destroy();
		redirect("candidate/student_login");
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
        $this->dompdf->stream("Form.pdf", array("Attachment"=>1));
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
        $this->dompdf->stream("Form.pdf", array("Attachment"=>1));
        //$output =$this->dompdf->output();
        //file_put_contents($pdfroot,$output);
    }

}	