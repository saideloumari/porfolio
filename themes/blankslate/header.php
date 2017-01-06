<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
<link href="https://fonts.googleapis.com/css?family=Baloo+Bhaina" rel="stylesheet">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
<header id="header" role="banner">
<section id="branding">
<!-- <div id="site-title"><?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '<h1>'; } ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a><?php if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '</h1>'; } ?></div> -->
<!-- <div id="site-description"><?php bloginfo( 'description' ); ?></div> -->
</section>
<nav id="menu" role="navigation">
<?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
</nav>
	<div id="portrait">
		<img src="http://a183431562.testurl.ws/wp-content/uploads/2016/09/said.jpg">
		<h2>Said El aoumari</h2>
		<p>Integrateur/Developper Web</p>
		<h3>Tag</h3>
		<ul>
			<li>CSS</li>
			<li>hTML</li>
			<li>JAVASCRIPT</li>
			<li>PHP</li>
			<li>MYSQL</li>
			<li>JQUERY</li>
			<li>BOOSTRAP</li>
			<li>LINUX</li>
			<li>PHOTOSHOP</li>
			<li>INDEESGN</li>
			<li>WOLRD</li>
		</ul>
	</div>
	<h3>Said El aoumari</h3>
	<ul>
		<li class="bleu"><a href="#slider">Slider</a></li>
		<li class="jaune"><a href="#langue">Langues</a></li>
		<li class="orange"><a href="#present">Presentation</a></li>
		<li class="bleu"><a href="#contact">Contact</a></li>
	</ul>
</header>
<div id="container">