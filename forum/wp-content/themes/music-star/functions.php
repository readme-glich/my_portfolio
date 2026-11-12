<?php 
// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! function_exists( 'music_star_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function music_star_setup() {
		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'music-star', get_template_directory() . '/languages' );
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );
		/*
		 * WooCommerce Support
		 */		
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		/*
		 * Gutenberg Support
		 */			
		add_theme_support( 'align-wide' );
		add_theme_support( 'disable-custom-font-sizes');
		add_theme_support( 'disable-custom-colors' );
		add_theme_support( 'wp-block-styles' );		
		add_theme_support( 'responsive-embeds' );
		// This theme uses wp_nav_menu() in one location.
		add_theme_support( 'nav-menus' );
		register_nav_menu('primary', esc_html__( 'Primary', 'music-star' ) );
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'music_star_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => ''
		) ) );
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		/**
		 * Add support for core custom logo.
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 80,
			'flex-width'  => true,
			'flex-height' => false,
		) );
		
		register_default_headers( array(
			'img1' => array(
			'url'           => get_template_directory_uri() . '/images/header.jpg',
			'thumbnail_url' => get_template_directory_uri() . '/images/header.jpg',
			'description'   => esc_html__( 'Default Image 1', 'music-star' )
			)
		));
		
	}
endif;
add_action( 'after_setup_theme', 'music_star_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function music_star_content_width() {
	// This variable is intended to be overruled from themes.
	$GLOBALS['content_width'] = apply_filters( 'music_star_content_width', 640 );
}
add_action( 'after_setup_theme', 'music_star_content_width', 0 );
/**
 * Register widget area.
 */
function music_star_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'music-star' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'music-star' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'music-star' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'music-star' ),
		'id'            => 'footer-2',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'music-star' ),
		'id'            => 'footer-3',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'music-star' ),
		'id'            => 'footer-4',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'music_star_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function music_star_scripts() {
	wp_enqueue_style( 'music_star-style-css', get_stylesheet_uri() );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'music_star-Sans-font', '//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i' );
	wp_enqueue_style( 'music_star-animate-css', get_template_directory_uri() . '/css/animate.css' );
	wp_enqueue_style( 'music_star-back-top-css', get_template_directory_uri() . '/include/back-to-top/style.css' );
	wp_enqueue_script( 'music_star-search-top-main-js', get_template_directory_uri() . '/include/back-to-top/main.js', array(), '', true );	
	wp_enqueue_script( 'music_star-search-top-util-js', get_template_directory_uri() . '/include/back-to-top/util.js', array(), '', true );
	wp_enqueue_style( 'music_star-font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.7.0'  );
	wp_enqueue_style( 'music_star-font-woo-css', get_template_directory_uri() . '/include/woocommerce/woo-css.css', array(), '4.7.0'  );
	wp_enqueue_script( 'music_star-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '', true );
	wp_enqueue_script( 'music_star-mobile-menu', get_template_directory_uri() . '/js/mobile-menu.js', array(), '', true );
	wp_enqueue_script( 'music_star-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'music_star_scripts' );
/**
 * Includes
*/
require_once get_template_directory() . '/include/content-customizer.php';
require_once get_template_directory() . '/include/custom-header.php';
require_once get_template_directory() . '/include/template-tags.php';
require_once get_template_directory() . '/include/customizer.php';
require_once get_template_directory() . '/include/header-top.php';
require_once get_template_directory() . '/include/back-to-top-button.php';
require_once get_template_directory() . '/include/read-more-button.php';
require_once get_template_directory() . '/include/animations/animations.php';
require_once get_template_directory() . '/include/letters/anime.php';
require_once get_template_directory() . '/include/post-options.php';
require_once get_template_directory() . '/include/social.php';
require_once get_template_directory() . '/include/footer-copyrights.php';
require_once get_template_directory() . '/include/dark.php';
require_once get_template_directory() . '/include/home-images/home-images.php';
require_once get_template_directory() . '/include/customize-pro/class-customize.php';
if( class_exists( 'WooCommerce' ) ) {
    require_once get_template_directory() . '/include/woocommerce/woo-functions.php';
}
/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require_once get_template_directory() . '/include/jetpack.php';
}
/**
 * Adds custom classes to the array of body classes.
 */
function music_star_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
	return $classes;
}
add_filter( 'body_class', 'music_star_body_classes' );
function music_star_sidebar_position() {
	if ( ( is_active_sidebar('sidebar-1') ) ) { 
		wp_enqueue_style( 'music_star-sidebar', get_template_directory_uri() . '/layouts/left-sidebar.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'music_star_sidebar_position' );
/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function music_star_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'music_star_pingback_header' );
/**
 * Header Image Animation
 */
function music_star_header_image_zoom () { 
	if (!get_theme_mod('music_star_header_zoom')) { 
	?>
		<style>
@-webkit-keyframes header-image {
  0% {
    -webkit-transform: scale(1) translateY(0);
            transform: scale(1) translateY(0);
    -webkit-transform-origin: 50% 16%;
            transform-origin: 50% 16%;
  }
  100% {
    -webkit-transform: scale(1.25) translateY(-15px);
            transform: scale(1.25) translateY(-15px);
    -webkit-transform-origin: top;
            transform-origin: top;
  }
}
@keyframes header-image {
  0% {
    -webkit-transform: scale(1) translateY(0);
            transform: scale(1) translateY(0);
    -webkit-transform-origin: 50% 16%;
            transform-origin: 50% 16%;
  }
  100% {
    -webkit-transform: scale(1.25) translateY(-15px);
            transform: scale(1.25) translateY(-15px);
    -webkit-transform-origin: top;
            transform-origin: top;
  }
}
	</style>
	<?php
	}
}
add_action('wp_head','music_star_header_image_zoom');
/**
 * Header Image - Zoom Animation Speed
 */
function music_star_heade_image_zoom_speed () { ?>
	-webkit-animation: header-image 
	<?php 
	if (get_theme_mod('header_zoom_speed')) { 
		echo esc_attr(get_theme_mod('header_zoom_speed')); 
	} else 
		echo "20";
	?>s ease-out both; 
	animation: header-image
	<?php
	if (get_theme_mod('header_zoom_speed')) {
		echo esc_attr(get_theme_mod('header_zoom_speed')); 
	} else
		echo "20";
	?>s ease-out 0s 1 normal both running;
<?php	
}

/*********************************************************************************************************
* Customizer Styles
**********************************************************************************************************/
add_action( 'customize_controls_print_styles', 'music_star_customize_checkbox_styles');
function music_star_customize_checkbox_styles( $input ) { ?>
	<style type="text/css">

	</style>
	<?php }
/*********************************************************************************************************
* Menu Active Link
**********************************************************************************************************/	
if( get_theme_mod( 'menu_active_links' ) ) {
	add_filter('nav_menu_css_class' , 'music_star_nav_class' , 10 , 2);
}
function music_star_nav_class ($classes, $item) {
	if (in_array('current-post-ancestor', $classes) || in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes) ){
		$classes[] = 'active ';
	}
	return $classes;
}
/*********************************************************************************************************
* Post Class
**********************************************************************************************************/		
function music_star_post_class () {
	global $music_star_posts_count; 
	$music_star_posts_count;
	if($music_star_posts_count % 2 == 0) {
		return "post-even";
	}
	else {
		return "post-odd";
	}
}

function music_star_customizer_styles() {
    wp_enqueue_style( 'seos-customizer-styles', get_template_directory_uri() . '/css/customize.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'music_star_customizer_styles' );