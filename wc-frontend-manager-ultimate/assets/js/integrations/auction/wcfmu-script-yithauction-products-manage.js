/**
 * @reference : yith-woocommerce-auctions-premium/assets/js/admin-settings-sections.js
 */
jQuery( function($) {

    var wcfmYithFieldsVisibility = {
        showPrefix        : '.ywcact_show_if_',

        conditions        : {
            buy_now                 : 'buy_now',
            overtime                : 'overtime',
            overtime_set            : 'overtime_set',
            fee                     : 'fee',
            ask_fee                 : 'ask_fee',
            reschedule              : 'reschedule',
            reschedule_no_bids      : 'reschedule_without_bids',
            reschedule_no_reserve   : 'reschedule_reserve_price',
            simple_rule             : 'simple',
            advanced_rule           : 'advanced',
            bid_up                  : 'bid_up',
            bid_up_set              : 'bid_up_set',
            auction_normal          : 'auction_normal',
            commission_fee          : 'commission_fee',
            apply_commission_fee    : 'apply_commission_fee',
        },
        dom               : {
            buyNowOff               : $( 'input[name="_yith_auction_buy_now_onoff"]' ),
            oVertime                : $( 'input[name="_yith_auction_overtime_onoff"]' ),
            oVertime_Set            : $( 'input[name="_yith_auction_overtime_set_onoff"' ),
            Fee                     : $( 'input[name="_yith_auction_fee_onoff"]' ),
            Ask_Fee                 : $( 'input[name="_yith_auction_fee_ask_onoff"]' ),
            rEschedule              : $( 'input[name="_yith_auction_reschedule_onoff"]' ),
            rEschedule_no_bids      : $( 'input[name="_yith_auction_reschedule_closed_without_bids_onoff"]' ),
            rEschedule_no_reserve   : $( 'input[name="_yith_auction_reschedule_reserve_no_reached_onoff"]' ),
            bId_type                : $( 'input[name="_yith_wcact_bid_type_radio"]' ),
            bId_type_set            : $( 'input[name="_yith_wcact_bid_type_set_radio"]' ),
            bId_type_OnOff          : $( 'input[name="_yith_auction_bid_type_onoff"]' ),
            aUction_type            : $( 'input[name="_yith_wcact_auction_type"]' ),
            Commission_Fee          : $( 'input[name="_yith_auction_commission_fee_onoff"]' ),
            Apply_Commission_Fee    : $( 'input[name="_yith_auction_commission_apply_fee_onoff"]' ),

        },
        init              : function () {
            var self = wcfmYithFieldsVisibility;

            // Buy now onff enabled
           self.dom.buyNowOff.on( 'change', function () {
                self.handle( self.conditions.buy_now, true === self.dom.buyNowOff.is(':checked') );
            } ).trigger( 'change' );

            // Overtime onoff enabled
            self.dom.oVertime.on( 'change', function () {
                self.handle( self.conditions.overtime, true === self.dom.oVertime.is(':checked') );
                self.dom.oVertime_Set.trigger('change');
            } ).trigger( 'change' );

            self.dom.oVertime_Set.on( 'change', function () {
                self.handle( self.conditions.overtime_set, true === self.dom.oVertime.is(':checked') && true === self.dom.oVertime_Set.is(':checked') );
            } ).trigger( 'change' );

            // fee onoff enabled
            self.dom.Fee.on( 'change', function () {
                self.handle( self.conditions.fee, true === self.dom.Fee.is(':checked') );
                self.dom.Ask_Fee.trigger('change');
            } ).trigger( 'change' );
            // fee onoff enabled
            self.dom.Ask_Fee.on( 'change', function () {
                self.handle( self.conditions.ask_fee, true === self.dom.Ask_Fee.is(':checked') && true === self.dom.Fee.is(':checked') );
            } ).trigger( 'change' );


            // reschedule onoff enabled
            self.dom.rEschedule.on( 'change', function () {
                self.handle( self.conditions.reschedule, true === self.dom.rEschedule.is(':checked') );
                self.dom.rEschedule_no_bids.trigger( 'change' );
            } ).trigger( 'change' );
            self.dom.rEschedule_no_bids.on( 'change', function () {
                self.handle( self.conditions.reschedule_no_bids, true === self.dom.rEschedule.is(':checked') && ( true === self.dom.rEschedule_no_bids.is(':checked') || true === self.dom.rEschedule_no_reserve.is(':checked') )  );
            } ).trigger( 'change' );
            self.dom.rEschedule_no_reserve.on( 'change', function () {
                self.handle( self.conditions.reschedule_no_reserve, true === self.dom.rEschedule.is(':checked') && ( true === self.dom.rEschedule_no_reserve.is(':checked') || true === self.dom.rEschedule_no_bids.is(':checked')  )  );
            } ).trigger( 'change' );

            //Bid type onoff
            // reschedule onoff enabled
            self.dom.bId_type_OnOff.on( 'change', function () {
                self.handle( self.conditions.bid_up, true === self.dom.bId_type_OnOff.is(':checked') );
                self.dom.bId_type_set.trigger('change');
            } ).trigger( 'change' );
            //Bid type set
            self.dom.bId_type_set.on( 'change', function () {
                self.handle( self.conditions.bid_up_set, true === self.dom.bId_type_OnOff.is(':checked') && 'automatic' === self.dom.bId_type_set.filter(':checked').val() );
                self.dom.bId_type.trigger( 'change' );
            } ).trigger( 'change' );
            //Bid type radiobutton
            self.dom.bId_type.on( 'change', function () {

                if( true === self.dom.bId_type_OnOff.is(':checked') && 'automatic' === self.dom.bId_type_set.filter(':checked').val() ) {
                    self.handle( self.conditions.simple_rule, 'simple' === self.dom.bId_type.filter(':checked').val() );
                    self.handle( self.conditions.advanced_rule, 'advanced' === self.dom.bId_type.filter(':checked').val() );
                }

            } ).trigger( 'change' );

            //Auction type options
            self.dom.aUction_type.on( 'change', function () {

                self.handle( self.conditions.auction_normal, 'normal' === self.dom.aUction_type.filter(':checked').val() );
                self.change_decrement( self.dom.aUction_type.filter(':checked').val() );

            } ).trigger( 'change' );

            /* == Commission Fee */
            self.dom.Commission_Fee.on( 'change', function () {

                self.handle( self.conditions.commission_fee, true === self.dom.Commission_Fee.is(':checked') );
                self.dom.Apply_Commission_Fee.trigger('change');

            } ).trigger( 'change' );

            /* == Apply Commission Fee */

            self.dom.Apply_Commission_Fee.on( 'change', function () {

                self.handle( self.conditions.apply_commission_fee, true === self.dom.Apply_Commission_Fee.is(':checked') && true === self.dom.Commission_Fee.is(':checked') );

            } ).trigger( 'change' );

            if( $('.wcfm-tabWrap').find('.page_collapsible:visible:first').hasClass('products_manage_yithauction') ) {
                $('.wcfm-tabWrap').find('.page_collapsible:visible:first').click();
            }

        },
        handle            : function ( target, condition ) {
            var targetHide    = wcfmYithFieldsVisibility.showPrefix + target;

            if ( condition ) {
                $( targetHide ).parents('.wcfm-field').show();
            } else {
                $( targetHide ).parents('.wcfm-field').hide();
            }

            resetCollapsHeight($('#wcfm_products_manage_form_yithauction_expander'));
        },

        change_decrement : function ( condition ) { // Set labels on minimun increment amount section on product page

            if( 'normal' === condition ) {

                $('._yith_auction_minimum_increment_amount strong').html(wcfmu_yithauction_products_manage_settings_section.minimun_increment_amount);
                $('._yith_auction_minimum_increment_amount span.img_tip').attr( 'data-tip', wcfmu_yithauction_products_manage_settings_section.minimun_increment_amount_desc );

            } else {

                $('._yith_auction_minimum_increment_amount strong').html(wcfmu_yithauction_products_manage_settings_section.minimun_decrement_amount);
                $('._yith_auction_minimum_increment_amount span.img_tip').attr( 'data-tip', wcfmu_yithauction_products_manage_settings_section.minimun_decrement_amount_desc );

            }

        }
    };

    wcfmYithFieldsVisibility.init();

    $('.ywcact-add-rule').prependTo($('.ywcact-automatic-bid-increment-advanced-end'));
    $('.ywcact-product-add-rule').prependTo($('.ywcact-automatic-product-bid-increment-advanced-end'));


    $('.ywcact-product-add-rule').on('click',function (e) {

        let row = $( '.ywcact-automatic-product-bid-increment-advanced-rule:last' ).clone().css( {'display': 'none'} );
        let numItems = $('.ywcact-bid-increment-row').length;
        row.find( 'input' ).val( '' );
        row.insertBefore( $( ".ywcact-automatic-product-bid-increment-advanced-end" ) );
        row.removeClass('ywcact-hide');
        row.addClass('ywcact-bid-increment-row');
        $(row).find('.ywcact-remove-rule').bind("click", function() {
            row.remove();
            reassign_id();
        });

        let inputs = $( row ).find( "input" );
        let actualinput = parseInt(numItems) - 1;

        $(inputs).each(function (i) {
            let data_type = $(this).data('input-type');
            $(this).attr('name','_yith_auction_bid_increment_advanced['+actualinput+']['+data_type+']');
        });

        let end = $( ".ywcact-automatic-product-bid-increment-advanced-end" );
        let inputs_end = $( end ).find( "input" );
        $(inputs_end).each(function (i) {
            let data_type = $(this).data('input-type');
            $(this).attr('name','_yith_auction_bid_increment_advanced['+numItems+']['+data_type+']');
        });


        row.fadeTo(
            400,
            1,
            function () {
                row.css( {'display': 'block'} );
            }
        );
    });


    $('.ywcact-remove-rule').on('click',function () { //COntar de nuevo los inputs

        let row = $(this).closest('.ywcact-automatic-product-bid-increment-advanced-rule');

        row.remove();
        reassign_id();

    });

    function reassign_id() {
        $('.ywcact-bid-increment-row').each(function (j) {

            let inputs = $( this ).find( "input" );

            $(inputs).each(function (i) {
                let data_type = $(this).data('input-type');
                $(this).attr('name','_yith_auction_bid_increment_advanced['+j+']['+data_type+']');
            });
        });
    }

    $('#reshedule_button').on('click',function(){
		$('#wcfm_products_manage_form_yithauction_expander').block({message:null, overlayCSS:{background:"#fff",opacity:.6}});
		var post_data = {
			'id': wcfmu_yithauction_products_manage_settings_section.id,
			security: wcfmu_yithauction_products_manage_settings_section.reschedule_product,
			action: 'yith_wcact_reshedule_product'
		};

		$.ajax({
			type    : "POST",
			data    : post_data,
			url     : wcfmu_yithauction_products_manage_settings_section.ajaxurl,
			success : function ( response ) {
				$('#wcfm_products_manage_form_yithauction_expander').unblock();
				$('#reshedule_button').hide();
				$('#yith-reshedule-notice-admin').show();
			},
			complete: function () {
			}
		});
	});

});
