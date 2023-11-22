<?php

/**
 * WooCommerce API Manager API Key Class
 *
 * @package Update API Manager/Key Handler
 * @since   1.3
 */

if (! defined('ABSPATH')) {
    exit;
    // Exit if accessed directly
}

class WCFMu_Key_Api
{

    // API Key URL
    public function create_software_api_url($args)
    {
        global $WCFMu;

        $api_url = add_query_arg('wc-api', 'am-software-api', $WCFMu->license->upgrade_url);

        return $api_url.'&'.http_build_query($args);

    }//end create_software_api_url()


    public function activate($args)
    {
        global $WCFMu;

        $defaults = [
            'request'          => 'activation',
            'product_id'       => $WCFMu->license->license_product_id,
            'instance'         => $WCFMu->license->license_instance_id,
            'platform'         => $WCFMu->license->license_domain,
            'software_version' => $WCFMu->license->license_software_version,
        ];

        $args = wp_parse_args($defaults, $args);

        $target_url = self::create_software_api_url($args);

        $request = wp_remote_get($target_url, [ 'sslverify' => is_ssl() ]);

        if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
            // Request failed
            return false;
        }

        $response = wp_remote_retrieve_body($request);

        return $response;

    }//end activate()


    public function deactivate($args)
    {
        global $WCFMu;

        $defaults = [
            'request'    => 'deactivation',
            'product_id' => $WCFMu->license->license_product_id,
            'instance'   => $WCFMu->license->license_instance_id,
            'platform'   => $WCFMu->license->license_domain,
        ];

        $args = wp_parse_args($defaults, $args);

        $target_url = self::create_software_api_url($args);

        $request = wp_remote_get($target_url, [ 'sslverify' => is_ssl() ]);

        if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
            // Request failed
            return false;
        }

        $response = wp_remote_retrieve_body($request);

        return $response;

    }//end deactivate()


    /**
     * Checks if the software is activated or deactivated
     *
     * @param  array $args
     * @return array
     */
    public function status($args)
    {
        global $WCFMu;

        $defaults = [
            'request'    => 'status',
            'product_id' => $WCFMu->license->license_product_id,
            'instance'   => $WCFMu->license->license_instance_id,
            'platform'   => $WCFMu->license->license_domain,
        ];

        $args = wp_parse_args($defaults, $args);

        $target_url = self::create_software_api_url($args);

        $request = wp_remote_get($target_url, [ 'sslverify' => is_ssl() ]);

        if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
            // Request failed
            return false;
        }

        $response = wp_remote_retrieve_body($request);

        return $response;

    }//end status()


}//end class

// Class is instantiated as an object by other classes on-demand
