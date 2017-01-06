<?php
function showTypeCar($class_full_row,$class) {

			$args = array(
				'post_type' => 'stern_taxi_car_type',
				'nopaging' => true,
				'order'     => 'ASC',
				'orderby' => 'meta_value',
				'meta_key' => '_stern_taxi_car_type_organizedBy'
			);
			$allTypeCars = get_posts( $args );	


			if (getShow_dropdown_typecar()=='false') {
				$visibility = "visibility: hidden;";
			} else {
				$visibility = "";
			}
	
			?>

			<div id="typeCarsDropDown" <?php echo $class_full_row; ?> style="padding-top: 15px;<?php echo $visibility ?>">				
				<?php if (showlabel()) : ?>
					<label for="cartypes"><?php _e('Car Type', 'stern_taxi_fare'); ?></label>
				<?php endif; ?>

				
				<select name="cartypes" id="cartypes" class="<?php echo $class; ?>" data-width="100%" style="padding-left: 15px; float: right;">
					<optgroup id="cartypesOptGroup" label="Type">
						<?php foreach ( $allTypeCars as $post ) : setup_postdata( $post ); ?>
							<?php $postId[] = $post->ID; ?>
							<option data-icon="glyphicon-road" value="<?php echo $post->ID; ?>">
								<?php echo get_post_meta($post->ID,'_stern_taxi_car_type_cartype',true); ?>
							</option>
							
						<?php endforeach; ?>
					</optgroup>
				</select>

			</div>


<?php
	
}										