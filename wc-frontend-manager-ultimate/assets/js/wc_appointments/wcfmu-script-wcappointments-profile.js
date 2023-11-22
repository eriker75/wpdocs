jQuery( function( $ ) {
    'use strict';

    var wcfm_wc_appointments_profile = {
        init: function() {
            var $body = $( 'body' );
            $body.on( 'click', '.wcfm_oauth_redirect', this.wcfm_appointments_oauth_redirect );
            $body.on( 'click', '.wcfm_manual_sync', this.wcfm_appointments_manual_sync );
        },

        wcfm_appointments_oauth_redirect: function() {
			var el       = $( this ).closest( 'td' );
			var staff_id = $( this ).attr( 'data-staff' );
			var logout   = $( this ).attr( 'data-logout' );

			// Block removed element.
			$( el ).block( { message: null } );

			var data = {
				action: 'wcfm_oauth_redirect',
				staff_id: staff_id,
				logout: logout,
				security: wc_appointments_writepanel_js_params.nonce_oauth_redirect
			};

			$.post( wc_appointments_writepanel_js_params.ajax_url, data, function( response ) {
				if ( response.error ) {
					alert( response.error );
					$( el ).unblock();
				} else {
					top.location.replace( response.uri );
					$( el ).unblock();
				}
			} );
		},
        wcfm_appointments_manual_sync: function() {
			var el       = $( this ).closest( 'td' );
			var staff_id = $( this ).attr( 'data-staff' );

			// Block removed element.
			$( el ).block( { message: null } );

			var data = {
				action: 'wcfm_woocommerce_manual_sync',
				staff_id: staff_id,
				security: wc_appointments_writepanel_js_params.nonce_manual_sync
			};

			$.post( wc_appointments_writepanel_js_params.ajax_url, data, function( response ) {
				if ( response.error ) {
					alert( response.error );
					$( el ).unblock();
				} else {
					$( '.last_synced' ).html( response.html );
					$( el ).unblock();
				}
			} );
		},
    };

    wcfm_wc_appointments_profile.init();
});