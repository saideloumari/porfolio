<?php
function joints_scripts_and_styles() {
  global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
    $theme_version = wp_get_theme()->Version;

    // Modernizr from bower_components
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/vendor/foundation/js//modernizr-min.js', array(), '2.8.3', true );
    
    // Adding Foundation scripts file in the footer
   wp_enqueue_script( 'foundation', get_template_directory_uri() . '/assets/vendor/foundation/js/foundation.min.js', array( 'jquery' ), '', true );
    
    // Adding scripts file in the footer
    wp_enqueue_script( 'bakedwo-site-js', get_template_directory_uri() . '/assets/js/scripts.js', array( 'jquery' ), '', true );
    
    // Register customized Foundation stylesheets, includes normalize
    wp_enqueue_style( 'foundation', get_template_directory_uri() . '/assets/css/foundation.css', array(), '', 'all' );
   
    // Register main stylesheet
    wp_enqueue_style( 'bakedwp-site-css', get_template_directory_uri() . '/style.css', array(), '', 'all' );
    
    // Comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }
}
add_action('wp_enqueue_scripts', 'joints_scripts_and_styles', 999);
?>