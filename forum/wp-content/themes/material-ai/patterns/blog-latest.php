<?php
/**
 * Title: Latest Blog
 * Slug: material-ai/blog-latest
 * Categories: material-ai
 *
 * @package Material AI
 */

?>
<!-- wp:group {"metadata":{"name":"Our Latest Blog"},"align":"full","className":"mai-blog","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"140px","left":"20px","right":"20px"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull mai-blog" style="padding-top:var(--wp--preset--spacing--60);padding-right:20px;padding-bottom:140px;padding-left:20px"><!-- wp:group {"metadata":{"name":"Section heading"},"className":"mai-blog__head","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group mai-blog__head"><!-- wp:paragraph {"className":"mai-eyebrow materialai-heading-default","style":{"border":{"radius":"30px"},"spacing":{"padding":{"top":"10px","bottom":"10px","left":"18px","right":"18px"}},"typography":{"fontWeight":"700","lineHeight":"1","textAlign":"center","fontStyle":"normal"}},"backgroundColor":"primary","textColor":"light-color","fontFamily":"jost"} -->
<p class="has-text-align-center mai-eyebrow materialai-heading-default has-light-color-color has-primary-background-color has-text-color has-background has-jost-font-family" style="border-radius:30px;padding-top:10px;padding-right:18px;padding-bottom:10px;padding-left:18px;font-style:normal;font-weight:700;line-height:1"><?php esc_html_e( 'What We Do', 'material-ai' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)"><!-- wp:heading {"style":{"typography":{"textAlign":"center"}},"textColor":"secondary","fontSize":"x-large","fontFamily":"jost"} -->
<h2 class="wp-block-heading has-text-align-center has-secondary-color has-text-color has-x-large-font-size has-jost-font-family wow fadeInUp"><?php esc_html_e( 'Our Latest', 'material-ai' ); ?> <mark style="background-color:rgba(0, 0, 0, 0)" class="has-inline-color has-primary-color"><?php esc_html_e( 'Blog', 'material-ai' ); ?></mark></h2>
<!-- /wp:heading --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":0,"query":{"perPage":8,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","search":"","exclude":[],"sticky":"","inherit":false},"className":"mai-blog__query","layout":{"type":"default"},"style":{"spacing":{"margin":{"top":"44px"}}}} -->
<div class="wp-block-query mai-blog__query" style="margin-top:44px"><!-- wp:post-template {"className":"mai-blog__list owl-carousel owl-theme","style":{"spacing":{"blockGap":"22px"}},"layout":{"type":"default"}} -->
<!-- wp:group {"metadata":{"name":"Post card"},"className":"mai-post","style":{"border":{"radius":"10px"},"spacing":{"blockGap":"0"}},"backgroundColor":"secondary","textColor":"light-color","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"stretch"}} -->
<div class="wp-block-group mai-post has-light-color-color has-secondary-background-color has-text-color has-background" style="border-radius:10px"><!-- wp:post-featured-image {"isLink":true,"width":"145px","height":"100%","className":"mai-post__media"} /-->

<!-- wp:group {"className":"mai-post__body","style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group mai-post__body"><!-- wp:group {"className":"mai-post__meta","style":{"spacing":{"blockGap":"14px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group mai-post__meta"><!-- wp:post-author-name /-->

<!-- wp:post-date {"format":"d F Y","metadata":{"bindings":{"datetime":{"source":"core/post-data","args":{"field":"date"}}}}} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"level":3,"isLink":true,"className":"mai-post__title"} /-->

<!-- wp:group {"className":"mai-post__actions","style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group mai-post__actions"><!-- wp:read-more {"content":"Read More","className":"mai-post__more"} /-->
<!-- wp:post-comments-count {"className":"mai-post__comments"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center"><?php esc_html_e( 'No posts published yet.', 'material-ai' ); ?></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->