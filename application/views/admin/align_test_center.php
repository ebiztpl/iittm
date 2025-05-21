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
		sidebar(10);
  ?>
	<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Test Center Assign to Candidate
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
                          <option value="1">BBA</option>
                          <option value="2">MBA</option>
                        </select>
                        </div>

                        <div class="col-sm-3">
                          <select class="form-control" ng-model="ddl_get_center" id="get_center">
                              <option value="">--Select--</option>
                               <?php 
                                foreach ($centers as $item) 
                                {
                                  echo "<option value='{$item['test_center_name']}'>{$item['test_center_name']}</option>";
                                }
                              ?>
                        </select>
                        </div>

                        <div class="col-sm-1">
                          <a class="btn btn-primary" ng-click="get_course_function()" ng-model="search">Show</a>
                        </div>

                        <div class="col-sm-5 text-right">
                          <b>Total Application Received :</b> <span class="btn btn-success btn-sm" style="padding:2px; font-size: 20px; line-height: 1;">{{total_application}}</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <b>Test Center Assigned :</b> <span class="btn btn-primary btn-sm"  style="padding:2px; font-size: 20px; line-height: 1;">{{total_testcenter}}</span>
                        </div>

                        </div>

                        <br/>
                     

                        <div class="row">
                          <div class="col-sm-12">

                            <div style="height: 300px; overflow-y: scroll;">

                            <table class="table table-bordered">
                              <tr>
                                <th><input type="checkbox" name="checkedAll" id="checkedAll" /> All</th>
                                <th>Full Name</th>
                                <th>First</th>
                                <th>Second</th>
                                <th>Third</th>
                                <th>Fourth</th>
                              </tr>

                             
                              <tr ng-repeat='list in list_items' id="">
                                <td><input type="checkbox" name="checkAll[]" class="checkSingle" value="{{list.user_id}}" /></td>
                                <td>{{list.first_name}}</td>
                                <td>{{list.study_centre_1}}</td>
                                <td>{{list.study_centre_2}}</td>
                                <td>{{list.study_centre_3}}</td>
                                <td>{{list.study_centre_4}}</td>
                              </tr>
                            </table>

                          </div>

                          </div>
                        </div>

                        <br/>

                        <div class="row">
                          <div class="col-sm-3">
                            <label>Assign To</label>
                            <select class="form-control" required="" name="assign_test_center">
                              <option value="">--Select--</option>
                              <?php 
                                foreach ($centers as $item) 
                                {
                                  echo "<option value='{$item['test_center_id']}'>{$item['test_center_name']}</option>";
                                }
                              ?>
                            </select>
                          </div>

                          <div class="col-sm-2">
                            <button class="btn btn-danger" style="margin-top: 24px;">Assign</button>
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
    $scope.total_application = 0;
    $scope.total_testcenter =0;
    $scope.ddl = <?php echo json_encode($centers) ?>
   
   

    $scope.list_items =[];
    $scope.get_course_function = function($event) {
       $("#loading").show();
       var course = angular.element(document.querySelector('#get_course')).val();
       var center_name = angular.element(document.querySelector('#get_center')).val();
       if(center_name !='')
       {
            var center_id = $.grep($scope.ddl, function (fruit) {return fruit.test_center_name == center_name;})[0].test_center_id;
       }

       var data = course+'~'+center_name+'~'+center_id; 
       $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/align_test_center_get?data=');?>"+data}).then(function(response){

              
              $scope.total_application = response.data['total_application'];
              $scope.total_testcenter = response.data['total_center'];
              $scope.list_items = response.data['list'];
              
              var newstr = '[' + response.data['arr_total_center'].join(', ') + ']';
              console.log(newstr);
              setTimeout(function(){
              var arrayValue = newstr;
              $(".checkSingle").filter(function () {
                  return arrayValue.indexOf(+this.value) != -1 }).closest("td").find('input[type="checkbox"]').prop('checked', true); 
               }, 1000);

              setTimeout(function(){$("#loading").hide()}, 1000);

           })
         };
}




$("#checkedAll").change(function(){
    if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;
      })              
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
      })              
    }
  });







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

