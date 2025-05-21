<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <script src="<?=base_url();?>themes/js/jquery.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="Dashboard_Details">
<div class="wrapper">
<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(1205);
  ?>
	
	

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Find Candidate
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
	

        <div class="row" style="margin-top:10px;">
        <div class="col-sm-2">
          
            <select class="form-control" name="exam" id="exam" required="" style="height: 45px;">
                	<option value="">--Select Exam--</option>
                	<?php 
                	foreach ($result as $key => $master) {
                		echo "<option value=".$master['id'].">".$master['exam_name']."</option>";
                	}
                	?>
                </select>
          </div>


 		  <div class="col-sm-2">
          
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
		</div>
				
		<div class="col-sm-1">
			<span class="badge badge-danger" style="line-height: 20px; width: 100%; display: grid;">
			<input type="radio" value='3' id="fail" name="status" /> Fail
		</span>
		</div> 


		<div class="col-sm-1">
          	<a class="btn btn-success" ng-model="btn" ng-click="search_data_exam()" ng-hide="to==''" style="line-height: 30px;"><i class="fa fa-search"></i> Search</a>
        </div>

        <div class="col-sm-2 pull-right">
        	<span style="font-size: 20px; color: green">Total Records - <span id="record">0</span></span>
        </div>

        </div>
				

				
				
        <br/>
       
		
			
			

		<div style="overflow:scroll; height:500px;">
				<table id="item-list-filter" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						
						<th class="tbl-header">Exam</th>
						<th class="tbl-header">Roll No.</th>
						<th class="tbl-header">Centre</th>
						<th class="tbl-header">Score</th>
						<th class="tbl-header">Full name</th>
						<th class="tbl-header">Mobile</th>
						<th class="tbl-header">Father Name</th>
						<th class="tbl-header">Attendance</th>
						<th class="tbl-header">Exam Status</th>
						<!-- <th class="tbl-header">Marks</th>
						<th class="tbl-header">Slot</th> -->
					
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



<div class="modal fade" id="exam_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Candidate Exam Data</h5>

        <span data-dismiss="modal" style="position: absolute; top: 15px; right: 15px; cursor: pointer;"><i class="fa fa-close"></i></span>
        
      
      
      </div>
      <div class="modal-body">
        <form action="#" id="exam_data_save" method="POST" >
          <input type="hidden" id="user_id" name="user_id" />
              <div class="form-group">
                <label>Select Exam <span style='color:red;'>*</span></label>
                <select class="form-control" name="exam_id" id="exam_id" required="">
                	<option value="">--Select--</option>
                	<?php 
                	foreach ($result as $key => $master) {
                		echo "<option value=".$master['id'].">".$master['exam_name']."</option>";
                	}
                	?>
                </select>
              </div>

                  <div class="form-group">
                <label>Exam Marks<span style='color:red;'>*</span></label>
                <input type="text" id="exam_marks" class="form-control" name="exam_marks" required="" />
                
              </div>

               <div class="form-group">
                <label>Exam Status <span style='color:red;'>*</span></label>
                <br/>
                <input type="radio" name="exam_status" required="" value="pass"> Pass &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="exam_status" required="" value="fail"> Fail &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="exam_status" required="" value="absent"> Absent
                
              </div>


        

              <button class="btn btn-primary" name="btnsubmit">Save</button>
            </form>
      </div>
     
    </div>
  </div>
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
	$("#loading").hide();
	
	$(document).on('click',".exam_status", function() {
		if($(this).is(':checked')){
			var id = $(this).attr('data-id'); 
			$("#user_id").val(id);
			$("#exam_status").modal('show');
		}
	});



	$(document).on('click',".status", function() {

		var id = $(this).attr('data-id');
		var txt = $(this).attr('data-text');

		 $.ajax({
	        url: "<?php echo site_url('exam/exam_attendance');?>", 
	        data: {'id':id, 'txt':txt}, 
	        type: "POST", 
	        dataType: 'json',
	        success: function (e) {
	        	console.log(e);
	        },
	    }); 

	});


	$(document).on('click',".result", function() {

		var id = $(this).attr('data-id');
		var txt = $(this).attr('data-text');

		$.ajax({
	        url: "<?php echo site_url('exam/exam_result');?>", 
	        data: {'id':id, 'txt':txt}, 
	        type: "POST", 
	        dataType: 'json',
	        success: function (e) {
	        	console.log(e);
	        },
	    }); 

	});


	// $(document).on('input',".marks", function() {

	// 	var id = $(this).attr('data-id');
	// 	var txt = $(this).val();

	// 	console.log(id+'-'+txt);

	// });


});
var App = angular.module('myApp', ['ui.bootstrap']); 
function Dashboard_Details($scope,$log,$http,$compile)
{


	$scope.list_items = "";
	$scope.sampledate = new Date();


    $scope.search_data_exam = function() {

    	$("#loading").show();

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
