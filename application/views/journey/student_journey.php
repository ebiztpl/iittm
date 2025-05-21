<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <script src="<?=base_url();?>themes/js/jquery.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

  <style type="text/css">


.badge.badge-default {
  background-color: #B0BEC5
}

.badge.bg-primary {
  background-color: #2196F3 !important;
}

.badge.badge-secondary {
  background-color: #323a45;
}

.badge.bg-success {
  background-color: #459314;
}

.badge.badge-warning {
  background-color: #FFD600;
}

.badge.badge-info {
  background-color: #29B6F6;
}

.badge.bg-danger {
  background-color: #ef1c1c;
}

.badge.badge-outlined {
  background-color: transparent
}

.badge.badge-outlined.badge-default {
  border-color: #B0BEC5;
  color: #B0BEC5
}

.badge.badge-outlined.badge-primary {
  border-color: #2196F3;
  color: #2196F3
}

.badge.badge-outlined.badge-secondary {
  border-color: #323a45;
  color: #323a45
}

.badge.badge-outlined.badge-success {
  border-color: #64DD17;
  color: #64DD17
}

.badge.badge-outlined.badge-warning {
  border-color: #FFD600;
  color: #FFD600
}

.badge.badge-outlined.badge-info {
  border-color: #29B6F6;
  color: #29B6F6
}

.badge.badge-outlined.badge-danger {
  border-color: #ef1c1c;
  color: #ef1c1c
}
  </style>
</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="Dashboard_Details">
<div class="wrapper">
<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
    sidebar(1206);
  ?>
  
  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Student Journey
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Journey</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="page-content">
    <?php
      // Initializing form
      $lFormAttrb = array(
        'role' => 'form',
        'id' => 'RegisterForm',
        'class' => 'form-horizontal',
        'novalidate'=>'novalidate',
        'ng-submit'=> 'assign_Submit($event)'
      );
      echo form_open('',$lFormAttrb); 
    ?>

    <div class="box">   
      <div class="box-body">
  

        <div class="row" style="margin-top:10px; ">
      <!--   <div class="col-sm-2">
          
            <select class="form-control" name="exam" id="exam" required="" style="height: 45px;">
                  <option value="">--Select Exam--</option>
                  <?php 
                  foreach ($result as $key => $master) {
                    echo "<option value=".$master['id'].">".$master['exam_name']."</option>";
                  }
                  ?>
                </select>
          </div> -->


    <!--   <div class="col-sm-2">
          
            <select class="form-control" name="course" id="course" required="" style="height: 45px;">
                  <option value="">--Select Course--</option>
                  <option value="1">BBA</option>
                  <option value="2">MBA</option>
                  
                </select>
          </div>

       <div class="col-sm-1"> 
        <span class="badge badge-danger" style="line-height: 20px; width: 100%; display: grid;">
      <input type="radio" value='2' id="present" name="attendance"  /> Present 
    </span>
    </div>
        
    <div class="col-sm-1">
      <span class="badge badge-danger" style="line-height: 20px; width: 100%; display: grid;">
      <input type="radio" value='3' id="absent" name="attendance" /> Absent 
      </span>
    </div> 

        
    <div class="col-sm-1">
      <span class="badge badge-danger" style="line-height: 20px; width: 100%; display: grid;">
      <input type="radio" value='2' id="pass" name="status" /> Pass 
      </span>
    </div> -->
        
  <!--  <div class="col-sm-1">
      <span class="badge badge-danger" style="line-height: 20px; width: 100%; display: grid;">
      <input type="radio" value='3' id="fail" name="status" /> Fail
    </span>
    </div> 


    <div class="col-sm-1">
            <a class="btn btn-success" ng-model="btn" ng-click="search_data_exam()" ng-hide="to==''" style="line-height: 30px;"><i class="fa fa-search"></i> Search</a>
        </div> -->

        <div class="col-sm-2 pull-right">
          <span style="font-size: 20px; color: green">Total Records - <span id="record">0</span></span>
        </div>

        </div>
        

        
        
        <br/>
       
    
      
      

    <div style="overflow:scroll; height:500px;">
        <table id="item-list-filter" class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            
            <th class="tbl-header">Sr.</th>
            <th class="tbl-header">Roll No.</th>
            <th class="tbl-header">Course</th>
            <th class="tbl-header">Centre</th>
            <th class="tbl-header">Full name</th>
            <th class="tbl-header">Mobile</th>
            <!-- <th class="tbl-header">Father</th>
            <th class="tbl-header">Category</th> -->
            <th class="tbl-header">Application <br/>Date</th>
            <th class="tbl-header">Fee</th>
            <?php $en =1; $gg=1; foreach ($exam as $key => $exams) {

              if($exams['exam_type']=='entrance'){
                $type="Entrance: Round-".$en;
                $en++;
              }
              if($exams['exam_type']=='gdpi'){
                $type="GD/PI Round-".$gg;
                $gg++;
              }
             ?>
              
              <th class="tbl-header"><?=$type?><br/>(<?=date('d-m-Y',strtotime($exams['start_datetime']))?>)</th>

            <?php } ?>
          
          </tr>
          </thead>
          <tbody>


    </tbody>
  </table>
</div>


</div>

<b><span id="loadingddupe" style="display:none;">Checking.........</span></b>
<span id="warning_msg" class="error"></span>
</div>
<!-- Begin Action Navigation Bar -->
      
<?php echo form_close(); ?>     
</div>
</section>
</div>



<?php $this->load->view('../layout/footer.php'); ?>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
</body>
</html>

<script>
$(document).ready(function(){
    $("#loading").show();
  
    $('#item-list-filter').DataTable({
        "ajax": {
            url : "<?php echo site_url('journey/getdata');?>",
            type : 'POST'
          },
          initComplete: function(e) {
           $("#record").html(e.json.recordsTotal);
           $("#loading").hide();
       },
          "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
      "order": [0, "asc"],
            "bInfo": true,
            "bAutoWidth": false,
            "searching": true,
            "bRetreive": true,
            "destroy": true,
            dom: 'Bfrtip',
          lengthMenu:[[25, 50, -1 ],['25 rows', '50 rows', 'Show all' ]],
          buttons:['copy', 'csv', 'excel', 'pdf', 'print'],
      });
});
var App = angular.module('myApp', ['ui.bootstrap']); 
function Dashboard_Details($scope,$log,$http,$compile)
{


  $scope.list_items = "";
  $scope.sampledate = new Date();


    $scope.search_data_exam = function() {

    var whereClauses = []; 

        if($("#exam").val() !="") 
        {
            whereClauses.push('ce.exam_id = '+$("#exam").val());
        }

         if($("#course").val() !="") 
        {
            whereClauses.push('um.course_id = '+$("#course").val());
        }

        if($('#present').is(":checked")){
        whereClauses.push('cr.attendance = "present"');
      }

      if($('#absent').is(":checked")){
        whereClauses.push('cr.attendance = "absent"');
      }

      if($('#pass').is(":checked")){
        whereClauses.push('cr.exam_status = "pass"');
      }

      if($('#fail').is(":checked")){
        whereClauses.push('cr.exam_status = "fail"');
      }

      
        var withand = whereClauses.join(" AND ");
          if (whereClauses.length != 0) 
          { 
            var where = ' WHERE '+ withand;
          } 
    
       

        $('#item-list_wrapper').hide();
        $('#item-list-filter').show();  

      $('#item-list-filter').DataTable({
          "ajax": {
              url : "<?php echo site_url('exam/filter_exam_search');?>",
        data:{'data':where},
              type : 'POST'
            },
            initComplete: function(e) {
             $("#record").html(e.json.recordsTotal);
         },
            "bPaginate": true,
              "bLengthChange": false,
              "bFilter": false,
              "bSort": true,
        "order": [0, "asc"],
              "bInfo": true,
              "bAutoWidth": true,
              "searching": true,
              "bRetreive": true,
              "destroy": true,
              dom: 'Bfrtip',
            lengthMenu:[[25, 50, -1 ],['25 rows', '50 rows', 'Show all' ]],
            buttons:['copy', 'csv', 'excel', 'pdf', 'print'],
        });

    };






}

</script>



<style>
.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
    width: 100%;
}

.box-header .col-lg-2 {
    width: 16.66666667%;
    margin-left: 10px;
    margin-right: 10px;
}
.box-header .col-lg-3 {
    width: 25%;
    margin-left: 10px;
    margin-right: 10px;
}

#loading{
  width: 100%;
height: 800px;
position: absolute;
background-color: rgba(0, 0, 0, 0.50) !important;
text-align: center;
padding-top: 30%;
z-index: 99999;
  }
</style>
