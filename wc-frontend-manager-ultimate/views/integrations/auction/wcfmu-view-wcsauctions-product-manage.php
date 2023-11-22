<?php
/**
 * WCFM plugin views
 *
 * Plugin WC Simple Auctions Products Manage Views
 *
 * @author  Squiz Pty Ltd <products@squiz.net>
 * @package wcfmu/views/thirdparty
 * @version 2.4.0
 */
global $wp, $WCFM, $WCFMu;

$product_id              = 0;
$_auction_item_condition = 'new';
$_auction_type           = 'normal';
$_auction_proxy          = get_option('simple_auctions_proxy_auction_on', 'no');
$_auction_sealed         = 'no';
$_auction_start_price    = '';
$_auction_bid_increment  = '';
$_auction_reserved_price = '';
$_regular_price          = '';
$_auction_dates_from     = '';
$_auction_dates_to       = '';

$relist_auction_dates_from = '';
$relist_auction_dates_to   = '';

$_auction_automatic_relist     = '';
$_auction_relist_fail_time     = '';
$_auction_relist_not_paid_time = '';
$_auction_relist_duration      = '';

if (isset($wp->query_vars['wcfm-products-manage']) && ! empty($wp->query_vars['wcfm-products-manage'])) {
    $product_id = $wp->query_vars['wcfm-products-manage'];
    if ($product_id) {
        $_auction_item_condition = get_post_meta($product_id, '_auction_item_condition', true);
        $_auction_type           = get_post_meta($product_id, '_auction_type', true);
        $_auction_proxy          = in_array(get_post_meta($product_id, '_auction_proxy', true), [ '0', 'yes' ]) ? get_post_meta($product_id, '_auction_proxy', true) : $_auction_proxy;
        $_auction_sealed         = get_post_meta($product_id, '_auction_sealed', true);
        $_auction_start_price    = get_post_meta($product_id, '_auction_start_price', true);
        $_auction_bid_increment  = get_post_meta($product_id, '_auction_bid_increment', true);
        $_auction_reserved_price = get_post_meta($product_id, '_auction_reserved_price', true);
        $_regular_price          = get_post_meta($product_id, '_regular_price', true);
        $_auction_dates_from     = get_post_meta($product_id, '_auction_dates_from', true);
        $_auction_dates_to       = get_post_meta($product_id, '_auction_dates_to', true);

        $_auction_automatic_relist     = get_post_meta($product_id, '_auction_automatic_relist', true);
        $_auction_relist_fail_time     = get_post_meta($product_id, '_auction_relist_fail_time', true);
        $_auction_relist_not_paid_time = get_post_meta($product_id, '_auction_relist_not_paid_time', true);
        $_auction_relist_duration      = get_post_meta($product_id, '_auction_relist_duration', true);
    }
}

?>
<div class="page_collapsible products_manage_wcsauction auction non-variable-subscription" id="wcfm_products_manage_form_auction_head"><label class="wcfmfa fa-gavel"></label><?php _e('Auction', 'wc-frontend-manager-ultimate'); ?><span></span></div>
<div class="wcfm-container auction non-variable-subscription">
    <div id="wcfm_products_manage_form_wcsauction_expander" class="wcfm-content">
        <?php
        $wcsauction_fields = apply_filters(
            'wcfm_product_manage_wcsauction_fields',
            [
                '_auction_item_condition' => [
                    'label'       => esc_html__( 'Item condition', 'wc_simple_auctions' ),
                    'type'        => 'select',
                    'class'       => 'wcfm-select wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'options'     => apply_filters( 
                        'simple_auction_item_condition',
                        [
                            'new'  => esc_html__( 'New', 'wc_simple_auctions' ),
                            'used' => esc_html__( 'Used', 'wc_simple_auctions' ),
                        ]
                    ),
                    'value'       => $_auction_item_condition,
                ],
                '_auction_type'           => [
                    'label'       => esc_html__( 'Auction type', 'wc_simple_auctions' ),
                    'type'        => 'select',
                    'class'       => 'wcfm-select wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'options'     => apply_filters( 
                        'simple_auction_type',
                        [
                            'normal'  => esc_html__( 'Normal', 'wc_simple_auctions' ),
					        'reverse' => esc_html__( 'Reverse', 'wc_simple_auctions' ),
                        ]
                    ),
                    'value'       => $_auction_type,
                ],
                '_auction_proxy'          => [
                    'label'       => esc_html__( 'Proxy bidding?', 'wc_simple_auctions' ),
                    'type'        => 'checkbox',
                    'class'       => 'wcfm-checkbox wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'value'       => 'yes',
                    'dfvalue'     => $_auction_proxy,
                    'hints'       => esc_html__( 'Enable proxy bidding', 'wc_simple_auctions' ),
                ],
                '_auction_sealed'         => [
                    'label'       => esc_html__( 'Sealed Bid?', 'wc_simple_auctions' ),
                    'type'        => 'checkbox',
                    'class'       => 'wcfm-checkbox wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'value'       => 'yes',
                    'dfvalue'     => $_auction_sealed,
                    'hints'       => esc_html__( 'In this type of auction all bidders simultaneously submit sealed bids so that no bidder knows the bid of any other participant. The highest bidder pays the price they submitted. If two bids with same value are placed for auction the one which was placed first wins the auction.', 'wc_simple_auctions' ),
                ],
                '_auction_start_price'    => [
                    'label'       => esc_html__( 'Start Price', 'wc_simple_auctions' ) . ' (' . get_woocommerce_currency_symbol() . ')',
                    'type'        => 'text',
                    'class'       => 'wcfm-text wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'value'       => $_auction_start_price,
                ],
                '_auction_bid_increment'  => [
                    'label'       => esc_html__( 'Bid increment', 'wc_simple_auctions' ) . ' (' . get_woocommerce_currency_symbol() . ')',
                    'type'        => 'text',
                    'class'       => 'wcfm-text wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'value'       => $_auction_bid_increment,
                ],
                '_auction_reserved_price' => [
                    'label'       => esc_html__( 'Reserve price', 'wc_simple_auctions' ) . ' (' . get_woocommerce_currency_symbol() . ')',
                    'type'        => 'text',
                    'class'       => 'wcfm-text wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'value'       => $_auction_reserved_price,
                    'hints'       => esc_html__( 'A reserve price is the lowest price at which you are willing to sell your item. If you don’t want to sell your item below a certain price, you can set a reserve price. The amount of your reserve price is not disclosed to your bidders, but they will see that your auction has a reserve price and whether or not the reserve has been met. If a bidder does not meet that price, you are not obligated to sell your item. ', 'wc_simple_auctions' ),
                ],
                '_regular_price'          => [
                    'label'       => esc_html__( 'Buy it now price', 'wc_simple_auctions' ) . ' (' . get_woocommerce_currency_symbol() . ')',
                    'type'        => 'text',
                    'class'       => 'wcfm-text wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'value'       => $_regular_price,
                    'hints'       => esc_html__( 'Buy it now disappears when bid exceeds the Buy now price for normal auction, or is lower than reverse auction', 'wc_simple_auctions' ),
                ],
                '_auction_dates_from'     => [
                    'label'       => esc_html__( 'Auction Dates', 'wc_simple_auctions' ),
                    'type'        => 'text',
                    'placeholder' => esc_html_x( 'From&hellip; YYYY-MM-DD HH:MM', 'placeholder', 'wc_simple_auctions' ),
                    'attributes'  => [
                        'maxlength' => 16,
                        'pattern'   => '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])[ ](0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])',
                    ],
                    'class'       => 'wcfm-text wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'value'       => $_auction_dates_from,
                ],
                '_auction_dates_to'       => [
                    'label'       => '',
                    'type'        => 'text',
                    'placeholder' => esc_html_x( 'To&hellip; YYYY-MM-DD HH:MM', 'placeholder', 'wc_simple_auctions' ),
                    'attributes'  => [
                        'maxlength' => 16,
                        'pattern'   => '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])[ ](0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])',
                    ],
                    'class'       => 'wcfm-text wcfm_ele auction',
                    'label_class' => 'wcfm_title auction',
                    'value'       => $_auction_dates_to,
                ],
            ],
            $product_id
        );

        if (get_option('simple_auctions_sealed_on', 'no') != 'yes') {
            unset($wcsauction_fields['_auction_sealed']);
        }

        $WCFM->wcfm_fields->wcfm_generate_form_field($wcsauction_fields);

        if ($product_id) {
            $product = wc_get_product($product_id);
            if (( method_exists($product, 'get_type') && $product->get_type() == 'auction' ) && $product->get_auction_closed() && ! $product->get_auction_payed()) {
                echo '<div style="margin:15px auto;"><div class="wcfm-clearfix"></div><h2>'.esc_html(__('Relist', 'wc_simple_auctions')).'</h2><div class="wcfm-clearfix"></div></div><div class="store_address store_address_wrap">';

                $WCFM->wcfm_fields->wcfm_generate_form_field(
                    apply_filters(
                        'wcfm_product_manage_wcsauction_relist_fields',
                        [
                            '_relist_auction_dates_from' => [
                                'label'       => __('Relist Auction Dates', 'wc_simple_auctions'),
                                'type'        => 'text',
                                'placeholder' => esc_html_x( 'From&hellip; YYYY-MM-DD HH:MM', 'placeholder', 'wc_simple_auctions' ),
                                'attributes'  => [
                                    'maxlength' => 16,
                                    'pattern'   => '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])[ ](0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])',
                                ],
                                'class'       => 'wcfm-text wcfm_ele auction',
                                'label_class' => 'wcfm_title auction',
                                'value'       => $relist_auction_dates_from,
                            ],
                            '_relist_auction_dates_to'   => [
                                'label'       => '',
                                'type'        => 'text',
                                'placeholder' => esc_html_x( 'To&hellip; YYYY-MM-DD HH:MM', 'placeholder', 'wc_simple_auctions' ),
                                'attributes'  => [
                                    'maxlength' => 16,
                                    'pattern'   => '[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])[ ](0[0-9]|1[0-9]|2[0-4]):(0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9])',
                                ],
                                'class'       => 'wcfm-text wcfm_ele auction',
                                'label_class' => 'wcfm_title auction',
                                'value'       => $relist_auction_dates_to,
                            ],
                        ],
                        $product_id
                    )
                );

                echo '</div><div class="wcfm-clearfix"></div>';
            }//end if
        }//end if

        echo '<div style="margin:15px auto;"><div class="wcfm-clearfix"></div><h2>'.esc_html(apply_filters('woocommerce_auction_history_heading', __('Auction automatic relist', 'wc_simple_auctions'))).'</h2><div class="wcfm-clearfix"></div></div><div class="store_address store_address_wrap">';

        $WCFM->wcfm_fields->wcfm_generate_form_field(
            apply_filters(
                'wcfm_product_manage_wcsauction_autorelist_fields',
                [
                    '_auction_automatic_relist'     => [
                        'label'       => esc_html__( 'Automatic relist auction', 'wc_simple_auctions' ),
                        'type'        => 'checkbox',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title auction',
                        'value'       => 'yes',
                        'dfvalue'     => $_auction_automatic_relist,
                        'hints'       => esc_html__( 'Enable automatic relisting', 'wc_simple_auctions' ),
                    ],
                    '_auction_relist_fail_time'     => [
                        'label'       => esc_html__( 'Relist if fail after n hours', 'wc_simple_auctions' ),
                        'type'        => 'number',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction',
                        'value'       => $_auction_relist_fail_time,
                    ],
                    '_auction_relist_not_paid_time' => [
                        'label'       => esc_html__( 'Relist if not paid after n hours', 'wc_simple_auctions' ),
                        'type'        => 'number',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction',
                        'value'       => $_auction_relist_not_paid_time,
                    ],
                    '_auction_relist_duration'      => [
                        'label'       => esc_html__( 'Relist auction duration in h', 'wc_simple_auctions' ),
                        'type'        => 'number',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction',
                        'value'       => $_auction_relist_duration,
                    ],
                ],
                $product_id
            )
        );

        echo '</div><div class="wcfm-clearfix"></div>';
        ?>
        <div class="wcfm-clearfix"></div>
    </div>
</div>
