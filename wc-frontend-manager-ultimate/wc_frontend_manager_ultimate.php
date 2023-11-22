<?php
/**
 * Plugin Name: WCFM - WooCommerce Frontend Manager - Ultimate
 * Plugin URI: https://wclovers.com
 * Description: Now manage your WooCommerce Store from your Store Front with more Powers. Easily and Peacefully.
 * Author: WC Lovers
 * Version: 6.7.2
 * Author URI: https://wclovers.com
 *
 * Text Domain: wc-frontend-manager-ultimate
 * Domain Path: /lang/
 *
 */

if (! defined('ABSPATH')) {
    exit;
    // Exit if accessed directly
}

if (! class_exists('WCFMu_Dependencies')) {
    include_once 'helpers/class-wcfmu-dependencies.php';
}

require_once 'helpers/wcfmu-core-functions.php';
require_once 'wc_frontend_manager_ultimate_config.php';

if (! defined('WCFMu_TOKEN')) {
    exit;
}

if (! defined('WCFMu_TEXT_DOMAIN')) {
    exit;
}

if (! WCFMu_Dependencies::woocommerce_plugin_active_check()) {
    add_action('admin_notices', 'wcfmu_woocommerce_inactive_notice');
} else {
    if (! WCFMu_Dependencies::wcfm_plugin_active_check()) {
        add_action('admin_notices', 'wcfmu_wcfm_inactive_notice');
    } else {
        if (! class_exists('WCFMu')) {
            include_once 'core/class-wcfmu.php';
            global $WCFMu;
            $WCFMu            = new WCFMu(__FILE__);
            $GLOBALS['WCFMu'] = $WCFMu;

            // Activation Hooks
            register_activation_hook(__FILE__, [ 'WCFMu', 'activate_wcfm' ]);
            register_activation_hook(__FILE__, 'flush_rewrite_rules');

            // Deactivation Hooks
            register_deactivation_hook(__FILE__, [ 'WCFMu', 'deactivate_wcfm' ]);
        }
    }
}//end if

add_action( 'in_plugin_update_message-wc-frontend-manager-ultimate/wc_frontend_manager_ultimate.php', function ( $plugin_data, $response ) {
    // Bail if the update notice is not relevant (new version is not yet 6.7.0 or we're already on 6.7.0)
    if ( version_compare( '6.7.0', $plugin_data['new_version'], '>' ) || version_compare( '6.7.0', $plugin_data['Version'], '<=' ) ) {
        return;
    }

    $update_notice = '<p class="wc_plugin_upgrade_notice">';
    $update_notice .= '<strong>Heads up!</strong>  Version 6.7.0 is a major update to the <strong>WCFM - WooCommerce Frontend Manager - Ultimate</strong> plugin. Before updating, please create a backup, update all WCFM related plugins, and test all plugins and custom code with version 6.7.0 on a staging site.';
    $update_notice .= '</p><p class="dummy" style="display:none">';

    echo wp_kses_post( $update_notice );
}, 10, 2 );