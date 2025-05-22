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
                $this->session->set_flashdata('error', 'Title is required.');
                redirect("bulklead/create_master");
                return;
            }

            $insert_data = [
                'title' => $title,
                'source' => $source,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('bulk_leads', $insert_data);

            if ($this->db->affected_rows() > 0) {
                setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
                redirect("bulklead/create_master");
            } else {
                setFlash("ViewMsgWarning", "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
                redirect("bulklead/create_master");
            }

            // else {
            //     setFlash("ViewMsgWarning", "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
            //     redirect("bulklead/create_master");
            // }
        }
        // For normal page load (non-AJAX), just load the upload form
        $data['title'] = $this->db->distinct()->select('id, title')->get('bulk_leads')->result_array();
        $this->load->view($this->folder . "bulklead",  $data);
    }

    public function download_sample()
    {
        $filename = "sample_upload.csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $output = fopen('php://output', 'w');

        // Headers
        fputcsv($output, ['S.No.', 'Full Name', 'Email', 'Mobile', 'DOB', 'Course', 'Father Name', 'Mother Name', 'Gender', 'Religion', 'Category', 'Nationality', 'parma_appertment', 'parma_colony', 'parma_area', 'parma_state', 'parma_city', 'parma_pincode']);


        fclose($output);
        exit;
    }

    public function upload_data()
    {
        $title = $this->input->post('title');

        // if (empty($title)) {
        //     $this->session->set_flashdata("error", "Please select a title.");
        //     redirect("bulklead/create_master");
        //     return;
        // }

        // if (empty($_FILES['upload_file']['name'])) {
        //     $this->session->set_flashdata("error", "Please select a file to upload.");
        //     redirect("bulklead/create_master");
        //     return;
        // }

        $file = $_FILES['upload_file']['tmp_name'];

        // try {
        //     $spreadsheet = IOFactory::load($file);
        // } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        //     $this->session->set_flashdata("error", "Error reading file: " . $e->getMessage());
        //     redirect("bulklead/create_master");
        //     return;
        // }

        // $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        if (($handle = fopen($file, "r")) !== FALSE) {
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $row++;
                if ($row == 1) continue; // Skip header row

                // Assuming your CSV columns correspond to these indexes (0-based)
                // Adjust indexes if needed
                // For example, B = column 1, C=2, D=3, etc.
                $full_name      = isset($data[1]) ? trim($data[1]) : '';
                $email          = isset($data[2]) ? trim($data[2]) : '';
                $mobile         = isset($data[3]) ? trim($data[3]) : '';
                $dob            = isset($data[4]) ? trim($data[4]) : '';
                $course         = isset($data[5]) ? trim($data[5]) : '';
                $father_name    = isset($data[6]) ? trim($data[6]) : '';
                $mother_name    = isset($data[7]) ? trim($data[7]) : '';
                $gender         = isset($data[8]) ? trim($data[8]) : '';
                $religion       = isset($data[9]) ? trim($data[9]) : '';
                $category       = isset($data[10]) ? trim($data[10]) : '';
                $nationality    = isset($data[11]) ? trim($data[11]) : '';
                $parma_appertment  = isset($data[12]) ? trim($data[12]) : '';
                $parma_colony   = isset($data[13]) ? trim($data[13]) : '';
                $parma_area     = isset($data[14]) ? trim($data[14]) : '';
                $parma_state    = isset($data[15]) ? trim($data[15]) : '';
                $parma_city     = isset($data[16]) ? trim($data[16]) : '';
                $parma_pincode  = isset($data[17]) ? trim($data[17]) : '';

                if (empty($full_name) || empty($mobile)) continue;

                // Split full name
                $name_parts = explode(' ', $full_name);
                $first_name = $name_parts[0] ?? '';
                $middle_name = $name_parts[1] ?? '';
                $last_name = isset($name_parts[2]) ? implode(' ', array_slice($name_parts, 2)) : '';

                // Check if user with login_status=1

                // $mobile = $this->db->escape($mobile);
                $this->db->where("CONVERT(user_mobile USING utf8) =", $mobile);
                $this->db->where('login_status', 1);
                $user = $this->db->get('user_master')->row();

                if ($user) {
                    // Existing user found with login_status=1
                    $user_id = $user->user_id;
                } else {
                    // Insert into user_master (only once if needed)
                    $this->db->insert('user_master', [
                        'user_mobile'     => $mobile,
                        'course_id'  => $course,
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
                    'email_id'           => $email,
                    'dob'             => $dob,
                    'course_name'          => $course,
                    'father_name'     => $father_name,
                    'mother_name'     => $mother_name,
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
                    'corre_appertment' => $parma_appertment,
                    'corre_colony'    => $parma_colony,
                    'corre_area'      => $parma_area,
                    'corre_state'     => $parma_state,
                    'corre_city'      => $parma_city,
                    'corre_pincode'   => $parma_pincode,
                    'source'          => $title,
                    // 'created_at'      => date('Y-m-d H:i:s')
                ]);
                if ($this->db->affected_rows() == 0) {
                    $error = $this->db->error();
                    var_dump($error);
                    exit;
                }
            }
            fclose($handle);
            $this->session->set_flashdata("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4><i class='icon fa fa-info'></i> Success!</h4> Data uploaded successfully!</div>");
        } else {
            $this->session->set_flashdata("error", "Unable to open the uploaded file.");
        }
        redirect("bulklead/create_master");
    }
}
