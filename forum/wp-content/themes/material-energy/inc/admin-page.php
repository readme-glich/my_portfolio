<?php
/**
 * Make the parent's theme dashboard describe this theme.
 *
 * Material AI ships its own dashboard (Appearance > Material AI Theme). It
 * reads its version, screenshot and links from the parent, so under this
 * child theme it showed Material AI's version, Material AI's screenshot and
 * Material AI's links. The parent cannot be changed, so the page is left to
 * render exactly as it does and its output is corrected on the way out:
 *
 * - the parent's version becomes this theme's version;
 * - the parent's screenshot becomes this theme's screenshot;
 * - the parent's name becomes this theme's name ("Material AI Pro" is kept,
 *   since that is a product of its own);
 * - links are pointed at this theme's own URLs, set once in
 *   material_energy_admin_page_config() below.
 *
 * Everything is read from this theme's style.css header and the array below,
 * so a new release only needs its Version bumped there — nothing in the
 * parent ever has to be touched again.
 *
 * The page is found by who registered it, not by its slug: whichever admin
 * page has its callback defined inside the parent theme's folder. So a slug
 * change in a future parent release is followed automatically.
 *
 * @package Material_Energy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * What the parent's dashboard should show for this theme.
 *
 * 'links' are matched by the button's visible text, exactly as it appears on
 * the parent's dashboard (case and spacing do not matter). Leave a URL empty
 * to keep the parent's link for that button.
 *
 * 'urls' swaps one exact URL for another, anywhere on the page — for a link
 * that has no text of its own, an image, or anything 'links' cannot reach.
 *
 * Both can also be changed from outside through the
 * 'material_energy_admin_page' filter.
 *
 * @return array
 */
function material_energy_admin_page_config() {

	$theme = wp_get_theme();

	$config = array(

		// Swap the parent's name for this theme's in the page text.
		'name'       => true,

		// Rename the parent's Pro too: "Material AI Pro" becomes
		// "Material Energy Pro". False keeps "Material AI Pro" as it is.
		'name_pro'   => true,

		// Swap the parent's version for this theme's.
		'version'    => true,

		// Swap the parent's screenshot for this theme's.
		'screenshot' => true,

		// Point WordPress.org links (reviews, support, theme page) at this
		// theme's own listing instead of the parent's.
		'wporg'      => true,

		// In every link that leaves this site, put this theme's slug where
		// the parent's is: material-ai and materialai both become
		// material-energy, the form nayrathemes.com uses for this theme
		// (nayrathemes.com/demo/pro/material-energy). Links inside
		// this site's admin are never touched.
		'slug_urls'  => true,

		// Button text, as the parent writes it => this theme's URL.
		// A URL here wins over every automatic rule above. Empty leaves the
		// automatic rules to decide.
		'links'      => array(
			'Visit Theme Website' => $theme->get( 'ThemeURI' ),
			'View Live Demo'      => 'https://nayrathemes.com/demo/pro/material-energy',
			'Buy Pro'             => '',
			'Get Material AI Pro' => '',
			'View Pro Demo'       => 'https://nayrathemes.com/demo/pro/material-energy',
			'Free Documentation'  => '',
			'Go to Docs'          => '',
			'Please Rate Us'      => '',
		),

		// Parent URL => this theme's URL, swapped wherever it appears.
		'urls'       => array(),
	);

	return apply_filters( 'material_energy_admin_page', $config );
}

/**
 * Where a hooked callback was defined.
 *
 * @param callable $callback A callback as stored in $wp_filter.
 * @return string Normalised file path, or '' when it cannot be told.
 */
function material_energy_callback_file( $callback ) {

	try {
		if ( is_string( $callback ) && false !== strpos( $callback, '::' ) ) {
			$callback = explode( '::', $callback, 2 );
		}

		if ( is_array( $callback ) && 2 === count( $callback ) ) {
			$reflection = new ReflectionMethod( $callback[0], $callback[1] );
		} elseif ( $callback instanceof Closure || ( is_string( $callback ) && function_exists( $callback ) ) ) {
			$reflection = new ReflectionFunction( $callback );
		} elseif ( is_object( $callback ) && method_exists( $callback, '__invoke' ) ) {
			$reflection = new ReflectionMethod( $callback, '__invoke' );
		} else {
			return '';
		}
	} catch ( ReflectionException $e ) {
		return '';
	}

	$file = $reflection->getFileName();

	return $file ? wp_normalize_path( $file ) : '';
}

/**
 * Find the admin page being loaded and, if the parent theme drew it, wrap its
 * output so it can be corrected.
 *
 * admin_init runs after the menus are registered and before the page's own
 * hook fires, which is the window where both are known.
 */
function material_energy_admin_page_watch() {

	global $plugin_page, $pagenow, $typenow, $wp_filter;

	if ( get_stylesheet() === get_template() || empty( $plugin_page ) ) {
		return;
	}

	// The same lookup wp-admin/admin.php makes to find the page's hook.
	$the_parent = empty( $typenow ) ? $pagenow : $pagenow . '?post_type=' . $typenow;
	$hook       = get_plugin_page_hook( $plugin_page, $the_parent );

	if ( ! $hook ) {
		$hook = get_plugin_page_hook( $plugin_page, $plugin_page );
	}

	if ( ! $hook || empty( $wp_filter[ $hook ] ) ) {
		return;
	}

	$parent_dir = trailingslashit( wp_normalize_path( get_template_directory() ) );
	$owned      = false;

	foreach ( $wp_filter[ $hook ]->callbacks as $callbacks ) {
		foreach ( $callbacks as $callback ) {
			if ( 0 === strpos( material_energy_callback_file( $callback['function'] ), $parent_dir ) ) {
				$owned = true;
				break 2;
			}
		}
	}

	if ( ! $owned ) {
		return;
	}

	add_action( $hook, 'material_energy_admin_page_start', -99999 );
	add_action( $hook, 'material_energy_admin_page_end', 99999 );
}
add_action( 'admin_init', 'material_energy_admin_page_watch', 99 );

/**
 * Start holding the parent's page output.
 */
function material_energy_admin_page_start() {

	$GLOBALS['material_energy_ob_level'] = ob_get_level();
	ob_start();
}

/**
 * Print the parent's page output, corrected.
 */
function material_energy_admin_page_end() {

	if ( ! isset( $GLOBALS['material_energy_ob_level'] ) || ob_get_level() <= $GLOBALS['material_energy_ob_level'] ) {
		return;
	}

	$html = ob_get_clean();

	echo material_energy_rewrite_admin_page( $html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- the parent's own markup, already escaped by it.
}

/**
 * Normalise a button's text so it can be compared.
 *
 * @param string $text Text or markup.
 * @return string
 */
function material_energy_link_label( $text ) {

	$text = html_entity_decode( wp_strip_all_tags( $text ), ENT_QUOTES, 'UTF-8' );
	$text = preg_replace( '/\s+/u', ' ', $text );

	return strtolower( trim( $text ) );
}

/**
 * Put this theme's version, screenshot, name and links into the parent's
 * dashboard markup.
 *
 * @param string $html The page as the parent drew it.
 * @return string
 */
function material_energy_rewrite_admin_page( $html ) {

	if ( ! is_string( $html ) || '' === $html ) {
		return $html;
	}

	$config = material_energy_admin_page_config();
	$child  = wp_get_theme();
	$parent = wp_get_theme( get_template() );

	/*
	 * Links by their text. Done first, while the text still reads exactly as
	 * the parent wrote it.
	 */
	$links = array();

	foreach ( (array) $config['links'] as $label => $url ) {
		if ( '' !== (string) $url ) {
			$links[ material_energy_link_label( $label ) ] = $url;
		}
	}

	if ( $links ) {
		$html = preg_replace_callback(
			'#<a\b([^>]*)>(.*?)</a>#is',
			static function ( $matches ) use ( $links ) {
				$label = material_energy_link_label( $matches[2] );

				if ( ! isset( $links[ $label ] ) ) {
					return $matches[0];
				}

				$href  = 'href="' . esc_url( $links[ $label ] ) . '"';
				$attrs = preg_replace( '#\bhref\s*=\s*(["\']).*?\1#is', $href, $matches[1], 1, $count );

				if ( ! $count ) {
					$attrs .= ' ' . $href;
				}

				return '<a' . $attrs . '>' . $matches[2] . '</a>';
			},
			$html
		);
	}

	/*
	 * The screenshot, however the parent wrote its address: with or without a
	 * scheme, with a query string, or with its slashes escaped inside JSON.
	 */
	$shot = $config['screenshot'] ? $child->get_screenshot() : '';

	if ( $shot ) {
		$shot = add_query_arg( 'ver', $child->get( 'Version' ), $shot );
		$base = preg_replace( '#^https?:#i', '', get_template_directory_uri() ) . '/screenshot.';

		foreach ( array( $base, str_replace( '/', '\/', $base ) ) as $variant ) {
			$html = preg_replace(
				'#(?:https?:)?' . preg_quote( $variant, '#' ) . '(?:png|jpe?g|gif|webp)(?:\?[^"\'\s<>)]*)?#i',
				esc_url( $shot ),
				$html
			);
		}
	}

	// Exact URL swaps, the theme's own Theme URI among them.
	$urls = (array) $config['urls'];

	$parent_uri = $parent->get( 'ThemeURI' );
	$child_uri  = $child->get( 'ThemeURI' );

	if ( $parent_uri && $child_uri && $parent_uri !== $child_uri && ! isset( $urls[ $parent_uri ] ) ) {
		$urls[ $parent_uri ] = $child_uri;
	}

	foreach ( $urls as $from => $to ) {
		if ( '' === (string) $from || '' === (string) $to ) {
			continue;
		}

		$html = str_replace(
			array( $from, esc_url( $from ), str_replace( '/', '\/', $from ) ),
			array( $to, esc_url( $to ), str_replace( '/', '\/', $to ) ),
			$html
		);
	}

	// WordPress.org listings: reviews, support forum and the theme page.
	if ( $config['wporg'] ) {
		$html = preg_replace(
			'#(WordPress\.org/(?:support/)?themes?/)' . preg_quote( get_template(), '#' ) . '(?=[/"\'?\#&]|$)#i',
			'${1}' . get_stylesheet(),
			$html
		);
	}

	// The parent's slug in outgoing links, swapped for this theme's.
	if ( ! empty( $config['slug_urls'] ) ) {
		$html = material_energy_swap_link_slugs( $html, array_map( 'material_energy_link_label', array_keys( $links ) ) );
	}

	/*
	 * Name and version, in the visible text only. Attributes — classes, asset
	 * URLs, data — are left exactly as the parent wrote them.
	 */
	$replace   = array();
	$name_rule = array();

	if ( $config['version'] ) {
		$from = (string) $parent->get( 'Version' );
		$to   = (string) $child->get( 'Version' );

		if ( '' !== $from && '' !== $to && $from !== $to ) {
			$replace[ '/(?<![\w.])' . preg_quote( $from, '/' ) . '(?!\w|\.\d)/u' ] = $to;
		}
	}

	if ( $config['name'] ) {
		$from = (string) $parent->get( 'Name' );
		$to   = (string) $child->get( 'Name' );

		if ( '' !== $from && '' !== $to && $from !== $to ) {
			// "Material AI Pro" stays unless 'name_pro' says otherwise.
			$keep_pro = empty( $config['name_pro'] ) ? '(?!\s*Pro\b)' : '';

			$name_rule = array( '/(?<![\w-])' . preg_quote( $from, '/' ) . $keep_pro . '(?![\w-])/u' => $to );
			$replace   = array_merge( $replace, $name_rule );
		}
	}

	if ( $replace ) {
		$html = preg_replace_callback(
			'#(<(script|style|textarea)\b.*?</\2>)|>([^<]+)(?=<)#is',
			static function ( $matches ) use ( $replace ) {
				if ( ! empty( $matches[1] ) ) {
					return $matches[0];
				}

				return '>' . preg_replace( array_keys( $replace ), array_values( $replace ), $matches[3] );
			},
			$html
		);

		// And the text that is read out rather than shown: alt, title and
		// aria-label. Only the name is swapped there, never the version.
		if ( ! empty( $name_rule ) ) {
			$name = $name_rule;

			$html = preg_replace_callback(
				'#\b(alt|title|aria-label)=(["\'])(.*?)\2#is',
				static function ( $matches ) use ( $name ) {
					return $matches[1] . '=' . $matches[2] . preg_replace( array_keys( $name ), array_values( $name ), $matches[3] ) . $matches[2];
				},
				$html
			);
		}
	}

	return $html;
}

/**
 * Put this theme's slug where the parent's is, in every link that leaves the
 * site.
 *
 * Covers the three ways the slug is written — material-ai, materialai and
 * material_ai — each swapped for the same form of this theme's slug. Links to
 * this site (the admin's own tabs, the Site Editor, the parent's files) keep
 * the parent's slug, since that is where those things really live.
 *
 * @param string   $html  The page.
 * @param string[] $fixed Labels of buttons already given a URL of their own.
 * @return string
 */
function material_energy_swap_link_slugs( $html, $fixed = array() ) {

	$from = get_template();
	$to   = get_stylesheet();

	$pairs = array();

	// material-ai and materialai both become material-energy: that is how
	// nayrathemes.com writes this theme's addresses. material_ai keeps its
	// underscore.
	$pairs = array(
		$from                        => $to,
		str_replace( '-', '', $from ) => $to,
		str_replace( '-', '_', $from ) => str_replace( '-', '_', $to ),
	);

	$home = wp_parse_url( home_url(), PHP_URL_HOST );

	return preg_replace_callback(
		'#<a\b([^>]*)>(.*?)</a>#is',
		static function ( $matches ) use ( $pairs, $home, $fixed ) {

			if ( in_array( material_energy_link_label( $matches[2] ), $fixed, true ) ) {
				return $matches[0];
			}

			$attrs = preg_replace_callback(
				'#\bhref\s*=\s*(["\'])(.*?)\1#is',
				static function ( $href ) use ( $pairs, $home ) {
					$url  = html_entity_decode( $href[2], ENT_QUOTES, 'UTF-8' );
					$host = wp_parse_url( $url, PHP_URL_HOST );

					// Relative, or on this site: leave it.
					if ( ! $host || ( $home && 0 === strcasecmp( $host, $home ) ) ) {
						return $href[0];
					}

					foreach ( $pairs as $old => $new ) {
						$url = preg_replace( '#(?<![a-z0-9])' . preg_quote( $old, '#' ) . '(?![a-z0-9])#i', $new, $url );
					}

					return 'href=' . $href[1] . esc_url( $url ) . $href[1];
				},
				$matches[1]
			);

			return '<a' . $attrs . '>' . $matches[2] . '</a>';
		},
		$html
	);
}
