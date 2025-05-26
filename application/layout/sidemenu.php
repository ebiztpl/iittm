<?php



if ($this->session->userdata['role'] == "service_provider") {

  function sidebar($index = 0)
  {  ?>

    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->

        <ul class="sidebar-menu" data-widget="tree">

          <li class="<?php if ($index >= 1 && $index <= 5) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-files-o"></i>
              <span>Reports</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 4) echo 'active' ?>"><a href="<?php echo base_url(); ?>/index.php/admin/transaction"><i class="fa fa-angle-double-right"></i>Transaction Report</a></li>

              <li class="<?php if ($index == 5) echo 'active' ?>"><a href="<?php echo base_url(); ?>/index.php/admin/razorpay_transaction"><i class="fa fa-angle-double-right"></i>Razorpay Report</a></li>

              <li class="<?php if ($index == 6) echo 'active' ?>"><a href="<?php echo base_url(); ?>/index.php/admin/seat"><i class="fa fa-angle-double-right"></i>Seat Reservation</a></li>

              <li class="<?php if ($index == 6) echo 'active' ?>"><a href="<?php echo base_url(); ?>/index.php/admin/update_status"><i class="fa fa-angle-double-right"></i>Update Transaction Id</a></li>

              <li class="<?php if ($index == 6) echo 'active' ?>"><a href="<?php echo base_url(); ?>/index.php/admin/form_update_request"><i class="fa fa-angle-double-right"></i>Form Update Request</a></li>

              <li class="<?php if ($index == 8) echo 'active' ?>"><a href="<?php echo base_url(); ?>/index.php/admin/admit_card"><i class="fa fa-angle-double-right"></i>Admit Card Link Send</a></li>

              <li class="<?php if ($index == 9) echo 'active' ?>"><a href="<?php echo base_url(); ?>/index.php/admin/test_center_finalization"><i class="fa fa-angle-double-right"></i>Test Center Final</a></li>

              <li class="<?php if ($index == 10) echo 'active' ?>"><a href="<?php echo base_url(); ?>/index.php/admin/align_test_center"><i class="fa fa-angle-double-right"></i>Test Center Alignment</a></li>

              <li class="<?php if ($index == 11) echo 'active' ?>"><a href="<?php echo base_url(); ?>/index.php/admin/Dashboard_Details"><i class="fa fa-angle-double-right"></i>Generate Admit card</a></li>

            </ul>

          </li>

        </ul>

      </section>
    </aside>
  <?php }
}
if ($this->session->userdata['role'] == "telecaller" || $this->session->userdata['role'] == "operation") {
  function sidebar($index = 0)
  {  ?>

    <aside class="main-sidebar">
      <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">

          <li class="<?php if ($index == 1) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/dashboard"><i class="fa fa-dashboard"></i></a></li>

          <li class="<?php if ($index == 1205) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Exam</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">


              <li class="<?php if ($index == 1205) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/exam/candidate_link_exam"><i class="fa fa-angle-double-right"></i>Candidate Link to Exam</a></li>

              <li class="<?php if ($index == 1205) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/exam/candidate_details"><i class="fa fa-angle-double-right"></i>Result Update</a></li>

            </ul>
          </li>

          <li class="<?php if ($index == 1206) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-user"></i>
              <span>Journey</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 1206) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/journey/student_journey"><i class="fa fa-angle-double-right"></i>Student Journey</a></li>


            </ul>
          </li>


          <li class="<?php if ($index == 1207) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-phone"></i>
              <span>Communication</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 1209) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/responses"><i class="fa fa-angle-double-right"></i>Responses</a></li>

              <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/assignment_report"><i class="fa fa-angle-double-right"></i>Assignment</a></li>

              <!-- <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/admit_card"><i class="fa fa-angle-double-right"></i>Communication Center</a></li> -->

            </ul>
          </li>


          <li class="<?php if ($index == 1207) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-table"></i>
              <span>My Reort</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="<?php if ($index == 1209) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/Myreport/filter_report"><i class="fa fa-angle-double-right"></i>My Report</a></li>
            </ul>
          </li>
        </ul>
      </section>
    </aside>


  <?php }
} else {

  function sidebar($index = 0)
  {  ?>

    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->

        <!-- search form -->

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

          <li class="<?php if ($index >= 1 && $index <= 5) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-file"></i>
              <span>Reports</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">


              <li class="<?php if ($index == 1) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/dashboard"><i class="fa fa-angle-double-right"></i>Dashboard</a></li>

              <li class="<?php if ($index == 2) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/Dashboard_Details"><i class="fa fa-angle-double-right"></i>Daily Admission Report</a></li>

              <li class="<?php if ($index == 3) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/maps"><i class="fa fa-angle-double-right"></i>Geographical Report</a></li>

              <li class="<?php if ($index == 6) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/search_seat"><i class="fa fa-angle-double-right"></i>Seat Reservation</a></li>

              <li class="<?php if ($index == 7) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/query"><i class="fa fa-angle-double-right"></i>Query/Issue</a></li>

              <li class="<?php if ($index == 8) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/final_report"><i class="fa fa-angle-double-right"></i>1000/500 Report</a></li>

              <!-- <li class="<?php if ($index == 4) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/transaction"><i class="fa fa-angle-double-right"></i>Transaction Report</a></li>

             <li class="<?php if ($index == 5) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/razorpay_transaction"><i class="fa fa-angle-double-right"></i>Razorpay Report</a></li>

          

            <li class="<?php if ($index == 6) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/update_status"><i class="fa fa-angle-double-right"></i>Update Transaction Id</a></li>

            <li class="<?php if ($index == 6) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/form_update_request"><i class="fa fa-angle-double-right"></i>Form Update Request</a></li>
        
            


             <li class="<?php if ($index == 11) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/Dashboard_Details"><i class="fa fa-angle-double-right"></i>Generate Admit card</a></li> -->

              <li class="<?php if ($index == 9) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/test_center_finalization"><i class="fa fa-angle-double-right"></i>Test Center Final</a></li>

              <li class="<?php if ($index == 10) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/align_test_center"><i class="fa fa-angle-double-right"></i>Test Center Alignment</a></li>

              <li class="<?php if ($index == 8) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/admit_card"><i class="fa fa-angle-double-right"></i>Admit Card Link Send</a></li>



            </ul>
          </li>


          <li class="<?php if ($index >= 11 && $index <= 15) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-university"></i>
              <span>Admission</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 11) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/create_admission"><i class="fa fa-angle-double-right"></i>Create Admission </a></li>

              <li class="<?php if ($index == 12) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/admission_graphical"><i class="fa fa-angle-double-right"></i>Graphical Report</a></li>

              <li class="<?php if ($index == 13) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/chartdata_bba"><i class="fa fa-angle-double-right"></i>BBA Graphical Report</a></li>


              <li class="<?php if ($index == 14) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/chartdata_mba"><i class="fa fa-angle-double-right"></i>MBA Graphical Report</a></li>



              <li class="<?php if ($index == 6) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/list_admission"><i class="fa fa-angle-double-right"></i>Listwise Report</a></li>


              <li class="<?php if ($index == 6) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/duplicate"><i class="fa fa-angle-double-right"></i>Duplicate Candidate</a></li>


            </ul>
          </li>


          <li class="<?php if ($index >= 133 && $index <= 144) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-inr"></i>
              <span>Transaction</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 11) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/tansactions"><i class="fa fa-angle-double-right"></i>Razorpay Transaction </a></li>



            </ul>
          </li>

          <li class="<?php if ($index >= 145 && $index <= 155) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-file"></i>
              <span>Overall Report</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 11) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/yearwiseregistration"><i class="fa fa-angle-double-right"></i>Year Wise Registration</a></li>
              <li class="<?php if ($index == 11) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/report2"><i class="fa fa-angle-double-right"></i>State/City Registration</a></li>


              <li class="<?php if ($index == 11) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/institute_wise_report"><i class="fa fa-angle-double-right"></i>Institute Wise </a></li>

              <li class="<?php if ($index == 11) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/report3"><i class="fa fa-angle-double-right"></i>Advance Search</a></li>

              <li class="<?php if ($index == 10) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/date_wise_registration"><i class="fa fa-angle-double-right"></i>Date Wise Registration </a></li>


              <li class="<?php if ($index == 145) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/journey/exam_candidate_report"><i class="fa fa-angle-double-right"></i>Exam/Candidate Report</a></li>

            </ul>
          </li>




          <li class="<?php if ($index == 125) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 125) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/create_users"><i class="fa fa-angle-double-right"></i>Create User</a></li>

            </ul>
          </li>



          <li class="<?php if ($index == 1205) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Exam</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 1205) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/exam/create_exam"><i class="fa fa-angle-double-right"></i>Create Exam</a></li>

              <li class="<?php if ($index == 1205) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/exam/candidate_link_exam"><i class="fa fa-angle-double-right"></i>Candidate Link to Exam</a></li>

              <li class="<?php if ($index == 1205) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/exam/candidate_details"><i class="fa fa-angle-double-right"></i>Result Update</a></li>

            </ul>
          </li>




          <li class="<?php if ($index == 1206) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-user"></i>
              <span>Journey</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 1206) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/journey/student_journey"><i class="fa fa-angle-double-right"></i>Student Journey</a></li>

            </ul>
          </li>


          <li class="<?php if ($index == 1207) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-phone"></i>
              <span>Communication</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/admin/create_users"><i class="fa fa-angle-double-right"></i>Team</a></li>

              <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/campaign"><i class="fa fa-angle-double-right"></i>Campaign</a></li>

              <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/mode"><i class="fa fa-angle-double-right"></i>Mode</a></li>

              <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/responses"><i class="fa fa-angle-double-right"></i>Responses</a></li>

              <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/candidates"><i class="fa fa-angle-double-right"></i>Create Assignment</a></li>

              <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/assignment_report"><i class="fa fa-angle-double-right"></i>Assignment Report</a></li>

              <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/team_report"><i class="fa fa-angle-double-right"></i>Team Report</a></li>


              <!-- <li class="<?php if ($index == 1207) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/communication/admit_card"><i class="fa fa-angle-double-right"></i>Communication Center</a></li> -->

            </ul>
          </li>

          <!-- create worklog here -->
          <li class="<?php if ($index == 1208) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-line-chart"></i>
              <span>Work Logs</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 1208) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/worklogs/create_worklogs"><i class="fa fa-angle-double-right"></i>Work Logs</a></li>

            </ul>
          </li>

          <li class="<?php if ($index == 1210) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-upload"></i>
              <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li class="<?php if ($index == 1210) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/bulklead/create_master"><i class="fa fa-angle-double-right"></i>Bulk Lead</a></li>

            </ul>
          </li>

          <li class="<?php if ($index == 1211) echo 'active' ?> treeview">
            <a href="#">
              <i class="fa fa-table"></i>
              <span>My Reort</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="<?php if ($index == 1211) echo 'active' ?>"><a href="<?php echo base_url(); ?>index.php/Myreport/filter_report"><i class="fa fa-angle-double-right"></i>My Report</a></li>
            </ul>
          </li>

        </ul>

      </section>
    </aside>

<?php }
} ?>