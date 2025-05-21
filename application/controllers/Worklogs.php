<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Worklogs extends CI_Controller
{

    public $folder = "worklogs/";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Worklog_model');
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

     public function create_worklogs()
    {
        if (!$this->usermodel->hasLoggedIn()) {
            redirect("admin/login");
        }
        if (isset($_POST['btnsubmit'])) {
            $fetch =  $this->db->select('*')->from('admin')->where('admin_name', $_POST['admin_name'])->get()->row();
            $selected_ids = $this->input->post('team_members'); // array of selected admin_ids
            if (!empty($selected_ids)) {
                // Get corresponding admin names
                $this->db->select('admin_name');
                $this->db->from('admin');
                $this->db->where_in('admin_id', $selected_ids);
                $result = $this->db->get()->result_array();
                $team_member_name = implode(', ', array_column($result, 'admin_name'));
            } else {
                $team_member_name = '';
            }
            // Check if a user with that exact team_member_names already exists (optional logic)
            $fetch = $this->db->select('*')
                ->from('admin')
                ->where('admin_name', $_POST['admin_name'])
                ->get()
                ->row();
            if (empty($fetch)) {
                $data = array(
                    'title' => $_POST['title'],
                    'team_member_name' => $team_member_name,
                    'date' => $_POST['date'],
                    'description' => $_POST['description'],
                    'category' => isset($_POST['categories']) ? implode(', ', $_POST['categories']) : ''
                );
                $last_id = $this->db_lib->insert('work_log', $data, '');
                if ($last_id > 0) {
                    setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
                    redirect("worklogs/create_worklogs");
                } else {
                    setFlash("ViewMsgWarning", "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
                    redirect("worklogs/create_worklogs");
                }
            } else {
                setFlash("ViewMsgWarning", "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
                redirect("worklogs/create_worklogs");
            }
        }
        $arry_data =  $this->db->select('*')->from('work_log')->get()->result();
        $team_members = $this->db->select('admin_id, admin_name')->from('admin')->get()->result();
        $categories = $this->db->get('categories')->result();
        $this->load->view($this->folder . "worklogs", array(
            'result' => $arry_data,
            'team_members' => $team_members,
            'categories' => $categories
        ));
    }


    public function delete_worklogs()
    {
        $id = $_POST['id'];
        $where = "id='$id'";
        $delete = $this->db_lib->delete("work_log", $where);
        if ($delete) {

            echo 1;
        }
    }

  public function get_worklogs()
    {
        $id = $_POST['id'];
        $where = "id='$id'";
        $get = $this->db_lib->fetchRecords("work_log", $where, '*');
        $record = $this->db->get_where('work_log', ['id' => $id])->row_array();
        // Explode comma-separated string into array
        $record['team_member_name'] = explode(',', $record['team_member_name']);
        $record['category'] = explode(',', $record['category']);
        echo json_encode($get);
    }


     public function edit_worklogs()
    {
        $id = $_POST['edit_id'];
        $where = "id = '$id'";
        // :white_check_mark: SAFELY handle multiple select fields
        $team_member_post = $this->input->post('team_member_name');
        $category_post = $this->input->post('category');
        $team_member = is_array($team_member_post) ? implode(', ', $team_member_post) : '';
        $category = is_array($category_post) ? implode(', ', $category_post) : '';
        $update_data = array(
            'title' => $_POST['title_edit'],
            'date' => $_POST['date_edit'],
            'team_member_name' => $team_member,
            'category' => $category,
            'description' => $_POST['description_edit'],
        );
        $rst = $this->db_lib->update('work_log', $update_data, $where);
        if ($rst) {
            setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
            redirect("worklogs/create_worklogs");
        }
    }
	
	 public function add_worklog()
    {
        $data['team_members'] = $this->Worklog_model->get_all_team_members();
        $this->load->view('worklogs', $data);
    }
	
	 public function create_category()
    {
        $category = $this->input->post("category-create");
        $exists = $this->db->get_where('categories', ['name' => $category])->row();
        if ($exists) {
            echo json_encode(['success' => false, 'message' => 'Category already exists']);
        } else {
            $this->db->insert('categories', ['name' => $category]);
            echo json_encode(['success' => true, 'message' => 'Category Created Successfully']);
        }
            // $id = $this->db_lib->insert('categories', array('name' => $category), '');
            // return $id;
    }
    public function get_category()
    {
        $categories = $this->db->select('category_id as id, name as text')->from('categories')->get()->result();
        echo json_encode($categories);
    }
    
}
