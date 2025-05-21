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
                <h3 class="box-title">Comparison MBA</h3>

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
        });

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
            fetch("<?= base_url('index.php/Admin/chartdata_mba_city') ?>")
              .then(res => res.json())
              .then(data => {
                console.log("Fetched Data:", data);
                drawCharts(data);
              })
              .catch(err => console.error("Chart Load Error:", err));
          });
        };


        // for display  overall chart
        function drawChart() {
          fetch("<?= site_url('Admin/chart_graphical_mba') ?>")
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
                  2: {
                    type: 'line'
                  }
                }
              };

              var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
              chart.draw(dataTable, options);
            })
        }

        google.charts.setOnLoadCallback(drawChart);
      </script>


      <!-- <script type="text/javascript">
        function drawChart2020() {

          var oldData = google.visualization.arrayToDataTable([
            ['Name', 'Seat'],
            ['Gwalior', 334],
            ['Noida', 189],
            ['Bhuvneshwar', 112],
            ['Nellore', 75],
            ['Goa', 40],
          ]);

          var newData = google.visualization.arrayToDataTable([
            ['Name', 'Application'],
            ['Gwalior', 400],
            ['Noida', 254],
            ['Bhuvneshwar', 102],
            ['Nellore', 85],
            ['Goa', 66],
          ]);


          var colChartDiff = new google.visualization.ColumnChart(document.getElementById('colchart_diff_2020'));
          // var view = new google.visualization.DataView(newData);
          // view.setColumns([0, 1, {
          //   calc: 'stringify',
          //   role: 'annotation',
          //   sourceColumn: 1,
          //   type: 'string'
          // }]);
          var options = {
            title: "2020",
            titleTextStyle: {
              fontSize: 20,
              bold: true
            },
            legend: {
              position: 'top',
              alignment: 'start'
            },
            chartArea: {
              left: 60,
              top: 60,
              bottom: 30,
              width: "100%",
              height: "100%"
            },
            colors: ['#69247C', 'green'],
          };
          var diffData = colChartDiff.computeDiff(oldData, newData);
          colChartDiff.draw(diffData, options);

        }


        function drawChart2021() {

          var oldData = google.visualization.arrayToDataTable([
            ['Name', 'Seat'],
            ['Gwalior', 334],
            ['Noida', 189],
            ['Bhuvneshwar', 112],
            ['Nellore', 75],
            ['Goa', 40],
          ]);

          var newData = google.visualization.arrayToDataTable([
            ['Name', 'Application'],
            ['Gwalior', 381],
            ['Noida', 205],
            ['Bhuvneshwar', 79],
            ['Nellore', 61],
            ['Goa', 87],
          ]);


          var colChartDiff = new google.visualization.ColumnChart(document.getElementById('colchart_diff_2021'));
          var options = {
            title: "2021",
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
              width: "100%",
              height: "100%"
            },
            colors: ['orange', 'green'],
          };
          var diffData = colChartDiff.computeDiff(oldData, newData);
          colChartDiff.draw(diffData, options);

        }


        function drawChart2022() {

          var oldData = google.visualization.arrayToDataTable([
            ['Name', 'Seat'],
            ['Gwalior', 334],
            ['Noida', 189],
            ['Bhuvneshwar', 112],
            ['Nellore', 75],
            ['Goa', 40],
          ]);

          var newData = google.visualization.arrayToDataTable([
            ['Name', 'Application'],
            ['Gwalior', 322],
            ['Noida', 160],
            ['Bhuvneshwar', 76],
            ['Nellore', 41],
            ['Goa', 92],
          ]);


          var colChartDiff = new google.visualization.ColumnChart(document.getElementById('colchart_diff_2022'));
          var options = {
            title: "2022",
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
              width: "100%",
              height: "100%"
            },
            colors: ['green', 'green'],
          };
          var diffData = colChartDiff.computeDiff(oldData, newData);
          colChartDiff.draw(diffData, options);

        }


        function drawChart2023() {

          var oldData = google.visualization.arrayToDataTable([
            ['Name', 'Seat'],
            ['Gwalior', 334],
            ['Noida', 189],
            ['Bhuvneshwar', 112],
            ['Nellore', 75],
            ['Goa', 40],
          ]);

          var newData = google.visualization.arrayToDataTable([
            ['Name', 'Application'],
            ['Gwalior', 178],
            ['Noida', 124],
            ['Bhuvneshwar', 64],
            ['Nellore', 33],
            ['Goa', 54],
          ]);


          var colChartDiff = new google.visualization.ColumnChart(document.getElementById('colchart_diff_2023'));
          var options = {
            title: "2023",
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
              width: "100%",
              height: "100%"
            },
            colors: ['blue', 'green'],
          };
          var diffData = colChartDiff.computeDiff(oldData, newData);
          colChartDiff.draw(diffData, options);

        }


        function drawChart2024() {

          var oldData = google.visualization.arrayToDataTable([
            ['Name', 'Seat'],
            ['Gwalior', 334],
            ['Noida', 189],
            ['Bhuvneshwar', 112],
            ['Nellore', 75],
            ['Goa', 40],
          ]);

          var newData = google.visualization.arrayToDataTable([
            ['Name', 'Application'],
            ['Gwalior', 241],
            ['Noida', 148],
            ['Bhuvneshwar', 42],
            ['Nellore', 3],
            ['Goa', 58],
          ]);


          var colChartDiff = new google.visualization.ColumnChart(document.getElementById('colchart_diff_2024'));
          var options = {
            title: "2024",
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
              width: "100%",
              height: "100%"
            },
            colors: ['red', 'green']
          };
          var diffData = colChartDiff.computeDiff(oldData, newData);
          colChartDiff.draw(diffData, options);

        }

        function drawChart2025() {

          var oldData = google.visualization.arrayToDataTable([
            ['Name', 'Seat'],
            ['Gwalior', 330],
            ['Noida', 219],
            ['Bhuvneshwar', 132],
            ['Nellore', 275],
            ['Goa', 140],
          ]);

          var newData = google.visualization.arrayToDataTable([
            ['Name', 'Application'],
            ['Gwalior', 321],
            ['Noida', 168],
            ['Bhuvneshwar', 42],
            ['Nellore', 103],
            ['Goa', 158],
          ]);


          var colChartDiff = new google.visualization.ColumnChart(document.getElementById('colchart_diff_2025'));
          var options = {
            title: "2025",
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
              width: "100%",
              height: "100%"
            },
            colors: ['brown', 'green']
          };
          var diffData = colChartDiff.computeDiff(oldData, newData);
          colChartDiff.draw(diffData, options);

        }

        google.charts.load('current', {
          packages: ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart2020);
        google.charts.setOnLoadCallback(drawChart2021);
        google.charts.setOnLoadCallback(drawChart2022);
        google.charts.setOnLoadCallback(drawChart2023);
        google.charts.setOnLoadCallback(drawChart2024);
        google.charts.setOnLoadCallback(drawChart2025);



        function drawVisualization() {
          // Some raw data (not necessarily accurate)
          var data = google.visualization.arrayToDataTable([
            ['Years', 'Application', 'Seats', 'Admission', 'Average'],
            ['2020', 907, 750, 340, 665.6],
            ['2021', 813, 750, 292, 618.3],
            ['2022', 691, 750, 264, 568.3],
            ['2023', 454, 750, 201, 468.3],
            ['2024', 520, 750, 213, 494.3],
            ['2025', 635, 750, 311, 565.3]
          ]);

          var view = new google.visualization.DataView(data);
          view.setColumns([0, 1, {
            calc: 'stringify',
            role: 'annotation',
            sourceColumn: 1,
            type: 'string'
          }]);

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
              2: {
                type: 'line'
              }
            }
          };

          var chart = new google.visualization.ComboChart(document.getElementById('comparison'));
          chart.draw(data, options);
        }
        google.charts.setOnLoadCallback(drawVisualization);
    </script> -->

      <?php $this->load->view('../layout/footer.php'); ?>

</body>

</html>