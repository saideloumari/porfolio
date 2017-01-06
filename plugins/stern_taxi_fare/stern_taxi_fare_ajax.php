<?php




add_action( 'wp_ajax_stern_options', 'stern_options' );
add_action( 'wp_ajax_nopriv_stern_options', 'stern_options' );
function stern_options() {
	if(isset($_POST['drag_event_FullCalendar'])) {
		echo get_option('stern_taxi_fare_drag_event_FullCalendar');
		wp_die();
	}
	if(isset($_POST['stern_taxi_use_list_address_source'])) {
		echo get_option('stern_taxi_use_list_address_source');
		wp_die();
	}	
	if(isset($_POST['stern_taxi_use_list_address_destination'])) {
		echo get_option('stern_taxi_use_list_address_destination');
		wp_die();
	}
	if(isset($_POST['stern_taxi_fare_typeCar_calendar_free'])) {
		echo get_option('stern_taxi_fare_typeCar_calendar_free');
		wp_die();
	}	
	if(isset($_POST['stern_taxi_fare_use_calendar'])) {
		echo get_option('stern_taxi_fare_use_calendar');
		wp_die();
	}
	if(isset($_POST['stern_taxi_fare_seat_field_as_input'])) {
		echo get_option('stern_taxi_fare_seat_field_as_input');
		wp_die();
	}
	if(isset($_POST['stern_taxi_fare_calendar_sideBySide'])) {
		echo get_option('stern_taxi_fare_calendar_sideBySide');
		wp_die();
	}	
	
}
	

add_action( 'wp_ajax_my_ajax_picker', 'my_ajax_picker' );
add_action( 'wp_ajax_nopriv_my_ajax_picker', 'my_ajax_picker' );
function my_ajax_picker() {
	if(isset($_POST['getCalendarsForDateTimePicker'])) {
		$arrayCalendar = '';
		$selectedCarTypeId =  $_POST['selectedCarTypeId'];
		$duration =  $_POST['duration'];
		$time_To_add_after_a_ride=  get_option('stern_taxi_fare_Time_To_add_after_a_ride');
		$carseat = get_post_meta($selectedCarTypeId ,'_stern_taxi_car_type_carseat',true);

			$selectedCarTypeId = $selectedCarTypeId;
			$args = array(
				'post_type' => 'stern_taxi_calendar',
				'nopaging' => true,
				'meta_query' => array(
					array(
						'key'     => 'typeIdCar',
						'value'   => $selectedCarTypeId,
						'compare' => '=',
					),
				),
				
			);

			$allPosts = get_posts( $args );	
			foreach ( $allPosts as $post ) {
				setup_postdata( $post );
				$oCalendar = new calendar($post->ID);
				if( (date($oCalendar->getdateTimeEnd()) >  date("Y-m-d H:i:s"))  or  $oCalendar->getisRepeat()=="true" ) {
					$arrayCalendar[$post->ID]["typeCalendar"] = $oCalendar->gettypeCalendar();					
					$minutes_to_add = intval($duration) + intval($time_To_add_after_a_ride);
					
			
					$arrayCalendar[$post->ID]["dateTimeBegin"] = date('Y-m-d H:i:s',strtotime(date($oCalendar->getdateTimeBegin() ). " - ".$minutes_to_add." minutes"));
				//	$arrayCalendar[$post->ID]["dateTimeBegin"] = $oCalendar->getdateTimeBegin();
					
					
					
					$arrayCalendar[$post->ID]["dateTimeEnd"] = $oCalendar->getdateTimeEnd();
					$arrayCalendar[$post->ID]["isRepeat"] = $oCalendar->getisRepeat();
				}

			}

		
		$response["carseat"] = $carseat;
		$response["arrayCalendar"] = $arrayCalendar;

		
		
		echo json_encode($response);
		wp_die();		
	}
	if(isset($_POST['refreshSeats'])) {	
		$arrayCalendar = '';
		$selectedCarTypeId =  $_POST['selectedCarTypeId'] ;
		$carseat = get_post_meta($selectedCarTypeId ,'_stern_taxi_car_type_carseat',true);

				$selectedCarTypeId = $selectedCarTypeId;
				$args = array(
					'post_type' => 'stern_taxi_calendar',
					'nopaging' => true,
					'meta_query' => array(
						array(
							'key'     => 'typeIdCar',
							'value'   => $selectedCarTypeId,
							'compare' => '=',
						),
					),
					
				);

				$allPosts = get_posts( $args );	
				foreach ( $allPosts as $post ) {
					setup_postdata( $post );
					$oCalendar = new calendar($post->ID);
					if(date($oCalendar->getdateTimeEnd()) >  date("Y-m-d H:i:s")) {
						$arrayCalendar[$post->ID]["typeCalendar"] = $oCalendar->gettypeCalendar();					
						$arrayCalendar[$post->ID]["dateTimeBegin"] = $oCalendar->getdateTimeBegin();					
						$arrayCalendar[$post->ID]["dateTimeEnd"] = $oCalendar->getdateTimeEnd();
						$arrayCalendar[$post->ID]["isRepeat"] = $oCalendar->getisRepeat();
					}

				}

		
		$response["carseat"] = $carseat;
		$response["arrayCalendar"] = $arrayCalendar;

		
		
		
		echo json_encode($response);
		wp_die();
	}
	
}


function getPrice($distance,$duration,$nbToll,$selectedCarTypeId,$car_seats ,$is_round_trip, $source,$destination ) {
	$otypeCar = new typeCar($selectedCarTypeId);
	$carFare = $otypeCar->getcarFare();
	$suitcases = $otypeCar->getsuitcases();
	$km_fare = $otypeCar->getfarePerDistance();
	$minutefare = $otypeCar->getfarePerMinute();
	$seatfare = $otypeCar->getfarePerSeat();
	$tollfare = $otypeCar->getfarePerToll();

	
	$addressSavedPoint = get_option('stern_taxi_fare_address_saved_point');
	
	$priceRule=0;
	$idRule=0;
//	$nbMaxRuleBeforeGoogleStop=0;
	$RuleApproved=false;
	$SourceRuleApproved = "";
	$DestinationRuleApproved = "";		
	$typeIdCarInRule = -1;
	
	$carTypeRuleApproved =false;
//	$typeCalculation = get_option('typeCalculation');
	$nameRule="";
	$logParsingRule="";
	
	$sourceAddressForm = $source;
	$sourceCityForm = getCityFromAddress($source);
	
	$destinationAddressForm = $destination;
	$destinationCityForm = getCityFromAddress($destination);
	
	
			$args = array(
				'post_type' => 'stern_taxi_rule',
				'nopaging' => true,
				/*'meta_query' => array(
					array(
					'key' => 'typeIdCar',
					'value' => $selectedCarTypeId,
					'compare' => '='
					)
				)*/
			);
			
			$the_query  = new WP_Query( $args );
			while ( $the_query->have_posts() ) {
				$oRule = null;
				$the_query->the_post();
				$typeRuleSource="";
				$typeRuleDest="";
				
			//$allRules = get_posts( $args );
			//foreach ( $allRules as $post )  {
				//setup_postdata( $post );	
			//	$nbMaxRuleBeforeGoogleStop++;
				$oRule = new rule($the_query->post->ID );
				//var_dump ($oRule);
				
				
				if($oRule->getisActive()=='true') {
					$SourceRuleApproved = "";
					$DestinationRuleApproved = "";					
					
					
					$typeIdCarInRule = $oRule->gettypeIdCar();
					
					if($typeIdCarInRule=="" or ($selectedCarTypeId == $typeIdCarInRule)) {
						
						$sourceAddressRule = $oRule->gettypeSourceValue();
						$sourceCityRule = $oRule->getsourceCity();						
						$typeRuleSource = $oRule->gettypeSource();
						
						$SourceRuleApproved 		= checkIfRuleIsApproved($sourceAddressRule, $sourceCityRule, $sourceAddressForm, $sourceCityForm, $typeRuleSource);
						
					
						if(substr($SourceRuleApproved,0,2) == "ok") {
							
							$destinationAddressRule = $oRule->gettypeDestinationValue();
							$destinationCityRule = $oRule->getdestinationCity();					
							$typeRuleDest = $oRule->gettypeDestination();
							
							$DestinationRuleApproved 	= checkIfRuleIsApproved($destinationAddressRule, $destinationCityRule, $destinationAddressForm, $destinationCityForm, $typeRuleDest);
					
							
							if(substr($DestinationRuleApproved,0,2) == "ok" ) {
								$RuleApproved=true;
								$priceRule=$oRule->getprice();
								$nameRule=$oRule->getnameRule();
								$idRule=$oRule->getid();
								$logParsingRule = $logParsingRule .",".$oRule->getid()."(".$SourceRuleApproved."[".$typeRuleSource."],".$DestinationRuleApproved."[".$typeRuleDest."])4 ";
								break;
							} else {
								$logParsingRule = $logParsingRule .",".$oRule->getid()."(".$SourceRuleApproved."[".$typeRuleSource."],".$DestinationRuleApproved."[".$typeRuleDest."])3 ";
							}										
						} else {
							$logParsingRule = $logParsingRule .",".$oRule->getid()."(".$SourceRuleApproved."[".$typeRuleSource."],".$DestinationRuleApproved."[".$typeRuleDest."])2 ";
						}
					} else {
						$logParsingRule = $logParsingRule .",".$oRule->getid()."(".$SourceRuleApproved."[".$selectedCarTypeId."],".$DestinationRuleApproved."[".$selectedCarTypeId."])1 ";
					}
				} else {
					$logParsingRule = $logParsingRule .",".$oRule->getid()."(NotActive)0 ";
				}
				
				
			}
			
			if($RuleApproved==true) {
				if(get_option('stern_taxi_Include_SeatFare_in_pricing_rules')=='true') {
					$estimated_fare = $priceRule + ($car_seats * $seatfare);
				} else {
					$estimated_fare = $priceRule;
				}
				
			} else {
				$estimated_fare_basic = $carFare  + ($distance * $km_fare) + ($duration * $minutefare) + ($car_seats * $seatfare) + ($nbToll * $tollfare);
				
				$estimated_fare = $estimated_fare_basic;
				
				if (get_option('stern_taxi_fare_minimum')>0 ){
					
					if($estimated_fare_basic < get_option('stern_taxi_fare_minimum')) {
						$estimated_fare = get_option('stern_taxi_fare_minimum');
					} else {
						$estimated_fare = $estimated_fare_basic;
					}
				}				
			}
			if($is_round_trip=="true") {
				$estimated_fare = $estimated_fare * 2;
			}
			
	
	$estimated_fare = round($estimated_fare);
	
	if($DestinationRuleApproved =="errorGoogleEmpty" or $SourceRuleApproved =="errorGoogleEmpty") {
		$statusGoogleGlobal = "errorGoogleEmpty";
	} else {
		$statusGoogleGlobal = "ok";
	}
	$price["estimated_fare"] = $estimated_fare;
	$price["statusGoogleGlobal"] = $statusGoogleGlobal;
	$price["RuleApproved"] = $RuleApproved;
	
	$price["logParsingRule"] = $logParsingRule;
	
/*
	$price["SourceRuleApproved"] = $SourceRuleApproved;
	$price["DestinationRuleApproved"] = $DestinationRuleApproved;
	$price["RuleApproved"] = $RuleApproved;
	*/	
	$price["nameRule"] = $nameRule;
	
	return $price ;
}


add_action( 'wp_ajax_my_ajax', 'my_ajax' );
add_action( 'wp_ajax_nopriv_my_ajax', 'my_ajax' );
function my_ajax() {
	if(isset($_POST['getAllTypeCar']) ) {
		$availableTypeCars = array();
		$args = array(
			'post_type' => 'stern_taxi_car_type',
			'nopaging' => true,
			'order'     => 'ASC',
			'orderby' => 'meta_value',
			'meta_key' => '_stern_taxi_car_type_organizedBy'
		);
		$allTypeCars = get_posts( $args );	
		foreach ( $allTypeCars as $post ) {
			$oTypeCar = new typeCar($post->ID);
			$selectedCarTypeId = $oTypeCar->getid();
			
			array_push($availableTypeCars, 
				array (
					$selectedCarTypeId, $oTypeCar->getcarType()
				)
			);
		}	
		
		
		echo json_encode($availableTypeCars);
		wp_die();		
	}
	if(isset($_POST['getTypeCarAvailable']) ) {
		$availableTypeCars = array();
		$log = "";
		$dateTimePickUp 				= ( $_POST['dateTimePickUp'] );
		$duration 						= ( $_POST['duration'] );
		$carSeat 						= ( $_POST['carSeat'] );
		
		$args = array(
			'post_type' => 'stern_taxi_car_type',
			'nopaging' => true,
			'order'     => 'ASC',
			'orderby' => 'meta_value',
			'meta_key' => '_stern_taxi_car_type_organizedBy'
		);
		$allTypeCars = get_posts( $args );
		$time_To_add_after_a_ride =  get_option('stern_taxi_fare_Time_To_add_after_a_ride');
		$minutes_to_add = intval($duration) + intval($time_To_add_after_a_ride);
		
		foreach ( $allTypeCars as $post ) {
			setup_postdata( $post );
			$oTypeCar = new typeCar($post->ID);
			$selectedCarTypeId = $oTypeCar->getid();
			$carSeatMax = $oTypeCar->getcarSeat();
			
			if(get_option('stern_taxi_fare_seat_field_as_input') == "true") {
				if($carSeat <= $carSeatMax) {
					$isCarSeatAvailable = true;
				} else {
					$isCarSeatAvailable = false;
				} 
			} else {
				$isCarSeatAvailable = true;
			}
			$args = array(
				'post_type' => 'stern_taxi_calendar',
				'nopaging' => true,
				'meta_query' => array(
					array(
						'key'     => 'typeIdCar',
						'value'   => $selectedCarTypeId,
						'compare' => '=',
					),
				),
				
			);
			

			$allPostsCalendars = get_posts( $args );
			$isAvailable = 0;
			foreach ( $allPostsCalendars as $postCalendar ) {
				setup_postdata( $postCalendar );
				$oCalendar = new calendar($postCalendar->ID);
				if($oCalendar->getisRepeat()=="true") {
					$loopIsRepeat = 200;
				} else {
					$loopIsRepeat = 0;			
				}
				
				//	$date = new DateTime($dateTimePickUp );
				//	$dateTimePickUp = $date->format('Y-m-d H:i:s');	
			
			//	echo "alan".$dateTimePickUp."alan ";
			//	echo "HJU".setToCorrectFormatDate($dateTimePickUp)."JU ";
				$dateTimePickUp = setToCorrectFormatDate($dateTimePickUp);
				
				
			//	$dateTimePickUp = date('Y-m-d H:i:s',strtotime($dateTimePickUp ));				
				$dateTimePickUpPlusMinuteToAdd = 	date('Y-m-d H:i:s', strtotime(" + ".$minutes_to_add." minutes", strtotime($dateTimePickUp )));				
				//$loopIsRepeat = 50;
				for ($i=0; $i <= $loopIsRepeat ; $i++) {
		
					$dateTimeBegin = 	date('Y-m-d H:i:s', strtotime(" + ".$i * 7 ." days", strtotime($oCalendar->getdateTimeBegin()		))); 
					$dateTimeEnd = 		date('Y-m-d H:i:s', strtotime(" + ".$i * 7 ." days", strtotime($oCalendar->getdateTimeEnd()		)));
					
	
					
					if( ($dateTimePickUpPlusMinuteToAdd < $dateTimeBegin ) or ($dateTimePickUp  > $dateTimeEnd    )) {
						
						$isAvailable = $isAvailable + 0;
					} else {
						
						$isAvailable = $isAvailable + 1;
				//		break 2 ;
					}
				//	echo  $dateTimeBegin . " - " . $selectedCarTypeId . " /////". $isAvailable. "////";
				//	echo  $dateTimePickUpPlusMinuteToAdd . " - " .$dateTimeBegin . " - " . $dateTimePickUp. " - " . $dateTimeEnd . " - " ;
				}	
				
			}
			if($isAvailable == 0 and $isCarSeatAvailable == true) {
				array_push($availableTypeCars, 
					array (
						$selectedCarTypeId, $oTypeCar->getcarType()
					)
				);
			}
		}
		
		echo json_encode($availableTypeCars);
		wp_die();


		
	}
	if(isset($_POST['getPriceAjax']) ) {	

		$selectedCarTypeId				= ( $_POST['selectedCarTypeId'] );
		$duration 						= ( $_POST['duration'] );
		$nbToll 						= ( $_POST['nbToll'] );
		$distance 						= ( $_POST['distance'] );
		$car_seats 						= ( $_POST['car_seats'] );
		$is_round_trip 					= ( $_POST['is_round_trip'] );
		$source 						= ( $_POST['source'] );
		$destination 					= ( $_POST['destination'] );
		
		$price = getPrice($distance,$duration,$nbToll,$selectedCarTypeId,$car_seats ,$is_round_trip, $source,$destination   );
		
		echo json_encode($price);
		wp_die();	
		
	}
	if(isset($_POST['setSessionDataAjax']) ) {	
		$distance				= ( $_POST['distance'] );
		$selectedCarTypeId		= ( $_POST['selectedCarTypeId'] );
		$distanceHtml			= ( $_POST['distanceHtml'] );
		$duration				= ( $_POST['duration'] );
		$durationHtml			= ( $_POST['durationHtml'] );
		$estimated_fare			= ( $_POST['estimated_fare'] );
		$cartypes				= ( $_POST['cartypes'] );
		$source					= ( $_POST['source'] );
		$destination			= ( $_POST['destination'] );
		$car_seats				= ( $_POST['car_seats'] );
		$dateTimePickUp			= ( $_POST['dateTimePickUp'] );
		$nbToll					= ( $_POST['nbToll'] );
		$is_round_trip			= ( $_POST['is_round_trip'] );
		$dateTimePickUpRoundTrip= ( $_POST['dateTimePickUpRoundTrip'] );
	
		
		
	
		
		saveToSesstion(		$distance, 
							$distanceHtml, 
							$duration, 
							$durationHtml, 
							$estimated_fare, 
							$selectedCarTypeId, 
							$cartypes, 
							$source, 
							$destination, 
							$car_seats, 
							$dateTimePickUp, 
							$nbToll, 
							$is_round_trip, 
							$dateTimePickUpRoundTrip );	

		
	}	
	
	if(isset($_POST['getTripInfo']) ) {
		$source 						= ( $_POST['source'] );
		$destination 					= ( $_POST['destination'] );
		$dateTimePickUp 				= ( $_POST['dateTimePickUp'] );
		$GoogleMapsData = getGoogleMapsDataFunction($source,$destination);
		$GoogleMapsDataStatus = $GoogleMapsData["status"];
		if($GoogleMapsDataStatus != "errorGoogleEmpty") {		
			$distance = $GoogleMapsData["DistanceValueKMOrMiles"];
			$distanceHtml = $GoogleMapsData["DistanceText"];
			$duration = $GoogleMapsData["DurationValue"];
			$durationHtml = $GoogleMapsData["DurationText"];	
			$nbToll = getCountToll($source,$destination);
		}
		$response["distance"] = $distance;
		$response["distanceHtml"] = $distanceHtml;
		$response["duration"] = $duration;
		$response["durationHtml"] = $durationHtml;
		$response["nbToll"] = $nbToll;		
		
		echo json_encode($response);
		wp_die();		
	}
	if(isset($_POST['getSuitcases']) ) {
		$selectedCarTypeId	= ( $_POST['selectedCarTypeId'] );
		$otypeCar = new typeCar($selectedCarTypeId);
		$suitcases = $otypeCar->getsuitcases();
		echo json_encode($suitcases);
		wp_die();	
	}
	
	if(isset($_POST['dateTimePickUp']) &&  isset($_POST['updateDateSection'])) {
		$dateTimePickUp 				= ( $_POST['dateTimePickUp'] );
		$stern_taxi_fare_round_trip 	= ( $_POST['stern_taxi_fare_round_trip'] );
		$dateTimePickUpRoundTrip 		= ( $_POST['dateTimePickUpRoundTrip'] );

	
		global $woocommerce;

		WC()->session->set( 'dateTimePickUp' , $dateTimePickUp );
		WC()->session->set( 'stern_taxi_fare_round_trip' , $stern_taxi_fare_round_trip );
		WC()->session->set( 'dateTimePickUpRoundTrip' , $dateTimePickUpRoundTrip );	
		
	}
	
	if(isset($_POST['getTripInfoGlobal'])) {
		global $wpdb;
		
		//$distance 						= intval( $_POST['distance'] );
	//	$duration 						=  $_POST['duration'] ;
	//	$estimated_fare 				= intval( $_POST['estimated_fare'] );
		$cartypes 						= ( $_POST['cartypes'] );
		$source 						= ( $_POST['source'] );
		$destination 					= ( $_POST['destination'] );
		$car_seats 						= ( $_POST['car_seats'] );
		$dateTimePickUp 				= ( $_POST['dateTimePickUp'] );
		$selectedCarTypeId 				= ( $_POST['selectedCarTypeId'] );	
		$is_round_trip 					= ( $_POST['stern_taxi_fare_round_trip'] );
		$dateTimePickUpRoundTrip 		= ( $_POST['dateTimePickUpRoundTrip'] );

		$otypeCar = new typeCar($selectedCarTypeId);
		$carFare = $otypeCar->getcarFare();
		$suitcases = $otypeCar->getsuitcases();
		$km_fare = $otypeCar->getfarePerDistance();
	/*	$minutefare = $otypeCar->getfarePerMinute();
		$seatfare = $otypeCar->getfarePerSeat();
		$tollfare = $otypeCar->getfarePerToll();		*/
		
	/*
		$km_fare 						= get_option('stern_taxi_fare_mile');
		$minutefare 					= get_option('stern_taxi_fare_minute');
		$seatfare 						= get_option('stern_taxi_fare_seat');
		$tollfare 						= getFareToll();
	*/
		$fare_minimum					= getFareMinimum();
		$stern_taxi_fare_fixed_amount 	= get_option('stern_taxi_fare_fixed_amount'); 
		$estimated_fare					= 0;
		$durationHtml					= "";
		$GoogleMapsData = getGoogleMapsDataFunction($source,$destination);
		$GoogleMapsDataStatus = $GoogleMapsData["status"];
		if($GoogleMapsDataStatus != "errorGoogleEmpty") {
			
			$distance = $GoogleMapsData["DistanceValueKMOrMiles"];
			$distanceHtml = $GoogleMapsData["DistanceText"];
			$duration = $GoogleMapsData["DurationValue"];
			$durationHtml = $GoogleMapsData["DurationText"];	
			$nbToll = getCountToll($source,$destination);	
		//	$suitcases = get_post_meta($selectedCarTypeId ,'_stern_taxi_car_type_suitcases',true);
 
			$price = getPrice($distance,$duration,$nbToll,$selectedCarTypeId,$car_seats ,$is_round_trip ,$source,$destination );			
			
		} else {
			$price["estimated_fare"] = "errorGoogleEmpty";
			$price["statusGoogleGlobal"] = "errorGoogleEmpty";
		}
		
		/*
		for ($i=0;$i<15;$i++) {
			$varalan[] = getGoogleMapsDataAlan($source,$destination);
		}*/


		
		$response["distance"] = $distance;
		$response["distanceHtml"] = $distanceHtml;
		$response["duration"] = $duration;
		$response["durationHtml"] = $durationHtml;
		$response["nbToll"] = $nbToll;
		$response["estimated_fare"] = $price["estimated_fare"];
		$response["cartypes"] = $cartypes;
		$response["carFare"] = $carFare;	
		$response["suitcases"] = $suitcases;
		$response["car_seats"] = $car_seats;	
		$response["km_fare"] = $km_fare;	
		
		
		
	//	$response["selectedCarTypeId"] = $selectedCarTypeId;
	//	$response["typeCalculation"] = $typeCalculation;
		/*
		$response["SourceRuleApproved"] =  $price["SourceRuleApproved"]; 
		$response["DestinationRuleApproved"] =  $price["DestinationRuleApproved"]; 
		$response["RuleApproved"] =  $price["RuleApproved"]; 
		$response["nameRule"] =  $price["nameRule"];
		*/
		$response["nameRule"] =  $price["nameRule"];
		$response["RuleApproved"] =  $price["RuleApproved"]; 
		$response["selectedCarTypeId"] = $selectedCarTypeId;
		//$response["typeIdCarInRule"] = $typeIdCarInRule;
	//	$response["nbMaxRuleBeforeGoogleStop"] = $nbMaxRuleBeforeGoogleStop;	
		//$response["idRule"] = $idRule;
		//$response["oRule"] = (string)$oRule;
		//$response["GoogleMapsData"] = $GoogleMapsData;
		$response["statusGoogleGlobal"] = $price["statusGoogleGlobal"];
		
		$response["dateTimePickUp"] = $dateTimePickUp ;
		$response["dateTimePickUpstrtotime"] = strtotime($dateTimePickUp );
		//$response["destination"] = $destination;
		
		
		$response["logParsingRule"] =$price["logParsingRule"];
		
		
		saveToSesstion(		$distance, 
							$distanceHtml, 
							$duration, 
							$durationHtml, 
							$estimated_fare, 
							$selectedCarTypeId, 
							$cartypes, 
							$source, 
							$destination, 
							$car_seats, 
							$dateTimePickUp, 
							$nbToll, 
							$is_round_trip, 
							$dateTimePickUpRoundTrip );


		//update_option("stern_taxi_fare_TEST_ALAN",'stern_taxi_fare_TEST_ALAN');	
		
		

		echo json_encode($response);
		wp_die();
	}
	
}

function saveToSesstion(	$distance, 
							$distanceHtml, 
							$duration, 
							$durationHtml, 
							$estimated_fare, 
							$selectedCarTypeId, 
							$cartypes, 
							$source, 
							$destination, 
							$car_seats, 
							$dateTimePickUp, 
							$nbToll, 
							$is_round_trip, 
							$dateTimePickUpRoundTrip ) {

	
		
		global $woocommerce;
		
		$woocommerce->session->set_customer_session_cookie(true);
		
		
		if (get_option('stern_taxi_fare_emptyCart') != 'false') {
			$woocommerce->cart->empty_cart(); 
		}	
		
		$woocommerce->cart->add_to_cart( get_option('stern_taxi_fare_product_id_wc') );
		
		
		WC()->session->set( 'distance' , $distance );
		WC()->session->set( 'distanceHtml' , $distanceHtml );
		WC()->session->set( 'duration' , $duration );
		WC()->session->set( 'durationHtml' , $durationHtml );	
		WC()->session->set( 'estimated_fare' , $estimated_fare );
		WC()->session->set( 'selectedCarTypeId' , $selectedCarTypeId );
		WC()->session->set( 'cartypes' , $cartypes );
		WC()->session->set( 'source' , $source );
		WC()->session->set( 'destination' , $destination );
		WC()->session->set( 'car_seats' , $car_seats );
		WC()->session->set( 'dateTimePickUp' , $dateTimePickUp );
		WC()->session->set( 'nbToll' , $nbToll );
		WC()->session->set( 'stern_taxi_fare_round_trip' , $is_round_trip );
		WC()->session->set( 'dateTimePickUpRoundTrip' , $dateTimePickUpRoundTrip );
		
					
}

