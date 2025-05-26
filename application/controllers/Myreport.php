<?php defined('BASEPATH') or exit('No direct script access allowed');

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
        // Fetch only telecallers for dropdown
        $this->db->select('admin_id, admin_name');
        $this->db->from('admin');
        $this->db->where('role', 'telecaller');
        $users = $this->db->get()->result();

        $data['user'] = $users;
        $data['result'] = [];

        $this->load->view($this->folder . 'myreport', $data);
    }

    public function fetch_report()
    {
        $from_date = $this->input->post('from');
        $to_date = $this->input->post('to');
        $team_id = $this->input->post('team_member');
        $user_type = $this->session->userdata('role');


        // If not selected by admin, fallback to current session team member
        if (empty($team_id)) {
            $team_id = $this->session->userdata('admin_id');
        }

        // 1. Fetch assignment names
        $this->db->distinct();
        $this->db->select('a.assignment_id, am.assignment_name');
        $this->db->from('calling_data cd');
        $this->db->join('assignment a', 'a.assign_id = cd.assign_id', 'left');
        $this->db->join('assignment_master am', 'am.id = a.assignment_id', 'left');
        // Filter by team_id if user is admin or telecaller
        if ($user_type == 'admin' || $user_type == 'telecaller') {
            $this->db->where('cd.team_id', $team_id);
        }

        $this->db->where('DATE(cd.call_date) >=', $from_date);
        $this->db->where('DATE(cd.call_date) <=', $to_date);
        $assignments = $this->db->get()->result();

        $final_result = [];

        foreach ($assignments as $assignment) {
            $this->db->select('cd.response_id, COUNT(*) as total');
            $this->db->from('calling_data cd');
            $this->db->join('assignment a', 'a.assign_id = cd.assign_id', 'left');
            if ($user_type == 'admin' || $user_type == 'telecaller') {
                $this->db->where('cd.team_id', $team_id);
            }
            $this->db->where('a.assignment_id', $assignment->assignment_id);
            $this->db->where('DATE(cd.call_date) >=', $from_date);
            $this->db->where('DATE(cd.call_date) <=', $to_date);
            $this->db->group_by('cd.response_id');
            $response_query = $this->db->get()->result();

            $response_data = [];
            foreach ($response_query as $resp_row) {
                $response = $this->db->get_where('responses', ['id' => $resp_row->response_id])->row();
                $response_data[] = [
                    'response' => $response ? $response->name : 'N/A',
                    'response_id' => $response ? $response->id : 'N/A',
                    'total' => $resp_row->total
                ];
            }

            $final_result[] = [
                'assignment' => $assignment->assignment_name,
                'assignment_id' => $assignment->assignment_id,
                'responses' => $response_data,
                // 'responses' => $response
            ];
        }

        // 3. Fetch only telecallers for dropdown
        $this->db->select('admin_id, admin_name');
        $this->db->from('admin');
        $this->db->where('role', 'telecaller');
        $users = $this->db->get()->result();

        echo json_encode([
            'data' => $final_result,
            'team_members' => $users
        ]);
    }

    // Method to load the page with DataTable
    public function report_details()
    {
        // Load database, helpers, etc. if needed
        $this->load->database();

        $assignment_id = $this->input->get('assignment_id');
        $response_id   = $this->input->get('response_id');
        $from_date     = $this->input->get('from_date');
        $to_date       = $this->input->get('to_date');

        // Base query
        $this->db->select('*');
        $this->db->from('calling_data');

        // Filter based on provided GET parameters
        if (!empty($assignment_id)) {
            $this->db->where('assign_id', $assignment_id);
        }

        if (!empty($response_id)) {
            $this->db->where('response_id', $response_id);
        }

        if (!empty($from_date) && !empty($to_date)) {
            $this->db->where('DATE(calling_data.call_date) >=', $from_date);
            $this->db->where('DATE(calling_data.call_date) <=', $to_date);
        }

        $query = $this->db->get();
        $data['report_data'] = $query->result();

        // Optional: pass filter labels to view
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;
        $data['assignment_id'] = $assignment_id;
        $data['response_id'] = $response_id;

        // Load view
        $this->load->view('myreport/report_details', $data);
    }

    // AJAX method to fetch data for DataTable
    public function report_details_display()
    {
        $draw = intval($this->input->post("draw"));
        $assignment_id = $this->input->post('assignment_id');
        $response_id = $this->input->post('response_id');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        // Build where clause dynamically
        $where = "WHERE am.id = ?";
        $params = [$assignment_id];

        if (!empty($from_date) && !empty($to_date)) {
            $where .= " AND DATE(cd.call_date) BETWEEN ? AND ?";
            $params[] = $from_date;
            $params[] = $to_date;
        }

        if (!empty($response_id)) {
            $where .= " AND cd.response_id = ?";
            $params[] = $response_id;
        }

        // Main query fetching assignments with user and master data
        $query = $this->db->query("
            SELECT DISTINCT um.*, aa.created_at, aa.assign_id, aa.campaign_id, am.id as course_id
            FROM assignment aa
            INNER JOIN assignment_master am ON am.id = aa.assignment_id
            INNER JOIN calling_data cd ON cd.user_id = aa.user_id AND cd.assign_id = aa.assign_id
            INNER JOIN user_master um ON um.user_id = aa.user_id
            $where
        ", $params);

        $data = [];
        $n = 0;
        $completed = 0;

        foreach ($query->result() as $r) {
            $n++;
            $user_id = $r->user_id;

            // Fetch candidate data
            $candidate_data = $this->db->where([
                'mobile_verified_id' => $user_id,
                'duplicate' => 0
            ])->get('candidate_data')->row();

            if (!$candidate_data) continue;

            // Candidate full name with link
            $fullname = "<a href='" . site_url("journey/show_journey/{$user_id}") . "' target='_blank'>{$candidate_data->first_name} {$candidate_data->middle_name} {$candidate_data->last_name}</a>";
            $course = ($candidate_data->course_name == 1) ? "BBA" : (($candidate_data->course_name == 2) ? "MBA" : "");
            $email = $candidate_data->email_id;
            $gender = $candidate_data->gender;
            $category = $candidate_data->category;
            $dob = $candidate_data->dob;
            $father_name = $candidate_data->father_name ?? "";
            $mother_name = $candidate_data->mother_name ?? "";
            $parma_state = $this->db->select('name')->where('id', $candidate_data->parma_state)->get('states')->row('name') ?? '';
            $parma_city = $this->db->select('name')->where('id', $candidate_data->parma_city)->get('cities')->row('name') ?? '';
            $study_center1 = $candidate_data->study_centre_1 ?? '';

            $candidate_info = "
                <b>Enroll No.: </b> 0000{$user_id}<br/>
                <b>Full Name: </b>{$fullname}<br/>
                <b>Mobile :</b> {$r->user_mobile}<br/>
                <b>Father Name: </b>{$father_name}<br/>
                <b>Mother Name: </b>{$mother_name}<br/>
                <b>DOB: </b>{$dob}<br/>
                <b>Email: </b>{$email}<br/>
                <b>Gender: </b>{$gender}";

            $academic_info = "
                <b>Course: </b>{$course}<br/>
                <b>Study Center: </b>{$study_center1}<br/>
                <b>Category: </b>{$category}<br/>
                <b>State: </b>{$parma_state}<br/>
                <b>City: </b>{$parma_city}<br/>
                <b>Enroll DateTime: </b>" . date("d-M-Y", strtotime($r->created_at));

            // Build communication query with filters (join with calling_data)
            $comm_query = "
                SELECT cd.*, admin.admin_name as tname, mode.name as mname, campaign.name as cname, responses.name as rname 
                FROM calling_data cd
                INNER JOIN admin ON admin.admin_id = cd.team_id
                INNER JOIN mode ON mode.id = cd.mode
                INNER JOIN campaign ON campaign.id = cd.campaign_id
                INNER JOIN responses ON responses.id = cd.response_id
                WHERE cd.user_id = ? AND cd.assign_id = ?
            ";
            $comm_params = [$user_id, $r->assign_id];

            if (!empty($response_id)) {
                $comm_query .= " AND cd.response_id = ?";
                $comm_params[] = $response_id;
            }

            if (!empty($from_date) && !empty($to_date)) {
                $comm_query .= " AND DATE(cd.call_date) BETWEEN ? AND ?";
                $comm_params[] = $from_date;
                $comm_params[] = $to_date;
            }

            $comm_query .= " ORDER BY cd.call_date ASC";

            $communication = $this->db->query($comm_query, $comm_params)->result_array();

            $communicate = '';
            foreach ($communication as $comm) {
                $tags = '';
                if (!empty($comm['tag'])) {
                    $tag_ids = explode(',', $comm['tag']);
                    foreach ($tag_ids as $tag_id) {
                        $tag_name = $this->db->select('name')->where('tag_id', $tag_id)->get('tags')->row('name');
                        if ($tag_name) {
                            $tags .= "<span class='badge badge-primary'>{$tag_name}</span> &nbsp;";
                        }
                    }
                }

                $communicate .= "<div class='tracking-item'>
                    <div class='tracking-date'><b>DateTime: </b>" . date('M d, Y', strtotime($comm['call_date'])) . " <span>" . date('h:i A', strtotime($comm['call_time'])) . "</span></div>
                    <div class='tracking-content'>
                        <b>Campaign: </b><span style='color:red; font-size:18px; padding-bottom:10px;'>{$comm['cname']}</span><br/>
                        <b>Calling Team: </b>{$comm['tname']}<br/>
                        <b>Communication Mode: </b>{$comm['mname']}<br/>
                        <b>Call Action: </b>{$comm['call_action']}<br/>
                        <b>Call Response: </b>{$comm['rname']}<br/>
                        <b>Remark: </b>{$comm['notes']}<br/>
                        <b>Tags: </b>{$tags}
                    </div>
                </div>";
            }

            $checkbox_html = '';
            $calling_check = $this->db->where('assign_id', $r->assign_id)->get('calling_data')->row();

            if ($this->session->userdata('role') == 'telecaller') {
                if ($calling_check) {
                    $checkbox_html = "<b>Done</b>";
                    $completed++;
                } else {
                    $checkbox_html = "<input type='checkbox' value='{$user_id}' assign-id='{$r->assign_id}' class='exam_status checkbox' name='user_id[]'/>";
                }
            } elseif ($calling_check) {
                $completed++;
            }

            $data[] = [
                $n . ". " . $checkbox_html,
                $candidate_info,
                $academic_info,
                $communicate,
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "data" => $data
        ]);
    }
}
