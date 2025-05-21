<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <script src="<?=base_url();?>themes/js/jquery.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
 
</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="home_screen">
<div class="wrapper">

  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(9);
  ?>
	<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Test Center Finalization
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="page-content">
		

            <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="box box-danger">   
                    <div class="box-header with-border">
                      <h3 class="box-title">Test Centers</h3>
                    </div>
                    <div class="box-body box-danger">
                      <div class="row">
                        <div class="col-sm-12">
                             
                               <?php
                                foreach ($center as $centers) {
                                  if($centers['test_center_status']==1){$check="checked";} else{$check="";}
                                  echo "<div class='checkbox'><label><input type='checkbox' class='chk' value='{$centers['test_center_id']}' ng-click='addrow({$centers['test_center_id']})' $check>{$centers['test_center_name']}</label></div>";
                                }
                               ?>
                              
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
              
            </div>
         </div>

    </section>
</div>

<?php $this->load->view('../layout/footer.php'); ?>

<script>
var App = angular.module('myApp', ['ui.bootstrap']); 
function home_screen($scope,$log,$http,$compile)
{
    $("#loading").hide();   

    
    $(".chk").change(function() {
      if($(this).prop('checked')) {
        value = $(this).val();
        $("#loading").show();
          $http({
              method: "get",
              dataType: 'html',
              url: "<?php echo site_url('admin/test_center_finalization_checked_post?data=');?>"+value}).then(function(response){
               window.location.reload();
              }) 
      } else 
      {
          value = $(this).val();
          $("#loading").show();
            $http({
                method: "get",
                dataType: 'html',
                url: "<?php echo site_url('admin/test_center_finalization_unchecked_post?data=');?>"+value}).then(function(response){
                  window.location.reload();
                }) 

      }
    });    

}






</script>

<style>
#loading{
width: 100%;
height: 800px;
position: absolute;
background-color: rgba(0, 0, 0, 0.50) !important;
text-align: center;
padding-top: 30%;
z-index: 99;
	}
</style>



</body>
</html>

