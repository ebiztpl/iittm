<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>

  <style type="text/css">
    .checkbox, .radio {
    position: relative;
    display: inline-block;
    margin-top: 10px;
    margin-bottom: 10px;
    margin-right: 20px;
    }
    .field_icon{
      position: absolute;
      margin-top: -23px;
      right: 28px;
    }
  </style>
</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="home_screen">
<div class="wrapper">

  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(1205);
  ?>
  
<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Create/View Team
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
	
          <?php
             if(hasFlash('ViewMsgSuccess')){echo getFlash('ViewMsgSuccess');}
             if(hasFlash('ViewMsgWarning')){echo getFlash('ViewMsgWarning');}
          ?> 
            <div class="row">
            <div class="col-sm-4">
                <div class="box box-primary">   
                    <div class="box-header with-border">
                      <h3 class="box-title">Create</h3>
                    </div>
                    <div class="box-body box-danger">

                      <div class="row">
                        <div class="col-sm-12">
                            
                            <form action="team" method="POST">
                              <div class="form-group">
                                <label>Name <span style='color:red;'>*</span></label>
                                <input type="text" class="form-control" name="exam_name" value="" required="" />
                              </div>

                              <button class="btn btn-primary" name="btnsubmit">Submit</button>
                            </form>

                        </div>
                      </div>


                

                        

                    </div>
                </div>
              
            </div>


            <div class="col-sm-8">
                <div class="box box-primary">   
                    <div class="box-header with-border">
                      <h3 class="box-title">Team List</h3>
                    </div>
                    <div class="box-body box-danger">

                      <div class="row">
                        <div class="col-sm-12">
                          
                          <table class="table table-bordered"  id="sample_data">
                            <thead>
                              <tr>
                                <th>Sr.</th>
                                <th>Name</th>
                                <th>Created at</th>
                             
                                <th>Action</th>
                              </tr>
                            </thead>
                              <tbody>
                                <?php 
                                $i = 0;
                                foreach ($result as $key => $list) { $i ++; 

                               

                                  ?>
                                   <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list->name; ?></td>
                                    <td><?php echo date('d-m-Y H:i A', strtotime($list->created_at)); ?>
                                   <td>
                                     
                                      <a class="btn btn-primary btn-xs edit" data-id='<?php echo $list->id; ?>'><i class="fa fa-pencil"></i> Edit</a> 
                                      <a class="btn btn-danger btn-xs delete" data-id='<?php echo $list->id; ?>'><i class="fa fa-trash"></i> Delete</a> </td>
                                   
                                  </tr>
                                <?php }?>
                               
                              </tbody>
                          </table>

                        </div>
                      </div>


                

                        

                    </div>
                </div>
              
            </div>


         </div>



	

			
			
	</div>
    </section>
</div>

<?php $this->load->view('../layout/footer.php'); ?>

<script>
$(document).ready(function(){
	$("#loading").hide();

   $("#toggle_pwd").click(function () {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
      $("#admin_password_edit").attr("type", type);
  });


   $("#toggle_pass").click(function () {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
      $("#admin_pass").attr("type", type);
  });

});


$('.edit').on('click', function(){
    var id = $(this).attr('data-id');
    $.ajax({
      url: "get_team", 
      method:'POST',
      data: {'id':id },
      success: function(result){
        var data = JSON.parse(result);
        console.log(result);
        $("#edit_id").val(data[0]['id']);
        $("#exam_name").val(data[0]['name']);
    }});
    $("#edit").modal('show');
  });


 $('.delete').on('click', function(){
    var id = $(this).attr('data-id');
    $.ajax({
      url: "delete_team", 
      method:'POST',
      data: {'id':id },
      success: function(result){
        if(result==1){
          alert('Team has been deleted!');
          location.reload();
        }
        console.log(result)
    }});
 });


</script>


<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
      
      </div>
      <div class="modal-body">
        <form action="edit_team" method="POST">
          <input type="hidden" id="edit_id" name="edit_id" />
              <div class="form-group">
                <label>Name <span style='color:red;'>*</span></label>
                <input type="text" class="form-control" name="exam_name" id="exam_name" value="" required="" />
              </div>

            

              <button class="btn btn-primary" name="btnsubmit">Update</button>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

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
z-index: 99;
	}
</style>



</body>
</html>

