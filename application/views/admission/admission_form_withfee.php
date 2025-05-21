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

<div id="loader-wrapper">
    <div id="loader"></div>
 
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
 
</div>

  <div class="container container_bg">
    
    <div class="row">
      <img src="<?=base_url();?>themes/dist/img/head.jpg" width="100%" />
    </div>

    <div class="row text-center">
      <h3><b>Online Admission Form for BBA (Tourism & Travel) 2025-28 Programme</b> <br/><span style="font-size: 20px;">(Under Collaborative Scheme with JNU, New Delhi)</span></h3>
      <hr/>
    </div> 



    <div class="row"  style="margin-top: 1%; margin-bottom: 10%;">

       <?php
       if(hasFlash('ViewMsgSuccess')){echo getFlash('ViewMsgSuccess');}
       ?> 



        <fieldset class="form_disable">
          <legend>Basic Details</legend>
          
        <div class="row">
        

        <div class="col-sm-10" style="padding-right: 0px;">
        <div class="row">
          <div class="col-sm-12" style="padding-right: 0px;">

           <div class="col-sm-4">
             <div class="form-group has-feedback">
                <label>Select Course<span class="require">*</span></label>
                <select class="form-control required" name="course" required="" id="course" disabled="">
                  <option value="">--Select--</option>
                  <option value="1">BBA(TT)-2025-28</option>
                  <option value="2">MBA(TTM)-2025-27</option>
                </select>
              </div>
           </div> 


           <div class="col-sm-5">
           <div class="form-group">
            <label>Category<span class="require">*</span></label><br/>
            <input type="radio" class="" name="category" value="General" ng-model="category" required="" ng-change="marks_change()"> &nbsp;General&nbsp;
            <input type="radio" class="" name="category" value="EWS" ng-model="category" required="" ng-change="marks_change()"> &nbsp;EWS 
            <input type="radio" class="" name="category" value="OBC" ng-model="category" required="" ng-change="marks_change()"> &nbsp;OBC 
            <input type="radio" class="" name="category" value="SC" ng-model="category" required="" ng-change="marks_change()"> &nbsp;SC        
            <input type="radio" class="" name="category" value="ST" ng-model="category" required="" ng-change="marks_change()"> &nbsp;ST 
            <br/>
              <span style="color:red" ng-show="LoginForm.category.$dirty && LoginForm.category.$invalid || LoginForm.$submitted && LoginForm.category.$invalid">
                   <span ng-show="LoginForm.category.$error.required">field is required.</span>
              </span>
          </div>
         </div>



         </div>
       </div>

       <div class="row">
        <div class="col-sm-12">

          
           <div class="col-sm-4">
             <div class="form-group has-feedback">
                <label>Name (as per 10<sup>th</sup> marksheet)<span class="require">*</span></label>
                <input type="text" class="form-control" name="fname" id="fname" autocomplete="off" ng-model="fname" required="">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>

                <span style="color:red" ng-show="LoginForm.fname.$dirty && LoginForm.fname.$invalid || LoginForm.$submitted && LoginForm.fname.$invalid">
                  <span ng-show="LoginForm.fname.$error.required">field is required.</span>
                </span> 

              </div>
           </div> 

           <div class="col-sm-4">
             <div class="form-group has-feedback">
                <label>Middle (as per 10<sup>th</sup> marksheet)</label>
                <input type="text" class="form-control" name="mname" id="mname">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
              </div>
           </div> 

           <div class="col-sm-4">
             <div class="form-group has-feedback">
                <label>Last Name (as per 10<sup>th</sup> marksheet)</label>
                <input type="text" class="form-control" name="lname" id="lname" autocomplete="off" ng-model="lname">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                 
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
               <input type="hidden" value="<?php echo $number; ?>" name="mobile_hidden">
             </div>
           </div>

           <div class="col-sm-3">
             <div class="form-group has-feedback">
              <label>Email Id<span class="require">*</span></label>
              <span class="fa fa-envelope form-control-feedback" ></span>
               <input type="text" class="form-control" name="txt_email" id="txt_email" autocomplete="off" ng-pattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/" ng-model="txt_email" required="">
              <span style="color:red" ng-show="LoginForm.txt_email.$dirty && LoginForm.txt_email.$invalid || LoginForm.$submitted && LoginForm.txt_email.$invalid">
                  <span ng-show="LoginForm.txt_email.$error.required">field is required.</span>
                  <span ng-show="LoginForm.txt_email.$invalid" ng-hide="LoginForm.txt_email.$error.required">Invalid email </span>
                </span> 
             </div>
           </div>


            <div class="col-sm-4">
           <div class="form-group has-feedback">
             <br/> <label><input type="checkbox" name="pwd" ng-model="pwd" value="1"> Are you a person with a Disability(PwD)</label>
                
           </div>
           </div>


         <div class="col-sm-2">
           <div class="form-group has-feedback">
              <label>Gender<span class="require">*</span></label><br/>
              <input type="radio" class="" name="gender" id="gender" ng-model="gender" value="Male" required=""  />
              Male &nbsp;
              <input type="radio" class="" name="gender" id="gender" ng-model="gender" value="Female" required=""  />
              Female
              &nbsp;
          <input type="radio" class="" name="gender" id="gender" ng-model="gender" value="Other" required=""  />
              Other
              &nbsp;
             
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
              <label>Mother's<br/>Mobile Number</label>
              <input type="text" class="form-control" name="mother_mobile" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="10" id="mother_mobile" autocomplete="off" ng-model="mother_mobile">
              <span class="glyphicon glyphicon-user form-control-feedback" style="padding-top: 20px;"></span>
              
                <span style="color:red" ng-show="LoginForm.mother_mobile.$dirty && LoginForm.mother_mobile.$invalid || LoginForm.$submitted && LoginForm.father_mobile.$invalid">
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
         <!--  <input id="file-input" name="file" type="file" ng-model="file" accept="image/gif, image/jpeg, image/png" onchange="angular.element(this).scope().readURL(this)" /> -->

          <input type="file" id="file-input" name="file" type="file" ng-model="file" onchange="angular.element(this).scope().setFile(this)">
              <br/>    
          <span style="color: red;">{{FileMessage}}</span>

            <br/>
            <span style="color:red" id="photo_check">
                  <span style="color:red">Upload photo</span>
            </span> 
        </div>
    
        <span style="font-size: 20px;">Admission Fees <br/><i class="fa fa-inr"></i> <span id="fee_amt"></span>
        <input type="hidden" id="amt" name="amt">
      </span>
       </div>

    </div>

    <div class="row">
        <div class="col-sm-12">


            <div class="col-sm-3">
          <div class="form-group has-feedback">
          <label>Father's/Husband's Email Id<span class="require">*</span></label>
          <input type="text" class="form-control" required="" ng-pattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/" name="father_email" autocomplete="off" ng-model="father_email" required>
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
        <option value="Other">Other</option>
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
        <option>Hinduism </option>
                <option>Christianity </option>
                <option>Islam </option>
                <option>Sikhism </option>
                <option>Buddhism</option>
                <option>Other </option>
               </select>
                <span style="color:red" ng-show="LoginForm.religion.$dirty && LoginForm.religion.$invalid || LoginForm.$submitted && LoginForm.religion.$invalid">
                <span ng-show="LoginForm.religion.$error.required">field is required.</span>
              </span>
               
            </div>
         </div>

         <div class="col-sm-3">

           <div class="form-group has-feedback">
              <label>DOB<span> (As per 10<sup>th</sup> marksheet)</span><span class="require">*</span></label><br/>
                <!--input type="date" id="birth_date" class="form-control" name="txt_dob" onblur="ageCalculate()" autocomplete="off" ng-model="txt_dob" required=""-->
         
         <input type="date" id="birth_date" class="form-control" name="txt_dob" autocomplete="off" ng-model="txt_dob" required="">
    
                 <span class="fa fa-calendar form-control-feedback"></span>
                 <span id="age" style="font-weight: normal;"></span>
                 <span style="color:red" ng-show="LoginForm.txt_dob.$dirty && LoginForm.txt_dob.$invalid || LoginForm.$submitted && LoginForm.txt_dob.$invalid">
                  <span ng-show="LoginForm.txt_dob.$error.required">field is required.</span>
                </span> 
            </div>
         </div>

         <div class="col-sm-2">
          <br/>
          <span style="color: red; font-weight: bold; font-size: 16px;" id="age_criteria"></span>
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
          <label>House No/Apartment</label>
          <input type="text" class="form-control" name="parma_apartment" id="parma_apartment" ng-model="parma_apartment">
          </div>
         </div>

         <div class="col-sm-3">
          <div class="form-group">
          <label>Street/Village/Colony</label>
          <input type="text" class="form-control" id="parma_colony" name="parma_colony" ng-model="parma_colony">
        </div>
         </div>

         <div class="col-sm-3">
          <div class="form-group">
          <label>Post office/Area</label>
          <input type="text" class="form-control" id="parma_area" name="parma_area" ng-model="parma_area">
        </div>
         </div>

          <div class="col-sm-3">
          <div class="form-group">
          <label>Residence Phone</label>
          <input type="text" class="form-control" name="parma_resi_phone" id="parma_resi_phone" ng-model="parma_resi_phone">
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
  <legend>Correspondence Address <br/><span style="font-size: 12px;"><input type="checkbox" ng-model="address_chk" name="address_chk" ng-change="getdetails()"> Same as Parmanent Address</span></legend>

   <div class="row">
        <div class="col-sm-12">

         <div class="col-sm-3">
          <div class="form-group">
          <label>House No./Apartment</label>
          <input type="text" class="form-control" name="corre_apartment" id="corre_apartment" ng-model="corre_apartment">
          </div>
         </div>

         <div class="col-sm-3">
          <div class="form-group">
          <label>Street/Village/Colony</label>
          <input type="text" class="form-control" name="corre_colony" id="corre_colony" ng-model="corre_colony">
        </div>
         </div>

         <div class="col-sm-3">
          <div class="form-group">
          <label>Post office/Area</label>
          <input type="text" class="form-control" name="corre_area" id="corre_area" ng-model="corre_area">
        </div>
         </div>

          <div class="col-sm-3">
          <div class="form-group">
          <label>Residence Phone</label>
          <input type="text" class="form-control" name="corre_resi_phone" id="corre_resi_phone" ng-model="corre_resi_phone">
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
          <!--select class="form-control" name="corre_city" id="corre_city" ng-model="corre_city" required="">
          </select-->
      
      <select ng-model="corre_city" class="form-control" name="corre_city" required="">  
                  <option value="">--Select City--</option>  
                  <option ng-repeat="corre_city in cities" value="{{corre_city.id}}" ng-selected="corre_city.id == parma_city">  
                       {{corre_city.name}}  
                  </option>  
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
             
      
             <label>Academic Details<span class="require">*</span></label><br/>
             <input type="radio" class="" name="academic" value="passed" ng-model="academic" required=""> &nbsp;10+2 Passed&nbsp;&nbsp;&nbsp;
             <input type="radio" class="" name="academic" value="appearance" ng-model="academic" required=""> &nbsp;10+2 Appearance&nbsp;&nbsp;&nbsp;
              <br/>
              <span style="color:red" ng-show="LoginForm.academic.$dirty && LoginForm.academic.$invalid || LoginForm.$submitted && LoginForm.academic.$invalid">
                <span ng-show="LoginForm.academic.$error.required">field is required.</span>
              </span>

     
            
            <table class="table table-bordred">
              <thead>
              <tr>
                <th>School Name</th>
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
                <td><input type="text" class="form-control marks_obt" id="acdmyE" name="academic_mark_obt" ng-model="academic_mark_obt" ng-blur="marks_change()">
                  <span id="marks_msg" style="font-size: 12px; color: red;"></span>
                </td>
                <td><input type="text" class="form-control marks_max" id="acdmyF" ng-model="academic_mark_max" name="academic_mark_max" ng-blur="marks_change()"></td>
                <td>
                    <input type="text" class="form-control marks_per" id="acdmyG" name="academic_percentage" readonly="" ng-model="academic_percentage"  ng-blur="marks_change()">
                    <input type="hidden" value="" id="academic_percentage_hidden" ng-blur="marks_change()">



          <span ng-show="m_criteria != ''">
            <input type="hidden" value="" name="m_criteria_hidden" ng-model="m_criteria_hidden" id="m_criteria_hidden">
              <span style="color:red" ng-show="LoginForm.m_criteria_hidden.$dirty && LoginForm.m_criteria_hidden.$invalid || LoginForm.$submitted && LoginForm.m_criteria_hidden.$invalid">
                <span ng-show="LoginForm.m_criteria_hidden.$error.required">field is required.</span>
              </span>
            <span style="color: red;font-size: 14px;" id="m_criteria" ng-model = "m_criteria"></span>
          </span>




                   <!--  <span style="color:red" ng-if="academic_percentage < 45 && (category =='SC' || category =='ST')" ng-hide="academic_percentage==0 && (category !='SC' || category !='ST')">
                      <span>Percentage Criteria Not Matched</span>
                   </span>

                    <span style="color:red" ng-if="academic_percentage < 50 && (category !='General' || category !='OBC' || category !='EWS')" ng-hide="academic_percentage==0 || (category !='General' || category !='OBC' || category !='EWS')">
                      <span>Percentage Criteria Not Matched</span>
                   </span> -->


                </td>
              </tr>
            </table>
          </div>
         </div>

       </div>
</fieldset>
   
 <fieldset class="form_disable">
    <legend>CUET 2024</legend>
    <div class="row">
      <div class="col-sm-6">
        <span style="font-size: 19px;"> Submit a valid scorecard of CUET 2024:</span>
      </div>
      <div class="col-sm-6">    
      
      <div class="row">
          <div class="col-sm-4"><h3 style="margin-top: 0px;"><input type="checkbox" ng-model="cuet" name="score_chek[]" value="cuet"> CUET</h3></div>
          <div class="col-sm-4">
             <input type="number" class="form-control" name="cuet_score" ng-model="cuet_score" placeholder="Score" ng-disabled="!cuet" />
             <span ng-hide="!cuet || cuet_score" style="color: red;" ng-show="cuet">required</span>
          </div>
          <div class="col-sm-4">
            <input type="date" class="form-control"  name="cuet_year" ng-model="cuet_year" placeholder="Year" ng-disabled="!cuet" />
             <span ng-hide="!cuet || cuet_year" style="color: red;" ng-show="cuet" >required</span>
          </div>
        </div>

      </div>

    </div>
   

  </fieldset> 


<fieldset class="form_disable" style="background-color: #e4e4e4;">
  <legend>Entrance Test (Online)</legend>
  <div class="row">
      <div class="col-sm-12">
     <input type="checkbox" name="appearing_center_online" style="width:24px; height:30px;" value="1" /> <span style="font-size: 24px; line-height:0px; vertical-align: text-top;"> IAET (IITTM Admission Entrance Test) </span>
    </div>
  </div>
</fieldset> 
  

<fieldset class="form_disable" style="display:none;">
  <legend>Centre for Appearing</legend>
  <div class="row">
    <div class="col-sm-4">
      <span style="font-size: 19px;"> Choice of centre for appearing in IIAT-2023:</span>
    </div>
    <div class="col-sm-2">
      <div class="form-group">

        <select name="first_center" class="form-control common" ng-model="first_center">
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
        <select name="second_center" class="form-control common" ng-model="second_center" >
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
       <select name="third_center" class="form-control common" ng-model="third_center" >
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
       <select name="forth_center" class="form-control common" ng-model="forth_center" >
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
  <legend>Centre for appearing in GD & PI</legend>
  <div class="row">

    <div class="col-sm-4">
     <span style="font-size: 19px;"> Choice of centre for appearing in GD & PI for CUET/IIAT-2025 (offline)</span>
    </div>

     <div class="col-sm-2">
      <div class="form-group">
       <select name="center_city_first" class="form-control center_city" ng-model="center_city_first" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
       <option value="Goa">NIWS-GOA</option>
         </select>
           <span style="color:red" ng-show="LoginForm.center_city_first.$dirty && LoginForm.center_city_first.$invalid || LoginForm.$submitted && LoginForm.center_city_first.$invalid">
                <span ng-show="LoginForm.center_city_first.$error.required">field is required.</span>
        </span>
      </div>
    </div>

     <div class="col-sm-2">
      <div class="form-group">
       <select name="center_city_second" class="form-control center_city" ng-model="center_city_second" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
       <option value="Goa">NIWS-GOA</option>
        </select>
        <span style="color:red" ng-show="LoginForm.center_city_second.$dirty && LoginForm.center_city_second.$invalid || LoginForm.$submitted && LoginForm.center_city_second.$invalid">
                <span ng-show="LoginForm.center_city_second.$error.required">field is required.</span>
        </span>
      </div>
    </div>

     <div class="col-sm-2">
      <div class="form-group">
       <select name="center_city_third" class="form-control center_city" ng-model="center_city_third" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
       <option value="Goa">NIWS-GOA</option>
        </select>
         <span style="color:red" ng-show="LoginForm.center_city_third.$dirty && LoginForm.center_city_third.$invalid || LoginForm.$submitted && LoginForm.center_city_third.$invalid">
                <span ng-show="LoginForm.center_city_third.$error.required">field is required.</span>
        </span>
      </div>
    </div>

     <div class="col-sm-2">
      <div class="form-group">
       <select name="center_city_four" class="form-control center_city" ng-model="center_city_four" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
       <option value="Goa">NIWS-GOA</option>
        </select>
        <span style="color:red" ng-show="LoginForm.center_city_four.$dirty && LoginForm.center_city_four.$invalid || LoginForm.$submitted && LoginForm.center_city_four.$invalid">
                <span ng-show="LoginForm.center_city_four.$error.required">field is required.</span>
        </span>
      </div>
    </div>
  </div>
</fieldset>

<fieldset class="form_disable">
  <legend>Preference Study Centre</legend>
  <div class="row">
    <div class="col-sm-4">
      <span style="font-size: 20px;"> Choice of Preference Study Centre</span>
     
    </div>

    <div class="col-sm-2">
      <div class="form-group">
       <select name="first_code" class="form-control common_code" ng-model="first_code" required="">
          <option value="">--Select--</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
       <option value="Goa">NIWS-GOA</option>
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
       <option value="Goa">NIWS-GOA</option>
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
       <option value="Goa">NIWS-GOA</option>
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
       <option value="Goa">NIWS-GOA</option>
        </select>
        <span style="color:red" ng-show="LoginForm.four_code.$dirty && LoginForm.four_code.$invalid || LoginForm.$submitted && LoginForm.four_code.$invalid">
                <span ng-show="LoginForm.four_code.$error.required">field is required.</span>
        </span>
      </div>
    </div>

  </div>
</fieldset>
  
  <fieldset id="tblFruits">
    <legend>Know IITTM:</legend>
     <div class="row">
      <div class="col-sm-4">
      <label style="font-size:19px;">From where you received an information about IITTM</label>
        <input type="hidden" id="know_concate" name="know_concate" />
     </div>
       
     <div class="col-sm-2">
       <input type="checkbox" class="know" name="Newspaper" value="Newspaper" ng-model="Newspaper" /> <label style="font-size:19px;">Newspaper</label>
     </div>
       
    <div class="col-sm-2">
      <input type="checkbox" class="know" name="Google" value="Google" ng-model="Google"  /> <label style="font-size:19px;">Google</label>
     </div>
       
    <div class="col-sm-2">
      <input type="checkbox" class="know" name="SocialMedia" value="Social Media" ng-model="SocialMedia"  /> <label style="font-size:19px;">Social Media</label>
     </div>
       
    <div class="col-sm-2">
      <input type="checkbox" class="know" name="Wordofmouth" value="Word of mouth" ng-model="Wordofmouth"  /> <label style="font-size:19px;">Word of mouth</label>
     </div>  
       
        <div class="col-sm-3">
      <input type="checkbox" class="know" name="Careercousellingsession" value="Career counselling session" ng-model="Careercousellingsession"   /> <label style="font-size:19px;">Career counselling session</label>
     </div>
       
    </div>
     
                 <!--span style="color:red;" ng-show="LoginForm.Newspaper.$error.required || LoginForm.Google.$error.required||LoginForm.SocialMedia.$error.required||LoginForm.Wordofmouth.$error.required">Atleast one day should be selected</span-->
       
    
    
  </fieldset>
     
 <fieldset>
  <legend>Signature:</legend>
    <div class="row">
      <div class="col-sm-12">
        <label>Upload Signature (pictures should be in <b>.jpeg, .jpg or .png</b> format only, and file size should not exceed <b>500 KB)</b></label>

         <input type="file" name="signature" id="signature" ng-model="signature" onchange="angular.element(this).scope().setSignature(this)">
        <span style="color: red;">{{SignatureMessage}}</span>
     
      </div>
      <div class="col-sm-4">
        <img src="" width="100%" style="cursor: pointer;" id="sig-pic"/>
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


<!-- 
<script src="<?=base_url();?>themes/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url();?>themes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<!-- <script src="<?=base_url();?>themes/plugins/iCheck/icheck.min.js"></script> -->

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script> -->


<script type="text/javascript">
  $(function () {
   
   $('input[name="category"]').on('change', function(event){
  
      if(this.value == 'General'|| this.value == 'OBC'|| this.value == 'EWS') {
          $("#fee_amt").html('1000');
          $("#amt").val('1000');
          $("#age_criteria").html("");
          //if($("#birth_date").val() !=""){ageCalculate();}
        }
      else if(this.value == 'SC' || this.value == 'ST') {
          $("#fee_amt").html('500');
          $("#amt").val('500');
          $("#age_criteria").html("");
          //if($("#birth_date").val() !=""){ageCalculate();}
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
function home_screen($scope,$log,$http,$window)
{


  $("#loader-wrapper").hide();

  $scope.academic_mark_obt="";
  $scope.academic_mark_max="";
  $scope.academic_percentage ="";
  $scope.file="";

    $scope.setFile = function(element) {
    $scope.$apply(function($scope) {
        $scope.theFile = element.files[0];
        $scope.FileMessage = '';
        var filename = $scope.theFile.name;
        var index = filename.lastIndexOf(".");
        var strsubstring = filename.substring(index, filename.length);
        if(strsubstring == '.png' || strsubstring == '.jpeg' || strsubstring == '.png' || strsubstring == '.gif' || strsubstring == '.jpg')
        {

          var f = element.files[0].size;
          if(f > 512000)
          {  
            $scope.FileMessage = 'Size Below 500KB';
          }
          else
          {

            if(element.files && element.files[0]) 
            {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-pic')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(element.files[0]);
            }
            $scope.FileMessage='';
          }
        }
        else {
              $scope.theFile = '';
              $scope.FileMessage = 'please upload correct File, extension should be .jpg, .jpeg, .png';
        }
    });        
  };



  $scope.setSignature = function(element) {
    $scope.$apply(function($scope) {
        $scope.theFile = element.files[0];
        $scope.SignatureMessage = '';
        var filename = $scope.theFile.name;
        var index = filename.lastIndexOf(".");
        var strsubstring = filename.substring(index, filename.length);
        if (strsubstring == '.png' || strsubstring == '.jpeg' || strsubstring == '.png' || strsubstring == '.gif' || strsubstring == '.jpg')
        {

          var f = element.files[0].size;
          if(f > 512000)
          {  
            $scope.SignatureMessage = 'Size Below 500KB';
          }
          else
          {
              if(element.files && element.files[0]) 
              {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#sig-pic').attr('src', e.target.result);
              };
              reader.readAsDataURL(element.files[0]);
              }
              $scope.SignatureMessage='';
            }
        }
        else {
              $scope.SignatureMessage = 'please upload correct File, extension should be .jpg, .jpeg, .png';
        }
    });        
  };





  $scope.marks_change=function()
  {
    var marks_obt = parseFloat($('.marks_obt').val());
    var total_marks = $('.marks_max').val();
    var get_per = parseFloat(((marks_obt * 100) / total_marks));
    var round = (Math.round(get_per * 100 )/100 ).toString();
    $('.marks_per').val(round);
    $scope.academic_percentage = round;
    console.log(round);
    $('#academic_percentage_hidden').val(round);
    if(marks_obt>total_marks){$("#marks_msg").html("Can't greater then Max Marks");}
    else{$("#marks_msg").html("");}

    var caterogry = $('input[name="category"]:checked').val();
   
    console.log(caterogry);
   
    if((caterogry =="General" || caterogry =="EWS" || caterogry =="OBC") && round < 50)
    { 

       $("#m_criteria").html("Less than 50% not eligible for " + caterogry + " category");
       $('#m_criteria_hidden').attr("required","required");
       $('#m_criteria_hidden').addClass("ng-invalid-required"); 
       $('#m_criteria_hidden').addClass("ng-invalid"); 
       $('#m_criteria_hidden').removeClass("ng-valid-required"); 
       $('#m_criteria_hidden').removeClass("ng-valid"); 
          $("#btnSubmit").attr('disabled','disabled');

    }
    else if((caterogry =="ST" || caterogry =="SC") && round < 45)
    { 
       $("#m_criteria").html("Less than 45% not eligible for " + caterogry + " category");
       $('#m_criteria_hidden').attr("required","required");
       $('#m_criteria_hidden').addClass("ng-invalid-required"); 
       $('#m_criteria_hidden').addClass("ng-invalid"); 
       $('#m_criteria_hidden').removeClass("ng-valid-required"); 
       $('#m_criteria_hidden').removeClass("ng-valid"); 
          $("#btnSubmit").attr('disabled','disabled');
    }
    else
    {    
         $("#m_criteria").html("");
         $('#m_criteria_hidden').removeAttr("required");
         $('#m_criteria_hidden').removeClass("ng-invalid-required"); 
         $('#m_criteria_hidden').removeClass("ng-invalid"); 
         $('#m_criteria_hidden').addClass("ng-valid"); 
         $('#m_criteria_hidden').addClass("ng-valid-required"); 
         $("#btnSubmit").removeAttr('disabled');
    }

  };


   
    $scope.login_check = function($event)
    {
      var vidFileLength = $("#file-input")[0].files.length;
      if(vidFileLength === 0){
        $scope.FileMessage = 'Upload File';
       
      }
     

      var signatureLength = $("#signature")[0].files.length;
      if(signatureLength === 0){
        $scope.SignatureMessage = 'Upload File'; 
       
      }
          
      
      if($scope.LoginForm.$invalid)
      {
        $scope.LoginForm.$submitted=true;
        $event.preventDefault();
      }
      

    };

    

    $scope.city_get = function($event) 
    {
        $("#loader-wrapper").show();
        var data = angular.element(document.querySelector('#parma_state')).val();
         $http({
            method: "get",
            url: "<?php echo site_url('admission/city_get?data=');?>"+data}).then(function(response){
                $("#parma_city").empty();
               $.each(response.data, function () {
                $("#parma_city").append($("<option></option>").val(this['id']).html(this['name']));
        $("#loader-wrapper").hide();
              });
          });  
      };

    $scope.city_get_corre_state = function($event) 
    {
      $("#loader-wrapper").show();
        var data = angular.element(document.querySelector('#corre_state')).val();
         $http({
            method: "get",
            url: "<?php echo site_url('admission/city_get_new?data=');?>"+data}).then(function(response){
                $scope.cities = response.data;
                $("#loader-wrapper").hide();
            }); 
    };

    
   $scope.city_get_corre_state_for_data_get = function(id) 
    {
      $("#loader-wrapper").show();
        var data = id;
         $http({
            method: "get",
            url: "<?php echo site_url('admission/city_get_new?data=');?>"+data}).then(function(response){
                $scope.cities = response.data;
                $("#loader-wrapper").hide();
            });  
            /*url: "<?php echo site_url('admission/city_get?data=');?>"+data}).then(function(response){
                $("#corre_city").empty();
               $.each(response.data, function () {
                $("#corre_city").append($("<option></option>").val(this['id']).html(this['name']));
              });

              });*/
      };


    $scope.getdetails = function() 
    {
     
     if($scope.address_chk == true)
     {

      $scope.corre_apartment = $scope.parma_apartment;
      $scope.corre_colony = $scope.parma_colony;
      $scope.corre_area = $scope.parma_area;
      $scope.corre_state = $scope.parma_state;
      $scope.city_get_corre_state_for_data_get($scope.parma_state);
      $scope.corre_pincode = $scope.parma_pincode;
      $scope.corre_resi_phone = $scope.parma_resi_phone;
      $scope.corre_city = $scope.parma_city;

     }
     else
     {

      $scope.corre_apartment ='';
      $scope.corre_colony = '';
      $scope.corre_area = '';
      $scope.corre_state = '';
      $scope.corre_pincode = '';
      $scope.corre_resi_phone = '';
      $scope.corre_city = '';

     }

  };

}




// function mCalculate(){

//     var caterogry = $('input[name="category"]:checked').val();
//     var academic_percentage = $('input[name="academic_percentage"]').val();
//     console.log(caterogry);
//     console.log(academic_percentage);

//    if((caterogry =="General" || caterogry =="EWS" || caterogry =="OBC") && academic_percentage < 50)
//           {
//             $("#m_criteria").html("Marks Criteria Not Matched");
            
//           }

// }



function ageCalculate(){

   if (!$('input[name="category"]').is(':checked')) 
   {
      $("#age_criteria").html("Select Category First");
      return false;
   }
   else
   {
     
      var caterogry = $('input[name="category"]:checked').val();
      var birthDate =document.getElementById('birth_date').value;
      var d = new Date(birthDate);
      var mdate = birthDate.toString();
      var yearThen = parseInt(mdate.substring(0,4), 10);
      var monthThen = parseInt(mdate.substring(5,7), 10);
      var dayThen = parseInt(mdate.substring(8,10), 10);
      //var today = new Date();
    var today = new Date("01 Jul 2023 23:59:59 GMT");
      var birthday = new Date(yearThen, monthThen-1, dayThen);
      var differenceInMilisecond = today.valueOf() - birthday.valueOf();
      var year_age = Math.floor(differenceInMilisecond / 31536000000);
      var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);
      var month_age = Math.floor(day_age/30);
      day_age = day_age % 30;
      var tMnt= (month_age + (year_age*12));
      var tDays =(tMnt*30) + day_age;
      document.getElementById("age").innerHTML = year_age + " years " + month_age + " months " + day_age + " days";


          $("#age_criteria").html("");
          $("#btnSubmit").removeAttr('disabled');
          //if(caterogry !="SC" && year_age >= 22 || caterogry !="ST" && year_age >= 22)
         // {
            //$("#age_criteria").html("Age Criteria Not Matched");
            //$("#btnSubmit").attr('disabled','disabled');
          //}
          
          //if(caterogry =="SC" && year_age >= 27 || caterogry =="ST" && year_age >= 27)
          //{
            //$("#age_criteria").html("Age Criteria Not Matched");
            //$("#btnSubmit").attr('disabled','disabled');
          //}
      
      if((caterogry =="SC" || caterogry =="ST") && year_age >= 27)
          {
            $("#age_criteria").html("Age Criteria Not Matched");
            $("#btnSubmit").attr('disabled','disabled');
          }
      
      if((caterogry =="General" || caterogry =="EWS" || caterogry =="OBC") && year_age >= 22)
          {
            $("#age_criteria").html("Age Criteria Not Matched");
            $("#btnSubmit").attr('disabled','disabled');
          }
      
      
      

       }

 
  

}
</script>


<script>

</script>

<script type="text/javascript">
  $('.common').on('change', function() {
    $('.common').find('option').prop('disabled', false);
    $('.common').each(function() {
       $('.common').not(this).find('option[value="' + this.value + '"]').prop('disabled', true); 
    });
  });

  $('.common_code').on('change', function() {
    $('.common_code').find('option').prop('disabled', false);
    $('.common_code').each(function() {
       $('.common_code').not(this).find('option[value="' + this.value + '"]').prop('disabled', true); 
    });
  });


 $('.center_city').on('change', function() {
    $('.center_city').find('option').prop('disabled', false);
    $('.center_city').each(function() {
       $('.center_city').not(this).find('option[value="' + this.value + '"]').prop('disabled', true); 
    });
  });




</script>


<script type="text/javascript">
  $(document).ready(function(){
      $("#photo_check").hide();
      $("#sig-req").hide();
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


  $(".know").click(function () {
            var selected = new Array();
            $("#tblFruits input[type=checkbox]:checked").each(function () {
                selected.push(this.value);
            });
 
            if (selected.length > 0) {
                $("#know_concate").val(selected.join(","));
            }
      else{
        $("#know_concate").val("");
      }
        });




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
#loader-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}
#loader {
    display: block;
    position: relative;
    left: 50%;
    top: 50%;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #3498db;

    -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
    animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    z-index: 1001;
}

    #loader:before {
        content: "";
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #e74c3c;

        -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
        animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    }

    #loader:after {
        content: "";
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #f9c922;

        -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
          animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    }

    @-webkit-keyframes spin {
        0%   { 
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }
    @keyframes spin {
        0%   { 
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }

    #loader-wrapper .loader-section {
        position: fixed;
        top: 0;
        width: 50%;
        height: 100%;
        background: #22222285;
        z-index: 1000;
    }

    #loader-wrapper .loader-section.section-left {
        left: 0;
    }
    #loader-wrapper .loader-section.section-right {
        right: 0;
    }

    /* Loaded styles */
    .loaded #loader-wrapper .loader-section.section-left {
        -webkit-transform: translateX(-100%);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(-100%);  /* IE 9 */
                transform: translateX(-100%);  /* Firefox 16+, IE 10+, Opera */

        -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);  /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
                transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);  /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
    }
    .loaded #loader-wrapper .loader-section.section-right {
        -webkit-transform: translateX(100%);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(100%);  /* IE 9 */
                transform: translateX(100%);  /* Firefox 16+, IE 10+, Opera */

        -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);  /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
                transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);  /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
    }
    .loaded #loader {
        opacity: 0;

        -webkit-transition: all 0.3s ease-out;  /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
                transition: all 0.3s ease-out;  /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */

    }
    .loaded #loader-wrapper {
        visibility: hidden;

        -webkit-transform: translateY(-100%);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateY(-100%);  /* IE 9 */
                transform: translateY(-100%);  /* Firefox 16+, IE 10+, Opera */
    
        -webkit-transition: all 0.3s 1s ease-out;  /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
                transition: all 0.3s 1s ease-out;  /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
    }
</style>