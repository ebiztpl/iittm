<?php

use FontLib\Table\Type\name;

defined('BASEPATH') or exit('No direct script access allowed');

class Myreport extends CI_Controller
{

    public $folder = "myreport/";

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

    public function filter_report()
    {
        $data['result'] = [];
        $this->load->view($this->folder . 'myreport', $data); // this will be the filter view file
    }

    // public function fetch_report()
    // {
    //     $from_date = $this->input->post('from');
    //     $to_date = $this->input->post('to');

    //     $this->db->where('DATE(call_date) >=', $from_date);
    //     $this->db->where('DATE(call_date) <=', $to_date);
    //     $query = $this->db->get('calling_data'); // replace with your actual table

    //     $result = [];
    //     foreach ($query->result() as $row) {
    //         $result[] = [
    //             'id' => $row->id,
    //             'title' => $row->call_action,
    //             'team_member_name' => $row->call_date,
    //             'category' => $row->call_action,
    //             'date' => date('d-m-Y', strtotime($row->call_date))
    //         ];
    //     }

    //     echo json_encode($result);
    // }

    // public function fetch_report()
    // {
    //     $from_date = $this->input->post('from');
    //     $to_date = $this->input->post('to');

    //     // Assuming the login session data holds user_id
    //     $user_id = $this->session->userdata('id'); // adjust key if different

    //     // Group by call_action to count each type
    //     $this->db->select('response_id, COUNT(*) as total');
    //     $this->db->from('calling_data');
    //     $this->db->where('DATE(call_date) >=', $from_date);
    //     $this->db->where('DATE(call_date) <=', $to_date);
    //     $this->db->where('team_id', $user_id); // assuming 'created_by' holds who entered the call
    //     $this->db->group_by('call_action');
    //     $query = $this->db->get();

    //     $result = [];
    //     foreach ($query->result() as $index => $row) {
    //         $result[] = [
    //             'sr_no' => $index + 1,
    //             'response_name' => $row->response_id,
    //             'total' => $row->total
    //         ];
    //     }

    //     echo json_encode($result);
    // }


    // public function fetch_response_report()
    // {
    //     $from_date = $this->input->post('from');
    //     $to_date = $this->input->post('to');
    //     $team_id = $this->session->userdata('admin_id'); // adjust if needed

    //     $this->db->select('responses.response_name, COUNT(calling_data.id) as total');
    //     $this->db->from('calling_data');
    //     $this->db->join('responses', 'id = calling_data.response_id', 'left');
    //     $this->db->where('DATE(calling_data.call_date) >=', $from_date);
    //     $this->db->where('DATE(calling_data.call_date) <=', $to_date);
    //     $this->db->where('calling_data.team_id', $team_id);
    //     $this->db->group_by('calling_data.response_id');
    //     $query = $this->db->get();

    //     $result = [];
    //     foreach ($query->result() as $index => $row) {
    //         $result[] = [
    //             'sr_no' => $index + 1,
    //             'response_name' => $row->response_name,
    //             'total' => $row->total
    //         ];
    //     }

    //     echo json_encode($result);
    // }

    public function fetch_report()
    {
        $from_date = $this->input->post('from');
        $to_date = $this->input->post('to');

        $team_id = $this->session->userdata('admin_id');

        $this->db->select('response_id, COUNT(*) as total');
        $this->db->from('calling_data');
        $this->db->where('DATE(call_date) >=', $from_date);
        $this->db->where('DATE(call_date) <=', $to_date);
        $this->db->where('team_id', $team_id);
        $this->db->group_by('response_id');
        $query = $this->db->get();

        $result = [];

        foreach ($query->result() as $row) {
            // Fetch the response text from responses table
            $this->db->where('id', $row->response_id);
            $response = $this->db->get('responses')->row();

            $result[] = [
                'response' => $response ? $response->name : 'N/A',
                'total' => $row->total
            ];
        }

        echo json_encode($result);
    }
}
