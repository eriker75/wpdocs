<?php

/**
 * WCFM plugin core
 *
 * Store Branch core
 *
 * @author  WC Lovers
 * @package wcfmu/core
 * @version 1.0.0
 * @since 6.6.7
 */

class WCFMu_MultiStore
{
    private $branch_logistics = [];
    public function __construct()
    {
        add_action('wcfm_vendor_settings_after_location', [&$this, 'wcfmu_load_view_multi_store']);
        add_action( 'end_wcfm_vendors_manage_form', [&$this, 'wcfmu_load_view_multi_store'], 11 );
			
        // load script
        add_action('after_wcfm_load_scripts', [&$this, 'wcfmu_multi_store_load_scripts']);

        // load style
        add_action('after_wcfm_load_styles', [&$this, 'wcfmu_multi_store_load_styles']);

        add_action('wp_ajax_wcfmu_store_branch_html', [&$this, 'wcfmu_store_branch_html']);

        add_action('wp_ajax_wcfmu_store_submit_branch', [&$this, 'wcfmu_store_submit_branch']);

        add_action('wp_ajax_wcfmu_store_delete_branch', [&$this, 'wcfmu_store_delete_branch']);

        add_action('wp_ajax_wcfmu_mark_branch_as_main', [&$this, 'wcfmu_mark_branch_as_main']);
        
        add_action('wp_ajax_wcfmu_toggle_branch_shipping', [&$this, 'wcfmu_toggle_branch_shipping']);
        
        add_action('wp_ajax_wcfmu_toggle_branch_pickup', [&$this, 'wcfmu_toggle_branch_pickup']);

        add_filter( 'wcfmmp_vendor_list_exclude_search_keys', [&$this, 'wcfmu_exclude_address_search_keys'] );
        add_filter( 'wcfmmp_vendor_list_args', [&$this, 'wcfmu_set_address_global_vars'], 10, 2 );
        //modify Radius Search User Query to support branches
        add_action( 'pre_user_query', array( &$this, 'wcfmu_pre_user_radius_query' ), 51 );
        //modify user vendor distance query to support branches
        add_filter( 'wcfmmp_user_vendor_distance_query', array( &$this, 'wcfmu_user_vendor_closest_branch_distance_query' ) );
        //Modify stores map marker array to include all valid branches
        add_filter('wcfmmp_include_all_valid_branches_for_map_marker', array(&$this, 'fetch_all_queried_branches'));
		add_filter( 'wcfmmp_store_vendor_data', [&$this, 'wcfmu_update_vendor_address_data'], 10 , 3 );
        //sync between profile settings address and main branch - backward compatibility
        add_action( 'wcfmu_main_branch_updated', [&$this, 'wcfmu_update_profile_address_settings'], 10, 2 );
        
        //show shipping and pickup status for the branch
        add_filter( 'wcfmmp_map_additional_store_info', [&$this, 'wcfmu_add_branch_logistics_data'], 10, 3 );
        // closest branch that offers store pickup
        add_filter( 'wcfmmp_local_pickup_shipping_option_label', [&$this, 'wcfmu_return_closest_pickup_address'], 10, 2 );

        add_action( 'woocommerce_checkout_update_order_meta', array( &$this, 'wcfmmp_checkout_vendor_branch_address_save' ), 51 );
        add_action( 'woocommerce_admin_order_items_after_shipping', array( &$this, 'wcfmmp_show_branch_address_on_order_details_page' ) );

    } //end __construct()

    /**
     * Loads the Store Branch view
     *
     * @param integer $user_id
     *
     * @return string
     */
    public function wcfmu_load_view_multi_store($user_id)
    {
        global $WCFMu;
        $WCFMu->template->get_template(
            'settings/wcfmu-view-multi-store.php',
            [
                'user_id' => $user_id
            ]
        );
        if(current_action()==='end_wcfm_vendors_manage_form') {
            echo '<br/>';
        }
    } //end wcfmu_load_view_multi_store()

    /**
     * load scripts
     */
    public function wcfmu_multi_store_load_scripts($end_point)
    {
        global $WCFMu;

        if (in_array($end_point, ['wcfm-settings', 'wcfm-vendors-manage', 'wcfm-vendors-new'])) {
            wp_register_script(
                'wcfmu-multi-store-settings-script',
                $WCFMu->library->js_lib_url . 'settings/wcfmu-script-multi-store-settings.js',
                ['jquery'],
                $WCFMu->version,
                true
            );

            wp_enqueue_script('wcfmu-multi-store-settings-script');

            $is_allowed_shipping = false;
            $is_allowed_pickup = false;
            if (apply_filters('wcfm_is_allow_store_shipping', true)) {
                $wcfm_shipping_options = get_option( 'wcfm_shipping_options', array() );
                $wcfmmp_store_shipping_enabled = isset( $wcfm_shipping_options['enable_store_shipping'] ) ? $wcfm_shipping_options['enable_store_shipping'] : 'yes';
                if( $wcfmmp_store_shipping_enabled == 'yes' ) {
                    $is_allowed_shipping = apply_filters('wcfm_is_allow_individual_branch_shipping', true);
                    $is_allowed_pickup = apply_filters('wcfm_is_allow_individual_branch_pickup', true);
                }
            }

            wp_localize_script('wcfmu-multi-store-settings-script', 'wcfmu_mb', [
                'i18n' => [
                    'no_branch'                  => __( 'No branch found.', 'wc-frontend-manager-ultimate' ),
                    'confirm_delete'             => __( "Are you sure you want to delete this 'Branch'? This action can not be undone.", "wc-frontend-manager-ultimate" ),
                    'confirm_main_branch_delete' => __( "You are about to delete the 'Main Branch'. Do you want to continue? This action can not be undone.", "wc-frontend-manager-ultimate" ),
                    'is_main_branch'             => __( "It's already your main branch", 'wc-frontend-manager-ultimate' ),
                    'switch_main_branch'         => __( "You are about to change your main branch. Are you sure?", "wc-frontend-manager-ultimate" ),
                    'mark_main_hint'             => __( 'Mark this as main branch', "wc-frontend-manager-ultimate" ),
                    'toggle_shipping'            => __( 'Are you sure you want to change the shipping settings for this branch?', "wc-frontend-manager-ultimate" ),
                    'shipping_hint'              => __( 'branch offers shipping', "wc-frontend-manager-ultimate" ),
                    'toggle_pickup'              => __( 'Are you sure you want to change the pickup settings for this branch?', "wc-frontend-manager-ultimate" ),
                    'pickup_hint'                => __( 'branch offers pickup', "wc-frontend-manager-ultimate" ),
                    'name_placeholder'           => __( '[BRANCH NAME]', "wc-frontend-manager-ultimate" ),
                    'edit'                       => __( 'Edit', "wc-frontend-manager-ultimate" ),
                    'delete'                     => __( 'Delete', "wc-frontend-manager-ultimate" ),
                    'update'                     => __( 'Update branch', "wc-frontend-manager-ultimate" ),
                    'state_mandatory'            => __( 'State/County: This field is required.', "wc-frontend-manager-ultimate" ),
                    'autocomplete_failed'        => __( 'Autocomplete returned place contains no geometry', "wc-frontend-manager-ultimate" ),
                ],
                'is_allowed_shipping'   => $is_allowed_shipping,
                'is_allowed_pickup'     => $is_allowed_pickup,
            ]);
        }
    } //end wcfmu_multi_store_load_scripts()

    /**
     * load styles
     */
    public function wcfmu_multi_store_load_styles($end_point)
    {
        global $WCFMu;

        if (in_array($end_point, ['wcfm-settings', 'wcfm-vendors-manage', 'wcfm-vendors-new'])) {
            wp_register_style(
                'wcfmu-multi-store-settings-style',
                $WCFMu->library->css_lib_url . 'settings/wcfmu-style-multi-store-settings.css',
                [],
                $WCFMu->version,
            );

            wp_enqueue_style('wcfmu-multi-store-settings-style');
        }
    } //end wcfmu_multi_store_load_styles()

    public function wcfmu_store_branch_html()
    {
        global $WCFMu;

        if (!check_ajax_referer('wcfm_ajax_nonce', 'wcfm_ajax_nonce', false)) {
            wp_send_json_error(esc_html__('Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager'));
        }

        ob_start();
        $WCFMu->template->get_template(
            'settings/wcfmu-view-multi-store-template.php',
        );
        $output = ob_get_clean();
        wp_send_json_success($output);
    }

    /**
     *  Updates/Adds a store branch
     */
    public function wcfmu_store_submit_branch()
    {
        global $wpdb;

        if (!check_ajax_referer('wcfm_ajax_nonce', 'wcfm_ajax_nonce', false)) {
            wp_send_json_error(esc_html__('Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager'));
        }
        $branch_data = $_POST['data'] ?? array();
        $vendor_id = 0;
        if (wcfm_is_vendor()) {
            $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        } elseif (!empty($branch_data['store_id'])) {
            $vendor_id = absint($branch_data['store_id']); // for admin
        }
        if (!$vendor_id) {
            wp_send_json_error(esc_html__('No vendor found.', 'wc-frontend-manager-ultimate'));
        }
        $branch_data = array_map('wc_clean', $branch_data);
        $branch_id   = $branch_data['branch_id'] ?? '';
        $name        = $branch_data['branch_name'] ?? '';
        $street_1    = $branch_data['branch_street_1'] ?? '';
        $street_2    = $branch_data['branch_street_2'] ?? '';
        $city        = $branch_data['branch_city'] ?? '';
        $zip         = $branch_data['branch_zip'] ?? '';
        $country     = $branch_data['branch_country'] ?? '';
        $state       = $branch_data['branch_state'] ?? '';
        $map_address = $branch_data['branch_find_address'] ?? '';
        $store_lat   = $branch_data['branch_store_lat'] ?? '';
        $store_lng   = $branch_data['branch_store_lng'] ?? '';

        $table = "{$wpdb->prefix}wcfm_store_locations";
        $branch_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$table} WHERE store_id = %d", $vendor_id));
        $data = [
            'store_id'      => $vendor_id,
            'name'          => $name,
            'latitude'      => $store_lat,
            'longitude'     => $store_lng,
            'map_address'   => $map_address,
            'address'       => $street_1,
            'address2'      => $street_2,
            'city'          => $city,
            'postal_code'   => $zip,
            'state'         => $state,
            'country'       => $country
        ];
        $format = ['%d', '%s', '%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s'];

        if ($branch_id) {
            $branch = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wcfm_store_locations WHERE ID = %d AND store_id = %d", $branch_id, $vendor_id), ARRAY_A);

            if (!$branch) {
                wp_send_json_error(esc_html__('Invalid branch ID.', 'wc-frontend-manager-ultimate'));
            }

            $where = ['ID' => $branch_id];
            $where_format = ['%d'];

            $is_successful = $wpdb->update($table, $data, $where, $format, $where_format);

            $msg = esc_html__('Branch updated Successfully', 'wc-frontend-manager-ultimate');

            do_action('wcfmu_multi_store_branch_updated', $branch_id, $vendor_id, $data);
        } else {
            $is_successful = $wpdb->insert($table, $data, $format);
            $branch_id = $wpdb->insert_id;

            $msg = esc_html__('Branch added successfully.', 'wc-frontend-manager-ultimate');

            do_action('wcfmu_multi_store_branch_created', $branch_id, $vendor_id, $data);
        }

        if ($is_successful===false) {
            wp_send_json_error(esc_html__('Error occured! Branch data not saved.', 'wc-frontend-manager-ultimate'));
        } else {
            if (!$branch_count) {
                $wpdb->insert(
                    "{$wpdb->prefix}wcfm_store_locations_meta",
                    array(
                        'branch_id' => $branch_id,
                        'store_id' => $vendor_id,
                        'meta_key' => 'is_main_branch',
                        'meta_value' => 1,
                    ),
                    array('%d', '%d', '%s', '%s'),
                );
            }
            $main_branch = $wpdb->get_var($wpdb->prepare("SELECT branch_id FROM {$wpdb->prefix}wcfm_store_locations_meta WHERE store_id = %d AND meta_key = %s AND meta_value = %d", $vendor_id, 'is_main_branch', 1));
            if($main_branch && $main_branch == $branch_id) {
                //trigger address & location sync for backward compatibility
                // $data contains the posted data
                do_action( 'wcfmu_main_branch_updated', array_merge(['ID' => $branch_id], $data), $vendor_id );
            }

            if ( !metadata_exists( 'user', $vendor_id, 'store_hv_multiloc' ) ) {
                update_user_meta( $vendor_id, 'store_hv_multiloc', 1 );
            }
        }
        $data = array_map('stripslashes_deep', $data);
        wp_send_json_success([
            'branch' => array_merge( ['ID' => $branch_id ], $data ),
            'branch_address' => $this->formatted_store_address($data),
            'msg' => $msg,
        ]);
    }

    /**
     *  Deletes a store branch
     */
    public function wcfmu_store_delete_branch()
    {
        global $wpdb;

        if (!check_ajax_referer('wcfm_ajax_nonce', 'wcfm_ajax_nonce', false)) {
            wp_send_json_error(esc_html__('Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager'));
        }
        $data = $_POST['data'] ?? array();
        $vendor_id = 0;
        if (wcfm_is_vendor()) {
            $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        } elseif (!empty($data['store_id'])) {
            $vendor_id = absint($data['store_id']); // for admin
        }
        if (!$vendor_id) {
            wp_send_json_error(esc_html__('No vendor found.', 'wc-frontend-manager-ultimate'));
        }

        $table = "{$wpdb->prefix}wcfm_store_locations";

        $branch = null;
        if (isset($data['branch_id'])) {
            $branch_id = absint($data['branch_id']);
            $branch = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE ID = %d AND store_id = %d", $branch_id, $vendor_id));
        }
        if (!$branch) {
            wp_send_json_error(esc_html__('Branch not found.', 'wc-frontend-manager-ultimate'));
        }

        $where = ['ID' => $branch_id];
        $where_format = ['%d'];

        $deleted = $wpdb->delete($table, $where, $where_format);

        if ($deleted!==false) {
            $wpdb->delete("{$wpdb->prefix}wcfm_store_locations_meta", array('branch_id' => $branch_id));
            $main_branch = $wpdb->get_var($wpdb->prepare("SELECT branch_id FROM {$wpdb->prefix}wcfm_store_locations_meta WHERE store_id = %d AND meta_key = %s AND meta_value = %d", $vendor_id, 'is_main_branch', 1));
            $data = [ 'main_branch' => $main_branch ];
            $msg = __('Branch deleted successfully.', 'wc-frontend-manager-ultimate');
            if (!$main_branch) {
                $msg = __('Main branch deleted successfully.', 'wc-frontend-manager-ultimate');
                $first_branch = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wcfm_store_locations WHERE store_id = %d LIMIT 1", $vendor_id), ARRAY_A);   
                if ($first_branch) {
                    $data['main_branch'] = $first_branch['ID'];
                    $wpdb->insert(
                        "{$wpdb->prefix}wcfm_store_locations_meta",
                        array(
                            'branch_id' => $first_branch['ID'],
                            'store_id' => $vendor_id,
                            'meta_key' => 'is_main_branch',
                            'meta_value' => 1,
                        ),
                        array('%d', '%d', '%s', '%s'),
                    );
                    do_action( 'wcfmu_main_branch_updated', $first_branch, $vendor_id );
                    $msg .= " " . __('First branch promoted.', 'wc-frontend-manager-ultimate');
                } else { // this vendor has no branch
                    $shop_info = get_user_meta( $vendor_id, 'wcfmmp_profile_settings', true );
                    $shop_info['address'] = [];
                    $shop_info['geolocation'] = [];
                    $shop_info['find_address'] = '';
                    $shop_info['store_location'] = '';
                    $shop_info['store_lat'] = 0;
                    $shop_info['store_lng'] = 0;
                    update_user_meta( $vendor_id, 'wcfmmp_profile_settings', $shop_info );
                    update_user_meta( $vendor_id, '_wcfm_store_lat', '' );
                    update_user_meta( $vendor_id, '_wcfm_store_lng', '' );
                }
            }
            wp_send_json_success([
                'branch' => $data,
                'msg' => $msg,
            ]);
        } else {
            wp_send_json_error(esc_html__('Can not delete the branch. Try again.', 'wc-frontend-manager-ultimate'));
        }
    }

    /**
     *  Mark this branch as the main store branch
     */
    public function wcfmu_mark_branch_as_main() {
        global $wpdb;

        if (!check_ajax_referer('wcfm_ajax_nonce', 'wcfm_ajax_nonce', false)) {
            wp_send_json_error(esc_html__('Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager'));
        }
        $data = $_POST['data'] ?? array();
        $vendor_id = 0;
        if (wcfm_is_vendor()) {
            $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        } elseif (!empty($data['store_id'])) {
            $vendor_id = absint($data['store_id']); // for admin
        }
        if (!$vendor_id) {
            wp_send_json_error(esc_html__('No vendor found.', 'wc-frontend-manager-ultimate'));
        }

        $branch = null;
        if (isset($data['branch_id'])) {
            $branch_id = absint($data['branch_id']);
            $branch = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wcfm_store_locations WHERE ID = %d AND store_id = %d", $branch_id, $vendor_id), ARRAY_A);
        }

        if (!$branch) {
            wp_send_json_error(esc_html__('Branch not found.', 'wc-frontend-manager-ultimate'));
        }

        $main_branch = $wpdb->get_row($wpdb->prepare("SELECT ID, branch_id FROM {$wpdb->prefix}wcfm_store_locations_meta WHERE store_id = %d AND meta_key = %s AND meta_value = %s", $vendor_id, 'is_main_branch', 1));

        if (!empty($main_branch) && $main_branch->branch_id != $branch_id) {
            $is_successful = $wpdb->update(
                "{$wpdb->prefix}wcfm_store_locations_meta",
                array(
                    'branch_id' => $branch_id,
                ),
                array(
                    'ID' => $main_branch->ID,
                ),
                array('%d'),
                array('%d'),
            );
        } elseif (empty($main_branch)) {
            $is_successful = $wpdb->insert(
                "{$wpdb->prefix}wcfm_store_locations_meta",
                array(
                    'branch_id' => $branch_id,
                    'store_id' => $vendor_id,
                    'meta_key' => 'is_main_branch',
                    'meta_value' => 1,
                ),
                array('%d', '%d', '%s', '%s'),
            );
        }
        if ($is_successful===false) {
            wp_send_json_error(esc_html__('Error occured! Couldn\'t update main branch.', 'wc-frontend-manager-ultimate'));
        }
        do_action( 'wcfmu_main_branch_updated', $branch, $vendor_id );
        wp_send_json_success(esc_html__('Main branch updated successfully.', 'wc-frontend-manager-ultimate'));
    }

    /**
     *  Toggle branch's product shipment status
     */
    public function wcfmu_toggle_branch_shipping() {
        global $wpdb;

        if (!check_ajax_referer('wcfm_ajax_nonce', 'wcfm_ajax_nonce', false)) {
            wp_send_json_error(esc_html__('Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager'));
        }
        $data = $_POST['data'] ?? array();
        $vendor_id = 0;
        if (wcfm_is_vendor()) {
            $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        } elseif (!empty($data['store_id'])) {
            $vendor_id = absint($data['store_id']); // for admin
        }
        if (!$vendor_id) {
            wp_send_json_error(esc_html__('No vendor found.', 'wc-frontend-manager-ultimate'));
        }

        $branch = null;
        $data = array_map('wc_clean', $data);
        if (isset($data['branch_id'])) {
            $branch_id = absint($data['branch_id']);
            $branch = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wcfm_store_locations WHERE ID = %d AND store_id = %d", $branch_id, $vendor_id), ARRAY_A);
        }

        if (!$branch) {
            wp_send_json_error(esc_html__('Branch not found.', 'wc-frontend-manager-ultimate'));
        }
        $query = $wpdb->prepare("SELECT ID FROM {$wpdb->prefix}wcfm_store_locations_meta WHERE branch_id = %d AND store_id = %d AND meta_key = %s", $branch_id, $vendor_id, 'offers_shipping');
        $meta_id = $wpdb->get_var($query);
        if($meta_id) {
            $is_successful = $wpdb->update(
                "{$wpdb->prefix}wcfm_store_locations_meta",
                array(
                    'meta_value' => $data['can_ship'],
                ),
                array(
                    'ID' => $meta_id,
                ),
                array('%s'),
                array('%d')
            );
        } else {
            $is_successful = $wpdb->insert(
                "{$wpdb->prefix}wcfm_store_locations_meta",
                array(
                    'branch_id' => $branch_id,
                    'store_id' => $vendor_id,
                    'meta_key' => 'offers_shipping',
                    'meta_value' => $data['can_ship'],
                ),
                array('%d', '%d', '%s', '%s'),
            );
        }
        if ($is_successful === false) {
            wp_send_json_error(esc_html__('Error occured! Couldn\'t update shipping.', 'wc-frontend-manager-ultimate'));
        }
        do_action( 'wcfmu_branch_shipping_pref_updated', $branch, $vendor_id );
        wp_send_json_success( esc_html__('Shipping preference updated successfully.', 'wc-frontend-manager-ultimate') );        
    }

    /**
     *  Toggle branch's product shipment status
     */
    public function wcfmu_toggle_branch_pickup() {
        global $wpdb;

        if (!check_ajax_referer('wcfm_ajax_nonce', 'wcfm_ajax_nonce', false)) {
            wp_send_json_error(esc_html__('Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager'));
        }
        $data = $_POST['data'] ?? array();
        $vendor_id = 0;
        if (wcfm_is_vendor()) {
            $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        } elseif (!empty($data['store_id'])) {
            $vendor_id = absint($data['store_id']); // for admin
        }
        if (!$vendor_id) {
            wp_send_json_error(esc_html__('No vendor found.', 'wc-frontend-manager-ultimate'));
        }

        $branch = null;
        $data = array_map('wc_clean', $data);
        if (isset($data['branch_id'])) {
            $branch_id = absint($data['branch_id']);
            $branch = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wcfm_store_locations WHERE ID = %d AND store_id = %d", $branch_id, $vendor_id), ARRAY_A);
        }

        if (!$branch) {
            wp_send_json_error(esc_html__('Branch not found.', 'wc-frontend-manager-ultimate'));
        }
        $query = $wpdb->prepare("SELECT ID FROM {$wpdb->prefix}wcfm_store_locations_meta WHERE branch_id = %d AND store_id = %d AND meta_key = %s", $branch_id, $vendor_id, 'offers_pickup');
        $meta_id = $wpdb->get_var($query);
        if($meta_id) {
            $is_successful = $wpdb->update(
                "{$wpdb->prefix}wcfm_store_locations_meta",
                array(
                    'meta_value' => $data['can_pickup'],
                ),
                array(
                    'ID' => $meta_id,
                ),
                array('%s'),
                array('%d')
            );
        } else {
            $is_successful = $wpdb->insert(
                "{$wpdb->prefix}wcfm_store_locations_meta",
                array(
                    'branch_id' => $branch_id,
                    'store_id' => $vendor_id,
                    'meta_key' => 'offers_pickup',
                    'meta_value' => $data['can_pickup'],
                ),
                array('%d', '%d', '%s', '%s'),
            );
        }
        if ($is_successful === false) {
            wp_send_json_error(esc_html__('Error occured! Couldn\'t update pickup.', 'wc-frontend-manager-ultimate'));
        }
        do_action( 'wcfmu_branch_pickup_pref_updated', $branch, $vendor_id );
        wp_send_json_success( esc_html__('Pickup preference updated successfully.', 'wc-frontend-manager-ultimate') );        
    }

    /**
     * Array to String represtation of Address
     *
     * @param array $location
     *
     * @return string
     */
    public function formatted_store_address($location = array())
    {
        $location = array_map('stripslashes_deep', $location);
        $addr_1  = $location['address'] ?? '';
        $addr_2  = $location['address2'] ?? '';
        $city    = $location['city'] ?? '';
        $zip     = $location['postal_code'] ?? '';
        $country = $location['country'] ?? '';
        $state   = $location['state'] ?? '';

        // Country -> States
        $country_obj   = new WC_Countries();
        $countries     = $country_obj->countries;
        $states        = $country_obj->states;
        $country_name  = '';
        $state_name    = '';
        if ($country) $country_name = $country;
        if ($state) $state_name = $state;
        if ($country && isset($countries[$country])) {
            $country_name = $countries[$country];
        }
        if ($state && isset($states[$country]) && is_array($states[$country])) {
            $state_name = isset($states[$country][$state]) ? $states[$country][$state] : '';
        }
        $store_address = '';
        if ($addr_1) $store_address .= $addr_1 . ", ";
        if ($addr_2) $store_address .= $addr_2 . ", ";
        if ($city) $store_address .= $city . ", ";
        if ($state_name) $store_address .= $state_name . ", ";
        if ($country_name) $store_address .= " " . $country_name;
        if ($zip) $store_address .= " - " . $zip;

        return str_replace('"', '&quot;', $store_address);
    } // end formatted_store_address()

    public function wcfmu_exclude_address_search_keys ($exclude_search_keys) {
        if (apply_filters('wcfm_is_pref_multi_store', true)) {
            return array_merge($exclude_search_keys, ['wcfmmp_store_country', 'wcfmmp_store_state', 'wcfmmp_store_city', 'wcfmmp_store_zip']);
        }
        return $exclude_search_keys;
    }

    public function wcfmu_set_address_global_vars ($args, $search_data) {
        global $user_country, $user_state, $user_city, $user_postcode;
        if (!empty($search_data) && apply_filters('wcfm_is_pref_multi_store', true)) {
            $user_country = $search_data['wcfmmp_store_country'] ?? '';
            $user_state = $search_data['wcfmmp_store_state'] ?? '';
            $user_city = $search_data['wcfmmp_store_city'] ?? '';
            $user_postcode = $search_data['wcfmmp_store_zip'] ?? '';
        }
        return $args;
    }

    public function wcfmu_pre_user_radius_query($store_query) {
		global $WCFMmp, $wpdb, $wcfmmp_radius_lat, $wcfmmp_radius_lng, $wcfmmp_radius_range;
        if(apply_filters('wcfm_is_pref_multi_store', true)) {
            if ( $wcfmmp_radius_lat && $wcfmmp_radius_lng ) {
                $store_query->query_fields .= ',branch.ID as branch_id, branch.latitude, branch.longitude, branch.address, branch.address2, branch.city, branch.postal_code, branch.state, branch.country';
        
                $radius_unit   = isset( $WCFMmp->wcfmmp_marketplace_options['radius_unit'] ) ? $WCFMmp->wcfmmp_marketplace_options['radius_unit'] : 'km';
                $earth_surface = ( 'mi' === $radius_unit ) ? 3959 : 6371;
        
                $store_query->query_fields .= ", (
                    {$earth_surface} * acos(
                        cos( radians( {$wcfmmp_radius_lat} ) ) *
                        cos( radians( branch.latitude ) ) *
                        cos(
                                radians( branch.longitude ) - radians( {$wcfmmp_radius_lng} )
                        ) +
                        sin( radians( {$wcfmmp_radius_lat} ) ) *
                        sin( radians( branch.latitude ) )
                    )
                ) as wcfmmp_distance";
                
                $store_query->query_from .= " inner join {$wpdb->prefix}wcfm_store_locations as branch on {$wpdb->users}.ID = branch.store_id";
                $distance = absint(  $wcfmmp_radius_range );
                $store_query->query_orderby = "having wcfmmp_distance < {$distance} " . $store_query->query_orderby . ", wcfmmp_distance ASC";
                
                $sql = "SELECT branch.ID, branch.store_id, (
                    {$earth_surface} * acos(
                        cos( radians( {$wcfmmp_radius_lat} ) ) *
                        cos( radians( branch.latitude ) ) *
                        cos(
                                radians( branch.longitude ) - radians( {$wcfmmp_radius_lng} )
                        ) +
                        sin( radians( {$wcfmmp_radius_lat} ) ) *
                        sin( radians( branch.latitude ) )
                    )
                ) as wcfmmp_distance FROM {$wpdb->prefix}wcfm_store_locations as branch HAVING wcfmmp_distance < %d ORDER BY wcfmmp_distance ASC";
                $result = $wpdb->get_results($wpdb->prepare($sql, $distance), ARRAY_A);
                $nearest_branches = [];
                foreach($result as $branch) {
                    if(isset($nearest_branches[$branch['store_id']])) continue;
                    $nearest_branches[$branch['store_id']] = $branch['ID'];
                }
                if(!empty($nearest_branches)) {
                    $store_query->query_where .= ' AND branch.ID IN ('.implode(',', array_values($nearest_branches)).')';
                }
            } else {
                global $user_country, $user_state, $user_city, $user_postcode;
                $where_clause = [];
                if ($user_country) $where_clause[] = 'branch.country="' . $user_country . '"';
                if ($user_state) $where_clause[] = 'branch.state="' . $user_state . '"';
                if ($user_city) $where_clause[] = 'branch.city="' . $user_city . '"';
                if ($user_postcode) $where_clause[] = 'branch.postal_code="' . $user_postcode . '"';
                if(!empty($where_clause)) {
                    $store_query->query_fields .= ',branch.ID as branch_id, branch.latitude, branch.longitude, branch.address, branch.address2, branch.city, branch.postal_code, branch.state, branch.country';
                    $store_query->query_from .= " inner join {$wpdb->prefix}wcfm_store_locations as branch on {$wpdb->users}.ID = branch.store_id";
                    $store_query->query_where = str_replace(
                        'WHERE 1=1 AND ',
                        "WHERE 1=1 AND " . implode(' AND ', $where_clause) . " AND ",
                        $store_query->query_where
                    );
                    $sql = "SELECT `ID`, `store_id` FROM {$wpdb->prefix}wcfm_store_locations as branch WHERE 1=1 AND " . implode(' AND ', $where_clause);
                    $result = $wpdb->get_results($sql, ARRAY_A);
                    $branches = [];
                    foreach($result as $branch) {
                        if(isset($branches[$branch['store_id']])) continue;
                        $branches[$branch['store_id']] = $branch['ID'];
                    }
                    if(!empty($branches)) {
                        $store_query->query_where .= ' AND branch.ID IN ('.implode(',', array_values($branches)).')';
                    }
                }
            }
        }
    }

    public function wcfmu_user_vendor_closest_branch_distance_query ($store_query = '', $add_branch_data = false) {
        global $WCFMmp, $wpdb, $wcfmmp_radius_lat, $wcfmmp_radius_lng;
	
        $radius_unit   = isset( $WCFMmp->wcfmmp_marketplace_options['radius_unit'] ) ? $WCFMmp->wcfmmp_marketplace_options['radius_unit'] : 'km';
        $earth_surface = ( 'mi' === $radius_unit ) ? 3959 : 6371;
        $store_query = " SELECT (
            {$earth_surface} * acos(
                cos( radians( {$wcfmmp_radius_lat} ) ) *
                cos( radians( branch.latitude ) ) *
                cos(
                        radians( branch.longitude ) - radians( {$wcfmmp_radius_lng} )
                ) +
                sin( radians( {$wcfmmp_radius_lat} ) ) *
                sin( radians( branch.latitude ) )
            )
        ) as wcfmmp_distance";
        if($add_branch_data) {
            $store_query .= ', branch.*';
        }
        $store_query .= " FROM {$wpdb->users}";
        $join_query = " inner join {$wpdb->prefix}wcfm_store_locations as branch on {$wpdb->users}.ID = branch.store_id";
        $where_clause = " WHERE {$wpdb->users}.ID = %d";
        if(apply_filters('wcfmu_shipping_default_to_main_branch', false) && is_checkout()) {
            $join_query .= " inner join {$wpdb->prefix}wcfm_store_locations_meta as branch_meta on branch_meta.branch_id = branch.ID";
            $where_clause .= " AND branch_meta.meta_key='is_main_branch' AND branch_meta.meta_value='1'";
        } elseif(apply_filters('wcfm_is_allow_individual_branch_shipping', true) && is_checkout()) {
            $join_query .= " inner join {$wpdb->prefix}wcfm_store_locations_meta as branch_meta on branch_meta.branch_id = branch.ID";
            $where_clause .= " AND branch_meta.meta_key='offers_shipping' AND branch_meta.meta_value='1'";
        }
        $order_by = " ORDER BY wcfmmp_distance ASC LIMIT 1";
        return $store_query.$join_query.$where_clause.$order_by;
    }

    private function convert_branch_address_in_old_format($branch_data) {
        return [
            'street_1' => $branch_data['address'] ?? '',
            'street_2' => $branch_data['address2'] ?? '',
            'city'     => $branch_data['city'] ?? '',
            'zip'      => $branch_data['postal_code'] ?? '',
            'country'  => $branch_data['country'] ?? '',
            'state'    => $branch_data['state'] ?? '',
        ];
    }

    public function wcfmu_update_vendor_address_data($shop_data, $vendor_id, $branch_id ) {
        global $wpdb;
		if(!$branch_id) {
            $branch_id = $wpdb->get_var($wpdb->prepare("SELECT branch_id FROM {$wpdb->prefix}wcfm_store_locations_meta WHERE store_id = %d AND meta_key = %s AND meta_value = %d", $vendor_id, 'is_main_branch', 1));
        }

        if($branch_id) {
            $branch_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}wcfm_store_locations WHERE ID = %d", $branch_id), ARRAY_A);
            $address = $this->convert_branch_address_in_old_format($branch_data);
            $shop_data['address'] = $address;
        }
        return $shop_data;
    }

    public function wcfmu_update_profile_address_settings($branch, $vendor_id) {
        $shop_info = get_user_meta( $vendor_id, 'wcfmmp_profile_settings', true );
        $shop_info['address'] = $this->convert_branch_address_in_old_format($branch);
        $shop_info['geolocation'] = [
            'store_location' => $branch['map_address'] ?? '',
            'store_lat' => $branch['latitude'] ?? 0,
            'store_lng' => $branch['longitude'] ?? 0,
        ];
        $shop_info['find_address'] = $branch['map_address'] ?? '';
        $shop_info['store_location'] = $branch['map_address'] ?? '';
        $shop_info['store_lat'] = $branch['latitude'] ?? 0;
        $shop_info['store_lng'] = $branch['longitude'] ?? 0;
        update_user_meta( $vendor_id, 'wcfmmp_profile_settings', $shop_info );
        update_user_meta( $vendor_id, '_wcfm_store_lat', $shop_info['store_lat'] );
        update_user_meta( $vendor_id, '_wcfm_store_lng', $shop_info['store_lng'] );
    }

    public function wcfmu_add_branch_logistics_data($info, $data, $vendor_id) {
        $branch_id = $data['branch_id'] ?? $data['b_id'] ?? 0;
        if(!$branch_id) return $info;
        if(!empty($data['branch_name'])) {
            $info = '<p><strong>'.$data['branch_name'].'</strong></p>' . $info;
        }
        if(apply_filters('wcfm_is_pref_multi_store', true) && apply_filters('wcfmu_display_logistics_data_on_info_window', true) ) {
            if(isset($this->branch_logistics[$branch_id]['offers_shipping']) && $this->branch_logistics[$branch_id]['offers_shipping']==1) {
                $info .= "<p class='wcfm_map_info_shipping'><i class='wcfmfa fa-truck'></i> ". esc_html( 'Offers shipping', 'wc-frontend-manager-ultimate') ."</p>";
            }
            if(isset($this->branch_logistics[$branch_id]['offers_pickup']) && $this->branch_logistics[$branch_id]['offers_pickup']==1) {
                $info .= "<p class='wcfm_map_info_pickup'><i class='wcfmfa fa-store'></i> ". esc_html( 'Offers in-store pickup', 'wc-frontend-manager-ultimate') ."</p>";
            }
        }
        return $info;
    }

    public function wcfmu_return_closest_pickup_address($label, $vendor_id, $only_address = false) {
        global $wpdb, $WCFMmp, $wcfmmp_radius_lat, $wcfmmp_radius_lng;
        $wcfmmp_radius_lat = (!$wcfmmp_radius_lat) ? WC()->session->get( '_wcfmmp_user_location_lat' ) : $wcfmmp_radius_lat;
        $wcfmmp_radius_lng = (!$wcfmmp_radius_lng) ? WC()->session->get( '_wcfmmp_user_location_lng' ) : $wcfmmp_radius_lng;

        if(!$wcfmmp_radius_lat || !$wcfmmp_radius_lng || !apply_filters( 'wcfmmp_is_allow_checkout_user_location', true )) {
            $customer_address = [];
            $customer_address['city']       = WC()->customer->get_shipping_city();
            $customer_address['state']      = WC()->customer->get_shipping_state();
            $customer_address['country']    = WC()->customer->get_shipping_country();
            $customer_address['postalcode'] = WC()->customer->get_shipping_postcode();
            $customer_address = array_filter($customer_address);
            if(count($customer_address)) {
                $query_arr = [];
                foreach($customer_address as $field=>$val) {
                    $query_arr[] = $field.'='.urlencode($val);
                }
                $search_query = implode('&', $query_arr);
                $url = 'https://nominatim.openstreetmap.org/search?'.$search_query.'&format=json';
                $response = wp_remote_get($url);
                if (!is_wp_error($response)) {
                    $body = wp_remote_retrieve_body($response);
                    $result = json_decode($body, true);
                    if (!empty($result)) {
                        $wcfmmp_radius_lat = $result[0]['lat'];
                        $wcfmmp_radius_lng = $result[0]['lon'];
                    }
                }
            }
        }

        if( !$wcfmmp_radius_lat || !$wcfmmp_radius_lng || !wcfm_is_vendor($vendor_id) || apply_filters('wcfmu_pickup_default_to_main_branch', false)) return $label;

        $radius_unit   = isset( $WCFMmp->wcfmmp_marketplace_options['radius_unit'] ) ? $WCFMmp->wcfmmp_marketplace_options['radius_unit'] : 'km';
        $earth_surface = ( 'mi' === $radius_unit ) ? 3959 : 6371;
        
		$select_query = " SELECT *, (
            {$earth_surface} * acos(
                cos( radians( {$wcfmmp_radius_lat} ) ) *
                cos( radians( branch.latitude ) ) *
                cos(
                        radians( branch.longitude ) - radians( {$wcfmmp_radius_lng} )
                ) +
                sin( radians( {$wcfmmp_radius_lat} ) ) *
                sin( radians( branch.latitude ) )
            )
        ) as wcfmmp_distance FROM {$wpdb->prefix}wcfm_store_locations as branch";
        $join_query = "";
        $where_clause = " WHERE branch.store_id = %d";
        $order_by = " ORDER BY wcfmmp_distance ASC LIMIT 1";

        if(apply_filters('wcfm_is_allow_individual_branch_pickup', true)) {
            $join_query .= " inner join {$wpdb->prefix}wcfm_store_locations_meta as branch_meta on branch_meta.branch_id = branch.ID";
            $where_clause .= " AND branch_meta.meta_key='offers_pickup' AND branch_meta.meta_value='1'";
        }

        $pickup_branch = $wpdb->get_row($wpdb->prepare($select_query.$join_query.$where_clause.$order_by, $vendor_id), ARRAY_A);
        if(!$pickup_branch) return $label;
        $pickup_address = $this->formatted_store_address($pickup_branch);
        if($only_address) {
            return $pickup_address;
        }
        return __('Pickup from Store', 'wc-multivendor-marketplace') . ' (' . $pickup_address .')';
    }

    public function wcfmmp_checkout_vendor_branch_address_save($order_id) {
        global $wpdb, $WCFMmp, $wcfmmp_radius_lat, $wcfmmp_radius_lng;
        $wcfmmp_radius_lat = (!$wcfmmp_radius_lat && !empty($_POST['wcfmmp_user_location_lat'])) ? sanitize_text_field($_POST['wcfmmp_user_location_lat']) : $wcfmmp_radius_lat;
        $wcfmmp_radius_lng = (!$wcfmmp_radius_lng && !empty($_POST['wcfmmp_user_location_lat'])) ? sanitize_text_field($_POST['wcfmmp_user_location_lng']) : $wcfmmp_radius_lng;
        $order = wc_get_order( $order_id );
        if(!$wcfmmp_radius_lat || !$wcfmmp_radius_lng || !apply_filters( 'wcfmmp_is_allow_checkout_user_location', true )) { 
            $customer_address = [];
            $customer_address['city']       = $order->get_shipping_city();
            $customer_address['state']      = $order->get_shipping_state();
            $customer_address['country']    = $order->get_shipping_country();
            $customer_address['postalcode'] = $order->get_shipping_postcode();
            $customer_address = array_filter($customer_address);
            if(count($customer_address)) {
                $query_arr = [];
                foreach($customer_address as $field=>$val) {
                    $query_arr[] = $field.'='.urlencode($val);
                }
                $search_query = implode('&', $query_arr);
                $url = 'https://nominatim.openstreetmap.org/search?'.$search_query.'&format=json';
                $response = wp_remote_get($url);
                if (!is_wp_error($response)) {
                    $body = wp_remote_retrieve_body($response);
                    $result = json_decode($body, true);
                    if (!empty($result)) {
                        $wcfmmp_radius_lat = $result[0]['lat'];
                        $wcfmmp_radius_lng = $result[0]['lon'];
                    }
                }
            }
        }

        if( !$wcfmmp_radius_lat || !$wcfmmp_radius_lng || apply_filters('wcfmu_shipping_default_to_main_branch', false) ) return;

        $vendors = array();
        foreach( $order->get_items( 'shipping' ) as $item_id => $item ){
            $vendor_id = $item->get_meta('vendor_id');
            if(!wcfm_is_vendor($vendor_id)) continue;
            $method_slug = $item->get_meta('method_slug');
            if($method_slug == 'local_pickup') continue;
            if(!in_array($vendor_id, $vendors)) {
                $vendors[] = $vendor_id;
            }
        }

        $include_branch_data = true;
        foreach($vendors as $v_id) {
            $nearest_branch_query = $this->wcfmu_user_vendor_closest_branch_distance_query('', $include_branch_data);
            $branch_data = $wpdb->get_row( $wpdb->prepare( $nearest_branch_query, $v_id ), ARRAY_A );
            if($branch_data) {
                $branch_address = $this->formatted_store_address( $branch_data );
                update_post_meta( $order_id, '_wcfmmp_vendor_'.$v_id.'_ship_from', $branch_address );
            }
        }
    }

    public function wcfmmp_show_branch_address_on_order_details_page($order_id) {
        $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        $branch_address = array();
        if($vendor_id) {
            $branch_address = get_post_meta( $order_id, '_wcfmmp_vendor_'.$vendor_id.'_ship_from', true );
            if($branch_address) {
                echo '<tr><td colspan="5"><strong>' . __("Ship from", 'wc-multivendor-marketplace') . ':</strong> '. $branch_address . '</td></tr>';
            } 
        }
    }

    public function fetch_all_queried_branches($stores) {
        global $WCFMmp, $wpdb, $wcfmmp_radius_lat, $wcfmmp_radius_lng, $wcfmmp_radius_range, $user_country, $user_state, $user_city, $user_postcode;
        if(!empty($stores) && !apply_filters('wcfmmp_vendor_restrict_to_single_map_marker', true) && apply_filters('wcfm_is_pref_multi_store', true)) {
            $store_ids = array_keys($stores);
            $result = null;
            if($wcfmmp_radius_lat && $wcfmmp_radius_lng && $wcfmmp_radius_range) {
                $radius_unit   = isset( $WCFMmp->wcfmmp_marketplace_options['radius_unit'] ) ? $WCFMmp->wcfmmp_marketplace_options['radius_unit'] : 'km';
                $earth_surface = ( 'mi' === $radius_unit ) ? 3959 : 6371;
                $distance = absint( $wcfmmp_radius_range );
                $sql = "SELECT branch.*, (
                    {$earth_surface} * acos(
                        cos( radians( {$wcfmmp_radius_lat} ) ) *
                        cos( radians( branch.latitude ) ) *
                        cos(
                                radians( branch.longitude ) - radians( {$wcfmmp_radius_lng} )
                        ) +
                        sin( radians( {$wcfmmp_radius_lat} ) ) *
                        sin( radians( branch.latitude ) )
                    )
                ) as wcfmmp_distance FROM {$wpdb->prefix}wcfm_store_locations as branch 
                WHERE 1=1 AND store_id IN (".implode(",", $store_ids).")
                HAVING wcfmmp_distance < %d
                ORDER BY store_id ASC, wcfmmp_distance ASC";
                $result = $wpdb->get_results($wpdb->prepare($sql, $distance), ARRAY_A);
            }  else {
                global $user_country, $user_state, $user_city, $user_postcode;
                $where_clause = [];
                if ($user_country) $where_clause[] = 'country="' . $user_country . '"';
                if ($user_state) $where_clause[] = 'state="' . $user_state . '"';
                if ($user_city) $where_clause[] = 'city="' . $user_city . '"';
                if ($user_postcode) $where_clause[] = 'postal_code="' . $user_postcode . '"';
                if(!empty($where_clause)) {
                    $sql = "SELECT * FROM {$wpdb->prefix}wcfm_store_locations
                    WHERE 1=1 AND store_id IN (".implode(",", $store_ids).") AND ".implode(' AND ', $where_clause)."
                    ORDER BY store_id ASC";
                    $result = $wpdb->get_results($sql, ARRAY_A);
                }
            }
            if(!empty($result)) {
                $all_branch_stores = [];
                $branch_ids = [];
                foreach($result as $branch) {
                    $store_id = $branch['store_id'];
                    $branch_ids[] = $branch['ID'];
                    $nearest_branch_data = $stores[$store_id][0];
                    $all_branch_stores[$store_id][] = array(
                        'ID' => $store_id,
                        'display_name' => $nearest_branch_data['display_name'],
                        'branch_id' => $branch['ID'],
                        'branch_name' => $branch['name'],
                        'latitude' => $branch['latitude'],
                        'longitude' => $branch['longitude'],
                        'address' => $branch['address'],
                        'address2' => $branch['address2'],
                        'city' => $branch['city'],
                        'postal_code' => $branch['postal_code'],
                        'state' => $branch['state'],
                        'country' => $branch['country'],
                        'wcfmmp_distance' => $branch['wcfmmp_distance'] ?? '',
                        'id' => $store_id,
                    );
                }
                $stores = $all_branch_stores;
            }
        }
        if(apply_filters('wcfmu_display_logistics_data_on_info_window', true) && apply_filters('wcfm_is_pref_multi_store', true)) {
            $branch_ids = [];
            $store_ids = [];
            foreach($stores as $store_id => $branches) {
                $store_ids[] = $store_id;
                foreach($branches as $branch) {
                    if(isset($branch['branch_id'])) {
                        $branch_ids[] = $branch['branch_id'];
                    }
                }
            }
            if(empty($branch_ids) && !empty($store_ids)) { 
                $sql = "SELECT l.ID, l.store_id, l.name FROM {$wpdb->prefix}wcfm_store_locations as l
                    INNER JOIN {$wpdb->prefix}wcfm_store_locations_meta as m ON l.ID = m.branch_id
                    WHERE 1=1 AND l.store_id IN (".implode(",", $store_ids).") AND m.meta_key = 'is_main_branch' AND m.meta_value = 1";
                $results = $wpdb->get_results($sql, ARRAY_A);
                foreach($results as $result) {
                    $store_id = $result['store_id'];
                    $branch_ids[] = $result['ID'];
                    $stores[$store_id][0]['b_id'] = $result['ID'];
                    $stores[$store_id][0]['branch_name'] = $result['name'];
                }
            }

            if(!empty($branch_ids)) {
                $branch_meta_query = "SELECT branch_id, meta_key, meta_value FROM {$wpdb->prefix}wcfm_store_locations_meta WHERE branch_id IN (". implode(',', $branch_ids) .") AND meta_key IN ('offers_shipping', 'offers_pickup')";
                $logistics = $wpdb->get_results($branch_meta_query);
                foreach($logistics as $branch_meta) {
                    if($branch_meta->meta_key=='offers_shipping') {
                        $this->branch_logistics[$branch_meta->branch_id]['offers_shipping'] = $branch_meta->meta_value;
                    } else {
                        $this->branch_logistics[$branch_meta->branch_id]['offers_pickup'] = $branch_meta->meta_value;
                    }
                }
            }
        }
        return $stores;
    }
}//end class
