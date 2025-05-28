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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
                            <input type="hidden" id="assignment_id" value="<?= $assignment_id ?>">
                            <div class="row" id="filter-section">
                                <div class="col-sm-2">
                                    <select class="form-control" name="tag[]" id="tag_filter" multiple>
                                        <?php foreach ($tags as $tag): ?>
                                            <option value="<?= $tag->tag_id ?>"><?= $tag->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Response Dropdown -->
                                <div class="form-group col-sm-2">
                                    <select class="form-control" name="response_id[]" id="response_filter" multiple>
                                        <?php foreach ($responses as $response): ?>
                                            <option value="<?= $response->id ?>"><?= $response->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Search Button -->
                                <div class="col-sm-2">
                                    <button type="button" id="filterBtn" class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="box">
                        <div class="box-body">
                            <!-- <span style="font-size: 20px; color: green; text-align: right; margin-left: 50px; float: right">Complete - <span id="complete">0</span></span> -->

                            <span style="font-size: 20px; color: green; text-align: right; display: block; ">Total Records - <span id="record">0</span></span>

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



        <script>
            $(document).ready(function() {
                $('#tag_filter').select2({
                    placeholder: "Select Tags"
                });

                $('#response_filter').select2({
                    placeholder: "Select Responses"
                });
            });

            $(document).ready(function() {
                $("#loading").show();

                var assignmentId = <?= json_encode($assignment_id) ?>;
                var responseId = <?= json_encode($response_id) ?>;
                var fromDate = <?= json_encode($from_date) ?>;
                var toDate = <?= json_encode($to_date) ?>;

                $('#item-list-filter').DataTable({
                    ajax: {
                        url: "<?= site_url('Myreport/report_details_display'); ?>",
                        type: 'POST',
                        data: function(d) {
                            d.assignment_id = assignmentId;
                            d.response_id = responseId;
                            d.from_date = fromDate;
                            d.to_date = toDate;
                        },
                        // complete: function(e) {
                        //     $("#loading").hide();
                        //     $("#record").html(e.json.recordsTotal);
                        //     $("#complete").html(e.json.recordsComplete);
                        // }
                    },
                    columns: [{
                            data: 0
                        },
                        {
                            data: 1
                        },
                        {
                            data: 2
                        },
                        {
                            data: 3
                        }
                    ],
                    order: [
                        [0, "asc"]
                    ],
                    fixedHeader: true,
                    bPaginate: false,
                    bLengthChange: false,
                    bFilter: false,
                    bSort: true,
                    bInfo: true,
                    bAutoWidth: false,
                    searching: true,
                    retrieve: true,
                    destroy: true,
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [25, 50, -1],
                        ['25 rows', '50 rows', 'Show all']
                    ],
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var info = api.page.info();
                        $("#record").text(info.recordsDisplay);
                    }
                });


                $("#filterBtn").on('click', function() {

                    $("#loading").show();
                    $('#item-list_wrapper').hide();
                    $('#item-list-filter').show();

                    $('#item-list-filter').DataTable({
                        "ajax": {
                            url: "<?php echo site_url('Myreport/report_details_display_filter'); ?>",
                            data: function(d) {
                                d.assignment_id = $("#assignment_id").val();
                                d.response_ids = $("#response_filter").val(); // array
                                d.tag_ids = $("#tag_filter").val(); // array
                                d.from_date = $("#from_date").val();
                                d.to_date = $("#to_date").val();
                            },
                            type: 'POST'
                        },
                        initComplete: function(e) {
                            $("#loading").hide();
                        },
                        "bPaginate": true,
                        "bLengthChange": false,
                        "bFilter": false,
                        "bSort": true,
                        "order": [0, "asc"],
                        "bInfo": true,
                        "bAutoWidth": false,
                        "searching": true,
                        "bRetreive": true,
                        "destroy": true,
                        dom: 'Bfrtip',
                        lengthMenu: [
                            [25, 50, -1],
                            ['25 rows', '50 rows', 'Show all']
                        ],
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                        "drawCallback": function(settings) {
                            var api = this.api();
                            var info = api.page.info();
                            $("#record").text(info.recordsDisplay);
                        }
                    });
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