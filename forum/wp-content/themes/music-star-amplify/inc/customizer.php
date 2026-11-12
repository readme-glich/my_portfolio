<?php
/**
 * Customizer options added by Music Star Amplify.
 *
 * @package Music_Star_Amplify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add a setting and its control in one call.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 * @param string               $id           Setting / control ID.
 * @param string               $sanitize     Sanitize callback.
 * @param array                $control      Control arguments (or 'class' => control class name).
 */
function music_star_amplify_add( $wp_customize, $id, $sanitize, $control ) {
	$wp_customize->add_setting(
		$id,
		array(
			'default'           => music_star_amplify_get_default( $id ),
			'sanitize_callback' => $sanitize,
		)
	);

	if ( isset( $control['class'] ) ) {
		$class = $control['class'];
		unset( $control['class'] );
		$wp_customize->add_control( new $class( $wp_customize, $id, $control ) );
	} else {
		$wp_customize->add_control( $id, $control );
	}
}

/**
 * Default value of an option (including translatable texts).
 *
 * @param string $id Option name.
 * @return mixed
 */
function music_star_amplify_get_default( $id ) {
	$defaults = music_star_amplify_defaults();
	$default  = array_key_exists( $id, $defaults ) ? $defaults[ $id ] : '';
	return null === $default ? music_star_amplify_text_default( $id ) : $default;
}

/**
 * Register the "Amplify Options" panel, sections, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function music_star_amplify_customize_register( $wp_customize ) {
	$pages = array(
		'all'   => esc_html__( 'All pages', 'music-star-amplify' ),
		'front' => esc_html__( 'Front page only', 'music-star-amplify' ),
	);

	$wp_customize->add_panel(
		'music_star_amplify_panel',
		array(
			'title'       => esc_html__( 'Amplify Options', 'music-star-amplify' ),
			'description' => esc_html__( 'Live Visualizer, Stage Lights, Release Countdown and News Ticker.', 'music-star-amplify' ),
			'priority'    => 2,
		)
	);

	/*
	 * Section: Live Visualizer.
	 */
	$wp_customize->add_section(
		'music_star_amplify_viz',
		array(
			'title'       => esc_html__( 'Live Visualizer', 'music-star-amplify' ),
			'description' => esc_html__( 'Animated bars or a wave that move with the real music when a visitor plays an audio file of your site (for example an Audio block in a post). Audio files from other websites cannot be analysed by the browser; for them the visualizer plays a soft animation instead.', 'music-star-amplify' ),
			'panel'       => 'music_star_amplify_panel',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_viz_enable',
		'music_star_amplify_sanitize_checkbox',
		array(
			'label'   => esc_html__( 'Show the Live Visualizer', 'music-star-amplify' ),
			'section' => 'music_star_amplify_viz',
			'type'    => 'checkbox',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_viz_style',
		'music_star_amplify_sanitize_select',
		array(
			'label'           => esc_html__( 'Style', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_viz',
			'type'            => 'select',
			'choices'         => array(
				'bars'   => esc_html__( 'Bars', 'music-star-amplify' ),
				'mirror' => esc_html__( 'Mirrored bars', 'music-star-amplify' ),
				'wave'   => esc_html__( 'Wave line', 'music-star-amplify' ),
			),
			'active_callback' => 'music_star_amplify_is_viz',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_viz_position',
		'music_star_amplify_sanitize_select',
		array(
			'label'           => esc_html__( 'Position', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_viz',
			'type'            => 'radio',
			'choices'         => array(
				'header' => esc_html__( 'Under the header', 'music-star-amplify' ),
				'bottom' => esc_html__( 'Fixed at the bottom of the screen while music plays', 'music-star-amplify' ),
			),
			'active_callback' => 'music_star_amplify_is_viz',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_viz_height',
		'music_star_amplify_sanitize_height',
		array(
			'label'           => esc_html__( 'Height (px)', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_viz',
			'type'            => 'range',
			'input_attrs'     => array(
				'min'  => 40,
				'max'  => 200,
				'step' => 5,
			),
			'active_callback' => 'music_star_amplify_is_viz',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_viz_idle',
		'music_star_amplify_sanitize_checkbox',
		array(
			'label'           => esc_html__( 'Soft animation while no music plays', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_viz',
			'type'            => 'checkbox',
			'active_callback' => 'music_star_amplify_is_viz',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_viz_display',
		'music_star_amplify_sanitize_select',
		array(
			'label'           => esc_html__( 'Show the Visualizer On', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_viz',
			'type'            => 'radio',
			'choices'         => $pages,
			'active_callback' => 'music_star_amplify_is_viz',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_color_1',
		'sanitize_hex_color',
		array(
			'class'       => 'WP_Customize_Color_Control',
			'label'       => esc_html__( 'Color 1', 'music-star-amplify' ),
			'description' => esc_html__( 'Colors 1 and 2 are used by the visualizer, the countdown and the ticker.', 'music-star-amplify' ),
			'section'     => 'music_star_amplify_viz',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_color_2',
		'sanitize_hex_color',
		array(
			'class'   => 'WP_Customize_Color_Control',
			'label'   => esc_html__( 'Color 2', 'music-star-amplify' ),
			'section' => 'music_star_amplify_viz',
		)
	);

	/*
	 * Section: Stage Lights.
	 */
	$wp_customize->add_section(
		'music_star_amplify_lights',
		array(
			'title'       => esc_html__( 'Stage Lights', 'music-star-amplify' ),
			'description' => esc_html__( 'A spotlight that follows the mouse over the header image.', 'music-star-amplify' ),
			'panel'       => 'music_star_amplify_panel',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_spotlight',
		'music_star_amplify_sanitize_checkbox',
		array(
			'label'       => esc_html__( 'Spotlight on the header image', 'music-star-amplify' ),
			'description' => esc_html__( 'On touch screens the spotlight moves slowly by itself.', 'music-star-amplify' ),
			'section'     => 'music_star_amplify_lights',
			'type'        => 'checkbox',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_spotlight_size',
		'music_star_amplify_sanitize_spotlight',
		array(
			'label'           => esc_html__( 'Spotlight Size (px)', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_lights',
			'type'            => 'range',
			'input_attrs'     => array(
				'min'  => 120,
				'max'  => 500,
				'step' => 10,
			),
			'active_callback' => 'music_star_amplify_is_spotlight',
		)
	);

	/*
	 * Section: Release Countdown.
	 */
	$wp_customize->add_section(
		'music_star_amplify_countdown',
		array(
			'title'       => esc_html__( 'Release Countdown', 'music-star-amplify' ),
			'description' => esc_html__( 'A live countdown to a new album, single or concert. The time zone of the site is used (Settings > General).', 'music-star-amplify' ),
			'panel'       => 'music_star_amplify_panel',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_cd_enable',
		'music_star_amplify_sanitize_checkbox',
		array(
			'label'   => esc_html__( 'Show the Release Countdown', 'music-star-amplify' ),
			'section' => 'music_star_amplify_countdown',
			'type'    => 'checkbox',
		)
	);

	$countdown_fields = array(
		'music_star_amplify_cd_title'  => array( 'sanitize_text_field', esc_html__( 'Title', 'music-star-amplify' ), 'text' ),
		'music_star_amplify_cd_date'   => array( 'music_star_amplify_sanitize_date', esc_html__( 'Date', 'music-star-amplify' ), 'date' ),
		'music_star_amplify_cd_time'   => array( 'music_star_amplify_sanitize_time', esc_html__( 'Time', 'music-star-amplify' ), 'time' ),
		'music_star_amplify_cd_button' => array( 'sanitize_text_field', esc_html__( 'Button Text', 'music-star-amplify' ), 'text' ),
		'music_star_amplify_cd_url'    => array( 'esc_url_raw', esc_html__( 'Button URL', 'music-star-amplify' ), 'url' ),
		'music_star_amplify_cd_done'   => array( 'sanitize_text_field', esc_html__( 'Text When the Time Is Up', 'music-star-amplify' ), 'text' ),
	);
	foreach ( $countdown_fields as $id => $field ) {
		music_star_amplify_add(
			$wp_customize,
			$id,
			$field[0],
			array(
				'label'           => $field[1],
				'section'         => 'music_star_amplify_countdown',
				'type'            => $field[2],
				'active_callback' => 'music_star_amplify_is_countdown',
			)
		);
	}

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_cd_position',
		'music_star_amplify_sanitize_select',
		array(
			'label'           => esc_html__( 'Position', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_countdown',
			'type'            => 'radio',
			'choices'         => array(
				'top'   => esc_html__( 'Bar at the top of the page', 'music-star-amplify' ),
				'under' => esc_html__( 'Under the header', 'music-star-amplify' ),
			),
			'active_callback' => 'music_star_amplify_is_countdown',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_cd_display',
		'music_star_amplify_sanitize_select',
		array(
			'label'           => esc_html__( 'Show the Countdown On', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_countdown',
			'type'            => 'radio',
			'choices'         => $pages,
			'active_callback' => 'music_star_amplify_is_countdown',
		)
	);

	/*
	 * Section: News Ticker.
	 */
	$wp_customize->add_section(
		'music_star_amplify_ticker',
		array(
			'title'       => esc_html__( 'News Ticker', 'music-star-amplify' ),
			'description' => esc_html__( 'A scrolling line with the titles of your latest posts. It stops when the mouse is over it.', 'music-star-amplify' ),
			'panel'       => 'music_star_amplify_panel',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_ticker_enable',
		'music_star_amplify_sanitize_checkbox',
		array(
			'label'   => esc_html__( 'Show the News Ticker', 'music-star-amplify' ),
			'section' => 'music_star_amplify_ticker',
			'type'    => 'checkbox',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_ticker_label',
		'sanitize_text_field',
		array(
			'label'           => esc_html__( 'Label', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_ticker',
			'type'            => 'text',
			'active_callback' => 'music_star_amplify_is_ticker',
		)
	);

	$categories = array( 0 => esc_html__( 'All categories', 'music-star-amplify' ) );
	foreach ( get_categories( array( 'hide_empty' => false ) ) as $category ) {
		$categories[ $category->term_id ] = $category->name;
	}
	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_ticker_category',
		'music_star_amplify_sanitize_category',
		array(
			'label'           => esc_html__( 'Category', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_ticker',
			'type'            => 'select',
			'choices'         => $categories,
			'active_callback' => 'music_star_amplify_is_ticker',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_ticker_number',
		'music_star_amplify_sanitize_number',
		array(
			'label'           => esc_html__( 'Number of Posts', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_ticker',
			'type'            => 'number',
			'input_attrs'     => array(
				'min'  => 3,
				'max'  => 12,
				'step' => 1,
			),
			'active_callback' => 'music_star_amplify_is_ticker',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_ticker_speed',
		'music_star_amplify_sanitize_select',
		array(
			'label'           => esc_html__( 'Speed', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_ticker',
			'type'            => 'radio',
			'choices'         => array(
				'slow'   => esc_html__( 'Slow', 'music-star-amplify' ),
				'normal' => esc_html__( 'Normal', 'music-star-amplify' ),
				'fast'   => esc_html__( 'Fast', 'music-star-amplify' ),
			),
			'active_callback' => 'music_star_amplify_is_ticker',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_ticker_position',
		'music_star_amplify_sanitize_select',
		array(
			'label'           => esc_html__( 'Position', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_ticker',
			'type'            => 'radio',
			'choices'         => array(
				'top'   => esc_html__( 'Bar at the top of the page', 'music-star-amplify' ),
				'under' => esc_html__( 'Under the header', 'music-star-amplify' ),
			),
			'active_callback' => 'music_star_amplify_is_ticker',
		)
	);

	music_star_amplify_add(
		$wp_customize,
		'music_star_amplify_ticker_display',
		'music_star_amplify_sanitize_select',
		array(
			'label'           => esc_html__( 'Show the Ticker On', 'music-star-amplify' ),
			'section'         => 'music_star_amplify_ticker',
			'type'            => 'radio',
			'choices'         => $pages,
			'active_callback' => 'music_star_amplify_is_ticker',
		)
	);
}
add_action( 'customize_register', 'music_star_amplify_customize_register', 20 );

/**
 * Value of a setting in the Customizer (for active callbacks).
 *
 * @param WP_Customize_Control $control Control.
 * @param string               $id      Setting ID.
 * @return bool
 */
function music_star_amplify_setting_on( $control, $id ) {
	$setting = $control->manager->get_setting( $id );
	return $setting ? (bool) $setting->value() : false;
}

/**
 * Active callback: visualizer is on.
 *
 * @param WP_Customize_Control $control Control.
 * @return bool
 */
function music_star_amplify_is_viz( $control ) {
	return music_star_amplify_setting_on( $control, 'music_star_amplify_viz_enable' );
}

/**
 * Active callback: spotlight is on.
 *
 * @param WP_Customize_Control $control Control.
 * @return bool
 */
function music_star_amplify_is_spotlight( $control ) {
	return music_star_amplify_setting_on( $control, 'music_star_amplify_spotlight' );
}

/**
 * Active callback: countdown is on.
 *
 * @param WP_Customize_Control $control Control.
 * @return bool
 */
function music_star_amplify_is_countdown( $control ) {
	return music_star_amplify_setting_on( $control, 'music_star_amplify_cd_enable' );
}

/**
 * Active callback: ticker is on.
 *
 * @param WP_Customize_Control $control Control.
 * @return bool
 */
function music_star_amplify_is_ticker( $control ) {
	return music_star_amplify_setting_on( $control, 'music_star_amplify_ticker_enable' );
}
