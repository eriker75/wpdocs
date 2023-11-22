<?php
$options = [
    'fixed'      => get_woocommerce_currency_symbol() . ' - ' . esc_html__( 'Fixed price', 'yith-auctions-for-woocommerce' ),
    'percentage' => esc_html__( '% of winner bid', 'yith-auctions-for-woocommerce' ),
];

ob_start();
?>

<p class="_yith_auction_commission_fee wcfm_title auction ywcact_show_if_commission_fee ywcact_show_if_apply_commission_fee"><strong><?php esc_html_e('Commission fee', 'yith-auctions-for-woocommerce'); ?></strong><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_html_e('Set the commission fee for auction winner', 'yith-auctions-for-woocommerce'); ?>" data-hasqtip="90"></span></p>
<label class="screen-reader-text" for="_yith_auction_commission_fee"><?php esc_html_e('Commission fee', 'yith-auctions-for-woocommerce'); ?></label>
<div class="wcfm-auction-multiinput-fields">
    <input type="number" id="_yith_auction_commission_fee_value" name="_yith_auction_commission_fee[value]" class="wcfm_ele auction multi_input_block_element" value="<?php echo $product && $auction_product ? $product->get_commission_fee( 'edit' )['value'] : ''; ?>" placeholder="" data-name="value" min="0">
    <select id="_yith_auction_commission_fee_unit" name="_yith_auction_commission_fee[unit]" class="wcfm-text wcfm_ele auction multi_input_block_element" data-name="unit">
        <?php
            foreach( $options as $key => $value ) {
                ?>
                <option value="<?php echo $key; ?>" <?php selected( esc_attr( $product && $auction_product ? $product->get_commission_fee( 'edit' )['unit'] : '' ), esc_attr( $key ) ) ?>><?php echo $value; ?></option>
                <?php
            }
        ?>
    </select>
</div>

<?php
return ob_get_clean();
