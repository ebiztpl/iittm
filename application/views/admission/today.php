<?php
$userid = $this->session->userdata('user_id');
$course_id = $download_status['course_id'];
$number = $download_status['user_mobile'];
?>

<!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" /> -->
 <?php // Initializing form
            $lFormAttrb = array(
              'role' => 'form',
              'id' => 'LoginForm',
              'name'=>'LoginForm',
              'method' => 'POST',
              'novalidate'=>'novalidate',
              'ng-submit'=> 'login_check($event)',
              'enctype'=> 'multipart/form-data'
            );
            echo form_open('',$lFormAttrb); 
          ?>  

<div class="main">

      


  <div class="container container_bg">
    
    <div class="row">
      <img src="<?=base_url();?>themes/dist/img/head.jpg" width="100%" />
    </div>

    <div class="row text-center">
      <h3><b>Online For Admission in BBA (Tourism & Travel) 2020-23</b> <br/><span style="font-size: 20px;">(under collaborative scheme)</span></h3>
      <hr/>
    </div> 



    <div class="row"  style="margin-top: 1%; margin-bottom: 10%;">

      

        <fieldset class="form_disable">
          <legend>Basic Details</legend>
          
        <div class="row">
        

        <div class="col-sm-10" style="padding-right: 0px;">
        <div class="row">
          <div class="col-sm-12" style="padding-right: 0px;">

           <div class="col-sm-3">
             <div class="form-group has-feedback">
                <label>Select Course<span class="require">*</span></label>
                <select class="form-control required" name="course" required="" id="course" disabled="">
                  <option value="">--Select--</option>
                  <option value="1">BBA(TT)-2020-23</option>
                  <option value="2">MBA(TTM)-2020-22</option>
                </select>
              </div>
           </div> 

           <div class="col-sm-3">
             <div class="form-group has-feedback">
                <label>Name(as per 10<sup>th</sup> marksheet)<span class="require">*</span></label>
                <input type="text" class="form-control" name="fname" id="fname" autocomplete="off" ng-model="fname" required="">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

                <span style="color:red" ng-show="LoginForm.fname.$dirty && LoginForm.fname.$invalid || LoginForm.$submitted && LoginForm.fname.$invalid">
                  <span ng-show="LoginForm.fname.$error.required">field is required.</span>
                </span> 

              </div>
           </div> 

           <div class="col-sm-3">
             <div class="form-group has-feedback">
                <label>Middle (as per 10<sup>th</sup> marksheet)</label>
                <input type="text" class="form-control" name="mname" id="mname">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
           </div> 

           <div class="col-sm-3">
             <div class="form-group has-feedback">
                <label>Last Name (as per 10<sup>th</sup> marksheet)<span class="require">*</span></label>
                <input type="text" class="form-control" name="lname" id="lname" autocomplete="off" ng-model="lname" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                 <span style="color:red" ng-show="LoginForm.lname.$dirty && LoginForm.lname.$invalid || LoginForm.$submitted && LoginForm.lname.$invalid">
                  <span ng-show="LoginForm.lname.$error.required">field is required.</span>
                </span> 
              </div>
           </div> 

         </div>
       </div>

        <div class="row">
          <div class="col-sm-12" style="padding-right: 0px;">

            <div class="col-sm-3">
             <div class="form-group has-feedback">
              <label>Mobile No.<span class="require">*</span></label>
              <span class="fa fa-phone form-control-feedback"></span>
               <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo $number; ?>" autocomplete="off" disabled="">
             </div>
           </div>

           <div class="col-sm-3">
             <div class="form-group has-feedback">
              <label>Email Id.<span class="require">*</span></label>
              <span class="fa fa-envelope form-control-feedback" ></span>
               <input type="text" class="form-control" name="txt_email" id="txt_email" autocomplete="off" ng-pattern="/^[a-z0-9]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/" ng-model="txt_email" required="">
              <span style="color:red" ng-show="LoginForm.txt_email.$dirty && LoginForm.txt_email.$invalid || LoginForm.$submitted && LoginForm.txt_email.$invalid">
                  <span ng-show="LoginForm.txt_email.$error.required">field is required.</span>
                  <span ng-show="LoginForm.txt_email.$invalid" ng-hide="LoginForm.txt_email.$error.required">Invalid email </span>
                </span> 
             </div>
           </div>


          <div class="col-sm-3">
           <div class="form-group has-feedback">
              <label>DOB<span> (As per 10<sup>th</sup> marksheet)</span><span class="require">*</span></label><br/>
                <input type="date" id="birth_date" class="form-control" name="txt_dob" onblur="ageCalculate()" autocomplete="off" ng-model="txt_dob">
                 <span class="fa fa-calendar form-control-feedback"></span>
                <span id="age" style="font-weight: bold;"></span>

                 <span style="color:red" ng-show="LoginForm.txt_dob.$dirty && LoginForm.txt_dob.$invalid || LoginForm.$submitted && LoginForm.txt_dob.$invalid">
                  <span ng-show="LoginForm.txt_dob.$error.required">field is required.</span>
                  <span ng-show="LoginForm.txt_dob.$invalid" ng-hide="LoginForm.txt_dob.$error.required">Invalid email </span>
                </span> 
            </div>
         </div>

         <div class="col-sm-3">
           <div class="form-group has-feedback">
              <label>Gender<span class="require">*</span></label><br/>
              <input type="radio" class="" name="gender" id="gender" ng-model="gender" value="Male" required=""  />
              Male &nbsp;
              <input type="radio" class="" name="gender" id="gender" ng-model="gender" value="Female" required=""  />
              Female
              &nbsp;
              <input type="radio" class="" name="gender" id="gender" ng-model="gender" value="Other" required=""  />
              Other
             <br/>
              <span style="color:red" ng-show="LoginForm.gender.$dirty && LoginForm.gender.$invalid || LoginForm.$submitted && LoginForm.gender.$invalid">
                  <span ng-show="LoginForm.gender.$error.required">field is required.</span>
                </span> 

            </div>
         </div>  

          </div>
        </div>





       <div class="row">
          <div class="col-sm-12" style="padding-right: 0px;">

            <div class="col-sm-3">
           <div class="form-group has-feedback">
              <label>Father's/Husband's Name<br/>(as per 10<sup>th</sup> marksheet)<span class="require">*</span></label>
              <input type="text" class="form-control" name="fathername" id="fathername" autocomplete="off" ng-model="fathername" required>
              <span class="glyphicon glyphicon-user form-control-feedback" style="padding-top: 20px;"></span>
              <span style="color:red" ng-show="LoginForm.fathername.$dirty && LoginForm.fathername.$invalid || LoginForm.$submitted && LoginForm.fathername.$invalid">
                  <span ng-show="LoginForm.fathername.$error.required">field is required.</span>
              </span>  

            </div>
         </div> 

         
          <div class="col-sm-3">
          <div class="form-group has-feedback">
          <label>Father's/Husband's <br/>Mobile Number<span class="require">*</span></label>
          <input type="text" class="form-control" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="10" id="father_mobile" name="father_mobile" ng-model="father_mobile" required="" autocomplete="off">
           <span class="fa fa-phone form-control-feedback" style="padding-top: 20px;"></span>
           <span style="color:red" ng-show="LoginForm.father_mobile.$dirty && LoginForm.father_mobile.$invalid || LoginForm.$submitted && LoginForm.father_mobile.$invalid">
                  <span ng-show="LoginForm.father_mobile.$error.required">field is required.</span>
                  <span ng-show="LoginForm.father_mobile.$invalid" ng-hide="LoginForm.father_mobile.$error.required">Invalid mobile number.</span>
           </span>  
               
          </div>
         </div>

           <div class="col-sm-3">
           <div class="form-group has-feedback">
              <label>Mother's Name<br/>(as per 10<sup>th</sup> marksheet)<span class="require">*</span></label>
              <input type="text" class="form-control" name="mothername" id="mothername" autocomplete="off" ng-model="mothername" required>
              <span class="glyphicon glyphicon-user form-control-feedback" style="padding-top: 20px;"></span>

               <span style="color:red" ng-show="LoginForm.mothername.$dirty && LoginForm.mothername.$invalid || LoginForm.$submitted && LoginForm.mothername.$invalid">
                  <span ng-show="LoginForm.mothername.$error.required">field is required.</span>
           </span>  
            </div>
         </div>


      <div class="col-sm-3">
           <div class="form-group has-feedback">
              <label>Mother's<br/>Mobile Number<span class="require">*</span></label>
              <input type="text" class="form-control" name="mother_mobile" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="10" id="mother_mobile" autocomplete="off" ng-model="mother_mobile" required>
              <span class="glyphicon glyphicon-user form-control-feedback" style="padding-top: 20px;"></span>
               <span style="color:red" ng-show="LoginForm.mother_mobile.$dirty && LoginForm.mother_mobile.$invalid || LoginForm.$submitted && LoginForm.mother_mobile.$invalid">
                  <span ng-show="LoginForm.mother_mobile.$error.required">field is required.</span>
                  <span ng-show="LoginForm.mother_mobile.$invalid" ng-hide="LoginForm.mother_mobile.$error.required">Invalid mobile number.</span>
           </span>
            </div>
         </div>

       

          </div>
       </div>


       </div>

       <div class="col-sm-2 text-center">
        <div class="image-upload" style="margin-top: 20px;">
          <label for="file-input">
            <img src="<?=base_url();?>/themes/dist/img/placeholder.png" width="100%" style="cursor: pointer;" id="img-pic" />
          </label>
          <input id="file-input" name="file" type="file" ng-model="file" accept="image/gif, image/jpeg, image/png" onchange="readURL(this);"  /><br/>
           <span style="color:red" ng-show="LoginForm.file.$dirty && LoginForm.file.$invalid || LoginForm.$submitted && LoginForm.file.$invalid">
                  <span ng-show="LoginForm.file.$error.required">field is required.</span>
           </span>
        </div>
    
        <span style="font-size: 20px;">Admission Fees <br/><i class="fa fa-inr"></i> <span id="fee_amt"></span></span>
       </div>

    </div>

    <div class="row">
        <div class="col-sm-12">


            <div class="col-sm-3">
          <div class="form-group has-feedback">
          <label>Father's/Husband's Email Id<span class="require">*</span></label>
          <input type="text" class="form-control" required="" ng-pattern="/^[a-z0-9]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/" name="father_email" autocomplete="off" ng-model="father_email" required>
           <span class="fa fa-envelope form-control-feedback" ></span>
           <span style="color:red" ng-show="LoginForm.father_email.$dirty && LoginForm.father_email.$invalid || LoginForm.$submitted && LoginForm.father_email.$invalid">
                  <span ng-show="LoginForm.father_email.$error.required">field is required.</span>
                  <span ng-show="LoginForm.father_email.$invalid" ng-hide="LoginForm.father_email.$error.required">Invalid email </span>
                </span>
          </div>
         </div>

         <div class="col-sm-2">
           <div class="form-group has-feedback">
              <label>Nationality</span><span class="require">*</span></label><br/>
              <select class="form-control" data-show-subtext="true" data-live-search="true" name="nationality" id="nationality" ng-model="nationality" required="">
                <option value="">--Select--</option>
                <option value="Afghan">Afghan</option>
                <option value="Albanian">Albanian</option>
                <option value="Algerian">Algerian</option>
                <option value="Argentine">Argentine</option>
                <option value="Argentinian">Argentinian</option>
                <option value="Australian">Australian</option>
                <option value="Austrian">Austrian</option>
                <option value="Bangladeshi">Bangladeshi</option>
                <option value="Belgian">Belgian</option>
                <option value="Bolivian">Bolivian</option>
                <option value="Batswana">Batswana</option>
                <option value="Brazilian">Brazilian</option>
                <option value="Bulgarian">Bulgarian</option>
                <option value="Cambodian">Cambodian</option>
                <option value="Cameroonian">Cameroonian</option>
                <option value="Canadian">Canadian</option>
                <option value="Chilean">Chilean</option>
                <option value="Chinese">Chinese</option>
                <option value="Colombian">Colombian</option>
                <option value="Costa Rican">Costa Rican</option>
                <option value="Croatian">Croatian</option>
                <option value="Cuban">Cuban</option>
                <option value="Czech">Czech</option>
                <option value="Danish">Danish</option>
                <option value="Dominican">Dominican</option>
                <option value="Ecuadorian">Ecuadorian</option>
                <option value="Egyptian">Egyptian</option>
                <option value="Salvadorian">Salvadorian</option>
                <option value="English">English</option>
                <option value="Estonian">Estonian</option>
                <option value="Ethiopian">Ethiopian</option>
                <option value="Fijian">Fijian</option>
                <option value="Fijian">Fijian</option>
                <option value="French">French</option>
                <option value="German">German</option>
                <option value="Ghanaian">Ghanaian</option>
                <option value="Greek">Greek</option>
                <option value="Guatemalan">Guatemalan</option>
                <option value="Haitian">Haitian</option>
                <option value="Honduran">Honduran</option>
                <option value="Hungarian">Hungarian</option>
                <option value="Icelandic">Icelandic</option>
                <option value="Indian">Indian</option>
                <option value="Indonesian">Indonesian</option>
                <option value="Iranian">Iranian</option>
                <option value="Italian">Italian</option>
                <option value="Jamaican">Jamaican</option>
                <option value="Japanese">Japanese</option>
                <option value="Kuwaiti">Kuwaiti</option>
              </select>
            
               <span style="color:red" ng-show="LoginForm.nationality.$dirty && LoginForm.nationality.$invalid || LoginForm.$submitted && LoginForm.nationality.$invalid">
                <span ng-show="LoginForm.nationality.$error.required">field is required.</span>
              </span>
               
            </div>
         </div>

         <div class="col-sm-2">
           <div class="form-group has-feedback">
              <label>Religion</span><span class="require">*</span></label><br/>
              <select class="form-control" data-show-subtext="true" data-live-search="true" name="religion" id="religion" ng-model="religion" required="">
                <option value="">--Select--</option>
                <option>Christianity </option>
                <option>Islam </option>
                <option>Nonreligious </option>
                <option>Hinduism </option>
                <option>Chinese</option>
                <option>Buddhism</option>
                <option>Primal-indigenous</option>
                <option>African </option>
                <option>Sikhism </option>
                <option>Juche</option>
               </select>
                <span style="color:red" ng-show="LoginForm.religion.$dirty && LoginForm.religion.$invalid || LoginForm.$submitted && LoginForm.religion.$invalid">
                <span ng-show="LoginForm.religion.$error.required">field is required.</span>
              </span>
               
            </div>
         </div>

         <div class="col-sm-5">
          <div class="form-group">
            <label>Category<span class="require">*</span></label><br/>
            <input type="radio" class="" name="category" value="General"  ng-model="category" required=""> &nbsp;General &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" class="" name="category" value="OBC" ng-model="category" required=""> &nbsp;OBC &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" class="" name="category" value="SC/ST" ng-model="category" required=""> &nbsp;SC/ST &nbsp;&nbsp;&nbsp;
            <input type="radio" class="" name="category" value="EWS" ng-model="category" required=""> &nbsp;EWS &nbsp;&nbsp;&nbsp;
            <input type="radio" class="" name="category" value="PWD" ng-model="category" required=""> &nbsp;PWD &nbsp;&nbsp;&nbsp;&nbsp;
            <br/>
             <span style="color:red" ng-show="LoginForm.category.$dirty && LoginForm.category.$invalid || LoginForm.$submitted && LoginForm.category.$invalid">
                  <span ng-show="LoginForm.category.$error.required">field is required.</span>
                </span>
          </div>
         </div>


       </div>
     </div>

 </fieldset>

     

<fieldset class="form_disable">
  <legend>Permanent Address</legend>

   <div class="row">
        <div class="col-sm-12">

         <div class="col-sm-3">
          <div class="form-group">
          <label>H.No/Apartment</label>
          <input type="text" class="form-control" name="parma_apartment" id="parma_apartment">
          </div>
         </div>

         <div class="col-sm-3">
          <div class="form-group">
          <label>Street/Village/Colony</label>
          <input type="text" class="form-control" id="parma_colony" name="parma_colony">
        </div>
         </div>

         <div class="col-sm-3">
          <div class="form-group">
          <label>Postoffice/Area</label>
          <input type="text" class="form-control" id="parma_area" name="parma_area">
        </div>
         </div>

          <div class="col-sm-3">
          <div class="form-group">
          <label>Residence Phone</label>
          <input type="text" class="form-control" name="parma_resi_phone" id="parma_resi_phone">
          </div>
         </div>


       </div>
     </div>

      <div class="row">
        <div class="col-sm-12">

          <div class="col-sm-3">
          <div class="form-group">
          <label>State/U.T.<span class="require">*</span></label>
          
          <select class="form-control" data-show-subtext="true" data-live-search="true" name="parma_state" id="parma_state" ng-change="city_get()" ng-model="parma_state" required="">
            <option value="" >--Select--</option>
            <?php
              foreach($state_list as $name) { ?>
                <option value="<?= $name['id'] ?>"><?= $name['name'] ?></option>
            <?php
              } ?>
          </select>

          <span style="color:red" ng-show="LoginForm.parma_state.$dirty && LoginForm.parma_state.$invalid || LoginForm.$submitted && LoginForm.parma_state.$invalid">
                <span ng-show="LoginForm.parma_state.$error.required">field is required.</span>
              </span>

          </div>
         </div>


     

       
          <div class="col-sm-3">
          <div class="form-group">
          <label>District/City<span class="require">*</span></label>
            <select id="parma_city" name="parma_city" class="form-control" ng-model="parma_city" required="">
              <option value="">--Select City--</option>
            </select>

            <span style="color:red" ng-show="LoginForm.parma_city.$dirty && LoginForm.parma_city.$invalid || LoginForm.$submitted && LoginForm.parma_city.$invalid">
                <span ng-show="LoginForm.parma_city.$error.required">field is required.</span>
            </span>

          </div>
         </div>

          <div class="col-sm-3">
          <div class="form-group">
          <label>Pincode<span class="require">*</span></label>
          <input type="text" class="form-control" name="parma_pincode" id="parma_pincode" ng-model="parma_pincode" required="">
           
           <span style="color:red" ng-show="LoginForm.parma_pincode.$dirty && LoginForm.parma_pincode.$invalid || LoginForm.$submitted && LoginForm.parma_pincode.$invalid">
                <span ng-show="LoginForm.parma_pincode.$error.required">field is required.</span>
            </span>
 

          </div>
         </div>

       </div>
     </div>

</fieldset>


<fieldset class="form_disable">
  <legend>Correspondence Address <br/><span style="font-size: 12px;"><input type="checkbox" name="address_chk" class="address_chk"> Same as Parmanent Address</span></legend>

   <div class="row">
        <div class="col-sm-12">

         <div class="col-sm-3">
          <div class="form-group">
          <label>H.No/Apartment</label>
          <input type="text" class="form-control" name="corre_apartment" id="corre_apartment">
          </div>
         </div>

         <div class="col-sm-3">
          <div class="form-group">
          <label>Street/Village/Colony</label>
          <input type="text" class="form-control" name="corre_colony" id="corre_colony">
        </div>
         </div>

         <div class="col-sm-3">
          <div class="form-group">
          <label>Postoffice/Area</label>
          <input type="text" class="form-control" name="corre_area" id="corre_area">
        </div>
         </div>

          <div class="col-sm-3">
          <div class="form-group">
          <label>Residence Phone</label>
          <input type="text" class="form-control" name="corre_resi_phone" id="corre_resi_phone">
          </div>
         </div> 

       </div>
     </div>

      <div class="row">
        <div class="col-sm-12">

          <div class="col-sm-3">
          <div class="form-group">
          <label>State/U.T.<span class="require">*</span></label>
          <select name="corre_state" class="form-control" id="corre_state" ng-change="city_get_corre_state()" ng-model="corre_state" required="">
            <option value="">--Select--</option>
            <?php
              foreach($state_list as $name) { ?>
                <option value="<?= $name['id'] ?>"><?= $name['name'] ?></option>
            <?php
              } ?>
          </select>

          <span style="color:red" ng-show="LoginForm.corre_state.$dirty && LoginForm.corre_state.$invalid || LoginForm.$submitted && LoginForm.corre_state.$invalid">
                <span ng-show="LoginForm.corre_state.$error.required">field is required.</span>
            </span>

          </div>
         </div>


         <div class="col-sm-3">
          <div class="form-group">
          <label>District/City<span class="require">*</span></label>
          <select class="form-control" name="corre_city" id="corre_city" ng-model="corre_city" required="">
            
          </select>

          <span style="color:red" ng-show="LoginForm.corre_city.$dirty && LoginForm.corre_city.$invalid || LoginForm.$submitted && LoginForm.corre_city.$invalid">
                <span ng-show="LoginForm.corre_city.$error.required">field is required.</span>
            </span>
         
          </div>
         </div>


          <div class="col-sm-3">
          <div class="form-group">
          <label>Pincode<span class="require">*</span></label>
          <input type="text" class="form-control" name="corre_pincode" id="corre_pincode" ng-model="corre_pincode" required="">
          <span style="color:red" ng-show="LoginForm.corre_pincode.$dirty && LoginForm.corre_pincode.$invalid || LoginForm.$submitted && LoginForm.corre_pincode.$invalid">
                <span ng-show="LoginForm.corre_pincode.$error.required">field is required.</span>
            </span>
          </div>
         </div>

        

       </div>
     </div>
      
</fieldset>


<fieldset class="form_disable">
  <legend>Academic Details</legend>

  <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
             
      
             <label>Academic Details (Self attested copy of mark sheet to be attached)<span class="require">*</span></label><br/>
             <input type="radio" class="" name="academic" value="passed" ng-model="academic" required=""> &nbsp;10+2 Passed&nbsp;&nbsp;&nbsp;
             <input type="radio" class="" name="academic" value="appearance" ng-model="academic" required=""> &nbsp;10+2 Appearance&nbsp;&nbsp;&nbsp;
              <br/>
              <span style="color:red" ng-show="LoginForm.academic.$dirty && LoginForm.academic.$invalid || LoginForm.$submitted && LoginForm.academic.$invalid">
                <span ng-show="LoginForm.academic.$error.required">field is required.</span>
              </span>

     
            
            <table class="table table-bordred">
              <thead>
              <tr>
                <th>Intermediate (10+2)</th>
                <th>Board</th>
                <th>Year of completion</th>
                <th>Marks Obtained</th>
                <th>Max. Marks</th>
                <th>Percentage</th>
              </tr>
            </thead>
              <tr>
                <td><input type="text" class="form-control" id="acdmyA" name="academic_intermediate"></td>
                <td><input type="text" class="form-control" id="acdmyB" name="academic_board"></td>
                <td><input type="text" class="form-control" id="acdmyC" name="academic_year"></td>
                <td><input type="text" class="form-control marks_obt" id="acdmyE" name="academic_mark_obt">
                  <span id="marks_msg" style="font-size: 12px; color: red;"></span>
                </td>
                <td><input type="text" class="form-control marks_max" id="acdmyF" name="academic_mark_max"></td>
                <td>
                  <input type="text" class="form-control marks_per" id="acdmyG" name="academic_percentage" readonly="">
                  <input type="hidden" value="" id="academic_percentage_hidden">
                </td>
              </tr>
            </table>
          </div>
         </div>

       </div>
</fieldset>
     

<fieldset class="form_disable">
  <legend>Centre for Appearing</legend>
  <div class="row">
    <div class="col-sm-4">
      <span style="font-size: 19px;"> Choice of centre for appearing in IIAT-2020:</span>
    </div>
    <div class="col-sm-2">
      <div class="form-group">

        <select name="first_center" class="form-control common" ng-model="first_center" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Goa">Goa</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
          <option value="Hajipur,Bihar">Hajipur,Bihar</option>
          <option value="Jaipur">Jaipur</option>
          <option value="Chennai">Chennai</option>
          <option value="Bhopal">Bhopal</option>
          <option value="Kolkata">Kolkata</option>
          <option value="Lucknow">Lucknow </option>
          <option value="Mumbai">Mumbai</option>
          <option value="Bengaluru">Bengaluru</option>
          <option value="Ahmedabad">Ahmedabad</option>
          <option value="Guwahati">Guwahati</option>
          <option value="Jammu">Jammu</option>
          <option value="Trivandrum">Trivandrum</option>
        </select>

        <span style="color:red" ng-show="LoginForm.first_center.$dirty && LoginForm.first_center.$invalid || LoginForm.$submitted && LoginForm.first_center.$invalid">
                <span ng-show="LoginForm.first_center.$error.required">field is required.</span>
        </span>
      </div>
    </div>

    <div class="col-sm-2">
      <div class="form-group">
        <select name="second_center" class="form-control common" ng-model="second_center" required="second_center">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Goa">Goa</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
          <option value="Hajipur,Bihar">Hajipur,Bihar</option>
          <option value="Jaipur">Jaipur</option>
          <option value="Chennai">Chennai</option>
          <option value="Bhopal">Bhopal</option>
          <option value="Kolkata">Kolkata</option>
          <option value="Lucknow">Lucknow </option>
          <option value="Mumbai">Mumbai</option>
          <option value="Bengaluru">Bengaluru</option>
          <option value="Ahmedabad">Ahmedabad</option>
          <option value="Guwahati">Guwahati</option>
          <option value="Jammu">Jammu</option>
          <option value="Trivandrum">Trivandrum</option>
        </select>

        <span style="color:red" ng-show="LoginForm.second_center.$dirty && LoginForm.second_center.$invalid || LoginForm.$submitted && LoginForm.second_center.$invalid">
                <span ng-show="LoginForm.second_center.$error.required">field is required.</span>
        </span>
      </div>
    </div>

    <div class="col-sm-2">
      <div class="form-group">
       <select name="third_center" class="form-control common" ng-model="third_center" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Goa">Goa</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
          <option value="Hajipur,Bihar">Hajipur,Bihar</option>
          <option value="Jaipur">Jaipur</option>
          <option value="Chennai">Chennai</option>
          <option value="Bhopal">Bhopal</option>
          <option value="Kolkata">Kolkata</option>
          <option value="Lucknow">Lucknow </option>
          <option value="Mumbai">Mumbai</option>
          <option value="Bengaluru">Bengaluru</option>
          <option value="Ahmedabad">Ahmedabad</option>
          <option value="Guwahati">Guwahati</option>
          <option value="Jammu">Jammu</option>
          <option value="Trivandrum">Trivandrum</option>
        </select>
        <span style="color:red" ng-show="LoginForm.third_center.$dirty && LoginForm.third_center.$invalid || LoginForm.$submitted && LoginForm.third_center.$invalid">
                <span ng-show="LoginForm.third_center.$error.required">field is required.</span>
        </span>
      </div>
    </div>

    <div class="col-sm-2">
      <div class="form-group">
       <select name="forth_center" class="form-control common" ng-model="forth_center" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Goa">Goa</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
          <option value="Hajipur,Bihar">Hajipur,Bihar</option>
          <option value="Jaipur">Jaipur</option>
          <option value="Chennai">Chennai</option>
          <option value="Bhopal">Bhopal</option>
          <option value="Kolkata">Kolkata</option>
          <option value="Lucknow">Lucknow </option>
          <option value="Mumbai">Mumbai</option>
          <option value="Bengaluru">Bengaluru</option>
          <option value="Ahmedabad">Ahmedabad</option>
          <option value="Guwahati">Guwahati</option>
          <option value="Jammu">Jammu</option>
          <option value="Trivandrum">Trivandrum</option>
        </select>
        <span style="color:red" ng-show="LoginForm.forth_center.$dirty && LoginForm.forth_center.$invalid || LoginForm.$submitted && LoginForm.forth_center.$invalid">
                <span ng-show="LoginForm.forth_center.$error.required">field is required.</span>
        </span>
      </div>
    </div>
  </div>
</fieldset>





<fieldset class="form_disable">
  <legend>Choice of Centre for appearing in GD & PI</legend>
  <div class="row">

     <div class="col-sm-2">
      <div class="form-group">
        <input type="checkbox" name="center_city[]" ng-model="center_city"  value="Gwalior" required=""> &nbsp;&nbsp;Gwalior
      </div>
    </div>

    <div class="col-sm-2">
      <div class="form-group">
       <input type="checkbox" name="center_city[]" ng-model="center_city"  value="Bhubaneswar" required=""> &nbsp;&nbsp;Bhubaneswar 
      </div>
    </div>

    <div class="col-sm-2">
      <div class="form-group">
        <input type="checkbox" name="center_city[]" ng-model="center_city"  value="Noida" required=""> &nbsp;&nbsp;Noida  
      </div>
    </div>

     <div class="col-sm-2">
      <div class="form-group">
        <input type="checkbox" name="center_city[]" ng-model="center_city"  value="Nellore" required=""> &nbsp;&nbsp;Nellore  
      </div>
    </div>

      <span style="color:red" ng-show="LoginForm.center_city.$dirty && LoginForm.center_city.$invalid || LoginForm.$submitted && LoginForm.center_city.$invalid">
        <span ng-show="LoginForm.center_city.$error.required">field is required.</span>
      </span>


  </div>
</fieldset>

<fieldset class="form_disable">
  <legend>Preference Study Centre</legend>
  <div class="row">
    <div class="col-sm-4">
      <span style="font-size: 20px;"> Write code as GWL, BSR, NOD, NLR</span>
     
    </div>

    <div class="col-sm-2">
      <div class="form-group">
       <select name="first_code" class="form-control common_code" ng-model="first_code" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
         </select>
           <span style="color:red" ng-show="LoginForm.first_code.$dirty && LoginForm.first_code.$invalid || LoginForm.$submitted && LoginForm.first_code.$invalid">
                <span ng-show="LoginForm.first_code.$error.required">field is required.</span>
        </span>
      </div>
    </div>

     <div class="col-sm-2">
      <div class="form-group">
       <select name="second_code" class="form-control common_code" ng-model="second_code" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
        </select>
        <span style="color:red" ng-show="LoginForm.second_code.$dirty && LoginForm.second_code.$invalid || LoginForm.$submitted && LoginForm.second_code.$invalid">
                <span ng-show="LoginForm.second_code.$error.required">field is required.</span>
        </span>
      </div>
    </div>

     <div class="col-sm-2">
      <div class="form-group">
       <select name="third_code" class="form-control common_code" ng-model="third_code" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
        </select>
         <span style="color:red" ng-show="LoginForm.third_code.$dirty && LoginForm.third_code.$invalid || LoginForm.$submitted && LoginForm.third_code.$invalid">
                <span ng-show="LoginForm.third_code.$error.required">field is required.</span>
        </span>
      </div>
    </div>

     <div class="col-sm-2">
      <div class="form-group">
       <select name="four_code" class="form-control common_code" ng-model="four_code" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
        </select>
        <span style="color:red" ng-show="LoginForm.four_code.$dirty && LoginForm.four_code.$invalid || LoginForm.$submitted && LoginForm.four_code.$invalid">
                <span ng-show="LoginForm.four_code.$error.required">field is required.</span>
        </span>
      </div>
    </div>

  </div>
</fieldset>
     
 <fieldset>
  <legend>Signature:</legend>
    <div class="row">
      <div class="col-sm-4">
        <label>Upload Signature</label>
        <input type="file" name="signature" ng-model="signature" class="form-control" accept="image/gif, image/jpeg, image/png" onchange="readSignature(this);" >

        <span style="color:red" ng-show="LoginForm.signature.$dirty && LoginForm.signature.$invalid || LoginForm.$submitted && LoginForm.signature.$invalid">
        <span ng-show="LoginForm.signature.$error.required">field is required.</span>
      </span>

      </div>
      <div class="col-sm-4">
        <img src="" width="100%" style="cursor: pointer;" id="sig-pic" />
      </div>
    </div>
  </fieldset>     

<fieldset>
  <legend>Declaration:</legend>
  <p>
    <span style="color:red" ng-show="LoginForm.check.$dirty && LoginForm.check.$invalid || LoginForm.$submitted && LoginForm.check.$invalid">
        <span ng-show="LoginForm.check.$error.required">field is required.</span>
      </span>
    <input type="checkbox" ng-model="check" name="check" required="" />  I have read all the instructions for filling up the Application Form carefully. I solemnly declare that the forgoing information given in the application form is complete, correct & true to the best of my knowledge and belief. I also certify that my admission to BBA (TT) programme in the institute is liable to be cancelled if any information given by me is found false / incorrect at any stage.

 

  </p>
</fieldset>

<div class="row text-center">
  <button class="btn btn-success" id="btnSubmit" name="btnSubmit">SUBMIT FORM & PAY FEE</button>
</div>

    </div>
   
  </div>

</div>

      

<?php echo form_close(); ?> 



<script src="<?=base_url();?>themes/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url();?>themes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- <script src="<?=base_url();?>themes/plugins/iCheck/icheck.min.js"></script> -->

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> -->


<script>
  $(function () {
   /* $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' 
    });*/

     //$('input').on('ifClicked', function (ev) {$(ev.target).click()});
    //$('input').on('ifChanged', function (ev) {$(ev.target).click()});

     $('input[name="category"]').on('change', function(event){
      if(this.value == 'General'|| this.value == 'OBC'|| this.value == 'EWS'|| this.value =='PWD') {
          $("#fee_amt").html('1000');
        }
      else if(this.value == 'SC/ST') {
          $("#fee_amt").html('500');
        }
    });



    


    $('input[name="check"]').on('ifChecked', function(event){
       $(".form_disable :input").prop("disabled", true);
    });

    $('input[name="check"]').on('ifUnchecked', function(event){
       $(".form_disable :input").prop("disabled", false);
    });

  });
</script>


<script>
var App = angular.module('myApp', ['ui.bootstrap']); 
 
function home_screen($scope,$log,$http)
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

    $scope.city_get = function($event) 
    {
        
        var data = angular.element(document.querySelector('#parma_state')).val();
         $http({
            method: "get",
            url: "<?php echo site_url('admission/city_get?data=');?>"+data}).then(function(response){
                $("#parma_city").empty();
               $.each(response.data, function () {
                $("#parma_city").append($("<option></option>").val(this['id']).html(this['name']));
              });
          });  
      };

    $scope.city_get_corre_state = function($event) 
    {
        var data = angular.element(document.querySelector('#corre_state')).val();
         $http({
            method: "get",
            url: "<?php echo site_url('admission/city_get?data=');?>"+data}).then(function(response){
                $("#corre_city").empty();
               $.each(response.data, function () {
                $("#corre_city").append($("<option></option>").val(this['id']).html(this['name']));
              });
          });  
      };


      


}

function readSignature(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#sig-pic')
                    .attr('src', e.target.result)
                    .width(250)
                    .height(50);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }



function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-pic')
                    .attr('src', e.target.result)
                    .width(116)
                    .height(144);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }



function ageCalculate(){

  var birthDate =document.getElementById('birth_date').value;
  var d = new Date(birthDate);
  var mdate = birthDate.toString();
  var yearThen = parseInt(mdate.substring(0,4), 10);
  var monthThen = parseInt(mdate.substring(5,7), 10);
  var dayThen = parseInt(mdate.substring(8,10), 10);
  
  var today = new Date();
  var birthday = new Date(yearThen, monthThen-1, dayThen);
 // alert(today.valueOf() + " " + birthday.valueOf());
  var differenceInMilisecond = today.valueOf() - birthday.valueOf();
//  alert(differenceInMilisecond);
  
  var year_age = Math.floor(differenceInMilisecond / 31536000000);
  var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);
  

  if ((today.getMonth() == birthday.getMonth()) && (today.getDate() == birthday.getDate())) {
      alert("Happy B'day!!!");
  }
  
  var month_age = Math.floor(day_age/30);
  
  day_age = day_age % 30;
  
  var tMnt= (month_age + (year_age*12));
  var tDays =(tMnt*30) + day_age;
  
  if (isNaN(year_age) || isNaN(month_age) || isNaN(day_age)) {
      document.getElementById("age").innerHTML = ("Invalid birthday - Please try again!");
  }
  else {
      document.getElementById("age").innerHTML = year_age + " years " + month_age + " months " + day_age + " days";
  }

}
</script>


<script>
  $('.marks_obt, .marks_max').change(function() {
    var marks_obt = parseFloat($('.marks_obt').val());
    var total_marks = $('.marks_max').val();
    var get_per = parseFloat(((marks_obt * 100) / total_marks));
    var round = (Math.round(get_per * 100 )/100 ).toString();
    $('.marks_per').val(round);
    $('#academic_percentage_hidden').val(round);
    if(marks_obt>total_marks){$("#marks_msg").html("Can't greater then Max Marks");}
    else{$("#marks_msg").html("");}

  });
</script>

<script type="text/javascript">
  $('.common').on('change', function() {
    $('.common').find('option').prop('disabled', false);
    $('.common').each(function() {
       $('.common').not(this).find('option[value="' + this.value + '"]').prop('disabled', true); 
       //$('.common').not(this).find('option[value="' + this.value + '"]').attr('style','background-color:#e4e4e4;');
    });
  });

  $('.common_code').on('change', function() {
    $('.common_code').find('option').prop('disabled', false);
    $('.common_code').each(function() {
       $('.common_code').not(this).find('option[value="' + this.value + '"]').prop('disabled', true); 
       //$('.common').not(this).find('option[value="' + this.value + '"]').attr('style','background-color:#e4e4e4;');
    });
  });
</script>


<script type="text/javascript">
  $(document).ready(function(){
    alert('hi');
      $("#course option").filter(function() { return this.value == '<?php echo $course_id; ?>' }).prop('selected', true);
  });

  

  $('input[name="academic"]').on('change', function(event){
      if(this.value == 'passed') {
          $("#acdmyA,#acdmyB,#acdmyC,#acdmyD,#acdmyE,#acdmyF,#acdmyG").removeAttr('disabled');
        }
      else if(this.value == 'appearance') {
          $("#acdmyA,#acdmyB,#acdmyC,#acdmyD,#acdmyE,#acdmyF,#acdmyG").val("");
          $("#acdmyA,#acdmyB,#acdmyC,#acdmyD,#acdmyE,#acdmyF,#acdmyG").attr('disabled','disabled'); 
        }
    });


    $('.address_chk').click(function(){

    if($(this). is(":checked")){
      $("#corre_apartment").val($("#parma_apartment").val());
        $("#corre_colony").val($("#parma_colony").val());
        $("#corre_area").val($("#parma_area").val());
        $("#corre_city").val($("#parma_city").val());
        $("#corre_state").val($("#parma_state").val());
        $("#corre_pincode").val($("#parma_pincode").val());
        $("#corre_resi_phone").val($("#parma_resi_phone").val());
    }
    else if($(this). is(":not(:checked)")){
        $("#corre_apartment").val("");
        $("#corre_colony").val("");
        $("#corre_area").val("");
        $("#corre_city").val("");
        $("#corre_state").val("");
        $("#corre_pincode").val("");
        $("#corre_resi_phone").val("");
    }


</script>





<style type="text/css">
fieldset { 
    display: block;
    margin-left: 20px;
    margin-right: 20px;
    padding-top: 0.35em;
    padding-bottom: 0.625em;
    padding-left: 0.75em;
    padding-right: 0.75em;
    border: 2px solid #e4e4e4;
    margin-bottom: 30px; 
}

legend {   
    display: block; 
    width: auto !important;
    margin-bottom:10px;
    font-size: 21px;
    color: #333;
    border-bottom: 0;
    font-weight: 600;
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

.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 100%;
}

.btn-default {
     background-color: #fff;
    color: #444;
    border-color: #ddd;
    border-radius: 0px;
    width: 100%;
}
</style>