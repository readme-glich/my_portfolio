<?php if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Enqueue scripts and styles.
 */
function music_star_animations_scripts() {	
	wp_enqueue_style( 'music_star-aos-css', get_template_directory_uri() . '/include/animations/aos.css' );
	wp_enqueue_script( 'music_star-aos-js', get_template_directory_uri() . '/include/animations/aos.js', array(), '', true);
	wp_enqueue_script( 'music_star-aos-options-js', get_template_directory_uri() . '/include/animations/aos-options.js', array(), '', true);
}
add_action( 'wp_enqueue_scripts', 'music_star_animations_scripts' );

/**
 * Default article animation
 */
function  music_star_animation ($animation) {
	if ( get_theme_mod( $animation ) != "none" and get_theme_mod( $animation ) != ""  )  {
		return "data-aos-delay='300'"." ".
		"data-aos-duration='800'"." ".
		"data-aos='".esc_html ( get_theme_mod( $animation ) )."'";
	}
	if ( get_theme_mod( $animation  ) == "" ) {
		return "data-aos-delay='300'"." ".
		"data-aos-duration='800'"." ".
		"data-aos='fade-left'";		
	}
}

function music_star_animation_post_image () {
	$featured_image = esc_html(get_theme_mod("music_star_articles_featured_image") );
	if ( $featured_image != "" ) {
		return "data-aos-delay='300'"." ".
		"data-aos-duration='800'"." ".
		"data-aos='".$featured_image."'";		
	}
	else {
		return "data-aos-delay='300'"." ".
		"data-aos-duration='800'"." ".
		"data-aos='fade-right'";
	}	
}

function music_star_animations() {
	$array = array(
				'' => esc_attr__( 'Default', 'music-star' ),			
				'none' => esc_attr__( 'Deactivate Animation', 'music-star' ),			
				'fade' => esc_attr__( 'fade', 'music-star' ),
				'fade-up' => esc_attr__( 'fade-up', 'music-star' ),
				'fade-down' => esc_attr__( 'fade-down', 'music-star' ),
				'fade-left' => esc_attr__( 'fade-left', 'music-star' ),
				'fade-right' => esc_attr__( 'fade-right', 'music-star' ),
				'fade-up-right' => esc_attr__( 'fade-up-right', 'music-star' ),
				'fade-up-left' => esc_attr__( 'fade-up-left', 'music-star' ),
				'fade-down-right' => esc_attr__( 'fade-down-right', 'music-star' ),
				'fade-down-left' => esc_attr__( 'fade-down-left', 'music-star' ),
				'flip-up' => esc_attr__( 'flip-up', 'music-star' ),
				'flip-down' => esc_attr__( 'flip-down', 'music-star' ),
				'flip-left' => esc_attr__( 'flip-left', 'music-star' ),
				'flip-right' => esc_attr__( 'flip-right', 'music-star' ),
				'slide-up' => esc_attr__( 'slide-up', 'music-star' ),
				'slide-down' => esc_attr__( 'slide-down', 'music-star' ),
				'slide-left' => esc_attr__( 'slide-left', 'music-star' ),
				'slide-right' => esc_attr__( 'slide-right', 'music-star' ),
				'zoom-in' => esc_attr__( 'zoom-in', 'music-star' ),
				'zoom-in-up' => esc_attr__( 'zoom-in-up', 'music-star' ),
				'zoom-in-down' => esc_attr__( 'zoom-in-down', 'music-star' ),
				'zoom-in-left' => esc_attr__( 'zoom-in-left', 'music-star' ),
				'zoom-in-right' => esc_attr__( 'zoom-in-right', 'music-star' ),
				'zoom-out' => esc_attr__( 'zoom-out', 'music-star' ),
				'zoom-out-up' => esc_attr__( 'zoom-out-up', 'music-star' ),
				'zoom-out-down' => esc_attr__( 'zoom-out-down', 'music-star' ),
				'zoom-out-left' => esc_attr__( 'zoom-out-left', 'music-star' ),
				'zoom-out-right' => esc_attr__( 'zoom-out-right', 'music-star' ),
				);
	return $array;
}
function music_star_sanitize_animations( $input ) {
	$valid = music_star_animations();
	if ( array_key_exists( $input, $valid ) ) {
		return $input;
		} else {
			return '';
		}
	}

function music_star_animations_customize_register( $wp_customize ) {
 
		$wp_customize->add_panel( 'music_star_panel_animations' , array(
			'title'       => __( 'Animations', 'music-star' ),
			'priority'   => 7,
		) );

/************************************
* Animation Header Buttons
************************************/

		$wp_customize->add_section( 'music_star_animations_section_buttons' , array(
			'title'       => __( 'Animation Header Buttons', 'music-star' ),
			'panel'       => 'music_star_panel_animations',
			'priority'   => 64,
		) );
		
		$wp_customize->add_setting( 'music_star_button_1_animation', array (
			'default' => 'fade-right',
			'sanitize_callback' => 'music_star_sanitize_animations',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_button_1_animation', array(
			'label'    => __( 'Button 1', 'music-star' ),
			'section'  => 'music_star_animations_section_buttons',
			'settings' => 'music_star_button_1_animation',
			'type'     =>  'select',
            'choices'  => music_star_animations(),		
		) ) );
		
		
		$wp_customize->add_setting( 'music_star_button_2_animation', array (
		'default' => 'fade-left',
			'sanitize_callback' => 'music_star_sanitize_animations',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_button_2_animation', array(
			'label'    => __( 'Button 2', 'music-star' ),
			'section'  => 'music_star_animations_section_buttons',
			'settings' => 'music_star_button_2_animation',
			'type'     =>  'select',
            'choices'  => music_star_animations(),		
		) ) );
		
/************************************
* Animation Articles
************************************/

		$wp_customize->add_section( 'music_star_animations_section_articles' , array(
			'title'       => __( 'Animation Articles', 'music-star' ),
			'panel'       => 'music_star_panel_animations',
			'priority'   => 64,
		) );
		
		$wp_customize->add_setting( 'music_star_articles_animation', array (
			'sanitize_callback' => 'music_star_sanitize_animations',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_articles_animation', array(
			'label'    => __( 'Animation Articles', 'music-star' ),
			'section'  => 'music_star_animations_section_articles',
			'settings' => 'music_star_articles_animation',
			'type'     =>  'select',
            'choices'  => music_star_animations(),		
		) ) );
		$wp_customize->add_setting( 'music_star_articles_featured_image', array (
			'sanitize_callback' => 'music_star_sanitize_animations',
		) );
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_articles_featured_image', array(
			'label'    => __( 'Animation Featured Image', 'music-star' ),
			'description'    => __( 'More Animations of elements with premium version of the theme.', 'music-star' ),		
			'section'  => 'music_star_animations_section_articles',
			'settings' => 'music_star_articles_featured_image',
			'type'     =>  'select',
            'choices'  => music_star_animations(),		
		) ) );		
}
add_action( 'customize_register', 'music_star_animations_customize_register' );
