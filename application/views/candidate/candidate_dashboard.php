

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
<body class="hold-transition skin-blue sidebar-mini">

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


    


<div class="wrapper" ng-app="" ng-controller="validateCtrl">


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px; background-color: #fff;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <span style="color: green; font-size: 18px;">Welcome to <?php echo $data['first_name']." ".$data['middle_name']." ".$data['last_name'] ?></span>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">

        <div class="col-sm-9">
          <br><br/>
          <div class="row text-center"> 

          <?php if($userdat['course_id']==1){?>
           <a href="show_form_bba/<?php echo $userdat['user_id'] ?>" class="btn btn-success btn-lg" style="margin: 2px;"><i class="fa fa-download"></i>  Download Form</a>
          <?php } else {?>
             <a href="show_form_mba/<?php echo $userdat['user_id'] ?>" class="btn btn-success btn-lg" style="margin: 2px;"><i class="fa fa-download"></i>  Download Form</a>
          <?php }?>


         <a href="#" class="btn btn-info btn-lg" style="margin: 2px;" disabled><i class="fa fa-download"></i> Download Admit Card</a>
        
       
        <a href="update_form" class="btn btn-primary btn-lg" style="margin: 2px;"><i class="fa fa-pencil"></i> Update Form Details</a>


        <a href="view_update_form" class="btn btn-warning btn-lg" style="margin: 2px;"><i class="fa fa-eye"></i> View Form Status</a> 
        
       
                       
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



       <!--  <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <div class="col-lg-3 col-xs-6">
          
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div> -->
        
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
  

  <!-- Control Sidebar -->
</div>
<script src="<?=base_url();?>themes/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url();?>themes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=base_url();?>themes/plugins/iCheck/icheck.min.js"></script>


<script>

function validateCtrl($scope,$log,$http)
{

}
</script>
</body>
</html>


