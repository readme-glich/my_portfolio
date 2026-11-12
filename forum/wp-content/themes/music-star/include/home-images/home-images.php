<?php if( ! defined( 'ABSPATH' ) ) exit;
/**
 * Enqueue scripts and styles.
 */
 
add_action('add_home_images_home','music_star_home_images_post');

function music_star_home_images_post () { ?>
<?php if ( get_theme_mod('music_star_home_images_activate') ) { ?>

	<div id="cat-home-act">
		<?php if ( get_theme_mod( 'music_star_home_images_title_') ) { ?>
		<h2><?php echo esc_html( get_theme_mod('music_star_home_images_title_') ); ?></h2>
		<?php } ?>

		<?php for($i=1;$i<=4;$i++) { ?>
			<?php if ( get_theme_mod( 'home_images_image'.$i) ) { ?> 
			<a href="<?php echo esc_url( get_theme_mod('music_star_home_images_url_'.$i) ); ?>">
				<div class="cont-cat">
					<img  <?php if(get_theme_mod('music_star_home_images_name_'.$i) ) { ?>style="-webkit-transform: scale(1); -moz-transform: scale(1);"<?php } ?> src="<?php echo esc_url( get_theme_mod('home_images_image'.$i) ); ?>" />
					<?php if ( get_theme_mod( 'music_star_home_images_name_'.$i) ) { ?> 
					<div class="cat-title"><?php echo esc_html( get_theme_mod('music_star_home_images_name_'.$i) ); ?></div>
					<?php } ?>
				</div>
			</a>	
				<?php } ?>
		<?php } ?>
	</div>
	<?php
	}
}

function music_star_home_images_customize_register( $wp_customize ) {

		$wp_customize->add_panel( 'music_star_panel_cats' , array(
			'title'       => __( 'Home Page Images', 'music-star' ),
			'priority'   => 2,
		) );
		
		$wp_customize->add_section( 'music_star_home_images_options' , array(
			'title'       => __( 'General', 'music-star' ),
			'panel' => 'music_star_panel_cats',
			'priority'   => 1,
		) );
		
		$wp_customize->add_setting( 'music_star_home_images_activate', array (
		    'default' => false,
			'sanitize_callback' => 'music_star_sanitize_checkbox',
		) );
		
		
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_home_images_activate', array(
			'label'    => __( 'Activate on Home Page', 'music-star' ),
			'description'    => __( 'More Images with premium version of the theme.', 'music-star' ),
			'section'  => 'music_star_home_images_options',
			'settings' => 'music_star_home_images_activate',
			'type' => 'checkbox',
		) ) );
		
		$wp_customize->add_setting( 'music_star_home_images_title_', array (
			'sanitize_callback' => 'sanitize_text_field',
		) );
			
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_home_images_title_', array(
			'label'    => __( 'Section Title', 'music-star' ),
			'section'  => 'music_star_home_images_options',
			'settings' => 'music_star_home_images_title_',
			'type' => 'text',
		) ) );		
		
	for($a=1;$a<=4;$a++) {
		
			$wp_customize->add_section( 'music_star_home_images_section_'.$a , array(
				'title'       => __( 'Image', 'music-star' ),
				'panel' => 'music_star_panel_cats',
				'priority'   => 1,
			) );
		
			$wp_customize->add_setting( 'home_images_image'.$a, array (
				'sanitize_callback' => 'esc_url_raw',
			) );
			
			$wp_customize->add_control( 
				new WP_Customize_Image_Control( $wp_customize, 'home_images_image'.$a, 
				array(
					'label'      => __( 'Select IMG ', 'music-star' ),
					'section'    => 'music_star_home_images_section_'.$a,
					'settings'   => 'home_images_image'.$a,
				) ) );

			$wp_customize->add_setting( 'music_star_home_images_name_'.$a, array (
				'sanitize_callback' => 'sanitize_text_field',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_home_images_name_'.$a, array(
				'label'    => __( 'Image Name ', 'music-star' ),
				'section'  => 'music_star_home_images_section_'.$a,
				'settings' => 'music_star_home_images_name_'.$a,
				'type' => 'text',
			) ) );
			
			$wp_customize->add_setting( 'music_star_home_images_url_'.$a, array (
				'sanitize_callback' => 'esc_url_raw',
			) );
			
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'music_star_home_images_url_'.$a, array(
				'label'    => __( 'Image URL ', 'music-star' ),
				'section'  => 'music_star_home_images_section_'.$a,
				'settings' => 'music_star_home_images_url_'.$a,
				'type' => 'url',
			) ) );

	}		
}
add_action( 'customize_register', 'music_star_home_images_customize_register' );

function music_star_cat_scripts() {
	if ( get_theme_mod('music_star_home_images_activate') ) {
		wp_enqueue_style( 'seos-home_images-css', get_template_directory_uri() . '/include/home-images/cat.css' );
	}	
}

add_action( 'wp_enqueue_scripts', 'music_star_cat_scripts' );