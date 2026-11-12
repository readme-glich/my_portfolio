<?php
// Do not allow direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The template for displaying the footer
 * Contains the closing of the #content div and all content after.
 */
?>
	</div><!-- #content -->
	<footer id="colophon" class="site-footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
			<div class="footer-center">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="footer-widgets">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
					<div class="footer-widgets">
						<?php dynamic_sidebar( 'footer-2' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
					<div class="footer-widgets">
						<?php dynamic_sidebar( 'footer-3' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
					<div class="footer-widgets">
						<?php dynamic_sidebar( 'footer-4' ); ?>
					</div>
				<?php endif; ?>
			</div>		
		<div class="site-info">
		<?php if ( get_theme_mod( 'music_star_active_social' ) ) { music_star_social_section (); } ?>
		<?php
		if ( get_theme_mod( 'music_star_copyright' ) ) {
			echo "<p>".esc_html( get_theme_mod( 'music_star_copyright' ) );
			?>
			<a title="Music Star Theme - seos" href="<?php echo esc_url( 'https://seosthemes.com/', 'music-star' ); ?>" target="_blank"><?php esc_html_e( 'Music Star Theme by Seos Themes', 'music-star' ); ?></a>
			<?php
			echo "</p>";
		}
		else { ?>
			<a class="powered" href="<?php echo esc_url( __( 'https://wordpress.org/', 'music-star' ) ); ?>">
				<?php
				esc_html_e( 'Powered by WordPress', 'music-star' );
				?>
			</a>
			<p>
				<?php esc_html_e( 'All rights reserved', 'music-star' ); ?>  &copy; <?php bloginfo( 'name' ); ?>			
				<a title="Music Star Theme - SEOS" href="<?php echo esc_url( 'https://seosthemes.com/', 'music-star' ); ?>" target="_blank"><?php esc_html_e( 'Music Star Theme by Seos Themes', 'music-star' ); ?></a>
			</p>
		<?php } ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	<?php if( get_theme_mod( 'activate_back_to_top', true ) ) { ?>
	<a   href="#" class="cd-top text-replace js-cd-top"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
	<?php } ?>
<?php wp_footer(); ?>
</body>
</html>