<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('../layout/head.php'); ?>

    <style type="text/css">
        .checkbox,
        .radio {
            position: relative;
            display: inline-block;
            margin-top: 10px;
            margin-bottom: 10px;
            margin-right: 20px;
        }

        .field_icon {
            position: absolute;
            margin-top: -23px;
            right: 28px;
        }
    </style>

    <!-- for the description box with tinymce -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="home_screen">
    <div class="wrapper">

        <?php $this->load->view('../layout/header.php'); ?>
        <!-- Left side column. contains the logo and sidebar -->

        <?php $this->load->view('../layout/sidemenu.php');
        sidebar(1210);
        ?>
        <div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Upload Bulk Leads
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
                        <div class="col-sm-4">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Create</h3>
                                </div>
                                <div class="box-body box-danger">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form id="masterForm" action="create_master" method="POST">
                                                <div class="form-group">
                                                    <label>Title <span style='color:red;'>*</span></label>
                                                    <input id="title" type="text" class="form-control" name="title" required="" />
                                                </div>

                                                <div class="form-group">
                                                    <label>Source</label>
                                                    <input id="source" type="text" class="form-control" name="source" />
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="save" id="saveBtn">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-8">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Upload Bulk Data</h3>
                                </div>
                                <div class="box-body box-danger">

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a href="<?= base_url('bulklead/download_sample') ?>" id="downloadSampleBtn" class="btn btn-success" style="margin-bottom: 20px;" >Download Sample File</a>

                                            <form method="post" action="upload_data">
                                                <div class="form-group">
                                                    <label>Select Title: <span style='color:red;'>*</span></label>
                                                    <select name="title" class="form-control" id="title_select" required="">
                                                        <option value="">--Select Title--</option>
                                                        <?php foreach ($title as $tit): ?>
                                                            <option value="<?= $tit['id'] ?>"><?= $tit['title'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Upload File:<span style='color:red;'>*</span></label>
                                                    <input type="file" id="upload_file" name="upload_file" accept=".csv,.xls,.xlsx" required="" />
                                                </div>

                                                <button id="uploadBtn" type="submit" class="btn btn-primary">Upload</button>
                                            </form>
                                        </div>
                                    </div>
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
            $('#saveBtn').click(function() {
                let title = $('#title').val().trim();
                let source = $('#source').val().trim();

                $.ajax({
                    url: '<?= site_url("bulklead/create_master") ?>',
                    type: 'POST',
                    data: {
                        title: title,
                        source: source,
                        // save: true
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#masterForm')[0].reset();
                            alert(response.message); // or show success message in your UI
                            // Optionally reload the source dropdown here
                            loadSourcesDropdown();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        $('#message').html('<p style="color:red;">An error occurred. Please try again.</p>');
                    }
                });
            });

            $('#uploadBtn').click(function(e) {
                e.preventDefault();

                var source = $('#title_select').val();
                var fileInput = $('#upload_file')[0];

                var formData = new FormData();
                formData.append('title', source);
                formData.append('upload_file', fileInput.files[0]);

                $.ajax({
                    url: '<?= site_url("bulklead/upload_data") ?>',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // $('#message').html('<p style="color:green;">' + response.message + '</p>');
                        // Optionally clear form
                        $('#title_select').val('');
                        $('#upload_file').val('');
                    },
                    error: function(xhr) {
                        $('#message').html('<p style="color:red;">Upload failed: ' + xhr.responseText + '</p>');
                    }
                });
            })

            $('#downloadSampleBtn').click(function(e) {
                e.preventDefault();
                window.location.href = '<?= site_url("bulklead/download_sample") ?>';
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
                z-index: 99;
            }

            .select2 {
                width: 100% !important;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background: #444 !important;
                border: none !important;
            }
        </style>
</body>

</html>