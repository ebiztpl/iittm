<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <!-- <script src="<?=base_url();?>themes/js/jquery.min.js"></script> -->

  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
  <style type="text/css">
    .select2 {width:100% !important;}
    .select2-container--default .select2-selection--multiple .select2-selection__choice{background: #444 !important; border:none !important;}
  </style>

</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="Dashboard_Details">
<div class="wrapper">
<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(1207);
  ?>
	
	

<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
    	<div class="page-content">

         <div class="box">   
      <div class="box-body">
        
          <div class="col-sm-12">
              <?php 
              echo "<ul style='justify-content: space-around; display: flex;}'>";
              foreach ($assignment as $key => $assignments) {
                echo '<a class="btn btn-primary click_assignment" data-id="'.$assignments->campaign_id.'">'.$assignments->name.'</a>';
              }
              echo "</ul>";
              ?>
          </div>
        </div>
      </div>


 <form action="assignment_save" method="post">

  <div class="box">   
      <div class="box-body">
        
          <div class="col-sm-12">

   <div style="overflow:scroll; height:500px;">
        <table id="item-list-filter" class="table table-bordered table-striped table-hover ">
        <thead>
          <tr>
            
            <!-- <th class="tbl-header">All <input type="checkbox" id="select_all"  ></th> -->
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

    
        
      </div>
  </div>
			
<?php echo form_close(); ?>			
</div>
</section>
</div>

<div class="modal fade" id="tag-create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 999999;">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top: 15%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Create Tag</h5>
        <span style="position: absolute; top: 15px; right: 15px; cursor: pointer;"><i class="fa fa-close fa-close-tag"></i></span>
      </div>
      <div class="modal-body">

        <form id="save-tag">
        <input type="text" name="tag-create" class="form-control" required="">
        <br/>
        <button class="btn btn-danger" id="submitButton">Create</button>
        </form>
      </div>
    </div>
  </div>
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
          	<div class="col-sm-4" style="padding-right: 0px;">
          		<div class="form-group">
              	<label>Calling Date<span style='color:red;'>*</span></label>
               <input type="text" class="form-control datepicker" name="call_date" required="">
              </div>
          	</div>
          	<div class="col-sm-4">
          		 <div class="form-group">
              	<label>Calling Time<span style='color:red;'>*</span></label>
                <input type="text" class="form-control timepicker" name="call_time"  required="">
              </div>
          	</div>

             <div class="col-sm-4" style="padding-left: 0px;">
               <div class="form-group">
                <label>Select Campaign <i class="fa fa-info-circle tooltipss"  data-toggle="tooltip" data-placement="top" title="Tooltip on top"></i></label>
                <input type="hidden" name="campaign_id_hidden" id="campaign_id_hidden">
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
          	<!-- <div class="col-sm-6">
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
          	</div> -->
          

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
              	<label>Call Responses<span style='color:red;'>*</span></label><br/>
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
              <label>Tag <span style='color:red;'>(type text & press enter)</span><a class="btn btn-primary btn-xs tag-create">Create</a></label>
                <select class="js-example-basic-multiple form-control" multiple="multiple" name="tags[]">
                  <?php 
                    foreach ($tags as $key => $tag) {
                      echo '<option value="'.$tag->tag_id.'">'.$tag->name.'</option>';
                    }
                  ?>
                </select>
            </div>
          </div>
          <br/>
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


$(function () {
  $('[data-toggle="tooltip"]').tooltip();

  $(".js-example-basic-multiple").select2();

});

$(document).ready(function(){

	$("#loading").hide();

	$('.datepicker').datepicker({
    	format: 'dd-mm-yyyy',
      showButtonPanel: true,
      autoclose: true,
	});

  $(".datepicker").datepicker("setDate", new Date());

	$(".timepicker").timepicker();

	$(".fa-close").click(function(){
		
		$("#exam_status").modal('hide');
		$(".js-select2").empty();
		$("#msg").html("");
		$(".js-select2").select2('refresh');

	});


  $(".fa-close-tag").click(function(){
    $("#tag-create-modal").modal('hide');
  });

  

	
	$(document).on('click',".exam_status", function() {
		 if ($(this).prop('checked')==true){ 
			var id = $(this).attr('data-id'); 
			$("#user_id").val(id);
			$("#exam_status").modal('show');
    }

		
	});


  $(document).on('click',".tag-create", function() {
    $("#tag-create-modal").modal('show');
  });



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








$(document).on('click',".click_assignment", function() {


    $("#loading").show();

      var id = $(this).attr('data-id');
       

        $('#item-list_wrapper').hide();
        $('#item-list-filter').show();  

         let candidate_table = $('#item-list-filter').DataTable({
          "ajax": {
              url : "<?php echo site_url('communication/candidate_search_team');?>",
              data:{'data': id},
              type : 'POST'
              },initComplete: function(e) {
                $("#loading").hide();
                $("#campaign_id option[value='"+id+"']").attr('selected', true);
                $("#campaign_id").attr('disabled','disabled');
                $("#campaign_id_hidden").val(id);
                
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


});



});
var App = angular.module('myApp', ['ui.bootstrap']); 
function Dashboard_Details($scope,$log,$http,$compile)
{


	$scope.list_items = "";
	$scope.sampledate = new Date();




    $scope.search_data = function() {

    



          $('#select_all').on('click', function(){
            var rows = candidate_table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
          });
   

    };

}


function get_tag()
{
  $.ajax({
      type: "POST",
      url: "<?php echo site_url('communication/get_tag');?>",
      success: function (data) {
         console.log(data);
          dataa = jQuery.parseJSON(data);
         $(".js-example-basic-multiple").select2({
            data: dataa,
            allowClear: false,
            minimumResultsForSearch: 2
        });
      },
    });
}



</script>

<script type="text/javascript">
    $("#submitButton").click(function (event) {
                event.preventDefault(); // Prevent default form submission

                let form = $("#save-tag");
               
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('communication/create_tag');?>",
                    data: form.serialize(), // Serialize form data
                    success: function (data) {
                        alert("Tag Created Successfully");
                        $("#tag-create-modal").modal('hide');
                        get_tag();

                    },
                    error: function (data) {
                        alert("Error occurred while submitting the form");
                    }
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
z-index: 99999;
	}
</style>
