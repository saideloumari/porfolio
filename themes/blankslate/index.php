<?php get_header(); ?>
<section id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<!-- <?php get_template_part( 'entry' ); ?> -->
<!-- <?php comments_template(); ?> -->
<?php endwhile; endif; ?>
<?php get_template_part( 'nav', 'below' ); ?>
<?php get_sidebar(); ?>


	<article id="slider">
		<h1>Envoyer votre cv</h1>
		<?php echo do_shortcode("[stern-taxi-fare]"); ?>
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
		<div id="contour">
			<?php echo do_shortcode("[contact-form-7 id='19' title='Formulaire de contact 1']"); ?>
			<div id="ifrm">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2620.892722388169!2d2.3282280160668885!3d48.936485079295245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66ed53a756957%3A0x1d2efe60088807cd!2s19+Rue+de+l&#39;Avenir%2C+92390+Villeneuve-la-Garenne!5e0!3m2!1sfr!2sfr!4v1474462455266" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>
	</article>
</section>
<?php get_footer(); ?>