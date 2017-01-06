<?php
// Register menus
register_nav_menus(
	array(
		'main-nav' => __( 'The Main Menu', 'bakedwp' ),   // Main nav in header
	)
);

// The Top Menu
function joints_top_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
        'container_class' => '',                        // Class of container
        'menu_class' => 'top-bar-menu right',           // Adding custom nav class
        'theme_location' => 'main-nav',                 // Where it's located in the theme
        'before' => '',                                 // Before each link <a>
        'after' => '',                                  // After each link </a>
        'link_before' => '',                            // Before each link text
        'link_after' => '',                             // After each link text
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => 'joints_fallback_menu',                         // Fallback function (see below)
        'walker' => new Top_Bar_Walker(),
    ));
} /* End Top Menu */

function joints_fallback_menu() {
	echo '<ul class="top-bar-menu right"><li><a href="'.esc_url(home_url()).'/wp-admin/nav-menus.php">'.__( 'ALERT: Please Set a Menu by Clicking Here', 'bakedwp' ).'</a></li></ul>';
}

?>
