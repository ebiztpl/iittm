<?php 
  $userid = $this->session->userdata('user_id');
  $dwn_status = $download_status['download_status'];
  $course_id = $download_status['course_id'];
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
  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body>
<div class="main" ng-app="myApp"  ng-controller="validateCtrl">
  <div class="container container_bg">
    
    <div class="row">
      <img src="<?=base_url();?>themes/dist/img/head.jpg" width="100%" />
    </div>

    <div class="row text-center">
      <h3><b>Online Admission for BBA(TT/2022-25) & MBA(TTM/2022-24)</b></h3>
      <hr/>
    </div> 

    <div class="row">
      <div class="col-sm-4 col-sm-offset-4">
        <label>Select Course*</label>
        <select class="form-control required" required="" id="course">
          <option value="">--Select--</option>
          <option value="1">BBA(TT)-2022-25</option>
          <option value="2">MBA(TTM)-2022-24</option>
        </select>
      </div>

    </div>
    
    <div class="row"><hr/></div>

     <form action="admission_form" method="post" id="BBA_guidline" name="LoginForm">
    <div class="row">
     
      <div class="col-sm-12">
        <h4 class="heading_ram">ELIGIBILITY FOR ADMISSION:</h4>
        <p style="font-size:16px;">Candidates satisfying the following criteria are eligible to apply for the BBA (TT) Programme:</p>
        <ul class="list">

          <li>The candidates seeking admission to BBA(Tourism & Travel) program shall not be more than 22 years as on 1-July-2022 for UR/OBC. (5 years of relaxation to the candidates from SC/ST category will be given).
          </li>
          <li>Candidates seeking admission in BBA (TT) programme shall be required to possess 10 + 2 examinations in any subject from a recognized University / Board with at least 50% marks (45% marks for SC / ST).</li>
          <li>Candidates appearing in final year examination of 10+ 2 are also eligible to apply, subject to they must submit their result of 12th class with the requisite percentage of marks by August 31, 2022, failing which their admission will be cancelled and course fee deposited in the institute, will also be forfeited. (In this regard, the student must submit an affidavit on Non judicial stamp paper of Rs.50/-).</li>



          
        </ul>
        <br/>

        <h4 class="heading_ram">Selection Procedure:</h4>
        <p style="font-size:16px;">The candidates meeting the eligibility criteria will have to clear the entrance examination of IITTM. The entrance exam will be a 2-step process:</p>
        <ul class="list">
        <li>A written exam - In this, a candidate has to write their answers on OMR Sheet. 
It will be an objective type test with four options of nearest answers carrying 100 questions / 100 marks </li>

<li>It will consist of: [General Awareness (50 Marks), Verbal ability (25 Marks), and Quantitative ability (25 marks)]. One mark for each right answer and no negative marking for the wrong answer.</li>

        <li>GD & PI - Shortlisted candidates will be required to appear for GD and PI at any one of the IITTM centers mentioned below. The candidates have to select and mark the test center of their choice in the admission form itself.
          <ul>
            <li>IITTM Bhubaneswar </li>
           <li>IITTM Gwalior </li>
           <li>IITTM Nellore </li>
           <li>IITTM Noida</li>
          </ul>
          </li>
        </ul>

       
       <h4 class="heading_ram" style='color:red;'>Note:</h4> 
        <ul class="list">
        <li>Candidates must carry all the original documents for verification before being allowed for the GD and PI.</li>
        <li>IITTM Management reserves the right to decide the eligibility conditions in terms of equivalence, percentage marks, and the recognition of the qualifying examination, intake etc. </li>
        </ul>
        <p style="font-size:16px; font-weight:bold;">On selecting the checkbox below, the course brochure would be downloaded. It is mandatory to read the brochure carefully for detailed guidelines and eligibility for admissions before proceeding further.</p>
      
      <hr/>

      <div class="" style="margin-bottom: 10px; padding-top:0px;">

      <div class="col-sm-10">
        <input type="checkbox" required="" class="chekce" >&nbsp; I have downloaded and read the course brochure and guidelines, and I agree with all the terms and conditions mentioned in them. 
      </div>
      <div class="col-sm-2 text-right">
        <button class="btn btn-primary">Next <i class="fa fa-arrow-circle-o-right"></i></button>
      </div>
      </div>
    </div>
    </div>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>In case of any query/issue or related concern, you can <a href="contact" target="_blank">contact us</b></a>.  
    <br/><br/>
    </form>


    <form action="admission_form_mba" method="post" id="MBA_guidline" name="LoginForm">
  
   <div class="row">
      
      <div class="col-sm-12">
         <h4 class="heading_ram">ELIGIBILITY FOR ADMISSION:</h4>
        <ul class="list">
          <li>Candidates seeking admission to MBA (TTM) programme shall be required to possess a Bachelor degree from a recognized Indian or foreign university (as per the AIU foreign equivalence list) having secured a minimum of 50% aggregate in case of General and OBC categories and 45% in case of candidates belonging to SC/ST categories are eligible to apply.
          </li>

          <li>
          Note: If the seats reserved for SC/ST remain vacant, then the same will be filled by the SC/ST candidates who appear for entrance exam irrespective of their ranking in the exam. Candidates appearing in final year examination of graduation are also eligible to apply, subject until he/she must submit their result of graduation with the requisite percentage of marks by 30/September/2022, failing which their admission will be cancelled and course fee deposited in the institute will also be forfeited. (In this regard, the student must submit an affidavit on Non judicial stamp paper of Rs.50/-).
          </li>

  <li>
    Must appear in any of the following Management Entrance Test and submit a valid score card between June 1, 2021, to May 31, 2023):
    <ul>
      <li>MAT (Management Aptitude Test) conducted by AIMA (All India Management Association) [http://www.aima.in]</li>
      <li>CAT (Common Admission Test) conducted by IIMs (Indian Institutes of Management) [https://iimcat.ac.in]</li>
      <li>CMAT (Common Management Admission Test) conducted by AICTE (All India Council for Technical Education) [www.aicte-cmat.in]</li>
      <li>XAT (Xavier Aptitude Test) conducted by XLRI (formerly known as Xavier Labour Relations Institute) [http://www.xatonline.net.in]</li>
      <li>GMAT (Graduate Management Admission Test) conducted by GMAC (Graduate Management Admission Council) [http://www.mba.com]</li>
      <li>ATMA (AIMS Test for Management Admissions) conducted by AIMS (Association of Indian Management Schools) [http://www.atmaaims.com]</li>
      <li><b>Appear in written test “IGNTU IITTM Admission Test (IIAT)” to be conducted by IGNTU & IITTM. Admission Test will be held on June 7, 2022 (Sunday) (tentative) from 10:00 am to 12:00pm at IITTM centres and other centres across the country.
      <span>The candidate has to write their answers on OMR Sheet. It will be an objective type test with four options of nearest answers carrying 100 questions /100 marks [General Awareness (50 Marks), Verbal ability (25 Marks) and Quantitative ability (25 marks)]. One mark for each right answer and no negative marking for wrong answer.</b></span>  
      </li>
    </ul>

    </li>

      <li>Group Discussion And Personal Interview:<br/>
        Short-listed candidates will be required to appear for GD and PI at any one of the IITTM centres, which they have to mark in the admission form:
        <ul>
          <li>IITTM Bhubaneswar</li>
          <li>IITTM Gwalior</li>
          <li>IITTM Nellore</li>
          <li>IITTM Noida</li>
		  <li>IITTM NIWS GOA</li>
        </ul>
       
      </li>

        </ul>
      
<h4 class="heading_ram" style='color:red;'>Note:</h4> 
        <ul class="list">
        <li>Candidates must carry all the original documents for verification before being allowed for the GD and PI.</li>
        <li>IITTM Management reserves the right to decide the eligibility conditions in terms of equivalence, percentage marks, and the recognition of the qualifying examination, intake etc. </li>
        </ul>
        <p style="font-size:16px; font-weight:bold;">On selecting the checkbox below, the course brochure would be downloaded. It is mandatory to read the brochure carefully for detailed guidelines and eligibility for admissions before proceeding further.</p>

      <hr/>

      <div class="" style="margin-bottom: 10px; padding-top:0px;">

      <div class="col-sm-10">
        <input type="checkbox" required="" class="chekce" >&nbsp; I have downloaded and read the course brochure and guidelines, and I agree with all the terms and conditions mentioned in them. 
      </div>
      <div class="col-sm-2 text-right">
        <button class="btn btn-primary">Next <i class="fa fa-arrow-circle-o-right"></i></button>
      </div>



      </div>
      


      

    </div>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>In case of any query/issue or related concern, you can <a href="contact" target="_blank">contact us</b></a>.       
<br/><br/>


</form>
      
  </div>









</div>

<!-- <script src="<?=base_url();?>themes/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url();?>themes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<!-- <script src="<?=base_url();?>themes/plugins/iCheck/icheck.min.js"></script> -->
<script>
  /*$(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' 
    });
  });*/


function downloadFile(filePath){
    var link=document.createElement('a');
    link.href = filePath;
    link.download = filePath.substr(filePath.lastIndexOf('/') + 1);
    link.click();
}
  
var App = angular.module('myApp', []); 
function validateCtrl($scope,$log,$http)
{

  $('.chekce').on('click', function(event) {
    var userid = '<?php echo $userid ?>';
    if($("#course").val()=="")
    {
        alert('Select any Course');
        $("#course").focus();
        return false;
    }
    else
    {

      $('.chekce').attr('disabled','disabled');
      $('#course').attr('disabled','disabled');
      var course = $("#course").val();

      $http({
      method: "post",
      url: "<?php echo site_url('criteria/download');?>",
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      data : $.param({userid:userid,course:course})
      }).then(function(response){
            if(response.data==1)
            {
              var cours_id = $("#course").val();
              if(cours_id == 1){var url= "<?php echo base_url('uploads/BBA.pdf');?>";}
              if(cours_id == 2){var url= "<?php echo base_url('uploads/MBA.pdf');?>";}
              //window.location.href = url;
              //window.open(url,'Download');
              downloadFile(url);
            }
          });  
    }

  });

     

}


  $(document).ready(function(){
    $("#MBA_guidline").hide();
    $("#BBA_guidline").hide();


    var dwn_status = '<?php echo $dwn_status ?>';
    var corse_id = '<?php echo $course_id; ?>';
    if(dwn_status==1){
      $('.chekce').attr('checked',true);
      $("#course option").filter(function() { return this.value == '<?php echo $course_id; ?>' }).prop('selected', true);
      $('.chekce').attr('disabled','disabled');
      $('#course').attr('disabled','disabled');
      if(corse_id == 1)
      {
        $("#BBA_guidline").show();
      }
       
      if(corse_id == 2)
      {
        $("#MBA_guidline").show();
      }
       
      
    }


  });

  $("#course").change(function(){
    var id = $(this).val();
    if(id == 1){$("#BBA_guidline").show(); $("#MBA_guidline").hide();}
    if(id == 2){$("#MBA_guidline").show(); $("#BBA_guidline").hide();}
  });

</script>

</body>
</html>
