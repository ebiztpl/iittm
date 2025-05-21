<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('../layout/head.php'); ?>
  <script src="<?= base_url(); ?>themes/js/jquery.min.js"></script>
  <script src="<?= base_url(); ?>themes/js/angular.min.js"></script>
  <style type="text/css">
    .progress {
      margin-bottom: 0px;
    }

    .progress-bar {
      font-size: 15px;
    }
  </style>
  <script src="<?= base_url(); ?>themes/js/jquery.min.js"></script>

</head>

<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="" ng-controller="validateCtrl">

  <div id="loading" class="text-center"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

  <div class="wrapper">

    <?php $this->load->view('../layout/header.php'); ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view('../layout/sidemenu.php');
    sidebar(2);
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="row">
          <form action="date_wise_registration" method="POST">

            <div class="col-sm-3">
              <label>Course</label>
              <select class="form-control" name="course" id="course">
                <option value="">All</option>
                <option value="1" <?php if ($course == '1') {
                                    echo  'selected';
                                  } ?>>BBA</option>
                <option value="2" <?php if ($course == '2') {
                                    echo  'selected';
                                  } ?>>MBA</option>
              </select>

            </div>

            <div class="col-sm-2">
              <label>Year</label>
              <select class="form-control" name="dbnamee" id="dbnamee">
                <option value="iittm_2025" <?php if ($year == 'iittm_2025') {
                                              echo 'selected';
                                            } ?>>2025</option>
                <option value="iittm_2024" <?php if ($year == 'iittm_2024') {
                                              echo 'selected';
                                            } ?>>2024</option>
                <option value="iittm_2023" <?php if ($year == 'iittm_2023') {
                                              echo 'selected';
                                            } ?>>2023</option>
                <option value="iittm_2022" <?php if ($year == 'iittm_2022') {
                                              echo 'selected';
                                            } ?>>2022</option>
                <option value="iittm_2021" <?php if ($year == 'iittm_2021') {
                                              echo 'selected';
                                            } ?>>2021</option>

                <option value="iittm_2020" <?php if ($year == 'iittm_2020') {
                                              echo 'selected';
                                            } ?>>2020</option>




              </select>
            </div>



            <div class="col-sm-3">
              <label>Study Center</label>
              <select class="form-control" name="final_study_center">
                <option value="">--Select Study Center--</option>
                <option value="Gwalior" <?php if ($study_center == 'Gwalior') {
                                          echo 'selected';
                                        } ?>>Gwalior</option>
                <option value="Bhubaneswar" <?php if ($study_center == 'Bhubaneswar') {
                                              echo 'selected';
                                            } ?>>Bhubaneswar</option>
                <option value="Noida" <?php if ($study_center == 'Noida') {
                                        echo 'selected';
                                      } ?>>Noida</option>
                <option value="Nellore" <?php if ($study_center == 'Nellore') {
                                          echo 'selected';
                                        } ?>>Nellore</option>
                <option value="Goa" <?php if ($study_center == 'Goa') {
                                      echo 'selected';
                                    } ?>>NIWS-GOA</option>
              </select>
              <span class="msg" style="color:red; font-weight: bold; font-size: 14px;" ng-model="msg"></span>
            </div>








            <div class="col-sm-3" style="padding-top:25px;">
              <button class="btn btn-primary">Search</button>
            </div>


          </form>
        </div>



      </section>

      <!-- Main content -->
      <section class="content">
        <div class="page-content">
          <div class="box">
            <div class="box-body">

              <div class="row">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Month</th>
                      <th>Complete</th>
                      <th>Incomplete</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $grand_complete = 0;
                    $grand_incomplete = 0;
                    $grand_total = 0;

                    $prevjan = 0;
                    $prevdec = 0;
                    $jan = 0;
                    $feb = 0;
                    $mar = 0;
                    $apr = 0;
                    $may = 0;
                    $jun = 0;
                    $jul = 0;
                    $aug = 0;
                    $sep = 0;
                    $oct = 0;
                    $nov = 0;
                    $dec = 0;
                    ?>

                    <tr>
                      <td><a href="month_wise_registration/11?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>&prev=1">November <?= $pev_year ?></a></td>
                      <?php $check = 0;


                      foreach ($prevcompleted as $comp) {
                        if ($comp->month == 11) {
                          $prevjan += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($previncompleted as $comp) {
                        if ($comp->month == 11) {
                          $prevjan += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <td><?= $prevjan ?></td>

                    </tr>


                    <tr>
                      <td><a href="month_wise_registration/12?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>&prev=1">December <?= $pev_year ?></td>

                      <?php $check = 0;
                      foreach ($prevcompleted as $comp) {
                        if ($comp->month == 12) {
                          $prevdec += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($previncompleted as $comp) {
                        if ($comp->month == 12) {
                          $prevdec += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>



                      <td><?= $prevdec; ?></td>



                    <tr>
                      <td><a href="month_wise_registration/1?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">January</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 1) {
                          $jan += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 1) {
                          $jan += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <td><?= $jan ?></td>


                    <tr>
                      <td><a href="month_wise_registration/2?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">Febuary</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 2) {
                          $feb += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 2) {
                          $feb += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>

                      <td><?= $feb ?></td>

                    </tr>


                    <tr>
                      <td><a href="month_wise_registration/3?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">March</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 3) {
                          $mar += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 3) {
                          $mar += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <td><?= $mar ?></td>

                    </tr>


                    <tr>
                      <td><a href="month_wise_registration/4?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">April</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 4) {
                          $apr += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 4) {
                          $apr += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>



                      <td><?= $apr ?></td>




                    </tr>


                    <tr>
                      <td><a href="month_wise_registration/5?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">May</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 5) {
                          $may += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 5) {
                          $may += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>

                      <td><?= $may ?></td>

                    </tr>


                    <tr>
                      <td><a href="month_wise_registration/6?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">June</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 6) {
                          $jun += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 6) {
                          $jun += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>

                      <td><?= $jun ?></td>

                    </tr>

                    <tr>
                      <td><a href="month_wise_registration/7?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">July</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 7) {
                          $jul += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 7) {
                          $jul += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>

                      <td><?= $jul ?></td>

                    </tr>

                    <tr>
                      <td><a href="month_wise_registration/8?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">August</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 8) {
                          $aug += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>

                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 8) {
                          $aug += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <td><?= $aug ?></td>

                    </tr>


                    <tr>
                      <td><a href="month_wise_registration/9?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">September</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 9) {
                          $sep += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>

                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 9) {
                          $sep += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>

                      <td><?= $sep ?></td>

                    </tr>


                    <tr>
                      <td><a href="month_wise_registration/10?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">October</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 10) {
                          $oct += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 10) {
                          $oct += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>

                      <td><?= $oct ?></td>

                    </tr>


                    <tr>
                      <td><a href="month_wise_registration/11?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">November</a></td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 11) {
                          $nov += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 11) {
                          $nov += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <td><?= $nov ?></td>

                    </tr>


                    <tr>
                      <td><a href="month_wise_registration/12?course=<?= $course ?>&year=<?= $year ?>&final_study_center=<?= $study_center ?>">December</td>
                      <?php $check = 0;
                      foreach ($completed as $comp) {
                        if ($comp->month == 12) {
                          $dec += $comp->count;
                          $grand_complete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>


                      <?php $check = 0;
                      foreach ($incompleted as $comp) {
                        if ($comp->month == 12) {
                          $dec += $comp->count;
                          $grand_incomplete += $comp->count;
                          $check = 1 ?>
                          <td><?= $comp->count ?></td>
                        <?php }
                      }
                      if ($check == 0) { ?>
                        <td> 0 </td>
                      <?php } ?>

                      <td><?= $dec ?></td>

                    </tr>

                    <tr style="font-weight: bold; background-color: #f2f2f2;">
                      <th></th>
                      <th>Total Complete: <?= $grand_complete ?></th>
                      <th>Total Complete: <?= $grand_incomplete ?></th>
                      <th>Grand Total: <?= $grand_total = $grand_complete + $grand_incomplete; ?></th>
                    </tr>

                  </tbody>
                </table>


              </div>
            </div>
          </div>

        </div>




      </section>

    </div>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#loading").hide();

        $('.datepicker').datepicker({
          format: 'yyyy-mm-dd'

        });

      });


      function validateCtrl($scope, $log, $http) {
        $("#loading").hide();
      }
    </script>



    <style type="text/css">
      #loading {
        width: 100%;
        height: 100%;
        background-color: #000000ba;
        position: absolute;
        z-index: 99999;
        padding-top: 30%;
      }
    </style>
    <?php $this->load->view('../layout/footer.php'); ?>

</body>

</html>