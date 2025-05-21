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
		sidebar(125);
  ?>
	<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Create/View Users
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
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
                            
                            <form action="create_users" method="POST">
                              <div class="form-group">
                                <label>User Name <span style='color:red;'>*</span></label>
                                <input type="text" class="form-control" name="admin_name_f" value="" required="" />
                              </div>

                               <div class="form-group">
                                <label>Password <span style='color:red;'>*</span></label>
                                <input type="password" id="admin_pass" class="form-control"  name="admin_password_f" required="" />
                                <span id="toggle_pass" class="fa fa-fw fa-eye field_icon"></span>
                              </div>

                               <div class="form-group" >
                                <label>Role <span style='color:red;'>*</span></label>
                                <select class="form-control" name="role" required="">
                                  <option value="">Select</option>
                                  <option value="telecaller">Telecaller</option>
                                </select>
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
                      <h3 class="box-title">User List</h3>
                    </div>
                    <div class="box-body box-danger">

                      <div class="row">
                        <div class="col-sm-12">
                          
                          <table class="table table-bordered"  id="sample_data">
                            <thead>
                              <tr>
                                <th>Sr.</th>
                                <th>User Name</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                              <tbody>
                                <?php 
                                $i = 0;
                                foreach ($result as $key => $list) { $i ++; ?>
                                   <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list->admin_name; ?></td>
                                    <td><?php echo $list->admin_password; ?></td>
                                    <td><?php echo $list->role; ?></td>
                                    <td> 
                                      <?php if($list->role != 'admin' && $list->role != 'service_provider'){ ?>
                                      <a class="btn btn-primary btn-xs edit" data-id='<?php echo $list->admin_id; ?>'>Edit</a> 
                                      <a class="btn btn-danger btn-xs delete" data-id='<?php echo $list->admin_id; ?>'>Delete</a> </td>
                                    <?php } ?>
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
      url: "get_user", 
      method:'POST',
      data: {'id':id },
      success: function(result){
        var data = JSON.parse(result);
        $("#edit_id").val(data[0]['admin_id']);
        $("#admin_name_edit").val(data[0]['admin_name']);
        $("#admin_password_edit").val(data[0]['admin_password']);
        $("#role_edit option[value='"+ data[0]['role'] +"']").attr("selected", "selected");
    }});
    $("#edit").modal('show');
  });


 $('.delete').on('click', function(){
    var id = $(this).attr('data-id');
    $.ajax({
      url: "delete_user", 
      method:'POST',
      data: {'id':id },
      success: function(result){
        if(result==1){
          alert('user has been deleted!');
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
        <form action="edit_users" method="POST">
          <input type="hidden" name="edit_id" id="edit_id">
          <div class="form-group">
            <label>User Name <span style='color:red;'>*</span></label>
            <input type="text" class="form-control" id="admin_name_edit" name="admin_name_edit" value="" required="" />
          </div>

           <div class="form-group">
            <label>Password <span style='color:red;'>*</span></label>
            <input type="password" class="form-control" id="admin_password_edit" value="*******" name="admin_password_edit" required="" />
            <span id="toggle_pwd" class="fa fa-fw fa-eye field_icon"></span>
          </div>

           <div class="form-group" >
            <label>Role <span style='color:red;'>*</span></label>
            <select class="form-control" name="role_edit" required="" id="role_edit">
              <option value="">Select</option>
              <option value="telecaller">Telecaller</option>
            </select>
          </div>

           <button type="submit" class="btn btn-primary">Update changes</button>
          
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

