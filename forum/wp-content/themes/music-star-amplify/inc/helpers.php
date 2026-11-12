<?php
/**
 * Helper functions: defaults, option getter and sanitize callbacks.
 *
 * @package Music_Star_Amplify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default values for all child theme options.
 *
 * A null default means a translatable text (see music_star_amplify_text_default()).
 *
 * @return array
 */
function music_star_amplify_defaults() {
	return array(
		// Colors.
		'music_star_amplify_color_1'         => '#c36dff',
		'music_star_amplify_color_2'         => '#ff4f8b',
		// Live Visualizer.
		'music_star_amplify_viz_enable'      => true,
		'music_star_amplify_viz_style'       => 'bars',
		'music_star_amplify_viz_position'    => 'header',
		'music_star_amplify_viz_height'      => 90,
		'music_star_amplify_viz_idle'        => true,
		'music_star_amplify_viz_display'     => 'all',
		// Stage Lights.
		'music_star_amplify_spotlight'       => true,
		'music_star_amplify_spotlight_size'  => 260,
		// Release Countdown.
		'music_star_amplify_cd_enable'       => false,
		'music_star_amplify_cd_title'        => null,
		'music_star_amplify_cd_date'         => '',
		'music_star_amplify_cd_time'         => '20:00',
		'music_star_amplify_cd_button'       => null,
		'music_star_amplify_cd_url'          => '',
		'music_star_amplify_cd_done'         => null,
		'music_star_amplify_cd_position'     => 'under',
		'music_star_amplify_cd_display'      => 'all',
		// News Ticker.
		'music_star_amplify_ticker_enable'   => true,
		'music_star_amplify_ticker_label'    => null,
		'music_star_amplify_ticker_category' => 0,
		'music_star_amplify_ticker_number'   => 6,
		'music_star_amplify_ticker_speed'    => 'normal',
		'music_star_amplify_ticker_position' => 'top',
		'music_star_amplify_ticker_display'  => 'all',
	);
}

/**
 * Translatable default texts. Kept separate so the translations are only
 * requested when the text is rendered (after init).
 *
 * @param string $key Option name.
 * @return string
 */
function music_star_amplify_text_default( $key ) {
	switch ( $key ) {
		case 'music_star_amplify_cd_title':
			return __( 'New album in', 'music-star-amplify' );
		case 'music_star_amplify_cd_button':
			return __( 'Pre-save', 'music-star-amplify' );
		case 'music_star_amplify_cd_done':
			return __( 'Out now!', 'music-star-amplify' );
		case 'music_star_amplify_ticker_label':
			return __( 'Latest', 'music-star-amplify' );
	}
	return '';
}

/**
 * Get a theme mod with the child theme default.
 *
 * @param string $key Option name.
 * @return mixed
 */
function music_star_amplify_get( $key ) {
	$defaults = music_star_amplify_defaults();
	$default  = array_key_exists( $key, $defaults ) ? $defaults[ $key ] : null;
	if ( null === $default ) {
		$default = music_star_amplify_text_default( $key );
	}
	return get_theme_mod( $key, $default );
}

/**
 * Is a feature shown on the current page ("all" pages or "front" page only)?
 *
 * @param string $key Name of the display option.
 * @return bool
 */
function music_star_amplify_on_this_page( $key ) {
	return 'front' !== music_star_amplify_get( $key ) || is_front_page();
}

/**
 * Sanitize a checkbox.
 *
 * @param mixed $input Value.
 * @return bool
 */
function music_star_amplify_sanitize_checkbox( $input ) {
	return ( isset( $input ) && true == $input ); // phpcs:ignore Universal.Operators.StrictComparisons.LooseEqual
}

/**
 * Sanitize a select / radio value against the control choices.
 *
 * @param string               $input   Value.
 * @param WP_Customize_Setting $setting Setting object.
 * @return string
 */
function music_star_amplify_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$control = $setting->manager->get_control( $setting->id );
	$choices = $control ? $control->choices : array();
	return array_key_exists( $input, $choices ) ? $input : $setting->default;
}

/**
 * Sanitize the visualizer height (40 - 200 px).
 *
 * @param mixed $input Value.
 * @return int
 */
function music_star_amplify_sanitize_height( $input ) {
	$input = absint( $input );
	return max( 40, min( 200, $input ? $input : 90 ) );
}

/**
 * Sanitize the spotlight size (120 - 500 px).
 *
 * @param mixed $input Value.
 * @return int
 */
function music_star_amplify_sanitize_spotlight( $input ) {
	$input = absint( $input );
	return max( 120, min( 500, $input ? $input : 260 ) );
}

/**
 * Sanitize the number of ticker posts (3 - 12).
 *
 * @param mixed $input Value.
 * @return int
 */
function music_star_amplify_sanitize_number( $input ) {
	$input = absint( $input );
	return max( 3, min( 12, $input ? $input : 6 ) );
}

/**
 * Sanitize a category ID (0 = all categories).
 *
 * @param mixed $input Value.
 * @return int
 */
function music_star_amplify_sanitize_category( $input ) {
	$id = absint( $input );
	return ( $id && term_exists( $id, 'category' ) ) ? $id : 0;
}

/**
 * Sanitize a date in the Y-m-d format.
 *
 * @param string $input Value.
 * @return string
 */
function music_star_amplify_sanitize_date( $input ) {
	$input = sanitize_text_field( $input );
	if ( preg_match( '/^(\d{4})-(\d{2})-(\d{2})$/', $input, $m ) && checkdate( (int) $m[2], (int) $m[3], (int) $m[1] ) ) {
		return $input;
	}
	return '';
}

/**
 * Sanitize a time in the H:i format.
 *
 * @param string $input Value.
 * @return string
 */
function music_star_amplify_sanitize_time( $input ) {
	$input = sanitize_text_field( $input );
	if ( preg_match( '/^([01]\d|2[0-3]):([0-5]\d)$/', $input ) ) {
		return $input;
	}
	return '20:00';
}

/**
 * Countdown target as a UNIX timestamp, using the site time zone.
 *
 * @return int 0 when no valid date is set.
 */
function music_star_amplify_countdown_target() {
	$date = music_star_amplify_get( 'music_star_amplify_cd_date' );
	$time = music_star_amplify_get( 'music_star_amplify_cd_time' );
	if ( ! $date && music_star_amplify_countdown_demo() ) {
		// Demo on a fresh site: always one year ahead, so it never runs out.
		$date = wp_date( 'Y-m-d', time() + YEAR_IN_SECONDS );
	}
	if ( ! $date ) {
		return 0;
	}
	$dt = date_create_immutable( $date . ' ' . ( $time ? $time : '00:00' ) . ':00', wp_timezone() );
	return $dt ? $dt->getTimestamp() : 0;
}

/**
 * Show the countdown as a preview on a fresh installation?
 *
 * Only while WordPress marks the site as fresh (no content published and the
 * Customizer never saved) and the countdown options were never touched. The
 * first change of the site turns the preview off by itself.
 *
 * @return bool
 */
function music_star_amplify_countdown_demo() {
	return (bool) get_option( 'fresh_site' )
		&& null === get_theme_mod( 'music_star_amplify_cd_enable', null )
		&& '' === (string) get_theme_mod( 'music_star_amplify_cd_date', '' );
}
