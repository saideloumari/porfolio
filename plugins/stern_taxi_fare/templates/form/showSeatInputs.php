<?php
function showSeatInputs1($class_full_row,$class) {

			
	
			?>

			
			
			<div <?php echo $class_full_row; ?> style="padding-top: 15px;">

			
				<?php if (showlabel()) : ?>
					<label for="baby_count"><?php _e('Seats', 'stern_taxi_fare'); ?></label>
				<?php endif; ?>
				

				
				<select name="baby_count" id="baby_count" class="<?php echo $class; ?>" data-width="100%" style="padding-left: 15px; float: right;">
					<optgroup id="labelSeats" label="<?php _e('Seats', 'stern_taxi_fare'); ?>">
						<?php 
						
						
						
						for ($i = 1; $i <= getMaxCarSeatfromAllCarType() ; $i++) {
							echo "<option data-icon='glyphicon-user' value='".$i."'>  ".$i."</option>";
						}
						
						?>
						
					</optgroup>
				</select>										
			</div>
<?php
	
}										