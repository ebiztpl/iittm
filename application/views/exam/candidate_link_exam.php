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
		<div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>
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
						'novalidate' => 'novalidate',
						'ng-submit' => 'assign_Submit($event)'
					);
					echo form_open('', $lFormAttrb);
					?>

					<div class="box">
						<div class="box-body">
							<div class="row">


								<div class="col-sm-2">
									<input type="text" name="name" id="name" class="form-control" placeholder="Name" />
								</div>


								<div class="col-sm-2">
									<input type="text" name="email" id="email" class="form-control" placeholder="Email" />
								</div>


								<div class="col-sm-2">
									<input type="text" class="form-control" placeholder="Mobile No." id="mobile" autocomplete="off">
								</div>

								<div class="col-sm-2">
									<select class="form-control" id="course" required="">
										<option value="1,2">All Course</option>
										<option value="1">BBA</option>
										<option value="2">MBA</option>
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

								<div class="col-sm-2">
									<span class="btn btn-primary">
										<input type="radio" value='1' id="missed" name="radio" /> Candidate Missed Exam
									</span>
								</div>


							</div>

							<!--  <div class="row" style="margin-top:10px;">
        <div class="col-sm-2">
          
            <select class="form-control" name="exam_search" id="exam_search" required="">
                	<option value="">--Select Exam--</option>
                	<?php
					foreach ($result as $key => $master) {
						echo "<option value=" . $master['id'] . ">" . $master['exam_name'] . "</option>";
					}
					?>
                </select>
          </div>

       
				
		<div class="col-sm-1">
			<input type="radio" value='2' id="take" name="radio" /> Appeared in Exam(Pass) 
		</div>
				
		<div class="col-sm-1">
			<input type="radio" value='3' id="fail" name="radio" /> Appeared in Exam(Fail) 
		</div>

        </div> -->

							<div class="row" style="margin-top:20px;">
								<div class="col-sm-11">
									<input type="text" class="form-control" id="ids" placeholder="Candidate Primary Ids" />
								</div>

								<div class="col-sm-1">
									<a class="btn btn-success" ng-model="btn" ng-click="search_data()" ng-hide="to==''">Search</a>
								</div>

							</div>


							<br />

							<span style="margin: 10px; font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>



							<div style="overflow:scroll; height:500px;">
								<table id="item-list-filter" class="table table-bordered table-striped table-hover">
									<thead>
										<tr>

											<th class="tbl-header">Action</th>
											<th class="tbl-header">Roll No.</th>
											<th class="tbl-header">Exam</th>
											<th class="tbl-header">Course</th>
											<th class="tbl-header">Study centre1</th>
											<th class="tbl-header">Score</th>
											<th class="tbl-header">Full name</th>
											<th class="tbl-header">Mobile</th>

											<th>Father Name</th>
											<th>Mother Name</th>
											<th>DOB</th>
											<th>Email</th>
											<th>Gender</th>
											<th>Category</th>
											<th>Father Mobile</th>
											<th>Mother Mobile</th>
											<th>Religion</th>
											<th>Parr. State</th>
											<th>Parr. City</th>
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



		<div class="modal fade" id="exam_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Candidate Exam Data</h5>

						<span style="position: absolute; top: 15px; right: 15px; cursor: pointer;"><i class="fa fa-close"></i></span>



					</div>
					<div class="modal-body">
						<form action="#" id="exam_data_save" method="POST">
							<input type="hidden" id="user_id" name="user_id" />
							<label>Select Exam <span style='color:red;'>*</span></label>
							<div class="form-group">

								<select class="form-control js-select2" name="exam_id[]" id="exam_id" required="" multiple="multiple">

									<?php
									foreach ($result as $key => $master) {
										echo "<option value=" . $master['id'] . ">" . $master['exam_name'] . "</option>";
									}
									?>
								</select>
							</div>

							<!--   <div class="form-group">
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
 -->



							<button class="btn btn-primary" name="btnsubmit">Save</button>
						</form>

						<span id="msg"></span>
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


		$(".fa-close").click(function() {

			$("#exam_status").modal('hide');
			$(".js-select2").empty();
			$("#msg").html("");
			$(".js-select2").select2('refresh');

		});



		$(document).on('click', ".exam_status", function() {

			var id = $(this).attr('data-id');
			$("#user_id").val(id);
			$("#exam_status").modal('show');

		});


		$("#exam_data_save").submit(function() {
			$.ajax({
				url: "<?php echo site_url('exam/c'); ?>",
				data: $("#exam_data_save").serialize(),
				type: "POST",
				dataType: 'json',
				success: function(e) {
					$("#msg").html(e.msg);
					// if(e==1){
					// 	alert('Data has been save successfully');
					// 	$("#exam_status").modal('hide');
					// }
				},
				error: function(e) {

					alert(e);
				}
			});
			return false;
		});


	});
	var App = angular.module('myApp', ['ui.bootstrap']);

	function Dashboard_Details($scope, $log, $http, $compile) {


		$scope.list_items = "";
		$scope.sampledate = new Date();


		$scope.search_data = function() {

			$("#loading").show();


			var whereClauses = [];


			if ($("#name").val() != "") {
				whereClauses.push('ca.first_name LIKE ' + "'" + $("#name").val() + "'");
			}

			if ($("#email").val() != "") {
				whereClauses.push('ca.email_id=' + "'" + $("#email").val() + "'");
			}

			if ($("#mobile").val() != "") {
				whereClauses.push('um.user_mobile=' + "'" + $("#mobile").val() + "'");
			}

			if ($("#course").val() != "") {
				whereClauses.push('um.course_id in ' + "(" + $("#course").val() + ")");
			}

			if ($("#study_center").val() != "") {
				whereClauses.push('ca.study_centre_1=' + "'" + $("#study_center").val() + "'");
			}

			if ($('#missed').is(":checked")) {
				var missed = 1;
			} else {
				var missed = 0;
			}

			if ($('#take').is(":checked")) {
				var missed = 2;
			}

			if ($('#fail').is(":checked")) {
				var missed = 3;
			}

			if ($("#ids").val() != "") {
				whereClauses.push('um.user_id in ' + "(" + $("#ids").val() + ")");
			}

			var withand = whereClauses.join(" AND ");
			if (whereClauses.length != 0) {
				var where = ' WHERE ' + withand;
			}



			$('#item-list_wrapper').hide();
			$('#item-list-filter').show();

			$('#item-list-filter').DataTable({
				"ajax": {
					url: "<?php echo site_url('exam/filter_exam_link_page'); ?>",
					data: {
						'data': where,
						'missed': missed
					},
					type: 'POST'
				},
				initComplete: function(e) {
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
		z-index: 99999;
	}
</style>