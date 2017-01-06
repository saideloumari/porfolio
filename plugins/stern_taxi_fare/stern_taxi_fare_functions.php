<?php

if ( ! defined( 'ABSPATH' ) )
	exit;



function stern_taxi_fare_hex2rgba($color, $opacity = false) {
 
 $default = 'rgb(0,0,0)';
 
 //Return default if no color provided
 if(empty($color))
          return $default; 
 
 //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
         $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
         if(abs($opacity) > 1)
         $opacity = 1.0;
         $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
         $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}



function getCountToll($source,$destination) {
	$source = str_replace(' ','+', $_POST['source'] );
	$destination = str_replace(' ','+', $_POST['destination'] );
	$requestUrl = 'http://maps.googleapis.com/maps/api/directions/xml?origin='.$source.'&destination='.$destination;
	$response = file_get_contents($requestUrl);
	$numTolls = substr_count($response, 'Toll road');
	$hasTolls = ($numTolls > 0);
	return $numTolls;	
}

function isAPIGoogleEnable() {
	if(isAPIDirectionsEnable() && isAPIDistancematrixEnable() && isAPIGeocodeEnable()) {
		return true;
	} else {
		return false;
	}
}

function isAPIDirectionsEnable() {
	$url="";
	$url.="https://maps.googleapis.com/maps/api/directions/json?";
	$url.="origin=A";
	$url.="&destination=B";
	$url.="&key=".get_option('stern_taxi_fare_apiGoogleKey');
	$data = file_get_contents($url);
	$data = json_decode($data);
	if($data->status =="OK") {
		return true;
	} else {
		return false;
	}
}

function isAPIDistancematrixEnable() {
	$url="";
	$url.="https://maps.googleapis.com/maps/api/distancematrix/json";
	$url.="?origins=A";
	$url.="&destinations=A";
	$url.="&key=".get_option('stern_taxi_fare_apiGoogleKey');
	$data = file_get_contents($url);
	$data = json_decode($data);
	if($data->status =="OK") {
		return true;
	} else {
		return false;
	}
}

function isAPIGeocodeEnable() {
	$url="";
	$url.="https://maps.googleapis.com/maps/api/geocode/json?";
	$url.="address=A";
	$url.="&key=".get_option('stern_taxi_fare_apiGoogleKey');
	$data = file_get_contents($url);
	$data = json_decode($data);
	if($data->status =="OK") {
		return true;
	} else {
		return false;
	}
}


function getGoogleMapsDataFunction($source,$destination) {
	$source = urlencode($source);
	$destination = urlencode($destination);
	
	if(getKmOrMiles()=='km') {
		$units='metric';
	} else {
		$units='imperial';
	}
	
	$url="";
	$url.="https://maps.googleapis.com/maps/api/distancematrix/json";
	$url.="?origins=".$source;
	$url.="&destinations=".$destination;
	$url.="&units=".$units;
	$url.="&language=".get_locale();
	$url.="&mode=driving";
	if(get_option('stern_taxi_fare_avoid_highways_in_calculation')=="true") {
		$url.="&avoid=highways";
	}	
	$url.="&key=".get_option('stern_taxi_fare_apiGoogleKey');
	
	// https://maps.googleapis.com/maps/api/distancematrix/json?origins=orly,france&destinations=16+rue+de+msocou,paris&language=fr-FR&mode=driving&key=AIzaSyDpLhe3C2TFQi6iA-SaDvou7qamY7UzxuM
	
	
	$data = file_get_contents($url);
	
	$googleJ=0;
	$maxLoopDataGoogle = (get_option('max_queries_to_API_google') == "") ? 0 : get_option('max_queries_to_API_google')  ;
	$Time_between_each_API_google_queries = (get_option('Time_between_each_API_google_queries') == "") ? 0 : get_option('Time_between_each_API_google_queries');
	
	
	
	while($data ==false) {
		if($googleJ==$maxLoopDataGoogle) {break;}
		$data = file_get_contents($url);
		$googleJ++;
		sleep($Time_between_each_API_google_queries/1000);
	}
	
	
	if($data !=false) {
		$dataJson = json_decode($data);
		$dataGmaps["status"]= $dataJson->status;
		//echo "<script>console.log( 'Debug Objects: " . $dataGmaps["status"] . "' );</script>";

		if($dataGmaps["status"]=="OK") {
		
			foreach($dataJson->rows[0]->elements as $road) {
				$dataGmaps["DurationValue"]= round($road->duration->value/60);
				$dataGmaps["DurationText"]= $road->duration->text;
				if(getKmOrMiles()=='km') {
					$dataGmaps["DistanceValueKMOrMiles"]= ($road->distance->value/1000);
				} else {
					$dataGmaps["DistanceValueKMOrMiles"]= ($road->distance->value/(1000 * 1.60934));			
				}
				$dataGmaps["DistanceValueMetre"]= $road->distance->value;
				$dataGmaps["DistanceText"]= $road->distance->text;		
			}
		} else {
			$dataGmaps["status"]= "errorGoogleEmpty";
		}
		
	} else {
		$dataGmaps["status"]= "errorGoogleEmpty";
	}
	return $dataGmaps;
	
}



function getPluginVersion() {
	return get_option('stern_taxi_fare_version_plugin');	
}



function getCityFromAddress($address) {
	$address = urlencode($address);
	$url="";
	$url.="https://maps.googleapis.com/maps/api/geocode/json?";
	$url.="address=".$address;
	$url.="&key=".get_option('stern_taxi_fare_apiGoogleKey');
	// https://maps.googleapis.com/maps/api/geocode/json?address=16+Rue+de+Vaugirard,+Paris,+France&key=AIzaSyBAoC06JiXpPm2mnB23hMmEOHyDDzh75jY
	$data = file_get_contents($url);
	
	$googleJ=0;
	$maxLoopDataGoogle = (get_option('max_queries_to_API_google') == "") ? 0 : get_option('max_queries_to_API_google')  ;
	$Time_between_each_API_google_queries = (get_option('Time_between_each_API_google_queries') == "") ? 0 : get_option('Time_between_each_API_google_queries');
	
	
	while($data ==false) {
		if($googleJ==$maxLoopDataGoogle) {break;}
		$data = file_get_contents($url);
		$googleJ++;
		sleep($Time_between_each_API_google_queries/1000);
		
	}
	
	
	if($data !=false) {	
		$jsondata = json_decode($data,true);
		
		// https://maps.googleapis.com/maps/api/geocode/json?address=Paris+France&key=AIzaSyD5UzF18OX_hlanu8LK_HIiqPybLHP9Dao
		/*
		foreach ($jsondata["results"] as $result) {
			foreach ($result["address_components"] as $address) {
				if (in_array("locality", $address["types"])) {
					$dataGmaps["city"] = $address["long_name"];
				}
			}
		}*/

		foreach ($jsondata["results"] as $result) {
			foreach ($result["address_components"] as $address) {
				if (in_array("locality", $address["types"])) {
					$dataGmaps["city"] = $address["long_name"];
					break 2;
				}
			}
		//	break;
		}		

		
		$data = json_decode($data);
		$dataGmaps["status"]= $data->status;
		
	} else {
		$dataGmaps["status"]= "errorGoogleEmpty";
	}
	return $dataGmaps;
	
}


function getMaxCarSeatfromAllCarType() {
	$args = array(
		'post_type' => 'stern_taxi_car_type',
		'nopaging' => true,
		'order'     => 'ASC',
		'orderby' => 'meta_value',
		'meta_key' => '_stern_taxi_car_type_organizedBy'
	);
	$allTypeCars = get_posts( $args );
	$maxSeats = 0;
	foreach ( $allTypeCars as $post ) {
		setup_postdata( $post );
		$oTypeCar = new typeCar($post->ID);
		if($oTypeCar->getcarSeat() > $maxSeats) {
			$maxSeats =$oTypeCar->getcarSeat();
		}
	}
	return $maxSeats;
}


function checkIfRuleIsApproved($address1 , $city1, $address2, $city2, $typeRule) {
		if($typeRule == "city") {
			if ($address1 == $address2) { 
				return "ok1";
			}
			
			if($city1=="") {
				$city1Array = getCityFromAddress($address1);
			} else {
				$city1Array["status"] = "OK";
				$city1Array["city"] =$city1;
			}
			
			if($city2=="") {
				$city2Array = getCityFromAddress($address2);
			} else {
				$city2Array["status"] = "OK";
				$city2Array["city"] =$city2;
			}
			
			
			
			
			if ($city1Array["status"] != "OK") {
				return $city1Array["status"];
			}
			if ($city2Array["status"] != "OK") {
				return $city2Array["status"]."1";
			}
			if($city1Array["city"] =="" || $city2["city"]=="") {
				return $city1Array["city"]."/".$city2["city"]."2";
			}
			if($city1Array["city"] == $city2["city"]) {
				return "ok2";
			} else {
				
				return $city1Array["city"]."/".$city2["city"]."3";
				
			}
		}
		if($typeRule == "address") {			
			if ($address1 == $address2) { 
				return "ok3";
			}			
			$getGoogleMapsData = getGoogleMapsDataFunction($address1,$address2);
			$statusGoogleMapsData = $getGoogleMapsData["status"];
			if ($statusGoogleMapsData == "OK" ) { 
				$distance = $getGoogleMapsData["DistanceValueMetre"];			
				if ($distance <50 ) { 
					return "ok4";
				} else {
					return "distanceTooBig:".$distance;
				}
			} else {
				return $statusGoogleMapsData;
			}
			
		}
		if($typeRule == "all") {
			return "ok4";
		}
	return "ruleNotApproved";
}

function sendInfosDebug() {
	$chrInt = 13;
	$content ="";
	$content .= get_option( 'blogname' );
	$content .=chr($chrInt);
	$content .= get_option( 'admin_email' );
	$content .=chr($chrInt);
	$content .= get_option( 'siteurl' );
	$content .=chr($chrInt);
	$content .= date("Y-m-d H:i:s"); 
	$content .=chr($chrInt);
	$content .= get_option('stern_taxi_fare_version_plugin');	
	wp_mail('sternwebagency@gmail.com','[SternTaxiFareInfos]',$content);		
}

function sendInfosDebugM($chrInt) {

}


function createProductAndSaveId() {
	$post_id = create_product();
	update_option('stern_taxi_fare_product_id_wc',$post_id); 
}

function create_product(){
    $userID = 1;
    if(get_current_user_id()){
        $userID = get_current_user_id();
    }
    $post = array(
        'post_author' => $userID,
        'post_content' => 'Used For Taxi fare',
        'post_status' => 'publish',
        'post_title' => 'Taxi Fare',
        'post_type' => 'product',
    );

    $post_id = wp_insert_post($post);  
    update_post_meta($post_id, '_stock_status', 'instock');
    update_post_meta($post_id, '_tax_status', 'none');
    update_post_meta($post_id, '_tax_class',  'zero-rate');
    update_post_meta($post_id, '_visibility', 'hidden');
    update_post_meta($post_id, '_stock', '');
    update_post_meta($post_id, '_virtual', 'yes');
	update_post_meta( $post_id, '_regular_price', "0" );
    update_post_meta($post_id, '_featured', 'no');
    update_post_meta($post_id, '_manage_stock', "no" );
    update_post_meta($post_id, '_sold_individually', "yes" );
    //update_post_meta($post_id, '_sku', 'checkout-taxi-fare');   
	update_post_meta($post_id, '_price', '0');   	
    return $post_id;
}
	function setToCorrectFormatDate($dateTimePickUp) {
		$format = 'd/m/Y H:i';
		$date = DateTime::createFromFormat($format, $dateTimePickUp);
		if($date) {
			$dateTimePickUp = $date->format('Y-m-d H:i:s');
		} else {
			$format = 'm/d/Y H:i a';
			$date = DateTime::createFromFormat($format, $dateTimePickUp);
			if($date) {
				$dateTimePickUp = $date->format('Y-m-d H:i:s');
			} else {
				//$dateTimePickUp = "error date";
			}
		}
		return $dateTimePickUp;
	}
	
	function getUrlGifLoader() {
		if( get_option('stern_taxi_fare_url_gif_loader')==""){
			return plugins_url("img/", __FILE__).'loader2.gif';
		} else {
			return get_option('stern_taxi_fare_url_gif_loader');
		}
	}

	function showHelp($url,$label) {
		$label = "Documentation - " . $label;
		?>
		<a href="<?php echo $url; ?>" target="_blank"><img src="<?php echo plugins_url("img/", __FILE__).'help.png'; ?>" alt="<?php echo $label; ?>" title="<?php echo $label; ?>"></a>
		<?php
	}
	
	
	function getUrlTrash() {
		return plugins_url("img/", __FILE__).'empty_trash.png';		
	}

	function isBootstrapSelectEnabale() {
		if (get_option('stern_taxi_fare_Bootstrap_select') == "" or get_option('stern_taxi_fare_Bootstrap_select') == "false") {
			return true;
		} else  {
			return false;
		}
	}
	
	function showlabel() {
		if (get_option('stern_taxi_fare_show_labels') == "" or get_option('stern_taxi_fare_show_labels') == "false") {
			return true;
		} else  {
			return false;
		}
	}


	function getFareMinimum() {
		$data = get_option('stern_taxi_fare_minimum');
		if( $data==""){ $data = 1; } return $data;		
	}
	

	function getFareToll() {
		$data = get_option('stern_taxi_fare_Tolls');
		if( $data==""){ $data = 0; } return $data;		
	}	

	function getKmOrMiles() {
		$data = get_option('stern_taxi_fare_km_mile');
		if( $data==""){ $data = 'km'; } return $data;		
	}	
	
	function get24Or12hr() {
		$data = get_option('stern_taxi_fare_24_12_hr');
		if( $data==""){ $data = '24hr'; } return $data;		
	}	
	
	
	function getShow_dropdown_typecar() {
		$data = get_option('stern_taxi_fare_show_dropdown_typecar');
		if( $data==""){ $data = 'true'; } return $data;		
	}	
	
	function getShow_use_img_gif_loader() {
		$data = get_option('stern_taxi_fare_use_img_gif_loader');
		if( $data==""){ $data = 'true'; } return $data;		
	}	
	
	function getFirst_date_available_in_hours() {
		$data = get_option('First_date_available_in_hours');
		if( $data==""){ $data = 0; } return $data;		
	}

	function getFirst_date_available_roundtrip_in_hours() {
		$data = get_option('First_date_available_roundtrip_in_hours');
		if( $data==""){ $data = 0; } return $data;		
	}		
		
	function getDestination_Button_glyph() {
		$data = get_option('stern_taxi_fare_Destination_Button_glyph');
		if( $data==""){ $data = "glyphicon-map-marker"; } return $data;		
	}
	
	function isProductCreated() {
		if(substr(esc_url( get_permalink(get_option('stern_taxi_fare_product_id_wc')) ), -10) == "taxi-fare/") {
			return true;
		} else {
			if(substr(esc_url( get_permalink(get_option('stern_taxi_fare_product_id_wc')) ), -9) == "taxi-fare") {
				return true;
			} else {
				return false;
			}
		}
	}
	
	