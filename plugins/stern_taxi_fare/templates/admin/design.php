<?php

if ( ! defined( 'ABSPATH' ) )
	exit;

Class design{
	function __construct(){
		
		echo '<br><form name="SternSaveSettings" method="post"><table name="instfare">';
		 
				
				?>
				<tr><td><h2>Design</h2></td><td></td></tr>
				
				<tr>
					<td>
						<?php echo _e('Show calendar field as an input', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select id="stern_taxi_fare_typeCar_calendar_free" name="stern_taxi_fare_typeCar_calendar_free" style="width:300px;">
							<option <?php echo (get_option('stern_taxi_fare_typeCar_calendar_free') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
							<option <?php echo (get_option('stern_taxi_fare_typeCar_calendar_free') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
							<option <?php echo (get_option('stern_taxi_fare_typeCar_calendar_free') == "false" ? 	"selected"	 : 	""	); ?> value="false">false</option>
						</select>
						<?php echo _e('Choose if this field will appear on the top or below in form. This option will impact others fields like claendar', 'stern_taxi_fare'); ?>
					</td>
				</tr>			
				<tr>
					<td>
						<?php echo _e('Show seat field as an input', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select id="stern_taxi_fare_seat_field_as_input" name="stern_taxi_fare_seat_field_as_input" style="width:300px;">
							<option <?php echo (get_option('stern_taxi_fare_seat_field_as_input') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
							<option <?php echo (get_option('stern_taxi_fare_seat_field_as_input') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
							<option <?php echo (get_option('stern_taxi_fare_seat_field_as_input') == "false" ? 	"selected"	 : 	""	); ?> value="false">false</option>
						</select>
						<?php echo _e('Choose if this field will appear on the top or below in form. This option will impact others fields like claendar', 'stern_taxi_fare'); ?>
					</td>
				</tr>
				<tr>
					<td><?php _e('Show dropdown typecar in form', 'stern_taxi_fare'); ?></td>
					<td>
						<select name="stern_taxi_fare_show_dropdown_typecar" style="width:300px;">
						<?php
							if (get_option('stern_taxi_fare_show_dropdown_typecar')=='') {$selected ="selected";} else {$selected ="";}
							echo "<option  value='' ".$selected."></option>";
							if (get_option('stern_taxi_fare_show_dropdown_typecar')=='true') {$selected ="selected";} else {$selected ="";}
							echo "<option  value='true' ".$selected.">true</option>";
							if (get_option('stern_taxi_fare_show_dropdown_typecar')=='false') {$selected ="selected";} else {$selected ="";}
							echo "<option  value='false' ".$selected.">false</option>";
						?>
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<?php echo _e('Show calendar time & date side by side', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select id="stern_taxi_fare_calendar_sideBySide" name="stern_taxi_fare_calendar_sideBySide" style="width:300px;">
							<option <?php echo (get_option('stern_taxi_fare_calendar_sideBySide') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
							<option <?php echo (get_option('stern_taxi_fare_calendar_sideBySide') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
							<option <?php echo (get_option('stern_taxi_fare_calendar_sideBySide') == "false" ? 	"selected"	 : 	""	); ?> value="false">false</option>
						</select>
						
					</td>
				</tr>
				
				<tr>
					<td><?php _e('Hide labels in form', 'stern_taxi_fare'); ?></td>
					<td>
						<select name="stern_taxi_fare_show_labels" style="width:300px;">
							<?php if (get_option('stern_taxi_fare_show_labels')=='') {$selected ="selected";} else {$selected ="";} ?>
							<option  value='' <?php echo $selected; ?>></option>
							<?php if (get_option('stern_taxi_fare_show_labels')=='true') {$selected ="selected";} else {$selected ="";} ?>
							<option  value='true' <?php echo $selected; ?>>true</option>
							<?php if (get_option('stern_taxi_fare_show_labels')=='false') {$selected ="selected";} else {$selected ="";} ?>
							<option  value='false' <?php echo $selected; ?>>false</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						<?php echo _e('Show label in buttons', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select id="stern_taxi_fare_show_label_in_button" name="stern_taxi_fare_show_label_in_button" style="width:300px;">
							<option <?php echo (get_option('stern_taxi_fare_show_label_in_button') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
							<option <?php echo (get_option('stern_taxi_fare_show_label_in_button') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
							<option <?php echo (get_option('stern_taxi_fare_show_label_in_button') == "false" ? 	"selected"	 : 	""	); ?> value="false">false</option>
						</select>
						
					</td>
				</tr>
								
				
				
				
				<tr>
					<td><?php _e('Show Tooltips in form', 'stern_taxi_fare'); ?></td>
					<td>
						<select name="stern_taxi_fare_show_tooltips" style="width:300px;">
							<?php if (get_option('stern_taxi_fare_show_tooltips')=='') {$selected ="selected";} else {$selected ="";} ?>
							<option  value='' <?php echo $selected; ?>></option>
							<?php if (get_option('stern_taxi_fare_show_tooltips')=='true') {$selected ="selected";} else {$selected ="";} ?>
							<option  value='true' <?php echo $selected; ?>>true</option>
							<?php if (get_option('stern_taxi_fare_show_tooltips')=='false') {$selected ="selected";} else {$selected ="";} ?>
							<option  value='false' <?php echo $selected; ?>>false</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td><?php _e('Show Form in full row', 'stern_taxi_fare'); ?></td>
					<td>					
						<select id="stern_taxi_fare_form_full_row" name="stern_taxi_fare_form_full_row" style="width:300px;">
							<option <?php echo (get_option('stern_taxi_fare_form_full_row') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
							<option <?php echo (get_option('stern_taxi_fare_form_full_row') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
							<option <?php echo (get_option('stern_taxi_fare_form_full_row') == "false" ? 	"selected"	 : 	""	); ?> value="false">false</option>
						</select>					
						
					</td>
				</tr>		
				
				
				<tr>
					<td>
					<?php echo _e('Show inputs in full row', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select name="stern_taxi_fare_full_row" style="width:300px;">
							<?php if (get_option('stern_taxi_fare_full_row')=='') {$selected ="selected";} else {$selected ="";} ?>
							<option  value='' <?php echo $selected; ?>></option>
							<?php if (get_option('stern_taxi_fare_full_row')=='true') {$selected ="selected";} else {$selected ="";} ?>
							<option  value='true' <?php echo $selected; ?>>true</option>
							<?php if (get_option('stern_taxi_fare_full_row')=='false') {$selected ="selected";} else {$selected ="";} ?>
							<option  value='false' <?php echo $selected; ?>>false</option>
						</select>
					</td>
				</tr>				
				
				
				<tr>
					<td>
						<?php echo _e('Result', 'stern_taxi_fare'); ?>
					</td>
					<td>
					</td>
				</tr>
				
				<tr>
					<td>
						<?php echo _e('Show estimated in result', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select name="stern_taxi_fare_show_estimated_in_form" style="width:300px;">
							<?php if (get_option('stern_taxi_fare_show_estimated_in_form')=='') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="" <?php echo $selected; ?>></option>						
							<?php if (get_option('stern_taxi_fare_show_estimated_in_form')=='true') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="true" <?php echo $selected; ?>>true</option>
							<?php if (get_option('stern_taxi_fare_show_estimated_in_form')=='false') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="false" <?php echo $selected; ?>>false</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<?php echo _e('Show distance in result', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select name="stern_taxi_fare_show_distance_in_form" style="width:300px;">
							<?php if (get_option('stern_taxi_fare_show_distance_in_form')=='') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="" <?php echo $selected; ?>></option>						
							<?php if (get_option('stern_taxi_fare_show_distance_in_form')=='true') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="true" <?php echo $selected; ?>>true</option>
							<?php if (get_option('stern_taxi_fare_show_distance_in_form')=='false') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="false" <?php echo $selected; ?>>false</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<?php echo _e('Show duration in result', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select name="stern_taxi_fare_show_duration_in_form" style="width:300px;">
							<?php if (get_option('stern_taxi_fare_show_duration_in_form')=='') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="" <?php echo $selected; ?>></option>						
							<?php if (get_option('stern_taxi_fare_show_duration_in_form')=='true') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="true" <?php echo $selected; ?>>true</option>
							<?php if (get_option('stern_taxi_fare_show_duration_in_form')=='false') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="false" <?php echo $selected; ?>>false</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						<?php echo _e('Show Suitcases in result', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select name="stern_taxi_fare_show_suitcases_in_form" style="width:300px;">
							<?php if (get_option('stern_taxi_fare_show_suitcases_in_form')=='') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="" <?php echo $selected; ?>></option>						
							<?php if (get_option('stern_taxi_fare_show_suitcases_in_form')=='true') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="true" <?php echo $selected; ?>>true</option>
							<?php if (get_option('stern_taxi_fare_show_suitcases_in_form')=='false') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="false" <?php echo $selected; ?>>false</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>
						<?php echo _e('Show tolls in results', 'stern_taxi_fare'); ?>
					</td>
					<td>
						<select name="stern_taxi_fare_show_tolls_in_form" style="width:300px;">
							<?php if (get_option('stern_taxi_fare_show_tolls_in_form')=='') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="" <?php echo $selected; ?>></option>						
							<?php if (get_option('stern_taxi_fare_show_tolls_in_form')=='true') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="true" <?php echo $selected; ?>>true</option>
							<?php if (get_option('stern_taxi_fare_show_tolls_in_form')=='false') {$selected ="selected";} else {$selected ="";} ?>
							<option  value="false" <?php echo $selected; ?>>false</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				
				<tr>
					<td><?php _e('Use stern_taxi_fare_lib_bootstrap_js ', 'stern_taxi_fare'); ?></td>
					<td>					
						<select id="stern_taxi_fare_lib_bootstrap_js" name="stern_taxi_fare_lib_bootstrap_js" style="width:300px;">
							<option <?php echo (get_option('stern_taxi_fare_lib_bootstrap_js') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
							<option <?php echo (get_option('stern_taxi_fare_lib_bootstrap_js') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
							<option <?php echo (get_option('stern_taxi_fare_lib_bootstrap_js') == "false" ? "selected"	 : 	""	); ?> value="false">false</option>
						</select>					
						
					</td>
				</tr>
				<tr>
					<td><?php _e('Use stern_taxi_fare_lib_bootstrap_css ', 'stern_taxi_fare'); ?></td>
					<td>					
						<select id="stern_taxi_fare_lib_bootstrap_css" name="stern_taxi_fare_lib_bootstrap_css" style="width:300px;">
							<option <?php echo (get_option('stern_taxi_fare_lib_bootstrap_css') == "" ? 		"selected"	 : 	""	); ?> value=""></option>
							<option <?php echo (get_option('stern_taxi_fare_lib_bootstrap_css') == "true" ? 	"selected"	 : 	""	); ?> value="true">true</option>
							<option <?php echo (get_option('stern_taxi_fare_lib_bootstrap_css') == "false" ? "selected"	 : 	""	); ?> value="false">false</option>
						</select>					
						
					</td>
				</tr>
				
				
				
				
				<tr><td>Use Bootstrap-select</td><td>
				<select name="stern_taxi_fare_Bootstrap_select" style="width:300px;">
					<?php if (get_option('stern_taxi_fare_Bootstrap_select')=='') {$selected ="selected";} else {$selected ="";} ?>
					<option  value='' <?php echo $selected; ?>></option>				
					<?php if (get_option('stern_taxi_fare_Bootstrap_select')=='true') {$selected ="selected";} else {$selected ="";} ?>
					<option  value='true' <?php echo $selected; ?>>true</option>
					<?php if (get_option('stern_taxi_fare_Bootstrap_select')=='false') {$selected ="selected";} else {$selected ="";} ?>
					<option  value='false' <?php echo $selected; ?>>false</option>
				</select>See details here <a href="https://silviomoreto.github.io/bootstrap-select" target="_blank">here</a>.</td></tr>

				<tr>
					<td>Show Pets informations in checkout</td>						
					<td>						
						<select name="stern_taxi_use_pets" style="width:300px;">								
							<option  value='' 		<?php echo ((get_option('stern_taxi_use_pets')=='') 		? "selected" : "");	?>></option>
							<option  value='true' 	<?php echo ((get_option('stern_taxi_use_pets')=='true')		? "selected" : "");	?>>true</option>
							<option  value='false'	<?php echo ((get_option('stern_taxi_use_pets')=='false')	? "selected" : "");	?>>false</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>Show map in checkout</td>						
					<td>						
						<select name="stern_taxi_fare_show_map_checkout" style="width:300px;">								
							<option  value='' 		<?php echo ((get_option('stern_taxi_fare_show_map_checkout')=='') 		? "selected" : "");	?>></option>
							<option  value='true' 	<?php echo ((get_option('stern_taxi_fare_show_map_checkout')=='true')	? "selected" : "");	?>>true</option>
							<option  value='false'	<?php echo ((get_option('stern_taxi_fare_show_map_checkout')=='false')	? "selected" : "");	?>>false</option>
						</select>
					</td>
				</tr>

				<tr>
					<td>Show map in form</td>						
					<td>						
						<select name="stern_taxi_fare_show_map" style="width:300px;">								
							<option  value='' 		<?php echo ((get_option('stern_taxi_fare_show_map')=='') 		? "selected" : "");	?>></option>
							<option  value='true' 	<?php echo ((get_option('stern_taxi_fare_show_map')=='true')	? "selected" : "");	?>>true</option>
							<option  value='false'	<?php echo ((get_option('stern_taxi_fare_show_map')=='false')	? "selected" : "");	?>>false</option>
						</select>
					</td>
				</tr>				
					

		
				<tr>
					<td>Open map automatically</td>						
					<td>						
						<select name="stern_taxi_fare_auto_open_map" style="width:300px;">								
							<option  value='' 		<?php echo ((get_option('stern_taxi_fare_auto_open_map')=='') 		? "selected" : "");	?>></option>
							<option  value='true' 	<?php echo ((get_option('stern_taxi_fare_auto_open_map')=='true')	? "selected" : "");	?>>true</option>
							<option  value='false'	<?php echo ((get_option('stern_taxi_fare_auto_open_map')=='false')	? "selected" : "");	?>>false</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Empty cart before using form</td>						
					<td>						
						<select name="stern_taxi_fare_emptyCart" style="width:300px;">								
							<option  value='' 		<?php echo ((get_option('stern_taxi_fare_emptyCart')=='') 		? "selected" : "");	?>></option>
							<option  value='true' 	<?php echo ((get_option('stern_taxi_fare_emptyCart')=='true')	? "selected" : "");	?>>true</option>
							<option  value='false'	<?php echo ((get_option('stern_taxi_fare_emptyCart')=='false')	? "selected" : "");	?>>false</option>
						</select>
					</td>
				</tr>

				

				<tr>
					<td>Background color</td>
					<td><input value="<?php echo get_option('stern_taxi_fare_bcolor'); ?>" type="text" name="stern_taxi_fare_bcolor" style="width:300px;"> Example: #1ABC9C</td>
				</tr>
				<tr>
					<td>Background transparency</td>
					<td><input value="<?php echo get_option('stern_taxi_fare_bTransparency'); ?>" type="number" step="0.1" name="stern_taxi_fare_bTransparency" style="width:300px;"> Min 0, max 1. Example: 0.7</td>
				</tr>				
				
				
				<tr>
					<td>book button text</td>
					<td><input value="<?php echo get_option('stern_taxi_fare_book_button_text'); ?>" type="text" name="stern_taxi_fare_book_button_text" style="width:300px;"> Example: Book now</td>
				</tr>
				
				<tr>
					<td>Destination Button glyph</td>
					<td><input value="<?php echo get_option('stern_taxi_fare_Destination_Button_glyph'); ?>" type="text" name="stern_taxi_fare_Destination_Button_glyph" style="width:300px;"> Example "glyphicon-plane". See details <a href="http://getbootstrap.com/components/">Bootstrap components</a>.</td>
				</tr>
				
				
				
				<?php
				
								
				echo '<tr><td style="vertical-align:bottom">Url_gif_loader</td><td><input value="'.get_option('stern_taxi_fare_url_gif_loader').'" type="text" name="stern_taxi_fare_url_gif_loader" style="width:300px;"><img src="'. getUrlGifLoader().'" /></td></tr>';
				
				echo '<tr><td>Form template ID</td><td>';
				echo '<select name="stern_taxi_fare_formID" style="width:300px;">';
						for ($i = 1; $i <= 1; $i++) {
							if (get_option('stern_taxi_fare_formID')==$i) {$selected ="selected";} else {$selected ="";}
							echo "<option data-icon='glyphicon-user' value='".$i."' ".$selected.">  ".$i."</option>";
						}
				echo '</select></td></tr>';	

				echo '<tr><td></td><td>';
				//echo '<img src="'.plugins_url("img/", __FILE__).'/template'.get_option('stern_taxi_fare_formID').'.jpg" width="700px">';
				echo '</td></tr>';

				
                echo '<tr><td colspan="3"><input type="submit" id="faresubmit" value="Save Changes" class="button-primary" name="SternSaveSettings" style="margin-top:40px;width:300px;z-index:2147483647; padding: 0px;"/></td></tr>';
                
		
		echo '</table></form>';
		echo '<br>';
			
	}
}