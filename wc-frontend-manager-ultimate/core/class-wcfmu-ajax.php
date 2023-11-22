<?php
/**
 * WCFMu plugin core
 *
 * Plugin Ajax Controler
 *
 * @author  WC Lovers
 * @package wcfmu/core
 * @version 1.0.0
 */

class WCFMu_Ajax
{

    public $controllers_path;

    public function __construct()
    {
        global $WCFM, $WCFMu;

        $this->controllers_path = $WCFMu->plugin_path.'controllers/';

        add_action('after_wcfm_ajax_controller', [ &$this, 'wcfmu_ajax_controller' ]);

        // Coupon Delete
        add_action('wp_ajax_delete_wcfm_coupon', [ &$this, 'delete_wcfm_coupon' ]);

        // Order Delete
        add_action('wp_ajax_delete_wcfm_order', [ &$this, 'delete_wcfm_order' ]);

        // Auction Bid Delete
        add_action('wp_ajax_delete_wcfm_auction_bid', [ &$this, 'delete_wcfm_auction_bid' ]);

        // Order Add Note
        add_action('wp_ajax_wcfm_add_order_note', [ &$this, 'wcfm_add_order_note' ]);

        // Add Taxonomy Attribute Term
        add_action('wp_ajax_wcfmu_add_attribute_term', [ &$this, 'wcfmu_add_attribute_term' ]);

        // Featured Product - 3.0.1
        add_action('wp_ajax_wcfmu_product_featured', [ &$this, 'wcfmu_product_featured' ]);

        // Generate Duplicate Product - 2.5.2
        add_action('wp_ajax_wcfmu_duplicate_product', [ &$this, 'wcfmu_duplicate_product' ]);
        add_action('woocommerce_product_duplicate', [ &$this, 'wcfmu_duplicate_product_taxonomy' ], 50, 2);

        // Generate Quick Edit Html
        add_action('wp_ajax_wcfmu_quick_edit_html', [ &$this, 'wcfmu_quick_edit_html' ]);

        // Generate Shipment Tracking Html
        add_action('wp_ajax_wcfmu_shipment_tracking_html', [ &$this, 'wcfmu_shipment_tracking_html' ]);

        // Generate Orders Manage Custom Add Html
        add_action('wp_ajax_wcfm_order_add_customer_html', [ &$this, 'wcfm_order_add_customer_html' ]);

        // Generate Screen Manager Html
        add_action('wp_ajax_wcfmu_screen_manager_html', [ &$this, 'wcfmu_screen_manager_html' ]);

        // Product Importer
        add_action('wp_ajax_wcfmu_ajax_product_import', [ &$this, 'wcfmu_ajax_product_import' ]);

    }//end __construct()

    /**
     * WCFM Ultimate Ajax Controllers
     */
    public function wcfmu_ajax_controller()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
			wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $controller = '';
        if (isset($_POST['controller'])) {
            $controller = $_POST['controller'];

            switch ($controller) {
                case 'wc-products':
                case 'wcfm-products':
                    include_once $this->controllers_path.'products/wcfmu-controller-products.php';
                    new WCFMu_Products_Controller();
                    break;

                case 'wcfm-products-manage':
                    include_once $this->controllers_path.'products/wcfmu-controller-products-manage.php';
                    new WCFMu_Products_Manage_Controller();
                    break;

                case 'wcfm-products-quick-manage':
                    include_once $this->controllers_path.'products/wcfmu-controller-products-quick-manage.php';
                    new WCFMu_Products_Quick_Manage_Controller();
                    break;

                case 'wcfm-stock-manage':
                    include_once $this->controllers_path.'products/wcfmu-controller-stock-manage.php';
                    new WCFMu_Stock_Manage_Controller();
                    break;

                case 'wcfm-stock-manage-update':
                    include_once $this->controllers_path.'products/wcfmu-controller-stock-manage.php';
                    new WCFMu_Stock_Manage_Update_Controller();
                    break;

                case 'wcfm-coupons':
                    include_once $this->controllers_path.'coupons/wcfmu-controller-coupons.php';
                    new WCFMu_Coupons_Controller();
                    break;

                case 'wcfm-coupons-manage':
                    include_once $this->controllers_path.'coupons/wcfmu-controller-coupons-manage.php';
                    new WCFMu_Coupons_Manage_Controller();
                    break;

                case 'wcfm-orders':
                    include_once $this->controllers_path.'orders/wcfmu-controller-orders.php';
                    new WCFMu_Orders_Controller();
                    break;

                case 'wcfm-orders-manage-add-customer':
                    include_once $this->controllers_path.'orders/wcfmu-controller-orders-manage-add-customer.php';
                    new WCFMu_Orders_Manage_Customer_Add_Controller();
                    break;

                case 'wcfm-reports-out-of-stock':
                    include_once $this->controllers_path.'reports/wcfmu-controller-reports-out-of-stock.php';
                    new WCFMu_Reports_Out_Of_Stock_Controller();
                    break;

                case 'wcfm-reports-low-in-stock':
                    include_once $this->controllers_path.'reports/wcfmu-controller-reports-low-in-stock.php';
                    new WCFMu_Reports_Low_In_Stock_Controller();
                    break;

                case 'wcfm-settings':
                    include_once $this->controllers_path.'settings/wcfmu-controller-settings.php';
                    new WCFMu_Settings_Controller();
                    break;

                case 'wcfm-screen-manage':
                    include_once $this->controllers_path.'wcfmu-controller-screen-manage.php';
                    new WCFMu_Screen_Manage_Controller();
                    break;
            }//end switch
        }//end if

        return;

    }//end wcfmu_ajax_controller()

    /**
     * Handle Coupon Delete
     */
    public function delete_wcfm_coupon()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
			wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $couponid = $_POST['couponid'];

        if ($couponid) {
            do_action('wcfm_before_coupon_delete', $couponid);
            if (apply_filters('wcfm_is_allow_coupon_delete', true)) {
                if (wp_delete_post($couponid)) {
                    echo 'success';
                    die;
                }
            } else {
                if (wp_trash_post($couponid)) {
                    echo 'success';
                    die;
                }
            }

            die;
        }

    }//end delete_wcfm_coupon()

    /**
     * Handle Order Delete
     */
    public function delete_wcfm_order()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $orderid = $_POST['orderid'];

        if ($orderid) {
            do_action('wcfm_before_order_delete', $orderid);
            if (apply_filters('wcfm_is_allow_order_delete', false)) {
                if (wp_delete_post($orderid)) {
                    do_action('woocommerce_delete_order', $orderid);
                    echo 'success';
                    die;
                }
            } else {
                if (wp_trash_post($orderid)) {
                    do_action('woocommerce_trash_order', $orderid);
                    echo 'success';
                    die;
                }
            }

            die;
        }

    }//end delete_wcfm_order()

    /**
     * Handle Auction Bid Delete
     */
    function delete_wcfm_auction_bid()
    {
        global $WCFM, $WCFMu, $wpdb;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        if ( ! current_user_can( 'edit_product', $_POST['postid'] ) ) {
            die();
        }

        //Check if auction product
        $product = wc_get_product( $_POST['postid'] );

        if( ! $product || $product->get_type() != 'auction' ) {
            die();
        }

        $auction_plugin = $_POST['plugin'];

        if ( $auction_plugin && $auction_plugin == 'simple' ) {
            if ($_POST['postid'] && $_POST['logid']) {
                $product_data = wc_get_product( $_POST['postid'] );
                $log          = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'simple_auction_log WHERE id=%d', $_POST['logid'] ) );
                $last_log     = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'simple_auction_log WHERE auction_id =%d ORDER BY `id` desc', $_POST['postid'] ) );
                if ( ! is_null( $log ) ) {
                    if ( $product_data->get_auction_type() == 'normal' ) {
                        if ( $log->id === $last_log->id ) {
                            if ( $product_data->get_auction_relisted() ) {
                                $time = 'AND `date` > \'' . $product_data->get_auction_relisted() . '\'';
                            } else {
                                $time = ' ';
                            }

                            $newbid = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'simple_auction_log WHERE auction_id =%d ' . $time . ' ORDER BY  `date` desc , `bid`  desc LIMIT 1, 1 ', $_POST['postid'] ) );
                            if ( ! is_null( $newbid ) ) {
                                update_post_meta( $_POST['postid'], '_auction_current_bid', $newbid->bid );
                                update_post_meta( $_POST['postid'], '_auction_current_bider', $newbid->userid );
                                delete_post_meta( $_POST['postid'], '_auction_max_bid' );
                                delete_post_meta( $_POST['postid'], '_auction_max_current_bider' );
                                $new_max_bider_id = $newbid->userid;
                            } else {
                                delete_post_meta( $_POST['postid'], '_auction_current_bid' );
                                delete_post_meta( $_POST['postid'], '_auction_current_bider' );
                                delete_post_meta( $_POST['postid'], '_auction_max_bid' );
                                delete_post_meta( $_POST['postid'], '_auction_max_current_bider' );
                                $new_max_bider_id = false;
                            }

                            $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'simple_auction_log WHERE id= %d', $_POST['logid'] ) );
                            update_post_meta( $_POST['postid'], '_auction_bid_count', intval( $product_data->get_auction_bid_count() - 1 ) );
                            $return['action'] = 'deleted';
                            $return['message'] = 'Current bid changed';
                            do_action(
                                'woocommerce_simple_auction_delete_bid',
                                array(
                                    'product_id' => $_POST['postid'],
                                    'delete_user_id' => $log->userid,
                                    'new_max_bider_id ' => $new_max_bider_id,
                                )
                            );
                        } else {
                            $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'simple_auction_log WHERE id= %d', $_POST['logid'] ) );
                            update_post_meta( $_POST['postid'], '_auction_bid_count', intval( $product_data->get_auction_bid_count() - 1 ) );
                            $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'simple_auction_log WHERE id= %d', $_POST['logid'] ) );
                            do_action(
                                'woocommerce_simple_auction_delete_bid',
                                array(
                                    'product_id' => $_POST['postid'],
                                    'delete_user_id' => $log->userid,
                                )
                            );
                            $return['action'] = 'deleted';
                        }//end if
                    } elseif ( $product_data->get_auction_type() == 'reverse' ) {
                        if ( $log->id === $last_log->id ) {
                            if ( $product_data->get_auction_relisted() ) {
                                $time = 'AND `date` > \'' . $product_data->get_auction_relisted() . '\'';
                            } else {
                                $time = ' ';
                            }

                            $newbid = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'simple_auction_log WHERE auction_id =%d  ' . $time . '  ORDER BY  `date` desc , `bid` asc LIMIT 1, 1 ', $_POST['postid'] ) );
                            if ( ! is_null( $newbid ) ) {
                                update_post_meta( $_POST['postid'], '_auction_current_bid', $newbid->bid );
                                update_post_meta( $_POST['postid'], '_auction_current_bider', $newbid->userid );
                                delete_post_meta( $_POST['postid'], '_auction_max_bid' );
                                delete_post_meta( $_POST['postid'], '_auction_max_current_bider' );
                                $new_max_bider_id = $newbid->userid;
                            } else {
                                delete_post_meta( $_POST['postid'], '_auction_current_bid' );
                                delete_post_meta( $_POST['postid'], '_auction_current_bider' );
                                $new_max_bider_id = false;
                            }

                            $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'simple_auction_log WHERE id= %d', $_POST['logid'] ) );
                            update_post_meta( $_POST['postid'], '_auction_bid_count', intval( $product_data->get_auction_bid_count() - 1 ) );
                            $return['action'] = 'deleted';
                            do_action(
                                'woocommerce_simple_auction_delete_bid',
                                array(
                                    'product_id' => $_POST['postid'],
                                    'delete_user_id' => $log->userid,
                                    'new_max_bider_id ' => $new_max_bider_id,
                                )
                            );
                        } else {
                            $wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'simple_auction_log  WHERE id= %d', $_POST['logid'] ) );
                            update_post_meta( $_POST['postid'], '_auction_bid_count', intval( $product_data->get_auction_bid_count() - 1 ) );
                            do_action(
                                'woocommerce_simple_auction_delete_bid',
                                array(
                                    'product_id' => $_POST['postid'],
                                    'delete_user_id' => $log->userid,
                                )
                            );
                            $return['action'] = 'deleted';
                        }//end if
                    }//end if

                    if ( isset( $return ) ) {
                        wp_send_json( $return );
                    }

                }//end if
            }//end if
        } else {
            // $wpdb->query($wpdb->prepare('DELETE FROM '.$wpdb->prefix.'yith_wcact_auction WHERE id= %d', absint($_POST['logid'])));

            $product_id = isset( $_POST['postid'] ) ? sanitize_text_field( wp_unslash( $_POST['postid'] ) ) : '';
			$user_id    = isset( $_POST['userid'] ) ? sanitize_text_field( wp_unslash( $_POST['userid'] ) ) : '';
			$datetime   = isset( $_POST['datetime'] ) ? sanitize_text_field( wp_unslash( $_POST['datetime'] ) ) : '';
			$bid        = isset( $_POST['bid'] ) ? sanitize_text_field( wp_unslash( $_POST['bid'] ) ) : '';
			$delete_id  = isset( $_POST['logid'] ) ? sanitize_text_field( wp_unslash( $_POST['logid'] ) ) : '';

			$instance = YITH_Auctions()->bids;

			$instance->delete_customer_bid( $delete_id );

            $return['action'] = 'deleted';

			$product = wc_get_product( $product_id );
			yit_delete_prop( $product, 'current_bid' );

			$instance   = YITH_Auctions()->bids;
			$max_bidder = $instance->get_max_bid( $product->get_id() );

			if ( $max_bidder ) {
				$price = $product->get_price();

				yit_save_prop( $product, 'current_bid', $price );

                $return['message'] = 'Current bid changed';
			}

			$args = compact( 'bid', 'datetime' );
			WC()->mailer();
			do_action( 'yith_wcact_auction_delete_customer_bid', $product_id, $user_id, $args );
			do_action( 'yith_wcact_auction_delete_customer_bid_admin', $product_id, $user_id, $args );

            if ( isset( $return ) ) {
                wp_send_json( $return );
            }

        }//end if

        $return['action'] = 'failed';

        if ( isset( $return ) ) {
            wp_send_json( $return );
        }

        exit;

    }//end delete_wcfm_auction_bid()

    /**
     * Handle Order Note Add
     */
    public function wcfm_add_order_note()
    {
        global $WCFM, $WCFMu, $woocommerce;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $user_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        $user    = $user_id;

        parse_str($_POST['note_data'], $wcfm_note_data);
        $order_id  = absint($wcfm_note_data['add_order_note_id']);
        $note      = apply_filters('wcfm_editor_content_before_save', wp_kses_post(trim(stripslashes($_POST['note']))));
        $note_type = $wcfm_note_data['order_note_type'];

        $is_customer_note = $note_type == 'customer' ? 1 : 0;
        $note_class       = '';
        if ($is_customer_note) {
            $note_class = 'customer-note';
        }

        if ($order_id > 0) {
            $order = wc_get_order($order_id);

            if (apply_filters('wcfm_is_allow_order_note_attachments', true)) {
                $attachments = $wcfm_note_data['order_note_attachments'];
                if (! empty($attachments)) {
                    $attachment_data = '';
                    foreach ($attachments as $index => $attachment) {
                        if (isset($attachment['file']) && ! empty($attachment['file'])) {
                            $name = ! empty($attachment['name']) ? $attachment['name'] : __('Attachment', 'wc-frontend-manager-ultimate').' '.$index;
                            if ($index != 0) {
                                $note .= ',&nbsp;';
                            }

                            $attachment_data .= '<a class="wcfm_dashboard_item_title wcfm_linked_attached" target="_blank" href="'.wcfm_get_attachment_url($attachment['file']).'">'.$name.'</a>';
                        }
                    }

                    if (! empty($attachment_data)) {
                        $note .= '<br />'.__('Attachments', 'wc-frontend-manager-ultimate').': '.$attachment_data;
                    }
                }
            }

            $note = apply_filters('wcfm_order_note_before_save', $note, $wcfm_note_data);

            // Vendor association
            if (wcfm_is_vendor()) {
                if (apply_filters('wcfmmp_is_allow_sold_by', true, $user_id) && $WCFM->wcfm_vendor_support->wcfm_vendor_has_capability($user_id, 'sold_by') && apply_filters('wcfm_is_allow_order_note_vendor_reference', true)) {
                    // translators: 1) vendor store url
                    $note = sprintf(__('%s has added the following note', 'wc-frontend-manager-ultimate'), wcfm_get_vendor_store($user_id)).': '.'<br />'.$note;
                }

                add_filter('woocommerce_new_order_note_data', [ $WCFMu->wcfmu_marketplace, 'filter_wcfm_vendors_comment' ], 10, 2);
            }

            $comment_id = $order->add_order_note($note, $is_customer_note, true);

            // Vendor association
            if (wcfm_is_vendor()) {
                remove_filter('woocommerce_new_order_note_data', [ $WCFMu->wcfmu_marketplace, 'filter_wcfm_vendors_comment' ], 10, 2);
            }

            echo '<tr class="'.$note_class.'"><td>';
            echo wpautop(wptexturize($note));
            echo '</td><td>'.__('Just Now', 'wc-frontend-manager-ultimate');
            echo '</td></tr>';
        }//end if

        die();

    }//end wcfm_add_order_note()

    /**
     * Add new attribute term
     */
    function wcfmu_add_attribute_term()
    {
        global $WCFM, $WCFMu, $_POST;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $taxonomy = esc_attr($_POST['taxonomy']);
        $term     = wc_clean($_POST['term']);

        if (taxonomy_exists($taxonomy)) {
            $result = wp_insert_term($term, $taxonomy);

            if (is_wp_error($result)) {
                wp_send_json(
                    [
                        'error' => $result->get_error_message(),
                    ]
                );
            } else {
                $term = get_term_by('id', $result['term_id'], $taxonomy);
                wp_send_json(
                    [
                        'term_id' => $term->term_id,
                        'name'    => $term->name,
                        'slug'    => $term->slug,
                    ]
                );
            }
        }

        wp_die(-1);

    }//end wcfmu_add_attribute_term()

    /**
     * WCFM Mark/Un-mark Product as Featured
     */
    public function wcfmu_product_featured()
    {
        global $WCFM, $WCFMu, $_POST;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        if (isset($_POST['proid']) && ! empty($_POST['proid'])) {
            $product_id  = $_POST['proid'];
            $is_featured = $_POST['featured'];

            if ($is_featured == 'featured') {
                wp_set_object_terms($product_id, 'featured', 'product_visibility');
            } else if ($is_featured == 'nofeatured') {
                wp_remove_object_terms($product_id, 'featured', 'product_visibility');
            }
        }

        echo 'success';
        die;

    }//end wcfmu_product_featured()

    /**
     * WCFM Generate Duplicate Product
     */
    public function wcfmu_duplicate_product()
    {
        global $WCFM, $WCFMu, $_POST;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        if (! class_exists('WC_Admin_Duplicate_Product')) {
            include WC_ABSPATH.'includes/admin/class-wc-admin-duplicate-product.php';
        }

        $WC_Admin_Duplicate_Product = new WC_Admin_Duplicate_Product();

        if (empty($_POST['proid'])) {
            echo '{"status": false, "message": "'.__('No product to duplicate has been supplied!', 'woocommerce').'"}';
        }

        $product_id = isset($_POST['proid']) ? absint($_POST['proid']) : '';

        // check_admin_referer( 'woocommerce-duplicate-product_' . $product_id );
        $product = wc_get_product($product_id);

        if (false === $product) {
            // translators: %s: product id
            echo '{"status": false, "message": "'.sprintf(__('Product creation failed, could not find original product: %s', 'woocommerce'), $product_id).'" }';
        }

        $duplicate = $WC_Admin_Duplicate_Product->product_duplicate($product);

        update_post_meta($duplicate->get_id(), '_wcfm_product_views', 0);
        delete_post_meta($duplicate->get_id(), '_wcfm_review_product_notified');

        // Hook rename to match other woocommerce_product_* hooks, and to move away from depending on a response from the wp_posts table.
        do_action('woocommerce_product_duplicate', $duplicate, $product);
        do_action('after_wcfm_product_duplicate', $duplicate->get_id(), $product);

        // Redirect to the edit screen for the new draft page
        echo '{"status": true, "redirect": "'.get_wcfm_edit_product_url($duplicate->get_id()).'", "id": "'.$duplicate->get_id().'"}';

        die;

    }//end wcfmu_duplicate_product()

    /**
     * WCFM Duplicate Product Custom Taxonomies
     */
    function wcfmu_duplicate_product_taxonomy($duplicate, $product)
    {
        global $WCFM, $WCFMu;

        $product_taxonomies = get_object_taxonomies('product', 'objects');
        if (! empty($product_taxonomies)) {
            foreach ($product_taxonomies as $product_taxonomy) {
                if (! in_array($product_taxonomy->name, [ 'product_cat', 'product_tag', 'wcpv_product_vendors' ])) {
                    if ($product_taxonomy->public && $product_taxonomy->show_ui && $product_taxonomy->meta_box_cb && $product_taxonomy->hierarchical) {
                        // Fetching Saved Values
                        $taxonomy_values = get_the_terms($product->get_id(), $product_taxonomy->name);
                        $is_first        = true;
                        if (! empty($taxonomy_values)) {
                            foreach ($taxonomy_values as $pkey => $ptaxonomy) {
                                if ($is_first) {
                                    $is_first = false;
                                    wp_set_object_terms($duplicate->get_id(), (int) $ptaxonomy->term_id, $product_taxonomy->name);
                                } else {
                                    wp_set_object_terms($duplicate->get_id(), (int) $ptaxonomy->term_id, $product_taxonomy->name, true);
                                }
                            }
                        }
                    }
                }
            }
        }//end if

    }//end wcfmu_duplicate_product_taxonomy()

    /**
     * Generate Product Quick Edit HTMl
     */
    function wcfmu_quick_edit_html()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        include_once $WCFMu->library->views_path.'products/wcfmu-view-products-quick-manage.php';
        die;

    }//end wcfmu_quick_edit_html()

    /**
     * Generate Shipment Tracking HTML
     */
    function wcfmu_shipment_tracking_html()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        include_once $WCFMu->library->views_path.'orders/wcfmu-view-shipment-tracking.php';
        die;

    }//end wcfmu_shipment_tracking_html()

    /**
     * Generate Add Customer Popup HTML
     */
    function wcfm_order_add_customer_html()
    {
        global $WCFM, $WCFMu;
        
        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        include_once $WCFMu->plugin_path.'views/orders/wcfmu-view-orders-add-customer.php';
        die;

    }//end wcfm_order_add_customer_html()

    /**
     * Generate Screen Manager HTMl
     */
    function wcfmu_screen_manager_html()
    {
        global $WCFM, $WCFMu;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        include_once $WCFMu->library->views_path.'wcfmu-view-screen-manager.php';
        die;

    }//end wcfmu_screen_manager_html()

    /**
     * Ajax callback for importing one batch of products from a CSV.
     */
    public function wcfmu_ajax_product_import()
    {
        global $WCFM, $WCFMu, $wpdb;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        check_ajax_referer('wcfm-product-import', 'security');

        if (! isset($_POST['file'])) {
            wp_die(-1);
        }

        include_once $WCFMu->plugin_path.'includes/product_importer/class-wcfm-product-csv-importer-controller.php';
        include_once WC_ABSPATH.'includes/admin/importers/class-wc-product-csv-importer-controller.php';
        include_once WC_ABSPATH.'includes/import/class-wc-product-csv-importer.php';

        $file   = wc_clean($_POST['file']);
        $params = [
            'delimiter'       => ! empty($_POST['delimiter']) ? wc_clean($_POST['delimiter']) : ',',
            'start_pos'       => isset($_POST['position']) ? absint($_POST['position']) : 0,
            'mapping'         => isset($_POST['mapping']) ? (array) $_POST['mapping'] : [],
            'update_existing' => isset($_POST['update_existing']) ? (bool) $_POST['update_existing'] : false,
            'lines'           => apply_filters('woocommerce_product_import_batch_size', 30),
            'parse'           => true,
        ];

        // Log failures.
        if (0 !== $params['start_pos']) {
            $error_log = array_filter((array) get_user_option('product_import_error_log'));
        } else {
            $error_log = [];
        }

        $importer         = WCFM_Product_CSV_Importer_Controller::get_importer($file, $params);
        $results          = $importer->import();
        $percent_complete = $importer->get_percent_complete();
        $error_log        = array_merge($error_log, $results['failed'], $results['skipped']);
        $current_user     = apply_filters('wcfm_current_vendor_id', get_current_user_id());

        update_user_option($current_user, 'product_import_error_log', $error_log);

        if (100 === $percent_complete) {
            // Clear temp meta.
            $wpdb->delete($wpdb->postmeta, [ 'meta_key' => '_original_id' ]);
            $wpdb->delete(
                $wpdb->posts,
                [
                    'post_status' => 'importing',
                    'post_type'   => 'product',
                ]
            );
            $wpdb->delete(
                $wpdb->posts,
                [
                    'post_status' => 'importing',
                    'post_type'   => 'product_variation',
                ]
            );

            // Send success.
            wp_send_json_success(
                [
                    'position'   => 'done',
                    'percentage' => 100,
                    'url'        => add_query_arg([ '_wpnonce' => wp_create_nonce('woocommerce-csv-importer') ], get_wcfm_import_product_url('done')),
                    'imported'   => count($results['imported']),
                    'failed'     => count($results['failed']),
                    'updated'    => count($results['updated']),
                    'skipped'    => count($results['skipped']),
                ]
            );
        } else {
            wp_send_json_success(
                [
                    'position'   => $importer->get_file_position(),
                    'percentage' => $percent_complete,
                    'imported'   => count($results['imported']),
                    'failed'     => count($results['failed']),
                    'updated'    => count($results['updated']),
                    'skipped'    => count($results['skipped']),
                ]
            );
        }//end if

    }//end wcfmu_ajax_product_import()

}//end class
