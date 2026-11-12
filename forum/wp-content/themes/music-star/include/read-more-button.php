<?php if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Read More Button
 */
	function music_star_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}
        return '<p class="link-more"><a class="myButt " href="'. esc_url(get_permalink( get_the_ID() ) ) . '">' . music_star_return_read_more_text (). '</a></p>';
	}
	add_filter( 'excerpt_more', 'music_star_excerpt_more' );	
	function music_star_excerpt_length( $length ) {
			if ( is_admin() ) {
					return $length;
			}
			return 42;
	}
	add_filter( 'excerpt_length', 'music_star_excerpt_length', 999 );
	function music_star_return_read_more_text () {
		if( get_theme_mod( 'music_star_read_more_text' ) ) {
			return esc_html( get_theme_mod( 'music_star_read_more_text' ) );
		} else {
	    	return __( 'Read More','music-star');
		}
	}
add_action( 'customize_register', 'music_star_read_more_customize_register' );
function music_star_read_more_customize_register( $wp_customize ) {
/***********************************************************************************
 * Back to top button Options
***********************************************************************************/
		$wp_customize->add_section( 'music_star_read_more' , array(
			'title'       => __( 'Read More Button', 'music-star' ),
			'priority'   => 34,
		) );
		$wp_customize->add_setting( 'music_star_read_more_text', array (
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_read_more_text', array(
			'priority'    => 1,
			'label'    => __( 'Read More Text', 'music-star' ),
			'section'  => 'music_star_read_more',
			'settings' => 'music_star_read_more_text',
			'type' => 'text',
		) ) );
}