<?php if( ! defined( 'ABSPATH' ) ) exit;
	function music_star_social_section () { ?>
			<div <?php if(get_theme_mod( 'social_media_activate' )){ ?> style="float: none;"<?php } ?> class="seos-fa-icons">
				<?php if (get_theme_mod( 'music_star_facebook' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'facebook_link' )) == "new"){ echo "_blank"; } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'music_star_facebook' )); ?>"><i class="fa fa-facebook-f"></i></a>
				<?php endif; ?>
				<?php if (get_theme_mod( 'music_star_twitter' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'twitter_link' )) == "new"){ echo "_blank"; } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'music_star_twitter' )); ?>"><i class="fa fa-twitter"></i></a>
				<?php endif; ?>
				<?php if (get_theme_mod( 'music_star_pinterest' )) : ?>
					<a target="<?php if(esc_attr(get_theme_mod( 'pinterest_link' )) == "new"){ echo "_blank"; } else {echo "_self"; } ?>" href="<?php echo esc_url(get_theme_mod( 'music_star_pinterest' )); ?>"><i class="fa fa-pinterest"></i></a>
				<?php endif; ?>	
				
			</div>
<?php } 
add_action( 'customize_register', 'music_star__social' );
function music_star__social( $wp_customize ) {
	function music_star_header_social_links( $input ) {
		$valid = array(
				'new' => esc_attr__( 'Open in a new window.', 'music-star' ),
				'' => esc_attr__( 'Open in the same window.', 'music-star' ),
		);
		if ( array_key_exists( $input, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}	
 		$wp_customize->add_section( 'music_star_social_section' , array(
			'title'       => __( 'Social Icons', 'music-star' ),
			'description' => __( 'Social Media Icons.', 'music-star' ),
			'priority'    => 2,	
			//'description' => __( 'Social media buttons', 'music-star' ),
		) ); 
 		$wp_customize->add_setting( 'music_star_active_social', array (
			'sanitize_callback' => 'music_star_sanitize_checkbox',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_active_social', array(
			'label'    => __( 'Activate Social Icons Footer', 'music-star' ),
			'description'    => __( 'More Social Icons with premium version of the theme.', 'music-star' ),			
			'section'  => 'music_star_social_section',
			'settings' => 'music_star_active_social',
			'type' => 'checkbox'
		) ) );
		$wp_customize->add_setting( 'music_star_facebook', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_facebook', array(
			'label'    => __( 'Enter Facebook url', 'music-star' ),		
			'section'  => 'music_star_social_section',
			'settings' => 'music_star_facebook',
		) ) );
 		$wp_customize->add_setting( 'facebook_link', array (
			'sanitize_callback' => 'music_star_header_social_links',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'facebook_link', array(
			'description'    => __( 'Open Facebook Link', 'music-star' ),
			'section'  => 'music_star_social_section',		
			'settings' => 'facebook_link',
			'type'     =>  'select',	
            'choices'  => array(
				'new' => esc_attr__( 'Open in a new window.', 'music-star' ),
				'' => esc_attr__( 'Open in the same window.', 'music-star' ),
            )
		) ) );		
		$wp_customize->add_setting( 'music_star_twitter', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_twitter', array(
			'label'    => __( 'Enter Twitter url', 'music-star' ),		
			'section'  => 'music_star_social_section',
			'settings' => 'music_star_twitter',
		) ) );	
 		$wp_customize->add_setting( 'twitter_link', array (
			'sanitize_callback' => 'music_star_header_social_links',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'twitter_link', array(
			'description'    => __( 'Open Twitter Link', 'music-star' ),
			'section'  => 'music_star_social_section',		
			'settings' => 'twitter_link',
			'type'     =>  'select',	
            'choices'  => array(
				'new' => esc_attr__( 'Open in a new window.', 'music-star' ),
				'' => esc_attr__( 'Open in the same window.', 'music-star' ),
            )
		) ) );		
		$wp_customize->add_setting( 'music_star_pinterest', array (
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_pinterest', array(
			'label'    => __( 'Enter Pinterest url', 'music-star' ),		
			'section'  => 'music_star_social_section',
			'settings' => 'music_star_pinterest',
		) ) );	
 		$wp_customize->add_setting( 'pinterest_link', array (
			'sanitize_callback' => 'music_star_header_social_links',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'pinterest_link', array(
			'description'    => __( 'Open Pinterest Link', 'music-star' ),
			'section'  => 'music_star_social_section',		
			'settings' => 'pinterest_link',
			'type'     =>  'select',	
            'choices'  => array(
				'new' => esc_attr__( 'Open in a new window.', 'music-star' ),
				'' => esc_attr__( 'Open in the same window.', 'music-star' ),
            )
		) ) );	
}
/********************************************
* Social styles
*********************************************/ 	
function music_star_social_method() {
        $social_media_color_mod = esc_attr(get_theme_mod( 'social_media_color' ));
        $social_media_hover_color_mod = esc_attr(get_theme_mod( 'social_media_hover_color' ));
		if($social_media_color_mod) { $social_media_color = ".social .fa-icons i, .social-top .fa {color: {$social_media_color_mod} !important;}";} else {$social_media_color ="";}
		if($social_media_hover_color_mod) { $social_media_hover_color = ".social .fa-icons i:hover, .social-top a:hover .fa {color: {$social_media_hover_color_mod} !important;}";} else {$social_media_hover_color ="";}
        wp_add_inline_style( 'music_star-style-css', 
		$social_media_color.$social_media_hover_color);
}
add_action( 'wp_enqueue_scripts', 'music_star_social_method' );				