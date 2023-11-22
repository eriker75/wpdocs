<?php
/**
 * WCFM plugin controllers
 *
 * Plugin Auctions Controller
 *
 * @author  WC Lovers
 * @package wcfmu/controllers
 * @version 2.4.0
 */

class WCFMu_Auctions_Controller
{

    public function __construct()
    {
        global $WCFM;

        $this->processing();

    }//end __construct()

    public function processing()
    {
        global $WCFM, $WCFMu, $wpdb, $_POST;

        $auction_plugin = '';

        $length = $_POST['length'];
        $offset = $_POST['start'];

        $the_auctionsby = ! empty($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'id';
        $the_auctions   = ( ! empty($_POST['order']) && 'asc' === $_POST['order'] ) ? 'ASC' : 'DESC';

        $items_per_page = $length;

        $valid_auctions = apply_filters('wcfm_valid_auctions', []);

        if( isset( $_POST['search'] ) && !empty( $_POST['search']['value'] )) {
			// Search product name
            $args = [
                's'         => $_POST['search']['value'],
                'post_type' => 'product',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_type',
                        'field'    => 'slug',
                        'terms'    => 'auction', 
                    ),
                ),
                'fields'    => 'ids'
            ];

            $product_ids = get_posts( $args );

            // If no product found
            $product_ids[] = 0;

            $valid_auctions = array_intersect( $valid_auctions, $product_ids );
		}

        if (WCFMu_Dependencies::wcfm_wcs_auction_active_check()) {
            $sql = 'SELECT COUNT(id) FROM '.$wpdb->prefix.'simple_auction_log';
        } elseif (WCFMu_Dependencies::wcfm_yith_auction_active_check()) {
            $sql = 'SELECT COUNT(id) FROM '.$wpdb->prefix.'yith_wcact_auction';
        }

        if (! empty($valid_auctions)) {
            $sql .= ' WHERE auction_id in ('.implode(',', $valid_auctions).')';
        }

        $total_items = $wpdb->get_var($sql);

        if (WCFMu_Dependencies::wcfm_wcs_auction_active_check()) {
            $auction_plugin = 'simple';
            $sql            = 'SELECT auctions.id, auctions.userid as userid, auctions.auction_id, auctions.bid, auctions.date FROM '.$wpdb->prefix.'simple_auction_log AS auctions';
        } elseif (WCFMu_Dependencies::wcfm_yith_auction_active_check()) {
            $auction_plugin = 'yith';
            $sql            = 'SELECT auctions.id, auctions.user_id as userid, auctions.auction_id, auctions.bid, auctions.date FROM '.$wpdb->prefix.'yith_wcact_auction AS auctions';
        }

        if (! empty($valid_auctions)) {
            $sql .= ' WHERE auctions.auction_id in ('.implode(',', $valid_auctions).')';
        }

        $sql .= " ORDER BY `{$the_auctionsby}` {$the_auctions}";

        $sql .= " LIMIT {$items_per_page}";

        $sql .= " OFFSET {$offset}";

        $auctions_summary = $wpdb->get_results($sql);

        // Generate Products JSON
        $wcfm_auctions_json = [
            'draw'              => $_POST['draw'],
            'recordsTotal'      => $total_items,
            'recordsFiltered'   => $total_items
        ];

        if (! empty($auctions_summary)) {
            $index                  = 0;
            $totals                 = 0;
            $wcfm_auctions_json_arr = [];

            foreach ($auctions_summary as $auctions) {
                // Auction
                $wcfm_auctions_json_arr[$index][] = '<span class="wcfm_auctions_title">#'.$auctions->id.' - '.get_the_title($auctions->auction_id).'</span>';

                // User
                $userdata = get_userdata($auctions->userid);
                $wcfm_auctions_json_arr[$index][] = apply_filters('wcfm_auction_bid_user', esc_attr($userdata->display_name), $auctions->userid);

                // Bid
                $wcfm_auctions_json_arr[$index][] = wc_price($auctions->bid);

                // Date
                $wcfm_auctions_json_arr[$index][] = date_i18n(wc_date_format(), strtotime($auctions->date));

                // Action
                $actions = '';
                if (apply_filters('wcfm_is_allow_auction_bid_delete', true)) {
                    $data_attr  = array(
                        'userid'    => absint( $auctions->userid ),
                        'datetime'  => $auctions->date,
                        'postid'    => $auctions->auction_id,
                        'bid'       => $auctions->bid,
                        'bidid'     => $auctions->id,
                        'plugin'    => $auction_plugin
                    );

                    // Prepare data attributes
                    $attributes = implode( ' ', array_map(
                        function( $k, $v ) {
                            return sprintf("data-%s='%s'", $k, $v);
                        }, 
                        array_keys( $data_attr ),
                        $data_attr
                    ) );

                    $actions = '<a class="wcfm_auction_bid_delete wcfm-action-icon" href="#" '. $attributes .'><span class="wcfmfa fa-trash-alt text_tip" data-tip="'.esc_attr__('Delete', 'wc-frontend-manager-ultimate').'"></span></a>';
                }

                $wcfm_auctions_json_arr[$index][] = apply_filters('wcfm_auctions_actions', $actions, $auctions);

                $index++;
            }//end foreach
        }//end if

        if (! empty($wcfm_auctions_json_arr)) {
            $wcfm_auctions_json['data'] = $wcfm_auctions_json_arr;
        } else {
            $wcfm_auctions_json['data'] = [];
        }

        wp_send_json( $wcfm_auctions_json );

    }//end processing()

}//end class
