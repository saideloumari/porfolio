<?php

Class checkoutEmail{
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
		<label><?php _e('Trip', 'stern_taxi_fare' ); ?></label>
		<?php
		echo '<p><strong>'.__('distance', 'stern_taxi_fare').':</strong> ' . get_post_meta( $order_id , '_distance', true ) .'</p>';
		echo '<p><strong>'.__('duration', 'stern_taxi_fare').':</strong> ' . get_post_meta( $order_id , '_duration', true ) . '</p>';
		//echo '<p><strong>'.__('estimated_fare').':</strong> ' . get_post_meta($order_id , '_estimated_fare', true ) . '</p>';
		echo '<p><strong>'.__('cartypes', 'stern_taxi_fare').':</strong> ' . get_post_meta( $order_id , '_cartypes', true ) . '</p>';
		echo '<p><strong>'.__('source', 'stern_taxi_fare').':</strong> ' . get_post_meta( $order_id , '_source', true ) . '</p>';
		echo '<p><strong>'.__('destination', 'stern_taxi_fare').':</strong> ' . get_post_meta( $order_id , '_destination', true ) . '</p>';	
		echo '<p><strong>'.__('car_seats', 'stern_taxi_fare').':</strong> ' . get_post_meta( $order_id , '_car_seats', true ) . '</p>';	
		echo '<p><strong>'.__('dateTimePickUp', 'stern_taxi_fare').':</strong> ' . get_post_meta( $order_id , '_local_pickup_time_select', true ) . '</p>';	
		?>
		<?php if($nbToll !="") : ?>	
			<p>
				<strong><?php _e('nbToll: ', 'stern_taxi_fare'); ?></strong><?php echo $nbToll; ?>
			</p>
		<?php endif; ?>
		<?php if($numberOfPets !="") : ?>
			<p>
				<strong><?php _e('Number Of Pets: ', 'stern_taxi_fare'); ?></strong><?php echo $numberOfPets; ?>
			</p>
		<?php endif; ?>
		<p>
			<strong><?php _e('Round trip: ', 'stern_taxi_fare'); ?></strong><?php echo get_post_meta( $order_id , '_stern_taxi_fare_round_trip', true ); ?>
		</p>
		<?php if($dateTimePickUpRoundTrip !="") : ?>
			<p>
				<strong><?php _e('Date Round Trip: ', 'stern_taxi_fare'); ?></strong><?php echo $dateTimePickUpRoundTrip; ?>
			</p>
		<?php endif; ?>
	<?php
	}
}