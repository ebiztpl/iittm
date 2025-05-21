
<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <script src="<?=base_url();?>themes/js/jquery.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="home_screen">
<div class="wrapper">

  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(6);
  ?>
	<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Seat Manage
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="page-content">
		



		<div class="row">


			<div class="col-sm-12">

<div class="box">

<div class="box-body box-success">

<div class="form-group">

      <div class="row">

          <div class="col-sm-5">
             <label>Study Centre:</label>

            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-university"></i>
              </div>
               <select class="form-control"  id="get_center">
                    <option value="'Gwalior','Bhubaneswar','Noida','Nellore','Noida','Goa'">--Select--</option>
                    <option value="'Gwalior'">Gwalior</option>
                    <option value="'Bhubaneswar'">Bhubaneswar</option>
                    <option value="'Noida'">Noida</option>
                    <option value="'Nellore'">Nellore</option>
					<option value="'Goa'">NIWS-GOA</option>
              </select>
            </div>

          </div>

          <div class="col-sm-5">
            <label>Course:</label>

                       <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-file"></i>
                        </div>
                       <select class="form-control" id="get_course" >
                          <option value="1,2">--Select--</option>
                          <option value="1">BBA</option>
                          <option value="2">MBA</option>
                        </select>
                      </div>

            </div>

            <div class="col-sm-2">
            <label>&nbsp;</label><br/>
            <a class="btn btn-primary" ng-click="get_course_function()" ng-model="search">Show</a>
            </div>
        </div>

</div>


<div class="form-group">
        <div class="row">
          <div class="col-sm-3 text-center"><b>Total Seat:</b> <label class="btn btn-danger btn-xs" ng-model="total_seat">{{totalseat}}</label></div>
          <div class="col-sm-3"><b>Total Application:</b> <label class="btn btn-danger btn-xs">{{total_application}}</label></div>

          <div class="col-sm-3"><b>Total Exam:</b> <label class="btn btn-danger btn-xs">{{total_exam}}</label></div>

          <div class="col-sm-3"><b>Total Admission:</b> <label class="btn btn-danger btn-xs" >{{total_admission}}</label></div>
        </div>
</div>


<div class="form-group text-center">
<!-- <table class="table" border="1" style="width:90%;" align="center" bordercolor="#e4e4e4"> 
       <thead>
            <tr>
                
                <th colspan="2" style="text-align:center; background-color:#d4d4d4;">No of Seat</th>
                <th colspan="3" style="text-align:center; background-color:#d4d4d4;">Application Recieved</th>
            </tr>
            <tr>
              <td><b>Category</b></td>
              <td><b>Seat</b></td>
              <td><b>PwD</b></td>
              <td><b>Normal</b></td>
              <td><b>Percentage</b></td>
            <tr>
            </thaed>
            <tbody>
            <tr>
              <td>UR</td>
              <td>{{general_cat}}</td>
              <td>{{general_pwd}}</td>
              <td>{{general_application}} </td>
              <td>{{(total_general/general_cat)*100 |number:'2'}}</td>
            </tr>
            <tr>
              <td>EWS</td>
              <td>{{ews_cat}}</td>
              <td>{{ews_pwd}}</td>
              <td>{{ews_application}}</td>
              <td>{{(total_ews/ews_cat)*100 |number:'2'}}</td>
            </tr>
            <tr>
             
               <td>OBC</td>
               <td>{{obc_cat}}</td>
               <td>{{obc_pwd}}</td>
               <td>{{obc_application}}</td>
               <td>{{(total_obc/obc_cat)*100 |number:'2'}}</td> 
            </tr>
            <tr>
             
              <td>SC</td>
              <td>{{sc_cat}}</td>
              <td>{{sc_pwd}}</td>
              <td>{{sc_application}}</td>
              <td>{{(total_sc/sc_cat)*100 |number:'2'}}</td>
            </tr>
            <tr>
              
              <td>ST</td>
              <td>{{st_cat}}</td>
              <td>{{st_pwd}}</td>
              <td>{{st_application}}</td>
              <td>{{(total_st/st_cat)*100 |number:'2'}}</td>
            </tr>

            <tr style="background-color:#d4d4d4;">
            <td>Total</td>
            <td>{{total_seat}}</td>
            <td>{{total_pwd}}</td>
            <td>{{total_application}}</td>
            <td></td>
          </tr>

            </tbody>
</table> -->



<table class="table" border="1" style="width:90%;" align="center" bordercolor="#e4e4e4"> 
       <thead>
            <tr>
                
                <th colspan="2" style="text-align:center; background-color:#d4d4d4;">No of Seat</th>
                <th style="text-align:center; background-color:#83baff;">Application Recieved</th>
                <th  style="text-align:center; background-color:#ffadad;">GDPI Done</th>
                <th  style="text-align:center; background-color:#7ed3ac;">Admission</th>
            </tr>
            <tr>
              <td style="text-align:center; background-color:#444; color: #fff;"><b>Category</b></td>
              <td style="text-align:center; background-color:#444; color: #fff;"><b>Seat</b></td>
              <td style="text-align:center; background-color:#83baff;"><b>Total</b></td>
              <td style="text-align:center; background-color:#ffadad;"><b>Total</b></td>
              <td style="text-align:center; background-color:#7ed3ac;"><b>Total</b></td>
            <tr>
            </thaed>
            <tbody>
            <tr>
              <td>UR</td>
              <td>{{general_cat}}</td>
              <td>{{general_application}} </td>
              <td>{{general_exam}}</td>
              <td>{{general_admission}}</td>
            
            </tr>
            <tr>
              <td>EWS</td>
              <td>{{ews_cat}}</td>
              <td>{{ews_application}}</td>
              <td>{{ews_exam}}</td>
              <td>{{ews_admission}}</td>
            
            </tr>
            <tr>
             
              <td>OBC</td>
              <td>{{obc_cat}}</td>
              <td>{{obc_application}}</td>
              <td>{{obc_exam}}</td>
              <td>{{obc_admission}}</td>
             
            </tr>
            <tr>
             
              <td>SC</td>
              <td>{{sc_cat}}</td>
              <td>{{sc_application}}</td>
              <td>{{sc_exam}}</td>
              <td>{{sc_admission}}</td>
          
            </tr>
            <tr>
              
              <td>ST</td>
              <td>{{st_cat}}</td>
              <td>{{st_application}}</td>
              <td>{{st_exam}}</td>
              <td>{{st_admission}}</td>
             
            </tr>

            <tr style="background-color:#d4d4d4;">
            <td>Total</td>
            <td>{{total_seat}}</td>
            <td>{{total_application}}</td>
            <td>{{total_exam}}</td>
            <td>{{total_admission}}</td>
          
          </tr>

            </tbody>
</table>







</div>

			</div>
			
		</div>

</div>

</div>


		
			<!-- Begin Action Navigation Bar -->
			
			
	</div>
    </section>
</div>

<?php $this->load->view('../layout/footer.php'); ?>

<script>
$(document).ready(function(){
	$("#loading").hide();
});

var App = angular.module('myApp', ['ui.bootstrap']); 

function home_screen($scope,$log,$http,$compile)
{


  $scope.login_check = function($event)
    {
      
      if($scope.LoginForm.$invalid)
      {
        $scope.LoginForm.$submitted=true;
        $event.preventDefault();
      }
      
    };

    $scope.open = function($event) {
    $scope.opened = true;
    };

	$scope.movieArray =[];

	$scope.fix_per = function()
	{
		$scope.txt_getseat = Math.round(($scope.txt_per*$scope.txt_seat)/100).toFixed(0);	
	};	
	
	 $scope.addRow = function () {
            if ($scope.category != undefined && $scope.txt_per != undefined) {
                var movie = [];
                movie.first = $scope.category;
                movie.second = $scope.txt_per;
                movie.third = $scope.txt_getseat;

                $scope.movieArray.push(movie);

                
                //$scope.category = "";
                //$scope.txt_per = "";
                //$scope.txt_getseat = "";
              
            }
        };

        // REMOVE SELECTED ROW(s) FROM TABLE.
        $scope.removeRow = function () {
            var arrMovie = [];
            angular.forEach($scope.movieArray, function (value) {
                if (!value.Remove) {
                    arrMovie.push(value);
                }
            });
            $scope.movieArray = arrMovie;
        };


      $scope.get_course_function = function($event) {
       $("#loading").show();
       var course = angular.element(document.querySelector('#get_course')).val();
       var center = angular.element(document.querySelector('#get_center')).val();
       var data = course+'~'+center;
       $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/get_data_seat?data=');?>"+data}).then(function(response){
            

             console.log(response.data['total_seat']);
             console.log(response.data['total_application']);
             $("#loading").hide();

             $scope.totalseat = response.data['total_seat'];
             $scope.totalapplication = response.data['total_application'];
             $scope.general_cat =  response.data['general_cat'];
             $scope.ews_cat =  response.data['ews_cat'];
             $scope.obc_cat =  response.data['obc_cat'];
             $scope.sc_cat =  response.data['sc_cat'];
             $scope.st_cat =  response.data['st_cat'];

             $scope.general_application = response.data['general_application'];
             $scope.ews_application = response.data['ews_application'];
             $scope.obc_application = response.data['obc_application'];
             $scope.sc_application = response.data['sc_application'];
             $scope.st_application = response.data['st_application'];

             $scope.general_exam_pwd = response.data['general_exam_pwd'];
             $scope.general_exam = response.data['general_exam'];
             $scope.obc_exam = response.data['obc_exam'];
             $scope.ews_exam = response.data['ews_exam'];
             $scope.sc_exam = response.data['sc_exam'];
             $scope.st_exam = response.data['st_exam'];


             $scope.general_admission = response.data['general_admission'];
             $scope.obc_admission = response.data['obc_admission'];
             $scope.ews_admission = response.data['ews_admission'];
             $scope.sc_admission = response.data['sc_admission'];
             $scope.st_admission = response.data['st_admission'];


             $scope.general_pwd = response.data['general_pwd'];
             $scope.ews_pwd = response.data['ews_pwd'];
             $scope.obc_pwd = response.data['obc_pwd'];
             $scope.sc_pwd = response.data['sc_pwd'];
             $scope.st_pwd = response.data['st_pwd'];





             $scope.total_general = parseInt(response.data['general_pwd'])+ parseInt(response.data['general_application']);
             $scope.total_ews = parseInt(response.data['ews_pwd'])+ parseInt(response.data['ews_application']);
             $scope.total_obc = parseInt(response.data['obc_pwd'])+ parseInt(response.data['obc_application']);
             $scope.total_sc = parseInt(response.data['sc_pwd'])+ parseInt(response.data['sc_application']);
             $scope.total_st = parseInt(response.data['st_pwd'])+ parseInt(response.data['st_application']);


             seat_totall = parseInt(response.data['st_cat'])+ parseInt(response.data['sc_cat'])+parseInt(response.data['general_cat'])+parseInt(response.data['ews_cat'])+parseInt(response.data['obc_cat']);
             $scope.total_seat = seat_totall;


             pwd_totall = parseInt(response.data['st_pwd'])+ parseInt(response.data['sc_pwd'])+parseInt(response.data['general_pwd'])+parseInt(response.data['ews_pwd'])+parseInt(response.data['obc_pwd']);
             $scope.total_pwd = pwd_totall;


            application_totall = parseInt(response.data['general_application'])+ parseInt(response.data['ews_application'])+parseInt(response.data['obc_application'])+parseInt(response.data['sc_application'])+parseInt(response.data['st_application']);
             $scope.total_application = application_totall;


              exam_totall = parseInt(response.data['general_exam'])+ parseInt(response.data['ews_exam'])+parseInt(response.data['obc_exam'])+parseInt(response.data['sc_exam'])+parseInt(response.data['st_exam']);
              $scope.total_exam = exam_totall;



               admission_totall = parseInt(response.data['general_admission'])+ parseInt(response.data['ews_admission'])+parseInt(response.data['obc_admission'])+parseInt(response.data['sc_admission'])+parseInt(response.data['st_admission']);
              $scope.total_admission = admission_totall;



           })
         };


       


}

 
 



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
z-index: 99;
	}
</style>



</body>
</html>

