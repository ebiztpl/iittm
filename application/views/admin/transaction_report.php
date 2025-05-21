<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <script src="<?=base_url();?>themes/js/jquery.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
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
				'novalidate'=>'novalidate',
				'ng-submit'=> 'assign_Submit($event)'
			);
			echo form_open('',$lFormAttrb); 
		?>

		<div class="box">		
			<div class="box-body table-responsive">
				<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
			
				<table class="table table-hover" id="example2">
					<thead>
					<tr>
						
						<th class="tbl-header">Sr.no</th>
						<th class="tbl-header">PaymentId</th>
						<th class="tbl-header">Amount</th>
						<th class="tbl-header">Name</th>
						<th class="tbl-header">Email</th>
						<th class="tbl-header">Mobile</th>
						<th class="tbl-header">Payment DateTime</th>
						<th class="tbl-header">Status</th>
						<th class="tbl-header">Entry DateTime</th>
						<!--th class="tbl-header">Action</th-->
						
					</tr>
					</thead>

					<tbody>	

						<tr ng-repeat='list in list_items' id="row_id{{list.user_id}}">
						<td>{{$index + 1}}</td>
						<td>{{list.razorpay_trans_id}}</td>	
						<td>{{(list.amount/100)}}</td>	
						<td>{{list.first_name}} {{list.middle_name}} <br/>{{list.last_name}}</td>
						<td>{{list.email_id}}</td>
						<td>{{list.user_mobile}}</td>
						<td>{{list.post_date | date: 'dd-MM-yyyy H:m:i'}}</td>
						<td>
							<span ng-if="list.login_status == 1" class="btn btn-xs btn-danger"> Mobile Verified</span>
							<span ng-if="list.login_status == 2 && list.razorpay_trans_id!=''" class="btn btn-xs btn-success"> Payment Done</span>
						</td>
						<td>{{list.created_date}}</td>
						<!--td><a href="{{list.user_id}}" class="btn btn-primary">Update</a></td-->
						</tr>

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

<script>
$(document).ready(function(){
	$("#loading").hide();
});
var App = angular.module('myApp', ['ui.bootstrap']); 
function Dashboard_Details($scope,$log,$http,$compile)
{

	$scope.list_items = <?php echo json_encode($result);?>;
	$scope.sampledate = new Date();
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

#loading{
	width: 100%;
height: 800px;
position: absolute;
background-color: rgba(0, 0, 0, 0.50) !important;
text-align: center;
padding-top: 30%;
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
            [25, 50, -1 ],
            ['25 rows', '50 rows', 'Show all' ]
        ],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
		
        

        });
    });
</script>