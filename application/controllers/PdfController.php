<?php defined('BASEPATH') OR exit('No direct script access allowed');
class PdfController extends CI_Controller {

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

		$data =$this->db_lib->fetchRecord('user_master','','*');
		$this->load->view('admission/user_list',array('users'=>$data));
		

		/*$html = $this->output->get_output();
		$this->load->library('pdf');
		$this->dompdf->loadHtml($html);
		$this->dompdf->setPaper('A4', 'landscape');
		$this->dompdf->render();
		$this->dompdf->stream("welcome.pdf", array("Attachment"=>0));*/
		}
} 