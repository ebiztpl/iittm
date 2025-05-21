<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); error_reporting(0);

/**
 * CredtRating Controller Class
 *
 * @author		ImpelPro Dev Team
**/

class Journey extends CI_Controller {
	
	public $folder = "journey/";

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
	
	

	public function student_journey()
	{
		if(!$this->usermodel->hasLoggedIn()){
			redirect("admin/login");
		}

		$table='exam_master';
		$fields = "*";
		$whr = "";
		
		
		$exam = $this->db_lib->fetchRecords($table,$whr,$fields);

		$this->load->view($this->folder."student_journey",array('exam'=>$exam));
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
	




public function getdata(){
	
	
	$draw = intval($this->input->get("draw"));
  	$start = intval(1);
  	$length = intval(5);

		
	$query = $this->db->query("SELECT * from candidate_exam ce 
		INNER JOIN user_master um ON um.user_id=ce.user_id  
		INNER JOIN candidate_data cd ON cd.mobile_verified_id=um.user_id  
	    group by ce.user_id");

    $data = [];
    $n = 0;
    foreach($query->result() as $r) {

      		$candidate_data = $this->db->select("*")->from("candidate_data")->where("mobile_verified_id = ".$r->user_id." AND duplicate = 0")->get()->row(); 
		  
		  	  $exam1 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",1)->get()->row();
		  	  if($exam1)
		  	  {
		  	  	 $examResult1 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam1->id."")->get()->row();
		  	  	 if($examResult1->exam_status=='pass'){$css="success";}
		  	  	 if($examResult1->exam_status=='fail'){$css="danger";}

		  	  	 if($examResult1->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult1->attendance=='present'){$csss="primary";}
		  	  	 $attendance1 = '<span class="badge bg-'.$csss.'">'.$examResult1->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult1->exam_status.'</span>';
		  	  }else{
		  	  	$attendance1="-";
		  	  }


		  	  $exam2 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",3)->get()->row();
		  	  if($exam2)
		  	  {
		  	  	 $examResult2 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam2->id."")->get()->row();
		  	  	 if($examResult2->exam_status=='pass'){$css="success";}
		  	  	 if($examResult2->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult2->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult2->attendance=='present'){$csss="primary";}
		  	  	 $attendance2 = '<span class="badge bg-'.$csss.'">'.$examResult2->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult2->exam_status.'</span>';
		  	  }else{
		  	  	$attendance2="-";
		  	  }


		  	  $exam3 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",4)->get()->row();
		  	  if($exam3)
		  	  {
		  	  	 $examResult3 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam3->id."")->get()->row();
		  	  	 if($examResult3->exam_status=='pass'){$css="success";}
		  	  	 if($examResult3->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult3->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult3->attendance=='present'){$csss="primary";}
		  	  	 $attendance3 = '<span class="badge bg-'.$csss.'">'.$examResult3->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult3->exam_status.'</span>';
		  	  }else{
		  	  	$attendance3="-";
		  	  }


		  	  $exam4 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",5)->get()->row();
		  	  if($exam4)
		  	  {
		  	  	 $examResult4 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam4->id."")->get()->row();
		  	  	 if($examResult4->exam_status=='pass'){$css="success";}
		  	  	 if($examResult4->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult4->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult4->attendance=='present'){$csss="primary";}
		  	  	 $attendance4 = '<span class="badge bg-'.$csss.'">'.$examResult4->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult4->exam_status.'</span>';
		  	  }else{
		  	  	$attendance4="-";
		  	  }
		
		
			  $exam5 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",6)->get()->row();
		  	  if($exam5)
		  	  {
		  	  	 $examResult5 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam5->id."")->get()->row();
		  	  	 if($examResult5->exam_status=='pass'){$css="success";}
		  	  	 if($examResult5->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult5->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult5->attendance=='present'){$csss="primary";}
		  	  	 $attendance5 = '<span class="badge bg-'.$csss.'">'.$examResult5->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult5->exam_status.'</span>';
		  	  }else{
		  	  	$attendance5="-";
		  	  }
		
		
			  $exam6 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",7)->get()->row();
		  	  if($exam6)
		  	  {
		  	  	 $examResult6 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam6->id."")->get()->row();
		  	  	 if($examResult6->exam_status=='pass'){$css="success";}
		  	  	 if($examResult6->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult6->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult6->attendance=='present'){$csss="primary";}
		  	  	 $attendance6 = '<span class="badge bg-'.$csss.'">'.$examResult6->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult6->exam_status.'</span>';
		  	  }else{
		  	  	$attendance6="-";
		  	  }
		
		
			  $exam7 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",8)->get()->row();
		  	  if($exam7)
		  	  {
		  	  	 $examResult7 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam7->id."")->get()->row();
		  	  	 if($examResult7->exam_status=='pass'){$css="success";}
		  	  	 if($examResult7->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult7->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult7->attendance=='present'){$csss="primary";}
		  	  	 $attendance7 = '<span class="badge bg-'.$csss.'">'.$examResult7->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult7->exam_status.'</span>';
		  	  }else{
		  	  	$attendance7="-";
		  	  }
		
			$exam8 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",9)->get()->row();
		  	  if($exam8)
		  	  {
		  	  	 $examResult8 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam8->id."")->get()->row();
		  	  	 if($examResult8->exam_status=='pass'){$css="success";}
		  	  	 if($examResult8->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult8->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult8->attendance=='present'){$csss="primary";}
		  	  	 $attendance8 = '<span class="badge bg-'.$csss.'">'.$examResult8->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult8->exam_status.'</span>';
		  	  }else{
		  	  	$attendance8="-";
		  	  }
		
			  $exam9 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",10)->get()->row();
		  	  if($exam9)
		  	  {
		  	  	 $examResult9 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam9->id."")->get()->row();
		  	  	 if($examResult9->exam_status=='pass'){$css="success";}
		  	  	 if($examResult9->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult9->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult9->attendance=='present'){$csss="primary";}
		  	  	 $attendance9 = '<span class="badge bg-'.$csss.'">'.$examResult9->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult9->exam_status.'</span>';
		  	  }else{
		  	  	$attendance9="-";
		  	  }
		
		
		$exam10 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",11)->get()->row();
		  	  if($exam10)
		  	  {
		  	  	 $examResult10 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam10->id."")->get()->row();
		  	  	 if($examResult10->exam_status=='pass'){$css="success";}
		  	  	 if($examResult10->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult10->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult10->attendance=='present'){$csss="primary";}
		  	  	 $attendance10 = '<span class="badge bg-'.$csss.'">'.$examResult10->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult10->exam_status.'</span>';
		  	  }else{
		  	  	$attendance10="-";
		  	  }
		
		
		$exam11 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",12)->get()->row();
		  	  if($exam11)
		  	  {
		  	  	 $examResult11 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam11->id."")->get()->row();
		  	  	 if($examResult11->exam_status=='pass'){$css="success";}
		  	  	 if($examResult11->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult11->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult11->attendance=='present'){$csss="primary";}
		  	  	 $attendance11 = '<span class="badge bg-'.$csss.'">'.$examResult11->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult11->exam_status.'</span>';
		  	  }else{
		  	  	$attendance11="-";
		  	  }
		
		
		$exam12 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",13)->get()->row();
		  	  if($exam12)
		  	  {
		  	  	 $examResult12 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam12->id."")->get()->row();
		  	  	 if($examResult12->exam_status=='pass'){$css="success";}
		  	  	 if($examResult12->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult12->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult12->attendance=='present'){$csss="primary";}
		  	  	 $attendance12 = '<span class="badge bg-'.$csss.'">'.$examResult12->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult12->exam_status.'</span>';
		  	  }else{
		  	  	$attendance12="-";
		  	  }
		
		
		$exam13 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",14)->get()->row();
		  	  if($exam13)
		  	  {
		  	  	 $examResult13 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam13->id."")->get()->row();
		  	  	 if($examResult13->exam_status=='pass'){$css="success";}
		  	  	 if($examResult13->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult13->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult13->attendance=='present'){$csss="primary";}
		  	  	 $attendance13 = '<span class="badge bg-'.$csss.'">'.$examResult13->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult13->exam_status.'</span>';
		  	  }else{
		  	  	$attendance13="-";
		  	  }
		
		
		$exam14 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",15)->get()->row();
		  	  if($exam14)
		  	  {
		  	  	 $examResult14 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam14->id."")->get()->row();
		  	  	 if($examResult14->exam_status=='pass'){$css="success";}
		  	  	 if($examResult14->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult14->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult14->attendance=='present'){$csss="primary";}
		  	  	 $attendance14 = '<span class="badge bg-'.$csss.'">'.$examResult14->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult14->exam_status.'</span>';
		  	  }else{
		  	  	$attendance14="-";
		  	  }
		
		
		$exam15 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$r->user_id."")->where("exam_id",16)->get()->row();
		  	  if($exam15)
		  	  {
		  	  	 $examResult15 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam15->id."")->get()->row();
		  	  	 if($examResult15->exam_status=='pass'){$css="success";}
		  	  	 if($examResult15->exam_status=='fail'){$css="danger";}
		  	  	 if($examResult15->attendance=='absent'){$csss="danger";}
		  	  	 if($examResult15->attendance=='present'){$csss="primary";}
		  	  	 $attendance15 = '<span class="badge bg-'.$csss.'">'.$examResult15->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult15->exam_status.'</span>';
		  	  }else{
		  	  	$attendance15="-";
		  	  }


      			$fullname =""; 
      			$email ="";  
      			$gender="";
	      		
				if($r->course_id==1){$course = "BBA";}
				if($r->course_id==2){$course = "MBA";}

      			if($r->course_id==1){$fullname = "<a href='show_journey/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}
			
				if($r->course_id==2){$fullname = "<a href='show_journey/$r->user_id' target='_blank'>".$candidate_data->first_name." ".$candidate_data->middle_name." ".$candidate_data->last_name."</a>";}

				$email = $candidate_data->email_id;
				$gender = $candidate_data->gender;
				$study_center1 = $candidate_data->study_centre_1;
				$category = $candidate_data->category;
					
		
      		$n++;
      		$amount = ($r->amount)/100;
      	
		 
            $data[] = array(
           		$n,
				'0000'.$r->user_id??'',
				$course,
				$study_center1,
           		$fullname ."(".$gender.")",
                $r->user_mobile??'',
			 	// $candidate_data->father_name??'',
				// $category,
				date("d-M-Y", strtotime($candidate_data->post_date??'')),
				$amount,
				$attendance1??'',
				$attendance2??'',
				$attendance3??'',
				$attendance4??'',
				$attendance5??'',
				$attendance6??'',
				$attendance7??'',
				$attendance8??'',
				$attendance9??'',
				$attendance10??'',
				$attendance11??'',
				$attendance12??'',
				$attendance13??'',
				$attendance14??'',
				$attendance15??''
				
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

	public function show_journey(){

		$student_id = $this->uri->segment(3);

		$query = $this->db->query("SELECT um.*,cd.* from candidate_exam ce 
		INNER JOIN user_master um ON um.user_id=ce.user_id  
		INNER JOIN candidate_data cd ON cd.mobile_verified_id = um.user_id 
		WHERE ce.user_id = $student_id and cd.duplicate=0");

		$r = $query->result();

      	if($r[0]->course_name==1){$course = "BBA";}
		if($r[0]->course_name==2){$course = "MBA";}

		$fullname = "".$r[0]->first_name." ".$r[0]->middle_name." ".$r[0]->last_name."";


		$table='exam_master';
		$fields = "*";
		$whr = "";
		$exam = $this->db_lib->fetchRecords($table,$whr,$fields);


		// $table='calling_data';
		// $fields = "*";
		// $whr = "user_id='$student_id'";
		// $communication = $this->db_lib->fetchRecords($table,$whr,$fields);

		$communication = $this->db->query("SELECT cd.*,admin.admin_name as tname,mode.name as mname, campaign.name as cname,responses.name as rname from calling_data cd inner join admin on admin.admin_id = cd.team_id inner join mode on mode.id = cd.mode inner join campaign on campaign.id = cd.campaign_id inner join responses on responses.id = cd.response_id where cd.user_id='$student_id' order by call_date asc")->result_array();

		$this->load->view($this->folder."details", array( 
			'user_id' => $student_id,
			'register'=> $r[0]->created_date,
			'complete'=> $r[0]->post_date, 
			'candidate_name' => $fullname,
			'course' => $course,
			'fee' => $r[0]->amount/100,
			'exam' => $exam,
			'communication' => $communication

		));
	}



	public function exam_candidate_report()
	{
		$gwalior =  $this->db->query("SELECT count(*) as count, user_master.course_id from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Gwalior' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate = 0 group by user_master.course_id")->result();

		foreach ($gwalior as $key => $gwl) {
			if($gwl->course_id == 1){$bba_gwl = $gwl->count; }
			if($gwl->course_id == 2){$mba_gwl = $gwl->count; }
		}

		$noida =  $this->db->query("SELECT count(*) as count, user_master.course_id from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Noida' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate = 0 group by user_master.course_id")->result();

		foreach ($noida as $key => $noi) {
			if($noi->course_id == 1){$bba_noi = $noi->count; }
			if($noi->course_id == 2){$mba_noi = $noi->count; }
		}
		

		$nellor =  $this->db->query("SELECT count(*) as count, user_master.course_id from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Nellore' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate = 0 group by user_master.course_id")->result();

		foreach ($nellor as $key => $nell) {
			if($nell->course_id == 1){$bba_nell = $nell->count; }
			if($nell->course_id == 2){$mba_nell = $nell->count; }
		}


		$Bhubaneswar =  $this->db->query("SELECT count(*) as count, user_master.course_id from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Bhubaneswar' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate = 0 group by user_master.course_id")->result();

		foreach ($Bhubaneswar as $key => $Bhub) {
			if($Bhub->course_id == 1){$bba_Bhub = $Bhub->count; }
			if($Bhub->course_id == 2){$mba_Bhub = $Bhub->count; }
		}


		$Goas =  $this->db->query("SELECT count(*) as count, user_master.course_id from user_master LEFT JOIN candidate_data ON candidate_data.mobile_verified_id = user_master.user_id WHERE candidate_data.study_centre_1 ='Goa' and user_master.login_status=2 and user_master.razorpay_trans_id !='' and candidate_data.duplicate = 0 group by user_master.course_id")->result();

		foreach ($Goas as $key => $Goa) {
			if($Goa->course_id == 1){$bba_Goa = $Goa->count; }
			if($Goa->course_id == 2){$mba_Goa = $Goa->count; }
		}
	

		$this->load->view($this->folder."exam_candidate_report",
			array('application'=> array('mba'=>array($mba_gwl,$mba_noi,$mba_nell,$mba_Bhub,$mba_Goa),'bba'=>array($bba_gwl,$bba_noi,$bba_nell,$bba_Bhub,$bba_Goa)))
		);
	}
}	