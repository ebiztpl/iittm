<?php

$amt = $this->session->userdata('amount');
$transaction_id = $this->session->userdata('transaction_id');


$course_id  = $this->session->userdata('course_id');
$userid = $this->session->userdata('user_id');

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Welcome to Indian Institute Of Tourism &amp; Travel Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url();?>themes/bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>themes/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url();?>themes/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>themes/dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_url();?>themes/plugins/iCheck/square/blue.css">

  <script src="<?=base_url();?>themes/js/jquery.min.js"></script>
  
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
<div class="main">
  <div class="container container_bg">
    
    <div class="row">
      <img src="<?=base_url();?>themes/dist/img/head.jpg" width="100%" />
    </div>

    <div class="row text-center">
      <h3>
       <b>Online Admission for <?php if($course_id==1){echo "BBA(TT/2025-28)";} else{ echo "MBA(TTM/2025-27)";} ?></b></h3>
      <hr/>
    </div> 


     <div class="row" style="margin-bottom: 10px;">
      <div class="col-sm-6">
        
      </div>
      <div class="col-sm-6 text-right">
       
      </div>
    </div>

    <h4 class="heading_ram" style="padding-bottom: 0px; color: red; padding-left:20px; color:blue;">Thanks for filling form <?php if($transaction_id != ""){ ?>and pay fee <?php } ?>. Your registration is complete now. </h4>

    <ul class="list" style="">
      <li>Admit card for Written admission test will have test center details also. You will get your admit card along with test center details 15 days prior to the test date.</li>
      <li>Admit card will be sent on your email id. You will also receive your admit card on your whatsapp number. You can also download your admit card from IITTM website. 
      </li>
      <li>
      If you wish to edit your details in the admission test application form, you can do that once and it will be chargeable. This facility will open after 15-Apr-2025 only. Please visit again on the website for more information.
      </li>
      <li>In case of any query/issue or related concern, you can <a href="../admission/contact" target="_blank">contact us</a> </li>
    </ul>
	    
	    <div class="row">
    <div class="col-lg-12 ">

      <table style="width:500px" class="table table-bordred" align="center" border='1' BORDERCOLOR='#e4e4e4'>
        <tr><td colspan="2" class="text-center" style="background-color: #e4e4e4">E-Receipt (Candidate copy)</td></tr>
        <tr>
          <td>Registration Number</td>
          <td>0000<?php echo $userid; ?></td>
        </tr>

       <?php if($transaction_id != ""){ ?>

         <tr>
          <td>Transaction Number</td>
          <td><?php echo $transaction_id; ?></td>
        </tr>

      <?php } ?>

         <tr>
          <td>Date of Registration</td>
          <td><?php echo date("d-m-Y"); ?></td>
        </tr>

        <?php if($amt != 0){ ?>
        <tr>
          <td>Transaction Amount(Rs)</td>
          <td><?php echo $amt; ?>/-</td>
        </tr>
     

        <tr>
          <td>Transaction Status</td>
          <td>Success</td>
        </tr>
         <?php } ?>
      </table>
       
    </div>
</div><!-- /.row -->

<div class="row text-center">
  <?php if($transaction_id != ""){ ?>
   <p style="color:#11a656; font-size: 20px;">Thank you for filling form. We have received your form and admission fee.</p>   
 <?php } ?>
  </div>


  <div class="row text-center"> 
        <a href="" onclick="myFunction()" class="btn btn-success btn" style="margin: 2px;"><i class="fa fa-print"></i> Print Receipt</a>

        <!--?php if($course_id==1)
        {
          echo "<a href='download_form' class='btn btn-info btn' style='margin: 2px;'><i class='fa fa-download'></i> Download Form</a>";
        }
        else
        {
          echo "<a href='download_form_mba' class='btn btn-info btn' style='margin: 2px;'><i class='fa fa-download'></i> Download Form</a>";
        }

      ?-->

       
        <a href="<?php print site_url();?>" class="btn btn-primary btn" style="margin: 2px;"><i class="fa fa-mail-reply"></i> Back To Home</a>                
    </div>  

	</div>
	</div>

<script>
function myFunction() {
  window.print();
}
</script>
</body>
</html>
