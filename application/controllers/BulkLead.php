<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BulkLead extends CI_Controller
{

    public $folder = "bulklead/";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('general_helper');
        $this->load->model("adminmodel");
        $this->load->model("usermodel");
    }

    public function index()
    {
        redirect('admin/login');
    }

}
