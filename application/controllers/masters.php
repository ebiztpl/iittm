<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CredtRating Controller Class
 *
 * @author		ImpelPro Dev Team
**/

class Masters extends CI_Controller {
	
	public $folder = "masters/";

	function __construct()
	{
		parent::__construct();
        $this->load->helper('form');
        $this->load->helper('general_helper');
		$this->load->model("accountmodel");
		$this->load->model("usermodel");

		date_default_timezone_set("Asia/Calcutta");
	}
	//////Start Type Setting/////////
	public function type() {
		$this->load->view($this->folder."type");
	}
	public function getAlltype(){
		$table='type_master'; $strWhere=''; $fields='*';
		$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
		//print_r($result);
		$res=array();$result1=array();
		if($result!=""){
			foreach($result as $row){
				$data=array();
				
				$data['id']=$row['type_id'];
				$data['name']=$row['type_name'];
				$data['postdate']=$this->db_lib->Dateformater($row['post_date']);
				$rowdata=htmlspecialchars(json_encode($row));
				$edit="";$delete="";
				
				$edit="<a rel='tooltip'  onclick=\"angular.element(this).scope().showAddTypeModal(".$rowdata.")\"  href='#' data-original-title='Edit' class='btn btn-info btn-circle btn-xs '><i class='fa fa-edit' data-toggle='tooltip' title='Edit'></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;";
			
				$delete="<a  onclick='angular.element(this).scope().getId(\"".$row['type_id']."\")' data-toggle='modal' data-target='#confirm' href='#' data-original-title='Delete' class='btn btn-info btn-circle btn-xs'><i class='fa fa-trash' data-toggle='tooltip' title='Delete'></i></a>";
				$data['action']=$edit.$delete;
				$res[]=$data;
			}
		}
		$result1['data']=$res;
		echo json_encode($result1); 
		return false; 
		//$this->load->view($this->folder."type",array("data"=>$result));
	}
	public function AddEditType(){
		$type_name = isset($_POST['type_name'])?$_POST['type_name']:"";
	 	$type_id =isset($_POST['type_id'])?$_POST['type_id']:"";
		 if($type_id ==0 && $type_name!="")
		{
			$table='type_master'; $strWhere='type_name='.'"'.$type_name.'"'; $fields='type_id';
			$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
			if($result){
				$status=false;
				$msg='Type already exist!';
			}else{
				$arrData = array(
						'type_name' => $type_name,
						'post_date' => date("Y-m-d H:i:s")
				);
				$inst = $this->db_lib->insert('type_master',$arrData);
				if($inst>0){
					$status=true;
					$msg='Insert successfully!';
				}else{
					$status=false;
					$msg='There is some problem';
				}
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
			//if($inst>0) $this->load->view($this->folder."type");
		}else if($type_id!=0 && $type_name!=""){
			$table='type_master'; $strWhere='type_id!='.$type_id.' and type_name='.'"'.$type_name.'"'; $fields='type_id';
			$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
			if($result){
				$status=false;
				$msg='Type already exist!';
			}else{
				$arrData = array(
						'type_id' => $type_id,
						'type_name' => $type_name
				);
				$strWhere="type_id=".$type_id;
				$update = $this->db_lib->update('type_master',$arrData,$strWhere);
				if($update>0){
					$status=true;
					$msg='Update successfully!';
				}else{
					$status=false;
					$msg='There is some problem';
				}
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
		//print_r($result);
	}
	public function deleteType($type_id){
		
		if($type_id!=0){
			$table='type_master'; $strWhere='type_id='.$type_id;
			$delet=$this->db_lib->delete($table,$strWhere);
			if($delet==1){
				$status=true;
				$msg='Deleted successfully!';
			}else{
				$status=false;
				$msg='There is some problem';
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
	}
	/////End Type Setting////////
	////////Start Meals Setting//////////
	public function mealsdata(){
		$table='meal_plan'; $strWhere=''; $fields='*';
		$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
		//print_r($result);
		$res=array();$result1=array();
		if($result!=""){
			foreach($result as $row){
				$data=array();
				
				$data['id']=$row['plan_id'];
				$data['name']=$row['plan_name'];
				$data['time_from']="";
				$data['time_to']="";
				$res[]=$data;
			}
		}
		$result1['data']=$res;
		echo json_encode($result1); 
		return false; 
		//$this->load->view($this->folder."type",array("data"=>$result));
	}
	
	public function Meals() {
		$this->load->view($this->folder."meals");
	}
	public function getAllMeals(){
		$table='meal_master'; $strWhere=''; $fields='*';
		$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
		//print_r($result);
		$res=array();$result1=array();
		if($result!=""){
			foreach($result as $row){
				$data=array();
				
				$data['id']=$row['meal_id'];
				$data['name']=$row['meal_name'];
				$data['valid_from']=$this->db_lib->Dateformater($row['valid_from']);
				$data['valid_to']=$this->db_lib->Dateformater($row['valid_to']);
				$data['amount']=$row['amount'];
				/////Get Meal Type Name///////
				$meals=explode(',',$row['meals']);
				$mealsdata='';
				for($i=0;$i<count($meals);$i++){
				$strwhere1="plan_id=".$meals[$i];$fieldname='plan_name';
					if($mealsdata=="")
						$mealsdata =$this->db_lib->getName('meal_plan',$strwhere1,$fieldname);
					else
						$mealsdata.=', '.$this->db_lib->getName('meal_plan',$strwhere1,$fieldname);
				}
				$data['meals']=$mealsdata;
				/////Get Type Name///////
				$strwhere1="type_id=".$row['meal_type'];$fieldname='type_name';
				$data['meal_type']=$this->db_lib->getName('type_master',$strwhere1,$fieldname);
				$rowdata=htmlspecialchars(json_encode($row));
				$edit="";$delete="";
				
				$edit="<a rel='tooltip'  onclick=\"angular.element(this).scope().showAddMealModal(".$rowdata.")\"  href='#' data-original-title='Edit' class='btn btn-info btn-circle btn-xs '><i class='fa fa-edit' data-toggle='tooltip' title='Edit'></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;";
			
				$delete="<a  onclick='angular.element(this).scope().getId(\"".$row['meal_id']."\")' data-toggle='modal'  data-target='#confirm' href='#' data-original-title='Delete' class='btn btn-info btn-circle btn-xs'><i class='fa fa-trash' data-toggle='tooltip' title='Delete'></i></a>";
				$data['action']=$edit.$delete;
				$res[]=$data;
			}
		}
		$result1['data']=$res;
		echo json_encode($result1); 
		return false; 
		//$this->load->view($this->folder."type",array("data"=>$result));
	}
	public function AddEditMealPlan(){
		$meal_name = isset($_POST['meal_name'])?$_POST['meal_name']:"";
	 	$valid_from =isset($_POST['valid_from'])?$this->db_lib->dateformatedatabase($_POST['valid_from']):"";
	 	$valid_to =isset($_POST['valid_to'])?$this->db_lib->dateformatedatabase($_POST['valid_to']):"";
	 	$amount =isset($_POST['amount'])?$_POST['amount']:"";
	 	$mealnames =isset($_POST['mealnames'])?implode(',',$_POST['mealnames']):"";
	 	$meal_type =isset($_POST['meal_type'])?$_POST['meal_type']:"";
	 	$meal_id =isset($_POST['meal_id'])?$_POST['meal_id']:"";
	 	
		if($meal_id ==0 && $meal_name!="") {
			$arrData = array(
				'meal_name' =>$meal_name,
				'valid_from' =>$valid_from,
				'valid_to' =>$valid_to,
				'amount' =>$amount,
				'meals' =>$mealnames,
				'meal_type' =>$meal_type,
				'created_date' => date("Y-m-d H:i:s")
			);
			$inst = $this->db_lib->insert('meal_master',$arrData);
			if($inst>0){
				$status=true;
				$msg='Insert successfully!';
			}else{
				$status=false;
				$msg='There is some problem';
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
		else if($meal_id!=0 && $meal_name!=""){
			$arrData = array(
				'meal_id' => $meal_id,
				'meal_name' =>$meal_name,
				'valid_from' =>$valid_from,
				'valid_to' =>$valid_to,
				'amount' =>$amount,
				'meals' =>$mealnames,
				'meal_type' =>$meal_type,
				'modified_date' => date("Y-m-d H:i:s")
			);
			$strWhere="meal_id=".$meal_id;
			$update = $this->db_lib->update('meal_master',$arrData,$strWhere);
			if($update>0){
				$status=true;
				$msg='Update successfully!';
			}else{
				$status=false;
				$msg='There is some problem';
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
		//print_r($result);
	}
	public function deleteMealPlan($meal_id){
		
		if($meal_id!=0){
			$table='meal_master'; $strWhere='meal_id='.$meal_id;
			$delet=$this->db_lib->delete($table,$strWhere);
			if($delet==1){
				$status=true;
				$msg='Deleted successfully!';
			}else{
				$status=false;
				$msg='There is some problem';
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
	}
	////////End Meals Setting//////////
	////////Start Meal Time Slot Setting//////////
	public function mealtimeslot(){
		$this->load->view($this->folder."meal_time_slot");
	}
	public function getAllMealTimeSlot(){
		$table='meal_time_slot_master'; $strWhere=''; $fields='*';
		$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
		//print_r($result);
		$res=array();$result1=array();
		if($result!=""){
			foreach($result as $row){
				$data=array();
				
				$data['id']=$row['slot_id'];
				$data['name']=$row['slot_name'];
				$data['time_from']=$row['time_from'];
				$data['time_to']=$row['time_to'];
				$strwhere1="plan_id=".$row['plan_id'];$fieldname='plan_name';
				$data['plan_name']=$mealsdata =$this->db_lib->getName('meal_plan',$strwhere1,$fieldname);
				$rowdata=htmlspecialchars(json_encode($row));
				$edit="";$delete="";
				
				$edit="<a rel='tooltip'  onclick=\"angular.element(this).scope().showAddTypeModal(".$rowdata.")\"  href='#' data-original-title='Edit' class='btn btn-info btn-circle btn-xs '><i class='fa fa-edit'></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;";
			
				$delete="<a rel='tooltip' title='Delete' onclick='angular.element(this).scope().getId(\"".$row['slot_id']."\")' data-toggle='modal' data-toggle='tooltip' data-target='#confirm' href='#' data-original-title='Delete' class='btn btn-info btn-circle btn-xs'><i class='fa fa-trash'></i></a>";
				$data['action']=$edit.$delete;
				$res[]=$data;
			}
		}
		$result1['data']=$res;
		echo json_encode($result1); 
		return false; 
		//$this->load->view($this->folder."type",array("data"=>$result));
	}
	public function AddMealTimeSlot(){
		$slottype = isset($_POST['slottype'])?$_POST['slottype']:"";
	 	$slotarr =json_decode($_REQUEST['mealtype']);
		
		if($slottype!="") {
			
			foreach($slotarr as $value){
				$from=$value->time_from;
				$to=$value->time_to;
				$planid=$value->id;
				$arrData = array(
				'slot_name' =>$slottype,
				'plan_id' =>$planid,
				'time_from' =>$from,
				'time_to' =>$to,
				'created_date' => date("Y-m-d H:i:s")
			);
			$inst = $this->db_lib->insert('meal_time_slot_master',$arrData);
			}
			
			if($inst>0){
				$status=true;
				$msg='Insert successfully!';
			}else{
				$status=false;
				$msg='There is some problem';
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
	}
	////////End Meal Time Slot Setting//////////
	////////Start Payment Recived Setting//////////
	public function payment_recived(){
		$this->load->view($this->folder."payment_recived");
	}
	public function getUserData($mobile){
		$table='user_master'; $strWhere='user_mobile='.'"'.$mobile.'"'; $fields='user_name,user_planid,user_id';
		$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
		$res=array();$result1=array();
		if($result!=""){
			foreach($result as $row){
				$data=array();
				$data['status']=true;
				$data['user_id']=$row['user_id'];
				$data['user_name']=$row['user_name'];
				$data['plan_id']=$row['user_planid'];
				$res['userData']=$data;
			}
		}else{
			$data=array();
			$data['status']=false;
			$res['userData']=$data;
		}
		$result1['data']=$res;
		echo json_encode($result1); 
	}
	public function getAllPayment(){
		$table='payment_master'; $strWhere=''; $fields='*';
		$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
		//print_r($result);
		$res=array();$result1=array();
		if($result!=""){
			foreach($result as $row){
				$data=array();
				
				$data['id']=$row['payment_id'];
				/////Get User Data Name///////
				$strwhere1="user_id=".$row['user_id'];$fieldname='user_name'; $fieldmob='user_mobile'; $fieldplan='user_planid';
				$data['name']=$this->db_lib->getName('user_master',$strwhere1,$fieldname);
				$data['mobile']=$this->db_lib->getName('user_master',$strwhere1,$fieldmob);
				$plan=$this->db_lib->getName('user_master',$strwhere1,$fieldplan);
				/////Get Meal Plan Name//////////
				$strwhere1="meal_id=".$plan; $fieldplan='meal_name';
				$data['userplan']=$this->db_lib->getName('meal_master',$strwhere1,$fieldplan);
				if($row['paidby']==1)
					$data['paidby']="Cash";
				else if($row['paidby']==2)
					$data['paidby']="Credit";
				else if($row['paidby']==3)
					$data['paidby']="Paytm";
				
				$data['transaction_id']=$row['transaction_id'];
				if($row['pay_month_date']==1)
					$data['pay_month_date']="Monthly";
				if($row['pay_month_date']==2)
					$data['pay_month_date']="Day";
				
				$data['paymentmonth']=$row['paymentmonth'];
				
				$rowdata=htmlspecialchars(json_encode($row));
				$edit="";$delete="";
				
				$edit="<a rel='tooltip'  onclick=\"angular.element(this).scope().showAddPaymentModal(".$rowdata.")\"  href='#' data-original-title='Edit' class='btn btn-info btn-circle btn-xs '><i class='fa fa-edit' data-toggle='tooltip' title='Edit'></i></a>&nbsp;&nbsp;|&nbsp;&nbsp;";
			
				$delete="<a  onclick='angular.element(this).scope().getId(\"".$row['payment_id']."\")' data-toggle='modal'  data-target='#confirm' href='#' data-original-title='Delete' class='btn btn-info btn-circle btn-xs'><i class='fa fa-trash' data-toggle='tooltip' title='Delete'></i></a>";
				$data['action']=$edit.$delete;
				$res[]=$data;
			}
		}
		$result1['data']=$res;
		echo json_encode($result1); 
		return false; 
		//$this->load->view($this->folder."type",array("data"=>$result));
	}
	
	public function AddPayment(){
		$user_id = isset($_POST['user_id'])?$_POST['user_id']:"";
	 	$mobile =isset($_POST['mobile'])?$_POST['mobile']:"";
	 	$username =isset($_POST['username'])?$_POST['username']:"";
	 	$paytype =isset($_POST['paytype'])?$_POST['paytype']:"";
		$monthpay =isset($_POST['monthpay'])?$_POST['monthpay']:"";
		$datepay =isset($_POST['datepay'])?$_POST['datepay']:"";
		if($paytype==1)
			$submitdate=date('Y-m-d', strtotime($monthpay));
		 else
			$submitdate=$this->db_lib->dateformatedatabase($datepay);
		
		$meal_plan =isset($_POST['meal_plan'])?$_POST['meal_plan']:"";
	 	$amount =isset($_POST['amount'])?$_POST['amount']:"";
	 	$paidto =isset($_POST['paidto'])?$_POST['paidto']:"";
	 	$paymode =isset($_POST['paymode'])?$_POST['paymode']:"";
	 	$trans_id =isset($_POST['trans_id'])?$_POST['trans_id']:"";
		if($user_id==0){
			$arrData = array(
				'user_mobile' => $mobile,
				'user_name' => $username,
				'user_planid' => $meal_plan,
				'created_date' => date("Y-m-d H:i:s")
			);
			$user_id = $this->db_lib->insert('user_master',$arrData);
		}else{
			$arrData = array(
				'user_planid' => $meal_plan,
				'modified_date' => date("Y-m-d H:i:s")
			);
			$strWhere="user_id=".$user_id;
			$update = $this->db_lib->update('user_master',$arrData,$strWhere);
		}
		if($user_id!=0)
		{
			$arrData = array(
				'user_id' => $user_id,
				'amount' => $amount,
				'pay_month_date' => $paytype,
				'paymentmonth' => $submitdate,
				'transaction_id' => $trans_id,
				'paid_to' => $paidto,
				'paidby' => $paymode,
				'created_date' => date("Y-m-d H:i:s")
			);
			$inst = $this->db_lib->insert('payment_master',$arrData);
			if($inst>0){
				$status=true;
				$msg='Insert successfully!';
			}else{
				$status=false;
				$msg='There is some problem';
			}
			
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
	}
	
	////////End Payment Recived Setting//////////
	////////Start Item Master Setting//////////
	public function categorydata(){
		$table='category_master'; $strWhere=''; $fields='*';
		$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
		//print_r($result);
		$res=array();$result1=array();
		if($result!=""){
			foreach($result as $row){
				$data=array();
				
				$data['id']=$row['cate_id'];
				$data['name']=$row['cate_name'];
				$res[]=$data;
			}
		}
		$result1['data']=$res;
		echo json_encode($result1); 
		return false; 
		//$this->load->view($this->folder."type",array("data"=>$result));
	}
	
	public function itemmaster(){
		$this->load->view($this->folder.'item_master');
	}
	public function AddCategory(){
		$cate_name=isset($_POST['cate_name'])?$_POST['cate_name']:"";
		if($cate_name!=""){
			$arrData = array(
				'cate_name' => $cate_name,
				'created_date' => date("Y-m-d H:i:s")
			);
			$inst = $this->db_lib->insert('category_master',$arrData);
			if($inst>0){
				$status=true;
				$msg='Insert successfully!';
			}else{
				$status=false;
				$msg='There is some problem';
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
	}
	public function AddEditItemPlan(){
		$item_name = isset($_POST['item_name'])?$_POST['item_name']:"";
	 	$mealnames =isset($_POST['mealnames'])?implode(',',$_POST['mealnames']):"";
	 	$cate_id =isset($_POST['cate_id'])?$_POST['cate_id']:"";
	 	$item_id =isset($_POST['item_id'])?$_POST['item_id']:"";
	 	
		if($item_id ==0 && $item_name!="") {
			$arrData = array(
				'item_name' =>$item_name,
				'cate_id' =>$cate_id,
				'meal_plan' =>$mealnames,
				'created_date' => date("Y-m-d H:i:s")
			);
			$inst = $this->db_lib->insert('item_master',$arrData);
			if($inst>0){
				$status=true;
				$msg='Insert successfully!';
			}else{
				$status=false;
				$msg='There is some problem';
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
		else if($item_id!=0 && $item_name!=""){
			$arrData = array(
				'item_id' => $item_id,
				'item_name' =>$item_name,
				'cate_id' =>$cate_id,
				'meal_plan' =>$mealnames,
				'modified_date' => date("Y-m-d H:i:s")
			);
			$strWhere="item_id=".$item_id;
			$update = $this->db_lib->update('item_master',$arrData,$strWhere);
			if($update>0){
				$status=true;
				$msg='Update successfully!';
			}else{
				$status=false;
				$msg='There is some problem';
			}
			$response=['status'=>$status,'msg'=>$msg];
			echo json_encode($response);
		}
		//print_r($result);
	}
	public function getAllItems(){
		$table='item_master'; $strWhere=''; $fields='*';
		$result = $this->accountmodel->fetch_data($table,$strWhere,$fields);
		//print_r($result);
		$res=array();$result1=array();
		if($result!=""){
			foreach($result as $row){
				$data=array();
				
				$data['id']=$row['item_id'];
				$data['name']=$row['item_name'];
				/////Get Meal Type Name///////
				$meals=explode(',',$row['meal_plan']);
				$mealsdata='';
				for($i=0;$i<count($meals);$i++){
				$strwhere1="plan_id=".$meals[$i];$fieldname='plan_name';
					if($mealsdata=="")
						$mealsdata =$this->db_lib->getName('meal_plan',$strwhere1,$fieldname);
					else
						$mealsdata.=', '.$this->db_lib->getName('meal_plan',$strwhere1,$fieldname);
				}
				$data['meals']=$mealsdata;
				/////Get Type Name///////
				$strwhere1="cate_id=".$row['cate_id'];$fieldname='cate_name';
				$data['cate_name']=$this->db_lib->getName('category_master',$strwhere1,$fieldname);
				$rowdata=htmlspecialchars(json_encode($row));
				$edit="";$delete="";
				
				$edit="<a rel='tooltip'  onclick=\"angular.element(this).scope().showAddItemModal(".$rowdata.")\"  href='#' data-original-title='Edit' class='btn btn-info btn-circle btn-xs ' ><i class='fa fa-edit' data-toggle='tooltip' title='Edit'></i></a>";
			
				$delete="<a  onclick='angular.element(this).scope().getId(\"".$row['item_id']."\")' data-toggle='modal'  data-target='#confirm' href='#' data-original-title='Delete' class='btn btn-info btn-circle btn-xs'><i class='fa fa-trash' data-toggle='tooltip' title='Delete'></i></a>";
				$data['action']=$edit;
				$res[]=$data;
			}
		}
		$result1['data']=$res;
		echo json_encode($result1); 
		return false; 
		//$this->load->view($this->folder."type",array("data"=>$result));
	}
	
	////////End Item Master Setting//////////
	// executes when clicked on login
	public function login()
	{	
		
		if(isset($_POST['username']) && isset($_POST['password'])){
			$username = $this->input->post('username', true);
			$password = $this->input->post('password', true);
			$sts = $this->accountmodel->login($username, $password); 
			if($sts !=0)
			{
				$session= array("admin_id" => $sts['admin_id'], "admin_name" =>  $sts['admin_name']);
				$this->session->set_userdata($session);
				redirect("account/dashboard");

			}
			else{
				setFlash("loginMsgError", "Please, enter <strong>valid Username and Password</strong>");			
			}			
		}
		
		$this->load->view($this->folder."login");
	}	

	public function dashboard()
	{	
		if(!$this->usermodel->hasLoggedIn()){
			redirect("account/login");
		}

		//echo $admin_id = $this->usermodel->getUserId();
		$this->load->view($this->folder."dashboard");
	}	


	public function logout()
	{
		if($this->usermodel->hasLoggedIn()){
			session_unset();
			session_destroy();
			redirect("account/login");
		}

	}

	
	// Execute when user forgot password
	public function forgot_password()
	{
		if($this->usermodel->hasLoggedIn()){
			$user_id=$this->usermodel->getUserId();
			if($this->role_management->check_permission($user_id,ACTIVATE_DEACTIVATE)==true)
			{
				redirect("admin/view_details");
			}
			else
			{
				redirect("account/change_password");
			}
		}
		/*--	Action Section	--*/
		if(isset($_POST['btnforgot'])){
			$email_id = $this->input->post("email",true);
			$result = $this->accountmodel->forgotPassword($email_id);
			if($result){
				
				setFlash("loginMsgSuccess", "Password reset email has been sent to your registered Email address - <strong>{$email_id}</strong>");
				redirect("account/login");
			}
			else{
				setFlash("forgotPasswordError", "The specified Email Address - <strong>{$email_id}</strong> is not registered with CreditRating.");
				redirect("account/forgot_password");
			}
		}
		
		/*--	Page Section	--*/		
		$this->load->view($this->folder."forgot");	
	}
	
	// Execute when user click on activation link
	public function reset_password()
	{
		if(isset($_GET['u']) && isset($_GET['a'])){
			$userEmail = trim($_GET['u']);
			$randomString = trim($_GET['a']);
			if(!$this->accountmodel->resetPassword($userEmail, $randomString)){
				echo "Link has been used already";
				exit();
			}
		}
		
		/*--	Action Section	--*/
		if(isset($_POST['btnReset'])){
			$userData = $this->input->post();
			echo $userEmail = $userData['u'];
			$randomString = $userData['a'];
			$result = $this->accountmodel->changePassword($userData, $userEmail, $randomString);
			if($result){
				setFlash("loginMsgSuccess", "Password has been updated successfully");
				redirect("account/login");
			}
			else{
				setFlash("changePasswordError", "Unable to update password");
				redirect("account/reset_password");
			}
		}
		
		/*--	Head Section	--*/
		$this->template->title = 'Profile';
		$this->template->meta_keywords = '';
		$this->template->meta_description = '';

		/*--	Page Section	--*/	
		$this->load->view($this->folder."resetpassword",array("u"=>$userEmail, "a"=>$randomString));	
	}
	
	// used to change user password
	public function change_password()
	{
		if(!$this->usermodel->hasLoggedIn()){
			redirect("account/login");
		}
		
		/*--	Action Section	--*/
		if(isset($_POST['btnUpdate'])){
			$userData = $this->input->post();		
			$result = $this->accountmodel->changePassword($userData);
			if($result){
				setFlash("changePasswordSuccess", "Password has been updated successfully");
			}
			else{
				setFlash("changePasswordError", "Unable to update the password. Please, verify you have entered your <strong>Old Passwword</strong> correctly.");
			}
		}
		
		/*--	Head Section	--*/
		$this->template->title = 'Profile';
		$this->template->meta_keywords = '';
		$this->template->meta_description = '';

		/*--	Page Section	--*/		
		$this->template->load($this->folder."changepassword");
	}
	
	// edit profile
	public function edit_profile()
	{
		if(isset($_POST["btnUpdate"])){
			
			$password = $this->input->post('password',true);
			$uploadimage = 'uploadimage';
			$userData=array(
						'empNickName'=> trim($this->input->post('nick_name',true)),
						'empBirthDate'=> trim($this->input->post('birth_date',true)),
						'empMobileNo'=> trim($this->input->post('mobile_number',true)),
						'empAltPhone'=> trim($this->input->post('alternate_number',true)),
						'empPersonalEmail'=> trim($this->input->post('personal_email',true))
						);
			if($password!=null)
			{						
				$userData['empPassword'] = $this->encrypt->sha1($password);
			}	
			if($this->accountmodel->edit_profile_data($userData)==true)
			{
				setFlash("Edit_Profile_Success","Details successfully updated");				
			}
			else
			{
				setFlash("Edit_Profile_Error","Sorry!Updation Failed");
			}
		}	
		
		
		// get employee details
		$userID = $this->session->userdata("user_id");
		$strWhere = "empID = '$userID'";
		$table = "employees";
		$employee_details = $this->accountmodel->fetch_details($table,$strWhere,'');
		/*--	Page Section	--*/		
		$this->template->load($this->folder."edit_profile",array('employee_details'=>$employee_details));
	}
	
	// function for tasks
	public function tasks()
	{
		/*------- check field officer ----------*/
		$userID = $this->session->userdata("user_id");
		$strWhere = "empID = ".$userID." AND empDeptID = ".FIELD_OFFICER;
		$employee_details = $this->db_lib->fetchRecord('employees',$strWhere,'empID');
		$employeeID = $employee_details['empID'];
		/*------- fetch assigned cases ----------*/
		$strWhere = "empID = ".$userID." AND loginStatus = ".STATUS_ASSIGNED;
		$case_details = $this->db_lib->fetchRecords('applicationlogin',$strWhere,'loginID,loginNumber,loginAssignedOn');	
		if($case_details != 0)
		{
			if(count($case_details) == 1)
			{
				$assigned_on = strtotime($case_details[0]['loginAssignedOn']); // datetime conversion			
				$notification_time = $this->time_conversion($assigned_on);			
				$case_details[0]['loginAssignedOn'] = $notification_time;
			}
			else
			{
				for($i=0; $i<count($case_details); $i++)
				{
					$assigned_on = strtotime($case_details[$i]['loginAssignedOn']); // datetime conversion			
					$notification_time = $this->time_conversion($assigned_on);			
					$case_details[$i]['loginAssignedOn'] = $notification_time;
				}
			}
			echo json_encode($case_details);
		}
	}
	
	// time conversion function
	public function time_conversion($time)
	{
		$time = time() - $time;

		$time_types = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($time_types as $unit => $value) {
			if ($time < $unit) continue;
			$units = floor($time / $unit);
			return $units.' '.$value.(($units>1)?'s':'');
		}
	}
	
	public function permission_error()
	{
		if(hasFlash("PermissionError")){
			
		}
		else if(hasFlash("PermissionSuccess"))
		{
			
		}
		else
		{
			setFlash("PermissionError","<h4>Sorry! You don't have permission to access </h4>");
		}	
		$this->template->load("account/permission_error");
	}
	
	// view attendance
	public function view_attendance()
	{
		$user_id=$this->usermodel->getUserId();
		if($this->role_management->check_permission($user_id,PROCESS_ATTENDANCE)==true) {
			
			$table = 'year_attendance LEFT JOIN employees ON employees.empID = year_attendance.AttYearUserID';
			$fields = 'empFirstName,empMiddleName,empLastName,AttJan,AttJanDays,AttFeb,
					  AttFebDays,AttMar,AttMarDays,AttApr,AttAprDays,AttMay,AttMayDays,AttJun,AttJunDays,
					  AttJul,AttJulDays,AttAug,AttAugDays,AttSep,AttSepDays,AttOct,AttOctDays,AttNov,AttNovDays,AttDec,AttDecDays,AttYearHours,AttYearDays';
			$limit = 10;			
			$start = 0;
			$result = $this->accountmodel->fetch_data($limit,$start,$table,'',$fields);
			$total_records = $this->accountmodel->record_count($table);	
			
			// pass table,where parameters to export liabrary
			$fields = 'CONCAT(empFirstName," ",empMiddleName," ",empLastName) AS EMPLOYEE_NAME,AttJan AS JANUARY,AttJanDays AS JANUARY_DAYS,AttFeb AS FEBRUARY,
					  AttFebDays AS FEBRUARY_DAYS,AttMar AS MARCH,AttMarDays AS MARCH_DAYS,AttApr AS APRIL,AttAprDays AS APRIL_DAYS,AttMay AS MAY,AttMayDays AS MAY_DAYS,AttJun AS JUNE,
					  AttJunDays AS JUNE_DAYS,AttJul AS JULY,AttJulDays AS JULY_DAYS,AttAug AS AUGEST,AttAugDays AS AUGEST_DAYS,AttSep AS SEPTEMBER,AttSepDays AS SEPTEMBER_DAYS,
					  AttOct AS OCTOMBER,AttOctDays AS OCTOMBER_DAYS,AttNov AS NOVEMBER,AttNovDays AS NOVEMBER_DAYS,AttDec AS DECEMBER,AttDecDays AS DECEMBER_DAYS,AttYearHours AS YEAR_HOURS,AttYearDays AS YEAR_DAYS';
			$fileName = "YearAttendanceDetails-".date("Y-m-d H:i:s");
			$this->export_to_csv->getExportData($table,'',$fields,$fileName);
			
			$this->template->load("account/view_attendance",array('result'=>$result,'total_records'=>$total_records));
		}
		else
		{
			redirect("account/permission_error");
		}
	}
	
	// search case details
	public function search_attendance()
	{
		$user_id=$this->usermodel->getUserId();
		if($this->role_management->check_permission($user_id,PROCESS_ATTENDANCE)==true) {
			
			$searchname = $this->input->get('data');
			$table = 'year_attendance LEFT JOIN employees ON employees.empID = year_attendance.AttYearUserID';
			$fields = 'empFirstName,empMiddleName,empLastName,AttJan,AttJanDays,AttFeb,
					  AttFebDays,AttMar,AttMarDays,AttApr,AttAprDays,AttMay,AttMayDays,AttJun,AttJunDays,
					  AttJul,AttJulDays,AttAug,AttAugDays,AttSep,AttSepDays,AttOct,AttOctDays,AttNov,AttNovDays,AttDec,AttDecDays,AttYearHours,AttYearDays';
			$limit = 10;		
			$start = 0;
			
			if($searchname != null)
			{
				$this->session->set_userdata("search",$searchname);
				$where = "empFirstName like '%$searchname' OR empMiddleName like '%$searchname' OR empLastName like '%$searchname' OR 
							empOfficeEmail like '%$searchname%' OR empPersonalEmail like '%$searchname%' OR empMobileNo like '%$searchname' OR 
							empOfficeExtn like '%$searchname' ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields,$searchname);
				$total_records = $this->accountmodel->record_count($table,$where);		
			}
			else
			{
				$this->session->unset_userdata("search");
				/*------fetch details------*/
				$result = $this->accountmodel->fetch_data($limit,$start,$table,'',$fields = null);
				$total_records = $this->accountmodel->record_count($table,'');
			}
			
			// fetch whole attendance data
			if($searchname != null)
			{
				// pass table,where parameters to export liabrary
				$fields = 'CONCAT(empFirstName,empMiddleName,empLastName) AS EMPLOYEE_NAME,AttJan AS JANUARY,AttJanDays AS JANUARY_DAYS,AttFeb AS FEBRUARY,
						  AttFebDays AS FEBRUARY_DAYS,AttMar AS MARCH,AttMarDays AS MARCH_DAYS,AttApr AS APRIL,AttAprDays AS APRIL_DAYS,AttMay AS MAY,AttMayDays AS MAY_DAYS,AttJun AS JUNE,
						  AttJunDays AS JUNE_DAYS,AttJul AS JULY,AttJulDays AS JULY_DAYS,AttAug AS AUGEST,AttAugDays AS AUGEST_DAYS,AttSep AS SEPTEMBER,AttSepDays AS SEPTEMBER_DAYS,
						  AttOct AS OCTOMBER,AttOctDays AS OCTOMBER_DAYS,AttNov AS NOVEMBER,AttNovDays AS NOVEMBER_DAYS,AttDec AS DECEMBER,AttDecDays AS DECEMBER_DAYS,AttYearHours AS YEAR_HOURS,AttYearDays AS YEAR_DAYS';
				$fileName = "YearAttendanceDetails-".date("Y-m-d H:i:s");
				$this->export_to_csv->getExportData($table,$where,$fields,$fileName);
			}
			else
			{
				// pass table,where parameters to export liabrary
				$fields = 'CONCAT(empFirstName," ",empMiddleName," ",empLastName) AS EMPLOYEE_NAME,AttJan AS JANUARY,AttJanDays AS JANUARY_DAYS,AttFeb AS FEBRUARY,
					  AttFebDays AS FEBRUARY_DAYS,AttMar AS MARCH,AttMarDays AS MARCH_DAYS,AttApr AS APRIL,AttAprDays AS APRIL_DAYS,AttMay AS MAY,AttMayDays AS MAY_DAYS,AttJun AS JUNE,
					  AttJunDays AS JUNE_DAYS,AttJul AS JULY,AttJulDays AS JULY_DAYS,AttAug AS AUGEST,AttAugDays AS AUGEST_DAYS,AttSep AS SEPTEMBER,AttSepDays AS SEPTEMBER_DAYS,
					  AttOct AS OCTOMBER,AttOctDays AS OCTOMBER_DAYS,AttNov AS NOVEMBER,AttNovDays AS NOVEMBER_DAYS,AttDec AS DECEMBER,AttDecDays AS DECEMBER_DAYS,AttYearHours AS YEAR_HOURS,AttYearDays AS YEAR_DAYS';
				$fileName = "YearAttendanceDetails-".date("Y-m-d H:i:s");
				$this->export_to_csv->getExportData($table,'',$fields,$fileName);
			}
			
			$result[]['total_records'] = $total_records;
			
			echo json_encode($result);	
		}
		else
		{
			redirect("account/permission_error");
		}
	}
	
	// pagination seach attendance
	public function pagination_search_attendance()
	{
		$user_id=$this->usermodel->getUserId();
		if($this->role_management->check_permission($user_id,PROCESS_ATTENDANCE)==true) {
			
			$limit = 10;
			$start = $this->input->get('page');	
			$table = 'year_attendance LEFT JOIN employees ON employees.empID = year_attendance.AttYearUserID';
			$fields = 'empFirstName,empMiddleName,empLastName,AttJan,AttJanDays,AttFeb,
					  AttFebDays,AttMar,AttMarDays,AttApr,AttAprDays,AttMay,AttMayDays,AttJun,AttJunDays,
					  AttJul,AttJulDays,AttAug,AttAugDays,AttSep,AttSepDays,AttOct,AttOctDays,AttNov,AttNovDays,AttDec,AttDecDays,AttYearHours,AttYearDays';
			if($this->session->userdata("search")!=null)
			{
				$searchname = $this->session->userdata("search");
				$where = "empFirstName like '%$searchname' OR empMiddleName like '%$searchname' OR empLastName like '%$searchname' OR 
							empOfficeEmail like '%$searchname%' OR empPersonalEmail like '%$searchname%' OR empMobileNo like '%$searchname' OR 
							empOfficeExtn like '%$searchname' ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
			}
			else
			{
				$this->session->unset_userdata("search");
				/*------fetch details------*/
				$result = $this->accountmodel->fetch_data($limit,$start,$table,'',$fields = null);
			}
			echo json_encode($result);
		}
		else
		{
			redirect("account/permission_error");
		}
	}
	
	// search attendance
	public function custom_search_attendance()
	{
		$user_id=$this->usermodel->getUserId();
		if($this->role_management->check_permission($user_id,PROCESS_ATTENDANCE)==true) {
			$searchname = $this->input->get('data');
			$this->session->set_userdata("first_name",$this->input->get('first_name'));
			$this->session->set_userdata("middle_name",$this->input->get('middle_name'));
			$this->session->set_userdata("last_name",$this->input->get('last_name'));
			$this->session->set_userdata("year",$this->input->get('year'));		
			
			$first_name = $this->session->userdata('first_name');
			$middle_name = $this->session->userdata('middle_name');
			$last_name = $this->session->userdata('last_name');
			$year = $this->session->userdata('year');
			
			$table = 'year_attendance LEFT JOIN employees ON employees.empID = year_attendance.AttYearUserID';
			$fields = 'empFirstName,empMiddleName,empLastName,AttJan,AttJanDays,AttFeb,
					  AttFebDays,AttMar,AttMarDays,AttApr,AttAprDays,AttMay,AttMayDays,AttJun,AttJunDays,
					  AttJul,AttJulDays,AttAug,AttAugDays,AttSep,AttSepDays,AttOct,AttOctDays,AttNov,AttNovDays,AttDec,AttDecDays,AttYearHours,AttYearDays';
			$limit = 10;		
			$start = 0;
			$where = '';
			
			if($first_name != null && $middle_name == null && $last_name == null && $year == null)
			{
				$where = "empFirstName like '$first_name' ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
				$total_records = $this->accountmodel->record_count($table,$where);
			}
			else if($first_name == null && $middle_name != null && $last_name == null && $year == null)
			{
				$where = "empMiddleName like '$middle_name' ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
				$total_records = $this->accountmodel->record_count($table,$where);
			}
			else if($first_name != null && $middle_name != null && $last_name != null && $year == null)
			{
				$where = "empFirstName like '%$first_name%' AND empMiddleName like '%$middle_name%' AND empLastName like '%$last_name%' ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
				$total_records = $this->accountmodel->record_count($table,$where);
			}
			else if($first_name != null && $middle_name != null && $last_name != null && $year != null)
			{
				$where = "empFirstName like '%$first_name%' AND empMiddleName like '%$middle_name%' AND empLastName like '%$last_name%' AND AttYear like '$year'  ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
				$total_records = $this->accountmodel->record_count($table,$where);
			}
			else if($first_name == null && $middle_name == null && $last_name == null && $year != null)
			{
				$where = "AttYear like '$year'  ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
				$total_records = $this->accountmodel->record_count($table,$where);
			}
			else
			{
				$result = $this->accountmodel->fetch_data($limit,$start,$table,'',$fields);
				$total_records = $this->accountmodel->record_count($table,'');
			}
			
			// pass table,where parameters to export liabrary
			$fields = 'CONCAT(empFirstName," ",empMiddleName," ",empLastName) AS EMPLOYEE_NAME,AttJan AS JANUARY,AttJanDays AS JANUARY_DAYS,AttFeb AS FEBRUARY,
					  AttFebDays AS FEBRUARY_DAYS,AttMar AS MARCH,AttMarDays AS MARCH_DAYS,AttApr AS APRIL,AttAprDays AS APRIL_DAYS,AttMay AS MAY,AttMayDays AS MAY_DAYS,AttJun AS JUNE,
					  AttJunDays AS JUNE_DAYS,AttJul AS JULY,AttJulDays AS JULY_DAYS,AttAug AS AUGEST,AttAugDays AS AUGEST_DAYS,AttSep AS SEPTEMBER,AttSepDays AS SEPTEMBER_DAYS,
					  AttOct AS OCTOMBER,AttOctDays AS OCTOMBER_DAYS,AttNov AS NOVEMBER,AttNovDays AS NOVEMBER_DAYS,AttDec AS DECEMBER,AttDecDays AS DECEMBER_DAYS,AttYearHours AS YEAR_HOURS,AttYearDays AS YEAR_DAYS';
			$fileName = "YearAttendanceDetails-".date("Y-m-d H:i:s");
			$this->export_to_csv->getExportData($table,$where,$fields,$fileName);
			
			
			$result[]['total_records'] = $total_records;
			
			echo json_encode($result);	
		}
		else
		{
			redirect("account/permission_error");
		}
	}
	
	// pagination for custom attendance
	public function pagination_custom_search_attendance()
	{
		$user_id=$this->usermodel->getUserId();
		if($this->role_management->check_permission($user_id,PROCESS_ATTENDANCE)==true) {
			
			$limit = 10;
			$start = $this->input->get('page');
			
			$first_name = $this->session->userdata('first_name');
			$middle_name = $this->session->userdata('middle_name');
			$last_name = $this->session->userdata('last_name');
			$year = $this->session->userdata('year');
			
			$table = 'year_attendance LEFT JOIN employees ON employees.empID = year_attendance.AttYearUserID';
			$fields = 'empFirstName,empMiddleName,empLastName,AttJan,AttJanDays,AttFeb,
					  AttFebDays,AttMar,AttMarDays,AttApr,AttAprDays,AttMay,AttMayDays,AttJun,AttJunDays,
					  AttJul,AttJulDays,AttAug,AttAugDays,AttSep,AttSepDays,AttOct,AttOctDays,AttNov,AttNovDays,AttDec,AttDecDays,AttYearHours,AttYearDays';
			if($first_name != null && $middle_name == null && $last_name == null && $year == null)
			{
				$where = "empFirstName like '$first_name' ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
			}
			else if($first_name == null && $middle_name != null && $last_name == null && $year == null)
			{
				$where = "empMiddleName like '$middle_name' ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
			}
			else if($first_name != null && $middle_name != null && $last_name != null && $year == null)
			{
				$where = "empFirstName like '%$first_name%' AND empMiddleName like '%$middle_name%' AND empLastName like '%$last_name%' ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
			}
			else if($first_name != null && $middle_name != null && $last_name != null && $year != null)
			{
				$where = "empFirstName like '%$first_name%' AND empMiddleName like '%$middle_name%' AND empLastName like '%$last_name%' AND AttYear like '$year' ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
			}
			else if($first_name == null && $middle_name == null && $last_name == null && $year != null)
			{
				$where = "AttYear like '$year'  ORDER BY empID DESC";
									
				$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
			}
			else
			{
				$result = $this->accountmodel->fetch_data($limit,$start,$table,'',$fields);
				// unset all custom search
				$this->session->unset_userdata('first_name');
				$this->session->unset_userdata('middle_name');
				$this->session->unset_userdata('last_name');
				$this->session->unset_userdata('year');
			}
			echo json_encode($result);
		}
		else
		{
			redirect("account/permission_error");
		}
	}
	
	// view daily attendance
	public function daily_attendance()
	{
		$user_id=$this->usermodel->getUserId();
		if($this->role_management->check_permission($user_id,PROCESS_ATTENDANCE)==true) {
			
			$table = 'attendance LEFT JOIN employees ON attendance.AttUserID = employees.empID';
			$fields = 'DISTINCT AttUserID,empFirstName,empMiddleName,empLastName,empMobileNo,empOfficeExtn,empOfficeEmail,min(AttLoginDateTime) as AttLoginDateTime,max(AttLoginDateTime) as last_login,count(AttUserID) as total';
			$current_date = DATE("Y-m-d");
			$where = "DATE(AttLoginDateTime) = '$current_date' group by AttUserID";
			$limit = 10;			
			$start = 0;
			$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
			
			// count records
			$total_records = $this->accountmodel->record_count($table,$where);
			
			// pass table,where parameters to export liabrary
			$fields = 'DISTINCT AttUserID as Serial,CONCAT(empFirstName," ",empMiddleName," ",empLastName) AS EMPLOYEE_NAME,empMobileNo AS MOBILE_NUMBER,min(AttLoginDateTime) as First_login,max(AttLoginDateTime) as Last_Login,count(AttUserID) as Total_locations';
			$fileName = "DailyAttendanceDetails-".date("Y-m-d H:i:s");
			$this->export_to_csv->getExportData($table,$where,$fields,$fileName);
			
			// departments
			$departments = $this->db_lib->fetchRecords("departments",'','');
			
			$this->template->load("account/daily_attendance",array('result'=>$result,'total_records'=>$total_records,'departments'=>$departments));
		}
		else
		{
			redirect("account/permission_error");
		}
	}
	
	// search daily attendance
	public function custom_search_daily_attendance()
	{
		$user_id=$this->usermodel->getUserId();
		if($this->role_management->check_permission($user_id,PROCESS_ATTENDANCE)==true) {	
			
			$userData = '';
			$userData['AttUserID'] = $this->input->get('empID');
			$first_date= $this->input->get('first_date');
			$second_date = $this->input->get('second_date');
			$userData['AttDepartment'] = $this->input->get('department');
			
			$table = 'attendance LEFT JOIN employees ON attendance.AttUserID = employees.empID';
			$fields = 'DISTINCT AttUserID,empFirstName,empMiddleName,empLastName,empMobileNo,empOfficeExtn,empOfficeEmail,min(AttLoginDateTime) as AttLoginDateTime,max(AttLoginDateTime) as last_login,count(AttUserID) as total';
			
			$limit = 10;		
			$start = 0;
			
			// erase empty indexes
				$userData = array_filter($userData);
	
			// total records
				$totalRecords = count($userData);
			
			// where condition
			$strWhere = '';
			if($totalRecords != 0){
					$count = 1;
					foreach($userData as $id=>$data){
						if($totalRecords > 1 && $count != $totalRecords){
							$strWhere .= "".$id." = '".strtolower($data)."' AND ";
						}else{
							$strWhere .= "".$id." = '".strtolower($data)."'";
						}
						$count = $count + 1;
					}	
			}
			
			$current_date = DATE("Y-m-d");
			
			if($first_date != '' && $second_date != ''){
				if($totalRecords == 0){
					$strWhere .= " DATE(AttLoginDateTime) BETWEEN '".$first_date."' AND '".$second_date."' group by AttUserID";
				}else{
					$strWhere .= " AND DATE(AttLoginDateTime) BETWEEN '".$first_date."' AND '".$second_date."' group by AttUserID";
				}
			}else if($totalRecords == 0){
				$strWhere = "DATE(AttLoginDateTime) = '$current_date' group by AttUserID";
			}else{
				$strWhere .= " group by AttUserID";
			}
			//echo $strWhere;exit();
			$result = $this->accountmodel->fetch_data($limit,$start,$table,$strWhere,$fields);
			
			// pass table,where parameters to export liabrary
			$fields = 'DISTINCT AttUserID as Serial,CONCAT(empFirstName," ",empMiddleName," ",empLastName) AS EMPLOYEE_NAME,empMobileNo AS MOBILE_NUMBER,min(AttLoginDateTime) as First_login,max(AttLoginDateTime) as Last_Login,count(AttUserID) as Total_locations';
			$fileName = "DailyAttendanceDetails-".date("Y-m-d H:i:s");
			$this->export_to_csv->getExportData($table,$strWhere,$fields,$fileName);
			
			$total_records = $this->accountmodel->record_count($table,$strWhere);
			
			$result[]['total_records'] = $total_records;
			
			echo json_encode($result);
		}
		else
		{
			redirect("account/permission_error");
		}
	}
	
	// pagination for daily attendance
	public function pagination_custom_search_daily_attendance()
	{
		$user_id=$this->usermodel->getUserId();
		if($this->role_management->check_permission($user_id,PROCESS_ATTENDANCE)==true) {
			$limit = 10;
			$start = $this->input->get('page');
			
			$userData = '';
			$userData['AttUserID'] = $this->input->get('empID');
			$first_date= $this->input->get('first_date');
			$second_date = $this->input->get('second_date');
			$userData['AttDepartment'] = $this->input->get('department');
			
			$table = 'attendance LEFT JOIN employees ON attendance.AttUserID = employees.empID';
			$fields = 'DISTINCT AttUserID,empFirstName,empMiddleName,empLastName,empMobileNo,empOfficeExtn,empOfficeEmail,,min(AttLoginDateTime) as AttLoginDateTime,max(AttLoginDateTime) as last_login,count(AttUserID) as total';
			
			$limit = 10;		
			$start = 0;
			
			// erase empty indexes
				$userData = array_filter($userData);
	
			// total records
				$totalRecords = count($userData);
			
			// where condition
			$strWhere = '';
			if($totalRecords != 0){
					$count = 1;
					foreach($userData as $id=>$data){
						if($totalRecords > 1 && $count != $totalRecords){
							$strWhere .= "".$id." = '".strtolower($data)."' AND ";
						}else{
							$strWhere .= "".$id." = '".strtolower($data)."'";
						}
						$count = $count + 1;
					}	
			}
			
			$current_date = DATE("Y-m-d");
			
			if($first_date != '' && $second_date != ''){
				if($totalRecords == 0){
					$strWhere .= " DATE(AttLoginDateTime) BETWEEN '".$first_date."' AND '".$second_date."' group by AttUserID";
				}else{
					$strWhere .= " AND DATE(AttLoginDateTime) BETWEEN '".$first_date."' AND '".$second_date."' group by AttUserID";
				}
			}else if($totalRecords == 0){
				$strWhere = "DATE(AttLoginDateTime) = '$current_date' group by AttUserID";
			}else{
				$strWhere .= " group by AttUserID";
			}
			
			$result = $this->accountmodel->fetch_data($limit,$start,$table,$strWhere,$fields);
			
			echo json_encode($result);
		}
		else
		{
			redirect("account/permission_error");
		}
	}
	
	// view employee locations in map
	public function employee_map_location()
	{
        // Initialize the map, passing through any parameters
		$config['center'] = $this->input->get('longitude').','.$this->input->get('latitude'); 
		$config['places'] = TRUE;
        $config['zoom'] = "17";
		$config['onboundschanged'] = 'if (!centreGot) {
			var mapCentre = map.getCenter();
			marker_0.setOptions({
				position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng()) 
			});
		}
		centreGot = true;';
        $this->googlemaps->initialize($config);
		
        // Get the co-ordinates from the database
      
		$marker['title']='SHB';
		$marker['position'] = $this->input->get('longitude').','.$this->input->get('latitude'); 
		$this->googlemaps->add_marker($marker);
        // Create the map
        $data = array();
        $data['map'] = $this->googlemaps->create_map();
		
		$this->load->view('supervisor/map_view',$data);
	
	}
	
	// view location details of employee
	public function view_employee_locations()
	{
		$userID = $this->input->get("userID");
		$table = 'attendance LEFT JOIN employees ON attendance.AttUserID = employees.empID';
		$fields = 'AttUserID,empFirstName,empMiddleName,empLastName,empMobileNo,empOfficeExtn,empOfficeEmail,AttLoginDateTime,AttLoginLongitude,AttLoginLatitude,AttLogoutDateTime,AttJobHours';
		$current_date = DATE("Y-m-d");
		$where = "AttUserID = '$userID' ORDER BY AttLoginDateTime DESC";
		$limit = 10;			
		$start = 0;
		$result = $this->accountmodel->fetch_data($limit,$start,$table,$where,$fields);
		
		// count records
		$total_records = $this->accountmodel->record_count($table,$where);
		
		// pass table,where parameters to export liabrary
		$fields = 'CONCAT(empFirstName," ",empMiddleName," ",empLastName) AS EMPLOYEE_NAME,empMobileNo AS MOBILE_NUMBER,CONCAT(AttLoginLongitude," , ",AttLoginLatitude) as Locations,
		AttLoginDateTime as logged_in,AttLogoutDateTime as logged_out,AttJobHours as Hours';
		$fileName = "DailyAttendanceDetails-".date("Y-m-d H:i:s");
		$this->export_to_csv->getExportData($table,$where,$fields,$fileName);
		
		// departments
		$departments = $this->db_lib->fetchRecords("departments",'','');
		
		$this->template->load("account/view_location_details",array('result'=>$result,'total_records'=>$total_records,'departments'=>$departments));
	}
	
	// search locations
	public function customer_search_employee_locations()
	{
		$userData = '';
		$userData['AttUserID'] = $this->input->get('empID');
		$first_date= $this->input->get('first_date');
		$second_date = $this->input->get('second_date');
		
		$table = 'attendance LEFT JOIN employees ON attendance.AttUserID = employees.empID';
		$fields = 'AttUserID,empFirstName,empMiddleName,empLastName,empMobileNo,empOfficeExtn,empOfficeEmail,AttLoginDateTime,AttLoginLongitude,AttLoginLatitude,AttLogoutDateTime,AttJobHours';
		
		$limit = 10;		
		$start = 0;
		
		// erase empty indexes
			$userData = array_filter($userData);

		// total records
			$totalRecords = count($userData);
		
		// where condition
		$strWhere = '';
		if($totalRecords != 0){
				$count = 1;
				foreach($userData as $id=>$data){
					if($totalRecords > 1 && $count != $totalRecords){
						$strWhere .= "".$id." = '".strtolower($data)."' AND ";
					}else{
						$strWhere .= "".$id." = '".strtolower($data)."'";
					}
					$count = $count + 1;
				}	
		}
		$current_date = DATE("Y-m-d");
		
		if($first_date != '' && $second_date != ''){
			if($totalRecords == 0){
				$strWhere .= " DATE(AttLoginDateTime) BETWEEN '".$first_date."' AND '".$second_date."' ORDER by AttLoginDateTime DESC";
			}else{
				$strWhere .= " AND DATE(AttLoginDateTime) BETWEEN '".$first_date."' AND '".$second_date."' ORDER by AttLoginDateTime DESC";
			}
		}else if($first_date != '' && $second_date == ''){
			$strWhere .= " AND DATE(AttLoginDateTime) = '".$first_date."' ORDER by AttLoginDateTime DESC";
		}else{
			$strWhere .= " ORDER BY AttLoginDateTime DESC";
		}
		
		$result = $this->accountmodel->fetch_data($limit,$start,$table,$strWhere,$fields);
		
		// pass table,where parameters to export liabrary
		$fields = 'CONCAT(empFirstName," ",empMiddleName," ",empLastName) AS EMPLOYEE_NAME,empMobileNo AS MOBILE_NUMBER,CONCAT(AttLoginLongitude," , ",AttLoginLatitude) as Locations,
		AttLoginDateTime as logged_in,AttLogoutDateTime as logged_out,AttJobHours as Hours';
		$fileName = "DailyAttendanceDetails-".date("Y-m-d H:i:s");
		$this->export_to_csv->getExportData($table,$strWhere,$fields,$fileName);
		
		$total_records = $this->accountmodel->record_count($table,$strWhere);
		
		$result[]['total_records'] = $total_records;
		
		echo json_encode($result);
	}
	
	// pagination for customer locations
	public function pagination_employee_locations()
	{
		$userData = '';
		$userData['AttUserID'] = $this->input->get('empID');
		$first_date= $this->input->get('first_date');
		$second_date = $this->input->get('second_date');
		
		$table = 'attendance LEFT JOIN employees ON attendance.AttUserID = employees.empID';
		$fields = 'AttUserID,empFirstName,empMiddleName,empLastName,empMobileNo,empOfficeExtn,empOfficeEmail,AttLoginDateTime,AttLoginLongitude,AttLoginLatitude,AttLogoutDateTime,AttJobHours';
		
		$limit = 10;		
		$start = $this->input->get('page');
		
		// erase empty indexes
			$userData = array_filter($userData);

		// total records
			$totalRecords = count($userData);
		
		// where condition
		$strWhere = '';
		if($totalRecords != 0){
				$count = 1;
				foreach($userData as $id=>$data){
					if($totalRecords > 1 && $count != $totalRecords){
						$strWhere .= "".$id." = '".strtolower($data)."' AND ";
					}else{
						$strWhere .= "".$id." = '".strtolower($data)."'";
					}
					$count = $count + 1;
				}	
		}
		$current_date = DATE("Y-m-d");
		
		if($first_date != '' && $second_date != ''){
			if($totalRecords == 0){
				$strWhere .= " DATE(AttLoginDateTime) BETWEEN '".$first_date."' AND '".$second_date."' ORDER by AttLoginDateTime DESC";
			}else{
				$strWhere .= " AND DATE(AttLoginDateTime) BETWEEN '".$first_date."' AND '".$second_date."' ORDER by AttLoginDateTime DESC";
			}
		}else if($first_date != '' && $second_date == ''){
			$strWhere .= " AND DATE(AttLoginDateTime) = '".$first_date."' ORDER by AttLoginDateTime DESC";
		}else{
			$strWhere .= " ORDER BY AttLoginDateTime DESC";
		}
		
		$result = $this->accountmodel->fetch_data($limit,$start,$table,$strWhere,$fields);
		
		echo json_encode($result);
	}
	
	// store field officer geo location every 1/2 
	public function store_field_officer_locations()
	{
		$latitude = $this->input->get('latitude');
		$longitude = $this->input->get('longitude');
		$userID = $this->input->get('user');
		
		if($latitude != '' && $latitude != 0 && $longitude != '' && $longitude != 0)
		{
			$strWhere = "empID = '$userID'";
			$employeeDetails = $this->db_lib->fetchRecord('employees',$strWhere,'empID');
			
			if($employeeDetails != 0)
			{
				$arrData = array(
						'userID' => $userID,
						'latitude' => $latitude,
						'longitude' => $longitude,
						'date_time' => date("Y-m-d H:i:s")
				);
				$geoID = $this->db_lib->insert('geo_location',$arrData);
			}
		}
	}
	
	// store menu id in session
	public function keep_menu_state()
	{
		$menu_id = $this->input->get('menu_id');
		$this->session->set_userdata('menu_data',$menu_id);
	}
}	