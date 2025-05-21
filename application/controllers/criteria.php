<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Controller Class
 *
 * @author		ImpelPro Dev Team
**/

class Criteria extends CI_Controller {
	
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
	
	
	public function download()
	{
		$user_id = $this->input->post('userid');
		$course = $this->input->post('course');
		$Data['download_status'] = 1;
		$Data['course_id'] = $course;
		$where = "user_id = '$user_id'";
		$srt = $this->db_lib->update('user_master',$Data,$where);
		if($srt!=0)
		{
			echo 1;
		}
	}


	
	
}	