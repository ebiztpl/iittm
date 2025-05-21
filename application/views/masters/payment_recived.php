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

<body class="hold-transition skin-blue sidebar-mini" ng-app="myapp" ng-controller="PaymentCtrl" >
	<?php $this->load->view('../layout/header.php'); ?>
	<!-- Left side column. contains the logo and sidebar -->
	<?php $this->load->view('../layout/sidemenu.php');
				sidebar(4);
	?>
<div class="content-wrapper" >
	<section class="content-header">
		<h1>Payment Recived List </h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
			<!--<li><a href="#">Type</a></li>-->
			<li class="active">Payment Recived</li>
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
						<a class="btn btn-info" data-toggle="tooltip" title="Add Payment " ng-click="showPaymentModal();">
						<i class="fa fa-plus"></i></a>
					</div>
				</div>
				<div class="box-body">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Mobile</th>
								<th>Plan</th>
								<th>Payment Mode</th>
								<th>Transaction ID</th>
								<th>Paid Type</th>
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
<div id="paymentModal" class="modal fade" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" ><span ng-show="payment_id==0">Add</span> <span ng-show="payment_id!=0">Edit</span> Payment Recived</h4>
				
			</div>
			<span style="color:red" class="pull-right">Note:fill mobile no. and press enter &nbsp;</span><br>
			<div class="modal-body">
				<form name="myForm" class="form-horizontal" novalidate >
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="hrzn-fm col-sm-4 control-label" for="mobile"> <i class="notika-icon notika-support"></i> Mobile</label>
										<div class="col-sm-8" ng-class="{false:'has-error',true:' has-success'}[myForm.mobile.$valid]">
											<input type="text" name="mobile" class="form-control input-sm" placeholder="Mobile No." required ng-model="mobile" ng-enter="getuserdata(mobile)">
											
											 <span ng-show="myForm.mobile.$invalid" style="color:red">{{msgerror}}</span>
											 
											 <span ng-show="findsts==false" style="color:red">{{nodatafound}}</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="hrzn-fm col-sm-4 control-label" for="username"> <i class="notika-icon notika-support"></i> Name</label>
										<div class="col-sm-8" ng-class="{false:'has-error',true:' has-success'}[myForm.username.$valid]">
											<input type="text" name="username" class="form-control input-sm" placeholder="Name" required ng-model="username">
											 <span ng-show="myForm.username.$invalid" style="color:red">{{msgerror}}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
									<label class="hrzn-fm col-sm-1" for="paytype"> <i class="notika-icon notika-support"></i></label>
										<div class="col-sm-6 text-right" style="margin-left: 8px">
											<input type="radio" value="1" ng-model="paytype" name="month" id="month" ng-click="SetMonth(1)" required><label for="month">&nbsp;&nbsp;Monthly</label>
										</div>
										<div class="col-sm-4">
											&nbsp;&nbsp;<input type="radio" value="2" name="date" ng-model="paytype" id="date" ng-click="SetMonth(2)" required><label for="date">&nbsp;&nbsp;Date</label>
										</div>
										<span class="text-right" ng-show="paytype==''" style="color:red;">{{msgerror}}</span>
							
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group" ng-show="showmonth">
										<label class="hrzn-fm col-sm-4 control-label" for="monthpay"> <i class="notika-icon notika-support"></i>Monthly</label>
										<div class="col-sm-8" ng-class="{false:'has-error',true:' has-success'}[myForm.monthpay.$valid]">
											<div class="input-group date" >
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" name="monthpay" id="monthpay" class="form-control input-sm" placeholder="Select Month"  ng-model="monthpay" >
											</div>
										</div>
									</div>
									<div class="form-group" ng-show="showdate">
										<label class="hrzn-fm col-sm-4 control-label" for="datepay"> <i class="notika-icon notika-support"></i> Date</label>
										<div class="col-sm-8" ng-class="{false:'has-error',true:' has-success'}[myForm.datepay.$valid]">
											<div class="input-group date" >
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
												<input type="text" name="datepay" id="datepay" class="form-control input-sm" placeholder="Date"  ng-model="datepay" >
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="hrzn-fm col-sm-4 control-label" for="meal_plan"> <i class="notika-icon notika-support"></i>Plan</label>
										<div class="col-sm-8" ng-class="{false:'has-error',true:' has-success'}[myForm.meal_plan.$valid]">
											<Select type="text" name="meal_plan" class="form-control input-sm" ng-model="meal_plan" ng-options="t.id as t.name for t in mealplansarr" required></select>
											<span ng-show="meal_plan==0" style="color:red">{{msgerror}}</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label class="hrzn-fm col-sm-4 control-label" for="amount"> <i class="notika-icon notika-support"></i> Amount</label>
										<div class="col-sm-8" ng-class="{false:'has-error',true:' has-success'}[myForm.amount.$valid]">
											<input type="text" name="amount" class="form-control input-sm" placeholder="Amount" required ng-model="amount">
											 <span ng-show="myForm.amount.$invalid" style="color:red">{{msgerror}}</span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
									<label class="hrzn-fm col-sm-1" for="username"> <i class="notika-icon notika-support"></i></label>
										<div class="col-sm-3 text-right" >
											&nbsp;&nbsp;<input type="radio" value="1" ng-model="paidto" name="selfpaid" id="selfpaid" required><label for="selfpaid">&nbsp;&nbsp;Self Paid</label>
										</div>
										<div class="col-sm-4">
											&nbsp;&nbsp;<input type="radio" value="2" name="orgpaid" id="orgpaid" ng-model="paidto" required><label for="orgpaid">&nbsp;&nbsp;Bill to organization</label>
										</div>
									</div>
									<span ng-show="paidto==''" style="color:red;margin-left:18px;">{{msgerror}}</span>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="hrzn-fm col-sm-2 control-label" for="username" style="margin-top: -5px"> <i class="notika-icon notika-support"></i>Mode</label>
										<div class="col-sm-2" style="margin-left: -9px">
											&nbsp;&nbsp;<input type="radio" value="1" ng-model="paymode" name="cash" id="cash" required><label for="cash">&nbsp;&nbsp;Cash</label>
										</div>
										<div class="col-sm-2">
											&nbsp;&nbsp;<input type="radio" value="2" name="credit" id="credit" ng-model="paymode" required><label for="credit">&nbsp;&nbsp;Credit</label>
										</div>
										<div class="col-sm-4">
											&nbsp;&nbsp;<input type="radio" value="3" name="paytm" id="paytam" ng-model="paymode" required><label for="paytam">&nbsp;&nbsp;Paytm</label>
										</div>
										
									</div>
									<span ng-show="paymode==''" style="color:red;margin-left:18px;">{{msgerror}}</span>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="hrzn-fm col-sm-4 control-label" for="trans_id"> <i class="notika-icon notika-support"></i> Transaction ID</label>
										<div class="col-sm-8" ng-class="{false:'has-error',true:' has-success'}[myForm.trans_id.$valid]">
											<input type="text" name="trans_id" class="form-control input-sm" placeholder="Transaction ID" required ng-model="trans_id">
											 <span ng-show="myForm.trans_id.$invalid" style="color:red">{{msgerror}}</span>
										</div>
									</div>
								</div>
							</div>	
							<div class="col-lg-8 col-md-8 col-xs-12">
								<div class="form-example-int pull-right">
									<button class="btn btn-success notika-btn-success" name="submit"  ng-show="payment_id==0" ng-click="payment_validation()" >Save</button>
									
									<button class="btn btn-success notika-btn-success" name="submit"  ng-show="payment_id!=0" ng-click="meals_validation()" >Update</button>
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
					"ajax": "getAllPayment",					
					"columnDefs": [
					{ "visible": true, "targets": 1 }
				],
					"columns": [
						   { "data": "name" },
						   { "data": "mobile" },
						   { "data": "userplan" },
						   { "data": "paidby" },
						   { "data": "transaction_id" },
						   { "data": "pay_month_date" },
						  
						   { "data": "action" }
					]
				})
 //Date picker
    $('#datepay').datepicker({
      autoclose: true,
	  format: 'dd/mm/yyyy'
    });
	$('#monthpay').datepicker({
		startView: "months", 
		minViewMode: "months",
		format:"MM yyyy",
		autoclose: true
	});

</script>
</body>

</html>