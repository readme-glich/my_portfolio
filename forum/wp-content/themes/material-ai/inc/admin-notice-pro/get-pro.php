<?php

/**
 * Material AI Pro Upgrade Notice
 */
function material_ai_pro_notice()
{

	// Only show on Appearance > Themes.
	$screen = get_current_screen();

	if (!$screen || 'themes' !== $screen->id) {
		return;
	}

	// Do not show if the current user has dismissed the notice.
	if (get_user_meta(get_current_user_id(), 'material_ai_pro_notice_dismissed', true)) {
		return;
	}

	$preview_image = get_stylesheet_directory_uri() . '/screenshot.jpg';
	?>

	<div class="notice material-ai-pro-notice is-dismissible" data-nonce="<?php echo esc_attr(wp_create_nonce('material_ai_dismiss_pro_notice')); ?>">
		<div class="material-ai-pro-notice-content">
			<div class="material-ai-pro-notice-text">
				<h2><?php esc_html_e('Get More with Material AI Pro','material-ai'); ?></h2>
				<p>
					<?php esc_html_e('Material AI is a fully block and pattern based theme. Everything you see on the front end can be changed visually in the Site Editor: colors, typography, spacing, templates and patterns. No extra plugin is required.','material-ai'); ?>
				</p>
				<p>
					<strong><?php esc_html_e('Unlock premium patterns, advanced customization options, and more with the Pro version.','material-ai'); ?></strong>
				</p>
				<a href="https://www.nayrathemes.com/materialai-pro/" class="material-ai-pro-button" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e('Upgrade to Pro','material-ai'	); ?>
				</a>
			</div>
			<div class="material-ai-pro-notice-image">
				<img src="<?php echo esc_url($preview_image); ?>" alt="<?php esc_attr_e(
				   	'Material AI Pro Preview','material-ai'); ?>">
			</div>
		</div>
	</div>
	<?php
}
add_action('admin_notices', 'material_ai_pro_notice');


/**
 * Material AI Pro Notice CSS
 */
function material_ai_pro_notice_css()
{

	$screen = get_current_screen();

	if (!$screen || 'themes' !== $screen->id) {
		return;
	}
	
	wp_enqueue_style('material-ai-get-pro', get_template_directory_uri() . '/inc/admin-notice-pro/get-pro.css', array(), MATERIALAI_THEME_VERSION);
}
add_action('admin_head', 'material_ai_pro_notice_css');


/**
 * Persist dismissal (per user) via AJAX.
 */
function material_ai_dismiss_pro_notice()
{
	check_ajax_referer('material_ai_dismiss_pro_notice', 'nonce');

	if (!current_user_can('edit_theme_options')) {
		wp_send_json_error(null, 403);
	}

	update_user_meta(get_current_user_id(), 'material_ai_pro_notice_dismissed', 1);
	wp_send_json_success();
}
add_action('wp_ajax_material_ai_dismiss_pro_notice', 'material_ai_dismiss_pro_notice');


/**
 * Dismiss button handler.
 */
function material_ai_pro_notice_js()
{
	$screen = get_current_screen();

	if (!$screen || 'themes' !== $screen->id) {
		return;
	}

	if (get_user_meta(get_current_user_id(), 'material_ai_pro_notice_dismissed', true)) {
		return;
	}
	?>
	<script>
	jQuery(function ($) {
		$(document).on('click', '.material-ai-pro-notice .notice-dismiss', function () {
			var $notice = $(this).closest('.material-ai-pro-notice');
			$.post(ajaxurl, {
				action: 'material_ai_dismiss_pro_notice',
				nonce: $notice.data('nonce')
			});
		});
	});
	</script>
	<?php
}
add_action('admin_print_footer_scripts', 'material_ai_pro_notice_js');
