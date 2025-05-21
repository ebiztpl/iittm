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
			<div class="box-body">
			<div class="row">
          <div class="col-sm-3">
           <input type="text" class="form-control" placeholder="Mobile No" id="mobile" ng-model="mobile" ng-disabled="email" require="" autocomplete="off">
          </div>

          <div class="col-sm-1 text-center" style="padding-top: 10px;">
          	<span style="width: 50px; height: 50px; background-color: #00bdff; border-radius: 100%; padding: 10px; color: #fff; font-weight: bold;">OR</span>
          </div>
            <div class="col-sm-3">

           <input type="text" class="form-control" placeholder="Email Id" id="email" ng-model="email"  ng-disabled="mobile" required="" autocomplete="off">
          </div>
         
          <div class="col-sm-3">
          <a class="btn btn-success" ng-model="btn" ng-click="filter_date()" ng-hide="to==''">Search</a>
          </div>

          
        </div>

        <br/>
       
				<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
			
				


				<table id="item-list-filter" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						
						<th class="tbl-header">Sr.no</th>
						<th class="tbl-header">Full name</th>
						<th class="tbl-header">Mobile</th>
						<th class="tbl-header">Email</th>
						<th class="tbl-header">Gender</th>
						<th>Category</th>
						<th>DOB</th>
						<th>Transaction Id</th>
						<th>Fee</th>
						<th>Status</th>
						<th>Entry DateTime</th>
						<th>Update Status</th>
					
					</tr>
					</thead>
					<tbody>
		</tbody>
	</table>


	
	


			</div>
			<b><span id="loadingddupe" style="display:none;">Checking.........</span></b>
			<span id="warning_msg" class="error"></span>
			</div>
			

		<div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
	      <div class="modal-dialog">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span></button>
	            <h4 class="modal-title">Update Fee Status</h4>
	          </div>
	          <div class="modal-body">

	          <div class="row">
	          	<div class="col-sm-8">
	          		<label>Transaction ID</label>
	          		<input type="text" class="form-control" name="trns_id" id="trns_id">
	          	</div>

	          	<div class="col-sm-4">
	          		<label>Fees(in paisa)</label>
	          		<input type="number" class="form-control" name="fees" id="fees">
	          	</div>	
         	  </div>
          		<input type="hidden" ng-model="hidden_query_id" ng-value="" id="hidden_query_id">
          </div>
          	<div class="modal-footer">
            <div class="col-sm-12">
            <button type="button" class="btn btn-primary" ng-click="save_data()">Update Data</button>
            </div>
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
function Dashboard_Details($scope,$log,$http,$compile)
{


    $scope.filter_date = function() {
        
        var from = $('#mobile').val();
        var to = $('#email').val();
        
        var data = from+"~"+to;

        $('#item-list_wrapper').hide();
        $('#item-list-filter').show();	

	    $('#item-list-filter').DataTable({
	        "ajax": {
	            url : "<?php echo site_url('admin/filter_update?data=');?>"+data,
	            type : 'POST'
	        	},
		        "bPaginate": true,
	            "bLengthChange": false,
	            "bFilter": false,
	            "bSort": true,
	            "bInfo": true,
	            "bAutoWidth": false,
	            "searching": true,
	            "bRetreive": true,
	            "destroy": true,
	            dom: 'Bfrtip',
		        lengthMenu:[[25, 50, -1 ],['25 rows', '50 rows', 'Show all' ]],
		        buttons:['copy', 'csv', 'excel', 'pdf', 'print'],
	      });

    };




    $scope.modalpop = function(userid) {
      angular.element('#hidden_query_id').val(userid);	          	
      $("#modal-default").modal('show');
  	  $("#loading").hide();	
    };


    $scope.save_data = function()
    {
    	var trns_id = angular.element('#trns_id').val();
    	var fees = angular.element('#fees').val();
    	if(trns_id==""){alert('Please Enter TransactionId'); $("#trns_id").focus(); return false;}
    	else if(fees==""){alert('Please Enter Fee'); $("#fees").focus(); return false;}
    	

    	$("#loading").show();
    	var data =  trns_id +"~"+ fees+"~"+angular.element('#hidden_query_id').val();
    	$http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/update_transactionId?data=');?>"+data}).then(function(response){
          	//console.log(response.data);
          	if(response.data==1)
          	{
          		$("#modal-default").modal('hide');
	          	$("#loading").hide(); 
	          	$scope.filter_date();
          	}
          	
          })
    }




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

<!--script type="text/javascript">
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
</script-->