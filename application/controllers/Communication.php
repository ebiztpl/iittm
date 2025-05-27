<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Controller Class
 *
 * @author		ImpelPro Dev Team
 **/

class Communication extends CI_Controller
{

	public $folder = "communication/";

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('general_helper');
		$this->load->model("adminmodel");
		$this->load->model("usermodel");

		date_default_timezone_set("Asia/Calcutta");
	}

	public function team()
	{
		if (!$this->usermodel->hasLoggedIn()) {
			redirect("admin/login");
		}

		if (isset($_POST['btnsubmit'])) {


			if (empty($fetch)) {

				$data = array(
					'name' => $_POST['exam_name'],
				);

				$last_id = $this->db_lib->insert('team', $data, '');

				if ($last_id > 0) {
					setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
					redirect("communication/team");
				} else {
					setFlash("ViewMsgWarning", "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
					redirect("communication/team");
				}
			} else {
				setFlash("ViewMsgWarning", "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("communication/team");
			}
		}


		$arry_data =  $this->db->select('*')->from('team')->get()->result();
		$this->load->view($this->folder . "team", array('result' => $arry_data));
	}


	public function delete_team()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$delete = $this->db_lib->delete("team", $where);
		if ($delete) {

			echo 1;
		}
	}

	public function get_team()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("team", $where, '*');

		echo json_encode($get);
	}


	public function edit_team()
	{
		$id = $_POST['edit_id'];

		$where = "id = '$id'";
		$update_data = array(
			'name' => $_POST['exam_name'],
		);
		$rst = $this->db_lib->update('team', $update_data, $where);

		if ($rst) {
			setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			redirect("communication/team");
		}
	}


	public function admit_card()
	{

		$rst_form_data = $this->db_lib->fetchRecords('update_form', '', '*');
		$this->load->view($this->folder . "admit_card", array('result' => $rst_form_data));
	}


	public function campaign()
	{
		if (!$this->usermodel->hasLoggedIn()) {
			redirect("admin/login");
		}

		if (isset($_POST['btnsubmit'])) {


			if (empty($fetch)) {

				$data = array(
					'name' => $_POST['exam_name'],
					'description' => $_POST['desc'],
				);

				$last_id = $this->db_lib->insert('campaign', $data, '');

				if ($last_id > 0) {
					setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
					redirect("communication/campaign");
				} else {
					setFlash("ViewMsgWarning", "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
					redirect("communication/campaign");
				}
			} else {
				setFlash("ViewMsgWarning", "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("communication/campaign");
			}
		}


		$arry_data =  $this->db->select('*')->from('campaign')->get()->result();
		$this->load->view($this->folder . "campaign", array('result' => $arry_data));
	}

	public function delete_campaign()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$delete = $this->db_lib->delete("campaign", $where);
		if ($delete) {

			echo 1;
		}
	}

	public function get_campaign()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("campaign", $where, '*');

		echo json_encode($get);
	}

	public function get_campaign_with_response()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("campaign", $where, '*');

		$rwhere = "campaign_id='$id'";
		$responses = $this->db_lib->fetchRecords("responses", $rwhere, '*');

		$res = "";
		if ($responses) {
			$res = "<ul>";
			foreach ($responses as $key => $value) {
				$res .= "<li>" . $value['name'] . "</li>";
			}
			$res .= "</ul>";
		}

		$data['campaign'] = $get;
		$data['response'] = $res;

		echo json_encode($data);
	}


	public function edit_campaign()
	{
		$id = $_POST['edit_id'];

		$where = "id = '$id'";
		$update_data = array(
			'name' => $_POST['exam_name'],
			'description' => $_POST['desc'],
		);


		//print_r($update_data); die;
		$rst = $this->db_lib->update('campaign', $update_data, $where);

		if ($rst) {
			setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			redirect("communication/campaign");
		}
	}

	public function mode()
	{
		if (!$this->usermodel->hasLoggedIn()) {
			redirect("admin/login");
		}

		if (isset($_POST['btnsubmit'])) {


			if (empty($fetch)) {

				$data = array(
					'name' => $_POST['exam_name'],
				);

				$last_id = $this->db_lib->insert('mode', $data, '');

				if ($last_id > 0) {
					setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
					redirect("communication/mode");
				} else {
					setFlash("ViewMsgWarning", "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
					redirect("communication/mode");
				}
			} else {
				setFlash("ViewMsgWarning", "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("communication/mode");
			}
		}


		$arry_data =  $this->db->select('*')->from('mode')->get()->result();
		$this->load->view($this->folder . "mode", array('result' => $arry_data));
	}

	public function delete_mode()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$delete = $this->db_lib->delete("mode", $where);
		if ($delete) {

			echo 1;
		}
	}

	public function get_mode()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("mode", $where, '*');

		echo json_encode($get);
	}


	public function edit_mode()
	{
		$id = $_POST['edit_id'];

		$where = "id = '$id'";
		$update_data = array(
			'name' => $_POST['exam_name'],
		);
		$rst = $this->db_lib->update('mode', $update_data, $where);

		if ($rst) {
			setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			redirect("communication/mode");
		}
	}

	public function responses()
	{
		if (!$this->usermodel->hasLoggedIn()) {
			redirect("admin/login");
		}

		if (isset($_POST['btnsubmit'])) {


			if (empty($fetch)) {

				$data = array(
					'campaign_id' => $_POST['campaign_id'],
					'name' => $_POST['exam_name'],
				);

				$last_id = $this->db_lib->insert('responses', $data, '');

				if ($last_id > 0) {
					setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
					redirect("communication/responses");
				} else {
					setFlash("ViewMsgWarning", "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
					redirect("communication/responses");
				}
			} else {
				setFlash("ViewMsgWarning", "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("communication/responses");
			}
		}

		$campaign = $this->db->select('*')->from('campaign')->get()->result();
		$arry_data =  $this->db->select('*')->from('responses')->get()->result();
		$this->load->view($this->folder . "responses", array('result' => $arry_data, 'campaign' => $campaign));
	}

	public function delete_responses()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$delete = $this->db_lib->delete("responses", $where);
		if ($delete) {

			echo 1;
		}
	}

	public function get_responses()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("responses", $where, '*');

		echo json_encode($get);
	}


	public function edit_responses()
	{
		$id = $_POST['edit_id'];

		$where = "id = '$id'";
		$update_data = array(
			'name' => $_POST['exam_name'],
			'campaign_id' => $_POST['campaign_id'],
		);
		$rst = $this->db_lib->update('responses', $update_data, $where);

		if ($rst) {
			setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			redirect("communication/responses");
		}
	}


	public function candidates()
	{

		if (!$this->usermodel->hasLoggedIn()) {
			redirect("admin/login");
		}
		$team = $this->db->select('*')->from('team')->get()->result();
		$campaign = $this->db->select('*')->from('campaign')->get()->result();
		$mode = $this->db->select('*')->from('mode')->get()->result();
		$responses = $this->db->select('*')->from('responses')->get()->result();
		$table = 'exam_master';
		$fields = "*";
		$whr = "";


		$exams = $this->db_lib->fetchRecords($table, $whr, $fields);
		$user = $this->db->select('*')->from('admin')->where('role', 'telecaller')->get()->result();
		$this->load->view($this->folder . "candidates", array(
			'team' => $team,
			'campaign' => $campaign,
			'mode' => $mode,
			'responses' => $responses,
			'user' => $user,
			'exams' => $exams,
		));
	}


	public function candidates_team()
	{

		if (!$this->usermodel->hasLoggedIn()) {
			redirect("admin/login");
		}

		$team = $this->db->select('*')->from('team')->get()->result();
		$campaign = $this->db->select('*')->from('campaign')->get()->result();
		$mode = $this->db->select('*')->from('mode')->get()->result();
		$responses = $this->db->select('*')->from('responses')->get()->result();

		$user = $this->db->select('*')->from('admin')->where('role', 'telecaller')->get()->result();

		$assignment = $this->db->select('*')
			->from('assignment')
			->join('campaign', 'campaign.id =assignment.campaign_id')
			->where('team_id', $this->session->userdata['admin_id'])
			->group_by('campaign_id')->get()->result();

		$tags = $this->db->select('*')->from('tags')->get()->result();

		$this->load->view($this->folder . "candidates_team", array(
			'team' => $team,
			'campaign' => $campaign,
			'mode' => $mode,
			'responses' => $responses,
			'user' => $user,
			'assignment' => $assignment,
			'tags' => $tags
		));
	}



	public function create_tag()
	{
		$tag = $this->input->post("tag-create");
		$id = $this->db_lib->insert('tags', array('name' => $tag), '');
		return $id;
	}

	public function get_tag()
	{
		$tags = $this->db->select('tag_id as id,name as text')->from('tags')->get()->result();

		echo json_encode($tags);
	}

	public function candidate_search()
	{



		$draw = intval($this->input->get("draw"));
		$start = intval(1);
		$length = intval(5);

		$whr = $this->input->post('data');

		$reg_status = $this->input->post('reg_status');

		if ($reg_status == 1) {

			$query = $this->db->query("SELECT um.*,ca.post_date FROM user_master um LEFT JOIN candidate_data ca on ca.mobile_verified_id = um.user_id $whr AND um.login_status = 1");
		} else {
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2");
		}




		$data = [];
		$n = 0;
		foreach ($query->result() as $r) {

			$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = " . $r->user_id . " AND duplicate = 0")->get()->row();

			$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = " . $r->user_id)->get()->row();

			$fullname = "";
			$corre_state = "";
			$corre_city = "";
			$email = "";
			$parma_city = "";
			$parma_state = "";
			$gender = "";
			$category = "";
			$dob = "";
			$university = "";
			$appr_center_1 = "";
			$gdpi_center_1 = "";
			$study_center1 = "";

			if ($candidate_data != "") {

				$parma_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->parma_state . "")->get()->row();
				$parma_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->parma_city . "")->get()->row();


				$corre_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->corre_state . "")->get()->row();
				$corre_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->corre_city . "")->get()->row();

				if ($r->course_id == 1) {
					$course = "BBA";
				}
				if ($r->course_id == 2) {
					$course = "MBA";
				}

				if ($r->course_id == 1) {
					$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				if ($r->course_id == 2) {
					$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;

				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name ?? '';

				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt = $candidate_data->academic_mark_obt;
				$academic_mark_max = $candidate_data->academic_mark_max;
				$academic_percentage = $candidate_data->academic_percentage;
				$obt = $academic_mark_obt . '/' . $academic_mark_max;
				$parma_address = $candidate_data->parma_appertment . " " . $candidate_data->parma_colony . " " . $candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment . " " . $candidate_data->corre_colony . " " . $candidate_data->corre_area;


				$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $r->user_id . "")->get()->row();

				$this->db->select('*');
				$this->db->from('candidate_exam CE');
				$this->db->join('exam_master em', 'em.id = CE.exam_id');
				$this->db->where('CE.user_id', $r->user_id);
				$exam = $this->db->get()->result();
				$examName = "<ul>";
				foreach ($exam as $key => $exams) {
					$examName .=  '<li>' . $exams->exam_name . '</li>';
				}
				$examName .= '</ul>';
			}


			$n++;
			if ($r->amount) {
				$amount = ($r->amount) / 100;
			} else {
				$amount = 0;
			}
			$tranid = $r->razorpay_trans_id;

			if ($r->login_status == 1) {
				$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";
			}

			if ($r->login_status == 2) {
				$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";
			}

			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$checked = "";
			if ($exam_status->id ?? 0 != '') {
				$checked = 'checked = checked; disabled';
			}

			if ($score_date) {
				$scoreA = "Name:" . $score_date->score_name ?? '';
				$scoreB = "<br/>Score: " . $score_date->score_marks ?? '';
				$scoreC = "<br/>Year: " .  $score_date->score_year ?? '';
			} else {
				$scoreA = "";
				$scoreB = "";
				$scoreC = "";
			}


			$data[] = array(
				//'<a data-id="'.$r->user_id.'" class="exam_status btn btn-danger btn-xs">Response</a>',
				'<input type="checkbox" value="' . $r->user_id . '" data-id="' . $r->user_id . '" class="exam_status checkbox" name="user_id[]"/>',
				'0000' . $r->user_id ?? '',
				//$examName,
				$course ?? '',
				$study_center1,
				$scoreA . $scoreB . $scoreC,
				$fullname,
				$r->user_mobile ?? '',
				$candidate_data->father_name ?? '',
				$candidate_data->mother_name ?? '',
				$dob,
				$email,
				$gender,
				$category,
				//$candidate_data->father_mobile??'',
				//$candidate_data->mather_mobile??'',
				$candidate_data->religion ?? '',
				$parma_state,
				$parma_city,
				date("d-M-Y", strtotime($r->created_date)),
				//date("d-M-Y", strtotime($candidate_data->post_date??''))
			);
		}

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"recordsFiltered" => $query->num_rows(),
			"data" => $data
		);


		echo json_encode($result);
		exit();
	}





	public function candidate_search_team()
	{



		$draw = intval($this->input->get("draw"));
		$start = intval(1);
		$length = intval(5);

		$campaign_id = $this->input->post('data');


		$query = $this->db->query("SELECT um.*,aa.created_at FROM assignment aa INNER JOIN user_master um ON um.user_id=aa.user_id WHERE aa.campaign_id = $campaign_id AND team_id = '" . $this->session->userdata['admin_id'] . "' AND um.login_status = 2");




		$data = [];
		$n = 0;
		foreach ($query->result() as $r) {

			$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = " . $r->user_id . " AND duplicate = 0")->get()->row();

			$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = " . $r->user_id)->get()->row();

			$fullname = "";
			$corre_state = "";
			$corre_city = "";
			$email = "";
			$parma_city = "";
			$parma_state = "";
			$gender = "";
			$category = "";
			$dob = "";
			$university = "";
			$appr_center_1 = "";
			$gdpi_center_1 = "";
			$study_center1 = "";

			if ($candidate_data != "") {

				$parma_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->parma_state . "")->get()->row();
				$parma_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->parma_city . "")->get()->row();


				$corre_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->corre_state . "")->get()->row();
				$corre_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->corre_city . "")->get()->row();

				if ($r->course_id == 1) {
					$course = "BBA";
				}
				if ($r->course_id == 2) {
					$course = "MBA";
				}

				if ($r->course_id == 1) {
					$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				if ($r->course_id == 2) {
					$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;

				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name ?? '';

				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt = $candidate_data->academic_mark_obt;
				$academic_mark_max = $candidate_data->academic_mark_max;
				$academic_percentage = $candidate_data->academic_percentage;
				$obt = $academic_mark_obt . '/' . $academic_mark_max;
				$parma_address = $candidate_data->parma_appertment . " " . $candidate_data->parma_colony . " " . $candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment . " " . $candidate_data->corre_colony . " " . $candidate_data->corre_area;


				$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $r->user_id . "")->get()->row();

				$this->db->select('*');
				$this->db->from('candidate_exam CE');
				$this->db->join('exam_master em', 'em.id = CE.exam_id');
				$this->db->where('CE.user_id', $r->user_id);
				$exam = $this->db->get()->result();
				$examName = "<ul>";
				foreach ($exam as $key => $exams) {
					$examName .=  '<li>' . $exams->exam_name . '</li>';
				}
				$examName .= '</ul>';
			}


			$n++;
			if ($r->amount) {
				$amount = ($r->amount) / 100;
			} else {
				$amount = 0;
			}
			$tranid = $r->razorpay_trans_id;

			if ($r->login_status == 1) {
				$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";
			}

			if ($r->login_status == 2) {
				$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";
			}

			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$checked = "";
			if ($exam_status->id ?? 0 != '') {
				$checked = 'checked = checked; disabled';
			}

			if ($score_date) {
				$scoreA = "Name:" . $score_date->score_name ?? '';
				$scoreB = "<br/>Score: " . $score_date->score_marks ?? '';
				$scoreC = "<br/>Year: " .  $score_date->score_year ?? '';
			} else {
				$scoreA = "";
				$scoreB = "";
				$scoreC = "";
			}


			$data[] = array(
				//'<a data-id="'.$r->user_id.'" class="exam_status btn btn-danger btn-xs">Response</a>',
				'<input type="checkbox" value="' . $r->user_id . '" data-id="' . $r->user_id . '" class="exam_status checkbox" name="user_id[]"/>',
				'0000' . $r->user_id ?? '',
				//$examName,
				$course,
				$study_center1,
				$scoreA . $scoreB . $scoreC,
				$fullname,
				$r->user_mobile ?? '',
				$candidate_data->father_name ?? '',
				$candidate_data->mother_name ?? '',
				$dob,
				$email,
				$gender,
				$category,
				//$candidate_data->father_mobile??'',
				//$candidate_data->mather_mobile??'',
				$candidate_data->religion ?? '',
				$parma_state,
				$parma_city,
				date("d-M-Y", strtotime($r->created_date)),
				//date("d-M-Y", strtotime($candidate_data->post_date??''))
			);
		}

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"recordsFiltered" => $query->num_rows(),
			"data" => $data
		);


		echo json_encode($result);
		exit();
	}


	public function calling_data_update()
	{

		
		$flag = 0; $check=array(); $msg="";
		
			$data = array(
				'call_date' => date('Y-m-d',strtotime($_POST['edit_call_date'])),
				'call_time' => $_POST['edit_call_time'],
				'mode' => $_POST['edit_mode_id'],
				'call_action' => $_POST['edit_call_action'],
				'response_id' => $_POST['edit_response_id'],
				'correct_email' => $_POST['edit_correct_email'],
				'correct_mobile' => $_POST['edit_correct_mobile'],
				'notes' => $_POST['edit_notes'],
				'tag'=> implode(',', $_POST['edit_tags'])
			);

		
			if(isset($_POST['edit_status'])?$_POST['edit_status']:"" == 1){
				
				$update = array('status' => 1);
				$where = "user_id = ".$_POST['edit_user_id']." AND assign_id = ".$_POST['edit_assign_id'];
				$update = $this->db_lib->update('assignment', $update, $where);
			} 

			$where_call = "id = ".$_POST['edit_calling_id'];
			$calling_update = $this->db_lib->update('calling_data', $data, $where_call);
			if($calling_update){
				$flag = 1; 
				$msg = "<span style='color:green;'>Response Has been Updated Successfully". "</span>";
			}

		
		if($flag==1){
			$array = array('status' => 1, 'msg' => $msg );
			echo json_encode($array);
		}else{
			$array = array('status' => 0, 'msg' => $msg );
			echo json_encode($array);
		}

		
	}


	public function calling_data_save()
	{


		$flag = 0;
		$check = array();
		$msg = "";

		$data = array(
			'user_id' => $_POST['user_id'],
			'team_id' => $this->session->userdata['admin_id'],
			'assign_id' => $_POST['assign_id'],
			'campaign_id' => $_POST['campaign_id_hidden'],
			'mode' => $_POST['mode_id'],
			'call_action' => $_POST['call_action'],
			'response_id' => $_POST['response_id'],
			'call_date' => date('Y-m-d', strtotime($_POST['call_date'])),
			'call_time' => $_POST['call_time'],
			'correct_email' => $_POST['correct_email'],
			'correct_mobile' => $_POST['correct_mobile'],
			'notes' => $_POST['notes'],
			'tag' => implode(',', $_POST['tags'])
		);


		if (isset($_POST['status']) ? $_POST['status'] : "" == 1) {

			$update = array('status' => 1);
			$where = "user_id = " . $_POST['user_id'] . " AND assign_id = " . $_POST['assign_id'];
			$update = $this->db_lib->update('assignment', $update, $where);
		}

		$last_id = $this->db_lib->insert('calling_data', $data, '');
		if ($last_id) {
			$flag = 1;
			$msg = "<span style='color:green;'>Response Has been Submited Successfully" . "</span>";
		}





		if ($flag == 1) {
			$array = array('status' => 1, 'msg' => $msg);
			echo json_encode($array);
		} else {
			$array = array('status' => 0, 'msg' => $msg);
			echo json_encode($array);
		}
	}

	public function assignment_save()
	{

		$assignment_master = array('assignment_name' => $_POST['assignment_name'], 'assignment_start' => $_POST['start_date'], 'assignment_end' => $_POST['end_date'], 'created_by' => $this->session->userdata['admin_id']);

		$assignment_id = $this->db_lib->insert('assignment_master', $assignment_master, '');

		//print_r($assignment_master); die;

		if ($assignment_id) {
			$flag = 0;
			foreach ($_POST['user_id'] as $key => $value) {

				$data = array(
					'campaign_id' => $_POST['assign_campaign'],
					'team_id' => $_POST['assign_team'],
					'assignment_id' => $assignment_id,
					'user_id' => $value,
				);

				$last_id = $this->db_lib->insert('assignment', $data, '');
				$flag++;
			}
		}


		if ($flag > 0) {
			$this->session->set_flashdata('msg', "Assignment has been Created!");
			redirect("communication/assignment_report");
		}
	}



	public function assignment_report()
	{
		$role = $this->session->userdata['role'];
		if ($role == 'admin') {
			$assignment = $this->db->select('am.*, am.id as id, c.name as cname, c.id as cid, a.admin_name as team')
				->from('assignment_master am')
				->join('assignment aa', 'aa.assignment_id = am.id')
				->join('campaign c', 'c.id = aa.campaign_id')
				->join('admin a', 'a.admin_id = aa.team_id')
				->group_by('aa.assignment_id')
				->order_by('aa.created_at', 'DESC')
				->get()->result();
		} else {
			$assignment = $this->db->select('am.*, am.id as id, c.name as cname, c.id as cid, a.admin_name as team')
				->from('assignment_master am')
				->join('assignment aa', 'aa.assignment_id = am.id')
				->join('campaign c', 'c.id = aa.campaign_id')
				->join('admin a', 'a.admin_id = aa.team_id')
				->where('aa.team_id', $this->session->userdata['admin_id'])
				->group_by('aa.assignment_id')
				->order_by('aa.created_at', 'DESC')
				->get()->result();
		}
		$team = $this->db->select('*')->from('team')->get()->result();
		$campaign = $this->db->select('*')->from('campaign')->get()->result();
		$mode = $this->db->select('*')->from('mode')->get()->result();
		$responses = $this->db->select('*')->from('responses')->get()->result();
		$tags = $this->db->select('*')->from('tags')->get()->result();
		$user = $this->db->select('*')->from('admin')->where('role', 'telecaller')->get()->result();
		$this->load->view($this->folder . "assignment_report", array(
			'assignment' => $assignment,
			'team' => $team,
			'campaign' => $campaign,
			'mode' => $mode,
			'responses' => $responses,
			'user' => $user,
			'tags' => $tags
		));
	}

	public function assignment_details($id)
	{
		$role = $this->session->userdata['role'];

		if ($role == 'admin') {
			$assignment = $this->db->select('am.*, am.id as id, c.name as cname, c.id as cid, a.admin_name as team')
				->from('assignment_master am')
				->join('assignment aa', 'aa.assignment_id = am.id')
				->join('campaign c', 'c.id = aa.campaign_id')
				->join('admin a', 'a.admin_id = aa.team_id')
				->where('am.id', $id)
				->group_by('aa.assignment_id')
				->order_by('aa.created_at', 'DESC')
				->get()->result();
		} else {
			$assignment = $this->db->select('am.*, am.id as id, c.name as cname, c.id as cid, a.admin_name as team')
				->from('assignment_master am')
				->join('assignment aa', 'aa.assignment_id = am.id')
				->join('campaign c', 'c.id = aa.campaign_id')
				->join('admin a', 'a.admin_id = aa.team_id')
				->where('am.id', $id)
				->where('aa.team_id', $this->session->userdata['admin_id'])
				->group_by('aa.assignment_id')
				->order_by('aa.created_at', 'DESC')
				->get()->result();
		}

		// Your requested line - fetch assignment_master data as array (for details)
		$details = $this->db->where('id', $id)->get('assignment_master')->result_array();

		$team = $this->db->select('*')->from('team')->get()->result();
		$campaign = $this->db->select('*')->from('campaign')->get()->result();
		$mode = $this->db->select('*')->from('mode')->get()->result();
		$responses = $this->db->select('*')->from('responses')->get()->result();
		$tags = $this->db->select('*')->from('tags')->get()->result();
		$user = $this->db->select('*')->from('admin')->where('role', 'telecaller')->get()->result();

		$this->load->view($this->folder . "assignment_details", array(
			'assignment' => $assignment,
			'details' => $details,   // pass details to view
			'team' => $team,
			'campaign' => $campaign,
			'mode' => $mode,
			'responses' => $responses,
			'tags' => $tags,
			'user' => $user,
			'tags' => $tags
		));
	}

	public function assignment_candidates()
	{

		$draw = intval($this->input->get("draw"));
		$start = $this->input->get("start");
		$length = $this->input->get("length");
		$id = $this->input->post('id');


		$query = $this->db->query("SELECT um.*,aa.created_at,aa.assign_id,aa.campaign_id FROM assignment aa INNER JOIN assignment_master am ON am.id = aa.assignment_id INNER JOIN user_master um ON um.user_id=aa.user_id WHERE am.id = $id");






		$data = [];
		$n = 0;
		$comp = 0;
		foreach ($query->result() as $r) {

			$campaign_id = $r->campaign_id;
			$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = " . $r->user_id . " AND duplicate = 0")->get()->row();

			$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = " . $r->user_id)->get()->row();

			$fullname = "";
			$corre_state = "";
			$corre_city = "";
			$email = "";
			$parma_city = "";
			$parma_state = "";
			$gender = "";
			$category = "";
			$dob = "";
			$university = "";
			$appr_center_1 = "";
			$gdpi_center_1 = "";
			$study_center1 = "";

			if ($candidate_data != "") {

				$parma_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->parma_state . "")->get()->row();
				$parma_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->parma_city . "")->get()->row();


				$corre_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->corre_state . "")->get()->row();
				$corre_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->corre_city . "")->get()->row();

				if ($r->course_id == 1) {
					$course = "BBA";
				}
				if ($r->course_id == 2) {
					$course = "MBA";
				}

				if ($r->course_id == 1) {
					$fullname = "<a href='../journey/show_journey/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				if ($r->course_id == 2) {
					$fullname = "<a href='../journey/show_journey/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;

				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = isset($corre_city_data->name) ? $corre_city_data->name : '';

				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt = $candidate_data->academic_mark_obt;
				$academic_mark_max = $candidate_data->academic_mark_max;
				$academic_percentage = $candidate_data->academic_percentage;
				$obt = $academic_mark_obt . '/' . $academic_mark_max;
				$parma_address = $candidate_data->parma_appertment . " " . $candidate_data->parma_colony . " " . $candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment . " " . $candidate_data->corre_colony . " " . $candidate_data->corre_area;


				$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $r->user_id . "")->get()->row();

				$this->db->select('*');
				$this->db->from('candidate_exam CE');
				$this->db->join('exam_master em', 'em.id = CE.exam_id');
				$this->db->where('CE.user_id', $r->user_id);
				$exam = $this->db->get()->result();
				$examName = "<ul>";
				foreach ($exam as $key => $exams) {
					$examName .=  '<li>' . $exams->exam_name . '</li>';
				}
				$examName .= '</ul>';
			}


			$n++;
			if ($r->amount) {
				$amount = ($r->amount) / 100;
			} else {
				$amount = 0;
			}
			$tranid = $r->razorpay_trans_id;

			if ($r->login_status == 1) {
				$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";
			}

			if ($r->login_status == 2) {
				$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";
			}

			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$checked = "";
			if ($exam_status->id ?? 0 != '') {
				$checked = 'checked = "checked"; disabled';
			}

			if ($score_date) {
				$scoreA = "Name:" . $score_date->score_name ?? '';
				$scoreB = "<br/>Score: " . $score_date->score_marks ?? '';
				$scoreC = "<br/>Year: " .  $score_date->score_year ?? '';
			} else {
				$scoreA = "";
				$scoreB = "";
				$scoreC = "";
			}

			if ($this->session->userdata['role'] == 'telecaller') {
				$calling_check = $this->db->select("*")->from("calling_data")->where("assign_id = " . $r->assign_id . "")->get()->row();
				if ($calling_check) {
					$firstCol = "<b>Done</b>";
					$comp++;
				} else {
					$firstCol = '<input type="checkbox" value="' . $r->user_id . '" assign-id="' . $r->assign_id . '" data-id="' . $r->user_id . '" class="exam_status checkbox" name="user_id[]"/>';
				}
			} elseif ($this->session->userdata['role'] == 'admin') {
				$firstCol = "<input type='checkbox' class='row-checkbox' name='select_user[]' value='$r->user_id'>";
			} else {
				$calling_check = $this->db->select("*")->from("calling_data")->where("assign_id = " . $r->assign_id . "")->get()->row();
				if ($calling_check) {
					$firstCol = "";
					$comp++;
				} else {
					$firstCol = '';
				}
			}

			

			if (isset($candidate_data->father_name)) {
				$fname = $candidate_data->father_name;
			} else {
				$fname = "";
			}
			if (isset($candidate_data->mother_name)) {
				$mname = $candidate_data->mother_name;
			} else {
				$mname = "";
			}

			$candidate_information = '<b>Enroll No.: </b> 0000' . $r->user_id . '<br/><b>Full Name: </b>' . $fullname . '<br/><b>Mobile :</b> ' . $r->user_mobile . '<br/><b>Father Name: </b>' . $fname . '<br/><b>Mother Name: </b>' . $mname . '<br/><b>DOB: </b>' . $dob . '<br/><b>Email: </b>' . $email . '<br/><b>Gender: </b>' . $gender;

			$academic_information = '<b>Course: </b>' . $course . '<br/><b>Study Center: </b>' . $study_center1 . '<br/><b>Category: </b>' . $category . '<br/><b>State: </b>' . $parma_state . '<br/><b>City: </b>' . $parma_city . '<br/><b>Enroll DateTime: </b>' . date("d-M-Y", strtotime($r->created_date));


			$communication = $this->db->query("SELECT cd.*,admin.admin_name as tname,mode.name as mname, campaign.name as cname,responses.name as rname from calling_data cd inner join admin on admin.admin_id = cd.team_id inner join mode on mode.id = cd.mode inner join campaign on campaign.id = cd.campaign_id inner join responses on responses.id = cd.response_id where cd.user_id='" . $r->user_id . "' and cd.assign_id='" . $r->assign_id . "'  order by call_date asc")->result_array();


			$communicate = "";
			foreach ($communication as $key => $comm) {
				$tags = "";
				if ($comm['tag'] != '') {
					$tag_array = explode(',', $comm['tag']);
					foreach ($tag_array as $key => $tag) {
						$tag_query = $this->db->query("select * from tags where tag_id = $tag")->row();
						$tags .= "<span class='badge badge-primary'>" . $tag_query->name . "</span> &nbsp;";
					}
				}

				$communicate = '<div class="tracking-item"><div class="tracking-date"><b>DateTime: </b>' . date('M d, Y', strtotime($comm['call_date'])) . '<span> ' . date('h:i A', strtotime($comm['call_time'])) . '</span> <a class="btn btn-xs btn-danger exam_status_edit" data-id="' . $comm['id'] . '"><i class="fa fa-pencil"></i></a></div>
                    <div class="tracking-content">
                    <b>Campaign: </b><span style="color:red; font-size:18px; padding-bottom:10px;">' . $comm['cname'] . '</span><br/>
                    <b>Calling Team: </b>' . $comm['tname'] . '<br/>
                    <b>Communication Mode: </b>' . $comm['mname'] . '<br/>
                    <b>Call Action: </b>' . $comm['call_action'] . '<br/>
                    <b>Call Response: </b>' . $comm['rname'] . '<br/>
                    <b>Remark: </b>' . $comm['notes'] . '<br/>
                    <b>Tags: </b>' . $tags . '
                    </div>
                    </div>';
			}

			$data[] = array(
				// $n . $firstCol,
				$firstCol,
				$candidate_information,
				$academic_information,
				$communicate,

			);
		}

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"recordsFiltered" => $query->num_rows(),
			"recordsComplete" => $comp,
			"campaign_id" => $campaign_id,
			"data" => $data,
		);


		echo json_encode($result);
	}


	public function candidate_assignment_save()
	{

		$assignment_master = array('assignment_name' => $_POST['assignment_name'], 'assignment_start' => $_POST['start_date'], 'assignment_end' => $_POST['end_date'], 'created_by' => $this->session->userdata['admin_id']);

		$assignment_id = $this->db_lib->insert('assignment_master', $assignment_master, '');

		//print_r($assignment_master); die;

		if ($assignment_id) {
			$flag = 0;
			foreach ($_POST['user_id'] as $key => $value) {

				$data = array(
					'campaign_id' => $_POST['assign_campaign'],
					'team_id' => $_POST['assign_team'],
					'assignment_id' => $assignment_id,
					'user_id' => $value,
				);

				$last_id = $this->db_lib->insert('assignment', $data, '');
				$flag++;
			}
		}


		if ($flag > 0) {
			$this->session->set_flashdata('msg', "Assignment has been Created!");
			redirect("communication/assignment_report");
		}
	}


	public function assignment_candidates_filter()
	{

		$draw = intval($this->input->get("draw"));
		$start = $this->input->get("start");
		$length = $this->input->get("length");
		$whr = $this->input->post('data');


		$query = $this->db->query("SELECT um.*,aa.created_at,aa.assign_id,aa.campaign_id, cd.tag, cd.response_id FROM assignment aa INNER JOIN assignment_master am ON am.id = aa.assignment_id INNER JOIN user_master um ON um.user_id=aa.user_id LEFT JOIN calling_data cd ON cd.user_id = aa.user_id AND cd.assign_id = aa.assign_id $whr");






		$data = [];
		$n = 0;
		$comp = 0;
		$course = "";
		foreach ($query->result() as $r) {

			$campaign_id = $r->campaign_id;
			$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = " . $r->user_id . " AND duplicate = 0")->get()->row();

			$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = " . $r->user_id)->get()->row();

			$fullname = "";
			$corre_state = "";
			$corre_city = "";
			$email = "";
			$parma_city = "";
			$parma_state = "";
			$gender = "";
			$category = "";
			$dob = "";
			$university = "";
			$appr_center_1 = "";
			$gdpi_center_1 = "";
			$study_center1 = "";

			if ($candidate_data != "") {

				$parma_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->parma_state . "")->get()->row();
				$parma_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->parma_city . "")->get()->row();


				$corre_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->corre_state . "")->get()->row();
				$corre_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->corre_city . "")->get()->row();

				if ($r->course_id == 1) {
					$course = "BBA";
				}
				if ($r->course_id == 2) {
					$course = "MBA";
				}

				if ($r->course_id == 1) {
					$fullname = "<a href='../journey/show_journey/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				if ($r->course_id == 2) {
					$fullname = "<a href='../journey/show_journey/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;

				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = isset($corre_city_data->name) ? $corre_city_data->name : '';

				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt = $candidate_data->academic_mark_obt;
				$academic_mark_max = $candidate_data->academic_mark_max;
				$academic_percentage = $candidate_data->academic_percentage;
				$obt = $academic_mark_obt . '/' . $academic_mark_max;
				$parma_address = $candidate_data->parma_appertment . " " . $candidate_data->parma_colony . " " . $candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment . " " . $candidate_data->corre_colony . " " . $candidate_data->corre_area;


				$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $r->user_id . "")->get()->row();

				$this->db->select('*');
				$this->db->from('candidate_exam CE');
				$this->db->join('exam_master em', 'em.id = CE.exam_id');
				$this->db->where('CE.user_id', $r->user_id);
				$exam = $this->db->get()->result();
				$examName = "<ul>";
				foreach ($exam as $key => $exams) {
					$examName .=  '<li>' . $exams->exam_name . '</li>';
				}
				$examName .= '</ul>';
			}


			$n++;
			if ($r->amount) {
				$amount = ($r->amount) / 100;
			} else {
				$amount = 0;
			}
			$tranid = $r->razorpay_trans_id;

			if ($r->login_status == 1) {
				$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";
			}

			if ($r->login_status == 2) {
				$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";
			}

			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$checked = "";
			if ($exam_status->id ?? 0 != '') {
				$checked = 'checked = "checked"; disabled';
			}

			if ($score_date) {
				$scoreA = "Name:" . $score_date->score_name ?? '';
				$scoreB = "<br/>Score: " . $score_date->score_marks ?? '';
				$scoreC = "<br/>Year: " .  $score_date->score_year ?? '';
			} else {
				$scoreA = "";
				$scoreB = "";
				$scoreC = "";
			}

			if ($this->session->userdata['role'] == 'telecaller') {
				$calling_check = $this->db->select("*")->from("calling_data")->where("assign_id = " . $r->assign_id . "")->get()->row();
				if ($calling_check) {
					$firstCol = "<b>Done</b>";
					$comp++;
				} else {
					$firstCol = '<input type="checkbox" value="' . $r->user_id . '" assign-id="' . $r->assign_id . '" data-id="' . $r->user_id . '" class="exam_status checkbox" name="user_id[]"/>';
				}
			} elseif ($this->session->userdata['role'] == 'admin') {
				$firstCol = "<input type='checkbox' class='row-checkbox' name='select_user[]' value='$r->user_id'>";
			} else {
				$calling_check = $this->db->select("*")->from("calling_data")->where("assign_id = " . $r->assign_id . "")->get()->row();
				if ($calling_check) {
					$firstCol = "";
					$comp++;
				} else {
					$firstCol = '';
				}
			}

			if (isset($candidate_data->father_name)) {
				$fname = $candidate_data->father_name;
			} else {
				$fname = "";
			}
			if (isset($candidate_data->mother_name)) {
				$mname = $candidate_data->mother_name;
			} else {
				$mname = "";
			}

			$candidate_information = '<b>Enroll No.: </b> 0000' . $r->user_id . '<br/><b>Full Name: </b>' . $fullname . '<br/><b>Mobile :</b> ' . $r->user_mobile . '<br/><b>Father Name: </b>' . $fname . '<br/><b>Mother Name: </b>' . $mname . '<br/><b>DOB: </b>' . $dob . '<br/><b>Email: </b>' . $email . '<br/><b>Gender: </b>' . $gender;

			$academic_information = '<b>Course: </b>' . $course . '<br/><b>Study Center: </b>' . $study_center1 . '<br/><b>Category: </b>' . $category . '<br/><b>State: </b>' . $parma_state . '<br/><b>City: </b>' . $parma_city . '<br/><b>Enroll DateTime: </b>' . date("d-M-Y", strtotime($r->created_date));


			$communication = $this->db->query("SELECT cd.*,admin.admin_name as tname,mode.name as mname, campaign.name as cname,responses.name as rname from calling_data cd inner join admin on admin.admin_id = cd.team_id inner join mode on mode.id = cd.mode inner join campaign on campaign.id = cd.campaign_id inner join responses on responses.id = cd.response_id where cd.user_id='" . $r->user_id . "' and cd.assign_id='" . $r->assign_id . "'  order by call_date asc")->result_array();


			$communicate = "";
			foreach ($communication as $key => $comm) {
				$tags = "";
				if ($comm['tag'] != '') {
					$tag_array = explode(',', $comm['tag']);
					foreach ($tag_array as $key => $tag) {
						$tag_query = $this->db->query("select * from tags where tag_id = $tag")->row();
						$tags .= "<span class='badge badge-primary'>" . $tag_query->name . "</span> &nbsp;";
					}
				}

				$communicate = '<div class="tracking-item"><div class="tracking-date"><b>DateTime: </b>' . date('M d, Y', strtotime($comm['call_date'])) . '<span> ' . date('h:i A', strtotime($comm['call_time'])) . '</span> <a class="btn btn-xs btn-danger exam_status_edit" data-id="' . $comm['id'] . '"><i class="fa fa-pencil"></i></a></div>
                    <div class="tracking-content">
                    <b>Campaign: </b><span style="color:red; font-size:18px; padding-bottom:10px;">' . $comm['cname'] . '</span><br/>
                    <b>Calling Team: </b>' . $comm['tname'] . '<br/>
                    <b>Communication Mode: </b>' . $comm['mname'] . '<br/>
                    <b>Call Action: </b>' . $comm['call_action'] . '<br/>
                    <b>Call Response: </b>' . $comm['rname'] . '<br/>
                    <b>Remark: </b>' . $comm['notes'] . '<br/>
                    <b>Tags: </b>' . $tags . '
                    </div>
                    </div>';
			}

			$data[] = array(
				// $n . $firstCol,
				$firstCol,
				$candidate_information,
				$academic_information,
				$communicate,

			);
		}

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"recordsFiltered" => $query->num_rows(),
			"recordsComplete" => $comp,
			// "campaign_id" => $campaign_id,
			"data" => $data,
		);


		echo json_encode($result);
	}















	public function create_exam()
	{
		if (!$this->usermodel->hasLoggedIn()) {
			redirect("admin/login");
		}




		if (isset($_POST['btnsubmit'])) {

			$fetch =  $this->db->select('*')->from('admin')->where('admin_name', $_POST['admin_name'])->get()->row();


			if (empty($fetch)) {

				$data = array(
					'exam_name' => $_POST['exam_name'],
					'exam_question' => $_POST['exam_question'],
					'start_datetime' => $_POST['start_datetime'],
					'end_datetime' => $_POST['end_datetime'],
					'no_of_candidate' => $_POST['no_of_candidate'],
				);

				$last_id = $this->db_lib->insert('exam_master', $data, '');

				if ($last_id > 0) {
					setFlash("ViewMsgSuccess", "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
					redirect("exam/create_exam");
				} else {
					setFlash("ViewMsgWarning", "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
					redirect("exam/create_exam");
				}
			} else {
				setFlash("ViewMsgWarning", "<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("exam/create_exam");
			}
		}


		$arry_data =  $this->db->select('*')->from('exam_master')->get()->result();
		$this->load->view($this->folder . "create_exam", array('result' => $arry_data));
	}


	public function candidate_link_exam()
	{

		if (!$this->usermodel->hasLoggedIn()) {
			redirect("admin/login");
		}


		$table = 'exam_master';
		$fields = "*";
		$whr = "";


		$result = $this->db_lib->fetchRecords($table, $whr, $fields);
		$this->load->view($this->folder . "candidate_link_exam", array('result' => $result));
	}


	public function candidate_details()
	{

		if (!$this->usermodel->hasLoggedIn()) {
			redirect("admin/login");
		}

		$table = 'exam_master';
		$fields = "*";
		$whr = "";


		$result = $this->db_lib->fetchRecords($table, $whr, $fields);
		$this->load->view($this->folder . "candidate_details", array('result' => $result));
	}





	public function filter_exam_link_page()
	{



		$draw = intval($this->input->get("draw"));
		$start = intval(1);
		$length = intval(5);

		$whr = $this->input->post('data');
		$missed =  $this->input->post('missed');



		if ($missed == 1) {

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id NOT IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status !='fail' )");
		} elseif ($missed == 2) {

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status='pass' )");
		} elseif ($missed == 3) {

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status='fail' )");
		} else {

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2");
		}

		$data = [];
		$n = 0;
		foreach ($query->result() as $r) {

			$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = " . $r->user_id . " AND duplicate = 0")->get()->row();

			$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = " . $r->user_id)->get()->row();

			$fullname = "";
			$corre_state = "";
			$corre_city = "";
			$email = "";
			$parma_city = "";
			$parma_state = "";
			$gender = "";
			$category = "";
			$dob = "";
			$university = "";
			$appr_center_1 = "";
			$gdpi_center_1 = "";
			$study_center1 = "";

			if ($candidate_data != "") {

				$parma_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->parma_state . "")->get()->row();
				$parma_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->parma_city . "")->get()->row();


				$corre_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->corre_state . "")->get()->row();
				$corre_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->corre_city . "")->get()->row();

				if ($r->course_id == 1) {
					$course = "BBA";
				}
				if ($r->course_id == 2) {
					$course = "MBA";
				}

				if ($r->course_id == 1) {
					$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				if ($r->course_id == 2) {
					$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;

				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name ?? '';

				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt = $candidate_data->academic_mark_obt;
				$academic_mark_max = $candidate_data->academic_mark_max;
				$academic_percentage = $candidate_data->academic_percentage;
				$obt = $academic_mark_obt . '/' . $academic_mark_max;
				$parma_address = $candidate_data->parma_appertment . " " . $candidate_data->parma_colony . " " . $candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment . " " . $candidate_data->corre_colony . " " . $candidate_data->corre_area;


				$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $r->user_id . "")->get()->row();

				$this->db->select('*');
				$this->db->from('candidate_exam CE');
				$this->db->join('exam_master em', 'em.id = CE.exam_id');
				$this->db->where('CE.user_id', $r->user_id);
				$exam = $this->db->get()->result();
				$examName = "<ul>";
				foreach ($exam as $key => $exams) {
					$examName .=  '<li>' . $exams->exam_name . '</li>';
				}
				$examName .= '</ul>';
			}


			$n++;
			$amount = ($r->amount) / 100;
			$tranid = $r->razorpay_trans_id;

			if ($r->login_status == 1) {
				$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";
			}

			if ($r->login_status == 2) {
				$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";
			}

			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$checked = "";
			if ($exam_status->id ?? 0 != '') {
				$checked = 'checked = checked; disabled';
			}

			if ($score_date) {
				$scoreA = "Name:" . $score_date->score_name ?? '';
				$scoreB = "<br/>Score: " . $score_date->score_marks ?? '';
				$scoreC = "<br/>Year: " .  $score_date->score_year ?? '';
			} else {
				$scoreA = "";
				$scoreB = "";
				$scoreC = "";
			}


			$data[] = array(
				' <a data-id="' . $r->user_id . '" class="exam_status btn btn-primary btn-xs">Link to Exam</a>',
				'0000' . $r->user_id ?? '',
				$examName,
				$course,
				$study_center1,
				$scoreA . $scoreB . $scoreC,
				$fullname,
				$r->user_mobile ?? '',
				$candidate_data->father_name ?? '',
				$candidate_data->mother_name ?? '',
				$dob,
				$email,
				$gender,
				$category,
				$candidate_data->father_mobile ?? '',
				$candidate_data->mather_mobile ?? '',
				$candidate_data->religion ?? '',
				$parma_state,
				$parma_city,
				date("d-M-Y", strtotime($r->created_date)),
				date("d-M-Y", strtotime($candidate_data->post_date ?? ''))
			);
		}

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"recordsFiltered" => $query->num_rows(),
			"data" => $data
		);


		echo json_encode($result);
		exit();
	}


	public function filter_exam_search()
	{


		$draw = intval($this->input->get("draw"));
		$start = intval(1);
		$length = intval(5);
		$whr = $this->input->post('data');

		$query = $this->db->query("SELECT um.*,ca.post_date,ce.exam_id,ce.id as linkid,cr.* FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id INNER JOIN candidate_exam ce ON ce.user_id = um.user_id LEFT JOIN candidate_result cr ON cr.link_id=ce.id $whr AND ca.duplicate = 0 AND um.login_status = 2");

		$data = [];
		$n = 0;
		foreach ($query->result() as $r) {

			$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = " . $r->user_id . " AND duplicate = 0")->get()->row();

			$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = " . $r->user_id)->get()->row();

			$fullname = "";
			$corre_state = "";
			$corre_city = "";
			$email = "";
			$parma_city = "";
			$parma_state = "";
			$gender = "";
			$category = "";
			$dob = "";
			$university = "";
			$appr_center_1 = "";
			$gdpi_center_1 = "";
			$study_center1 = "";

			if ($candidate_data != "") {

				$parma_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->parma_state . "")->get()->row();
				$parma_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->parma_city . "")->get()->row();


				$corre_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->corre_state . "")->get()->row();
				$corre_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->corre_city . "")->get()->row();

				if ($r->course_id == 1) {
					$course = "BBA";
				}
				if ($r->course_id == 2) {
					$course = "MBA";
				}

				if ($r->course_id == 1) {
					$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				if ($r->course_id == 2) {
					$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;

				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name ?? '';

				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt = $candidate_data->academic_mark_obt;
				$academic_mark_max = $candidate_data->academic_mark_max;
				$academic_percentage = $candidate_data->academic_percentage;
				$obt = $academic_mark_obt . '/' . $academic_mark_max;
				$parma_address = $candidate_data->parma_appertment . " " . $candidate_data->parma_colony . " " . $candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment . " " . $candidate_data->corre_colony . " " . $candidate_data->corre_area;


				$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $r->user_id . "")->get()->row();
			}


			$n++;
			$amount = ($r->amount) / 100;
			$tranid = $r->razorpay_trans_id;

			if ($r->login_status == 1) {
				$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";
			}

			if ($r->login_status == 2) {
				$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";
			}

			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$checked = "";
			if ($exam_status->id ?? 0 != '') {
				$checked = 'checked = checked; disabled';
			}

			if ($score_date) {
				$scoreA = "Name:" . $score_date->score_name ?? '';
				$scoreB = "<br/>Score: " . $score_date->score_marks ?? '';
				$scoreC = "<br/>Year: " .  $score_date->score_year ?? '';
			} else {
				$scoreA = "";
				$scoreB = "";
				$scoreC = "";
			}

			$exam = $this->db->select("*")->from("exam_master")->where("id = " . $r->exam_id . "")->get()->row();

			$this->db->select('*');
			$this->db->from('candidate_exam CE');
			$this->db->join('candidate_result CR', 'CE.id = CR.link_id');
			$this->db->where('CR.link_id', $r->linkid);
			$this->db->where('CE.user_id', $r->user_id);
			$link = $this->db->get()->row();

			if ($link) {

				if ($link->attendance == 'present') {
					$pesent = "checked = checked";
				} else {
					$pesent = "";
				}
				if ($link->attendance == 'absent') {
					$absent = "checked = checked";
				} else {
					$absent = "";
				}
				if ($link->attendance == 'late') {
					$late = "checked = checked";
				} else {
					$late = "";
				}
				if ($link->attendance == 'notfill') {
					$notfill = "checked = checked";
				} else {
					$notfill = "";
				}

				if ($link->exam_status == 'pass') {
					$pass = "checked = checked";
				} else {
					$pass = "";
				}
				if ($link->exam_status == 'fail') {
					$fail = "checked = checked";
				} else {
					$fail = "";
				}
			} else {
				$pesent = "";
				$absent = "";
				$pass = "";
				$fail = "";
				$notfill = "";
				$late = "";
			}

			$data[] = array(
				$exam->exam_name,
				'0000' . $r->user_id . '<br/><b>' . $course . '</b>',
				$study_center1,
				$scoreA . $scoreB . $scoreC,
				$fullname,
				$r->user_mobile ?? '',
				$candidate_data->father_name ?? '',
				'<input type="radio" class="status" name="sts' . $r->linkid . '" data-id="' . $r->linkid . '" data-text="present" ' . $pesent . ' /> Present &nbsp;&nbsp;<input type="radio" name="sts' . $r->linkid . '" data-id="' . $r->linkid . '" class="status" data-text="absent" ' . $absent . ' /> Absent &nbsp;&nbsp;<input type="radio" name="sts' . $r->linkid . '" data-id="' . $r->linkid . '" class="status" data-text="late" ' . $late . ' /> Late Fill &nbsp;&nbsp;<input type="radio" name="sts' . $r->linkid . '" data-id="' . $r->linkid . '" class="status" data-text="notfill" ' . $notfill . ' /> Not Fill',
				'<input type="radio" class="result" name="' . $r->linkid . '" data-id="' . $r->linkid . '" data-text="pass" ' . $pass . '/> Pass &nbsp;&nbsp;<input type="radio" name="' . $r->linkid . '" class="result" data-id="' . $r->linkid . '" data-text="fail" ' . $fail . '/> Fail',
				// '<input type="text" style="width:80px;" class="marks" data-id="'.$r->linkid.'" />',
				// '<input type="text" style="width:80px;" />'
			);
		}

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"recordsFiltered" => $query->num_rows(),
			"data" => $data
		);


		echo json_encode($result);
		exit();
	}






	public function exam_attendance()
	{
		$link_id = $this->input->post('id');
		$txt = $this->input->post('txt');

		$data = $this->db->select("*")
			->from("candidate_result")
			->where("link_id = " . $link_id . "")
			->get()->result();


		$insert = array(

			'link_id' => $link_id,
			'attendance' => $txt,
		);

		if (empty($data)) {

			$last_id = $this->db_lib->insert('candidate_result', $insert, '');
			$array = array('status' => 1, 'msg' => 'Insert');
		} else {

			$where = "link_id = '$link_id'";
			$update_id = $this->db_lib->update('candidate_result', $insert, $where);
			$array = array('status' => 1, 'msg' => 'Update');
		}




		echo json_encode($array);
	}



	public function exam_result()
	{
		$link_id = $this->input->post('id');
		$txt = $this->input->post('txt');

		$data = $this->db->select("*")
			->from("candidate_result")
			->where("link_id = " . $link_id . "")
			->get()->result();


		$insert = array(

			'link_id' => $link_id,
			'exam_status' => $txt,
		);

		if (empty($data)) {

			$last_id = $this->db_lib->insert('candidate_result', $insert, '');
			$array = array('status' => 1, 'msg' => 'Insert');
		} else {

			$where = "link_id = '$link_id'";
			$update_id = $this->db_lib->update('candidate_result', $insert, $where);
			$array = array('status' => 1, 'msg' => 'Update');
		}




		echo json_encode($array);
	}



	public function filter_exam()
	{



		$draw = intval($this->input->get("draw"));
		$start = intval(1);
		$length = intval(5);

		$whr = $this->input->post('data');
		$missed =  $this->input->post('missed');



		if ($missed == 1) {

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id NOT IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status !='fail' )");
		} elseif ($missed == 2) {

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status='pass' )");
		} elseif ($missed == 3) {

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status='fail' )");
		} else {

			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2");
		}

		$data = [];
		$n = 0;
		foreach ($query->result() as $r) {

			$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = " . $r->user_id . " AND duplicate = 0")->get()->row();

			$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = " . $r->user_id)->get()->row();

			$fullname = "";
			$corre_state = "";
			$corre_city = "";
			$email = "";
			$parma_city = "";
			$parma_state = "";
			$gender = "";
			$category = "";
			$dob = "";
			$university = "";
			$appr_center_1 = "";
			$gdpi_center_1 = "";
			$study_center1 = "";

			if ($candidate_data != "") {

				$parma_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->parma_state . "")->get()->row();
				$parma_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->parma_city . "")->get()->row();


				$corre_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->corre_state . "")->get()->row();
				$corre_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->corre_city . "")->get()->row();

				if ($r->course_id == 1) {
					$course = "BBA";
				}
				if ($r->course_id == 2) {
					$course = "MBA";
				}

				if ($r->course_id == 1) {
					$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				if ($r->course_id == 2) {
					$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;

				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name ?? '';

				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt = $candidate_data->academic_mark_obt;
				$academic_mark_max = $candidate_data->academic_mark_max;
				$academic_percentage = $candidate_data->academic_percentage;
				$obt = $academic_mark_obt . '/' . $academic_mark_max;
				$parma_address = $candidate_data->parma_appertment . " " . $candidate_data->parma_colony . " " . $candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment . " " . $candidate_data->corre_colony . " " . $candidate_data->corre_area;


				$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $r->user_id . "")->get()->row();
			}


			$n++;
			$amount = ($r->amount) / 100;
			$tranid = $r->razorpay_trans_id;

			if ($r->login_status == 1) {
				$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";
			}

			if ($r->login_status == 2) {
				$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";
			}

			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$checked = "";
			if ($exam_status->id ?? 0 != '') {
				$checked = 'checked = checked; disabled';
			}

			if ($score_date) {
				$scoreA = "Name:" . $score_date->score_name ?? '';
				$scoreB = "<br/>Score: " . $score_date->score_marks ?? '';
				$scoreC = "<br/>Year: " .  $score_date->score_year ?? '';
			} else {
				$scoreA = "";
				$scoreB = "";
				$scoreC = "";
			}


			$data[] = array(
				$n . ' <input type="checkbox" data-id="' . $r->user_id . '" class="exam_status" ' . $checked . ' />',
				'0000' . $r->user_id ?? '',
				$course,
				$study_center1,
				$scoreA . $scoreB . $scoreC,
				$fullname,
				$r->user_mobile ?? '',
				$candidate_data->father_name ?? '',
				$candidate_data->mother_name ?? '',
				$dob,
				$email,
				$gender,
				$category,
				$candidate_data->father_mobile ?? '',
				$candidate_data->mather_mobile ?? '',
				$candidate_data->religion ?? '',
				$parma_state,
				$parma_city,
				date("d-M-Y", strtotime($r->created_date)),
				date("d-M-Y", strtotime($candidate_data->post_date ?? ''))
			);
		}

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"recordsFiltered" => $query->num_rows(),
			"data" => $data
		);


		echo json_encode($result);
		exit();
	}



	public function exam_data_save()
	{


		$flag = 0;
		$check = array();
		$msg = "<ul>";
		foreach ($_POST['exam_id'] as $key => $exam_id) {
			$data = array(
				'user_id' => $_POST['user_id'],
				'exam_id' => $exam_id,
				'created_by' => $this->session->userdata('admin_id'),
			);

			$exam = $this->db->select("*")->from("exam_master")->where("id = " . $exam_id . "")->get()->row();

			$check = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $_POST['user_id'] . "")->where("exam_id = " . $exam_id . "")->get()->result();
			if (empty($check)) {
				$last_id = $this->db_lib->insert('candidate_exam', $data, '');
				if ($last_id) {
					$flag = 1;
					$msg .= "<li style='color:green;'><b>" . $exam->exam_name . ",</b> exam has been assigned for this candidate" . "</li>";
				}
			} else {
				$msg .= "<li style='color:red;'><b>" . $exam->exam_name . ",</b> this exam already assign with this candidate" . "</li>";
			}
		}

		$msg .= "</ul>";

		if ($flag == 1) {
			$array = array('status' => 1, 'msg' => $msg);
			echo json_encode($array);
		} else {
			$array = array('status' => 0, 'msg' => $msg);
			echo json_encode($array);
		}
	}







	public function exam_wise_candidate()
	{

		$this->load->view($this->folder . "exam_wise_candidate");
	}


	public function exam_wise_candidate_ajax()
	{


		$draw = intval($this->input->get("draw"));
		$start = intval(1);
		$length = intval(5);
		$exam_id = $this->input->post('exam_id');
		$status = $this->input->post('status');
		if ($status == 't') {
			$whr = '';
		}
		if ($status == 'p') {
			$whr = 'AND cr.attendance=' . '"present"';
		}
		if ($status == 'a') {
			$whr = 'AND cr.attendance=' . '"absent"';
		}
		if ($status == 'pass') {
			$whr = 'AND cr.exam_status=' . '"pass"';
		}
		if ($status == 'fail') {
			$whr = 'AND cr.exam_status=' . '"fail"';
		}


		$query = $this->db->query("SELECT um.*,ca.post_date,ce.exam_id,ce.id as linkid,cr.* FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id INNER JOIN candidate_exam ce ON ce.user_id = um.user_id LEFT JOIN candidate_result cr ON cr.link_id=ce.id WHERE ce.exam_id='" . $exam_id . "' $whr AND ca.duplicate = 0 AND um.login_status = 2");

		$data = [];
		$n = 0;
		$pr = 0;
		$ab = 0;
		$pp = 0;
		$fl = 0;
		foreach ($query->result() as $r) {

			$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = " . $r->user_id . " AND duplicate = 0")->get()->row();

			$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = " . $r->user_id)->get()->row();

			$fullname = "";
			$corre_state = "";
			$corre_city = "";
			$email = "";
			$parma_city = "";
			$parma_state = "";
			$gender = "";
			$category = "";
			$dob = "";
			$university = "";
			$appr_center_1 = "";
			$gdpi_center_1 = "";
			$study_center1 = "";

			if ($candidate_data != "") {

				$parma_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->parma_state . "")->get()->row();
				$parma_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->parma_city . "")->get()->row();


				$corre_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->corre_state . "")->get()->row();
				$corre_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->corre_city . "")->get()->row();

				if ($r->course_id == 1) {
					$course = "BBA";
				}
				if ($r->course_id == 2) {
					$course = "MBA";
				}

				if ($r->course_id == 1) {
					$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				if ($r->course_id == 2) {
					$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;

				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name ?? '';

				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt = $candidate_data->academic_mark_obt;
				$academic_mark_max = $candidate_data->academic_mark_max;
				$academic_percentage = $candidate_data->academic_percentage;
				$obt = $academic_mark_obt . '/' . $academic_mark_max;
				$parma_address = $candidate_data->parma_appertment . " " . $candidate_data->parma_colony . " " . $candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment . " " . $candidate_data->corre_colony . " " . $candidate_data->corre_area;


				$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $r->user_id . "")->get()->row();
			}


			$n++;
			$amount = ($r->amount) / 100;
			$tranid = $r->razorpay_trans_id;

			if ($r->login_status == 1) {
				$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";
			}

			if ($r->login_status == 2) {
				$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";
			}

			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$checked = "";
			if ($exam_status->id ?? 0 != '') {
				$checked = 'checked = checked; disabled';
			}

			if ($score_date) {
				$scoreA = "Name:" . $score_date->score_name ?? '';
				$scoreB = "<br/>Score: " . $score_date->score_marks ?? '';
				$scoreC = "<br/>Year: " .  $score_date->score_year ?? '';
			} else {
				$scoreA = "";
				$scoreB = "";
				$scoreC = "";
			}

			$exam = $this->db->select("*")->from("exam_master")->where("id = " . $r->exam_id . "")->get()->row();

			$this->db->select('*');
			$this->db->from('candidate_exam CE');
			$this->db->join('candidate_result CR', 'CE.id = CR.link_id');
			$this->db->where('CR.link_id', $r->linkid);
			$this->db->where('CE.user_id', $r->user_id);
			$link = $this->db->get()->row();

			if ($link) {

				if ($link->attendance == 'present') {
					$pesent = "checked = checked";
					$pr += 1;
				} else {
					$pesent = "";
				}
				if ($link->attendance == 'absent') {
					$absent = "checked = checked";
					$ab += 1;
				} else {
					$absent = "";
				}

				if ($link->exam_status == 'pass') {
					$pass = "checked = checked";
					$pp += 1;
				} else {
					$pass = "";
				}
				if ($link->exam_status == 'fail') {
					$fail = "checked = checked";
					$fl += 1;
				} else {
					$fail = "";
				}
			} else {
				$pesent = "";
				$absent = "";
				$pass = "";
				$fail = "";
				// $pr = 0;
				// $ab =0;
				// $pp = 0;
				// $fl =0;
			}

			$data[] = array(

				$n,
				'0000' . $r->user_id ?? '',
				$exam->exam_name,
				$course,
				$study_center1,
				$scoreA . $scoreB . $scoreC,
				$fullname,
				$r->user_mobile ?? '',
				$candidate_data->father_name ?? '',
				$candidate_data->mother_name ?? '',
				$dob,
				$email,
				$gender,
				$category,
				$candidate_data->father_mobile ?? '',
				$candidate_data->mather_mobile ?? '',
				$candidate_data->religion ?? '',
				$parma_state,
				$parma_city,
				date("d-M-Y", strtotime($r->created_date)),
				date("d-M-Y", strtotime($candidate_data->post_date ?? ''))
			);
		}

		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"present"  => $pr,
			"absent" => $ab,
			"pass" => $pp,
			"fail" => $fl,
			"recordsFiltered" => $query->num_rows(),
			"data" => $data
		);


		echo json_encode($result);
		exit();
	}


	public function team_report()
	{
		$team_member_id = $this->input->get('team_member');
		$from_date = $this->input->get('from');
		$to_date = $this->input->get('to');
		// Fetch all assignments for assignment filter dropdown
		$assignment_list = $this->db->select('id, assignment_name')
			->order_by('assignment_name', 'ASC')
			->get('assignment_master')
			->result();
		// Fetch all tags for tag filter dropdown
		$tags = $this->db->select('*')->from('tags')->get()->result();
		$user = $this->db->where('role', 'telecaller')
			->order_by('admin_name', 'ASC')
			->get('admin')
			->result();
		$assignments = [];
		if (!empty($team_member_id) || !empty($from_date) || !empty($to_date) || !empty($assignment_id) || !empty($tag_id)) {
			$this->db->select('a.admin_name, am.id as assignment_id, am.assignment_name as assignment_title, am.assignment_start as assigned_date');
			$this->db->from('assignment aa');
			$this->db->join('assignment_master am', 'aa.assignment_id = am.id');
			$this->db->join('admin a', 'a.admin_id = aa.team_id');
			$this->db->join('calling_data cd', 'cd.assignment_id = am.id', 'left');
			$this->db->join('tags t', 't.tag_id = cd.tag', 'left');
			$this->db->group_by(['a.admin_name', 'am.id', 'am.assignment_name', 'am.assignment_start']);
			$this->db->order_by('am.assignment_start', 'ASC'); // order by assignment_start
			if (!empty($team_member_id)) {
				$this->db->where('a.admin_id', $team_member_id);
			}
			if (!empty($from_date)) {
				$this->db->where('am.assignment_start >=', date('Y-m-d', strtotime($from_date)));
			}
			if (!empty($to_date)) {
				$this->db->where('am.assignment_start <=', date('Y-m-d', strtotime($to_date)));
			}
			if (!empty($assignment_id)) {
				$this->db->where('am.id', $assignment_id);
			}
			if (!empty($tag_id)) {
				$this->db->where('t.tag_id', $tag_id);
			}
			$this->db->order_by('am.assignment_start', 'DESC');
			$assignments = $this->db->get()->result();
		}
		// :white_check_mark: Pass actual assignment list
		$this->load->view($this->folder . "team_report", array(
			'assignments' => $assignments, // will be [] if no filter is applied
			'user' => $user,
			'assignment_list' => $assignment_list,
			'tags' => $tags
		));
	}
	public function filter_team()
	{
		$team_member_id = $this->input->post('team_member');
		$from_date = $this->input->post('from');
		$to_date = $this->input->post('to');
		$tag_names = $this->input->post('tag_names'); // Now these are tag **names**, not IDs
		$assignment_ids = $this->input->post('assignment_ids'); // array
		// Step 1: If tags filter is present, get assignment IDs from calling_data matching these tags
		$assignment_ids_from_tags = [];
		if (!empty($tag_names) && is_array($tag_names)) {
			$this->db->select('DISTINCT assignment_id');
			$this->db->from('calling_data');
			$this->db->group_start();
			foreach ($tag_names as $i => $tag_name) {
				$tag_name = trim($this->db->escape_str($tag_name));
				if ($i === 0) {
					$this->db->where("FIND_IN_SET('{$tag_name}', tag) !=", 0);
				} else {
					$this->db->or_where("FIND_IN_SET('{$tag_name}', tag) !=", 0);
				}
			}
			$this->db->group_end();
			$query = $this->db->get();
			$assignment_ids_from_tags = array_column($query->result_array(), 'assignment_id');
			if (empty($assignment_ids_from_tags)) {
				// No assignments found with these tags, so no results
				echo ''; // return empty result
				return;
			}
		}
		$this->db->select('a.admin_name, am.id as assignment_id, am.assignment_name as assignment_title, am.assignment_start as assigned_date');
		$this->db->from('assignment aa');
		$this->db->join('assignment_master am', 'aa.assignment_id = am.id');
		$this->db->join('admin a', 'a.admin_id = aa.team_id');
		// $this->db->join('calling_data cd', 'cd.team_id = a.admin_id', 'left');
		// // Join calling_data for tag filtering
		// if (!empty($tag_names) && is_array($tag_names)) {
		//  $this->db->join('calling_data cd', 'cd.team_id = am.id', 'inner');
		//  $this->db->group_start(); // start OR group for multiple tags
		//  foreach ($tag_names as $i => $tag_name) {
		//      $tag_name = $this->db->escape_str(trim($tag_name));
		//      if ($i == 0) {
		//          $this->db->where("FIND_IN_SET('{$tag_name}', cd.tag) !=", 0);
		//      } else {
		//          $this->db->or_where("FIND_IN_SET('{$tag_name}', cd.tag) !=", 0);
		//      }
		//  }
		//  $this->db->group_end();
		//  $this->db->group_by('am.id'); // avoid duplicates
		// }
		if (!empty($team_member_id)) {
			$this->db->where('a.admin_id', $team_member_id);
		}
		if (!empty($from_date)) {
			$this->db->where('am.assignment_start >=', date('Y-m-d', strtotime($from_date)));
		}
		if (!empty($to_date)) {
			$this->db->where('am.assignment_start <=', date('Y-m-d', strtotime($to_date)));
		}
		// If tag filter was applied, restrict assignments to those found in calling_data
		if (!empty($assignment_ids)) {
			$this->db->where_in('am.id', $assignment_ids);
		}
		// if (!empty($tag_ids)) {
		//  $this->db->where_in('cd.tag_id', $tag_ids); // Make sure your tag filter matches how tags are stored
		// }
		$this->db->order_by('am.assignment_start', 'DESC');
		$assignments = $this->db->get()->result();
		// // Prepare grouped data same as in view
		// // Fetch all tags for mapping ids to names
		// $tag_list = $this->db->select('tag_id, name')->order_by('name')->get('tags')->result();
		// $tag_names = [];
		// foreach ($tag_list as $tag) {
		//  $tag_names[$tag->tag_id] = $tag->name;
		// }
		$grouped = [];
		foreach ($assignments as $a) {
			$date = $a->assigned_date;
			$key = $a->admin_name . '_' . $date;
			if (!isset($grouped[$key])) {
				$grouped[$key] = [
					'admin_name' => $a->admin_name,
					'date' => $date,
					'assignments' => []
					// 'tags' => []
				];
			}
			$grouped[$key]['assignments'][$a->assignment_id] = $a->assignment_title;
		}
		$sno = 1;
		$html = '';
		foreach ($grouped as $entry) {
			$html .= '<tr>';
			$html .= '<td>' . $sno++ . '</td>';
			$html .= '<td>' . $entry['admin_name'] . '</td>';
			// Tags column
			// Tags column: here you can fetch tags from calling_data if needed
			// Or leave as '-' since no direct tag linkage is fetched here
			// $html .=  '<td>' . (!empty($entry['tags']) ? implode(', ', $entry['tags']) : 'No Tags') . '</td>';
			$html .= '<td>' . date('d-m-Y', strtotime($entry['date'])) . '</td>';
			$html .= '<td>';
			foreach ($entry['assignments'] as $id => $title) {
				$html .= '<button type="button" class="btn btn-sm btn-primary assignment-link" data-id="' . $id . '" style="margin-right: 5px; margin-bottom: 5px;">' . $title . '</button>';
			}
			$html .= '</td>';
			$html .= '</tr>';
		}
		echo $html; // output only the table rows for ajax replacement
	}


	public function team_assignment_candidates()
	{
		$draw = intval($this->input->get("draw"));
		$start = intval(1);
		$length = intval(5);
		$assignment_id = $this->input->post('data');
		$from_date = $this->input->post('from');  // format: YYYY-MM-DD
		$to_date = $this->input->post('to');
		// $query = $this->db->query("SELECT um.*,aa.created_at,aa.assign_id FROM assignment aa INNER JOIN assignment_master am ON am.id = aa.assignment_id INNER JOIN user_master um ON um.user_id=aa.user_id WHERE am.id = $assignment_id;");
		// Base query with placeholders and date filter if given
		$this->db->select("um.*, aa.created_at, aa.assign_id");
		$this->db->from("assignment aa");
		$this->db->join("assignment_master am", "am.id = aa.assignment_id");
		$this->db->join("calling_data cd", "cd.user_id = aa.user_id");
		$this->db->join("user_master um", "um.user_id = aa.user_id");
		$this->db->where("am.id", $assignment_id);
		if (!empty($from_date) && !empty($to_date)) {
			// Filter by created_at date range (adjust the column name if needed)
			$this->db->where("DATE(cd.call_date) >=", $from_date);
			$this->db->where("DATE(cd.call_date) <=", $to_date);
		}
		$query = $this->db->get();
		$data = [];
		$n = 0;
		$comp = 0;
		foreach ($query->result() as $r) {
			$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = " . $r->user_id . " AND duplicate = 0")->get()->row();
			$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = " . $r->user_id)->get()->row();
			$fullname = "";
			$corre_state = "";
			$corre_city = "";
			$email = "";
			$parma_city = "";
			$parma_state = "";
			$gender = "";
			$category = "";
			$dob = "";
			$university = "";
			$appr_center_1 = "";
			$gdpi_center_1 = "";
			$study_center1 = "";
			if ($candidate_data != "") {
				$parma_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->parma_state . "")->get()->row();
				$parma_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->parma_city . "")->get()->row();
				$corre_state_data = $this->db->select("*")->from("states")->where("id = " . $candidate_data->corre_state . "")->get()->row();
				$corre_city_data = $this->db->select("*")->from("cities")->where("id = " . $candidate_data->corre_city . "")->get()->row();
				if ($r->course_id == 1) {
					$course = "BBA";
				}
				if ($r->course_id == 2) {
					$course = "MBA";
				}
				if ($r->course_id == 1) {
					$fullname = "<a href='../journey/show_journey/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}
				if ($r->course_id == 2) {
					$fullname = "<a href='../journey/show_journey/$r->user_id' target='_blank'>" . $candidate_data->first_name . " " . $candidate_data->middle_name . " " . $candidate_data->last_name . "</a>";
				}
				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name ?? '';
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt = $candidate_data->academic_mark_obt;
				$academic_mark_max = $candidate_data->academic_mark_max;
				$academic_percentage = $candidate_data->academic_percentage;
				$obt = $academic_mark_obt . '/' . $academic_mark_max;
				$parma_address = $candidate_data->parma_appertment . " " . $candidate_data->parma_colony . " " . $candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment . " " . $candidate_data->corre_colony . " " . $candidate_data->corre_area;
				$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = " . $r->user_id . "")->get()->row();
				$this->db->select('*');
				$this->db->from('candidate_exam CE');
				$this->db->join('exam_master em', 'em.id = CE.exam_id');
				$this->db->where('CE.user_id', $r->user_id);
				$exam = $this->db->get()->result();
				$examName = "<ul>";
				foreach ($exam as $key => $exams) {
					$examName .=  '<li>' . $exams->exam_name . '</li>';
				}
				$examName .= '</ul>';
			}
			$n++;
			if ($r->amount) {
				$amount = ($r->amount) / 100;
			} else {
				$amount = 0;
			}
			$tranid = $r->razorpay_trans_id;
			if ($r->login_status == 1) {
				$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";
			}
			if ($r->login_status == 2) {
				$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";
			}
			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";
			$checked = "";
			if ($exam_status->id ?? 0 != '') {
				$checked = 'checked = checked; disabled';
			}
			if ($score_date) {
				$scoreA = "Name:" . $score_date->score_name ?? '';
				$scoreB = "<br/>Score: " . $score_date->score_marks ?? '';
				$scoreC = "<br/>Year: " .  $score_date->score_year ?? '';
			} else {
				$scoreA = "";
				$scoreB = "";
				$scoreC = "";
			}
			if ($this->session->userdata['role'] == 'telecaller') {
				$calling_check = $this->db->select("*")->from("calling_data")->where("assign_id = " . $r->assign_id . "")->get()->row();
				if ($calling_check) {
					$btn = "<b>Done</b>";
					$comp++;
				} else {
					$btn = '<input type="checkbox" value="' . $r->user_id . '" assign-id="' . $r->assign_id . '" data-id="' . $r->user_id . '" class="exam_status checkbox" name="user_id[]"/>';
				}
			} else {
				$calling_check = $this->db->select("*")->from("calling_data")->where("assign_id = " . $r->assign_id . "")->get()->row();
				if ($calling_check) {
					$btn = "";
					$comp++;
				} else {
					$btn = '';
				}
			}
			// if (strtotime($r->created_at) >= strtotime($from_date) && strtotime($r->created_at) <= strtotime($to_date)) {
			$candidate_information = '<b>Enroll No.: </b> 0000' . $r->user_id . '<br/><b>Full Name: </b>' . $fullname . '<br/><b>Mobile :</b> ' . $r->user_mobile . '<br/><b>Father Name: </b>' . $candidate_data->father_name . '<br/><b>Mother Name: </b>' . $candidate_data->mother_name . '<br/><b>DOB: </b>' . $dob . '<br/><b>Email: </b>' . $email . '<br/><b>Gender: </b>' . $gender;
			// } else {
			//  $candidate_information = '';
			// }
			// if (strtotime($r->created_at) >= strtotime($from_date) && strtotime($r->created_at) <= strtotime($to_date)) {
			$academic_information = '<b>Course: </b>' . $course . '<br/><b>Study Center: </b>' . $study_center1 . '<br/><b>Category: </b>' . $category . '<br/><b>State: </b>' . $parma_state . '<br/><b>City: </b>' . $parma_city . '<br/><b>Enroll DateTime: </b>' . date("d-M-Y", strtotime($r->created_at));
			// } else {
			//  $academic_information = '';
			// }
			//      $communication = $this->db->query("SELECT cd.*,admin.admin_name as tname,mode.name as mname, campaign.name as cname,responses.name as rname from calling_data cd inner join admin on admin.admin_id = cd.team_id inner join mode on mode.id = cd.mode inner join campaign on campaign.id = cd.campaign_id inner join responses on responses.id = cd.response_id where cd.user_id='" . $r->user_id . "' AND cd.call_date BETWEEN '$from_date' AND '$to_date'
			// ORDER BY call_date ASC")->result_array();
			//      $communicate = "";

			$communication = $this->db->query("SELECT cd.*,admin.admin_name as tname,mode.name as mname, campaign.name as cname,responses.name as rname from calling_data cd inner join admin on admin.admin_id = cd.team_id inner join mode on mode.id = cd.mode inner join campaign on campaign.id = cd.campaign_id inner join responses on responses.id = cd.response_id where cd.user_id='" . $r->user_id . "' ORDER BY call_date ASC")->result_array();
			$communicate = "";
			foreach ($communication as $key => $comm) {
				$tags = "";
				$tag_array = explode(',', $comm['tag']);
				foreach ($tag_array as $key => $tag) {
					$tag_query = $this->db->query("select * from tags where tag_id = $tag")->row();
					$tags = '<span class="badge badge-primary">' . $tag_query->name ?? '' . '</span>';
				}
				$communicate = '<div class="tracking-item"><div class="tracking-date"><b>DateTime: </b>' . date('M d, Y', strtotime($comm['call_date'])) . '<span> ' . date('h:i A', strtotime($comm['call_time'])) . '</span></div>
                            <div class="tracking-content">
                            <b>Campaign: </b><span style="color:red; font-size:18px; padding-bottom:10px;">' . $comm['cname'] . '</span><br/>
                            <b>Calling Team: </b>' . $comm['tname'] . '<br/>
                            <b>Communication Mode: </b>' . $comm['mname'] . '<br/>
                            <b>Call Action: </b>' . $comm['call_action'] . '<br/>
                            <b>Call Response: </b>' . $comm['rname'] . '<br/>
                            <b>Remark: </b>' . $comm['notes'] . '<br/>
                            <b>Tags: </b>' . $tags . '
                            </div>
                            </div>';
			}
			$data[] = array(
				$n . $btn,
				$candidate_information,
				$academic_information,
				$communicate,
			);
		}
		$result = array(
			"draw" => $draw,
			"recordsTotal" => $query->num_rows(),
			"recordsFiltered" => $query->num_rows(),
			"recordsComplete" => $comp,
			"data" => $data
		);
		echo json_encode($result);
		exit();
	}


	public function get_calling_data()
	{

		$id = $this->input->post('id');
		$callingdata = $this->db->query("SELECT calling_data.*,assignment.status FROM calling_data INNER JOIN assignment on assignment.assign_id = calling_data.assign_id where calling_data.id=$id")->row();
		echo json_encode($callingdata);
	}

	public function filter_exam_candidate_search()
	{
		$draw = intval($this->input->post("draw"));
		$start = intval($this->input->post("start"));
		$length = intval($this->input->post("length"));
		$filter_where = $this->input->post("filter_where");
		// Parse filter_where to detect exam_id only filter (basic check)
		$onlyExamFilter = false;
		$exam_id = null;
		if ($filter_where) {
			// Try to extract exam_id condition from filter_where string, e.g. "ce.exam_id = 1"
			if (preg_match('/ce\.exam_id\s*=\s*(\d+)/', $filter_where, $matches)) {
				$exam_id = intval($matches[1]);
				// Check if filter_where contains anything else besides exam_id condition
				// e.g. does filter_where only contain "ce.exam_id = 1"
				$withoutExamId = preg_replace('/ce\.exam_id\s*=\s*\d+/', '', $filter_where);
				$withoutExamId = trim($withoutExamId, " \t\n\r\0\x0BAND"); // trim AND and spaces
				if ($withoutExamId == '') {
					$onlyExamFilter = true;
				}
			}
		}
		$baseWhere = "ca.duplicate = 0 AND um.login_status = 2";
		if ($onlyExamFilter && $exam_id !== null) {
			// Fetch no_of_candidates from exam_master table for this exam_id
			$exam_data = $this->db->select('no_of_candidates')
				->from('exam_master')
				->where('exam_id', $exam_id)
				->get()
				->row();
			$total_candidates = $exam_data ? intval($exam_data->no_of_candidate) : 0;
			// For data, fetch actual paginated candidates matching exam filter
			$where = "WHERE $baseWhere AND ce.exam_id = $exam_id";
			$query = $this->db->query("SELECT um.*, ca.*, ce.exam_id, ce.id as linkid, cr.* FROM candidate_data ca INNER JOIN user_master um ON um.user_id = ca.mobile_verified_id INNER JOIN candidate_exam ce ON ce.user_id = um.user_id LEFT JOIN candidate_result cr ON cr.link_id = ce.id $where LIMIT $start, $length ");
			$data = [];
			foreach ($query->result() as $r) {
				$course = $r->course_id == 1 ? "BBA" : ($r->course_id == 2 ? "MBA" : "");
				$roll_no = '0000' . $r->user_id;
				$study_center = $r->study_centre_1 ?? '';
				$score_data = $this->db->select("*")
					->from("candidate_score_mba")
					->where("candidate_id", $r->user_id)
					->get()->row();
				if ($r->course_id == 1) {
					$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>" . $r->first_name . " " . $r->middle_name . " " . $r->last_name . "</a>";
				}
				if ($r->course_id == 2) {
					$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>" . $r->first_name . " " .
						$r->middle_name . " " . $r->last_name . "</a>";
				}
				$score = $score_data
					? "Name: {$score_data->score_name}<br>Score: {$score_data->score_marks}<br>Year: {$score_data->score_year}"
					: '';
				$parma_state = $this->db->where('id', $r->parma_state)->get('states')->row()->name ?? '';
				$parma_city = $this->db->where('id', $r->parma_city)->get('cities')->row()->name ?? '';
				$checkbox = '<input type="checkbox" class="select_candidate" value="' . $r->user_id . '">';
				$fullname = "<a href='/$r->user_id' target='_blank'>" . $r->first_name . " " . $r->middle_name . " " . $r->last_name . "</a>";
				$data[] = [
					$checkbox,
					$roll_no,
					$course,
					$study_center,
					$score,
					$fullname,
					$r->user_mobile ?? '',
					$r->father_name ?? '',
					$r->mother_name ?? '',
					$r->dob ?? '',
					$r->email_id ?? '',
					$r->gender ?? '',
					$r->category ?? '',
					$r->religion ?? '',
					$parma_state,
					$parma_city,
					$r->post_date
				];
			}
			$result = [
				"draw" => $draw,
				"recordsTotal" => $total_candidates,
				"recordsFiltered" => $total_candidates,
				"data" => $data
			];
		} else {
			// Usual filter logic (multiple filters or no filters)
			$where = "WHERE $baseWhere";
			if (!empty($filter_where)) {
				$where .= " AND ($filter_where)";
			}
			$totalCountQuery = $this->db->query("SELECT COUNT(*) as cnt FROM candidate_data ca INNER JOIN user_master um ON um.user_id = ca.mobile_verified_id INNER JOIN candidate_exam ce ON ce.user_id = um.user_id LEFT JOIN candidate_result cr ON cr.link_id = ce.id $where ");
			$recordsTotal = $totalCountQuery->row()->cnt;
			$query = $this->db->query("SELECT um.*, ca.*, ce.exam_id, ce.id as linkid, cr.* FROM candidate_data ca INNER JOIN user_master um ON um.user_id = ca.mobile_verified_id INNER JOIN candidate_exam ce ON ce.user_id = um.user_id LEFT JOIN candidate_result cr ON cr.link_id = ce.id $where LIMIT $start, $length ");
			$data = [];
			foreach ($query->result() as $r) {
				$course = $r->course_id == 1 ? "BBA" : ($r->course_id == 2 ? "MBA" : "");
				$roll_no = '0000' . $r->user_id;
				$study_center = $r->study_centre_1 ?? '';
				$score_data = $this->db->select("*")
					->from("candidate_score_mba")
					->where("candidate_id", $r->user_id)
					->get()->row();
				if ($r->course_id == 1) {
					$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>" . $r->first_name . " " . $r->middle_name . " " . $r->last_name . "</a>";
				}
				if ($r->course_id == 2) {
					$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>" . $r->first_name . " " . $r->middle_name . " " . $r->last_name . "</a>";
				}
				$score = $score_data
					? "Name: {$score_data->score_name}<br>Score: {$score_data->score_marks}<br>Year: {$score_data->score_year}"
					: '';
				$parma_state = $this->db->where('id', $r->parma_state)->get('states')->row()->name ?? '';
				$parma_city = $this->db->where('id', $r->parma_city)->get('cities')->row()->name ?? '';
				$checkbox = '<input type="checkbox" class="select_candidate" value="' . $r->user_id . '">';
				$fullname = "<a href='show_from_bba/$r->user_id' target='_blank'>" . $r->first_name . " " . $r->middle_name . " " . $r->last_name . "</a>";
				$data[] = [
					$checkbox,
					$roll_no,
					$course,
					$study_center,
					$score,
					$fullname,
					$r->user_mobile ?? '',
					$r->father_name ?? '',
					$r->mother_name ?? '',
					$r->dob ?? '',
					$r->email_id ?? '',
					$r->gender ?? '',
					$r->category ?? '',
					$r->religion ?? '',
					$parma_state,
					$parma_city,
					$r->post_date
				];
			}
			$result = [
				"draw" => $draw,
				"recordsTotal" => $recordsTotal,
				"recordsFiltered" => $recordsTotal,
				"data" => $data
			];
		}
		echo json_encode($result);
		exit();
	}

	

	public function general_report(){
		$responses = $this->db->select('*')->from('responses')->get()->result();
		$tags = $this->db->select('*')->from('tags')->get()->result();
		$this->load->view($this->folder . "general_report", array('tags'=>$tags, 'responses' => $responses));
	}


	public function general_report_search()
	{

	
	  $draw = intval($this->input->get("draw"));
      $start = intval(1);
      $length = intval(5);

	  $whr = $this->input->post('data');
		
	  //$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca 
	  // INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id 
	  // INNER JOIN calling_data cd ON cd.user_id = um.user_id $whr AND ca.duplicate = 0 AND ca.admission=0 AND um.login_status = 2");

	  $query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca 
		INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id 
		INNER JOIN calling_data cd ON cd.user_id = um.user_id
		INNER JOIN candidate_exam ce ON ce.user_id = um.user_id
		INNER JOIN candidate_result cr ON cr.link_id = ce.id
		INNER JOIN exam_master em ON em.id = ce.exam_id
		$whr AND ca.duplicate = 0 AND ca.admission=0 AND um.login_status = 2 AND ce.exam_status='pass' AND em.exam_type='gdpi'");
			

      $data = [];
      $n = 0;
      foreach($query->result() as $r) {




      		    $candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = ".$r->user_id." AND duplicate = 0")->get()->row(); 
		  
		  		$score_date = $this->db->select("*")->from("candidate_score_mba")->where("candidate_id = ".$r->user_id)->get()->row(); 

      			$fullname =""; $corre_state=""; $corre_city="";
      			$email ="";  $parma_city=""; $parma_state="";
      			$gender=""; $category=""; $dob="";
      			$university=""; $appr_center_1=""; $gdpi_center_1=""; $study_center1="";

      		if($candidate_data !=""){

      			$parma_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->parma_state."")->get()->row();
      			$parma_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->parma_city."")->get()->row(); 
	      		

	      		$corre_state_data = $this->db->select("*")->from("states")->where("id = ".$candidate_data->corre_state."")->get()->row();
	      		$corre_city_data = $this->db->select("*")->from("cities")->where("id = ".$candidate_data->corre_city."")->get()->row(); 
	      		
				if($r->course_id==1){$course = "BBA";}
				if($r->course_id==2){$course = "MBA";}

      			if($r->course_id==1){$fullname = "<a href='../journey/show_journey/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='../journey/show_journey/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$university = $candidate_data->academic_board;
				$appr_center_1 = $candidate_data->appearing_center_1;
				$appr_center_2 = $candidate_data->appearing_center_2;
				$appr_center_3 = $candidate_data->appearing_center_3;
				$appr_center_4 = $candidate_data->appearing_center_4;
				$gdpi_center_1 = $candidate_data->gdpi_center_1;
				$gdpi_center_2 = $candidate_data->gdpi_center_2;
				$gdpi_center_3 = $candidate_data->gdpi_center_3;
				$gdpi_center_4 = $candidate_data->gdpi_center_4;
				$study_center1 = $candidate_data->study_centre_1;
				$study_center2 = $candidate_data->study_centre_2;
				$study_center3 = $candidate_data->study_centre_3;
				$study_center4 = $candidate_data->study_centre_4;
				$category = $candidate_data->category;
				$dob = $candidate_data->dob;
				
				$parma_state = $parma_state_data->name;
				$parma_city = $parma_city_data->name;
				$corre_state = $corre_state_data->name;
				$corre_city = $corre_city_data->name??'';
				
				$college = $candidate_data->academic_intermediate;
				$academic_year = $candidate_data->academic_year;
				$academic_mark_obt =$candidate_data->academic_mark_obt;
				$academic_mark_max =$candidate_data->academic_mark_max;
				$academic_percentage =$candidate_data->academic_percentage;
				$obt = $academic_mark_obt.'/'.$academic_mark_max;
				$parma_address = $candidate_data->parma_appertment." ".$candidate_data->parma_colony." ".$candidate_data->parma_area;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;


			$exam_status = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->get()->row();

			$this->db->select('*');    
			$this->db->from('candidate_exam CE');
			$this->db->join('exam_master em', 'em.id = CE.exam_id');
			$this->db->where('CE.user_id', $r->user_id);
			$exam = $this->db->get()->result();
			$examName = "<ul>";
			foreach ($exam as $key => $exams) {
				$examName .=  '<li>'.$exams->exam_name.'</li>';
			}
			$examName .='</ul>';


      		}
      		

      		$n++;
      		$amount = ($r->amount)/100;
      		$tranid = $r->razorpay_trans_id;

			if($r->login_status==1){$sts_btn = "<span class='btn btn-xs btn-danger'> Mobile Verified</span>";} 

			if($r->login_status==2){$sts_btn = "<span class='btn btn-xs btn-success'> Paid</span>";}
			
			$admit_btn = "<a href='generate_admit_card/$r->user_id' target='_blank' class='btn btn-danger btn-xs'>Admit Card</a>";

			$checked="";
			if($exam_status->id??0 !=''){$checked = 'checked = checked; disabled';}
			
		  	if($score_date){
				$scoreA = "Name:". $score_date->score_name??'';
				$scoreB = "<br/>Score: ". $score_date->score_marks??'';
				$scoreC = "<br/>Year: ".  $score_date->score_year??'';
		  	}else{$scoreA=""; $scoreB=""; $scoreC="";}


			$call_count = $this->db->query("SELECT * FROM calling_data where user_id = '".$r->user_id."'")->num_rows();
		  
			
           $data[] = array(
				'0000'.$r->user_id??'',
				$examName,
				$course,
				$study_center1,
			    $scoreA.$scoreB.$scoreC,
           		$fullname.'<br/> Total Calls- '.$call_count,
                $r->user_mobile??'',
			    $candidate_data->father_name??'',
			    $candidate_data->mother_name??'',
			    $dob,
                $email,
                $gender,
				$category,
				$candidate_data->father_mobile??'',
				$candidate_data->mather_mobile??'',
				$candidate_data->religion??'',
                $parma_state,
                $parma_city,
				date("d-M-Y", strtotime($r->created_date)),
				date("d-M-Y", strtotime($candidate_data->post_date??''))
           );
      }

	      $result = array(
	               	 "draw" => $draw,
	                 "recordsTotal" => $query->num_rows(),
	                 "recordsFiltered" => $query->num_rows(),
	                 "data" => $data
	      );


      echo json_encode($result);
      exit();

	}
}	

