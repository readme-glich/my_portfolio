<?php
// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Header Top
 *
 */
function music_star_header () {
?>
<div id="mobile-grid" class="grid-top">
	<!-- Site Navigation  -->
	<button id="s-button-menu" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><img src="<?php echo esc_url(get_template_directory_uri() ) . '/images/mobile.jpg'; ?>"/></button>
	<nav id="site-navigation-mobile" class="main-navigation" role="navigation">
		<button class="menu-toggle"><?php esc_html_e( 'Menu', 'music-star' ); ?></button>
		<?php wp_nav_menu( array( 
		'theme_location' => 'primary',
		'menu_id' => 'primary-menu',	
		) ); ?>
	</nav><!-- #site-navigation -->
</div>
<div id="grid-top" class="grid-top">
	<!-- Site Navigation  -->
	<button id="s-button-menu"><img src="<?php echo esc_url(get_template_directory_uri() ) . '/images/mobile.jpg'; ?>"/></button>
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'music-star' ); ?></button>
		<?php wp_nav_menu( array( 
		'theme_location' => 'primary',
		'menu_id' => 'primary-menu',
		) ); ?>
	</nav><!-- #site-navigation -->
</div>
<header id="masthead" class="site-header" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
<?php if( has_header_image() or (is_singular() and has_post_thumbnail() and get_theme_mod( 'music_star_header_featured' )) ) { ?>
	<!-- Header Image  -->
	<div class="all-header">
	    <div class="s-shadow"></div>
		<?php if( !get_theme_mod( 'activate_header_overlay' ) ) { ?>
	    <div class="dotted"></div>
		<?php } ?>
	    <div class="s-hidden">
			<?php if (get_theme_mod( 'header_image_position' ) == 'default' ) { ?>
			<img id="masthead" style="<?php music_star_heade_image_zoom_speed (); ?>" class="header-image" src='<?php echo esc_url(get_template_directory_uri() ) . '/images/header.jpg'; ?>' alt="<?php esc_attr_e( 'header image','music-star' ); ?>"/>	
			<?php } ?>
			<?php if (get_theme_mod( 'header_image_position' ) == 'real' ) { ?>
			<img id="masthead" style="<?php music_star_heade_image_zoom_speed (); ?>" class="header-image" src='<?php if ( !is_home() and has_post_thumbnail() and get_theme_mod( 'music_star_header_featured' ) ) { the_post_thumbnail_url(); } else { header_image(); } ?>' alt="<?php esc_attr_e( 'header image','music-star' ); ?>"/>	
			<?php } else { ?>
			<div id="masthead" class="header-image" style="<?php music_star_heade_image_zoom_speed (); ?> background-image: url( '<?php if (  !is_home() and has_post_thumbnail() and get_theme_mod( 'music_star_header_featured' ) ) { the_post_thumbnail_url(); } else { header_image(); } ?>' );"></div>
			<?php } ?>
		</div>
		<div class="site-branding">
		<?php if ( display_header_text() == true ) { 
			if ( is_front_page() && is_home() ) :
			if ( has_custom_logo() ) { ?>
				<div class="header-logo" itemprop="logo" itemscope="itemscope" itemtype="http://schema.org/Brand">
						<?php the_custom_logo(); ?>
				</div>			
		<?php } else { ?>
					<h1 class="site-title" itemscope itemtype="http://schema.org/Brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span class="ml2"><?php esc_html( bloginfo( 'name' ) ); ?></span></a></h1>
					<?php
				}
				else :
				if ( has_custom_logo() ) { ?>
					<div class="header-logo" itemprop="logo" itemscope="itemscope" itemtype="http://schema.org/Brand">
							<?php the_custom_logo(); ?>
					</div>			
				<?php } else { ?>
					<p class="site-title" itemscope itemtype="http://schema.org/Brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span class="ml2"><?php esc_html( bloginfo( 'name' ) ); ?></span></a></p>
					<?php
				}
				endif;
				$music_star_description = esc_html(get_bloginfo( 'description', 'display' ) );
				if ( $music_star_description || is_customize_preview() ) :
					?>    
					<p class="site-description" itemprop="headline">
						<span class="ml2"><?php echo esc_html($music_star_description); ?></span>
					</p>
				<?php endif; ?>	
		<?php } ?>
		<?php if ( get_theme_mod( 'music_star_home_button_1' ) ) { ?>
		    <a <?php echo wp_kses_post( music_star_animation( "music_star_button_1_animation" ) ); ?> class="button-h1" href="<?php echo esc_url( get_theme_mod( 'music_star_home_buttom_1_url' ) ); ?>">
			<div><?php echo esc_html( get_theme_mod( 'music_star_home_button_1', 'Contacts' ) ); ?></div></a>
		<?php } ?>
		<?php if ( get_theme_mod( 'music_star_home_button_2' ) ) { ?>
		    <a <?php echo wp_kses_post( music_star_animation( "music_star_button_2_animation" ) ); ?> class="button-h2" href="<?php echo esc_url( get_theme_mod( 'music_star_home_buttom_2_url' ) ); ?>">
				<div><?php echo esc_html( get_theme_mod( 'music_star_home_button_2', 'Abous US' ) ); ?></div>
			</a>
		<?php } ?>
		</div>
		<!-- .site-branding -->
	</div>
<?php } ?>
</header>
	<?php 
}