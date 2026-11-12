<?php
/**
 * Material AI theme info / welcome page.
 *
 * Adds a single "Material AI Theme" page under Appearance with getting
 * started links, a Free vs Pro comparison, the bundled pattern list and
 * help / upgrade links. No options are stored and no remote resources
 * are loaded.
 *
 * @package Material AI
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the theme info page under Appearance.
 */
function materialai_info_add_page() {
	add_theme_page(
		__( 'Material AI Theme', 'material-ai' ),
		__( 'Material AI Theme', 'material-ai' ),
		'edit_theme_options',
		'material-ai-info',
		'materialai_info_render_page'
	);
}
add_action( 'admin_menu', 'materialai_info_add_page' );

/**
 * Enqueue the info page assets only on its own screen.
 *
 * @param string $hook_suffix Current admin page hook suffix.
 */
function materialai_info_assets( $hook_suffix ) {
	if ( 'appearance_page_material-ai-info' !== $hook_suffix ) {
		return;
	}

	$materialai_version = wp_get_theme( get_template() )->get( 'Version' );
	$materialai_asset_version = $materialai_version . '-' . filemtime( get_template_directory() . '/inc/theme-info/theme-info.css' );

	wp_enqueue_style(
		'materialai-info',
		get_template_directory_uri() . '/inc/theme-info/theme-info.css',
		array(),
		$materialai_asset_version
	);

	wp_enqueue_script(
		'materialai-info',
		get_template_directory_uri() . '/inc/theme-info/theme-info.js',
		array(),
		$materialai_version,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'materialai_info_assets' );

/**
 * Helper: important theme URLs in one place.
 *
 * @return array<string,string>
 */
function materialai_info_urls() {
	return array(
		'pro'       => 'https://www.nayrathemes.com/materialai-pro/',
		'free_home' => 'https://www.nayrathemes.com/materialai-free/',
		'demo_free' => 'https://nayrathemes.com/demo/lite/materialai/',
		'demo_pro'  => 'https://nayrathemes.com/demo/pro/materialai/',
		'docs'      => 'https://help.nayrathemes.com/',
		'support'   => 'https://nayrathemes.ticksy.com/',
		'forum'     => 'https://wordpress.org/support/theme/material-ai/',
		'rate'      => 'https://wordpress.org/support/theme/material-ai/reviews/#new-post',
	);
}

/**
 * Helper: Site Editor deep link.
 *
 * @param array $args Query args for site-editor.php.
 * @return string
 */
function materialai_info_editor_link( $args = array() ) {
	return esc_url( add_query_arg( $args, admin_url( 'site-editor.php' ) ) );
}

/**
 * Discover published WordPress.org children of Material AI.
 * WordPress.org does not expose a parent-slug directory query: search the
 * publisher's catalog and relevant keywords, then verify each candidate.
 * Additional known slugs can be supplied using materialai_child_theme_slugs.
 *
 * @return array|WP_Error
 */
/**
 * Call the WordPress.org theme API with a scoped warning handler.
 * WordPress core emits E_USER_WARNING when the remote directory is unreachable;
 * record the warning and restore the previous handler without printing it in UI.
 * Other warnings remain governed by the site's normal PHP handler.
 */
function materialai_info_safe_themes_api( $action, $args ) {
	$warnings = array();
	set_error_handler(
		function ( $severity, $message ) use ( &$warnings ) {
			if ( E_USER_WARNING === $severity && false !== strpos( $message, 'themes_api()' ) ) {
				$warnings[] = $message;
				error_log( '[Material AI Child Themes] WordPress.org API warning: ' . wp_strip_all_tags( $message ) );
				return true;
			}
			return false;
		},
		E_USER_WARNING
	);
	try {
		$result = themes_api( $action, $args );
	} finally {
		restore_error_handler();
	}
	if ( ! empty( $warnings ) && ! is_wp_error( $result ) ) {
		return new WP_Error( 'materialai_directory_unavailable', __( 'WordPress.org could not be reached.', 'material-ai' ) );
	}
	return $result;
}

/**
 * Fetch or reuse the verified child-theme directory. Successful results are
 * persisted in an option, independent of expiring transients. Never overwrite
 * a known-good catalog with a failed/partial network response.
 *
 * @param bool $force Whether to query WordPress.org even when cache is fresh.
 * @return array|WP_Error Verified themes, or an error if no saved catalog exists.
 */
function materialai_info_directory_children( $force = false ) {
	$cache_key  = 'materialai_directory_children_v5';
	$backup_key = 'materialai_directory_children_last_success_v1';
	$status_key = 'materialai_directory_children_status_v1';
	$cached     = get_transient( $cache_key );
	$backup     = get_option( $backup_key, false );
	$backup     = is_array( $backup ) ? $backup : false;
	if ( ! $force && false !== $cached ) {
		return $cached;
	}
	if ( ! function_exists( 'themes_api' ) ) {
		require_once ABSPATH . 'wp-admin/includes/theme.php';
	}
	$slugs = apply_filters( 'materialai_child_theme_slugs', array( 'material-agency' ) );
	$slugs = is_array( $slugs ) ? $slugs : array( 'material-agency' );
	$queries = array(
		array( 'author' => 'nayrathemes' ),
		array( 'search' => 'material ai' ),
		array( 'search' => 'material-ai' ),
		array( 'search' => 'material agency' ),
	);
	$failed = false;
	$success_count = 0;
	foreach ( $queries as $query ) {
		for ( $page = 1; $page <= 10; $page++ ) {
			$args = array_merge( $query, array(
				'per_page' => 100,
				'page' => $page,
				'fields' => array( 'template' => true, 'parent' => true, 'description' => false, 'creation_time' => true ),
			) );
			$response = materialai_info_safe_themes_api( 'query_themes', $args );
			if ( is_wp_error( $response ) ) {
				$failed = true;
				break 2; // Offline: no need to issue many doomed requests.
			}
			$success_count++;
			if ( empty( $response->themes ) || ! is_array( $response->themes ) ) {
				break;
			}
			foreach ( $response->themes as $theme ) {
				if ( ! empty( $theme->slug ) && isset( $theme->template ) && 'material-ai' === $theme->template ) {
					$slugs[] = sanitize_key( $theme->slug );
				}
			}
			if ( count( $response->themes ) < 100 ) {
				break;
			}
		}
	}
	$found = array();
	if ( ! $failed ) {
		foreach ( array_unique( array_filter( array_map( 'sanitize_key', $slugs ) ) ) as $slug ) {
			$theme = materialai_info_safe_themes_api( 'theme_information', array(
				'slug' => $slug,
				'fields' => array( 'template' => true, 'parent' => true, 'screenshot_url' => true, 'description' => true, 'creation_time' => true ),
			) );
			if ( is_wp_error( $theme ) ) {
				$failed = true;
				break;
			}
			if ( ! empty( $theme->slug ) && $slug === sanitize_key( $theme->slug ) &&
				isset( $theme->template ) && 'material-ai' === $theme->template ) {
				$found[ $slug ] = $theme;
			}
		}
	}
	if ( $failed || 0 === $success_count ) {
		set_transient( $status_key, 'offline', 10 * MINUTE_IN_SECONDS );
		// Cool down failed lookups for five minutes to avoid repeated warnings.
		if ( false !== $backup ) {
			set_transient( $cache_key, $backup, 5 * MINUTE_IN_SECONDS );
			return $backup;
		}
		$unavailable = new WP_Error( 'materialai_directory_offline', __( 'The WordPress.org theme directory is currently unavailable.', 'material-ai' ) );
		set_transient( $cache_key, $unavailable, 5 * MINUTE_IN_SECONDS );
		return $unavailable;
	}
	uasort( $found, function ( $a, $b ) {
		return strcasecmp( $a->name, $b->name );
	} );
	update_option( $backup_key, $found, false );
	set_transient( $cache_key, $found, 12 * HOUR_IN_SECONDS );
	delete_transient( $status_key );
	return $found;
}

/** Refresh only when requested by an authorized user, and report the real outcome. */
function materialai_info_refresh_children() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		wp_die( esc_html__( 'You are not allowed to refresh this theme directory.', 'material-ai' ) );
	}
	check_admin_referer( 'materialai_refresh_children' );
	delete_transient( 'materialai_directory_children_v5' );
	$result = materialai_info_directory_children( true );
	$state = is_wp_error( $result ) || 'offline' === get_transient( 'materialai_directory_children_status_v1' ) ? 'offline' : 'success';
	set_transient( 'materialai_child_refresh_notice_' . get_current_user_id(), $state, MINUTE_IN_SECONDS * 2 );
	wp_safe_redirect( admin_url( 'themes.php?page=material-ai-info#child-themes' ) );
	exit;
}
add_action( 'admin_post_materialai_refresh_children', 'materialai_info_refresh_children' );

/** Display directory-backed child theme catalog with client-side browsing. */
function materialai_info_render_children() {
	$children = materialai_info_directory_children();
	$theme_count = is_wp_error( $children ) ? 0 : count( $children );
	$active_child = get_stylesheet() !== get_template() ? wp_get_theme( get_stylesheet() ) : false;
	?>
	<div class="materialai-card materialai-child-directory">
		<div class="materialai-child-showcase materialai-child-showcase-luxe">
			<div class="materialai-child-heading materialai-child-heading-luxe">
				<div class="materialai-child-heading-copy">
					<span class="materialai-child-eyebrow"><?php esc_html_e( 'THEME COLLECTION', 'material-ai' ); ?></span>
					<h2><?php esc_html_e( 'Child Themes', 'material-ai' ); ?></h2>
					<p><?php esc_html_e( 'Discover beautifully crafted child themes for Material AI. Browse verified designs and install them directly from WordPress.org with a polished one-click flow.', 'material-ai' ); ?></p>
					<div class="materialai-child-highlights">
						<div class="materialai-child-highlight-item">
							<span class="materialai-child-highlight-label"><?php esc_html_e( 'Published themes', 'material-ai' ); ?></span>
							<strong><?php echo esc_html( number_format_i18n( $theme_count ) ); ?></strong>
						</div>
						<div class="materialai-child-highlight-item">
							<span class="materialai-child-highlight-label"><?php esc_html_e( 'Install method', 'material-ai' ); ?></span>
							<strong><?php esc_html_e( 'One Click', 'material-ai' ); ?></strong>
						</div>
						<div class="materialai-child-highlight-item">
							<span class="materialai-child-highlight-label"><?php esc_html_e( 'Catalog refresh', 'material-ai' ); ?></span>
							<strong><?php esc_html_e( 'Auto Sync', 'material-ai' ); ?></strong>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if ( $active_child && $active_child->exists() ) : ?>
			<div class="materialai-active-child-banner" role="status">
				<div class="materialai-active-child-badge"><span class="dashicons dashicons-yes-alt" aria-hidden="true"></span><?php esc_html_e( 'Active Child Theme', 'material-ai' ); ?></div>
				<div class="materialai-active-child-copy"><strong><?php echo esc_html( $active_child->get( 'Name' ) ); ?></strong><span><?php esc_html_e( 'is currently active. Material AI remains the parent theme. You can explore other compatible child themes below.', 'material-ai' ); ?></span></div>
				<a href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>" class="materialai-active-child-manage"><?php esc_html_e( 'Manage Themes', 'material-ai' ); ?><span class="dashicons dashicons-arrow-right-alt2" aria-hidden="true"></span></a>
			</div>
		<?php endif; ?>
		<?php
		$refresh_notice_key = 'materialai_child_refresh_notice_' . get_current_user_id();
		$refresh_notice = get_transient( $refresh_notice_key );
		if ( false !== $refresh_notice ) {
			delete_transient( $refresh_notice_key );
		}
		$is_offline = 'offline' === get_transient( 'materialai_directory_children_status_v1' ) || is_wp_error( $children );
		?>
		<?php if ( 'success' === $refresh_notice ) : ?>
			<div class="notice notice-success inline materialai-refresh-notice" role="status"><p><?php esc_html_e( 'Theme directory updated successfully.', 'material-ai' ); ?></p></div>
		<?php endif; ?>
		<?php if ( $is_offline ) : ?>
			<div class="materialai-directory-offline" role="status">
				<span class="dashicons dashicons-cloud" aria-hidden="true"></span>
				<div><strong><?php esc_html_e( 'Unable to connect to WordPress.org', 'material-ai' ); ?></strong>
				<p><?php echo is_wp_error( $children ) ? esc_html__( 'No saved directory is available yet. Please connect to the internet and try again.', 'material-ai' ) : esc_html__( 'Showing the last successfully loaded themes. New themes will appear when WordPress.org is reachable again.', 'material-ai' ); ?></p></div>
				<form class="materialai-refresh-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post"><input type="hidden" name="action" value="materialai_refresh_children" /><?php wp_nonce_field( 'materialai_refresh_children' ); ?><button type="submit" class="button materialai-refresh-button"><?php esc_html_e( 'Retry Connection', 'material-ai' ); ?></button></form>
			</div>
		<?php endif; ?>
		<?php if ( is_wp_error( $children ) ) : ?>
			<div class="materialai-child-empty"><span class="dashicons dashicons-cloud" aria-hidden="true"></span><h3><?php esc_html_e( 'Directory unavailable', 'material-ai' ); ?></h3><p><?php esc_html_e( 'Connect to the internet to load verified child themes from WordPress.org.', 'material-ai' ); ?></p></div>
		<?php else : ?>
			<div class="materialai-child-toolbar materialai-child-toolbar-luxe">
				<div class="materialai-child-toolbar-summary">
					<div class="materialai-child-count-card">
						<span class="materialai-child-count-number"><?php echo esc_html( number_format_i18n( $theme_count ) ); ?></span>
						<div class="materialai-child-count-copy">
							<strong><?php esc_html_e( 'Published themes', 'material-ai' ); ?></strong>
							<span><?php esc_html_e( 'Verified compatible child themes', 'material-ai' ); ?></span>
						</div>
					</div>
				</div>
				<div class="materialai-child-controls materialai-child-controls-luxe">
					<label class="screen-reader-text" for="materialai-child-search"><?php esc_html_e( 'Search child themes', 'material-ai' ); ?></label>
					<div class="materialai-child-field materialai-child-search-wrap"><span class="dashicons dashicons-search" aria-hidden="true"></span><input type="search" id="materialai-child-search" placeholder="<?php esc_attr_e( 'Search themes...', 'material-ai' ); ?>" /></div>
					<label class="screen-reader-text" for="materialai-child-filter"><?php esc_html_e( 'Filter child themes', 'material-ai' ); ?></label>
					<div class="materialai-child-field materialai-child-select-wrap"><select id="materialai-child-filter"><option value="all"><?php esc_html_e( 'All themes', 'material-ai' ); ?></option><option value="installed"><?php esc_html_e( 'Installed', 'material-ai' ); ?></option><option value="available"><?php esc_html_e( 'Available', 'material-ai' ); ?></option></select></div>
					<form class="materialai-refresh-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
						<input type="hidden" name="action" value="materialai_refresh_children" />
						<?php wp_nonce_field( 'materialai_refresh_children' ); ?>
						<button type="submit" class="button materialai-refresh-button"><span class="dashicons dashicons-update" aria-hidden="true"></span><?php esc_html_e( 'Refresh Themes', 'material-ai' ); ?></button>
					</form>
				</div>
			</div>
			<?php if ( ! empty( $children ) ) :
				// Pick the newest originally published theme, not the first alphabetical result.
				// Some directory responses omit creation_time; in that case fall back
				// to a stable alphabetical choice, not last_updated (an update date).
				$featured_child = reset( $children );
				$featured_time = 0;
				foreach ( $children as $candidate ) {
					if ( empty( $candidate->creation_time ) ) {
						continue;
					}
					$candidate_time = is_numeric( $candidate->creation_time )
						? (int) $candidate->creation_time
						: strtotime( (string) $candidate->creation_time );
					if ( false !== $candidate_time && $candidate_time > $featured_time ) {
						$featured_time = $candidate_time;
						$featured_child = $candidate;
					}
				}

				$featured_slug = sanitize_key( $featured_child->slug );
				$featured_installed = wp_get_theme( $featured_slug )->exists();
				$featured_install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-theme&theme=' . rawurlencode( $featured_slug ) ), 'install-theme_' . $featured_slug );
			?>
				<section class="materialai-featured-theme materialai-featured-theme-luxe" aria-label="<?php esc_attr_e( 'Featured child theme', 'material-ai' ); ?>">
					<div class="materialai-featured-details">
						<span class="materialai-featured-kicker"><span class="dashicons dashicons-star-filled" aria-hidden="true"></span><?php esc_html_e( 'Featured Child Theme', 'material-ai' ); ?></span>
						<?php if ( get_stylesheet() === $featured_slug ) : ?><span class="materialai-featured-active-flag"><span class="dashicons dashicons-yes" aria-hidden="true"></span><?php esc_html_e( 'Active on this site', 'material-ai' ); ?></span><?php endif; ?>
						<h3><?php echo esc_html( $featured_child->name ); ?></h3>
						<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( isset( $featured_child->description ) ? $featured_child->description : '' ), 24 ) ); ?></p>
						<div class="materialai-featured-meta">
							<span><?php esc_html_e( 'Verified for Material AI', 'material-ai' ); ?></span>
							<span><?php esc_html_e( 'Direct WordPress.org install', 'material-ai' ); ?></span>
						</div>
						<div class="materialai-featured-links">
							<?php if ( get_stylesheet() === $featured_slug ) : ?>
								<a class="materialai-featured-primary" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php esc_html_e( 'Manage Active Theme', 'material-ai' ); ?></a>
							<?php elseif ( $featured_installed ) : ?>
								<a class="materialai-featured-primary" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php esc_html_e( 'Manage Theme', 'material-ai' ); ?></a>
							<?php elseif ( current_user_can( 'install_themes' ) && ! $is_offline ) : ?>
								<a class="materialai-featured-primary" href="<?php echo esc_url( $featured_install_url ); ?>"><?php esc_html_e( 'Install Theme', 'material-ai' ); ?></a>
							<?php elseif ( ! $featured_installed && $is_offline ) : ?><span class="materialai-featured-primary materialai-offline-disabled" aria-disabled="true"><?php esc_html_e( 'Install requires internet', 'material-ai' ); ?></span><?php endif; ?>
							<a class="materialai-featured-secondary" href="<?php echo esc_url( 'https://wordpress.org/themes/' . rawurlencode( $featured_slug ) . '/' ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View details', 'material-ai' ); ?><span class="dashicons dashicons-external" aria-hidden="true"></span></a>
						</div>
					</div>
					<div class="materialai-featured-preview">
						<div class="materialai-featured-preview-frame">
							<?php if ( ! empty( $featured_child->screenshot_url ) ) : ?>
								<img src="<?php echo esc_url( $featured_child->screenshot_url ); ?>" alt="<?php echo esc_attr( $featured_child->name ); ?>" loading="lazy" />
							<?php else : ?>
								<span class="dashicons dashicons-format-image" aria-hidden="true"></span>
							<?php endif; ?>
						</div>
					</div>
				</section>
			<?php endif; ?>
			<?php if ( empty( $children ) ) : ?>
				<div class="materialai-child-empty"><span class="dashicons dashicons-admin-appearance" aria-hidden="true"></span><h3><?php esc_html_e( 'More designs are on the way', 'material-ai' ); ?></h3><p><?php esc_html_e( 'No verified published child themes are available in the latest WordPress.org results. Try Refresh Themes again later.', 'material-ai' ); ?></p></div>
			<?php else : ?>
				<div class="materialai-child-grid" id="materialai-child-grid">
				<?php foreach ( $children as $slug => $child ) :
					$installed = wp_get_theme( $slug );
					$is_installed = $installed->exists();
					$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-theme&theme=' . rawurlencode( $slug ) ), 'install-theme_' . $slug );
					$active = get_stylesheet() === $slug;
					$details_url = 'https://wordpress.org/themes/' . rawurlencode( $slug ) . '/';
					$status_label = $active ? __( 'Active', 'material-ai' ) : ( $is_installed ? __( 'Installed', 'material-ai' ) : __( 'WordPress.org', 'material-ai' ) );
				?>
					<article class="materialai-child-card materialai-child-card-luxe" data-name="<?php echo esc_attr( strtolower( $child->name . ' ' . $slug ) ); ?>" data-installed="<?php echo $is_installed ? 'installed' : 'available'; ?>">
						<div class="materialai-child-visual">
							<?php if ( ! empty( $child->screenshot_url ) ) : ?>
								<img class="materialai-child-image" loading="lazy" src="<?php echo esc_url( $child->screenshot_url ); ?>" alt="<?php echo esc_attr( $child->name ); ?>" />
							<?php else : ?>
								<div class="materialai-child-placeholder"><span class="dashicons dashicons-format-image"></span></div>
							<?php endif; ?>
							<span class="materialai-child-status <?php echo $is_installed ? 'is-installed' : ''; ?> <?php echo $active ? 'is-active' : ''; ?>"><?php echo esc_html( $status_label ); ?></span>
						</div>
						<div class="materialai-child-content">
							<div class="materialai-child-meta-top">
								<span class="materialai-child-chip"><?php esc_html_e( 'Child Theme', 'material-ai' ); ?></span>
								<span class="materialai-child-slug"><?php echo esc_html( $slug ); ?></span>
							</div>
							<h3><?php echo esc_html( $child->name ); ?></h3>
							<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( isset( $child->description ) ? $child->description : '' ), 22 ) ); ?></p>
							<div class="materialai-child-meta-bottom">
								<span><span class="dashicons dashicons-yes-alt" aria-hidden="true"></span><?php esc_html_e( 'Verified for Material AI', 'material-ai' ); ?></span>
							</div>
							<div class="materialai-child-actions">
							<?php if ( $active ) : ?>
								<a class="button button-primary" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php esc_html_e( 'Manage Active Theme', 'material-ai' ); ?></a>
							<?php elseif ( $is_installed ) : ?>
								<a class="button button-primary" href="<?php echo esc_url( admin_url( 'themes.php' ) ); ?>"><?php esc_html_e( 'Manage Theme', 'material-ai' ); ?></a>
							<?php elseif ( current_user_can( 'install_themes' ) && ! $is_offline ) : ?>
								<a class="button button-primary" href="<?php echo esc_url( $install_url ); ?>"><?php esc_html_e( 'Install Now', 'material-ai' ); ?></a>
							<?php elseif ( ! $is_installed && $is_offline ) : ?><span class="button disabled" aria-disabled="true"><?php esc_html_e( 'Requires internet', 'material-ai' ); ?></span><?php endif; ?>
							<a class="button materialai-child-details-btn" href="<?php echo esc_url( $details_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View Details', 'material-ai' ); ?></a>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
				</div>
				<p class="materialai-child-no-results" id="materialai-child-no-results" hidden><?php esc_html_e( 'No themes match your search or filter.', 'material-ai' ); ?></p>
				<div class="materialai-child-pager" id="materialai-child-pager" aria-label="<?php esc_attr_e( 'Child theme pages', 'material-ai' ); ?>"></div>
			<?php endif; ?>
			<p class="materialai-child-footnote"><?php esc_html_e( 'Shows verified WordPress.org results only. The catalog refreshes every 12 hours automatically, and you can also use Refresh Themes any time.', 'material-ai' ); ?></p>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Render the theme info page.
 */
function materialai_info_render_page() {
	$materialai_theme   = wp_get_theme( get_template() );
	$materialai_version = $materialai_theme->get( 'Version' );
	$materialai_urls    = materialai_info_urls();
	$materialai_user    = wp_get_current_user();

	$materialai_templates = array(
		array(
			'label' => __( 'Header', 'material-ai' ),
			'link'  => materialai_info_editor_link(
				array(
					'postType' => 'wp_template_part',
					'postId'   => 'material-ai//header',
					'canvas'   => 'edit',
				)
			),
			'icon'  => 'dashicons-align-wide',
		),
		array(
			'label' => __( 'Footer', 'material-ai' ),
			'link'  => materialai_info_editor_link(
				array(
					'postType' => 'wp_template_part',
					'postId'   => 'material-ai//footer',
					'canvas'   => 'edit',
				)
			),
			'icon'  => 'dashicons-align-center',
		),
		array(
			'label' => __( 'Homepage', 'material-ai' ),
			'link'  => materialai_info_editor_link(
				array(
					'postType' => 'wp_template',
					'postId'   => 'material-ai//front-page',
					'canvas'   => 'edit',
				)
			),
			'icon'  => 'dashicons-admin-home',
		),
		array(
			'label' => __( 'Page', 'material-ai' ),
			'link'  => materialai_info_editor_link(
				array(
					'postType' => 'wp_template',
					'postId'   => 'material-ai//page',
					'canvas'   => 'edit',
				)
			),
			'icon'  => 'dashicons-media-document',
		),
		array(
			'label' => __( 'Single Post', 'material-ai' ),
			'link'  => materialai_info_editor_link(
				array(
					'postType' => 'wp_template',
					'postId'   => 'material-ai//single',
					'canvas'   => 'edit',
				)
			),
			'icon'  => 'dashicons-admin-post',
		),
		array(
			'label' => __( 'Blog / Archive', 'material-ai' ),
			'link'  => materialai_info_editor_link(
				array(
					'postType' => 'wp_template',
					'postId'   => 'material-ai//archive',
					'canvas'   => 'edit',
				)
			),
			'icon'  => 'dashicons-excerpt-view',
		),
		array(
			'label' => __( 'Search Results', 'material-ai' ),
			'link'  => materialai_info_editor_link(
				array(
					'postType' => 'wp_template',
					'postId'   => 'material-ai//search',
					'canvas'   => 'edit',
				)
			),
			'icon'  => 'dashicons-search',
		),
		array(
			'label' => __( '404 Page', 'material-ai' ),
			'link'  => materialai_info_editor_link(
				array(
					'postType' => 'wp_template',
					'postId'   => 'material-ai//404',
					'canvas'   => 'edit',
				)
			),
			'icon'  => 'dashicons-warning',
		),
	);

	$materialai_quick = array(
		array(
			'label' => __( 'Colors & Styles', 'material-ai' ),
			'desc'  => __( 'Palette, typography and 10 style variations.', 'material-ai' ),
			'link'  => materialai_info_editor_link( array( 'path' => '/wp_global_styles' ) ),
			'icon'  => 'dashicons-art',
		),
		array(
			'label' => __( 'Navigation Menus', 'material-ai' ),
			'desc'  => __( 'Edit the header and footer menus.', 'material-ai' ),
			'link'  => materialai_info_editor_link( array( 'path' => '/navigation' ) ),
			'icon'  => 'dashicons-menu-alt',
		),
		array(
			'label' => __( 'Site Logo & Identity', 'material-ai' ),
			'desc'  => __( 'Logo, site title and tagline.', 'material-ai' ),
			'link'  => materialai_info_editor_link(
				array(
					'postType' => 'wp_template_part',
					'postId'   => 'material-ai//header',
					'canvas'   => 'edit',
				)
			),
			'icon'  => 'dashicons-format-image',
		),
		array(
			'label' => __( 'Block Patterns', 'material-ai' ),
			'desc'  => __( 'Browse all Material AI patterns.', 'material-ai' ),
			'link'  => materialai_info_editor_link( array( 'path' => '/patterns' ) ),
			'icon'  => 'dashicons-layout',
		),
	);

	$materialai_free_patterns = array(
		__( 'Main Banner', 'material-ai' ),
		__( 'Service', 'material-ai' ),
		__( 'CTA Banner', 'material-ai' ),
		__( 'Flexible Pricing', 'material-ai' ),
		__( 'Text Ticker', 'material-ai' ),
		__( 'Latest Blog', 'material-ai' ),
		__( 'Header', 'material-ai' ),
		__( 'Footer', 'material-ai' ),
		__( 'Breadcrumb', 'material-ai' ),
		__( 'Sidebar', 'material-ai' ),
		__( 'Home (full page)', 'material-ai' ),
	);

	$materialai_pro_patterns = array(
		__( 'Advanced Sliders (8+ pre-built)', 'material-ai' ),
		__( 'Customer Reviews / Testimonials', 'material-ai' ),
		__( 'AI Expert Team', 'material-ai' ),
		__( 'Projects Portfolio (filterable)', 'material-ai' ),
		__( 'Gallery Showcase', 'material-ai' ),
		__( 'Advanced Technology & Features', 'material-ai' ),
		__( 'Client Logos', 'material-ai' ),
		__( '24+ Page Templates', 'material-ai' ),
	);

	$materialai_compare = array(
		array( __( 'Price', 'material-ai' ), __( 'Free', 'material-ai' ), __( 'From $49', 'material-ai' ) ),
		array( __( 'Block Patterns', 'material-ai' ), __( '11 patterns', 'material-ai' ), __( 'All Pro patterns & sections', 'material-ai' ) ),
		array( __( 'Style Variations', 'material-ai' ), __( '10 color styles', 'material-ai' ), __( 'Unlimited color customization', 'material-ai' ) ),
		array( __( 'Homepage Slider', 'material-ai' ), __( 'Static banner', 'material-ai' ), __( '8+ sliders, unlimited slides', 'material-ai' ) ),
		array( __( 'Page Templates', 'material-ai' ), __( 'Core templates', 'material-ai' ), __( '24+ page templates', 'material-ai' ) ),
		array( __( 'Testimonials, Team, Portfolio, Gallery', 'material-ai' ), '&mdash;', __( 'Included', 'material-ai' ) ),
		array( __( 'Material Icons Library', 'material-ai' ), __( '1200 icons', 'material-ai' ), __( '1200 icons', 'material-ai' ) ),
		array( __( 'WooCommerce Templates', 'material-ai' ), __( 'Included', 'material-ai' ), __( 'Advanced shop layouts', 'material-ai' ) ),
		array( __( 'One-Click Demo Import', 'material-ai' ), '&mdash;', __( 'Included', 'material-ai' ) ),
		array( __( 'MailChimp / Newsletter', 'material-ai' ), '&mdash;', __( 'Included', 'material-ai' ) ),
		array( __( 'Translation Ready', 'material-ai' ), __( 'Yes', 'material-ai' ), __( 'Yes (WPML / Polylang)', 'material-ai' ) ),
		array( __( 'Support', 'material-ai' ), __( 'WordPress.org forum', 'material-ai' ), __( 'Priority support', 'material-ai' ) ),
	);
	?>
	<div class="wrap materialai-info">

		<div class="materialai-info-hero">
			<div class="materialai-info-hero-text">
				<h1>
					<?php esc_html_e( 'Material AI', 'material-ai' ); ?>
					<span class="materialai-info-badge"><?php echo esc_html( $materialai_version ); ?></span>
					<span class="materialai-info-badge materialai-info-badge-free"><?php esc_html_e( 'Free', 'material-ai' ); ?></span>
				</h1>
				<p><?php esc_html_e( 'A Full Site Editing block theme for AI startups, corporate businesses and creative agencies.', 'material-ai' ); ?></p>
			</div>
			<div class="materialai-info-hero-actions">
				<a class="materialai-btn materialai-btn-pro" href="<?php echo esc_url( $materialai_urls['pro'] ); ?>" target="_blank" rel="noopener"><span class="dashicons dashicons-cart"></span><?php esc_html_e( 'Buy Pro', 'material-ai' ); ?></a>
				<a class="materialai-btn materialai-btn-ghost" href="<?php echo esc_url( $materialai_urls['demo_free'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View Live Demo', 'material-ai' ); ?></a>
				<a class="materialai-btn materialai-btn-ghost" href="<?php echo esc_url( $materialai_urls['docs'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Free Documentation', 'material-ai' ); ?></a>
			</div>
		</div>

		<nav class="nav-tab-wrapper materialai-info-tabs">
			<a href="#getting-started" class="nav-tab nav-tab-active" data-materialai-tab="getting-started"><?php esc_html_e( 'Getting Started', 'material-ai' ); ?></a>
			<a href="#free-vs-pro" class="nav-tab" data-materialai-tab="free-vs-pro"><?php esc_html_e( 'Free vs Pro', 'material-ai' ); ?></a>
			<a href="#child-themes" class="nav-tab" data-materialai-tab="child-themes"><?php esc_html_e( 'Child Themes', 'material-ai' ); ?></a>
			<a href="#patterns" class="nav-tab" data-materialai-tab="patterns"><?php esc_html_e( 'Patterns', 'material-ai' ); ?></a>
			<a href="#support" class="nav-tab" data-materialai-tab="support"><?php esc_html_e( 'Support', 'material-ai' ); ?></a>
		</nav>

		<div class="materialai-info-layout">

			<div class="materialai-info-main">

				<!-- Getting Started -->
				<div class="materialai-info-tab is-active" id="materialai-tab-getting-started">

					<div class="materialai-welcome-label"><span class="dashicons dashicons-sparkles" aria-hidden="true"></span><?php esc_html_e( 'YOUR DESIGN WORKSPACE', 'material-ai' ); ?></div>
					<div class="materialai-card materialai-welcome">
						<div class="materialai-welcome-text">
							<h2>
							<?php
							/* translators: %s: current user display name. */
							printf( esc_html__( 'Hello %s, welcome to Material AI', 'material-ai' ), esc_html( $materialai_user->display_name ) );
							?>
							</h2>
							<p><?php esc_html_e( 'Material AI is a fully block and pattern based theme. Everything you see on the front end can be changed visually in the Site Editor: colors, typography, spacing, templates and patterns. No extra plugin is required.', 'material-ai' ); ?></p>
							<p>
								<a class="materialai-btn materialai-btn-primary" href="<?php echo materialai_info_editor_link(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>"><span class="dashicons dashicons-edit"></span><?php esc_html_e( 'Start Customizing the Site', 'material-ai' ); ?></a>
								<a class="materialai-btn materialai-btn-link" href="<?php echo esc_url( $materialai_urls['free_home'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Visit Theme Website', 'material-ai' ); ?> <span class="dashicons dashicons-external"></span></a>
							</p>
						</div>
						<div class="materialai-welcome-shot">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.jpg' ); ?>" alt="<?php esc_attr_e( 'Material AI theme preview', 'material-ai' ); ?>" />
						</div>
					</div>

					<div class="materialai-section-heading"><div><span><?php esc_html_e( 'PERSONALIZE', 'material-ai' ); ?></span><h2 class="materialai-info-heading"><?php esc_html_e( 'Quick Customizer Settings', 'material-ai' ); ?></h2></div><p><?php esc_html_e( 'Everything you need to make the site yours.', 'material-ai' ); ?></p></div>
					<div class="materialai-grid materialai-grid-2">
						<?php foreach ( $materialai_quick as $materialai_item ) : ?>
							<a class="materialai-card materialai-quick-card" href="<?php echo $materialai_item['link']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>">
								<span class="materialai-quick-icon dashicons <?php echo esc_attr( $materialai_item['icon'] ); ?>"></span>
								<span class="materialai-quick-body">
									<strong><?php echo esc_html( $materialai_item['label'] ); ?></strong>
									<span><?php echo esc_html( $materialai_item['desc'] ); ?></span>
									<span class="materialai-start-edit"><?php esc_html_e( 'Start Edit', 'material-ai' ); ?></span>
								</span>
							</a>
						<?php endforeach; ?>
					</div>

					<div class="materialai-section-heading"><div><span><?php esc_html_e( 'YOUR LAYOUTS', 'material-ai' ); ?></span><h2 class="materialai-info-heading"><?php esc_html_e( 'Edit Templates Quickly', 'material-ai' ); ?></h2></div><p><?php esc_html_e( 'Launch directly into the Site Editor.', 'material-ai' ); ?></p></div>
					<div class="materialai-grid materialai-grid-4">
						<?php foreach ( $materialai_templates as $materialai_item ) : ?>
							<a class="materialai-card materialai-template-card" href="<?php echo $materialai_item['link']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>">
								<span class="dashicons <?php echo esc_attr( $materialai_item['icon'] ); ?>"></span>
								<strong><?php echo esc_html( $materialai_item['label'] ); ?></strong>
								<span class="materialai-start-edit"><?php esc_html_e( 'Start Edit', 'material-ai' ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>

				</div>

				<!-- WordPress.org child themes -->
				<div class="materialai-info-tab" id="materialai-tab-child-themes">
					<?php materialai_info_render_children(); ?>
				</div>

				<!-- Free vs Pro -->
				<div class="materialai-info-tab" id="materialai-tab-free-vs-pro">
					<div class="materialai-card">
						<h2 class="materialai-compare-title"><?php esc_html_e( 'Compare Free vs Pro', 'material-ai' ); ?></h2>
						<table class="widefat striped materialai-compare">
							<thead>
								<tr>
									<th><?php esc_html_e( 'Feature', 'material-ai' ); ?></th>
									<th><?php esc_html_e( 'Material AI Free', 'material-ai' ); ?></th>
									<th class="materialai-compare-pro-col"><?php esc_html_e( 'Material AI Pro', 'material-ai' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $materialai_compare as $materialai_row ) : ?>
									<tr>
										<td><?php echo esc_html( $materialai_row[0] ); ?></td>
										<td><?php echo wp_kses_post( $materialai_row[1] ); ?></td>
										<td class="materialai-compare-pro-col"><?php echo wp_kses_post( $materialai_row[2] ); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<p class="materialai-compare-cta">
							<a class="materialai-btn materialai-btn-pro" href="<?php echo esc_url( $materialai_urls['pro'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Upgrade to Material AI Pro', 'material-ai' ); ?></a>
							<a class="materialai-btn materialai-btn-link" href="<?php echo esc_url( $materialai_urls['demo_pro'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Preview the Pro demo', 'material-ai' ); ?> <span class="dashicons dashicons-external"></span></a>
						</p>
					</div>
				</div>

				<!-- Patterns -->
				<div class="materialai-info-tab" id="materialai-tab-patterns">
					<h2 class="materialai-info-heading"><?php esc_html_e( 'Included Free Patterns', 'material-ai' ); ?></h2>
					<div class="materialai-grid materialai-grid-4">
						<?php foreach ( $materialai_free_patterns as $materialai_index => $materialai_name ) : ?>
							<a class="materialai-card materialai-pattern-card" href="<?php echo materialai_info_editor_link( array( 'path' => '/patterns' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>">
								<span class="materialai-pattern-thumb materialai-pattern-thumb-<?php echo esc_attr( $materialai_index % 4 ); ?>" aria-hidden="true"></span>
								<strong><?php echo esc_html( $materialai_name ); ?></strong>
								<span class="materialai-tag materialai-tag-free"><?php esc_html_e( 'Free', 'material-ai' ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>

					<h2 class="materialai-info-heading"><?php esc_html_e( 'Pro Patterns & Sections', 'material-ai' ); ?></h2>
					<div class="materialai-grid materialai-grid-4">
						<?php foreach ( $materialai_pro_patterns as $materialai_index => $materialai_name ) : ?>
							<a class="materialai-card materialai-pattern-card materialai-pattern-card-pro" href="<?php echo esc_url( $materialai_urls['demo_pro'] ); ?>" target="_blank" rel="noopener">
								<span class="materialai-pattern-thumb materialai-pattern-thumb-pro materialai-pattern-thumb-<?php echo esc_attr( $materialai_index % 4 ); ?>" aria-hidden="true"><span class="dashicons dashicons-lock"></span></span>
								<strong><?php echo esc_html( $materialai_name ); ?></strong>
								<span class="materialai-tag materialai-tag-pro"><?php esc_html_e( 'Pro', 'material-ai' ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>
				</div>

				<!-- Support -->
				<div class="materialai-info-tab" id="materialai-tab-support">
					<div class="materialai-grid materialai-grid-2">
						<div class="materialai-card materialai-support-card">
							<span class="dashicons dashicons-book-alt"></span>
							<h3><?php esc_html_e( 'Documentation', 'material-ai' ); ?></h3>
							<p><?php esc_html_e( 'Step by step guides for setting up the theme, templates and patterns.', 'material-ai' ); ?></p>
							<a class="materialai-btn materialai-btn-primary" href="<?php echo esc_url( $materialai_urls['docs'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Go to Docs', 'material-ai' ); ?></a>
						</div>
						<div class="materialai-card materialai-support-card">
							<span class="dashicons dashicons-sos"></span>
							<h3><?php esc_html_e( 'Free Theme Support', 'material-ai' ); ?></h3>
							<p><?php esc_html_e( 'Questions about the free theme? Ask in the WordPress.org support forum.', 'material-ai' ); ?></p>
							<a class="materialai-btn materialai-btn-primary" href="<?php echo esc_url( $materialai_urls['forum'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Open Support Forum', 'material-ai' ); ?></a>
						</div>
						<div class="materialai-card materialai-support-card">
							<span class="dashicons dashicons-star-filled"></span>
							<h3><?php esc_html_e( 'Please Rate Us', 'material-ai' ); ?></h3>
							<p><?php esc_html_e( 'Enjoying Material AI? A five star review keeps us motivated and helps other users.', 'material-ai' ); ?></p>
							<a class="materialai-btn materialai-btn-primary" href="<?php echo esc_url( $materialai_urls['rate'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Rate on WordPress.org', 'material-ai' ); ?></a>
						</div>
						<div class="materialai-card materialai-support-card">
							<span class="dashicons dashicons-admin-users"></span>
							<h3><?php esc_html_e( 'Pro Priority Support', 'material-ai' ); ?></h3>
							<p><?php esc_html_e( 'Pro users get dedicated priority support through our ticket system.', 'material-ai' ); ?></p>
							<a class="materialai-btn materialai-btn-primary" href="<?php echo esc_url( $materialai_urls['support'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Open a Ticket', 'material-ai' ); ?></a>
						</div>
					</div>
				</div>

			</div>

			<div class="materialai-info-sidebar">

				<div class="materialai-card materialai-side-card materialai-side-docs">
                    <span class="materialai-side-icon dashicons dashicons-book-alt" aria-hidden="true"></span>
					<h3><?php esc_html_e( 'Documentation', 'material-ai' ); ?></h3>
					<p><?php esc_html_e( 'Need help? Our detailed docs will guide you through everything.', 'material-ai' ); ?></p>
					<a class="materialai-btn materialai-btn-primary" href="<?php echo esc_url( $materialai_urls['docs'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Go to Docs', 'material-ai' ); ?></a>
				</div>

				<div class="materialai-card materialai-side-card materialai-pro-card"><span class="materialai-side-pro-label"><span class="dashicons dashicons-superhero-alt" aria-hidden="true"></span><?php esc_html_e( 'EXPLORE MORE', 'material-ai' ); ?></span>
					<h3><?php esc_html_e( 'Preview Pro Theme', 'material-ai' ); ?></h3>
					<p><?php esc_html_e( 'Explore the Pro demo and see the power of customization.', 'material-ai' ); ?></p>

					<div class="materialai-pro-mockup" aria-hidden="true">
						<span class="materialai-pro-mockup-bar"><i></i><i></i><i></i></span>
						<span class="materialai-pro-mockup-hero">
							<span class="materialai-pro-mockup-line materialai-pro-mockup-line-lg"></span>
							<span class="materialai-pro-mockup-line"></span>
							<span class="materialai-pro-mockup-btn"></span>
						</span>
						<span class="materialai-pro-mockup-cards"><i></i><i></i><i></i></span>
					</div>

					<ul class="materialai-pro-list">
						<li><?php esc_html_e( '8+ pre-built sliders', 'material-ai' ); ?></li>
						<li><?php esc_html_e( 'Testimonials, Team & Portfolio', 'material-ai' ); ?></li>
						<li><?php esc_html_e( '24+ page templates', 'material-ai' ); ?></li>
						<li><?php esc_html_e( 'One-click demo import', 'material-ai' ); ?></li>
					</ul>
					<p class="materialai-pro-price">
						<?php
						/* translators: %s: price. */
						printf( esc_html__( 'Starting at %s', 'material-ai' ), '<strong>$49</strong>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static markup.
						?>
					</p>
					<a class="materialai-btn materialai-btn-pro materialai-btn-block" href="<?php echo esc_url( $materialai_urls['pro'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Get Material AI Pro', 'material-ai' ); ?></a>
					<a class="materialai-btn materialai-btn-ghost-dark materialai-btn-block" href="<?php echo esc_url( $materialai_urls['demo_pro'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'View Pro Demo', 'material-ai' ); ?></a>
				</div>

				<div class="materialai-card materialai-side-card materialai-side-review">
                    <span class="materialai-side-icon dashicons dashicons-heart" aria-hidden="true"></span>
					<h3><?php esc_html_e( 'Leave Us a Review', 'material-ai' ); ?></h3>
					<p class="materialai-side-stars" aria-hidden="true">
						<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span>
					</p>
					<p><?php esc_html_e( 'Your feedback helps us improve Material AI for everyone.', 'material-ai' ); ?></p>
					<a class="materialai-btn materialai-btn-ghost-dark materialai-btn-block" href="<?php echo esc_url( $materialai_urls['rate'] ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Please Rate Us', 'material-ai' ); ?></a>
				</div>

			</div>

		</div>
	</div>
	<?php
}
