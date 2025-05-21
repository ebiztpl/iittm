/* Mess Setup js */
/* Author: Namrta Mittal*/


var app=angular.module('myapp',[]);
app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});
///////Type Controller////////
app.controller('TypeCtrl',function($scope, $http, $timeout){
	$scope.type_name="";
	$scope.type_id=0;
	$scope.msg="";
	$scope.status="";
	///////Check Validation///////////
	 $scope.type_check = function($event){
        if($scope.myForm.$invalid)
        {
			$scope.msgerror="This field is required";
         
        }else{
			$scope.AddEditType();
                          
		}
	};
	///Show Add Edit Type modal///
	$scope.showAddTypeModal =function($categoryJson=""){
		if($categoryJson!=""){
			$scope.type_name=$categoryJson.type_name;
			$scope.type_id=$categoryJson.type_id;
		}else{
			$scope.type_name='';
			$scope.type_id=0;
			$scope.msg="";
			$scope.msgerror="";
		}
		$timeout(function(){
			
			$('#TypeModal').modal('show'); 
		},500);
		
	}
	//////Add Type//////////
	$scope.AddEditType=function(){
		$scope.hastrue=true;
		var xsrf = $.param({type_name: $scope.type_name, type_id: $scope.type_id});
		$http({
			url: 'AddEditType',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.type_name='';
				$scope.type_id=0;
				$('#TypeModal').modal('hide'); 
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.type_name='';
				$scope.type_id=0;
				$('#TypeModal').modal('hide'); 
				//errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	$scope.getId = function($id){
		$scope.type_id=$id;
	}
	$scope.deleteType =function(){
		$scope.hastrue=true;
		$http({
			url:'deleteType/'+$scope.type_id,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
			}
			$scope.userid=0;
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				/* //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers; */$scope.hastrue=false;
		});
	}
});
//////Meal Plan Controller////////
app.controller('MealCtrl',function($scope,$filter, $http, $timeout){
	$scope.meal_name="";
	$scope.valid_from="";
	$scope.valid_to="";
	$scope.amount='';
	$scope.mealnamesarr=[];
	$scope.mealnames=[];
	$scope.meal_type=0;
	$scope.meal_id=0;
	$scope.msg="";
	$scope.status="";
	onfetch('mealsdata',1);
	onfetch('getAlltype',2);
	Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};
	
	Array.prototype.remove = function (index) {
	  this.splice(index,1);
	};
  
	function onfetch($val,$id){
		$http({
			url: $val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {				
				
					if($id==1){
						$scope.mealsarr=[];
						$scope.mealsarr=data.data;
					}else if($id==2){
						$scope.typearr=[];
						$scope.typearr=data.data;
						$scope.typearr.insert(0,{id:0, name:"---- All Types----"});	
					
					}
				
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
		
	}
	////Set Comma Checkbox Value /////////
	$scope.toggleSelection = function toggleSelection(selectionName, listSelection){
		var idx = listSelection.indexOf(selectionName);
		
		// is currently selected
		if (idx > -1) {
			listSelection.splice(idx, 1);
			
		}// is newly selected
		else {
			listSelection.push(selectionName);
		}
	};
	//////Set ToDate After Fromdate////////
	$scope.timediffest = function($leaveto){
		var fromdate=$("#valid_from").datepicker( "getDate" );
		if(fromdate==null){
			alert("Select valid from date");
			$('#valid_to').val("");
		}else{
			fromdate.setDate(fromdate.getDate());
			$('#valid_to').datepicker("remove");
			$('#valid_to').datepicker({
				startDate: fromdate,
				format: 'dd/mm/yyyy'
			});
		}
		
	}
	///Show Add Edit Type modal///
	$scope.showAddMealModal =function($categoryJson=""){
		if($categoryJson!=""){
			$scope.meal_name=$categoryJson.meal_name;
			$scope.meal_id=$categoryJson.meal_id;
			$scope.valid_from=$filter('date')(new Date($categoryJson.valid_from.split('-').join('/')), "MM/dd/yyyy");
			$scope.valid_from
			$scope.valid_to=$filter('date')(new Date($categoryJson.valid_to.split('-').join('/')), "MM/dd/yyyy");
			$scope.amount=$categoryJson.amount;
			$scope.mealnamesarr=($categoryJson.meals.split(','));
			$scope.meal_type=$categoryJson.meal_type;
		}else{
			$scope.meal_name="";
			$scope.valid_from="";
			$scope.valid_to="";
			$scope.amount='';
			$scope.mealnamesarr=[];
			$scope.mealnames=[];
			$scope.meal_type=0;
			$scope.meal_id=0;
			$scope.msg="";
			$scope.status="";
		}
		$timeout(function(){
			
			$('#MealModal').modal('show'); 
		},500);
		
	}
	////////Check Validations///////////
	 $scope.meals_validation = function($event){
        if($scope.myForm.$invalid)
        {
			$scope.msgerror="This field is required";
			if($scope.mealnames.length==0){
				$scope.mealarr="select atleast one meal";
			}
			if($scope.meal_type==0){
				$scope.msgerror="This field is required";
			}
        }else{
			$scope.AddEditMealPlan();
                          
		}
	};
	//////Add Type//////////
	$scope.AddEditMealPlan=function(){
		$scope.hastrue=true;
		var xsrf = $.param({meal_name: $scope.meal_name, valid_from: $scope.valid_from, valid_to: $scope.valid_to, amount: $scope.amount, mealnames: $scope.mealnamesarr, meal_type: $scope.meal_type, meal_id: $scope.meal_id});
		$http({
			url: 'AddEditMealPlan',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.isCheck=false;
				$scope.meal_name="";
				$scope.valid_from="";
				$scope.valid_to="";
				$scope.amount='';
				$scope.mealnamesarr=[];
				$scope.mealnames=[];
				$scope.meal_type=0;
				$scope.meal_id=0;
				$('#MealModal').modal('hide'); 
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.meal_name="";
				$scope.valid_from="";
				$scope.valid_to="";
				$scope.amount='';
				$scope.mealnamesarr=[];
				$scope.mealnames=[];
				$scope.meal_type=0;
				$scope.meal_id=0;
				$('#MealModal').modal('hide'); 
				//errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	$scope.getId = function($id){
		$scope.meal_id=$id;
	}
	$scope.deleteType =function(){
		$scope.hastrue=true;
		$http({
			url:'deleteMealPlan/'+$scope.meal_id,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
			}
			$scope.userid=0;
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				/* //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers; */$scope.hastrue=false;
		});
	}
});
///////Meal Time Slot Controller///////////
app.controller('MealTimeSlotCtrl',function($scope,$filter, $http, $timeout){
	$scope.slottype="";
	$scope.mealnamesarr=[];
	$scope.slot_id=0;
	$scope.msg="";
	$scope.status="";
	onfetch('mealsdata',1);
	Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};
	
	Array.prototype.remove = function (index) {
	  this.splice(index,1);
	};
  
	function onfetch($val,$id){
		$http({
			url: $val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {				
				if($id==1){
					$scope.mealsarr=[];
					$scope.mealsarr=data.data;
				}
				$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	///Show Add Edit Type modal///
	$scope.AddMealTimeModal =function($categoryJson=""){
		if($categoryJson!=""){
			$scope.meal_name=$categoryJson.meal_name;
			
		}else{
			$scope.slot_id=0;
			$scope.slottype="";
			$scope.msgerror="";
			$scope.timeerror="";
			//onfetch('mealsdata',1);
			$scope.msg="";
			$scope.status="";
		}
		$timeout(function(){
			
			$('#MealtimeModal').modal('show'); 
		},500);
		
	}
	////////Check Validations///////////
	 $scope.meals_slot_validation = function($event)
      {
        if($scope.myForm.$invalid) {
			if($scope.slottype=="")
			$scope.msgerror="This field is required";
		
			 for(var i=0;i<$scope.mealsarr.length;i++){
				var timefromVal=$("#time_from"+$scope.mealsarr[i]['id']).val();
				var timetoVal=$("#time_to"+$scope.mealsarr[i]['id']).val();
				console.log(timefromVal.match(/\d+:\d+/));
				if(timefromVal.match(/\d+:\d+/)==null){
					
					$scope.errorshow=true;
					$scope.timeerror="All Time From && Time To required";
					break;
				}else{
					$scope.errorshow=false;
				}
				if(timetoVal.match(/\d+:\d+/)==null){
					$scope.errorshow=true;
					$scope.timeerror="All Time From && Time To required";
					break;
				}else{
					$scope.errorshow=false;
				}
			} 
			
        }else{
			$scope.AddMealTimeSlot();
                          
		}
	};
	//////Add Type//////////
	$scope.AddMealTimeSlot=function(){
		$scope.hastrue=true;
		var json = angular.toJson($scope.mealsarr);
		var xsrf = $.param({slottype: $scope.slottype,mealtype:json});
		$http({
			url: 'AddMealTimeSlot',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.isCheck=false;
				$scope.slot_id=0;
				$scope.slottype="";
				$scope.msgerror="";
				$scope.timeerror="";
				onfetch('mealsdata',1);
				$('#MealtimeModal').modal('hide'); 
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.slot_id=0;
				$scope.slottype="";
				$scope.msgerror="";
				$scope.timeerror="";
				onfetch('mealsdata',1);
				$('#MealtimeModal').modal('hide'); 
				//errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	$scope.getId = function($id){
		$scope.meal_id=$id;
	}
	$scope.deleteType =function(){
		$scope.hastrue=true;
		$http({
			url:'deleteMealPlan/'+$scope.meal_id,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
			}
			$scope.userid=0;
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				/* //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers; */$scope.hastrue=false;
		});
	}
});
////////Payment Recived Controller////////////
app.controller('PaymentCtrl',function($scope,$filter, $http, $timeout){
	$scope.mobile="";
	$scope.username="";
	$scope.paytype="";
	$scope.datepay="";
	$scope.monthpay="";
	$scope.paymode='';
	$scope.paidto="";
	$scope.meal_plan=0;
	$scope.amount='';
	$scope.payment_id=0;
	$scope.user_id=0;
	$scope.trans_id="";
	$scope.msg="";
	$scope.status="";
	$scope.showmonth=false;
	$scope.showdate=false;
	onfetch('getAllMeals',1);
	Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};
	
	Array.prototype.remove = function (index) {
	  this.splice(index,1);
	};
	$scope.SetMonth=function($val){
		if($val==1){
			$scope.showmonth=true;
			$scope.showdate=false;
			$scope.datepay="";
		}else if($val==2){
			$scope.showmonth=false;
			$scope.showdate=true;
			$scope.monthpay="";
			
		}
			
	}
	$scope.getuserdata=function($mobile){
		$scope.mobile=$mobile;
		
		$http({
			url: "getUserData/"+$scope.mobile,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {	
				if(data.data.userData['status']==true){
					$scope.findsts=true;
					$scope.user_id=data.data.userData['user_id'];
					$scope.username=data.data.userData['user_name'];
					$scope.meal_plan=data.data.userData['plan_id'];
				}else{
					$scope.findsts=false;
					$scope.user_id='';
					$scope.username='';
					$scope.meal_plan='';
					$scope.nodatafound='No data found';
				}
				$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	function onfetch($val,$id){
		$http({
			url: $val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {				
				if($id==1){
					$scope.mealplansarr=[];
					$scope.mealplansarr=data.data;
					$scope.mealplansarr.insert(0,{id:0, name:"---- All Meal Plan----"});	
				}
				$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	///Show Add Edit Type modal///
	$scope.showPaymentModal =function($categoryJson=""){
		if($categoryJson!=""){
			$scope.meal_name=$categoryJson.meal_name;
			
		}else{
			$scope.mobile="";
			$scope.username="";
			$scope.paytype="";
			$scope.payment_id=0;
			$scope.nodatafound="";
			$scope.showmonth=false;
			$scope.showdate=false;
			//onfetch('mealsdata',1);
			$scope.msg="";
			$scope.status="";
		}
		$timeout(function(){
			
			$('#paymentModal').modal('show'); 
		},500);
		
	}
	////////Check Validations///////////
	 $scope.payment_validation = function($event)
      {
        if($scope.myForm.$invalid) {
			if($scope.paytype=="")
			$scope.msgerror="This field is required";
		if($scope.paidto=="")
			$scope.msgerror="This field is required";
		if($scope.paymode=="")
			$scope.msgerror="This field is required";
		if($scope.meal_plan==0)
			$scope.msgerror="This field is required";
		
			 
        }else{
			$scope.AddPayment();
                          
		}
	};
	//////Add Payment//////////
	$scope.AddPayment=function(){
		$scope.hastrue=true;
		var xsrf = $.param({user_id: $scope.user_id, mobile:$scope.mobile, username:$scope.username, paytype:$scope.paytype, monthpay:$scope.monthpay, datepay:$scope.datepay, meal_plan:$scope.meal_plan, amount:$scope.amount, paidto:$scope.paidto,paymode:$scope.paymode,trans_id:$scope.trans_id });
		$http({
			url: 'AddPayment',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.mobile="";
				$scope.username="";
				$scope.paytype="";
				$scope.datepay="";
				$scope.monthpay="";
				$scope.paymode='';
				$scope.paidto="";
				$scope.meal_plan=0;
				$scope.amount='';
				$scope.payment_id=0;
				$scope.user_id=0;
				$scope.trans_id="";
				$scope.showmonth=false;
				$scope.showdate=false;
				$('#paymentModal').modal('hide'); 
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.mobile="";
				$scope.username="";
				$scope.paytype="";
				$scope.datepay="";
				$scope.monthpay="";
				$scope.paymode='';
				$scope.paidto="";
				$scope.meal_plan=0;
				$scope.amount='';
				$scope.payment_id=0;
				$scope.user_id=0;
				$scope.showmonth=false;
				$scope.showdate=false;
				$('#paymentModal').modal('hide'); 
				//errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	$scope.getId = function($id){
		$scope.meal_id=$id;
	}
	$scope.deleteType =function(){
		$scope.hastrue=true;
		$http({
			url:'deletePayment/'+$scope.payment_id,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
			}
			$scope.userid=0;
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				/* //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers; */$scope.hastrue=false;
		});
	}
});
//////Item Master Controller////////
app.controller('ItemMasterCtrl',function($scope,$filter, $http, $timeout){
	$scope.item_name="";
	$scope.mealnamesarr=[];
	$scope.mealnames=[];
	$scope.cate_id=0;
	$scope.item_id=0;
	$scope.msg="";
	$scope.status="";
	onfetch('mealsdata',1);
	onfetch('categorydata',2);
	
	Array.prototype.insert = function (index, item) {
	  this.splice(index, 0, item);
	};
	
	Array.prototype.remove = function (index) {
	  this.splice(index,1);
	};
  
	function onfetch($val,$id){
		$http({
			url: $val,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		  }).success(function (data, status, headers, config) {				
				
					if($id==1){
						$scope.mealsarr=[];
						$scope.mealsarr=data.data;
					}else if($id==2){
						$scope.catearr=[];
						$scope.catearr=data.data;
						$scope.catearr.insert(0,{id:0, name:"---- All Category----"});	
					
					}
				
				$scope.hastrue=false;
			}).error(function (data, status, headers, config) {
				//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
				$scope.hastrue=false;
			});
		
	}
	////Set Comma Checkbox Value /////////
	$scope.toggleSelection = function toggleSelection(selectionName, listSelection){
		var idx = listSelection.indexOf(selectionName);
		
		// is currently selected
		if (idx > -1) {
			listSelection.splice(idx, 1);
			
		}// is newly selected
		else {
			listSelection.push(selectionName);
		}
	};
	
	///Show Add Edit Item Master modal///
	$scope.showAddItemModal =function($categoryJson=""){
		if($categoryJson!=""){
			$scope.item_name=$categoryJson.item_name;
			$scope.item_id=$categoryJson.item_id;
			$scope.mealnamesarr=($categoryJson.meal_plan.split(','));
			$scope.cate_id=$categoryJson.cate_id;
		}else{
			$scope.item_name="";
			$scope.cate_id=0;
			$scope.mealnamesarr=[];
			$scope.mealnames=[];
			$scope.item_id=0;
			$scope.msg="";
			$scope.status="";
		}
		$timeout(function(){
			
			$('#ItemModal').modal('show'); 
		},500);
		
	}
	//////Check Category Validation/////////
	$scope.cate_validation=function(){
		if($scope.myForm1.$invalid){
			$scope.msgerror1="This field is required";
		}else{
			$scope.AddCategory();
		}
	}
	///////Add Category//////////
	$scope.AddCategory= function(){
		var xsrf = $.param({cate_name: $scope.cate_name});
		$http({
			url: 'AddCategory',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.cate_name="";
				onfetch('categorydata',2);
				$('#categorymodal').modal('hide'); 
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.cate_name="";
				$('#categorymodal').modal('hide'); 
				//errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
		
	}
	////////Check Validations///////////
	 $scope.item_validation = function($event){
        if($scope.myForm.$invalid)
        {
			$scope.msgerror="This field is required";
			if($scope.mealnames.length==0){
				$scope.mealarr="select atleast one meal";
			}
			if($scope.cate_id==0){
				$scope.msgerror="This field is required";
			}
        }else{
			$scope.AddEditItemPlan();
                          
		}
	};
	//////Add Type//////////
	$scope.AddEditItemPlan=function(){
		$scope.hastrue=true;
		var xsrf = $.param({item_name: $scope.item_name, cate_id: $scope.cate_id, mealnames: $scope.mealnamesarr,item_id: $scope.item_id});
		$http({
			url: 'AddEditItemPlan',
			method: "POST",
			data: xsrf,
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.isCheck=false;
				$scope.item_name="";
				$scope.cate_id=0;
				$scope.mealnamesarr=[];
				$scope.mealnames=[];
				$scope.item_id=0;
				$('#ItemModal').modal('hide'); 
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
				$scope.item_name="";
				$scope.cate_id=0;
				$scope.mealnamesarr=[];
				$scope.mealnames=[];
				$scope.item_id=0;
				$('#ItemModal').modal('hide'); 
				//errorMessage(data.errorMsg);
			}
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
			//errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers;
			$scope.hastrue=false;
		});
	}
	
	$scope.getId = function($id){
		$scope.meal_id=$id;
	}
	$scope.deleteType =function(){
		$scope.hastrue=true;
		$http({
			url:'deleteMealPlan/'+$scope.meal_id,
			method: "POST",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		}).success(function (data, status, headers, config) {
			if(data.status){
				$scope.status=data.status;
				$scope.msg=data.msg;
				table.ajax.reload();
			}else{
				$scope.status=data.status;
				$scope.msg=data.msg;
			}
			$scope.userid=0;
			$scope.hastrue=false;
		}).error(function (data, status, headers, config) {
				/* //errorMessage("error: "+$scope.status);//$scope.status = status + ' ' + headers; */$scope.hastrue=false;
		});
	}
});
