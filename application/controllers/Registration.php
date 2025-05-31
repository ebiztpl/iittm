<?php defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends CI_Controller
{

    public $folder = "admission_process/";

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

    public function all_steps() 
    {

        if (!$this->usermodel->hasLoggedIn()) {
            redirect("admin/login");
        }


        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.msg91.com/api/balance.php?authkey=322873AxMkWjplhxu5e6a21f3P1&type=4",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            "cURL Error #:" . $err;
        } else {
            $response;
        }

        $total_regis = $this->db->query("SELECT count(*) as count FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id WHERE um.course_id in (1,2) AND ca.duplicate = 0 AND um.login_status = 2")->row('count');


        $whr_inc = "login_status=1";
        $total_inc = $this->adminmodel->record_count('user_master', $whr_inc);


        $admission = $this->db->query("SELECT count(*) as count FROM candidate_data where admission = '1'")->row('count');

        $waiting  = $this->db->query("SELECT count(*) as count FROM calling_data INNER JOIN candidate_data cd ON cd.mobile_verified_id = calling_data.user_id where calling_data.response_id = 32")->row('count');


        $in_not_interested = $this->db->query("SELECT count(*) as count FROM assignment INNER JOIN user_master um on um.user_id = assignment.user_id where assignment.status = 1 and um.login_status=1")->row('count');

        $interested = $this->db->query("SELECT count(*) as count FROM assignment INNER JOIN user_master um on um.user_id = assignment.user_id where assignment.status = 0 and um.login_status=1")->row('count');

        $gdpi = $this->db->query("SELECT count(*) as count from exam_master em INNER JOIN candidate_exam ce on ce.exam_id = em.id INNER JOIN candidate_result cr on cr.link_id = ce.id where em.exam_type='gdpi' and cr.exam_status='pass'")->row('count');

        $gdpi_not_done = $this->db->query("SELECT count(*) as count from exam_master em INNER JOIN candidate_exam ce on ce.exam_id = em.id INNER JOIN candidate_result cr on cr.link_id = ce.id where em.exam_type='gdpi' and cr.attendance='absent'")->row('count');

        $entrance = $this->db->query("SELECT count(*) as count from exam_master em INNER JOIN candidate_exam ce on ce.exam_id = em.id INNER JOIN candidate_result cr on cr.link_id = ce.id where em.exam_type='entrance' and cr.exam_status='pass'")->row('count');

        $entrance_not_done = $this->db->query("SELECT COUNT(DISTINCT ce.user_id) as count from exam_master em INNER JOIN candidate_exam ce on ce.exam_id = em.id INNER JOIN candidate_result cr on cr.link_id = ce.id where em.exam_type='entrance' and cr.attendance='absent'")->row('count');

   

        $this->load->view($this->folder . "all_steps", array('balance' => $response, 'total_regis' => $total_regis, 'total_inc' => $total_inc,  'admission' => $admission, 'waiting' =>  $waiting, 'in_not_interested' => $in_not_interested, 'interested' => $interested, 'gdpi' => $gdpi, 'gdpi_not_done' => $gdpi_not_done, 'entrance' => $entrance, 'entrance_not_done' => $entrance_not_done));
    
    }

    public function admission_process_details() 
    {
        $section_id = $this->uri->segment(3);
        $from = $this->input->post('from');
        $to = $this->input->post('to');

        if (!empty($from) && !empty($to)) {
            $from_date = date('Y-m-d', strtotime($from)) . " 00:00:01";
            $to_date = date('Y-m-d', strtotime($to)) . " 23:59:59";
            $conditions[] = "user_master.created_date BETWEEN '$from_date' AND '$to_date'";
        }
    
        if ($section_id == "registration") {

            $table = "user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city";
            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
            $whr = "user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate = 0";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);
        }

        if($section_id == "entrance_done") {
            $table = "user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city LEFT JOIN candidate_exam AS ce on ce.user_id = candidate_data.mobile_verified_id
            LEFT JOIN exam_master AS em ON em.id = ce.exam_id 
            LEFT JOIN candidate_result AS cr ON cr.link_id = ce.id";
            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
            $whr = "em.exam_type = 'entrance' AND cr.exam_status = 'pass' GROUP BY user_master.user_id";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);   
        }

        if($section_id == "entrance_not_done") {
            $table = "user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city LEFT JOIN candidate_exam AS ce on ce.user_id = candidate_data.mobile_verified_id
            LEFT JOIN exam_master AS em ON em.id = ce.exam_id 
            LEFT JOIN candidate_result AS cr ON cr.link_id = ce.id";
            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
            $whr = "em.exam_type='entrance' and cr.attendance='absent'  GROUP BY user_master.user_id";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);
        }

        if($section_id == "gdpi_done") {
            $table = "user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city LEFT JOIN candidate_exam AS ce on ce.user_id = candidate_data.mobile_verified_id
            LEFT JOIN exam_master AS em ON em.id = ce.exam_id 
            LEFT JOIN candidate_result AS cr ON cr.link_id = ce.id";
            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
            $whr = "em.exam_type='gdpi' and cr.exam_status='pass' GROUP BY user_master.user_id";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);
        }
        
        if($section_id == "gdpi_not_done") {
            $table = "user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city LEFT JOIN candidate_exam AS ce on ce.user_id = candidate_data.mobile_verified_id
            LEFT JOIN exam_master AS em ON em.id = ce.exam_id LEFT JOIN candidate_result AS cr ON cr.link_id = ce.id";
            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
            $whr = "em.exam_type='gdpi' and cr.attendance='absent'  GROUP BY user_master.user_id";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);
        }

        if ($section_id == "admission") {

            $table = 'user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';
            $whr = "candidate_data.admission = 1 and user_master.login_status=2";
            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);
        }

        if ($section_id == "waiting_for_admission") {

            $table = 'user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city LEFT JOIN calling_data ON calling_data.user_id = user_master.user_id';
            $whr = "calling_data.response_id = 32 and user_master.login_status=2";
            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);
        }

        if ($section_id == "incomplete_registration") {

            if (isset($_POST['from'])) {

                $from =  $_POST['from'];
                $to = $_POST['to'];

                $whr = "user_master.login_status=1 AND user_master.created_date BETWEEN '$from 00:00:01' AND '$to 23:59:59'";
            } else {
                $whr = "user_master.login_status=1";
            }



            $table = 'user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city';

            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city ";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);
        }


        if ($section_id == "interested") {
            $table = 'user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city INNER JOIN assignment on assignment.user_id = user_master.user_id';
            $whr = "assignment.status = 0 and user_master.login_status=1";
            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);
        }

        if ($section_id == "not_interested") {
            $table = 'user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id LEFT JOIN states ON states.id=candidate_data.parma_state LEFT JOIN cities ON cities.id=candidate_data.parma_city LEFT JOIN states stc ON stc.id=candidate_data.corre_state LEFT JOIN cities ctc ON ctc.id=candidate_data.corre_city INNER JOIN assignment on assignment.user_id = user_master.user_id';
            $whr = "assignment.status = 1 and user_master.login_status=1";
            $fields = "*,states.name as parma_state, cities.name as parma_city,stc.name as corre_state, ctc.name as corre_city";
            $result = $this->db_lib->fetchRecords($table, $whr, $fields);
        }



       

        $this->load->view($this->folder . "admission_process_details", array('result' => $result, 'titlenma' => $section_id));
    }
}
