<?php
// Do not allow direct access to the file.
if(  ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Theme Customizer
 *
 */
add_action( 'customize_register', 'music_star_customize_register' );
function music_star_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'music_star_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'music_star_customize_partial_blogdescription',
		) );
	}
  	    $wp_customize->add_setting( 'background_color', array (
			'sanitize_callback' => 'sanitize_text_field',
		) );
 		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
			'label'    => __( 'Background Color ', 'music-star' ),
			'section'  => 'music-star',
			'settings' => 'background_color',
		) ) );
/**
 * Sanitize Functions
 */
	function music_star_sanitize_checkbox( $input ) {
		if ( $input ) {
			return 1;
		}
		return 0;
	}
	function music_star_header_sanitize_position( $input ) {
		$valid = array(
			'center' => esc_attr__( 'center center', 'music-star' ),
			'real' => esc_attr__( 'Real Size (Deactivate the image height.)', 'music-star' ),
		);
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}
	function music_star_header_sanitize_position_buttons( $input ) {
		$valid = array(
			'center' => esc_attr__( 'Center', 'music-star' ),
			'left' => esc_attr__( 'Left', 'music-star' )
		);
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}
	function music_star_header_sanitize_show( $input ) {
		$valid = array(
				'all' => esc_attr__( 'All Pages', 'music-star' ),
				'home' => esc_attr__( 'Home Page', 'music-star' ),
		);
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}	
/**
 * Header Image
 */	
   	    $wp_customize->add_setting( 'body_background', array (
			'sanitize_callback' => 'sanitize_hex_color',
		) );
 		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_background', array(
			'label'    => __( 'Body Background Color', 'music-star' ),
			'description'    => __( 'More Colors with premium version of the theme.', 'music-star' ),			
			'priority' => 14,
			'section'  => 'colors',
			'settings' => 'body_background',
		) ) );
   	    $wp_customize->add_setting( 'menu_active_links', array (
			'sanitize_callback' => 'sanitize_hex_color',
		) );
 		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_active_links', array(
			'label'    => __( 'Menu Active Links Color', 'music-star' ),
			'priority' => 14,
			'section'  => 'colors',
			'settings' => 'menu_active_links',
		) ) );
   	    $wp_customize->add_setting( 'main_content_color', array (
			'sanitize_callback' => 'sanitize_hex_color',
		) );
 		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_content_color', array(
			'label'    => __( 'Content Background Color', 'music-star' ),
			'priority' => 14,
			'section'  => 'colors',
			'settings' => 'main_content_color',
		) ) );
   	    $wp_customize->add_setting( 'body_color', array (
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		
 		$wp_customize->add_setting( 'header_image_show', array (
			'sanitize_callback' => 'music_star_header_sanitize_show',
		) );		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_show', array(
			'label'    => __( 'Activate Header Image', 'music-star' ),
			'section'  => 'header_image',		
			'settings' => 'header_image_show',
			'type'     =>  'select',
			'priority'    => 1,			
            'choices'  => array(
				'all' => esc_attr__( 'All Pages', 'music-star' ),
				'home' => esc_attr__( 'Home Page', 'music-star' ),
            ),
			'default'  => 'all'	
		) ) );
		$wp_customize->add_setting( 'header_image_height', array (
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_height', array(
			'section'  => 'header_image',
			'priority'    => 1,
			'settings' => 'header_image_height',
			'label'       => __( 'Header Image Height', 'music-star' ),			
			'type'     =>  'number',
			'input_attrs'     => array(
				'min'  => 200,
				'max'  => 1000,
				'step' => 1,
			),
		) ) );
		$wp_customize->add_setting( 'header_image_mobile_height', array (
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_mobile_height', array(
			'section'  => 'header_image',
			'priority'    => 1,
			'settings' => 'header_image_mobile_height',
			'label'       => __( 'Header Image Mobile Height', 'music-star' ),			
			'type'     =>  'number',
			'input_attrs'     => array(
				'min'  => 200,
				'max'  => 1000,
				'step' => 1,
			),
		) ) );		
		$wp_customize->add_setting( 'header_image_position', array (
			'sanitize_callback' => 'music_star_header_sanitize_position',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'header_image_position', array(
			'label'    => __( 'Image Position', 'music-star' ),
			'section'  => 'header_image',		
			'settings' => 'header_image_position',
			'type'     =>  'select',
			'priority'    => 2,			
            'choices'  => array(
				'center' => esc_attr__( 'Background Cover (center center)', 'music-star' ),
				'real' => esc_attr__( 'Real Size (Deactivate the image height.)', 'music-star' ),
            ),
			'default'  => 'real'	
		) ) );
 		$wp_customize->add_setting( 'music_star_header_shadow', array (
            'default' => 0,		
			'sanitize_callback' => 'absint',
		) );
		 $wp_customize->add_control( 'music_star_header_shadow', array(
		    'priority'    => 3,	
		    'type' => 'range',
		    'section' => 'header_image',
		    'settings' => 'music_star_header_shadow',
		    'label' => __( 'Image Shadow:', 'music-star' ),
		    'input_attrs' => array(
			  'min' => 0,
			  'max' => 9,
			  'step' => 1,
		    ),
		) );
		$wp_customize->add_setting( 'activate_header_text_shadow', array (
			'sanitize_callback' => 'music_star_sanitize_checkbox',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'activate_header_text_shadow', array(
			'priority'    => 3,
			'label'    => __( 'Deactivate Header Text Shadow', 'music-star' ),
			'section'  => 'header_image',
			'settings' => 'activate_header_text_shadow',
			'type' => 'checkbox',
		) ) );
		$wp_customize->add_setting( 'music_star_header_zoom', array (
            'default' => '',		
			'sanitize_callback' => 'music_star_sanitize_checkbox',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_header_zoom', array(
			'label'    => __( 'Dectivate Image Zoom:', 'music-star' ),
			'section'  => 'header_image',
			'priority'    => 3,				
			'settings' => 'music_star_header_zoom',
			'type' => 'checkbox',
		) ) );
		$wp_customize->add_setting( 'music_star_header_animation', array (
            'default' => '',		
			'sanitize_callback' => 'music_star_sanitize_checkbox',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_header_animation', array(
			'label'    => __( 'Dectivate Text Animation:', 'music-star' ),
			'section'  => 'header_image',
			'priority'    => 3,				
			'settings' => 'music_star_header_animation',
			'type' => 'checkbox',
		) ) );
		$wp_customize->add_setting( 'music_star_header_featured', array (
            'default' => '',		
			'sanitize_callback' => 'music_star_sanitize_checkbox',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_header_featured', array(
			'label'    => __( 'Activate All Featured Image like Header Image:', 'music-star' ),
			'section'  => 'header_image',
			'priority'    => 3,				
			'settings' => 'music_star_header_featured',
			'type' => 'checkbox',
		) ) );
			$wp_customize->add_setting( 'music_star_home_button_1', array (
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_home_button_1', array(
				'label'    => __( 'Button 1', 'music-star' ),
				'section'  => 'header_image',
				'settings' => 'music_star_home_button_1',
				'type' => 'text',
			) ) );
			$wp_customize->add_setting( 'music_star_home_buttom_1_url', array (
				'sanitize_callback' => 'esc_url_raw',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_home_buttom_1_url', array(
				'label'    => __( 'Button 1 URL ', 'music-star' ),
				'section'  => 'header_image',
				'settings' => 'music_star_home_buttom_1_url',
				'type' => 'url',
			) ) );			
			$wp_customize->add_setting( 'music_star_home_button_2', array (
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_home_button_2', array(
				'label'    => __( 'Button 2', 'music-star' ),
				'section'  => 'header_image',
				'settings' => 'music_star_home_button_2',
				'type' => 'text',
			) ) );
			$wp_customize->add_setting( 'music_star_home_buttom_2_url', array (
				'sanitize_callback' => 'esc_url_raw',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_home_buttom_2_url', array(
				'label'    => __( 'Button 2 URL ', 'music-star' ),
				'section'  => 'header_image',
				'settings' => 'music_star_home_buttom_2_url',
				'type' => 'url',
			) ) );
			$wp_customize->add_setting( 'music_star_branding_top', array (
				'sanitize_callback' => 'absint',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_branding_top', array(
				'label'    => __( 'Site Branding Margin Top ', 'music-star' ),
				'description'    => __( 'Min 1% and Max 60%', 'music-star' ),
				'section'  => 'header_image',
				'settings' => 'music_star_branding_top',
				'type' => 'number',
					'input_attrs' => array(
				    'min' => 0,
				    'max' => 60,
				    'step' => 1,
				),
			) ) );	
			$wp_customize->add_setting( 'music_star_branding_left', array (
				'sanitize_callback' => 'absint',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_branding_left', array(
				'label'    => __( 'Site Branding Margin Left ', 'music-star' ),
				'description'    => __( 'Min 1% and Max 60%', 'music-star' ),
				'section'  => 'header_image',
				'settings' => 'music_star_branding_left',
				'type' => 'number',
					'input_attrs' => array(
				    'min' => 0,
				    'max' => 60,
				    'step' => 1,
				),
			) ) );	
}
/**
 * Custom Font Size Styles
 */ 	
add_action( 'wp_enqueue_scripts', 'music_star_header_position' );	
function music_star_header_position() {
        $header_image_height = esc_html(get_theme_mod( 'header_image_height' ) );
        $header_image_position = esc_html(get_theme_mod( 'header_image_position' ) );
        $music_star_branding_top = esc_html(get_theme_mod( 'music_star_branding_top' ) );
        $music_star_branding_left = esc_html(get_theme_mod( 'music_star_branding_left' ) );
		if( $header_image_height and $header_image_position != 'real' ) { $header_height = ".header-image {height: {$header_image_height}px !important;}";} else {$header_height ="";}
		if( $header_image_position == 'center' ) { $header_position = ".header-image {background-position: center center !important;}";} else {$header_position ="";}
		if( $header_image_position == '50' ) { $header_position = ".header-image {background-position: 50% 50% !important;}";} else {$header_position ="";}
		if( $header_image_position == 'real' ) { $header_position = ".header-image {background-position: no !important; height: auto;} .site-branding {display:block;}";} else {$header_position ="";}
		if( $music_star_branding_top) { $sbtop = ".site-branding {top: {$music_star_branding_top}% ;}";} else {$sbtop ="";}
		if( $music_star_branding_left) { $sbposition = ".site-branding { padding-left: {$music_star_branding_left}%;   text-align: left; }";} else {$sbposition ="";}
        wp_add_inline_style( 'music_star-style-css', 
		$header_height.$header_position.$sbtop.$sbposition
		);
}
/**
 * Render the site title for the selective refresh partial.
 */
function music_star_customize_partial_blogname() {
	bloginfo( 'name' );
}
/**
 * Render the site tagline for the selective refresh partial.
 */
function music_star_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
/**
 * Custom Font Size Styles
 */ 	
function music_star_customizing_styles() {
        $header_tagline_hide = esc_attr(get_theme_mod( 'header_tagline_hide' ) );
        $music_star_top_menu_sub_font_size = esc_attr(get_theme_mod( 'music_star_top_menu_sub_font_size' ) );
        $music_star_top_menu_font_size = esc_attr(get_theme_mod( 'music_star_top_menu_font_size' ) );
        $header_image_show = esc_attr(get_theme_mod( 'header_image_show' ) );
        $sidebar_position = esc_attr(get_theme_mod( 'sidebar_position' ) );
        $music_star_menu_background_color = esc_attr(get_theme_mod( 'music_star_menu_background_color' ) );
        $music_star_menu_color = esc_attr(get_theme_mod( 'music_star_menu_color' ) );
        $music_star_menu_background_hover_color = esc_attr(get_theme_mod( 'music_star_menu_background_hover_color' ) );
        $before_background_color = esc_attr(get_theme_mod( 'before_background_color' ) );
        $before_border_color = esc_attr(get_theme_mod( 'before_border_color' ) );
        $music_star_link_color = esc_attr(get_theme_mod( 'music_star_link_color' ) );
        $music_star_link_hover_color = esc_attr(get_theme_mod( 'music_star_link_hover_color' ) );
        $body_background = esc_attr(get_theme_mod( 'body_background' ) );
        $music_star_header_shadow = esc_html(get_theme_mod( 'music_star_header_shadow' ) );
        $header_image_mobile_height = esc_attr(get_theme_mod( 'header_image_mobile_height' ) );
        $activate_header_text_shadow = esc_attr(get_theme_mod( 'activate_header_text_shadow' ) );
        $menu_active_links = esc_attr(get_theme_mod( 'menu_active_links' ) );
        $main_content_color = esc_attr(get_theme_mod( 'main_content_color' ) );
## Header Styles
		if( $main_content_color) { $style30 = "article, #secondary section,.woocommerce ul.products li.product .button{ background: {$main_content_color} !important;}";} else {$style30 ="";}
		if( $music_star_header_shadow) { $style28 = ".s-shadow { background-color: rgba(0,0,0,0.{$music_star_header_shadow}) !important;}";} else {$style28 ="";}
		if( $header_tagline_hide) { $style9 = ".site-branding .site-description {display: none !important;}";} else {$style9 ="";}
		if( $music_star_top_menu_sub_font_size) { $style10 = ".main-navigation ul ul li a {font-size: {$music_star_top_menu_sub_font_size}px !important;}";} else {$style10 ="";}
		if( $music_star_top_menu_font_size) { $style29 = ".main-navigation ul li a {font-size: {$music_star_top_menu_font_size}px !important;}";} else {$style29 ="";}
		if( $before_background_color) { $style17 = ".before-header {background: {$before_background_color} !important;}";} else {$style17 ="";}
		if( $before_border_color) { $style19 = ".before-header {border-bottom: 1px solid {$before_border_color} !important;}";} else {$style19 ="";}
		if( ((!is_front_page() or !is_home() ) and (!has_post_thumbnail() or !get_theme_mod( 'music_star_header_featured' ) ) ) and $header_image_show == 'home' ) { $style11 = ".all-header{display: none !important;} .site-header {overflow: visible;}";} else {$style11 ="";}
		if( ((is_front_page() and !is_home() ) and (!has_post_thumbnail() or !get_theme_mod( 'music_star_header_featured' ) ) )and $header_image_show == 'home' ) { $style27 = " body .all-header{display: block !important;} body .site-header {overflow: hidden;}";} else {$style27 ="";}
		if( $body_background) { $body_background = "body {background: {$body_background} !important;}";} else {$body_background ="";}			
## Sidebar Styles
		if( $sidebar_position == 'no' ) { $style12 = "#content #secondary {display: none !important;}";} else {$style12 ="";}
		if( is_active_sidebar( 'sidebar-1' ) ){ $sidebar = "#content, .h-center {padding: 0 60px;}";} else {$sidebar ="";}
## Menu Styles		
		if( $music_star_menu_background_color) { $style15 = ".grid-top, .main-navigation ul ul, .slicknav_menu {background: {$music_star_menu_background_color} !important; box-shadow: none !important;}";} else {$style15 ="";}
		if( $music_star_menu_color) { $style16 = ".main-navigation ul li a, .main-navigation ul ul li a, .main-navigation ul ul li a:hover, .main-navigation ul ul li > a:after, .main-navigation ul ul ul li > a:after, .slicknav_nav a {color: {$music_star_menu_color} !important; }";} else {$style16 ="";}
		if( $music_star_menu_background_hover_color) { $style18 = ".main-navigation ul li a:hover, .slicknav_nav a:hover {background: {$music_star_menu_background_hover_color} !important; box-shadow: none !important;}";} else {$style18 ="";}
		if( $menu_active_links) { $active = "#grid-top nav ul .active a {color: {$menu_active_links}}";} else {$active ="";}
## Colors Styles
		if( $music_star_link_color) { $style22 = "a {color: {$music_star_link_color};}";} else {$style22 ="";}
		if( $music_star_link_hover_color ) { $style23 = "a:hover {color: {$music_star_link_hover_color};}";} else {$style23 ="";}
## Header Mobile Height		
		if( $header_image_mobile_height ) { $h_mobile = "@media screen and (max-width: 800px) { .header-image {height: {$header_image_mobile_height}px !important;} }";} else {$h_mobile ="";}		
		if( !$activate_header_text_shadow ) { $h_shadow= ".site-branding .site-title a, .site-title, .site-description { text-shadow: -1px 0 black, 0 1px black, 2px 0 black, 0 -2px black;}";} else {$h_shadow ="";}		
        wp_add_inline_style( 'music_star-style-css', 
		$style9.$style10.$style11.$style12.$style15.$style16.$style17.$style18.$style19.$style22.$style23.$style27.$style28.$style29.$body_background.$h_mobile.$h_shadow.$active.$style30.$sidebar
		);
}
add_action( 'wp_enqueue_scripts', 'music_star_customizing_styles' );