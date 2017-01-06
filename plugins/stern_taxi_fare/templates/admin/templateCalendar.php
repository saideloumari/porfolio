<?php

if ( ! defined( 'ABSPATH' ) )
	exit;


Class templateCalendar{
	function __construct(){	
		?>
				
			
			<div class="wrap"><div id="icon-tools" class="icon32"></div>
				<h2>Calendar settings</h2>
			</div>
			
			<form name="SternSaveSettingsCalendar" method="post">
				<table name="SternSaveSettingsCalendarTable">
					<tr>
						<td><?php echo _e('Enable booking calendar', 'stern_taxi_fare'); ?></td>
						<td></td>
						<td>					
							<select id="stern_taxi_fare_use_calendar" name="stern_taxi_fare_use_calendar" style="width:300px;">
								<option <?php echo (get_option('stern_taxi_fare_use_calendar') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
								<option <?php echo (get_option('stern_taxi_fare_use_calendar') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
								<option <?php echo (get_option('stern_taxi_fare_use_calendar') == "false" ? "selected"	 : 	""	); ?> value="false">false</option>
							</select>
							<?php echo _e('The calendar will appear and show the niches already booked vehicle.', 'stern_taxi_fare'); ?> 
						</td>						
					</tr>
					<tr>
						<td><?php echo _e('Show FullCalendar Front', 'stern_taxi_fare'); ?></td>
						<td></td>
						<td>					
							<select id="stern_taxi_fare_use_FullCalendar" name="stern_taxi_fare_use_FullCalendar" style="width:300px;">
								<option <?php echo (get_option('stern_taxi_fare_use_FullCalendar') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
								<option <?php echo (get_option('stern_taxi_fare_use_FullCalendar') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
								<option <?php echo (get_option('stern_taxi_fare_use_FullCalendar') == "false" ? "selected"	 : 	""	); ?> value="false">false</option>
							</select>
							<?php echo _e('This option will make the vehicle unavailable when the vehicle has already been booked', 'stern_taxi_fare'); ?> 
						</td>						
					</tr>
					<tr>
						<td>Drag Event in full calendar</td>
						<td></td>
						<td>					
							<select id="stern_taxi_fare_drag_event_FullCalendar" name="stern_taxi_fare_drag_event_FullCalendar" style="width:300px;">
								<option <?php echo (get_option('stern_taxi_fare_drag_event_FullCalendar') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
								<option <?php echo (get_option('stern_taxi_fare_drag_event_FullCalendar') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
								<option <?php echo (get_option('stern_taxi_fare_drag_event_FullCalendar') == "false" ? "selected"	 : 	""	); ?> value="false">false</option>
							</select>							
						</td>						
					</tr>					
					<tr>
						<td>Use FullCalendar Back</td>
						<td></td>
						<td>					
							<select id="stern_taxi_fare_use_FullCalendar_back" name="stern_taxi_fare_use_FullCalendar_back" style="width:300px;">
								<option <?php echo (get_option('stern_taxi_fare_use_FullCalendar_back') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
								<option <?php echo (get_option('stern_taxi_fare_use_FullCalendar_back') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
								<option <?php echo (get_option('stern_taxi_fare_use_FullCalendar_back') == "false" ? "selected"	 : 	""	); ?> value="false">false</option>
							</select>							
						</td>						
					</tr>						
					<tr>
						<td>Time To add after a ride</td>
						<td></td>
						<td><input value="<?php echo get_option('stern_taxi_fare_Time_To_add_after_a_ride'); ?>" type="number" step="0.05" name="stern_taxi_fare_Time_To_add_after_a_ride" style="width:400px;">min. Example: 10</td>
					</tr>
					<tr>
						<td>Granularity in min</td>
						<td></td>
						<?php 
							$slotDuration_min = (get_option('stern_taxi_fare_slotDuration_min') <=0) ? 30 : get_option('stern_taxi_fare_slotDuration_min');
						?>
						<td><input value="<?php echo $slotDuration_min; ?>" type="number" step="1" name="stern_taxi_fare_slotDuration_min" id="stern_taxi_fare_slotDuration_min" style="width:400px;">min. Example: 10</td>
					</tr>					
					
					
					<tr>
						<td><input type="submit" id="SternSaveSettingsCalendarTableSubmit" value="Save Changes" class="button-primary" name="SternSaveSettingsCalendarTableSubmit" style="width:150px;"/></td>
						<td></td>
						<td></td>
					</tr>
									
				</table>
			</form>
			<br>
			<br>
			<br>
			<br>
			<br>
			<div class="wrap"><div id="icon-tools" class="icon32"></div>
			
				<h2>Calendar</h2>
			</div>			
			<form id="selecttypeIDcarCalendar" method="get">
			
			
			
				<?php 
				$args = array(
				'post_type' => 'stern_taxi_car_type',
				'posts_per_page' => 200,
				);

				$allPosts = get_posts( $args );
							
				if(isset($_GET['typeIdCar'])) {					
					$selectedCarTypeId = $_GET['typeIdCar'];
				} else {
					$selectedCarTypeId = "";
				}

				?>			
		

				<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>">
				<select name="typeIdCar" id="typeIdCar" >
					<option value="" >Type car</option>
					<?php foreach ( $allPosts as $post ) : setup_postdata( $post ); ?>
					<?php $otypeCar = new typeCar($post->ID); ?>
						<?php $selected = ($selectedCarTypeId == $otypeCar->getid()) ? "selected" : "" ; ?>
						<option value="<?php echo $otypeCar->getid(); ?>" <?php echo $selected; ?>><?php echo $otypeCar->getcarType(); ?></option>
					<?php endforeach; ?>
				</select>
				
			
				
				
					<label>
						<input name="future" id="future" type="checkbox" <?php echo (isset($_GET['future']) ? 		"checked"	 : 	""	); ?>>Show all dates
					</label>
							
				
				
							
			</form>
			<?php
			
			if(isset($_GET['future'])) {
				$value = '';
			} else {
				$value = date("Y-m-d H:i:s");
			}
				
				
			if(isset($_GET['typeIdCar'])) {
						
					
				$selectedCarTypeId = $_GET['typeIdCar'];
				$args = array(
					'post_type' => 'stern_taxi_calendar',
					'posts_per_page' => 200,
					'order'   => 'ASC',
					'orderby' => 'meta_value',
					'meta_key' => 'dateTimeBegin',						
					'meta_query' => array(
						array(
							'key'     => 'typeIdCar',
							'value'   => $selectedCarTypeId,
							'compare' => '=',
						),
	
						array(
							
							'key'     => 'dateTimeEnd',
							'value'   => $value,
							'compare' => '>',
							
						),						
					),
						
				);
				
		
				$allPosts = get_posts( $args );				
						
				?>
				
				<?php if(get_option('stern_taxi_fare_use_FullCalendar_back')=="true") : ?>
					<h4>Events</h4> 
					
					
									

									
					<div id='detailsEvents'></div>
					<div id='notificationCalendar' style="height:20px;"></div>
					<br><br>
					<div id='calendar'></div>				
				<?php else: ?>					
					<br>
					<form method="post">
						<table class="displayrecord">
							<thead  align="left">
								<tr class="home">
									<th>Id</th>
									<th>type Car</th>
									<th>typeCalendar</th>
									<th></th>
									<th>dateTimeBegin</th>
									<th></th>									
									<th>dateTimeEnd</th>
									
									<th>userName</th>
									<th>WooCommerceOrderId</th>
									<th>IsRepeat</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ( $allPosts as $post ) : setup_postdata( $post );
							$oCalendar = new calendar($post->ID);
							$otypeCar = new typeCar($oCalendar->gettypeIdCar());
							?>
							
								<tr>
									<td><?php echo $oCalendar->getid() ?></td>
									<td><?php echo $otypeCar->getcarType()." (". $oCalendar->gettypeIdCar() .")" ?></td>
									<td><?php echo $oCalendar->gettypeCalendar(); ?></td>
									<td></td>
									<td><?php echo $oCalendar->getdateTimeBegin(); ?></td>
									<td></td>
									<td><?php echo $oCalendar->getdateTimeEnd(); ?></td>
									
									<td><a href="<?php echo admin_url( 'user-edit.php?user_id='.$oCalendar->getuserId() );?>"> <?php echo the_author_meta( 'user_nicename' , $oCalendar->getuserId() ); ?></a></td>
									<td><a href="<?php echo get_edit_post_link( $oCalendar->getwooCommerceOrderId() ); ?>"> <?php echo $oCalendar->getwooCommerceOrderId(); ?></a></td>
									<td><?php echo $oCalendar->getisRepeat(); ?></td>
									<td><input type="checkbox" name="remove<?php echo $post->ID; ?>" value="yes"></td>
								</tr>
							<?php endforeach; 
								wp_reset_postdata();
							?>	
								<tr>
									<td></td>
									<td><input type="hidden" name="typeIdCar" value="<?php echo $selectedCarTypeId; ?>"></td>
									
									<td>
										<select name="typeCalendar">
											<option value=""></option>
											<option value="disabledTimeIntervals">Disabled Time Interval</option>
										</select>							
									</td>
									<td><input type="date" name="dateBegin" value="<?php echo date('Y-m-d'); ?>" ></td>
									<td><input type="time" name="dateTimeBegin" value="<?php echo date('H:i'); ?>" ></td>
									<td><input type="date" name="dateEnd" value="<?php echo date('Y-m-d'); ?>" ></td>
									<td><input type="time" name="dateTimeEnd" value="<?php echo date('H:i'); ?>" ></td>
									
									<td></td>
									<td></td>
									<td>
										<select name="isRepeat">
											<option value=""></option>
											<option value="true">true</option>
										</select>	
									</td>
				
									<td>
										<input type="submit" id="ruleSubmit" value="Go" class="button-primary" name="calendarSubmit" />
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				<?php endif; ?>	

				<?php
			}
	}
}