<?php
/**
 * Title: CTA Banner
 * Slug: material-ai/cta-banner
 * Categories: material-ai
 *
 * @package Material AI
 */
?>
<!-- wp:group {"className":"materialai-cta-banner","style":{"background":{"backgroundImage":{"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/cta-banner/cta-banner-bg.jpg","id":1026,"source":"file","title":"cta-banner-bg"},"backgroundSize":"cover"}},"layout":{"type":"default"}} -->
<div class="wp-block-group materialai-cta-banner">

	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">

		<!-- wp:columns -->
		<div class="wp-block-columns">

			<!-- wp:column {"style":{"spacing":{"padding":{"top":"100px","bottom":"100px","left":"0px","right":"0px"}}}} -->
			<div class="wp-block-column wow fadeInLeft" style="padding-top:100px;padding-right:0px;padding-bottom:100px;padding-left:0px">

				<!-- wp:heading {"level":4,"textColor":"light-color","fontFamily":"jost","style":{"typography":{"fontSize":"20px"},"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}}} -->
				<h4 class="wp-block-heading has-light-color-color has-text-color has-link-color has-jost-font-family" style="font-size:20px"><?php esc_html_e( 'GET STARTED', 'material-ai' ); ?></h4>
				<!-- /wp:heading -->

				<!-- wp:heading {"textColor":"light-color","fontFamily":"jost","style":{"typography":{"fontSize":"50px","lineHeight":"1.2"},"elements":{"link":{"color":{"text":"var:preset|color|light-color"}}}}} -->
				<h2 class="wp-block-heading has-light-color-color has-text-color has-link-color has-jost-font-family" style="font-size:50px;line-height:1.2"><?php esc_html_e( "Let's Make Something Great Together", 'material-ai' ); ?></h2>
				<!-- /wp:heading -->

				<!-- wp:buttons -->
				<div class="wp-block-buttons">

					<!-- wp:button {"className":"materialai-cta-banner-btn","fontFamily":"jost"} -->
					<div class="wp-block-button materialai-cta-banner-btn">
						<a class="wp-block-button__link has-jost-font-family wp-element-button" href="#"><?php esc_html_e( 'Contact Us', 'material-ai' ); ?></a>
					</div>
					<!-- /wp:button -->

				</div>
				<!-- /wp:buttons -->

			</div>
			<!-- /wp:column -->

			<!-- wp:column -->
			<div class="wp-block-column wow fadeInRight">

				<!-- wp:image {"id":1029,"sizeSlug":"full","linkDestination":"none"} -->
				<figure class="wp-block-image size-full">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/cta-banner/cta-banner-right.png" alt="" class="wp-image-1029"/>
				</figure>
				<!-- /wp:image -->

			</div>
			<!-- /wp:column -->

		</div>
		<!-- /wp:columns -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->