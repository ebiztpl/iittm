<?php 
 $yummy = json_decode($result, true);
?>
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
		sidebar(5);
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
        
        <div class="row">
          <div class="col-sm-3">
           <input type="text" class="form-control" placeholder="Transaction Id" id="search" ng-model="sch">
          </div>
          <div class="col-sm-3">
          <a class="btn btn-success" ng-model="btn" ng-click="table_filter()" >Search</a>
          </div>
        </div>

        <br/>
       
				<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
			
				<table class="table table-hover" id="example_razor">
					<thead>
					<tr>
						
						<th class="tbl-header">Sr.no</th>
						<th class="tbl-header">PaymentId</th>
            <th class="tbl-header">Database Id</th>
						<th class="tbl-header">Amount</th>
						<th class="tbl-header">User Id</th>
						<th class="tbl-header">Email</th>
						<th class="tbl-header">Mobile</th>
						<th class="tbl-header">Created At</th>
						<th class="tbl-header">Status</th>
						<th class="tbl-header">Method</th>
						<th class="tbl-header">Action</th>
						
					</tr>
					</thead>

					<tbody>	

						<!--ng-show="list.status=='captured'"-->
						<tr ng-repeat='list in list_items' id="{{$index + cnt}}">
						<td>{{$index +cnt}}</td>
						<td>{{list.id}}</td>	
            <td>{{list.tablepayment_id}}</td>  
						<td>{{(list.amount/100)}}</td>	
						<td>{{list.userid}}</td>
						<td>{{list.email}}</td>
						<td>{{list.contact}}</td>
						<td>{{list.created_at * 1000 | date:'dd-MM-yyyy HH:mm:ss'}}</td>
						<td>
						<span ng-if="list.status=='captured'" class="btn btn-success btn-xs">{{list.status}}</span>
						<span ng-if="list.status=='failed'" class="btn btn-danger btn-xs">{{list.status}}</span>
						<span ng-if="list.status=='refunded'" class="btn btn-primary btn-xs">{{list.status}}</span>
						<span ng-if="list.status=='authorized'" class="btn btn-warning btn-xs">{{list.status}}</span>
						<span ng-if="list.error_description!='' && list.status=='failed'" style="display:block; width:100px;">{{list.error_description}}</span>

						
						</td>
						<td>{{list.method}}</td>
						<td><a title="" class="btn btn-primary" ng-click="modalpop(list.description.split('-')[1])">Show</a></td>
						</tr>

					</tbody>
					
					
				</table>
    <br/>
    <div class="row">
      <div class="col-sm-12 text-center">
        <a ng-click="pre()" class="btn btn-primary"><</a>
        <a ng-click="next()" class="btn btn-primary">></a>
      </div>
    </div>

  </div>	
  
</div>


	<!-- Begin Action Navigation Bar -->
	<div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Candidate Information</h4>
          </div>
          <div class="modal-body">
            <table class="table">
              <thead>
				
                  <tr>
                    <td><b>Name</b></td>
                    <td>{{name}}</td>
                  </tr>

                  <tr>
                    <td><b>Mobile</b></td>
                    <td>{{mobile}}</td>
                  </tr>

                  <tr>
                    <td><b>Email</b></td>
                    <td>{{email}}</td>
                  </tr>

                   <tr>
                    <td><b>Course</b></td>
                    <td><span ng-if="course==1">BBA</span><span ng-if="course==2">MBA</span></td>
                  </tr>

                  <tr>
                    <td><b>Amount</b></td>
                    <td>{{amount/100}}</td>
                  </tr>

                  <tr>
                    <td><b>Created At</b></td>
                    <td>{{createdate | date: 'dd-MM-yyyy H:m:i'}}</td>
                  </tr>

                  <tr>
                    <td><b>Payment Id</b></td>
                    <td>{{paymentid}}</td>
                  </tr>

                  <tr>
                    <td><b>Status</b></td>
                    <td><span ng-if="status==1">Mobile Verified</span><span ng-if="status==2">Paid</span></td>
                  </tr>
              </thead>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
     <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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
function Dashboard_Details($scope,$log,$http,$compile,$window)
{
  $scope.cnt=1;
  

	$scope.list_items = <?php echo $result?>;
	$scope.modalpop = function(userid) {
       $("#loading").show();
      $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/get_data_by_id?data=');?>"+userid}).then(function(response){
          	//console.log(response.data['result'][0]['first_name']);
            $scope.name= response.data['result'][0]['first_name']+" "+ response.data['result'][0]['middle_name']+" "+response.data['result'][0]['last_name'];
            $scope.mobile = response.data['result'][0]['mobile'];
            $scope.email = response.data['result'][0]['email_id']
            $scope.course=response.data['result'][0]['course_id'];
            $scope.amount=response.data['result'][0]['amount'];
            $scope.paymentid=response.data['result'][0]['razorpay_trans_id'];
            $scope.createdate = response.data['result'][0]['created_date'];
            $scope.status = response.data['result'][0]['login_status'];
			
            $("#modal-default").modal('show');
            $("#loading").hide();
          })
       
    };

	

    $scope.next = function() {
        
        var count = $('table tbody tr:last').attr('id');
        
         $("#loading").show();
         $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/table_filter_next?data=');?>"+count}).then(function(response){
            console.log(response.data);
            $scope.cnt = parseInt(count)+1;
            $scope.list_items = response.data;
             $("#loading").hide();
            
          })
        
    };


    $scope.pre = function() {
        
        var count = $('table tbody tr:last').attr('id');
        var lesscnt = parseInt(count)-99;
		//if(lesscnt==="NaN"){$window.location.reload();}
         alert(lesscnt);
         $("#loading").show();
         $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/table_filter_pre?data=');?>"+lesscnt}).then(function(response){
            console.log(response.data);
            $scope.cnt = parseInt(lesscnt);
            $scope.list_items = response.data;
             $("#loading").hide();
            
          })
        
    };


    $scope.table_filter = function() {
        
        var data = $('#search').val();
        if(data !='')
        {
          $("#loading").show();
         $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/table_filter_search?data=');?>"+data}).then(function(response){
            console.log(response.data);
            $scope.cnt = 1;
            $scope.list_items = response.data;
             $("#loading").hide();
            
          })
        }
      
         
        
    };






};

 

</script>

<script type="text/javascript">
     $(function() {
        $('#example_razor').dataTable({
            "bPaginate": false,
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