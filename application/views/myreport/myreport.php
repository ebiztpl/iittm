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

    <script>
        // var reportDetailsURL = "<?= site_url('Myreport/report_details?assignment_id=') ?>" + assignment_id;
        var reportDetailsURL = "<?= site_url('Myreport/report_details') ?>";
    </script>

</head>

<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="home_screen">
    <div class="wrapper">

        <?php $this->load->view('../layout/header.php'); ?>
        <!-- Left side column. contains the logo and sidebar -->

        <?php $this->load->view('../layout/sidemenu.php');
        sidebar(1211);
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
                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                    <div class="col-sm-2">
                                        <select id="team_member" class="form-control">
                                            <option value="">Select Team Member</option>
                                            <?php foreach ($user as $u): ?>
                                                <option value="<?= $u->admin_id ?>"><?= $u->admin_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>


                                <div class="col-sm-2">
                                    <input type="text" id="from" class="form-control datepicker" placeholder="From Date">
                                </div>

                                <div class="col-sm-2">
                                    <input type="text" id="to" class="form-control datepicker" placeholder="To Date">
                                </div>

                                <div class="col-sm-1">
                                    <button type="button" id="search_btn" class="btn btn-success">Search</button>
                                </div>

                                <div class="col-sm-1">
                                    <button type="button" id="reset" class="btn btn-danger">Reset</button>
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
                                        <!-- <caption id="assignment-title" style="color: black; text-align:center; caption-side: top; font-size: 20px; font-weight: bold; background-color:#e0e0e0; padding:4px;"></caption> -->

                                        <thead id="report_head" style="display: none; background-color: #e0e0e0">
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

            $('#reset').click(function() {
                location.reload();
            });
            
            $(document).ready(function() {
                // Initially hide the table head
                $('#report_head').hide();

                // Show default message before search
                $('#report_table tbody').html(`<tr><td colspan="3" style="text-align: center; font-weight: bold; font-size: 18px; background-color: #e2e3e5; color: #383d41; padding: 6px; border: 1px solid #d6d8db;">📅 Please Select a Date Range to View the Report. </td></tr>`);

                $('#search_btn').on('click', function() {
                    var from = $('#from').val();
                    var to = $('#to').val();
                    var team_member = $('#team_member').val();

                    if (from === "" || to === "") {
                        alert("Please select both from and to dates.");
                        return;
                    }

                    $.ajax({
                        url: "<?php echo site_url('Myreport/fetch_report'); ?>",
                        type: "POST",
                        data: {
                            from: from,
                            to: to,
                            team_member: team_member
                        },
                        dataType: "json",
                        success: function(data) {
                            var assignmentReports = data.data; // The response data array
                            // var assignments = data.assignments; // The assignment names string
                            var html = '';
                            var totalAll = 0;


                            //  Populate team member dropdown dynamically
                            var teamMembers = data.team_members;
                            var teamMemberSelect = $('#team_member');
                            teamMemberSelect.empty();
                            teamMemberSelect.append('<option value="">Select Team Member</option>');
                            $.each(teamMembers, function(index, member) {
                                teamMemberSelect.append('<option value="' + member.admin_id + '">' + member.admin_name + '</option>');
                            });


                            if (assignmentReports.length === 0) {
                                $('#report_head').hide();

                                html = '<tr> <td colspan = "3" style = "text-align: center; font-weight: bold; font-size: 18px; background-color: #f8d7da; color: #721c24; padding: 6px; border: 1px solid #f5c6cb;" > 🚫 No Data Found for the Selected Date Range! </td> </tr>';

                                $('#report_table tbody').html(html);
                                $('#report-title').html('');
                                // $('#assignment-title').html('');

                            } else {
                                $('#report_head').show();
                                // $('#assignment-title').html('Assignment(s) Report');
                                $('#report-title').html('Report as: (' + from + ' to ' + to + ')');

                                assignmentReports.forEach((assignmentReport, aIndex) => {
                                    let assignmentTotal = 0;
                                    var rowCount = 1;


                                    // Calculate total first (required to show total before responses)
                                    assignmentReport.responses.forEach((r) => {
                                        assignmentTotal += parseInt(r.total);
                                        totalAll += parseInt(r.total);
                                    });


                                    let assignmentLink = "<?php echo site_url('Myreport/report_details'); ?>" +
                                        "?assignment_id=" + assignmentReport.assignment_id +
                                        "&response_id=" +
                                        "&from_date=" + from +
                                        "&to_date=" + to;

                                    // Show assignment total FIRST (above the responses)
                                    html += '<tr style="background-color: #F1F1F1; font-weight: bold; font-size:20px;">' +
                                        '<td></td>' +
                                        '<td style="text-align: left">Total For ' + assignmentReport.assignment + '</td>' +
                                        '<td><a href="' + assignmentLink + '" >' + assignmentTotal + '</a></td>' +
                                        '</tr>';


                                    assignmentReport.responses.forEach((r, rIndex) => {
                                        let responseLink = "<?php echo site_url('Myreport/report_details'); ?>" +
                                            "?assignment_id=" + assignmentReport.assignment_id +
                                            "&response_id=" + r.response_id +
                                            "&from_date=" + from +
                                            "&to_date=" + to;

                                        html += '<tr style="font-size:16px;">';
                                        html += '<td>' + (rowCount++) + '</td>';
                                        html += '<td><strong>' + r.response + '</strong></td>';
                                        html += '<td><a href="' + responseLink + '" >' + r.total + '</a></td>';
                                        html += '</tr>';
                                    });
                                });

                                html = '<tr style="font-size:18px; font-weight:bold;"><td>#</td><td><strong>Total Calls</strong></td><td>' + totalAll + '</td></tr>' + html;
                            }

                            if ($.fn.DataTable.isDataTable('#report_table')) {
                                $('#report_table').DataTable().destroy();
                            }

                            $('#report_table tbody').html(html);

                            $('#report_table').DataTable({
                                dom: 'Bfrtip',
                                buttons: [{
                                    extend: 'excelHtml5',
                                    title: 'My Report IITTM'
                                }],
                                paging: false,
                                searching: false,
                                ordering: false,
                                info: false
                            });
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