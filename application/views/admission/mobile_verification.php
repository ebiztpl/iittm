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
      <h3><b>Online Admission for BBA(TT/2022-25) & MBA(TTM/2022-24)</b>
      </h3>
      <hr/>
    </div> 


     <div class="row" style="margin-bottom: 10px;">
      <div class="col-sm-6">
        
      </div>
      <div class="col-sm-6 text-right">
        
      </div>
    </div>

    <div class="row" ng-app="" ng-controller="validateCtrl" style="margin-top: 1%; margin-bottom: 2%;">
		
		<div class="col-sm-12">
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

         
      <h4 class="heading_ram" style="padding-bottom: 0px; color: red; padding-left:20px; padding-right: 20px;">
      Please read these instructions carefully:
              
    </h4>

      <ul class="list" style="">
        <li>Your mobile number need to be verified only once. This mobile number will be used for further communication. Please enter mobile number which is in use.</li>
        <li>If you have not paid the fee after filling form, you have to fill your form again after login.</li>
        <li>You have to upload your photograph and signature picture while filling form. Both these pictures should be in <b>jpeg,jpg or png</b> format only, and file size <br>should not exceed <b>500 KB</b>.</li>
        <li>Admit card for written admission test will have test center details also. You will get your admit card along with test center details 15 days prior to the test date.</li>
        <li>Admit card will be sent on your email id. You will also receive your admit card on your whatsapp number. You can also download your admit card from IITTM website. </li>
        <li>In case of any query/issue or related concern, you can <a href="contact" target="_blank">contact us.</a></li>
      </ul>

<hr/>
        <div class="col-sm-4 col-xs-12 col-sm-offset-4 text-left" style="border: solid 1px #e4e4e4;">
          <h4 class="heading_ram">Mobile Verification</h4>
          <div class="form-group has-feedback">
          <input type="text" class="form-control" autocomplete="off" name="mobile" id="mobile" ng-model="mobile" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="10" placeholder="Enter 10 digit mobile no." required >
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
           <a class="btn btn-primary" ng-model="submit" ng-click="get_sms()" ng-hide="LoginForm.mobile.$invalid" id="send_otp">Register</a>
           <input type="text" class="form-control" name="otp_textbox" id="otp_textbox" placeholder="Enter 6 digit OTP">
        </div>

          <div class="form-group has-feedback text-center" id="verify_otp">
             <a class="btn btn-primary" ng-model="submit" ng-click="verify_otp()" id="verfied_button">Verify OTP</a>
             <a class="btn btn-success" id="resend_button" ng-click="resent_otp()">Resend OTP</a>
          </div>

           <div class="form-group has-feedback text-center" id="message_success">
            <span style="color:blue" id="already_verified">Your Mobile No. has already Verified</span><br/>
            <span style="color:blue" id="already">Your Mobile Number has been Verified Successfully</span><br/>
            <span style="font-size: 18px; color: green;">You are being redirected to next step in <span class="timeLeft">5</span></span> sec.
           </div>

           <div class="form-group has-feedback text-center" id="already_verified_div">
            <span style="color:blue" id="already_verified">Your Mobile No. has already Verified</span><br/>
            <span style="font-size: 18px; color: green;">You are being redirected to next step in <span class="timeLeft">5</span></span> sec.
           </div>
		   
		    <div class="form-group has-feedback text-center" id="save_res">
            <span style="color:blue" id="already_verified">Your Mobile No. has been Successfully Registered</span><br/>
            <span style="font-size: 18px; color: green;">You are being redirected to next step in <span class="timeLeft">5</span></span> sec.
           </div>

           <div class="form-group has-feedback text-center" id="verified_not_mached">
             <span style="color:red">Wrong OTP. check again</span>
           </div>

             <div id="loading" class="text-center"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
 
      </div>

      <div class="col-sm-3 col-xs-12 text-center" style='display:none;'>
         <span class="" style="font-size: 17px; font-weight: bold; color: red;"><img src="<?=base_url();?>themes/dist/img/arrow.gif" width="30" /><br/><a href="<?php echo base_url();?>index.php/candidate/student_login" class="blinking">Candidate Login</a></span>

      </div>

    
	<br/><br/><br/><br/><br/>
    <hr/>
   <div style="text-align:center;font-size: 22px;margin-bottom: 15px;letter-spacing: 1px; margin-top: 15px;">
   <a href="https://ebiztechnocrats.com/iittm_2021/about_us.php" target="_blank">About Us</a> | 
   <a href="https://ebiztechnocrats.com/iittm_2021/privacy.php" target="_blank">Privacy Policy</a> | 
   <a href="https://ebiztechnocrats.com/iittm_2021/terms.php" target="_blank"> Terms and Conditions |
   <a href="https://ebiztechnocrats.com/iittm_2021/refund.php" target="_blank"> Refund Policy | 
   <a href="https://ebiztechnocrats.com/iittm_2021/pricing.php" target="_blank"> Fee </a>| 
   <a href="https://ebiztechnocrats.com/iittm_2021/contact_us.php" target="_blank">Contact Us </a> |
   <a href="https://ebiztechnocrats.com/iittm_2021/Scholarship_and_bank_loan.pdf" target="_blank">Scholarship assistance </a>
    </div>
    </div>

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
	$("#save_res").hide();
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
            url: "<?php echo site_url('admission/mobile_number?data=');?>"+data}).then(function(response){
              
              //status 2 candidate already fill full form with same number
              if(response.data == 2)
              {
                $("#already").show();
                $("#verify_otp").hide();
              }
             
              //status 1 candidate verified the number but not complete form fill 
              else if(response.data == 1)
              {
                $("#already_verified_div").show();
                $("#already_verified").show();
                $("#send_otp").hide(); 
                window.setInterval(function() {
                var timeLeft = $(".timeLeft").html();
                    if(eval(timeLeft) == 0) {
                            window.location= ("criteria");
                    } else {
                        $(".timeLeft").html(eval(timeLeft)- eval(1));
                    }
                }, 500);
              }

              else
              {
                if(response.data=="save")
                {
                   
					
					$("#save_res").show();
                    window.setInterval(function() {
                      var timeLeft = $(".timeLeft").html();
                          if(eval(timeLeft) == 0) {
                                  window.location= ("criteria");
                          } else {
                              $(".timeLeft").html(eval(timeLeft)- eval(1));
                          }
                      }, 500);
                }
                else
                {

                }
               
              }
              $("#loading").hide();
              
          });
        
      };


      $scope.verify_otp = function($event) {
        $("#loading").show();
        var data = angular.element(document.querySelector('#otp_textbox')).val();
         $http({
            method: "get",
            url: "<?php echo site_url('admission/verified_number?data=');?>"+data}).then(function(response){
              console.log(response);
             if(response.data=="success")
              {
                $("#message_success").show();
                $("#verfied_button").attr("disabled","disabled"); 
                $("#resend_button").attr("disabled","disabled");
                $("#already_verified").hide();
                $("#verified_not_mached").hide();
                window.setInterval(function() {
                var timeLeft = $(".timeLeft").html();
                    if(eval(timeLeft) == 0) {
                            window.location= ("criteria");
                    } else {
                        $(".timeLeft").html(eval(timeLeft)- eval(1));
                    }
                }, 500);
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
            url: "<?php echo site_url('admission/resent_otp?data=');?>"+data}).then(function(response)
            {
            if(response.data=="success")
            {

            }
          });  
      };

} 

</script>

</body>
</html>


