<?php
/**
 * The footer for the Music Star Amplify child theme.
 *
 * Same markup as the parent theme. On a fresh installation, while all four
 * footer widget areas are empty, it shows a preview with core widgets that use
 * the real data of the site (recent posts, categories, archives, search).
 *
 * @package Music_Star_Amplify
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$music_star_amplify_footer_demo = music_star_amplify_footer_demo();
?>
	</div><!-- #content -->
	<footer id="colophon" class="site-footer" itemscope="itemscope" itemtype="https://schema.org/WPFooter">
		<div class="footer-center">
			<?php
			for ( $music_star_amplify_i = 1; $music_star_amplify_i <= 4; $music_star_amplify_i++ ) {
				if ( is_active_sidebar( 'footer-' . $music_star_amplify_i ) ) {
					echo '<div class="footer-widgets">';
					dynamic_sidebar( 'footer-' . $music_star_amplify_i );
					echo '</div>';
				} elseif ( $music_star_amplify_footer_demo ) {
					echo '<div class="footer-widgets">';
					music_star_amplify_footer_demo_widget( $music_star_amplify_i );
					echo '</div>';
				}
			}
			?>
		</div>
		<div class="site-info">
			<?php
			if ( get_theme_mod( 'music_star_active_social' ) && function_exists( 'music_star_social_section' ) ) {
				music_star_social_section();
			}
			?>
			<?php if ( get_theme_mod( 'music_star_copyright' ) ) : ?>
				<p>
					<?php echo esc_html( get_theme_mod( 'music_star_copyright' ) ); ?>
					<a href="<?php echo esc_url( 'https://seosthemes.com/' ); ?>"><?php esc_html_e( 'Music Star Theme by Seos Themes', 'music-star-amplify' ); ?></a>
				</p>
			<?php else : ?>
				<a class="powered" href="<?php echo esc_url( __( 'https://wordpress.org/', 'music-star-amplify' ) ); ?>"><?php esc_html_e( 'Powered by WordPress', 'music-star-amplify' ); ?></a>
				<p>
					<?php esc_html_e( 'All rights reserved', 'music-star-amplify' ); ?> &copy; <?php bloginfo( 'name' ); ?>
					<a href="<?php echo esc_url( 'https://seosthemes.com/' ); ?>"><?php esc_html_e( 'Music Star Theme by Seos Themes', 'music-star-amplify' ); ?></a>
				</p>
			<?php endif; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	<?php if ( get_theme_mod( 'activate_back_to_top', true ) ) : ?>
		<a href="#" class="cd-top text-replace js-cd-top"><span class="dashicons dashicons-arrow-up-alt2" aria-hidden="true"></span><span class="screen-reader-text"><?php esc_html_e( 'Back to top', 'music-star-amplify' ); ?></span></a>
	<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>
