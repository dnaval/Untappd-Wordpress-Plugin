<?php
/**
 * Theme Functions
 *
 * Contains custom theme setup, enqueues, and other functionalities.
 *
 * @package tbkinterview
 * @since 1.0.0
 */

/**
 * Enqueue styles for the theme.
 *
 * This function enqueues the parent and child theme stylesheets.
 *
 * @return void
 */
function my_theme_enqueue_styles() {
	wp_enqueue_style( 'main-style', get_stylesheet_uri() );
}
	add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/**
 * Register navigation menus for the theme.
 *
 * This function registers custom menu locations for use in the theme.
 *
 * @return void
 */
function my_theme_register_menus() {
	register_nav_menus(
		array(
			'main-menu' => 'Main Menu',
		)
	);
}
	add_action( 'init', 'my_theme_register_menus' );

/**
 * Enqueue scripts for the theme.
 *
 * This function adds custom scripts and stylesheets to the theme.
 *
 * @return void
 */
function my_theme_enqueue_scripts() {

	wp_enqueue_script(
		'custom-script',
		get_template_directory_uri() . '/js/script.js',
		array(),
		null,
		true
	);
}
	add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );
