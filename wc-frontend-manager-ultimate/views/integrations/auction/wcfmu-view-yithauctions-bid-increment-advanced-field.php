<?php
$automatic_bid_increment_advanced = $product && $auction_product ? $product->get_bid_increment_advanced() : array();
$automatic_bid_type               = $product && $auction_product ? yith_wcact_field_radio_value( 'bid_type_radio', 'bid_increment', $product, 'simple' ) : 'simple';

ob_start();
?>

<p class="bid_increment_advanced wcfm_title auction ywcact_show_if_bid_up ywcact_show_if_bid_up_set ywcact_show_if_advanced"><strong><?php echo esc_html__('Automatic bid increment', 'yith-auctions-for-woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')'; ?></strong><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_html_e('Set the bidding increment for automatic bidding. You can create more rules to set different bid increments based on the auction\'s current bid and then set a last rule to cover all the offers made after the last current bid step', 'yith-auctions-for-woocommerce'); ?>" data-hasqtip="90"></span></p>
<label class="screen-reader-text" for="bid_increment"><?php echo esc_html__('Automatic bid increment', 'yith-auctions-for-woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')'; ?></label>
<div class="wcfm-auction-multiinput-fields wcfm-yith-inline-fields">
<?php
    if ( ! empty( $automatic_bid_increment_advanced ) && is_array( $automatic_bid_increment_advanced ) && 'advanced' === $automatic_bid_type ) {
		$automatic_bid_increment = ! is_array( $automatic_bid_increment_advanced ) ? maybe_unserialize( $automatic_bid_increment_advanced ) : $automatic_bid_increment_advanced;
		$size                    = count( $automatic_bid_increment_advanced ) - 1;
		$html_block              = '';

        foreach ( $automatic_bid_increment_advanced as $key => $value ) {
			if ( 0 === $key ) {
                ?>
					<div class="ywcact-automatic-product-bid-increment-advanced-start ywcact-bid-increment-row">
						<span for="_yith_auction_bid_increment_advanced[0][end]" class="ywcact-span">
							<?php
								// translators: %s is the currency symbol.
								echo esc_html( sprintf( _x( 'With a current bid from start price to %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
							?>
						</span>
						<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="end"  name="_yith_auction_bid_increment_advanced[0][end]" value="<?php echo esc_attr( $value['end'] ); ?>">
						<span for="_yith_auction_bid_increment_advanced[0][value]" class="ywcact-span last">
							<?php
								// translators: %s is the currency symbol.
								echo esc_html( sprintf( _x( 'set an automatic bid increment of %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
							?>
						</span>
						<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="value"  name="_yith_auction_bid_increment_advanced[0][value]" value="<?php echo esc_attr( $value['value'] ); ?>">
                        <div class="borderTop"></div>
					</div>
				<?php
            } elseif ( $size === $key ) {
                ?>
					<div class="ywcact-automatic-product-bid-increment-advanced-end ywcact-bid-increment-row">
						<span for="_yith_auction_bid_increment_advanced[][start]" class="ywcact-span">
							<?php
								// translators: %s is the currency symbol.
								echo esc_html( sprintf( _x( 'Finally, with a current bid from %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
							?>
						</span>
						<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="start"  name="_yith_auction_bid_increment_advanced[<?php echo esc_attr( $key ); ?>][start]" value="<?php echo esc_attr( $value['start'] ); ?>">
						<span for="_yith_auction_bid_increment_advanced[][value]" class="ywcact-span last">
							<?php
								// translators: %s is the currency symbol.
								echo esc_html( sprintf( _x( 'onwards set an automatic bid increment of %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
							?>
						</span>
						<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="value"  name="_yith_auction_bid_increment_advanced[<?php echo esc_attr( $key ); ?>][value]" value="<?php echo esc_attr( $value['value'] ); ?>">
					</div>
				<?php
            } else {
                ?>
					<div class="ywcact-automatic-product-bid-increment-advanced-rule ywcact-bid-increment-row">
						<span for="_yith_auction_bid_increment_advanced[][]" class="ywcact-span">
							<?php
								// translators: %s is the currency symbol.
								echo esc_html( sprintf( _x( 'With a current bid from %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
							?>
						</span>
						<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="from"  name="_yith_auction_bid_increment_advanced[<?php echo esc_attr( $key ); ?>][from]" value="<?php echo esc_attr( $value['from'] ); ?>">
						<span for="_yith_auction_bid_increment_advanced[][]" class="ywcact-span">
							<?php
								// translators: %s is the currency symbol.
								echo esc_html( sprintf( _x( 'to %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
							?>
						</span>
						<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="to"  name="_yith_auction_bid_increment_advanced[<?php echo esc_attr( $key ); ?>][to]" value="<?php echo esc_attr( $value['to'] ); ?>">
						<span for="_yith_auction_bid_increment_advanced[][]" class="ywcact-span last">
							<?php
								// translators: %s is the currency symbol.
								echo esc_html( sprintf( _x( 'set an automatic bid increment of %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
							?>
						</span>
						<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="value"  name="_yith_auction_bid_increment_advanced[<?php echo esc_attr( $key ); ?>][value]" value="<?php echo esc_attr( $value['value'] ); ?>">
						<span class="wcfmfa fa-trash-alt ywcact-remove-rule"></span>
                        <div class="borderTop"></div>
					</div>
				<?php
            }
        }
    } else {
        ?>
			<div class="ywcact-automatic-product-bid-increment-advanced-start ywcact-bid-increment-row">
				<span for="_yith_auction_bid_increment_advanced[0][end]" class="">
					<?php
						// translators: %s is the currency symbol.
						echo esc_html( sprintf( _x( 'With a current bid from start price to %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
					?>
				</span>
				<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="end"  name="_yith_auction_bid_increment_advanced[0][end]" value="">
				<span for="_yith_auction_bid_increment_advanced[0][value]" class="">
					<?php
						// translators: %s is the currency symbol.
						echo esc_html( sprintf( _x( 'set an automatic bid increment of %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
					?>
				</span>
				<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="value" name="_yith_auction_bid_increment_advanced[0][value]" value="">
			</div>

			<!-- Here the other labels-->
			<div class="ywcact-automatic-product-bid-increment-advanced-end ywcact-bid-increment-row">
				<span for="_yith_auction_bid_increment_advanced[][start]" class="ywcact-span">
					<?php
						// translators: %s is the currency symbol.
						echo esc_html( sprintf( _x( 'Finally, with a current bid from %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
					?>
				</span>
				<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="start"  name="_yith_auction_bid_increment_advanced[1][start]" value="">
				<span for="_yith_auction_bid_increment_advanced[][value]" class="ywcact-span last">
					<?php
						// translators: %s is the currency symbol.
						echo esc_html( sprintf( _x( 'onwards set an automatic bid increment of %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
					?>
				</span>
				<input type="number" step="0.01" class="wcfm_ele auction" data-input-type="value"  name="_yith_auction_bid_increment_advanced[1][value]" value="">
			</div>
		<?php
    }
?>

    <!--Hidden rule-->
    <div class="ywcact-automatic-product-bid-increment-advanced-rule ywcact-hide">
        <span for="_yith_auction_bid_increment_advanced[][]" class="">
            <?php
                // translators: %s is the currency symbol.
                echo esc_html( sprintf( _x( 'With a current bid from %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
            ?>
        </span>
        <input type="number" step="0.01" class="ywcact-input-product-number" data-input-type="from"  name="_yith_auction_bid_increment_advanced_dummy[][from]" value="">
        <span for="_yith_auction_bid_increment_advanced[][]" class="">
            <?php
                // translators: %s is the currency symbol.
                echo esc_html( sprintf( _x( 'to %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
            ?>
        </span>
        <input type="number" step="0.01" class="ywcact-input-product-number" data-input-type="to"  name="_yith_auction_bid_increment_advanced_dummy[][to]" value="">
        <span for="_yith_auction_bid_increment_advanced[][]" class="ywcact-span last">
            <?php
                // translators: %s is the currency symbol.
                echo esc_html( sprintf( _x( 'set an automatic bid increment of %s ', 'Set an automatic bid increment of €', 'yith-auctions-for-woocommerce' ), get_woocommerce_currency_symbol() ) );
            ?>
        </span>
        <input type="number" step="0.01" class="ywcact-input-product-number" data-input-type="value"  name="_yith_auction_bid_increment_advanced_dummy[][value]" value="">
        <span class="wcfmfa fa-trash-alt ywcact-remove-rule"></span>
        <div class="borderTop"></div>
    </div>
    <div>
        <a class="ywcact-product-add-rule">+ <?php echo esc_html__( 'add rule', 'yith-auctions-for-woocommerce' ); ?></a>
    </div>
</div>

<?php
return ob_get_clean();
