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
        $this->load->view($this->folder . 'myreport', $data);
    }

    public function fetch_report()
    {
        $from_date = $this->input->post('from');
        $to_date = $this->input->post('to');

        $team_id = $this->session->userdata('admin_id');

        // 1. Fetch assignment names
        $this->db->distinct();
        $this->db->select('a.assignment_id, am.assignment_name');
        $this->db->from('calling_data cd');
        $this->db->join('assignment a', 'a.assign_id = cd.assign_id', 'left');
        $this->db->join('assignment_master am', 'am.id = a.assignment_id', 'left');
        $this->db->where('cd.team_id', $team_id);
        $this->db->where('DATE(cd.call_date) >=', $from_date);
        $this->db->where('DATE(cd.call_date) <=', $to_date);
        $query_assignments = $this->db->get();

        $assignment_names = [];
        foreach ($query_assignments->result() as $row) {
            if (!in_array($row->assignment_name, $assignment_names)) {
                $assignment_names[] = $row->assignment_name;
            }
        }

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

        echo json_encode([
            'data' => $result,
            'assignments' => implode(' / ', $assignment_names)
        ]);
    }
}
