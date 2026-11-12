<?php
/**
 * Title: Footer
 * Slug: material-ai/footer
 * Categories: material-ai
 *
 * @package Material AI
 */

?>
<!-- wp:group {"metadata":{"patternName":"material-ai/footer","name":"Footer","categories":["material-ai"]},"className":"materialai-footer","backgroundColor":"secondary","layout":{"type":"default"}} -->
<div class="wp-block-group materialai-footer has-secondary-background-color has-background">

	<!-- wp:group {"className":"footer-cta","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group footer-cta" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">

		<!-- wp:columns {"verticalAlignment":"center"} -->
		<div class="wp-block-columns are-vertically-aligned-center wow zoomIn">

			<!-- wp:column {"verticalAlignment":"center","width":"20%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:20%">

				<!-- wp:image {"width":"214px","height":"auto","sizeSlug":"full","linkDestination":"none","style":{"spacing":{"margin":{"top":"-90px"}}}} -->
				<figure class="wp-block-image size-full is-resized" style="margin-top:-90px">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/footer/footer-robot.png' ); ?>" alt="" style="width:214px;height:auto"/>
				</figure>
				<!-- /wp:image -->

			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"50%","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} -->
			<div class="wp-block-column is-vertically-aligned-center has-background-color has-text-color has-link-color" style="flex-basis:50%">

				<!-- wp:heading {"style":{"typography":{"lineHeight":"0.1"}}} -->
				<h2 class="wp-block-heading" style="line-height:0.1"><?php esc_html_e( 'Ready to build the future with AI?', 'material-ai' ); ?></h2>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px","lineHeight":"1.6"}}} -->
				<p style="font-size:16px;line-height:1.6"><?php esc_html_e( "Let's create intelligent solutions that drive real impact.", 'material-ai' ); ?></p>
				<!-- /wp:paragraph -->

			</div>
			<!-- /wp:column -->

			<!-- wp:column {"verticalAlignment":"center","width":"30%"} -->
			<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:30%">

				<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"right"}} -->
				<div class="wp-block-buttons">

					<!-- wp:button {"className":"materialai-button-right materialai-button-circle-secondary"} -->
					<div class="wp-block-button materialai-button-right materialai-button-circle-secondary">
						<a class="wp-block-button__link wp-element-button"><?php esc_html_e( "Let's Talk", 'material-ai' ); ?></a>
					</div>
					<!-- /wp:button -->

				</div>
				<!-- /wp:buttons -->

			</div>
			<!-- /wp:column -->

		</div>
		<!-- /wp:columns -->

	</div>
	<!-- /wp:group -->


	<!-- wp:group {"className":"materialai-footer-divider","style":{"spacing":{"margin":{"top":"-30px","bottom":"-30px"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group materialai-footer-divider" style="margin-top:-30px;margin-bottom:-30px">

		<!-- wp:html -->
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1920 82" aria-hidden="true" focusable="false">
			<defs>
				<style>
					.cls-1 {
						fill: none;
						stroke: var(--wp--preset--color--primary);
						stroke-width: 3px;
						fill-rule: evenodd;
						filter: url(#filter);
					}
					feFlood {
						flood-color: var(--wp--preset--color--primary);
					}
				</style>
				<filter id="filter" x="-20" y="7448" filterUnits="userSpaceOnUse">
					<feOffset result="offset" in="SourceAlpha"/>
					<feGaussianBlur result="blur" stdDeviation="4.472"/>
					<feFlood result="flood" flood-color="#5d85f3" flood-opacity="0.2"/>
					<feComposite result="composite" operator="in" in2="blur"/>
					<feBlend result="blend" in="SourceGraphic"/>
				</filter>
			</defs>

			<g transform="translate(0 -7448)" style="fill:none;filter:url(#filter)">
				<path
				id="Animation_Line"
				data-name="Animation Line"
				class="cls-1"
				d="M1,7489H930l17,16,17-33,18,25,14-8h924"
				style="stroke:inherit;filter:none;fill:inherit"
				/>
			</g>

			<use
			transform="translate(0 -7448)"
			href="#Animation_Line"
			style="stroke:var(--wp--preset--color--primary);filter:none;fill:none"
			/>
		</svg>
		<!-- /wp:html -->

	</div>
	<!-- /wp:group -->


	<!-- wp:group {"className":"materialai-footer-main","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"0","left":"0","top":"0","bottom":"0"},"blockGap":"0px"},"dimensions":{"minHeight":"0px"}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
	<div class="wp-block-group materialai-footer-main" style="min-height:0px;margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">

		<!-- wp:columns {"style":{"spacing":{"margin":{"top":"60px","bottom":"60px"}}}} -->
		<div class="wp-block-columns" style="margin-top:60px;margin-bottom:60px">

			<!-- wp:column {"verticalAlignment":"top","width":"30%","style":{"spacing":{"blockGap":"15px","padding":{"top":"0px","bottom":"0px"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
			<div class="wp-block-column is-vertically-aligned-top wow fadeInUp" style="padding-top:0px;padding-bottom:0px;flex-basis:30%">

				<!-- wp:image {"width":"225px","height":"auto","aspectRatio":"5.001233806292412","sizeSlug":"full","linkDestination":"none"} -->
				<figure class="wp-block-image size-full is-resized">
					<img
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/footer/footer-logo.png' ); ?>"
					alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
					style="aspect-ratio:5.001233806292412;width:225px;height:auto"
					/>
				</figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"16px"}},"textColor":"background"} -->
				<p class="has-background-color has-text-color has-link-color" style="font-size:16px"><?php esc_html_e( 'Lorem Ipsum is simply dummy text of the printing typesetting industry.', 'material-ai' ); ?><br><?php esc_html_e( 'Lorem Ipsum has been the when an unknown of type and scrambled.', 'material-ai' ); ?></p>
				<!-- /wp:paragraph -->


				<!-- wp:group {"layout":{"type":"constrained"}} -->
				<div class="wp-block-group">

					<!-- wp:separator {"className":"is-style-wide materialai-footer-sep","backgroundColor":"primary"} -->
					<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background is-style-wide materialai-footer-sep"/>
					<!-- /wp:separator -->

					<!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"blockGap":"8px","margin":{"top":"8px","bottom":"8px"}}},"textColor":"primary","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left","orientation":"horizontal"}} -->
					<div class="wp-block-group has-primary-color has-text-color has-link-color" style="margin-top:8px;margin-bottom:8px">

						<!-- wp:paragraph {"style":{"border":{"radius":{"topLeft":"50%","topRight":"50%","bottomLeft":"50%","bottomRight":"50%"},"width":"1px"},"spacing":{"padding":{"top":"10px","bottom":"10px","left":"3px","right":"3px"}},"typography":{"textAlign":"center"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background","fontSize":"small","borderColor":"primary"} -->
						<p class="has-text-align-center has-border-color has-primary-border-color has-background-color has-text-color has-link-color has-small-font-size footer-item-prs" style="border-width:1px;border-top-left-radius:50%;border-top-right-radius:50%;border-bottom-left-radius:50%;border-bottom-right-radius:50%;padding-top:10px;padding-right:3px;padding-bottom:10px;padding-left:3px">
							<strong><?php esc_html_e( '90%', 'material-ai' ); ?></strong>
						</p>
						<!-- /wp:paragraph -->

						<!-- wp:group {"style":{"spacing":{"blockGap":"10px","margin":{"top":"0","bottom":"0"},"padding":{"right":"0","left":"0","top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
						<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">

							<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} -->
							<p class="has-background-color has-text-color has-link-color">
								<strong><?php esc_html_e( 'Artificial Intelligence', 'material-ai' ); ?></strong>
							</p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

					</div>
					<!-- /wp:group -->


					<!-- wp:separator {"className":"is-style-wide materialai-footer-sep","style":{"spacing":{"margin":{"top":"0"}}},"backgroundColor":"primary"} -->
					<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background is-style-wide materialai-footer-sep" style="margin-top:0px"/>
<!-- /wp:separator -->

<!-- wp:group {"style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"spacing":{"margin":{"top":"8px","bottom":"8px"},"blockGap":"8px"}},"textColor":"primary","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left","orientation":"horizontal"}} -->
<div class="wp-block-group has-primary-color has-text-color has-link-color" style="margin-top:8px;margin-bottom:8px">

	<!-- wp:paragraph {"style":{"border":{"radius":{"topLeft":"50%","topRight":"50%","bottomLeft":"50%","bottomRight":"50%"},"width":"1px"},"spacing":{"padding":{"top":"10px","bottom":"10px","left":"3px","right":"3px"}},"typography":{"textAlign":"center"}},"textColor":"background","fontSize":"small","borderColor":"primary"} -->
	<p class="has-text-align-center has-border-color has-primary-border-color has-background-color has-text-color has-link-color has-small-font-size footer-item-prs" style="border-width:1px;border-top-left-radius:50%;border-top-right-radius:50%;border-bottom-left-radius:50%;border-bottom-right-radius:50%;padding-top:10px;padding-right:3px;padding-bottom:10px;padding-left:3px">
		<strong><?php esc_html_e( '70%', 'material-ai' ); ?></strong>
	</p>
	<!-- /wp:paragraph -->


	<!-- wp:group {"layout":{"type":"constrained"}} -->
	<div class="wp-block-group">

		<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} -->
		<p class="has-background-color has-text-color has-link-color">
			<strong><?php esc_html_e( 'Robotics Management', 'material-ai' ); ?></strong>
		</p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->


<!-- wp:separator {"className":"is-style-wide materialai-footer-sep","backgroundColor":"primary","style":{"spacing":{"margin":{"top":"0px","bottom":"10px"}}}} -->
<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background is-style-wide materialai-footer-sep" style="margin-top:0px;margin-bottom:10px"/>
<!-- /wp:separator -->

</div>
<!-- /wp:group -->


<!-- wp:social-links {"iconColor":"secondary","iconColorValue":"var(--wp--preset--color--secondary)","iconBackgroundColor":"background","iconBackgroundColorValue":"#FFFFFF","size":"has-normal-icon-size","className":"is-style-default","style":{"spacing":{"margin":{"top":"20px","bottom":"20px"},"blockGap":{"top":"9px","left":"15px"}}}} -->
<ul class="wp-block-social-links has-normal-icon-size has-icon-color has-icon-background-color is-style-default" style="margin-top:20px;margin-bottom:20px">
	<!-- wp:social-link {"url":"#","service":"facebook"} /-->
	<!-- wp:social-link {"url":"#","service":"twitter"} /-->
	<!-- wp:social-link {"url":"#","service":"instagram"} /-->
	<!-- wp:social-link {"url":"#","service":"behance"} /-->
	<!-- wp:social-link {"url":"#","service":"youtube"} /-->
</ul>
<!-- /wp:social-links -->

</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"20%","layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-column is-vertically-aligned-top wow fadeInUp" style="flex-basis:20%">

	<!-- wp:heading {"level":5,"className":"materialai-footer-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} -->
	<h5 class="wp-block-heading materialai-footer-title has-background-color has-text-color has-link-color"><?php esc_html_e( 'Quick Links', 'material-ai' ); ?></h5>
	<!-- /wp:heading -->


	<!-- wp:list {"className":"materialai-footer-links","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} -->
	<ul class="wp-block-list materialai-footer-links has-background-color has-text-color has-link-color">

		<!-- wp:list-item -->
		<li>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'material-ai' ); ?></a>
		</li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'About Us', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'Services', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'Blog', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'Portfolio', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'Contact Us', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

	</ul>
	<!-- /wp:list -->

</div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top","width":"20%","layout":{"type":"constrained","justifyContent":"left"}} -->
<div class="wp-block-column is-vertically-aligned-top wow fadeInUp" style="flex-basis:20%">

	<!-- wp:heading {"level":5,"className":"materialai-footer-title","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} -->
	<h5 class="wp-block-heading materialai-footer-title has-background-color has-text-color has-link-color"><?php esc_html_e( 'Our Services', 'material-ai' ); ?></h5>
	<!-- /wp:heading -->


	<!-- wp:list {"className":"materialai-footer-links","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} -->
	<ul class="wp-block-list materialai-footer-links has-background-color has-text-color has-link-color">

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'AI Powered Solutions', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'Custom Technology', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'Predictive Analytics', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'Machine Learning', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'Language Processing ', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

		<!-- wp:list-item -->
		<li><a href="#"><?php esc_html_e( 'Computer Vision', 'material-ai' ); ?></a></li>
		<!-- /wp:list-item -->

	</ul>
	<!-- /wp:list -->

</div>
<!-- /wp:column -->

<!-- wp:column {"width":"26%","className":"newsletter-card","style":{"spacing":{"blockGap":"0","padding":{"right":"0","left":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-column newsletter-card wow fadeInUp" style="padding-right:0;padding-left:0;flex-basis:26%">

	<!-- wp:group {"className":"materialai-subscribe-card","style":{"spacing":{"padding":{"top":"15px","bottom":"15px","left":"16px","right":"15px"},"blockGap":"0px"},"border":{"radius":{"topLeft":"0px","topRight":"0px","bottomLeft":"0px","bottomRight":"0px"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group materialai-subscribe-card" style="border-top-left-radius:0px;border-top-right-radius:0px;border-bottom-left-radius:0px;border-bottom-right-radius:0px;padding-top:15px;padding-right:15px;padding-bottom:15px;padding-left:16px">

		<!-- wp:heading {"level":3,"style":{"typography":{"textAlign":"center","fontSize":"36px"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"margin":{"top":"10px","bottom":"10px"}}},"textColor":"background"} -->
		<h3 class="wp-block-heading has-text-align-center has-background-color has-text-color has-link-color" style="margin-top:10px;margin-bottom:10px;font-size:36px">
			<?php esc_html_e( 'Stay Ahead With', 'material-ai' ); ?><mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color"><?php esc_html_e( 'AI', 'material-ai' ); ?></mark>
		</h3>
		<!-- /wp:heading -->

		<!-- wp:shortcode -->
		[contact-form-7 id="8dea8c7" title="Contact form 1"]
		<!-- /wp:shortcode -->

		<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"10px","bottom":"10px"}}},"textColor":"background"} -->
		<p class="has-background-color has-text-color has-link-color" style="margin-top:10px;margin-bottom:10px;font-size:16px">
			<span aria-hidden="true">🛡️</span> <strong><?php esc_html_e( 'No spam. Unsubscribe anytime ', 'material-ai' ); ?></strong>
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:separator {"align":"full","className":"is-style-wide","style":{"spacing":{"margin":{"top":"0px","bottom":"0px"}}},"backgroundColor":"primary"} -->
		<hr class="wp-block-separator alignfull has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background is-style-wide" style="margin-top:0px;margin-bottom:0px"/>
		<!-- /wp:separator -->

		<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"margin":{"top":"10px","bottom":"10px"}}},"textColor":"background"} -->
		<p class="has-background-color has-text-color has-link-color" style="margin-top:10px;margin-bottom:10px;font-size:16px">
			<span aria-hidden="true">📍</span> <strong><?php esc_html_e( '7164 Barton Terrace, Vermont, 97879, USA', 'material-ai' ); ?></strong>
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}},"spacing":{"margin":{"top":"10px","bottom":"10px"}}},"textColor":"background"} -->
		<p class="has-background-color has-text-color has-link-color" style="margin-top:10px;margin-bottom:10px;font-size:16px">
			<span aria-hidden="true">☎️</span> <strong><?php esc_html_e( '+1 70 975 975 70', 'material-ai' ); ?></strong>
		</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} -->
		<p class="has-background-color has-text-color has-link-color" style="font-size:16px">
			<span aria-hidden="true">📩</span> <strong><?php esc_html_e( 'info@example.com', 'material-ai' ); ?></strong>
		</p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:column -->

</div>
<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- wp:group {"className":"footer-top-border-box","layout":{"type":"default"}} -->
<div class="wp-block-group footer-top-border-box">

	<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":{"top":"0","left":"0"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center" style="padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">

		<!-- wp:column {"verticalAlignment":"center","width":"49.25%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:49.25%">

			<!-- wp:separator {"className":"is-style-wide materialai-footer-sep","backgroundColor":"primary"} -->
			<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background is-style-wide materialai-footer-sep"/>
			<!-- /wp:separator -->

		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"2%","style":{"border":{"width":"1px","radius":{"topLeft":"50%","topRight":"50%","bottomLeft":"50%","bottomRight":"50%"}},"spacing":{"padding":{"top":"6px","bottom":"6px","left":"5px","right":"5px"},"blockGap":"0"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","className":"footer-border-icon materialai-footer-sep"} -->
		<div class="wp-block-column is-vertically-aligned-center has-primary-color has-text-color has-link-color footer-border-icon materialai-footer-sep" style="border-width:1px;border-top-left-radius:50%;border-top-right-radius:50%;border-bottom-left-radius:50%;border-bottom-right-radius:50%;padding-top:6px;padding-right:5px;padding-bottom:6px;padding-left:5px;flex-basis:2%;">

			<!-- wp:icon {"icon":"core/arrow-up","align":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background","ariaLabel":""} /-->

		</div>
		<!-- /wp:column -->


		<!-- wp:column {"verticalAlignment":"center","width":"49.25%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:49.25%">

			<!-- wp:separator {"className":"is-style-wide materialai-footer-sep","backgroundColor":"primary"} -->
			<hr class="wp-block-separator has-text-color has-primary-color has-alpha-channel-opacity has-primary-background-color has-background is-style-wide materialai-footer-sep"/>
			<!-- /wp:separator -->

		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0">

	<!-- wp:group {"style":{"spacing":{"blockGap":"0","padding":{"right":"0","left":"0","top":"0","bottom":"15px"},"margin":{"top":"0"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group" style="margin-top:0;padding-top:0;padding-right:0;padding-bottom:15px;padding-left:0">

		<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
		<div class="wp-block-group">

			<!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} -->
			<p class="has-background-color has-text-color has-link-color" style="font-size:16px">
				<?php echo esc_html__( 'Copyright ©', 'material-ai' ); ?>
				<?php echo esc_html( wp_date( 'Y' ) ); ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color">
						<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
					</mark>
					</a><?php echo esc_html__( ', All rights reserved.', 'material-ai' ); ?>
				</p>
				<!-- /wp:paragraph -->

			</div>
			<!-- /wp:group -->


			<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
			<div class="wp-block-group">

				<!-- wp:navigation {"ref":343,"textColor":"background","style":{"typography":{"fontSize":"16px"}}} /-->

			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="Preloader">
	<div class="pl">
		<svg class="pl__rings" viewBox="0 0 128 128" width="128" height="128" aria-hidden="true" focusable="false">
			<g fill="none" stroke-linecap="round" stroke-width="4">

				<g class="pl__ring" transform="rotate(0)">
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="color-mix(in srgb, var(--wp--preset--color--primary) 30%, transparent)" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="color-mix(in srgb, var(--wp--preset--color--primary) 50%, transparent)" stroke-dasharray="50 240" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="var(--wp--preset--color--primary)" stroke-dasharray="25 265" />
				</g>

				<g class="pl__ring" transform="rotate(0)">
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="transparent" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="color-mix(in srgb, var(--wp--preset--color--primary) 50%, transparent)" stroke-dasharray="50 240" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="var(--wp--preset--color--primary)" stroke-dasharray="25 265" />
				</g>

				<g class="pl__ring" transform="rotate(0)">
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="transparent" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="color-mix(in srgb, var(--wp--preset--color--primary) 50%, transparent)" stroke-dasharray="50 240" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="var(--wp--preset--color--primary)" stroke-dasharray="25 265" />
				</g>

				<g class="pl__ring" transform="rotate(0)">
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="transparent" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="color-mix(in srgb, var(--wp--preset--color--primary) 50%, transparent)" stroke-dasharray="50 240" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="var(--wp--preset--color--primary)" stroke-dasharray="25 265" />
				</g>

				<g class="pl__ring" transform="rotate(180)">
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="color-mix(in srgb, var(--wp--preset--color--primary) 30%, transparent)" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="color-mix(in srgb, var(--wp--preset--color--primary) 50%, transparent)" stroke-dasharray="50 240" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="var(--wp--preset--color--primary)" stroke-dasharray="25 265" />
				</g>

				<g class="pl__ring" transform="rotate(180)">
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="transparent" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="color-mix(in srgb, var(--wp--preset--color--primary) 50%, transparent)" stroke-dasharray="50 240" />
					<ellipse class="pl__orbit" cx="64" cy="64" rx="60" ry="30" stroke="var(--wp--preset--color--primary)" stroke-dasharray="25 265" />
				</g>

				<g class="pl__ring" transform="rotate(0)">
					<ellipse class="pl__electron" cx="64" cy="64" rx="60" ry="30" stroke="hsl(0,0%,100%)" stroke-dasharray="1 289" stroke-width="8" />
					<ellipse class="pl__electron" cx="64" cy="64" rx="60" ry="30" stroke="hsl(0,0%,100%)" stroke-dasharray="1 289" stroke-width="8" />
				</g>

				<g class="pl__ring" transform="rotate(180)">
					<ellipse class="pl__electron" cx="64" cy="64" rx="60" ry="30" stroke="hsl(0,0%,100%)" stroke-dasharray="1 289" stroke-width="8" />
					<ellipse class="pl__electron" cx="64" cy="64" rx="60" ry="30" stroke="hsl(0,0%,100%)" stroke-dasharray="1 289" stroke-width="8" />
					<ellipse class="pl__electron" cx="64" cy="64" rx="60" ry="30" stroke="hsl(0,0%,100%)" stroke-dasharray="1 289" stroke-width="8" />
					<ellipse class="pl__electron" cx="64" cy="64" rx="60" ry="30" stroke="hsl(0,0%,100%)" stroke-dasharray="1 289" stroke-width="8" />
				</g>

			</g>
		</svg>

		<div class="pl__nucleus">
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
			<div class="pl__nucleus-particle"></div>
		</div>
	</div>
</div>
<!-- /wp:html -->

<!-- wp:group {"className":"materialai-back-to-top","layout":{"type":"default"}} -->
<div class="wp-block-group materialai-back-to-top">

	<!-- wp:html -->
	<a
	class="materialai-back-to-top__button"
	href="#"
	aria-label="<?php echo esc_attr__( 'Back to top', 'material-ai' ); ?>"
	>
	<svg
	class="materialai-back-to-top__text"
	viewBox="0 0 140 140"
	aria-hidden="true"
	focusable="false"
	>
	<defs>
		<path
		id="materialai-back-to-top-circle"
		d="M 70,70 m -54,0 a 54,54 0 1,1 108,0 a 54,54 0 1,1 -108,0"
		/>
	</defs>

	<text>
		<textPath
		href="#materialai-back-to-top-circle"
		startOffset="0%"
		><?php esc_html_e( 'AI BACK TO TOP AI BACK TO TOP AI BACK TO TOP', 'material-ai' ); ?></textPath>
	</text>
</svg>

<span class="materialai-back-to-top__outer-ring" aria-hidden="true"></span>

<span class="materialai-back-to-top__core" aria-hidden="true">
	<svg
	class="materialai-back-to-top__arrow"
	viewBox="0 0 24 24"
	focusable="false"
	>
	<path d="M12 19V5"></path>
	<path d="M6 11L12 5L18 11"></path>
</svg>
</span>
</a>
<!-- /wp:html -->

</div>
<!-- /wp:group -->