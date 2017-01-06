<?php
function baked_customize_register( $wp_customize ) {
	$wp_customize->get_section('title_tagline')->title = __('Site Name and Description', 'bakedwp');  
	$wp_customize->get_control('blogname')->label = __('Site Name', 'bakedwp');  
	$wp_customize->get_control('blogdescription')->label = __('Site Description', 'bakedwp');
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	 $wp_customize->add_section('bakedwp_color_options', array(
        'title'    => __('Color Options', 'bakedwp'),
        'description' => '',
        'priority' => 120,
    ));
    
    $wp_customize->add_section('bakedwp_footer_options', array(
        'title'    => __('Footer Options', 'bakedwp'),
        'description' => '',
        'priority' => 120,
    ));
 
    $wp_customize->add_setting('hero_bg_color', array(
        'default'           => '#008c9e',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'hero_bg_color', array(
        'label'    => __('Hero BG Color', 'bakedwp'),
        'section'  => 'bakedwp_color_options',
        'settings' => 'hero_bg_color',
    )));
    
    $wp_customize->add_setting('link_color', array(
        'default'           => '#008c9e',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
 
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'link_color', array(
        'label'    => __('Link Color', 'bakedwp'),
        'section'  => 'bakedwp_color_options',
        'settings' => 'link_color',
    )));
    
    $wp_customize->add_setting('footer_text', array(
        'default'           => __('BakedWP Theme. Built with <a href="http://jointswp.com>JointsWP</a>.', 'bakedwp'),
        'sanitize_callback' => 'baked_sanitize_text'
    ));
    
    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'footer_text', array(
            'label'          => __( 'Footer Text', 'bakedwp' ),
            'section'        => 'bakedwp_footer_options',
            'settings'       => 'footer_text',
            'type'           => 'text'
    ))); 
}
add_action( 'customize_register', 'baked_customize_register' );

function baked_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function baked_customize_preview_js() {
	wp_enqueue_script( 'baked_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'baked_customize_preview_js' );

function baked_customize_css() {
    ?>
         <style type="text/css">
             .hero { background:<?php echo esc_html(get_theme_mod('hero_bg_color')); ?>; }
             a { color:<?php echo esc_html(get_theme_mod('link_color')); ?>; }
         </style>
    <?php
}
add_action( 'wp_head', 'baked_customize_css');