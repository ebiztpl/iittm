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
        sidebar(1208);
        ?>
        <div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    View My Report
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
                    <?php
                    if (hasFlash('ViewMsgSuccess')) {
                        echo getFlash('ViewMsgSuccess');
                    }
                    if (hasFlash('ViewMsgWarning')) {
                        echo getFlash('ViewMsgWarning');
                    }
                    ?>

                    <div class="box">
                        <div class="box-body">
                            <div class="row" id="filter-section">
                                <div class="col-sm-2">
                                    <input type="text" id="from" class="form-control datepicker" placeholder="From Date">
                                </div>

                                <div class="col-sm-2">
                                    <input type="text" id="to" class="form-control datepicker" placeholder="To Date">
                                </div>

                                <div class="col-sm-2">
                                    <button type="button" id="search_btn" class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-1">

                                </div>
                                <div class="col-sm-10">
                                    <!-- <div class="box-header" style="text-align:center; font-size:24px; background-color:#e0e0e0; padding:4px;">
                                        <h3 class="box-title"><strong>ABSENT/FAIL ENTRANCE EXAM CANDIDATE</strong></h3>
                                    </div> -->
                                    <table class="table table-bordered table-hover text-center" id="report_table">
                                        <thead id="report_head" style="display: none;">
                                            <tr>
                                                <th colspan="3" id="assignment-title" style="text-align:center; font-size:24px; background-color:#e0e0e0; padding:4px;">

                                                </th>
                                            </tr>
                                            <tr style="font-size:18px;">
                                                <th style="width: 150px;">S.No.</th>
                                                <th id="report-title"></th>
                                                <th style="width: 150px;">Total Count</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                                <div class="col-sm-1">

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
            $(function() {
                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });
            });

            $(document).ready(function() {
                // Initially hide the table head
                $('#report_head').hide();

                // Show default message before search
                $('#report_table tbody').html(`<tr><td colspan="3" style="text-align: center; font-weight: bold; font-size: 18px; background-color: #e2e3e5; color: #383d41; padding: 6px; border: 1px solid #d6d8db;">📅 Please Select a Date Range to View the Report. </td></tr>`);

                $('#search_btn').on('click', function() {
                    var from = $('#from').val();
                    var to = $('#to').val();

                    if (from === "" || to === "") {
                        alert("Please select both from and to dates.");
                        return;
                    }

                    $.ajax({
                        url: "<?php echo site_url('Myreport/fetch_report'); ?>",
                        type: "POST",
                        data: {
                            from: from,
                            to: to
                        },
                        dataType: "json",
                        success: function(data) {                            
                            var reportData = data.data; // The response data array
                            var assignments = data.assignments; // The assignment names string
                            var html = '';
                            var totalAll = 0;

                            if (reportData.length === 0) {
                                $('#report_head').hide();

                                html = '<tr> <td colspan = "3" style = "text-align: center; font-weight: bold; font-size: 18px; background-color: #f8d7da; color: #721c24; padding: 6px; border: 1px solid #f5c6cb;" > 🚫 No Data Found for the Selected Date Range! </td> </tr>';

                                $('#report_table tbody').html(html);
                                $('#report-title').html('');
                                $('#assignment-title').html('');

                            } else {
                                $('#report_head').show();
                                $('#assignment-title').html('Assignment(s): ' + assignments);
                                $('#report-title').html('Report as: (' + from + ' to ' + to + ')');

                                $.each(reportData, function(index, value) {
                                    totalAll += parseInt(value.total);
                                });

                                // Insert Total row at top
                                html += '<tr style="font-size:16px; font-weight:bold;">';
                                html += '<td>1</td>';
                                html += '<td><strong>Total Calls</strong></td>';
                                html += '<td>' + totalAll + '</td>';
                                html += '</tr>';


                                // Append rest of data
                                $.each(reportData, function(index, value) {
                                    html += '<tr style="font-size:16px;">';
                                    html += '<td>' + (index + 2) + '</td>';
                                    html += '<td><strong>' + value.response + '</strong></td>';
                                    html += '<td>' + value.total + '</td>';
                                    html += '</tr>';
                                });
                            }
                            $('#report_table tbody').html(html);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            alert("Something went wrong");
                        }
                    });
                });

                $('#report_head').hide();
            });
        </script>

        <!-- <script>
            $(document).ready(function() {
                $('#report_table').DataTable({
                    "fixedHeader": true,
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "order": [0, "asc"],
                    "bInfo": true,
                    "bAutoWidth": false,
                    // "searching": true,
                    "bRetreive": true,
                    "destroy": true,

                    dom: 'Bfrtip',
                    lengthMenu: [
                        [25, 50, -1],
                        ['25 rows', '50 rows', 'Show all']
                    ],
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                });
            });
        </script> -->

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