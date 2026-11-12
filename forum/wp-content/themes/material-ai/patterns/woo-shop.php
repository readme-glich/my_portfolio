<?php
/**
 * Title: WooCommerce Shop
 * Slug: material-ai/woo-shop
 * Categories: material-ai
 * Inserter: no
 *
 * @package Material AI
 */

?>
<!-- wp:group {"tagName":"main","className":"materialai-woo-shop","layout":{"type":"constrained"}} -->
<main class="wp-block-group materialai-woo-shop">

	<!-- wp:woocommerce/store-notices /-->

	<!-- wp:columns {"className":"materialai-woo-layout"} -->
	<div class="wp-block-columns materialai-woo-layout">

		<!-- wp:column {"width":"66.66%","className":"materialai-woo-main"} -->
		<div class="wp-block-column materialai-woo-main" style="flex-basis:66.66%">

			<!-- wp:group {"className":"materialai-woo-toolbar","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
			<div class="wp-block-group materialai-woo-toolbar">
				<!-- wp:woocommerce/product-results-count /-->
				<!-- wp:woocommerce/catalog-sorting /-->
			</div>
			<!-- /wp:group -->

			<!-- wp:woocommerce/product-collection {"queryId":0,"query":{"perPage":9,"pages":0,"offset":0,"postType":"product","order":"asc","orderBy":"title","search":"","exclude":[],"inherit":true,"taxQuery":{},"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[]},"tagName":"div","displayLayout":{"type":"flex","columns":3,"shrinkColumns":true},"collection":"woocommerce/product-collection/product-catalog","className":"materialai-woo-grid"} -->
			<div class="wp-block-woocommerce-product-collection materialai-woo-grid">
				<!-- wp:woocommerce/product-template -->
					<!-- wp:woocommerce/product-image {"showSaleBadge":true,"imageSizing":"single","isDescendentOfQueryLoop":true} /-->
					<!-- wp:post-title {"textAlign":"center","level":3,"isLink":true,"className":"materialai-woo-card-title","__woocommerceNamespace":"woocommerce/product-query/product-title"} /-->
					<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"center"} /-->
					<!-- wp:woocommerce/product-rating {"isDescendentOfQueryLoop":true,"textAlign":"center"} /-->
					<!-- wp:woocommerce/product-button {"textAlign":"center","isDescendentOfQueryLoop":true} /-->
				<!-- /wp:woocommerce/product-template -->

				<!-- wp:query-pagination {"className":"materialai-woo-pagination","layout":{"type":"flex","justifyContent":"center"}} -->
					<!-- wp:query-pagination-previous /-->
					<!-- wp:query-pagination-numbers /-->
					<!-- wp:query-pagination-next /-->
				<!-- /wp:query-pagination -->

				<!-- wp:query-no-results -->
					<!-- wp:paragraph {"align":"center"} -->
					<p class="has-text-align-center"><?php esc_html_e( 'No products were found matching your selection.', 'material-ai' ); ?></p>
					<!-- /wp:paragraph -->
				<!-- /wp:query-no-results -->
			</div>
			<!-- /wp:woocommerce/product-collection -->

		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"33.33%","className":"materialai-woo-sidebar"} -->
		<div class="wp-block-column materialai-woo-sidebar" style="flex-basis:33.33%">

			<!-- wp:template-part {"slug":"sidebar-woocommerce","theme":"material-ai"} /-->

		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</main>
<!-- /wp:group -->
