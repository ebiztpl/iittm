<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * HealthRepublic Helper
	 *
	 * @author		ImpelPro Dev Team
	**/

	function setFlash($variable, $message){
		$CI =& get_instance();
		$CI->session->set_userdata($variable, $message);
	}
	
	function getFlash($variable){
		$CI =& get_instance();
		if($CI->session->userdata($variable))
			$message = $CI->session->userdata($variable);
		$CI->session->unset_userdata($variable);
		return $message;
	}
	
	function hasFlash($variable){
		$CI =& get_instance();
		if($CI->session->userdata($variable))
			return true;
		return false;
	}
	