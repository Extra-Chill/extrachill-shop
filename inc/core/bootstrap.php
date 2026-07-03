<?php
/**
 * Procedural bootstrap helpers for the Extra Chill Shop plugin.
 *
 * Kept separate from the main plugin file so that file stays purely
 * object-oriented (singleton class) per WordPress coding standards.
 *
 * @package ExtraChillShop
 */

defined( 'ABSPATH' ) || exit;

/**
 * Retrieve the shared ExtraChillShop singleton instance.
 *
 * @return ExtraChillShop
 */
function extrachill_shop() {
	return ExtraChillShop::instance();
}

/**
 * Render homepage content for shop.extrachill.com.
 *
 * Hooked via extrachill_homepage_content action.
 */
function extrachill_shop_render_homepage() {
	include EXTRACHILL_SHOP_PLUGIN_DIR . 'inc/templates/shop-homepage.php';
}
add_action( 'extrachill_homepage_content', 'extrachill_shop_render_homepage', 10 );
