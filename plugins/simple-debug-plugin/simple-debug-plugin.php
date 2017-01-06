<?php
/**
 * @package simple_debug_plugin
 * @version 0.1
 */
/*
 * Plugin Name: Simple debug plugin
 * Plugin URI: http://www.lepoles.org
 * Description: Ce plugin affiche un menu info de débogage personnalisé dans la barre d'admin pour faciliter le débogage.
 * Version: 1.0
 * Author: Abdoulaye Diarra
 * Author URI:  http://www.lepoles.org
 * License: No fuckin licence
*/

if(!is_admin()){

	function define_current_theme_file( $template ) {
	 	$GLOBALS['current_theme_template'] = basename($template);
	 	return $template;
	}
	add_action('template_include', 'define_current_theme_file', 1000);

	/**
	 * This function will create a new node in the admin toolbar using $wp_admin_bar->add_node
	 * @return null
	 */
	function create_node_toolbar($wp_admin_bar) {
		global $wp_admin_bar;

		$debug_args = array(
	 		'id' => 'info_debogage',
	 		'title' => 'Info Debogage',
	 		'parent' => false
	 	);

		$current_file_args = array(
	 		'id' => 'current_file',
	 		'title' => 'Thème actuel: ' . $GLOBALS['current_theme_template'],
	 		'parent' => 'info_debogage'
	 	);

		$current_post_type = array(
	 		'id' => 'current_post_type',
	 		'title' => 'Type de poste actuel: ' . get_post_type(),
	 		'parent' => 'info_debogage'
	 	);

		$number_queries_args = array(
	 		'id' => 'num_queries',
	 		'title' => get_num_queries().' requêtes en '. timer_stop(0) .' secondes',
	 		'parent' => 'info_debogage'
	 	);

		$wp_admin_bar->add_node($debug_args);
	 	$wp_admin_bar->add_node($current_file_args);
	 	$wp_admin_bar->add_node($current_post_type);
	 	$wp_admin_bar->add_node($number_queries_args);
	}
	add_action( 'admin_bar_menu', 'create_node_toolbar', 999 );
}