<!DOCTYPE html>
<html>
<head>
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
  <link rel="stylesheet" href="<?=base_url();?>themes/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url();?>themes/plugins/iCheck/square/blue.css">

  <script src="<?=base_url();?>themes/js/jquery.min.js"></script>

  <script src="<?=base_url();?>themes/js/angular.min.js"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src='https://www.google.com/recaptcha/api.js'></script>
<style>
    #g-recaptcha-response {
  display: block !important;
  position: absolute;
  margin: -78px 0 0 0 !important;
  width: 302px !important;
  height: 76px !important;
  z-index: -999999;
  opacity: 0;
}
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a><b>Admin</b> Login</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" ng-app=""  ng-controller="validateCtrl">
    <p class="login-box-msg">Sign in to start your session</p>

    <?php // Initializing form
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
    <?php
if (isset($_COOKIE['admin_username']) && isset($_COOKIE['admin_password'])) {
  $id= $_COOKIE['admin_username'];
  $pass= $_COOKIE['admin_password'];
  $checked = 1;
}
else{

  $id="";
  $pass="";
  $checked = 0;
} ?>
      <div class="form-group has-feedback">
        <input type="text"  value="<?php echo $id ?>"  class="form-control" autocomplete="off" name="username" ng-model="username" id="userbame" ng-pattern="/^[A-Za-z0-9]+$/" ng-minlength="4" placeholder="Username" required>
        <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
         <span style="color:red" ng-show="LoginForm.$submitted && LoginForm.username.$invalid">
            <span ng-show="LoginForm.username.$error.required">Username is required.</span>
            
        </span>  -->
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" ng-model="password"  ng-pattern="/^[A-Za-z0-9!@#$%^&*()_]{6,16}$/" ng-minlength="6" ng-maxlength="16" class=form-control id="" value="<?php echo $pass ?>" placeholder="Password" required />
        <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span style="color:red" ng-show="LoginForm.password.$dirty || LoginForm.$submitted && LoginForm.password.$invalid">
          <span ng-show="LoginForm.password.$error.required">Password is required.</span>
                               
                      </span> -->
      </div>

      <div class="form-group has-feedback">
      <div class="g-recaptcha" data-sitekey="6LdHzTQpAAAAAH_Fh4_GsqKHOqDcGFeMFVpvQoUc" style="margin-bottom:2px;"></div>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <?php if($checked == 1){ ?>
              <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="rememberme" checked="checked" />
              <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
            <?php }else{?>

              <input class="form-check-input" id="inputRememberPassword" type="checkbox" name="rememberme" />
              <label class="form-check-label" for="inputRememberPassword">Remember Password</label>

              <?php   } ?>
          
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">

          <button type="submit" name="btnLogin" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
      <div class="row text-center">
        <?php if(hasFlash("loginMsgError")){  ?>
            <span style="color: red; font-weight: bold;"><?php echo getFlash("loginMsgError"); ?></span>
        <?php  } ?>
      </div>
    <?php echo form_close(); ?>
  </div>

    
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?=base_url();?>themes/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url();?>themes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=base_url();?>themes/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>

<script>
window.addEventListener('load', () => {
  const $recaptcha = document.querySelector('#g-recaptcha-response');
  if ($recaptcha) {
    $recaptcha.setAttribute('required', 'required');
  }
})
</script>
<!-- <script>
function validateCtrl($scope)
{
  $scope.username = "<?php echo $this->input->cookie('uname'); ?>";
  $scope.password = "<?php echo $this->input->cookie('upass'); ?>";
   $scope.login_check = function($event)
      {
        if($scope.LoginForm.$invalid)
        {
          $scope.LoginForm.$submitted=true;
          $event.preventDefault();
                            
        }
        };
}
</script> -->
</body>
</html>
