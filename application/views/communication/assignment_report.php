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
                                        <th>
                                            <?php if ($this->session->userdata('role') === 'admin'): ?>
                                                Status Remark
                                            <?php endif; ?>
                                        </th>
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
                                            <td>
                                                <a href="<?= site_url('communication/calling_data_display/' . $assignments->id); ?>">
                                                    <?= $count; ?>
                                                </a>
                                            </td>
                                            <td><?php if ($assignments->assignment_start != '0000-00-00') {
                                                    echo date('d-m-Y', strtotime($assignments->assignment_start));
                                                } ?></td>
                                            <td><?php if ($assignments->assignment_end != '0000-00-00') {
                                                    echo date('d-m-Y', strtotime($assignments->assignment_end));
                                                } ?></td>
                                            <td class="remark">
                                                <?php if ($this->session->userdata('role') === 'admin'): ?>
                                                    <?= $assignments->report_remark ?>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= $assignments->created_at ?></td>
                                            <td style="white-space: nowrap;">
                                                <a href="<?= site_url('communication/assignment_details/') . $assignments->id ?>" class="btn btn-sm btn-primary btn_click mr-1">View</a>

                                                <?php if ($this->session->userdata('role') === 'admin'): ?>
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm status-btn <?= ($assignments->report_status === 'closed' ? 'btn-danger' : 'btn-success') ?>"
                                                        data-id="<?= $assignments->id ?>"
                                                        data-status="<?= $assignments->report_status ?>">

                                                        <?= ($assignments->report_status === 'closed' ? 'Closed' : 'In Progress') ?>
                                                    </button>
                                                <?php endif; ?>
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

        <!-- status modal -->
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true" style="z-index: 999999;">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document" style="margin-top: 15%;">
                <form id="statusForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Assignment Status</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="assignment_id" name="assignment_id">

                            <div class="form-group">
                                <label>Status</label>
                                <select name="report_status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Remark</label>
                                <textarea name="report_remark" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- campaign modal -->
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


    let activeButton = null;

    $(document).on('click', '.status-btn', function() {
        activeButton = $(this);
        const id = activeButton.data('id');
        const current = activeButton.data('status') || 'in_progress';

        if (current === 'closed') {
            return;
        }

        $('#assignment_id').val(id);
        $('#statusForm')[0].reset();
        $('select[name="report_status"]').val(current);
        $('#statusModal').modal('show');
    });

    $('#statusForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '<?= site_url("communication/update_assignment_status") ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function() {
                $('#statusModal').modal('hide');

                const newStatus = $('select[name="report_status"]').val();
                const newRemark = $('textarea[name="report_remark"]').val();

                if (newStatus === 'closed') {
                    activeButton
                        .removeClass('btn-success')
                        .addClass('btn-danger')
                        .text('Closed')
                        .data('status', 'closed');
                } else {
                    activeButton
                        .removeClass('btn-danger')
                        .addClass('btn-success')
                        .text('In Progress...')
                        .data('status', 'in_progress');
                }
                activeButton.closest('tr').find('.remark').text(newRemark);
            },
            error: function() {
                alert('Failed to update status.');
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