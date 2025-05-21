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
	  .badge {background-color:#000 !important;}
  </style>

</head>
<body class="skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(1207);
  ?>
	
	

<div class="content-wrapper">
    <!-- Content Header (Page header) -->

  <section class="content-header">
      <h1>
       Assignment Report
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Communication</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="page-content">

         <div class="box">   
      <div class="box-body">
		  

        <table class="table table-bordered">
          <thead>
          <tr>
          <th>Sr.</th>
          <th>Assignment</th>
          <th>Campaign</th>
          <th>Team</th>
          <th>Candidate</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Created At</th>
          <th>Action</th>
          </tr>
        </thead>

        <tbody>

          <?php foreach ($assignment as $key => $assignments) { 
            $count = $this->db->select('*')->from('assignment')->where('assignment_id', $assignments->id)->get()->num_rows();
            
           ?>
        <tr>
            <td><?= $assignments->id ?></td>
            <td><?= $assignments->assignment_name ?></td>
            <td><a data-id='<?= $assignments->cid ?>' style="cursor: pointer;" class="campaign_modal_btn"><?= $assignments->cname ?></a></td>
            <td><?= $assignments->team ?></td>
            <td><?= $count; ?></td>
            <td><?php if($assignments->assignment_start !='0000-00-00'){echo date('d-m-Y',strtotime($assignments->assignment_start));} ?></td>
            <td><?php if($assignments->assignment_end !='0000-00-00'){echo date('d-m-Y',strtotime($assignments->assignment_end));} ?></td>
             <td><?= $assignments->created_at ?></td>
            <td><a data-id="<?= $assignments->id ?>" class="btn btn-primary btn_click">View</a></td>
          </tr>
          <?php } ?>
           </tbody>

        </table>
     
      
        
         
        </div>
      </div>

<div class="box">   
      <div class="box-body">
		   <span style="font-size: 20px; color: green; text-align: right; margin-left: 50px; float: right">Total Records - <span id="record">0</span></span>

          <span style="font-size: 20px; color: green; text-align: right; display: block; ">Complete - <span id="complete">0</span></span>
<div style="overflow:scroll; height:500px;">
         <table id="item-list-filter" class="table table-bordered table-striped table-hover ">
        <thead>
          <tr>
            <?php if($this->session->userdata['role']=='telecaller'){ ?>
            <th class="tbl-header">Action</th>
            <?php } else{?>
              <th class="tbl-header">Sr.</th>
            <?php } ?>
            <th class="tbl-header">Candidate Information</th>
            <th style='width:30%;'>Academic Information</th>
            <th style='width:40%;'>Communication</th>
          <!--   <th class="tbl-header">Exam</th>
            <th>Course</th>
            <th>Study Centre</th>
            <th>Score</th>
            <th>Full name</th>
            <th>Mobile</th>
            <th>Father Name</th>
            <th>Mother Name</th>
            <th>DOB</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Category</th>
            <th>Father Mobile</th>
            <th>Mother Mobile</th> 
            <th>Religion</th>
            <th >Parr. State</th>
            <th >Parr. City</th>
            <th>Entry DateTime</th>
            <th>Fee DateTime</th> -->
          
          </tr>
          </thead>
          <tbody>
</tbody>
</table>
</div>
      </div>
    </div>



</div>
</section>
</div>


	
	<div class="modal fade" id="campaign_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 999999;">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top: 15%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Campaign Details</h5>
       
      </div>
      <div class="modal-body">
        <div class="form-group">
        <label>Campaign Name</label><br/>
        <span id="campagin_name"></span>
        </div>

        <div class="form-group">
        <label>Campaign Desc</label><br/>
        <span id="campagin_desc"></span>
        </div>

        <div class="form-group">
        <label>Campaign Responses</label><br/>
        <span id="campagin_res"></span>
        </div>

      </div>
    </div>
  </div>
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
          <input type="hidden" id="assign_id" name="assign_id" />
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
				    <span style="float: right; color:red; font-weight: bold; font-size:"><input type="radio" name="status" value="1" /> Dead Lead</span>
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


<div class="modal fade" id="exam_status_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Candidate Calls Response</h5>
        <span style="position: absolute; top: 15px; right: 15px; cursor: pointer;"><i class="fa fa-close fa-close-edit"></i></span>
      </div>
      <div class="modal-body">
        <form action="#" id="calling_data_update" method="POST" >
          <input type="hidden" id="edit_calling_id" name="edit_calling_id" />
          <input type="hidden" id="edit_user_id" name="edit_user_id" />
          <input type="hidden" id="edit_assign_id" name="edit_assign_id" />
          <div class="row">
            <div class="col-sm-4" style="padding-right: 0px;">
              <div class="form-group">
            <label>Calling Date<span style='color:red;'>*</span></label>
            <input type="text" class="form-control datepicker" id="edit_call_date" name="edit_call_date" required="">
              </div>
            </div>
            <div class="col-sm-4">
               <div class="form-group">
                <label>Calling Time<span style='color:red;'>*</span></label>
                <input type="text" class="form-control timepicker" id="edit_call_time" name="edit_call_time"  required="">
              </div>
            </div>

             <div class="col-sm-4" style="padding-left: 0px;">
               <div class="form-group">
                <label>Select Campaign <i class="fa fa-info-circle tooltipss"  data-toggle="tooltip" data-placement="top" title="Tooltip on top"></i></label>
                <select class="form-control" name="edit_campaign_id" id="edit_campaign_id" required="">
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
                <select class="form-control" name="edit_mode_id" id="edit_mode_id" required="">
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
                <select class="form-control" name="edit_call_action" id="edit_call_action" required="">
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
                <select class="form-control" name="edit_response_id" id="edit_response_id" required="">
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
               <input type="text" class="form-control" name="edit_correct_email" id="edit_correct_email">
              </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group">
                <label>Correct Mobile (if needed)</label>
              <input type="text" class="form-control" name="edit_correct_mobile" id="edit_correct_mobile">
              </div>
            </div>
          </div>

            <div class="row">
            <div class="col-sm-12">
              <label>Tag <span style='color:red;'>(type text & press enter)</span><a class="btn btn-primary btn-xs tag-create">Create</a></label>
                <select class="js-example-basic-multiple form-control" id="edit_tags" multiple="multiple" name="edit_tags[]">
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
            <span style="float: right; color:red; font-weight: bold; font-size:"><input type="radio" name="edit_status" value="1" id="edit_status" /> Dead Lead</span>
                <textarea class="form-control" name="edit_notes" id="edit_notes"></textarea>
              </div>
            </div>
          </div>
              
              <button class="btn btn-primary" name="btnsubmit">Update</button>
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
      format: 'dd-mm-yyyy',
      showButtonPanel: true,
      autoclose: true,
  });

$(".js-example-basic-multiple").select2();
  $(".datepicker").datepicker("setDate", new Date());

  $(".timepicker").timepicker();

});
	
	
$(document).on('click',".campaign_modal_btn", function() {

    var id = $(this).attr('data-id');
    $.ajax({
      url: "get_campaign_with_response", 
      method:'POST',
      data: {'id':id },
      success: function(result){
        var data = JSON.parse(result);
        console.log(result);
       
        $("#campagin_name").html(data['campaign'][0]['name']);
        $("#campagin_desc").html(data['campaign'][0]['description']);
        $("#campagin_res").html(data['response']);
    }});

    $("#campaign_modal").modal('show');
  });

$(document).on('click',".btn_click", function() {


    $("#loading").show();

      var id = $(this).attr('data-id');
       

        $('#item-list_wrapper').hide();
        $('#item-list-filter').show();  

         $('#item-list-filter').DataTable({
          "ajax": {
              url : "<?php echo site_url('communication/assignment_candidates');?>",
              data:{'data': id},
              type : 'POST'
              },initComplete: function(e) {
                console.log(e);
                 $("#loading").hide();
                $("#campaign_id option[value='"+e.json.campaign_id+"']").attr('selected', true);
                $("#campaign_id").attr('disabled','disabled');
                $("#campaign_id_hidden").val(e.json.campaign_id);
				$("#record").html(e.json.recordsTotal);
                $("#complete").html(e.json.recordsComplete);
                
                
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

</script>

<script type="text/javascript">
  $(document).on('click',".exam_status", function() {
     if ($(this).prop('checked')==true){ 
      var id = $(this).attr('data-id');
      var assign_id = $(this).attr('assign-id'); 
      $("#user_id").val(id);
      $("#assign_id").val(assign_id);
      $("#exam_status").modal('show');
    }
  });
	
	
	$(document).on('click',".exam_status_edit", function() {
   
      var id = $(this).attr('data-id');

      $.ajax({
          url: "<?php echo site_url('communication/get_calling_data');?>", 
          data: {'id':id}, 
          type: "POST", 
          dataType: 'json',
          success: function (e) {
            console.log(e);
         
            $("#edit_user_id").val(e.user_id);
            $("#edit_assign_id").val(e.assign_id);
            $("#edit_calling_id").val(e.id);
            $("#edit_call_time").val(e.call_time);
            $("#edit_campaign_id option[value='"+e.campaign_id+"']").attr('selected', true);
            $("#edit_campaign_id").attr('disabled','disabled');
            $("#edit_mode_id option[value='"+e.mode+"']").attr('selected', true);
            $("#edit_call_action option[value='"+e.call_action+"']").attr('selected', true);
            $("#edit_response_id option[value='"+e.response_id+"']").attr('selected', true);
            $("#edit_correct_email").val(e.correct_email);
            $("#edit_correct_mobile").val(e.correct_mobile);
            $("#edit_notes").val(e.notes);
            var dt = moment(e.call_date).format('DD-MM-YYYY');
            $('#edit_call_date').val(dt);
        
            var strVal = e.tag;
            var result = strVal.split(",").map(x=>+x);
            $("#edit_tags").val(result).select2();
             
            if(e.status == 1){$("#edit_status").attr('checked',true);}else{$("#edit_status").removeAttr('checked');}
            $("#exam_status_edit").modal('show');

          }
      }); 
  });
	
	
	 $("#calling_data_update").submit(function(){
     $("#loading").show();
      $.ajax({
          url: "<?php echo site_url('communication/calling_data_update');?>", 
          data: $("#calling_data_update").serialize(), 
          type: "POST", 
          dataType: 'json',
          success: function (e) {
             $("#loading").hide();
             $("#msg").html(e.msg);
            //$("#calling_data_save").reset();
              location.reload();
          },
          error:function(e){
              alert(e);
          }
      }); 
      return false;
  });

  $(".fa-close").click(function(){
    $("#exam_status").modal('hide');
    $("#msg").html("");
  });

  $(".fa-close-tag").click(function(){
    $("#tag-create-modal").modal('hide');
  });

	 $(".fa-close-edit").click(function(){
    $("#exam_status_edit").modal('hide');
  });
	
  $(document).on('click',".tag-create", function() {
    $("#tag-create-modal").modal('show');
  });

  $("#calling_data_save").submit(function(){
     $("#loading").show();
      $.ajax({
          url: "<?php echo site_url('communication/calling_data_save');?>", 
          data: $("#calling_data_save").serialize(), 
          type: "POST", 
          dataType: 'json',
          success: function (e) {
             $("#loading").hide();
            $("#msg").html(e.msg);
            //$("#calling_data_save").reset();
			  location.reload();
          },
          error:function(e){
              alert(e);
          }
      }); 
      return false;
  });

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
