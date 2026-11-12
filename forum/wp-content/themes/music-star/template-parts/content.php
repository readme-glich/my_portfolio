<?php
// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package score
 */

?>
<?php global $music_star_posts_count; ++$music_star_posts_count; 



?>
		<?php
		if ( has_post_thumbnail() and get_theme_mod('hide_featured') and is_singular() ) { ?>
			<div class="post-thumb-featured">
				<?php the_post_thumbnail( 'post-thumbnail', array( 'itemprop' => 'image' ) ); ?>
			</div>
		<?php } ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(music_star_post_class ());   ?>>
<div <?php if(!is_singular() ) { ?>class="content-seos"<?php } else { ?> class="art-width"<?php } ?> <?php echo wp_kses_post(music_star_animation( "music_star_articles_animation" )); ?>>
	<header class="entry-header">

		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		the_excerpt();
		endif;
		
		if ( !is_singular() ) {
?>

		<footer class="entry-footer">
		<?php if ( 'post' === get_post_type() ) { ?>
			<div class="entry-meta">
			<?php music_star_posted_on(); ?>
				<?php
				$music_star_categories_list = get_the_category_list( esc_html__( ', ', 'music-star' ) );
				if ( $music_star_categories_list ) {
					/* translators: 1: list of categories. */
					echo '<span class="news-cate cat-hide"><span class="dashicons dashicons-portfolio"></span> <span class="cat-links  "></span>'. wp_kses_post( $music_star_categories_list ).'</span>' ;
				}
				music_star_posted_by();
				music_star_entry_footer(); 
				?>
			</div><!-- .entry-meta -->
		<?php } ?>	


	</footer><!-- .entry-footer -->	
	
		<?php } ?>
	</header>
</div>
	<?php if ( (is_front_page() || is_home() || is_category() || is_archive() || is_page_template('template-blog.php')) and (!is_page_template( 'templeat-full-width.php'))) : ?>
	<?php if ( !get_theme_mod('hide_read_more') ) { ?>
		<?php if ( has_post_thumbnail() ) { ?>
		<a <?php echo wp_kses_post(music_star_animation_post_image( "music_star_articles_featured_image" )); ?> class="app-img-effect" href="<?php the_permalink(); ?>">
			<div class="app-first">
				<div class="app-sub">
				<div class="hover-eff">
					<div class="fig">
							<div class="art-title"><?php the_title( ); ?></div>
							<div class="art-shadow"></div>
						    <?php the_post_thumbnail( 'post-thumbnail', array( 'itemprop' => 'image' ) ); ?>		
					</div>
				</div>
				</div>
			</div>
		</a> 
	
		<?php } ?>
		<?php if ( !has_post_thumbnail() ) { ?>
		<a <?php echo wp_kses_post(music_star_animation_post_image( "music_star_articles_featured_image" )); ?> class="app-img-effect" href="<?php the_permalink(); ?>">
			<div class="app-first">
				<div class="app-sub">
				<div class="hover-eff">
					<div class="fig">
							<div class="art-shadow"></div>
						    <img class="attachment-post-thumbnail size-post-thumbnail wp-post-image" alt="featured image" src="<?php echo esc_url( get_template_directory_uri() )."/images/featured.jpg"; ?>"/> 		
					</div>
				</div>
				</div>
			</div>
		</a> 
	
		<?php } ?>		
	<?php  

	} else {
?>
	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'music-star' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		?>
	</div><!-- .entry-content -->

<?php } ?>
	
	<?php else : ?>

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'music-star' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'music-star' ),
			'after'  => '</div>',
		) );
		?>		
		<footer class="entry-footer">
		<?php if ( 'post' === get_post_type() ) { ?>
			<div  class="entry-meta">
				<?php
				music_star_posted_on(); 
				$music_star_categories_list = get_the_category_list( esc_html__( ', ', 'music-star' ) );
				if ( $music_star_categories_list ) {
					/* translators: 1: list of categories. */
					echo '<span class="news-cate cat-hide"><span class="dashicons dashicons-portfolio"></span> <span class="cat-links  "></span>'. wp_kses_post( $music_star_categories_list ).'</span>' ;
				}
				music_star_posted_by();
				music_star_entry_footer(); 
				?>
			</div><!-- .entry-meta -->
		<?php } ?>	
		</footer><!-- .entry-footer -->	
	</div><!-- .entry-content -->
	
<?php endif; ?>
	
</article>