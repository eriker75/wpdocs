<?php
ob_start();
?>

<p class="automatic_reschedule wcfm_title auction ywcact_show_if_reschedule ywcact_show_if_reschedule_reserve_price ywcact_show_if_reschedule_without_bids"><strong><?php esc_html_e('Auctions will be rescheduled for another', 'yith-auctions-for-woocommerce'); ?></strong><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_html_e('Set the length of time for which the auction will run again. The auction will reset itself to the original auction product settings and all previous bids will be removed.', 'yith-auctions-for-woocommerce'); ?>" data-hasqtip="90"></span></p>
<label class="screen-reader-text" for="_yith_check_time_for_overtime_option"><?php esc_html_e('Auctions will be rescheduled for another', 'yith-auctions-for-woocommerce'); ?></label>
<div class="wcfm-auction-multiinput-fields">
    <input type="number" id="_yith_wcact_auction_automatic_reschedule" name="_yith_wcact_auction_automatic_reschedule" class="wcfm_ele auction multi_input_block_element" value="<?php echo $product && $auction_product ? $product->get_automatic_reschedule( 'edit' ) : ''; ?>" placeholder="" data-name="value" min="0">
    <select id="_yith_wcact_automatic_reschedule_auction_unit" name="_yith_wcact_automatic_reschedule_auction_unit" class="wcfm-text wcfm_ele auction multi_input_block_element" data-name="unit">
        <?php
            foreach( yith_wcact_get_select_time_values() as $key => $value ) {
                ?>
                <option value="<?php echo $key; ?>" <?php selected( esc_attr( $product && $auction_product ? $product->get_automatic_reschedule_auction_unit( 'edit' ) : '' ), esc_attr( $key ) ) ?>><?php echo $value; ?></option>
                <?php
            }
        ?>
    </select>
</div>

<?php
return ob_get_clean();
