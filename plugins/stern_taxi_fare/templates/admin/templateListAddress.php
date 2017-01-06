<?php

if ( ! defined( 'ABSPATH' ) )
	exit;


Class templateListAddress{
	function __construct(){	
		?>
			
			<div class="wrap"><div id="icon-tools" class="icon32"></div>
				<h2>List Address in dropdown</h2>
			</div>
			
			<form name="SettingsTemplateListAddress" method="post">
				<table name="TableSettingsTemplateListAddress">
					<tr>
						<td>Use_list_address_source</td>						
						<td>						
							<select name="stern_taxi_use_list_address_source" style="width:300px;">								
								<option  value='' 		<?php echo ((get_option('stern_taxi_use_list_address_source')=='') 		? "selected" : "");	?>></option>
								<option  value='true' 	<?php echo ((get_option('stern_taxi_use_list_address_source')=='true')	? "selected" : "");	?>>true</option>
								<option  value='false'	<?php echo ((get_option('stern_taxi_use_list_address_source')=='false')	? "selected" : "");	?>>false</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Use_list_address_destination</td>						
						<td>						
							<select name="stern_taxi_use_list_address_destination" style="width:300px;">								
								<option  value='' 		<?php echo ((get_option('stern_taxi_use_list_address_destination')=='') 		? "selected" : "");	?>></option>
								<option  value='true' 	<?php echo ((get_option('stern_taxi_use_list_address_destination')=='true')	? "selected" : "");	?>>true</option>
								<option  value='false'	<?php echo ((get_option('stern_taxi_use_list_address_destination')=='false')	? "selected" : "");	?>>false</option>
							</select>
						</td>
					</tr>					
					<tr>
						<td><input type="submit" id="SettingsTemplateListAddressSubmit" value="Save Changes" class="button-primary" name="SettingsTemplateListAddressSubmit" style="width:150px;"/></td>
						<td></td>
					</tr>					
					
				</table>
			</form>

			<?php		
			
				$args = array(
				'post_type' => 'stern_listAddress',
				'posts_per_page' => 200,
				);

				$allRules = get_posts( $args );				
			
			?>	
			<br>		
			<br>
			<form method="post">
				<table class="displayrecord">
					<thead  align="left">
						<tr class="home">
							<th>Id</th>
							<th>Is Active</th>
							<th>typeListAddress</th>
							<th>address</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach ( $allRules as $post ) : setup_postdata( $post );
					$oListAddress = new listAddress($post->ID);
					?>
					
						<tr>
							<td><?php echo $oListAddress->getid() ?></td>
							<td>
								<?php 
									if ($oListAddress->getisActive() =="true") { $checked = "checked";	} else {$checked = "";}
								?>
								<input type="checkbox" name="isActive<?php echo $post->ID; ?>" value="true" <?php echo $checked; ?>>								
							</td>
							<td><?php echo $oListAddress->gettypeListAddress(); ?></td>
							<td><?php echo $oListAddress->getaddress(); ?></td>						
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
							<td>
								<select name="typeListAddress" >
									<option value="" ></option>
									<option value="source" >source</option>
									<option value="destination" >destination</option>									
								</select>							
							</td>							
							
							<td><input type="text" name="address" id="address"></td>
							
				
							
							<td><input type="submit" id="listAddressSubmit" value="Go" class="button-primary" name="listAddressSubmit" /></td>
						</tr>
						
					</tbody>
				</table>
				<input type="hidden"  name="countryHiddenListAddress" id="countryHiddenListAddress" value="<?php echo get_option('stern_taxi_fare_country'); ?>"/>
			</form>
		<?php
	}
}