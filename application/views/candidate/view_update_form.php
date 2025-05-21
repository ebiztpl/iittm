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
  <link rel="stylesheet" href="<?=base_url();?>themes/dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url();?>themes/plugins/iCheck/square/blue.css">

  <script src="<?=base_url();?>themes/js/jquery.min.js"></script>

  <script src="<?=base_url();?>themes/js/angular.min.js"></script>

  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style type="text/css">
    #loading
    {
    width: 100%;
    height: 100%;
    }
    .box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0px 1px 1px #050505;
}
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini" ng-app="myApp" ng-controller="validateCtrl">

<div class="main">
  
  <div class="container container_bg">
    
    <div class="row">
      <img src="<?=base_url();?>themes/dist/img/head.jpg" width="100%" />
    </div>

    <div class="row text-center">
      <h3><b>Online Admission for BBA(TT/2020-23) & MBA(TTM/2020-22)</b>
         <span class="pull-right" style="padding-right: 10px;"><a href="logout" class="btn btn-danger"><i class='fa fa-sign-out'></i> Logout</a></span>
      </h3>
      <hr />
    </div> 


    


<div class="wrapper">


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px; background-color: #fff;">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      
        <div class="col-sm-9">
          
          <div class="row"> 

              <section class="content-header" style="padding:0px;">
                <h1>
                  <span style="color: green; font-size: 18px;">Welcome to <?php echo $data['first_name']." ".$data['middle_name']." ".$data['last_name'] ?> </span>
                  <span class="pull-right">
                   <a href="candidate_dashboard" class="btn btn-danger btn-sm" style=""><i class="fa fa-arrow-left"></i> Back</a>
                 </span>
                </h1>
              </section>

              <br/>
              <table class="table table-hover" id="example2">
              <thead>
                <tr>
                    <th>SrNo.</th>
                    <th>Subject</th>
                    <th>Form Desc</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
              </thead>
              <tbody>
                  <tr ng-repeat='list in list_items'>
                     <td>{{$index + 1}}</td>
                     <td>{{list.subject_line}}</td>
                     <td>{{list.form_desc}}</td>
                     <td>{{list.post_date | date: 'dd-MM-yyyy'}}</td>
                     <td>
                       <span ng-if="list.status == 0" class="text-red"> <b>Pending</b></span>
                      <span ng-if="list.status == 1" class="text-green"> <b>Complete</b></span>
                     </td>
                  <tr>
              </tbody>
              </table>


           
          </div>


        </div>

        <div class="col-sm-3">
          <div class="box box-success">
            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-comments-o"></i>
              <h3 class="box-title">News & Update</h3>
            </div>
              
              <div class="box-body" style="min-height: 200px; text-align: center;">
                <marquee direction="up" scrollamount="3" height="200" onmouseover="this.stop()" onmouseout="this.start()">Welcome to Indian Institute of Tourism and Travel Management (IITTM) <br/>

                </marquee>
              </div>
            
          </div>

        </div>

      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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
</body>
</html>
<script>
var App = angular.module('myApp', ['ui.bootstrap']); 
function validateCtrl($scope,$log,$http,$compile)
{
  $scope.list_items = <?php echo json_encode($result);?>;
}
</script>

