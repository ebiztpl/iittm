<!DOCTYPE html>
<html>
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-164569761-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-164569761-1');
    </script>
	
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Welcome to Indian Institute Of Tourism &amp; Travel Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url();?>themes/bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>themes/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url();?>themes/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>themes/dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url();?>themes/plugins/iCheck/square/blue.css">

  <script src="<?=base_url();?>themes/js/jquery.min.js"></script>

  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style type="text/css">
    #loading
    {
    width: 100%;
    height: 100%;
    }
    .list> li {
    line-height: 25px;
    text-align: justify;
    font-size: 16px;
    margin-bottom: 3px;
    color: #000;
}


  .blinking{
    animation:blinkingText 1.2s infinite; text-transform: uppercase;
}
@keyframes blinkingText{
    0%{     color: red;    }
    49%{    color: blue; }
    60%{    color: transparent; }
    99%{    color:transparent;  }
    100%{   color: green;    }
}

  </style>
</head>
<body>
<div class="main">
  
  <div class="container container_bg">
    
    <div class="row">
      <img src="<?=base_url();?>themes/dist/img/head.jpg" width="100%" />
    </div>

    <div class="row text-center">
      <h3><b>Online Admission for BBA(TT/2020-23) & MBA(TTM/2020-22)</b>
        <a href="<?=base_url();?>index.php/admission/mobile_verification" class="btn btn-danger btn-sm pull-right" style="margin: 2px; margin-right:20px;"><i class="fa fa-arrow-left"></i> Back</a>
      </h3>
      <hr/>
    </div> 


     <div class="row" style="margin-bottom: 10px;">
      <div class="col-sm-6">
        
      </div>
      <div class="col-sm-6 text-right">
        
      </div>
    </div>

    <div class="row" ng-app="" ng-controller="validateCtrl" style="margin-top: 1%; margin-bottom: 10%;">

       <?php 

            $lFormAttrb = array(
              'role' => 'form',
              'id' => 'LoginForm',
              'name'=>'LoginForm',
              'action'=>'welcome/login',
              'novalidate'=>'novalidate',
              'ng-submit'=> 'login_check($event)'
            );
            echo form_open('',$lFormAttrb); 

          ?>  

        <div class="col-sm-4 col-sm-offset-4 text-left" style="border: solid 1px #e4e4e4;">
          <h4 class="heading_ram">Candidate Login</h4>
          <div class="form-group has-feedback">
          <input type="text" class="form-control" autocomplete="off" name="mobile" id="mobile" ng-model="mobile" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="10" placeholder="Register Mobile no." required >
         <span class="glyphicon glyphicon-phone form-control-feedback"></span>
         <span style="color:red" ng-show="LoginForm.mobile.$dirty && LoginForm.mobile.$invalid || LoginForm.$submitted && LoginForm.mobile.$invalid">
            <span ng-show="LoginForm.mobile.$error.required">Mobile No. is required.</span>
            <span ng-show="LoginForm.mobile.$invalid" ng-hide="LoginForm.mobile.$error.required">Mobile No. must be 10 digit!</span>
            <br/>
            <span ng-show="LoginForm.mobile.$invalid" ng-hide="LoginForm.mobile.$error.required">Only number!</span>
        </span> 

        <span style="color:blue" id="already">Your Mobile No. has already Verified and Registered with us.</span>

        </div>

        <div class="form-group has-feedback">
           <a class="btn btn-primary" ng-model="submit" ng-click="get_sms()" ng-hide="LoginForm.mobile.$invalid" id="send_otp">Send OTP</a>
           <input type="text" class="form-control" name="otp_textbox" id="otp_textbox" placeholder="Enter 6 digit OTP">
        </div>

          <div class="form-group has-feedback text-center" id="verify_otp">
             <a class="btn btn-primary" ng-model="submit" ng-click="verify_otp()" id="verfied_button">Verify OTP</a>
             <a class="btn btn-success" id="resend_button" ng-click="resent_otp()">Resend OTP</a>
          </div>

           <div class="form-group has-feedback text-center" id="verified_not_mached">
             <span style="color:red">Wrong OTP. check again</span>
           </div>
           <span id="dynmsg" style="color: green;"></span>
            <span id="dynerror" style="color: red;"></span>

           
             <div id="loading" class="text-center"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
 
      </div>


    

    </div>

    <hr/>
   <div style="text-align:center;font-size: 22px;margin-bottom: 15px;letter-spacing: 1px;">
   <a href="https://ebiztechnocrats.com/iittm/about_us.php" target="_blank">About Us</a> | 
   <a href="https://ebiztechnocrats.com/iittm/privacy.php" target="_blank">Privacy Policy</a> | 
   <a href="https://ebiztechnocrats.com/iittm/terms.php" target="_blank"> Terms and Conditions |
   <a href="https://ebiztechnocrats.com/iittm/refund.php" target="_blank"> Refund Policy | 
   <a href="https://ebiztechnocrats.com/iittm/pricing.php" target="_blank"> Fee </a>| 
   <a href="https://ebiztechnocrats.com/iittm/contact_us.php" target="_blank">Contact Us </a> |
   <a href="https://ebiztechnocrats.com/iittm/Scholarship_and_bank_loan.pdf" target="_blank">Scholarship assistance </a>
    </div>
  </div>

</div>

<script src="<?=base_url();?>themes/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url();?>themes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=base_url();?>themes/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });

  $(document).ready(function(){
    $("#loading").hide();
    $("#MBA_guidline").hide();
    $("#BBA_guidline").hide();
    $("#already").hide();
    $("#otp_textbox").hide();
    $("#verify_otp").hide();
    $("#message_success").hide();
    $("#already_verified_div").hide();
    $("#verified_not_mached").hide();
  });

  $("#course").change(function(){
    var id = $(this).val();
    if(id == 1){$("#BBA_guidline").show(); $("#MBA_guidline").hide();}
    if(id == 2){$("#MBA_guidline").show(); $("#BBA_guidline").hide();}
  });

</script>

<script>

function validateCtrl($scope,$log,$http)
{
    $scope.username = "<?php echo $this->input->cookie('uname'); ?>";
    $scope.login_check = function($event)
    {
      if($scope.LoginForm.$invalid)
      {
        $scope.LoginForm.$submitted=true;
        $event.preventDefault();
      }
    };


      $scope.get_sms = function($event) {
        $("#loading").show();
         var data = angular.element(document.querySelector('#mobile')).val();
         $http({
            method: "get",
            url: "<?php echo site_url('candidate/student_login_otp?data=');?>"+data}).then(function(response){
            if(response.data=="save")
            {
                $("#mobile").attr("disabled","disabled"); 
                $("#otp_textbox").show();
                $("#send_otp").hide();  
                $("#verify_otp").show();
                $("#dynerror").html("");
            }
            else
            {
              $("#dynerror").html("Mobile No. Not found!");
            }
            $("#loading").hide();
          });
        
      };


      $scope.verify_otp = function($event) {
        $("#loading").show();
        var data = angular.element(document.querySelector('#otp_textbox')).val();
         $http({
            method: "get",
            url: "<?php echo site_url('candidate/verified_candidate_number?data=');?>"+data}).then(function(response){
              console.log(response);
             if(response.data=="success")
              {
                window.location= ("candidate_dashboard");
              }
              if(response.data=="failed")
              {
                $("#verified_not_mached").show();
              }
              $("#loading").hide();
          });  
      };


      $scope.resent_otp = function($event) {
        var data = angular.element(document.querySelector('#mobile')).val();
         $http({
            method: "get",
            url: "<?php echo site_url('candidate/resent_candidate_otp?data=');?>"+data}).then(function(response)
            {
              console.log(response.data);
            if(response.data=="save")
            {
              $("#dynmsg").html("OTP has been send Successfully!");
            }
          });  
      };

} 

</script>

</body>
</html>


