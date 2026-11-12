<?php
/**
 * Material AI theme functions and definitions.
 *
 * @package Material AI
 */

if (!function_exists('materialai_setup')):
	/**
	 * Set up theme defaults and register support for various WordPress features.
	 */
	function materialai_setup()
	{
		/*
		 * Define Theme Version
		 */
		define('MATERIALAI_THEME_VERSION', '2.3');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support('post-thumbnails');

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Add selective refresh for sidebar widget.
		add_theme_support('customize-selective-refresh-widgets');

		// Add custom logo support.
		add_theme_support('custom-logo');

		add_theme_support('block-templates');

		/*
		 * WooCommerce Plugin Support
		 */
		add_theme_support('woocommerce');
	}
endif;
add_action('after_setup_theme', 'materialai_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function materialai_content_width()
{
	$GLOBALS['content_width'] = apply_filters('materialai_content_width', 1100);
}
add_action('after_setup_theme', 'materialai_content_width', 0);

/**
 * Add the navbar class to the custom logo image.
 *
 * @param array $attr Attachment image attributes.
 * @return array Filtered attributes.
 */
function materialai_custom_logo_class($attr)
{
	if (isset($attr['class']) && 'custom-logo' === $attr['class']) {
		$attr['class'] = 'custom-logo navbar-brand';
	}

	return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'materialai_custom_logo_class');

if (!function_exists('materialai_setup_style')) {
	/**
	 * Set up editor styles.
	 */
	function materialai_setup_style()
	{
		add_theme_support('wp-block-styles');
		add_theme_support('editor-styles');
		add_editor_style('style.css');
	}
}
add_action('after_setup_theme', 'materialai_setup_style');

/**
 * Register the theme block pattern category.
 */
function materialai_register_pattern_category()
{
	register_block_pattern_category(
		'material-ai',
		array('label' => __('Material AI', 'material-ai'))
	);
}
add_action('init', 'materialai_register_pattern_category');

/**
 * Enqueue scripts and styles.
 */
function materialai_scripts()
{

	wp_enqueue_style('owl-carousel-min-css', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), MATERIALAI_THEME_VERSION);
	wp_enqueue_style('animate-min', get_template_directory_uri() . '/assets/css/animate.min.css', array(), MATERIALAI_THEME_VERSION);
	wp_enqueue_style('materialai-responsive-css', get_template_directory_uri() . '/assets/css/responsive.css', array(), MATERIALAI_THEME_VERSION);
	wp_enqueue_style('materialai-patterns-css', get_template_directory_uri() . '/assets/css/patterns.css', array(), MATERIALAI_THEME_VERSION);
	if (class_exists('WooCommerce')) {
		wp_enqueue_style('materialai-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), MATERIALAI_THEME_VERSION);
		foreach (array('wc-mini-cart-block-frontend', 'wc-blocks-mini-cart-frontend', 'wc-mini-cart-frontend') as $materialai_handle) {
			if (wp_script_is($materialai_handle, 'registered')) {
				wp_enqueue_script($materialai_handle);
			}
		}
	}
	wp_enqueue_style('materialai-style', get_stylesheet_uri(), array(), MATERIALAI_THEME_VERSION);
	// Scripts.
	wp_enqueue_script('jquery');
	wp_enqueue_script('owl-carousel-min-js', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), MATERIALAI_THEME_VERSION, true);
	wp_enqueue_script('owl-carousel2-thumbs-js', get_template_directory_uri() . '/assets/js/owl.carousel2.thumbs.js', array('owl-carousel-min-js'), MATERIALAI_THEME_VERSION, true);
	wp_enqueue_script('wow-min', get_template_directory_uri() . '/assets/js/wow.min.js', array(), MATERIALAI_THEME_VERSION, true);
	wp_enqueue_script('materialai-script-js', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), MATERIALAI_THEME_VERSION, true);

	if (class_exists('WooCommerce') && function_exists('wc_get_cart_url')) {
		wp_add_inline_script(
			'materialai-script-js',
			'window.materialaiWoo = ' . wp_json_encode(
				array(
					'clearCartUrl' => wp_nonce_url(add_query_arg('materialai_clear_cart', '1', wc_get_cart_url()), 'materialai_clear_cart'),
					'cartUrl' => wc_get_cart_url(),
				)
			) . ';',
			'before'
		);
	}

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'materialai_scripts');

/**
 * Load theme stylesheets inside the block editor iframe,
 * in the same order as the frontend so the cascade matches.
 */
function materialai_block_assets()
{
	if (!is_admin()) {
		return; // Frontend already handled by materialai_scripts().
	}
	wp_enqueue_style('animate-min', get_template_directory_uri() . '/assets/css/animate.min.css', array(), MATERIALAI_THEME_VERSION);
	wp_enqueue_style('materialai-responsive-css', get_template_directory_uri() . '/assets/css/responsive.css', array(), MATERIALAI_THEME_VERSION);
	wp_enqueue_style('materialai-patterns-css', get_template_directory_uri() . '/assets/css/patterns.css', array(), MATERIALAI_THEME_VERSION);
	if (class_exists('WooCommerce')) {
		wp_enqueue_style('materialai-woocommerce', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), MATERIALAI_THEME_VERSION);
	}
	wp_enqueue_style('materialai-style', get_stylesheet_uri(), array(), MATERIALAI_THEME_VERSION);
}
add_action('enqueue_block_assets', 'materialai_block_assets');

require get_theme_file_path('inc/icons.php');

if (is_admin()) {
	require get_theme_file_path('inc/theme-info/theme-info.php');
}

/**
 * Render the WooCommerce Mini-Cart after the header search button.
 * Applied at render time so it also appears when the header template
 * part has been customized in the Site Editor, and skipped whenever
 * the header already contains a Mini-Cart (no duplicates).
 */
function materialai_inject_header_minicart($block_content, $block)
{
	if (!class_exists('WooCommerce')) {
		return $block_content;
	}

	if (empty($block['attrs']['slug']) || 'header' !== $block['attrs']['slug']) {
		return $block_content;
	}

	if (false !== strpos($block_content, 'wc-block-mini-cart')) {
		return $block_content;
	}

	$anchor = strpos($block_content, 'search-btn');
	if (false === $anchor) {
		return $block_content;
	}

	$form_end = strpos($block_content, '</form>', $anchor);
	if (false === $form_end) {
		return $block_content;
	}

	$mini_cart = do_blocks('<!-- wp:woocommerce/mini-cart {"hasHiddenPrice":true,"className":"materialai-header-minicart"} /-->');

	return substr_replace($block_content, '</form>' . $mini_cart, $form_end, strlen('</form>'));
}
add_filter('render_block_core/template-part', 'materialai_inject_header_minicart', 10, 2);

/**
 * Empty the WooCommerce cart when the Clear Cart button is used.
 */
function materialai_handle_clear_cart()
{
	if (!isset($_GET['materialai_clear_cart']) || !class_exists('WooCommerce')) {
		return;
	}

	if (!isset($_GET['_wpnonce']) || !wp_verify_nonce(sanitize_key(wp_unslash($_GET['_wpnonce'])), 'materialai_clear_cart')) {
		return;
	}

	if (WC()->cart) {
		WC()->cart->empty_cart();
	}

	wp_safe_redirect(wc_get_cart_url());
	exit;
}
add_action('template_redirect', 'materialai_handle_clear_cart');

/**
 * Core search blocks that declare a post type (the shop sidebar's product
 * search) must submit it; some WordPress versions skip rendering the hidden
 * field, which makes the search return blog results instead of products.
 */
function materialai_search_post_type_field($block_content, $block)
{
	if (empty($block['attrs']['query']['post_type'])) {
		return $block_content;
	}

	if (false !== strpos($block_content, 'name="post_type"')) {
		return $block_content;
	}

	$hidden = '<input type="hidden" name="post_type" value="' . esc_attr($block['attrs']['query']['post_type']) . '" />';

	return str_replace('</form>', $hidden . '</form>', $block_content);
}
add_filter('render_block_core/search', 'materialai_search_post_type_field', 10, 2);

require_once get_template_directory() . '/inc/admin-notice-pro/get-pro.php';
