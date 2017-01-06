<?php

// Fire all our initial functions at the start
add_action('after_setup_theme','joints_start', 16);

function joints_start() {

    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'joints_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'joints_remove_recent_comments_style', 1);
    // clean up gallery output in wp
    add_filter('gallery_style', 'joints_gallery_style');

    // launching this stuff after theme setup
    joints_theme_support();

    add_action( 'widgets_init', 'joints_register_sidebars' );
    add_filter('excerpt_more', 'joints_excerpt_more');

} /* end joints start */

// Remove injected CSS for recent comments widget
function joints_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// Remove Read More jump
function remove_more_tag_link_jump($link) {
    $offset = strpos($link, '#more-'); //Locate the jump portion of the link
    if ($offset) { //If we found the jump portion of the link
        $end = strpos($link, '"', $offset); //Locate the end of the jump portion
    }
    if ($end) { //If we found the end of the jump portion
        $link = substr_replace($link, '', $offset, $end-$offset); //Remove the jump portion
    }
    return $link; //Return the link without jump portion or just the normal link if we didn't find a jump portion
}

add_filter('the_content_more_link', 'remove_more_tag_link_jump'); //Add our function to the more link filter

// Remove injected CSS from recent comments widget
function joints_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// Remove injected CSS from gallery
function joints_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

// This removes the annoying […] to a Read More link
function joints_excerpt_more($more) {
	global $post;
	// edit here if you like
return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'bakedwp') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'bakedwp') .'</a>';
}

//This is a modified the_author_posts_link() which just returns the link. This is necessary to allow usage of the usual l10n process with printf()
function joints_get_the_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s', 'bakedwp' ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

add_action('wp_head', 'admin_bar_fix', 5);

// Fixes admin bar issues with the Foundation Top Bar
function admin_bar_fix() {
  if( !is_admin() && is_admin_bar_showing() ) {
    remove_action( 'wp_head', '_admin_bar_bump_cb' );
    $output  = '<style type="text/css">'."\n\t";
    //$output .= 'body.admin-bar { padding-top: 28px; }'."\n";
    $output .= 'body.admin-bar .top-bar { margin-top: 28px; }'."\n";
    $output .= '</style>'."\n";
    echo $output;
  }
}

?>
