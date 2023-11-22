<?php
ob_start();
?>

<p class="override_settings wcfm_title auction ywcact_show_if_overtime ywcact_show_if_overtime_set"><strong><?php esc_html_e('Override settings', 'yith-auctions-for-woocommerce'); ?></strong><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_html_e('Set the overtime rule when the auction is about to end.', 'yith-auctions-for-woocommerce'); ?>" data-hasqtip="90"></span></p>
<label class="screen-reader-text" for="_yith_check_time_for_overtime_option"><?php esc_html_e('Override settings', 'yith-auctions-for-woocommerce'); ?></label>
<div class="wcfm-auction-multiinput-fields wcfm-yith-inline-fields">
    <span for="ywcact_general_overtime_before" class="">
        <?php esc_html_e('If someone adds a bid  ', 'yith-auctions-for-woocommerce'); ?>
    </span>
    <input type="number" id="_yith_check_time_for_overtime_option" name="_yith_check_time_for_overtime_option" class="wcfm_ele auction multi_input_block_element" value="<?php echo $product && $auction_product ? $product->get_check_time_for_overtime_option('edit') : ''; ?>" placeholder="" data-name="value" min="0">
    <span for="ywcact_general_overtime" class="">
        <?php esc_html_e('minutes before the auction ends, extend the auction for another ', 'yith-auctions-for-woocommerce'); ?>
    </span>
    <input type="number" id="_yith_overtime_option" name="_yith_overtime_option" class="wcfm_ele auction multi_input_block_element" value="<?php echo $product && $auction_product ? $product->get_overtime_option('edit') : ''; ?>" placeholder="" data-name="value" min="0">
    <span class=""><?php esc_html_e('minutes', 'yith-auctions-for-woocommerce'); ?></span>
</div>

<?php
return ob_get_clean();
