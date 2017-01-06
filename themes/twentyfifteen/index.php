<?php get_header(); ?>
<section id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<!-- <?php get_template_part( 'entry' ); ?> -->
<!-- <?php comments_template(); ?> -->
<?php endwhile; endif; ?>
<?php get_template_part( 'nav', 'below' ); ?>


<?php get_sidebar(); ?>
<article id="slider">
	<h1>slider</h1>
	
	<!-- slider -->
		

	<!--  -->
</article>
<article id="langue">
	<h1>languages</h1>
	<div>
		<img src="http://a183431562.testurl.ws/wp-content/uploads/2016/09/css3.png">
		<img src="http://a183431562.testurl.ws/wp-content/uploads/2016/09/html5.png">
		<img src="http://a183431562.testurl.ws/wp-content/uploads/2016/09/javascript.png">
	</div>
</article>
<article id="present">
	<h1>presentation</h1>
	<ul>
		<li>css/html</li>
		<li>javascript/jquery</li>
		<li>php/mysql</li>
	</ul>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	
</article>
<article id="contact">
	<h1>contact</h1>
</article>
</section>
<?php get_footer(); ?>