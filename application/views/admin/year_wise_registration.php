<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('../layout/head.php'); ?>
<script src="<?=base_url();?>themes/js/jquery.min.js"></script>
<script src="<?=base_url();?>themes/js/angular.min.js"></script> 
<style type="text/css">.progress{margin-bottom: 0px;} .progress-bar{font-size: 15px;}</style>


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
   

    <!-- Main content -->
    <section class="content">
   
       <div class="row">
        <div class="col-sm-12">

        <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Year Wise Registration</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              	<div class="col-sm-12" style="margin-top:10px; ">
                <div class="col-sm-2">
                   <select class="form-control" id="course" required="">
                    <option value="1,2">All Course</option>
                    <option value="1">BBA</option>
                    <option value="2">MBA</option>
                    </select>
                  </div>
            
                  <div class="col-sm-3">
                  <a class="btn btn-success" ng-click="get_course()" >Search</a>
                  </div>
              </div>
              
				
               <div class="col-sm-12 text-center" style="background-color: #fff;">
                <div id='comparison' style='width: 100%; height:450px;'></div>
              </div>


         
            </div>
          </div>
        </div>
    </div>

  
		
		   <div class="row">
          <div class="col-sm-12">
          <div class="box box-solid">
             <div id='citychart' style='width: 100%; height:450px;'></div>
          </div>
          </div>
    </div>
		
        <div class="row">
        <div class="col-sm-12">
            <div class="box box-solid">
              <div class="box-body box-profile">
                 <div id="source_chart" style="width: 100%; height: 350px;"></div>
              </div>
            </div>
          </div>
        </div>



</section>

  </div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
    $("#loading").hide();
	 
	 setTimeout(function() { 
      var table = $('#myTable').DataTable( {
         scrollY: 300,
         scrollX: false,
         scrollCollapse: true,
         paging: false,        
         fixedHeader: true
        });
    });
	 
	 
  });
	

function validateCtrl($scope,$log,$http)
{

  $scope.chartdata = <?php echo json_encode($chart) ?>;
  $scope.citychartdata = <?php echo json_encode($citychart) ?>;
  $scope.source_data = <?php echo json_encode($source_chart) ?>;

  $scope.source_chart = function($event){
       
        var data = google.visualization.arrayToDataTable($scope.source_data);
        var view = new google.visualization.DataView(data);
      
        view.setColumns([0, 1, {
          calc: 'stringify',
          sourceColumn: 1,
          type: 'string',
          role: 'annotation'
        },2,{
         calc: 'stringify',
          sourceColumn: 2,
          type: 'string',
          role: 'annotation'
        },3,{
         calc: 'stringify',
          sourceColumn: 3,
          type: 'string',
          role: 'annotation'
        }

      ]);

        var options = {
          title : '',
          vAxis: {title: ''},
          hAxis: {title: 'Know IITTM'},
          seriesType: 'bars',
          legend: { position: 'top'},
           chartArea: { 
             width: '90%', 
             height: '60%'
          },
        };

          var chart = new google.visualization.ComboChart(document.getElementById('source_chart'));
          chart.draw(view,options);
      };

      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback($scope.source_chart);




 $scope.drawVisualizationfunction = function($event){

        // Some raw data (not necessarily accurate)
         var data = google.visualization.arrayToDataTable($scope.chartdata);
         var view = new google.visualization.DataView(data);
               view.setColumns([0, 1, {
                  calc: 'stringify',
                  sourceColumn: 1,
                  type: 'string',
                  role: 'annotation'
                },2,{
                 calc: 'stringify',
                  sourceColumn: 2,
                  type: 'string',
                  role: 'annotation'
                }
              ]);

        var options = {
          title : '',
          vAxis: {title: ''},
          hAxis: {title: 'Year wise Registration/Admission'},
          seriesType: 'bars',
          legend: { position: 'top'},
           chartArea: { 
             width: '90%', 
             height: '60%'
          },
        };

          var chart = new google.visualization.ComboChart(document.getElementById('comparison'));
          chart.draw(view,options);
      }


      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback($scope.drawVisualizationfunction);
  



$scope.citychartfunction = function($event){
  
        console.log($scope.citychartdata);
        var data = google.visualization.arrayToDataTable($scope.citychartdata);
        var view = new google.visualization.DataView(data);

        view.setColumns([0, 1, {
          calc: 'stringify',
          sourceColumn: 1,
          type: 'string',
          role: 'annotation'
        }, 2, {
          calc: 'stringify',
          sourceColumn: 2,
          type: 'string',
          role: 'annotation'
      }, 3, {
          calc: 'stringify',
          sourceColumn: 3,
          type: 'string',
          role: 'annotation'
      }, 4, {
          calc: 'stringify',
          sourceColumn: 4,
          type: 'string',
          role: 'annotation'
      }, 5, {
          calc: 'stringify',
          sourceColumn: 5,
          type: 'string',
          role: 'annotation'
      },
      6, {
          calc: 'stringify',
          sourceColumn: 6,
          type: 'string',
          role: 'annotation'
      },


      ]);

        var options = {
          title : '',
          vAxis: {title: ''},
          hAxis: {title: 'Study Center Wise Report'},
          seriesType: 'bars',
          legend: { position: 'top'},
           chartArea: { 
             width: '90%', 
             height: '70%'
          },
        };
   
        var chart = new google.visualization.ComboChart(document.getElementById('citychart'));
        chart.draw(view,options);
      }
     
      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback($scope.citychartfunction);
   
      


   $scope.get_course = function($event) {
       $("#loading").show();
       var course = angular.element(document.querySelector('#course')).val();
       if(course ==""){
        $(".msg").html('Mandatory Field!');
        return false;
       }
       
       var data = course;
       $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/yearwiseregistration_filter?data=');?>"+data}).then(function(response){
              console.log(response.data);
             $("#loading").hide();

             
              $scope.chartdata = response.data['chart'];
              $scope.citychartdata = response.data['citychart'];
              $scope.source_data = response.data['source_chart']; 

              google.charts.load('current', {packages: ['corechart', 'bar']});
              google.charts.setOnLoadCallback($scope.drawVisualizationfunction);
              google.charts.setOnLoadCallback($scope.citychartfunction);
              google.charts.setOnLoadCallback($scope.source_chart);
              

            }); 

                  
       
             
      };
          


             
}


</script>

<?php $this->load->view('../layout/footer.php'); ?>
  
</body>
</html>
