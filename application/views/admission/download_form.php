<?php
$amt = $this->session->userdata('amount');
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
      <h3><b>Online Admission for BBA(TT/2021-24) & MBA(TTM/2021-23)</b></h3>
      <hr/>
    </div> 


     <div class="row" style="margin-bottom: 10px;">
      <div class="col-sm-6">
        
      </div>
      <div class="col-sm-6 text-right">
       
      </div>
    </div>
	    
	    <div class="row">
    <div class="col-lg-12 ">

      <table style="width:500px" class="table table-bordred" align="center" border='1' BORDERCOLOR='#e4e4e4'>
        <tr><td colspan="2" class="text-center" style="background-color: #e4e4e4">E-Receipt (Candidate copy)</td></tr>
        <tr>
          <td>Registration Number</td>
          <td>0000<?php echo $userid; ?></td>
        </tr>

        <tr>
          <td>Exam Name</td>
          <td></td>
        </tr>

         <tr>
          <td>Transaction Number</td>
          <td>pay_EOtg4TS5nZiHAO</td>
        </tr>

         <tr>
          <td>Date of Transaction</td>
          <td><?php echo date("d-m-Y"); ?></td>
        </tr>

        <tr>
          <td>Transaction Amount(Rs)</td>
          <td><?php echo $amt; ?>/-</td>
        </tr>

        <tr>
          <td>Transaction Status</td>
          <td>Success</td>
        </tr>
      </table>
       
    </div>
</div><!-- /.row -->

<div class="row text-center">
   <p style="color:#11a656; font-size: 20px;">Thank You, Your payment has been processed successfully.</p>   
  </div>


  <div class="row text-center"> 
        <a href="" onclick="myFunction()" class="btn btn-success btn" style="margin: 2px;"><i class="fa fa-print"></i> Print Receipt</a>
        <a href="<?php print site_url();?>/download_form" class="btn btn-info btn" style="margin: 2px;"><i class="fa fa-download"></i> Download Form</a>  
        <a href="<?php print site_url();?>" class="btn btn-primary btn" style="margin: 2px;"><i class="fa fa-mail-reply"></i> Back To Home</a>                
    </div>  

	</div>
	</div>

<?php

    $filename = "Attendance Sheet_".$btId;

    // include autoloader
    require_once 'dompdf/autoload.inc.php';

    // reference the Dompdf namespace
    use Dompdf\Dompdf;

    use Dompdf\FontMetrics;

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $dompdf->loadHtml($tr);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    $font = FontMetrics::getFont("helvetica", "bold");

    $dompdf->get_canvas()->page_text(35, 12, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 9, array(0,0,0));

    // Output the generated PDF to Browser
    $dompdf->stream($filename,array("Attachment"=>1));

?>

</body>
</html>
