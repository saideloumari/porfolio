<?php

Class checkoutAfter{
	function __construct($order_id){

	
	$distanceHtml = get_post_meta( $order_id , '_distance', true );
	$durationHtml = get_post_meta( $order_id , '_duration', true );
	$estimated_fare = get_post_meta($order_id , '_estimated_fare', true );
	$cartypes = get_post_meta( $order_id , '_cartypes', true );
	$source = get_post_meta( $order_id , '_source', true );
	$destination = get_post_meta( $order_id , '_destination', true );
	$car_seats = get_post_meta( $order_id , '_car_seats', true );
	$dateTimePickUp = get_post_meta( $order_id , '_local_pickup_time_select', true );
	$nbToll = get_post_meta( $order_id , '_nbToll', true );
	$numberOfPets = get_post_meta( $order_id , '_NumberOfPets', true );
	$dateTimePickUpRoundTrip = get_post_meta( $order_id , '_dateTimePickUpRoundTrip', true );
	$stern_taxi_fare_round_trip = (get_post_meta( $order_id , '_stern_taxi_fare_round_trip', true )=="true") ? __('Round Trip', 'stern_taxi_fare') : __('One way', 'stern_taxi_fare') ;
	
	

	

	?>
	
    <br>
	<h3><?php _e('Your trip', 'stern_taxi_fare' ); ?></h3>
	<br>
	<div class="row">

		
			
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<label><?php _e( 'Pickup Time', 'stern_taxi_fare' ); ?></label>
			<input name="dateEstimatedPickedUp" type="text" class="input-text" readonly value="<?php echo $dateTimePickUp; ?>">
			<input name="timeEstimatedPickedUp" type="hidden" class="input-text" readonly value="">			
		</div>
			
			
		
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<label><?php _e('Distance', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $distanceHtml; ?>">
		</div>
		
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<label><?php _e('Duration', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $durationHtml; ?>">
		</div>	


		<div class="col-xs-12 col-sm-6 col-lg-4">
			<label><?php _e('Car type', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $cartypes; ?>">
		</div>
		
		<?php if($nbToll !="") : ?>
			<div class="col-xs-12 col-sm-6 col-lg-4">
				<label><?php _e('Number of Tolls', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $nbToll; ?>">
			</div>
		<?php endif; ?>	

		<div class="col-xs-12 col-sm-6 col-lg-4">
			<label><?php _e('Seats', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $car_seats; ?>">
		</div>
		
		<?php if($numberOfPets !="") : ?>
			<div class="col-xs-12 col-sm-6 col-lg-4">
				<label><?php _e('Number Of Pets', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $numberOfPets; ?>">
			</div>		
		<?php endif; ?>
		

		<div class="col-xs-12 col-sm-6 col-lg-4">
			<label><?php _e('Source', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $source; ?>">
		</div>

		
		<div class="col-xs-12 col-sm-6 col-lg-4">
			<label><?php _e('Destination', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $destination; ?>">
		</div>

		<div class="col-xs-12 col-sm-6 col-lg-4">
			<label><?php _e('Round trip?', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $stern_taxi_fare_round_trip; ?>">
		</div>
		
		<?php if($dateTimePickUpRoundTrip !="") : ?>
			<div class="col-xs-12 col-sm-6 col-lg-4">
				<label><?php _e('Pickup Time for Round Trip', 'stern_taxi_fare'); ?></label><input type="text" class="input-text" readonly value="<?php echo $dateTimePickUpRoundTrip; ?>">
			</div>		
		<?php endif; ?>

	
	
	
		<?php

		
		if (get_option('stern_taxi_fare_show_map_checkout') ==true) {
			$apiGoogleKey = get_option('stern_taxi_fare_apiGoogleKey');
			$iframeGmap = "<iframe  width='100%'   height='350' ";
			$iframeGmap .= "frameborder='0' style='border:0'  ";
			$iframeGmap .= "src='https://www.google.com/maps/embed/v1/directions?key=" . $apiGoogleKey ;
			$iframeGmap .= "&origin=" . $source;
			$iframeGmap .= "&destination=" . $destination ;
			$iframeGmap .= "&avoid=tolls|highways' allowfullscreen></iframe>";
			echo $iframeGmap;
		}
		?>
    </div>
	<br><br>
	<?php
	}
}