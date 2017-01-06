<?php


if ( ! defined( 'ABSPATH' ) )
	exit;

add_action( 'woocommerce_email_after_order_table', 'add_link_back_to_order', 10, 2 );
function add_link_back_to_order( $order, $is_admin ) {

	$order_id  = $order->id;
	new checkoutEmail($order_id);
	
}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
function my_custom_checkout_field_display_admin_order_meta($order){
	$order_id  = $order->id;
	new checkoutEmail($order_id);
	
}


add_action( 'woocommerce_view_order', 'woocommerce_view_order_taxi', 10, 1 );
function woocommerce_view_order_taxi( $order_id ) {
	new checkoutAfter($order_id);
}


add_filter('woocommerce_thankyou_order_received_text', 'isa_order_received_text', 10, 2 );
function isa_order_received_text( $text, $order ) {

	$order_id  = $order->id;
	new checkoutAfter($order_id);
}



add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );
function my_custom_checkout_field( $checkout ) {
		global $woocommerce;
		$checkIfInCart=0;
		foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];
		
			if( get_option('stern_taxi_fare_product_id_wc') == $_product->id ) {
				$checkIfInCart = $checkIfInCart+1;
			}
		}
		if($checkIfInCart>0) {
			new checkout(); 
		}
}



add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );
function my_custom_checkout_field_update_order_meta( $order_id ) {
	
	
	
	global $woocommerce;
	
	$distance = WC()->session->get( 'distance' );
	$duration = WC()->session->get( 'duration' );
	$durationHtml = WC()->session->get( 'durationHtml' );
	$distanceHtml = WC()->session->get( 'distanceHtml' );
	
	$estimated_fare = WC()->session->get( 'estimated_fare' );	
	$cartypes = WC()->session->get( 'cartypes' );
	$selectedCarTypeId = WC()->session->get( 'selectedCarTypeId' );
	
	$source = WC()->session->get( 'source' );	
	$destination = WC()->session->get( 'destination' );	
	$car_seats = WC()->session->get( 'car_seats' );	
	$dateTimePickUp = setToCorrectFormatDate(WC()->session->get( 'dateTimePickUp' ));	
	

	
	$nbToll = WC()->session->get( 'nbToll' );
	$stern_taxi_fare_round_trip = WC()->session->get( 'stern_taxi_fare_round_trip' );

	$dateTimePickUpRoundTrip = setToCorrectFormatDate(WC()->session->get( 'dateTimePickUpRoundTrip' ));	
	
	//$estimatedDateOfArrival = 

	$oCalendar = new calendar();
	$oCalendar->settypeIdCar($selectedCarTypeId);
	$oCalendar->settypeCalendar("disabledTimeIntervals");
	
	$fullDuration = $duration + get_option('stern_taxi_fare_Time_To_add_after_a_ride');
	$dateTimePickUpEnd = date("Y-m-d H:i:s", strtotime('+'.$fullDuration.' minutes', strtotime($dateTimePickUp))); 
	$estimatedDateOfArrival = date("Y-m-d H:i:s", strtotime('+'.$duration.' minutes', strtotime($dateTimePickUp))); 
	
	$oCalendar->setdateTimeBegin($dateTimePickUp); 
	$oCalendar->setdateTimeEnd($dateTimePickUpEnd);
	
	$oCalendar->setwooCommerceOrderId($order_id);
	
	$oCalendar->save();	
	

    if ( ! empty( $distanceHtml ) ) {
        update_post_meta( $order_id, '_distance', sanitize_text_field( $distanceHtml ) );
    }	
    if ( ! empty( $durationHtml ) ) {
        update_post_meta( $order_id, '_duration', sanitize_text_field( $durationHtml ) );
    }
    if ( ! empty( $estimated_fare ) ) {
        update_post_meta( $order_id, '_estimated_fare', sanitize_text_field( $estimated_fare ) );
    }
    if ( ! empty( $cartypes ) ) {
        update_post_meta( $order_id, '_cartypes', sanitize_text_field( $cartypes ) );
    }
    if ( ! empty( $source ) ) {
        update_post_meta( $order_id, '_source', sanitize_text_field( $source ) );
    }
    if ( ! empty( $destination ) ) {
        update_post_meta( $order_id, '_destination', sanitize_text_field( $destination ) );
    }
    if ( ! empty( $car_seats ) ) {
        update_post_meta( $order_id, '_car_seats', sanitize_text_field( $car_seats ) );
    }
    if ( ! empty( $nbToll ) ) {
        update_post_meta( $order_id, '_nbToll', sanitize_text_field( $nbToll ) );
    }
    if ( ! empty( $stern_taxi_fare_round_trip ) ) {
        update_post_meta( $order_id, '_stern_taxi_fare_round_trip', sanitize_text_field( $stern_taxi_fare_round_trip ) );
    }
    if ( ! empty( $dateTimePickUpRoundTrip ) ) {
        update_post_meta( $order_id, '_dateTimePickUpRoundTrip', sanitize_text_field( $dateTimePickUpRoundTrip ) );
    }
    if ( ! empty( $estimatedDateOfArrival ) ) {
        update_post_meta( $order_id, '_estimatedDateOfArrival', sanitize_text_field( $estimatedDateOfArrival ) );
    }

    if ( ! empty( $dateTimePickUp ) ) {
        update_post_meta( $order_id, '_local_pickup_time_select', sanitize_text_field( $dateTimePickUp ) );
    }		
	
	if ( ! empty( $_POST['NumberOfPets'] ) ) {
        update_post_meta( $order_id, '_NumberOfPets', sanitize_text_field( $_POST['NumberOfPets'] ) );
    }	


	
}





add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' );

function add_custom_price( $cart_object ) {

  global $woocommerce;
 
  $cart_item_meta['estimated_fare'] = WC()->session->get( 'estimated_fare' );

  
    $custom_price = $cart_item_meta['estimated_fare'] ; // This will be your custome price  
    $target_product_id = get_option('stern_taxi_fare_product_id_wc');
    foreach ( $cart_object->cart_contents as $key => $value ) {
        if ( $value['product_id'] == $target_product_id ) {
            $value['data']->price = $custom_price;
        }
    }
}

