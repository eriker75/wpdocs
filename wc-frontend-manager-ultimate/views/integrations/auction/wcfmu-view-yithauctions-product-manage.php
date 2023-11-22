<?php
/**
 * WCFM plugin views
 *
 * Plugin YITH Auctions Products Manage Views
 *
 * @author  Squiz Pty Ltd <products@squiz.net>
 * @package wcfmu/thirdparty/views
 * @version 2.4.0
 */
global $wp, $WCFM, $WCFMu;

$product_id         = 0;
$product            = null;
$auction_product    = null;

if (isset($wp->query_vars['wcfm-products-manage']) && ! empty($wp->query_vars['wcfm-products-manage'])) {
    $product_id = $wp->query_vars['wcfm-products-manage'];
    if ($product_id) {
        $product = wc_get_product( $product_id );
        $auction_product = ( $product && 'auction' === $product->get_type() ) ? true : false;
    }//end if

    $minimun_increment_amount_title       = ( $auction_product && 'reverse' === $product->get_auction_type() ) ? esc_html__( 'Minimum decrement amount', 'yith-auctions-for-woocommerce' ) : esc_html__( 'Minimum increment amount', 'yith-auctions-for-woocommerce' );
    $minimun_increment_amount_description = ( $auction_product && 'reverse' === $product->get_auction_type() ) ? esc_html__( 'Set the minimum decrement amount for manual bids', 'yith-auctions-for-woocommerce' ) : esc_html__( 'Set the minimum increment amount for manual bids', 'yith-auctions-for-woocommerce' );
} else {
    $minimun_increment_amount_title       = esc_html__( 'Minimum increment amount', 'yith-auctions-for-woocommerce' );
    $minimun_increment_amount_description = esc_html__( 'Set the minimum increment amount for manual bids', 'yith-auctions-for-woocommerce' );
}

?>

<div class="page_collapsible products_manage_yithauction auction non-variable-subscription" id="wcfm_products_manage_form_auction_head"><label class="wcfmfa fa-gavel"></label><?php _e('Auction', 'wc-frontend-manager-ultimate'); ?><span></span></div>
<div class="wcfm-container auction non-variable-subscription">
    <div id="wcfm_products_manage_form_yithauction_expander" class="wcfm-content">
        <?php
        $WCFM->wcfm_fields->wcfm_generate_form_field(
            apply_filters(
                'wcfm_product_manage_yithauction_fields',
                [
                    'auction_settings_title'                     => [
                        'label'       => esc_html__( 'Auction Settings', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'title',
                    ],
                    '_yith_wcact_item_condition'                     => [
                        'label'       => esc_html__( 'Item condition', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Optional: Enter the item condition (new, used, damaged...)', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'text',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction',
                        'value'       => $product && $auction_product ? $product->get_item_condition( 'edit' ) : '',
                    ],
                    '_yith_wcact_auction_type'                     => [
                        'label'       => esc_html__( 'Auction type', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Choose the auction type. In a normal auction, the higher bid wins, in a reverse auction, the lower bid wins.', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'radio',
                        'class'       => 'wcfm-select wcfm_ele auction',
                        'label_class' => 'wcfm_title auction',
                        'options'     => apply_filters(
							'yith_wcact_auction_type_product_options',
							array(
								'normal'  => esc_html__( 'Normal', 'yith-auctions-for-woocommerce' ),
								'reverse' => esc_html__( 'Reverse', 'yith-auctions-for-woocommerce' ),
							)
						),
                        'value'       => $product && $auction_product ? $product->get_auction_type( 'edit' ) : apply_filters( 'yith_wcact_auction_type_product_options_default', 'normal' ),
                    ],
                    '_yith_wcact_auction_sealed'                     => [
                        'label'         => esc_html__( 'Make sealed', 'yith-auctions-for-woocommerce' ),
                        'hints'         => esc_html__( 'Enable if you want to make this a sealed auction. All bids will be hidden.', 'yith-auctions-for-woocommerce' ),
                        'type'          => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'         => 'wcfm-checkbox wcfm_ele auction',
                        'label_class'   => 'wcfm_title checkbox_title auction',
                        'value'         => 'yes',
                        'dfvalue'       => $product && $auction_product ? $product->get_auction_sealed( 'edit' ) : apply_filters( 'yith_wcact_metabox_default_value', 'no', 'auction_sealed' ),
                    ],
                    '_yith_auction_start_price'                     => [
                        'label'       => esc_html__( 'Starting Price', 'yith-auctions-for-woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
                        'hints'       => esc_html__( 'Set a starting price for this auction', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'text',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction',
                        'value'       => $product && $auction_product ? $product->get_start_price( 'edit' ) : '',
                        'custom_attributes' => [
                            'required' => true
                        ],
                    ],
                    '_yith_auction_minimum_increment_amount'        => [
                        'label'       => $minimun_increment_amount_title . ' (' . get_woocommerce_currency_symbol() . ')',
                        'hints'       => implode(
                            '<br />',
                            array(
                                $minimun_increment_amount_description,
                                esc_html__( 'Note: If you set automatic bidding, this value will be overridden by the value of "Automatic bid increment".', 'yith-auctions-for-woocommerce' ),
                            )
                        ),
                        'type'        => 'text',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction',
                        'value'       => $product && $auction_product ? $product->get_minimum_increment_amount( 'edit' ) : '',
                    ],
                    '_yith_auction_reserve_price'                   => [
                        'label'       => esc_html__( 'Reserve price', 'yith-auctions-for-woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
                        'hints'       => esc_html__( 'Set the reserve price for this auction.', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'text',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction ywcact_show_if_auction_normal',
                        'value'       => $product && $auction_product ? $product->get_reserve_price( 'edit' ) : '',
                    ],
                    '_yith_auction_buy_now_onoff'                     => [
                        'label'       => esc_html__( 'Show \'Buy Now\' button', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to show a \'Buy Now\' button to allow users to buy this product without to bid', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction ywcact_show_if_auction_normal',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? yith_wcact_field_onoff_value( 'buy_now_onoff', 'buy_now', $product ) : apply_filters( 'yith_wcact_metabox_default_value', 'no', 'buy_now_onoff' ),
                    ],
                    '_yith_auction_buy_now'                         => [
                        'label'       => esc_html__( 'Buy it now price', 'yith-auctions-for-woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
                        'hints'       => esc_html__( 'Set the \'Buy Now\' price for this auction.', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'text',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction ywcact_show_if_buy_now',
                        'value'       => $product && $auction_product ? $product->get_buy_now( 'edit' ) : '',
                    ],
                    'auction_dates'     => [
                        'name'      => '',
                        'class'     => 'wcfm-auction-multiinput-holder',
                        'type'      => 'html',
                        'value'     => include $WCFMu->plugin_path . 'views/integrations/auction/wcfmu-view-yithauctions-auction-dates-field.php',
                    ],
                    '_yith_auction_bid_type_onoff'                     => [
                        'label'       => esc_html__( 'Override bid type options', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to override the global options and set specific bid type options for this auction', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? yith_wcact_field_onoff_value( 'bid_type_onoff', 'bid_increment', $product ) : 'no',
                    ],
                    '_yith_wcact_bid_type_set_radio'                     => [
                        'label'       => esc_html__( 'Set bid type', 'yith-auctions-for-woocommerce' ),
                        'hints'       => implode(
                            '<br />',
                            array(
                                esc_html__( 'With the automatic bidding, the user enters the maximum amount it\'s willing to pay for the item.', 'yith-auctions-for-woocommerce' ),
                                esc_html_x( 'The system will automatically bid for the user with the smallest amount possible every time, once his maximum limit is reached', 'The system will automatically bid for him with the smallest amount posible every time, once his maximun limit is reached', 'yith-auctions-for-woocommerce' ),
                            )
                        ),
                        'type'        => 'radio',
                        'class'       => 'wcfm-select wcfm_ele auction',
                        'label_class' => 'wcfm_title auction ywcact_show_if_bid_up',
                        'options'     => [
							'manual'    => esc_html__( 'Manual', 'yith-auctions-for-woocommerce' ),
							'automatic' => esc_html__( 'Automatic', 'yith-auctions-for-woocommerce' ),
                        ],
                        'value'       => $product && $auction_product ? yith_wcact_field_radio_value( 'bid_type_set_radio', 'bid_increment', $product, 'manual', 'automatic' ) : 'manual',
                    ],
                    '_yith_wcact_bid_type_radio'                     => [
                        'label'       => esc_html__( 'Auction bid type', 'yith-auctions-for-woocommerce' ),
                        'hints'       => implode(
                            '<br />',
                            array(
                                esc_html_x( 'With the simple type you can set only one bid increment amount, independently from the current bid value.', 'The system will automatically bid for him with the smallest amount posible every time, once his maximun limit is reached', 'yith-auctions-for-woocommerce' ),
                                esc_html__( 'With the advanced type you can set different auctomatic bid increments based on the current bid value.', 'yith-auctions-for-woocommerce' ),
                            )
                        ),
                        'type'        => 'radio',
                        'class'       => 'wcfm-select wcfm_ele auction',
                        'label_class' => 'wcfm_title auction ywcact_show_if_bid_up ywcact_show_if_bid_up_set',
                        'options'     => [
							'simple'   => esc_html__( 'Simple', 'yith-auctions-for-woocommerce' ),
							'advanced' => esc_html__( 'Advanced', 'yith-auctions-for-woocommerce' ),
                        ],
                        'value'       => $product && $auction_product ? yith_wcact_field_radio_value( 'bid_type_radio', 'bid_increment', $product, 'simple' ) : 'simple',
                    ],
                    'bid_increment_simple'     => [
                        'name'      => '',
                        'class'     => 'wcfm-auction-multiinput-holder',
                        'type'      => 'html',
                        'value'     => include $WCFMu->plugin_path . 'views/integrations/auction/wcfmu-view-yithauctions-bid-increment-simple-field.php',
                    ],
                    'bid_increment_advanced'     => [
                        'name'      => '',
                        'class'     => 'wcfm-auction-multiinput-holder',
                        'type'      => 'html',
                        'value'     => include $WCFMu->plugin_path . 'views/integrations/auction/wcfmu-view-yithauctions-bid-increment-advanced-field.php',
                    ],
                    '_yith_auction_fee_onoff'                     => [
                        'label'       => esc_html__( 'Override fee options', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to override the global options and set specific fee options for this auction', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? $product->get_fee_onoff( 'edit' ) : 'no',
                    ],
                    '_yith_auction_fee_ask_onoff'                     => [
                        'label'       => esc_html__( 'Ask fee payment before bidding', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to ask users to pay a fee before placing a bid.', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction ywcact_show_if_fee',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? $product->get_fee_ask_onoff( 'edit' ) : 'no',
                    ],
                    '_yith_auction_fee_amount'                              => [
                        'label'       => esc_html__( 'Fee amount', 'yith-auctions-for-woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
                        'hints'       => esc_html__( 'Set the fee for this auction, a user needs to pay, before being able to place a bid', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'text',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction ywcact_show_if_fee ywcact_show_if_ask_fee',
                        'value'       => $product && $auction_product ? $product->get_fee_amount( 'edit' ) : '',
                    ],

                    '_yith_auction_commission_fee_onoff'                     => [
                        'label'       => esc_html__( 'Override commissions fee options', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to override the global options and set specific commission fee options for this auction', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? $product->get_commission_fee_onoff( 'edit' ) : 'no',
                    ],
                    '_yith_auction_commission_apply_fee_onoff'               => [
                        'label'       => esc_html__( 'Apply commission fee for winner auction', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to apply a specific commission fee for auction winner', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction ywcact_show_if_commission_fee',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? $product->get_commission_apply_fee_onoff( 'edit' ) : 'no',
                    ],
                    'commission_fee'     => [
                        'name'      => '',
                        'class'     => 'wcfm-auction-multiinput-holder',
                        'type'      => 'html',
                        'value'     => include $WCFMu->plugin_path . 'views/integrations/auction/wcfmu-view-yithauctions-commission-fee-field.php',
                    ],
                    '_yith_auction_commission_label'                              => [
                        'label'       => esc_html__( 'Commission label', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enter a label to identify the commission in checkout and product page. This will override general option', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'text',
                        'class'       => 'wcfm-text wcfm_ele auction',
                        'label_class' => 'wcfm_title auction ywcact_show_if_commission_fee ywcact_show_if_apply_commission_fee',
                        'value'       => $product && $auction_product ? $product->get_commission_fee_label( 'edit' ) : '',
                    ],
                    '_yith_auction_reschedule_onoff'                     => [
                        'label'       => esc_html__( 'Override rescheduling options', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to override the global options and set specific rescheduling options for this auction.', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? yith_wcact_field_onoff_value( 'reschedule_onoff', 'automatic_reschedule', $product ) : apply_filters( 'yith_wcact_metabox_default_value', 'no', 'reschedule_onoff' ),
                    ],
                    '_yith_auction_reschedule_closed_without_bids_onoff' => [
                        'label'       => esc_html__( 'Reschedule ended auctions without bids', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to automatically reschedule ended auctions without bid.', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction ywcact_show_if_reschedule',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? yith_wcact_field_onoff_value( 'reschedule_closed_without_bids_onoff', 'automatic_reschedule', $product ) : apply_filters( 'yith_wcact_metabox_default_value', 'no', 'reschedule_closed_without_bids_onoff' ),
                    ],
                    '_yith_auction_reschedule_reserve_no_reached_onoff'  => [
                        'label'       => esc_html__( 'Reschedule ended auctions with the reserve price not reached', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to automatically reschedule ended auctions if the reserve price was not reached by any submitted bids.', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction ywcact_show_if_reschedule',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? $product->get_reschedule_reserve_no_reached_onoff() : apply_filters( 'yith_wcact_metabox_default_value', 'no', 'reschedule_reserve_no_reached_onoff' ),
                    ],
                    'automatic_reschedule'     => [
                        'name'      => '',
                        'class'     => 'wcfm-auction-multiinput-holder',
                        'type'      => 'html',
                        'value'     => include $WCFMu->plugin_path . 'views/integrations/auction/wcfmu-view-yithauctions-automatic-reschedule-field.php',
                    ],
                    '_yith_auction_overtime_onoff'                     => [
                        'label'       => esc_html__( 'Override overtime options', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to override the global options and set specific overtime options for this auction.', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? yith_wcact_field_onoff_value( 'overtime_onoff', 'check_time_for_overtime_option', $product ) : 'no',
                    ],
                    '_yith_auction_overtime_set_onoff'                     => [
                        'label'       => esc_html__( 'Set overtime', 'yith-auctions-for-woocommerce' ),
                        'hints'       => esc_html__( 'Enable to extend the auction duration if someone puts a bid when the auction is about to end.', 'yith-auctions-for-woocommerce' ),
                        'type'        => 'checkboxoffon',
                        'wrapper_class' => 'wcfm-yesno-switch',
                        'class'       => 'wcfm-checkbox wcfm_ele auction',
                        'label_class' => 'wcfm_title checkbox_title auction ywcact_show_if_overtime',
                        'value'       => 'yes',
                        'dfvalue'     => $product && $auction_product ? yith_wcact_field_onoff_value( 'overtime_set_onoff', 'check_time_for_overtime_option', $product ) : 'no',
                    ],
                    'override_settings'     => [
                        'name'      => '',
                        'class'     => 'wcfm-auction-multiinput-holder',
                        'type'      => 'html',
                        'value'     => include $WCFMu->plugin_path . 'views/integrations/auction/wcfmu-view-yithauctions-override-settings-field.php',
                    ],
                    'reschedule_button'     => [
                        'name'      => '',
                        'class'     => 'wcfm-auction-multiinput-holder',
                        'type'      => 'html',
                        'value'     => include $WCFMu->plugin_path . 'views/integrations/auction/wcfmu-view-yithauctions-reschedule-button-field.php',
                    ],
                ],
                $product_id
            )
        );
        ?>
    </div>
</div>
