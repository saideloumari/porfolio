<?php

if ( ! defined( 'ABSPATH' ) )
	exit;


Class templateRule{
	function __construct(){	
		?>
			
			<div class="wrap"><div id="icon-tools" class="icon32"></div>
				<h2><?php _e('Pricing Rules', 'stern_taxi_fare'); ?></h2>
			</div>
			
			<form name="SettingsPricingRules" method="post">
				<table name="TableSettingsPricingRules">
					<tr>
						<td><?php _e('Include Seat Fare in pricing rules', 'stern_taxi_fare'); ?></td>						
						<td>						
							<select name="stern_taxi_Include_SeatFare_in_pricing_rules" style="width:300px;">								
								<option  value='' 		<?php echo ((get_option('stern_taxi_Include_SeatFare_in_pricing_rules')=='') 		? "selected" : "");	?>></option>
								<option  value='true' 	<?php echo ((get_option('stern_taxi_Include_SeatFare_in_pricing_rules')=='true')	? "selected" : "");	?>>true</option>
								<option  value='false'	<?php echo ((get_option('stern_taxi_Include_SeatFare_in_pricing_rules')=='false')	? "selected" : "");	?>>false</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td><input type="submit" id="SettingsPricingRulesSubmit" value="Save Changes" class="button-primary" name="SettingsPricingRulesSubmit" style="width:150px;"/></td>
						<td></td>
					</tr>					
					
				</table>
			</form>

			
			<div class="wrap"><div id="icon-tools" class="icon32"></div>
				<h2>Warning!</h2> Google map APIs is free, but you have a limitaion. We advie to use a maximum 4 rules for the Free maps API. See details here : <a href="https://developers.google.com/maps/documentation/business/faq#usage_limits">Usage limits for the Google Maps API</a>.
			</div>
			
			
			
		<?php
			$args = array(
			'post_type' => 'stern_taxi_rule',
			'posts_per_page' => 200,
			);

			$allRules = get_posts( $args );				
			
		?>
			<br>
			<?php echo count($allRules)." rules"; ?>
			<br>
			<form method="post">
				<table class="displayrecord">
					<thead  align="left">
						<tr class="home">
							<th>Id</th>
							<th>Is Active</th>
							<th>Name Rule</th>
							<th>Type source</th>
							<th>Type source value</th>
							<th>Source City</th>
							<th>Type Destination</th>
							<th>Type Destination Value</th>
							<th>Destination City</th>
							<th>Type Car</th>
							<th>Price for this rule</th>							
							<th><input type="checkbox" name="checkboxALL" id="checkboxALL" />Delete</th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ( $allRules as $post ) : setup_postdata( $post );
					$oRule = new rule($post->ID);
					?>
					
						<tr>
							<td><?php echo $oRule->getid() ?></td>
							<td>
								<?php 
									if ($oRule->getisActive() =="true") { $checked = "checked";	} else {$checked = "";}
								?>
								<input type="checkbox" name="isActive<?php echo $post->ID; ?>" value="true" <?php echo $checked; ?>>
								
								
							</td>
							<td><?php echo $oRule->getnameRule(); ?></td>
							<td><?php echo $oRule->gettypeSource(); ?></td>
							<td><?php echo $oRule->gettypeSourceValue(); ?></td>
							<td><?php echo $oRule->getsourceCity(); ?></td>
							<td><?php echo $oRule->gettypeDestination(); ?></td>
							<td><?php echo $oRule->gettypeDestinationValue(); ?></td>
							<td><?php echo $oRule->getdestinationCity(); ?></td>
							<?php 
								$otypeCar = new typeCar($oRule->gettypeIdCar() ); 
								if($otypeCar->getcarType()=="") { $typeCar = "All";} else { $typeCar = $otypeCar->getcarType();}
							?>
							<td><?php echo $typeCar; ?> (<?php echo $oRule->gettypeIdCar(); ?>)</td>					
							<td><?php echo $oRule->getprice(); ?></td>							
							<td><input type="checkbox" name="remove<?php echo $post->ID; ?>" value="yes"></td>
						</tr>
					   
					<?php endforeach; ?>
					<?php wp_reset_postdata(); ?>	
						<tr>
							<td></td>
							<td>							
								<select name="isActive" >
									<option value="true" >true</option>
									<option value="false" >false</option>					
								</select>
							</td>
							
							<td><input type="text" name="nameRule"></td>
							
							<td>
								<select name="typeSource" >
									<option value="address" >address</option>
									<option value="city" >city</option>
									<option value="all" >all</option>
								</select>							
							</td>
							<td><input type="text" id="typeSourceValue" name="typeSourceValue"></td>
							<td></td>
							
							<td>
								<select name="typeDestination" >
									<option value="address" >address</option>
									<option value="city" >city</option>									
									<option value="all" >all</option>
								</select>								
							</td>
							<td><input type="text" id="typeDestinationValue" name="typeDestinationValue"></td>
							<td></td>
							<?php 
								$args = array(
								'post_type' => 'stern_taxi_car_type',
								'posts_per_page' => 200,
								);

								$allPosts = get_posts( $args );
							?>			
					

							<td>
								<select name="typeIdCar" >
									<option value="" >All</option>
									<?php foreach ( $allPosts as $post ) : setup_postdata( $post ); ?>
									<?php $otypeCar = new typeCar($post->ID); ?>																	
										<option value="<?php echo $otypeCar->getid(); ?>" ><?php echo $otypeCar->getcarType(); ?></option>
									<?php endforeach; ?>
								</select>								
							</td>							
							
							<td><input type="number" step="0.1" name="price"></td>
							<td><input type="submit" id="ruleSubmit" value="Go" class="button-primary" name="ruleSubmit" /></td>
						</tr>
						<input type="hidden"  name="countryHidden" id="countryHidden" value="<?php echo get_option('stern_taxi_fare_country'); ?>"/>
					</tbody>
				</table>
				<br>
				<br/>
				
				<h4><?php _e('Bulk upload', 'stern_taxi_fare'); ?><?php showHelp("http://stern-taxi-fare.sternwebagency.com/docs/set-pricing-rules-in-bulk/","Set Pricing rules in bulk"); ?></h4>
				
				<br>
				<?php _e('Use tab to split each colums. 1 rule per row.', 'stern_taxi_fare'); ?>
				<br>
				<?php _e('Example:', 'stern_taxi_fare'); ?>
				<br>
				<input type="text" size="100%" readonly value="true	lille-marseille	city	Lille, France	city	Marseille, France	All	99">
				<?php _e('Price is 99 for all Type Cars', 'stern_taxi_fare'); ?>
				<br>
				<input type="text" size="100%" readonly value="true	SF-LA	city	San Francisco, CA, United States	address	Los Angeles, CA, United States	131	399">
				<?php _e('Price is 399 for all typeCarID = 131', 'stern_taxi_fare'); ?>
				
				<br>
				<textarea cols="100%" rows="5" name="bulkPricingRules" id="bulkPricingRules"></textarea><br/>
				<input type="submit" id="bulkPricingRulesSubmit" value="Go" class="button-primary" name="bulkPricingRulesSubmit" />
				
			</form>
		<?php
	}
}