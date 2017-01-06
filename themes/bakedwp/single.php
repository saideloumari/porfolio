<?php get_header(); ?>
			
			<div id="content">

				<div id="inner-content" class="row">
			
					<div id="main" class="large-10 medium-10 columns small-centered" role="main">
					
					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
					    	<?php get_template_part( 'parts/loop', 'single' ); ?>
					    	
					    <?php endwhile; else : ?>
					
					   		<?php get_template_part( 'parts/content', 'missing' ); ?>

					    <?php endif; ?>
			
					</div> <!-- end #main -->
    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>