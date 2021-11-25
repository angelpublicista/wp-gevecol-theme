<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementorChild
 */

/**
 * Load child theme css and optional scripts
 *
 * @return void
 */
function hello_elementor_child_enqueue_scripts() {
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[
			'hello-elementor-theme-style',
		],
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_scripts', 20 );

// Custom post types
require('inc/cpt/cpt-graphics.php');

// Custom taxonomies
require('inc/tax/tax-gev-pais.php');
require('inc/tax/tax-gev-sector.php');
require('inc/tax/tax-gev-subsector.php');
require('inc/tax/tax-gev-mes.php');
require('inc/tax/tax-gev-ano.php');

// Functions filters
require('inc/gev-filter-charts.php');
require('inc/gev-filter-ajax.php');