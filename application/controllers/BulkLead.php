<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bulklead extends CI_Controller
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

    public function create_master()
    {
        if ($this->input->method() === 'post') {
            $title = trim($this->input->post('title'));
            $source = trim($this->input->post('source'));

            // Server side validation: check title is not empty
            if (empty($title)) {
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['status' => 'error', 'message' => 'Title is required.']);
                    return;
                } else {
                    $this->session->set_flashdata('error', 'Title is required.');
                    redirect("bulklead/create_master");
                    return;
                }
            }

            $insert_data = [
                'title' => $title,
                'source' => $source,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('bulk_leads', $insert_data);

            if ($this->db->affected_rows() > 0) {
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['status' => 'success', 'message' => 'Record Inserted Successfully!']);
                } else {
                    setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'>...</div>");
                    redirect("bulklead/create_master");
                }

            } else {
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['status' => 'error', 'message' => 'Something went wrong!']);
                } else {
                    setFlash("ViewMsgWarning", "<div class='alert alert-danger alert-dismissible'>...</div>");
                    redirect("bulklead/create_master");
                }
            }
        } else {
            // For normal page load (non-AJAX), just load the upload form
            $data['title'] = $this->db->distinct()->select('id, title')->get('bulk_leads')->result_array();
            $this->load->view($this->folder . "bulklead",  $data);
        }
    }

    public function download_sample()
    {
        $filename = "sample_upload.csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $output = fopen('php://output', 'w');

        // Headers
        fputcsv($output, ['S.No.', 'First Name', 'Middle Name', 'Last Name', 'Email', 'Mobile', 'DOB', 'Course', 'Father Name', 'Mother Name', 'Alternate_mobile', 'Gender', 'Religion', 'Category', 'Nationality', 'Permanent Appartment', 'Permanent Colony', 'Permanent Area', 'Permanent State', 'Permanent City', 'Permanent Pincode', 'Corresponding Appartment', 'Corresponding Colony', 'Corresponding Area', 'Corresponding State', 'Corresponding City', 'Corresponding Pincode', 'Academic Intermediate', 'Academic Board', 'Academic Year', 'Academic Status']);


        fclose($output);
        exit;
    }

    public function upload_data()
    {
        header('Content-Type: application/json');
        
        $title = $this->input->post('title');

        if (empty($title)) {
            echo json_encode(['status' => 'error', 'message' => 'Please select a title.']);
            return;
        }
    
        if (empty($_FILES['upload_file']['name'])) {
            echo json_encode(['status' => 'error', 'message' => 'Please select a file to upload.']);
            return;
        }

        $file = $_FILES['upload_file']['tmp_name'];

        if (($handle = fopen($file, "r")) !== FALSE) {
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if ($row == 1) continue; // Skip header row
                $first_name     = isset($data[1]) ? trim($data[1]) : '';
                $middle_name    = isset($data[2]) ? trim($data[2]) : '';
                $last_name      = isset($data[3]) ? trim($data[3]) : '';
                $email          = isset($data[4]) ? trim($data[4]) : '';
                $mobile         = isset($data[5]) ? trim($data[5]) : '';
                $raw_dob        = isset($data[6]) ? trim($data[6]) : '';
                $course         = isset($data[7]) ? trim($data[7]) : '';
                $father_name    = isset($data[8]) ? trim($data[8]) : '';
                $mother_name    = isset($data[9]) ? trim($data[9]) : '';
                $father_mobile  = isset($data[10]) ? trim($data[10]) : '';
                $gender         = isset($data[11]) ? trim($data[11]) : '';
                $religion       = isset($data[12]) ? trim($data[12]) : '';
                $category       = isset($data[13]) ? trim($data[13]) : '';
                $nationality    = isset($data[14]) ? trim($data[14]) : '';
                $parma_appertment  = isset($data[15]) ? trim($data[15]) : '';
                $parma_colony   = isset($data[16]) ? trim($data[16]) : '';
                $parma_area     = isset($data[17]) ? trim($data[17]) : '';
                $parma_state    = isset($data[18]) ? trim($data[18]) : '';
                $parma_city     = isset($data[19]) ? trim($data[19]) : '';
                $parma_pincode  = isset($data[20]) ? trim($data[20]) : '';
                $corre_appertment  = isset($data[21]) ? trim($data[21]) : '';
                $corre_colony   = isset($data[22]) ? trim($data[22]) : '';
                $corre_area     = isset($data[23]) ? trim($data[23]) : '';
                $corre_state    = isset($data[24]) ? trim($data[24]) : '';
                $corre_city     = isset($data[25]) ? trim($data[25]) : '';
                $corre_pincode  = isset($data[26]) ? trim($data[26]) : '';
                $academic_intermediate  = isset($data[27]) ? trim($data[27]) : '';
                $academic_board  = isset($data[28]) ? trim($data[28]) : '';
                $academic_year  = isset($data[29]) ? trim($data[29]) : '';
                $academic_status  = isset($data[30]) ? trim($data[30]) : '';

                if (empty($first_name) || empty($mobile)) continue;

                // // Split full name
                // $name_parts = explode(' ', $full_name);
                // $first_name = $name_parts[0] ?? '';
                // $middle_name = $name_parts[1] ?? '';
                // $last_name = isset($name_parts[2]) ? implode(' ', array_slice($name_parts, 2)) : '';

                // date format yyyy-mm-dd
                $dob = '';
                if (!empty($raw_dob)) {
                    $timestamp = strtotime($raw_dob);
                    if ($timestamp !== false) {
                        $dob = date('Y-m-d', $timestamp);
                    }
                }

                // Get state ID
                $this->db->where('name', $parma_state);
                $state = $this->db->get('states')->row();
                $parma_state = $state ? $state->id : 0;

                // Get city ID
                $this->db->where('name', $parma_city);
                $city = $this->db->get('cities')->row();
                $parma_city = $city ? $city->id : 0;

                $this->db->where('name', $corre_state);
                $state = $this->db->get('states')->row();
                $corre_state = $state ? $state->id : 0;

                // Get city ID
                $this->db->where('name', $corre_city);
                $city = $this->db->get('cities')->row();
                $corre_city = $city ? $city->id : 0;

                // Map course to ID
                $course_name = strtolower($course);
                $course_id = 0;
                if ($course_name === 'bba') {
                    $course_id = 1;
                } elseif ($course_name === 'mba') {
                    $course_id = 2;
                }

                // $mobile = $this->db->escape($mobile);
                $this->db->where("CONVERT(user_mobile USING utf8) =", $mobile);
                $this->db->where('login_status', 2);
                $user = $this->db->get('user_master')->row();

                if ($user) {
                    // Existing user found with login_status=1
                    $user_id = $user->user_id;
                } else {
                    // Insert into user_master (only once if needed)
                    $this->db->insert('user_master', [
                        'user_mobile'     => $mobile,
                        'course_id'  => $course_id,
                        'login_status' => 3,
                        'razorpay_trans_id' => 'Bulklead',
                        'amount' => 0,
                        'created_date' => date('Y-m-d H:i:s')
                    ]);
                    if ($this->db->affected_rows() == 0) {
                        $error = $this->db->error();
                        var_dump($error);
                        exit;
                    }
                    $user_id = $this->db->insert_id();
                    echo $user_id;
                }
                // Insert into candidate_data
                $this->db->insert('candidate_data', [
                    'mobile_verified_id' => $user_id,
                    'first_name'      => $first_name,
                    'middle_name'     => $middle_name,
                    'last_name'       => $last_name,
                    'mobile'          => $mobile,
                    'email_id'        => $email,
                    'dob'             => $dob,
                    'course_name'     => $course_id,
                    'father_name'     => $father_name,
                    'mother_name'     => $mother_name,
                    'father_mobile'   => $father_mobile,
                    'gender'          => $gender,
                    'religion'        => $religion,
                    'category'        => $category,
                    'nationality'     => $nationality,
                    'parma_appertment' => $parma_appertment,
                    'parma_colony'    => $parma_colony,
                    'parma_area'      => $parma_area,
                    'parma_state'     => $parma_state,
                    'parma_city'      => $parma_city,
                    'parma_pincode'   => $parma_pincode,
                    'corre_appertment' => $corre_appertment,
                    'corre_colony'    => $corre_colony,
                    'corre_area'      => $corre_area,
                    'corre_state'     => $corre_state,
                    'corre_city'      => $corre_city,
                    'corre_pincode'   => $corre_pincode,
                    'academic_intermediate'   => $academic_intermediate,
                    'academic_board'   => $academic_board,
                    'academic_year'  => $academic_year,
                    'academic_status'   => $academic_status,
                    'source'          => $title,
                    'post_date' => date('Y-m-d H:i:s')
                ]);
                if ($this->db->affected_rows() == 0) {
                    $error = $this->db->error();
                    var_dump($error);
                    exit;
                }
            }
            fclose($handle);
            echo json_encode(['status' => 'success', 'message' => 'Data Uploaded Successfully!']);
        } else {
            $this->session->set_flashdata("error", "Unable to Open the Uploaded File.");
        }
        // redirect("bulklead/create_master");
    }
}
