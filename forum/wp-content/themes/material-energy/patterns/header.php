<?php
/**
 * Title: Header
 * Slug: material-ai/header
 * Categories: material-ai
 * Block Types: core/template-part/header
 *
 * The Material Energy header. It keeps the parent's slug, so WordPress uses
 * it in place of Material AI's header on every template without a template
 * or template part being copied. The markup is Material AI Pro's Header 02
 * with the Energy wording; the classes materialai-header-spa and
 * materialai-header-energy carry the Energy look (see style.css).
 *
 * @package Material_Energy
 */

?>

<!-- wp:group {"metadata":{"patternName":"material-ai/header","name":"Header","categories":["material-ai"]},"align":"full","className":"materialai-header materialai-header-02 materialai-header-spa materialai-header-energy","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull materialai-header materialai-header-02 materialai-header-spa materialai-header-energy">

	<!-- wp:group {"align":"full","className":"materialai-topbar-02","layout":{"type":"default"}} -->
	<div class="wp-block-group alignfull materialai-topbar-02">

		<!-- wp:group {"align":"full","className":"materialai-topbar-02__gutter","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group alignfull materialai-topbar-02__gutter" style="margin-top:0;margin-bottom:0">

			<!-- wp:group {"style":{"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"30px","bottomRight":"30px"}},"spacing":{"padding":{"top":"clamp(6px, 1.2vw, 17px)","bottom":"clamp(6px, 1.2vw, 17px)","left":"0","right":"0"}}},"backgroundColor":"secondary","layout":{"type":"constrained","contentSize":"1620px"}} -->
			<div class="wp-block-group has-secondary-background-color has-background" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:30px;border-bottom-right-radius:30px;padding-top:clamp(6px, 1.2vw, 17px);padding-right:0;padding-bottom:clamp(6px, 1.2vw, 17px);padding-left:0">

				<!-- wp:group {"className":"materialai-topbar-02__row","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center","justifyContent":"space-between"}} -->
				<div class="wp-block-group materialai-topbar-02__row">

					<!-- wp:group {"className":"materialai-topbar-02__promo","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center","justifyContent":"left"}} -->
					<div class="wp-block-group materialai-topbar-02__promo">

						<!-- wp:paragraph {"className":"materialai-topbar-02__tag","style":{"border":{"radius":"999px"},"spacing":{"padding":{"top":"2px","bottom":"2px","left":"12px","right":"12px"}},"typography":{"letterSpacing":"0.5px"}},"backgroundColor":"primary","textColor":"light-color","fontSize":"small","fontFamily":"poppins"} -->
						<p class="materialai-topbar-02__tag has-light-color-color has-primary-background-color has-text-color has-background has-poppins-font-family has-small-font-size" style="border-radius:999px;padding-top:2px;padding-right:12px;padding-bottom:2px;padding-left:12px;letter-spacing:0.5px"><strong><?php esc_html_e( 'NEW', 'material-energy' ); ?></strong></p>
						<!-- /wp:paragraph -->

						<!-- wp:group {"className":"materialai-topbar-02__copy","style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
						<div class="wp-block-group materialai-topbar-02__copy">

							<!-- wp:paragraph {"style":{"typography":{"fontSize":"15px","fontWeight":"500"}},"textColor":"light-color","fontFamily":"poppins"} -->
							<p class="has-light-color-color has-text-color has-poppins-font-family" style="font-size:15px;font-weight:500"><?php esc_html_e( 'Flat 20% OFF on First Order | Free Shipping on Order Over $50', 'material-energy' ); ?></p>
							<!-- /wp:paragraph -->


						</div>
						<!-- /wp:group -->

					</div>
					<!-- /wp:group -->

					<!-- wp:group {"className":"materialai-topbar-02__meta","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center","justifyContent":"right"}} -->
					<div class="wp-block-group materialai-topbar-02__meta">


						<!-- wp:group {"className":"materialai-topbar-02__item","style":{"spacing":{"blockGap":"9px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
						<div class="wp-block-group materialai-topbar-02__item">

							<!-- wp:icon {"icon":"materialai/chat-fill","className":"materialai-topbar-02__icon materialai-topbar-02__icon--chat","style":{"dimensions":{"width":"18px"}},"textColor":"primary"} /-->

							<!-- wp:paragraph {"style":{"typography":{"fontSize":"15px","fontWeight":"500"}},"textColor":"light-color","fontFamily":"poppins"} -->
							<p class="has-light-color-color has-text-color has-poppins-font-family" style="font-size:15px;font-weight:500"><a href="#"><?php esc_html_e( 'Live Chat', 'material-energy' ); ?></a></p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:group {"className":"materialai-topbar-02__item","style":{"spacing":{"blockGap":"9px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
						<div class="wp-block-group materialai-topbar-02__item">

							<!-- wp:icon {"icon":"materialai/person-fill","className":"materialai-topbar-02__icon materialai-topbar-02__icon--user","style":{"dimensions":{"width":"18px"}},"textColor":"primary"} /-->

							<!-- wp:paragraph {"style":{"typography":{"fontSize":"15px","fontWeight":"500"}},"textColor":"light-color","fontFamily":"poppins"} -->
							<p class="has-light-color-color has-text-color has-poppins-font-family" style="font-size:15px;font-weight:500"><a href="#"><?php esc_html_e( 'Login', 'material-energy' ); ?></a></p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:group {"className":"materialai-topbar-02__item","style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
						<div class="wp-block-group materialai-topbar-02__item">

							<!-- wp:paragraph {"style":{"typography":{"fontSize":"15px","fontWeight":"500"}},"textColor":"light-color","fontFamily":"poppins"} -->
							<p class="has-light-color-color has-text-color has-poppins-font-family" style="font-size:15px;font-weight:500"><a href="#"><?php esc_html_e( 'Us Dollar', 'material-energy' ); ?></a></p>
							<!-- /wp:paragraph -->

							<!-- wp:icon {"icon":"materialai/arrow-drop-down","className":"materialai-topbar-02__icon materialai-topbar-02__icon--caret","style":{"dimensions":{"width":"18px"}},"textColor":"light-color"} /-->

						</div>
						<!-- /wp:group -->

					</div>
					<!-- /wp:group -->

				</div>
				<!-- /wp:group -->

			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"full","className":"materialai-nav-wrap-02","layout":{"type":"default"}} -->
	<div class="wp-block-group alignfull materialai-nav-wrap-02">

		<!-- wp:group {"className":"materialai-navbar-02","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center","justifyContent":"space-between"}} -->
		<div class="wp-block-group materialai-navbar-02">

			<!-- wp:group {"className":"site-branding materialai-branding-02","layout":{"type":"default"}} -->
			<div class="wp-block-group site-branding materialai-branding-02">

				<!-- wp:site-logo {"width":190,"shouldSyncIcon":true} /-->

				<!-- wp:group {"className":"site-branding-fallback","layout":{"type":"default"}} -->
				<div class="wp-block-group site-branding-fallback">
					<!-- wp:site-title {"level":3,"isLink":true} /-->
					<!-- wp:site-tagline /-->
				</div>
				<!-- /wp:group -->

			</div>
			<!-- /wp:group -->

			<!-- wp:navigation {"overlayMenu":"mobile","className":"materialai-nav-02","layout":{"type":"flex","justifyContent":"center"}} /-->

			<!-- wp:group {"className":"materialai-actions-02","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center","justifyContent":"right"}} -->
			<div class="wp-block-group materialai-actions-02">

				<!-- wp:search {"label":"","showLabel":false,"placeholder":"Search here…","width":100,"widthUnit":"%","buttonText":"","buttonPosition":"button-only","buttonUseIcon":true,"className":"search-btn search-btn-02"} /-->

				<!-- wp:woocommerce/mini-cart {"hasHiddenPrice":true,"className":"materialai-header-minicart materialai-minicart-02"} /-->

				<!-- wp:buttons {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<div class="wp-block-buttons">

					<!-- wp:button {"backgroundColor":"primary","textColor":"light-color","className":"materialai-btn-arrow materialai-btn-disc materialai-button-circle-secondary materialai-btn-started-02","fontSize":"normal"} -->
					<div class="wp-block-button materialai-btn-arrow materialai-btn-disc materialai-button-circle-secondary materialai-btn-started-02"><a class="wp-block-button__link has-light-color-color has-primary-background-color has-text-color has-background has-normal-font-size has-custom-font-size wp-element-button"><?php esc_html_e( 'Get a Free Quote', 'material-energy' ); ?></a></div>
					<!-- /wp:button -->

				</div>
				<!-- /wp:buttons -->

			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->
