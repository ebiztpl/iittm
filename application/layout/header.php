<header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url();?>index.php/admin/dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">IITTM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">IITTM</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>


       <!--div class="col-sm-1 pull-right text-right" style="margin-top:7px;">
        <form action="db_session" id="db_session" method="post">
          <select class="form-control" name="dbname" id="dbname" >
			  <option value="iittm_2025~iittm_2025~@hgP629r6" selected="" <?php if($this->session->userdata('dbname')=='iittm_2025'){echo "selected";} ?>>2025</option>
			  <option value="iittm_2024~iittm_root_2024~*yWje2659" <?php if($this->session->userdata('dbname')=='iittm_2024'){echo "selected";} ?>>2024</option>
			  <option value="iittm_2023~iittm_root~*yWje2659" <?php if($this->session->userdata('dbname')=='iittm_2023'){echo "selected";} ?>>2023</option>
			  <option value="iittm_2022~iittm_2022~*yWje2659" <?php if($this->session->userdata('dbname')=='iittm_2022'){echo "selected";} ?> >2022</option>
			  <option value="iittm_2021~iittm_2021~*yWje2659" <?php if($this->session->userdata('dbname')=='iittm_2021'){echo "selected";} ?> >2021</option>
              <option value="iittm_2020~iittm_2020~*yWje2659" <?php if($this->session->userdata('dbname')=='iittm_2020'){echo "selected";} ?> >2020</option>
  
          </select>
        </form>
        </div-->

      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             
              <span class="hidden-xs"><?= $this->session->userdata['admin_name']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header" style="height: auto;">
               
                <p>
                 Welcome <?= $this->session->userdata['admin_name']; ?>
                </p>
              </li>
              <li class="user-footer">
                <div class="text-center">
                  <a href="<?php echo base_url();?>index.php/admin/logout" class="btn btn-success btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        
        </ul>
      </div>
    </nav>
  </header>