<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('../layout/head.php'); ?>
<script src="<?=base_url();?>themes/js/jquery.min.js"></script>
<script src="<?=base_url();?>themes/js/angular.min.js"></script> 
<style type="text/css">.progress{margin-bottom: 0px;} .progress-bar{font-size: 15px;}</style>
<script src="<?=base_url();?>themes/js/jquery.min.js"></script>

</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="" ng-controller="validateCtrl">

<div id="loading" class="text-center"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

<div class="wrapper">

  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(2);
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">






  
    <!-- Content Header (Page header) -->
    <section class="content-header" style="display: flow-root;">
      
       <h1 style="float:left;">
       <?= $study_center ?> Registration Report Of <?= $course ?><small> For <?= $year ?>  <?= $month ?></small>
       </h1>
   
       <span style="float:right;">
        <form action="<?php echo site_url();?>/admin/date_wise_registration" method="POST">
          <input type="hidden" name="course" value="<?= $courseid ?>">
          <input type="hidden" name="dbnamee" value="iittm_<?= $year ?>">
          <input type="hidden" name="final_study_center" value="<?= $study_center ?>">
<button class="btn btn-success">Back</button>
</form>
</span>

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
  <th>Date</th>
  <th>Day</th>
  <th>Complete</th>
  <th>Incomplete</th>
  <th>Total</th>
</tr>
</thead>
<tbody>
<?php $tot1 = 0;$tot2 = 0;$tot3 = 0 ;foreach($dayslist as $day){ $con =0;?>
    <tr>
    <td><?= $day['date'] ?></td>
  <td><?= $day['day'] ?></td>
  <td>
    <?php $count = 0; foreach($result as $res){
           if(($res->login_status == 2) && (date("d-m-Y", strtotime($res->post_date)) ==date("d-m-Y", strtotime($day['date']))) && ($res->duplicate == 0)){
            $count++;
            $con++;
            $tot1++;
           }
    }
    echo $count;
?>
  </td>
  <td>
    <?php $count = 0; foreach($result2 as $res){
           if(($res->login_status == 1) && (date("d-m-Y", strtotime($res->created_date)) ==date("d-m-Y", strtotime($day['date'])))){
            $count++;
            $con++;
            $tot2++;
           }
    }
    echo $count;
?>
  </td>
  <td>
    <?php $count = 0; foreach($result as $res){



           if(date("d-m-Y", strtotime($res->created_date)) == date("d-m-Y", strtotime($day['date']))){
            $count++;
            $tot3++;
           }
    }
    echo  $con++;
?>
  </td>
    </tr>


   
    <?php
    }
?>
</tbody>
</thead>
    <tr>
  <th></th>
  <th></th>
  <th>Total Complete : <?= $tot1 ?></th>
  <th>Total Incomplete : <?= $tot2  ?></th>
  <th>Grand Total : <?= $tot1 +  $tot2   ?></th>
</tr>
</thead>
</table>


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
	
    $('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
    
});

  });


function validateCtrl($scope,$log,$http)
{
             $("#loading").hide();
}
</script>

 

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
<?php $this->load->view('../layout/footer.php'); ?>
  
</body>
</html>
