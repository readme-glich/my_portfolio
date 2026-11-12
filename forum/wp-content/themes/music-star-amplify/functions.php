<?php
/**
 * Music Star Amplify functions and definitions.
 *
 * @package Music_Star_Amplify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'MUSIC_STAR_AMPLIFY_VERSION' ) ) {
	define( 'MUSIC_STAR_AMPLIFY_VERSION', '1.0.0' );
}

/**
 * Load the translations.
 */
function music_star_amplify_setup() {
	load_child_theme_textdomain( 'music-star-amplify', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'music_star_amplify_setup', 20 );

/**
 * Load the parent stylesheet before the parent theme loads the child style.css.
 *
 * The parent theme enqueues get_stylesheet_uri() (this child's style.css) on
 * priority 10, so the parent stylesheet is enqueued earlier on priority 5.
 */
function music_star_amplify_parent_style() {
	wp_enqueue_style(
		'music-star-amplify-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( get_template() )->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'music_star_amplify_parent_style', 5 );

/**
 * Child theme styles and scripts.
 */
function music_star_amplify_scripts() {
	// Replace the remote Google Font of the parent theme with a locally hosted copy of Raleway.
	wp_dequeue_style( 'music_star-Sans-font' );
	wp_enqueue_style(
		'music-star-amplify-font-raleway',
		get_stylesheet_directory_uri() . '/assets/fonts/raleway/font.css',
		array(),
		MUSIC_STAR_AMPLIFY_VERSION
	);

	wp_enqueue_style(
		'music-star-amplify-style',
		get_stylesheet_directory_uri() . '/assets/css/amplify.css',
		array( 'music-star-amplify-parent-style' ),
		MUSIC_STAR_AMPLIFY_VERSION
	);

	$color_1 = sanitize_hex_color( music_star_amplify_get( 'music_star_amplify_color_1' ) );
	$color_2 = sanitize_hex_color( music_star_amplify_get( 'music_star_amplify_color_2' ) );
	$css     = sprintf(
		':root{--msa-c1:%1$s;--msa-c2:%2$s;--msa-spot-size:%3$dpx;}',
		$color_1 ? $color_1 : '#c36dff',
		$color_2 ? $color_2 : '#ff4f8b',
		music_star_amplify_sanitize_spotlight( music_star_amplify_get( 'music_star_amplify_spotlight_size' ) )
	);
	wp_add_inline_style( 'music-star-amplify-style', $css );

	wp_enqueue_script(
		'music-star-amplify-script',
		get_stylesheet_directory_uri() . '/assets/js/amplify.js',
		array(),
		MUSIC_STAR_AMPLIFY_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'music_star_amplify_scripts', 20 );

/**
 * Includes.
 */
require_once get_stylesheet_directory() . '/inc/helpers.php';
require_once get_stylesheet_directory() . '/inc/customizer.php';
require_once get_stylesheet_directory() . '/inc/template-functions.php';
