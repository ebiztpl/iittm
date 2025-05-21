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
					Advance Search
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


					<div class="box">
						<div class="box-body">
							<div class="row">

								<div class="col-sm-1">
									<label>Session</label><br />
									<form action="db_session" id="db_session" method="post">
										<select class="form-control" name="dbname" id="dbname">
											<option value="iittm_2025~iittm_2025~@hgP629r6" <?php if ($this->session->userdata('dbname') == 'iittm_2025') {
																								echo "selected";
																							} ?>>2025</option>
											<option value="iittm_2024~iittm_root_2024~*yWje2659" <?php if ($this->session->userdata('dbname') == 'iittm_2024') {
																										echo "selected";
																									} ?>>2024</option>
											<option value="iittm_2023~iittm_root~*yWje2659" <?php if ($this->session->userdata('dbname') == 'iittm_2023') {
																								echo "selected";
																							} ?>>2023</option>
											<option value="iittm_2022~iittm_2022~*yWje2659" <?php if ($this->session->userdata('dbname') == 'iittm_2022') {
																								echo "selected";
																							} ?>>2022</option>
											<option value="iittm_2021~iittm_2021~*yWje2659" <?php if ($this->session->userdata('dbname') == 'iittm_2021') {
																								echo "selected";
																							} ?>>2021</option>
											<option value="iittm_2020~iittm_2020~*yWje2659" <?php if ($this->session->userdata('dbname') == 'iittm_2020') {
																								echo "selected";
																							} ?>>2020</option>
										</select>
									</form>
								</div>

								<div class="col-sm-1" style="padding-left: 2px; padding-right: 3px;">
									<label>Course</label><br />
									<select class="form-control" id="course" required="">
										<option value="1,2">Both</option>
										<option value="1">BBA</option>
										<option value="2">MBA</option>
									</select>
								</div>


								<div class="col-sm-2" style="padding-right: 0px;">
									<label>FromDate</label><br />
									<input type="text" class="form-control datepicker" placeholder="From Date" id="from" ng-model="from" require="" autocomplete="off" style="border-radius: 0px;">
								</div>
								<div class="col-sm-2" style="padding-right: 0px;">
									<label>ToDate</label><br />
									<input type="text" class="form-control datepicker" placeholder="To Date" id="to" ng-model="to" required="" autocomplete="off" style="border-radius: 0px;">
								</div>







								<div class="col-sm-2" style="padding-right: 0px;">
									<label>Name</label><br />
									<input type="text" class="form-control" placeholder="Name" id="name" autocomplete="off">
								</div>

								<div class="col-sm-2" style="padding-right: 0px;">
									<label>Mobile</label><br />
									<input type="text" class="form-control" placeholder="Mobile No." id="mobile" autocomplete="off">
								</div>

								<div class="col-sm-2">
									<label>Email</label><br />
									<input type="text" class="form-control" placeholder="Email" id="email" autocomplete="off">
								</div>

							</div>
							<div class="row" style="margin-top: 10px;">

								<div class="col-sm-2">
									<label>Category</label><br />
									<input type="checkbox" class="category" name="category" value="General"> &nbsp;General &nbsp;
									<input type="checkbox" class="category" name="category" value="EWS"> &nbsp;EWS &nbsp;
									<input type="checkbox" class="category" name="category" value="OBC"> &nbsp;OBC &nbsp;<br />
									<input type="checkbox" class="category" name="category" value="SC"> &nbsp;SC &nbsp;
									<input type="checkbox" class="category" name="category" value="ST"> &nbsp;ST &nbsp;

								</div>

								<div class="col-sm-2">
									<label>Study Centre</label>
									<select name="first_code" class="form-control common_code" ng-model="study_center" id="study_center">
										<option value="">All</option>
										<option value="Gwalior">Gwalior</option>
										<option value="Bhubaneswar">Bhubaneswar</option>
										<option value="Noida">Noida</option>
										<option value="Nellore">Nellore</option>
										<option value="Goa">Goa</option>
									</select>

								</div>

								<div class="col-sm-2">
									<label>Candidate</label><br />
									<input type="checkbox" class="candidate" name="candidate" value="0"> &nbsp;Registration&nbsp;
									<input type="checkbox" class="candidate" name="candidate" value="1"> &nbsp;Admission

								</div>

								<div class="col-sm-2">
									<label>Gender</label><br />
									<input type="checkbox" class="gender" name="gender" value="Male"> &nbsp;Male&nbsp;
									<input type="checkbox" class="gender" name="gender" value="Female"> &nbsp;Female

								</div>


								<div class="col-sm-2">
									<label>Academic Status</label><br />
									<input type="checkbox" class="academic" name="academic" value="appearance"> &nbsp;Appearance&nbsp;
									<input type="checkbox" class="academic" name="academic" value="Graduation"> &nbsp;Graduation <br />
									<input type="checkbox" class="academic" name="academic" value="passed"> &nbsp;Passed
								</div>

								<div class="col-sm-1">
									<label>MBA Score</label><br />
									<input type="radio" name="score" value="yes" class="score"> Yes
									<input type="radio" name="score" value="no" class="score"> No
								</div>

								<div class="col-sm-1">
									<br />
									<a class="btn btn-success" id="filter_data">Search</a>
								</div>


								<!--   <div class="col-sm-1">
          <a class="btn btn-success" ng-model="btn" ng-click="filter_mobile()" ng-hide="to==''"><i class="fa fa-search"></i></a>
          </div> -->


							</div>

							<br />

							<div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

							<span style="margin: 10px; font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>

							<div style="overflow:scroll; height:700px; display: none;" id="tb_div">
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






		$scope.filter_date = function() {

			var from = $('#from').val();
			var to = $('#to').val();
			var status = $('#status').val();
			var course = $('#course').val();

			var data = from + "~" + to + "~" + status + "~" + course;

			$('#item-list_wrapper').hide();
			$('#item-list-filter').show();

			$('#item-list-filter').DataTable({
				"ajax": {
					url: "<?php echo site_url('admin/report3_filter?data='); ?>" + data,
					type: 'POST'
				},
				"bPaginate": true,
				"bLengthChange": false,
				"bFilter": false,
				"bSort": true,
				"order": ['3', 'asc'],
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



	$("#filter_data").click(function() {
		$("#loader-wrapper").show();
		var whereClauses = [];

		if ($("#from").val() != "" && $("#to").val() != "") {
			//	ca.post_date BETWEEN '$from' AND '$to 23:59:59'
			//whereClauses.push('ca.post_date BETWEEN '+"'"+$("#from").val()+"' AND '"+ $("#to").val()+"'");
			whereClauses.push('ca.post_date >= ' + "'" + $("#from").val() + " 00:00:01' AND ca.post_date <= '" + $("#to").val() + " 23:59:59'");
		}


		if ($("#course").val() != "") {
			//um.course_id in ($course)
			whereClauses.push('um.course_id in ' + "(" + $("#course").val() + ")");
		}

		if ($("#name").val() != "") {
			whereClauses.push('ca.first_name like ' + "'%" + $("#name").val() + "%'");
		}
		if ($("#mobile").val() != "") {
			whereClauses.push('um.user_mobile=' + "'" + $("#mobile").val() + "'");
		}
		if ($("#email").val() != "") {
			whereClauses.push('ca.email=' + "'" + $("#email").val() + "'");
		}

		if ($("#study_center").val() != "") {
			whereClauses.push('ca.final_study_center=' + "'" + $("#study_center").val() + "'");
		}



		if ($(".category").is(':checked')) {

			chk = [];
			$("input[name='category']:checked").each(function() {
				chkId = $(this).val();
				chk.push(chkId);
			});

			whereClauses.push('ca.category in ' + "('" + chk + "')");

		}

		if ($(".candidate").is(':checked')) {
			chk1 = [];
			$("input[name='candidate']:checked").each(function() {
				chkId1 = $(this).val();
				chk1.push(chkId1);
			});

			whereClauses.push('ca.admission in ' + "('" + chk1 + "')");
		}

		if ($(".gender").is(':checked')) {
			chk2 = [];
			$("input[name='gender']:checked").each(function() {
				chkId2 = $(this).val();
				chk2.push(chkId2);
			});

			whereClauses.push('ca.gender in ' + "('" + chk2 + "')");
		}

		if ($(".academic").is(':checked')) {
			chk3 = [];
			$("input[name='academic']:checked").each(function() {
				chkId3 = $(this).val();
				chk3.push(chkId3);
			});

			whereClauses.push('ca.academic_status in ' + "('" + chk3 + "')");
		}

		if ($(".score").is(':checked')) {

			var score = 1;
		}



		var withand = whereClauses.join(" AND ");
		if (whereClauses.length != 0) {
			var where = ' WHERE ' + withand;
		}


		$('#item-list_wrapper').hide();
		$('#item-list-filter').show();

		$('#item-list-filter').DataTable({
			"ajax": {
				url: "<?php echo site_url('admin/report3_filter'); ?>",
				data: {
					'data': where,
					'score': score
				},
				type: 'POST'
			},
			"bPaginate": true,
			"bLengthChange": false,
			"bFilter": false,
			"bSort": true,
			"order": false,
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

		$("#tb_div").show();

	});
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