
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
<script src='https://www.google.com/recaptcha/api.js'></script>
  <style>
  .require{color:red;}
  </style>
</head>
<body ng-app="" ng-controller="home_screen">
<div class="main">
  <div class="container container_bg" style="height:auto;">
    
    <div class="row">
      <img src="<?=base_url();?>themes/dist/img/head.jpg" width="100%" />
    </div>

    <div class="row text-center">
      <h3>
        <b>
       Query Form

      </b></h3>
      <hr/>
    </div> 


     

<div class="row text-center">
   <p style="color:#11a656; font-size: 20px;">If you have any query/issue while filing admission form or any related concern, please fill the below form.<br/> We will be happy to help you.</p>  
   
      <?php
       if(hasFlash('ViewMsgSuccess')){echo getFlash('ViewMsgSuccess');}
       ?>  
 </div>

<br/>
<br/>

<?php // Initializing form
            $lFormAttrb = array(
              'role' => 'form',
              'id' => 'LoginForm',
              'name'=>'LoginForm',
              'method' => 'POST',
              'novalidate'=>'novalidate',
              'ng-submit'=> 'login_check($event)',
              'enctype'=> 'multipart/form-data'
            );
            echo form_open('',$lFormAttrb); 
          ?>  
<div class="row">
<div class="col-sm-3">
      <div class="form-group has-feedback">
      <label>Course Applied<span class="require">*</span></label>
      <select class="form-control required" name="course" required="" id="course" ng-model="course">
        <option value="">--Select--</option>
        <option value="1">BBA(TT)-2021-24</option>
        <option value="2">MBA(TTM)-2021-23</option>
      </select>
      <span style="color:red" ng-show="LoginForm.course.$dirty && LoginForm.course.$invalid || LoginForm.$submitted && LoginForm.course.$invalid">
                  <span ng-show="LoginForm.course.$error.required">field is required.</span>
                </span>
    </div>
</div>
<div class="col-sm-3">
   <div class="form-group has-feedback">
                <label>Your Name<span class="require">*</span></label>
                <input type="text" class="form-control" name="your_fname" id="your_fname" autocomplete="off" ng-model="your_fname" required="">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <span style="color:red" ng-show="LoginForm.your_fname.$dirty && LoginForm.your_fname.$invalid || LoginForm.$submitted && LoginForm.your_fname.$invalid">
                  <span ng-show="LoginForm.your_fname.$error.required">field is required.</span>
                </span> 

              </div>
</div>
<div class="col-sm-3">
  <div class="form-group has-feedback">
              <label>Your Email Id<span class="require">*</span></label>
              <span class="fa fa-envelope form-control-feedback" ></span>
               <input type="text" class="form-control" name="your_txt_email" id="your_txt_email" autocomplete="off" ng-pattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/" ng-model="your_txt_email" required="">
              <span style="color:red" ng-show="LoginForm.your_txt_email.$dirty && LoginForm.your_txt_email.$invalid || LoginForm.$submitted && LoginForm.your_txt_email.$invalid">
                  <span ng-show="LoginForm.your_txt_email.$error.required">field is required.</span>
                  <span ng-show="LoginForm.your_txt_email.$invalid" ng-hide="LoginForm.your_txt_email.$error.required">Invalid email </span>
                </span> 
         </div>
</div>
<div class="col-sm-3">

<div class="form-group has-feedback">
          <label>Your Mobile Number<span class="require">*</span></label>
          <input type="text" class="form-control" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="10" id="your_father_mobile" name="your_father_mobile" ng-model="your_father_mobile" required="" autocomplete="off">
           <span class="fa fa-phone form-control-feedback" style="padding-top: 0px;"></span>
           <span style="color:red" ng-show="LoginForm.your_father_mobile.$dirty && LoginForm.your_father_mobile.$invalid || LoginForm.$submitted && LoginForm.your_father_mobile.$invalid">
                  <span ng-show="LoginForm.your_father_mobile.$error.required">field is required.</span>
                  <span ng-show="LoginForm.your_father_mobile.$invalid" ng-hide="LoginForm.your_father_mobile.$error.required">Invalid mobile number.</span>
           </span>  
          </div>
</div>
</div>


<div class="row">

<div class="col-sm-3">
  <div class="form-group has-feedback">
              <label>Email Id Filled for Registration<span class="require">*</span></label>
              <span class="fa fa-envelope form-control-feedback" ></span>
               <input type="text" class="form-control" name="txt_email" id="txt_email" autocomplete="off" ng-pattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/" ng-model="txt_email" required="">
              <span style="color:red" ng-show="LoginForm.txt_email.$dirty && LoginForm.txt_email.$invalid || LoginForm.$submitted && LoginForm.txt_email.$invalid">
                  <span ng-show="LoginForm.txt_email.$error.required">field is required.</span>
                  <span ng-show="LoginForm.txt_email.$invalid" ng-hide="LoginForm.txt_email.$error.required">Invalid email </span>
                </span> 
         </div>
</div>
<div class="col-sm-3">

<div class="form-group has-feedback">
          <label>Mobile Number Filled for Registration<span class="require">*</span></label>
          <input type="text" class="form-control" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="10" id="father_mobile" name="father_mobile" ng-model="father_mobile" required="" autocomplete="off">
           <span class="fa fa-phone form-control-feedback" style="padding-top: 0px;"></span>
           <span style="color:red" ng-show="LoginForm.father_mobile.$dirty && LoginForm.father_mobile.$invalid || LoginForm.$submitted && LoginForm.father_mobile.$invalid">
                  <span ng-show="LoginForm.father_mobile.$error.required">field is required.</span>
                  <span ng-show="LoginForm.father_mobile.$invalid" ng-hide="LoginForm.father_mobile.$error.required">Invalid mobile number.</span>
           </span>  
          </div>
</div>

  
<div class="col-sm-3">

      <div class="form-group">
      <br/>
    <label>Is it<span class="require">*</span></label> &nbsp;
     
    <input type="radio" name="form_type" id="form_type" ng-model="form_type" value="query" required> Query&nbsp; &nbsp;
    <input type="radio" name="form_type" id="form_type" ng-model="form_type" value="issue" required> Issue
<br/>
     <span style="color:red" ng-show="LoginForm.form_type.$dirty && LoginForm.form_type.$invalid || LoginForm.$submitted && LoginForm.form_type.$invalid">
                  <span ng-show="LoginForm.form_type.$error.required">field is required.</span>
                  <span ng-show="LoginForm.form_type.$invalid" ng-hide="LoginForm.form_type.$error.required">Invalid mobile number.</span>
           </span>  

    </div>  
     
</div>


  
</div>


<div class="row">
  
  <div class="col-sm-12">

  <div class="form-group has-feedback">
          <label>Query/Issue Description.<span class="require">*</span></label>
          <textarea type="text" class="form-control" id="problem" name="problem" ng-model="problem" required="" autocomplete="off" rows="8"></textarea>
           <span class="fa fa-question form-control-feedback" style="padding-top: 0px;"></span>
           <span style="color:red" ng-show="LoginForm.problem.$dirty && LoginForm.problem.$invalid || LoginForm.$submitted && LoginForm.problem.$invalid">
                  <span ng-show="LoginForm.problem.$error.required">field is required.</span>
                  
           </span>  
          </div>

  </div>

  <div class="col-sm-3">

  <div class="image-upload" style="margin-top: 0px;">
         
          <label>Upload any screen shot</label>
          <input type="file" id="file-input" name="file" type="file" ng-model="file" onchange="angular.element(this).scope().setFile(this)">
              <br/>    
          <span style="color: red;">{{FileMessage}}</span>

        </div>


  </div>



</div>

  <div class='form-group text-center'>
   <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>
     <button class="btn btn-success btn-lg" name="btnSubmit">Submit</button>
  </div> 
        
</div>
       
             <?php echo form_close(); ?>           
    </div>  

	</div>
	</div>



<script>

function home_screen($scope,$log,$http,$window)
{
    $scope.FileMessage="";
    $scope.login_check = function($event)
    {
      
      console.log($scope.LoginForm);
      if($scope.LoginForm.$invalid)
      {

        $scope.LoginForm.$submitted=true;
        $event.preventDefault();
      }
    };


     $scope.setFile = function(element) {
      $scope.$apply(function($scope) {
        $scope.theFile = element.files[0];
        $scope.FileMessage = '';
        var filename = $scope.theFile.name;
        var index = filename.lastIndexOf(".");
        var strsubstring = filename.substring(index, filename.length);
        if(strsubstring == '.png' || strsubstring == '.jpeg' || strsubstring == '.png' || strsubstring == '.gif' || strsubstring == '.jpg')
        {

          var f = element.files[0].size;
          if(f > 512000)
          {  
            $scope.FileMessage = 'Size Below 500KB';
          }
          else
          {
            $scope.FileMessage='';
          }
        }
        else {
              $scope.theFile = '';
              $scope.FileMessage = 'please upload correct File, extension should be .jpg, .jpeg, .png';
        }
    });        
  };
}
</script>

</body>
</html>
