<?php
if ( $product && 'auction' === $product->get_type() ) {
	yit_delete_prop( $product, 'yith_wcact_new_bid' );

	$datetime     = $product->get_start_date();
	$from_auction = $datetime ? absint( $datetime ) : '';
	$from_auction = $from_auction ? get_date_from_gmt( gmdate( 'Y-m-d H:i:s', $from_auction ) ) : '';
	$datetime     = $product->get_end_date();
	$to_auction   = $datetime ? absint( $datetime ) : '';
	$to_auction   = $to_auction ? get_date_from_gmt( gmdate( 'Y-m-d H:i:s', $to_auction ) ) : '';
} else {
	$from_auction = '';
	$to_auction   = '';
}

ob_start();
?>

<p class="auction_dates wcfm_title auction"><strong><?php esc_html_e('Auction Dates', 'yith-auctions-for-woocommerce'); ?><span class="required">*</span></strong><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_html_e('Set the length of time for which the auction will run again. The auction will reset itself to the original auction product settings and all previous bids will be removed.', 'yith-auctions-for-woocommerce'); ?>" data-hasqtip="90"></span></p>
<label class="screen-reader-text" for="_yith_auction_dates"><?php esc_html_e('Set a start and end time for this auction', 'yith-auctions-for-woocommerce'); ?></label>
<div class="wcfm-auction-multiinput-fields">
    <input type="text" id="_yith_auction_for" name="_yith_auction_for" class="wcfm-text wcfm_ele auction multi_input_block_element" value="<?php echo esc_attr( $from_auction ); ?>" placeholder="YYYY-MM-DD hh:mm:ss" data-required="1" data-required_message="<?php esc_attr_e( __('Auction Dates', 'yith-auctions-for-woocommerce') . ': ' . __( 'This field is required.', 'wc-frontend-manager' ) ); ?>">
    <input type="text" id="_yith_auction_to" name="_yith_auction_to" class="wcfm-text wcfm_ele auction multi_input_block_element" value="<?php echo esc_attr( $to_auction ); ?>" placeholder="YYYY-MM-DD hh:mm:ss" data-required="1" data-required_message="<?php esc_attr_e( __('Auction Dates', 'yith-auctions-for-woocommerce') . ': ' . __( 'This field is required.', 'wc-frontend-manager' ) ); ?>">
</div>

<?php
return ob_get_clean();
