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

    <style>
        * {
            position: relative;
            margin: 0;
            padding: 0;
            border: 0 none;
            transition: all ease .4s;
        }

        .tree-navbar {
            margin: 20px auto;
            width: 100%;
            min-height: auto;
            justify-items: center;
        }

        .tree-navbar ul {
            position: relative;
            padding-top: 20px;
        }

        .tree-navbar li {
            position: relative;
            padding: 20px 3px 0 3px;
            float: left;

            text-align: center;
            list-style-type: none;
        }

        .tree-navbar li::before,
        .tree-navbar li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            width: 50%;
            height: 20px;
            border-top: 1px solid black;
        }

        .tree-navbar li::after {
            left: 50%;
            right: auto;

            border-left: 1px solid black;
        }

        .tree-navbar li:only-child::after,
        .tree-navbar li:only-child::before {
            content: '';
            display: none;
        }

        .tree-navbar li:only-child {
            padding-top: 0;
        }

        .tree-navbar li:first-child::before,
        .tree-navbar li:last-child::after {
            border: 0 none;
        }

        .tree-navbar li:last-child::before {
            border-right: 1px solid black;
            border-radius: 0 5px 0 0;
        }

        .tree-navbar li:first-child::after {
            border-radius: 5px 0 0 0;
        }

        .tree-navbar ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1px solid black;
            width: 0;
            height: 20px;
        }
    </style>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load AngularJS first -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <script src="<?= base_url(); ?>themes/js/angular.min.js"></script>

</head>

<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="validateCtrl">
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
                    Admission Process
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Admission</li>
                </ol>
            </section>


            <div class="box-body">
                <nav class="tree-navbar">
                    <ul>
                        <li>
                            <button type="button" id="details_btn" class="btn btn-lg btn-block btn-primary">IITTM</button>
                            <ul>
                                <li>
                                    <a href="admission_process_details/registration" id="details_btn" class="btn btn-success">Registration
                                        <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{ total_regis }}</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="admission_process_details/entrance_done" id="details_btn" class="btn btn-success">Entrance Done
                                                <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{ entrance }}</span>
                                            </a>
                                            <ul>
                                                <li>
                                                    <a href="admission_process_details/gdpi_done" id="details_btn" class="btn btn-success">GDPI Done
                                                        <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{ gdpi }}</span>
                                                    </a>
                                                    <ul>
                                                        <li>
                                                            <a href="admission_process_details/admission" id="details_btn" class="btn btn-success">Admission
                                                                <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{ admission }}</span>
                                                            </a>
                                                        </li>

                                                        <li><a href="admission_process_details/waiting_for_admission" id="details_btn" class="btn btn-warning">Waiting For Admission
                                                                <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{ waiting }}</span>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </li>
                                                <li>
                                                    <a href="admission_process_details/gdpi_not_done" id="details_btn" class="btn btn-danger">GDPI Not Done
                                                        <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{ gdpi_not_done }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="admission_process_details/entrance_not_done" id="details_btn" class="btn btn-danger">Entrance Not Done
                                                <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{ entrance_not_done }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="admission_process_details/incomplete_registration" id="details_btn" class="btn btn-danger">Incomplete Registration
                                        <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{ total_inc }}</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="admission_process_details/interested" id="details_btn" class="btn btn-success">Interested
                                                <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{interested}}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="admission_process_details/not_interested" id="details_btn" class="btn btn-danger">Not Interested
                                                <span class="label" style="font-size: 15px; display: block; margin-top: 5px;">{{in_not_interested}}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </nav>
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


        <script type="text/javascript">
            $(document).ready(function() {
                $("#loading").hide();
            });

            var app = angular.module("myApp", []);

            app.controller("validateCtrl", function($scope, $log, $http) {
                $scope.total_regis = <?= json_encode($total_regis) ?>;
                $scope.total_inc = <?= json_encode($total_inc) ?>;
                $scope.admission = <?= json_encode($admission) ?>;
                $scope.waiting = <?= json_encode($waiting) ?>;
                $scope.gdpi = <?= json_encode($gdpi) ?>;
                $scope.gdpi_not_done = <?= json_encode($gdpi_not_done) ?>;
                $scope.entrance = <?= json_encode($entrance) ?>;
                $scope.entrance_not_done = <?= json_encode($entrance_not_done) ?>;
                $scope.in_not_interested = <?= json_encode($in_not_interested) ?>;
                $scope.interested = <?= json_encode($interested) ?>;
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