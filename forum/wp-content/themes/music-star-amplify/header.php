<?php
/**
 * The header for the Music Star Amplify child theme.
 *
 * Same markup as the parent theme with two extra action hooks: one before the
 * site header (top bars) and one after it (countdown, visualizer, ticker).
 *
 * @package Music_Star_Amplify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!DOCTYPE html>
<html itemscope itemtype="https://schema.org/WebPage" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'music-star-amplify' ); ?></a>
<?php
/**
 * Fires before the site header (bars shown at the very top of the page).
 *
 * @hooked music_star_amplify_countdown_top - 10
 * @hooked music_star_amplify_ticker_top - 20
 */
do_action( 'music_star_amplify_before_header' );

music_star_header();

if ( is_front_page() && get_theme_mod( 'music_star_home_images_activate' ) ) {
	do_action( 'add_home_images_home' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- Hook of the parent theme.
}

/**
 * Fires after the site header, before the content wrapper.
 *
 * @hooked music_star_amplify_countdown_under - 10
 * @hooked music_star_amplify_visualizer - 20
 * @hooked music_star_amplify_ticker_under - 30
 */
do_action( 'music_star_amplify_after_header' );
?>
<div id="content" class="site-content">
