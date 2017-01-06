<?php

if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Event admin
 */
class stern_taxi_fare_events_Admin {

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action('admin_menu', array( $this,'register_stern_taxi_fare') );
		add_action('admin_menu', array( $this,'register_submenu_type_car') );
		add_action('admin_menu', array( $this,'register_submenu_design') );
		add_action('admin_menu', array( $this,'register_submenu_rule') );
		add_action('admin_menu', array( $this,'register_submenu_listAddress') );
		add_action('admin_menu', array( $this,'register_submenu_calendar') );
		
		
	}
	
	
	public function create_post_type_car($cartype,$carfare,$carseat,$suitcases){
		$userID = 1;
		if(get_current_user_id()){
			$userID = get_current_user_id();
		}
		$post = array(
			'post_author' => $userID,
			'post_content' => '',
			'post_status' => 'publish',
			'post_title' => 'stern_taxi_car_type',
			'post_type' => 'stern_taxi_car_type',
		);

		$post_id = wp_insert_post($post);  
		update_post_meta($post_id, '_stern_taxi_car_type_cartype', $cartype);
		update_post_meta($post_id, '_stern_taxi_car_type_carfare', $carfare);
		update_post_meta($post_id, '_stern_taxi_car_type_carseat', $carseat);
		update_post_meta($post_id, '_stern_taxi_car_type_suitcases', $suitcases);
		
		
		return $post_id;
	}

	
	

	public function register_stern_taxi_fare(){
		add_menu_page( 'Stern Taxi Fare', 'Stern Taxi Fare', 'manage_options', 'SternTaxiPage', array( $this,'menu_page_stern_taxi_fare'), plugins_url("img/", __FILE__).'stern_taxi_fare.png', 6 ); 
	}
	

	function register_submenu_type_car() {
		add_submenu_page( 'SternTaxiPage', 'Type Cars', 'Type Cars', 'manage_options', 'stern-add-type-car', array( $this,'my_custom_submenu_page_callback')  );
	}

	function register_submenu_design() {
		add_submenu_page( 'SternTaxiPage', 'Design', 'Design', 'manage_options', 'stern-design', array( $this,'my_custom_submenu_page_callback_design')  );
	}

	function register_submenu_rule() {
		add_submenu_page( 'SternTaxiPage', 'Pricing Rules', 'Pricing Rules', 'manage_options', 'stern-Pricing-rules', array( $this,'my_custom_submenu_page_callback_rule')  );
	}
	
	function register_submenu_listAddress() {
		add_submenu_page( 'SternTaxiPage', 'List Addresses', 'List Addresses', 'manage_options', 'stern-Pricing-list-addresses', array( $this,'my_custom_submenu_page_callback_list_addresses')  );
	}	
	
	

	function register_submenu_calendar() {
		add_submenu_page( 'SternTaxiPage', 'Calendar', 'Calendar', 'manage_options', 'stern-calendar', array( $this,'my_custom_submenu_page_callback_calendar')  );
	}		

	
	public function my_custom_submenu_page_callback_calendar(){
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['SternSaveSettingsCalendarTableSubmit']) ) {
			
			$stern_taxi_fare_use_calendar=sanitize_text_field($_POST['stern_taxi_fare_use_calendar']);
			update_option("stern_taxi_fare_use_calendar",$stern_taxi_fare_use_calendar);
			
			$stern_taxi_fare_use_FullCalendar=sanitize_text_field($_POST['stern_taxi_fare_use_FullCalendar']);
			update_option("stern_taxi_fare_use_FullCalendar",$stern_taxi_fare_use_FullCalendar);
			
			$stern_taxi_fare_drag_event_FullCalendar=sanitize_text_field($_POST['stern_taxi_fare_drag_event_FullCalendar']);
			update_option("stern_taxi_fare_drag_event_FullCalendar",$stern_taxi_fare_drag_event_FullCalendar);
			
			$stern_taxi_fare_use_FullCalendar_back=sanitize_text_field($_POST['stern_taxi_fare_use_FullCalendar_back']);
			update_option("stern_taxi_fare_use_FullCalendar_back",$stern_taxi_fare_use_FullCalendar_back);			

			$stern_taxi_fare_Time_To_add_after_a_ride=sanitize_text_field($_POST['stern_taxi_fare_Time_To_add_after_a_ride']);
			update_option("stern_taxi_fare_Time_To_add_after_a_ride",$stern_taxi_fare_Time_To_add_after_a_ride);			
			
			$stern_taxi_fare_slotDuration_min=sanitize_text_field($_POST['stern_taxi_fare_slotDuration_min']);
			update_option("stern_taxi_fare_slotDuration_min",$stern_taxi_fare_slotDuration_min);				
		}
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['calendarSubmit']) ) {
			if( $_POST['dateTimeBegin']!=null && $_POST['dateTimeEnd']!=null  && $_POST['typeCalendar']!=null ) {
				
				$oCalendar = new calendar();
				$oCalendar->settypeIdCar(sanitize_text_field($_POST['typeIdCar']));
				$oCalendar->settypeCalendar(sanitize_text_field($_POST['typeCalendar']));
				$oCalendar->setisRepeat(sanitize_text_field($_POST['isRepeat']));

				
			//	$oCalendar->setdateEnd(sanitize_text_field($_POST['dateEnd']));
			//	$oCalendar->setdateBegin(sanitize_text_field($_POST['dateBegin']));
			
				$date1=date_create($_POST['dateBegin'] . " " . $_POST['dateTimeBegin']);
				$date1=date_format($date1,"Y/m/d g:i A");			
				$oCalendar->setdateTimeBegin(sanitize_text_field($date1));
				
				$date2=date_create($_POST['dateEnd'] . " " . $_POST['dateTimeEnd']);
				$date2=date_format($date2,"Y/m/d g:i A");				
				$oCalendar->setdateTimeEnd(sanitize_text_field($date2));
				
				
				if($date1<$date2) {
					$oCalendar->save();	
				} else {
					echo 'Date Begin is  greater than date End!';
				}
					
				
				
				
			}

			// Delete
			$args = array(
				'post_type' => 'stern_taxi_calendar',
				'posts_per_page' => 200,
			);

			$allPosts = get_posts( $args );			
			foreach ( $allPosts as $post ) {
			setup_postdata( $post );			
				if (isset($_POST['remove'.$post->ID])) {						
					if ($_POST['remove'.$post->ID] =='yes') {
						$oCalendar = new calendar($post->ID);
						$oCalendar->delete();
					}				
				}
			}
		}
		new templateCalendar();
	}	

	
	
	public function my_custom_submenu_page_callback_list_addresses(){
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['SettingsTemplateListAddressSubmit']) ) {
			
			$stern_taxi_use_list_address_source=sanitize_text_field($_POST['stern_taxi_use_list_address_source']);
			update_option("stern_taxi_use_list_address_source",$stern_taxi_use_list_address_source);			
			
			$stern_taxi_use_list_address_destination=sanitize_text_field($_POST['stern_taxi_use_list_address_destination']);
			update_option("stern_taxi_use_list_address_destination",$stern_taxi_use_list_address_destination);
			
			
		}		
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['listAddressSubmit']) ) {
			if( $_POST['typeListAddress']!=null && $_POST['address']!=null  ) {
				$oListAddress = new listAddress();
				$oListAddress->setisActive(sanitize_text_field($_POST['isActive']));
				$oListAddress->settypeListAddress(sanitize_text_field($_POST['typeListAddress']));				
				$oListAddress->setaddress(sanitize_text_field($_POST['address']));
				$oListAddress->save();	
			} else {
				$args = array(
				'post_type' => 'stern_listAddress',
				'posts_per_page' => 200,
				);

				$allPosts = get_posts( $args );			
				foreach ( $allPosts as $post ) {
					setup_postdata( $post );
					$oListAddress = new listAddress($post->ID);			
					if (isset($_POST['remove'.$post->ID])) {						
						$oListAddress->delete();
					}
					if (isset($_POST['isActive'.$post->ID])) {									
						$oListAddress->setisActive("true");
						$oListAddress->save();
					} else {
						$oListAddress->setisActive("false");
						$oListAddress->save();
					}		
				
				}
			}
			
		}		
		new templateListAddress();
	}
		
	public function my_custom_submenu_page_callback_rule(){
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['SettingsPricingRulesSubmit']) ) {
			$stern_taxi_Include_SeatFare_in_pricing_rules=sanitize_text_field($_POST['stern_taxi_Include_SeatFare_in_pricing_rules']);
			update_option("stern_taxi_Include_SeatFare_in_pricing_rules",$stern_taxi_Include_SeatFare_in_pricing_rules);						
		}
	
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['ruleSubmit']) ) {
			if( $_POST['price']!=null && $_POST['nameRule']!=null  ) {				
				$oRule = new rule();	
				$oRule->setisActive(sanitize_text_field($_POST['isActive']));
				$oRule->setnameRule(sanitize_text_field($_POST['nameRule']));				
				$oRule->settypeSource(sanitize_text_field($_POST['typeSource']));
				$oRule->settypeSourceValue(sanitize_text_field($_POST['typeSourceValue']));
				$oRule->settypeDestination(sanitize_text_field($_POST['typeDestination']));
				$oRule->settypeDestinationValue(sanitize_text_field($_POST['typeDestinationValue']));
				$oRule->settypeIdCar(sanitize_text_field($_POST['typeIdCar']));
				$oRule->setprice(sanitize_text_field($_POST['price']));	
				$oRule->save();	
			}

			// Delete
			$args = array(
			'post_type' => 'stern_taxi_rule',
			'posts_per_page' => 200,
			);

			$allPosts = get_posts( $args );			
			foreach ( $allPosts as $post ) {
				setup_postdata( $post );
				$oRule = new rule($post->ID);			
				if (isset($_POST['remove'.$post->ID])) {						
					$oRule->delete();					
				}					
				if (isset($_POST['isActive'.$post->ID])) {						
					$oRule->setisActive("true");
					$oRule->save();
				} else {
					$oRule->setisActive("false");
					$oRule->save();
				}
			
			}
		}
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['bulkPricingRulesSubmit']) ) {
			$bulkData = $_POST['bulkPricingRules'];
			
			$splitcontents = explode("\n", $bulkData);
			foreach ( $splitcontents as $line ) {
				$parts = preg_split('/[\t]/', $line);
				if (
					isset($parts[0]) and
					isset($parts[1]) and
					isset($parts[2]) and
					isset($parts[3]) and
					isset($parts[4]) and
					isset($parts[5]) and
					isset($parts[6]) and
					isset($parts[7])					
				) {
					$oRule = new rule();	
					$oRule->setisActive(sanitize_text_field($parts[0]));
					$oRule->setnameRule(sanitize_text_field($parts[1]));				
					$oRule->settypeSource(sanitize_text_field($parts[2]));
					$oRule->settypeSourceValue(sanitize_text_field($parts[3]));
					$oRule->settypeDestination(sanitize_text_field($parts[4]));
					$oRule->settypeDestinationValue(sanitize_text_field($parts[5]));
					$oRule->settypeIdCar(sanitize_text_field($parts[6]));
					$oRule->setprice(sanitize_text_field($parts[7]));	
					$oRule->save();
				}
			}

				
		}
	//	var_dump( $bulkData);
	//	var_dump($parts);
		new templateRule();
	}

	//true	lille-marseille2	city	Lille, France	city	Marseille, France	All	9
			
	public function my_custom_submenu_page_callback_design(){
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['SternSaveSettings']) ) 
        {		
			$stern_taxi_fare_show_suitcases_in_form=sanitize_text_field($_POST['stern_taxi_fare_show_suitcases_in_form']);
			update_option("stern_taxi_fare_show_suitcases_in_form",$stern_taxi_fare_show_suitcases_in_form);

			$stern_taxi_fare_show_estimated_in_form=sanitize_text_field($_POST['stern_taxi_fare_show_estimated_in_form']);
			update_option("stern_taxi_fare_show_estimated_in_form",$stern_taxi_fare_show_estimated_in_form);

			
			$stern_taxi_fare_show_distance_in_form=sanitize_text_field($_POST['stern_taxi_fare_show_distance_in_form']);
			update_option("stern_taxi_fare_show_distance_in_form",$stern_taxi_fare_show_distance_in_form);

			$stern_taxi_fare_show_tolls_in_form=sanitize_text_field($_POST['stern_taxi_fare_show_tolls_in_form']);
			update_option("stern_taxi_fare_show_tolls_in_form",$stern_taxi_fare_show_tolls_in_form);

			$stern_taxi_fare_show_duration_in_form=sanitize_text_field($_POST['stern_taxi_fare_show_duration_in_form']);
			update_option("stern_taxi_fare_show_duration_in_form",$stern_taxi_fare_show_duration_in_form);



			
			$stern_taxi_fare_emptyCart=sanitize_text_field($_POST['stern_taxi_fare_emptyCart']);
			update_option("stern_taxi_fare_emptyCart",$stern_taxi_fare_emptyCart);					 

			$stern_taxi_fare_show_map=sanitize_text_field($_POST['stern_taxi_fare_show_map']);
			update_option("stern_taxi_fare_show_map",$stern_taxi_fare_show_map);
			
			$stern_taxi_fare_auto_open_map=sanitize_text_field($_POST['stern_taxi_fare_auto_open_map']);
			update_option("stern_taxi_fare_auto_open_map",$stern_taxi_fare_auto_open_map);
			

			$stern_taxi_fare_show_dropdown_typecar=sanitize_text_field($_POST['stern_taxi_fare_show_dropdown_typecar']);
			update_option("stern_taxi_fare_show_dropdown_typecar",$stern_taxi_fare_show_dropdown_typecar);

			$stern_taxi_fare_formID=sanitize_text_field($_POST['stern_taxi_fare_formID']);
			update_option("stern_taxi_fare_formID",$stern_taxi_fare_formID);					
			 
			$stern_taxi_use_pets=sanitize_text_field($_POST['stern_taxi_use_pets']);
			update_option("stern_taxi_use_pets",$stern_taxi_use_pets);

			$stern_taxi_fare_show_map_checkout=sanitize_text_field($_POST['stern_taxi_fare_show_map_checkout']);
			update_option("stern_taxi_fare_show_map_checkout",$stern_taxi_fare_show_map_checkout);
			
			$stern_taxi_fare_url_gif_loader=sanitize_text_field($_POST['stern_taxi_fare_url_gif_loader']);
			update_option("stern_taxi_fare_url_gif_loader",$stern_taxi_fare_url_gif_loader);				
			
			$stern_taxi_fare_lib_bootstrap_js=sanitize_text_field($_POST['stern_taxi_fare_lib_bootstrap_js']);
			update_option("stern_taxi_fare_lib_bootstrap_js",$stern_taxi_fare_lib_bootstrap_js);

			
			$stern_taxi_fare_typeCar_calendar_free=sanitize_text_field($_POST['stern_taxi_fare_typeCar_calendar_free']);
			update_option("stern_taxi_fare_typeCar_calendar_free",$stern_taxi_fare_typeCar_calendar_free);
			
			$stern_taxi_fare_seat_field_as_input=sanitize_text_field($_POST['stern_taxi_fare_seat_field_as_input']);
			update_option("stern_taxi_fare_seat_field_as_input",$stern_taxi_fare_seat_field_as_input);
			
			$stern_taxi_fare_lib_bootstrap_css=sanitize_text_field($_POST['stern_taxi_fare_lib_bootstrap_css']);
			update_option("stern_taxi_fare_lib_bootstrap_css",$stern_taxi_fare_lib_bootstrap_css);
			
			
			
			$stern_taxi_fare_Bootstrap_select=sanitize_text_field($_POST['stern_taxi_fare_Bootstrap_select']);
			update_option("stern_taxi_fare_Bootstrap_select",$stern_taxi_fare_Bootstrap_select);				
			
			
			
			$stern_taxi_fare_calendar_sideBySide=sanitize_text_field($_POST['stern_taxi_fare_calendar_sideBySide']);
			update_option("stern_taxi_fare_calendar_sideBySide",$stern_taxi_fare_calendar_sideBySide);		

			
			$stern_taxi_fare_show_labels=sanitize_text_field($_POST['stern_taxi_fare_show_labels']);
			update_option("stern_taxi_fare_show_labels",$stern_taxi_fare_show_labels);		

			$stern_taxi_fare_show_tooltips=sanitize_text_field($_POST['stern_taxi_fare_show_tooltips']);
			update_option("stern_taxi_fare_show_tooltips",$stern_taxi_fare_show_tooltips);

			$stern_taxi_fare_show_label_in_button=sanitize_text_field($_POST['stern_taxi_fare_show_label_in_button']);
			update_option("stern_taxi_fare_show_label_in_button",$stern_taxi_fare_show_label_in_button);			
			
			$stern_taxi_fare_form_full_row=sanitize_text_field($_POST['stern_taxi_fare_form_full_row']);
			update_option("stern_taxi_fare_form_full_row",$stern_taxi_fare_form_full_row);				
			
			$stern_taxi_fare_full_row=sanitize_text_field($_POST['stern_taxi_fare_full_row']);
			update_option("stern_taxi_fare_full_row",$stern_taxi_fare_full_row);	
			
			$stern_taxi_fare_Destination_Button_glyph=sanitize_text_field($_POST['stern_taxi_fare_Destination_Button_glyph']);
			update_option("stern_taxi_fare_Destination_Button_glyph",$stern_taxi_fare_Destination_Button_glyph);				

			$stern_taxi_fare_bcolor=sanitize_text_field($_POST['stern_taxi_fare_bcolor']);
			update_option("stern_taxi_fare_bcolor",$stern_taxi_fare_bcolor);

			$stern_taxi_fare_bTransparency=sanitize_text_field($_POST['stern_taxi_fare_bTransparency']);
			update_option("stern_taxi_fare_bTransparency",$stern_taxi_fare_bTransparency);			
			
			$stern_taxi_fare_book_button_text=sanitize_text_field($_POST['stern_taxi_fare_book_button_text']);
			update_option("stern_taxi_fare_book_button_text",$stern_taxi_fare_book_button_text);


		}
		
		new design();
	}
	

	function my_custom_submenu_page_callback() {		
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['SternSaveSettingsCars']) ) 
			{
				$cartype=sanitize_text_field($_POST['cartype']);
				$carfare=sanitize_text_field($_POST['carfare']);
				$carseat=sanitize_text_field($_POST['carseat']);
				$suitcases=sanitize_text_field($_POST['suitcases']);
				
				
				// Create
				if($cartype != null & $carfare!=null && $carseat!=null) {
					stern_taxi_fare_events_Admin::create_post_type_car($cartype,$carfare,$carseat,$suitcases);
				}
				
				// Delete
				$args = array(
					'post_type' => 'stern_taxi_car_type',
					'posts_per_page' => 200,
				);

				$allTypeCars = get_posts( $args );			
				foreach ( $allTypeCars as $post ) {
				 setup_postdata( $post );
				
					if (isset($_POST['remove'.$post->ID])) {						
						if ($_POST['remove'.$post->ID] =='yes') {						
							wp_delete_post( $post->ID, true);
						}				
					}
				}
			}
			
			new typeCars();

	}





	public function menu_page_stern_taxi_fare(){
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['SternSaveSettings']) ) 
        {		
			$stern_taxi_fare_country=sanitize_text_field($_POST['country']);
			update_option("stern_taxi_fare_country",$stern_taxi_fare_country);

			$stern_taxi_fare_apiGoogleKey=sanitize_text_field($_POST['apiGoogleKey']);
			update_option("stern_taxi_fare_apiGoogleKey",$stern_taxi_fare_apiGoogleKey);	

			$stern_taxi_fare_avoid_highways_in_calculation=sanitize_text_field($_POST['stern_taxi_fare_avoid_highways_in_calculation']);
			update_option("stern_taxi_fare_avoid_highways_in_calculation",$stern_taxi_fare_avoid_highways_in_calculation);			
			
			$stern_taxi_fare_minimum=sanitize_text_field($_POST['stern_taxi_fare_minimum']);
			update_option("stern_taxi_fare_minimum",$stern_taxi_fare_minimum);	
						
			$stern_taxi_fare_product_id_wc=sanitize_text_field($_POST['stern_taxi_fare_product_id_wc']);
			update_option("stern_taxi_fare_product_id_wc",$stern_taxi_fare_product_id_wc);				


			$stern_taxi_fare_km_mile=sanitize_text_field($_POST['stern_taxi_fare_km_mile']);
			update_option("stern_taxi_fare_km_mile",$stern_taxi_fare_km_mile);
	/*		
			$stern_taxi_fare_24_12_hr=sanitize_text_field($_POST['stern_taxi_fare_24_12_hr']);
			update_option("stern_taxi_fare_24_12_hr",$stern_taxi_fare_24_12_hr);
*/
			
	
	
	/*
			$stern_taxi_fare_saved_point_to_use_in_button_destination=sanitize_text_field($_POST['stern_taxi_fare_saved_point_to_use_in_button_destination']);
			update_option("stern_taxi_fare_saved_point_to_use_in_button_destination",$stern_taxi_fare_saved_point_to_use_in_button_destination);				
		*/		
			
			
			
			$stern_taxi_fare_address_saved_point=sanitize_text_field($_POST['stern_taxi_fare_address_saved_point']);
			update_option("stern_taxi_fare_address_saved_point",$stern_taxi_fare_address_saved_point);			

			$stern_taxi_fare_address_saved_point2=sanitize_text_field($_POST['stern_taxi_fare_address_saved_point2']);
			update_option("stern_taxi_fare_address_saved_point2",$stern_taxi_fare_address_saved_point2);		
			
			$stern_taxi_fare_round_trip=sanitize_text_field($_POST['stern_taxi_fare_round_trip']);
			update_option("stern_taxi_fare_round_trip",$stern_taxi_fare_round_trip);
			

		/*	
            $stern_taxi_fare_fixed_amount_to_saved_point=sanitize_text_field($_POST['stern_taxi_fare_fixed_amount_to_saved_point']);
            $stern_taxi_fare_fixed_amount_to_saved_point=filter_var( $stern_taxi_fare_fixed_amount_to_saved_point, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			update_option("stern_taxi_fare_fixed_amount_to_saved_point",$stern_taxi_fare_fixed_amount_to_saved_point);			
			
			
            $stern_taxi_fare_fixed_amount=sanitize_text_field($_POST['stern_taxi_fare_fixed_amount']);
            $stern_taxi_fare_fixed_amount=filter_var( $stern_taxi_fare_fixed_amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			update_option("stern_taxi_fare_fixed_amount",$stern_taxi_fare_fixed_amount);			
		*/

		/*
            $seat=sanitize_text_field($_POST['seat']);
            $seat=filter_var( $seat, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			update_option("stern_taxi_fare_seat",$seat);
		*/
/*		
			$stern_taxi_fare_mile=sanitize_text_field($_POST['stern_taxi_fare_mile']);
            $stern_taxi_fare_mile=filter_var( $stern_taxi_fare_mile, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			update_option("stern_taxi_fare_mile",$stern_taxi_fare_mile);
	*/

	
			$First_date_available_in_hours=sanitize_text_field($_POST['First_date_available_in_hours']);
            $First_date_available_in_hours=filter_var( $First_date_available_in_hours, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			update_option("First_date_available_in_hours",$First_date_available_in_hours);			

			$First_date_available_roundtrip_in_hours=sanitize_text_field($_POST['First_date_available_roundtrip_in_hours']);
            $First_date_available_roundtrip_in_hours=filter_var( $First_date_available_roundtrip_in_hours, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			update_option("First_date_available_roundtrip_in_hours",$First_date_available_roundtrip_in_hours);					
	/*		
            $minute=sanitize_text_field($_POST['minute']);
            $minute=filter_var( $minute, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			update_option("stern_taxi_fare_minute",$minute);
	*/

	/*
            $stern_taxi_fare_Tolls=sanitize_text_field($_POST['stern_taxi_fare_Tolls']);
            $stern_taxi_fare_Tolls=filter_var( $stern_taxi_fare_Tolls, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
			update_option("stern_taxi_fare_Tolls",$stern_taxi_fare_Tolls);
		*/

		
			$max_queries_to_API_google=sanitize_text_field($_POST['max_queries_to_API_google']);
			update_option("max_queries_to_API_google",$max_queries_to_API_google);
			
			$Time_between_each_API_google_queries=sanitize_text_field($_POST['Time_between_each_API_google_queries']);
			update_option("Time_between_each_API_google_queries",$Time_between_each_API_google_queries);

		}
		
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['initVal']) ) 
        {
		/*	update_option("stern_taxi_fare_country",'fr');
			update_option("stern_taxi_fare_apiGoogleKey",'AIzaSyD5UzF18OX_hlanu8LK_HIiqPybLHP9Dao');						
			update_option("stern_taxi_fare_emptyCart",'true');					 
			update_option("stern_taxi_fare_show_map",'true');
			update_option("stern_taxi_fare_max_car_seats",'5');			
			update_option("stern_taxi_fare_formID",'1');					
			update_option("stern_taxi_fare_show_map_checkout",'true');

			update_option("stern_taxi_fare_Bootstrap_select",'false');				
			update_option("stern_taxi_fare_show_labels",'true');
			update_option("stern_taxi_fare_bcolor",'#1ABC9C');	
			update_option("stern_taxi_fare_url_gif_loader",getUrlGifLoader());
			update_option("stern_taxi_fare_mile",'1.34');
			
			update_option("stern_taxi_fare_fixed_amount",'');
			update_option("stern_taxi_fare_seat",'0');
			update_option("stern_taxi_fare_minute",'0');
			update_option("stern_taxi_fare_book_button_text",' Book now');
			
			update_option("stern_taxi_fare_minimum",'10');
			*/

			
			$beginNameOption = "stern_taxi_fare%";
			global $wpdb;
			$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name like %s",$beginNameOption));
		
						
					
		}
		if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['createProduct']) ) 
        {
			createProductAndSaveId();			
			
		}		
		
		
		new settings();
	}




}

new stern_taxi_fare_events_Admin();