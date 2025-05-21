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
        Candidate Details
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
       

 	
       <?php if($_REQUEST['status']=='t') {?>

       <div class="col-sm-2"> 
       	<span class="badge badge-danger" style="line-height: 35px; width: 100%; display: grid;">
       		<span style="font-size: 20px;">Present - <span id="present">0</span></span>
		</span>
		</div>
				
		 <div class="col-sm-2"> 
       	<span class="badge badge-danger" style="line-height: 35px; width: 100%; display: grid;">
       		<span style="font-size: 20px;">Absent - <span id="absent">0</span></span>
		</span>
		</div>

				
		 <div class="col-sm-2"> 
       	<span class="badge badge-danger" style="line-height: 35px; width: 100%; display: grid;">
       		<span style="font-size: 20px;">Pass - <span id="pass">0</span></span>
		</span>
		</div>
				
		 <div class="col-sm-2"> 
       	<span class="badge badge-danger" style="line-height: 35px; width: 100%; display: grid;">
       		<span style="font-size: 20px; ">Fail - <span id="fail">0</span></span>
		</span>
		</div>

	<?php } ?>
		

        <div class="col-sm-2 pull-right">
        	<span style="font-size: 25px; color: red; line-height: 35px;">Total Records - <span id="record">0</span></span>
        </div>

        </div>
				

				
				
        <br/>
       
		
			
			
		<div style="overflow:scroll; ">
				
	<table id="item-list-filter" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						
						<th>Sr.</th>
						<th>Roll No.</th>
						<!--th>Exam</th-->
						<th>Course</th>
						<th>Study centre1</th>
						<!--th>Score</th-->
						<th>Full name</th>
						<th>Mobile</th>
						<th>Father Name</th>
						<th>Father Mobile</th>
						<th>Mother Name</th>
						<th>Mother Mobile</th>
						<th>DOB</th>
						<th>Email</th>
						<th>Gender</th>
						<th>Category</th>
						<th>Religion</th>
						<th>Permanent City</th>
						<th>Per. Address</th>
						<th>Corresponding City</th>
						<th>Cors. Address</th>
						<th>Entry DateTime</th>
						<th>Fee DateTime</th>
					
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
		$("#loading").show();
	
	
		$('#item-list_wrapper').hide();
        $('#item-list-filter').show();	

	    $('#item-list-filter').DataTable({
	        "ajax": {
	            url : "<?php echo site_url('exam/exam_wise_candidate_ajax');?>",
				data:{'exam_id':<?php echo $_REQUEST['exam'] ?>,'status':"<?php echo $_REQUEST['status'] ?>"},
	            type : 'POST'
	        	},
	        	initComplete: function(e) {
			       $("#record").html(e.json.recordsTotal);
			       $("#present").html(e.json.present);
			       $("#absent").html(e.json.absent);
			       $("#pass").html(e.json.pass);
			       $("#fail").html(e.json.fail);
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
