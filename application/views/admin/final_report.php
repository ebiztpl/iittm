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
		sidebar(8);
  ?>
	<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Final Report
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
		    
        <form action="align_center_post" method="post" id="sectionForm">

            <div class="row">
            <div class="col-sm-12">
                <div class="box box-danger">   
                    <div class="box-header with-border">
                      <h3 class="box-title">Search Criteria</h3>
                    </div>
                    <div class="box-body box-danger">

                      

                      <?php
                         if(hasFlash('ViewMsgSuccess')){echo getFlash('ViewMsgSuccess');}
                         if(hasFlash('ViewMsgWarning')){echo getFlash('ViewMsgWarning');}
                      ?> 

                      <div class="row">
                        <div class="col-sm-3">
                           <select class="form-control" ng-model="get_course" id="get_course" name="get_course">
                          <option value="">--Select--</option>
                          <option value="100000">1000</option>
                          <option value="50000">500</option>
                        </select>
                        </div>

                   

                        <div class="col-sm-1">
                          <a class="btn btn-primary" ng-click="get_course_function()" ng-model="search">Show</a>
                        </div>

                  

                        </div>

                        <br/>
                     

                        <div class="row">
                          <div class="col-sm-12">

                            <div >

                            <table class="table table-bordered data-table" id="data-table">
                              <tr>
                                <th>Sr.</th>
                                <th>Full Name</th>
                                <th>Category</th>
                                <th>Course</th>
                                <th>Prefer Study Centre</th>
                                <th>Date of Application</th>
                              </tr>

                             
                              <tr ng-repeat='list in list_items' id="">
                                <td>{{$index+1}}</td>
                                <td>{{list.first_name}}</td>
                                <td>{{list.category}}</td>
                                <td><span ng-if="list.course_id==1">MBA</span><span ng-if="list.course_id==2">BBA</span></td>
                                <td>{{list.study_centre_1}}</td>
                                <td>{{list.created_date}}</td>
                              </tr>
                            </table>

                          </div>

                          </div>
                        </div>

                      </div>
                    </div>
                </div>
              
            </div>

        </form>    
         </div>

    </section>
</div>

<?php $this->load->view('../layout/footer.php'); ?>

<script>
var App = angular.module('myApp', ['ui.bootstrap']); 
function home_screen($scope,$log,$http,$compile,$window)
{
    $("#loading").hide();   
    $scope.list_items =[];
    $scope.get_course_function = function($event) {
       $("#loading").show();
       var course = angular.element(document.querySelector('#get_course')).val();
       
       $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/final_report_get?data=');?>"+course}).then(function(response){
              $scope.list_items = response.data['list'];              
              console.log(response);
              setTimeout(function(){$("#loading").hide()}, 1000);
           })
         };
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


<script type="text/javascript">
    (function() {
    const form = document.querySelector('#sectionForm');
    const checkboxes = form.querySelectorAll('input[type=checkbox]');
    const checkboxLength = checkboxes.length;
    const firstCheckbox = checkboxLength > 0 ? checkboxes[0] : null;

    function init() {
        if (firstCheckbox) {
            for (let i = 0; i < checkboxLength; i++) {
                checkboxes[i].addEventListener('change', checkValidity);
            }

            checkValidity();
        }
    }

    function isChecked() {
        for (let i = 0; i < checkboxLength; i++) {
            if (checkboxes[i].checked) return true;
        }

        return false;
    }

    function checkValidity() {
        const errorMessage = !isChecked() ? 'At least one checkbox must be selected.' : '';
        firstCheckbox.setCustomValidity(errorMessage);
    }

    init();
    })();
  </script>
</body>
</html>

