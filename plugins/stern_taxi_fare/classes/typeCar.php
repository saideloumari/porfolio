<?php

if ( ! defined( 'ABSPATH' ) )
	exit;


class typeCar {
		protected $id;
		protected $carType;		
		protected $carFare;
		protected $carSeat;
		protected $suitcases;
		protected $organizedBy;
		protected $farePerDistance;
		protected $farePerMinute;
		protected $farePerSeat;
		protected $farePerToll;
		
		
		
		

	/**
	 * Constructor
	 */
	public function __construct($id = null) {
		if($id != null){			
			$this->id = $id;
			$this->carType = get_post_meta( $id, '_stern_taxi_car_type_cartype',true );
			$this->carFare = get_post_meta( $id, '_stern_taxi_car_type_carfare',true );
			$this->carSeat = get_post_meta( $id, '_stern_taxi_car_type_carseat',true ); 
			$this->suitcases = get_post_meta( $id, '_stern_taxi_car_type_suitcases',true );
			$this->organizedBy = get_post_meta( $id, '_stern_taxi_car_type_organizedBy',true );			
			$this->farePerDistance = get_post_meta( $id, '_stern_taxi_car_type_farePerDistance',true );
			$this->farePerMinute = get_post_meta( $id, '_stern_taxi_car_type_farePerMinute',true );
			$this->farePerSeat = get_post_meta( $id, '_stern_taxi_car_type_farePerSeat',true );
			$this->farePerToll = get_post_meta( $id, '_stern_taxi_car_type_farePerToll',true );
			
		}
	}
	
	function getid(){                   			return $this->id; }
	function getcarType(){                   		return $this->carType; }
	function getcarFare(){                   		return $this->carFare; }
	function getcarSeat(){                  		return $this->carSeat; }
	function getsuitcases(){ 	                  	return $this->suitcases; }
	function getorganizedBy(){ 	                  	return $this->organizedBy; }	
	function getfarePerDistance(){					return $this->farePerDistance; }
	function getfarePerMinute(){					return $this->farePerMinute; }
	function getfarePerSeat(){ 	                  	return $this->farePerSeat; }
	function getfarePerToll(){ 	                  	return $this->farePerToll; }
	
	

	
	function setid($id) {										$this->id = $id; }
	function setcarType($carType) {								$this->carType = $carType; }
	function setcarFare($carFare) {								$this->carFare = $carFare; }	
	function setcarSeat($carSeat) {								$this->carSeat = $carSeat; }
	function setsuitcases($suitcases) {							$this->suitcases = $suitcases; }
	function setorganizedBy($organizedBy) {						$this->organizedBy = $organizedBy; }	
	function setfarePerDistance($farePerDistance) {				$this->farePerDistance = $farePerDistance; }
	function setfarePerMinute($farePerMinute) {					$this->farePerMinute = $farePerMinute; }
	function setfarePerSeat($farePerSeat) {						$this->farePerSeat = $farePerSeat; }
	function setfarePerToll($farePerToll) {						$this->farePerToll = $farePerToll; }
	
	
	
	function save(){
		$userID = 1;
		if(get_current_user_id()){
			$userID = get_current_user_id();
		}
		
		$post = array(
		  'post_status'           => 'publish', 
		  'post_type'             => 'stern_taxi_car_type',
		  'post_author'           => $userID,
		  'ping_status'           => get_option('default_ping_status'), 
		  'post_parent'           => 0,
		  'menu_order'            => 0,
		  'to_ping'               =>  '',
		  'pinged'                => '',
		  'post_password'         => '',
		  'guid'                  => '',
		  'post_content_filtered' => '',
		  'post_excerpt'          => '',
		  'import_id'             => 0
		);			
		if($this->id != null){ $post['ID'] = $this->id ; }

		$post_id = wp_insert_post( $post );	
		update_post_meta($post_id , '_stern_taxi_car_type_cartype' , $this->carType);	
		update_post_meta($post_id , '_stern_taxi_car_type_carfare' , $this->carFare);
		update_post_meta($post_id , '_stern_taxi_car_type_carseat' , $this->carSeat);
		update_post_meta($post_id , '_stern_taxi_car_type_suitcases' , $this->suitcases);
		update_post_meta($post_id , '_stern_taxi_car_type_organizedBy' , $this->organizedBy);		
		update_post_meta($post_id , '_stern_taxi_car_type_farePerDistance' , $this->farePerDistance);
		update_post_meta($post_id , '_stern_taxi_car_type_farePerMinute' , $this->farePerMinute);
		update_post_meta($post_id , '_stern_taxi_car_type_farePerSeat' , $this->farePerSeat);
		update_post_meta($post_id , '_stern_taxi_car_type_farePerToll' , $this->farePerToll);
		return $post_id;		
		
	
	}

			
			
	
	function delete() {
		if($this->id != null){
			wp_delete_post($this->id,true);
		}		
	}
	

	
}
	