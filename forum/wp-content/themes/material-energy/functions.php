<?php
/**
 * Material Energy child theme functions.
 *
 * @package Material_Energy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme version, used to bust the stylesheet cache.
 */
const MATERIAL_ENERGY_VERSION = '1.0';

/**
 * The parent's theme dashboard, made to show this theme's version, screenshot
 * and links. Admin only.
 */
if ( is_admin() ) {
	require get_stylesheet_directory() . '/inc/admin-page.php';
}

/**
 * Load the parent stylesheet, then this theme's, in that order.
 *
 * The parent enqueues its main stylesheet with get_stylesheet_uri(), which
 * resolves to the CHILD's style.css once a child theme is active — so under
 * this theme the handle "materialai-style" holds this file and the parent's
 * own style.css is never enqueued at all. Dropping that handle and naming
 * both files explicitly puts the parent back underneath this one.
 *
 * (add_editor_style() is not affected: core already loads the parent's copy
 * first for a child theme. This is only about the enqueued path.)
 */
function material_energy_stylesheets() {

	wp_dequeue_style( 'materialai-style' );

	wp_enqueue_style(
		'material-ai-parent',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( get_template() )->get( 'Version' )
	);

	wp_enqueue_style(
		'material-energy',
		get_stylesheet_uri(),
		array( 'material-ai-parent' ),
		MATERIAL_ENERGY_VERSION
	);
}

/**
 * Load the parent stylesheet, then this theme's.
 *
 * The parent enqueues its main stylesheet with get_stylesheet_uri(), which
 * resolves to the CHILD's style.css once a child theme is active — so the
 * parent's own style.css would otherwise never load and the whole design
 * would come apart. Naming it here puts it back, ahead of this theme's.
 */
function material_energy_styles() {

	material_energy_stylesheets();

	/*
	* The mobile menu panel and the hero's tuck under the header need
	* scripting; the banner itself is static markup. jQuery comes
	* from the parent, which enqueues it on every page.
	*/
	wp_enqueue_script(
		'material-energy',
		get_stylesheet_directory_uri() . '/assets/js/energy.js',
		array( 'jquery' ),
		MATERIAL_ENERGY_VERSION,
		true
	);

	/*
	* The sub-menu toggles are built in the browser, so their label has to
	* reach the script to be translatable.
	*/
	wp_localize_script(
		'material-energy',
		'materialEnergyMenu',
		array(
			/* translators: %s: the name of the menu item the sub-menu belongs to. */
			'submenu' => __( 'Show submenu of %s', 'material-energy' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'material_energy_styles', 20 );

/**
 * Is the parent theme missing from wp_get_theme()?
 *
 * Material AI is a block theme with no index.php, so WordPress cannot confirm
 * the parent by that file and falls back to search_theme_directories(). On a
 * host where that search does not list the parent — the WordPress.org theme
 * previewer, which renders every style variation, is one — the child's
 * WP_Theme object ends up with no parent(), while get_template_directory()
 * still points at Material AI.
 *
 * Templates and style variations are read from get_template_directory(), so
 * they keep working. The two things core reads through parent() do not: the
 * parent's patterns are never registered, and its theme.json is never merged.
 * The front page is nothing but wp:pattern blocks (home → main banner,
 * services, pricing…) and the footer part is a single wp:pattern, so the page
 * rendered the header and then nothing at all.
 *
 * @return bool
 */
function material_energy_parent_unresolved() {

	if ( get_stylesheet() === get_template() ) {
		return false;
	}

	return ! wp_get_theme()->parent() && is_dir( get_template_directory() );
}

/**
 * Register the parent's patterns when core could not.
 *
 * Mirrors _register_theme_block_patterns(), reading from
 * get_template_directory() instead of wp_get_theme()->parent(). A slug that
 * is already registered is skipped, so this theme's own header and main
 * banner keep precedence and, where core did find the parent, nothing here
 * runs at all.
 *
 * Priority 11: after core's registration on init (10), before the badge
 * repair below (20), which then sees these patterns like any others.
 */
function material_energy_register_parent_patterns() {

	if ( ! material_energy_parent_unresolved() || ! class_exists( 'WP_Block_Patterns_Registry' ) ) {
		return;
	}

	$files = glob( trailingslashit( get_template_directory() ) . 'patterns/*.php' );

	if ( empty( $files ) ) {
		return;
	}

	$registry  = WP_Block_Patterns_Registry::get_instance();
	$lazy_load = version_compare( get_bloginfo( 'version' ), '6.5', '>=' );
	$headers   = array(
		'title'         => 'Title',
		'slug'          => 'Slug',
		'description'   => 'Description',
		'viewportWidth' => 'Viewport Width',
		'inserter'      => 'Inserter',
		'categories'    => 'Categories',
		'keywords'      => 'Keywords',
		'blockTypes'    => 'Block Types',
		'postTypes'     => 'Post Types',
		'templateTypes' => 'Template Types',
	);

	foreach ( $files as $file ) {

		$data = get_file_data( $file, $headers );

		if ( empty( $data['slug'] ) || empty( $data['title'] ) || $registry->is_registered( $data['slug'] ) ) {
			continue;
		}

		$pattern = array(
			'title' => $data['title'],
		);

		if ( '' !== $data['description'] ) {
			$pattern['description'] = $data['description'];
		}

		if ( '' !== $data['viewportWidth'] ) {
			$pattern['viewportWidth'] = (int) $data['viewportWidth'];
		}

		if ( '' !== $data['inserter'] ) {
			$pattern['inserter'] = in_array( strtolower( $data['inserter'] ), array( 'yes', 'true' ), true );
		}

		foreach ( array( 'categories', 'keywords', 'blockTypes', 'postTypes', 'templateTypes' ) as $list ) {
			if ( '' !== $data[ $list ] ) {
				$pattern[ $list ] = array_filter( array_map( 'trim', explode( ',', $data[ $list ] ) ) );
			}
		}

		if ( $lazy_load ) {
			$pattern['filePath'] = $file;
		} else {
			ob_start();
			include $file;
			$pattern['content'] = ob_get_clean();
		}

		register_block_pattern( $data['slug'], $pattern );
	}
}
add_action( 'init', 'material_energy_register_parent_patterns', 11 );

/**
 * Merge the parent's theme.json when core could not.
 *
 * The same unresolved parent leaves the site on this theme's theme.json
 * alone — the palette, but none of the parent's fonts, layout widths or
 * spacing. Put the parent's file underneath, with this theme's on top, which
 * is the order core would have used.
 *
 * @param WP_Theme_JSON_Data $theme_json This theme's theme.json data.
 * @return WP_Theme_JSON_Data
 */
function material_energy_merge_parent_theme_json( $theme_json ) {

	if ( ! material_energy_parent_unresolved() || ! class_exists( 'WP_Theme_JSON' ) || ! class_exists( 'WP_Theme_JSON_Data' ) ) {
		return $theme_json;
	}

	$file = trailingslashit( get_template_directory() ) . 'theme.json';

	if ( ! is_readable( $file ) ) {
		return $theme_json;
	}

	$data = wp_json_file_decode( $file, array( 'associative' => true ) );

	if ( ! is_array( $data ) ) {
		return $theme_json;
	}

	$merged = new WP_Theme_JSON( $data, 'theme' );
	$merged->merge( new WP_Theme_JSON( $theme_json->get_data(), 'theme' ) );

	return new WP_Theme_JSON_Data( $merged->get_raw_data(), 'theme' );
}
add_filter( 'wp_theme_json_data_theme', 'material_energy_merge_parent_theme_json' );

/**
 * Keep WooCommerce from auto-inserting its own mini-cart into the header.
 *
 * WooCommerce adds a mini-cart to header template parts through Block Hooks.
 * That copy carries none of this theme's classes, lands outside the header's
 * action group, and is taller than the themed disc — which is why the cart
 * showed up unstyled, in the wrong order, and pushed the navigation bar about
 * 24px taller than it should be.
 *
 * Worse, the parent only injects its own themed mini-cart when the header does
 * not already contain one, so WooCommerce's copy was displacing it entirely.
 * Dropping the hooked copy lets the parent put the themed one back.
 *
 * @param string[] $hooked_blocks     Block types to insert.
 * @param string   $relative_position Where they would go.
 * @param string   $anchor_block_type The block they hang off.
 * @param mixed    $context           Template, template part, post or pattern.
 * @return string[]
 */
function material_energy_drop_hooked_minicart( $hooked_blocks, $relative_position, $anchor_block_type, $context ) {

	if ( ! in_array( 'woocommerce/mini-cart', (array) $hooked_blocks, true ) ) {
		return $hooked_blocks;
	}

	$area = '';

	if ( $context instanceof WP_Block_Template ) {
		$area = ! empty( $context->area ) ? $context->area : '';

		if ( '' === $area && ! empty( $context->slug ) ) {
			$area = $context->slug;
		}
	}

	if ( 'header' !== $area ) {
		return $hooked_blocks;
	}

	return array_values(
		array_diff( (array) $hooked_blocks, array( 'woocommerce/mini-cart' ) )
	);
}
add_filter( 'hooked_block_types', 'material_energy_drop_hooked_minicart', 10, 4 );

/**
 * Let the parent's template parts resolve under this child theme.
 *
 * Material AI's templates name the theme on their template-part blocks —
 * {"slug":"header","theme":"material-ai"}. WordPress only looks a part up when
 * that name matches the ACTIVE theme (wp-includes/blocks/template-part.php:
 * `if ( isset( $attributes['slug'] ) && get_stylesheet() === $theme )`), so
 * with a child theme active every one of them falls through to "Template part
 * has been deleted or is unavailable". The footer mostly escapes it only
 * because its blocks were written without the attribute.
 *
 * Pointing the attribute at the active theme is enough: the part is then
 * looked up in this theme's directory first and the parent's second, so the
 * parent's own parts/*.html still answer.
 *
 * @param string $content Template or template part content.
 * @return string
 */
function material_energy_retheme_parts( $content ) {

	if ( get_stylesheet() === get_template() || ! is_string( $content ) || '' === $content ) {
		return $content;
	}

	return str_replace(
		'"theme":"' . get_template() . '"',
		'"theme":"' . get_stylesheet() . '"',
		$content
	);
}

/**
 * Apply it to a single template or template part as it is loaded from file.
 *
 * @param WP_Block_Template|null $template The template.
 * @return WP_Block_Template|null
 */
function material_energy_fix_file_template( $template ) {

	if ( $template instanceof WP_Block_Template ) {
		$template->content = material_energy_retheme_parts( $template->content );
	}

	return $template;
}
add_filter( 'get_block_file_template', 'material_energy_fix_file_template' );

/**
 * And to every template in a list, which is what the Site Editor reads.
 *
 * @param WP_Block_Template[] $templates The templates.
 * @return WP_Block_Template[]
 */
function material_energy_fix_templates( $templates ) {

	foreach ( $templates as $template ) {
		if ( $template instanceof WP_Block_Template ) {
			$template->content = material_energy_retheme_parts( $template->content );
		}
	}

	return $templates;
}
add_filter( 'get_block_templates', 'material_energy_fix_templates' );

/**
 * A last guard at render time, for a template part block that reaches the
 * renderer without having passed through either filter — a template saved in
 * the database before this theme was activated, for instance.
 *
 * @param array $parsed_block The block about to render.
 * @return array
 */
function material_energy_fix_rendered_part( $parsed_block ) {

	if ( ! empty( $parsed_block['blockName'] )
		&& 'core/template-part' === $parsed_block['blockName']
		&& ! empty( $parsed_block['attrs']['theme'] )
		&& get_template() === $parsed_block['attrs']['theme']
		&& get_stylesheet() !== get_template()
	) {
		$parsed_block['attrs']['theme'] = get_stylesheet();
	}

	return $parsed_block;
}
add_filter( 'render_block_data', 'material_energy_fix_rendered_part' );

/**
 * Give the editor the same pair of stylesheets, in the same order as the
 * front end, so the header and banner look there exactly as they render.
 *
 * The parent hooks enqueue_block_assets at the default priority; running
 * after it means its mis-pointed handle is already in the queue to be
 * dropped and replaced.
 */
function material_energy_editor_assets() {

	if ( ! is_admin() ) {
		return;
	}

	material_energy_stylesheets();
}
add_action( 'enqueue_block_assets', 'material_energy_editor_assets', 20 );

/**
 * Repair the section badge that WordPress rewrites on every save.
 *
 * The "What We Do" badge in the parent theme's patterns is a paragraph whose
 * alignment is held in the block's own attributes, under
 * style.typography.textAlign. WordPress turns that into a class,
 * has-text-align-center, and emits no inline rule for it — the style engine
 * has no text-align entry at all. The pattern's markup does the opposite: it
 * carries the inline rule and leaves the class out.
 *
 * A block whose markup does not match what its attributes would produce is
 * invalid, and WordPress rewrites it when the page is saved. That rewrite is
 * what leaves an empty copy of the badge above the real one, and why another
 * appears every time the page is updated.
 *
 * This puts the markup back in step with the attributes. It is done here
 * rather than in the parent theme because the parent cannot be changed.
 *
 * @param string $content Block markup.
 * @return string
 */
function material_energy_repair_eyebrow( $content ) {

	if ( ! is_string( $content ) || ( false === strpos( $content, 'wp:paragraph' ) && false === strpos( $content, 'wp:columns' ) ) ) {
		return $content;
	}

	/*
	 * Give the paragraph the class WordPress generates from its own
	 * attributes, and take the inline rule back out. Any paragraph that holds
	 * its alignment this way is treated the same, whether or not it is one of
	 * the badges.
	 */
	$content = preg_replace_callback(
		'#(<!--\s*wp:paragraph\s+\{[^\r\n]*?"textAlign":"([a-z]+)"[^\r\n]*?\}\s*-->\s*<p)([^>]*)(>)#',
		static function ( $matches ) {
			$attributes = $matches[3];
			$class      = 'has-text-align-' . $matches[2];

			if ( false === strpos( $attributes, $class ) ) {
				if ( false !== strpos( $attributes, 'class="' ) ) {
					$attributes = preg_replace( '/class="([^"]*)"/', 'class="$1 ' . $class . '"', $attributes, 1 );
				} else {
					$attributes = ' class="' . $class . '"' . $attributes;
				}
			}

			$attributes = preg_replace( '/\s*text-align\s*:\s*[a-z]+\s*;?/', '', $attributes );
			$attributes = preg_replace( '/\s*style="\s*"/', '', $attributes );
			$attributes = preg_replace( '/style="([^"]*?);\s*"/', 'style="$1"', $attributes );

			return $matches[1] . $attributes . $matches[4];
		},
		$content
	);

	/*
	 * The row of plans in the pricing pattern has the same kind of mismatch:
	 * a top margin set in the block's attributes that never made it into the
	 * markup. Left alone it is rewritten on save like the badge was, and the
	 * gap above the cards goes with it. Only a block with no inline styles at
	 * all is touched, so nothing already written there can be overwritten.
	 */
	$content = preg_replace_callback(
		'#(<!--\s*wp:columns\s+\{[^\r\n]*?"margin":\{([^{}]*)\}[^\r\n]*?\}\s*-->\s*<div\s+class="wp-block-columns)([^>]*)(>)#',
		static function ( $matches ) {
			if ( false !== strpos( $matches[3], 'style=' ) ) {
				return $matches[0];
			}

			$rules = array();

			foreach ( array( 'top', 'right', 'bottom', 'left' ) as $side ) {
				if ( preg_match( '/"' . $side . '":"([^"]+)"/', $matches[2], $found ) ) {
					$rules[] = 'margin-' . $side . ':' . $found[1];
				}
			}

			if ( ! $rules ) {
				return $matches[0];
			}

			return $matches[1] . $matches[3] . ' style="' . implode( ';', $rules ) . '"' . $matches[4];
		},
		$content
	);

	/*
	 * And clear out the empty badges an earlier save already left behind.
	 * Only a badge with nothing at all in it is removed; one with a word in it
	 * is the real thing.
	 */
	$content = preg_replace(
		'#<!--\s*wp:paragraph\s+\{[^\r\n]*?\}\s*-->\s*<p[^>]*class="[^"]*\bmai-eyebrow\b[^"]*"[^>]*>\s*</p>\s*<!--\s*/wp:paragraph\s*-->\s*#',
		'',
		$content
	);

	return $content;
}

/**
 * Hand the corrected markup to the patterns themselves.
 *
 * The parent's patterns are registered from its own files, and there is no
 * filter on their content, so each one is read back out of the registry,
 * repaired, and registered again in place. Nothing is copied into this theme:
 * the patterns stay the parent's, with the one fault taken out of them.
 *
 * Runs after _register_theme_block_patterns(), which is on init at the
 * default priority.
 */
function material_energy_repair_registered_patterns() {

	if ( ! class_exists( 'WP_Block_Patterns_Registry' ) ) {
		return;
	}

	$registry = WP_Block_Patterns_Registry::get_instance();
	$prefix   = get_template() . '/';

	foreach ( $registry->get_all_registered() as $pattern ) {

		if ( empty( $pattern['name'] ) || 0 !== strpos( $pattern['name'], $prefix ) ) {
			continue;
		}

		if ( empty( $pattern['content'] ) ) {
			continue;
		}

		$repaired = material_energy_repair_eyebrow( $pattern['content'] );

		if ( $repaired === $pattern['content'] ) {
			continue;
		}

		$name               = $pattern['name'];
		$pattern['content'] = $repaired;

		unregister_block_pattern( $name );
		register_block_pattern( $name, $pattern );
	}
}
add_action( 'init', 'material_energy_repair_registered_patterns', 20 );

/**
 * Repair a page as it is saved.
 *
 * Fixing the patterns stops the fault reaching anything built from now on, but
 * a page saved earlier keeps its own copy of the markup, and no theme update
 * reaches that. Repairing the content on its way into the database mends those
 * pages the next time they are saved, and clears the empty badges already in
 * them.
 *
 * @param array $data Slashed post data about to be written.
 * @return array
 */
function material_energy_repair_saved_content( $data ) {

	if ( empty( $data['post_content'] ) || false === strpos( $data['post_content'], 'mai-' ) ) {
		return $data;
	}

	$content  = wp_unslash( $data['post_content'] );
	$repaired = material_energy_repair_eyebrow( $content );

	if ( $repaired !== $content ) {
		$data['post_content'] = wp_slash( $repaired );
	}

	return $data;
}
add_filter( 'wp_insert_post_data', 'material_energy_repair_saved_content' );

/**
 * Show this theme's logo while the site has no logo of its own.
 *
 * The Site Logo block prints nothing when no logo is set under Site
 * Identity, which would leave the navigation bar's dark panel with only the
 * site title. Until a logo is chosen, the bundled Material Energy logo
 * stands in; a logo of the site's own always wins. The width set on the
 * block is honoured, as it would be for an uploaded logo.
 *
 * @param string $block_content Rendered Site Logo block.
 * @param array  $block         The block, with its attributes.
 * @return string
 */
function material_energy_default_logo( $block_content, $block = array() ) {

	if ( '' !== trim( $block_content ) || has_custom_logo() ) {
		return $block_content;
	}

	$path = get_theme_file_path( 'assets/images/energy/logo.png' );
	$size = is_readable( $path ) ? wp_getimagesize( $path ) : false;

	if ( ! $size ) {
		return $block_content;
	}

	if ( ! empty( $block['attrs']['width'] ) ) {
		$width   = (int) $block['attrs']['width'];
		$size[1] = (int) round( $size[1] * $width / $size[0] );
		$size[0] = $width;
	}

	return sprintf(
		'<div class="wp-block-site-logo"><a href="%1$s" class="custom-logo-link" rel="home"><img src="%2$s" class="custom-logo" alt="%3$s" width="%4$d" height="%5$d" decoding="async" /></a></div>',
		esc_url( home_url( '/' ) ),
		esc_url( get_theme_file_uri( 'assets/images/energy/logo.png' ) ),
		esc_attr( get_bloginfo( 'name', 'display' ) ),
		(int) $size[0],
		(int) $size[1]
	);
}
add_filter( 'render_block_core/site-logo', 'material_energy_default_logo', 10, 2 );

/**
 * Show the same logo in the editor's empty Site Logo placeholder, so the
 * Site Editor previews the header as the site shows it.
 */
function material_energy_editor_logo() {

	if ( ! is_admin() || has_custom_logo() ) {
		return;
	}

	wp_add_inline_style(
		'material-energy',
		sprintf(
			'.wp-block-site-logo .components-placeholder{min-height:48px;background:url("%s") left center / contain no-repeat !important;box-shadow:none !important;}.wp-block-site-logo .components-placeholder > *{opacity:0;}',
			esc_url( get_theme_file_uri( 'assets/images/energy/logo.png' ) )
		)
	);
}
add_action( 'enqueue_block_assets', 'material_energy_editor_logo', 30 );

/**
 * Swap the footer's bundled Material AI logo for this theme's.
 *
 * Only the parent's own footer logo file is replaced, so an image picked for
 * the footer in the editor is never touched. The aspect ratio the Image
 * block writes is updated too, or the new logo would be squeezed into the
 * old one's proportions.
 *
 * @param string $block_content Rendered Image block.
 * @return string
 */
function material_energy_footer_logo( $block_content ) {

	$default = '/assets/images/footer/footer-logo.png';

	if ( false === strpos( $block_content, $default ) ) {
		return $block_content;
	}

	$path = get_theme_file_path( 'assets/images/energy/logo.png' );
	$size = is_readable( $path ) ? wp_getimagesize( $path ) : false;

	if ( ! $size ) {
		return $block_content;
	}

	$block_content = str_replace(
		esc_url( get_template_directory_uri() ) . $default,
		esc_url( get_theme_file_uri( 'assets/images/energy/logo.png' ) ),
		$block_content
	);

	return preg_replace(
		'/aspect-ratio:\s*[0-9.]+/',
		'aspect-ratio:' . round( $size[0] / $size[1], 4 ),
		$block_content,
		1
	);
}
add_filter( 'render_block_core/image', 'material_energy_footer_logo' );

/**
 * Relative luminance of a hex colour, as WCAG defines it.
 *
 * @param string $hex A colour such as #ADF025 (3- or 6-digit, # optional).
 * @return float|null 0 (black) to 1 (white), or null when it is not a hex colour.
 */
function material_energy_luminance( $hex ) {

	$hex = ltrim( trim( (string) $hex ), '#' );

	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}

	if ( ! preg_match( '/^[0-9a-f]{6}/i', $hex ) ) {
		return null;
	}

	$channels = array();

	foreach ( array( 0, 2, 4 ) as $offset ) {
		$c          = hexdec( substr( $hex, $offset, 2 ) ) / 255;
		$channels[] = $c <= 0.03928 ? $c / 12.92 : pow( ( $c + 0.055 ) / 1.055, 2.4 );
	}

	return 0.2126 * $channels[0] + 0.7152 * $channels[1] + 0.0722 * $channels[2];
}

/**
 * Contrast ratio between two luminances.
 *
 * @param float $a Luminance.
 * @param float $b Luminance.
 * @return float 1 to 21.
 */
function material_energy_contrast( $a, $b ) {

	return ( max( $a, $b ) + 0.05 ) / ( min( $a, $b ) + 0.05 );
}

/**
 * The palette in use, by slug: the theme's, or a style variation's or the
 * colours picked under Styles, whichever the site has.
 *
 * @return array<string,string> Slug => colour.
 */
function material_energy_palette() {

	$palette = wp_get_global_settings( array( 'color', 'palette' ) );
	$colours = array();

	foreach ( array( 'default', 'theme', 'custom' ) as $origin ) {
		if ( empty( $palette[ $origin ] ) || ! is_array( $palette[ $origin ] ) ) {
			continue;
		}

		foreach ( $palette[ $origin ] as $entry ) {
			if ( isset( $entry['slug'], $entry['color'] ) ) {
				$colours[ $entry['slug'] ] = $entry['color'];
			}
		}
	}

	return $colours;
}

/**
 * The primary colour this theme ships with, from its own theme.json.
 *
 * @return string
 */
function material_energy_default_primary() {

	$data = wp_json_file_decode( get_stylesheet_directory() . '/theme.json', array( 'associative' => true ) );

	foreach ( (array) ( isset( $data['settings']['color']['palette'] ) ? $data['settings']['color']['palette'] : array() ) as $entry ) {
		if ( isset( $entry['slug'], $entry['color'] ) && 'primary' === $entry['slug'] ) {
			return strtolower( $entry['color'] );
		}
	}

	return '';
}

/**
 * Is the site on a palette other than the one this theme ships with — a
 * style variation, or colours picked under Styles?
 *
 * @return bool
 */
function material_energy_is_repainted() {

	$colours = material_energy_palette();
	$default = material_energy_default_primary();

	return isset( $colours['primary'] ) && '' !== $default && strtolower( $colours['primary'] ) !== $default;
}

/**
 * Colours worked out from the palette in use, for every style variation.
 *
 * The design puts type and glyphs on the primary colour in several places —
 * the NEW tag, the cart count, the hover fills, the hero buttons' discs, the
 * breadcrumb's home disc. Navy reads on the lime this theme ships with, but
 * not on the darker primaries of variations such as Royal Blue or Red, so
 * the colour is chosen here: whichever of the palette's secondary and light
 * colours stands out more against the primary.
 *
 * The highlight icons are drawn on white discs; they take the primary
 * colour where it shows against white, and its darker shade where it does
 * not (a light primary such as Amber). And a dark primary is lifted toward
 * white where it is set as type over the photograph.
 *
 * @return string CSS custom properties for :root.
 */
function material_energy_palette_css() {

	$colours = material_energy_palette();

	if ( empty( $colours['primary'] ) ) {
		return '';
	}

	$primary   = material_energy_luminance( $colours['primary'] );
	$secondary = isset( $colours['secondary'] ) ? material_energy_luminance( $colours['secondary'] ) : null;
	$light     = isset( $colours['light-color'] ) ? material_energy_luminance( $colours['light-color'] ) : 1.0;

	if ( null === $primary ) {
		return '';
	}

	$on_primary = 'var(--wp--preset--color--secondary)';

	if ( null === $secondary || material_energy_contrast( $primary, $light ) > material_energy_contrast( $primary, $secondary ) ) {
		$on_primary = 'var(--wp--preset--color--light-color)';
	}

	$icon_ink = material_energy_contrast( $primary, 1.0 ) >= 2.4 || empty( $colours['primary-shade-2'] )
		? 'var(--wp--preset--color--primary)'
		: 'var(--wp--preset--color--primary-shade-2)';

	/*
	 * A dark primary that carries light type would also be dark on the hero
	 * photograph, where the headline's highlighted word is set in it, so
	 * there it is lifted toward white.
	 */
	$primary_ink = 'var(--wp--preset--color--light-color)' === $on_primary
		? 'color-mix(in srgb, var(--wp--preset--color--primary) 60%, var(--wp--preset--color--light-color))'
		: 'var(--wp--preset--color--primary)';

	return ':root{--mai-on-primary:' . $on_primary . ';--mai-icon-ink:' . $icon_ink . ';--mai-primary-ink:' . $primary_ink . ';}';
}

/**
 * Print those colours after this theme's stylesheet, on the site and in the
 * editor.
 */
function material_energy_palette_styles() {

	$css = material_energy_palette_css();

	if ( '' !== $css && wp_style_is( 'material-energy', 'enqueued' ) ) {
		wp_add_inline_style( 'material-energy', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'material_energy_palette_styles', 30 );
add_action( 'enqueue_block_assets', 'material_energy_palette_styles', 30 );

/**
 * Mark the page when a style variation or picked colours are in use, so the
 * bundled highlight icons — pictures drawn in this theme's greens — can be
 * repainted in the palette's colour.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function material_energy_repainted_body_class( $classes ) {

	if ( material_energy_is_repainted() ) {
		$classes[] = 'material-energy-repainted';
	}

	return $classes;
}
add_filter( 'body_class', 'material_energy_repainted_body_class' );

/**
 * Hand each bundled highlight icon to the stylesheet as a mask.
 *
 * Only this theme's own icon files are touched; a picture chosen in the
 * editor is left exactly as it is. The address goes into a custom property
 * on the figure at render time, so the saved block markup never changes.
 *
 * @param string $block_content Rendered Image block.
 * @return string
 */
function material_energy_icon_mask( $block_content ) {

	if ( false === strpos( $block_content, 'materialai-spa-feature__icon' ) || ! class_exists( 'WP_HTML_Tag_Processor' ) ) {
		return $block_content;
	}

	$base = get_theme_file_uri( 'assets/images/energy/' );

	if ( ! preg_match( '/<img\b[^>]*\bsrc="([^"]+)"/i', $block_content, $match ) || 0 !== strpos( html_entity_decode( $match[1] ), $base ) ) {
		return $block_content;
	}

	$tags = new WP_HTML_Tag_Processor( $block_content );

	if ( $tags->next_tag( 'figure' ) ) {
		$style = (string) $tags->get_attribute( 'style' );
		$tags->set_attribute( 'style', trim( $style . ';--mai-icon:url("' . esc_url( html_entity_decode( $match[1] ) ) . '")', ';' ) );
	}

	return $tags->get_updated_html();
}
add_filter( 'render_block_core/image', 'material_energy_icon_mask' );
