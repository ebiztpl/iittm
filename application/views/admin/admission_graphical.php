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
      <section class="content-header">
        <div class="row">

          <div class="col-sm-3">
            <select class="form-control" name="final_study_center" id="final_study_center" ng-model="final_study_center">
              <option value="">--Select Study Center--</option>
              <option value="Gwalior">Gwalior</option>
              <option value="Bhubaneswar">Bhubaneswar</option>
              <option value="Noida">Noida</option>
              <option value="Nellore">Nellore</option>
              <option value="Goa">NIWS-GOA</option>
            </select>
            <span class="msg" style="color:red; font-weight: bold; font-size: 14px;" ng-model="msg"></span>
          </div>


          <div class="col-sm-3">
            <select class="form-control" name="course" id="course" ng-model="course">
              <option value="">--Select Course--</option>
              <option value="1">BBA</option>
              <option value="2">MBA</option>
            </select>
            <span class="msg" style="color:red; font-weight: bold; font-size: 14px;"></span>
          </div>

          <div class="col-sm-2">
            <a class="btn btn-primary" id="search" ng-click="get_course()">Search</a>
          </div>

          <div class="col-sm-9 text-right">
            <!--span class="btn btn-danger">SMS BALANCE : - <?php echo $balance; ?></span-->
          </div>



        </div>



      </section>

      <!-- Main content -->
      <section class="content">



        <div class="row">
          <div class="col-sm-12">

            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Chart wise Details</h3>

                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body no-padding">
                <div class="col-sm-4 text-center" style="background-color: #fff;">
                  <h3>Category</h3>
                  <div id="category" style="width: 100%; height: 300px;"></div>
                </div>

                <div class="col-sm-4 text-center" style="background-color: #fff;">
                  <h3>Gender</h3>
                  <div id="gender" style="width: 100%; height: 300px;"></div>
                </div>

                <div class="col-sm-4 text-center" style="background-color: #fff;">
                  <h3>Religion</h3>
                  <div id="religion" style="width: 100%; height: 300px;"></div>
                </div>


              </div>
            </div>



          </div>





        </div>

        <div class="row">

          <div class="col-sm-3">

            <div class="box box-primary">
              <div class="box-body box-profile">
                <h3 class="profile-username text-center">State Wise Application ({{leng}})</h3>
                <div style="height: 350px; overflow-y: scroll;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>State Name</th>
                        <th>Application</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat='list in statelist'>
                        <td>{{list.name}}</td>
                        <td>{{list.cnt}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-3">

            <div class="box box-primary">
              <div class="box-body box-profile">
                <h3 class="profile-username text-center">District Wise Application ({{dis}})</h3>
                <div style="height: 350px; overflow-y: scroll;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>District Name</th>
                        <th>Application</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat='list in districtlist'>
                        <td>{{list.name}}</td>
                        <td>{{list.cnt}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!--   <div class="col-sm-6">

             <div class="box box-primary">
              <div class="box-body box-profile">
                <h3 class="profile-username text-center">Study Centre Wise Admission</h3>
                <div id="columnchart_material" style="width: 100%; height: 350px;"></div>
              </div>
            </div>
            
          </div> -->

          <div class="col-sm-6">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Category wise Seat</h3>

                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <div id="category_material" style="width: 100%; height: 350px;"></div>
              </div>
            </div>
          </div>



        </div>



        <div class="row">
          <div class="col-sm-12">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Source of Admission</h3>

                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <div id="source_chart" style="width: 100%; height: 350px;"></div>
              </div>
            </div>
          </div>
        </div>




      </section>


      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
        $(document).ready(function() {
          $("#loading").hide();
        });

        function validateCtrl($scope, $log, $http) {

          $scope.statelist = <?php echo json_encode($statelist) ?>;
          $scope.districtlist = <?php echo json_encode($districtlist) ?>;
          $scope.category = <?php echo json_encode($category) ?>;
          $scope.genderdata = <?php echo json_encode($gender) ?>;
          $scope.religiondata = <?php echo json_encode($religion) ?>;
          $scope.categorychartdata = <?php echo json_encode($categorybar) ?>;
          $scope.centerdata = <?php echo json_encode($center) ?>;
          $scope.source_data = <?php echo json_encode($source_chart) ?>;


          var st_count = 0;
          for (var i = 0; i < $scope.statelist.length; i++) {
            var st_get = $scope.statelist[i].cnt;
            st_count += parseInt(st_get);
          }
          $scope.leng = st_count;


          var dis_count = 0;
          for (var i = 0; i < $scope.districtlist.length; i++) {
            var dis_get = $scope.districtlist[i].cnt;
            dis_count += parseInt(dis_get);
          }
          $scope.dis = dis_count;




          $scope.CategoryBarChart = function($event) {

            var data = google.visualization.arrayToDataTable($scope.categorychartdata);
            var options = {
              legend: {
                position: 'none',
              }
            };
            var chart = new google.charts.Bar(document.getElementById('category_material'));
            chart.draw(data, options);
          };


          google.charts.load('current', {
            packages: ['corechart']
          });
          google.charts.setOnLoadCallback($scope.CategoryBarChart);



          $scope.barChart = function($event) {
            var data = google.visualization.arrayToDataTable($scope.centerdata);
            var options = {
              chart: {
                title: '',
                subtitle: '',
              },
              legend: {
                position: 'none',
              }

            };
            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            chart.draw(data, options);
          };



          $scope.drawChart = function($event) {
            var data = google.visualization.arrayToDataTable($scope.category);
            var options = {
              title: '',
              //pieHole: 0.1,
              pieSliceText: 'value',
              pieSliceTextStyle: {
                color: 'black',
              },
              pieSliceTextStyle: {
                color: 'white',
                fontSize: 15
              },

              chartArea: {
                top: 5,
                width: '90%',
                height: '80%'
              },
              legend: {
                position: 'bottom',
                labeledValueText: 'both',
                textStyle: {
                  fontSize: 12
                }
              }
            };
            var chart = new google.visualization.PieChart(document.getElementById('category'));
            chart.draw(data, options);
          };


          $scope.gender = function($event) {
            var dataa = google.visualization.arrayToDataTable($scope.genderdata);

            var options = {
              title: '',
              pieSliceText: 'value',
              pieSliceTextStyle: {
                color: 'black',
              },
              pieSliceTextStyle: {
                color: 'white',
                fontSize: 15
              },

              chartArea: {
                top: 5,
                width: '90%',
                height: '80%'
              },

              legend: {
                position: 'bottom',
                labeledValueText: 'both',
                textStyle: {
                  fontSize: 12
                }
              }
            };
            var charta = new google.visualization.PieChart(document.getElementById('gender'));
            charta.draw(dataa, options);
          };



          $scope.religion = function($event) {
            var dataa = google.visualization.arrayToDataTable($scope.religiondata);

            var options = {
              title: '',
              pieSliceText: 'value',
              pieSliceTextStyle: {
                color: 'black',
              },
              pieSliceTextStyle: {
                color: 'white',
                fontSize: 15
              },

              chartArea: {
                top: 5,
                width: '90%',
                height: '80%'
              },

              legend: {
                position: 'bottom',
                labeledValueText: 'both',
                textStyle: {
                  fontSize: 12
                }
              }
            };
            var charta = new google.visualization.PieChart(document.getElementById('religion'));
            charta.draw(dataa, options);
          };



          $scope.source_chart = function($event) {

            var data = google.visualization.arrayToDataTable($scope.source_data);

            var options = {
              title: '',
              titleTextStyle: {
                bold: false,
                italic: false,
                fontSize: 18,
              },
              legend: {
                position: 'none',
              }
            };


            var chart = new google.charts.Bar(document.getElementById('source_chart'));
            chart.draw(data, google.charts.Bar.convertOptions(options));

          };


          $scope.get_course = function($event) {

            var course = angular.element(document.querySelector('#course')).val();
            var center = angular.element(document.querySelector('#final_study_center')).val();
            if (course == "" && center == "") {
              $(".msg").html('Mandatory Field!');
              return false;
            }
            $("#loading").show();
            var data = course + '~' + center;

            $http({
              method: "get",
              dataType: 'html',
              url: "<?php echo site_url('admin/getcoursewisedata?data='); ?>" + data
            }).then(function(response) {
              console.log(response.data);
              $("#loading").hide();

              $scope.category = "";
              $scope.genderdata = "";
              $scope.religiondata = "";
              $scope.statelist = "";
              $scope.districtlist = "";
              $scope.categorychartdata = "";
              $scope.centerdata = "";
              $scope.source_data = "";
              $scope.source_chart = response.data['Appearing'];
              $scope.category = response.data['category'];
              $scope.genderdata = response.data['gender'];
              $scope.religiondata = response.data['religion'];
              $scope.statelist = response.data['statelist'];
              $scope.districtlist = response.data['districtlist'];
              $scope.categorychartdata = response.data['categorybar'];
              $scope.source_chart = response.data['source_data'];

              google.charts.load('current', {
                'packages': ['corechart']
              });
              google.charts.setOnLoadCallback($scope.drawChart);
              google.charts.setOnLoadCallback($scope.gender);
              google.charts.setOnLoadCallback($scope.religion);
              google.charts.setOnLoadCallback($scope.CategoryBarChart);
              google.charts.setOnLoadCallback(function() {
                $scope.drawSourceChart($scope.source_chart);
              });



              $scope.centerdata = response.data['center'];
              google.charts.load('current', {
                'packages': ['bar']
              });
              google.charts.setOnLoadCallback($scope.barChart);
              google.charts.setOnLoadCallback($scope.source_chart);

              var st_count = 0;
              for (var i = 0; i < $scope.statelist.length; i++) {
                var st_get = $scope.statelist[i].cnt;
                st_count += parseInt(st_get);
              }
              $scope.leng = st_count;


              var dis_count = 0;
              for (var i = 0; i < $scope.districtlist.length; i++) {
                var dis_get = $scope.districtlist[i].cnt;
                dis_count += parseInt(dis_get);
              }
              $scope.dis = dis_count;

            });
          };



          // Source Chart Drawing Function
          $scope.drawSourceChart = function(data) {
            var chartData = google.visualization.arrayToDataTable(data);

            var options = {
              title: '',
              legend: {
                position: 'none' 
              },
              // hAxis: {
              // title: 'name',
              titleTextStyle: {
                fontSize: 18,
                bold: false,
                italic: false
              },
            };

            var chart = new google.charts.Bar(document.getElementById('source_chart'));
            chart.draw(chartData, google.charts.Bar.convertOptions(options));
          };





          google.charts.load('current', {
            'packages': ['corechart']
          });
          google.charts.setOnLoadCallback($scope.drawChart);
          google.charts.setOnLoadCallback($scope.gender);
          google.charts.setOnLoadCallback($scope.religion);


          google.charts.load('current', {
            'packages': ['bar']
          });
          google.charts.setOnLoadCallback($scope.barChart);
          google.charts.setOnLoadCallback($scope.source_chart);


          angular.element(window).bind('resize', function() {
            if ($scope.source_chart) {
              $scope.drawSourceChart($scope.source_chart);
            }
          });


        }
      </script>
      <?php $this->load->view('../layout/footer.php'); ?>

</body>

</html>