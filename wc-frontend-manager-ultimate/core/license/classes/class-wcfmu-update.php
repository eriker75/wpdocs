<?php

if (! defined('ABSPATH')) {
    exit;
    // Exit if accessed directly
}

class WCFMu_API_Manager_Update_API_Check
{

    private $upgrade_url;

    // URL to access the Update API Manager.
    private $plugin_name;

    // same as plugin slug. if a theme use a theme name like 'twentyeleven'
    private $product_id;

    // Software Title
    private $api_key;

    // API License Key
    private $activation_email;

    // License Email
    private $renew_license_url;

    // URL to renew a license
    private $instance;

    // Instance ID (unique to each blog activation)
    private $domain;

    // blog domain name
    private $software_version;

    private $plugin_or_theme;

    // 'theme' or 'plugin'
    private $text_domain;

    // localization for translation
    private $extra;
    // Used to send any extra information.


    /**
     * Constructor.
     *
     * @access public
     * @since  1.0.0
     * @return void
     */
    public function __construct($upgrade_url, $plugin_name, $product_id, $api_key, $activation_email, $renew_license_url, $instance, $domain, $software_version, $plugin_or_theme, $text_domain, $extra='')
    {
        // API data
        $this->upgrade_url = $upgrade_url;
        $this->plugin_name = $plugin_name;
        // same as plugin slug. if a theme use a theme name like 'twentyeleven'
        $this->product_id        = $product_id;
        $this->api_key           = $api_key;
        $this->activation_email  = $activation_email;
        $this->renew_license_url = $renew_license_url;
        $this->instance          = $instance;
        $this->domain            = $domain;
        $this->software_version  = $software_version;
        $this->text_domain       = $text_domain;
        $this->extra             = $extra;

        /*
         * Flag for plugin or theme updates
         *
         * @access public
         * @since  1.0.0
         * @param  string, plugin or theme
         */
        $this->plugin_or_theme = $plugin_or_theme;
        // 'theme' or 'plugin'
        /*
         * The plugin and theme filters should not be active at the same time
         */

        /*
         * More info:
         * function set_site_transient moved from wp-includes/functions.php
         * to wp-includes/option.php in WordPress 3.4
         *
         * set_site_transient() contains the pre_set_site_transient_{$transient} filter
         * {$transient} is either update_plugins or update_themes
         *
         * Transient data for plugins and themes exist in the Options table:
         * _site_transient_update_themes
         * _site_transient_update_plugins
         */

        // uses the flag above to determine if this is a plugin or a theme update request
        if ($this->plugin_or_theme == 'plugin') {
            /*
             * Plugin Updates
             */
            // Check For Plugin Updates
            add_filter('pre_set_site_transient_update_plugins', [ $this, 'update_check' ]);

            // Check For Plugin Information to display on the update details page
            add_filter('plugins_api', [ $this, 'request' ], 10, 3);
        } else if ($this->plugin_or_theme == 'theme') {
            /*
             * Theme Updates
             */
            // Check For Theme Updates
            add_filter('pre_set_site_transient_update_themes', [ $this, 'update_check' ]);

            // Check For Theme Information to display on the update details page
            // add_filter( 'themes_api', array( $this, 'request' ), 10, 3 );
        }//end if

    }//end __construct()


    // Upgrade API URL
    private function create_upgrade_api_url($args)
    {
        $upgrade_url = add_query_arg('wc-api', 'upgrade-api', $this->upgrade_url);

        return $upgrade_url.'&'.http_build_query($args);

    }//end create_upgrade_api_url()


    /**
     * Check for updates against the remote server.
     *
     * @access public
     * @since  1.0.0
     * @param  object $transient
     * @return object $transient
     */
    public function update_check($transient)
    {
        global $sc_helpers;

        if (empty($transient->checked)) {
            return $transient;
        }

        if (! isset($transient->checked[$this->plugin_name])) {
            return $transient;
        }

        $args = [
            'request'          => 'pluginupdatecheck',
            'plugin_name'      => $this->plugin_name,
            'version'          => $transient->checked[$this->plugin_name],
            'product_id'       => $this->product_id,
            'api_key'          => $this->api_key,
            'activation_email' => $this->activation_email,
            'instance'         => $this->instance,
            'domain'           => $this->domain,
            'software_version' => $this->software_version,
            'extra'            => $this->extra,
        ];

        // Check for a plugin update
        $response = $this->plugin_information($args);

        // Displays an admin error message in the WordPress dashboard
        if (isset($response->errors['no_key']) && $response->errors['no_key'] == 'no_key' && isset($response->errors['no_subscription']) && $response->errors['no_subscription'] == 'no_subscription') {
            add_action('admin_notices', [ &$this, 'no_key_error_notice' ]);
            add_action('admin_notices', [ &$this, 'no_subscription_error_notice' ]);
        } else if (isset($response->errors['exp_license']) && $response->errors['exp_license'] == 'exp_license') {
            add_action('admin_notices', [ &$this, 'expired_license_error_notice' ]);
        } else if (isset($response->errors['hold_subscription']) && $response->errors['hold_subscription'] == 'hold_subscription') {
            add_action('admin_notices', [ &$this, 'on_hold_subscription_error_notice' ]);
        } else if (isset($response->errors['cancelled_subscription']) && $response->errors['cancelled_subscription'] == 'cancelled_subscription') {
            add_action('admin_notices', [ &$this, 'cancelled_subscription_error_notice' ]);
        } else if (isset($response->errors['exp_subscription']) && $response->errors['exp_subscription'] == 'exp_subscription') {
            add_action('admin_notices', [ &$this, 'expired_subscription_error_notice' ]);
        } else if (isset($response->errors['suspended_subscription']) && $response->errors['suspended_subscription'] == 'suspended_subscription') {
            add_action('admin_notices', [ &$this, 'suspended_subscription_error_notice' ]);
        } else if (isset($response->errors['pending_subscription']) && $response->errors['pending_subscription'] == 'pending_subscription') {
            add_action('admin_notices', [ &$this, 'pending_subscription_error_notice' ]);
        } else if (isset($response->errors['trash_subscription']) && $response->errors['trash_subscription'] == 'trash_subscription') {
            add_action('admin_notices', [ &$this, 'trash_subscription_error_notice' ]);
        } else if (isset($response->errors['no_subscription']) && $response->errors['no_subscription'] == 'no_subscription') {
            add_action('admin_notices', [ &$this, 'no_subscription_error_notice' ]);
        } else if (isset($response->errors['no_activation']) && $response->errors['no_activation'] == 'no_activation') {
            add_action('admin_notices', [ &$this, 'no_activation_error_notice' ]);
        } else if (isset($response->errors['no_key']) && $response->errors['no_key'] == 'no_key') {
            add_action('admin_notices', [ &$this, 'no_key_error_notice' ]);
        } else if (isset($response->errors['download_revoked']) && $response->errors['download_revoked'] == 'download_revoked') {
            add_action('admin_notices', [ &$this, 'download_revoked_error_notice' ]);
        } else if (isset($response->errors['switched_subscription']) && $response->errors['switched_subscription'] == 'switched_subscription') {
            add_action('admin_notices', [ &$this, 'switched_subscription_error_notice' ]);
        }//end if

        // Set version variables
        if (isset($response) && is_object($response) && $response !== false) {
            // New plugin version from the API
            $new_ver = (string) $response->new_version;
            // Current installed plugin version
            $curr_ver = (string) $transient->checked[$this->plugin_name];
        }

        // If there is a new version, modify the transient to reflect an update is available
        if (isset($new_ver) && isset($curr_ver)) {
            if ($response !== false && version_compare($new_ver, $curr_ver, '>')) {
                if ($this->plugin_or_theme == 'plugin') {
                    $transient->response[$this->plugin_name] = $response;
                } else if ($this->plugin_or_theme == 'theme') {
                    $transient->response[$this->plugin_name] = [
                        'new_version' => $response->new_version,
                        'url'         => $response->url,
                        'package'     => $response->package,
                    ];
                }
            }
        }

        return $transient;

    }//end update_check()


    /**
     * Sends and receives data to and from the server API
     *
     * @access public
     * @since  1.0.0
     * @return object $response
     */
    public function plugin_information($args)
    {
        $target_url = $this->create_upgrade_api_url($args);

        $request = wp_remote_get($target_url, [ 'sslverify' => false ]);

        if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
            return false;
        }

        $response = unserialize(wp_remote_retrieve_body($request));

        /*
         * For debugging errors from the API
         * For errors like: unserialize(): Error at offset 0 of 170 bytes
         * Comment out $response above first
         */
        // $response = wp_remote_retrieve_body( $request );
        // print_r($response); exit;
        if (is_object($response)) {
            return $response;
        } else {
            return false;
        }

    }//end plugin_information()


    /**
     * Generic request helper.
     *
     * @access public
     * @since  1.0.0
     * @param  array $args
     * @return object $response or boolean false
     */
    public function request($false, $action, $args)
    {
        global $sc_helpers;

        // Is this a plugin or a theme?
        if ($this->plugin_or_theme == 'plugin') {
            $version = get_site_transient('update_plugins');
        } else if ($this->plugin_or_theme == 'theme') {
            $version = get_site_transient('update_themes');
        }

        // Check if this plugins API is about this plugin
        if (isset($args->slug)) {
            // Check if this plugins API is about this plugin
            if ($args->slug != $this->plugin_name) {
                return $false;
            }
        } else {
            return $false;
        }

        $args = [
            'request'          => 'plugininformation',
            'plugin_name'      => $this->plugin_name,
            'version'          => $version->checked[$this->plugin_name],
            'product_id'       => $this->product_id,
            'api_key'          => $this->api_key,
            'activation_email' => $this->activation_email,
            'instance'         => $this->instance,
            'domain'           => $this->domain,
            'software_version' => $this->software_version,
            'extra'            => $this->extra,
        ];

        $response = $this->plugin_information($args);

        // Displays an admin error message in the WordPress dashboard
        if (isset($response->errors['no_key']) && $response->errors['no_key'] == 'no_key' && isset($response->errors['no_subscription']) && $response->errors['no_subscription'] == 'no_subscription') {
            add_action('admin_notices', [ &$this, 'no_key_error_notice' ]);
            add_action('admin_notices', [ &$this, 'no_subscription_error_notice' ]);
        } else if (isset($response->errors['exp_license']) && $response->errors['exp_license'] == 'exp_license') {
            add_action('admin_notices', [ &$this, 'expired_license_error_notice' ]);
        } else if (isset($response->errors['hold_subscription']) && $response->errors['hold_subscription'] == 'hold_subscription') {
            add_action('admin_notices', [ &$this, 'on_hold_subscription_error_notice' ]);
        } else if (isset($response->errors['cancelled_subscription']) && $response->errors['cancelled_subscription'] == 'cancelled_subscription') {
            add_action('admin_notices', [ &$this, 'cancelled_subscription_error_notice' ]);
        } else if (isset($response->errors['exp_subscription']) && $response->errors['exp_subscription'] == 'exp_subscription') {
            add_action('admin_notices', [ &$this, 'expired_subscription_error_notice' ]);
        } else if (isset($response->errors['suspended_subscription']) && $response->errors['suspended_subscription'] == 'suspended_subscription') {
            add_action('admin_notices', [ &$this, 'suspended_subscription_error_notice' ]);
        } else if (isset($response->errors['pending_subscription']) && $response->errors['pending_subscription'] == 'pending_subscription') {
            add_action('admin_notices', [ &$this, 'pending_subscription_error_notice' ]);
        } else if (isset($response->errors['trash_subscription']) && $response->errors['trash_subscription'] == 'trash_subscription') {
            add_action('admin_notices', [ &$this, 'trash_subscription_error_notice' ]);
        } else if (isset($response->errors['no_subscription']) && $response->errors['no_subscription'] == 'no_subscription') {
            add_action('admin_notices', [ &$this, 'no_subscription_error_notice' ]);
        } else if (isset($response->errors['no_activation']) && $response->errors['no_activation'] == 'no_activation') {
            add_action('admin_notices', [ &$this, 'no_activation_error_notice' ]);
        } else if (isset($response->errors['no_key']) && $response->errors['no_key'] == 'no_key') {
            add_action('admin_notices', [ &$this, 'no_key_error_notice' ]);
        } else if (isset($response->errors['download_revoked']) && $response->errors['download_revoked'] == 'download_revoked') {
            add_action('admin_notices', [ &$this, 'download_revoked_error_notice' ]);
        } else if (isset($response->errors['switched_subscription']) && $response->errors['switched_subscription'] == 'switched_subscription') {
            add_action('admin_notices', [ &$this, 'switched_subscription_error_notice' ]);
        }//end if

        // If everything is okay return the $response
        if (isset($response) && is_object($response) && $response !== false) {
            return $response;
        }

    }//end request()


    /**
     * Display license expired error notice
     *
     * @param  string $message
     * @return void
     */
    public function expired_license_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('The license key for %1$s has expired. You can reactivate or purchase a license key from your account <a href="%2$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end expired_license_error_notice()


    /**
     * Display subscription on-hold error notice
     *
     * @param  string $message
     * @return void
     */
    public function on_hold_subscription_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('The subscription for %1$s is on-hold. You can reactivate the subscription from your account <a href="%2$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end on_hold_subscription_error_notice()


    /**
     * Display subscription cancelled error notice
     *
     * @param  string $message
     * @return void
     */
    public function cancelled_subscription_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('The subscription for %1$s has been cancelled. You can renew the subscription from your account <a href="%2$s" target="_blank">dashboard</a>. A new license key will be emailed to you after your order has been completed.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end cancelled_subscription_error_notice()


    /**
     * Display subscription expired error notice
     *
     * @param  string $message
     * @return void
     */
    public function expired_subscription_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('The subscription for %1$s has expired. You can reactivate the subscription from your account <a href="%2$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end expired_subscription_error_notice()


    /**
     * Display subscription expired error notice
     *
     * @param  string $message
     * @return void
     */
    public function suspended_subscription_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('The subscription for %1$s has been suspended. You can reactivate the subscription from your account <a href="%2$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end suspended_subscription_error_notice()


    /**
     * Display subscription expired error notice
     *
     * @param  string $message
     * @return void
     */
    public function pending_subscription_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('The subscription for %1$s is still pending. You can check on the status of the subscription from your account <a href="%2$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end pending_subscription_error_notice()


    /**
     * Display subscription expired error notice
     *
     * @param  string $message
     * @return void
     */
    public function trash_subscription_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('The subscription for %1$s has been placed in the trash and will be deleted soon. You can purchase a new subscription from your account <a href="%2$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end trash_subscription_error_notice()


    /**
     * Display subscription expired error notice
     *
     * @param  string $message
     * @return void
     */
    public function no_subscription_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('A subscription for %1$s could not be found. You can purchase a subscription from your account <a href="%2$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end no_subscription_error_notice()


    /**
     * Display missing key error notice
     *
     * @param  string $message
     * @return void
     */
    public function no_key_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) plugin name 3) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('A license key for %1$s could not be found. Maybe you forgot to enter a license key when setting up %2$s, or the key was deactivated in your account. You can reactivate or purchase a license key from your account <a href="%3$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $plugin_name, $this->renew_license_url);

    }//end no_key_error_notice()


    /**
     * Display missing download permission revoked error notice
     *
     * @param  string $message
     * @return void
     */
    public function download_revoked_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('Download permission for %1$s has been revoked possibly due to a license key or subscription expiring. You can reactivate or purchase a license key from your account <a href="%2$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end download_revoked_error_notice()


    /**
     * Display no activation error notice
     *
     * @param  string $message
     * @return void
     */
    public function no_activation_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) plugin name
        echo sprintf('<div id="message" class="error"><p>'.__('%1$s has not been activated. Go to the settings page and enter the license key and license email to activate %2$s.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $plugin_name);

    }//end no_activation_error_notice()


    /**
     * Display switched activation error notice
     *
     * @param  string $message
     * @return void
     */
    public function switched_subscription_error_notice($message)
    {
        $plugins = get_plugins();

        $plugin_name = isset($plugins[$this->plugin_name]) ? $plugins[$this->plugin_name]['Name'] : $this->plugin_name;

        // translators: 1) plugin name 2) renew license url
        echo sprintf('<div id="message" class="error"><p>'.__('You changed the subscription for %1$s, so you will need to enter your new API License Key in the settings page. The License Key should have arrived in your email inbox, if not you can get it by logging into your account <a href="%2$s" target="_blank">dashboard</a>.', 'wc-frontend-manager-ultimate').'</p></div>', $plugin_name, $this->renew_license_url);

    }//end switched_subscription_error_notice()


}//end class

 // End of class
