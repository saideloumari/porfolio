<?php get_header(); ?>
			
			<div id="content">

				<div id="inner-content" class="row">
			
					<div id="main" class="large-12 medium-12 columns first" role="main">
						<header class="page-header">
							<h1 class="archive-title text-center"><span><?php _e('Search Results for:', 'bakedwp'); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>
						</header>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					
							<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
								<header class="article-header">

									<h3 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
										<?php get_template_part( 'parts/content', 'byline' ); ?>
						
								</header> <!-- end article header -->
					
								<section class="entry-content">
									<?php the_content('<button class="tiny">' .__( 'Read more...', 'bakedwp') .'</button>'); ?> 
								</section> <!-- end article section -->
						
							</article> <!-- end article -->
					
						<?php endwhile; ?>	
					
						        <?php joints_page_navi(); ?>	
					
					    <?php else : ?>
					
    					    <article id="post-not-found" class="hentry clearfix">
    					    	<header class="article-header">
    					    		<h1><?php _e("Sorry, No Results.", "bakedwp"); ?></h1>
    					    	</header>
    					    	<section class="entry-content">
    					    		<p><?php _e("Try your search again.", "bakedwp"); ?></p>
    					    	</section>
    					    	<section class="search">
                                    <p><?php get_search_form(); ?></p>
                		        </section> <!-- end search section -->
    					    </article>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    			    			
    			</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>

