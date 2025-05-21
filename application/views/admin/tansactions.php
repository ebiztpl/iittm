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
					Transaction Report
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


							<div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

							<span style="margin: 10px; font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>

							<table id="item-list-filter" class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<td colspan="5" align="center" style="background-color: black; color:#fff;">Admission Portal Details</td>
										<td style="background-color: red; color:#fff;">Razorpay <br />Account</td>
										<td colspan="8" align="center" style="background-color: #233ccf; color:#fff;">Razorpay Transaction Detail</td>
									</tr>
									<tr>
										<th class="tbl-header">Sr.no</th>
										<th class="tbl-header">Course</th>
										<th>Name</th>
										<th class="tbl-header">Email</th>
										<th>Mobile</th>
										<th></th>
										<th style="background-color: lightskyblue;">PaymentID</th>
										<th style="background-color: lightskyblue;">Bank</th>
										<th style="background-color: lightskyblue;">Method</th>
										<th style="background-color: lightskyblue;">Amount</th>
										<th style="background-color: lightskyblue;">Fee</th>
										<th style="background-color: lightskyblue;">Tax</th>
										<th style="background-color: lightskyblue;">Refund</th>
										<th style="background-color: lightskyblue;">PaymentDate</th>

									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>








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



<style type="text/css">
	div.dataTables_wrapper div.dataTables_processing {
		position: absolute;
		top: 10%;
		left: 0px;
		width: 100%;
		height: 600px;
		margin-left: 0px;
		background-color: #00000052;
		text-align: center;
		padding: 9em 0;
		color: #fff;
		font-size: 30px;
	}
</style>
<script>
	$(document).ready(function() {
		$("#loading").hide();

		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd'

		});
	});
	var App = angular.module('myApp', ['ui.bootstrap']);

	function Dashboard_Details($scope, $log, $http, $compile) {


		$scope.sampledate = new Date();

		$('#item-list-filter').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "<?php echo site_url('admin/c'); ?>",
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
				[10, 20, -1],
				['10 rows', '20 rows', 'Show all']
			],
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
			"drawCallback": function(settings) {
				var api = this.api();
				var info = api.page.info();
				$("#record").text(info.recordsDisplay); 
			}
		});




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