
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

			<div class="col-sm-6">

			 <?php // Initializing form
            $lFormAttrb = array(
              'role' => 'form',
              'id' => 'LoginForm',
              'name'=>'LoginForm',
              'method' => 'POST',
              'novalidate'=>'novalidate',
              'ng-submit'=> 'login_check($event)',
              'enctype'=> 'multipart/form-data',
              
            );
            echo form_open('',$lFormAttrb); 
          ?>  
				<div class="box">		
				<div class="box-body box-danger">
			
			<?php
       if(hasFlash('ViewMsgSuccess')){echo getFlash('ViewMsgSuccess');}
       ?> 
				<div class="form-group">

				<div class="row">

					<div class="col-sm-6">
						 <label>Study Centre:</label>

            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-university"></i>
              </div>
              <select class="form-control" ng-model="first_code" name="first_code" required>
                    <option value="">--Select--</option>
                    <option value="Gwalior">Gwalior</option>
                    <option value="Bhubaneswar">Bhubaneswar</option>
                    <option value="Noida">Noida</option>
                    <option value="Nellore">Nellore</option>
					<option value="Goa">NIWS-GOA</option>
              </select>
              
            </div>
<span style="color:red" ng-show="LoginForm.first_code.$dirty && LoginForm.first_code.$invalid || LoginForm.$submitted && LoginForm.first_code.$invalid">
                <span ng-show="LoginForm.first_code.$error.required">field is required.</span>
                </span>
					</div>

					<div class="col-sm-6">
						<label>Course:</label>

			               	 <div class="input-group">
			                  <div class="input-group-addon">
			                    <i class="fa fa-file"></i>
			                  </div>
			                  <select class="form-control" name="course" ng-model="course" required>
                          <option value="">--Select--</option>
                          <option value="1">BBA</option>
                          <option value="2">MBA</option>
                        </select>
			                </div>

                  <span style="color:red" ng-show="LoginForm.course.$dirty && LoginForm.course.$invalid || LoginForm.$submitted && LoginForm.course.$invalid">
                <span ng-show="LoginForm.course.$error.required">field is required.</span>
                </span>
						</div>
				</div>
        <!-- /.input group -->
    </div>


             

        

  <div class="form-group">
    <label>Total Seat:</label>

    <div class="input-group">
      <div class="input-group-addon">
        <i class="fa fa-check"></i>
      </div>
      <input type="number" class="form-control" name="txt_seat" ng-model="txt_seat" ng-blur="fix_per()" required>
    </div>
    
    <span style="color:red" ng-show="LoginForm.txt_seat.$dirty && LoginForm.txt_seat.$invalid || LoginForm.$submitted && LoginForm.txt_seat.$invalid">
    <span ng-show="LoginForm.txt_seat.$error.required">field is required.</span>
    </span>
    
  </div>
					

			<div class="form-group">
              <div class="row">
                <div class="col-xs-4">
                <label>Category:</label>

                  <select class="form-control" ng-model="category" name="category" required>
                  <option value="">--Select--</option>
                  <option value="General">General</option>
                  <option value="OBC">OBC</option>
                  <option value="SC">SC</option>
                  <option value="ST">ST</option>
                  <option value="EWS">EWS</option>
                  </select>

                  <span style="color:red" ng-show="LoginForm.category.$dirty && LoginForm.category.$invalid || LoginForm.$submitted && LoginForm.category.$invalid">
                <span ng-show="LoginForm.category.$error.required">field is required.</span>
                </span>

                </div>
                <div class="col-xs-4">
                  <label>Percentage of seat:</label>
                  <input type="text" class="form-control" name="txt_per" ng-model="txt_per" ng-blur="fix_per()" required />
                <span style="color:red" ng-show="LoginForm.txt_per.$dirty && LoginForm.txt_per.$invalid || LoginForm.$submitted && LoginForm.txt_per.$invalid">
                <span ng-show="LoginForm.txt_per.$error.required">field is required.</span>
                </span>
                </div>
                <div class="col-xs-3">
                <label>Seat:</label>
                  <input type="text" class="form-control"  ng-model="txt_getseat" readonly>
                </div>

                <div class="col-xs-1" style="padding-left:0px;">
                <label>&nbsp;</label>
                	<a class="btn btn-danger btn-sm" ng-click="addRow()"><i class="fa fa-plus"></i></a>
                </div>
              </div>
              </div>

			
				</div>

			<div class="form-group">

			 <table class="table" border="1" style="width:90%;" align="center" bordercolor="#e4e4e4"> 
			 <thead>
            <tr>
                <th>Sr</th>
                <th>Category</th>
                <th>Percentage</th>
                <th>Seat</th>
                <th>Delete</th>
            </tr>
            </thaed>

            <tbody>
            <tr ng-repeat="movies in movieArray">
                <td>{{$index + 1}}</td>
                <td>{{movies.first}}<input type="hidden" id="hidden_cat" ng-model="hidden_cat" name="hiddencat[]" value="{{movies.first}}" /></td>
                <td>{{movies.second}} <input type="hidden" ng-model="hidden_persentage" name="hiddenpersentage[]" value="{{movies.second}}" /></td>
                <td>{{movies.third}} <input type="hidden" ng-model="hidden_seat" name="hiddenseat[]" value="{{movies.third}}" /></td>
                
                <td><a class="btn btn-primary btn-xs" ng-click="removeRow()"> <input type="checkbox" ng-model="movies.Remove" /> Remove</a></td>
               
            </tr>
            </tbody>
            

            <tfoot>
              <tr>
                
                <td colspan="2" align="center"><b>Total</b></td>
                <td style="background-color:#d4d4d4;" >{{total_persentace}}</td>
                <td style="background-color:#d4d4d4;">{{total_seat}}</td>
                <td></td>
              </tr>
            </tfoot>

        </table>
       
      
			</div>	

            <div class="form-group text-center">
              <button class="btn btn-success" id="btnSubmit" name="btnSubmit">Save Data</button>
            </div>
            <br/>

            <div nd-model="display">{{display}}</div>
				</div>
				<?php echo form_close(); ?>	

			</div>


			<div class="col-sm-6">

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
              <select class="form-control" ng-model="get_center" id="get_center">
                    <option value="">--Select--</option>
                    <option value="Gwalior">Gwalior</option>
                    <option value="Bhubaneswar">Bhubaneswar</option>
                    <option value="Noida">Noida</option>
                    <option value="Nellore">Nellore</option>
					<option value="Goa">NIWS-GOA</option>
              </select>
            </div>

          </div>

          <div class="col-sm-5">
            <label>Course:</label>

                       <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-file"></i>
                        </div>
                        <select class="form-control" ng-model="get_course" id="get_course" >
                          <option value="">--Select--</option>
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
          <div class="col-sm-6 text-center"><b>Total Seat:</b> <label class="btn btn-danger btn-xs" ng-hide="!totalseat" ng-model="total_seat">{{totalseat}}</label></div>
          <div class="col-sm-6"><b>Total Application Recieved:</b> <label class="btn btn-danger btn-xs" ng-hide="!totalapplication" ng-model="total_seat">{{totalapplication}}</label></div>
        </div>
</div>


<div class="form-group text-center">
<table class="table" border="1" style="width:90%;" align="center" bordercolor="#e4e4e4"> 
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
	 var total_per = 0; var total_seats = 0;
	 $scope.addRow = function () {
            if ($scope.category != undefined && $scope.txt_per != undefined) {
                var movie = []; 
                movie.first = $scope.category;
                movie.second = $scope.txt_per;
                movie.third = $scope.txt_getseat;

                $scope.movieArray.push(movie);

                console.log(movie);
                //$scope.category = "";
                //$scope.txt_per = "";
                //$scope.txt_getseat = "";

                total_per += parseFloat(movie.second == "" ? 0 : movie.second);
                total_seats += parseFloat(movie.third == "" ? 0 : movie.third);
               
                $scope.total_persentace = total_per;
                $scope.total_seat = total_seats;                
                
                //console.log(total);                
             
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

