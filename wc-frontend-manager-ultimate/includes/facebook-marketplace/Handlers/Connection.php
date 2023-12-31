<?php
/**
 * Copyright (c) Facebook, Inc. and its affiliates. All Rights Reserved
 *
 * This source code is licensed under the license found in the
 * LICENSE file in the root directory of this source tree.
 *
 * @package FacebookCommerce
 */

namespace WCFMu\Facebook\Handlers;

use SkyVerge\WooCommerce\PluginFramework\v5_10_0\SV_WC_API_Exception;

defined('ABSPATH') or exit;

if (! class_exists('\\SkyVerge\\WooCommerce\\PluginFramework\\v5_10_0\\SV_WC_Plugin_Exception')) {
    return;
}

/**
 * The connection handler.
 *
 * @since 1.0.0
 */
class Connection
{


    /**
 * @var string Facebook client identifier
*/
    const CLIENT_ID = '474166926521348';

    /**
 * @var string Facebook OAuth URL
*/
    const OAUTH_URL = 'https://facebook.com/dialog/oauth';

    /**
 * @var string WooCommerce connection proxy URL
*/
    const PROXY_URL = 'https://connect.woocommerce.com/auth/facebook/';

    /**
 * @var string the action callback for the connection
*/
    const ACTION_CONNECT = 'wcfm_facebook_connect';

    /**
 * @var string the action callback for the disconnection
*/
    const ACTION_DISCONNECT = 'wcfm_facebook_disconnect';

    /**
 * @var string the WordPress option name where the external business ID is stored
*/
    const OPTION_EXTERNAL_BUSINESS_ID = 'wc_facebook_external_business_id';

    /**
 * @var string the business manager ID option name
*/
    const OPTION_BUSINESS_MANAGER_ID = 'wcfm_facebook_business_manager_id';

    /**
 * @var string the ad account ID option name
*/
    const OPTION_AD_ACCOUNT_ID = 'wcfm_facebook_ad_account_id';

    /**
 * @var string the system user ID option name
*/
    const OPTION_SYSTEM_USER_ID = 'wcfm_facebook_system_user_id';

    /**
 * @var string the system user access token option name
*/
    const OPTION_ACCESS_TOKEN = 'wcfm_facebook_access_token';

    /**
 * @var string the merchant access token option name
*/
    const OPTION_MERCHANT_ACCESS_TOKEN = 'wcfm_facebook_merchant_access_token';

    /**
     * @var string|null the generated external merchant settings ID
     */
    private $external_business_id;

    /**
     * @var \WC_Facebookcommerce
     */
    private $plugin;

    private $vendor_id;


    /**
     * Constructs a new Connection.
     *
     * @since 1.0.0
     */
    public function __construct(\WCFMu_Vendor_Facebook_Marketplace $plugin)
    {
        $this->plugin = $plugin;

        add_action('init', [ $this, 'refresh_business_configuration' ]);

        add_action('admin_init', [ $this, 'refresh_installation_data' ]);

        // add_action( 'woocommerce_api_' . self::ACTION_CONNECT, [ $this, 'handle_connect' ] );
        // add_action( 'admin_action_' . self::ACTION_DISCONNECT, [ $this, 'handle_disconnect' ] );

    }//end __construct()


    public function set_vendor_id($vendor_id)
    {
        $this->vendor_id = $vendor_id;

    }//end set_vendor_id()


    /**
     * Refreshes the local business configuration data with the latest from Facebook.
     *
     * @internal
     *
     * @since 1.0.0
     */
    public function refresh_business_configuration()
    {
        // only refresh once an hour
        if (get_transient('wcfm_facebook_business_configuration_refresh')) {
            return;
        }

        // bail if not connected
        if (! $this->is_connected()) {
            return;
        }

        try {
            $response = $this->get_plugin()->get_api($this->vendor_id)->get_business_configuration($this->get_external_business_id());

            // update the messenger settings
            if ($messenger_configuration = $response->get_messenger_configuration()) {
                // store the local "enabled" setting
                update_user_meta($this->vendor_id, $this->get_plugin()->get_integration($this->vendor_id)::SETTING_ENABLE_MESSENGER, wc_bool_to_string($messenger_configuration->is_enabled()));

                if ($default_locale = $messenger_configuration->get_default_locale()) {
                    update_user_meta($this->vendor_id, $this->get_plugin()->get_integration($this->vendor_id)::SETTING_MESSENGER_LOCALE, sanitize_text_field($default_locale));
                }

                // if the site's domain is somehow missing from the allowed domains, re-add it
                if ($messenger_configuration->is_enabled() && ! in_array(home_url('/'), $messenger_configuration->get_domains(), true)) {
                    $messenger_configuration->add_domain(home_url('/'));

                    $this->get_plugin()->get_api($this->vendor_id)->update_messenger_configuration($this->get_external_business_id(), $messenger_configuration);
                }
            }
        } catch (SV_WC_API_Exception $exception) {
            if ($this->get_plugin()->get_integration($this->vendor_id)->is_debug_mode_enabled()) {
                wcfm_fb_log('Could not refresh business configuration. '.$exception->getMessage());
            }
        }//end try

        set_transient('wcfm_facebook_business_configuration_refresh', time(), HOUR_IN_SECONDS);

    }//end refresh_business_configuration()


    /**
     * Refreshes the connected installation data.
     *
     * @since 1.0.0
     */
    public function refresh_installation_data()
    {
        // bail if not connected
        if (! $this->is_connected()) {
            return;
        }

        // only refresh once a day
        if (get_transient('wcfm_facebook_connection_refresh')) {
            return;
        }

        try {
            $this->update_installation_data();
        } catch (SV_WC_API_Exception $exception) {
            if ($this->get_plugin()->get_integration($this->vendor_id)->is_debug_mode_enabled()) {
                wcfm_fb_log('Could not refresh installation data. '.$exception->getMessage());
            }
        }

        set_transient('wcfm_facebook_connection_refresh', time(), DAY_IN_SECONDS);

    }//end refresh_installation_data()


    /**
     * Retrieves and stores the connected installation data.
     *
     * @since 1.0.0
     *
     * @throws SV_WC_API_Exception
     */
    private function update_installation_data()
    {
        $response = $this->get_plugin()->get_api($this->vendor_id)->get_installation_ids($this->get_external_business_id());

        if ($response->get_page_id()) {
            $this->get_plugin()->get_integration($this->vendor_id)->update_facebook_page_id(sanitize_text_field($response->get_page_id()));
        }

        if ($response->get_pixel_id()) {
            $this->get_plugin()->get_integration($this->vendor_id)->update_facebook_pixel_id(sanitize_text_field($response->get_pixel_id()));
        }

        if ($response->get_catalog_id()) {
            $this->get_plugin()->get_integration($this->vendor_id)->update_product_catalog_id(sanitize_text_field($response->get_catalog_id()));
        }

        if ($response->get_business_manager_id()) {
            $this->update_business_manager_id(sanitize_text_field($response->get_business_manager_id()));
        }

        if ($response->get_ad_account_id()) {
            $this->update_ad_account_id(sanitize_text_field($response->get_ad_account_id()));
        }

    }//end update_installation_data()


    /**
     * Processes the returned connection.
     *
     * @internal
     *
     * @since 1.0.0
     */
    public function handle_connect()
    {
        // don't handle anything unless the user can manage WooCommerce settings
        if (! current_user_can('manage_woocommerce')) {
            return;
        }

        try {
            if (empty($_GET['nonce']) || ! wp_verify_nonce($_GET['nonce'], self::ACTION_CONNECT)) {
                throw new SV_WC_API_Exception('Invalid nonce');
            }

            $merchant_access_token = ! empty($_GET['merchant_access_token']) ? sanitize_text_field($_GET['merchant_access_token']) : '';

            if (! $merchant_access_token) {
                throw new SV_WC_API_Exception('Access token is missing');
            }

            $system_user_access_token = ! empty($_GET['system_user_access_token']) ? sanitize_text_field($_GET['system_user_access_token']) : '';

            if (! $system_user_access_token) {
                throw new SV_WC_API_Exception('System User access token is missing');
            }

            $system_user_id = ! empty($_GET['system_user_id']) ? sanitize_text_field($_GET['system_user_id']) : '';

            if (! $system_user_id) {
                throw new SV_WC_API_Exception('System User ID is missing');
            }

            $this->update_access_token($system_user_access_token);
            $this->update_merchant_access_token($merchant_access_token);
            $this->update_system_user_id($system_user_id);
            $this->update_installation_data();

            facebook_for_woocommerce()->get_products_sync_handler()->create_or_update_all_products();

            update_option('wc_facebook_has_connected_fbe_2', 'yes');

            facebook_for_woocommerce()->get_message_handler()->add_message(__('Connection complete! Thanks for using Facebook for WooCommerce.', 'facebook-for-woocommerce'));
        } catch (SV_WC_API_Exception $exception) {
            facebook_for_woocommerce()->log(sprintf('Connection failed: %s', $exception->getMessage()));

            set_transient('wc_facebook_connection_failed', time(), 30);
        }//end try

        wp_safe_redirect(facebook_for_woocommerce()->get_settings_url());
        exit;

    }//end handle_connect()


    /**
     * Disconnects the integration using the Graph API.
     *
     * @internal
     *
     * @since 1.0.0
     */
    public function handle_disconnect()
    {
        check_admin_referer(self::ACTION_DISCONNECT);

        if (! current_user_can('manage_woocommerce')) {
            wp_die(__('You do not have permission to uninstall Facebook Business Extension.', 'facebook-for-woocommerce'));
        }

        try {
            $response = facebook_for_woocommerce()->get_api()->get_user();
            $response = facebook_for_woocommerce()->get_api()->delete_user_permission($response->get_id(), 'manage_business_extension');

            $this->disconnect();

            facebook_for_woocommerce()->get_message_handler()->add_message(__('Uninstall successful', 'facebook-for-woocommerce'));
        } catch (SV_WC_API_Exception $exception) {
            facebook_for_woocommerce()->log(sprintf('Uninstall failed: %s', $exception->getMessage()));

            facebook_for_woocommerce()->get_message_handler()->add_error(__('Uninstall unsuccessful. Please try again.', 'facebook-for-woocommerce'));
        }

        wp_safe_redirect(facebook_for_woocommerce()->get_settings_url());
        exit;

    }//end handle_disconnect()


    /**
     * Disconnects the plugin.
     *
     * Deletes local asset data.
     *
     * @since 1.0.0
     */
    private function disconnect()
    {
        $this->update_access_token('');
        $this->update_merchant_access_token('');
        $this->update_system_user_id('');
        $this->update_business_manager_id('');
        $this->update_ad_account_id('');

        update_option(\WC_Facebookcommerce_Integration::SETTING_FACEBOOK_PAGE_ID, '');
        update_option(\WC_Facebookcommerce_Integration::SETTING_FACEBOOK_PIXEL_ID, '');
        facebook_for_woocommerce()->get_integration()->update_product_catalog_id('');

        delete_transient('wcfm_facebook_business_configuration_refresh');

    }//end disconnect()


    /**
     * Gets the API access token.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_access_token()
    {
        $access_token = get_user_meta($this->vendor_id, self::OPTION_ACCESS_TOKEN, true);

        /*
         * Filters the API access token.
         *
         * @since 1.0.0
         *
         * @param string $access_token access token
         * @param Connection $connection connection handler instance
         */
        return apply_filters('wcfm_facebook_connection_access_token', $access_token, $this);

    }//end get_access_token()


    /**
     * Gets the merchant access token.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_merchant_access_token()
    {
        $access_token = get_user_meta($this->vendor_id, self::OPTION_MERCHANT_ACCESS_TOKEN, true);

        /*
         * Filters the merchant access token.
         *
         * @since 1.0.0
         *
         * @param string $access_token access token
         * @param Connection $connection connection handler instance
         */
        return apply_filters('wcfm_facebook_connection_merchant_access_token', $access_token, $this);

    }//end get_merchant_access_token()


    /**
     * Gets the URL to start the connection flow.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_connect_url()
    {
        return add_query_arg(rawurlencode_deep($this->get_connect_parameters()), self::OAUTH_URL);

    }//end get_connect_url()


    /**
     * Gets the URL to manage the connection.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_manage_url()
    {
        $app_id      = $this->get_client_id();
        $business_id = $this->get_external_business_id();

        return "https://www.facebook.com/facebook_business_extension?app_id={$app_id}&external_business_id={$business_id}";

    }//end get_manage_url()


    /**
     * Gets the URL for disconnecting.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_disconnect_url()
    {
        return wp_nonce_url(
            add_query_arg(
                [
                    'action'     => 'wcfm_ajax_controller',
                    'controller' => 'wcfm-facebook-marketplace-disconnect',
                ],
                admin_url('admin-ajax.php')
            ),
            self::ACTION_DISCONNECT
        );

    }//end get_disconnect_url()


    /**
     * Gets the scopes that will be requested during the connection flow.
     *
     * @since 1.0.0
     *
     * @link https://developers.facebook.com/docs/marketing-api/access/#access_token
     *
     * @return string[]
     */
    public function get_scopes()
    {
        $scopes = [
            'manage_business_extension',
            'catalog_management',
            'business_management',
            'ads_management',
            'ads_read',
        ];

        /*
         * Filters the scopes that will be requested during the connection flow.
         *
         * @since 1.0.0
         *
         * @param string[] $scopes connection scopes
         * @param Connection $connection connection handler instance
         */
        return (array) apply_filters('wcfm_facebook_connection_scopes', $scopes, $this);

    }//end get_scopes()


    /**
     * Gets the stored external business ID.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_external_business_id()
    {
        $value = get_user_meta($this->vendor_id, self::OPTION_EXTERNAL_BUSINESS_ID, true);

        if (! $value) {
            $value = sanitize_title(wcfm_get_vendor_store_name($this->vendor_id)).'-'.uniqid();

            update_user_meta($this->vendor_id, self::OPTION_EXTERNAL_BUSINESS_ID, $value);
        }

        $this->external_business_id = $value;

        /*
         * Filters the external business ID.
         *
         * @since 1.0.0
         *
         * @param string $external_business_id stored external business ID
         * @param Connection $connection connection handler instance
         */
        return (string) apply_filters('wcfm_facebook_external_business_id', $this->external_business_id, $this);

    }//end get_external_business_id()


    /**
     * Gets the site's business name.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_business_name()
    {
        $business_name = html_entity_decode(wcfm_get_vendor_store_name($this->vendor_id), ENT_QUOTES, 'UTF-8');

        /*
         * Filters the shop's business name.
         *
         * This is passed to Facebook when connecting. Defaults to the site name.
         *
         * @since 1.0.0
         *
         * @param string $business_name the shop's business name
         */
        return apply_filters('wcfm_facebook_connection_business_name', $business_name);

    }//end get_business_name()


    /**
     * Gets the business manager ID value.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_business_manager_id()
    {
        return get_user_meta($this->vendor_id, self::OPTION_BUSINESS_MANAGER_ID, true);

    }//end get_business_manager_id()


    /**
     * Gets the ad account ID value.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_ad_account_id()
    {
        return get_user_meta($this->vendor_id, self::OPTION_AD_ACCOUNT_ID, true);

    }//end get_ad_account_id()


    /**
     * Gets the System User ID value.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_system_user_id()
    {
        return get_user_meta($this->vendor_id, self::OPTION_SYSTEM_USER_ID, true);

    }//end get_system_user_id()


    /**
     * Gets the proxy URL.
     *
     * @since 1.0.0
     *
     * @return string URL
     */
    public function get_proxy_url()
    {
        /*
         * Filters the proxy URL.
         *
         * @since 1.0.0
         *
         * @param string $proxy_url the connection proxy URL
         */
        return (string) apply_filters('wcfm_facebook_connection_proxy_url', self::PROXY_URL);

    }//end get_proxy_url()


    /**
     * Gets the full redirect URL where the user will return to after OAuth.
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_redirect_url()
    {
        $redirect_url = add_query_arg(
            [
                'wc-api'               => self::ACTION_CONNECT,
                'external_business_id' => $this->get_external_business_id(),
                'nonce'                => wp_create_nonce(self::ACTION_CONNECT),
                'vendor_id'            => $this->vendor_id,
            ],
            home_url('/')
        );

        /*
         * Filters the redirect URL where the user will return to after OAuth.
         *
         * @since 1.0.0
         *
         * @param string $redirect_url redirect URL
         * @param Connection $connection connection handler instance
         */
        return (string) apply_filters('wcfm_facebook_connection_redirect_url', $redirect_url, $this);

    }//end get_redirect_url()


    /**
     * Gets the full set of connection parameters for starting OAuth.
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_connect_parameters()
    {
        /*
         * Filters the connection parameters.
         *
         * @since 1.0.0
         *
         * @param array $parameters connection parameters
         */
        return apply_filters(
            'wcfm_facebook_connection_parameters',
            [
                'client_id'     => $this->get_client_id(),
                'redirect_uri'  => $this->get_proxy_url(),
                'state'         => $this->get_redirect_url(),
                'display'       => 'page',
                'response_type' => 'code',
                'scope'         => implode(',', $this->get_scopes()),
                'extras'        => json_encode($this->get_connect_parameters_extras()),
            ]
        );

    }//end get_connect_parameters()


    /**
     * Gets connection parameters extras.
     *
     * @see Connection::get_connect_parameters()
     *
     * @since 1.0.0
     *
     * @return array associative array (to be converted to JSON encoded for connection purposes)
     */
    private function get_connect_parameters_extras()
    {
        $parameters = [
            'setup'           => [
                'external_business_id' => $this->get_external_business_id(),
                'timezone'             => $this->get_timezone_string(),
                'currency'             => get_woocommerce_currency(),
                'business_vertical'    => 'ECOMMERCE',
            ],
            'business_config' => [
                'business' => [
                    'name' => $this->get_business_name(),
                ],
            ],
            'repeat'          => false,
        ];

        if ($external_merchant_settings_id = $this->get_plugin()->get_integration($this->vendor_id)->get_external_merchant_settings_id()) {
            $parameters['setup']['merchant_settings_id'] = $external_merchant_settings_id;
        }

        // if messenger was previously enabled
        if ($this->get_plugin()->get_integration($this->vendor_id)->is_messenger_enabled()) {
            $parameters['business_config']['messenger_chat'] = [
                'enabled' => true,
                'domains' => home_url('/'),
            ];
        }

        return $parameters;

    }//end get_connect_parameters_extras()


    /**
     * Gets the configured timezone string using values accepted by Facebook
     *
     * @since 1.0.0
     *
     * @return string
     */
    private function get_timezone_string()
    {
        $timezone = wc_timezone_string();

        // convert +05:30 and +05:00 into Etc/GMT+5 - we ignore the minutes because Facebook does not allow minute offsets
        if (preg_match('/([+-])(\d{2}):\d{2}/', $timezone, $matches)) {
            $hours    = (int) $matches[2];
            $timezone = "Etc/GMT{$matches[1]}{$hours}";
        }

        return $timezone;

    }//end get_timezone_string()


    /**
     * Stores the given ID value.
     *
     * @since 1.0.0
     *
     * @param string $value the business manager ID
     */
    public function update_business_manager_id($value)
    {
        update_user_meta($this->vendor_id, self::OPTION_BUSINESS_MANAGER_ID, $value);

    }//end update_business_manager_id()


    /**
     * Stores the given ID value.
     *
     * @since 1.0.0
     *
     * @param string $value the ad account ID
     */
    public function update_ad_account_id($value)
    {
        update_user_meta($this->vendor_id, self::OPTION_AD_ACCOUNT_ID, $value);

    }//end update_ad_account_id()


    /**
     * Stores the given system user ID.
     *
     * @since 1.0.0
     *
     * @param string $value the ID
     */
    public function update_system_user_id($value)
    {
        update_user_meta($this->vendor_id, self::OPTION_SYSTEM_USER_ID, $value);

    }//end update_system_user_id()


    /**
     * Stores the given token value.
     *
     * @since 1.0.0
     *
     * @param string $value the access token
     */
    public function update_access_token($value)
    {
        update_user_meta($this->vendor_id, self::OPTION_ACCESS_TOKEN, $value);

    }//end update_access_token()


    /**
     * Stores the given merchant access token.
     *
     * @since 1.0.0
     *
     * @param string $value the access token
     */
    public function update_merchant_access_token($value)
    {
        update_user_meta($this->vendor_id, self::OPTION_MERCHANT_ACCESS_TOKEN, $value);

    }//end update_merchant_access_token()


    /**
     * Determines whether the site is connected.
     *
     * A site is connected if there is an access token stored.
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    public function is_connected()
    {
        return (bool) $this->get_access_token();

    }//end is_connected()


    /**
     * Determines whether the site has previously connected to FBE 2.
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    public function has_previously_connected_fbe_2()
    {
        return 'yes' === get_user_meta($this->vendor_id, 'wc_facebook_has_connected_fbe_2', true);

    }//end has_previously_connected_fbe_2()


    /**
     * Determines whether the site has previously connected to FBE 1.x.
     *
     * @since 1.0.0
     *
     * @return boolean
     */
    public function has_previously_connected_fbe_1()
    {
        $integration = $this->get_plugin()->get_integration($this->vendor_id);

        return $integration && $integration->get_external_merchant_settings_id();

    }//end has_previously_connected_fbe_1()


    /**
     * Gets the client ID for connection.
     *
     * @since 1.0.0
     *
     * @return string
     */
    private function get_client_id()
    {
        /*
         * Filters the client ID.
         *
         * @since 1.0.0
         *
         * @param string $client_id the client ID
         */
        return apply_filters('wcfm_facebook_connection_client_id', self::CLIENT_ID);

    }//end get_client_id()


    /**
     * Gets the plugin instance.
     *
     * @since 1.0.0
     *
     * @return \WCFMu_Vendor_Facebook_Marketplace
     */
    public function get_plugin()
    {
        return $this->plugin;

    }//end get_plugin()


}//end class
