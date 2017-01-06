<?php get_header(); ?>
			
			<div id="content">

				<div id="inner-content" class="row">
			
					<div id="main" class="large-8 medium-8 small-centered columns text-center" role="main">

						<article id="content-not-found">
						
							<header class="article-header">
								<h1><?php _e("Epic 404 - Article Not Found", "bakedwp"); ?></h1>
							</header> <!-- end article header -->
					
							<section class="entry-content">
								<p><?php _e("The article you were looking for was not found, but maybe try looking again!", "bakedwp"); ?></p>
							</section> <!-- end article section -->

							<section class="search">
							    <p><?php get_search_form(); ?></p>
							</section> <!-- end search section -->
					
						</article> <!-- end article -->
			
					</div> <!-- end #main -->

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>

