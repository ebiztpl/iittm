<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @package Razorpay :  CodeIgniter Razorpay Gateway
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *   
 * Description of Razorpay Controller
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Razorpay extends CI_Controller {
    // construct
    public function __construct() {
        parent::__construct();   
        $this->load->model('Site', 'site'); 
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('general_helper');
        $this->load->library('session');    
    }
    // index page
    

    // initialized cURL Request
    private function get_curl_handle($payment_id, $amount)  {
		 $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
         $key_id = RAZOR_KEY_ID;
         $key_secret = RAZOR_KEY_SECRET;
         $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');
        return $ch;
    }  

	public function emailSentNew()
    {   
		
        $user_id=48;
		$email='rambthm376@gmail.com';
        $this->load->library('email_manager');
        $email = $email;
        $emilMessage = '<strong>Thanks for Registration.<br/> Keep Visitng IITTM Official Website for further updates related to Admission Process.</strong><br/><a href="https://www.iittm.ac.in">www.iittm.ac.in</a><br/><br/><br/>Please find below the form filled by you and your payment reciept';
       
		
        $EmailDetails=array(
            'To'=> $email,
            'BCC'=>'',
            'from' =>'admissions@iittm.ac.in',
            'Subject'=> 'IITTM | ONLINE ADMISSION REGISTRATION SUCCESSFULL',
            'Message'=> $emilMessage,
            'path' => 'E:/XAMPP/htdocs/iittm_2021/uploads/attachment/'.$user_id.'.pdf',
        );
		
        $this->email_manager->send_email($EmailDetails);
    }
	
	
	
	public function emailSent($user_id,$email,$course_id)
    {   
        
        if($course_id==1)
        {
            $this->save_pdf_bba();
        }
        else
        {
            $this->save_pdf_mba();
        }

        $this->load->library('email_manager');
        $email = $email;
        $emilMessage = '<strong>Thanks for Registration.<br/> Keep Visitng IITTM Official Website for further updates related to Admission Process.</strong><br/><a href="https://www.iittm.ac.in">www.iittm.ac.in</a><br/><br/><br/>Please find below the form filled by you and your payment reciept';
        
        $EmailDetails=array(
            'To'=> $email,
            'BCC'=>'rambthm376@gmail.com',
            'from' =>'admissions@iittm.ac.in',
            'Subject'=> 'IITTM | ONLINE ADMISSION REGISTRATION SUCCESSFULL',
            'Message'=> $emilMessage,
            'path' => 'C:/Inetpub/vhosts/ebiztechnocrats.com/httpdocs/iittm_2021/uploads/attachment/'.$user_id.'.pdf',
        );
       
        $this->email_manager->send_email($EmailDetails);
    }

    public function messageSent($razorpay_payment_id,$mobile)
 	{
 		
		//Your authentication key
		$authKey = "322873AxMkWjplhxu5e6a21f3P1"; 

		//Multiple mobiles numbers separated by comma
		$mobileNumber = "$mobile";

		//Sender ID,While using route4 sender id should be 6 characters long.
		$senderId = "IITTMA";

		//Your message to send, Add URL encoding here.
		$message = "Admission Form Submited Successfully. Your transaction_id is ".$razorpay_payment_id.".";
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

        
    // callback method
    public function callback() {      

    	$razorpay_payment_id = $this->input->post('razorpay_payment_id');

        if (!empty($razorpay_payment_id)) {
            
            $merchant_order_id = $this->input->post('merchant_order_id');
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
			$save_amount = $this->input->post('save_amount');
            $success = false;
            $error = '';
            try {                
                $ch = $this->get_curl_handle($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
						//echo "<pre>";print_r($response_array);exit;
                        //Check success response
                        if ($http_status == 200){
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
            if ($success === true) 
            {
            	$this->session->set_userdata('transaction_id', $razorpay_payment_id);
            	$userid = $this->session->userdata('user_id');

            	$Data['razorpay_trans_id'] = $razorpay_payment_id;
				$Data['amount'] = $save_amount;
				$Data['login_status'] = 2;
				$where = "user_id = '$userid'";
				$this->db_lib->update('user_master',$Data,$where);

				$rst = $this->db_lib->fetchRecord('user_master',$where,'user_mobile,course_id');
            	$this->session->set_userdata('course_id', $rst['course_id']);
	
            	//$this->messageSent($razorpay_payment_id,$rst['user_mobile']);
				
				//$whr_email = "mobile_verified_id = '$userid'";
                //$rst_email = $this->db_lib->fetchRecord('candidate_data',$whr_email,'email_id');
				//$this->emailSent($userid,$rst_email['email_id'],$rst['course_id']);

				redirect($this->input->post('merchant_surl_id'));
            } 
            else {
                redirect($this->input->post('merchant_furl_id'));
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    } 
    public function success() {

        $data['title'] = 'Razorpay Success | IITTM';
        $this->load->view('admission/success', $data);
    }  
    public function failed() {
        $data['title'] = 'Razorpay Failed | IITTM';            
        $this->load->view('admission/failed', $data);
    } 


    public function save_pdf_bba()
    {
        $user_id = $this->session->userdata('user_id');
        $pdfroot = 'C:/Inetpub/vhosts/ebiztechnocrats.com/httpdocs/iittm_2021/uploads/attachment/'.$user_id.".pdf";
        
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
        $output =$this->dompdf->output();
        file_put_contents($pdfroot,$output);
    }

    public function save_pdf_mba()
    {
        $user_id = $this->session->userdata('user_id');
        $pdfroot = 'C:/Inetpub/vhosts/ebiztechnocrats.com/httpdocs/iittm_2021/uploads/attachment/'.$user_id.".pdf";
        
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
        $output =$this->dompdf->output();
        file_put_contents($pdfroot,$output);
    }


    public function download_form()
    {
        $user_id = $this->session->userdata('user_id');
        //$user_id =63;
        //$pdfroot = 'F:/XAMPP/htdocs/iittm_2022/uploads/attachment/'.$user_id.".pdf";
        $pdfroot = 'https://ebiztechnocrats.com/iittm_2022/uploads/attachment/'.$user_id.".pdf";
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
        $output =$this->dompdf->output();
        file_put_contents($pdfroot,$output);
    }
	
	
	public function download_form_mba()
    {
		$user_id = $this->session->userdata('user_id');
		//$user_id =63;
		$pdfroot = 'F:/XAMPP/htdocs/iittm_2022/uploads/attachment/'.$user_id.".pdf";
		//$pdfroot = 'https://ebiztechnocrats.com/iittm_2022/uploads/attachment/'.$user_id.".pdf";
		
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
		$output =$this->dompdf->output();
		file_put_contents($pdfroot,$output);
    }

   

}