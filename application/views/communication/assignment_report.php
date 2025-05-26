<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('../layout/head.php'); ?>
    <!-- <script src="<?= base_url(); ?>themes/js/jquery.min.js"></script> -->

    <script src="<?= base_url(); ?>themes/js/angular.min.js"></script>
    <script src="<?= base_url(); ?>themes/js/angular-ui.min.js"></script>
    <style type="text/css">
        .select2 {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: #444 !important;
            border: none !important;
        }

        .badge {
            background-color: #000 !important;
        }
    </style>

</head>

<body class="skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">
        <div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>
        <?php $this->load->view('../layout/header.php'); ?>
        <!-- Left side column. contains the logo and sidebar -->

        <?php $this->load->view('../layout/sidemenu.php');
        sidebar(1207);
        ?>



        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <section class="content-header">
                <h1>
                    Assignment Report
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Communication</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="page-content">

                    <div class="box">
                        <div class="box-body" style="max-height: 700px; overflow-y: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>Assignment</th>
                                        <th>Campaign</th>
                                        <th>Team</th>
                                        <th>Candidate</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($assignment as $key => $assignments) {
                                        $count = $this->db->select('*')->from('assignment')->where('assignment_id', $assignments->id)->get()->num_rows();

                                    ?>
                                        <tr>
                                            <td><?= $assignments->id ?></td>
                                            <td><?= $assignments->assignment_name ?></td>
                                            <td><a data-id='<?= $assignments->cid ?>' style="cursor: pointer;" class="campaign_modal_btn"><?= $assignments->cname ?></a></td>
                                            <td><?= $assignments->team ?></td>
                                            <td><?= $count; ?></td>
                                            <td><?php if ($assignments->assignment_start != '0000-00-00') {
                                                    echo date('d-m-Y', strtotime($assignments->assignment_start));
                                                } ?></td>
                                            <td><?php if ($assignments->assignment_end != '0000-00-00') {
                                                    echo date('d-m-Y', strtotime($assignments->assignment_end));
                                                } ?></td>
                                            <td><?= $assignments->created_at ?></td>
                                            <td>
                                                <a href="<?= site_url('communication/assignment_details/') . $assignments->id ?>" class="btn btn-primary btn_click">View</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>



        <div class="modal fade" id="campaign_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 999999;">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top: 15%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Campaign Details</h5>

                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Campaign Name</label><br />
                            <span id="campagin_name"></span>
                        </div>

                        <div class="form-group">
                            <label>Campaign Desc</label><br />
                            <span id="campagin_desc"></span>
                        </div>

                        <div class="form-group">
                            <label>Campaign Responses</label><br />
                            <span id="campagin_res"></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <?php $this->load->view('../layout/footer.php'); ?>


        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

</body>

</html>


<script>
    $(document).ready(function() {

        $("#loading").hide();
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            showButtonPanel: true,
            autoclose: true,
        });

        $(".js-example-basic-multiple").select2();
        $(".datepicker").datepicker("setDate", new Date());

        $(".timepicker").timepicker();

    });


    $(document).on('click', ".campaign_modal_btn", function() {

        var id = $(this).attr('data-id');
        $.ajax({
            url: "get_campaign_with_response",
            method: 'POST',
            data: {
                'id': id
            },
            success: function(result) {
                var data = JSON.parse(result);
                console.log(result);

                $("#campagin_name").html(data['campaign'][0]['name']);
                $("#campagin_desc").html(data['campaign'][0]['description']);
                $("#campagin_res").html(data['response']);
            }
        });

        $("#campaign_modal").modal('show');
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
        z-index: 99999;
    }
</style>