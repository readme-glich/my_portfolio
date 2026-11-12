<?php 
// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
function music_star_footer_customize_register( $wp_customize ) {
			$wp_customize->add_section( 'music_star_footer_section' , array(
				'title'       => __( 'Footer Copyright', 'music-star' ),
				'priority'   => 34,
			) );
			$wp_customize->add_setting( 'music_star_copyright', array (
				'sanitize_callback' => 'wp_kses_post',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_copyright', array(
			    'label'    => __( 'Custom Copyright ', 'music-star' ),
			    'description'    => __( 'Remove theme credits with premium version of the theme.', 'music-star' ),				
				'section'  => 'music_star_footer_section',
				'settings' => 'music_star_copyright',
				'type' => 'textarea',
			) ) );
}
		add_action( 'customize_register', 'music_star_footer_customize_register' );