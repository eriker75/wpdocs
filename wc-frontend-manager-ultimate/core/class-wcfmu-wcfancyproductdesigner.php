<?php

/**
 * WCFM plugin core
 *
 * Appointments WC Fancy Product Designer Support
 *
 * @author      WC Lovers
 * @package     wcfm/core
 * @version   5.5.0
 */

class WCFMu_WCFanyProductDesigner
{

    const REACT_NO_CONFLICT_JS = 'window.lodash = _.noConflict(); window.underscore = _.noConflict();';

    public function __construct()
    {
        if ( apply_filters('wcfm_is_pref_fancy_product_designer', true) && apply_filters('wcfm_is_allow_fancy_product_designer', true) ) {
            if ( WCFMu_Dependencies::wcfm_wc_fancy_product_designer_active_check() ) {
                // WCFM Appointments Query Var Filter
                add_filter('wcfm_query_vars', array( &$this, 'wcfpd_wcfm_query_vars' ), 90);
                add_filter('wcfm_endpoint_title', array( &$this, 'wcfpd_wcfm_endpoint_title' ), 90, 2);
                add_action('init', array( &$this, 'wcfpd_wcfm_init' ), 90);

                // WCFM Appointments Endpoint Edit
                add_filter('wcfm_endpoints_slug', array( $this, 'wcfpd_wcfm_endpoints_slug' ));

                // WCFM Menu Filter
                add_filter('wcfm_menus', array( &$this, 'wcfpd_wcfm_menus' ), 90);

                // Appointments Load WCFMu Scripts
                add_action('after_wcfm_load_scripts', array( &$this, 'wcfpd_load_scripts' ), 90);

                // Appointments Load WCFMu Styles
                add_action('after_wcfm_load_styles', array( &$this, 'wcfpd_load_styles' ), 90);

                // Appointments Load WCFMu views
                add_action('wcfm_load_views', array( &$this, 'wcfpd_load_views' ), 90);

                // Appointments Ajax Controllers
                add_action('after_wcfm_ajax_controller', array( &$this, 'wcfpd_ajax_controller' ));

                // Appointments General Block
                add_action('end_wcfm_products_manage', array( &$this, 'wcfpd_product_manage_general' ), 90);

                // Order Details Fancy View
                add_action('end_wcfm_orders_details', array( &$this, 'wcfpd_orders_details_load_views' ), 18);

                // Vendor wise product filter
                add_filter('fpd_get_products_sql_attrs', array( &$this, 'wcfpd_get_products_sql_attrs' ));
                add_filter('fpd_get_categories_sql_attrs', array( &$this, 'wcfpd_get_categories_sql_attrs' ));
            }
        }
    }

    /**
     * WC Appointments Query Var
     */
    function wcfpd_wcfm_query_vars( $query_vars )
    {
        $wcfm_modified_endpoints = wcfm_get_option('wcfm_endpoints', array());

        $query_appointments_vars = array(
            'wcfm-fncy-product-designer' => ! empty($wcfm_modified_endpoints['wcfm-fncy-product-designer']) ? $wcfm_modified_endpoints['wcfm-fncy-product-designer'] : 'fncy-product-designer',
            'wcfm-fncy-product-builder'  => ! empty($wcfm_modified_endpoints['wcfm-fncy-product-builder']) ? $wcfm_modified_endpoints['wcfm-fncy-product-builder'] : 'fncy-product-builder',
        );

        $query_vars = array_merge($query_vars, $query_appointments_vars);

        return $query_vars;
    }

    /**
     * WC Fancy Product Designer End Point Title
     * 
     * @param string $title
     * @param string $endpoint
     * @return string $title
     */
    function wcfpd_wcfm_endpoint_title( $title, $endpoint )
    {
        switch ( $endpoint ) {
            case 'wcfm-fncy-product-designer':
                $title = __('Product Designer', 'wc-frontend-manager-ultimate');
                break;
            case 'wcfm-fncy-product-builder':
                $title = __('Product Builder', 'wc-frontend-manager-ultimate');
                break;
        }

        return $title;
    }

    /**
     * WC Fancy Product Designer Endpoint Intialize
     */
    function wcfpd_wcfm_init()
    {
        global $WCFM_Query;

        // Intialize WCFM End points
        $WCFM_Query->init_query_vars();
        $WCFM_Query->add_endpoints();

        if ( ! get_option('wcfm_updated_end_point_wc_fancyproductdesigner') ) {
            // Flush rules after endpoint update
            flush_rewrite_rules();
            update_option('wcfm_updated_end_point_wc_fancyproductdesigner', 1);
        }

        /**
         * Add fancy product designer capability for vendor
         */
        $role = get_role( 'wcfm_vendor' );
        if( ! $role->has_cap( Fancy_Product_Designer::CAPABILITY ) ) {
            $role->add_cap( Fancy_Product_Designer::CAPABILITY );
        }
    }

    /**
     * WC Fancy Product Designer Endpoint Edit
     */
    function wcfpd_wcfm_endpoints_slug( $endpoints )
    {

        $appointment_endpoints = array(
            'wcfm-fncy-product-designer' => 'fncy-product-designer',
            'wcfm-fncy-product-builder'  => 'fncy-product-builder',
        );

        $endpoints = array_merge($endpoints, $appointment_endpoints);

        return $endpoints;
    }

    /**
     * WC Fancy Product Designer Menu
     * 
     * @param array $menus
     * @return array $menus
     */
    function wcfpd_wcfm_menus( $menus )
    {
        $menus = array_slice($menus, 0, 3, true) +
            array(
                'wcfm-fncy-product-designer' => array(
                    'label' => __('Product Designer', 'wc-frontend-manager-ultimate'),
                    'url'      => get_wcfm_fncy_product_designer_url(),
                    'icon'     => 'object-group',
                    'priority' => 20,
                ),
            ) +
            array_slice($menus, 3, count($menus) - 3, true);

        return $menus;
    }

    /**
     * WC Fancy Product Designer Scripts
     */
    public function wcfpd_load_scripts( $end_point )
    {
        global $WCFM, $WCFMu, $wp;

        $fpd_admin_opts = array(
            'adminAjaxUrl'        => admin_url('admin-ajax.php'),
            'ajaxNonce'           => wp_create_nonce('fpd_ajax_nonce'),
            // 'ajaxNonce' => FPD_Admin::$ajax_nonce,
            'adminUrl'            => admin_url(),
            'localTest'           => Fancy_Product_Designer::LOCAL,
            'enterTitlePrompt'    => __('Please enter a title!', 'radykal'),
            'tryAgain'            => __('Something went wrong. Please try again!', 'radykal'),
            'addToLibrary'        => __('Add imported image source to media library?', 'radykal'),
            'remove'              => __('Do you really want to delete the item?', 'radykal'),
            'chooseThumbnail'     => __('Choose Thumbnail', 'radykal'),
            'dialogCancel'        => __('Cancel', 'radykal'),
            'dialogAlertButton'   => __('Got It', 'radykal'),
            'dialogConfirmButton' => __('Yes', 'radykal'),
            'dialogConfirmCancel' => __('No', 'radykal'),
            'dialogPromptButton'  => __('Okay', 'radykal'),
        );

        switch ( $end_point ) {
            case 'wcfm-products-manage':
                wp_enqueue_script('wp-color-picker');
                wp_enqueue_script('radykal-admin');
                wp_enqueue_script('fpd-admin');
                wp_enqueue_script('fpd-semantic-ui');
                wp_enqueue_script('radykal-select-sortable');

                wp_localize_script('fpd-admin', 'fpd_admin_opts', $fpd_admin_opts);

                // wp_enqueue_script( 'wcfmu_wc_appointments_products_manage_js', $WCFMu->library->js_lib_url . 'wc_fncy_product_designer/wcfmu-script-wcappointments-products-manage.js', array( 'jquery' ), $WCFMu->version, true );
                break;

            case 'wcfm-orders-details':
                global $post_id;
                $order_id = 0;
                if ( isset($wp->query_vars['wcfm-orders-details']) && ! empty($wp->query_vars['wcfm-orders-details']) ) {
                    $post_id = $order_id = $wp->query_vars['wcfm-orders-details'];
                }

                require_once FPD_PLUGIN_ADMIN_DIR . '/labels/order-viewer.php';

                wp_localize_script('fpd-admin', 'fpd_admin_opts', $fpd_admin_opts);

                wp_enqueue_script(
                    'wcfm-fpd-react-order-viewer',
                    $WCFMu->library->js_lib_url . 'wc_fncy_product_designer/wcfmu-script-fancy-order-viewer.js',
                    array(
                        'fpd-semantic-ui',
                        'fpd-admin',
                        'jquery-fpd',
                    ),
                    Fancy_Product_Designer::VERSION
                );

                $order_viewer_opts = array(
                    'labels'                  => json_encode(FPD_Labels_Order_Viewer::get_labels()),
                    'templatesDirectory'      => plugins_url('/assets/templates/', FPD_PLUGIN_ROOT_PHP),
                    'printReadyExportEnabled' => class_exists('Fancy_Product_Designer_Export'),
                    'options'                 => array(
                        'enabled_fonts'              => json_decode(FPD_Fonts::to_json(FPD_Fonts::get_enabled_fonts())),
                        'fpd_depositphotosApiKey'    => fpd_get_option('fpd_depositphotosApiKey'),
                        'fpd_depositphotosUsername'  => fpd_get_option('fpd_depositphotosUsername'),
                        'fpd_depositphotosPassword'  => fpd_get_option('fpd_depositphotosPassword'),
                        'fpd_depositphotosImageSize' => fpd_get_option('fpd_depositphotosImageSize'),
                    ),
                );

                wp_localize_script('wcfm-fpd-react-order-viewer', 'fpd_order_viewer_opts', $order_viewer_opts);

                wp_add_inline_script('wcfm-fpd-react-order-viewer', self::REACT_NO_CONFLICT_JS, 'after');

                break;

            case 'wcfm-fncy-product-designer':

                require_once FPD_PLUGIN_ADMIN_DIR . '/labels/products.php';

                wp_enqueue_media();

                wp_localize_script('fpd-admin', 'fpd_admin_opts', $fpd_admin_opts);

                wp_enqueue_script( 'wcfm-fpd-react-products', plugins_url('/admin/react-app/js/products.js', FPD_PLUGIN_ROOT_PHP), array(
					'jquery-ui-core',
					'jquery-ui-mouse',
					'jquery-ui-sortable',
					'jquery-ui-droppable',
					'fpd-semantic-ui',
					'fpd-admin'
				), Fancy_Product_Designer::VERSION );

                wp_add_inline_script('wcfm-fpd-react-products', self::REACT_NO_CONFLICT_JS, 'after');

                wp_localize_script(
                    'wcfm-fpd-react-products',
                    'fpd_fancy_products_opts',
                    array(
                        'labels'            => json_encode(FPD_Labels_Products::get_labels()),
                        'productBuilderUri' => get_wcfm_fncy_product_builder_url(),
                        'currentUserId'     => get_current_user_id(),
                        'dokanUsers'        => wcfm_is_vendor() ? get_users(array( 'fields' => array( 'ID', 'user_nicename' ) )) : null,
                    )
                );

                break;

            case 'wcfm-fncy-product-builder':
                $WCFM->library->load_colorpicker_lib();

                require_once FPD_PLUGIN_ADMIN_DIR . '/labels/product-builder.php';

                wp_enqueue_media();

                wp_localize_script('fpd-admin', 'fpd_admin_opts', $fpd_admin_opts);

                wp_enqueue_script( 'wcfm-fpd-react-product-builder', plugins_url('/admin/react-app/js/product-builder.js', FPD_PLUGIN_ROOT_PHP), array(
                    'jquery-ui-core',
					'jquery-ui-mouse',
					'jquery-ui-sortable',
					'jquery-ui-droppable',
					'fpd-semantic-ui',
					'radykal-select2',
					'fpd-admin',
					'jquery-fpd'
				), Fancy_Product_Designer::VERSION );

                wp_add_inline_script('wcfm-fpd-react-product-builder', self::REACT_NO_CONFLICT_JS, 'after');

                $script_options = FPD_Resource_Options::get_options(array(
					'fpd_common_parameter_originX',
					'fpd_common_parameter_originY',
					'fpd_uploadZonesTopped',
					'fpd_fabricjs_texture_size',
					'fpd_font',
					'enabled_fonts',
					'primary_layout_props',
					'design_categories',
					'plus_enabled',
					'fpd_custom_texts_parameter_maxFontSize',
					'fpd_custom_texts_parameter_patterns',
					'fpd_designs_parameter_patterns',
					'fpd_color_colorPickerPalette'
				));

				$script_options['color_lists'] = array(
					'none' => 'None'
				);

				$color_lists = json_decode( get_option( 'fpd_color_lists', '[]' ), true );

				if( is_array($color_lists) ) {

					foreach($color_lists as $key => $color_list) {
						$script_options['color_lists'][$key] = $color_list['name'];
					}

				}

				$script_options['templates_directory'] = plugins_url('/assets/templates/', FPD_PLUGIN_ROOT_PHP );
				$script_options['products'] = FPD_Resource_Products::get_products( array('limit' => -1) );
				$script_options['adminUrl'] = admin_url();
				$script_options['labels'] = FPD_Labels_Product_Builder::get_labels();

                wp_localize_script('wcfm-fpd-react-product-builder', 'fpd_product_builder_opts', $script_options);

                break;
        }
    }

    /**
     * WC Fany Product Designer Styles
     */
    public function wcfpd_load_styles( $end_point )
    {
        global $WCFM, $WCFMu;

        switch ( $end_point ) {
            case 'wcfm-products-manage':
                wp_enqueue_style('wp-color-picker');
                wp_enqueue_style('radykal-admin');
                wp_enqueue_style('fpd-admin');
                wp_enqueue_style('fpd-semantic-ui');

                wp_enqueue_style(
                    'wcfm-fpd-product-manage',
                    $WCFMu->library->css_lib_url . 'wc_fncy_product_designer/wcfmu-style-fpd-product-manage.css'
                );
                break;

            case 'wcfm-orders-details':
                wp_enqueue_style(
                    'wcfm-fpd-order-viewer',
                    $WCFMu->library->css_lib_url . 'wc_fncy_product_designer/wcfmu-style-fancy-order-viewer.css',
                    array(
                        'fpd-semantic-ui',
                        'jquery-fpd',
                    ),
                    Fancy_Product_Designer::VERSION
                );
                break;

            case 'wcfm-fncy-product-designer':
                wp_enqueue_style(
                    'wcfm-fpd-manage-fancy-products',
                    $WCFMu->library->css_lib_url . 'wc_fncy_product_designer/wcfmu-style-manage-fancy-products-designer.css',
                    array(
                        'fpd-semantic-ui',
                    ),
                    Fancy_Product_Designer::VERSION
                );
                break;

            case 'wcfm-fncy-product-builder':
                wp_enqueue_style(
                    'wcfm-fpd-react-product-builder',
                    $WCFMu->library->css_lib_url . 'wc_fncy_product_designer/wcfmu-style-manage-fancy-products-builder.css',
                    array(
                        'radykal-select2',
                        'jquery-fpd',
                        'fpd-semantic-ui'
                    ),
                    Fancy_Product_Designer::VERSION
                );
                break;
        }
    }

    /**
     * WC Fany Product Designer Views
     */
    public function wcfpd_load_views( $end_point )
    {
        global $WCFM, $WCFMu;

        switch ( $end_point ) {
            case 'wcfm-fncy-product-designer':
                $WCFMu->template->get_template('wc_fncy_product_designer/wcfmu-view-fncy-product-designer.php');
                break;

            case 'wcfm-fncy-product-builder':
                $WCFMu->template->get_template('wc_fncy_product_designer/wcfmu-view-fncy-product-builder.php');
                break;
        }
    }

    /**
     * WC Fany Product Designer Ajax Controllers
     */
    public function wcfpd_ajax_controller()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
			wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $controllers_path = $WCFMu->plugin_path . 'controllers/wc_fncy_product_designer/';

        $controller = '';
        if ( isset($_POST['controller']) ) {
            $controller = $_POST['controller'];

            switch ( $controller ) {
                case 'wcfm-products-manage':
                    include_once $controllers_path . 'wcfmu-controller-fncy-product-designer.php';
                    new WCFMu_WCFancy_Products_Manage_Controller();
                    break;
            }
        }
    }

    /**
     * WC Fancy Product General Options
     */
    function wcfpd_product_manage_general( $product_id )
    {
        global $WCFM, $WCFMu;

        include_once $WCFMu->library->views_path . 'wc_fncy_product_designer/wcfmu-view-fancy-products-manage.php';
    }

    public function wcfpd_orders_details_load_views()
    {
        global $WCFMu;

        $WCFMu->template->get_template('wc_fncy_product_designer/wcfmu-view-fancy-order-viewer.php');
    }

    public function wcfpd_get_products_sql_attrs( $attrs )
    {

        $where = isset($attrs['where']) ? $attrs['where'] : null;

        if ( wcfm_is_vendor() ) {

            $user_ids = array( get_current_user_id() );

            // add fpd products from user
            /*
            $fpd_products_user_id = fpd_get_option( 'fpd_wc_dokan_user_global_products' );

            //skip if no use is set or on product builder
            if( $fpd_products_user_id !== 'none' && !(isset( $_GET['page'] ) && $_GET['page'] === 'fpd_product_builder') )
                array_push( $user_ids, $fpd_products_user_id );*/

            $user_ids = join(',', $user_ids);

            $where = empty($where) ? "user_id IN ($user_ids)" : $where . " AND user_id IN ($user_ids)";

        }

        // manage products filter
        if ( isset($_POST['fpd_filter_users_select']) && $_POST['fpd_filter_users_select'] != '-1' ) {
            $where = 'user_id=' . $_POST['fpd_filter_users_select'];
        }

        $attrs['where'] = $where;

        return $attrs;

    }

    public function wcfpd_get_categories_sql_attrs( $attrs )
    {

        $where = isset($attrs['where']) ? $attrs['where'] : null;

        // only return products created by the current logged-in user
        if ( wcfm_is_vendor() ) {
            $where = empty($where) ? 'user_id=' . get_current_user_id() : $where . ' AND user_id=' . get_current_user_id();
        }

        $attrs['where'] = $where;

        return $attrs;

    }

    public function wcfmfpd_get_product_item_html( $id, $title, $category_ids = '', $thumbnail = '', $user_id = '' )
    {

        if ( ! empty($thumbnail) ) {
            $thumbnail = '<img src="' . $thumbnail . '" />';
        }

        $actions = array(
            'fpd-add-view'             => array(
                'title' => __('Add View', 'radykal'),
                'icon'  => 'fpd-admin-icon-add-box',
            ),
            'fpd-edit-product-title'   => array(
                'title' => __('Edit Title', 'radykal'),
                'icon'  => 'fpd-admin-icon-mode-edit',
            ),
            'fpd-edit-product-options' => array(
                'title' => __('Edit Options', 'radykal'),
                'icon'  => 'fpd-admin-icon-settings',
            ),
            'fpd-export-product'       => array(
                'title' => __('Export', 'radykal'),
                'icon'  => 'fpd-admin-icon-cloud-download',
            ),
            'fpd-save-as-template'     => array(
                'title' => __('Save as template', 'radykal'),
                'icon'  => 'fpd-admin-icon-template',
            ),
            'fpd-duplicate-product'    => array(
                'title' => __('Duplicate', 'radykal'),
                'icon'  => 'fpd-admin-icon-content-copy',
            ),
            'fpd-remove-product'       => array(
                'title' => __('Delete', 'radykal'),
                'icon'  => 'fpd-admin-icon-bin',
            ),
        );

        $actions = apply_filters('fpd_admin_manage_products_product_actions', $actions, $id, $user_id);

        $user_info = get_userdata(intval($user_id));
        $username  = $user_info ? __(' | ', 'radykal') . $user_info->user_nicename : '';

        ob_start();
        ?>
        <li id="<?php echo $id; ?>" data-categories="<?php echo $category_ids; ?>" class="fpd-product-item fpd-clearfix">
            <span class="fpd-clearfix">
                <span class="fpd-single-image-upload fpd-admin-tooltip" title="<?php _e('Product Thumbnail', 'radykal'); ?>">
                    <span class="fpd-remove">
                        <span class="dashicons dashicons-minus"></span>
                    </span>
                    <?php echo $thumbnail; ?>
                </span>
                <span class="fpd-product-meta">
                    <span class="fpd-item-id"># <?php echo $id . $username; ?></span>
                    <span class="fpd-product-title"><?php echo $title; ?></span>
                </span>
            </span>
            <span>
                <?php

                foreach ( $actions as $key => $action ) {
                    echo '<a href="#" class="' . $key . ' fpd-admin-tooltip" title="' . $action['title'] . '"><i class="' . $action['icon'] . '"></i></a>';
                }

                ?>
            </span>
        </li>
          <?php

            $output = ob_get_contents();
            ob_end_clean();

            return $output;

    }

    public function wcfmfpd_get_view_item_html( $id, $image, $title, $user_id = '' )
    {

        $product_builder_url = get_wcfm_fncy_product_builder_url($id);

        $actions = array(
            'fpd-edit-view-layers' => array(
                'title' => __('Edit view in product builder', 'radykal'),
                'icon'  => 'fpd-admin-icon-layers',
                'href'  => esc_attr($product_builder_url),
            ),
            'fpd-edit-view-title'  => array(
                'title' => __('Edit Title', 'radykal'),
                'icon'  => 'fpd-admin-icon-mode-edit',
            ),
            'fpd-duplicate-view'   => array(
                'title' => __('Duplicate', 'radykal'),
                'icon'  => 'fpd-admin-icon-content-copy',
            ),
            'fpd-remove-view'      => array(
                'title' => __('Delete', 'radykal'),
                'icon'  => 'fpd-admin-icon-bin',
            ),
        );

        $actions = apply_filters('fpd_admin_manage_products_view_actions', $actions, $id, $user_id);

        ob_start();
        ?>
        <li id="<?php esc_attr_e($id); ?>" class="fpd-view-item fpd-clearfix">
            <span>
                <img src="<?php esc_attr_e($image); ?>" class="fpd-admin-tooltip" title="<?php _e('View Thumbnail', 'radykal'); ?>" />
                <label><?php esc_html_e($title); ?></label>
            </span>
            <span>
                <?php

                foreach ( $actions as $key => $action ) {

                    $href = isset($action['href']) ? $action['href'] : '#';

                    echo '<a href="' . $href . '" class="' . $key . ' fpd-admin-tooltip" title="' . $action['title'] . '" target="_self"><i class="' . $action['icon'] . '"></i></a>';

                }

                ?>
            </span>
        </li>
        <?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;

    }

    public function wcfmfpd_get_category_item_html( $id, $title )
    {

        $active_filter = '';
        $url_params    = '?page=fancy_product_designer&category_id=' . $id;
        if ( isset($_GET['category_id']) && $_GET['category_id'] === $id ) {
            $active_filter = 'fpd-active';
            $url_params    = '?page=fancy_product_designer';
        }

        return '<li id="' . $id . '" class="fpd-category-item fpd-clearfix"><span><div class="fpd-ad-checkbox"><input type="checkbox" id="fpd_category_' . $id . '" /><label for="fpd_category_' . $id . '">' . $title . '</label></div></span><span><a href="' . $url_params . '" class="fpd-filter-category fpd-admin-tooltip ' . $active_filter . '" title="' . __('Show only products of this category', 'radykal') . '"><i class="fpd-admin-icon-remove-red-eye"></i></a><a href="#" class="fpd-edit-category-title fpd-admin-tooltip" title="' . __('Edit Title', 'radykal') . '"><i class="fpd-admin-icon-mode-edit"></i></a><a href="#" class="fpd-remove-category fpd-admin-tooltip" title="' . __('Delete', 'radykal') . '"><i class="fpd-admin-icon-bin"></i></a></span></li>';

    }

    public function wcfmfpd_get_template_link_html( $template_id, $title )
    {
        return "<li><a href='#' id='" . esc_attr($template_id) . "'>" . $title . "</a><a href='#' class='fpd-remove-template fpd-right'><i class='fpd-admin-icon-close'></i></a></li>";
    }
}
