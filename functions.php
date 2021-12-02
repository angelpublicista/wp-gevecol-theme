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


function gev_slick_assets_enqueue(){
	// Slick js
	wp_enqueue_script( 'gev-slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), '1.8.1');

	// Slick css
	wp_enqueue_style( 'gev-slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');

	// Slick theme css
	wp_enqueue_style( 'gev-slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css');
}

add_action( 'wp_enqueue_scripts', 'gev_slick_assets_enqueue');

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

require('inc/sc/sc-formacion.php');