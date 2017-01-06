<?php
function showDateTimeInput($class_full_row,$class) {


	
			?>

			<div <?php echo $class_full_row; ?> style="padding-top: 15px;">
				<?php if (showlabel()) : ?>
					<label for="setNowDateId"><?php _e('DateTime Picking', 'stern_taxi_fare'); ?></label>
				<?php endif; ?>												
				<div class="form-group">
					<div class='input-group date' id='datetimepickerDateNotCalendar'>
						<?php $tooltip = (get_option('stern_taxi_fare_show_tooltips') != "false") ? "data-toggle='tooltip' data-placement='bottom' data-original-title='". __('DateTime Picking', 'stern_taxi_fare')."';" : ""; ?>
						<div class="input-group-btn" <?php echo $tooltip; ?>>
							<button type="button"  id="setNowDateId" onClick="setNowDate()" class="btn btn-primary " style="font-size: 14px; font-weight: bold" >
								<span id="buttonDateTime" class="glyphicon glyphicon-time" aria-hidden="true"></span>
							</button>
						</div>
						<input type='text' class="form-control"id="dateTimePickUp" name="dateTimePickUp" />														
					</div>
				</div>
			</div>


<?php
	
}										