
<!DOCTYPE html>
<html lang="en"><html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Welcome to Indian Institute Of Tourism &amp; Travel Management</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <!-- <link rel="stylesheet" href="<?=base_url();?>themes/bower_components/bootstrap/dist/css/bootstrap.min.css" /> -->
  <!-- Font Awesome -->

  <!-- Ionicons -->

  <!-- Theme style -->
  


  <style type="text/css">


fieldset { 
   
    
  
}

legend {   
  
   
  
}  

  .form-group .require{color: red;}
  .form-group .glyphicon{color: #e4e4e4;}
  .form-group .fa{color: #e4e4e4;}
  th{background-color: #e4e4e4;}


.image-upload>input {
  display: none;
}

label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: normal;
}



.btn-default {
     background-color: #fff;
    color: #444;
    border-color: #ddd;
    border-radius: 0px;
    width: 100%;
}

.form-control {
  display: block;
  width: 100%;
  height: 20px;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.42857143;
  color: #555555;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccc;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
  transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
  transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
  transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
}


body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.42857143;
  color: #333333;
  background-color: #fff;
}
.row {
  margin-right: -15px;
  margin-left: -15px;
  width: 100%;

}

  .col-sm-12 {
    width: 100%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-11 {
    width: 91.66666667%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-10 {
    width: 83.33333333%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-9 {
    width: 75%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-8 {
    width: 66.66666667%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-7 {
    width: 58.33333333%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-6 {
    width: 50%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-5 {
    width: 41.66666667%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-4 {
    width: 33.33333333%;
  float:left;
  padding:0px;
  margin:0px;
  
  }
  .col-sm-3 {
    width: 25%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-2 {
    width: 16.66666667%;
  float:left;
  padding:0px;
  margin:0px;
  }
  .col-sm-1 {
    width: 8.33333333%;
  float:left;
  padding:0px;
  margin:0px;
  }

 table td{vertical-align:top;}


</style>
</head>
<body>

<div class="row">
  
<img src="<?php echo base_url()?>/themes/dist/img/head.jpg" style="width:100%;">
<div>
  
  <!-- <link rel="stylesheet" href="<?=base_url();?>themes/bower_components/bootstrap/dist/css/bootstrap.css" /> -->
  <table width="100%">
    <tr>
      <td align="center" > <h3><span style="font-size: 20px;">(Under Collaborative Scheme with JNU, New Delhi)</span><br/><b>BBA (Tourism & Travel) 2025-28</b></h3></td>
     
    </tr>
  </table>

    <div class="row text-center">

      <hr/>
    </div> 
  
<table width="100%" border="1" cellpadding="5">
<tr>
<td align="center" colspan="4"><h2><b>Thanks for Applying in IIAT 2025. Please find below, Information Filled by You.</b></h2></td>
</tr>


<tr>
<td align="center" colspan="4"><h2><b>Basic Details</b></h2></td>
</tr>

<tr>
<td><label>First Name</label>
<b><?php echo $users['first_name']; ?></b>
</td>
<td><label>Middle Name </label>

<b><?php echo $users['middle_name']; ?></b>
</td>
<td><label>Last Name</label>

<b><?php echo $users['last_name']; ?></b>

</td>

<td><label>Mobile Number</label>
<b><?php echo $users['mobile']; ?></b>
</td>
</tr>

<tr>
<td><label>Email Id </label>
<b><?php echo $users['email_id']; ?></b>

</td>


<td><label>Category </label>

<b><?php echo $users['category']; ?></b>

</td>

<td><label>Gender </label>

<b><?php echo $users['gender']; ?></b>

</td>

<td><label>Father's/Husband's Name</label>
<b><?php echo $users['father_name']; ?></b>
</td>

</tr>

<tr>
<td><label>Father's/Husband's Mobile Number </label>
<b><?php echo $users['father_mobile']; ?></b>

</td>


<td><label>Mother's Name </label>

<b><?php echo $users['mother_name']; ?></b>

</td>

<td><label>Mother's Mobile Number </label>

<b><?php echo $users['mather_mobile']; ?></b>

</td>

<td><label>Father's/Husband's Email Id </label>
<b><?php echo $users['father_email']; ?></b>
</td>

</tr>


<tr>
<td><label>Nationality </label>
<b><?php echo $users['nationality']; ?></b>

</td>


<td><label>Religion </label>

<b><?php echo $users['religion']; ?></b>

</td>

<td><label>DOB (dd-mm-yyyy) </label>

<b><?php echo date('d-m-Y', strtotime($users['dob'])); ?></b>

</td>
</tr>

<tr>
<td align="center" colspan="4"><h2><b>Permanent Address</b></h2></td>
</tr>


<tr>
<td><label>H.No/Apartment </label>
<b><?php echo $users['parma_appertment']; ?></b>

</td>


<td><label>Street/Village/Colony </label>

<b><?php echo $users['parma_colony']; ?></b>

</td>

<td><label>Postoffice/Area </label>

<b><?php echo $users['parma_area']; ?></b>

</td>

<td><label>Residence Phone </label>

<b><?php echo $users['parma_phone']; ?></b>

</td>
</tr>


<tr>
<td><label>State/U.T. </label>

<?php 
    $pstate_id = $users['parma_state'];
    $where_pid = "id='$pstate_id'";
    $rst_state = $this->db_lib->fetchRecord('states',$where_pid,'name');
?>

<b><?php echo $rst_state['name']; ?></b>

</td>


<td><label>District/City </label>


<?php 
    $pcity_id = $users['parma_city'];
    $where_cid = "id='$pcity_id'";
    $rst_city = $this->db_lib->fetchRecord('cities',$where_cid,'name');
?>


<b><?php echo $rst_city['name']; ?></b>

</td>

<td><label>Pincode </label>

<b><?php echo $users['parma_pincode']; ?></b>

</td>
</tr>


<tr>
<td align="center" colspan="4"><h2><b>Correspondence Address </b></h2></td>
</tr>

<tr>
<td><label>H.No/Apartment </label>
<b><?php echo $users['corre_appertment']; ?></b>

</td>


<td><label>Street/Village/Colony </label>

<b><?php echo $users['corre_colony']; ?></b>

</td>

<td><label>Postoffice/Area </label>

<b><?php echo $users['corre_area']; ?></b>

</td>

<td><label>Residence Phone </label>

<b><?php echo $users['corre_phone']; ?></b>

</td>
</tr>

<tr>
<td><label>State/U.T. </label>

<?php 
    $cstate_id = $users['corre_state'];
    $where_cstate_id = "id='$cstate_id'";
    $rst_c_state = $this->db_lib->fetchRecord('states',$where_cstate_id,'name');
?>

<b><?php echo $rst_c_state['name']; ?></b>

</td>


<td><label>District/City </label>

<?php 
    $corr_city_id = $users['corre_city'];
    $cid_whr = "id='$corr_city_id'";
    $city_rs = $this->db_lib->fetchRecord('cities',$cid_whr,'name');
?>

<b><?php echo $city_rs['name']; ?></b>

</td>

<td><label>Pincode </label>

<b><?php echo $users['corre_pincode']; ?></b>

</td>
</tr>

<tr>
<td align="center" colspan="4"><h2><b>Academic Details </b></h2></td>
</tr>


<tr>
<td><label>College </label>
<b><?php echo $users['academic_intermediate']; ?></b>

</td>


<td><label>University </label>

<b><?php echo $users['academic_board']; ?></b>

</td>

<td><label>Year of completion</label>

<b><?php echo $users['academic_year']; ?></b>

</td>

<td><label>Marks Obtained </label>

<b><?php echo $users['academic_mark_obt']; ?></b>

</td>
</tr>

<tr>
<td><label>Max. Marks </label>
<b><?php echo $users['academic_mark_max']; ?></b>

</td>


<td><label>Percentage Obtained</label>

<b><?php echo $users['academic_percentage']; ?>%</b>

</td>
</tr>
  
  
  <tr>
<td align="center" colspan="4"><h2><b>Entrance Test </b></h2></td>
</tr>

<tr>
<td><label>MAT </label>
<?php
    $user_id =$users['mobile_verified_id'];
    $where = "candidate_id = '$user_id' and score_name='mat'";
    $rst = $this->db_lib->fetchRecord('candidate_score_mba',$where,'*');
?>


Score : <b><?php echo $rst['score_marks']??0; ?></b> <br>
Exam Date : <b><?php echo $rst['score_year']??'' ? date('d-m-Y', strtotime($rst['score_year'])) : ''; ?></b> 

</td>


<td><label>CAT </label>

<?php
    $user_id =$users['mobile_verified_id'];
    $whereA = "candidate_id = '$user_id' and score_name='cat'";
    $rstA = $this->db_lib->fetchRecord('candidate_score_mba',$whereA,'*');
?>

Score : <b><?php echo $rstA['score_marks']??0; ?></b> <br>
Exam Date : <b><?php echo $rstA['score_year']??'' ? date('d-m-Y', strtotime($rstA['score_year'])) : ''; ?></b> 

</td>

<td><label>CMAT </label>

<?php
    $user_id =$users['mobile_verified_id'];
    $whereB = "candidate_id = '$user_id' and score_name='cmat'";
    $rstB = $this->db_lib->fetchRecord('candidate_score_mba',$whereB,'*');
?>

Score : <b><?php echo $rstB['score_marks']??0; ?></b> <br>
Exam Date : <b><?php echo $rstB['score_year']??'' ? date('d-m-Y', strtotime($rstB['score_year'])) : ''; ?></b> 

</td>


<td><label>XAT </label>

<?php
   $user_id =$users['mobile_verified_id'];
    $whereC = "candidate_id = '$user_id' and score_name='xat'";
    $rstC = $this->db_lib->fetchRecord('candidate_score_mba',$whereC,'*');
?>

Score : <b><?php echo $rstC['score_marks']??0; ?></b> <br>
Exam Date : <b><?php echo $rstC['score_year']??'' ? date('d-m-Y', strtotime($rstC['score_year'])) : ''; ?></b> 

</td>

</tr>

<tr>
<td><label>GMAT </label>

<?php
    $user_id =$users['mobile_verified_id'];
    $whereD = "candidate_id = '$user_id' and score_name='gmat'";
    $rstD = $this->db_lib->fetchRecord('candidate_score_mba',$whereD,'*');
?>

Score : <b><?php echo $rstD['score_marks']??0; ?></b> <br>
Exam Date : <b><?php echo $rstD['score_year']??'' ? date('d-m-Y', strtotime($rstD['score_year'])) : ''; ?></b> 

</td>


<td><label>ATMA </label>

<?php
    $user_id =$users['mobile_verified_id'];
    $whereE = "candidate_id = '$user_id' and score_name='atma'";
    $rstE = $this->db_lib->fetchRecord('candidate_score_mba',$whereE,'*');
?>



Score : <b><?php echo $rstE['score_marks']??0; ?></b> <br>
Exam Date : <b><?php echo $rstE['score_year']??'' ? date('d-m-Y', strtotime($rstE['score_year'])) : ''; ?></b> 

</td>
  
  
  <td><label>CUET </label>

<?php
    $user_id =$users['mobile_verified_id'];
    $whereE = "candidate_id = '$user_id' and score_name='cuet'";
    $rstE = $this->db_lib->fetchRecord('candidate_score_mba',$whereE,'*');
?>



Score : <b><?php echo $rstE['score_marks']??0; ?></b> <br>
Exam Date : <b><?php echo $rstE['score_year']??'' ? date('d-m-Y', strtotime($rstE['score_year'])) : ''; ?></b> 

</td>
  
</tr>

<!--tr>
<td align="center" colspan="4"><h2 style='margin:0px; padding:0px;'><b>Examination Centre for Appearing </b></h2>In order of your preference</td>
</tr>

<tr>
<td><label> Centre 1 </label>
<b><?php echo $users['appearing_center_1']; ?></b>

</td>


<td><label> Centre 2 </label>

<b><?php echo $users['appearing_center_2']; ?></b>

</td>

<td><label> Centre 3 </label>

<b><?php echo $users['appearing_center_3']; ?></b>

</td>

<td><label> Centre 4 </label>

<b><?php echo $users['appearing_center_4']; ?></b>

</td>
</tr-->


<tr>
<td align="center" colspan="4"><h2 style='margin:0px; padding:0px;'><b>Centre for Appearing in GD/PI </b></h2>In order of your preference</td>
</tr>

<tr>
<td><label> Centre 1 </label>
<b><?php echo $users['gdpi_center_1']; ?></b>

</td>


<td><label> Centre 2 </label>

<b><?php echo $users['gdpi_center_2']; ?></b>

</td>

<td><label> Centre 3 </label>

<b><?php echo $users['gdpi_center_3']; ?></b>

</td>

<td><label> Centre 4 </label>

<b><?php echo $users['gdpi_center_4']; ?></b>

</td>
</tr>


<tr>
<td align="center" colspan="4"><h2 style='margin:0px; padding:0px;'><b>Preference for Study Centre </b></h2>In order of your preference</td>
</tr>

<tr>
<td><label> Centre 1 </label>
<b><?php echo $users['study_centre_1']; ?></b>

</td>


<td><label> Centre 2 </label>

<b><?php echo $users['study_centre_2']; ?></b>

</td>

<td><label> Centre 3 </label>

<b><?php echo $users['study_centre_3']; ?></b>

</td>

<td><label> Centre 4 </label>

<b><?php echo $users['study_centre_4']; ?></b>

</td>
</tr>


<tr>
<td align="center" colspan="4"><h2><b> </b></h2></td>
</tr>

<tr>
<td><label> Candidate Signature </label></td>
<td>
<b><img src="<?php echo base_url()."/uploads/BBA/".$users['candidate_signature'] ?>" width="100"></b>

</td>


</tr>

<tr>
<td>
<label> Candidate Photo </label></td>
<td><img src="<?php echo base_url()."/uploads/BBA/".$users['candidate_photo'] ?>" width="100"></td></tr>

</table>

<br/><br/>

<?php
    $get_user = $users['mobile_verified_id'];
    $whereE = "user_id = '$get_user'";
    $rstE = $this->db_lib->fetchRecord('user_master',$whereE,'*');
?>

<?php 
   if($rstE['razorpay_trans_id'] !="withoutfee")
   {
  $gdate = date('d-m-Y', strtotime($users['post_date']));
  if($users['category'] == 'General'|| $users['category'] == 'OBC'|| $users['category'] == 'EWS'|| $users['category'] =='PWD') {$fee= '1000/-';} else{$fee='500/-';}  
    echo "<table style='width:500px' class='table table-bordred' align='center' border='1' BORDERCOLOR='#e4e4e4'>
          <tr><td colspan='2' class='text-center' style='background-color: #e4e4e4'>E-Receipt (Candidate copy)</td></tr>
          <tr>
            <td>Registration Number</td>
            <td>0000 {$rstE['user_id']}</td>
          </tr>

          <tr>
            <td>Transaction Number</td>
            <td>{$rstE['razorpay_trans_id']}</td>
          </tr>

           <tr>
            <td>Date of Registration</td>
            <td>$gdate</td>
          </tr>

          <tr>
            <td>Transaction Amount(Rs)</td>
            <td>$fee</td>
          </tr>

          <tr>
            <td>Transaction Status</td>
            <td>Success</td>
          </tr>
      </table>";
   }
  else
  {
    $gdate = date('d-m-Y', strtotime($users['post_date']));
     echo "<table style='width:500px' class='table table-bordred' align='center' border='1' BORDERCOLOR='#e4e4e4'>
          <tr><td colspan='2' class='text-center' style='background-color: #e4e4e4'>E-Receipt (Candidate copy)</td></tr>
          <tr>
            <td>Registration Number</td>
            <td>0000 {$rstE['user_id']}</td>
          </tr>

           <tr>
            <td>Date of Registration</td>
            <td>$gdate</td>
          </tr>

      </table>";
  }

?>


</div>
</body>
</html>