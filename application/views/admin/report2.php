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
</head>

<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="" ng-controller="validateCtrl">

  <div id="loading" class="text-center"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

  <div class="wrapper">

    <?php $this->load->view('../layout/header.php'); ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view('../layout/sidemenu.php');
    sidebar(1);
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!-- Main content -->
      <section class="content">











        <div class="row">
          <div class="col-sm-12">
            <div class="box box-primary">
              <div class="box-body box-profile">

                <div class="row">
                  <div class="col-sm-12" style="margin-top:10px; ">
                    <div class="col-sm-2">
                      <select class="form-control" id="course" required="">
                        <option value="1,2">All Course</option>
                        <option value="1">BBA</option>
                        <option value="2">MBA</option>
                      </select>
                    </div>

                    <div class="col-sm-2">
                      <select class="form-control" name="study_center" id="study_center" ng-model="study_center">
                        <option value="">--Select Study Center--</option>
                        <option value="Gwalior">Gwalior</option>
                        <option value="Bhubaneswar">Bhubaneswar</option>
                        <option value="Noida">Noida</option>
                        <option value="Nellore">Nellore</option>
                        <option value="Goa">NIWS-GOA</option>
                      </select>
                    </div>

                    <div class="col-sm-3">
                      <a class="btn btn-success" ng-click="get_course()">Search</a>
                    </div>
                  </div>
                </div>

                <span style="margin: 10px; font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>

                <!--  <h3 class="profile-username text-center">City Wise Application</h3> -->
                <table class="table table-bordered" id="myTable">
                  <thead class='headertbl'>
                    <tr>
                      <th>State Name</th>
                      <th>2020</th>
                      <th>2021</th>
                      <th>2022</th>
                      <th>2023</th>
                      <th>2024</th>
                      <th>2025</th>
                    </tr>
                  </thead>
                  <tbody>


                    <tr ng-repeat='list in districtlist' ng-click="statewisecity(list.id)" style=" cursor: pointer;">
                      <th style="background: #e4e4e4;">{{list.name}}</th>
                      <th style="background: #e4e4e4;">{{list.2020}}</th>
                      <th style="background: #e4e4e4;">{{list.2021}}</th>
                      <th style="background: #e4e4e4;">{{list.2022}}</th>
                      <th style="background: #e4e4e4;">{{list.2023}}</th>
                      <th style="background: #e4e4e4;">{{list.2024}}</th>
                      <th style="background: #e4e4e4;">{{list.2025}}</th>
                    </tr>




                  </tbody>
                </table>






              </div>

            </div>
          </div>
        </div>

      </section>


      <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="citymodal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content" style="padding: 30px; height: 450px; overflow-y:scroll;">
            <table class="table table-bordered">
              <thead class='headertbl'>
                <tr>
                  <th>City Name</th>
                  <th>2020</th>
                  <th>2021</th>
                  <th>2022</th>
                  <th>2023</th>
                  <th>2024</th>
                  <th>2025</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat='lists in rows'>
                  <td>{{lists.name}}</td>
                  <td>{{lists.cnt_20}}</td>
                  <td>{{lists.cnt_21}}</td>
                  <td>{{lists.cnt_22}}</td>
                  <td>{{lists.cnt_23}}</td>
                  <td>{{lists.cnt_24}}</td>
                  <td>{{lists.cnt_25}}</td>

                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#loading").hide();

        setTimeout(function() {
          var table = $('#myTable').DataTable({
            scrollY: 500,
            scrollX: false,
            scrollCollapse: true,
            paging: false,
            fixedHeader: true
          });





        });


      });



      function validateCtrl($scope, $log, $http) {

        $scope.districtlist = <?php echo json_encode($districtlist) ?>;

        $scope.get_course = function($event) {
          $("#loading").show();
          var course = angular.element(document.querySelector('#course')).val();
          var center = angular.element(document.querySelector('#study_center')).val();

          var data = course + '~' + center;

          $http({
            method: "get",
            dataType: 'html',
            url: "<?php echo site_url('admin/report2_filter?data='); ?>" + data
          }).then(function(response) {
            console.log(response.data);
            $("#loading").hide();
            $("#record").html(response.data.filtered_total);
            $scope.districtlist = response.data['districtlist'];

          });

        };

        $scope.statewisecity = function(id) {
          $("#loading").show();
          var course = angular.element(document.querySelector('#course')).val();
          var center = angular.element(document.querySelector('#study_center')).val();
          var data = course + '~' + id + '~' + center;
          $http({
            method: "get",
            dataType: 'html',
            url: "<?php echo site_url('admin/statewisecity?data='); ?>" + data
          }).then(function(response) {
            console.log(response.data);
            $("#loading").hide();
            //$row = $(this).closest('tr');
            //console.log($row);
            $scope.rows = response.data;
            $("#citymodal").modal('show');
          });

        };

        $scope.getGrandTotal = function() {
          var course = angular.element(document.querySelector('#course')).val();
          $http({
            method: "get",
            url: "<?php echo site_url('admin/report2_grandtotal?course='); ?>" + course
          }).then(function(response) {
            document.getElementById('record').innerText = response.data.grand_total;
            $("#record").html(response.data.grand_total);
          });
        };

        $scope.getGrandTotal();

      }


      $('.dataTable').on('click', 'tbody td', function() {

        //get textContent of the TD
        console.log('TD cell textContent : ', this.textContent)

        //get the value of the TD using the API 
        console.log('value by API : ', table.cell({
          row: this.parentNode.rowIndex,
          column: this.cellIndex
        }).data());
      })
    </script>

    <?php $this->load->view('../layout/footer.php'); ?>

</body>

</html>