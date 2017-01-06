		
var initialLoad = true;				
var stops_count = 0;
var baby_count = 0;
var markerBounds = new google.maps.LatLngBounds();
var geocoder = new google.maps.Geocoder();
var map;
var lang = document.documentElement.lang;

jQuery(document).ready(function() {	
	if(document.getElementById('countryHidden') !=null){	
	
		var VarCountry = document.getElementById('countryHidden').value;
		var options = {		
			componentRestrictions: {country: VarCountry}
		};
	  
		jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_use_list_address_source' : true,	}, function(DataResponse) {
			if(DataResponse != "true") {
				var input = document.getElementById('source');
				var autocomplete = new google.maps.places.Autocomplete(input,options);
			} 
		});	
		jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_use_list_address_destination' : true,	}, function(DataResponse) {
			if(DataResponse != "true") {
				var drop = document.getElementById('destination');
				var drop_autocomplete = new google.maps.places.Autocomplete(drop,options);
			} 
		});	
		
		
	}
	
	if(initialLoad==true) {
	//	setNowDate();
	}	
	initialLoad = false;
  
});





jQuery(document).ready(function() {
	jQuery('[data-toggle="tooltip"]').tooltip(); 
 
    jQuery('#stern_taxi_fare_div')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                source: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
                destination: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                },
                dateTimePickUp: {
                    validators: {
                        notEmpty: {
                            message: ' '
                        }
                    }
                }
            }
        });

		
		
    jQuery('#resetBtn').click(function() {
		softReset();
		document.getElementById('SpanCal1').className="glyphicon glyphicon-check";
		jQuery('#stern_taxi_fare_div').data('bootstrapValidator').resetForm(true);
		jQuery("#resultLeft").css("display","none");
		jQuery("#resultText").css("display","none");
		document.getElementById('cal3').style.visibility = 'hidden';
		setNowDate();
    });	
	




	
    jQuery('#cal1').click(function() {
        jQuery('#stern_taxi_fare_div').bootstrapValidator('validate');
		document.getElementById('SpanCal3').className="glyphicon glyphicon-map-marker";
    });
	

	startDate = getStartDateForDateTimepicker();	
	
		



	jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_fare_calendar_sideBySide' : true,	}, function(DataResponse) {
		if(DataResponse == "true") {
			jQuery('#dateTimePickUp').datetimepicker({
				showClose: true,		
				minDate: startDate,	
				locale: lang,
				sideBySide: true
			});	
			jQuery('#dateTimePickUpRoundTrip').datetimepicker({	
				showClose: true,
				minDate: startDate,
				locale: lang,
				sideBySide: true
			});
	
		} else {
			jQuery('#dateTimePickUp').datetimepicker({
				showClose: true,		
				minDate: startDate,	
				locale: lang,
				
			});	
			jQuery('#dateTimePickUpRoundTrip').datetimepicker({	
				showClose: true,
				minDate: startDate,
				locale: lang,
				
			});			

		}
	});	
	

	
	


	
	jQuery('#baby_count').on('change', function(){
		softReset();
		jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_fare_seat_field_as_input' : true,	}, function(DataResponse) {
			if(DataResponse != "true") {
				refreshPrice();
				console.log("refreshPrice");
			} else {
				doCalculation();
			}
		});
	});
	
	jQuery('#stern_taxi_fare_round_trip').on('change', function(){
		softReset();
		refreshPrice();
		console.log("refreshPrice");
		var Selectstern_taxi_fare_round_trip = document.getElementById('stern_taxi_fare_round_trip').value;
		if( Selectstern_taxi_fare_round_trip == "false") {
			jQuery("#divDateTimePickUpRoundTrip").css("display","none");
			if(document.getElementById('dateTimePickUpRoundTrip') !=null){
				document.getElementById("dateTimePickUpRoundTrip").value = "";
			}
		} else {
			jQuery("#divDateTimePickUpRoundTrip").css("display","");
			setNowDateRoundTrip();
		}		
	});
		
		
	jQuery('#cartypes').on('change', function(){
		jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_fare_seat_field_as_input' : true,	}, function(DataResponse) {
			if(DataResponse != "true") {	
				refreshSeats();
			} else {
				refreshPrice();
				console.log("refreshPrice");
			}
		});
		laodfullCalendarDiv();
		refreshSuitcases();
		
		//laodfullCalendarDiv();
	});	
	
/*
	if(document.getElementById("First_date_available_in_hours")!=null){
		var First_date_available_in_hours = document.getElementById("First_date_available_in_hours").value
		var startDate= new Date();
		startDate.setTime( startDate.getTime() + First_date_available_in_hours * (1000*60*60) );
	}
	*/

	
	
});

function closeBox() {
	document.getElementById('boxclose').style.visibility = 'hidden';
	setTimeout(function(){
		document.getElementById('main2').style.visibility = 'hidden';
		document.getElementById('SpanCal3').className="glyphicon glyphicon-map-marker";
	}, 0);
	
}

function setNowDate() {	
	if(document.getElementById("First_date_available_in_hours")!=null){
		var First_date_available_in_hours = document.getElementById("First_date_available_in_hours").value
		var startDate= new Date();
		startDate.setTime( startDate.getTime() + First_date_available_in_hours * (1000*60*60) );
		
		
		var options = {year: 'numeric', month: '2-digit', day: 'numeric' , hour: 'numeric', minute: 'numeric',  hour12: false };
		if(document.getElementById('dateTimePickUp') !=null){
			document.getElementById("dateTimePickUp").value = startDate.toLocaleString(document.documentElement.lang, options);
		}
	}
}

function setNowDateRoundTrip() {
	console.log("setNowDateRoundTrip");
	/*
	if(document.getElementById("First_date_available_roundtrip_in_hours")!=null){
		var First_date_available_roundtrip_in_hours = document.getElementById("First_date_available_roundtrip_in_hours").value
		var startDate= new Date();
		startDate.setTime( startDate.getTime() + (First_date_available_roundtrip_in_hours ) * (1000*60*60) );
		
		
		var options = {year: 'numeric', month: '2-digit', day: 'numeric' , hour: 'numeric', minute: 'numeric',  hour12: false };
		if(document.getElementById('dateTimePickUpRoundTrip') !=null){
			document.getElementById("dateTimePickUpRoundTrip").value = startDate.toLocaleString(document.documentElement.lang, options);
		}
	}
	*/
	var duration = document.getElementById("stern_taxi_fare_duration").value;
	refreshDates(duration,'#dateTimePickUpRoundTrip') 
}


function getStartDateForDateTimepicker(divId) {
	var divFirst_date_available_in_hours = "";
	if(divId=='#dateTimePickUp') {
		divFirst_date_available_in_hours = "First_date_available_in_hours";
	} else {
		divFirst_date_available_in_hours = "First_date_available_roundtrip_in_hours";
	}
	
	if(document.getElementById(divFirst_date_available_in_hours)!=null){
		var First_date_available_in_hours = document.getElementById(divFirst_date_available_in_hours).value
		var startDate= new Date();
		startDate.setTime( startDate.getTime() + First_date_available_in_hours * (1000*60*60) );
		console.log(startDate);
		return startDate;
		
	}
}


function refreshDates(duration,divId) {
		var selectedCarTypeId = document.getElementById('cartypes').value;
		
		
		var dataPicker = {
			'action': 'my_ajax_picker',
			'getCalendarsForDateTimePicker': 'getCalendarsForDateTimePicker',
			'selectedCarTypeId': selectedCarTypeId,			
			'duration' : duration,
		};
		console.log(dataPicker);
		jQuery.post(my_ajax_object_picker.ajax_url, dataPicker ,   function(DataResponse) {

			var res = jQuery.parseJSON(DataResponse);
			var stern_taxi_fare_Time_To_add_after_a_ride = document.getElementById('stern_taxi_fare_Time_To_add_after_a_ride').value;
			var disabledDatesTimeArray = []
			var arrayCalendarJS = res.arrayCalendar;
			if(arrayCalendarJS !='') {
				
				var arrayCalendarMoment = [];
				var arrayDisableDates = [];
				
				for(var key in arrayCalendarJS) {
					var val = arrayCalendarJS[key];
					/*
					dateBeginWithpotentialBooking = new Date(val["dateTimeBegin"]);
					dateBeginWithpotentialBooking = new Date(dateBeginWithpotentialBooking.getTime() - duration*(60 * 1000) - stern_taxi_fare_Time_To_add_after_a_ride * (60 * 1000));
					*/
					dateTimeBegin = moment(val["dateTimeBegin"]);
					dateTimeEnd = moment(val["dateTimeEnd"]);
					
			//		console.log(dateTimeBegin);
			//		console.log(dateTimeEnd);
					
					arrayCalendarMoment.push([
						dateTimeBegin,
						dateTimeEnd,
					]);
					
					if(val["isRepeat"] == "true") {
						for(i=0;i<200;i++) {
							dateTimeBegin = moment(val["dateTimeBegin"]).add(i*7, 'day');
							dateTimeEnd = moment(val["dateTimeEnd"]).add(i*7, 'day');
							if(dateTimeEnd > moment()) {
								arrayCalendarMoment.push([
									dateTimeBegin,
									dateTimeEnd,
								]);
							}
						}						
					}
					
					var nbDaysinPeriod = ((dateTimeBegin - dateTimeEnd)/(1000*60*60*24));
					dateParsing = new Date(val["dateTimeBegin"]);
		//			console.log(dateParsing);
					for( k=0 ; k < nbDaysinPeriod-1 ; k++) {
						
						dateParsing.setTime( dateParsing.getTime() + 1 * (24*60*60*1000) );
						arrayDisableDates.push(moment(dateParsing));
									
					}
						
				}

				startDate = getStartDateForDateTimepicker(divId);
		

				var lang = document.documentElement.lang;
			//	console.log(arrayCalendarMoment);
				if(document.getElementById("stern_taxi_fare_use_calendar").value=='true'){
					
			
					
			
					if(jQuery(divId).data("DateTimePicker")!=null) {
						jQuery(divId).data("DateTimePicker").destroy();
					}


					jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_fare_calendar_sideBySide' : true,	}, function(DataResponse) {
						if(DataResponse == "true") {
									
							jQuery(divId).datetimepicker({	
									showClose: true,
									locale: lang,
									minDate: startDate,
									disabledDates:arrayDisableDates,
									sideBySide: true,
									disabledTimeIntervals:  arrayCalendarMoment 

							});	
					
						} else {					
							jQuery(divId).datetimepicker({	
									showClose: true,
									locale: lang,
									minDate: startDate,
									disabledDates:arrayDisableDates,
									disabledTimeIntervals:  arrayCalendarMoment 

							});	
						}
					});	
	


					
				
				}
			}
			if(document.getElementById('buttonDateTime')!=null) {
				document.getElementById('buttonDateTime').className="glyphicon glyphicon-time";
			}
		});	
}






function softReset(){
	jQuery("#divAlert").css("display","none");
	jQuery("#divAlertError").css("display","none");
	
/*
	jQuery("#resultText").css("display","none");	
	document.getElementById('cal3').style.visibility = 'hidden';
	document.getElementById('main2').style.visibility = 'hidden';

	
	jQuery("#resultLeft").css("display","none");
	if(document.getElementById('boxclose') !=null){
		document.getElementById('boxclose').style.visibility = 'hidden';
	}
	*/
}

function getLocation() {
	document.getElementById('getLocationSource').className="glyphicon glyphicon-refresh glyphicon-spin";
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(onGeoSuccess);
    }
	softReset();
}

 function onGeoSuccess(event)
 {
	geocoder = new google.maps.Geocoder();
	codeLatLng(event.coords.latitude,event.coords.longitude);
 }
 
 var geocoder;
 
 function codeLatLng(lat, lng) {
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({
    'latLng': latlng
  }, function (results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      if (results[0]) {
		document.getElementById("source").value = results[0].formatted_address;
      } else {
        alert('No results found');
      }
    } else {
      alert('Geocoder failed due to: ' + status);
    }
	document.getElementById('getLocationSource').className="glyphicon glyphicon-map-marker";
  });
}




function getLocationDestination() {
	
	var stern_taxi_fare_address_saved_point = document.getElementById("stern_taxi_fare_address_saved_point").value;
	var stern_taxi_fare_address_saved_point2 = document.getElementById("stern_taxi_fare_address_saved_point2").value;
	
	if(stern_taxi_fare_address_saved_point!='') {
		if(document.getElementById("destination").value != stern_taxi_fare_address_saved_point) {
			document.getElementById("destination").value = stern_taxi_fare_address_saved_point;
		} else if (stern_taxi_fare_address_saved_point2 != "") {
			document.getElementById("destination").value = stern_taxi_fare_address_saved_point2;
		}
			
		
	} else {
		document.getElementById('getLocationDestination').className="glyphicon glyphicon-refresh glyphicon-spin";
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(onGeoSuccessDestination);
		}
	}	
	softReset();  
}

 function onGeoSuccessDestination(event)
 {
	geocoder = new google.maps.Geocoder();
	codeLatLngDestination(event.coords.latitude,event.coords.longitude);
 }
 
 var geocoder;
 
 function codeLatLngDestination(lat, lng) {
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({
    'latLng': latlng
  }, function (results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      if (results[0]) {
		document.getElementById("destination").value = results[0].formatted_address;
      } else {
        alert('No results found');
      }
    } else {
      alert('Geocoder failed due to: ' + status);
    }
	document.getElementById('getLocationDestination').className="glyphicon glyphicon-map-marker";
  });
}

	
	

function showMap() {
	if (document.getElementById('main2').style.visibility == 'hidden') {
		
		document.getElementById('SpanCal3').className="glyphicon glyphicon-eye-close";
		var source = document.getElementById("source").value;
		var destination = document.getElementById("destination").value;
		var apiGoogleKey = document.getElementById("apiGoogleKey").value;
		var getKmOrMilesHTML='';
		var getKmOrMiles = document.getElementById("getKmOrMiles").value;
		if(getKmOrMiles=='km') {
			getKmOrMilesHTML = 'metric';
		} else {
			getKmOrMilesHTML = 'imperial';
		}

		
		jQuery("#main2").html("");
		document.getElementById('main2').style.visibility = 'visible';
		
		var stern_taxi_fare_avoid_highways_in_calculation=document.getElementById('stern_taxi_fare_avoid_highways_in_calculation').value;
		
		$htmliframe = "";
		$htmliframe += "<a class='boxclose' id='boxclose' onclick='closeBox();'></a>";
		$htmliframe += "<iframe  width='100%'   height='450' ";
		$htmliframe += "frameborder='0' style='border:0'  ";
		$htmliframe += "src='https://www.google.com/maps/embed/v1/directions?key=" + apiGoogleKey ;
		$htmliframe += "&origin=" + source;
		$htmliframe += "&units=" + getKmOrMilesHTML ;
		$htmliframe += "&mode=driving";
		if(stern_taxi_fare_avoid_highways_in_calculation=="true") {
			$htmliframe += "&avoid=highways";
		}
		$htmliframe += "&destination=" + destination ;
		$htmliframe += "' allowfullscreen></iframe>";
		jQuery("#main2").append($htmliframe);
						
	} else {
		document.getElementById('main2').style.visibility = 'hidden';
		document.getElementById('SpanCal3').className="glyphicon glyphicon-map-marker";
	}	
	
}


function doCalculation()
{
	document.getElementById('cal3').style.visibility = 'hidden';
	var stern_taxi_fare_show_map = document.getElementById('stern_taxi_fare_show_map').value;
	softReset();
	destroyFullCalendar();
	
    var address = document.getElementById('source').value;
    var destination = document.getElementById('destination').value;
	
	if(address.trim() == '') {
        source = '';
        return false;
    }
    else if(destination.trim() == '') {
        destination = '';
        return false;
    }	
    else
    {
		document.getElementById('SpanCal1').className="glyphicon glyphicon-refresh glyphicon-spin";
		
		jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_fare_typeCar_calendar_free' : true,	}, function(DataResponse) {					
			var source = document.getElementById("source").value;				
			var destination = document.getElementById("destination").value;	
			if (stern_taxi_fare_show_map != 'false'){
				document.getElementById('cal3').style.visibility = 'visible';
			}				
			if(DataResponse == "true") {
				getTripInfo(source,destination);
				
			} else {
				calc(source,destination);
			}
		});		
        	   
    }

}



function getTripInfo(source,destination) {
	
	var dateTimePickUp=document.getElementById('dateTimePickUp').value;
	var data = {
		'action': 'my_ajax',
		'getTripInfo': true,		
		'source': source,		
		'destination': destination,		
		'dateTimePickUp': dateTimePickUp,
	};					
	jQuery.post(my_ajax_object.ajax_url, data,   function(response) {
			jQuery("#resultLeft").css("display","");
			jQuery("#resultText").css("display","");
			document.getElementById('SpanCal1').className="glyphicon glyphicon-refresh";
			
			var res = jQuery.parseJSON(response);
			if(document.getElementById("distanceSpanValue")!=null) {
				document.getElementById("distanceSpanValue").innerHTML =  res.distanceHtml;
			}
			if(document.getElementById("tollSpanValue")!=null) {
				document.getElementById("tollSpanValue").innerHTML = res.nbToll ;
			}
			if(document.getElementById("durationSpanValue")!=null) {
				document.getElementById("durationSpanValue").innerHTML = res.durationHtml ;
			}
			if(document.getElementById("stern_taxi_fare_duration")!=null) {
				document.getElementById("stern_taxi_fare_duration").value =  res.duration ;
			}
			if(document.getElementById("stern_taxi_fare_distance")!=null) {
				document.getElementById("stern_taxi_fare_distance").value =  res.distance ;
			}

			
			jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_fare_seat_field_as_input' : true,	}, function(DataResponse) {
				if(DataResponse == "true") {
					if (document.getElementById("baby_count")) {
						carSeat = parseFloat(document.getElementById("baby_count").value);
					}
								
					refreshCarTypeDropDown(dateTimePickUp, res.duration, carSeat);
					console.log("refreshCarTypeDropDown");
				} else {
					jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_fare_typeCar_calendar_free' : true,	}, function(DataResponse) {
						if(DataResponse == "true") {
						// 
						} else {
							refreshPrice();
							console.log("refreshPrice");
						}
					});
					
				}
			});			
		
	});
	
}

function refreshCarTypeDropDown(dateTimePickUp, duration, carSeat) {
	jQuery("#cartypesOptGroup").empty();
	jQuery("#cartypesOptGroup").append("<option data-icon='glyphicon-refresh glyphicon-spin' value='' selected>  </option>");
	jQuery('.selectpicker').selectpicker('refresh'); 
	jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_fare_use_calendar' : true,	}, function(DataResponse) {
		if(DataResponse == "true") {
			var data = {
				'action': 'my_ajax',
				'getTypeCarAvailable': true,		
				'dateTimePickUp': dateTimePickUp,
				'duration': duration,
				'carSeat': carSeat,
			};
			//console.log(data);
			refreshCarTypeDropDownHtml(data);
			
		} else {
			var data = {
				'action': 'my_ajax',
				'getAllTypeCar': true,
			};
			refreshCarTypeDropDownHtml(data);
		}	
		
	});		
}

function refreshCarTypeDropDownHtml(data) {
	console.log("refreshCarTypeDropDownHtml");
	jQuery.post(my_ajax_object.ajax_url, data,   function(DataResponse) {
		console.log(DataResponse);
		var dataHtml = "";
		var res = jQuery.parseJSON(DataResponse);
		for(var key in res) {
			var val = res[key];
			dataHtml += "<option data-icon='glyphicon-user' value='"+ val[0] +"'>  "+ val[1] +"</option>";
		}
		
		
		jQuery("#cartypesOptGroup").empty();	
		jQuery("#cartypesOptGroup").append(dataHtml);
		jQuery('.selectpicker').selectpicker('refresh'); 		
		refreshSuitcases();
		jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'stern_taxi_fare_seat_field_as_input' : true,	}, function(DataResponse) {
			if(DataResponse != "true") {		
				refreshSeats();
			} else {
				refreshPrice();
				console.log("refreshPrice");
			}
		});
		var duration = document.getElementById("stern_taxi_fare_duration").value;
		refreshDates(duration,'#dateTimePickUp' );
		
	});	
}

function refreshSuitcases() {
	console.log("refreshSuitcases");
	var selectedCarTypeId = document.getElementById('cartypes').value;
	document.getElementById("suitcasesSpanValue").innerHTML ="<span class='glyphicon glyphicon-refresh glyphicon-spin'>";
	var data = {
		'action': 'my_ajax',
		'getSuitcases': true,		
		'selectedCarTypeId': selectedCarTypeId,		
	};					
	jQuery.post(my_ajax_object.ajax_url, data,   function(DataResponse) {
		var res = jQuery.parseJSON(DataResponse);
		if(document.getElementById("suitcasesSpanValue")!=null) {
			document.getElementById("suitcasesSpanValue").innerHTML = res;
		}
	});
					
	
}
function refreshSeats() {
	console.log("refreshSeats");
	var selectedCarTypeId = document.getElementById('cartypes').value;
	softReset();
				
	
	jQuery("#labelSeats").empty();	
	jQuery("#labelSeats").append("<option data-icon='glyphicon-refresh glyphicon-spin' value='' selected>  </option>");
	jQuery('.selectpicker').selectpicker('refresh'); 
	
	var dataPicker = {
		'action': 'my_ajax_picker',
		'selectedCarTypeId': selectedCarTypeId,
		'refreshSeats': 'refreshSeats'
	};	
	
	jQuery.post(my_ajax_object_picker.ajax_url, dataPicker,   function(DataResponse) {
		//console.log(DataResponse);										
		var cadena = '';
		var selected ='';
		var res = jQuery.parseJSON(DataResponse);
		for (i=1 ; i<= res.carseat ; i++) {
			if(i==res.carseat) {
				var selected='selected';
			}
			cadena += "<option data-icon='glyphicon-user' value='"+ i +"' "+selected+">  "+ i +"</option>";
		}

		jQuery("#labelSeats").empty();	
		jQuery("#labelSeats").append(cadena);
		jQuery('.selectpicker').selectpicker('refresh'); 
		refreshPrice();
		console.log("refreshPrice");
	});	
}

function refreshPrice() {
	
	document.getElementById("estimatedFareSpanValue").innerHTML ="<span class='glyphicon glyphicon-refresh glyphicon-spin'>";
	var selectedCarTypeId = document.getElementById('cartypes').value;
	var duration = document.getElementById("stern_taxi_fare_duration").value;
	var distance = document.getElementById("stern_taxi_fare_distance").value;
	var nbToll = document.getElementById("tollSpanValue").innerHTML;
	var is_round_trip = document.getElementById('stern_taxi_fare_round_trip').value;
	var source = document.getElementById("source").value;
	var destination = document.getElementById("destination").value;		
	if (document.getElementById("baby_count")) {
		car_seats = parseFloat(document.getElementById("baby_count").value);
	}	
	var data = {
		'action': 'my_ajax',
		'getPriceAjax' : true,
		'duration': duration,
		'distance': distance,
		'source': source,
		'destination': destination,
		'selectedCarTypeId': selectedCarTypeId,		
		'car_seats': car_seats,
		'is_round_trip': is_round_trip,
		'nbToll' : nbToll,
	};	

	jQuery.post(my_ajax_object.ajax_url, data,   function(response) {
		var res = jQuery.parseJSON(response);
		console.log(res);
		showEstimatedFareHtml(res.estimated_fare) ;
	});		
}
	
function showEstimatedFareHtml(estimated_fare) {
	jQuery("#estimatedFareDivId").css("display","");
	var currency_symbol=document.getElementById('currency_symbol').value;
	var currency_symbol_right='';
	var currency_symbol_left='';
	if(currency_symbol=='€') {
		currency_symbol_right = currency_symbol;
		currency_symbol_left = '';
	} else {
		currency_symbol_right = '';
		currency_symbol_left = currency_symbol;						
	}
	document.getElementById("estimatedFareSpanValue").innerHTML = currency_symbol_left + estimated_fare + currency_symbol_right;
	document.getElementById("stern_taxi_fare_estimated_fare").value =  estimated_fare;
	setSessionDataAjax();
}
	
function calc(source,destination) {

	
	jQuery("#estimatedFareDivId").css("display","");
	jQuery("#suicasesDivId").css("display","");
	
	var e=document.getElementById('cartypes');
	var cartypes = e.options[e.selectedIndex].text

	var dateTimePickUp=document.getElementById('dateTimePickUp').value;
	var dateTimePickUpRoundTrip=document.getElementById('dateTimePickUpRoundTrip').value;
	
	var selectedCarTypeId = document.getElementById('cartypes').value;
	var stern_taxi_fare_round_trip = document.getElementById('stern_taxi_fare_round_trip').value;
	


	

	if (document.getElementById("baby_count")) {
		baby_count = parseFloat(document.getElementById("baby_count").value);
	}					
	//var getShow_use_img_gif_loader = document.getElementById("getShow_use_img_gif_loader").value;
	var getKmOrMiles = document.getElementById("getKmOrMiles").value;



		
	var data = {
		'action': 'my_ajax',
		'getTripInfoGlobal' : true,
		'cartypes': cartypes,
		'source': source,
		'selectedCarTypeId': selectedCarTypeId,				
		'destination': destination,
		'car_seats': baby_count,
		'stern_taxi_fare_round_trip': stern_taxi_fare_round_trip,
		'dateTimePickUpRoundTrip': dateTimePickUpRoundTrip,
		'dateTimePickUp': dateTimePickUp
	};					
	jQuery.post(my_ajax_object.ajax_url, data,   function(response) {
		
		jQuery("#resultLeft").css("display","none");
		
			
		
		var stern_taxi_fare_show_map = document.getElementById('stern_taxi_fare_show_map').value;

		document.getElementById('SpanCal1').className="glyphicon glyphicon-refresh";
		
				
	//	console.log(response);
							
		var res = jQuery.parseJSON(response);
		console.log(res);
		if(res.statusGoogleGlobal == "errorGoogleEmpty") {
			jQuery("#divAlertError").css("display","");
			
			
		} else {
			if(res.RuleApproved==true) {
				jQuery("#divAlert").css("display","");
				var stern_taxi_fare_great_text = document.getElementById("stern_taxi_fare_great_text").value;
				var stern_taxi_fare_fixed_price_text = document.getElementById("stern_taxi_fare_fixed_price_text").value;
				document.getElementById("divAlertText").innerHTML = "<strong>" + stern_taxi_fare_great_text +" </strong>"+ stern_taxi_fare_fixed_price_text + " "+ res.nameRule;
			}

			jQuery("#resultLeft").css("display","");
			jQuery("#resultText").css("display","");
			var stern_taxi_fare_Time_To_add_after_a_ride = document.getElementById('stern_taxi_fare_Time_To_add_after_a_ride').value;
			var fullDuration = (res.duration*1) + (stern_taxi_fare_Time_To_add_after_a_ride*1)
			

				
			jQuery.post(my_ajax_object.ajax_url, { 'action': 'stern_options', 'drag_event_FullCalendar' : true,	}, function(DataResponse) {
				if(DataResponse == "true") {
					setDraggableSection(fullDuration);
				} 
			});		
			

			getTripInfo(source,destination);

			refreshSuitcases();
			refreshDates(res.duration,'#dateTimePickUp' );
			laodfullCalendarDiv();
			
			if (document.getElementById('stern_taxi_fare_auto_open_map').value == 'true'){	
				showMap();
			}
		
		}
			
	});


}




function setSessionDataAjax() {
	var selectedCarTypeId = document.getElementById('cartypes').value;
	var duration = document.getElementById("stern_taxi_fare_duration").value;
	var estimated_fare = document.getElementById("stern_taxi_fare_estimated_fare").value;	
	var is_round_trip = document.getElementById('stern_taxi_fare_round_trip').value;
	var durationHtml = document.getElementById("durationSpanValue").innerHTML;
	var e=document.getElementById('cartypes');
	var cartypes = e.options[e.selectedIndex].text
	var source = document.getElementById("source").value;
	var destination = document.getElementById("destination").value;	
	var car_seats = parseFloat(document.getElementById("baby_count").value);
	var dateTimePickUp=document.getElementById('dateTimePickUp').value;
	var nbToll=document.getElementById('tollSpanValue').innerHTML;	
	var dateTimePickUpRoundTrip=document.getElementById('dateTimePickUpRoundTrip').value;
	var distanceHtml = document.getElementById("distanceSpanValue").innerHTML;
	var distance = document.getElementById("stern_taxi_fare_distance").value;
		
	var data = {
		'action': 'my_ajax',
		'setSessionDataAjax' : true,
		'duration': 				duration,
		'durationHtml': 			durationHtml,
		'estimated_fare': 			estimated_fare,
		'selectedCarTypeId': 		selectedCarTypeId,
		'cartypes': 				cartypes,
		'source':					source,
		'destination': 				destination,
		'car_seats': 				car_seats,
		'dateTimePickUp': 			dateTimePickUp,
		'nbToll': 					nbToll,
		'is_round_trip': 			is_round_trip,
		'dateTimePickUpRoundTrip': 	dateTimePickUpRoundTrip,
		'distanceHtml': 			distanceHtml,
		'distance': 				distance,
	};	
	//console.log(data);
	jQuery.post(my_ajax_object.ajax_url, data,   function(response) {
		//console.log(data);
	});	
}


function checkout_url_function() {	
	document.getElementById('SpanBookButton').className="glyphicon glyphicon-refresh glyphicon-spin";
	var stern_taxi_fare_round_trip = document.getElementById('stern_taxi_fare_round_trip').value;
	var dateTimePickUpRoundTrip=document.getElementById('dateTimePickUpRoundTrip').value;
	var dateTimePickUp=document.getElementById('dateTimePickUp').value;
	var data = {
		'action': 'my_ajax',
		'updateDateSection': 'updateDateSection',
		'stern_taxi_fare_round_trip': stern_taxi_fare_round_trip,
		'dateTimePickUpRoundTrip': dateTimePickUpRoundTrip,
		'dateTimePickUp': dateTimePickUp
	};					
	jQuery.post(my_ajax_object.ajax_url, data,   function(response) {

		var checkout_url_var ='';
		checkout_url_var = document.getElementById('checkout_url').value;
		window.location=checkout_url_var;
	});
}

