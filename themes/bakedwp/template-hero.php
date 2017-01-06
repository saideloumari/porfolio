<?php
/*
Template Name: Hero
*/
?>

<?php get_header(); ?>

			<div class="hero">
				<div class="row">
					<div class="large-12 columns">
						<h1><?php the_title(); ?></h1>
					</div>
				</div>
			</div>		
				
			<div id="content">
			
				<div id="inner-content" class="row">
			
				    <div id="main" class="large-10 medium-10 small-centered columns" role="main">
					
					    	<?php get_template_part( 'parts/loop', 'page-hero' ); ?>
					    					
    				</div> <!-- end #main -->
    				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>