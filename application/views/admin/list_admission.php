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
					Search Registration
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
						<div class="box-body" style="padding:20px;">
							<div class="row">

								<div class="col-sm-2">
									<label>Year</label>
									<select class="form-control" name="dbnamee" id="dbnamee">
										<option value="iittm_2025">2025</option>
										<option value="iittm_2024">2024</option>
										<option value="iittm_2023">2023</option>
										<option value="iittm_2022">2022</option>
										<option value="iittm_2021">2021</option>

										<option value="iittm_2020">2020</option>




									</select>
								</div>



								<div class="col-sm-2">
									<label>Select Course</label>
									<select class="form-control" id="course" required="">
										<option value="1,2">All Course</option>
										<option value="1">BBA</option>
										<option value="2">MBA</option>
									</select>
								</div>

								<div class="col-sm-1" style="padding-top: 24px;">
									<a class="btn btn-success" ng-model="btn" ng-click="filter_course()" ng-hide="to==''"><i class="fa fa-search"></i> Search</a>
								</div>

								<div class="col-sm-2">
									<label>Search By Study Center</label>
									<select class="form-control" name="final_study_center" id="final_study_center" ng-model="final_study_center">
										<option value="">--Select Study Center--</option>
										<option value="Gwalior">Gwalior</option>
										<option value="Bhubaneswar">Bhubaneswar</option>
										<option value="Noida">Noida</option>
										<option value="Nellore">Nellore</option>
										<option value="Goa">NIWS-GOA</option>
									</select>
								</div>

								<div class="col-sm-1" style="padding-top: 24px;">
									<a class="btn btn-danger" ng-model="btn" ng-click="filter_center()" ng-hide="to==''"><i class="fa fa-search"></i> Search</a>
								</div>


							</div>
						</div>
					</div>

					<div class="box">
						<div class="box-body">


							<div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

							<span style="margin: 4px; font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>

							<div style="overflow:scroll; height:500px;">
								<table id="item-list-filter" class="table table-bordered table-striped table-hover">
									<thead>
										<tr>

											<th class="tbl-header">Sr.no</th>
											<th class="tbl-header">Roll No.</th>
											<th class="tbl-header">Course</th>
											<th class="tbl-header">Full name</th>
											<th class="tbl-header">Mobile</th>
											<th class="tbl-header">Email</th>
											<th class="tbl-header">Gender</th>
											<th>Category</th>
											<th>DOB</th>
											<th>Father Name</th>
											<th>Father Mobile</th>
											<th>Mother Name</th>
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



											<th class="tbl-header">Study centre1</th>
											<th class="tbl-header">Study centre2</th>
											<th class="tbl-header">Study centre3</th>
											<th class="tbl-header">Study centre4</th>
											<th class="tbl-header" style="background-color: #000; color: #fff;">Final Study centre</th>
											<th>Admission Date</th>

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

		$scope.list_items = <?php echo json_encode($list) ?>;
		$scope.sampledate = new Date();

		$('#item-list-filter').DataTable({
			"ajax": {
				url: "<?php echo site_url('admin/default_list'); ?>",
				type: 'POST'
			},
			"bPaginate": true,
			"bLengthChange": false,
			"bFilter": false,
			"bSort": false,
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




		$scope.filter_center = function() {

			var center = $('#final_study_center').val();

			$('#item-list_wrapper').hide();
			$('#item-list-filter').show();

			$('#item-list-filter').DataTable({
				"ajax": {
					url: "<?php echo site_url('admin/search_by_center?data='); ?>" + center,
					type: 'POST'
				},
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": false,
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



		$scope.filter_course = function() {

			var course = $('#course').val();
			var year = $('#dbnamee').val();
			$('#item-list_wrapper').hide();
			$('#item-list-filter').show();

			$('#item-list-filter').DataTable({
				"ajax": {
					url: "<?php echo site_url('admin/search_by_course?data='); ?>" + course + "&year=" + year,
					type: 'POST'
				},
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": false,
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


		$scope.getTotalRecords = function() {
			$http.get('<?php echo base_url("index.php/Admin/total_records_count_registration"); ?>')
				.then(function(response) {
					document.getElementById('record').innerText = response.data.totalRecords;
				}, function(error) {
					console.error('Error fetching total records:', error);
				});
		};

		// Call it once when controller loads
		$scope.getTotalRecords();

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

	#loading {
		width: 100%;
		height: 800px;
		position: absolute;
		background-color: rgba(0, 0, 0, 0.50) !important;
		text-align: center;
		padding-top: 30%;
	}
</style>