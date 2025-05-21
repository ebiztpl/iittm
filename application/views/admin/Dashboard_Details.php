<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('../layout/head.php'); ?>
	<script src="<?= base_url(); ?>themes/js/jquery.min.js"></script>
	<script src="<?= base_url(); ?>themes/js/angular.min.js"></script>
	<script src="<?= base_url(); ?>themes/js/angular-ui.min.js"></script>
</head>

<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="Dashboard_Details">
	<div class="wrapper">

		<?php $this->load->view('../layout/header.php'); ?>
		<!-- Left side column. contains the logo and sidebar -->

		<?php $this->load->view('../layout/sidemenu.php');
		sidebar(2);
		?>


		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					All Registration
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
						'novalidate' => 'novalidate',
						'ng-submit' => 'assign_Submit($event)'
					);
					echo form_open('', $lFormAttrb);
					?>

					<div class="box">
						<div class="box-body">
							<div class="row">
								<div class="col-sm-2">
									<input type="text" class="form-control datepicker" placeholder="From Date" id="from" ng-model="from" require="" autocomplete="off">
								</div>
								<div class="col-sm-2">
									<input type="text" class="form-control datepicker" placeholder="To Date" id="to" ng-model="to" required="" autocomplete="off">
								</div>



								<div class="col-sm-2">
									<select class="form-control" id="course" required="">
										<option value="1,2">All Course</option>
										<option value="1">BBA</option>
										<option value="2">MBA</option>
									</select>
								</div>
								<div class="col-sm-2" style="display:none;">
									<select class="form-control" id="status" required="">
										<option value="1,2">All</option>
										<option value="1">Mobile Verified</option>
										<option value="2">Paid</option>
									</select>
								</div>

								<div class="col-sm-2">

									<select class="form-control ng-pristine ng-valid" name="study_center" id="study_center" ng-model="study_center">
										<option value="">--Select Study Center--</option>
										<option value="Gwalior">Gwalior</option>
										<option value="Bhubaneswar">Bhubaneswar</option>
										<option value="Noida">Noida</option>
										<option value="Nellore">Nellore</option>
										<option value="Goa">NIWS-GOA</option>
									</select>
								</div>
								<div class="col-sm-1">
									<a class="btn btn-success" ng-model="btn" ng-click="filter_date()" ng-hide="to==''">Search</a>
								</div>



								<div class="col-sm-2">
									<input type="text" class="form-control" placeholder="Mobile No." id="mobile" autocomplete="off">
								</div>

								<div class="col-sm-1">
									<a class="btn btn-success" ng-model="btn" ng-click="filter_mobile()" ng-hide="to==''"><i class="fa fa-search"></i></a>
								</div>


							</div>

							<br />



							<div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>
							<span style="margin: 10px; font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>
							<!--table class="table table-hover" id="example2" style="display:none;">
					<thead>
					<tr>
						
						<th class="tbl-header">Sr.no</th>
						<th class="tbl-header">Full name</th>
						<th class="tbl-header">Mobile</th>
						<th class="tbl-header">Email</th>
						<th class="tbl-header">Gender</th>
						<!--th class="tbl-header">Parr. State</th>
						<th class="tbl-header">Parr. City</th>
						<th class="tbl-header">Corr. State</th>
						<th class="tbl-header">Corr. City</th>
						<th class="tbl-header">College</th>
						<th class="tbl-header">University</th>


						<th class="tbl-header">Appearing center1</th>
						<th class="tbl-header">Gdpi center1</th>
						<th class="tbl-header">Study centre1</th>

						<th>Category</th>
						<th>DOB</th>
						<th>Transaction Id</th>
						<th>Fee</th>
						<th>Status</th>
						<th>Generate</th>
						<th>Entry DateTime</th>
					
					</tr>
					</thead>

					<tbody>	

						<tr ng-repeat='list in list_items' id="row_id{{list.loginID}}">
						<td>
							
								{{$index + 1}}
							
							
						</td>
								
						<td>
							<span ng-if="list.course_id==1"><a href="<?php echo site_url(); ?>/admin/show_form_bba/{{list.user_id}}" target="_blank">{{list.first_name}} {{list.middle_name}} <br/>{{list.last_name}}</a></span>
							<span ng-if="list.course_id==2"><a href="<?php echo site_url(); ?>/admin/show_form_mba/{{list.user_id}}" target="_blank">{{list.first_name}} {{list.middle_name}} <br/>{{list.last_name}}</a></span>
						</td>
						<td>{{list.user_mobile}}</td>
						<td>{{list.email_id}}</td>
						<td>{{list.gender}}</td>
						<!--td>{{list.parma_state}}</td>
						<td>{{list.parma_city}}</td>
						<td>{{list.corre_state}}</td>
						<td>{{list.corre_city}}</td>

						<td>{{list.academic_intermediate}}</td>
						<td>{{list.academic_board}}</td>

						<td>{{list.appearing_center_1}}</td>
						<td>{{list.gdpi_center_1}}</td>
						<td>{{list.study_centre_1}}</td>

						<td>{{list.category}}</td>
						<td>{{list.dob | date: 'dd-MM-yyyy'}}</td>
						<td>{{list.razorpay_trans_id}}</td>
						<td>{{(list.amount/100)}}</td>
						<td>
							<span ng-if="list.login_status == 1" class="btn btn-xs btn-danger"> Mobile Verified</span>
							<span ng-if="list.login_status == 2 && list.razorpay_trans_id!=''" class="btn btn-xs btn-success"> Paid</span>
							<!-- <span ng-if="list.login_status == 2 && list.razorpay_trans_id==''" class="btn btn-xs btn-primary"> Complete & Not Pay</span>

						</td>
						<td>{{list.created_date}}</td>
						
						</tr>

					</tbody>
					
				</table-->

							<div style="overflow:scroll; height:500px;">
								<table id="item-list-filter" class="table table-bordered table-striped table-hover">
									<thead>
										<tr>

											<th class="tbl-header">Sr.no</th>
											<th class="tbl-header">Roll No.</th>
											<th class="tbl-header">Course</th>
											<th class="tbl-header">Full name</th>
											<th class="tbl-header">Mobile</th>

											<th>Father Name</th>
											<th>Mother Name</th>
											<th>DOB</th>
											<th class="tbl-header">Email</th>
											<th class="tbl-header">Gender</th>
											<th>Category</th>

											<th>Father Mobile</th>

											<th>Mother Mobile</th>
											<th>Father Email</th>
											<th>Religion</th>
											<th>Parr. Address</th>
											<th class="tbl-header">Parr. State</th>
											<th class="tbl-header">Parr. City</th>
											<th class="tbl-header">Corr. Address</th>
											<th class="tbl-header">Corr. State</th>
											<th class="tbl-header">Corr. City</th>
											<th class="tbl-header">College</th>
											<th class="tbl-header">University</th>
											<th class="tbl-header">Year</th>
											<th class="tbl-header">Marks obtained/Total</th>
											<th class="tbl-header">Percentage</th>


											<th class="tbl-header">Appearing center1</th>
											<th class="tbl-header">Appearing center2</th>
											<th class="tbl-header">Appearing center3</th>
											<th class="tbl-header">Appearing center4</th>

											<th class="tbl-header">Gdpi center1</th>
											<th class="tbl-header">Gdpi center2</th>
											<th class="tbl-header">Gdpi center3</th>
											<th class="tbl-header">Gdpi center4</th>

											<th class="tbl-header">Study centre1</th>
											<th class="tbl-header">Study centre2</th>
											<th class="tbl-header">Study centre3</th>
											<th class="tbl-header">Study centre4</th>


											<th>Transaction Id</th>
											<th>Fee</th>
											<th>Status</th>
											<th>Generate</th>
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
	$(document).ready(function() {
		$("#loading").hide();

		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'

		});
	});
	var App = angular.module('myApp', ['ui.bootstrap']);

	function Dashboard_Details($scope, $log, $http, $compile) {


		$scope.list_items = "";
		$scope.sampledate = new Date();

		/*$scope.filter_dateeeeeee = function() {
        
        var from = $('#from').val();
        var to = $('#to').val();

        var data = from+"~"+to;

        if(data !='')
        {
         $("#loading").show();
         $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/filter_date?data='); ?>"+data}).then(function(response){
            console.log(response.data);
            $scope.cnt = 1;
            $scope.list_items = response.data;
            $("#loading").hide();
            
          })
        } 
    };*/

		$scope.filter_mobile = function() {

			var mobile = $('#mobile').val();

			$('#item-list_wrapper').hide();
			$('#item-list-filter').show();

			$('#item-list-filter').DataTable({
				"ajax": {
					url: "<?php echo site_url('admin/filter_mobile?data='); ?>" + mobile,
					type: 'POST'
				},
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": true,
				"order": [3, "asc"],
				"bInfo": true,
				"bAutoWidth": false,
				"searching": true,
				"bRetreive": true,
				"destroy": true,
				dom: 'Bfrtip',
				lengthMenu: [
					[25, 50, -1],
					['25 rows', '50 rows', 'Show all']
				],
				buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],

				"drawCallback": function(settings) {
					var api = this.api();
					var info = api.page.info();
					// info.recordsDisplay = filtered record count
					// info.recordsTotal = total records before filter (if implemented)
					$("#record").text(info.recordsDisplay); // update element with filtered count
				}
			});

		};






		$scope.filter_date = function() {

			var from = $('#from').val();
			var to = $('#to').val();
			var status = $('#status').val();
			var course = $('#course').val();
			var study_center = $("#study_center").val();

			var data = from + "~" + to + "~" + status + "~" + course + "~" + study_center;

			$('#item-list_wrapper').hide();
			$('#item-list-filter').show();

			$('#item-list-filter').DataTable({
				"ajax": {
					url: "<?php echo site_url('admin/filter_date?data='); ?>" + data,
					type: 'POST'
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
				lengthMenu: [
					[25, 50, -1],
					['25 rows', '50 rows', 'Show all']
				],
				buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],

				"drawCallback": function(settings) {
					var api = this.api();
					var info = api.page.info();
					// info.recordsDisplay = filtered record count
					// info.recordsTotal = total records before filter (if implemented)
					$("#record").text(info.recordsDisplay); // update element with filtered count
				}
			});

		};






	}
</script>


<!--script>
	 $('#item-list-filter').hide();		
	 $('#item-list').DataTable({
        "ajax": {
            url : "<?php echo site_url('admin/get_items') ?>",
            type : 'POST'
        },
         		"bPaginate": true,
	            "bLengthChange": false,
	            "bFilter": false,
	            "bSort": true,
	            "bInfo": true,
	            "bAutoWidth": false,
	            "searching": true,
	            "bRetreive": true,
	            "destroy": true,
	            dom: 'Bfrtip',
		        lengthMenu:[[25, 50, -1 ],['25 rows', '50 rows', 'Show all' ]],
		        buttons:['copy', 'csv', 'excel', 'pdf', 'print'],
    });
</script-->

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

	#loading {
		width: 100%;
		height: 800px;
		position: absolute;
		background-color: rgba(0, 0, 0, 0.50) !important;
		text-align: center;
		padding-top: 30%;
	}
</style>

<!--script type="text/javascript">
     $(function() {
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "searching": true,
            dom: 'Bfrtip',
			lengthMenu: [
            [25, 50, -1 ],
            ['25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
		
        

        });
    });
</script-->