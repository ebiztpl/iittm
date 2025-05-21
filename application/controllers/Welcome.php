<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
    {
        // this is your constructor
        parent::__construct();
        $this->load->helper('form');
    }

	public function index()
	{
		redirect('admission/mobile_verification');
	}
}
