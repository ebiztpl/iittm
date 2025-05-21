<?php
if($this->session->userdata('amount')==1000)
{
  $whitout_transcation_amt = $this->session->userdata('amount');
  $whit_transaction_amt = $whitout_transcation_amt+25;
}
if($this->session->userdata('amount')==500)
{
  $whitout_transcation_amt = $this->session->userdata('amount');
  $whit_transaction_amt = $whitout_transcation_amt+15;
}





$s_amt = $this->session->userdata('amount');
$save_amt = ($s_amt*100);

$amt = $whit_transaction_amt;
$userid = $this->session->userdata('user_id');

$txnid = time();
$surl = site_url().'/razorpay/success';
$furl = site_url().'/razorpay/failed';    

//iittm credential Live API
//$key_id = "rzp_live_XmUfoXAp5gsYCH";

//iittm credential Test API
$key_id = "rzp_test_Zg3g9bHxxcZiz2";

$currency_code ="INR";            
$total = ($amt*100); 
$amount = $amt;
$productinfo = "";
$merchant_order_id = "";
$card_holder_name = 'IITTM';
$email = '';
$phone = '';
$name = "IITTM";
$return_url = site_url().'/razorpay/callback';
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-164569761-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-164569761-1');
    </script>

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

    <?php
      $whereE = "user_id = '$userid'";
      $rstE = $this->db_lib->fetchRecord('user_master',$whereE,'*');
    ?>

    <div class="row text-center">
      <h3><b>
      <?php 
        if($rstE['course_id']==1){echo "Online Admission for BBA(TT/2022-25)";}  
        if($rstE['course_id']==2){echo "Online Admission for MBA(TTM/2022-24)";}
      ?>
    </b></h3>
      <hr/>
    </div> 

     <div class="row" style="margin-bottom: 10px;">
      <div class="col-sm-6">
        
      </div>
      <div class="col-sm-6 text-right">
       
      </div>
    </div>

    <div class="row text-center" ng-app="" ng-controller="validateCtrl" style="margin-top: 5%; margin-bottom: 10%;">
	<div class="col-sm-12">
      <form name="razorpay-form" id="razorpay-form" action="<?php echo $return_url; ?>" method="POST">
          <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="" />
          <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $userid; ?>"/>
          <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $userid; ?>"/>
          <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="Product"/>
          <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo site_url(); ?>/razorpay/success"/>
          <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo site_url(); ?>/razorpay/failed"/>
          <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="ram"/>
          <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total; ?>"/>
          <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amt; ?>"/>
          <input type="hidden" name="save_amount" id="save_amount" value="<?php echo $save_amt; ?>"/>

      </form>
      <h4 class="heading_ram hidden" style="padding-bottom: 20px; color: red;">Complete your Registration by Paying the requisite fee, failing which your registration will be automatically cancelled.</h4>
      <h4 class="heading_ram" style="padding-bottom: 20px; color: red;">Please read these instructions carefully before making payment.</h4>

      <ul class="list" style="">
        <li>While entering your mobile number and email during fee payment, please use your same mobile number and email which you had filled in your form. Please reverify your mobile number and email on payment form again, as you will get confirmation of payment on your mobile and email only.</li>
        <li>If you have paid fee and amount has been deducted from your account, please do not fill admission form again or pay fee again. Please wait for few days. You can contact us for any clarification.</li>
        <li>If you have paid fee twice by mistake, your fee will be refunded in 5 to 15 working days automatically by payment gateway. You can contact us for any clarification.</li>
        <li>In case of refund, transaction charges will be deducted and rest amount shall be remitted to your account.</li>
        <li>If you have filled form and paid the fee, but you have not received any confirmation, please contact us.</li>
        <li>In case of any query/issue or related concern, you can <a href="contact" target="_blank">contact us.</a></li>
      </ul>

        <div class="col-sm-12 text-center" >

          <!--h4 class="heading_ram">Your enrollment id - 0000<?php echo $userid; ?></h4-->
          <div class="form-group has-feedback text-center" id="verify_otp">
              <input  id="submit-pay" type="submit" onclick="razorpaySubmit(this);" value="Pay <?php echo $amt; ?>/-" class="btn btn-primary btn-lg" />
          </div>
      </div>

<?php

if($this->session->userdata('amount')==1000)
{
  echo "<h4 class='' style='padding-bottom: 20px; color: blue;'>1000/- Admission Test Fee + 25/- Online Transaction Fee = Total 1025/-</h4>";
} 

if($this->session->userdata('amount')==500)
{
  echo "<h4 class='' style='padding-bottom: 20px; color: blue;'>500/- Admission Test Fee + 15/- Online Transaction Fee = Total 515/-</h4>";
}   
      

?>
    </div>
</div>
  </div>
</div>



<script src="<?=base_url();?>themes/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url();?>themes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  var razorpay_options = {
    key: "<?php echo $key_id; ?>",
    amount: "<?php echo $total; ?>",
    name: "<?php echo $name; ?>",
    description: "enrollment Id-0000<?php echo $userid;?>",
    netbanking: true,
    currency: "<?php echo $currency_code; ?>",
    prefill: {
      name:"<?php echo $card_holder_name; ?>",
      email: "<?php echo $email; ?>",
      contact: "<?php echo $phone; ?>"
    },
    notes: {
      soolegal_order_id: "<?php echo $merchant_order_id; ?>",
    },
    handler: function (transaction) {
        document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
        document.getElementById('razorpay-form').submit();
    },
    "modal": {
        "ondismiss": function(){
            location.reload()
        }
    }
  };
  var razorpay_submit_btn, razorpay_instance;

  function razorpaySubmit(el)
  {
    if(typeof Razorpay == 'undefined'){
      setTimeout(razorpaySubmit, 200);
      if(!razorpay_submit_btn && el){
        razorpay_submit_btn = el;
        el.disabled = true;
        el.value = 'Please wait...';  
      }
    } else {
      if(!razorpay_instance){
        razorpay_instance = new Razorpay(razorpay_options);
        if(razorpay_submit_btn){
          razorpay_submit_btn.disabled = false;
          razorpay_submit_btn.value = "Pay Now";
        }
      }
      razorpay_instance.open();
    }
  }  
</script>


</body>
</html>


