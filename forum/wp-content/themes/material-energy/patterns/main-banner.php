<?php
/**
 * Title: Main Banner
 * Slug: material-ai/main-banner
 * Categories: material-ai
 *
 * The Material Energy hero. It keeps the parent's slug, so the front page
 * shows it in place of Material AI's banner without the template being
 * copied. The markup is the first slide of Material AI Pro's Slider 04, as a
 * single static Cover block — its photograph, overlay and copy are all
 * editable — followed by the strip of four highlights. The wrapper keeps its
 * slider-2 class because the hero's height rules hang off it; nothing turns
 * it into a carousel, and it has no slide arrows.
 *
 * To change a highlight, edit it in the editor; to add one, duplicate an
 * item in the strip.
 *
 * @package Material_Energy
 */

$material_energy_img = trailingslashit( get_theme_file_uri( 'assets/images/energy' ) );

$material_energy_features = array(
	array(
		'image' => 'sustainable.png',
		'title' => __( 'Sustainable', 'material-energy' ),
		'text'  => __( 'Clean Energy', 'material-energy' ),
	),
	array(
		'image' => 'reliable.png',
		'title' => __( 'Reliable', 'material-energy' ),
		'text'  => __( 'High Performance', 'material-energy' ),
	),
	array(
		'image' => 'cost-saving.png',
		'title' => __( 'Cost Saving', 'material-energy' ),
		'text'  => __( 'Lower Bills', 'material-energy' ),
	),
	array(
		'image' => 'eco-friendly.png',
		'title' => __( 'Eco Friendly', 'material-energy' ),
		'text'  => __( 'Better Tomorrow', 'material-energy' ),
	),
);
?>

<!-- wp:group {"metadata":{"patternName":"material-ai/main-banner","name":"Main Banner","categories":["material-ai"]},"align":"full","className":"materialai-hero2 materialai-hero-spa materialai-hero-energy","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull materialai-hero2 materialai-hero-spa materialai-hero-energy">

	<!-- wp:group {"className":"slider-2","layout":{"type":"default"}} -->
	<div class="wp-block-group slider-2">

		<!-- wp:cover {"url":"<?php echo esc_url( $material_energy_img . 'hero-bg.jpg' ); ?>","dimRatio":50,"isUserOverlayColor":false,"isDark":false,"sizeSlug":"large","className":"materialai-hero2-slide","layout":{"type":"default"}} -->
		<div class="wp-block-cover is-light materialai-hero2-slide"><img class="wp-block-cover__image-background size-large" alt="" src="<?php echo esc_url( $material_energy_img . 'hero-bg.jpg' ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-background-dim"></span><div class="wp-block-cover__inner-container">

			<!-- wp:group {"className":"materialai-hero2-inner","style":{"spacing":{"blockGap":"0px"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
			<div class="wp-block-group materialai-hero2-inner">

				<!-- wp:group {"className":"materialai-hero2-content","style":{"spacing":{"blockGap":"28px"}},"layout":{"type":"constrained","justifyContent":"left","contentSize":"900px"}} -->
				<div class="wp-block-group materialai-hero2-content">

					<!-- wp:group {"className":"materialai-badge wow fadeInUp","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center","justifyContent":"left"}} -->
					<div class="wp-block-group materialai-badge wow fadeInUp">

						<!-- wp:icon {"icon":"materialai/bolt-fill","textColor":"primary"} /-->

						<!-- wp:paragraph {"className":"materialai-hero2-eyebrow","textColor":"light-color","fontFamily":"poppins"} -->
						<p class="materialai-hero2-eyebrow has-light-color-color has-text-color has-poppins-font-family"><?php esc_html_e( 'Clean Energy Brighter Tomorrow', 'material-energy' ); ?></p>
						<!-- /wp:paragraph -->

					</div>
					<!-- /wp:group -->

					<!-- wp:heading {"level":1,"className":"materialai-hero2-title wow fadeInUp","textColor":"light-color","fontFamily":"poppins"} -->
					<h1 class="wp-block-heading materialai-hero2-title wow fadeInUp has-light-color-color has-text-color has-poppins-font-family"><?php esc_html_e( 'Powering A Cleaner', 'material-energy' ); ?><br><?php esc_html_e( '& Greener', 'material-energy' ); ?> <mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color"><?php esc_html_e( 'Future', 'material-energy' ); ?></mark></h1>
					<!-- /wp:heading -->

					<!-- wp:paragraph {"className":"materialai-hero2-text wow fadeInUp","textColor":"light-color","fontFamily":"poppins"} -->
					<p class="materialai-hero2-text wow fadeInUp has-light-color-color has-text-color has-poppins-font-family"><?php esc_html_e( 'Sustainable energy solutions for a smarter, cleaner and brighter tomorrow.', 'material-energy' ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:buttons {"className":"materialai-hero2-buttons wow fadeInUp","layout":{"type":"flex","flexWrap":"wrap"}} -->
					<div class="wp-block-buttons materialai-hero2-buttons wow fadeInUp">

						<!-- wp:button {"backgroundColor":"secondary","textColor":"light-color","className":"materialai-btn-arrow materialai-btn-disc materialai-btn-ring-02"} -->
						<div class="wp-block-button materialai-btn-arrow materialai-btn-disc materialai-btn-ring-02"><a class="wp-block-button__link has-light-color-color has-secondary-background-color has-text-color has-background wp-element-button" href="#"><?php esc_html_e( 'Explore Solutions', 'material-energy' ); ?></a></div>
						<!-- /wp:button -->

						<!-- wp:button {"backgroundColor":"secondary","textColor":"light-color","className":"materialai-btn-arrow materialai-btn-disc materialai-btn-ring-02"} -->
						<div class="wp-block-button materialai-btn-arrow materialai-btn-disc materialai-btn-ring-02"><a class="wp-block-button__link has-light-color-color has-secondary-background-color has-text-color has-background wp-element-button" href="#"><?php esc_html_e( 'Learn More', 'material-energy' ); ?></a></div>
						<!-- /wp:button -->

					</div>
					<!-- /wp:buttons -->

				</div>
				<!-- /wp:group -->

			</div>
			<!-- /wp:group -->

		</div></div>
		<!-- /wp:cover -->

	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"materialai-hero2-statsbar","layout":{"type":"default"}} -->
	<div class="wp-block-group materialai-hero2-statsbar">

		<!-- wp:group {"className":"materialai-spa-features","layout":{"type":"default"}} -->
		<div class="wp-block-group materialai-spa-features">

		<?php foreach ( $material_energy_features as $material_energy_feature ) : ?>

			<!-- wp:group {"className":"materialai-spa-feature wow fadeInUp","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
			<div class="wp-block-group materialai-spa-feature wow fadeInUp">

				<!-- wp:image {"sizeSlug":"full","className":"materialai-spa-feature__icon"} -->
				<figure class="wp-block-image size-full materialai-spa-feature__icon"><img src="<?php echo esc_url( $material_energy_img . $material_energy_feature['image'] ); ?>" alt=""/></figure>
				<!-- /wp:image -->

				<!-- wp:group {"className":"materialai-spa-feature__content","style":{"spacing":{"blockGap":"2px"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
				<div class="wp-block-group materialai-spa-feature__content">

					<!-- wp:heading {"level":3,"className":"materialai-spa-feature__title","textColor":"primary","fontFamily":"poppins"} -->
					<h3 class="wp-block-heading materialai-spa-feature__title has-primary-color has-text-color has-poppins-font-family"><?php echo esc_html( $material_energy_feature['title'] ); ?></h3>
					<!-- /wp:heading -->

					<!-- wp:paragraph {"className":"materialai-spa-feature__text","textColor":"light-color","fontFamily":"poppins"} -->
					<p class="materialai-spa-feature__text has-light-color-color has-text-color has-poppins-font-family"><?php echo esc_html( $material_energy_feature['text'] ); ?></p>
					<!-- /wp:paragraph -->

				</div>
				<!-- /wp:group -->

			</div>
			<!-- /wp:group -->

		<?php endforeach; ?>

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
