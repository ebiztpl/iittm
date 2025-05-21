<?php

	class UserModel extends CI_Model
	{
		function __construct()
		{
			// Call the Model constructor
			parent::__construct();
		}


		public function hasLoggedIn()
		{
			if($this->session->userdata("admin_id"))
			return true;
			return false;
		}
		
		public function getUserId()
		{
			if($this->session->userdata("admin_id"))
				return $this->session->userdata("admin_id");
			return false;
		}
		
		public function getUserEmail()
		{
			if($this->session->userdata("user_email"))
				return $this->session->userdata("user_email");
			return false;
		}
		
		public function getUserFname()
		{
			if($this->session->userdata("user_fname"))
				return $this->session->userdata("user_fname");
			return false;
		}
		
		public function getUserMname()
		{
			if($this->session->userdata("user_mname"))
				return $this->session->userdata("user_mname");
			return false;
		}
		
		public function getUserLname()
		{
			if($this->session->userdata("user_lname"))
				return $this->session->userdata("user_lname");
			return false;
		}
		public function getLastLogin()
		{
			if($this->session->userdata("user_last_login"))
				return $this->session->userdata("user_last_login");
			return false;
		}
		
		public function getProfilePicture()
		{
			if($this->session->userdata("profile_picture"))
				return $this->session->userdata("profile_picture");
			return false;
		}
		
		public function setUserEmail($userEmail)
		{
			if(!empty($userEmail)){
				$this->session->set_userdata("user_email", $userEmail);
				return true;
			}
			return false;
		}
		
		public function setUserFname($userFname)
		{
			if(!empty($userEmail)){
				$this->session->set_userdata("user_fname", $userFname);
				return true;
			}
			return false;
		}
		
		public function setProfilePicture($profilePicture)
		{
			if(!empty($profilePicture)){
				$this->session->set_userdata("profile_picture", $profilePicture);
				return true;
			}
			return false;
		}
		
		public function login($userId, $userEmail = null, $userLastLogin = null, $userFname = null, $userMname = null, $userLname = null, $profilePicture = null)
		{
			$session= array("admin_id" =>  $userId, 
				"user_email" =>  $userEmail, 
				"user_last_login" => $userLastLogin,
				"user_fname" => $userFname,
				"user_mname" => $userMname,
				"user_lname" => $userLname,
				"profile_picture" => $profilePicture,
			);
			$this->session->set_userdata($session);
			return true;
		}
		
	}

?>