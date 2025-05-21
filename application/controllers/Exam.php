<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Controller Class
 *
 * @author		ImpelPro Dev Team
**/

class Exam extends CI_Controller {
	
	public $folder = "exam/";

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
	
	public function index()
	{
		redirect('admin/login');
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



	public function delete_exam()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$delete = $this->db_lib->delete("exam_master",$where);
		if($delete){

			echo 1;
		}

	}

	public function get_exam()
	{
		$id = $_POST['id'];
		$where = "id='$id'";
		$get = $this->db_lib->fetchRecords("exam_master",$where,'*');
		
		echo json_encode($get);
	}


	public function edit_exam()
	{
		$id = $_POST['edit_id'];
		
		$where = "id = '$id'";
		$update_data = array(
			'exam_name' => $_POST['exam_name'], 
			'exam_question' => $_POST['exam_question'], 
			'start_datetime' => $_POST['start_datetime'],
			'end_datetime' => $_POST['end_datetime'],
			'no_of_candidate' => $_POST['no_of_candidate'],
		);
		$rst = $this->db_lib->update('exam_master',$update_data,$where);

		if($rst)
		{
			 setFlash("ViewMsgSuccess","<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><h4 style='    display: contents;'><i class='icon fa fa-info'></i> Success!</h4> Record Update Successfully!</div>");
			 redirect("exam/create_exam");
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
				$parma_pincode = $candidate_data->parma_pincode;
				$corre_address = $candidate_data->corre_appertment." ".$candidate_data->corre_colony." ".$candidate_data->corre_area;
				$corre_pincode = $candidate_data->corre_pincode;


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
				//$exam->exam_name,
				$course,
				$study_center1,
			    //$scoreA.$scoreB.$scoreC,
           		$fullname,
                $r->user_mobile??'',
			    $candidate_data->father_name??'',
			    $candidate_data->father_mobile??'',
			    $candidate_data->mother_name??'',
			    $candidate_data->mather_mobile??'',
			    $dob,
                $email,
                $gender,
				$category,
				$candidate_data->religion??'',
                '<b>State:</b>'. $parma_state.'<br/><b>City:</b> '.$parma_city,
			    $parma_address.'<br/><b>Pincode: </b>'.$parma_pincode,
                '<b>State:</b>'. $corre_state.'<br/><b>City:</b> '.$corre_city,
			    $corre_address.'<br/><b>Pincode: </b>'.$corre_pincode,
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
   
	

	
}	