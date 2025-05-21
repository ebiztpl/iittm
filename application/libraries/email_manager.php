<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * library Email Manager
 * @author		ImpelPro Team
 *
**/

class Email_manager {
	var $ci;
	/**
	* Constructor
	*
	* @access private
	* 
	*/
	public function __construct()
	{
		$this->ci =& get_instance();
	}
	
	/**
	* Executed when requested send an email
	*
	* @access public
	* @param no parameters
	*/
	public function send_email($email_params)
	{
		// Ensure email id and password is spethis->cified to be able to login
		if(!isset($email_params))
		{
			return false;
		}
		
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'ebiztechnocrats.com@gmail.com',
			'smtp_pass' => 'ebiz@1234',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE,
			'priority' => 3,
			'newline' =>'\r\n',
			'smtp_timeout' => 30
			
			
			
		);
		
		$this->ci->load->library('email', $config);
		$this->ci->email->set_newline("\r\n");
		$this->ci->email->from($email_params['from'], $email_params['from']);
		$this->ci->email->to($email_params['To']);
		if(!empty($email_params['CC'])){
			$this->ci->email->cc($email_params['CC']);
		}
		if(!empty($email_params['BCC'])){
			$this->ci->email->bcc($email_params['BCC']);
		}
		$this->ci->email->subject($email_params['Subject']);
		$this->ci->email->message($email_params['Message']);
		$this->ci->email->attach($email_params['path']);
		
		if($this->ci->email->send()){
			return true;
		}
		 else {
			
			show_error($this->ci->email->print_debugger());
		} 
		return false;
	}
}