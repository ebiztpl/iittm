<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('../layout/head.php'); ?>
  <script src="<?= base_url(); ?>themes/js/jquery.min.js"></script>
  <script src="<?= base_url(); ?>themes/js/angular.min.js"></script>
  <style type="text/css">
    .progress {
      margin-bottom: 0px;
    }

    .progress-bar {
      font-size: 15px;
    }
  </style>
  <script src="<?= base_url(); ?>themes/js/jquery.min.js"></script>

  <style type="text/css">
    #loading {
      width: 100%;
      height: 100%;
      background-color: #000000ba;
      position: absolute;
      z-index: 99999;
      padding-top: 30%;
    }
  </style>
</head>

<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="" ng-controller="validateCtrl">

  <div id="loading" class="text-center"><img src="<?php echo base_url(); ?>/themes/img/loader.gif" /></div>

  <div class="wrapper">

    <?php $this->load->view('../layout/header.php'); ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view('../layout/sidemenu.php');
    sidebar(1);
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->


      <!-- Main content -->
      <section class="content">

        <div class="row">
          <div class="col-sm-12">

            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Comparison BBA</h3>

                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body no-padding">

                <div class="col-sm-12 text-center" style="background-color: #fff;">
                  <div id='chart_div' style='width: 100%; height:450px;'></div>
                </div>




              </div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-sm-12">

            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">-</h3>

                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body no-padding">

                <div class="col-sm-4 text-center" style="background-color: #fff;">
                  <div id='colchart_diff_2020' style='width: 100%; height:250px;'></div>
                </div>


                <div class="col-sm-4 text-center" style="background-color: #fff;">
                  <div id='colchart_diff_2021' style='width: 100%; height:250px;'></div>
                </div>

                <div class="col-sm-4 text-center" style="background-color: #fff;">
                  <div id='colchart_diff_2022' style='width: 100%; height:250px;'></div>
                </div>

                <div class="col-sm-4 text-center" style="background-color: #fff;">
                  <div id='colchart_diff_2023' style='width: 100%; height:250px;'></div>
                </div>


                <div class="col-sm-4 text-center" style="background-color: #fff;">
                  <div id='colchart_diff_2024' style='width: 100%; height:250px;'></div>
                </div>

                <div class="col-sm-4 text-center" style="background-color: #fff;">
                  <div id='colchart_diff_2025' style='width: 100%; height:250px;'></div>
                </div>


              </div>
            </div>
          </div>
        </div>
      </section>


      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


      <script type="text/javascript">
        $(document).ready(function() {
          $("#loading").hide();
        });;

        google.charts.load('current', {
          packages: ['corechart']
        });

        const allCities = ['Gwalior', 'Noida', 'Bhubaneswar', 'Nellore', 'Goa'];

        const defaultSeats = {
          'Gwalior': 334,
          'Noida': 189,
          'Bhubaneswar': 112,
          'Nellore': 75,
          'Goa': 40
        };

        const colorsByYear = {
          '2020': ['#69247C', 'green'],
          '2021': ['orange', 'green'],
          '2022': ['green', 'green'],
          '2023': ['blue', 'green'],
          '2024': ['red', 'green'],
          '2025': ['brown', 'green']
        };

        function drawCharts(data) {
          for (const year in colorsByYear) {
            const chartId = 'colchart_diff_' + year;
            const yearData = data[year] || [];

            // Build city → application map
            const appMap = {};
            yearData.forEach(([city, count]) => {
              appMap[city] = parseInt(count);
            });

            // Build chart data with all cities (0 if missing)
            const oldData = [
              ['Name', 'Seat']
            ];
            const newData = [
              ['Name', 'Application']
            ];

            allCities.forEach(city => {
              oldData.push([city, defaultSeats[city]]);
              newData.push([city, appMap[city] || 0]);
            });

            const oldTable = google.visualization.arrayToDataTable(oldData);
            const newTable = google.visualization.arrayToDataTable(newData);
            const chart = new google.visualization.ColumnChart(document.getElementById(chartId));

            const options = {
              title: year,
              titleTextStyle: {
                fontSize: 20,
                bold: true
              },
              legend: {
                position: 'top'
              },
              chartArea: {
                left: 60,
                top: 60,
                bottom: 30,
                width: '100%',
                height: '100%'
              },
              colors: colorsByYear[year]
            };

            const diffData = chart.computeDiff(oldTable, newTable);
            chart.draw(diffData, options);
          }
        }

        window.onload = function() {
          google.charts.setOnLoadCallback(() => {
            fetch("<?= base_url('index.php/Admin/chartdata_bba_city') ?>")
              .then(res => res.json())
              .then(data => {
                console.log("Fetched Data:", data);

                const table = data.citychart;
                if (!table || table.length < 2) {
                  console.error("Invalid data format");
                  return;
                }

                const header = table[0]; 
                const years = header.slice(1);

                const transformed = {};
                years.forEach(y => {
                  transformed[y] = [];
                });

                for (let i = 1; i < table.length; i++) {
                  const row = table[i];
                  const city = row[0];
                  for (let j = 1; j < row.length; j++) {
                    const year = header[j];
                    const count = parseInt(row[j]) || 0;
                    transformed[year].push([city, count]);
                  }
                }

                drawCharts(transformed);
              })
              .catch(err => console.error("Chart Load Error:", err));
          });
        };



        // for display  overall chart
        function drawChart() {
          fetch("<?= site_url('Admin/chart_graphical_bba') ?>")
            .then(response => response.json())
            .then(data => {
              var chartData = [
                ['Year', 'Application', 'Seats', 'Admission', 'Average']
              ];

              data.forEach(row => {
                chartData.push([
                  row.year.toString(),
                  parseInt(row.applications),
                  parseInt(row.seats),
                  parseInt(row.admissions),
                  parseFloat(row.average)
                ]);
              });

              var dataTable = google.visualization.arrayToDataTable(chartData);

              var options = {
                title: '',
                vAxis: {
                  title: ''
                },
                hAxis: {
                  title: 'Years'
                },
                seriesType: 'bars',
                series: {
                  3: {
                    type: 'line'
                  }
                } // 4th column (average) as line
              };

              var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
              chart.draw(dataTable, options);
            })
        }

        google.charts.setOnLoadCallback(drawChart);
      </script>


      <?php $this->load->view('../layout/footer.php'); ?>

</body>

</html>