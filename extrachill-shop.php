<?php
/**
 * Plugin Name: Extra Chill Shop
 * Plugin URI: https://extrachill.com
 * Description: WooCommerce integration and e-commerce functionality for the Extra Chill platform. Features cross-domain ad-free license system, performance optimizations, and store customizations.
 * Version: 1.0.0
 * Author: Chris Huber
 * Author URI: https://chubes.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: extrachill-shop
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Requires Plugins: woocommerce
 */

defined( 'ABSPATH' ) || exit;
define( 'EXTRACHILL_SHOP_VERSION', '1.0.0' );
define( 'EXTRACHILL_SHOP_PLUGIN_FILE', __FILE__ );
define( 'EXTRACHILL_SHOP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'EXTRACHILL_SHOP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'EXTRACHILL_SHOP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

class ExtraChillShop {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'plugins_loaded', [ $this, 'init' ] );
        add_action( 'init', [ $this, 'load_textdomain' ] );

        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
    }

    public function init() {
        $this->load_includes();
    }

    private function load_includes() {
        require_once EXTRACHILL_SHOP_PLUGIN_DIR . 'inc/database.php';
        require_once EXTRACHILL_SHOP_PLUGIN_DIR . 'inc/ad-free-license.php';
        require_once EXTRACHILL_SHOP_PLUGIN_DIR . 'inc/breadcrumb-integration.php';

        require_once EXTRACHILL_SHOP_PLUGIN_DIR . 'templates/cart-icon.php';
        require_once EXTRACHILL_SHOP_PLUGIN_DIR . 'templates/product-category-header.php';
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            'extrachill-shop',
            false,
            dirname( EXTRACHILL_SHOP_PLUGIN_BASENAME ) . '/languages'
        );
    }

    public function activate() {
        extrachill_shop_create_ad_free_table();
        update_option( 'extrachill_shop_activated', true );
        flush_rewrite_rules();
    }

    public function deactivate() {
        delete_option( 'extrachill_shop_activated' );
        flush_rewrite_rules();
    }

    public function get_version() {
        return EXTRACHILL_SHOP_VERSION;
    }
}

// Initialize the plugin
function extrachill_shop() {
    return ExtraChillShop::instance();
}

// Start the plugin
extrachill_shop();