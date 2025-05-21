<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('../layout/head.php'); ?>

  <style type="text/css">
    .require {
      color: red;
    }
  </style>



  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url(); ?>themes/bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url(); ?>themes/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url(); ?>themes/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url(); ?>themes/dist/css/AdminLTE.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url(); ?>themes/plugins/iCheck/square/blue.css">

  <script src="<?= base_url(); ?>themes/js/jquery.min.js"></script>

  <script src="<?= base_url(); ?>themes/js/angular.min.js"></script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src='https://www.google.com/recaptcha/api.js'></script>


  <!-- for the query description box with tinymce -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- TinyMCE CDN with version and valid API key -->
  <script src="https://cdn.tiny.cloud/1/kjnz7rljuofa7jce4904eidi6gi8r7zy0lwyt1k54h1jxrr0/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      tinymce.init({
        selector: '#problem',
        height: 300,
        menubar: false,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        setup: function(editor) {
          const form = document.getElementById('myForm'); // Use your actual form ID
          const errorSpan = document.getElementById('problem-error');

          form.addEventListener('submit', function(e) {
            const content = editor.getContent({
              format: 'text'
            }).trim();

            if (!content) {
              e.preventDefault();

              // Show error message
              errorSpan.style.display = 'inline';

              // Scroll to the visible TinyMCE editor container
              const editorContainer = editor.getContainer();
              editorContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
              });

              // Focus the editor
              setTimeout(() => {
                editor.focus();
              }, 100);
            } else {
              errorSpan.style.display = 'none';
            }
          });
        }
      });
    });
  </script>



  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


</head>

<!-- <body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="home_screen"> -->

<body class="skin-blue sidebar-mini sidebar-collapse">
  <div class="wrapper">

    <?php $this->load->view('../layout/header.php'); ?>
    <!-- Left side column. contains the logo and sidebar -->

    <?php $this->load->view('../layout/sidemenu.php');
    sidebar(1208);
    ?>

    <div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Query/Issue Form
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Users</li>
        </ol>
      </section>




      <!-- Main content -->
      <section class="content">
        <div class="page-content">
          <?php
          if (hasFlash('ViewMsgSuccess')) {
            echo getFlash('ViewMsgSuccess');
          }
          if (hasFlash('ViewMsgWarning')) {
            echo getFlash('ViewMsgWarning');
          }
          ?>

          <div class="row">
            <div class="col-sm-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Query Form</h3>
                </div>

                <form action="ticket" id="myForm" name="LoginForm" method="POST" enctype="multipart/form-data">
                  <div class="" style="padding: 20px;">
                    <div class="row gap-4">
                      <div class="col-sm-4">
                        <div class="form-group has-feedback">
                          <label>Course Applied<span class="require">*</span></label>
                          <select class="form-control" name="course" id="course" ng-model="course" required="">
                            <option value="">--Select--</option>
                            <option value="1">BBA(TT)-2021-24</option>
                            <option value="2">MBA(TTM)-2021-23</option>
                          </select>

                        </div>
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group has-feedback">
                          <label>Your Name<span class="require">*</span></label>
                          <select class="form-control" name="name" id="student" ng-model="course" required="">
                            <option value="">--Select Student--</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group has-feedback">
                          <label>Email Id Filled for Registration<span class="require">*</span></label>
                          <span class="fa fa-envelope form-control-feedback"></span>
                          <input type="text" class="form-control" name="txt_email" id="txt_email" autocomplete="off" ng-pattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/" ng-model="txt_email" required="" readonly>
                        </div>
                      </div>


                    </div>


                    <div class="row gap-4">
                      <div class="col-sm-4">
                        <div class="form-group has-feedback">
                          <label>Mobile Number Filled for Registration<span class="require">*</span></label>
                          <input type="text" class="form-control" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="10" id="father_mobile" name="father_mobile" ng-model="father_mobile" required="" autocomplete="off" readonly>
                          <span class="fa fa-phone form-control-feedback" style="padding-top: 0px;"></span>
                        </div>
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group has-feedback">
                          <label>Alternate Mobile Number<span class="require">*</span></label>
                          <span class="fa fa-phone form-control-feedback" style="padding-top: 0px;"></span>
                          <input type="text" class="form-control" ng-pattern="/^[0-9]+$/" ng-minlength="10" ng-maxlength="10" id="your_father_mobile" name="your_father_mobile" ng-model="your_father_mobile" required="" autocomplete="off">
                          <span id="alt_mobile_error" style="color: red; font-size: 0.9em;"></span>

                        </div>
                      </div>

                      <div class="col-sm-4">
                        <div class="form-group has-feedback">
                          <label>Alternate Email Id<span class="require">*</span></label>
                          <span class="fa fa-envelope form-control-feedback"></span>
                          <input type="text" class="form-control" name="your_txt_email" id="your_txt_email" autocomplete="off" ng-pattern="/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/" ng-model="your_txt_email" required="">
                          <span id="alt_email_error" style="color: red; font-size: 0.9em;"></span>
                        </div>
                      </div>
                    </div>


                    <div class="row gap-4">
                      <div class="col-sm-12">
                        <div class="form-group has-feedback">

                          <label>Query/Issue Description.<span class="require">*</span></label>
                          <span id="problem-error" style="display:none; color: red; font-size: 0.9em; margin-left: 10px;">
                            This field is required *.
                          </span>
                          <textarea type="text" class="form-control" id="problem" name="problem"></textarea>
                          <span class="fa fa-question form-control-feedback" style="padding-top: 0px;"></span>
                        </div>
                      </div>
                    </div>


                    <div class="row gap-4">
                      <div class="col-sm-2">
                        <div class="image-upload">
                          <label>Upload any screen shot</label>
                          <input type="file" id="file-input" name="file" type="file" ng-model="file" onchange="angular.element(this).scope().setFile(this)">
                          <br />
                          <!-- <span style="color: red;">{{FileMessage}}</span> -->
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group">
                          <br />
                          <label>Is it<span class="require">*</span></label> &nbsp;
                          <input type="radio" name="form_type" id="form_type" ng-model="form_type" value="query" required=""> Query&nbsp; &nbsp;
                          <input type="radio" name="form_type" id="form_type" ng-model="form_type" value="issue" required=""> Issue
                          <br />
                        </div>
                      </div>
                    </div>


                    <div class='form-group text-center'>
                      <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div>
                      <button class="btn btn-success btn-lg" type="submit" name="btnSubmit">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
      </section>
    </div>

    <?php $this->load->view('../layout/footer.php'); ?>


    <script>
      $(document).ready(function() {
        // Select2 on the student dropdown
        $('#student').select2({
          placeholder: "--Select or Search a Student--",
          allowClear: true
        });

        $('#course').on('change', function() {
          var course = $(this).val();
          $.ajax({
            url: "<?= site_url('admin/fetch_candidates'); ?>",
            method: "POST",
            data: {
              course: course
            },
            success: function(data) {
              $('#student').html(data);
              $('#txt_email').val('');
              $('#father_mobile').val('');
            }
          });
        });

        $('#student').change(function() {
          var user_id = $(this).val();
          if (user_id !== '') {
            $.ajax({
              url: "<?= site_url('admin/get_email_mobile') ?>",
              type: "POST",
              data: {
                user_id: user_id
              },
              dataType: "json",
              success: function(data) {
                $('#txt_email').val(data.email_id);
                console.log(data);

                $('#father_mobile').val(data.mobile);
              }
            });
          } else {
            $('#txt_email').val('');
            $('#father_mobile').val('');
          }
        });


      });
    </script>



    <script>
      $(document).ready(function() {
        $("#loading").hide();

        $("#toggle_pwd").click(function() {
          $(this).toggleClass("fa-eye fa-eye-slash");
          var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
          $("#admin_password_edit").attr("type", type);
        });


        $("#toggle_pass").click(function() {
          $(this).toggleClass("fa-eye fa-eye-slash");
          var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
          $("#admin_pass").attr("type", type);
        });

      });
    </script>

    <script>
      function home_screen($scope, $log, $http, $window) {
        $scope.FileMessage = "";
        $scope.login_check = function($event) {

          console.log($scope.LoginForm);
          if ($scope.LoginForm.$invalid) {

            $scope.LoginForm.$submitted = true;
            $event.preventDefault();
          }
        };


        $scope.setFile = function(element) {
          $scope.$apply(function($scope) {
            $scope.theFile = element.files[0];
            $scope.FileMessage = '';
            var filename = $scope.theFile.name;
            var index = filename.lastIndexOf(".");
            var strsubstring = filename.substring(index, filename.length);
            if (strsubstring == '.png' || strsubstring == '.jpeg' || strsubstring == '.png' || strsubstring == '.gif' || strsubstring == '.jpg') {

              var f = element.files[0].size;
              if (f > 512000) {
                $scope.FileMessage = 'Size Below 500KB';
              } else {
                $scope.FileMessage = '';
              }
            } else {
              $scope.theFile = '';
              $scope.FileMessage = 'please upload correct File, extension should be .jpg, .jpeg, .png';
            }
          });
        };
      }
    </script>

    <script>
      document.querySelector("form").addEventListener("submit", function(e) {
        let isValid = true;
        let firstErrorField = null;

        const mobileField = document.getElementById("your_father_mobile");
        const emailField = document.getElementById("your_txt_email");

        const mobile = mobileField.value.trim();
        const email = emailField.value.trim();

        const mobileError = document.getElementById("alt_mobile_error");
        const emailError = document.getElementById("alt_email_error");

        // Clear previous errors
        mobileError.textContent = "";
        emailError.textContent = "";

        // Mobile validate
        const mobilePattern = /^\d{10}$/; // (/^\d{10,}$/) this is for atleast 10 digits
        if (!mobilePattern.test(mobile)) {
          mobileError.textContent = "Please Enter a Valid 10-Digit Mobile Number (Digits Only).";
          isValid = false;
          firstErrorField = mobileField;
        }

        // Email validate
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
          emailError.textContent = "Please Enter a Valid Email Address.";
          isValid = false;
          if (!firstErrorField) {
            firstErrorField = emailField;
          }
        }

        if (!isValid) {
          e.preventDefault();
          setTimeout(() => {
            firstErrorField.scrollIntoView({
              behavior: "smooth",
              block: "center"
            });
            firstErrorField.focus({
              preventScroll: true
            });
          }, 100);
        }
      });
    </script>


    <style>
      .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
        width: 100%;
      }

      .box-header .col-lg-2 {
        width: 16.66666667%;
        margin-left: 10px;
        margin-right: 10px;
      }

      .box-header .col-lg-3 {
        width: 25%;
        margin-left: 10px;
        margin-right: 10px;
      }

      #loading {
        width: 100%;
        height: 800px;
        position: absolute;
        background-color: rgba(0, 0, 0, 0.50) !important;
        text-align: center;
        padding-top: 30%;
        z-index: 9999;
      }
    </style>
</body>

</html>