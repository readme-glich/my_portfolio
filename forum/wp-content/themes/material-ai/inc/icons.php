<?php
/**
 * MaterialAI icon library.
 *
 * Registers the "materialai" icon collection and 1200 Material Symbols (1000 outlined + 200 filled)
 * icons for the SVG Icon API introduced in WordPress 7.1. On older
 * WordPress versions this is a no-op.
 *
 * @package MaterialAI
 */

/**
 * Register the MaterialAI icon collection and its icons.
 *
 * @return void
 */
function materialai_register_icons() {
	// The public SVG Icon API ships in WordPress 7.1.
	if ( ! function_exists( 'wp_register_icon_collection' ) || ! function_exists( 'wp_register_icon' ) ) {
		return;
	}

	wp_register_icon_collection(
		'materialai',
		array(
			'label'       => __( 'MaterialAI', 'material-ai' ),
			'description' => __( 'Material Symbols icons bundled with the MaterialAI theme.', 'material-ai' ),
		)
	);

	$icons = require get_theme_file_path( 'inc/icons-manifest.php' );
	$dir   = trailingslashit( get_theme_file_path( 'assets/icons/materialai' ) );

	foreach ( $icons as $name => $label ) {
		wp_register_icon(
			'materialai/' . $name,
			array(
				'label'     => $label,
				'file_path' => $dir . $name . '.svg',
			)
		);
	}
}
add_action( 'init', 'materialai_register_icons' );
