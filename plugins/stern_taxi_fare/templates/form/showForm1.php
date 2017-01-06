<?php
function showForm1($atts) {

			$args = array(
				'post_type' => 'stern_taxi_car_type',
				'nopaging' => true,
				'order'     => 'ASC',
				'orderby' => 'meta_value',
				'meta_key' => '_stern_taxi_car_type_organizedBy'
			);
			$allTypeCars = get_posts( $args );	

			$args = array(
				'post_type' => 'stern_listAddress',
				'nopaging' => true,
				'meta_query' => array(
					array(
						'key'     => 'typeListAddress',
						'value'   => 'source',
						'compare' => '=',
					),
					array(
						'key'     => 'isActive',
						'value'   => 'true',
						'compare' => '=',
					),
				),				
			);
			$allListAddressesSource = get_posts( $args );
			
			$args = array(
				'post_type' => 'stern_listAddress',
				'nopaging' => true,
				'meta_query' => array(
					array(
						'key'     => 'typeListAddress',
						'value'   => 'destination',
						'compare' => '=',
					),				
					array(
						'key'     => 'isActive',
						'value'   => 'true',
						'compare' => '=',
					),
				),				
			);
			$allListAddressesDestination = get_posts( $args );			


			 $backgroundColor=get_option('stern_taxi_fare_bcolor');
			 if($backgroundColor!="")
			 {
				$backgroundColor='background-color:'.stern_taxi_fare_hex2rgba($backgroundColor,get_option('stern_taxi_fare_bTransparency'));
			 }
			global $woocommerce;
			$checkout_url = $woocommerce->cart->get_checkout_url();
			$currency_symbol = get_woocommerce_currency_symbol();

			if (isBootstrapSelectEnabale())
			{
				$class = "form-control";
			} else {
				$class = "selectpicker show-tick";
			}
		
			$stern_taxi_fare_book_button_text = get_option('stern_taxi_fare_book_button_text');
			
			
			$class_full_row12 = (get_option('stern_taxi_fare_full_row') != "true") ? "class='col-lg-12 col-md-12 col-sm-12 col-xs-12'" : "class='col-lg-12 col-md-12 col-sm-12 col-xs-12'";
			$class_full_row6 = (get_option('stern_taxi_fare_full_row') != "true") ? "class='col-lg-6 col-md-6 col-sm-12 col-xs-12'" : "class='col-lg-12 col-md-12 col-sm-12 col-xs-12'";
			$class_full_row3 = (get_option('stern_taxi_fare_full_row') != "true") ? "class='col-lg-3 col-md-3 col-sm-12 col-xs-12'" : "class='col-lg-12 col-md-12 col-sm-12 col-xs-12'";
			
						
									
					
			$classMain = (get_option('stern_taxi_fare_form_full_row') != "true") ? "class='col-xs-12 col-sm-6 col-lg-6'" : "class='col-xs-12 col-sm-12 col-lg-12'";
			
		
			?>

            
          
   
			<div class="container">
				<div class="stern-taxi-fare">
					<div class="row">
						<div  <?php echo $classMain; ?> id="main1" style="<?php echo $backgroundColor; ?>;padding-bottom: 5px" >

						
					
							<form id="stern_taxi_fare_div" method="post" action="<?php echo $checkout_url; ?>">
							

					
								<div class="row">
								
									<?php if(get_option('stern_taxi_fare_seat_field_as_input') =="true") : ?>
										<?php showSeatInputs1($class_full_row3,$class); ?>
									<?php endif;?>
									
									
								
									<?php if(get_option('stern_taxi_fare_typeCar_calendar_free') =="true") : ?>										
										<?php showDateTimeInput($class_full_row12,$class); ?>
									<?php else: ?>
										<?php showTypeCar($class_full_row6,$class); ?>
										<?php showRoundTrip($class_full_row3,$class); ?>
									<?php endif;?>
									
									
									<?php if(get_option('stern_taxi_fare_seat_field_as_input') !="true") : ?>
										<?php showSeatInputs1($class_full_row3,$class); ?>
									<?php endif; ?>							
										
								</div>
								
		
			

								
									
									
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top: 15px;">
										<div class="input-group form-group" id ="divSource">
											<div class="input-group-btn">
												<button type="button" class="btn btn-primary " id="cal4" name="submit" value="getLocation" onClick="getLocation()" style="font-size: 14px; font-weight: bold" >
													<span id="getLocationSource" class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
												</button>
											</div>										
											<?php if(get_option('stern_taxi_use_list_address_source')=='true') : ?>
												<select name="source" id="source" class="<?php echo $class; ?>" data-width="100%" style="padding-left: 15px; float: right;">';
													<optgroup label="<?php _e('Pick Up Address', 'stern_taxi_fare'); ?>">
														<?php foreach ( $allListAddressesSource as $post ) : setup_postdata( $post ); ?>
															<?php $oListAddress = new listAddress($post->ID); ?>
															<option data-icon="glyphicon-import" value="<?php echo $oListAddress->getaddress(); ?>">
																<?php echo $oListAddress->getaddress(); ?>
															</option>															
														<?php endforeach; ?>
													</optgroup>
												</select>
											<?php else: ?>												
												<input id="source" name="source" type="text" class="form-control" placeholder="<?php _e('Pick Up Address', 'stern_taxi_fare'); ?>">												
											<?php endif ?>
										</div>
										
									</div>
								</div>								

								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top: 15px;">
										<div class="input-group form-group" id ="divDestination">
											<div class="input-group-btn">
												<button type="button" class="btn btn-primary " id="cal5" name="submit"  onClick="getLocationDestination()" style="font-size: 14px; font-weight: bold" >
													<span id="getLocationDestination" class="glyphicon <?php echo getDestination_Button_glyph();?>" aria-hidden="true"></span>
												</button>
											</div>										
											<?php if(get_option('stern_taxi_use_list_address_destination')=='true') : ?>												
												<select name="destination" id="destination" class="<?php echo $class; ?>" data-width="100%" style="padding-left: 15px; float: right;">
													<optgroup label="<?php _e('Destination', 'stern_taxi_fare'); ?>">
														<?php foreach ( $allListAddressesDestination as $post ) : setup_postdata( $post ); ?>
															<?php $oListAddress = new listAddress($post->ID); ?>
															<option data-icon="glyphicon-export" value="<?php echo $oListAddress->getaddress(); ?>">
																<?php echo $oListAddress->getaddress(); ?>
															</option>														
														<?php endforeach; ?>
													</optgroup>
												</select>											
											<?php else: ?>	
												<input id="destination" name="destination" type="text" class="form-control" placeholder="<?php _e('Drop Off Address', 'stern_taxi_fare'); ?>" >											
											<?php endif ?>	
										</div>
									</div>
								</div>
								

								
														
						
							
						
								
								<div class="row">	
									<div class="col-xs-12 form-group" style="text-align: center;padding-top: 15px; margin-bottom: 15px">
									
										<?php $tooltip = (get_option('stern_taxi_fare_show_tooltips') != "false") ? "data-toggle='tooltip' data-placement='left' data-original-title='". __('Reset Form', 'stern_taxi_fare')."';" : ""; ?>
										<button type="button"  <?php echo $tooltip; ?> class="btn btn-primary " id="resetBtn" name="reset" value="Reset"  style="font-size: 14px; font-weight: bold;" />
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
											<?php echo (get_option('stern_taxi_fare_show_label_in_button') == "true") ? __('Reset Form', 'stern_taxi_fare') : ""; ?>
										</button>									
	
										

										<?php $tooltip = (get_option('stern_taxi_fare_show_tooltips') != "false") ? "data-toggle='tooltip' data-placement='top' data-original-title='". __('Show Map', 'stern_taxi_fare')."';" : ""; ?>
										<button type="button" <?php echo $tooltip; ?> class="btn btn-primary " id="cal3" name="submit" value="showMap" onClick="showMap()" style="font-size: 14px; font-weight: bold;visibility: hidden;" >
											<span id="SpanCal3" class="glyphicon glyphicon-map-marker" aria-hidden="true">
												
											</span>
											<?php echo (get_option('stern_taxi_fare_show_label_in_button') == "true") ? __('Show Map', 'stern_taxi_fare') : ""; ?>
										</button>
										
								
										<?php $tooltip = (get_option('stern_taxi_fare_show_tooltips') != "false") ? "data-toggle='tooltip' data-placement='right' data-original-title='". __('Check Price', 'stern_taxi_fare')."';" : ""; ?>
										<button type="button" <?php echo $tooltip; ?>  class="btn btn-primary " id="cal1" name="submit" value="Check" onClick="doCalculation()" style="font-size: 14px; font-weight: bold" />
											<span id="SpanCal1"  class="glyphicon glyphicon-check" aria-hidden="true">
												
											</span>
											<?php echo (get_option('stern_taxi_fare_show_label_in_button') == "true") ? __('Check Price', 'stern_taxi_fare') : ""; ?>
										</button>

									
										
										
									</div>		
										
								</div>
								
								<input type="hidden"  name="stern_taxi_fare_use_calendar" id="stern_taxi_fare_use_calendar" value="<?php echo get_option('stern_taxi_fare_use_calendar'); ?>"/>
								<input type="hidden"  name="stern_taxi_fare_use_FullCalendar" id="stern_taxi_fare_use_FullCalendar" value="<?php echo get_option('stern_taxi_fare_use_FullCalendar'); ?>"/>
								<input type="hidden"  name="actualVersionPlugin" id="actualVersionPlugin" readonly value="<?php echo getPluginVersion(); ?>"/>
								<input type="hidden"  name="checkout_url" id="checkout_url" readonly value="<?php echo $checkout_url; ?>"/>
								<input type="hidden"  name="currency_symbol" id="currency_symbol" readonly value="<?php echo $currency_symbol; ?>"/>
								<input type="hidden"  name="countryHidden" id="countryHidden" value="<?php echo get_option('stern_taxi_fare_country'); ?>"/>									
								<input type="hidden"  name="stern_taxi_fare_url_gif_loader" id="stern_taxi_fare_url_gif_loader" value="<?php echo getUrlGifLoader(); ?>"/>									
								<input type="hidden"  name="apiGoogleKey" id="apiGoogleKey" value="<?php echo get_option('stern_taxi_fare_apiGoogleKey'); ?>"/>
								<input type="hidden"  name="stern_taxi_fare_show_map" id="stern_taxi_fare_show_map" value="<?php echo get_option('stern_taxi_fare_show_map'); ?>"/>
								<input type="hidden"  name="stern_taxi_fare_auto_open_map" id="stern_taxi_fare_auto_open_map" value="<?php echo get_option('stern_taxi_fare_auto_open_map'); ?>"/>									
								<input type="hidden"  name="getKmOrMiles" id="getKmOrMiles" value="<?php echo getKmOrMiles(); ?>"/>									
								<input type="hidden"  name="stern_taxi_fare_avoid_highways_in_calculation" id="stern_taxi_fare_avoid_highways_in_calculation" value="<?php echo get_option('stern_taxi_fare_avoid_highways_in_calculation'); ?>"/>									
								<input type="hidden"  name="getShow_use_img_gif_loader" id="getShow_use_img_gif_loader" value="<?php echo getShow_use_img_gif_loader(); ?>"/>									
								<input type="hidden"  name="stern_taxi_fare_address_saved_point" id="stern_taxi_fare_address_saved_point" value="<?php echo get_option('stern_taxi_fare_address_saved_point') ?>"/>
								<input type="hidden"  name="stern_taxi_fare_address_saved_point2" id="stern_taxi_fare_address_saved_point2" value="<?php echo get_option('stern_taxi_fare_address_saved_point2') ?>"/>									
								<input type="hidden"  name="First_date_available_in_hours" id="First_date_available_in_hours" value="<?php echo getFirst_date_available_in_hours(); ?>"/>
								<input type="hidden"  name="First_date_available_roundtrip_in_hours" id="First_date_available_roundtrip_in_hours" value="<?php echo getFirst_date_available_roundtrip_in_hours(); ?>"/>
								<input type="hidden"  name="stern_taxi_fare_Time_To_add_after_a_ride" id="stern_taxi_fare_Time_To_add_after_a_ride" value="<?php echo get_option('stern_taxi_fare_Time_To_add_after_a_ride') ?>"/>									
								<input type="hidden"  name="stern_taxi_fare_great_text" id="stern_taxi_fare_great_text" value="<?php _e('Great! ', 'stern_taxi_fare'); ?>"/>
								<input type="hidden"  name="stern_taxi_fare_fixed_price_text" id="stern_taxi_fare_fixed_price_text" value="<?php _e('This is a fixed price ! ', 'stern_taxi_fare'); ?>"/>
								<input type="hidden"  name="stern_taxi_fare_duration" id="stern_taxi_fare_duration" value=""/>
								<input type="hidden"  name="stern_taxi_fare_distance" id="stern_taxi_fare_distance" value=""/>
								<input type="hidden"  name="stern_taxi_fare_nb_toll" id="stern_taxi_fare_nb_toll" value=""/>
								<input type="hidden"  name="stern_taxi_fare_estimated_fare" id="stern_taxi_fare_estimated_fare" value=""/>
								
								
								<div id="divAlertError" class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<div id="divAlertErrorText">
									<strong><?php _e('Error!', 'stern_taxi_fare'); ?></strong><?php _e('Please Try again', 'stern_taxi_fare'); ?> 
									</div>
								</div>											
								
								
								<div id="divAlert" class="alert alert-success alert-dismissible" role="alert" style="display: none;">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<div id="divAlertText"></div>
								</div>									
								
						
							
								<div class="row">

											
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="resultRightMain" style="display: inline-block;">

										<div id="resultText"  style="display: none;<?php echo $backgroundColor; ?>;">
											<div class="row">
												
												

											
											
												<div  <?php echo $classMain; ?> style="display: inline-block;<?php echo (get_option('stern_taxi_fare_show_distance_in_form')!="false") ? "" : "display:none;"; ?>">
													<span>
														<strong><?php _e('Distance: ', 'stern_taxi_fare'); ?></strong><span id="distanceSpanValue"></span>
													</span>
												</div>
												
											
											
												<div  <?php echo $classMain; ?> style="display: inline-block;<?php echo (get_option('stern_taxi_fare_show_tolls_in_form')!="false") ? "" : "display:none;"; ?>">
													<span>
														<strong><?php _e('Tolls: ', 'stern_taxi_fare'); ?></strong><span id="tollSpanValue"></span>
													</span>
												</div>
											
										
											
											
											
												<div  <?php echo $classMain; ?> style="display: inline-block;<?php echo (get_option('stern_taxi_fare_show_duration_in_form')!="false") ? "" : "display:none;"; ?>">
													<span>
														<strong><?php _e('Duration: ', 'stern_taxi_fare'); ?></strong><span id="durationSpanValue"></span>
													</span>
												</div>
												
												
				
											
												
												<div  <?php echo $classMain; ?> id="suicasesDivId" style="display: inline-block;<?php echo (get_option('stern_taxi_fare_show_suitcases_in_form')!="false") ? "" : "display:none;"; ?>">
													<span>
														<strong><?php _e('Max suitcases: ', 'stern_taxi_fare'); ?></strong><span id="suitcasesSpanValue"></span>
													</span>
												</div>														
											
												
												<div  <?php echo $classMain; ?> id="estimatedFareDivId" style="display: inline-block;<?php echo (get_option('stern_taxi_fare_show_estimated_in_form')!="false") ? "" : "display:none;"; ?>">
													<span>
														<strong><?php _e('Estimated Fare: ', 'stern_taxi_fare'); ?></strong><span id="estimatedFareSpanValue"></span>
													</span>
												</div>
																									
										
																																				
												
											</div>	
		
								
										</div>												
									</div>	
								</div>
							
								<div id="resultLeft" style="display: none;">
									<?php if(get_option('stern_taxi_fare_typeCar_calendar_free') =="true") : ?>

										<?php showTypeCar($class_full_row6,$class); ?>
										<?php showRoundTrip($class_full_row3,$class); ?>
									
									<?php else : ?>	

										<div class="row">									
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top: 15px;">
												<?php if (showlabel()) : ?>
													<label for="dtp_input1" class="col-md-3 control-label"><?php _e('DateTime Picking', 'stern_taxi_fare'); ?></label>
												<?php endif; ?>												
												<div class="form-group">
													<div class='input-group date' id='datetimepickerDateNotCalendar'>
														<?php $tooltip = (get_option('stern_taxi_fare_show_tooltips') != "false") ? "data-toggle='tooltip' data-placement='bottom' data-original-title='". __('DateTime Picking', 'stern_taxi_fare')."';" : ""; ?>
														<div class="input-group-btn" <?php echo $tooltip; ?>>
															<button type="button"  id="setNowDateId" onClick="setNowDate()" class="btn btn-primary " style="font-size: 14px; font-weight: bold" >
																<span id="buttonDateTime" class="glyphicon glyphicon-time" aria-hidden="true"></span>
															</button>
														</div>
														<input type='text' class="form-control"id="dateTimePickUp" name="dateTimePickUp" />														
													</div>
												</div>	
											</div>
										</div>
									
									<?php endif; ?>
									
							
									
									<div class="row" id="divDateTimePickUpRoundTrip" style="display: none;">									
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top: 15px;">
											<?php if (showlabel()) : ?>
												<label for="dtp_input1"><?php _e('DateTime Picking for round trip', 'stern_taxi_fare'); ?></label>
											<?php endif; ?>												
											<div class="form-group">
												<div class='input-group date' id='datetimepickerRoundTrip'>
													<?php $tooltip = (get_option('stern_taxi_fare_show_tooltips') != "false") ? "data-toggle='tooltip' data-placement='bottom' data-original-title='". __('DateTime Picking for round trip', 'stern_taxi_fare')."';" : ""; ?>
													<div class="input-group-btn" <?php echo $tooltip; ?>>
														<button type="button"  id="setNowDateId" onClick="setNowDateRoundTrip()" class="btn btn-primary " style="font-size: 14px; font-weight: bold" >
															<span id="buttonDateTimeROundTrip" class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
														</button>
													</div>
													<input type='text' class="form-control"id="dateTimePickUpRoundTrip" name="dateTimePickUpRoundTrip" />														
												</div>
											</div>	
										</div>
									</div>
									
									
									<div class="row">
										<div class="col-xs-12 form-group" style="text-align: center;padding-top: 15px; margin-bottom: 15px">
										
											<button type="button" class="btn btn-primary " onclick="checkout_url_function()" id="calCheckout_url" name="calCheckout_url" value="calCheckout_url"  style="font-size: 14px; font-weight: bold" />
												<span id="SpanBookButton" class="glyphicon glyphicon-ok" aria-hidden="true"> </span> <?php echo $stern_taxi_fare_book_button_text; ?>
											</button>
										</div>
									</div>										
									
								</div>								
							</form>
						</div>
						
						<div <?php echo $classMain; ?>  id="fullCalendarDivContainer" style="<?php echo $backgroundColor; ?>;display: none;padding-top: 10px;padding-bottom: 10px;">
							<div id='external-events'>
								
							</div>

							<div id='fullCalendarDiv'></div>
						</div>
					
						<div <?php echo $classMain; ?>  id="main2" style="<?php echo $backgroundColor; ?>; background-image:url(<?php echo getUrlGifLoader(); ?>);visibility: hidden;"></div>						
						
						

				
					</div>
				</div>
				


			</div>
		<?php
	/*
echo "<pre>";
    var_dump(WC()->session);
echo "</pre>";
	*/
	
}
