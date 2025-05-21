<!doctype html>
<html class="no-js" lang="">

<head>
   <?php $this->load->view('../layout/head.php'); ?>
   <style>
   .tooltip-inner {
		max-width: 125px;
		width: 125px; 
	}
</style>
</head>

<body class="hold-transition skin-blue sidebar-mini" ng-app="myapp" ng-controller="MealTimeSlotCtrl" >
	<?php $this->load->view('../layout/header.php'); ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php $this->load->view('../layout/sidemenu.php');
				sidebar(3);
	?>
<div class="content-wrapper" >
	<section class="content-header">
		<h1>Meal Time Slot</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
			<!--<li><a href="#">Type</a></li>-->
			<li class="active">Meal Time Slot</li>
		</ol>
    </section>
	<section class="content">
			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title"></h3>
					<span ng-show="msg!='' && status==true" >
					<div class="alert alert-success alert-dismissible" >
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                       </button><strong> {{msg}}</strong>
					</div>
					</span>
					<span ng-show="msg!='' && status==false">
					<div class="alert alert-danger alert-dismissible" >
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                       </button> <strong>{{msg}}</strong>
					</div>
					</span>
						
					<div class="box-tools pull-right">
						<a class="btn btn-info" data-toggle="tooltip" title="Add Meal Time Slot" ng-click="AddMealTimeModal();">
						<i class="fa fa-plus"></i></a>
					</div>
				</div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Slot Name</th>
								<th>Plan Name</th>
								<th>Time From</th>
								<th>Time To</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
           </div>
		
	</section>
</div>
<div id="MealtimeModal" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" ><span ng-show="slot_id==0">Add</span> <span ng-show="slot_id!=0">Edit</span> Meal Time Slot</h4>
			</div>
			<div class="modal-body">
			 <form name="myForm" class="form-horizontal" novalidate >
				<div class="row">
					<div class="col-sm-12">
					<div class="col-sm-6">
						<div class="col-sm-6">
							<input type="radio" value="weekend" ng-model="slottype" name="weekend" id="weekend" required><label for="weekend">&nbsp;&nbsp;Weekend</label>
						</div>
						<div class="col-sm-6">
							&nbsp;&nbsp;<input type="radio" value="weekday" name="weekday" ng-model="slottype" id="weekday" required><label for="weekday">&nbsp;&nbsp;Weekday</label>
						</div>
						 <span ng-show="slottype==''" style="color:red;margin-left:18px;">{{msgerror}}</span>
					</div><br>
						<table id="example" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Plan Name</th>
									<th>Time From</th>
									<th>Time To</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="m in mealsarr">
									<td>{{m.name}} <span style="color:red;font-size: 16px;">*</span></td>
									<td><input type="time" name="time_from" id="time_from{{m.id}}"class="form-control input-sm"   ng-model="m.time_from" required></td>
									<td><input type="time" name="time_to" id="time_to{{m.id}}" class="form-control input-sm"  ng-model="m.time_to" required></td>
								</tr>
							</tbody>
							
						</table>
						<div class="row">
							<div class="col-sm-6">
								<span ng-show="errorshow==true" style="color:red">{{timeerror}}</span>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-xs-12">
							<div class="form-example-int pull-right">
								<button class="btn btn-success notika-btn-success" name="submit"  ng-show="slot_id==0" ng-click="meals_slot_validation()" >Save</button>
							
								<button class="btn btn-danger notika-btn-danger" name="cancel" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
			<div class="modal-footer">
				
			</div>
		</div>
	</div>
</div>
<div id="confirm" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
			<h4> Do you want to delete this record?</h4>
				
			</div>
			<div class="modal-footer">
				<div class="form-example-int">
					<button class="btn btn-success notika-btn-success" name="submit"  ng-click="deleteType()" data-dismiss="modal">Yes</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
   
   <!-- End Realtime sts area-->
    <!-- Start Footer area-->
  <?php $this->load->view('../layout/footer.php'); ?>
<script type="text/javascript">
	var table= $('#example1').DataTable({
					'paging'      : true,
					'lengthChange': true,
					'searching'   : true,
					'ordering'    : true,
					'info'        : true,
					'autoWidth'   : false,
					"iDisplayLength": 15,
					order: [[ 1,'desc']],
					lengthMenu: [
						[ 10, 25, 50, 100, 500 ],
						[ '10', '25', '50', '100', '500' ]
					],	
					"contentType": "application/json",
					"ajax": "getAllMealTimeSlot",					
					"columnDefs": [
					{ "visible": false, "targets":0 }
				],
					"columns": [
						   { "data": "name" },
						   { "data": "plan_name" },
						   { "data": "time_from" },
						   { "data": "time_to" },
						   { "data": "action" }
					],
					"drawCallback": function ( settings ) {
					var api = this.api();
					var rows = api.rows( {page:'current'} ).nodes();
					var last=null;

					api.column(0, {page:'current'} ).data().each( function ( group, i ) {
					if ( last !== group ) {
					$(rows).eq( i ).before(
					'<tr class="group"><td bgcolor="#EFE2AB" colspan=4><b>Slot Name: '+group+'</b><b>&nbsp;&nbsp;</b></td></tr>'
					);
					last = group;
					}
					} );
				}
				})
 //Date picker
  
</script>
</body>

</html>