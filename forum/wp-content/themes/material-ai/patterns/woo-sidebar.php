<?php
/**
 * Title: WooCommerce Sidebar
 * Slug: material-ai/woo-sidebar
 * Categories: material-ai
 * Inserter: no
 *
 * @package Material AI
 */

?>
	<!-- wp:group {"className":"materialai-woo-widget","layout":{"type":"default"}} -->
	<div class="wp-block-group materialai-woo-widget">
		<!-- wp:heading {"level":3,"className":"materialai-woo-widget-title"} -->
		<h3 class="wp-block-heading materialai-woo-widget-title"><?php esc_html_e( 'Search', 'material-ai' ); ?></h3>
		<!-- /wp:heading -->
		<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search...","buttonText":"Search","buttonUseIcon":true,"query":{"post_type":"product"}} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"materialai-woo-widget","layout":{"type":"default"}} -->
	<div class="wp-block-group materialai-woo-widget">
		<!-- wp:woocommerce/filter-wrapper {"filterType":"price-filter","heading":"Filter By Price"} -->
		<div class="wp-block-woocommerce-filter-wrapper">
			<!-- wp:heading {"level":3,"className":"materialai-woo-widget-title"} -->
			<h3 class="wp-block-heading materialai-woo-widget-title"><?php esc_html_e( 'Filter By Price', 'material-ai' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:woocommerce/price-filter {"showInputFields":false,"showFilterButton":true,"heading":""} -->
			<div class="wp-block-woocommerce-price-filter is-loading" data-showinputfields="false" data-showfilterbutton="true" data-heading="" data-heading-level="3"><span aria-hidden="true" class="wc-block-product-categories__placeholder"></span></div>
			<!-- /wp:woocommerce/price-filter -->
		</div>
		<!-- /wp:woocommerce/filter-wrapper -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"materialai-woo-widget","layout":{"type":"default"}} -->
	<div class="wp-block-group materialai-woo-widget">
		<!-- wp:heading {"level":3,"className":"materialai-woo-widget-title"} -->
		<h3 class="wp-block-heading materialai-woo-widget-title"><?php esc_html_e( 'Categories', 'material-ai' ); ?></h3>
		<!-- /wp:heading -->
		<!-- wp:woocommerce/product-categories {"hasCount":true,"hasEmpty":false} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"materialai-woo-widget","layout":{"type":"default"}} -->
	<div class="wp-block-group materialai-woo-widget">
		<!-- wp:heading {"level":3,"className":"materialai-woo-widget-title"} -->
		<h3 class="wp-block-heading materialai-woo-widget-title"><?php esc_html_e( 'Best Selling Product', 'material-ai' ); ?></h3>
		<!-- /wp:heading -->
		<!-- wp:woocommerce/product-collection {"queryId":1,"query":{"perPage":3,"pages":1,"offset":0,"postType":"product","order":"desc","orderBy":"popularity","search":"","exclude":[],"inherit":false,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[]},"tagName":"div","displayLayout":{"type":"flex","columns":1,"shrinkColumns":true},"collection":"woocommerce/product-collection/best-sellers","className":"materialai-woo-bestsellers"} -->
		<div class="wp-block-woocommerce-product-collection materialai-woo-bestsellers">
			<!-- wp:woocommerce/product-template -->
				<!-- wp:group {"className":"materialai-woo-bestseller","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
				<div class="wp-block-group materialai-woo-bestseller">
					<!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true} /-->
					<!-- wp:group {"layout":{"type":"default"}} -->
					<div class="wp-block-group">
						<!-- wp:post-title {"level":4,"isLink":true,"className":"materialai-woo-bestseller-title","__woocommerceNamespace":"woocommerce/product-query/product-title"} /-->
						<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true} /-->
					</div>
					<!-- /wp:group -->
				</div>
				<!-- /wp:group -->
			<!-- /wp:woocommerce/product-template -->
		</div>
		<!-- /wp:woocommerce/product-collection -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"materialai-woo-widget","layout":{"type":"default"}} -->
	<div class="wp-block-group materialai-woo-widget">
		<!-- wp:heading {"level":3,"className":"materialai-woo-widget-title"} -->
		<h3 class="wp-block-heading materialai-woo-widget-title"><?php esc_html_e( 'Tags', 'material-ai' ); ?></h3>
		<!-- /wp:heading -->
		<!-- wp:tag-cloud {"numberOfTags":12,"taxonomy":"product_tag","className":"materialai-woo-tags"} /-->
	</div>
	<!-- /wp:group -->
