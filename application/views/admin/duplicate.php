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
		sidebar(1205);
		?>



		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Duplicate Candidate
					<small>Control panel</small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
					<li class="active">Duplicate</li>
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

							<div style="overflow:scroll; height:500px;">
								<table id="item-list-filter" class="table table-bordered table-striped table-hover">
									<thead>
										<tr>

											<th class="tbl-header">Sr.no</th>
											<th class="tbl-header">Roll No.</th>
											<th class="tbl-header">Course</th>
											<th class="tbl-header">Study centre1</th>
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



		<div class="modal fade" id="exam_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Candidate Exam Data</h5>

						<span data-dismiss="modal" style="position: absolute; top: 15px; right: 15px; cursor: pointer;"><i class="fa fa-close"></i></span>



					</div>
					<div class="modal-body">
						<form action="#" id="exam_data_save" method="POST">
							<input type="hidden" id="user_id" name="user_id" />
							<div class="form-group">
								<label>Select Exam <span style='color:red;'>*</span></label>
								<select class="form-control" name="exam_id" id="exam_id" required="">
									<option value="">--Select--</option>
									<?php
									foreach ($result as $key => $master) {
										echo "<option value=" . $master['id'] . ">" . $master['exam_name'] . "</option>";
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
								<br />
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
	$(document).ready(function() {
		$("#loading").hide();

		$(document).on('click', ".exam_status", function() {
			if ($(this).is(':checked')) {
				var id = $(this).attr('data-id');
				$("#user_id").val(id);
				$("#exam_status").modal('show');
			}
		});



		$(document).on('click', ".status", function() {

			var id = $(this).attr('data-id');
			var txt = $(this).attr('data-text');

			$.ajax({
				url: "<?php echo site_url('exam/exam_attendance'); ?>",
				data: {
					'id': id,
					'txt': txt
				},
				type: "POST",
				dataType: 'json',
				success: function(e) {
					console.log(e);
				},
			});

		});


		$(document).on('click', ".result", function() {

			var id = $(this).attr('data-id');
			var txt = $(this).attr('data-text');

			$.ajax({
				url: "<?php echo site_url('exam/exam_result'); ?>",
				data: {
					'id': id,
					'txt': txt
				},
				type: "POST",
				dataType: 'json',
				success: function(e) {
					console.log(e);
				},
			});

		});


		$(document).ready(function() {

			$('#item-list-filter').DataTable({
				"ajax": {
					url: "<?php echo site_url('admin/duplicate_ajax'); ?>",
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

	#loading {
		width: 100%;
		height: 800px;
		position: absolute;
		background-color: rgba(0, 0, 0, 0.50) !important;
		text-align: center;
		padding-top: 30%;
	}
</style>