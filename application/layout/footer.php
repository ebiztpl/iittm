  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="">e-Biz Technocrats Pvt. Ltd.</a></strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?=base_url();?>themes/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=base_url();?>themes/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url();?>themes/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<!-- <script src="<?=base_url();?>themes/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>themes/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> -->

 
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  
 <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>

<!-----Angular JS-------->
<!-- <script src="<?=base_url();?>themes/js/angular.min.js"></script>
<script src="<?=base_url();?>themes/js/setup.js"></script> -->
<!-- Morris.js charts -->
<script src="<?=base_url();?>themes/bower_components/raphael/raphael.min.js"></script>
<script src="<?=base_url();?>themes/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?=base_url();?>themes/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<!-- <script src="<?=base_url();?>themes/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=base_url();?>themes/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->

<!-- jQuery Knob Chart -->
<script src="<?=base_url();?>themes/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=base_url();?>themes/bower_components/moment/min/moment.min.js"></script>
<script src="<?=base_url();?>themes/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?=base_url();?>themes/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap time picker -->
<script src="<?=base_url();?>themes/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=base_url();?>themes/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?=base_url();?>themes/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url();?>themes/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url();?>themes/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="<?=base_url();?>themes/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->

<!-- <script src="<?=base_url();?>themes/dist/js/demo.js"></script> -->


<script src="<?=base_url();?>themes/bower_components/moment/moment.js"></script>
<script src="<?=base_url();?>themes/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
   $('#dbname').on('change', function() {
   $(this).closest('form').submit();
  });
	
	 $(document).ready(function(){
    $(".js-select2").select2();
  });

</script>