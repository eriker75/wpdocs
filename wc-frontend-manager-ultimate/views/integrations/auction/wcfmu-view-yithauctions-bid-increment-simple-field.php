<?php
ob_start();
?>

<p class="bid_increment_simple wcfm_title auction ywcact_show_if_bid_up ywcact_show_if_bid_up_set ywcact_show_if_simple"><strong><?php echo esc_html__('Automatic bid increment', 'yith-auctions-for-woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')'; ?></strong><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_html_e('Set the bidding increment for automatic bidding. You can create more rules to set different bid increments based on the auction\'s current bid and then set a last rule to cover all the offers made after the last current bid step', 'yith-auctions-for-woocommerce'); ?>" data-hasqtip="90"></span></p>
<label class="screen-reader-text" for="bid_increment"><?php echo esc_html__('Automatic bid increment', 'yith-auctions-for-woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')'; ?></label>
<div class="wcfm-auction-multiinput-fields wcfm-yith-inline-fields">
    <span for="ywcact_bid_increment_simple" class="">
        <?php
        // translators: %s is the currency symbol.
        echo esc_html(sprintf(_x('Set an automatic bid increment of %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce'), get_woocommerce_currency_symbol()));
        ?>
    </span>
    <input type="number" id="ywcact_automatic_product_bid_simple" name="_yith_auction_bid_increment" class="wcfm_ele auction" value="<?php echo $product && $auction_product ? $product->get_bid_increment() : 0; ?>" placeholder="" data-name="value" step="0.01">
</div>

<?php
return ob_get_clean();
