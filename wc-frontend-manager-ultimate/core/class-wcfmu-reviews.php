<?php
/**
 * WCFM plugin core
 *
 * WCFM Reviews core
 *
 * @author  WC Lovers
 * @package wcfm/core
 * @version 4.0.2
 */

class WCFMu_Reviews
{


    public function __construct()
    {
        global $WCFM, $WCFMu;

        if (WCFM_Dependencies::dokanpro_plugin_active_check()) {
            // WCFM Reviews Query Var Filter - 2.5.3
            add_filter('wcfm_query_vars', [ &$this, 'wcfm_reviews_query_vars' ], 10);
            add_filter('wcfm_endpoint_title', [ &$this, 'wcfm_reviews_endpoint_title' ], 10, 2);
            add_action('init', [ &$this, 'wcfm_reviews_init' ], 120);

            // WCFMu Reviews Load WCFMu Scripts
            add_action('wcfm_load_scripts', [ &$this, 'wcfm_reviews_load_scripts' ], 10);
            add_action('after_wcfm_load_scripts', [ &$this, 'wcfm_reviews_load_scripts' ], 10);

            // WCFMu Reviews Load WCFMu Styles
            add_action('wcfm_load_styles', [ &$this, 'wcfm_reviews_load_styles' ], 10);
            add_action('after_wcfm_load_styles', [ &$this, 'wcfm_reviews_load_styles' ], 10);

            // WCFMu Reviews Load WCFMu views
            add_action('wcfm_load_views', [ &$this, 'wcfm_reviews_load_views' ], 10);

            // WCFMu Reviews Ajax Controller
            add_action('after_wcfm_ajax_controller', [ &$this, 'wcfm_reviews_ajax_controller' ]);

            // Reviews menu on WCfM dashboard
            if (apply_filters('wcfm_is_allow_reviews', true)) {
                add_filter('wcfm_menus', [ &$this, 'wcfm_reviews_menus' ], 30);
            }

            // Reviews Status Update
            add_action('wp_ajax_wcfmu_reviews_status_update', [ &$this, 'wcfmu_reviews_status_update' ]);
        }//end if

    }//end __construct()


    /**
     * WCMp Query Var
     */
    function wcfm_reviews_query_vars($query_vars)
    {
        $wcfm_modified_endpoints = wcfm_get_option('wcfm_endpoints', []);

        $query_wcmp_vars = [
            // 'wcfm-payments'        => ! empty( $wcfm_modified_endpoints['wcfm-payments'] ) ? $wcfm_modified_endpoints['wcfm-payments'] : 'wcfm-payments',
            'wcfm-reviews' => ! empty($wcfm_modified_endpoints['wcfm-reviews']) ? $wcfm_modified_endpoints['wcfm-reviews'] : 'reviews',
        ];
        $query_vars      = array_merge($query_vars, $query_wcmp_vars);

        return $query_vars;

    }//end wcfm_reviews_query_vars()


    /**
     * WCMp End Point Title
     */
    function wcfm_reviews_endpoint_title($title, $endpoint)
    {
        switch ($endpoint) {
            // case 'wcfm-payments' :
                // $title = __( 'Payments History', 'wc-frontend-manager-ultimate' );
            // break;
            case 'wcfm-reviews':
                $title = __('Reviews', 'wc-frontend-manager-ultimate');
                break;
        }

        return $title;

    }//end wcfm_reviews_endpoint_title()


    /**
     * WCMp Endpoint Intialize
     */
    function wcfm_reviews_init()
    {
        global $WCFM_Query;

        // Intialize WCFM End points
        $WCFM_Query->init_query_vars();
        $WCFM_Query->add_endpoints();

        // if( !get_option( 'wcfm_updated_end_point_payment' ) ) {
            // Flush rules after endpoint update
            flush_rewrite_rules();
            update_option('wcfm_updated_end_point_reviews', 1);
        // }

    }//end wcfm_reviews_init()


    /**
     * WCFM Reviews Menu
     */
    function wcfm_reviews_menus($menus)
    {
        global $WCFM;

        $menus = (array_slice($menus, 0, 3, true) + [
            'wcfm-reviews' => [
                'label'    => __('Reviews', 'wc-frontend-manager-ultimate'),
                'url'      => wcfm_reviews_url(),
                'icon'     => 'comment-alt',
                'priority' => 69,
            ],
        ] + array_slice($menus, 3, (count($menus) - 3), true));
        return $menus;

    }//end wcfm_reviews_menus()


    /**
     * WCFM Scripts
     */
    public function wcfm_reviews_load_scripts($end_point)
    {
        global $WCFM, $WCFMu;

        switch ($end_point) {
            case 'wcfm-reviews':
                $WCFM->library->load_datatable_lib();
                // $WCFM->library->load_datatable_download_lib();
                if ($WCFM->is_marketplace == 'wcmarketplace') {
                    // wp_enqueue_script( 'wcfmu_wcmp_reviews_js', $WCFMu->library->js_lib_url . 'reviews/wcmp/wcfmu-script-reviews.js', array('jquery'), $WCFM->version, true );
                } else if ($WCFM->is_marketplace == 'dokan') {
                    wp_enqueue_script('wcfmu_dokan_reviews_js', $WCFMu->library->js_lib_url.'reviews/dokan/wcfmu-script-reviews.js', [ 'jquery' ], $WCFMu->version, true);
                }
                break;
        }

    }//end wcfm_reviews_load_scripts()


    /**
     * WCMp Styles
     */
    public function wcfm_reviews_load_styles($end_point)
    {
        global $WCFM, $WCFMu;

        switch ($end_point) {
            case 'wcfm-reviews':
                if ($WCFM->is_marketplace == 'wcmarketplace') {
                    // wp_enqueue_style( 'wcfm_wcmp_reviews_css',  $WCFMu->library->css_lib_url . 'reviews/wcmp/wcfmu-style-reviews.css', array(), $WCFM->version );
                } else if ($WCFM->is_marketplace == 'dokan') {
                    wp_enqueue_style('collapsible_css', $WCFM->library->css_lib_url.'wcfm-style-collapsible.css', [], $WCFM->version);
                    wp_enqueue_style('wcfm_wcmp_reviews_css', $WCFMu->library->css_lib_url.'reviews/dokan/wcfmu-style-reviews.css', [], $WCFMu->version);
                }
                break;
        }

    }//end wcfm_reviews_load_styles()


    /**
     * WCMp Views
     */
    public function wcfm_reviews_load_views($end_point)
    {
        global $WCFM, $WCFMu;

        switch ($end_point) {
            case 'wcfm-reviews':
                if ($WCFM->is_marketplace == 'wcmarketplace') {
                    // include_once( $WCFM->library->views_path . 'reviews/wcmp/wcfmu-view-reviews.php' );
                } else if ($WCFM->is_marketplace == 'dokan') {
                    $WCFMu->template->get_template('reviews/dokan/wcfmu-view-reviews.php');
                }
                break;
        }

    }//end wcfm_reviews_load_views()


    /**
     * WCMp Ajax Controllers
     */
    public function wcfm_reviews_ajax_controller()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
			wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $controllers_path = $WCFMu->plugin_path.'controllers/reviews/';

        $controller = '';
        if (isset($_POST['controller'])) {
            $controller = $_POST['controller'];
            switch ($controller) {
                case 'wcfm-reviews':
                    if ($WCFM->is_marketplace == 'dokan') {
                        include_once $controllers_path.'dokan/wcfmu-controller-reviews.php';
                        new WCFM_Reviews_Controller();
                    }
                    break;
            }
        }

    }//end wcfm_reviews_ajax_controller()


    /**
     * reviews Status Update
     */
    function wcfmu_reviews_status_update()
    {
        global $WCFM, $WCFMu, $_POST;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $reviewid = $_POST['reviewid'];
        $status   = $_POST['status'];

        if ($reviewid) {
            if ($status == 'delete') {
                wp_delete_comment($reviewid);
            }

            wp_set_comment_status($reviewid, $status);

            $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
            $cache_key = 'dokan-count-comments-product-'.$vendor_id;
            wp_cache_delete($cache_key, 'dokan');
        }

        echo 'success';
        die;

    }//end wcfmu_reviews_status_update()


}//end class
