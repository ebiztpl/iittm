<!doctype html>
<html class="no-js" lang="">

<head>
   <?php $this->load->view('../layout/head.php'); ?>
    <style>
   .tooltip-inner {
		max-width: 100px;
		width: 100px; 
	}
</style>
</head>

<body class="hold-transition skin-blue sidebar-mini" ng-app="myapp" ng-controller="ItemMasterCtrl" >
	<?php $this->load->view('../layout/header.php'); ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php $this->load->view('../layout/sidemenu.php');
				sidebar(5);
	?>
<div class="content-wrapper" >
	<section class="content-header">
		<h1>Item List </h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
			<!--<li><a href="#">Type</a></li>-->
			<li class="active">Item Master</li>
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
						<a class="btn btn-info" data-toggle="tooltip" title="Add Item" ng-click="showAddItemModal();">
						<i class="fa fa-plus"></i></a>
					</div>
				</div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Item name</th>
								<th>Category</th>
								<th>Meals</th>
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
<div id="ItemModal" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" ><span ng-show="item_id==0">Add</span> <span ng-show="item_id!=0">Edit</span>Item Master</h4>
			</div>
			<div class="modal-body">
			 <form name="myForm" class="form-horizontal" novalidate >
				<div class="row">
					<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="hrzn-fm col-sm-4 control-label" for="item_name"> <i class="notika-icon notika-support"></i>Item Name</label>
								<div class="col-sm-8" ng-class="{false:'has-error',true:' has-success'}[myForm.item_name.$valid]">
									<input type="text" name="item_name" class="form-control input-sm" placeholder="Name" required ng-model="item_name">
									 <span ng-show="myForm.item_name.$invalid" style="color:red">{{msgerror}}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="hrzn-fm col-sm-2 control-label" for="cate_id"> <i class="notika-icon notika-support"></i>Category</label>
								<div class="col-sm-4" ng-class="{false:'has-error',true:' has-success'}[myForm.cate_id.$valid]">
									<Select type="text" name="cate_id" class="form-control input-sm" ng-model="cate_id" ng-options="t.id as t.name for t in catearr" required></select>
									<span ng-show="cate_id==0" style="color:red">{{msgerror}}</span>
									
								</div>
								<div class="col-sm-1">
									<a class="btn btn-info" data-toggle='modal' data-toggle='tooltip' data-target='#categorymodal'  title="Add Category" >
										<i class="fa fa-plus" data-toggle='tooltip' title="Add Category"></i>
									</a>
								</div>
							</div>
							
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-sm-2 control-label"> <i class="notika-icon notika-support"></i>Meals</label>
								<div class="col-sm-10">
								<div class="row">
								<div class="col-sm-3" ng-repeat="m in mealsarr">
									<input type="checkbox" ng-model="mealnames[m.id]" name="mealnames[]" id="{{m.id}}"  ng-checked="mealnamesarr.indexOf(m.id) > -1" ng-click="toggleSelection(m.id,mealnamesarr)" value="m.id" >
										<label class="control-label" for="{{m.id}}">&nbsp;&nbsp;{{m.name}}</label>
										
								</div>
								<span ng-show="mealnames.length==0" style="color:red">{{mealarr}}</span>
								</div>
								</div>
							</div>
						</div>
						
					</div>
					
						<div class="col-lg-8 col-md-8 col-xs-12">
							<div class="form-example-int pull-right">
								<button class="btn btn-success notika-btn-success" name="submit"  ng-show="item_id==0" ng-click="item_validation()" >Save</button>
								
								<button class="btn btn-success notika-btn-success" name="submit"  ng-show="item_id!=0" ng-click="item_validation()" >Update</button>
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
<div id="categorymodal" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" >Add Category</h4>
			</div>
			<div class="modal-body">
			 <form name="myForm1" class="form-horizontal" novalidate >
				<div class="row">
					<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="hrzn-fm col-sm-4 control-label" for="cate_name"> <i class="notika-icon notika-support"></i>Category</label>
								<div class="col-sm-8" ng-class="{false:'has-error',true:' has-success'}[myForm.cate_name.$valid]">
									<input type="text" name="cate_name" class="form-control input-sm" placeholder="Category" required ng-model="cate_name">
									 <span ng-show="myForm1.cate_name.$invalid" style="color:red">{{msgerror1}}</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-xs-12">
						<div class="form-example-int pull-right">
							<button class="btn btn-success notika-btn-success" name="submit" ng-click="cate_validation()" >Save</button>
							
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
					"ajax": "getAllItems",					
					"columnDefs": [
					{ "visible": true, "targets": 1 }
				],
					"columns": [
						   { "data": "name" },
						   { "data": "cate_name" },
						   { "data": "meals" },
						   { "data": "action" }
					]
				})
 //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
	  format: 'dd/mm/yyyy'
    })

</script>
</body>

</html>