<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <script src="<?=base_url();?>themes/js/jquery.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

  <style type="text/css">
    th{background: #e4e4e4;}
    #loading{
    width: 100%;
    height: 800px;
    position: absolute;
    background-color: rgba(0, 0, 0, 0.50) !important;
    text-align: center;
    padding-top: 30%;
    z-index: 99999;
    }
  </style>

</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="Dashboard_Details">
<div class="wrapper">
<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(145);
  ?>
	
	

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Exam/Candidate Report
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="page-content">
    		<div class="row">
    			<div class="col-sm-8">

        <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Application wise</h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">

                <table class="table table-bordered">
                  <tr>
                    <th>Course</th>
                    <th colspan="2" style="text-align: center;">Gwalior</th>
                    <th colspan="2" style="text-align: center;">Noida</th>
                    <th colspan="2" style="text-align: center;">Nellore</th>
                    <th colspan="2" style="text-align: center;">Bhubaneswar</th>
                    <th colspan="2" style="text-align: center;">Goa</th>
                  </tr>

                  <tr>
                    <td></td>
                    
                    <td style="background: #888; color: #fff;">Application</td>
                    <td style="background: #5b68ff; color: #fff;">Seat</td>

                    <td style="background: #888; color: #fff;">Application</td>
                    <td style="background: #5b68ff; color: #fff;">Seat</td>

                    <td style="background: #888; color: #fff;">Application</td>
                    <td style="background: #5b68ff; color: #fff;">Seat</td>

                    <td style="background: #888; color: #fff;">Application</td>
                    <td style="background: #5b68ff; color: #fff;">Seat</td>

                    <td style="background: #888; color: #fff;">Application</td>
                    <td style="background: #5b68ff; color: #fff;">Seat</td>
                   
                  </tr>

                  <tr>
                    <td>MBA</td>
                    <td><b><?=$application['mba'][0];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">334</td>
                    <td><b><?=$application['mba'][1];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">112</td>
                    <td><b><?=$application['mba'][2];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">189</td>
                    <td><b><?=$application['mba'][3];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">75</td>
                    <td><b><?=$application['mba'][4];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">40</td>
                  </tr>

                  <tr>
                    <td>BBA</td>
                    <td><b><?=$application['bba'][0];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">112</td>
                    <td><b><?=$application['bba'][1];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">75</td>
                    <td><b><?=$application['bba'][2];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">113</td>
                    <td><b><?=$application['bba'][3];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">75</td>
                    <td><b><?=$application['bba'][4];?></b></td>
                    <td style="background: #5b68ff; color: #fff;">0</td>
                  </tr>
                </table>
              
            </div>
          </div>


          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Exam wise</h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">

          
            </div>
          </div>


          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Admission wise</h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">

          
            </div>
          </div>



          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Category wise</h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">

          
            </div>
          </div>


        
        </div>


        <div class="col-sm-4">

        <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Communication</h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">

          
          

               
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
</body>
</html>

<script>
$(document).ready(function(){
	$("#loading").hide();
});
</script>

