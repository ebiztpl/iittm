<!DOCTYPE html>
<html>
<head>
 <?php $this->load->view('../layout/head.php'); ?>
 <script src="<?=base_url();?>themes/js/jquery.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular.min.js"></script>
  <script src="<?=base_url();?>themes/js/angular-ui.min.js"></script>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

  <style>
  	

/******************* Timeline Demo - 7 *****************/
span.time{display: block;
    font-size: 17px !important;
    margin: 0px;
    padding: 0px;}
.main-timeline7{overflow:hidden;position:relative}
.main-timeline7 .timeline{width:49%;float:left;z-index:1;position:relative}
.main-timeline7 .timeline:after,.main-timeline7 .timeline:before{content:"";display:block;clear:both}
.main-timeline7 .timeline:before{content:"";width:40px;height:90%;background:#727cb6;position:absolute;top:10%;right:-20px;left: unset;}
.main-timeline7 .timeline:last-child:before{height:0}
.main-timeline7 .timeline-icon{width:80px;height:80px;border-radius:50%;background:#727cb6;overflow:hidden;text-align:center;position:absolute;top:0;right:-40px;z-index:3}
.main-timeline7 .timeline-icon:before{content:"";width:60px;height:60px;border-radius:50%;background:#fff;border:2px solid #727CB6;box-shadow:0 0 0 4px #A5AFE4;margin:auto;position:absolute;top:0;left:0;bottom:0;right:0}
.main-timeline7 .timeline-icon i{font-size:35px;color:#303a3b;line-height:80px;z-index:1;position:relative}
.main-timeline7 .year{display:block;padding:0 60px 0 30px;font-size:25px;color:#303a3b;text-align:right;border-bottom:2px solid #303A3B;z-index:2;position:relative}
.main-timeline7 .year:before{content:"";display:block;width:30px;height:30px;border-radius:50%;background:#727cb6;border:5px solid #fff;box-shadow:0 0 0 4px #727CB6;margin:auto;position:absolute;bottom:-15px;left:4px}
.main-timeline7 .year:after{content:"";border-left:10px solid #303A3B;border-top:10px solid transparent;border-bottom:10px solid transparent;position:absolute;bottom:-11px;left:50px}
.main-timeline7 .timeline-content{padding:18px 60px 18px 40px;text-align:right;position:relative;z-index:1}
.main-timeline7 .timeline-content:after,.main-timeline7 .timeline-content:before{content:"";width:80px;height:150px;border-radius:50%;background:#fff;position:absolute;top:-7%;right:7px;z-index:-1}
.main-timeline7 .timeline-content:after{left:auto;right:-85px}
.main-timeline7 .timeline:last-child .timeline-content:after,.main-timeline7 .timeline:last-child .timeline-content:before{width:0;height:0}
.main-timeline7 .title{font-size:22px;font-weight:700;color:#727cb6;margin-top:0}
.main-timeline7 .description{font-size:15px;color:#7f8386;line-height:25px}
.main-timeline7 .timeline:nth-child(2){margin-top:140px}
.main-timeline7 .timeline:nth-child(even){margin-bottom:80px}
.main-timeline7 .timeline:nth-child(odd){margin:-140px 0 0}
.main-timeline7 .timeline:first-child,.main-timeline7 .timeline:last-child:nth-child(even){margin:0!important}
.main-timeline7 .timeline:nth-child(2n) .timeline-icon,.main-timeline7 .timeline:nth-child(2n):before{right:auto;left:-20px;background:#e77e21}
.main-timeline7 .timeline:nth-child(2n) .timeline-icon{left:-40px}
.main-timeline7 .timeline:nth-child(2n) .year{padding:0 30px 0 60px;text-align:left}
.main-timeline7 .timeline:nth-child(2n) .year:before{left:auto;right:3px}
.main-timeline7 .timeline:nth-child(2n) .year:after{border-left:none;border-right:10px solid #303A3B;right:50px}
.main-timeline7 .timeline:nth-child(2n) .timeline-content{padding:18px 40px 18px 60px;text-align:left}
.main-timeline7 .timeline:nth-child(2n) .timeline-content:before{left:-85px}
.main-timeline7 .timeline:nth-child(2n) .timeline-content:after{left:7px}
.main-timeline7 .timeline:nth-child(2n) .timeline-icon:before{border-color:#e77e21;box-shadow:0 0 0 4px #F1A563}
.main-timeline7 .timeline:nth-child(2n) .year:before{background:#e77e21;box-shadow:0 0 0 4px #E77E21}
.main-timeline7 .timeline:nth-child(2n) .title{color:#e77e21}
.main-timeline7 .timeline:nth-child(3n) .timeline-icon,.main-timeline7 .timeline:nth-child(3n):before{background:#008b8b}
.main-timeline7 .timeline:nth-child(3n) .timeline-icon:before{border-color:#008b8b;box-shadow:0 0 0 4px #50B5B4}
.main-timeline7 .timeline:nth-child(3n) .year:before{background:#008b8b;box-shadow:0 0 0 4px #008B8B}
.main-timeline7 .timeline:nth-child(3n) .title{color:#008b8b}
.main-timeline7 .timeline:nth-child(4n) .timeline-icon,.main-timeline7 .timeline:nth-child(4n):before{background:#ed687c}
.main-timeline7 .timeline:nth-child(4n) .timeline-icon:before{border-color:#ed687c;box-shadow:0 0 0 4px #F798A8}
.main-timeline7 .timeline:nth-child(4n) .year:before{background:#ed687c;box-shadow:0 0 0 4px #ED687C}
.main-timeline7 .timeline:nth-child(4n) .title{color:#ed687c}
@media only screen and (max-width:990px){.main-timeline7 .timeline{width:100%}
.main-timeline7 .timeline:nth-child(even),.main-timeline7 .timeline:nth-child(odd){margin:0}
.main-timeline7 .timeline:before,.main-timeline7 .timeline:nth-child(2n):before{width:30px;height:100%;left:25px}
.main-timeline7 .timeline-icon,.main-timeline7 .timeline:nth-child(2n) .timeline-icon{left:0}
.main-timeline7 .timeline:nth-child(2n) .year,.main-timeline7 .year{text-align:left;padding:0 30px 0 100px}
.main-timeline7 .timeline:nth-child(2n) .year:before,.main-timeline7 .year:before{left:auto;right:4px}
.main-timeline7 .year:after{left:auto;right:50px;border-right:10px solid #303A3B;border-left:none}
.main-timeline7 .timeline-content .description{color:#666}
.main-timeline7 .timeline-content,.main-timeline7 .timeline:nth-child(2n) .timeline-content{text-align:left;padding:18px 40px 18px 100px}
.main-timeline7 .timeline-content:after,.main-timeline7 .timeline-content:before{width:0;height:0}
}
.app-pera {
    border-bottom: solid 1px #E1E1E1;
}
h5.title {
    border-bottom: solid 1px #E1E1E1;
    padding-bottom: 6px;
}
</style>
 <style type="text/css">


.badge.badge-default {
  background-color: #B0BEC5
}

.badge.bg-primary {
  background-color: #2196F3 !important;
}

.badge.badge-secondary {
  background-color: #323a45;
}

.badge.bg-success {
  background-color: #459314;
}

.badge.badge-warning {
  background-color: #FFD600;
}

.badge.badge-info {
  background-color: #29B6F6;
}

.badge.bg-danger {
  background-color: #ef1c1c;
}

.badge.badge-outlined {
  background-color: transparent
}

.badge.badge-outlined.badge-default {
  border-color: #B0BEC5;
  color: #B0BEC5
}

.badge.badge-outlined.badge-primary {
  border-color: #2196F3;
  color: #2196F3
}

.badge.badge-outlined.badge-secondary {
  border-color: #323a45;
  color: #323a45
}

.badge.badge-outlined.badge-success {
  border-color: #64DD17;
  color: #64DD17
}

.badge.badge-outlined.badge-warning {
  border-color: #FFD600;
  color: #FFD600
}

.badge.badge-outlined.badge-info {
  border-color: #29B6F6;
  color: #29B6F6
}

.badge.badge-outlined.badge-danger {
  border-color: #ef1c1c;
  color: #ef1c1c
}


.tracking-detail {
 padding:3rem 0
}
#tracking {
 margin-bottom:1rem
}
[class*=tracking-status-] p {
 margin:0;
 font-size:1.1rem;
 color:#fff;
 text-transform:uppercase;
 text-align:center
}
[class*=tracking-status-] {
 padding:1.6rem 0
}
.tracking-status-intransit {
 background-color:#65aee0
}
.tracking-status-outfordelivery {
 background-color:#f5a551
}
.tracking-status-deliveryoffice {
 background-color:#f7dc6f
}
.tracking-status-delivered {
 background-color:#4cbb87
}
.tracking-status-attemptfail {
 background-color:#b789c7
}
.tracking-status-error,.tracking-status-exception {
 background-color:#d26759
}
.tracking-status-expired {
 background-color:#616e7d
}
.tracking-status-pending {
 background-color:#ccc
}
.tracking-status-inforeceived {
 background-color:#214977
}
.tracking-list {
 /*border:1px solid #e5e5e5*/
}
.tracking-item {
 border-left:1px solid #e5e5e5;
 position:relative;
 padding:2rem 1.5rem .5rem 2.5rem;
/* font-size:.9rem;*/
 margin-left:3rem;
 min-height:5rem
}
.tracking-item:last-child {
 padding-bottom:4rem
}
.tracking-item .tracking-date {
 margin-bottom:.5rem
}
.tracking-item .tracking-date span {
 color:#888;
 font-size:85%;
 padding-left:.4rem
}
.tracking-item .tracking-content {
 padding:.5rem .8rem;
 background-color:#f4f4f4;
 border-radius:.5rem
}
.tracking-item .tracking-content span {
 display:block;
 color:#888;
 font-size:85%
}
.tracking-item .tracking-icon {
 line-height:2.6rem;
 position:absolute;
 left:-1.3rem;
 width:2.6rem;
 height:2.6rem;
 text-align:center;
 border-radius:50%;
 font-size:1.1rem;
 background-color:#fff;
 color:#fff
}
.tracking-item .tracking-icon.status-sponsored {
 background-color:#f68
}
.tracking-item .tracking-icon.status-delivered {
 background-color:#4cbb87
}
.tracking-item .tracking-icon.status-outfordelivery {
 background-color:#f5a551
}
.tracking-item .tracking-icon.status-deliveryoffice {
 background-color:#f7dc6f
}
.tracking-item .tracking-icon.status-attemptfail {
 background-color:#b789c7
}
.tracking-item .tracking-icon.status-exception {
 background-color:#d26759
}
.tracking-item .tracking-icon.status-inforeceived {
 background-color:#214977
}
.tracking-item .tracking-icon.status-intransit {
 color:#000;
 border:1px solid #e5e5e5;

}
@media(min-width:992px) {
 .tracking-item {
  margin-left:10rem
 }
 .tracking-item .tracking-date {
  position:absolute;
  left:-10rem;
  width:7.5rem;
  text-align:right
 }
 .tracking-item .tracking-date span {
  display:block
 }
 .tracking-item .tracking-content {
  padding:0;
  background-color:transparent
 }
}
  </style>

</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="myApp" ng-controller="Dashboard_Details">
<div class="wrapper">
<div id="loading"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>
  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(1206);
  ?>
	
	

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Student Journey
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Journey</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	<div class="page-content">
    		<div class="row">
    			<div class="col-sm-8">

        <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title" style="text-align:center;    text-align: center;    display: block;
    color: red;    font-size: x-large;"><?=$candidate_name; ?></h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">

            	 <div class="">
            <!-- <h4>Timeline Style : Demo-7</h4> -->
            <div class="row">
                <div class="col-md-12">
                    <div class="main-timeline7" style="width: 90%; margin-left: auto; margin-right: auto;">
                        <div class="timeline">
                            <div class="timeline-icon"><i class="fa fa-user"></i></div>
                            <span class="year"><?= date('d-M-Y', strtotime($register)); ?><span class="time"><?= date('H:i:s A', strtotime($register)); ?></span></span>
                            <div class="timeline-content">
                                <h5 class="title">Application</h5>
                                <div class="inner-box-1">
			                    <p><b><?=$candidate_name; ?></b> has applied for the <b><?=$course; ?></b> program at IITTM, aiming to pursue advanced studies in tourism and management. </p>
		                        </div>
                            </div>
                        </div>
                        <div class="timeline">
                            <div class="timeline-icon"><i class="fa fa-check"></i></div>
                             <span class="year"><?= date('d-M-Y', strtotime($complete)); ?><span class="time"><?= date('H:i:s A', strtotime($complete)); ?></span></span>
                            <div class="timeline-content">
                                <h5 class="title">Completed & Pay Fee</h5>
                                <p>Completed the application process, and successfully paid the <b><?=$fee ?></b> fee. The candidate now awaits further steps in the admission procedure.</p>
                            </div>
                        </div>
                        <?php
                          $en =1; $gg=1;  $chk=0;
                        	foreach ($exam as $key => $exams) {
                        		  
                                if($exams['exam_type']=='entrance'){
                                  $type="Entrance: Round-".$en;
                                  $en++;
                                  $icon ='fa fa-desktop';
                                  

                                }
                                if($exams['exam_type']=='gdpi'){
                                  $type="GD/PI Round-".$gg;
                                  $gg++;
                                  $icon ='fa fa-users';
                                  
                                }


                                 $exam1 = $this->db->select("*")->from("candidate_exam")->where("user_id = ".$user_id."")->where("exam_id",$exams['id'])->get()->row();
                                if($exam1)
                                {
                                   $examResult1 = $this->db->select("*")->from("candidate_result")->where("link_id = ".$exam1->id."")->get()->row();
                                   if($examResult1->exam_status=='pass'){$css="success"; $chk +=1;}
                                   if($examResult1->exam_status=='fail'){$css="danger"; $chk -=1;}

                                   if($examResult1->attendance=='absent'){$csss="danger";}
                                   if($examResult1->attendance=='present'){$csss="primary";}
                                   $attendance1 = 'Attempted the '.$exams['exam_type'].' exam, and has been selected for the next round of the '.$course.' admission at IITTM.<br/> <span class="badge bg-'.$csss.'">'.$examResult1->attendance.'</span> <span class="badge bg-'.$css.'">'.$examResult1->exam_status.'</span>';
                                }else{
                                  $attendance1="-";
                                }

                                
                          		    echo '<div class="timeline">
  		                            <div class="timeline-icon"><i class="'.$icon.'"></i></div>
  		                            <span class="year">'.date('d-M-Y', strtotime($exams['start_datetime'])).'</span>
  		                            <div class="timeline-content">
                                  	<h5 class="title">'.$type.'</h5>
                                 		<p>'.$attendance1.'</p>
  		                            </div>
  		                        	</div>';
                                
                        	}

                        ?>


                     
                        
                    </div>
                </div>
            </div>
        </div>

            

            </div>

          </div>


        
        </div>


        <div class="col-sm-4">

        <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Communication</h3>
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">

            <div id="tracking-pre"></div>
            <div id="tracking">
         
            <div class="tracking-list">

              <?php 

                foreach($communication as $key => $comm) {
                    
                    echo '<div class="tracking-item">
                    <div class="tracking-icon status-intransit">
                      <i class="fa fa-user"></i>
                    </div>
                    <div class="tracking-date">'.date('M d, Y',strtotime($comm['call_date'])).'<span>'.date('H:i A',strtotime($comm['call_time'])).'</span></div>
                    <div class="tracking-content">
                    <b>Campaign: </b><span style="color:red; font-size:18px; padding-bottom:10px;">'.$comm['cname'].'</span>
                    <b>Team: </b>'.$comm['tname'].'<br/>
                    <b>Mode: </b>'.$comm['mname'].'<br/>
                    <b>Action: </b>'.$comm['call_action'].'<br/>
                    <b>Response: </b>'.$comm['rname'].'<br/>
                    <b>Note: </b>'.$comm['notes'].'<br/>
                    </div>
                    </div>';

                }

              ?>

           
            
            </div>
         </div>

               
            </div>

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
</body>
</html>

<script>
$(document).ready(function(){
	$("#loading").hide();
});
</script>



<style>
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
