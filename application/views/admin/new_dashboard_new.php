<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('../layout/head.php'); ?>
<script src="<?=base_url();?>themes/js/jquery.min.js"></script>
<script src="<?=base_url();?>themes/js/angular.min.js"></script> 
<style type="text/css">.progress{margin-bottom: 0px;} .progress-bar{font-size: 15px;}</style>
<script src="<?=base_url();?>themes/js/jquery.min.js"></script>

<style type="text/css">
    #loading
    {
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

<div id="loading" class="text-center"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

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
        <select class="form-control" name="course" id="course" ng-model="course" ng-change="get_course()">
          <option value="">All</option>
          <option value="1">BBA</option>
          <option value="2">MBA</option>
        </select>

        </div>

         <div class="col-sm-3">
        <select class="form-control" name="center" id="center" ng-model="center" ng-change="get_center()">
          <option value="">All</option>
          <option value="1">BBA</option>
          <option value="2">MBA</option>
        </select>

        </div>

        <div class="col-sm-9 text-right">
         <span class="btn btn-danger">SMS BALANCE : - <?php echo $balance; ?></span>
        </div>

     

      </div>

     

    </section>

    <!-- Main content -->
    <section class="content">
   
   

    <div class="row">
        <div class="col-sm-9">

        <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Chart wise Details</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
               <div class="col-sm-3 text-center" style="background-color: #fff;">
                <h3>Category</h3>
                <div id="category" style="width: 100%; height: 300px;"></div>
              </div>

               <div class="col-sm-3 text-center" style="background-color: #fff;">
                <h3>Gender</h3>
                <div id="gender" style="width: 100%; height: 300px;"></div>
              </div>

               <div class="col-sm-3 text-center" style="background-color: #fff;">
                <h3>Religion</h3>
                <div id="religion" style="width: 100%; height: 300px;"></div>
              </div>

               <div class="col-sm-3 text-center" style="background-color: #fff;">
                <h3>Academic</h3>
                <div id="academic" style="width: 100%; height: 300px;"></div>
              </div>
            </div>
          </div>


        <div class="row">

          <div class="col-sm-6">

            <div class="box box-primary">
              <div class="box-body box-profile">
                <h3 class="profile-username text-center">Study Centre</h3>
                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-3">
                        <b>Gwalior</b> 
                      </div>
                      <div class="col-sm-8">
                         <div class='progress'>
                          <div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' aria-valuenow='{{study_center1}}' aria-valuemin='0' aria-valuemax='100' style='width: {{(study_center1/500)*100}}%'>{{study_center1}}
                            <span id='current-progress'></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <a class="pull-right" href="dashboard_filter/study_center_gwalior/{{course}}">{{study_center1}}</a>
                      </div>
                  </div>
                    
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-3">
                        <b>Bhubaneswar</b> 
                      </div>
                      <div class="col-sm-8">
                         <div class='progress'>
                          <div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' aria-valuenow='{{study_center2}}' aria-valuemin='0' aria-valuemax='100' style='width: {{(study_center2/500)*100}}%'>{{study_center2}}
                            <span id='current-progress' ></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <a class="pull-right" href="dashboard_filter/study_center_bhubaneswar/{{course}}">{{study_center2}}</a>
                      </div>
                  </div>
                    
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-3">
                        <b>Noida</b> 
                      </div>
                      <div class="col-sm-8">
                         <div class='progress'>
                          <div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' aria-valuenow='{{study_center3}}' aria-valuemin='0' aria-valuemax='100' style='width: {{(study_center3/500)*100}}%'>{{study_center3}}
                            <span id='current-progress' ></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <a class="pull-right" href="dashboard_filter/study_center_noida/{{course}}">{{study_center3}}</a>
                      </div>
                  </div>
                   
                  </li>
                    <li class="list-group-item">
                      <div class="row">
                      <div class="col-sm-3">
                        <b>Nellore</b> 
                      </div>
                      <div class="col-sm-8">
                         <div class='progress'>
                          <div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' aria-valuenow='{{study_center4}}' aria-valuemin='0' aria-valuemax='100' style='width:{{(study_center4/500)*100}}%'>{{study_center4}}
                            <span id='current-progress'></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <a class="pull-right" href="dashboard_filter/study_center_nellore/{{course}}">{{study_center4}}</a>
                      </div>
                  </div>
                    
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-sm-6">

            <div class="box box-success">
              <div class="box-body box-profile">
                <h3 class="profile-username text-center">Centre for GD & PI</h3>
                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-3">
                        <b>Gwalior</b> 
                      </div>
                      <div class="col-sm-8">
                         <div class='progress'>
                          <div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' aria-valuenow='{{gdpi_center_1}}' aria-valuemin='0' aria-valuemax='100' style='width: {{(gdpi_center_1/500)*100}}%'>{{gdpi_center_1}}
                            <span id='current-progress'></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <a class="pull-right" href="dashboard_filter/gdpi_center_gwalior/{{course}}">{{gdpi_center_1}}</a>
                      </div>
                  </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-3">
                        <b>Bhubaneswar</b> 
                      </div>
                      <div class="col-sm-8">
                         <div class='progress'>
                          <div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' aria-valuenow='{{gdpi_center_2}}' aria-valuemin='0' aria-valuemax='100' style='width: {{(gdpi_center_2/500)*100}}%'>{{gdpi_center_2}}
                            <span id='current-progress'></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <a class="pull-right" href="dashboard_filter/gdpi_center_bhubaneshwar/{{course}}">{{gdpi_center_2}}</a>
                      </div>
                  </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-sm-3">
                        <b>Noida</b> 
                      </div>
                      <div class="col-sm-8">
                         <div class='progress'>
                          <div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' aria-valuenow='{{gdpi_center_3}}' aria-valuemin='0' aria-valuemax='100' style='width: {{(gdpi_center_3/500)*100}}%'>{{gdpi_center_3}}
                            <span id='current-progress'></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <a class="pull-right" href="dashboard_filter/gdpi_center_noida/{{course}}">{{gdpi_center_3}}</a>
                      </div>
                  </div> 
                  </li>
                    <li class="list-group-item">
                      <div class="row">
                      <div class="col-sm-3">
                        <b>Nellore</b> 
                      </div>
                      <div class="col-sm-8">
                         <div class='progress'>
                          <div class='progress-bar progress-bar-success progress-bar-striped active' role='progressbar' aria-valuenow='{{gdpi_center_4}}' aria-valuemin='0' aria-valuemax='100' style='width: {{(gdpi_center_4/500)*100}}%'>{{gdpi_center_4}}
                            <span id='current-progress'></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <a class="pull-right" href="dashboard_filter/gdpi_center_nellore/{{course}}">{{gdpi_center_4}}</a>
                      </div>
                  </div> 
                  </li>
                </ul>
              </div>
            </div>
          </div></div>
        </div>
    


      <div class="col-sm-3">

      <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Registration</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding" style="">
              <ul class="nav nav-pills nav-stacked">
                <li class="">

              

                    <a href="dashboard_filter/total_regis/{{course}}"><i class="fa fa-users"></i> Total  
                      <span class="label label-primary pull-right" style="font-size: 15px;">{{total_regis}}</span>
                    </a>

             

                   

                  </li>
                <li><a href="#"><i class="fa fa-calendar"></i> From Date (12-Mar-2020)</a></li>
                <li><a href="dashboard_filter/today_regis/{{course}}"><i class="fa fa-calendar"></i> Today (<?php echo date('d-M-Y'); ?>)<span class="label label-primary pull-right" style="color: #000; font-size: 15px;">
                  {{today_candidate}}
                </span></a></li>
              
              </ul>
            </div>
            <!-- /.box-body -->
          </div>



          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Incomplete Application</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li class=""><a href="dashboard_filter/total_inc/{{course}}"><i class="fa fa-users"></i> Total  <span class="label label-danger pull-right" style="font-size: 15px;">{{total_inc}}</span></a></li>
                <li><a href="#"><i class="fa fa-calendar"></i> From Date (12-Mar-2020)</a></li>
                <li><a href="dashboard_filter/today_inc/{{course}}"><i class="fa fa-calendar"></i> Today (<?php echo date('d-M-Y'); ?>)<span class="label label-danger pull-right" style="color: #000; font-size: 15px;">
                  {{today_inc}}
                </span></a></li>
              
              </ul>
            </div>
            <!-- /.box-body -->
          </div>


          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Fee Collection</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
             <ul class="nav nav-pills nav-stacked">
                <li class=""><a href="dashboard_filter/total_fee/{{course}}"><i class="fa fa-inr"></i> Total  <span class="label label-success pull-right" style="font-size: 15px;">{{total_fee/100}}</span></a></li>
                 <li><a href="#"><i class="fa fa-calendar"></i> From Date (12-Mar-2020)</a></li>
                 <li><a href="dashboard_filter/today_fee/{{course}}"><i class="fa fa-calendar"></i> Today (<?php echo date('d-M-Y'); ?>)<span class="label label-success pull-right" style="color: #000; font-size: 15px;">
                  {{today_fee/100}}</span></a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>



          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Settlements Amount</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body text-center">
              <a class="btn btn-primary btn-lg"><i class="fa fa-inr "></i> {{settelment/100}} </a>
            </div>
            <!-- /.box-body -->
          </div>



        </div>
  
    </div>


    <div class="row">
      <div class="col-sm-12">
      <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Centre for Appearing</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
               <div id="chart_div" style="width: 100%; height: 350px;"></div>
            </div>
          </div>
        </div>
    </div>


    <div class="row ">
      <div class="col-sm-6">
      <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Date wise Candidates Registered</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
               <div id="candidate" style="width: 100%; height: 250px;"></div>
            </div>
          </div>
        </div>

        <div class="col-sm-6">
      <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Fee Collection</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
               <div id="fees" style="width: 100%; height: 250px;"></div>
            </div>
          </div>
        </div>
    </div>



    </section>

  
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
    $("#loading").hide();
  });
function validateCtrl($scope,$log,$http)
{

  
  $scope.total_regis = <?php echo $total_regis ?>;
  $scope.today_candidate = <?php echo $today_candidate ?>;
  $scope.total_inc = <?php echo $total_inc ?>;
  $scope.today_inc = <?php echo $today_inc ?>;
  $scope.total_fee = <?php echo $total_fee ?>;
  $scope.today_fee = <?php if($today_fee ==''){echo 0;} else{echo $today_fee;} ?>;
  $scope.category = <?php echo json_encode($category) ?>; 
  $scope.genderdata = <?php echo json_encode($gender) ?>; 
  $scope.religiondata = <?php echo json_encode($religion) ?>; 
  $scope.academicdata = <?php echo json_encode($academic) ?>; 
  $scope.appearingdata = <?php echo json_encode($Appearing) ?>;
  $scope.study_center1 = <?php echo $study_center1 ?>;
  $scope.study_center2 = <?php echo $study_center2 ?>;
  $scope.study_center3 = <?php echo $study_center3 ?>;
  $scope.study_center4 = <?php echo $study_center4 ?>;
  $scope.gdpi_center_1 = <?php echo $gdpi_center_1 ?>;
  $scope.gdpi_center_2 = <?php echo $gdpi_center_2 ?>;
  $scope.gdpi_center_3 = <?php echo $gdpi_center_3 ?>;
  $scope.gdpi_center_4 = <?php echo $gdpi_center_4 ?>;

  $scope.candidate_chart = <?php echo json_encode($candidate) ?>; 
 
  console.log($scope.candidate_chart);

  $scope.settelment = <?php echo $settelment; ?>;


  $scope.drawChart = function($event){
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
            fontSize:15
        },

        chartArea: { 
          top: 5,
             width: '90%', 
             height: '80%'
        },
          legend:{position: 'bottom', labeledValueText: 'both', textStyle: {fontSize: 12}}
        };
        var chart = new google.visualization.PieChart(document.getElementById('category'));
        chart.draw(data, options);
      };


      $scope.gender = function($event){
        var dataa = google.visualization.arrayToDataTable($scope.genderdata);

        var options = {
          title: '',
          pieSliceText: 'value',
          pieSliceTextStyle: {
            color: 'black',
          },
          pieSliceTextStyle: {
            color: 'white',
            fontSize:15
        },

         chartArea: { 
             top: 5,
             width: '90%', 
             height: '80%'
          },

          legend:{position: 'bottom', labeledValueText: 'both', textStyle: {fontSize: 12}}
        };
        var charta = new google.visualization.PieChart(document.getElementById('gender'));
        charta.draw(dataa, options);
      };


      $scope.religion = function($event){
       
        var dataa = google.visualization.arrayToDataTable($scope.religiondata);

        var options = {
          title: '',
          pieSliceText: 'value',
          pieSliceTextStyle: {
            color: 'black',
          },
          pieSliceTextStyle: {
            color: 'white',
            fontSize:15
        },

        chartArea: { 
          top: 5,
             width: '90%', 
             height: '80%'
        },
          legend:{position: 'bottom', labeledValueText: 'both', textStyle: {fontSize: 12}}
        };
        var charta = new google.visualization.PieChart(document.getElementById('religion'));
        charta.draw(dataa, options);
      };



      $scope.academic = function($event){
      
        var dataa = google.visualization.arrayToDataTable($scope.academicdata);

        var options = {
          title: '',
          pieSliceText: 'value',
          pieSliceTextStyle: {
            color: 'black',
          },
          pieSliceTextStyle: {
            color: 'white',
            fontSize:15
        },

        chartArea: { 
              top: 5, 
             width: '90%', 
             height: '80%'
        },
          legend:{position: 'bottom', labeledValueText: 'both', textStyle: {fontSize: 12}}
        };
        var charta = new google.visualization.PieChart(document.getElementById('academic'));
        charta.draw(dataa, options);
      };


      $scope.appearing = function($event){
       
        var data = google.visualization.arrayToDataTable($scope.appearingdata);

        var options = {
            title: '',
            titleTextStyle: {
                bold: false,
                italic: false,
                fontSize: 18,
            },
            legend:{position: 'none'},
        };

         var chart = new google.charts.Bar(document.getElementById('chart_div'));
         chart.draw(data, google.charts.Bar.convertOptions(options));
        
      };



       $scope.candidate = function($event){
       
         var data = google.visualization.arrayToDataTable([['Date', 'Total Candidate'],<?php echo $candidate?>]); 

         var options = {'title' : '',
               hAxis: {
                  title: ''
               },
               vAxis: {
                  title: ''
               },   
               pointsVisible:true,
               legend:{position: 'none'},   
            };
        /* Instantiate and draw the chart.*/
        var chart = new google.visualization.LineChart(document.getElementById('candidate'));
        chart.draw(data, options);
         };


         $scope.fees_chart = function($event){
       
         var data = google.visualization.arrayToDataTable([['Date', 'Total Fee'],<?php echo $fees?>]); 

         var options = {'title' : '',
               hAxis: {
                  title: ''
               },
               vAxis: {
                  title: ''
               },   
               pointsVisible:true,
               legend:{position: 'none'},   
            };
        /* Instantiate and draw the chart.*/
        var chart = new google.visualization.LineChart(document.getElementById('fees'));
        chart.draw(data, options);
         };
        




      $scope.get_course = function($event) {
        $("#loading").show();
       var data = angular.element(document.querySelector('#course')).val();
       if(data ==0){window.location= ("dashboard");}
       $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/get_course_data?data=');?>"+data}).then(function(response){
             //alert(response.data['category']);
             //console.log(response.data['Appearing']);
             $("#loading").hide();
              $scope.total_regis = response.data['total_regis'];
              $scope.today_candidate = response.data['today_candidate'];
              $scope.total_inc = response.data['total_inc'];
              $scope.today_inc = response.data['today_inc'];
              $scope.total_fee = response.data['total_fee'];
              $scope.today_fee = response.data['today_fee'];
              $scope.category = response.data['category'];
              $scope.genderdata = response.data['gender'];
              $scope.religiondata = response.data['religion'];
              $scope.academicdata = response.data['academic'];
              $scope.appearingdata = response.data['Appearing'];
              $scope.study_center1 = response.data['study_center1'];
              $scope.study_center2 = response.data['study_center2'];
              $scope.study_center3 = response.data['study_center3'];
              $scope.study_center4 = response.data['study_center4'];
              $scope.gdpi_center_1 = response.data['gdpi_center_1'];
              $scope.gdpi_center_2 = response.data['gdpi_center_2'];
              $scope.gdpi_center_3 = response.data['gdpi_center_3'];
              $scope.gdpi_center_4 = response.data['gdpi_center_4'];


              google.charts.load('current', {'packages':['corechart']});
              google.charts.setOnLoadCallback($scope.drawChart);
              google.charts.setOnLoadCallback($scope.gender);
              google.charts.setOnLoadCallback($scope.religion);
              google.charts.setOnLoadCallback($scope.academic);

              google.charts.load('current', {'packages':['bar']});
              google.charts.setOnLoadCallback($scope.appearing);

            }); 
      };

    
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback($scope.drawChart);
      google.charts.setOnLoadCallback($scope.gender);
      google.charts.setOnLoadCallback($scope.religion);
      google.charts.setOnLoadCallback($scope.academic);

      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback($scope.appearing);


      google.charts.load('current', {packages: ['corechart','line']});
      google.charts.setOnLoadCallback($scope.candidate);
      google.charts.setOnLoadCallback($scope.fees_chart);
       
   
     
 
}
</script>
<?php $this->load->view('../layout/footer.php'); ?>
  
</body>
</html>
