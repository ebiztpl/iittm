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

    <!-- Correct TinyMCE CDN with version and valid API key -->
    <!-- Correct TinyMCE CDN with version and valid API key -->
<script src="https://cdn.tiny.cloud/1/k0ud6ova6zim15fcfyjhcqo5irdp4tgok5hr4zyfcr1w1xee/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>



    <script>
        tinymce.init({
            selector: '#description', // Target your textarea
            height: 200,
            menubar: false,
            plugins: 'advlist autolink lists link image charmap  preview anchor ' +
                'searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
            alignleft aligncenter alignright alignjustify | \
            bullist numlist outdent indent | removeformat | help'
        });


        tinymce.init({
            selector: '#edit-description',
            height: 200,
            menubar: false,
            plugins: 'advlist autolink lists link image charmap preview anchor ' +
                'searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | removeformat | help',
            setup: function(editor) {
                editor.on('init', function() {
                    editor.setContent($('#edit-description').val());
                });
            }
        });
    </script>

    <!-- select2 cdn links -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>

<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="home_screen">
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
                    Create/View Work Logs
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

                                            <form action="create_worklogs" method="POST">
                                                <div class="form-group">
                                                    <label>Title <span style='color:red;'>*</span></label>
                                                    <input type="text" class="form-control" name="title" value="" required="" />
                                                </div>

                                                <div class="form-group">
                                                    <!-- <label>Team Member Name <span style='color:red;'>* (Type Text & Press Enter)</span></label> -->
                                                    <label>Team Member Name <span style='color:red;'>*</span></label>
                                                    <select name="team_members[]" id="team_members" class="form-control" multiple="multiple" required="">
                                                        <?php foreach ($team_members as $member): ?>
                                                            <option value="<?= $member->admin_id ?>"><?= $member->admin_name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Category<span style='color:red;'>*</span> <a class="btn btn-primary btn-xs category-create" style="margin-left: 10px;">Add</a></label>
                                                    <select name="categories[]" id="categories" class="form-control category" multiple required="">
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?= $category->name ?>"><?= $category->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Work Log Date <span style='color:red;'>*</span></label>
                                                    <input type="date" id="" class="form-control" name="date" required="" />
                                                </div>

                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea type="text" class="form-control" id="description" name="description"></textarea>
                                                </div>
                                                <button class="btn btn-primary" name="btnsubmit">Submit</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-8">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">WorkLogs List</h3>
                                </div>
                                <div class="box-body box-danger">

                                    <div class="row">
                                        <div class="col-sm-12" style="max-height: 570px; overflow-y: auto;">
                                            <table class="table table-bordered" id="sample_data">
                                                <thead>
                                                    <tr>
                                                        <th>Sr.</th>
                                                        <th>Title</th>
                                                        <th>Team Member Name</th>
                                                        <th>Category</th>
                                                        <th>Date</th>
                                                        <!-- <th>Description</th> -->
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    usort($result, function ($a, $b) {
                                                        return strtotime($b->date) - strtotime($a->date);
                                                    });
                                                    foreach ($result as $key => $list) {
                                                        $i++; ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <!-- <td><?php echo $list->title; ?></td> -->
                                                            <td>
                                                                <span data-toggle="tooltip" data-placement="top" title="<?= htmlspecialchars(strip_tags($list->description)) ?>">
                                                                    <?= htmlspecialchars($list->title) ?>
                                                                </span>
                                                            </td>
                                                            <td><?php echo $list->team_member_name; ?></td>
                                                            <td><?php echo $list->category; ?></td>
                                                            <td><?php echo $list->date; ?></td>
                                                            <!-- <td><?php echo $list->description; ?></td> -->
                                                            <td>

                                                                <a class="btn btn-primary btn-xs edit" data-id='<?php echo $list->id; ?>'><i class="fa fa-pencil"></i> Edit</a>
                                                                <a class="btn btn-danger btn-xs delete" data-id='<?php echo $list->id; ?>'><i class="fa fa-trash"></i> Delete</a>
                                                            </td>

                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
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
            $(document).ready(function() {
                $('.select2').select2();

                $('.edit').on('click', function() {

                    var id = $(this).attr('data-id');
                    $.ajax({
                        url: "get_worklogs",
                        method: 'POST',
                        data: {
                            'id': id
                        },
                        success: function(result) {
                            console.log(result);

                            var data = JSON.parse(result);

                            $("#edit_id").val(data[0]['id']);
                            $("#title_edit").val(data[0]['title']);
                            $("#date_edit").val(data[0]['date']);

                            var teamMembers = data[0]['team_member_name'].split(',').map(item => item.trim());
                            $('#edit_team_members').val(teamMembers).trigger('change');

                            var categories = data[0]['category'].split(',').map(item => item.trim());
                            $('#edit_categories').val(categories).trigger('change');

                            tinymce.get('edit-description').setContent(data[0]['description']);
                            $("#edit-description").val(data[0]['description']);
                        }
                    });
                    $("#edit").modal('show');
                });
            });


            $('.delete').on('click', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "delete_worklogs",
                    method: 'POST',
                    data: {
                        'id': id
                    },
                    success: function(result) {
                        if (result == 1) {
                            alert('Work Log has been deleted!');
                            location.reload();
                        }
                        console.log(result)
                    }
                });
            });
        </script>


        <div class="modal fade" id="category-create-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 999999;">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top: 15%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Category</h5>
                        <span style="position: absolute; top: 15px; right: 15px; cursor: pointer;"><i class="fa fa-close fa-close-category"></i></span>
                    </div>
                    <div class="modal-body">
                        <form id="save-category">
                            <input type="text" id="new_category" name="category-create" class="form-control" required="">
                            <br />
                            <button class="btn btn-danger" id="submitButton">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>

                    </div>
                    <div class="modal-body">
                        <form action="edit_worklogs" method="POST">
                            <input type="hidden" name="edit_id" id="edit_id">
                            <div class="form-group">
                                <label>Title <span style='color:red;'>*</span></label>
                                <input type="text" class="form-control" id="title_edit" name="title_edit" value="" required="" />
                            </div>

                            <div class="form-group">
                                <label>Team Members</label>
                                <select id="edit_team_members" name="team_member_name[]" class="form-control select2" multiple>
                                    <?php foreach ($team_members as $member): ?>
                                        <option value="<?= $member->admin_name ?>"><?= $member->admin_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Categories</label>
                                <select id="edit_categories" name="category[]" class="form-control select2 category" multiple>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->name ?>"><?= $category->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Date <span style='color:red;'>*</span></label>
                                <input type="date" id="date_edit" class="form-control" name="date_edit" required="" />

                            </div>

                            <div class="form-group">
                                <label>Description </label>
                                <textarea type="text" class="form-control" id="edit-description" name="description_edit"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update changes</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function() {
                $('#team_members').select2({
                    placeholder: "Select or Type Team Members Name",
                    allowClear: true,
                    width: '100%'
                });
            });

            $(document).ready(function() {
                $('#categories').select2({
                    placeholder: "Select or Type Categories",
                    allowClear: true,
                    width: '100%'
                });
            });


            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            $(".fa-close-category").click(function() {
                $("#category-create-modal").modal('hide');
            });

            $(document).on('click', ".category-create", function() {
                $("#category-create-modal").modal('show');
            });

            function get_category() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('worklogs/get_category'); ?>",
                    success: function(data) {
                        console.log(data);
                        data = jQuery.parseJSON(data);
                        $(".category").select2({
                            data: data,
                            allowClear: false,
                            minimumResultsForSearch: 2
                        });
                    },
                });
            }

            $("#submitButton").click(function(event) {
                event.preventDefault();

                let form = $("#save-category");

                // var categoryName = $('#new_category').val().trim();
                // if (categoryName === '') {
                //     alert('Please Enter a Category Name.');
                //     return;
                // }

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('worklogs/create_category'); ?>",
                    dataType: "json",
                    data: form.serialize(),
                    success: function(data) {
                        if (data.success) {
                            alert(data.message);
                            $("#category-create-modal").modal('hide');
                            get_category(); // refresh dropdown
                            $('#new_category').val('');
                        } else {
                            alert(data.message);
                        }
                        // alert("Category Created Successfully");
                        // $("#category-create-modal").modal('hide');
                        // get_category()

                    },
                    error: function(data) {
                        alert("Error occurred while submitting the form");
                    }
                });
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