<?php
/**
 * Front end output for the child theme options.
 *
 * @package Music_Star_Amplify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * ---------------------------------------------------------------------------
 * Release Countdown
 * ---------------------------------------------------------------------------
 */

/**
 * Is the countdown shown on this page?
 *
 * @return bool
 */
function music_star_amplify_show_countdown() {
	return ( music_star_amplify_get( 'music_star_amplify_cd_enable' ) || music_star_amplify_countdown_demo() )
		&& music_star_amplify_countdown_target()
		&& music_star_amplify_on_this_page( 'music_star_amplify_cd_display' );
}

/**
 * Countdown markup.
 *
 * @param string $position top|under.
 */
function music_star_amplify_countdown( $position ) {
	if ( ! music_star_amplify_show_countdown() || music_star_amplify_get( 'music_star_amplify_cd_position' ) !== $position ) {
		return;
	}
	$target = music_star_amplify_countdown_target();
	$left   = max( 0, $target - time() );
	$parts  = array(
		'd' => array( (int) floor( $left / DAY_IN_SECONDS ), __( 'days', 'music-star-amplify' ) ),
		'h' => array( (int) floor( ( $left % DAY_IN_SECONDS ) / HOUR_IN_SECONDS ), __( 'hrs', 'music-star-amplify' ) ),
		'm' => array( (int) floor( ( $left % HOUR_IN_SECONDS ) / MINUTE_IN_SECONDS ), __( 'min', 'music-star-amplify' ) ),
		's' => array( (int) ( $left % MINUTE_IN_SECONDS ), __( 'sec', 'music-star-amplify' ) ),
	);
	$title  = music_star_amplify_get( 'music_star_amplify_cd_title' );
	$button = music_star_amplify_get( 'music_star_amplify_cd_button' );
	$url    = music_star_amplify_get( 'music_star_amplify_cd_url' );
	$done   = music_star_amplify_get( 'music_star_amplify_cd_done' );
	$class  = 'msa-countdown msa-countdown--' . $position . ( $left ? '' : ' is-done' );
	?>
	<div class="<?php echo esc_attr( $class ); ?>" data-target="<?php echo esc_attr( $target ); ?>">
		<div class="msa-cd-inner">
			<?php if ( $title ) : ?>
				<span class="msa-cd-title"><?php echo esc_html( $title ); ?></span>
			<?php endif; ?>
			<span class="msa-cd-clock" role="timer" aria-live="off">
				<?php foreach ( $parts as $unit => $part ) : ?>
					<span class="msa-cd-unit">
						<b data-unit="<?php echo esc_attr( $unit ); ?>"><?php echo esc_html( 'd' === $unit ? $part[0] : str_pad( (string) $part[0], 2, '0', STR_PAD_LEFT ) ); ?></b>
						<small><?php echo esc_html( $part[1] ); ?></small>
					</span>
				<?php endforeach; ?>
			</span>
			<span class="msa-cd-done"><?php echo esc_html( $done ); ?></span>
			<?php if ( $button && $url ) : ?>
				<a class="msa-cd-button" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $button ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/**
 * Countdown at the top of the page.
 */
function music_star_amplify_countdown_top() {
	music_star_amplify_countdown( 'top' );
}
add_action( 'music_star_amplify_before_header', 'music_star_amplify_countdown_top', 10 );

/**
 * Countdown under the header.
 */
function music_star_amplify_countdown_under() {
	music_star_amplify_countdown( 'under' );
}
add_action( 'music_star_amplify_after_header', 'music_star_amplify_countdown_under', 10 );

/*
 * ---------------------------------------------------------------------------
 * Live Visualizer
 * ---------------------------------------------------------------------------
 */

/**
 * Is the visualizer shown on this page?
 *
 * @return bool
 */
function music_star_amplify_show_visualizer() {
	return music_star_amplify_get( 'music_star_amplify_viz_enable' )
		&& music_star_amplify_on_this_page( 'music_star_amplify_viz_display' );
}

/**
 * Visualizer markup (the canvas is drawn by assets/js/amplify.js).
 */
function music_star_amplify_visualizer() {
	if ( ! music_star_amplify_show_visualizer() ) {
		return;
	}
	$position = music_star_amplify_get( 'music_star_amplify_viz_position' );
	$height   = music_star_amplify_sanitize_height( music_star_amplify_get( 'music_star_amplify_viz_height' ) );
	printf(
		'<div class="%1$s" data-style="%2$s" data-idle="%3$s" style="--msa-viz-height:%4$dpx" aria-hidden="true"><canvas class="msa-viz-canvas"></canvas></div>',
		esc_attr( 'msa-viz msa-viz--' . ( 'bottom' === $position ? 'bottom' : 'header' ) ),
		esc_attr( music_star_amplify_get( 'music_star_amplify_viz_style' ) ),
		music_star_amplify_get( 'music_star_amplify_viz_idle' ) ? '1' : '0',
		absint( $height )
	);
}
add_action( 'music_star_amplify_after_header', 'music_star_amplify_visualizer', 20 );

/*
 * ---------------------------------------------------------------------------
 * News Ticker
 * ---------------------------------------------------------------------------
 */

/**
 * Ticker markup.
 *
 * @param string $position top|under.
 */
function music_star_amplify_ticker( $position ) {
	if ( ! music_star_amplify_get( 'music_star_amplify_ticker_enable' )
		|| music_star_amplify_get( 'music_star_amplify_ticker_position' ) !== $position
		|| ! music_star_amplify_on_this_page( 'music_star_amplify_ticker_display' ) ) {
		return;
	}

	$args     = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => music_star_amplify_sanitize_number( music_star_amplify_get( 'music_star_amplify_ticker_number' ) ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);
	$category = absint( music_star_amplify_get( 'music_star_amplify_ticker_category' ) );
	if ( $category ) {
		$args['cat'] = $category;
	}
	$posts = get_posts( $args );
	if ( empty( $posts ) ) {
		return;
	}

	$speed = music_star_amplify_get( 'music_star_amplify_ticker_speed' );
	$label = music_star_amplify_get( 'music_star_amplify_ticker_label' );
	?>
	<div class="<?php echo esc_attr( 'msa-ticker msa-ticker--' . $position ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" role="region" aria-label="<?php esc_attr_e( 'Latest posts', 'music-star-amplify' ); ?>">
		<?php if ( $label ) : ?>
			<span class="msa-ticker-label"><span class="msa-ticker-dot" aria-hidden="true"></span><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
		<div class="msa-ticker-viewport">
			<div class="msa-ticker-track">
				<?php for ( $copy = 0; $copy < 2; $copy++ ) : ?>
					<ul class="msa-ticker-list"<?php echo $copy ? ' aria-hidden="true"' : ''; ?>>
						<?php foreach ( $posts as $item ) : ?>
							<li><a href="<?php echo esc_url( get_permalink( $item ) ); ?>"<?php echo $copy ? ' tabindex="-1"' : ''; ?>><?php echo esc_html( get_the_title( $item ) ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endfor; ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Ticker at the top of the page.
 */
function music_star_amplify_ticker_top() {
	music_star_amplify_ticker( 'top' );
}
add_action( 'music_star_amplify_before_header', 'music_star_amplify_ticker_top', 20 );

/**
 * Ticker under the header.
 */
function music_star_amplify_ticker_under() {
	music_star_amplify_ticker( 'under' );
}
add_action( 'music_star_amplify_after_header', 'music_star_amplify_ticker_under', 30 );

/*
 * ---------------------------------------------------------------------------
 * Body classes
 * ---------------------------------------------------------------------------
 */

/**
 * Body classes for the options.
 *
 * @param array $classes Body classes.
 * @return array
 */
function music_star_amplify_body_classes( $classes ) {
	$classes[] = 'music-star-amplify';
	if ( music_star_amplify_get( 'music_star_amplify_spotlight' ) ) {
		$classes[] = 'msa-spotlight-on';
	}
	if ( music_star_amplify_show_visualizer() && 'bottom' === music_star_amplify_get( 'music_star_amplify_viz_position' ) ) {
		$classes[] = 'msa-viz-at-bottom';
	}
	return $classes;
}
add_filter( 'body_class', 'music_star_amplify_body_classes' );

/*
 * ---------------------------------------------------------------------------
 * Footer preview on a fresh installation
 * ---------------------------------------------------------------------------
 */

/**
 * Show preview widgets in the footer?
 *
 * Only while WordPress marks the site as fresh and all four footer widget
 * areas of the parent theme are empty. The first change of the site (or the
 * first widget added to the footer) turns the preview off by itself.
 *
 * @return bool
 */
function music_star_amplify_footer_demo() {
	if ( ! get_option( 'fresh_site' ) ) {
		return false;
	}
	for ( $i = 1; $i <= 4; $i++ ) {
		if ( is_active_sidebar( 'footer-' . $i ) ) {
			return false;
		}
	}
	return true;
}

/**
 * One preview widget. The core widgets show the real data of the site.
 *
 * @param int $column Footer column 1 - 4.
 */
function music_star_amplify_footer_demo_widget( $column ) {
	$args = array(
		'before_widget' => '<div class="widget %s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);
	switch ( (int) $column ) {
		case 1:
			the_widget(
				'WP_Widget_Recent_Posts',
				array(
					'title'  => __( 'Recent Posts', 'music-star-amplify' ),
					'number' => 5,
				),
				$args
			);
			break;
		case 2:
			the_widget( 'WP_Widget_Categories', array( 'title' => __( 'Categories', 'music-star-amplify' ) ), $args );
			break;
		case 3:
			the_widget( 'WP_Widget_Archives', array( 'title' => __( 'Archives', 'music-star-amplify' ) ), $args );
			break;
		case 4:
			the_widget( 'WP_Widget_Search', array( 'title' => __( 'Search', 'music-star-amplify' ) ), $args );
			break;
	}
}

/*
 * ---------------------------------------------------------------------------
 * Footer widget areas
 * ---------------------------------------------------------------------------
 */

/**
 * Register the four footer widget areas of the parent theme again, with the
 * same IDs and markup, so they get clear names and descriptions in
 * Appearance > Widgets (the parent theme leaves the descriptions empty).
 * Runs after the parent theme, so the areas and their widgets stay the same.
 */
function music_star_amplify_footer_areas() {
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				/* translators: %d: footer column number. */
				'name'          => sprintf( esc_html__( 'Footer %d', 'music-star-amplify' ), $i ),
				'id'            => 'footer-' . $i,
				/* translators: %d: footer column number. */
				'description'   => sprintf( esc_html__( 'Widgets in this area are shown in column %d of the footer. While the four footer areas are empty on a fresh installation, the footer shows a preview with recent posts, categories, archives and search.', 'music-star-amplify' ), $i ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'music_star_amplify_footer_areas', 20 );
