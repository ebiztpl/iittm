<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('../layout/head.php'); ?>
	<script src="<?= base_url(); ?>themes/js/jquery.min.js"></script>
	<script src="<?= base_url(); ?>themes/js/angular.min.js"></script>
	<script src="<?= base_url(); ?>themes/js/angular-ui.min.js"></script>



	<!-- for the query description box with tinymce -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

	<!-- TinyMCE CDN with version and valid API key -->
	<script src="https://cdn.tiny.cloud/1/kjnz7rljuofa7jce4904eidi6gi8r7zy0lwyt1k54h1jxrr0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular-sanitize.js"></script>

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
					Query Report
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


					<!-- filters -->
					<div class="box">
						<div class="box-body">
							<div class="row">
								<div class="col-sm-2">
									<input type="text" class="form-control datepicker" placeholder="From Date" ng-model="from" require="" autocomplete="off">
								</div>

								<div class="col-sm-2">
									<input type="text" class="form-control datepicker" placeholder="To Date" ng-model="to" required="" autocomplete="off">
								</div>

								<div class="col-sm-2">
									<select class="form-control" ng-model="status" required>
										<option value="">--Search By Status--</option>
										<option value="All">All</option>
										<option value="Pending">Pending</option>
										<option value="Open">Open</option>
										<option value="Closed">Closed</option>
									</select>
								</div>

								<div class="col-sm-1">
									<a class="btn btn-success" ng-model="btn" ng-click="filter_query()">Search</a>
								</div>



								<div class="col-sm-2">
									<input type="text" class="form-control" placeholder="Mobile No." id="mobile" ng-model="searchMobile" autocomplete="off">
								</div>

								<div class="col-sm-1">
									<a class="btn btn-success" ng-click="filter_mobile()"><i class="fa fa-search"></i></a>
								</div>


								<div class="col-sm-2">
									<a href="<?php echo site_url('admin/ticket'); ?>" class="btn btn-primary">Create Query</a>
								</div>
							</div>


							<span style="margin-top: 10px; font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>

							<div class="box-body table-responsive">
								<div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

								<table class="table table-hover" id="example2">
									<thead>
										<tr>

											<th class="tbl-header">Query No.</th>
											<th class="tbl-header">Name</th>
											<th class="tbl-header">Email</th>
											<th class="tbl-header">Mobile</th>
											<th class="tbl-header">Form Type</th>

											<th class="tbl-header">DateTime</th>
											<th class="tbl-header">Issue</th>
											<th class="tbl-header">Solution</th>
											<th class="tbl-header">Solution DateTime</th>
											<th class="tbl-header">Status</th>
											<th class="tbl-header">Action</th>

										</tr>
									</thead>

									<tbody>

										<tr ng-repeat='list in queryData' id="row_id{{list.query_id}}">
											<td>{{list.query_id}}</td>
											<td>{{list.first_name}} {{list.last_name}}</td>
											<td>{{list.emailid}}</td>
											<td>{{list.alt_mobile}}</td>
											<td>{{list.form_type}}</td>
											<td>{{list.query_post_date | date:'dd-MM-yyyy HH:mm:ss'}}</td>
											<td>{{ stripHtml(list.problem) }}</td>
											<td>{{ stripHtml(list.finding) }}</td>
											<td><span ng-show="list.status=='Closed'">{{list.solution_datetime | date:'dd-MM-yyyy HH:mm:ss'}}</span></td>

											<td>
												<button type="button" class="btn btn-sm"
													ng-class="{
															'btn-warning': list.status === 'Pending',
															'btn-success': list.status === 'Open',
															'btn-danger': list.status === 'Closed'
														}" ng-click="$event.stopPropagation()">
													{{ list.status }}
												</button>
											</td>

											<td>
												<a class="btn btn-primary btn-xs" style="margin-bottom: 8px;" ng-click="modalpop(list.query_id)"><i class="fa fa-wrench" style="margin-right: 6px;" aria-hidden="true"></i>Action</a>

												<a class="btn btn-success btn-xs" ng-click="viewQueryDetails(list.query_id)"><i class="fa fa-eye" style="margin-right: 6px;" aria-hidden="true"></i>View</a>


												<!-- <a class="btn btn-primary" ng-click="modalpop(list.query_id)" ng-hide="list.solution_datetime!='0000-00-00 00:00:00'">Action</a> -->

												<!-- <span ng-show="list.status=='Pending'" style="color:green; font-weight:bold;"><a class='btn btn-primary' ng-click="modalpop(list.query_id)">Open</a></span>
												<span ng-show="list.status=='Complete'" style="color:green; font-weight:bold;"><a class='btn btn-success' ng-click="modalpop(list.query_id)">Close</a></span> -->
											</td>
										</tr>

									</tbody>
								</table>
							</div>

							<b><span id="loadingddupe" style="display:none;">Checking.........</span></b>
							<span id="warning_msg" class="error"></span>
						</div>



						<!-- Begin Action Navigation Bar -->
						<div class="modal fade" id="modal-default" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Query/Issue Number - {{hidden_query_id}}</h4>
									</div>
									<div class="modal-body">

										<div class="row">
											<div class="col-sm-12" style="margin-bottom: 24px;">
												<table class="table table-bordered p-4 text-center">
													<thead>
														<tr>
															<td><label>Name:</label><br />
																{{getname}}
															</td>

															<td><label>Email:</label><br />
																{{getemail}}
															</td>

															<td><label>Mobile:</label><br />
																{{getmob}}
															</td>

															<td><label>Course:</label><br />
																<span ng-if='getcourse==1'>BBA</span><span ng-if='getcourse==2'>MBA</span>
															</td>

															<td><label>Reg. Email:</label><br />
																{{getregemail}}
															</td>

															<td><label>Reg. Mobile:</label><br />
																{{getregmob}}
															</td>

															<td><label> Type:</label><br />
																{{getformtype}}
															</td>

															<td><label>Query Date:</label><br />
																{{getdate}}
															</td>

														</tr>
													</thead>
												</table>

											</div>

											<div class="col-sm-12" style="margin-bottom: 24px;">
												<label>Query/Issue:</label><br />

												<textarea type="text" ng-model="getproblem" class="form-control" id="getproblem" name="getproblem"></textarea>
											</div>
										</div>


										<input type="hidden" ng-model="hidden_query_id" ng-value="" id="hidden_query_id">

										<table class="table">
											<thead>
												<tr>
													<td><label><b>Finding</b><span style="color:red;">*</span></label>
														<!-- <textarea class="form-control" ng-model="finding" id="finding" name="finding">{{finding}}</textarea> -->
														<textarea class="form-control" ng-model="lastFinding" id="finding" name="finding"></textarea>
													</td>

													<td><label><b>Solution</b><span style="color:red;">*</span></label>
														<!-- <textarea class="form-control" ng-model="solution" id="solution" name="solution">{{solution}}</textarea> -->
														<textarea class="form-control" ng-model="lastSolution" id="solution" name="solution"></textarea>
													</td>
												</tr>



											</thead>
										</table>
									</div>
									<div class="modal-footer">
										<div class="col-sm-2 text-left">
											<a href='<?php echo base_url(); ?>/uploads/query/{{getdownload}}' target="_blank" class="btn btn-danger" ng-hide="getdownload==''">View Attachment</a>
										</div>

										<div class="col-sm-1 text-right" style="padding-right:0px; padding-top:7px;"><label><b>Status</b><span style="color:red;">*</span></label></div>
										<div class="col-sm-3">
											<select class="form-control" id="status" ng-model="statuss">
												<option value="Pending" ng-selected="statuss=='Pending'">Pending</option>
												<option value="Open" ng-selected="statuss=='Open'">Open</option>
												<option value="Closed" ng-selected="statuss=='Closed'">Close</option>
											</select>
										</div>

										<div class="col-sm-4 text-left" style="padding-top:7px;">
											<label><b>Solution Date: </b>{{getsolutiondate}}</label>
										</div>

										<div class="col-sm-2">
											<button type="button" class="btn btn-primary" ng-click="save_data()">Save Data</button>
										</div>
									</div>
								</div>
								<!-- /.modal-content -->
							</div>
							<!-- /.modal-dialog -->
						</div>



						<!-- this is the modal for the view all findings and solutions -->
						<div class="modal fade" id="queryDetailsModal" tabindex="-1" role="dialog" aria-labelledby="queryDetailsModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Query/Issue Number - {{hidden_query_id}}</h4>
									</div>
									<div class="modal-body" ng-if="queryDetails">
										<div class="row">
											<div class="col-sm-12" style="margin-bottom: 24px;">
												<table class="table table-bordered p-4 text-center">
													<thead>
														<tr>
															<td><label>Name:</label><br />
																{{ queryDetails.full_name }}
															</td>

															<td><label>Email:</label><br />
																{{ queryDetails.emailid }}
															</td>

															<td><label>Mobile:</label><br />
																{{ queryDetails.mobile }}
															</td>

															<td><label>Course:</label><br />
																<span ng-if='queryDetails.course_id==1'>BBA</span><span ng-if='queryDetails.course_id==2'>MBA</span>
															</td>

															<td><label>Reg. Email:</label><br />
																{{queryDetails.register_email}}
															</td>

															<td><label>Reg. Mobile:</label><br />
																{{queryDetails.register_mobile}}
															</td>

															<td><label> Type:</label><br />
																{{queryDetails.form_type}}
															</td>

															<td><label>Query Date:</label><br />
																{{queryDetails.post_date}}
															</td>

															<td><label>Status:</label><br />
																{{queryDetails.status}}
															</td>

														</tr>
													</thead>
												</table>
											</div>

											<div class="col-sm-12" style="margin-bottom: 24px;">
												<table class="table table-bordered table-striped p-4 text-center">
													<thead>
														<tr>
															<th>Query/Issue:</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>{{ stripHtml(queryDetails.problem) }}</td>
														</tr>
													</tbody>
													<!-- <td><label>Query/Issue:</label><br />
														{{ stripHtml(queryDetails.problem) }}
													</td> -->
												</table>
											</div>

											<input type="hidden" ng-model="hidden_query_id" ng-value="" id="hidden_query_id">


											<!-- <div class="text-center display-6" ng-if="queryDetails.finding.length == 0">No entries found.</div> -->
											<table class="table table-striped p-2 text-center">
												<thead>
													<tr>
														<th>#</th>
														<th>Finding</th>
														<th>Solution</th>
														<!-- <th>Timestamp</th> -->
													</tr>
												</thead>
												<tbody>
													<tr ng-if="getSplitList(queryDetails.finding).length === 0">
														<td colspan="3" style="color: red; font-size: large;">No Entries Found!</td>
													</tr>
													<tr ng-repeat="i in getSplitList(queryDetails.finding) track by $index">
														<td>{{$index + 1}}</td>
														<td>{{ getSplitList(stripHtml(queryDetails.finding))[$index] }}</td>
														<td>{{ getSplitList(stripHtml(queryDetails.solution))[$index] }}</td>
													</tr>
												</tbody>
											</table>

											<div class="modal-footer">
												<!-- todo -->
												<div class="col-sm-6 text-left">
													<div ng-if="queryDetails.file.length == 0" style="color: red; font-size: large;">No Attachment Found!</div>
													<a href='<?php echo base_url(); ?>/uploads/query/{{getdownload}}' target="_blank" class="btn btn-danger" ng-hide="getdownload==''">View Attachment</a>
												</div>

												<div class="col-sm-6 text-left" style="padding-top:7px;">
													<label><b>Solution Date: </b>{{queryDetails.solution_datetime}}</label>
												</div>

											</div>
										</div>
										<div class="modal-body" ng-if="!queryDetails">
											<p class="text-danger">No query details found.</p>
										</div>
									</div>
								</div>
							</div>
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
		}).on('changeDate', function(e) {
			var el = angular.element(e.target);
			var model = el.attr('ng-model');
			if (model) {
				var scope = el.scope();
				scope.$apply(function() {
					scope[model] = e.format('yyyy-mm-dd');
				});
			}
		});
	});


	var App = angular.module('myApp', ['ui.bootstrap']);

	function Dashboard_Details($scope, $log, $http, $compile) {

		// function to remove tags
		$scope.stripHtml = function(html) {
			var tempDiv = document.createElement("div");
			tempDiv.innerHTML = html;
			return tempDiv.textContent || tempDiv.innerText || "";
		};

		$scope.getSplitList = function(input) {
			if (!input) return [];
			return input.split('||');
		};

		// Get the latest value from a ||-separated string
		$scope.getLastItem = function(input) {
			if (!input) return '';
			let parts = input.split('||');
			return parts[parts.length - 1];
		};

		$scope.queryData = <?php echo json_encode($result); ?>;
		$scope.sampledate = new Date();

		$scope.modalpop = function(userid) {
			// $("#loading").show();

			$http({
				method: "get",
				dataType: 'html',
				url: "<?php echo site_url('admin/get_query_by_id?data='); ?>" + userid
			}).then(function(response) {
				console.log(response.data);

				$scope.getname = response.data[0]['first_name'] + ' ' + response.data[0]['last_name'];
				$scope.getemail = response.data[0]['emailid'];
				$scope.getmob = response.data[0]['alt_mobile'];
				$scope.getcourse = response.data[0]['course_id'];
				$scope.getregemail = response.data[0]['register_email'];
				$scope.getregmob = response.data[0]['register_mobile'];
				$scope.getformtype = response.data[0]['form_type'];
				$scope.getdate = response.data[0]['query_post_date'];
				$scope.getdownload = response.data[0]['file'];
				$scope.statuss = response.data[0]['status'];
				$scope.getsolutiondate = response.data[0]['solution_datetime'];
				$scope.hidden_query_id = userid;


				$scope.getproblem = response.data[0]['problem'];
				// Set TinyMCE content directly
				if (tinymce.get('problem')) {
					tinymce.get('problem').setContent(data.problem);
				}

				// Extract full finding and solution history
				var fullFinding = response.data[0]['finding'] || '';
				var fullSolution = response.data[0]['solution'] || '';

				// Extract only the latest (last) entry from the history
				var lastFinding = fullFinding.split('||').pop();
				var lastSolution = fullSolution.split('||').pop();

				// Set the values for use in TinyMCE setup
				$scope.finding = lastFinding;
				$scope.solution = lastSolution;

				setTimeout(function() {
					// Show modal
					$("#modal-default").modal("show");

					$('#modal-default').on('shown.bs.modal', function() {
						['getproblem', 'finding', 'solution'].forEach(function(id) {
							if (tinymce.get(id)) {
								tinymce.get(id).remove();
							}
						});

						tinymce.init({
							selector: '#getproblem',
							height: 200,
							menubar: false,
							plugins: 'lists link image table code help wordcount',
							toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat | code',
							setup: function(editor) {
								editor.on('init', function() {
									const id = editor.id;
									// Set content from AngularJS model manually
									editor.setContent(angular.element(document.getElementById(id)).scope()[id]);
								});
							}
						});

						tinymce.init({
							selector: '#finding, #solution',
							height: 300,
							menubar: false,
							plugins: 'lists link image table code help wordcount',
							toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat | code',
							setup: function(editor) {
								editor.on('init', function() {
									const id = editor.id;
									// Set content from AngularJS model manually
									editor.setContent(angular.element(document.getElementById(id)).scope()[id]);
								});
							}
						});
					});

				}, 200);

				angular.element('#hidden_query_id').val(userid);
				// $("#loading").hide();
			})



		};

		$scope.save_data = function() {
			var status = $scope.statuss;
			var finding = tinymce.get('finding').getContent();
			var solution = tinymce.get('solution').getContent();
			var getproblem = tinymce.get('getproblem').getContent(); // ✅ NEW LINE

			if (status == "") {
				alert('Please select Status');
				return false;
			} else if (finding.trim() == "") {
				alert('Please Type Finding');
				return false;
			} else if (solution.trim() == "") {
				alert('Please Type Solution');
				return false;
			} else if (getproblem.trim() == "") {
				alert("I can't find any query. Please Type Query");
				return false;
			}


			$("#loading").show();

			var data = encodeURIComponent([
				getproblem,
				finding,
				solution,
				angular.element('#hidden_query_id').val(),
				status
			].join("~"));

			$http({
				method: "get",
				dataType: 'html',
				url: "<?php echo site_url('admin/save_query_by_id?data='); ?>" + data
			}).then(function(response) {
				console.log(response);
				if (response.data == 1) {

					var updatedId = $scope.hidden_query_id;
					var updatedStatus = $scope.statuss;

					var index = $scope.queryData.findIndex(q => q.query_id == updatedId);
					if (index !== -1) {
						$scope.queryData[index].status = updatedStatus;
						// $scope.queryData[index].finding = finding;
						// $scope.queryData[index].solution = solution;


						$scope.queryData[index].finding = $scope.queryData[index].finding ?
							$scope.queryData[index].finding + '||' + finding :
							finding;

						$scope.queryData[index].solution = $scope.queryData[index].solution ?
							$scope.queryData[index].solution + '||' + solution :
							solution;


						$scope.queryData[index].problem = getproblem; // Adjust if your field name differs
					}

					$("#modal-default").modal('hide');
				} else {
					alert("Failed to save data.");
				}

				$("#loading").hide();
			})
		}

		$scope.queryFindings = [];
		$scope.queryDetails = {};

		$scope.viewQueryDetails = function(query_id) {
			// 1. Get main details
			$http.post('<?= base_url("index.php/Admin/get_query_details") ?>', {
					query_id: query_id
				})
				.then(function(response) {
					// $scope.getSplitList = function(input) {
					// 	if (!input) return [];
					// 	return input.split('||');
					// };
					$scope.queryDetails = response.data;
					$scope.hidden_query_id = $scope.queryDetails.query_id;
					$scope.getdownload = $scope.queryDetails.file;
					$('#queryDetailsModal').modal('show');
				}, function(error) {
					console.error("Error response:", error);
					alert("Error: " + error.status + " - " + error.statusText);

					angular.element('#hidden_query_id').val(query_id);
				});
		};

		$scope.filter_mobile = function() {
			var mobile = document.getElementById('mobile').value;

			if (mobile.trim() === '') {
				alert("Enter Mobile Number.");
				return;
			}

			$http.post("<?php echo base_url('index.php/Admin/filter_query_mobile'); ?>", {
				mobile: mobile
			}).then(function(response) {
				$scope.queryData = response.data.data;
				$("#record").html(response.data.recordsFiltered);
			}, function(error) {
				console.error("Error:", error);
				alert("Something went wrong.");
			});
		};

		$scope.filter_query = function() {
			if (!$scope.from && !$scope.to && !$scope.status) {
				alert("Please select at least one filter.");
				return;
			}

			$http.post('<?php echo base_url("index.php/Admin/filter_query"); ?>', {
				from: $scope.from,
				to: $scope.to,
				status: $scope.status
			}).then(function(response) {
				$scope.queryData = response.data.data;
				// Update the total record count display
				// $("#record").html(response.data.recordsTotal);			
				$("#record").html(response.data.recordsFiltered);
			}, function(error) {
				alert("Something went wrong");
				console.error(error);
			});
		};

		$scope.getTotalRecords = function() {
			$http.get('<?php echo base_url("index.php/Admin/total_records_count"); ?>')
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

	.table td {
		word-break: break-word;
	}
</style>

<script type="text/javascript">
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
				[25, 50, -1],
				['25 rows', '50 rows', 'Show all']
			],
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],



		});
	});
</script>