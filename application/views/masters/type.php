<!doctype html>
<html class="no-js" lang="">

<head>
   <?php $this->load->view('../layout/head.php'); ?>
    <style>
   .tooltip-inner {
		max-width: 80px;
		width: 80px; 
	}
</style>
</head>

<body class="hold-transition skin-blue sidebar-mini" ng-app="myapp" ng-controller="TypeCtrl" >
	<?php $this->load->view('../layout/header.php'); ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php $this->load->view('../layout/sidemenu.php');
				sidebar(1);
	?>
<div class="content-wrapper" >
	<section class="content-header">
		<h1>Type Master </h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
			<!--<li><a href="#">Type</a></li>-->
			<li class="active">Type</li>
		</ol>
    </section>
	<section class="content">
			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title"></h3>
					<span ng-show="msg!='' && status==true">
					<div class="alert alert-success alert-dismissible" >
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                       </button><strong> {{msg}}</strong>
					</div>
					</span>
					<span ng-show="msg!='' && status==false">
					<div class="alert alert-danger alert-dismissible" >
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                       </button><strong>{{msg}}</strong> 
					</div>
					</span>
						
					<div class="box-tools pull-right">
						<a class="btn btn-info" data-toggle="tooltip" title="Add Type" ng-click="showAddTypeModal();">
						<i class="fa fa-plus"></i></a>
					</div>
				</div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Type</th>
								<th>PostDate</th>
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
<div id="TypeModal" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" ><span ng-show="type_id==0">Add</span> <span ng-show="type_id!=0">Edit</span> Type</h4>
			</div>
			<div class="modal-body">
			 <form name="myForm" class="form-horizontal" novalidate >
				<div class="row">
					<div class="col-sm-12">
						<div class="col-sm-8">
							<div class="form-group">
								<label class="hrzn-fm col-sm-2"> <i class="notika-icon notika-support"></i> Type</label>
								<div class="col-sm-9" ng-class="{false:'has-error',true:' has-success'}[myForm.type_name.$valid]">
									<input type="text" name="type_name" class="form-control input-sm" placeholder="Type" required ng-model="type_name">
									 <span ng-show="myForm.type_name.$invalid" style="color:red">{{msgerror}}</span>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12">
							<div class="form-example-int">
								<button class="btn btn-success notika-btn-success" name="submit" ng-show="type_id==0" ng-click="type_check()" >Save</button>
								<button class="btn btn-success notika-btn-success" name="submit"  ng-show="type_id!=0" ng-click="type_check()" >Update</button>
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
<div id="confirm" class="modal fade" role="dialog" >
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
					"ajax": "getAlltype",					
					"columnDefs": [
					{ "visible": true, "targets": 1 }
				],
					"columns": [
						   { "data": "name" },
						   { "data": "postdate" },
						  
						   { "data": "action" }
					]
				})

</script>
</body>

</html>