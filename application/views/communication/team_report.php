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
                    Team Report
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Communication</li>
                </ol>
            </section>


            <section class="content">
                <div class="page-content">
                    <div class="box">
                        <div class="box-body">
                            <div class="row" id="filter-section">
                                <div class="col-sm-2">
                                    <select id="team_member" class="form-control">
                                        <option value="">Select Team Member</option>
                                        <?php foreach ($user as $u): ?>
                                            <option value="<?= $u->admin_id ?>"><?= $u->admin_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <input type="text" id="from" class="form-control datepicker" placeholder="From Date">
                                </div>

                                <div class="col-sm-2">
                                    <input type="text" id="to" class="form-control datepicker" placeholder="To Date">
                                </div>

                                <div class="form-group col-sm-2">
                                    <select class="form-control" name="assignment_id" id="assignment_filter">
                                        <option value="">Select Assignment</option>
                                        <?php foreach ($assignment_list as $row): ?>
                                            <option value="<?= $row->id ?>"><?= $row->assignment_name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Tag Dropdown -->
                                <div class="form-group col-sm-2">
                                    <select id="tag_names" name="tag_names[]" multiple placeholder="Choose skills" data-allow-clear="1" class="form-control">
                                        <?php foreach ($tags as $tag): ?>
                                            <option value="<?= $tag->name ?>"><?= $tag->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <button type="button" id="filterBtn" class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </div>



                        <!-- main content here -->
                        <div class="box">
                            <div class="box-body" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Team Member</th>
                                            <!-- <th>Tags</th> -->
                                            <th>Date</th>
                                            <th>Assignments</th>
                                        </tr>
                                    </thead>
                                    <tbody id="assignment_table_body">
                                        <?php
                                        $grouped = [];
                                        foreach ($assignments as $a) {
                                            $date = $a->assigned_date;
                                            $key = $a->admin_name . '_' . $date;

                                            if (!isset($grouped[$key])) {
                                                $grouped[$key] = [
                                                    'admin_name' => $a->admin_name,
                                                    'date' => $date,
                                                    'assignments' => []
                                                    // 'tags' => []
                                                ];
                                            }

                                            $assignment_id = $a->assignment_id;
                                            if (!isset($grouped[$key]['assignments'][$assignment_id])) {
                                                $grouped[$key]['assignments'][$assignment_id] = $a->assignment_title;
                                            }

                                            // if (!empty($a->tags)) {
                                            //     $tags_array = explode(',', $a->tags);
                                            //     foreach ($tags_array as $tag) {
                                            //         $tag = trim($tag);
                                            //         if ($tag && !in_array($tag, $grouped[$key]['tags'])) {
                                            //             $grouped[$key]['tags'][] = $tag;
                                            //         }
                                            //     }
                                            // }
                                        }

                                        // ✅ Sort grouped array by date DESCENDING
                                        $grouped = array_values($grouped); // Reset numeric keys
                                        usort($grouped, function ($a, $b) {
                                            return strtotime($b['date']) - strtotime($a['date']);
                                        });

                                        $sno = 1;
                                        foreach ($grouped as $entry): ?>
                                            <tr>
                                                <td><?= $sno++ ?></td>
                                                <td><?= $entry['admin_name'] ?></td>
                                                <!-- <td>
                                                    <?php
                                                    if (!empty($entry['tags'])) {
                                                        echo implode(', ', $entry['tags']);
                                                    } else {
                                                        echo 'No Tags';
                                                    }
                                                    ?>
                                                </td> -->

                                                <td><?= date('d-m-Y', strtotime($entry['date'])) ?></td>
                                                <td>
                                                    <?php foreach ($entry['assignments'] as $id => $title): ?>
                                                        <button type="button" class="btn btn-sm btn-primary assignment-link" data-id="<?= $id ?>" style="margin-right: 5px; margin-bottom: 5px;">
                                                            <?= $title ?>
                                                        </button>
                                                    <?php endforeach; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-body">
                            <span style="font-size: 20px; color: green; text-align: right; margin-left: 50px; float: right">Total Records - <span id="record">0</span></span>

                            <span style="font-size: 20px; color: green; text-align: right; display: block; ">Complete - <span id="complete">0</span></span>

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
                                            <th>Academic Information</th>
                                            <th>Communication</th>
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


        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


</body>

</html>


<script>
    $(document).ready(function() {

        $(function() {
            $('select').each(function() {
                $("#tag_names").select2({
                    placeholder: 'Select Tags',
                    allowClear: Boolean($(this).data('allow-clear')),
                });
            });
        });

        $("#loading").hide();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        })

        $(".js-example-basic-multiple").select2();


        $('#filterBtn').click(function() {
            var team_member = $('#team_member').val();
            var from = $('#from').val();
            var to = $('#to').val();
            var assignment_ids = $('#assignment_filter').val(); // Multiselect
            var tag_names = $('#tag_names').val(); // array of selected assignments

            $.ajax({
                url: "<?= site_url('communication/filter_team') ?>",
                method: "POST",
                data: {
                    team_member: team_member,
                    from: from,
                    to: to,
                    assignment_ids: assignment_ids,
                    tag_names: tag_names
                },
                traditional: true,
                success: function(response) {

                    $('#assignment_table_body').html(response);
                },
                error: function() {
                    alert('Error loading filtered data.');
                }
            });
        });
    });



    $(document).on("click", ".assignment-link", function(e) {
        e.preventDefault();
        var assignmentId = $(this).data("id");
        var from = $('#from').val();
        var to = $('#to').val();
        $.ajax({
            url: "<?php echo site_url('communication/team_assignment_candidates'); ?>",
            type: "POST",
            data: {
                data: assignmentId,
                from: from,
                to: to,
            },
            dataType: "json",
            success: function(response) {

                if ($.fn.DataTable.isDataTable('#item-list-filter')) {
                    $('#item-list-filter').DataTable().destroy();
                }


                $('#item-list-filter tbody').empty();


                $('#record').text(response.recordsTotal);
                $('#complete').text(response.recordsComplete);


                $.each(response.data, function(index, item) {
                    var row = '<tr>';
                    row += '<td>' + item[0] + '</td>';
                    row += '<td>' + item[1] + '</td>';
                    row += '<td>' + item[2] + '</td>';
                    row += '<td>' + item[3] + '</td>';
                    row += '</tr>';
                    $('#item-list-filter tbody').append(row);
                });

                $('#item-list-filter').DataTable({
                    "fixedHeader": true,
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "order": [0, "asc"],
                    "bInfo": true,
                    "bAutoWidth": false,
                    "searching": true,
                    "retrieve": true,
                    "destroy": true,
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [25, 50, -1],
                        ['25 rows', '50 rows', 'Show all']
                    ],
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                });
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
        z-index: 99999;
    }
</style>