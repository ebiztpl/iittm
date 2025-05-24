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
                    Report Details
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">My Report</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="page-content">
                    <div class="box">
                        <div class="box-body">
                            <!-- <span style="font-size: 20px; color: green; text-align: right; margin-left: 50px; float: right">Total Records - <span id="record">0</span></span> -->

                            <!-- <span style="font-size: 20px; color: green; text-align: right; display: block; ">Complete - <span id="complete">0</span></span> -->
                             
                            <div style="overflow:scroll; height:500px;">
                                <table id="item-list-filter" class="table table-bordered table-striped table-hover ">
                                    <thead>
                                        <tr>
                                            <?php if ($this->session->userdata['role'] == 'telecaller') { ?>
                                                <th class="tbl-header">Action</th>
                                            <?php } else { ?>
                                                <th class="tbl-header">Sr.</th>
                                            <?php } ?>
                                            <th class="tbl-header">Candidate Information</th>
                                            <th style='width:30%;'>Academic Information</th>
                                            <th style='width:40%;'>Communication</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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



        <<script>
            $(document).ready(function() {
            $("#loading").show();

            var assignmentId = <?= json_encode($assignment_id) ?>;
            var responseId = <?= json_encode($response_id) ?>;
            var fromDate = <?= json_encode($from_date) ?>;
            var toDate = <?= json_encode($to_date) ?>;

            $('#item-list-filter').DataTable({
            ajax: {
            url: "<?= site_url('Myreport/report_details2'); ?>",
            type: 'POST',
            data: function(d) {
            d.assignment_id = assignmentId;
            d.response_id = responseId;
            d.from_date = fromDate;
            d.to_date = toDate;
            },
            complete: function() {
            $("#loading").hide();
            }
            },
            columns: [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 }
            ],
            order: [[0, "asc"]],
            paging: false,
            searching: false
            });
            });
        </script>
</body>

</html>



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