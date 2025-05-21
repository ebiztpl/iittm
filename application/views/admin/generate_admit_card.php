<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <script src="<?=base_url();?>themes/js/jquery.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
  <style type="text/css">
   
    table td{font-weight: bold; line-height: 25px;}
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
</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="home_screen">
<div class="wrapper">

  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(11);
  ?>
	<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
    	<div class="page-content">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3">

              <div class="box box-widget" id="printableArea" style="border: solid 1px #afadad;">

              <style type="text/css">
                @page {
                  size: 135mm 53.34; // set appropriately
                  margin: 0;
                }
                @media print {
                  html, body {
                    margin-left: auto;
                    margin-right: auto;
                    width: 135mm; // set appropriately
                    height: 53.34mm; // set appropriately
                  }   
                  .box-widget {border: solid 1px #afadad;}  
                }
              </style>              
                  
  <link rel="stylesheet" href="<?=base_url();?>themes/bower_components/bootstrap/dist/css/bootstrap.min.css">
 
  <link rel="stylesheet" href="<?=base_url();?>themes/dist/css/AdminLTE.min.css">
 
  <link rel="stylesheet" href="<?=base_url();?>themes/dist/css/skins/_all-skins.min.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


            <div class="box-header with-border text-center">
             <img src="<?=base_url();?>themes/dist/img/head.jpg" width="100%" />
             <h3><b>ADMIT CARD</b></h3>
            </div>
            
            <div class="box-body">

             

              <table width="100%">
                <tr>
                  <td style="width: 75%;">
                    <table width="100%">
                    <tr>
                      <td>Name</td>
                      <td>: <?php echo $data[0]['first_name'] ?> <?php echo $data[0]['middle_name'] ?> <?php echo $data[0]['last_name'] ?></td>
                    </tr>
                    <tr>
                      <td>Father Name</td>
                      <td>: <?php echo $data[0]['father_name'] ?></td>
                    </tr>
                    <tr>
                      <td>Mother Name</td>
                      <td>: <?php echo $data[0]['mother_name'] ?></td>
                    </tr>
                     <tr>
                      <td>Mobile</td>
                      <td>: <?php echo $data[0]['mobile'] ?></td>
                    </tr>
                     <tr>
                      <td>Course</td>
                      <td>:  <?php if($data[0]['course_id']==1) {?>
                          BBA
                        <?php } else {?>
                         MBA
                        <?php } ?>
                      </td>  
                    </tr>
                     <tr>
                      <td>Study Center</td>
                      <td>: <?php echo $data[0]['study_centre_1'] ?></td>
                    </tr>
                     <tr>
                      <td>Address</td>
                      <td>: </td>
                    </tr>
                  </table>
                  </td>
                  <td style="width: 25%;">
                    <?php if($data[0]['course_id']==1) {?>
                      <img src="<?=base_url();?>uploads/BBA/<?php echo $data[0]['candidate_photo'] ?>" width="120"/>
                    <?php } else {?>
                      <img src="<?=base_url();?>uploads/MBA/<?php echo $data[0]['candidate_photo'] ?>" width="120"/>
                    <?php } ?>
                  </td>
                </tr>
              </table>

            </div>

            <div class="box box-danger">   
                    <div class="box-header with-border" style="padding: 0px;">
                     
                    </div>
                    <div class="box-body box-danger">
                      <div class="row">
                        <div class="col-sm-12">
                          <b>General Instruction</b><br/>
                          <ul>
                            <li>Each candidate must bring printed copy of this admit card in to the exam.</li>
                            <li>Each candidate must bring printed copy of this admit card </li>
                            <li>Each candidate must bring print card in to the exam.</li>
                          </ul>
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-sm-12 text-center">
                            <a href="" class="btn btn-success" onclick="printDiv('printableArea')">Print</a>
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

<script>
$(document).ready(function(){
	$("#loading").hide();
});

var App = angular.module('myApp', ['ui.bootstrap']); 
function home_screen($scope,$log,$http,$compile)
{

 
}
</script>
<script type="text/javascript">
        function printDiv() {
           var getpanel = document.getElementById("printableArea");
           var MainWindow = window.open('', '', 'height=500,width=800');
           MainWindow.document.write('<html><head><title></title>');
           MainWindow.document.write("<link rel=\"stylesheet\" href=\"<?php base_url()?>themes/bower_components/bootstrap/dist/css/bootstrap.min\" type=\"text/css\"/>");
           MainWindow.document.write('</head><body onload="window.print();window.close()">');
           MainWindow.document.write(getpanel.innerHTML);
           MainWindow.document.write('</body></html>');
           MainWindow.document.close();
           setTimeout(function () {
              MainWindow.print();
           }, 500)
           return false;
        }
</script>
</body>
</html>

