<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('../layout/head.php'); ?>

  <style type="text/css">
    .checkbox,
    .radio {
      position: relative;
      display: inline-block;
      margin-top: 10px;
      margin-bottom: 10px;
      margin-right: 20px;
    }

    .field_icon {
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

    <div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Create/View Exam
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Exam</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="page-content">

          <?php
          if (hasFlash('ViewMsgSuccess')) {
            echo getFlash('ViewMsgSuccess');
          }
          if (hasFlash('ViewMsgWarning')) {
            echo getFlash('ViewMsgWarning');
          }
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

                      <form action="create_exam" method="POST">
                        <div class="form-group">
                          <label>Exam Name <span style='color:red;'>*</span></label>
                          <input type="text" class="form-control" name="exam_name" value="" required="" />
                        </div>

                        <div class="form-group">
                          <label>Exam Question <span style='color:red;'>*</span></label>
                          <input type="text" id="admin_pass" class="form-control" name="exam_question" required="" />

                        </div>


                        <div class="form-group">
                          <label>Exam Start Date Time <span style='color:red;'>*</span></label>
                          <input type="datetime-local" id="admin_pass" class="form-control" name="start_datetime" required="" />

                        </div>


                        <div class="form-group">
                          <label>Exam End Date Time <span style='color:red;'>*</span></label>
                          <input type="datetime-local" id="admin_pass" class="form-control" name="end_datetime" required="" />

                        </div>

                        <div class="form-group">
                          <label>No of Candidate <span style='color:red;'>*</span></label>
                          <input type="text" id="admin_pass" class="form-control" name="no_of_candidate" required="" />

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
                  <h3 class="box-title">Exam List</h3>
                </div>
                <div class="box-body box-danger">

                  <div class="row">
                    <div class="col-sm-12">
                      <div style="overflow-y:scroll; height:400px;">
                        <table class="table table-bordered" id="sample_data">
                          <thead>
                            <tr>
                              <th>Sr.</th>
                              <th>Exam Name</th>
                              <th>Question</th>
                              <th>Start/End</th>

                              <th>Total</th>
                              <th>Absent</th>
                              <th>Present</th>

                              <th>Pass</th>
                              <th>Fail</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $i = 0;
                            $aa = 0;
                            $b = 0;
                            $c = 0;
                            $d = 0;
                            $e = 0;
                            foreach ($result as $key => $list) {
                              $i++;

                              $this->db->select('*');
                              $this->db->from('candidate_exam CE');
                              $this->db->join('candidate_result CR', 'CE.id = CR.link_id');
                              $this->db->where('CE.exam_id', $list->id);
                              $this->db->where('CR.attendance', 'present');
                              $p = $this->db->get()->num_rows();


                              $this->db->select('*');
                              $this->db->from('candidate_exam CE');
                              $this->db->join('candidate_result CR', 'CE.id = CR.link_id');
                              $this->db->where('CE.exam_id', $list->id);
                              $this->db->where('CR.attendance', 'absent');
                              $a = $this->db->get()->num_rows();

                              $this->db->select('*');
                              $this->db->from('candidate_exam CE');
                              $this->db->join('candidate_result CR', 'CE.id = CR.link_id');
                              $this->db->where('CE.exam_id', $list->id);
                              $this->db->where('CR.exam_status', 'pass');
                              $pass = $this->db->get()->num_rows();


                              $this->db->select('*');
                              $this->db->from('candidate_exam CE');
                              $this->db->join('candidate_result CR', 'CE.id = CR.link_id');
                              $this->db->where('CE.exam_id', $list->id);
                              $this->db->where('CR.exam_status', 'fail');
                              $fail = $this->db->get()->num_rows();



                            ?>
                              <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $list->exam_name; ?></td>
                                <td><?php echo $list->exam_question; ?></td>
                                <td><?php echo date('d-m-Y H:i A', strtotime($list->start_datetime)); ?>
                                  <br />
                                  <?php echo date('d-m-Y H:i A', strtotime($list->end_datetime)); ?>
                                </td>
                                <td><a href='exam_wise_candidate?exam=<?php echo $list->id ?>&status=t'><?php echo $list->no_of_candidate; ?></a></td>
                                <td><a href='exam_wise_candidate?exam=<?php echo $list->id ?>&status=a'><?php echo $a ?? 0; ?></a></td>
                                <td><a href='exam_wise_candidate?exam=<?php echo $list->id ?>&status=p'><?php echo $p ?? 0; ?></a></td>

                                <td><a href='exam_wise_candidate?exam=<?php echo $list->id ?>&status=pass'><?php echo $pass ?? 0; ?></a></td>
                                <td><a href='exam_wise_candidate?exam=<?php echo $list->id ?>&status=fail'><?php echo $fail ?? 0; ?></a></td>
                                <td>

                                  <a class="btn btn-primary btn-xs edit" data-id='<?php echo $list->id; ?>'><i class="fa fa-pencil"></i> Edit</a>
                                  <a class="btn btn-danger btn-xs delete" data-id='<?php echo $list->id; ?>'><i class="fa fa-trash"></i> Delete</a>
                                </td>

                              </tr>
                            <?php
                              $aa += $list->no_of_candidate;
                              $b += $p;
                              $c += $a;
                              $d += $pass;
                              $e += $fail;
                            } ?>
                            <tr style="background-color:#e4e4e4;">
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><?= $aa; ?></td>
                              <td><?= $c; ?></td>
                              <td><?= $b; ?></td>

                              <td><?= $d; ?></td>
                              <td><?= $e; ?></td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>

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
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script>
      $(document).ready(function() {
        $("#loading").hide();

        $("#toggle_pwd").click(function() {
          $(this).toggleClass("fa-eye fa-eye-slash");
          var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
          $("#admin_password_edit").attr("type", type);
        });


        $("#toggle_pass").click(function() {
          $(this).toggleClass("fa-eye fa-eye-slash");
          var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
          $("#admin_pass").attr("type", type);
        });

      });


      $('.edit').on('click', function() {
        var id = $(this).attr('data-id');
        $.ajax({
          url: "get_exam",
          method: 'POST',
          data: {
            'id': id
          },
          success: function(result) {
            var data = JSON.parse(result);
            $("#edit_id").val(data[0]['id']);
            $("#exam_name").val(data[0]['exam_name']);
            $("#exam_question").val(data[0]['exam_question']);
            $("#start_datetime").val(data[0]['start_datetime']);
            $("#end_datetime").val(data[0]['end_datetime']);
            $("#no_of_candidate").val(data[0]['no_of_candidate']);
          }
        });
        $("#edit").modal('show');
      });


      $('.delete').on('click', function() {
        var id = $(this).attr('data-id');
        $.ajax({
          url: "delete_exam",
          method: 'POST',
          data: {
            'id': id
          },
          success: function(result) {
            if (result == 1) {
              alert('Exam has been deleted!');
              location.reload();
            }
            console.log(result)
          }
        });
      });
    </script>


    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>

          </div>
          <div class="modal-body">
            <form action="edit_exam" method="POST">
              <input type="hidden" id="edit_id" name="edit_id" />
              <div class="form-group">
                <label>Exam Name <span style='color:red;'>*</span></label>
                <input type="text" class="form-control" name="exam_name" id="exam_name" value="" required="" />
              </div>

              <div class="form-group">
                <label>Exam Question <span style='color:red;'>*</span></label>
                <input type="text" class="form-control" name="exam_question" id="exam_question" required="" />

              </div>


              <div class="form-group">
                <label>Exam Start Time <span style='color:red;'>*</span></label>
                <input type="datetime-local" id="start_datetime" class="form-control" name="start_datetime" required="" />

              </div>


              <div class="form-group">
                <label>Exam End Time <span style='color:red;'>*</span></label>
                <input type="datetime-local" id="end_datetime" class="form-control" name="end_datetime" required="" />

              </div>

              <div class="form-group">
                <label>No of Candidate <span style='color:red;'>*</span></label>
                <input type="text" id="no_of_candidate" class="form-control" name="no_of_candidate" required="" />

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

    <!-- <script>
      $(document).ready(function() {
        $('#sample_data').DataTable({
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
          lengthMenu: [
            [25, 50, -1],
            ['25 rows', '50 rows', 'Show all']
          ],
          buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });
      }); -->
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

      #loading {
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