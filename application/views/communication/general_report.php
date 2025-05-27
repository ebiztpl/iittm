<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <!-- <script src="<?=base_url();?>themes/js/jquery.min.js"></script> -->

  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
  <style type="text/css">
    .select2 {width:100% !important;}
    .select2-container--default .select2-selection--multiple .select2-selection__choice{background: #444 !important; border:none !important;}
    .badge {background-color:#000 !important;}
  </style>

</head>
<body class="skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
    sidebar(1207);
  ?>
  
  

<div class="content-wrapper">
    <!-- Content Header (Page header) -->

  <section class="content-header">
      <h1>
       General Report
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
                 
                        
                                <div class="form-group col-sm-2">
                                    <select class="form-control" name="assignment_id" id="assignment_id">
                                        <option value="">Select Responses</option>
                                        <?php foreach ($responses as $row): ?>
                                            <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Tag Dropdown -->
                                <div class="form-group col-sm-2">
                                    <select id="tag_names" name="tag_names[]" multiple placeholder="Choose skills" data-allow-clear="1" class="form-control">
                                        <?php foreach ($tags as $tag): ?>
                                            <option value="<?= $tag->tag_id ?>"><?= $tag->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <button type="button" id="filterBtn" class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </div>

                                          <span style="margin: 10px; font-size: 20px; color: green; text-align: right; display: block;">Total Records - <span id="record">0</span></span>

                        <div style="overflow:scroll; height:500px;">
								<table id="item-list-filter" class="table table-bordered table-striped table-hover">
									<thead>
										<tr>

											
											<th class="tbl-header">Roll No.</th>
											<th class="tbl-header">Exam</th>
											<th class="tbl-header">Course</th>
											<th class="tbl-header">Study centre1</th>
											<th class="tbl-header">Score</th>
											<th class="tbl-header">Full name</th>
											<th class="tbl-header">Mobile</th>

											<th>Father Name</th>
											<th>Mother Name</th>
											<th>DOB</th>
											<th>Email</th>
											<th>Gender</th>
											<th>Category</th>
											<th>Father Mobile</th>
											<th>Mother Mobile</th>
											<th>Religion</th>
											<th>Parr. State</th>
											<th>Parr. City</th>
											<th>Entry DateTime</th>
											<th>Fee DateTime</th>

										</tr>
									</thead>
									<tbody>


									</tbody>
								</table>
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


$(document).ready(function(){

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
      format: 'dd-mm-yyyy',
      showButtonPanel: true,
      autoclose: true,
  });


$('#filterBtn').click(function(){
	$("#loading").show();


			var whereClauses = [];


			if ($("#assignment_id").val() != "") {
				whereClauses.push('cd.response_id = ' + "'" + $("#assignment_id").val() + "'");
			}

			if ($("#tag_names").val() != "") {
				whereClauses.push('cd.tag LIKE ' + "'%" + $("#tag_names").val() + "%'");
			}

	
			var withand = whereClauses.join(" AND ");
			if (whereClauses.length != 0) {
				var where = ' WHERE ' + withand;
			}

      console.log(where);

			$('#item-list_wrapper').hide();
			$('#item-list-filter').show();

			$('#item-list-filter').DataTable({
				"ajax": {
					url: "<?php echo site_url('communication/general_report_search'); ?>",
					data: {
						'data': where
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
					// info.recordsDisplay = filtered record count
					// info.recordsTotal = total records before filter (if implemented)
					$("#record").text(info.recordsDisplay); // update element with filtered count
				}
			});
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

#loading{
  width: 100%;
height: 800px;
position: absolute;
background-color: rgba(0, 0, 0, 0.50) !important;
text-align: center;
padding-top: 30%;
z-index: 99999;
  }
</style>
