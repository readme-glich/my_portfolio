<?php if( ! defined( 'ABSPATH' ) ) exit;
function music_star_ark_mode_customize_register( $wp_customize ) {
		$wp_customize->add_section( 'music_star_ark_mode_options' , array(
			'title'       => __( 'Theme Mode', 'music-star' ),
			'priority'   => 1,
		) );
		$wp_customize->add_setting( 'music_star_dark_mode', array (
		    'default' => false,
			'sanitize_callback' => 'music_star_sanitize_checkbox',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_dark_mode', array(
			'label'    => __( 'Deactivate Dark Mode', 'music-star' ),
			'section'  => 'music_star_ark_mode_options',
			'settings' => 'music_star_dark_mode',
			'type' => 'checkbox',
		) ) );
}
add_action( 'customize_register', 'music_star_ark_mode_customize_register' );
function music_star_dark_scripts() {	
	if ( !get_theme_mod('music_star_dark_mode') ) {
		wp_enqueue_style( 'music_star-dark-css', get_template_directory_uri() . '/css/dark.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'music_star_dark_scripts' );