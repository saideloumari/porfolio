<?php


add_action( 'wp_ajax_ajax_calendar', 'ajax_calendar' );
add_action( 'wp_ajax_nopriv_ajax_calendar', 'ajax_calendar' );
function ajax_calendar() {
	if(isset($_POST['getAllCalendars'])) {
		$arrayCalendar = '';
		$selectedCarTypeId =  $_POST['selectedCarTypeId'] ;
		
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
				$oTypeCar = new typeCar($oCalendar->gettypeIdCar());
				$arrayCalendar[$post->ID]["typeCalendar"] = $oCalendar->gettypeCalendar();
				$arrayCalendar[$post->ID]["id"] = $oCalendar->getid();
				$arrayCalendar[$post->ID]["dateTimeBegin"] = $oCalendar->getdateTimeBegin();					
				$arrayCalendar[$post->ID]["dateTimeEnd"] = $oCalendar->getdateTimeEnd();
				$arrayCalendar[$post->ID]["isRepeat"] = $oCalendar->getisRepeat();
				$arrayCalendar[$post->ID]["carType"] = $oTypeCar->getcarType();

			}
		$response = $arrayCalendar;

		echo json_encode($response);
		wp_die();
	}
if(isset($_POST['getCalendar'])) {
		
		
		$post_id = $_POST['id'];
		
		$oCalendar = new calendar($post_id );
		$oTypeCar = new typeCar($oCalendar->gettypeIdCar());
		$arrayCalendar = '';
		$arrayCalendar[$post_id]["typeCalendar"] = $oCalendar->gettypeCalendar();
		$arrayCalendar[$post_id]["id"] = $oCalendar->getid();
		$arrayCalendar[$post_id]["dateTimeBegin"] = $oCalendar->getdateTimeBegin();					
		$arrayCalendar[$post_id]["dateTimeEnd"] = $oCalendar->getdateTimeEnd();
		$arrayCalendar[$post_id]["isRepeat"] = $oCalendar->getisRepeat();
		$arrayCalendar[$post_id]["carType"] = $oTypeCar->getcarType();
		$arrayCalendar[$post_id]["wooCommerceOrderId"] = $oCalendar->getwooCommerceOrderId();
		$arrayCalendar[$post_id]["wooCommerceURLEdit"] = get_edit_post_link( $oCalendar->getwooCommerceOrderId() );
		$arrayCalendar[$post_id]["userName"] = get_the_author_meta( 'user_nicename' , $oCalendar->getuserId() );
		$arrayCalendar[$post_id]["userNameURL"] = admin_url( 'user-edit.php?user_id='.$oCalendar->getuserId() );
		
		$response = $arrayCalendar;

		echo json_encode($response);
		wp_die();
	}	
	
	if(isset($_POST['changeCalendar'])) {
		$oCalendar = new calendar($_POST['id']);
		
		$date1=date_create($_POST['start']);
		$date1=date_format($date1,"Y/m/d g:i A");			
		$oCalendar->setdateTimeBegin(sanitize_text_field($date1));
		
		$date2=date_create($_POST['end'] );
		$date2=date_format($date2,"Y/m/d g:i A");				
		$oCalendar->setdateTimeEnd(sanitize_text_field($date2));
		
		
		$post_id = $oCalendar->save();	
			
		
		echo json_encode($post_id);
		wp_die();
	}
	if(isset($_POST['newCalendar'])) {
		$oCalendar = new calendar();
		$oCalendar->settypeIdCar(sanitize_text_field($_POST['typeIdCar']));
		$oCalendar->settypeCalendar(sanitize_text_field($_POST['typeCalendar']));	
		
		$date1=date_create($_POST['start']);
		$date1=date_format($date1,"Y/m/d g:i A");			
		$oCalendar->setdateTimeBegin(sanitize_text_field($date1));
		
		$date2=date_create($_POST['end'] );
		$date2=date_format($date2,"Y/m/d g:i A");				
		$oCalendar->setdateTimeEnd(sanitize_text_field($date2));
		
		
		$post_id = $oCalendar->save();
		$oCalendar = new calendar($post_id);
		$oTypeCar = new typeCar($oCalendar->gettypeIdCar());
		$arrayCalendar = '';
		$arrayCalendar[$post_id]["typeCalendar"] = $oCalendar->gettypeCalendar();
		$arrayCalendar[$post_id]["id"] = $oCalendar->getid();
		$arrayCalendar[$post_id]["dateTimeBegin"] = $oCalendar->getdateTimeBegin();					
		$arrayCalendar[$post_id]["dateTimeEnd"] = $oCalendar->getdateTimeEnd();
		$arrayCalendar[$post_id]["isRepeat"] = $oCalendar->getisRepeat();
		$arrayCalendar[$post_id]["carType"] = $oTypeCar->getcarType();
		$response = $arrayCalendar;

		echo json_encode($response);
		wp_die();		

			
	}
	if(isset($_POST['deleteCalendar'])) {
		$oCalendar = new calendar($_POST['id']);		
		$oCalendar->delete();
	}	
	if(isset($_POST['repeatCalendar'])) {
		$oCalendar = new calendar($_POST['id']);
		if($oCalendar->getisRepeat() == "true") {
			$oCalendar->setisRepeat("false");
		} else {
			$oCalendar->setisRepeat("true");
		}		
		$post_id = $oCalendar->save();	
			
		
		echo json_encode($post_id." " . $oCalendar->getisRepeat());
		wp_die();
	}	
	
}


add_action( 'wp_ajax_ajax_type_car_admin', 'ajax_type_car_admin' );
add_action( 'wp_ajax_nopriv_ajax_type_car_admin', 'ajax_type_car_admin' );
function ajax_type_car_admin() {
	
	if(isset($_POST['id']) &&  isset($_POST['carFare'])) {
		$id =  $_POST['id'] ;
		$carFare =  $_POST['carFare'] ;
		$otypeCar = new typeCar($id);
		$otypeCar->setcarFare($carFare);
		$otypeCar->save();
	} 
	if(isset($_POST['arrayOrder']) ) {
		$arrayOrder =  $_POST['arrayOrder'] ;
		foreach ($arrayOrder as $value) {
			echo "<script>console.log( 'Debug Objects: " . $value[0] ."/". $value[1]. "' );</script>";
			$otypeCar = new typeCar($value[1]);
			$otypeCar->setorganizedBy($value[0]);
			$otypeCar->save();
			$returnData = array ($id ,$organizedBy);
			
		}
	}
	if(isset($_POST['id']) &&  isset($_POST['carType'])) {
		$id =  $_POST['id'] ;
		$carType =  $_POST['carType'] ;
		$otypeCar = new typeCar($id);
		$otypeCar->setcarType($carType);
		$otypeCar->save();
	}
	if(isset($_POST['id']) &&  isset($_POST['carSeat'])) {
		$id =  $_POST['id'] ;
		$carSeat =  $_POST['carSeat'] ;
		$otypeCar = new typeCar($id);
		$otypeCar->setcarSeat($carSeat);
		$otypeCar->save();
	}
	if(isset($_POST['id']) &&  isset($_POST['suitcases'])) {
		$id =  $_POST['id'] ;
		$suitcases =  $_POST['suitcases'] ;
		$otypeCar = new typeCar($id);
		$otypeCar->setsuitcases($suitcases);
		$otypeCar->save();
	}
	if(isset($_POST['id']) &&  isset($_POST['farePerDistance'])) {
		$id =  $_POST['id'] ;
		$farePerDistance =  $_POST['farePerDistance'] ;
		$otypeCar = new typeCar($id);
		$otypeCar->setfarePerDistance($farePerDistance);
		$otypeCar->save();
	}
	if(isset($_POST['id']) &&  isset($_POST['farePerMinute'])) {
		$id =  $_POST['id'] ;
		$farePerMinute =  $_POST['farePerMinute'] ;
		$otypeCar = new typeCar($id);
		$otypeCar->setfarePerMinute($farePerMinute);
		$otypeCar->save();
	}
	if(isset($_POST['id']) &&  isset($_POST['farePerSeat'])) {
		$id =  $_POST['id'] ;
		$farePerSeat =  $_POST['farePerSeat'] ;
		$otypeCar = new typeCar($id);
		$otypeCar->setfarePerSeat($farePerSeat);
		$otypeCar->save();
	}
	if(isset($_POST['id']) &&  isset($_POST['farePerToll'])) {
		$id =  $_POST['id'] ;
		$farePerToll =  $_POST['farePerToll'] ;
		$otypeCar = new typeCar($id);
		$otypeCar->setfarePerToll($farePerToll);
		$otypeCar->save();
	}	
	if(isset($_POST['id']) &&  isset($_POST['isDelete'])) {
		$id =  $_POST['id'] ;
		$otypeCar = new typeCar($id);
		$otypeCar->delete();
	}	
	if(isset($_POST['isNewTypeCar'])) {
		$otypeCar = new typeCar();		
		$typeCarId = $otypeCar->save();
		$response = $typeCarId;
		echo json_encode($response);
	}
	if(isset($_POST['loadInit'])) {
		$args = array(
			'post_type' => 'stern_taxi_car_type',
			'posts_per_page' => 200,
			'order'     => 'ASC',
			'orderby' => 'meta_value',
			'meta_key' => '_stern_taxi_car_type_organizedBy'
		);		

		$allPosts = get_posts( $args );		
		
		foreach ( $allPosts as $post ) {
			setup_postdata( $post ); 
			$otypeCar = new typeCar($post->ID); 

			
			$arrayData[] = 			
				array(					
					'id' 				=> $otypeCar->getid(),				
					'carType' 			=> $otypeCar->getcarType(),
					'carFare'			=> $otypeCar->getcarFare(),
					'carSeat'			=> $otypeCar->getcarSeat(),
					'suitcases'			=> $otypeCar->getsuitcases(),
					'organizedBy'		=> $otypeCar->getorganizedBy(),		
					'farePerDistance'	=> $otypeCar->getfarePerDistance(),		
					'farePerMinute'		=> $otypeCar->getfarePerMinute(),		
					'farePerSeat'		=> $otypeCar->getfarePerSeat(),		
					'farePerToll'		=> $otypeCar->getfarePerToll(),		
					
				);
			
		}
		$response = $arrayData;
		echo json_encode($response);
	}
	wp_die();
}


