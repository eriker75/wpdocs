<?php
ob_start();
if ( $product && 'auction' === $product->get_type() && ( $product->is_closed() || 'outofstock' === $product->get_stock_status() ) ) {
    ?>
        <p class="reschedule_button wcfm_title auction"></p>
        <label class="screen-reader-text" for="reschedule_button"></label>
        <div class="wcfm-auction-multiinput-fields">
            <input type="button" class="button wcfm_ele auction multi_input_block_element" id="reshedule_button" value="<?php esc_html_e( 'Re-schedule', 'yith-auctions-for-woocommerce' ); ?>">
            <p class="form-field" id="yith-reshedule-notice-admin"><?php esc_html_e( ' Change the dates and click on the update button to re-schedule the auction', 'yith-auctions-for-woocommerce' ); ?></p>
        </div>
    <?php
}
return ob_get_clean();