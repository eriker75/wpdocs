<?php

/**
 * WCFM plugin core
 *
 * Appointments WC Appointments Support
 *
 * @author      WC Lovers
 * @package     wcfm/core
 * @version   2.4.0
 */

class WCFMu_WCAppointments
{

    public function __construct()
    {
        global $WCFM, $WCFMu;

        if ( $wcfm_is_allow_appointments = apply_filters('wcfm_is_allow_appointments', true) ) {
            if ( WCFMu_Dependencies::wcfm_wc_appointments_active_check() ) {
                // WCFM Appointments Query Var Filter
                add_filter('wcfm_query_vars', array( &$this, 'wca_wcfm_query_vars' ), 90);
                add_filter('wcfm_endpoint_title', array( &$this, 'wca_wcfm_endpoint_title' ), 90, 2);
                add_action('init', array( &$this, 'wca_wcfm_init' ), 90);

                // WCFM Appointments Endpoint Edit
                add_filter('wcfm_endpoints_slug', array( $this, 'wca_wcfm_endpoints_slug' ));

                if ( current_user_can('manage_appointments') ) {
                    // WCFM Menu Filter
                    add_filter('wcfm_menus', array( &$this, 'wca_wcfm_menus' ), 90);

                    // Appointments Product Type
                    add_filter('wcfm_product_types', array( &$this, 'wca_product_types' ), 90);

                    // Appointment Product Type Capability
                    add_filter('wcfm_capability_settings_fields_product_types', array( &$this, 'wcfmcap_product_types' ), 90, 3);

                    // Appointments Load WCFMu Scripts
                    add_action('after_wcfm_load_scripts', array( &$this, 'wca_load_scripts' ), 90);

                    // Appointments Load WCFMu Styles
                    add_action('after_wcfm_load_styles', array( &$this, 'wca_load_styles' ), 90);

                    // Appointments Load WCFMu views
                    add_action('wcfm_load_views', array( &$this, 'wca_load_views' ), 90);

                    // Appointments Ajax Controllers
                    add_action('after_wcfm_ajax_controller', array( &$this, 'wca_ajax_controller' ));

                    // Apointments Inventory Block
                    add_filter('wcfm_product_fields_stock', array( &$this, 'wca_product_manage_fields_stock' ), 90, 3);

                    // Appointments General Block
                    add_action('after_wcfm_products_manage_general', array( &$this, 'wca_product_manage_general' ), 90, 2);

                    // Appointments Addons Options
                    add_filter('wcfm_product_manage_fields_wcaddons', array( &$this, 'wca_product_manage_fields_wcaddons' ), 90);

                    // Appointment Mark as Confirmed
                    add_action('wp_ajax_wcfm_appointment_mark_confirm', array( &$this, 'wcfm_appointment_mark_confirm' ));

                    // Appointment Status Update
                    add_action('wp_ajax_wcfm_modify_appointment_status', array( &$this, 'wcfm_modify_appointment_status' ));

                    // Customer Status Update
                    add_action('wp_ajax_wcfm_modify_customer_status', array( &$this, 'wcfm_modify_customer_status' ));

                    // Manual Appointment set Customer as Guest
                    add_filter('wcfm_manual_appointment_props', array( &$this, 'wcfm_manual_appointment_props' ));

                    // Profile Google Calendar Sync option
                    add_action('end_wcfm_user_profile', array( &$this, 'wcfm_appointment_gcal_user_profile' ), 15);
                    add_action('wcfm_profile_update', array( &$this, 'wcfm_appointment_gcal_user_profile_update' ), 15, 2);

                    add_action( 'wp_ajax_wcfm_oauth_redirect', [ $this, 'oauth_redirect' ] );
                    add_action( 'wp_ajax_wcfm_woocommerce_manual_sync', [ $this, 'manual_sync' ] );
                }
            }
        }

        // add vendor email for confirm appointment email
        if ( apply_filters('wcfm_is_allow_new_appointments_vendor_notification', true) ) {
            add_filter('woocommerce_email_recipient_new_appointment', array( $this, 'wcfm_filter_appointment_emails' ), 10, 2);
        }

        // add vendor email for cancelled appointment email
        if ( apply_filters('wcfm_is_allow_cancel_appointments_vendor_notification', true) ) {
            add_filter('woocommerce_email_recipient_appointment_cancelled', array( $this, 'wcfm_filter_appointment_emails' ), 10, 2);
        }

        // Add Vendor Direct System Message
        add_filter('wcfm_message_types', array( &$this, 'wca_wcfm_message_types' ), 20);
        if ( apply_filters('wcfm_is_allow_appointments_extended_notifications', false) ) {
            add_action('woocommerce_appointment_in-cart_to_paid_notification', array( $this, 'wcfm_message_on_new_appointment' ));
            add_action('woocommerce_appointment_in-cart_to_pending-confirmation_notification', array( $this, 'wcfm_message_on_new_appointment' ));
            add_action('woocommerce_appointment_unpaid_to_paid_notification', array( $this, 'wcfm_message_on_new_appointment' ));
            add_action('woocommerce_appointment_unpaid_to_pending-confirmation_notification', array( $this, 'wcfm_message_on_new_appointment' ));
            add_action('woocommerce_appointment_confirmed_to_paid_notification', array( $this, 'wcfm_message_on_new_appointment' ));
        }
        add_action('woocommerce_new_appointment_notification', array( $this, 'wcfm_message_on_new_appointment' ));
        add_action('woocommerce_admin_new_appointment_notification', array( $this, 'wcfm_message_on_new_appointment' ));

        add_filter('wcfm_dashboard_modified_endpoint_slug', array( $this, 'modified_appointment_endpoint_slug' ));

        // Sync vendor availability slot for calendar
        add_filter( 'woocommerce_appointments_get_all_availabilities', array( $this, 'woocommerce_appointments_get_vendor_availabilities' ) );

        // Modify vendor appointment product availability
        add_filter( 'woocommerce_appointment_get_availability_rules', array( $this, 'get_availability_rules' ), 10, 3 );
    }

    /**
     * WC Appointments Query Var
     */
    function wca_wcfm_query_vars( $query_vars )
    {
        $wcfm_modified_endpoints = wcfm_get_option('wcfm_endpoints', array());

        $query_appointments_vars = array(
            'wcfm-appointments-dashboard'     => ! empty($wcfm_modified_endpoints['wcfm-appointments-dashboard']) ? $wcfm_modified_endpoints['wcfm-appointments-dashboard'] : 'appointments-dashboard',
            'wcfm-appointments'               => ! empty($wcfm_modified_endpoints['wcfm-appointments']) ? $wcfm_modified_endpoints['wcfm-appointments'] : 'appointmentslist',
            'wcfm-appointments-staffs'        => ! empty($wcfm_modified_endpoints['wcfm-appointments-staffs']) ? $wcfm_modified_endpoints['wcfm-appointments-staffs'] : 'appointments-staffs',
            'wcfm-appointments-staffs-manage' => ! empty($wcfm_modified_endpoints['wcfm-appointments-staffs-manage']) ? $wcfm_modified_endpoints['wcfm-appointments-staffs-manage'] : 'appointments-staffs-manage',
            'wcfm-appointments-manual'        => ! empty($wcfm_modified_endpoints['wcfm-appointments-manual']) ? $wcfm_modified_endpoints['wcfm-appointments-manual'] : 'appointments-manual',
            'wcfm-appointments-calendar'      => ! empty($wcfm_modified_endpoints['wcfm-appointments-calendar']) ? $wcfm_modified_endpoints['wcfm-appointments-calendar'] : 'appointments-calendar',
            'wcfm-appointments-details'       => ! empty($wcfm_modified_endpoints['wcfm-appointments-details']) ? $wcfm_modified_endpoints['wcfm-appointments-details'] : 'appointments-details',
            'wcfm-appointments-settings'      => ! empty($wcfm_modified_endpoints['wcfm-appointments-settings']) ? $wcfm_modified_endpoints['wcfm-appointments-settings'] : 'appointments-settings',
        );

        $query_vars = array_merge($query_vars, $query_appointments_vars);

        return $query_vars;
    }

    /**
     * WC Appointments End Point Title
     */
    function wca_wcfm_endpoint_title( $title, $endpoint )
    {
        global $WCFM, $WCFMu, $wp;

        switch ( $endpoint ) {
            case 'wcfm-appointments-dashboard':
                $title = __('Appointments Dashboard', 'wc-frontend-manager-ultimate');
                break;
            case 'wcfm-appointments':
                $title = __('Appointments List', 'wc-frontend-manager-ultimate');
                break;
            case 'wcfm-appointments-staffs':
                $title = __('Appointments Staffs', 'wc-frontend-manager-ultimate');
                break;
            case 'wcfm-appointments-staffs-manage':
                $title = __('Appointments Staffs Manage', 'wc-frontend-manager-ultimate');
                break;
            case 'wcfm-appointments-manual':
                $title = __('Create Appointments', 'wc-frontend-manager-ultimate');
                break;
            case 'wcfm-appointments-calendar':
                $title = __('Appointments Calendar', 'wc-frontend-manager-ultimate');
                break;
            case 'wcfm-appointments-details':
                // translators: 1) appointment id
                $title = sprintf(__('Appointments Details #%s', 'wc-frontend-manager-ultimate'), $wp->query_vars['wcfm-appointments-details']);
                break;
            case 'wcfm-appointments-settings':
                $title = __('Appointments Settings', 'wc-frontend-manager-ultimate');
                break;
        }

        return $title;
    }

    /**
     * WC Appointments Endpoint Intialize
     */
    function wca_wcfm_init()
    {
        global $WCFM_Query;

        // Intialize WCFM End points
        $WCFM_Query->init_query_vars();
        $WCFM_Query->add_endpoints();

        if ( ! get_option('wcfm_updated_end_point_wc_appointments') ) {
            // Flush rules after endpoint update
            flush_rewrite_rules();
            update_option('wcfm_updated_end_point_wc_appointments', 1);
        }
    }

    /**
     * WC Appointments Endpoiint Edit
     */
    function wca_wcfm_endpoints_slug( $endpoints )
    {

        $appointment_endpoints = array(
            'wcfm-appointments-dashboard'     => 'appointments-dashboard',
            'wcfm-appointments'               => 'appointmentslist',
            'wcfm-appointments-staffs'        => 'appointments-staffs',
            'wcfm-appointments-staffs-manage' => 'appointments-staffs-manage',
            'wcfm-appointments-manual'        => 'appointments-manual',
            'wcfm-appointments-calendar'      => 'appointments-calendar',
            'wcfm-appointments-details'       => 'appointments-details',
            'wcfm-appointments-settings'      => 'appointments-settings',
        );

        $endpoints = array_merge($endpoints, $appointment_endpoints);

        return $endpoints;
    }

    /**
     * WC Appointments Menu
     */
    function wca_wcfm_menus( $menus )
    {
        global $WCFM;

        if ( current_user_can('manage_appointments') ) {
            $menus = array_slice($menus, 0, 3, true) +
            array(
                'wcfm-appointments-dashboard' => array(
                    'label'    => __('Appointments', 'woocommerce-appointments'),
                    'url'      => get_wcfm_appointments_dashboard_url(),
                    'icon'     => 'clock',
                    'priority' => 20,
                ),
            ) +
            array_slice($menus, 3, count($menus) - 3, true);
        }

        return $menus;
    }

    /**
     * WC Appointments Product Type
     */
    function wca_product_types( $pro_types )
    {
        global $WCFM;
        if ( current_user_can('manage_appointments') ) {
            $pro_types['appointment'] = __('Appointable product', 'woocommerce-appointments');
        }

        return $pro_types;
    }

    /**
     * WCFM Capability Product Types
     */
    function wcfmcap_product_types( $product_types, $handler = 'wcfm_capability_options', $wcfm_capability_options = array() )
    {
        global $WCFM, $WCFMu;

        $appointment = ( isset($wcfm_capability_options['appointment']) ) ? $wcfm_capability_options['appointment'] : 'no';

        $product_types['appointment'] = array(
            'label'       => __('Appointment', 'wc-frontend-manager-ultimate'),
            'name'        => $handler . '[appointment]',
            'type'        => 'checkboxoffon',
            'class'       => 'wcfm-checkbox wcfm_ele',
            'value'       => 'yes',
            'label_class' => 'wcfm_title checkbox_title',
            'dfvalue'     => $appointment,
        );

        return $product_types;
    }

    /**
     * WC Appointments Scripts
     */
    public function wca_load_scripts( $end_point )
    {
        global $WCFM, $WCFMu;

        switch ( $end_point ) {
            case 'wcfm-products-manage':
                $WCFM->library->load_colorpicker_lib();
                wp_enqueue_script( 'iris', admin_url('js/iris.min.js'),array('jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch'), false, 1);
                wp_enqueue_script( 'wp-color-picker', admin_url('js/color-picker.min.js'), array('iris'), false,1);
                
                wp_enqueue_script('wcfmu_wc_appointments_products_manage_js', $WCFMu->library->js_lib_url . 'wc_appointments/wcfmu-script-wcappointments-products-manage.js', array( 'jquery' ), $WCFMu->version, true);
                break;

            case 'wcfm-appointments':
                $WCFM->library->load_datatable_lib();
                $WCFM->library->load_daterangepicker_lib();
                wp_enqueue_script('wcfmu_appointments_js', $WCFMu->library->js_lib_url . 'wc_appointments/wcfmu-script-wcappointments.js', array( 'jquery', 'dataTables_js' ), $WCFMu->version, true);

                // Screen manager
                $wcfm_screen_manager      = (array) get_option('wcfm_screen_manager');
                $wcfm_screen_manager_data = array();
                if ( isset($wcfm_screen_manager['appointment']) ) {
                    $wcfm_screen_manager_data = $wcfm_screen_manager['appointment'];
                }
                if ( ! isset($wcfm_screen_manager_data['admin']) ) {
                    $wcfm_screen_manager_data['admin']  = $wcfm_screen_manager_data;
                    $wcfm_screen_manager_data['vendor'] = $wcfm_screen_manager_data;
                }
                if ( wcfm_is_vendor() ) {
                    $wcfm_screen_manager_data = $wcfm_screen_manager_data['vendor'];
                } else {
                    $wcfm_screen_manager_data = $wcfm_screen_manager_data['admin'];
                }
                if ( ! apply_filters('wcfm_is_allow_manage_appointment_staff', true) || ! apply_filters('wcfm_is_allow_manage_staff', true) ) {
                    $wcfm_screen_manager_data[4] = 'yes';
                }
                if ( apply_filters('wcfm_appointments_additonal_data_hidden', true) ) {
                    $wcfm_screen_manager_data[7] = 'yes';
                }
                wp_localize_script('wcfmu_appointments_js', 'wcfm_appointments_screen_manage', $wcfm_screen_manager_data);
                break;

            case 'wcfm-appointments-staffs':
                $WCFM->library->load_datatable_lib();
                wp_enqueue_script('wcfmu_appointments_staffs_js', $WCFMu->library->js_lib_url . 'wc_appointments/wcfmu-script-wcappointments-staffs.js', array( 'jquery', 'dataTables_js' ), $WCFMu->version, true);
                break;

            case 'wcfm-appointments-staffs-manage':
                $WCFM->library->load_datepicker_lib();
                wp_enqueue_script('wcfmu_appointments_staffs_manage_js', $WCFMu->library->js_lib_url . 'wc_appointments/wcfmu-script-wcappointments-staffs-manage.js', array( 'jquery' ), $WCFMu->version, true);
                // Localized Script
                $wcfm_messages = get_wcfm_staffs_manage_messages();
                wp_localize_script('wcfmu_appointments_staffs_manage_js', 'wcfm_staffs_manage_messages', $wcfm_messages);
                break;

            case 'wcfm-appointments-manual':
                $WCFM->library->load_select2_lib();
                wp_enqueue_script('wcfmu_appointments_manual_js', $WCFMu->library->js_lib_url . 'wc_appointments/wcfmu-script-wcappointments-manual.js', array( 'jquery', 'select2_js' ), $WCFMu->version, true);
                break;

            case 'wcfm-appointments-calendar':
                $WCFM->library->load_tiptip_lib();
                $WCFM->library->load_datepicker_lib();
                wp_enqueue_script('wcfmu_appointments_calendar_js', $WCFMu->library->js_lib_url . 'wc_appointments/wcfmu-script-wcappointments-calendar.js', array( 'jquery' ), $WCFMu->version, true);
                break;

            case 'wcfm-appointments-details':
                wp_enqueue_script('wcfmu_appointments_details_js', $WCFMu->library->js_lib_url . 'wc_appointments/wcfmu-script-wcappointments-details.js', array( 'jquery' ), $WCFMu->version, true);
                break;

            case 'wcfm-appointments-settings':
                $WCFM->library->load_datepicker_lib();
                wp_enqueue_script('wcfmu_appointments_settings_js', $WCFMu->library->js_lib_url . 'wc_appointments/wcfmu-script-wcappointments-settings.js', array( 'jquery' ), $WCFMu->version, true);
                break;

            case 'wcfm-profile':
                wp_enqueue_script('wcfmu_appointments_profile_js', $WCFMu->library->js_lib_url . 'wc_appointments/wcfmu-script-wcappointments-profile.js', array( 'jquery' ), $WCFMu->version, true);
                break;
        }
    }

    /**
     * WC Appointments Styles
     */
    public function wca_load_styles( $end_point )
    {
        global $WCFM, $WCFMu;

        switch ( $end_point ) {
            case 'wcfm-products-manage':
                wp_enqueue_style('wcfmu_wc_appointments_products_manage_css', $WCFMu->library->css_lib_url . 'wc_appointments/wcfmu-style-wcappointments-products-manage.css', array(), $WCFMu->version);
                break;

            case 'wcfm-appointments-dashboard':
                wp_enqueue_style('wcfmu_appointments_dashboard_css', $WCFMu->library->css_lib_url . 'wc_appointments/wcfmu-style-wcappointments-dashboard.css', array(), $WCFMu->version);
                break;

            case 'wcfm-appointments':
                wp_enqueue_style('wcfmu_appointments_css', $WCFMu->library->css_lib_url . 'wc_appointments/wcfmu-style-wcappointments.css', array(), $WCFMu->version);
                break;

            case 'wcfm-appointments-staffs':
                wp_enqueue_style('wcfmu_appointments_staffs_css', $WCFMu->library->css_lib_url . 'wc_appointments/wcfmu-style-wcappointments-staffs.css', array(), $WCFMu->version);
                break;

            case 'wcfm-appointments-staffs-manage':
                wp_enqueue_style('collapsible_css', $WCFM->library->css_lib_url . 'wcfm-style-collapsible.css', array(), $WCFMu->version);
                wp_enqueue_style('wcfmu_appointments_staffs_manage_css', $WCFMu->library->css_lib_url . 'wc_appointments/wcfmu-style-wcappointments-staffs-manage.css', array(), $WCFMu->version);
                break;

            case 'wcfm-appointments-manual':
                wp_enqueue_style('collapsible_css', $WCFM->library->css_lib_url . 'wcfm-style-collapsible.css', array(), $WCFMu->version);
                wp_enqueue_style('wcfmu_appointments_manual_css', $WCFMu->library->css_lib_url . 'wc_appointments/wcfmu-style-wcappointments-manual.css', array(), $WCFMu->version);
                break;

            case 'wcfm-appointments-calendar':
                wp_enqueue_style('collapsible_css', $WCFM->library->css_lib_url . 'wcfm-style-collapsible.css', array(), $WCFMu->version);
                wp_enqueue_style('wcfmu_appointments_calendar_css', $WCFMu->library->css_lib_url . 'wc_appointments/wcfmu-style-wcappointments-calendar.css', array(), $WCFMu->version);
                break;

            case 'wcfm-appointments-details':
                wp_enqueue_style('collapsible_css', $WCFM->library->css_lib_url . 'wcfm-style-collapsible.css', array(), $WCFMu->version);
                wp_enqueue_style('wcfmu_appointments_details_css', $WCFMu->library->css_lib_url . 'wc_appointments/wcfmu-style-wcappointments-details.css', array(), $WCFMu->version);
                break;

            case 'wcfm-appointments-settings':
                wp_enqueue_style('collapsible_css', $WCFM->library->css_lib_url . 'wcfm-style-collapsible.css', array(), $WCFMu->version);
                wp_enqueue_style('wcfmu_appointments_settings_css', $WCFMu->library->css_lib_url . 'wc_appointments/wcfmu-style-wcappointments-settings.css', array(), $WCFMu->version);
                break;
        }
    }

    /**
     * WC Appointments Views
     */
    public function wca_load_views( $end_point )
    {
        global $WCFM, $WCFMu;

        switch ( $end_point ) {
            case 'wcfm-appointments-dashboard':
                $WCFMu->template->get_template('wc_appointments/wcfmu-view-wcappointments-dashboard.php');
                break;

            case 'wcfm-appointments':
                $WCFMu->template->get_template('wc_appointments/wcfmu-view-wcappointments.php');
                break;

            case 'wcfm-appointments-staffs':
                $WCFMu->template->get_template('wc_appointments/wcfmu-view-wcappointments-staffs.php');
                break;

            case 'wcfm-appointments-staffs-manage':
                $WCFMu->template->get_template('wc_appointments/wcfmu-view-wcappointments-staffs-manage.php');
                break;

            case 'wcfm-appointments-manual':
                $WCFMu->template->get_template('wc_appointments/wcfmu-view-wcappointments-manual.php');
                break;

            case 'wcfm-appointments-calendar':
                $WCFMu->template->get_template('wc_appointments/wcfmu-view-wcappointments-calendar.php');
                break;

            case 'wcfm-appointments-details':
                $WCFMu->template->get_template('wc_appointments/wcfmu-view-wcappointments-details.php');
                break;

            case 'wcfm-appointments-settings':
                $WCFMu->template->get_template('wc_appointments/wcfmu-view-wcappointments-settings.php');
                break;
        }
    }

    /**
     * WC Appointments Ajax Controllers
     */
    public function wca_ajax_controller()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
			wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $controllers_path = $WCFMu->plugin_path . 'controllers/wc_appointments/';

        $controller = '';
        if ( isset($_POST['controller']) ) {
            $controller = $_POST['controller'];

            switch ( $controller ) {
                case 'wcfm-products-manage':
                    include_once $controllers_path . 'wcfmu-controller-wcappointments-products-manage.php';
                    new WCFMu_WCAppointments_Products_Manage_Controller();
                    break;

                case 'wcfm-appointments':
                    include_once $controllers_path . 'wcfmu-controller-wcappointments.php';
                    new WCFMu_WCAppointments_Controller();
                    break;

                case 'wcfm-appointments-staffs':
                    include_once $controllers_path . 'wcfmu-controller-wcappointments-staffs.php';
                    new WCFMu_WCAppointments_Staffs_Controller();
                    break;

                case 'wcfm-appointments-staffs-manage':
                    include_once $controllers_path . 'wcfmu-controller-wcappointments-staffs-manage.php';
                    new WCFMu_WCAppointments_Staffs_Manage_Controller();
                    break;

                case 'wcfm-appointments-settings':
                    include_once $controllers_path . 'wcfmu-controller-wcappointments-settings.php';
                    new WCFMu_WCAppointments_Settings_Controller();
                    break;
            }
        }
    }

    /**
     * WC Appoinemtnts Product Stock Options
     */
    function wca_product_manage_fields_stock( $stock_fields, $product_id, $product_type )
    {
        global $WCFM, $WCFMu;

        $capacity     = 1;
        $capacity_min = 1;
        $capacity_max = 1;
        if ( $product_id ) {
            $appointable_product = new WC_Product_Appointment($product_id);

            $capacity     = max(absint($appointable_product->get_qty('edit')), 1);
            $capacity_min = max(absint($appointable_product->get_qty_min('edit')), 1);
            $capacity_max = max(absint($appointable_product->get_qty_max('edit')), 1);
        }
        $apt_stock_fields = array(
            '_wc_appointment_qty'     => array(
                'label'       => __('Quantity', 'woocommerce-appointments'),
                'type'        => 'number',
                'class'       => 'wcfm-text wcfm_ele appointment',
                'label_class' => 'wcfm_title wcfm_ele appointment',
                'value'       => $capacity,
                'hints'       => __('The maximum number of appointments per slot.', 'woocommerce-appointments'),
            ),
            '_wc_appointment_qty_min' => array(
                'label'       => __('Min order', 'woocommerce-appointments'),
                'type'        => 'number',
                'class'       => 'wcfm-text wcfm_ele appointment',
                'label_class' => 'wcfm_title wcfm_ele appointment',
                'value'       => $capacity_min,
                'hints'       => __('The minimum number of appointments per order.', 'woocommerce-appointments'),
            ),
            '_wc_appointment_qty_max' => array(
                'label'       => __('Max order', 'woocommerce-appointments'),
                'type'        => 'number',
                'class'       => 'wcfm-text wcfm_ele appointment',
                'label_class' => 'wcfm_title wcfm_ele appointment',
                'value'       => $capacity_max,
                'hints'       => __('The maximum number of appointments per order.', 'woocommerce-appointments'),
            ),
        );
        $stock_fields     = array_merge($stock_fields, $apt_stock_fields);

        return $stock_fields;
    }

    /**
     * WC Appointments Product General Options
     */
    function wca_product_manage_general( $product_id, $product_type )
    {
        global $WCFM, $WCFMu;

        include_once $WCFMu->library->views_path . 'wc_appointments/wcfmu-view-wcappointments-products-manage.php';
    }

    /**
     * WC Appointments Product Addon Options
     */
    function wca_product_manage_fields_wcaddons( $product_addon_fields )
    {
        global $WCFM, $WCFMu;

        $product_addon_fields['_product_addons']['options'] = array_slice($product_addon_fields['_product_addons']['options'], 0, 4, true) +
        array(
            'wc_appointment_hide_duration_label' => array(
                'label'       => __('Hide duration label for customers', 'woocommerce-appointments'),
                'type'        => 'checkbox',
                'class'       => 'wcfm-checkbox',
                'label_class' => 'wcfm_title checkbox_title',
                'value'       => 1,
            ),
            'wc_appointment_hide_price_label'    => array(
                'label'       => __('Hide price label for customers', 'woocommerce-appointments'),
                'type'        => 'checkbox',
                'class'       => 'wcfm-checkbox',
                'label_class' => 'wcfm_title checkbox_title',
                'value'       => 1,
            ),
        ) +
        array_slice($product_addon_fields['_product_addons']['options'], 4, count($product_addon_fields['_product_addons']['options']) - 4, true);

        $product_addon_fields['_product_addons']['options']['options']['options'] = array_slice($product_addon_fields['_product_addons']['options']['options']['options'], 0, 3, true) +
        array(
            'duration' => array(
                'label'       => __('Duration', 'woocommerce-appointments'),
                'type'        => 'number',
                'placeholder' => __('N/A', 'woocommerce-appointments'),
                'attributes'  => array(
                    'min'  => 0,
                    'step' => 1,
                ),
                'class'       => 'wcfm-text addon_duration',
                'label_class' => 'wcfm_title addon_duration',
            ),
        ) +
        array_slice($product_addon_fields['_product_addons']['options']['options']['options'], 3, count($product_addon_fields['_product_addons']['options']['options']['options']) - 3, true);

        return $product_addon_fields;
    }

    /**
     * Handle Appointment confirmation
     */
    public function wcfm_appointment_mark_confirm()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $appointment_id = $_POST['appointmentid'];

        $appointment = get_wc_appointment($appointment_id);
        if ( 'confirmed' !== $appointment->get_status() ) {
            $appointment->update_status('confirmed');
        }
        die;
    }

    /**
     * Handle Appointment Details Status Update
     */
    public function wcfm_modify_appointment_status()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $appointment_id     = $_POST['appointment_id'];
        $appointment_status = $_POST['appointment_status'];

        $appointment = get_wc_appointment($appointment_id);
        $appointment->update_status($appointment_status);

        // Status Update Notification
        $user_id   = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        $shop_name = get_user_by('ID', $user_id)->display_name;
        if ( wcfm_is_vendor() ) {
            $shop_name = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_by_vendor(absint($user_id));
        }
        // translators: 1) appointment url 2) appointment status 3) shop name
        $wcfm_messages = sprintf(__('<b>%1$s</b> appointment status updated to <b>%2$s</b> by <b>%3$s</b>', 'wc-frontend-manager-ultimate'), '#<a target="_blank" class="wcfm_dashboard_item_title" href="' . get_wcfm_view_appointment_url($appointment_id) . '">' . $appointment_id . '</a>', ucfirst($appointment_status), $shop_name);

        $raw_message = [
            'l10n'	=> [
                'text' 		=> '<b>%1$s</b> appointment status updated to <b>%2$s</b> by <b>%3$s</b>',
                'domain'    => 'wc-frontend-manager-ultimate',
                'wrapper'	=> [
                    'function' 	=> 'sprintf',
                    'args' 		=> [
                        '#<a target="_blank" class="wcfm_dashboard_item_title" href="' . get_wcfm_view_appointment_url($appointment_id) . '">' . $appointment_id . '</a>', 
                        ucfirst($appointment_status), 
                        $shop_name
                    ]
                ]
            ]
        ];

        $WCFM->wcfm_notification->wcfm_send_direct_message(-2, 0, 1, 0, $wcfm_messages, 'status-update', true, $raw_message);

        echo '{"status": true, "message": "' . __('Appointment status updated.', 'wc-frontend-manager-ultimate') . '"}';
        die;
    }

    /**
     * Handle Customer Status Update
     */
    public function wcfm_modify_customer_status()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $appointment_id     = $_POST['appointment_id'];
        $customer_status    = $_POST['customer_status'];

        $appointment = get_wc_appointment($appointment_id);
        $appointment->update_customer_status($customer_status);

        // Status Update Notification
        $user_id   = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        $shop_name = get_user_by('ID', $user_id)->display_name;
        if ( wcfm_is_vendor() ) {
            $shop_name = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_by_vendor(absint($user_id));
        }
        // translators: 1) appointment url 2) customer status 3) shop name
        $wcfm_messages = sprintf(__('<b>%1$s</b> customer status updated to <b>%2$s</b> by <b>%3$s</b>', 'wc-frontend-manager-ultimate'), '#<a target="_blank" class="wcfm_dashboard_item_title" href="' . get_wcfm_view_appointment_url($appointment_id) . '">' . $appointment_id . '</a>', ucfirst($customer_status), $shop_name);

        $raw_message = [
            'l10n'	=> [
                'text' 		=> '<b>%1$s</b> customer status updated to <b>%2$s</b> by <b>%3$s</b>',
                'domain'    => 'wc-frontend-manager-ultimate',
                'wrapper'	=> [
                    'function' 	=> 'sprintf',
                    'args' 		=> [
                        '#<a target="_blank" class="wcfm_dashboard_item_title" href="' . get_wcfm_view_appointment_url($appointment_id) . '">' . $appointment_id . '</a>', 
                        ucfirst($customer_status), 
                        $shop_name
                    ]
                ]
            ]
        ];

        $WCFM->wcfm_notification->wcfm_send_direct_message(-2, 0, 1, 0, $wcfm_messages, 'status-update', true, $raw_message);

        echo '{"status": true, "message": "' . __('Customer status updated.', 'wc-frontend-manager-ultimate') . '"}';
        die;
    }

    function wcfm_manual_appointment_props( $new_appointment )
    {
        if ( wcfm_is_vendor() ) {
            $customer_id = $new_appointment->get_customer_id();
            $vendor_id   = apply_filters('wcfm_current_vendor_id', get_current_user_id());
            if ( $vendor_id == $customer_id ) {
                $new_appointment->set_customer_id(0);
            }
        }
        return $new_appointment;
    }

    /**
     * WCfM dashboard profile Google Calendar sync option
     */
    function wcfm_appointment_gcal_user_profile()
    {
        global $WCFM, $WCFMu;

        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        $user_id = get_current_user_id();

        // Calendar ID.
        $calendar_id = ( $calendar_id = get_user_meta($user_id, 'wc_appointments_gcal_calendar_id', true) ) ? $calendar_id : '';

        // Run Gcal oauth redirect.
        $gcal_integration_class = wc_appointments_integration_gcal();
        $gcal_integration_class->set_user_id($user_id);

        // Get access token.
        $access_token  = $gcal_integration_class->get_access_token();
        $client_id     = $gcal_integration_class->get_client_id();
        $client_secret = $gcal_integration_class->get_client_secret();
        $get_calendars = $gcal_integration_class->get_calendars();

        // Calendar ID.
        $calendar_id = get_user_meta($user_id, 'wc_appointments_gcal_calendar_id', true);
        $calendar_id = $calendar_id ? $calendar_id : '';

        // Two way sync.
        $two_way = get_user_meta($user_id, 'wc_appointments_gcal_twoway', true);
        $two_way = 'one_way' !== $two_way ? 'two_way' : 'one_way';
        if ( 'two_way' === $two_way ) {
            $gcal_integration_class->set_twoway('two_way');
        }
        ?>
        <div class="page_collapsible wcfm_profile_manage_apt_gcal_sync" id="sm_profile_form_gcal_sync"><label class="wcfmfa fa-calendar"></label><?php _e('Google Calendar Sync', 'wc-frontend-manager-ultimate'); ?><span></span></div>
        <div class="wcfm-container">
            <div id="wcfm_profile_manage_form_apt_gcal_sync_expander" class="wcfm-content">
                <table>
                    <tr>
                        <th><span class="wcfm_title" style="width:100%"><strong><?php _e('Authorization', 'woocommerce-appointments'); ?></strong></span></th>
                        <td>
                            <?php if ( ! $access_token && $client_id && $client_secret ) : ?>
                                <button type="button" class="button wcfm_oauth_redirect" data-staff="<?php echo esc_attr(absint($user_id)); ?>" data-logout="0"><?php _e('Connect with Google', 'woocommerce-appointments'); ?></button>
                            <?php elseif ( $access_token ) : ?>
                                <p style="color:green;"><?php _e('Successfully authenticated.', 'woocommerce-appointments'); ?></p>
        
                                <p class="submit">
                                    <button type="button" class="button wcfm_oauth_redirect" data-staff="<?php echo esc_attr(absint($user_id)); ?>" data-logout="1"><?php _e('Disconnect', 'woocommerce-appointments'); ?></button>
                                </p>
                            <?php else : ?>
                                <p><?php printf(__('Please configure <a class="wcfm_dashboard_item_title" href="%s">Google Calendar Sync settings</a> first.', 'woocommerce-appointments'), admin_url('admin.php?page=wc-settings&tab=appointments&section=gcal')); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if ( $access_token ) : ?>
                        <tr>
                            <th><span class="wcfm_title" style="width:100%"><strong><?php _e('Calendar ID', 'woocommerce-appointments'); ?></strong></span></th>
                            <td>
                                <?php if ( $get_calendars ) : ?>
                                    <select id="wc_appointments_gcal_calendar_id" name="wc_appointments_gcal_calendar_id" class="wcfm-select wc-enhanced-select" style="width:25em;">
                                        <option value=""><?php esc_html_e('N/A', 'woocommerce-appointments'); ?></option>
                                        <?php
                                        foreach ( $get_calendars as $cal_id => $cal_name ) {
                                            ?>
                                            <option value="<?php echo esc_attr($cal_id); ?>" <?php selected($calendar_id, $cal_id); ?>><?php echo esc_attr($cal_name); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                <?php else : ?>
                                    <input type="text" class="regular-text" name="wc_appointments_gcal_calendar_id" id="wc_appointments_gcal_calendar_id" value="<?php echo esc_attr($calendar_id); ?>">
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th><span class="wcfm_title" style="width:100%"><strong><?php esc_html_e('Sync Preference', 'woocommerce-appointments'); ?></strong></span></th>
                            <td>
                                <select id="wc_appointments_gcal_twoway" name="wc_appointments_gcal_twoway" class="wcfm-select wc-enhanced-select">
                                    <option value="one_way" <?php selected($two_way, 'one_way'); ?>><?php esc_html_e('One way - from Store to Google', 'woocommerce-appointments'); ?></option>
                                    <option value="two_way" <?php selected($two_way, 'two_way'); ?>><?php esc_html_e('Two way - between Store and Google', 'woocommerce-appointments'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <?php if ( $calendar_id && 'two_way' === $two_way ) : ?>
                            <tr>
                                <th><label><?php esc_html_e('Last Sync', 'woocommerce-appointments'); ?></label></th>
                                <td>
                                    <?php
                                    $last_synced = get_user_meta($user_id, 'wc_appointments_gcal_availability_last_synced', true);
                                    $last_synced = $last_synced ? $last_synced : '';
                                    if ( $last_synced ) {
                                        $ls_timestamp = isset($last_synced[0]) && $last_synced[0] ? absint($last_synced[0]) : absint(current_time('timestamp'));
                                        /* translators: 1: date format, 2: time format */
                                        $ls_message = sprintf(__('%1$s, %2$s', 'woocommerce-appointments'), date_i18n(wc_date_format(), $ls_timestamp), date_i18n(wc_time_format(), $ls_timestamp));
                                        ?>
                                        <p class="last_synced"><?php echo esc_attr($ls_message); ?></p>
                                    <?php } else { ?>
                                        <p class="last_synced"><?php esc_html_e('Not synced yet.', 'woocommerce-appointments'); ?></p>
                                    <?php } ?>
                                    <p class="submit">
                                        <button type="button" class="button wcfm_manual_sync" data-staff="<?php echo esc_attr(absint($user_id)); ?>"><?php esc_html_e('Sync Manually', 'woocommerce-appointments'); ?></button>
                                    </p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        <?php
        wp_register_script('wc_appointments_writepanel_js', WC_APPOINTMENTS_PLUGIN_URL . '/assets/js/writepanel' . $suffix . '.js', array( 'jquery', 'jquery-ui-datepicker' ), WC_APPOINTMENTS_VERSION, true);
        wp_enqueue_script('wc_appointments_writepanel_js');
        $params = array(
            'i18n_remove_staff'         => esc_js(__('Are you sure you want to remove this staff?', 'woocommerce-appointments')),
            'i18n_remove_staff_product' => esc_js(__('Are you sure you want to remove staff from this product?', 'woocommerce-appointments')),
            'nonce_delete_staff'        => wp_create_nonce('delete-appointable-staff'),
            'nonce_add_staff'           => wp_create_nonce('add-appointable-staff'),
            'nonce_add_product'         => wp_create_nonce('add-staff-product'),
            'nonce_staff_html'          => wp_create_nonce('appointable-staff-html'),
            'nonce_manual_sync'         => wp_create_nonce('add-manual-sync'),
            'nonce_oauth_redirect'      => wp_create_nonce('add-oauth-redirect'),

            'i18n_minutes'              => esc_js(__('minutes', 'woocommerce-appointments')),
            'i18n_hours'                => esc_js(__('hours', 'woocommerce-appointments')),
            'i18n_days'                 => esc_js(__('days', 'woocommerce-appointments')),

            'post'                      => get_the_ID(),
            'plugin_url'                => WC()->plugin_url(),
            'ajax_url'                  => admin_url('admin-ajax.php'),
            'fistday'                   => absint(get_option('start_of_week', 1)),
            'calendar_image'            => WC()->plugin_url() . '/assets/images/calendar.png',
            
            'exporter'                  => [
				'string'     => esc_js( __( 'Export', 'woocommerce-appointments' ) ),
				'url'        => esc_url_raw( admin_url( 'edit.php?post_type=wc_appointment&page=appointment_exporter' ) ),
				'permission' => current_user_can( 'export' ) ? true : false,
			],
        );

        wp_localize_script('wc_appointments_writepanel_js', 'wc_appointments_writepanel_js_params', $params);
    }

    function wcfm_appointment_gcal_user_profile_update( $user_id, $wcfm_profile_form )
    {

        if ( isset($wcfm_profile_form['wc_appointments_gcal_calendar_id']) && ! empty($wcfm_profile_form['wc_appointments_gcal_calendar_id']) ) {
            update_user_meta($user_id, 'wc_appointments_gcal_calendar_id', $wcfm_profile_form['wc_appointments_gcal_calendar_id']);

            $two_way = isset($wcfm_profile_form['wc_appointments_gcal_twoway']) ? $wcfm_profile_form['wc_appointments_gcal_twoway'] : 'one_way';
            update_user_meta($user_id, 'wc_appointments_gcal_twoway', $two_way);

            // Schedule incremental sync each hour.
            if ( ! wp_next_scheduled('wc-appointment-sync-from-gcal', array( $user_id )) ) {
                wp_clear_scheduled_hook('wc-appointment-sync-from-gcal', array( $user_id ));
                wp_schedule_event(time(), apply_filters('woocommerce_appointments_sync_from_gcal', 'hourly'), 'wc-appointment-sync-from-gcal', array( $user_id ));
            }
        } else {
            delete_user_meta($user_id, 'wc_appointments_gcal_calendar_id');
            delete_user_meta($user_id, 'wc_appointments_gcal_twoway');
            delete_user_meta($user_id, 'wc_appointments_gcal_availability');
            delete_user_meta($user_id, 'wc_appointments_gcal_availability_last_synced');
            wp_clear_scheduled_hook('wc-appointment-sync-from-gcal', array( $user_id ));
        }
    }

    /**
     * Add vendor email to appointment admin emails - 2.6.2
     */
    public function wcfm_filter_appointment_emails( $recipients, $this_email )
    {
        global $WCFM, $WCFMu;

        if ( ! empty($this_email) ) {
            if ( $WCFMu->is_marketplace ) {

                $vendor_email = $WCFM->wcfm_vendor_support->wcfm_get_vendor_email_from_product($this_email->product_id);
                if ( isset($recipients) ) {
                    $recipients .= ',' . $vendor_email;
                } else {
                    $recipients = $vendor_email;
                }
            }
        }

        return $recipients;
    }

    function wca_wcfm_message_types( $message_types )
    {

        if ( current_user_can('manage_appointments') ) {
            $message_types['appointment'] = __('New Appointment', 'wc-frontend-manager-ultimate');
        }

        return $message_types;
    }

    /**
     * Vendor direct message on new appointment - 3.0.6
     */
    function wcfm_message_on_new_appointment( $appointment_id )
    {
        global $WCFM, $wpdb, $WCFMu;

        if ( is_admin() ) {
            return;
        }

        $author_id        = -2;
        $author_is_admin  = 1;
        $author_is_vendor = 0;
        $message_to       = 0;

        if ( $appointment_id ) {

            $appointment_object = get_wc_appointment($appointment_id);

            if ( ! is_object($appointment_object) ) {
                return;
            }

            if ( $appointment_object->has_status('in-cart') ) {
                // return;
            }

            $product_id = $appointment_object->get_product()->get_id();

            // Admin Notification
            // translators: 1) appointment url 2) appointment title
            $wcfm_messages = sprintf(__('You have received an Appointment <b>#%1$s</b> for <b>%2$s</b>', 'wc-frontend-manager-ultimate'), '<a target="_blank" class="wcfm_dashboard_item_title" href="' . get_wcfm_view_appointment_url($appointment_id) . '">' . $appointment_id . '</a>', $appointment_object->get_product()->get_title());

            $raw_message = [
                'l10n'	=> [
                    'text' 		=> 'You have received an Appointment <b>#%1$s</b> for <b>%2$s</b>',
                    'domain'    => 'wc-frontend-manager-ultimate',
                    'wrapper'	=> [
                        'function' 	=> 'sprintf',
                        'args' 		=> [
                            '<a target="_blank" class="wcfm_dashboard_item_title" href="' . get_wcfm_view_appointment_url($appointment_id) . '">' . $appointment_id . '</a>', 
                            $appointment_object->get_product()->get_title()
                        ]
                    ]
                ]
            ];

            $WCFM->wcfm_notification->wcfm_send_direct_message($author_id, $message_to, $author_is_admin, $author_is_vendor, $wcfm_messages, 'appointment', true, $raw_message);

            // Vendor Notification
            if ( $WCFM->is_marketplace ) {
                $author_id  = -1;
                $message_to = wcfm_get_vendor_id_by_post($product_id);

                if ( $message_to ) {
                    $wcfm_messages = sprintf(__('You have received an Appointment <b>#%1$s</b> for <b>%2$s</b>', 'wc-frontend-manager-ultimate'), '<a target="_blank" class="wcfm_dashboard_item_title" href="' . get_wcfm_view_appointment_url($appointment_id) . '">' . $appointment_id . '</a>', $appointment_object->get_product()->get_title());

                    $raw_message = [
                        'l10n'	=> [
                            'text' 		=> 'You have received an Appointment <b>#%1$s</b> for <b>%2$s</b>',
                            'domain'    => 'wc-frontend-manager-ultimate',
                            'wrapper'	=> [
                                'function' 	=> 'sprintf',
                                'args' 		=> [
                                    '<a target="_blank" class="wcfm_dashboard_item_title" href="' . get_wcfm_view_appointment_url($appointment_id) . '">' . $appointment_id . '</a>', 
                                    $appointment_object->get_product()->get_title()
                                ]
                            ]
                        ]
                    ];

                    $WCFM->wcfm_notification->wcfm_send_direct_message($author_id, $message_to, $author_is_admin, $author_is_vendor, $wcfm_messages, 'appointment', true, $raw_message);

                    // Vendor Google Calendar Sync
                    $gcal_integration_class = wc_appointments_integration_gcal();
                    $gcal_integration_class->set_user_id($message_to);

                    // Get access token.
                    $access_token  = $gcal_integration_class->get_access_token();
                    $client_id     = $gcal_integration_class->get_client_id();
                    $client_secret = $gcal_integration_class->get_client_secret();
                    $twoway        = $gcal_integration_class->get_twoway();
                    if ( $access_token && $client_id && $client_secret ) {
                        $vendor_calendar_id = ( $calendar_id = get_user_meta($message_to, 'wc_appointments_gcal_calendar_id', true) ) ? $calendar_id : '';
                        if ( $vendor_calendar_id ) {
                            $gcal_integration_class->sync_to_gcal($appointment_id, $message_to, $vendor_calendar_id);
                        }
                    }
                }
            }
        }
    }

    /**
     * WooCommerce Appointment plugin doesn't allow the 'appointments' endpoint
     * So, it must be modified
     *
     * @param String $endpoint
     * @return String $endpoint
     *
     * @TODO: adapt this change in WCFM free plugin later
     */
    function modified_appointment_endpoint_slug( $endpoint )
    {
        if ( $endpoint == 'appointments' ) {
            $endpoint = 'appointmentslist';
        }
        return $endpoint;
    }

    /**
	 * Manually perform calendar sync.
	 */
	public function oauth_redirect() {
		$nonce = $_POST['security'];

		if ( empty( $_POST ) || ! wp_verify_nonce( $nonce, 'add-oauth-redirect' ) ) {
		    wp_send_json(
				[
					'error' => __( 'Reload the page and try again.', 'woocommerce-appointments' ),
				]
			);
		}

		check_ajax_referer( 'add-oauth-redirect', 'security' );

		$user_id = isset( $_POST['staff_id'] ) ? absint( $_POST['staff_id'] ) : '';
		$logout  = isset( $_POST['logout'] ) && $_POST['logout'] ? true : false;

		if ( $user_id ) {
			// Run Gcal oauth redirect.
			$gcal_integration_class = wc_appointments_integration_gcal();
			$gcal_integration_class->set_user_id( $user_id );

			$oauth_url = add_query_arg(
				[
					'scope'           => $gcal_integration_class->api_scope,
					'redirect_uri'    => $gcal_integration_class->get_redirect_uri(),
					'response_type'   => 'code',
					'client_id'       => $gcal_integration_class->get_client_id(),
					'approval_prompt' => 'force',
					'access_type'     => 'offline',
					'state'           => $user_id,
				],
				$gcal_integration_class->oauth_uri . 'auth'
			);

			// Logout.
			if ( $logout ) {
				$oauth_url = add_query_arg(
					[
						'logout' => 'true',
						'state'  => $user_id,
					],
					$gcal_integration_class->get_redirect_uri()
				);
			// Run GCal sync for the first time.
			} else {
				$gcal_integration_class->sync_from_gcal( $user_id );
			}
		} else {
			// Run Gcal oauth redirect.
			$gcal_integration_class = wc_appointments_integration_gcal();

			$oauth_url = add_query_arg(
				[
					'scope'           => $gcal_integration_class->api_scope,
					'redirect_uri'    => $gcal_integration_class->get_redirect_uri(),
					'response_type'   => 'code',
					'client_id'       => $gcal_integration_class->get_client_id(),
					'approval_prompt' => 'force',
					'access_type'     => 'offline',
				],
				$gcal_integration_class->oauth_uri . 'auth'
			);

			// Logout.
			if ( $logout ) {
				$oauth_url = add_query_arg(
					[
						'logout' => 'true',
					],
					$gcal_integration_class->get_redirect_uri()
				);
			// Run GCal sync for the first time.
			} else {
				$gcal_integration_class->sync_from_gcal();
			}
		}

		wp_send_json(
			[
				'result' => 'SUCCESS',
				'uri'    => $oauth_url,
			]
		);

		die();
	}

    /**
	 * Manually perform calendar sync.
	 */
	public function manual_sync() {
		$nonce = $_POST['security'];

		if ( empty( $_POST ) || ! wp_verify_nonce( $nonce, 'add-manual-sync' ) ) {
		    wp_send_json(
				[
					'error' => __( 'Reload the page and try again.', 'woocommerce-appointments' ),
				]
			);
		}

		check_ajax_referer( 'add-manual-sync', 'security' );

		$user_id = isset( $_POST['staff_id'] ) ? absint( $_POST['staff_id'] ) : '';
		$counter = false;

		if ( $user_id ) {

			// Run GCal sync manually.
			$gcal_integration_class = wc_appointments_integration_gcal();
			$gcal_integration_class->set_user_id( $user_id );
			$gcal_integration_class->sync_from_gcal( $user_id );
			$last_synced_saved     = get_user_meta( $user_id, 'wc_appointments_gcal_availability_last_synced', true );
			$last_synced_timestamp = isset( $last_synced_saved[0] ) && $last_synced_saved[0] ? absint( $last_synced_saved[0] ) : absint( current_time( 'timestamp' ) );
			$last_synced_counter   = isset( $last_synced_saved[1] ) && $last_synced_saved[1] ? absint( $last_synced_saved[1] ) : 0;

			// Update last synced timestamp.
			$last_synced[] = absint( current_time( 'timestamp' ) );
			$last_synced[] = $last_synced_counter;
			update_user_meta( $user_id, 'wc_appointments_gcal_availability_last_synced', $last_synced );

		} else {

			// Run GCal sync manually.
			$gcal_integration_class = wc_appointments_integration_gcal();
			$gcal_integration_class->sync_from_gcal();
			$last_synced_saved     = get_option( 'wc_appointments_gcal_availability_last_synced' );
			$last_synced_timestamp = isset( $last_synced_saved[0] ) && $last_synced_saved[0] ? absint( $last_synced_saved[0] ) : absint( current_time( 'timestamp' ) );
			$last_synced_counter   = isset( $last_synced_saved[1] ) && $last_synced_saved[1] ? absint( $last_synced_saved[1] ) : 0;

			// Update last synced timestamp.
			$last_synced[] = absint( current_time( 'timestamp' ) );
			$last_synced[] = $last_synced_counter;
			update_option( 'wc_appointments_gcal_availability_last_synced', $last_synced );

		}

		// Last sycned event count, date, time.
		/* translators: %1$s: date format, %2$s: time format */
		$ls_message  = sprintf( __( '%1$s, %2$s', 'woocommerce-appointments' ), date_i18n( wc_appointments_date_format(), $last_synced_timestamp ), date_i18n( wc_appointments_time_format(), $last_synced_timestamp ) );
		$ls_message .= ' - ';
		if ( $user_id ) {
			/* translators: %1$s: link to staff rules, %2$s: sync text */
			$ls_message .= sprintf( '<a href="%1$s" onclick="location.reload()">%2$s</a>', esc_url( admin_url( "user-edit.php?user_id=$user_id#staff-details" ) ), __( 'check synced events', 'woocommerce-appointments' ) );
		} else {
			/* translators: %1$s: link to global rules, %2$s: sync text */
			$ls_message .= sprintf( '<a href="%1$s">%2$s</a>', esc_url( admin_url( 'admin.php?page=wc-settings&tab=appointments&view=synced' ) ), __( 'check synced events', 'woocommerce-appointments' ) );
		}

		wp_send_json(
			[
				'result' => 'SUCCESS',
				'html'   => $ls_message,
			]
		);

		die();
	}

    public function woocommerce_appointments_get_vendor_availabilities( $availabilities ) {
        global $wp;
        
        if( isset( $wp->query_vars ) && !isset( $wp->query_vars['wcfm-appointments-calendar'] ) ) return $availabilities;

        if( ! is_admin() && is_user_logged_in() ) {
            $user_id = get_current_user_id();
            
            if( wcfm_is_vendor( $user_id ) ) {
                if (is_callable([ 'WC_Appointments_Cache', 'clear_cache' ])) {
                    WC_Appointments_Cache::clear_cache();
                }

                $availability_filters = [
                    [
                        'key'     => 'kind',
                        'compare' => '=',
                        'value'   => 'availability#staff',
                    ],
                    [
                        'key'     => 'kind_id',
                        'compare' => '=',
                        'value'   => $user_id,
                    ],
                    [
                        'key'     => 'event_id',
                        'compare' => '!=',
                        'value'   => '',
                    ],
                ];
    
                remove_filter( 'woocommerce_appointments_get_all_availabilities', [ $this, 'woocommerce_appointments_get_vendor_availabilities'] );
                $staff_availabilities = WC_Data_Store::load( WC_Appointments_Availability::DATA_STORE )->get_all( $availability_filters, WC_Appointments_Availability_Data_Store::DEFAULT_MIN_DATE, WC_Appointments_Availability_Data_Store::DEFAULT_MAX_DATE );
                add_filter( 'woocommerce_appointments_get_all_availabilities', [ $this, 'woocommerce_appointments_get_vendor_availabilities'] );
    
                return $staff_availabilities;
            }
        }
    
        return $availabilities;
    }

    public function get_availability_rules( $availability_rules, $for_staff, $product ) {
        $product_id = $product->get_id();
    
        // Check if it is a vendor product
        if( $product_id && $vendor_id = wcfm_get_vendor_id_by_post( $product_id ) ) {

            if (is_callable([ 'WC_Appointments_Cache', 'clear_cache' ])) {
                WC_Appointments_Cache::clear_cache();
            }

            // Resets appointment availability for vendor products
            if( apply_filters( 'wcfm_allow_reset_vendor_appointment_product_availability', true, $product, $availability_rules, $for_staff ) ) {
                // Remove global availability
                $availability_rules = array_filter( $availability_rules, function( $rule ) {
                    return ! ( isset( $rule['level'] ) && 'global' == $rule['level'] );
                } );

                // Re add global availability without admin gcal events
                $global_rules = WC_Appointments_Availability_Data_Store::get_global_availability( false );
                $global_availability = WC_Product_Appointment_Rule_Manager::process_availability_rules( array_reverse( $global_rules ), 'global' );

                $availability_rules = array_merge( 
                    $availability_rules, 
                    $global_availability,
                );

                if( apply_filters( 'wcfm_filter_appointments_availability_rules_by_vendor_gcal_events', true ) ) {
                    // Add vendor availability
                    $vendor_rules = WC_Data_Store::load( WC_Appointments_Availability::DATA_STORE )->get_all_as_array(
                        [
                            [
                                'key'     => 'kind',
                                'compare' => '=',
                                'value'   => 'availability#staff',
                            ],
                            [
                                'key'     => 'kind_id',
                                'compare' => '=',
                                'value'   => $vendor_id,
                            ],
                        ]
                    );
            
                    $vendor_availability = WC_Product_Appointment_Rule_Manager::process_availability_rules( array_reverse( $vendor_rules ), 'global' );

                    $availability_rules = array_merge( 
                        $availability_rules, 
                        $vendor_availability
                    );
                }
            }

            // Filter vendor vacation for appointment
            if( apply_filters( 'wcfm_allow_filter_vendor_appointment_product_for_vacation_mode', true, $product, $availability_rules, $for_staff ) ) {
                $vendor_data = get_user_meta( $vendor_id, 'wcfmmp_profile_settings', true );
                $vacation_mode = isset( $vendor_data['wcfm_vacation_mode'] ) ? $vendor_data['wcfm_vacation_mode'] : 'no';
                $wcfm_vacation_mode_type = isset( $vendor_data['wcfm_vacation_mode_type'] ) ? $vendor_data['wcfm_vacation_mode_type'] : 'instant';
                $wcfm_vacation_start_date = isset( $vendor_data['wcfm_vacation_start_date'] ) ? $vendor_data['wcfm_vacation_start_date'] : '';
                $wcfm_vacation_end_date = isset( $vendor_data['wcfm_vacation_end_date'] ) ? $vendor_data['wcfm_vacation_end_date'] : '';
                if ( $vacation_mode == 'yes' ) {
                    if( $wcfm_vacation_mode_type == 'instant' ) {
                        $vacation_arg = array(
                            'type' => 'days',
                            'range' => array(
                                '1' => false, 
                                '2' => false, 
                                '3' => false, 
                                '4' => false,
                                '5' => false,
                                '6' => false,
                                '7' => false
                            ),
                        );
                    } elseif( $wcfm_vacation_start_date && $wcfm_vacation_end_date ) {
                        $start_time = strtotime( $wcfm_vacation_start_date );
                        $end_time = strtotime( $wcfm_vacation_end_date );
                        $end_time = strtotime( '+1 day', $end_time - 1 );
                        $y = date("Y", $end_time);
                        $m = date("m", $end_time);
                        $d = date("d", $end_time);
                        $range = array();
                        while($start_time < $end_time) {
                            $year = date("Y", $start_time);
                            if(!isset($range[$year])) {
                                $range[$year] = array();
                            }
                            $mon = date("n", $start_time); 
                            if(!isset($range[$year][$mon])) {
                                $range[$year][$mon] = array();
                            }
                            $date = date("j", $start_time);
                            if($y > $year || $m > $mon) {
                                $month_days = date("t", $start_time);
                                $range[$year][$mon] = array_fill($date, $month_days - $date + 1, false);
                                $start_time = strtotime("+1 day", strtotime("{$year}-{$mon}-{$month_days}"));
                            } else {
                                $range[$year][$mon] = array_fill($date+0, $d - $date + 1, '');
                                $start_time = $end_time;
                            }
                        }
                        $vacation_arg = array(
                            'type' => 'custom',
                            'range' => $range,
                        );
                    }

                    if(isset($availability_rules)) {
                        $availability_rules[] = apply_filters( 'wcfm_appointments_availability_rules_by_vendor_vacation', array_merge(
                            $vacation_arg,
                            array(
                                'priority' => 1,
                                'qty' => 0,
                                'level' => 'global',
                                'order' => 0,
                                'kind_id' => $vendor_id,
                            ),
                        ) );
                    }
                }
            }

            usort( $availability_rules, [ $product, 'rule_override_power_sort' ] );
        }

        return $availability_rules;
    }
}
