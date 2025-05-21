<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('../layout/head.php'); ?>
<script src="<?=base_url();?>themes/js/jquery.min.js"></script>
<script src="<?=base_url();?>themes/js/angular.min.js"></script> 
<style type="text/css">.progress{margin-bottom: 0px;} .progress-bar{font-size: 15px;}</style>
	 <style type="text/css">
   
#mapdiv {
  height: 100%;
  width: 100%;
}
#mapdiv2 {
  height: 100%;
  width: 100%;
}
div.arrow_box {
    font-size: 13px;
    width: 77px;
    height: auto;
    padding:5px;
    text-align: center;
    background: #000;
    border-radius: 8px;
    margin: 36px -39px;
    color: #FFFFFF;
    cursor: pointer;
    overflow: hidden;
}
div.arrow_box img {
  min-width: 150px;
  width: auto;
  max-height: 100px;
  height: auto;
  border-radius: 5px;
}
.arrow_box:after {
  top: 30px;
  left: 0px;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(136, 183, 213, 0);
  border-top-color: blue;
  border-width: 5px;
  margin-left: -5px;
}
.arrow_box {
  position: absolute;
  font-size: 10px;
  width: 60px;
  height: 20px;
  background: blue;
  border-radius: 10px;
  margin: 10px -30px;
  color: white;
  cursor: pointer;
}
.arrow_box img {
  min-width: 150px;
  width: auto;
  max-height: 100px;
  height: auto;
  border-radius: 5px;
}
.arrow_box:after {
    top: 0px;
    left: 50%;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    border-color: rgba(136, 183, 213, 0);
    border-top-color: #ffffff00;
    border-width: 5px;
    margin-left: -5px;
}
  </style>
<script src="<?=base_url();?>themes/js/jquery.min.js"></script>

</head>
<body class="skin-blue sidebar-mini sidebar-collapse" ng-app="" ng-controller="validateCtrl">

<div id="loading" class="text-center"><img src="<?php echo base_url();?>/themes/img/loader.gif" /></div>

<div class="wrapper">

  <?php $this->load->view('../layout/header.php'); ?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php $this->load->view('../layout/sidemenu.php'); 
		sidebar(1);
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <div class="row">
    

        <div class="col-sm-3">
		<label>Course</label>
        <select class="form-control" name="course" id="course" ng-model="course" ng-change="get_course()">
          <option value="">All</option>
          <option value="1">BBA</option>
          <option value="2">MBA</option>
        </select>

        </div>
		
		<div class="col-sm-3">
		<label>Study Centre</label>
        <select name="first_code" class="form-control common_code" ng-model="study_center" id="study_center">
          <option value="">All</option>
          <option value="Gwalior">Gwalior</option>
          <option value="Bhubaneswar">Bhubaneswar</option>
          <option value="Noida">Noida</option>
          <option value="Nellore">Nellore</option>
		  <option value="Goa">Goa</option>
         </select>

        </div>

	<div class="col-sm-3" style="padding-top:25px;">
	<a class="btn btn-primary" ng-click="search()" ng-model="search_btn">Search</a>
	</div>
       
     

      </div>

     

    </section>

    <!-- Main content -->
    <section class="content">
   
   

    <div class="row">
        <div class="col-sm-12">
			<div class="box box-solid">
				<div class="box-header with-border">
				  <h3 class="box-title">State Wise Candidates </h3>

				  <div class="box-tools">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
					</button>
				  </div>
				</div>
				<div class="box-body">
				  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDL_myFpsCy0rvkSqRyYPC2gyQ-7Xsvx4k&v=3.exp&sensor=false"></script>
	 
			<div class="col-sm-12">
				 <div id="map" style="width:100%; height:500px;" ng-init="make_map(this)"></div>
				 <div id="map_filter" style="width:100%; height:500px;"></div>
			</div>
			
				
			
	 
	      
       


				</div>
			</div>
		</div>
    </div>


    
   
</section>

</div>

  
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
    $("#loading").hide();
	$("#map_filter").hide();

  });


function validateCtrl($scope,$log,$http)
{

	
 

	
	
   $scope.make_map = function($event){
   
       var locations =[<?php echo $result ?>];      
       
       var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4.7,
          center: new google.maps.LatLng(22.72, 75.83),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
        });
	   
	    function HTMLMarker(lat, lng, price) {
		this.price = price;
		this.pos = new google.maps.LatLng(lat, lng);
	  	}
	   
	   HTMLMarker.prototype = new google.maps.OverlayView();
	   HTMLMarker.prototype.onRemove = function() {}
	   HTMLMarker.prototype.onAdd = function() {
		   this.div = document.createElement('div');
		   this.div.className = "arrow_box d-flex";
		   this.div.innerHTML = "<div class='m-auto'> " + this.price + "</div>";
		   var panes = this.getPanes();
		   panes.overlayMouseTarget.appendChild(this.div);
	   }
	   HTMLMarker.prototype.draw = function() {
		   var overlayProjection = this.getProjection();
		   var position = overlayProjection.fromLatLngToDivPixel(this.pos);
		   this.div.style.left = position.x + 'px';
		   this.div.style.top = (position.y - 35) + 'px';
	   }
	    for (let i = 0; i < locations.length; i++) {
			let htmlMarker = new HTMLMarker(locations[i][1], locations[i][2], locations[i][0]);
			htmlMarker.setMap(map);
		  }
	   
	    for (i = 0; i < locations.length; i++) {
          //console.log(locations.length);
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),map: map
                    });
          google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
                        return function () {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map, marker);
            }
                    })(marker, i));
                }
	    
	   
       

 };

  
      $scope.search = function($event) {
       $("#loading").show();
       var course = angular.element(document.querySelector('#course')).val();
	   var study_center = angular.element(document.querySelector('#study_center')).val();
	   
	   if(course=='' && study_center=='')
	   {
		   window.location= ("maps");
	   }
	   
	   else if(course!='' && study_center!='')
	   {
		   var data = course+"~"+study_center;
		   
		   $http({
			  method: "get",
			  dataType: 'html',
			  url: "<?php echo site_url('admin/get_map_both?data=');?>"+data}).then(function(response){
            
			 $("#map").hide();
			 $("#map_filter").show();
             $("#loading").hide();
             
				var map;
				var bounds = new google.maps.LatLngBounds();
				var mapOptions = {
					 mapTypeId: 'roadmap'
				};
                 
				 // Display a map on the page
				map = new google.maps.Map(document.getElementById("map_filter"), mapOptions);
				map.setTilt(45);
 
				// Multiple Markers
				var markers = JSON.parse(response.data['result']);
				console.log(markers);
				  
				 var infoWindowContent = JSON.parse(response.data['result1']);       
					 
				// Display multiple markers on a map
				var infoWindow = new google.maps.InfoWindow(), marker, i;
				 
				// Loop through our array of markers &amp; place each one on the map  
				for( i = 0; i < markers.length; i++ ) 
				{
					var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(position);
					marker = new google.maps.Marker({
						position: position,
						map: map,
						title: markers[i][0]
					});
					 
					// Each marker to have an info window    
					google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
						return function() {
							infoWindow.setContent(infoWindowContent[i][0]);
							infoWindow.open(map, marker);
						}
					})(marker, i));
				 
					// Automatically center the map fitting all markers on the screen
					map.fitBounds(bounds);
				}
			 
				// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
				var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
					this.setZoom(4.7);
					google.maps.event.removeListener(boundsListener);
				});
            }); 
	   }
	   else if(course!='')
	   {
		  $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/get_map_course?data=');?>"+course}).then(function(response){
            
			 $("#map").hide();
			 $("#map_filter").show();
             $("#loading").hide();
             
				var map;
				var bounds = new google.maps.LatLngBounds();
				var mapOptions = {
					 mapTypeId: 'roadmap'
				};
                 
				 // Display a map on the page
				map = new google.maps.Map(document.getElementById("map_filter"), mapOptions);
				map.setTilt(45);
 
				// Multiple Markers
				var markers = JSON.parse(response.data['result']);
				console.log(markers);
				  
				 var infoWindowContent = JSON.parse(response.data['result1']);       
					 
				// Display multiple markers on a map
				var infoWindow = new google.maps.InfoWindow(), marker, i;
				 
				// Loop through our array of markers &amp; place each one on the map  
				for( i = 0; i < markers.length; i++ ) 
				{
					var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(position);
					marker = new google.maps.Marker({
						position: position,
						map: map,
						title: markers[i][0]
					});
					 
					// Each marker to have an info window    
					google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
						return function() {
							infoWindow.setContent(infoWindowContent[i][0]);
							infoWindow.open(map, marker);
						}
					})(marker, i));
				 
					// Automatically center the map fitting all markers on the screen
					map.fitBounds(bounds);
				}
			 
				// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
				var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
					this.setZoom(4.7);
					google.maps.event.removeListener(boundsListener);
				});
            }); 
	   }
	   
	   else if(study_center!='')
	   {
		  
		  $http({
          method: "get",
          dataType: 'html',
          url: "<?php echo site_url('admin/get_map_center?data=');?>"+study_center}).then(function(response){
            
			 $("#map").hide();
			 $("#map_filter").show();
             $("#loading").hide();
             
				var map;
				var bounds = new google.maps.LatLngBounds();
				var mapOptions = {
					 mapTypeId: 'roadmap'
				};
                 
				 // Display a map on the page
				map = new google.maps.Map(document.getElementById("map_filter"), mapOptions);
				map.setTilt(45);
 
				// Multiple Markers
				var markers = JSON.parse(response.data['result']);
				console.log(markers);
				  
				 var infoWindowContent = JSON.parse(response.data['result1']);       
					 
				// Display multiple markers on a map
				var infoWindow = new google.maps.InfoWindow(), marker, i;
				 
				// Loop through our array of markers &amp; place each one on the map  
				for( i = 0; i < markers.length; i++ ) 
				{
					var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(position);
					marker = new google.maps.Marker({
						position: position,
						map: map,
						title: markers[i][0]
					});
					 
					// Each marker to have an info window    
					google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
						return function() {
							infoWindow.setContent(infoWindowContent[i][0]);
							infoWindow.open(map, marker);
						}
					})(marker, i));
				 
					// Automatically center the map fitting all markers on the screen
					map.fitBounds(bounds);
				}
			 
				// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
				var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
					this.setZoom(4.7);
					google.maps.event.removeListener(boundsListener);
				});
            }); 
	   }
	   
	   
	   
	   
       
      
      };
       
   
     
 
}
</script>

 

<style type="text/css">
    #loading
    {
    width: 100%;
    height: 100%;
    background-color: #000000ba;
    position: absolute;
    z-index: 99999; 
    padding-top: 30%;
    }
  </style>
<?php $this->load->view('../layout/footer.php'); ?>
  
</body>
</html>
