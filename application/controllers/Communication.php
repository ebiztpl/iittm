<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Controller Class
 *
 * @author		ImpelPro Dev Team
**/

class Communication extends CI_Controller {
	
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
			if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
		
		if(isset($_POST['btnsubmit']))
		{

					
  			if(empty($fetch)){

				$data = array(
				'name' => $_POST['exam_name'], 
			);

			$last_id = $this->db_lib->insert('team',$data,'');

			if($last_id>0)
			{
				 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
				 redirect("communication/team");
			}
			else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
				redirect("communication/team");
			}

			}else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("communication/team");
			}	
		}
		

		$arry_data =  $this->db->select('*')->from('team')->get()->result();
		$this->load->view($this->folder."team",array('result'=>$arry_data));
	}	


	public function delete_team()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$delete = $this->db_lib->delete("team",$where);
		if($delete){

			echo 1;
		}

	}

	public function get_team()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("team",$where,'*');
		
		echo json_encode($get);
	}


	public function edit_team()
	{
		$id = $_POST['edit_id'];
		
		$where = "id = '$id'";
		$update_data = array(
			'name' => $_POST['exam_name'], 
		);
		$rst = $this->db_lib->update('team',$update_data,$where);

		if($rst)
		{
			 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			 redirect("communication/team");
		}
	}


	public function admit_card()
	{
		
		$rst_form_data = $this->db_lib->fetchRecords('update_form','','*');
		$this->load->view($this->folder."admit_card",array('result'=>$rst_form_data));
	}


	public function campaign()
	{
			if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
		
		if(isset($_POST['btnsubmit']))
		{

					
  			if(empty($fetch)){

				$data = array(
				'name' => $_POST['exam_name'], 
				'description' => $_POST['desc'],
			);

			$last_id = $this->db_lib->insert('campaign',$data,'');

			if($last_id>0)
			{
				 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
				 redirect("communication/campaign");
			}
			else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
				redirect("communication/campaign");
			}

			}else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("communication/campaign");
			}	
		}
		

		$arry_data =  $this->db->select('*')->from('campaign')->get()->result();
		$this->load->view($this->folder."campaign",array('result'=>$arry_data));
	}

	public function delete_campaign()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$delete = $this->db_lib->delete("campaign",$where);
		if($delete){

			echo 1;
		}

	}

	public function get_campaign()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("campaign",$where,'*');
		
		echo json_encode($get);
	}
	
	public function get_campaign_with_response()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("campaign",$where,'*');

		$rwhere = "campaign_id='$id'";
		$responses = $this->db_lib->fetchRecords("responses",$rwhere,'*');

		$res="";
		if($responses){
			$res = "<ul>";
			foreach ($responses as $key => $value) {
				$res .= "<li>".$value['name']."</li>";
			}	
			$res .="</ul>";	
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
		$rst = $this->db_lib->update('campaign',$update_data,$where);

		if($rst)
		{
			 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			 redirect("communication/campaign");
		}
	}

	public function mode()
	{
			if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
		
		if(isset($_POST['btnsubmit']))
		{

					
  			if(empty($fetch)){

				$data = array(
				'name' => $_POST['exam_name'], 
			);

			$last_id = $this->db_lib->insert('mode',$data,'');

			if($last_id>0)
			{
				 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
				 redirect("communication/mode");
			}
			else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
				redirect("communication/mode");
			}

			}else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("communication/mode");
			}	
		}
		

		$arry_data =  $this->db->select('*')->from('mode')->get()->result();
		$this->load->view($this->folder."mode",array('result'=>$arry_data));
	}

	public function delete_mode()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$delete = $this->db_lib->delete("mode",$where);
		if($delete){

			echo 1;
		}

	}

	public function get_mode()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("mode",$where,'*');
		
		echo json_encode($get);
	}


	public function edit_mode()
	{
		$id = $_POST['edit_id'];
		
		$where = "id = '$id'";
		$update_data = array(
			'name' => $_POST['exam_name'], 
		);
		$rst = $this->db_lib->update('mode',$update_data,$where);

		if($rst)
		{
			 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			 redirect("communication/mode");
		}
	}

	public function responses()
	{
			if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
		
		if(isset($_POST['btnsubmit']))
		{

					
  			if(empty($fetch)){

				$data = array(
				'campaign_id' =>$_POST['campaign_id'], 
				'name' => $_POST['exam_name'], 
			);

			$last_id = $this->db_lib->insert('responses',$data,'');

			if($last_id>0)
			{
				 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
				 redirect("communication/responses");
			}
			else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
				redirect("communication/responses");
			}

			}else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("communication/responses");
			}	
		}

		$campaign = $this->db->select('*')->from('campaign')->get()->result();
		$arry_data =  $this->db->select('*')->from('responses')->get()->result();
		$this->load->view($this->folder."responses",array('result'=>$arry_data,'campaign'=>$campaign));
	}

	public function delete_responses()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$delete = $this->db_lib->delete("responses",$where);
		if($delete){

			echo 1;
		}

	}

	public function get_responses()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("responses",$where,'*');
		
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
		$rst = $this->db_lib->update('responses',$update_data,$where);

		if($rst)
		{
			 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			 redirect("communication/responses");
		}
	}


	public function candidates()
	{
		
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
		$team = $this->db->select('*')->from('team')->get()->result();
		$campaign = $this->db->select('*')->from('campaign')->get()->result();
		$mode = $this->db->select('*')->from('mode')->get()->result();
		$responses = $this->db->select('*')->from('responses')->get()->result();
		$table='exam_master';
			$fields = "*";
			$whr = "";
			
			
		$exams = $this->db_lib->fetchRecords($table,$whr,$fields);
		$user = $this->db->select('*')->from('admin')->where('role','telecaller')->get()->result();
		$this->load->view($this->folder."candidates",array(
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
		
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}

		$team = $this->db->select('*')->from('team')->get()->result();
		$campaign = $this->db->select('*')->from('campaign')->get()->result();
		$mode = $this->db->select('*')->from('mode')->get()->result();
		$responses = $this->db->select('*')->from('responses')->get()->result();

		$user = $this->db->select('*')->from('admin')->where('role','telecaller')->get()->result();

		$assignment = $this->db->select('*')
		->from('assignment')
		->join('campaign','campaign.id =assignment.campaign_id')
		->where('team_id',$this->session->userdata['admin_id'])
		->group_by('campaign_id')->get()->result();

		$tags = $this->db->select('*')->from('tags')->get()->result();

		$this->load->view($this->folder."candidates_team",array(
			'team' => $team,
			'campaign' => $campaign,
			'mode' => $mode,
			'responses' => $responses,
			'user' => $user,
			'assignment' => $assignment,
			'tags' => $tags
		));
	}



	public function create_tag(){
		$tag = $this->input->post("tag-create");
		$id = $this->db_lib->insert('tags',array('name'=>$tag),'');
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

		if($reg_status == 1){

			$query = $this->db->query("SELECT um.*,ca.post_date FROM user_master um LEFT JOIN candidate_data ca on ca.mobile_verified_id = um.user_id $whr AND um.login_status = 1");

		}else
		{
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2");
		}

			
			
		
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

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

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
      		if($r->amount){
      		$amount = ($r->amount)/100;
      			}else{$amount=0;}
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
		  
			
           $data[] = array(
           		//'<a data-id="'.$r->user_id.'" class="exam_status btn btn-danger btn-xs">Response</a>',
           		'<input type="checkbox" value="'.$r->user_id.'" data-id="'.$r->user_id.'" class="exam_status checkbox" name="user_id[]"/>',
				'0000'.$r->user_id??'',
				//$examName,
				$course??'',
				$study_center1,
			    $scoreA.$scoreB.$scoreC,
           		$fullname,
                $r->user_mobile??'',
			    $candidate_data->father_name??'',
			    $candidate_data->mother_name??'',
			    $dob,
                $email,
                $gender,
				$category,
				//$candidate_data->father_mobile??'',
				//$candidate_data->mather_mobile??'',
				$candidate_data->religion??'',
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

		
			$query = $this->db->query("SELECT um.*,aa.created_at FROM assignment aa INNER JOIN user_master um ON um.user_id=aa.user_id WHERE aa.campaign_id = $campaign_id AND team_id = '".$this->session->userdata['admin_id']."' AND um.login_status = 2");
		

			
		
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

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

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
      		if($r->amount){
      		$amount = ($r->amount)/100;
      			}else{$amount=0;}
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
		  
			
           $data[] = array(
           		//'<a data-id="'.$r->user_id.'" class="exam_status btn btn-danger btn-xs">Response</a>',
           		'<input type="checkbox" value="'.$r->user_id.'" data-id="'.$r->user_id.'" class="exam_status checkbox" name="user_id[]"/>',
				'0000'.$r->user_id??'',
				//$examName,
				$course,
				$study_center1,
			    $scoreA.$scoreB.$scoreC,
           		$fullname,
                $r->user_mobile??'',
			    $candidate_data->father_name??'',
			    $candidate_data->mother_name??'',
			    $dob,
                $email,
                $gender,
				$category,
				//$candidate_data->father_mobile??'',
				//$candidate_data->mather_mobile??'',
				$candidate_data->religion??'',
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

		
		$flag = 0; $check=array(); $msg="";
		
			$data = array(
			'user_id' => $_POST['user_id'],
			'team_id' => $this->session->userdata['admin_id'],
			'assign_id' => $_POST['assign_id'],
			'campaign_id' => $_POST['campaign_id_hidden'],
			'mode' => $_POST['mode_id'],
			'call_action' => $_POST['call_action'],
			'response_id' => $_POST['response_id'],
			'call_date' => date('Y-m-d',strtotime($_POST['call_date'])),
			'call_time' => $_POST['call_time'],
			'correct_email' => $_POST['correct_email'],
			'correct_mobile' => $_POST['correct_mobile'],
			'notes' => $_POST['notes'],
			'tag'=> implode(',', $_POST['tags'])
			);

		
			if(isset($_POST['status'])?$_POST['status']:"" == 1){
				
				$update = array('status' => 1);
				$where = "user_id = ".$_POST['user_id']." AND assign_id = ".$_POST['assign_id'];
				$update = $this->db_lib->update('assignment', $update, $where);
			} 

			$last_id = $this->db_lib->insert('calling_data',$data,'');
			if($last_id){
				$flag = 1; 
				$msg = "<span style='color:green;'>Response Has been Submited Successfully". "</span>";
			}
			
		

	
		
		if($flag==1){
			$array = array('status' => 1, 'msg' => $msg );
			echo json_encode($array);
		}else{
			$array = array('status' => 0, 'msg' => $msg );
			echo json_encode($array);
		}

		
	}

	public function assignment_save()
	{

		$assignment_master = array('assignment_name'=> $_POST['assignment_name'],'assignment_start' => $_POST['start_date'],'assignment_end'=>$_POST['end_date'],'created_by'=> $this->session->userdata['admin_id']);

		$assignment_id = $this->db_lib->insert('assignment_master',$assignment_master,'');
		
		//print_r($assignment_master); die;
		
		if($assignment_id)
		{
			$flag = 0;
			foreach ($_POST['user_id'] as $key => $value) 
			{
			
				$data = array(
					'campaign_id' => $_POST['assign_campaign'],
					'team_id' => $_POST['assign_team'],
					'assignment_id' => $assignment_id, 
					'user_id' => $value,
				);

				$last_id = $this->db_lib->insert('assignment',$data,'');
				$flag++;
			}
		}


		if($flag > 0){
			$this->session->set_flashdata('msg', "Assignment has been Created!");
			redirect("communication/assignment_report");

		}

	}



	public function assignment_report(){

			$role = $this->session->userdata['role'];

			if($role == 'admin'){
				$assignment = $this->db->select('am.*,am.id as id,c.name as cname, c.id as cid, a.admin_name as team')->from('assignment_master am')
					->join('assignment aa', 'aa.assignment_id = am.id')
					->join('campaign c', 'c.id = aa.campaign_id')
					->join('admin a', 'a.admin_id = aa.team_id')
					->group_by('aa.assignment_id')
					->get()->result();
			}
			else{
				$assignment = $this->db->select('am.*,am.id as id,c.name as cname, c.id as cid, a.admin_name as team')->from('assignment_master am')
				->join('assignment aa', 'aa.assignment_id = am.id')
				->join('campaign c', 'c.id = aa.campaign_id')
				->join('admin a', 'a.admin_id = aa.team_id')
				->where('aa.team_id',$this->session->userdata['admin_id'])
				->group_by('aa.assignment_id')
				->get()->result();
			}

			
		$team = $this->db->select('*')->from('team')->get()->result();
		$campaign = $this->db->select('*')->from('campaign')->get()->result();
		$mode = $this->db->select('*')->from('mode')->get()->result();
		$responses = $this->db->select('*')->from('responses')->get()->result();
		$tags = $this->db->select('*')->from('tags')->get()->result();
		$user = $this->db->select('*')->from('admin')->where('role','telecaller')->get()->result();

			$this->load->view($this->folder."assignment_report",array(
				'assignment' => $assignment,
				'team' => $team,
				'campaign' => $campaign,
				'mode' => $mode,
				'responses' => $responses,
				'user' => $user,
				'tags' => $tags
			));

	}



	public function assignment_candidates()
	{
	
	
	
		$draw = intval($this->input->get("draw"));
      	$start = intval(1);
      	$length = intval(5);

		$assignment_id = $this->input->post('data');

		
		$query = $this->db->query("SELECT um.*,aa.created_at,aa.assign_id,aa.campaign_id FROM assignment aa INNER JOIN assignment_master am ON am.id = aa.assignment_id INNER JOIN user_master um ON um.user_id=aa.user_id WHERE am.id = $assignment_id");
		

			
		
      $data = [];
      $n = 0; $comp = 0; $course="";
      foreach($query->result() as $r) {

		  	$campaign_id = $r->campaign_id;
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
      		if($r->amount){
      		$amount = ($r->amount)/100;
      			}else{$amount=0;}
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
		  
		  	if($this->session->userdata['role']=='telecaller'){

		  		$calling_check = $this->db->select("*")->from("calling_data")->where("assign_id = ".$r->assign_id."")->get()->row();
		  		if($calling_check){
		  				$btn = "<b>Done</b>";
						$comp++;
		  		}else{
		  			$btn = '<input type="checkbox" value="'.$r->user_id.'" assign-id="'.$r->assign_id.'" data-id="'.$r->user_id.'" class="exam_status checkbox" name="user_id[]"/>';
		  		}
		  		
		  	}else{
		  		$calling_check = $this->db->select("*")->from("calling_data")->where("assign_id = ".$r->assign_id."")->get()->row();
		  		if($calling_check){
		  				$btn = "";
						$comp++;
		  		}else{
		  			$btn='';
		  		}
		  		
		  	}
		  
		  if(isset($candidate_data->father_name)){$fname = $candidate_data->father_name;}else{$fname="";}
		   if(isset($candidate_data->mother_name)){$mname = $candidate_data->mother_name;}else{$mname="";}
		  
		  	$candidate_information = '<b>Enroll No.: </b> 0000'.$r->user_id.'<br/><b>Full Name: </b>'.$fullname.'<br/><b>Mobile :</b> '.$r->user_mobile.'<br/><b>Father Name: </b>'.$fname.'<br/><b>Mother Name: </b>'.$mname.'<br/><b>DOB: </b>'.$dob.'<br/><b>Email: </b>'.$email.'<br/><b>Gender: </b>'.$gender;

		  	$academic_information = '<b>Course: </b>'.$course.'<br/><b>Study Center: </b>'.$study_center1.'<br/><b>Category: </b>'.$category.'<br/><b>State: </b>'.$parma_state.'<br/><b>City: </b>'.$parma_city.'<br/><b>Enroll DateTime: </b>'.date("d-M-Y", strtotime($r->created_date));


		  	$communication = $this->db->query("SELECT cd.*,admin.admin_name as tname,mode.name as mname, campaign.name as cname,responses.name as rname from calling_data cd inner join admin on admin.admin_id = cd.team_id inner join mode on mode.id = cd.mode inner join campaign on campaign.id = cd.campaign_id inner join responses on responses.id = cd.response_id where cd.user_id='".$r->user_id."' and cd.assign_id='".$r->assign_id."'  order by call_date asc")->result_array();
		  
		  
		  $communicate="";
		  	foreach($communication as $key => $comm) {
		  		$tags="";
				if($comm['tag'] !=''){
		  		$tag_array = explode(',', $comm['tag']);
		  		foreach ($tag_array as $key => $tag) {
		  		$tag_query = $this->db->query("select * from tags where tag_id = $tag")->row();
		  			$tags .= "<span class='badge badge-primary'>".$tag_query->name."</span> &nbsp;";
		  		}
				}
                    
                    $communicate = '<div class="tracking-item"><div class="tracking-date"><b>DateTime: </b>'.date('M d, Y',strtotime($comm['call_date'])).'<span> '.date('h:i A',strtotime($comm['call_time'])).'</span> <a class="btn btn-xs btn-danger exam_status_edit" data-id="'.$comm['id'].'"><i class="fa fa-pencil"></i></a></div>
                    <div class="tracking-content">
                    <b>Campaign: </b><span style="color:red; font-size:18px; padding-bottom:10px;">'.$comm['cname'].'</span><br/>
                    <b>Calling Team: </b>'.$comm['tname'].'<br/>
                    <b>Communication Mode: </b>'.$comm['mname'].'<br/>
                    <b>Call Action: </b>'.$comm['call_action'].'<br/>
                    <b>Call Response: </b>'.$comm['rname'].'<br/>
                    <b>Remark: </b>'.$comm['notes'].'<br/>
                    <b>Tags: </b>'.$tags.'
                    </div>
                    </div>';

                }
			
           $data[] = array(
           		$n.$btn,
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
	                 "data" => $data
	      );


      echo json_encode($result);
      exit();

	}

































	public function create_exam()
	{
			if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}


		
		
		if(isset($_POST['btnsubmit']))
		{

			$fetch =  $this->db->select('*')->from('admin')->where('admin_name',$_POST['admin_name'])->get()->row();

			
  			if(empty($fetch)){

				$data = array(
				'exam_name' => $_POST['exam_name'], 
				'exam_question' => $_POST['exam_question'], 
				'start_datetime' => $_POST['start_datetime'],
				'end_datetime' => $_POST['end_datetime'],
				'no_of_candidate' => $_POST['no_of_candidate'],
			);

			$last_id = $this->db_lib->insert('exam_master',$data,'');

			if($last_id>0)
			{
				 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Insert Successfully!</div>");
				 redirect("exam/create_exam");
			}
			else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Failed!</h4> Something went wrong!</div>");
				redirect("exam/create_exam");
			}

			}else
			{
				setFlash("ViewMsgWarning","<div class='alert alert-warning alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='display: contents;'><i class='icon fa fa-info'></i> Warning!</h4> User already with this name</div>");
				redirect("exam/create_exam");
			}	
		}
		

		$arry_data =  $this->db->select('*')->from('exam_master')->get()->result();
		$this->load->view($this->folder."create_exam",array('result'=>$arry_data));
	}


public function candidate_link_exam()
{
	
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}


			$table='exam_master';
			$fields = "*";
			$whr = "";
			
			
			$result = $this->db_lib->fetchRecords($table,$whr,$fields);
			$this->load->view($this->folder."candidate_link_exam",array('result'=>$result));
}


	public function candidate_details()
	{	

		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}
			
			$table='exam_master';
			$fields = "*";
			$whr = "";
			
			
			$result = $this->db_lib->fetchRecords($table,$whr,$fields);
			$this->load->view($this->folder."candidate_details",array('result'=>$result));
			
	
	}
	




public function filter_exam_link_page()
	{
	
	
	
		$draw = intval($this->input->get("draw"));
      	$start = intval(1);
      	$length = intval(5);

		$whr = $this->input->post('data');
		$missed =  $this->input->post('missed');
	
	
	
		if($missed == 1)
		{
			
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id NOT IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status !='fail' )");
			
		}elseif($missed == 2){
			
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status='pass' )");
			
		}elseif($missed == 3){
			
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status='fail' )");
			
		}else{
			
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2");
			
		}

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

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

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
		  
			
           $data[] = array(
           		' <a data-id="'.$r->user_id.'" class="exam_status btn btn-primary btn-xs">Link to Exam</a>',
				'0000'.$r->user_id??'',
				$examName,
				$course,
				$study_center1,
			    $scoreA.$scoreB.$scoreC,
           		$fullname,
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


public function filter_exam_search()
	{
	

		$draw = intval($this->input->get("draw"));
      	$start = intval(1);
      	$length = intval(5);
		$whr = $this->input->post('data');

		$query = $this->db->query("SELECT um.*,ca.post_date,ce.exam_id,ce.id as linkid,cr.* FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id INNER JOIN candidate_exam ce ON ce.user_id = um.user_id LEFT JOIN candidate_result cr ON cr.link_id=ce.id $whr AND ca.duplicate = 0 AND um.login_status = 2");
			
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

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

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
		  
			$exam = $this->db->select("*")->from("exam_master")->where("id = ".$r->exam_id."")->get()->row();

			$this->db->select('*');    
			$this->db->from('candidate_exam CE');
			$this->db->join('candidate_result CR', 'CE.id = CR.link_id');
			$this->db->where('CR.link_id', $r->linkid);
			$this->db->where('CE.user_id', $r->user_id);
			$link = $this->db->get()->row();

			if($link){

			if($link->attendance == 'present'){$pesent = "checked = checked";} else{$pesent="";}
			if($link->attendance == 'absent'){$absent = "checked = checked";} else{$absent="";}
			if($link->attendance == 'late'){$late = "checked = checked";} else{$late="";}
			if($link->attendance == 'notfill'){$notfill = "checked = checked";} else{$notfill="";}

			if($link->exam_status == 'pass'){$pass = "checked = checked";} else{$pass="";}
			if($link->exam_status == 'fail'){$fail = "checked = checked";} else{$fail="";}
			}else{
				$pesent="";
				$absent="";
				$pass="";
				$fail="";
					$notfill="";
				$late="";
			}

           $data[] = array(
           		$exam->exam_name,
				'0000'.$r->user_id.'<br/><b>'.$course.'</b>',
				$study_center1,
			    $scoreA.$scoreB.$scoreC,
           		$fullname,
                $r->user_mobile??'',
			    $candidate_data->father_name??'',
				'<input type="radio" class="status" name="sts'.$r->linkid.'" data-id="'.$r->linkid.'" data-text="present" '.$pesent.' /> Present &nbsp;&nbsp;<input type="radio" name="sts'.$r->linkid.'" data-id="'.$r->linkid.'" class="status" data-text="absent" '.$absent.' /> Absent &nbsp;&nbsp;<input type="radio" name="sts'.$r->linkid.'" data-id="'.$r->linkid.'" class="status" data-text="late" '.$late.' /> Late Fill &nbsp;&nbsp;<input type="radio" name="sts'.$r->linkid.'" data-id="'.$r->linkid.'" class="status" data-text="notfill" '.$notfill.' /> Not Fill',
				'<input type="radio" class="result" name="'.$r->linkid.'" data-id="'.$r->linkid.'" data-text="pass" '.$pass.'/> Pass &nbsp;&nbsp;<input type="radio" name="'.$r->linkid.'" class="result" data-id="'.$r->linkid.'" data-text="fail" '.$fail.'/> Fail',
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
	->where("link_id = ".$link_id."")
	->get()->result();


	$insert = array(

		'link_id'=> $link_id,
		'attendance' =>$txt,
	);		

	if(empty($data)){

		$last_id = $this->db_lib->insert('candidate_result',$insert,'');
		$array = array('status' => 1, 'msg' => 'Insert' );

	}else{

		$where = "link_id = '$link_id'";
		$update_id = $this->db_lib->update('candidate_result',$insert,$where);
		$array = array('status' => 1, 'msg' => 'Update' );
	} 



	
	echo json_encode($array);


}



public function exam_result()
{
	$link_id = $this->input->post('id');
	$txt = $this->input->post('txt');

	$data = $this->db->select("*")
	->from("candidate_result")
	->where("link_id = ".$link_id."")
	->get()->result();


	$insert = array(

		'link_id'=> $link_id,
		'exam_status' =>$txt,
	);		

	if(empty($data)){

		$last_id = $this->db_lib->insert('candidate_result',$insert,'');
		$array = array('status' => 1, 'msg' => 'Insert' );

	}else{

		$where = "link_id = '$link_id'";
		$update_id = $this->db_lib->update('candidate_result',$insert,$where);
		$array = array('status' => 1, 'msg' => 'Update' );
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
	
	
	
		if($missed == 1)
		{
			
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id NOT IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status !='fail' )");
			
		}elseif($missed == 2){
			
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status='pass' )");
			
		}elseif($missed == 3){
			
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2 AND um.user_id IN ( SELECT followed.user_id FROM candidate_exam AS followed WHERE followed.user_id = um.user_id and followed.exam_status='fail' )");
			
		}else{
			
			$query = $this->db->query("SELECT um.*,ca.post_date FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id $whr AND ca.duplicate = 0 AND um.login_status = 2");
			
		}

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

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

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
		  
			
           $data[] = array(
           		$n.' <input type="checkbox" data-id="'.$r->user_id.'" class="exam_status" '.$checked.' />',
				'0000'.$r->user_id??'',
				$course,
				$study_center1,
			    $scoreA.$scoreB.$scoreC,
           		$fullname,
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



	public function exam_data_save()
	{

		
		$flag = 0; $check=array(); $msg="<ul>";
		foreach ($_POST['exam_id'] as $key => $exam_id) {
			$data = array(
			'user_id' => $_POST['user_id'],
			'exam_id' => $exam_id,
			'created_by' => $this->session->userdata('admin_id'),
			);

			$exam = $this->db->select("*")->from("exam_master")->where("id = ".$exam_id."")->get()->row();

			$check = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$_POST['user_id']."")->where("exam_id = ".$exam_id."")->get()->result();
			if(empty($check)){
				$last_id = $this->db_lib->insert('candidate_exam',$data,'');
				if($last_id){
					$flag = 1; 
					$msg .= "<li style='color:green;'><b>".$exam->exam_name. ",</b> exam has been assigned for this candidate". "</li>";
				}
			}else
			{
				$msg .= "<li style='color:red;'><b>".$exam->exam_name. ",</b> this exam already assign with this candidate". "</li>";
			}
		}

		$msg .="</ul>";
		
		if($flag==1){
			$array = array('status' => 1, 'msg' => $msg );
			echo json_encode($array);
		}else{
			$array = array('status' => 0, 'msg' => $msg );
			echo json_encode($array);
		}

		
	}



	



	public function exam_wise_candidate()
	{
	
		$this->load->view($this->folder."exam_wise_candidate");

	}


	public function exam_wise_candidate_ajax()
	{
		

		$draw = intval($this->input->get("draw"));
      	$start = intval(1);
      	$length = intval(5);
		$exam_id = $this->input->post('exam_id');
		$status = $this->input->post('status');
		if($status=='t'){$whr = '';}
		if($status=='p'){$whr = 'AND cr.attendance='.'"present"';}
		if($status=='a'){$whr = 'AND cr.attendance='.'"absent"';}
		if($status=='pass'){$whr = 'AND cr.exam_status='.'"pass"';}
		if($status=='fail'){$whr = 'AND cr.exam_status='.'"fail"';}


		$query = $this->db->query("SELECT um.*,ca.post_date,ce.exam_id,ce.id as linkid,cr.* FROM candidate_data ca INNER JOIN user_master um ON um.user_id=ca.mobile_verified_id INNER JOIN candidate_exam ce ON ce.user_id = um.user_id LEFT JOIN candidate_result cr ON cr.link_id=ce.id WHERE ce.exam_id='".$exam_id."' $whr AND ca.duplicate = 0 AND um.login_status = 2");
			
      $data = [];
      $n = 0; $pr = 0;
				$ab =0;
				$pp = 0;
				$fl =0;
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

      			if($r->course_id==1){$fullname = "<a href='show_form_bba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_form_mba/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

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
		  
			$exam = $this->db->select("*")->from("exam_master")->where("id = ".$r->exam_id."")->get()->row();

			$this->db->select('*');    
			$this->db->from('candidate_exam CE');
			$this->db->join('candidate_result CR', 'CE.id = CR.link_id');
			$this->db->where('CR.link_id', $r->linkid);
			$this->db->where('CE.user_id', $r->user_id);
			$link = $this->db->get()->row();

			if($link){

			if($link->attendance == 'present'){$pesent = "checked = checked"; $pr +=1;} else{$pesent=""; }
			if($link->attendance == 'absent'){$absent = "checked = checked"; $ab +=1;} else{$absent=""; }

			if($link->exam_status == 'pass'){$pass = "checked = checked"; $pp+=1;} else{$pass=""; }
			if($link->exam_status == 'fail'){$fail = "checked = checked"; $fl+=1;} else{$fail=""; }
			}else{
				$pesent="";
				$absent="";
				$pass="";
				$fail="";
				// $pr = 0;
				// $ab =0;
				// $pp = 0;
				// $fl =0;
			}

           $data[] = array(
           		
				$n,
				'0000'.$r->user_id??'',
				$exam->exam_name,
				$course,
				$study_center1,
			    $scoreA.$scoreB.$scoreC,
           		$fullname,
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
	                 "present"  => $pr,
	                 "absent" => $ab,
	                 "pass" => $pp,
	                 "fail" =>$fl,
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
        $this->db->select('a.admin_name, am.id as assignment_id, am.assignment_name as assignment_title, am.assignment_start as assigned_date');
        $this->db->from('assignment aa');
        $this->db->join('assignment_master am', 'aa.assignment_id = am.id');
        $this->db->join('admin a', 'a.admin_id = aa.team_id');
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
        $this->db->order_by('am.assignment_start', 'ASC');
        $assignments = $this->db->get()->result();
        $user = $this->db->get('admin')->result();
        $this->load->view($this->folder . "team_report", array(
            'assignments' => $assignments,
            'user' => $user
        ));
    }
	
	
	 public function filter_team()
    {
        $team_member_id = $this->input->post('team_member');
        $from_date = $this->input->post('from');
        $to_date = $this->input->post('to');
        $this->db->select('a.admin_name, am.id as assignment_id, am.assignment_name as assignment_title, am.assignment_start as assigned_date');
        $this->db->from('assignment aa');
        $this->db->join('assignment_master am', 'aa.assignment_id = am.id');
        $this->db->join('admin a', 'a.admin_id = aa.team_id');
        if (!empty($team_member_id)) {
            $this->db->where('a.admin_id', $team_member_id);
        }
        if (!empty($from_date)) {
            $this->db->where('am.assignment_start >=', date('Y-m-d', strtotime($from_date)));
        }
        if (!empty($to_date)) {
            $this->db->where('am.assignment_start <=', date('Y-m-d', strtotime($to_date)));
        }
        $this->db->order_by('am.assignment_start', 'ASC');
        $assignments = $this->db->get()->result();
        // Prepare grouped data same as in view
        $grouped = [];
        foreach ($assignments as $a) {
            $date = $a->assigned_date;
            $key = $a->admin_name . '_' . $date;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'admin_name' => $a->admin_name,
                    'date' => $date,
                    'assignments' => []
                ];
            }
            $assignment_id = $a->assignment_id;
            if (!isset($grouped[$key]['assignments'][$assignment_id])) {
                $grouped[$key]['assignments'][$assignment_id] = $a->assignment_title;
            }
        }
        $sno = 1;
        $html = '';
        foreach ($grouped as $entry) {
            $html .= '<tr>';
            $html .= '<td>' . $sno++ . '</td>';
            $html .= '<td>' . $entry['admin_name'] . '</td>';
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
        $query = $this->db->query("SELECT um.*,aa.created_at,aa.assign_id FROM assignment aa INNER JOIN assignment_master am ON am.id = aa.assignment_id INNER JOIN user_master um ON um.user_id=aa.user_id WHERE am.id = $assignment_id;");
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
            $candidate_information = '<b>Enroll No.: </b> 0000' . $r->user_id . '<br/><b>Full Name: </b>' . $fullname . '<br/><b>Mobile :</b> ' . $r->user_mobile . '<br/><b>Father Name: </b>' . $candidate_data->father_name . '<br/><b>Mother Name: </b>' . $candidate_data->mother_name . '<br/><b>DOB: </b>' . $dob . '<br/><b>Email: </b>' . $email . '<br/><b>Gender: </b>' . $gender;
            $academic_information = '<b>Course: </b>' . $course . '<br/><b>Study Center: </b>' . $study_center1 . '<br/><b>Category: </b>' . $category . '<br/><b>State: </b>' . $parma_state . '<br/><b>City: </b>' . $parma_city . '<br/><b>Enroll DateTime: </b>' . date("d-M-Y", strtotime($r->created_date));
            $communication = $this->db->query("SELECT cd.*,admin.admin_name as tname,mode.name as mname, campaign.name as cname,responses.name as rname from calling_data cd inner join admin on admin.admin_id = cd.team_id inner join mode on mode.id = cd.mode inner join campaign on campaign.id = cd.campaign_id inner join responses on responses.id = cd.response_id where cd.user_id='" . $r->user_id . "' order by call_date asc")->result_array();
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
   
	
	public function get_calling_data(){

		$id = $this->input->post('id');
		$callingdata = $this->db->query("SELECT calling_data.*,assignment.status FROM calling_data INNER JOIN assignment on assignment.assign_id = calling_data.assign_id where calling_data.id=$id")->row();
		echo json_encode($callingdata);

	}
	

	
}	