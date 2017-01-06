jQuery(document).ready(function() {
	
	
	
	if(document.getElementById('countryHidden') !=null){
	
		var VarCountry = document.getElementById('countryHidden').value;
		var options = {		
			componentRestrictions: {country: VarCountry}
		};
	  

		var drop = document.getElementById('typeSourceValue');
		var drop_autocomplete = new google.maps.places.Autocomplete(drop,options);
		
		var drop = document.getElementById('typeDestinationValue');
		var drop_autocomplete = new google.maps.places.Autocomplete(drop,options);		
	
		
	}
	if(document.getElementById('countryHiddenListAddress') !=null){	
		var VarCountry = document.getElementById('countryHiddenListAddress').value;
		var options = {		
			componentRestrictions: {country: VarCountry}
		};	  

		var drop = document.getElementById('address');
		var drop_autocomplete = new google.maps.places.Autocomplete(drop,options);
	}		
	
	
	
	jQuery('#typeIdCar').on('change', function(){
		//var selectedCarTypeId = jQuery(this).find("option:selected").val();
		jQuery('#selecttypeIDcarCalendar').submit();
	
	});
	jQuery('#future').on('change', function(){
		//var selectedCarTypeId = jQuery(this).find("option:selected").val();
		jQuery('#selecttypeIDcarCalendar').submit();
	
	});	

	
	jQuery('#checkboxALL').click(function(event) {
		
		
		jQuery("input:checkbox").prop('checked', jQuery(this).prop("checked"));
	});	
	
	
	
	if(document.getElementById('tblAppendGrid') !=null){
		jQuery('#tblAppendGrid').appendGrid({	
			
			caption: 'Type Cars',
			initRows: 1,
			columns: [
				{ name: 'id', display: 'id', type: 'text', ctrlAttr: { maxlength: 40, 'readonly': 'readonly'  }, ctrlCss: { width: '100px'} },		
				{ 
					name: 'carType', display: 'carType', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '160px'},
						onChange: function (evt, rowIndex) {
							var idRow = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', rowIndex);
							if(idRow != "") {	
								var dataAjax = {
									'action': 'ajax_type_car_admin',
									'carType': jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'carType', rowIndex),
									'id': idRow,
								}
								jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
									document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
									setTimeout(function(){
										document.getElementById("tblAppendGridStatus").innerHTML = "";
										}, 1000);													
								});	
							}
						}
				},
				{ 
					name: 'carFare', display: 'carFare', type: 'ui-spinner', ctrlAttr: { maxlength: 40 }, ctrlCss: { width: '100px' }, 
						onChange: function (evt, rowIndex) {
							var idRow = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', rowIndex);
							if(idRow != "") {	
								var dataAjax = {
									'action': 'ajax_type_car_admin',
									'carFare': jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'carFare', rowIndex),
									'id': idRow,
								}
								jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
									document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
									setTimeout(function(){
										document.getElementById("tblAppendGridStatus").innerHTML = "";
										}, 1000);													
								});	
							}
						} 
				},
				{ 
					name: 'carSeat', display: 'carSeat', type: 'ui-spinner', ctrlAttr: { maxlength: 40 }, ctrlCss: { width: '100px'},
						onChange: function (evt, rowIndex) {
							var idRow = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', rowIndex);
							if(idRow != "") {	
								var dataAjax = {
									'action': 'ajax_type_car_admin',
									'carSeat': jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'carSeat', rowIndex),
									'id': idRow,
								}
								jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
									document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
									setTimeout(function(){
										document.getElementById("tblAppendGridStatus").innerHTML = "";
										}, 1000);													
								});	
							}
						} 									
					
				},
				{ 
					name: 'suitcases', display: 'suitcases', type: 'ui-spinner', ctrlAttr: { maxlength: 40 }, ctrlCss: { width: '100px'},
						onChange: function (evt, rowIndex) {
							var idRow = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', rowIndex);
							if(idRow != "") {						
								var dataAjax = {
									'action': 'ajax_type_car_admin',
									'suitcases': jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'suitcases', rowIndex),
									'id': idRow,
								}
								jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
									document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
									setTimeout(function(){
										document.getElementById("tblAppendGridStatus").innerHTML = "";
										}, 1000);													
								});	
							}
						} 									
				},
				{ 
					name: 'farePerDistance', display: 'farePerDistance', type: 'ui-spinner', ctrlAttr: { maxlength: 40 }, ctrlCss: { width: '100px'},
						onChange: function (evt, rowIndex) {
							var idRow = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', rowIndex);
							if(idRow != "") {						
								var dataAjax = {
									'action': 'ajax_type_car_admin',
									'farePerDistance': jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'farePerDistance', rowIndex),
									'id': idRow,
								}
								jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
									document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
									setTimeout(function(){
										document.getElementById("tblAppendGridStatus").innerHTML = "";
										}, 1000);													
								});	
							}
						} 									
				},
				{ 
					name: 'farePerMinute', display: 'farePerMinute', type: 'ui-spinner', ctrlAttr: { maxlength: 40 }, ctrlCss: { width: '100px'},
						onChange: function (evt, rowIndex) {
							var idRow = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', rowIndex);
							if(idRow != "") {						
								var dataAjax = {
									'action': 'ajax_type_car_admin',
									'farePerMinute': jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'farePerMinute', rowIndex),
									'id': idRow,
								}
								jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
									document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
									setTimeout(function(){
										document.getElementById("tblAppendGridStatus").innerHTML = "";
										}, 1000);													
								});	
							}
						} 									
				},
				{ 
					name: 'farePerSeat', display: 'farePerSeat', type: 'ui-spinner', ctrlAttr: { maxlength: 40 }, ctrlCss: { width: '100px'},
						onChange: function (evt, rowIndex) {
							var idRow = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', rowIndex);
							if(idRow != "") {						
								var dataAjax = {
									'action': 'ajax_type_car_admin',
									'farePerSeat': jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'farePerSeat', rowIndex),
									'id': idRow,
								}
								jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
									document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
									setTimeout(function(){
										document.getElementById("tblAppendGridStatus").innerHTML = "";
										}, 1000);													
								});	
							}
						} 									
				},
				{ 
					name: 'farePerToll', display: 'farePerToll', type: 'ui-spinner', ctrlAttr: { maxlength: 40 }, ctrlCss: { width: '100px'},
						onChange: function (evt, rowIndex) {
							var idRow = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', rowIndex);
							if(idRow != "") {						
								var dataAjax = {
									'action': 'ajax_type_car_admin',
									'farePerToll': jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'farePerToll', rowIndex),
									'id': idRow,
								}
								jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
									document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
									setTimeout(function(){
										document.getElementById("tblAppendGridStatus").innerHTML = "";
										}, 1000);													
								});	
							}
						} 									
				},				
				
			],
			initData: [],
			rowDragging: true,
			afterRowDragged: function (caller, rowIndex, uniqueIndex) {
				refreshOrder();							
			},
			afterRowAppended: function(caller, parentRowIndex, addedRowIndex) {
				if(jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', addedRowIndex) == ""){
					var dataAjax = {
						'action': 'ajax_type_car_admin',
						'isNewTypeCar': "yes",								
					}
					jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
						var res = jQuery.parseJSON(DataResponse);
						jQuery('#tblAppendGrid').appendGrid('setCtrlValue', 'id', addedRowIndex, res);
						refreshOrder();
						
					});
				
				}
				
			},
			beforeRowRemove: function (caller, rowIndex) {
				
				
				var idRow = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', rowIndex);
				var dataAjax = {
					'action': 'ajax_type_car_admin',
					'isDelete': "yes",
					'id': idRow,				
				}
				jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
					jQuery('#tblAppendGrid').appendGrid('removeRow', rowIndex);
					document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
					setTimeout(function(){
						document.getElementById("tblAppendGridStatus").innerHTML = "";
						}, 1000);
					
				});
				
			},

			hideButtons: { moveUp: true, moveDown: true , insert: true }
		});
		
		
		var dataAjax = {
			'action': 'ajax_type_car_admin',
			'loadInit': "yes",	
		};			
		
		jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
			var objJSON = jQuery.parseJSON(DataResponse);
				jQuery('#tblAppendGrid').appendGrid('appendRow',						
					objJSON						
				);
		});	
	}
  
});



function refreshOrder() {
	var count = jQuery('#tblAppendGrid').appendGrid('getRowCount') ;
	arrayOrder = [];
//	console.log(count);
	for (var z = 0; z < count; z++) {
		id = jQuery('#tblAppendGrid').appendGrid('getCtrlValue', 'id', z);
		arrayOrder.push([z,id]);
	}
	var dataAjax = {
		'action': 'ajax_type_car_admin',
		'arrayOrder': arrayOrder,
	}
	jQuery.post(ajax_obj_type_car_admin.ajax_url, dataAjax,   function(DataResponse) {
			document.getElementById("tblAppendGridStatus").innerHTML = "<strong>Saved!</strong>";
			setTimeout(function(){
			document.getElementById("tblAppendGridStatus").innerHTML = "";
			}, 1000);	
	});

	
}


