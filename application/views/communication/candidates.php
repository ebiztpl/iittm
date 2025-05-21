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
<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(1205);
  ?>
	
	

<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
    	<div class="page-content">
	

		<div class="box">		
			<div class="box-body">
		
        <div class="row">

       

          <div class="col-sm-2" >
            <label>Course</label><br/>
          <select class="form-control" id="course" required="">
            <option value="0,1,2">Both</option>
            <option value="0">N/A</option>
            <option value="1">BBA</option>
            <option value="2">MBA</option>
            </select>
          </div>
     

          <div class="col-sm-2" style="padding-right: 0px;">
            <label>FromDate</label><br/>
           <input type="text" class="form-control datepicker" placeholder="From Date" id="from" ng-model="from" require="" autocomplete="off" style="border-radius: 0px;">
          </div>
            <div class="col-sm-2" style="padding-right: 0px;">
              <label>ToDate</label><br/>
           <input type="text" class="form-control datepicker" placeholder="To Date" id="to" ng-model="to" required="" autocomplete="off"  style="border-radius: 0px;">
          </div>

        <div class="col-sm-2" style="padding-right: 0px;">
          <label>Name</label><br/>
          <input type="text" class="form-control" placeholder="Name" id="name" autocomplete="off">
        </div>

          <div class="col-sm-2" style="padding-right: 0px;">
            <label>Mobile</label><br/>
           <input type="text" class="form-control" placeholder="Mobile No." id="mobile" autocomplete="off">
          </div>

        <div class="col-sm-2">
            <label>Email</label><br/>
           <input type="text" class="form-control" placeholder="Email" id="email" autocomplete="off">
          </div>

      </div>
      <div class="row" style="margin-top: 10px;">

        <div class="col-sm-2">
    <label>Study Centre</label>
        <select name="first_code" class="form-control common_code" ng-model="study_center" id="study_center">
          <option value="">All</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
      <option value="Goa">Goa</option>
         </select>

        </div>


           <div class="col-sm-2">
            <label>Category</label><br/>
            <input type="checkbox" class="category" name="category" value="General" > &nbsp;General &nbsp;
            <input type="checkbox" class="category" name="category" value="EWS"> &nbsp;EWS &nbsp;
            <input type="checkbox" class="category" name="category" value="OBC"> &nbsp;OBC &nbsp;<br/>
            <input type="checkbox" class="category" name="category" value="SC" > &nbsp;SC  &nbsp;      
            <input type="checkbox" class="category" name="category" value="ST" > &nbsp;ST &nbsp;
            
          </div>

          

           <div class="col-sm-2">
            <label>Candidate</label><br/>
              <!--  <input type="radio" class="candidate" name="candidate" value="0"  > &nbsp;Registration&nbsp; -->
            <input type="radio" class="candidate" name="candidate" value="1"> &nbsp;Admission &nbsp;&nbsp;&nbsp;
            <input type="radio" class="candidate" name="candidate" value="2"> &nbsp;Exam 
      

              <select class="exam form-control" style="display: none;">
                <option>--Select--</option>
                <?php foreach ($exams as $key => $exam) { ?>
                  <option value="<?=$exam['id']?>"><?=$exam['exam_name']?></option>
                <?php } ?>
              </select>
      
          </div>

           <div class="col-sm-2">
            <label>Gender</label><br/>
            <input type="checkbox" class="gender" name="gender" value="Male" > &nbsp;Male&nbsp;
            <input type="checkbox" class="gender" name="gender" value="Female"> &nbsp;Female 
      
          </div>

       
          <div class="col-sm-2">
            <label>Academic Status</label><br/>
            <input type="checkbox" class="academic" name="academic" value="appearance"  > &nbsp;Appearance&nbsp;
            <input type="checkbox" class="academic" name="academic" value="Graduation"> &nbsp;Graduation <br/>
          <input type="checkbox" class="academic" name="academic" value="passed"> &nbsp;Passed 
          </div>

           <div class="col-sm-2">
            <label>Candidate Status</label><br/>
            <input type="radio" name="reg_status" value="complete" class="reg_status" checked> Completed &nbsp;
            <input type="radio" name="reg_status" value="incomplete" class="reg_status"> Incompleted
           </div>

          
        </div>
      
				
    		<div class="row" style="margin-top:20px;">
    			<div class="col-sm-11">
    			<input type="text" class="form-control" id="ids" placeholder="Candidate Primary Ids" />
    			</div>
    			
    			<div class="col-sm-1">
              	<a class="btn btn-success" ng-model="btn" ng-click="search_data()" ng-hide="to==''">Search</a>
          </div>

		</div>
				
				
        <br/>
       
		
			
			

		

</div>

<b><span id="loadingddupe" style="display:none;">Checking.........</span></b>
<span id="warning_msg" class="error"></span>
</div>
<!-- Begin Action Navigation Bar -->

 <form action="assignment_save" method="post" id="assignment_save">

  <div class="box">   
      <div class="box-body">
        
          <div class="col-sm-10">
  <span style="font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>
            <div style="overflow:scroll; height:500px;">
        <table id="item-list-filter" class="table table-bordered table-striped table-hover ">
        <thead>
          <tr>
            
            <th class="tbl-header">All <input type="checkbox" id="select_all"  ></th>
            <th class="tbl-header">Roll No.</th>
            <!-- <th class="tbl-header">Exam</th> -->
            <th class="tbl-header">Course</th>
            <th class="tbl-header">Study Centre</th>
            <th class="tbl-header">Score</th>
            <th class="tbl-header">Full name</th>
            <th class="tbl-header">Mobile</th>
            <th>Father Name</th>
            <th>Mother Name</th>
            <th>DOB</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Category</th>
        <!--     <th>Father Mobile</th>
            <th>Mother Mobile</th> -->
            <th>Religion</th>
            <th >Parr. State</th>
            <th >Parr. City</th>
            <th>Entry DateTime</th>
            <!-- <th>Fee DateTime</th> -->
          
          </tr>
          </thead>
          <tbody>


    </tbody>
  </table>
</div>
        
        </div>

        <div class="col-sm-2">

          <h4>Assign</h4>
          <hr style="margin-top: 0px;" />

           <label>Assignment Name<span style="color: red">*</span></label>
          <input type="text" name="assignment_name" class="form-control" required="">
          <br/>


          <label>Campaign<span style="color: red">*</span></label>
          <select class="form-control" name="assign_campaign" id="assign_campaign" required="">
          <option value="">Select</option>
            <?php 
            foreach ($campaign as $key => $campaigns) {
              echo "<option value=".$campaigns->id.">".$campaigns->name."</option>";
            }
            ?>
          </select>

          <br/>
          <label>Team/User<span style="color: red">*</span></label>
          <select class="form-control" name="assign_team" id="assign_team" required="">
            <option value="">Select</option>
            <?php 
            foreach ($user as $key => $users) {
              echo "<option value=".$users->admin_id.">".$users->admin_name."</option>";
            }
            ?>

          </select>

          <br/>


          <label>StartDate</label>
          <input type="text" name="start_date" class="form-control datepicker">

           <br/>


          <label>EndDate</label>
            <input type="text" name="end_date" class="form-control datepicker">
          <br/>

          <button class="btn btn-primary">Assign</button>

        </div>
        
      </div>
  </div>
			
<?php echo form_close(); ?>			
</div>
</section>
</div>



<div class="modal fade" id="exam_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Candidate Calls Response</h5>

        <span style="position: absolute; top: 15px; right: 15px; cursor: pointer;"><i class="fa fa-close"></i></span>
        
      
      
      </div>
      <div class="modal-body">
        <form action="#" id="calling_data_save" method="POST" >
          <input type="hidden" id="user_id" name="user_id" />

          <div class="row">
          	<div class="col-sm-6">
          		<div class="form-group">
              	<label>Calling Date<span style='color:red;'>*</span></label>
               <input type="text" class="form-control datepicker" name="call_date" required="">
              </div>
          	</div>
          	<div class="col-sm-6">
          		 <div class="form-group">
              	<label>Calling Time<span style='color:red;'>*</span></label>
                <input type="text" class="form-control timepicker" name="call_time"  required="">
              </div>
          	</div>
          </div>


          <div class="row">
          	<div class="col-sm-6">
          		<div class="form-group">
              	<label>Select Team Member<span style='color:red;'>*</span></label>
                <select class="form-control" name="team_id" id="team_id" required="">
                	<option value="">Select</option>
                	<?php 
                	foreach ($team as $key => $teams) {
                		echo "<option value=".$teams->id.">".$teams->name."</option>";
                	}
                	?>
                </select>
              </div>
          	</div>
          	<div class="col-sm-6">
          		 <div class="form-group">
              	<label>Select Campaign<span style='color:red;'>*</span></label>
                <select class="form-control" name="campaign_id" id="campaign_id" required="">
                	<option value="">Select</option>
                	<?php 
                	foreach ($campaign as $key => $campaigns) {
                		echo "<option value=".$campaigns->id.">".$campaigns->name."</option>";
                	}
                	?>
                </select>
              </div>
          	</div>
          </div>


          <div class="row">
          	<div class="col-sm-6">
          		<div class="form-group">
              	<label>Select Calling Mode<span style='color:red;'>*</span></label>
                <select class="form-control" name="mode_id" id="mode_id" required="">
                	<option value="">Select</option>
                	<?php 
                	foreach ($mode as $key => $modes) {
                		echo "<option value=".$modes->id.">".$modes->name."</option>";
                	}
                	?>
                </select>
              </div>
          	</div>
          	<div class="col-sm-6">
          		 <div class="form-group">
              	<label>Call Action<span style='color:red;'>*</span></label>
                <select class="form-control" name="call_action" id="call_action" required="">
                	<option value="connected">Connected</option>
                	<option value="not-answer">Not Answer</option>
                	<option value="invalid-no">Invalid No.</option>
                	<option value="disconnected">Disconnected</option>
                </select>
              </div>
          	</div>
          </div>



          <div class="row">
          	
          	<div class="col-sm-12">
          		 <div class="form-group">
              	<label>Campaign Responses<span style='color:red;'>*</span></label><br/>
                <select class="form-control" name="response_id" id="response_id" required="">
                	<option value="">Select</option>
                	<?php 
                	foreach ($responses as $key => $responsess) {
                		echo "<option value=".$responsess->id.">".$responsess->name."</option>";
                	}
                	?>
                </select>
              </div>
          	</div>
          </div>



          <div class="row">
          	<div class="col-sm-6">
          		<div class="form-group">
              	<label>Correct Email (if needed)</label>
               <input type="text" class="form-control" name="correct_email">
              </div>
          	</div>
          	<div class="col-sm-6">
          		 <div class="form-group">
              	<label>Correct Mobile (if needed)</label>
              <input type="text" class="form-control" name="correct_mobile">
              </div>
          	</div>
          </div>


          <div class="row">
          	<div class="col-sm-12">
          		 <div class="form-group">
              	<label>Notes</label>
                <textarea class="form-control" name="notes"></textarea>
              </div>
          	</div>
          </div>
          	  
              <button class="btn btn-primary" name="btnsubmit">Save</button>
            </form>

            <span id="msg" style="font-size:20px;"></span>
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
$(document).ready(function(){
	
	$("#loading").hide();

	$('.datepicker').datepicker({
    	format: 'yyyy-mm-dd',
    	 autoclose: true
	});

  $("#assignment_save").hide();


	$(".timepicker").timepicker();

	$(".fa-close").click(function(){
		
		$("#exam_status").modal('hide');
		$(".js-select2").empty();
		$("#msg").html("");
		$(".js-select2").select2('refresh');

	});
  

	
	// $(document).on('click',".exam_status", function() {
		
	// 		var id = $(this).attr('data-id'); 
	// 		$("#user_id").val(id);
	// 		$("#exam_status").modal('show');

		
	// });


	$("#calling_data_save").submit(function(){
	    $.ajax({
	        url: "<?php echo site_url('communication/calling_data_save');?>", 
	        data: $("#calling_data_save").serialize(), 
	        type: "POST", 
	        dataType: 'json',
	        success: function (e) {
	        	$("#msg").html(e.msg);
	        	$("#calling_data_save").reset();
	            
	        },
	        error:function(e){
	            
 alert(e);
	        }
	    }); 
   		return false;
	});


});
var App = angular.module('myApp', ['ui.bootstrap']); 
function Dashboard_Details($scope,$log,$http,$compile)
{

 $('.candidate').click(function(){
    id = $(this).val();
    if(id == 2){
      $('.exam').show();
    }else{
       $('.exam').hide();
    }
  });
	
	$scope.list_items = "";
	$scope.sampledate = new Date();




    $scope.search_data = function() {

    	$("#loading").show();

		   var whereClauses = []; 

          if($("#from").val() !="" && $("#to").val() !="") 
          {
             var status = $("input[name='reg_status']:checked").val();
			 if(status=='incomplete'){
				 whereClauses.push('um.created_date >= '+"'"+$("#from").val()+" 00:00:01' AND um.created_date <= '"+ $("#to").val()+" 23:59:59'");
			 }else{
            	whereClauses.push('ca.post_date >= '+"'"+$("#from").val()+" 00:00:01' AND ca.post_date <= '"+ $("#to").val()+" 23:59:59'");
			  }
          }
          

          if ($("#course").val() !="") 
          {
              //um.course_id in ($course)
              whereClauses.push('um.course_id in '+"("+$("#course").val()+")"); 
          }
       
          if ($("#name").val() !="") 
          {
              whereClauses.push('ca.first_name like '+"'%"+$("#name").val()+"%'"); 
          }
          if ($("#mobile").val() !="") 
          {
              whereClauses.push('um.user_mobile='+"'"+$("#mobile").val()+"'"); 
          }
          if ($("#email").val() !="") 
          {
              whereClauses.push('ca.email='+"'"+$("#email").val()+"'"); 
          }

          if ($("#study_center").val() !="") 
          {
              whereClauses.push('ca.study_centre_1='+"'"+$("#study_center").val()+"'"); 
          }

          
          if ($(".category").is(':checked')) 
          {
              chk=[];
              $("input[name='category']:checked").each ( function() {
              chkId = $(this).val();
              chk.push(chkId);
               });

                whereClauses.push('ca.category in '+"('"+chk+"')"); 

          }

         if ($(".candidate").is(':checked')) 
          {
              // chk1=[];
              // $("input[name='candidate']:checked").each ( function() {
              // chkId1 = $(this).val();
              // chk1.push(chkId1);
              // });

              // whereClauses.push('ca.admission in '+"('"+chk1+"')"); 

              var candidate = $("input[name='candidate']:checked").val();
              if(candidate == 1){
                whereClauses.push('ca.admission = 1');
              }
              if(candidate == 2){
                var exam = $('.exam').val();
                whereClauses.push('ce.exam_id ='+ exam);
              }
             

          }

          if ($(".gender").is(':checked')) 
          {
                  chk2=[];
                  $("input[name='gender']:checked").each ( function() {
                  chkId2 = $(this).val();
                  chk2.push(chkId2);
                   });

                  whereClauses.push('ca.gender in '+"('"+chk2+"')");
          }

          if($(".academic").is(':checked')) 
          {
                  chk3=[];
                  $("input[name='academic']:checked").each ( function() {
                  chkId3 = $(this).val();
                  chk3.push(chkId3);
                  });

                  whereClauses.push('ca.academic_status in '+"('"+chk3+"')");
          }

          if($(".reg_status").is(':checked')) 
          {

           var res = $('input[name=reg_status]:checked').val();
          
            if(res == 'complete'){
              var reg_status = 0;
            }else{
              var reg_status = 1;
            }
          }


      		if($("#ids").val() !=""){
      			whereClauses.push('um.user_id in '+"("+$("#ids").val()+")");
      		}

	        var withand = whereClauses.join(" AND ");
          if (whereClauses.length != 0) 
          { 
            var where = ' WHERE '+ withand;
          } 
		
       

        $('#item-list_wrapper').hide();
        $('#item-list-filter').show();	

	       let candidate_table = $('#item-list-filter').DataTable({
	        "ajax": {
	            url : "<?php echo site_url('communication/candidate_search');?>",
				      data:{'data': where,'reg_status' : reg_status },
	            type : 'POST'
	        	  },initComplete: function(e) {
			          $("#loading").hide();
					  $("#assignment_save").show();
					  $("#record").html(e.json.recordsTotal);
			        },
               "fixedHeader": true,
		          "bPaginate": false,
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
		          lengthMenu:[[25, 50, -1 ],['25 rows', '50 rows', 'Show all' ]],
		          buttons:['copy', 'csv', 'excel', 'pdf', 'print'],
              

	      });




          $('#select_all').on('click', function(){
            var rows = candidate_table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
    		
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

#loading{
	width: 100%;
height: 800px;
position: absolute;
background-color: rgba(0, 0, 0, 0.50) !important;
text-align: center;
padding-top: 30%;
z-index: 99999;
	}
</style>
