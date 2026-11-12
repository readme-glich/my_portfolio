<?php
/**
 * Title: Sidebar
 * Slug: material-ai/sidebar
 * Categories: material-ai
 *
 * @package Material AI
 */

?>
<!-- wp:column {"width":"32%","className":"aipost-sidebar"} -->
<div class="wp-block-column aipost-sidebar wow fadeInUp" style="flex-basis:32%">

	<!-- wp:group {"className":"aipost-widget has-secondary-background-color has-background","layout":{"type":"constrained"}} -->
	<div class="wp-block-group aipost-widget has-secondary-background-color has-background">
		<!-- wp:heading {"level":4,"className":"aipost-widget__title has-light-color-color has-text-color has-normal-font-size"} -->
		<h4 class="wp-block-heading aipost-widget__title has-light-color-color has-text-color has-normal-font-size"><?php esc_html_e( 'Search here', 'material-ai' ); ?></h4>
		<!-- /wp:heading -->

		<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search…","buttonText":"Search","buttonPosition":"button-inside","className":"aipost-search","style":{"border":{"radius":"8px"}}} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"aipost-widget has-secondary-background-color has-background","layout":{"type":"constrained"}} -->
	<div class="wp-block-group aipost-widget has-secondary-background-color has-background">
		<!-- wp:heading {"level":4,"className":"aipost-widget__title has-light-color-color has-text-color has-normal-font-size"} -->
		<h4 class="wp-block-heading aipost-widget__title has-light-color-color has-text-color has-normal-font-size"><?php esc_html_e( 'Categories', 'material-ai' ); ?></h4>
		<!-- /wp:heading -->

		<!-- wp:categories {"className":"aipost-categories","displayAsDropdown":false,"showPostCounts":false,"showHierarchy":false,"showEmpty":false} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"aipost-widget has-secondary-background-color has-background","layout":{"type":"constrained"}} -->
	<div class="wp-block-group aipost-widget has-secondary-background-color has-background">
		<!-- wp:heading {"level":4,"className":"aipost-widget__title has-light-color-color has-text-color has-normal-font-size"} -->
		<h4 class="wp-block-heading aipost-widget__title has-light-color-color has-text-color has-normal-font-size"><?php esc_html_e( 'Recent Posts', 'material-ai' ); ?></h4>
		<!-- /wp:heading -->

		<!-- wp:latest-posts {"postsToShow":3,"displayPostDate":true,"displayFeaturedImage":true,"featuredImageSizeSlug":"thumbnail","featuredImageAlign":"left","className":"aipost-recent-posts"} /-->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"aipost-widget has-secondary-background-color has-background","layout":{"type":"constrained"}} -->
	<div class="wp-block-group aipost-widget has-secondary-background-color has-background">
		<!-- wp:heading {"level":4,"className":"aipost-widget__title has-light-color-color has-text-color has-normal-font-size"} -->
		<h4 class="wp-block-heading aipost-widget__title has-light-color-color has-text-color has-normal-font-size"><?php esc_html_e( 'Popular Tags', 'material-ai' ); ?></h4>
		<!-- /wp:heading -->

		<!-- wp:tag-cloud {"taxonomy":"post_tag","showTagCounts":false,"className":"aipost-tags"} /-->
	</div>
	<!-- /wp:group -->
	<!-- wp:group {"className":"aipost-widget has-secondary-background-color has-background","layout":{"type":"constrained"}} -->
	<div class="wp-block-group aipost-widget has-secondary-background-color has-background">
		<!-- wp:heading {"level":4,"className":"aipost-widget__title has-light-color-color has-text-color has-normal-font-size"} -->
		<h4 class="wp-block-heading aipost-widget__title has-light-color-color has-text-color has-normal-font-size"><?php esc_html_e( 'Follow Us', 'material-ai' ); ?></h4>
		<!-- /wp:heading -->

		<!-- wp:social-links {"className":"aipost-social is-style-filled-square"} -->
		<ul class="wp-block-social-links aipost-social is-style-filled-square">
			<!-- wp:social-link {"url":"#","service":"facebook"} /-->
			<!-- wp:social-link {"url":"#","service":"twitter"} /-->
			<!-- wp:social-link {"url":"#","service":"instagram"} /-->
			<!-- wp:social-link {"url":"#","service":"linkedin"} /-->
			<!-- wp:social-link {"url":"#","service":"youtube"} /-->
		</ul>
		<!-- /wp:social-links -->
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:column -->