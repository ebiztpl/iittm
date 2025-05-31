<!DOCTYPE html>
<html>

<head>
    <?php $this->load->view('../layout/head.php'); ?>
    <script src="<?= base_url(); ?>themes/js/jquery.min.js"></script>
    <script src="<?= base_url(); ?>themes/js/angular.min.js"></script>
    <script src="<?= base_url(); ?>themes/js/angular-ui.min.js"></script>
</head>

<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="Dashboard_Details">
    <div class="wrapper">

        <?php $this->load->view('../layout/header.php'); ?>
        <!-- Left side column. contains the logo and sidebar -->

        <?php $this->load->view('../layout/sidemenu.php');
        sidebar(2);
        ?>


        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    All Registration
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="page-content">
                    <div class="box">


                        <form method="post" action="<?= site_url('admin/bulkleaddata/' . $bulklead_id); ?>">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-7">
                                    </div>
                                    <div class="col-sm-2" style="padding-right: 0px;">
                                        <label>FromDate</label><br />
                                        <input type="text" class="form-control datepicker" placeholder="From Date" name="from" required="" autocomplete="off" style="border-radius: 0px;">
                                    </div>
                                    <div class="col-sm-2" style="padding-right: 0px;">
                                        <label>ToDate</label><br />
                                        <input type="text" class="form-control datepicker" placeholder="To Date" name="to" required="" autocomplete="off" style="border-radius: 0px;">
                                    </div>


                                    <div class="col-sm-1" style="padding-top:25px;">
                                        <button class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <?php
                        // Initializing form
                        $lFormAttrb = array(
                            'role' => 'form',
                            'id' => 'RegisterForm',
                            'class' => 'form-horizontal',
                            'novalidate' => 'novalidate',
                            'ng-submit' => 'assign_Submit($event)'
                        );
                        echo form_open('', $lFormAttrb);
                        ?>


                        <div class="box-body table-responsive">
                            <div id="loading"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>
                            <span style="margin: 10px; font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>
                            <div style="overflow:scroll; height:500px;">
                                <table class="table table-hover" id="example2">
                                    <thead>
                                        <tr>

                                            <th class="tbl-header">Sr.no</th>
                                            <th class="tbl-header">Full name</th>
                                            <th class="tbl-header">Course</th>
                                            <th class="tbl-header">Mobile</th>
                                            <th class="tbl-header">Email</th>
                                            <th class="tbl-header">Gender</th>
                                            <th class="tbl-header">Father Name</th>
                                            <th class="tbl-header">Mother Name</th>
                                            <th class="tbl-header">Alternate Number</th>
                                            <th class="tbl-header">Religion</th>
                                            <th class="tbl-header">Category</th>
                                            <th class="tbl-header">DOB</th>
                                            <th class="tbl-header">Nationality</th>
                                            <th class="tbl-header">Parr. Appartment</th>
                                            <th class="tbl-header">Parr. Colony</th>
                                            <th class="tbl-header">Parr. Area</th>
                                            <th class="tbl-header">Parr. State</th>
                                            <th class="tbl-header">Parr. City</th>
                                            <th class="tbl-header">Parr. Pincode</th>
                                            <th class="tbl-header">Corr. Appartment</th>
                                            <th class="tbl-header">Corr. Colony</th>
                                            <th class="tbl-header">Corr. Area</th>
                                            <th class="tbl-header">Corr. State</th>
                                            <th class="tbl-header">Corr. City</th>
                                            <th class="tbl-header">Corr. Pincode</th>
                                            <th class="tbl-header">Academic Intermediate</th>
                                            <th class="tbl-header">Academic Board</th>
                                            <th class="tbl-header">Academic Year</th>
                                            <th class="tbl-header">Academic Status</th>
                                            <th class="tbl-header">Entry DateTime</th>

                                        </tr>
                                    </thead>

                                    <tbody>

                                        <tr ng-repeat='list in list_items' id="row_id{{list.loginID}}">
                                            <td>

                                                {{$index + 1}}


                                            </td>

                                            <td>
                                                {{list.first_name}} {{list.middle_name}} {{list.last_name}}
                                            </td>
                                            <td><span ng-if="list.course_id==1">BBA</span> <span ng-if="list.course_id==2">MBA</span></td>
                                            <td>{{list.user_mobile}} </td>
                                            <td>{{list.email_id}}</td>
                                            <td>{{list.gender}}</td>
                                            <td>{{list.father_name}}</td>
                                            <td>{{list.mother_name}}</td>
                                            <td>{{list.father_mobile}}</td>
                                            <td>{{list.religion}}</td>
                                            <td>{{list.category}}</td>
                                            <td>{{list.dob}}</td>
                                            <td>{{list.nationality}}</td>
                                            <td>{{list.parma_appertment}}</td>
                                            <td>{{list.parma_colony}}</td>
                                            <td>{{list.parma_area}}</td>
                                            <td>{{list.parma_state}}</td>
                                            <td>{{list.parma_city}}</td>
                                            <td>{{list.parma_pincode}}</td>
                                            <td>{{list.corre_appertment}}</td>
                                            <td>{{list.corre_colony}}</td>
                                            <td>{{list.corre_area}}</td>
                                            <td>{{list.corre_state}}</td>
                                            <td>{{list.corre_city}}</td>
                                            <td>{{list.corre_pincode}}</td>
                                            <td>{{list.academic_intermediate}}</td>
                                            <td>{{list.academic_board}}</td>
                                            <td>{{list.academic_year}}</td>
                                            <td>{{list.academic_status}}</td>
                                            <td>{{list.created_date}}</td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <b><span id="loadingddupe" style="display:none;">Checking.........</span></b>
                        <span id="warning_msg" class="error"></span>
                    </div>
                    <!-- Begin Action Navigation Bar -->

                    <?php echo form_close(); ?>
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
</body>

</html>

<script>
    $(document).ready(function() {
        $("#loading").hide();
    });
    var App = angular.module('myApp', ['ui.bootstrap']);

    function Dashboard_Details($scope, $log, $http, $compile) {

        $scope.list_items = <?php echo json_encode($result); ?>;
        $scope.sampledate = new Date();
    }
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
    }
</style>

<script type="text/javascript">
    $(function() {
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "searching": true,
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, -1],
                ['25 rows', '50 rows', 'Show all']
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "drawCallback": function(settings) {
                var api = this.api();
                var info = api.page.info();
                // info.recordsDisplay = filtered record count
                // info.recordsTotal = total records before filter (if implemented)
                $("#record").text(info.recordsDisplay); // update element with filtered count
            }


        });
    });


    $(document).ready(function() {


        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'

        });
    });
</script>