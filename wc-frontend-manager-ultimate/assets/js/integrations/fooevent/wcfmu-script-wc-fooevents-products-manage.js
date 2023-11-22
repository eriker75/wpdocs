(function ($) {
	jQuery( '.woocommerce-events-color-field' ).wpColorPicker();
	if (jQuery( "#WooCommerceEventsEvent" ).length) {
		checkEventForm();

		jQuery( '#WooCommerceEventsEvent' ).change(
			function () {
				checkEventForm();
			}
		)

		if ((typeof localObj === "object") && (localObj !== null)) {
			jQuery( '#WooCommerceEventsDate' ).datepicker(
				{
					showButtonPanel: true,
					closeText: localObj.closeText,
					currentText: localObj.currentText,
					monthNames: localObj.monthNames,
					monthNamesShort: localObj.monthNamesShort,
					dayNames: localObj.dayNames,
					dayNamesShort: localObj.dayNamesShort,
					dayNamesMin: localObj.dayNamesMin,
					dateFormat: localObj.dateFormat,
					firstDay: localObj.firstDay,
					isRTL: localObj.isRTL
				}
			);
		} else {
			jQuery( '#WooCommerceEventsDate' ).datepicker();
		}

		if ((typeof localObj === "object") && (localObj !== null)) {
			jQuery( '#WooCommerceEventsEndDate' ).datepicker(
				{
					showButtonPanel: true,
					closeText: localObj.closeText,
					currentText: localObj.currentText,
					monthNames: localObj.monthNames,
					monthNamesShort: localObj.monthNamesShort,
					dayNames: localObj.dayNames,
					dayNamesShort: localObj.dayNamesShort,
					dayNamesMin: localObj.dayNamesMin,
					dateFormat: localObj.dateFormat,
					firstDay: localObj.firstDay,
					isRTL: localObj.isRTL
				}
			);
		} else {
			jQuery( '#WooCommerceEventsEndDate' ).datepicker();
		}

		if ((typeof localObj === "object") && (localObj !== null)) {
			jQuery( '#WooCommerceEventsExpire, #WooCommerceEventsTicketsExpireSelect' ).datepicker(
				{
					showButtonPanel: true,
					closeText: localObj.closeText,
					currentText: localObj.currentText,
					monthNames: localObj.monthNames,
					monthNamesShort: localObj.monthNamesShort,
					dayNames: localObj.dayNames,
					dayNamesShort: localObj.dayNamesShort,
					dayNamesMin: localObj.dayNamesMin,
					dateFormat: localObj.dateFormat,
					firstDay: localObj.firstDay,
					isRTL: localObj.isRTL
				}
			);
		} else {
			jQuery( '#WooCommerceEventsExpire, #WooCommerceEventsTicketsExpireSelect' ).datepicker();
		}

		var fileInput = '';

		jQuery( '#wcfm_products_manage_form_wc_fooevents_expander' ).on(
			'click',
			'.upload_image_button_woocommerce_events',
			function (e) {
				e.preventDefault();

				var button = jQuery( this );
				var id     = jQuery( this ).parent().prev( 'input.uploadfield' );

				wp.media.editor.send.attachment = function (props, attachment) {
					id.val( attachment.url );
				};

				wp.media.editor.open( button );
				return false;
			}
		);

		jQuery( '.upload_reset' ).click(
			function (e) {
				e.preventDefault();
				jQuery( this ).siblings( 'input.uploadfield' ).val( '' );
			}
		);

		// user inserts file into post. only run custom if user started process using the above process
		// window.send_to_editor(html) is how wp would normally handle the received data
		window.original_send_to_editor = window.send_to_editor;
		window.send_to_editor          = function (html) {
			window.original_send_to_editor( html );
		};

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommerceEventsExportUnpaidTickets',
			function (e) {
				showUpdateMessageBadges();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommerceEventsExportBillingDetails',
			function (e) {
				showUpdateMessageBadges();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommerceBadgeSize',
			function (e) {
				showUpdateMessageBadges();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommerceBadgeField1',
			function (e) {
				showUpdateMessageBadges();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommerceBadgeField2',
			function (e) {
				showUpdateMessageBadges();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommerceBadgeField3',
			function (e) {
				showUpdateMessageBadges();
			}
		);

		jQuery( 'input[type=radio][name=WooCommerceEventsPrintTicketLogoOption]' ).on(
			'change',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommerceEventsPrintTicketLogo',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField1',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField1_font',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField2',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField2_font',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField3',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField3_font',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField4',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField4_font',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField5',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField5_font',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField6',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);

		jQuery( '.wrap' ).on(
			'change',
			'#WooCommercePrintTicketField6_font',
			function (e) {
				showUpdateMessagePrintTickets();
			}
		);
	}//end if

	function showUpdateMessageBadges()
	{
		jQuery( '#WooCommerceBadgeMessage' ).html( 'Update product for attendee badge options to take affect.' );
	}

	function showUpdateMessagePrintTickets()
	{
		jQuery( '#WooCommercePrintTicketMessage' ).html( 'Update product for ticket printing options to take affect.' );
	}

	// Start functions
	function checkEventForm()
	{
		var WooCommerceEventsEvent = jQuery( '#WooCommerceEventsEvent' ).val();
		if (WooCommerceEventsEvent == 'Event') {
			jQuery( '#WooCommerceEventsForm' ).show();
		} else {
			jQuery( '#WooCommerceEventsForm' ).hide();
		}

		resetCollapsHeight( jQuery( '#WooCommerceEventsForm' ) );
	}
})( jQuery );

(function ($) {
	if (jQuery( 'input[name=WooCommerceEventsType]' ).length) {
		if ((typeof localObj === "object") && (localObj !== null)) {
			jQuery( '.WooCommerceEventsSelectDate' ).datepicker(
				{
					showButtonPanel: true,
					closeText: localObj.closeText,
					currentText: localObj.currentText,
					monthNames: localObj.monthNames,
					monthNamesShort: localObj.monthNamesShort,
					dayNames: localObj.dayNames,
					dayNamesShort: localObj.dayNamesShort,
					dayNamesMin: localObj.dayNamesMin,
					dateFormat: localObj.dateFormat,
					firstDay: localObj.firstDay,
					isRTL: localObj.isRTL
				}
			);
		} else {
			jQuery( '.WooCommerceEventsSelectDate' ).datepicker();
		}//end if

		var event_type = jQuery( 'input[name=WooCommerceEventsType]:checked' ).val();

		if (event_type == 'single') {
			display_select_date_inputs( localObj.dayTerm );
			fooevents_event_type_single_show();
		}

		if (event_type == 'sequential') {
			fooevents_event_type_sequential_show();
		}

		if (event_type == 'select') {
			var changed = true;
			display_select_date_inputs_np();
			fooevents_event_type_select_show( changed );
		}

		if (event_type == 'bookings') {
			display_select_date_inputs( localObj.dayTerm );
			fooevents_event_type_bookings_show();
		}

		if (event_type == 'seating') {
			display_select_date_inputs( localObj.dayTerm );
			fooevents_event_type_seating_show();
		}

		jQuery( 'input[name=WooCommerceEventsType]' ).change(
			function () {
				var event_type = this.value;

				if (event_type == 'single') {
					display_select_date_inputs( localObj.dayTerm );
					fooevents_event_type_single_show();
				}

				if (event_type == 'sequential') {
					fooevents_event_type_sequential_show();
				}

				if (event_type == 'select') {
					var changed = true;
					display_select_date_inputs( localObj.dayTerm );
					fooevents_event_type_select_show( changed );
				}

				if (event_type == 'bookings') {
					display_select_date_inputs( localObj.dayTerm );
					fooevents_event_type_bookings_show();
				}

				if (event_type == 'seating') {
					display_select_date_inputs( localObj.dayTerm );
					fooevents_event_type_seating_show();
				}
			}
		);

		jQuery( '#WooCommerceEventsNumDays' ).change(
			function () {
				var event_type = jQuery( 'input[name=WooCommerceEventsType]:checked' ).val();

				if (event_type == 'select') {
					hide_start_end_date();
					display_select_date_inputs( localObj.dayTerm );
				}
			}
		);
	}//end if

	function fooevents_event_type_single_show()
	{
		jQuery( '#WooCommerceEventsEndDateContainer' ).hide();
		jQuery( '#WooCommerceEventsSelectDateContainer' ).hide();
		jQuery( '#WooCommerceEventsSelectGlobalTimeContainer' ).hide();
		jQuery( '#WooCommerceEventsNumDaysContainer' ).hide();
		jQuery( '#WooCommerceEventsTimeContainer' ).show();
		jQuery( '#WooCommerceEventsEndTimeContainer' ).show();
		jQuery( '#WooCommerceEventsTimezoneContainer' ).show();
		jQuery( '#WooCommerceEventsDateContainer' ).show();
	}

	function fooevents_event_type_sequential_show()
	{
		jQuery( '#WooCommerceEventsDateContainer' ).show();
		jQuery( '#WooCommerceEventsEndDateContainer' ).show();
		jQuery( '#WooCommerceEventsSelectDateContainer' ).hide();
		jQuery( '#WooCommerceEventsNumDaysContainer' ).show();
	}

	function fooevents_event_type_select_show(changed)
	{
		jQuery( '#WooCommerceEventsDateContainer' ).hide();
		jQuery( '#WooCommerceEventsEndDateContainer' ).hide();
		jQuery( '#WooCommerceEventsSelectDateContainer' ).show();
		jQuery( '#WooCommerceEventsNumDaysContainer' ).show();

		if (changed) {
			fooevents_display_select_date_inputs( localObj.dayTerm );
		}
	}

	function fooevents_event_type_bookings_show()
	{
		jQuery( '#WooCommerceEventsDateContainer' ).hide();
		jQuery( '#WooCommerceEventsEndDateContainer' ).hide();
		jQuery( '#WooCommerceEventsSelectDateContainer' ).hide();
		jQuery( '#WooCommerceEventsNumDaysContainer' ).hide();
		jQuery( '#WooCommerceEventsTimeContainer' ).hide();
		jQuery( '#WooCommerceEventsEndTimeContainer' ).hide();
		// jQuery('#WooCommerceEventsTimezoneContainer').hide();
	}

	function fooevents_event_type_seating_show()
	{
		jQuery( '#WooCommerceEventsEndDateContainer' ).hide();
		jQuery( '#WooCommerceEventsSelectDateContainer' ).hide();
		jQuery( '#WooCommerceEventsNumDaysContainer' ).hide();
		jQuery( '#WooCommerceEventsDateContainer' ).show();
		jQuery( '#WooCommerceEventsTimeContainer' ).show();
		jQuery( '#WooCommerceEventsEndTimeContainer' ).show();
		jQuery( '#WooCommerceEventsTimezoneContainer' ).show();
		jQuery( '#WooCommerceEventsTimeContainer' ).show();
		jQuery( '#WooCommerceEventsEndTimeContainer' ).show();
		jQuery( '#WooCommerceEventsTimezoneContainer' ).show();
	}

	if (jQuery( 'input[name=WooCommerceEventsMultiDayType]' ).length) {
		if ((typeof localObj === "object") && (localObj !== null)) {
			jQuery( '.WooCommerceEventsSelectDate' ).datepicker(
				{
					showButtonPanel: true,
					closeText: localObj.closeText,
					currentText: localObj.currentText,
					monthNames: localObj.monthNames,
					monthNamesShort: localObj.monthNamesShort,
					dayNames: localObj.dayNames,
					dayNamesShort: localObj.dayNamesShort,
					dayNamesMin: localObj.dayNamesMin,
					dateFormat: localObj.dateFormat,
					firstDay: localObj.firstDay,
					isRTL: localObj.isRTL
				}
			);
		} else {
			jQuery( '.WooCommerceEventsSelectDate' ).datepicker();
		}//end if

		var multiDayType = jQuery( 'input[name=WooCommerceEventsMultiDayType]:checked' ).val();

		if (multiDayType == 'select') {
			hide_start_end_date();
			display_select_date_inputs_np();
		}

		if (multiDayType == 'sequential') {
			show_start_end_date();
			hide_select_date_inputs();
		}

		jQuery( 'input[name=WooCommerceEventsMultiDayType]' ).change(
			function () {
				var multiDayType = this.value;

				if (multiDayType == 'select') {
					hide_start_end_date();
					display_select_date_inputs( localObj.dayTerm );
				}

				if (multiDayType == 'sequential') {
					show_start_end_date();
					hide_select_date_inputs();
				}
			}
		);

		jQuery( '#WooCommerceEventsNumDays' ).change(
			function () {
				var multiDayType = jQuery( 'input[name=WooCommerceEventsMultiDayType]:checked' ).val();

				if (multiDayType == 'select') {
					hide_start_end_date();
					display_select_date_inputs( localObj.dayTerm );
				}
			}
		);
	}//end if

	function hide_start_end_date()
	{
		jQuery( '#WooCommerceEventsEndDateContainer' ).hide();
		jQuery( '#WooCommerceEventsDateContainer' ).hide();
	}

	function show_start_end_date()
	{
		jQuery( '#WooCommerceEventsEndDateContainer' ).show();
		jQuery( '#WooCommerceEventsDateContainer' ).show();
	}

	function show_select_date_inputs()
	{
		jQuery( '#WooCommerceEventsDateContainer' ).hide();
	}

	function hide_select_date_inputs()
	{
		jQuery( '#WooCommerceEventsSelectDateContainer' ).hide();
	}

	function display_select_date_inputs_np()
	{
		jQuery( '#WooCommerceEventsSelectDateContainer' ).show();
	}

	function display_select_date_inputs(dayTerm)
	{
		jQuery( '#WooCommerceEventsSelectDateContainer' ).show();

		var numDays = jQuery( '#WooCommerceEventsNumDays' ).val();
		// alert(numDays);
		// jQuery('#WooCommerceEventsMultiDayTypeHolder').after('<div id="space">Test</div>');
		var dateFields = '';
		for (var i = 1; i <= numDays; i++) {
			dateFields += '<p class="form-field">';
			dateFields += '<span class="wcfm_title"><strong>' + dayTerm + ' ' + i + '</strong></span>';
			dateFields += '<input type="text" class="WooCommerceEventsSelectDate wcfm-text" name="WooCommerceEventsSelectDate[]" value=""/>';
			dateFields += '</p>';
		}

		jQuery( '#WooCommerceEventsSelectDateContainer' ).html( dateFields );

		if ((typeof localObj === "object") && (localObj !== null)) {
			jQuery( '.WooCommerceEventsSelectDate' ).datepicker(
				{
					showButtonPanel: true,
					closeText: localObj.closeText,
					currentText: localObj.currentText,
					monthNames: localObj.monthNames,
					monthNamesShort: localObj.monthNamesShort,
					dayNames: localObj.dayNames,
					dayNamesShort: localObj.dayNamesShort,
					dayNamesMin: localObj.dayNamesMin,
					dateFormat: localObj.dateFormat,
					firstDay: localObj.firstDay,
					isRTL: localObj.isRTL
				}
			);
		} else {
			jQuery( '.WooCommerceEventsSelectDate' ).datepicker();
		}
	}
})( jQuery );


(function ($) {
	var typing_timer;
	var done_typing_interval = 800;

	jQuery( '#fooevents_custom_attendee_fields_new_field' ).on(
		'click',
		function () {
			fooevents_new_attendee_field();
			resetCollapsHeight( jQuery( '#WooCommerceEventsForm' ) );
			return false;
		}
	);

	jQuery( '#fooevents_custom_attendee_fields_options_table' ).on(
		'click',
		'.fooevents_custom_attendee_fields_remove',
		function (event) {
			fooevents_delete_attendee_field( jQuery( this ) );
			return false;
		}
	);

	jQuery( '#fooevents_custom_attendee_fields_options_table' ).on(
		'keyup',
		'.fooevents_custom_attendee_fields_label',
		function (event) {
			clearTimeout( typing_timer );
			typing_timer = setTimeout( fooevents_update_attendee_row_ids, done_typing_interval, jQuery( this ) );
			return false;
		}
	);

	jQuery( '#fooevents_custom_attendee_fields_options_table' ).on(
		'keyup',
		'.fooevents_custom_attendee_fields_options',
		function (event) {
			fooevents_serialize_options();
			return false;
		}
	);

	jQuery( '#fooevents_custom_attendee_fields_options_table' ).on(
		'keydown',
		'.fooevents_custom_attendee_fields_label',
		function (event) {
			clearTimeout( typing_timer );
		}
	);

	jQuery( '#fooevents_custom_attendee_fields_options_table' ).on(
		'change',
		'.fooevents_custom_attendee_fields_req',
		function (event) {
			fooevents_serialize_options();
		}
	);

	jQuery( '#fooevents_custom_attendee_fields_options_table' ).on(
		'change',
		'.fooevents_custom_attendee_fields_type',
		function (event) {
			fooevents_serialize_options();
			fooevents_enable_disable_options( jQuery( this ) );
		}
	);

	jQuery( '#fooevents_custom_attendee_fields_options_table' ).on(
		'change',
		'.fooevents_custom_attendee_fields_def',
		function (event) {
			fooevents_serialize_options();
			fooevents_enable_disable_options( jQuery( this ) );
		}
	);

	fooevents_serialize_options();
})( jQuery );

function fooevents_new_attendee_field()
{
	var opt_num  = jQuery( '#fooevents_custom_attendee_fields_options_table tr' ).length;
	var field_id = fooevents_custom_attendees_make_id( 20 );

	var label   = '<input type="text" id="' + field_id + '_label" name="' + field_id + '_label" class="fooevents_custom_attendee_fields_label" value="Label_' + opt_num + '" autocomplete="off" maxlength="50" />';
	var type    = '<select id="' + field_id + '_type" name="' + field_id + '_type" class="fooevents_custom_attendee_fields_type"><option value="text">Text</option><option value="textarea">Textarea</option><option value="select">Select</option><option value="checkbox">Checkbox</option><option value="radio">Radio</option><option value="country">Country</option><option value="date">Date</option><option value="time">Time</option><option value="email">Email</option><option value="url">URL</option><option value="numbers">Numbers</option><option value="alphabet">Alphabet</option><option value="alphanumeric">Alphanumeric</option></select>';
	var options = '<input id="' + field_id + '_options" name="' + field_id + '_options" class="fooevents_custom_attendee_fields_options" type="text" disabled autocomplete="off" />';
	var def     = '<input id="' + field_id + '_def" name="' + field_id + '_def" type="text" class="fooevents_custom_attendee_fields_def" disabled autocomplete="off" />';
	var req     = '<select id="' + field_id + '_req" name="' + field_id + '_req" class="fooevents_custom_attendee_fields_req"><option value="true">Yes</option><option value="false">No</option></select>';
	var remove  = '<a href="#" id="' + field_id + '_remove" name="' + field_id + '_remove" class="fooevents_custom_attendee_fields_remove" class="fooevents_custom_attendee_fields_remove">[X]</a>';

	var new_field = '<tr id="' + field_id + '" class="fooevents_custom_attendee_fields_option"><td>' + label + '</td><td>' + type + '</td><td>' + options + '</td><td>' + def + '</td><td>' + req + '</td><td>' + remove + '</td></tr>';
	jQuery( '#fooevents_custom_attendee_fields_options_table tbody' ).append( new_field );

}

function fooevents_delete_attendee_field(row)
{
	row.closest( 'tr' ).remove();
	fooevents_serialize_options();

}

function fooevents_change_attendee_field_type(row)
{
	row.closest( '.fooevents_custom_attendee_fields_options' ).remove();

}

function fooevents_update_attendee_row_ids(row)
{
	/*var row_num = row.closest('tr').index()+1;
	var value = fooevents_encode_input(row.val());

	var new_label_id = value+'_label';
	var new_type_id = value+'_type';
	var new_options_id = value+'_options';
	var new_req_id = value+'_req';
	var new_remove_id = value+'_remove';
	var new_option_id = value+'_option';

	fooevents_check_if_label_exists(value);

	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_label').attr("id", new_label_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_label').attr("name", new_label_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_type').attr("id", new_type_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_type').attr("name", new_type_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_options').attr("id", new_options_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_options').attr("name", new_options_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_req').attr("id", new_req_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_req').attr("name", new_req_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_remove').attr("id", new_remove_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+') .fooevents_custom_attendee_fields_remove').attr("name", new_remove_id);
	jQuery('#fooevents_custom_attendee_fields_options_table tr:eq('+row_num+')').attr("id", new_option_id);
	*/
	fooevents_serialize_options();

}

function fooevents_get_row_option_names()
{
	var IDs = [];
	jQuery( "#fooevents_custom_attendee_fields_options_table" ).find( "tr" ).each(
		function () {
			IDs.push( this.id );
		}
	);

	return IDs;

}

function fooevents_serialize_options()
{
	var data     = {};
	var item_num = 0;
	jQuery( '#fooevents_custom_attendee_fields_options_table' ).find( 'tr' ).each(
		function () {
			var id = jQuery( this ).attr( 'id' );
			if (item_num) {
				var row = {};
				jQuery( this ).find( 'input,select,textarea' ).each(
					function () {
						row[jQuery( this ).attr( 'name' )] = jQuery( this ).val();
					}
				);
				data[id] = row;
			}

			item_num++;
		}
	);

	data = JSON.stringify( data );

	jQuery( '#fooevents_custom_attendee_fields_options_serialized' ).val( data );

}

function fooevents_enable_disable_options(row)
{
	var row_num     = row.closest( 'tr' ).index() + 1;
	var option_type = jQuery( '#fooevents_custom_attendee_fields_options_table tr:eq(' + row_num + ') .fooevents_custom_attendee_fields_type' ).val();
	if (option_type == 'select' || option_type == 'radio') {
		jQuery( '#fooevents_custom_attendee_fields_options_table tr:eq(' + row_num + ') .fooevents_custom_attendee_fields_options' ).prop( "disabled", false );
		jQuery( '#fooevents_custom_attendee_fields_options_table tr:eq(' + row_num + ') .fooevents_custom_attendee_fields_def' ).prop( "disabled", false );
	} else {
		jQuery( '#fooevents_custom_attendee_fields_options_table tr:eq(' + row_num + ') .fooevents_custom_attendee_fields_options' ).prop( "disabled", true );
		jQuery( '#fooevents_custom_attendee_fields_options_table tr:eq(' + row_num + ') .fooevents_custom_attendee_fields_options' ).val( "" );
		jQuery( '#fooevents_custom_attendee_fields_options_table tr:eq(' + row_num + ') .fooevents_custom_attendee_fields_def' ).prop( "disabled", true );
		jQuery( '#fooevents_custom_attendee_fields_options_table tr:eq(' + row_num + ') .fooevents_custom_attendee_fields_def' ).val( "" );
	}

	fooevents_serialize_options();

}


(function ($) {
	var typing_timer;
	var done_typing_interval = 800;

	jQuery( '#fooevents_seating_new_field' ).on(
		'click',
		function () {
			fooevents_seating_new_row_field();
			resetCollapsHeight( jQuery( '#WooCommerceEventsForm' ) );
			return false;
		}
	);

	jQuery( '#fooevents_seating_options_table' ).on(
		'click',
		'.fooevents_seating_remove',
		function (event) {
			fooevents_seating_delete_row_field( jQuery( this ) );
			return false;
		}
	);

	jQuery( '#fooevents_seating_options_table' ).on(
		'keyup',
		'.fooevents_seating_row_name, .fooevents_seating_options',
		function (event) {
			clearTimeout( typing_timer );
			typing_timer = setTimeout( fooevents_update_row_row_ids, done_typing_interval, jQuery( this ) );
			return false;
		}
	);

	jQuery( '#fooevents_seating_options_table' ).on(
		'keydown',
		'.fooevents_seating_row_name, .fooevents_seating_options',
		function (event) {
			clearTimeout( typing_timer );
		}
	);

	jQuery( '#fooevents_seating_options_table' ).on(
		'change',
		'.fooevents_seating_variations',
		function (event) {
			fooevents_serialize_options_seating();
		}
	);

	jQuery( '#fooevents_seating_options_table' ).on(
		'change',
		'.fooevents_seating_number_seats',
		function (event) {
			fooevents_serialize_options_seating();
		}
	);

	fooevents_serialize_options_seating();
})( jQuery );



jQuery( '#fooevents_seating_chart' ).on(
	'click',
	function () {
		var viewportWidth  = (window.innerWidth - 20);
		var viewportHeight = (window.innerHeight - 20);
		if (viewportWidth > 1000) {
			viewportWidth = 1000;
		}

		if (viewportHeight > 500) {
			viewportHeight = 500;
		}

		jQuery( "#fooevents_seating_dialog" ).html( "" );

		var rowName            = "";
		var rowID              = "";
		var numberSeats        = 0;
		var seats              = "";
		var unavailableSeatsID = "";
		var unavailableSeats   = "";
		var currentRow         = "";
		var seatClass          = "available";

		jQuery( "#fooevents_seating_options_table tbody tr" ).each(
			function () {
				rowName     = jQuery( this ).find( ".fooevents_seating_row_name" ).val();
				rowID       = jQuery( this ).find( ".fooevents_seating_row_name" ).attr( "id" );
				numberSeats = jQuery( this ).find( ".fooevents_seating_number_seats" ).val();
				jQuery( "#fooevents_seating_dialog" ).append( "<div class='fooevents_seating_chart_view_row_name' id='" + rowID + "'>" + rowName + "</div>" );
				seats = jQuery( '<div>', { 'class': 'fooevents_seating_chart_view_row' } );

				unavailableSeatsID = jQuery( 'input[value="fooevents_seats_unavailable_serialized"]' ).attr( "id" );
				if (unavailableSeatsID !== undefined) {
					unavailableSeatsID = unavailableSeatsID.substr( 0, unavailableSeatsID.lastIndexOf( "-" ) ) + "-value";
					unavailableSeats   = jQuery( "#" + unavailableSeatsID ).html();
				} else {
					unavailableSeatsID = "";
				}

				currentRow = rowID.substr( 0, rowID.indexOf( "_row_name" ) ) + "_number_seats_";

				for (var i = 1; i <= numberSeats; i++) {
					if ((unavailableSeats !== undefined) && (unavailableSeats.indexOf( currentRow + i ) > -1)) {
							seatClass = "unavailable";
					}

					jQuery( seats ).append( "<span class='" + seatClass + "'>" + i + "</span>" );
					seatClass = "available";
				}

				jQuery( "#fooevents_seating_dialog" ).append( seats );
			}
		);
		if (jQuery( "#fooevents_seating_dialog" ).is( ':empty' )) {
			jQuery( "#fooevents_seating_dialog" ).append( "<div style='margin-top:20px'>No seats to show. Add rows and seats by clicking on the '+ New Row' button.</div>" );
		}

		jQuery( "#fooevents_seating_dialog" ).dialog(
			{
				width: "50%",
				maxWidth: "768px",
				height: "auto",
				maxHeight: "768px"
			}
		);
	}
);



function get_variations(opt_num)
{
	var productID      = jQuery( "#post_ID" ).val();
	var the_variations = "";
	var dataVariations = {
		'action': 'fetch_woocommerce_variations',
		'productID': productID,
		'dataType': 'json',
	};

	the_variations = jQuery.post(
		ajaxurl,
		dataVariations,
		function (response) {
			if (response) {
				return response;
			}
		}
	).done(
		function (data) {
			option_pos_start = data.indexOf( "<option" );
			option_pos_end   = data.lastIndexOf( "</select>" );
			data             = data.substring( option_pos_start, option_pos_end );
			jQuery( "#" + opt_num + "_WooCommerceEventsSelectedVariation" ).append( data );
		}
	);

}

function fooevents_seating_new_row_field()
{
	var opt_num = jQuery( '#fooevents_seating_options_table tr' ).length;

	var row_name     = '<input type="text" id="' + opt_num + '_row_name" name="' + opt_num + '_row_name" class="fooevents_seating_row_name" value="Row' + opt_num + '" autocomplete="off" maxlength="50" />';
	var number_seats = '<input class="fooevents_seating_number_seats" type="number" id="' + opt_num + '_number_seats" name="' + opt_num + '_number_seats" min="1" max="50" value="1">';

	var variations = '<select class="fooevents_seating_variations" id="' + opt_num + '_variations" name="' + opt_num + '_variations">' + jQuery( "#fooevents_variations" ).html() + '</select>';

	var remove = '<a href="#" id="' + opt_num + '_remove" name="' + opt_num + '_remove" class="fooevents_seating_remove" class="fooevents_seating_remove">[X]</a>';

	var new_field = '<tr id="' + opt_num + '_option" class="fooevents_seating_option"><td>' + row_name + '</td><td>' + number_seats + '</td><td>' + variations + '</td><td>' + remove + '</td></tr>';
	jQuery( '#fooevents_seating_options_table tbody' ).append( new_field );

}


function fooevents_seating_delete_row_field(row)
{
	row.closest( 'tr' ).remove();
	fooevents_serialize_options_seating();

}

function fooevents_change_row_field_type(row)
{
	 row.closest( '.fooevents_seating_options' ).remove();

}

function fooevents_update_row_row_ids(row)
{
	/*var row_num = row.closest('tr').index()+1;
	var value = fooevents_encode_input(row.val());

	var new_row_name_id = value+'_row_name';
	var new_number_seats_id = value+'_number_seats';
	var new_variations_id = value+'_variations';
	var new_remove_id = value+'_remove';
	var new_option_id = value+'_option';

	fooevents_check_if_option_exists(value);

	jQuery('#fooevents_seating_options_table tr:eq('+row_num+') .fooevents_seating_row_name').attr("id", new_row_name_id);
	jQuery('#fooevents_seating_options_table tr:eq('+row_num+') .fooevents_seating_row_name').attr("name", new_row_name_id);
	jQuery('#fooevents_seating_options_table tr:eq('+row_num+') .fooevents_seating_number_seats').attr("id", new_number_seats_id);
	jQuery('#fooevents_seating_options_table tr:eq('+row_num+') .fooevents_seating_number_seats').attr("name", new_number_seats_id);
	jQuery('#fooevents_seating_options_table tr:eq('+row_num+') .fooevents_seating_variations').attr("id", new_variations_id);
	jQuery('#fooevents_seating_options_table tr:eq('+row_num+') .fooevents_seating_variations').attr("name", new_variations_id);
	jQuery('#fooevents_seating_options_table tr:eq('+row_num+') .fooevents_seating_remove').attr("id", new_remove_id);
	jQuery('#fooevents_seating_options_table tr:eq('+row_num+') .fooevents_seating_remove').attr("name", new_remove_id);
	jQuery('#fooevents_seating_options_table tr:eq('+row_num+')').attr("id", new_option_id);
	*/
	fooevents_serialize_options_seating();

}

function fooevents_encode_input(input)
{
	var output = input.toLowerCase();
	output     = output.replace( / /g,"_" );

	return output;

}

function fooevents_get_row_option_names()
{
	var IDs = [];
	jQuery( "#fooevents_seating_options_table" ).find( "tr" ).each(
		function () {
			IDs.push( this.id );
		}
	);

	return IDs;

}

function fooevents_check_if_option_exists(value)
{
	value = value + '_option';

	var IDs = fooevents_get_row_option_names();
	if (jQuery.inArray( value, IDs ) !== -1) {
		alert( 'Row name is already in use' );
	}

}

function fooevents_serialize_options_seating()
{
	var data     = {};
	var item_num = 0;
	jQuery( '#fooevents_seating_options_table tbody' ).find( 'tr' ).each(
		function () {
			var id = jQuery( this ).attr( 'id' );
			if (id) {
				var row = {};
				jQuery( this ).find( 'input,select,textarea' ).each(
					function () {
						row[jQuery( this ).attr( 'name' )] = jQuery( this ).val();
					}
				);
				data[id] = row;
			}

			item_num++;
		}
	);

	data = JSON.stringify( data );
	jQuery( '#fooevents_seating_options_serialized' ).val( data );

}

function fooevents_check_if_label_exists(value)
{
	var arr = [];
	jQuery( ".fooevents_custom_attendee_fields_label" ).each(
		function () {
			var value = jQuery( this ).val();
			if (arr.indexOf( value ) == -1) {
				arr.push( value );
			} else {
				alert( 'Label is already in use' );
			}
		}
	);

}

function fooevents_custom_attendees_make_id(length)
{
	var result           = '';
	var characters       = 'abcdefghijklmnopqrstuvwxyz';
	var charactersLength = characters.length;

	for (var i = 0; i < length; i++) {
		result += characters.charAt( Math.floor( Math.random() * charactersLength ) );
	}

	return result;

}

(function ($) {
	function initAddToCalendarReminderRemove()
	{
		jQuery( '.fooevents_add_to_calendar_reminders_remove' ).off( 'click' );

		jQuery( '.fooevents_add_to_calendar_reminders_remove' ).click(
			function (e) {
				e.preventDefault();

				jQuery( this ).parent( '.fooevents-add-to-calendar-reminder-row' ).remove();
			}
		);
	}

	if (jQuery( '#WooCommerceEventsTicketAddCalendarMeta' ).length) {
		initAddToCalendarReminderRemove();

		jQuery( '#fooevents_add_to_calendar_reminders_new_field' ).click(
			function (e) {
				e.preventDefault();

				var reminderRow = jQuery( '<div class="fooevents-add-to-calendar-reminder-row"></div>' );

				reminderRow.append( '<input class="wcfm-text width25" type="number" min="0" step="1" name="WooCommerceEventsTicketAddCalendarReminderAmounts[]" value="10">' ).append( '&nbsp;' );

				var reminderUnitsSelect = jQuery( '<select class="wcfm-select width35" name="WooCommerceEventsTicketAddCalendarReminderUnits[]"></select>' );

				var minutesValue = "minutes";
				var hoursValue   = "hours";
				var daysValue    = "days";
				var weeksValue   = "weeks";

				if ((typeof localRemindersObj === "object") && (localRemindersObj !== null)) {
					minutesValue = localRemindersObj.minutesValue;
					hoursValue   = localRemindersObj.hoursValue;
					daysValue    = localRemindersObj.daysValue;
					weeksValue   = localRemindersObj.weeksValue;
				}

				reminderUnitsSelect.append( '<option value="minutes" SELECTED>' + minutesValue + '</option>' );
				reminderUnitsSelect.append( '<option value="hours">' + hoursValue + '</option>' );
				reminderUnitsSelect.append( '<option value="days">' + daysValue + '</option>' );
				reminderUnitsSelect.append( '<option value="weeks">' + weeksValue + '</option>' );

				reminderRow.append( reminderUnitsSelect ).append( '&nbsp;' );

				reminderRow.append( '<a href="#" class="fooevents_add_to_calendar_reminders_remove">[X]</a>' );

				jQuery( '#fooevents_add_to_calendar_reminders_container' ).append( reminderRow );

				initAddToCalendarReminderRemove();
			}
		);
	}//end if
})( jQuery );

(function ($) {
	jQuery( "#WooCommercePrintTicketSize" ).on(
		'change',
		function () {
			fooevents_set_number_columns_rows( jQuery( this ).find( ":selected" ).val() );
		}
	);

	jQuery( "#WooCommercePrintTicketNrColumns" ).on(
		'change',
		function () {
			fooevents_set_layout_columns( jQuery( this ).val() );

			jQuery( "#fooevents_printing_layout_block .fooevents_printing_widget" ).each(
				function () {
					jQuery( this ).css( "width", "" );
				}
			);

			fooevents_set_layout_widget_resized_width();
		}
	);

	jQuery( "#WooCommercePrintTicketNrRows" ).on(
		'change',
		function () {
			fooevents_set_layout_rows( jQuery( this ).val() );
		}
	);

	jQuery( "#WooCommercePrintTicketNumbers" ).on(
		'keyup',
		function () {
			fooevents_enable_print_all_tickets_checkbox();
		}
	);

	jQuery( "#WooCommercePrintTicketOrders" ).on(
		'keyup',
		function () {
			fooevents_enable_print_all_tickets_checkbox();
		}
	);

	jQuery( "#WooCommerceEventsPrintAllTickets" ).on(
		'change',
		function () {
			fooevents_check_print_all_tickets_button( jQuery( this ) );
		}
	);

	jQuery( "#wcfm_products_manage_form_wc_fooevents_head" ).on(
		"click",
		function () {
			setTimeout( fooevents_set_layout_widget_resized_width , 1000 );
			// fooevents_set_layout_widget_resized_width();
			jQuery( "#fooevents_printing_widgets" ).accordion(
				{
					animate: true
				},
				{
					collapsible: true,
					heightStyle: "content"
				}
			);
		}
	);

	jQuery( "#fooevents-add-printing-widgets" ).on(
		"click",
		function () {
			fooevents_expand_collapse_fields();
		}
	);

	jQuery( '#fooevents_printing_layout_block .fooevents_printing_widget > span' ).on(
		"click",
		function () {
			fooevents_show_hide_widget_details( jQuery( this ) );
		}
	);

	if (jQuery( "#WooCommerceEventsEvent" ).length) {
		if ((typeof localObjPrint === "object") && (localObjPrint !== null)) {
			jQuery( '#fooevents_printing_save' ).on(
				'click',
				function (e) {
					e.preventDefault();
					fooevents_save_printing_options();
					return false;
				}
			);
		}

		var ticketExpirationType = jQuery( 'input[name=WooCommerceEventsTicketExpirationType]:checked' ).val();

		if (ticketExpirationType == 'select') {
			jQuery( '#WooCommerceEventsTicketsExpireValue, #WooCommerceEventsTicketsExpireUnit' ).prop( 'disabled', true ).addClass( 'wcfm-disabled' );
		}

		if (ticketExpirationType == 'time') {
			jQuery( '#WooCommerceEventsTicketsExpireSelect' ).prop( 'disabled', true ).addClass( 'wcfm-disabled' );
		}

		jQuery( 'input[name=WooCommerceEventsTicketExpirationType]' ).change(
			function () {
				var ticketExpirationType = this.value;

				if (ticketExpirationType == 'select') {
					jQuery( '#WooCommerceEventsTicketsExpireValue, #WooCommerceEventsTicketsExpireUnit' ).prop( 'disabled', true ).addClass( 'wcfm-disabled' );
					jQuery( '#WooCommerceEventsTicketsExpireSelect' ).prop( 'disabled', false ).removeClass( 'wcfm-disabled' );
				}

				if (ticketExpirationType == 'time') {
					jQuery( '#WooCommerceEventsTicketsExpireSelect' ).prop( 'disabled', true ).addClass( 'wcfm-disabled' );
					jQuery( '#WooCommerceEventsTicketsExpireValue, #WooCommerceEventsTicketsExpireUnit' ).prop( 'disabled', false ).removeClass( 'wcfm-disabled' );
				}
			}
		);

		function fooevents_save_printing_options()
		{
			jQuery( '#fooevents_printing_save' ).prop( "disabled", true );

			var data = {

				'action': 'fooevents_save_printing_options',
				'post_id': jQuery( "#post_ID" ).val(),
				'WooCommercePrintTicketSize': jQuery( "#WooCommercePrintTicketSize" ).val(),
				'WooCommercePrintTicketNrColumns': jQuery( "#WooCommercePrintTicketNrColumns" ).val(),
				'WooCommercePrintTicketNrRows': jQuery( "#WooCommercePrintTicketNrRows" ).val(),
				'WooCommerceBadgeFieldTopLeft': jQuery( "#WooCommerceBadgeFieldTopLeft" ).val(),
				'WooCommerceBadgeFieldTopMiddle': jQuery( "#WooCommerceBadgeFieldTopMiddle" ).val(),
				'WooCommerceBadgeFieldTopRight': jQuery( "#WooCommerceBadgeFieldTopRight" ).val(),
				'WooCommerceBadgeFieldMiddleLeft': jQuery( "#WooCommerceBadgeFieldMiddleLeft" ).val(),
				'WooCommerceBadgeFieldMiddleMiddle': jQuery( "#WooCommerceBadgeFieldMiddleMiddle" ).val(),
				'WooCommerceBadgeFieldMiddleRight': jQuery( "#WooCommerceBadgeFieldMiddleRight" ).val(),
				'WooCommerceBadgeFieldBottomLeft': jQuery( "#WooCommerceBadgeFieldBottomLeft" ).val(),
				'WooCommerceBadgeFieldBottomMiddle': jQuery( "#WooCommerceBadgeFieldBottomMiddle" ).val(),
				'WooCommerceBadgeFieldBottomRight': jQuery( "#WooCommerceBadgeFieldBottomRight" ).val(),
				'WooCommerceBadgeFieldTopLeft_font': jQuery( "#WooCommerceBadgeFieldTopLeft_font" ).val(),
				'WooCommerceBadgeFieldTopMiddle_font': jQuery( "#WooCommerceBadgeFieldTopMiddle_font" ).val(),
				'WooCommerceBadgeFieldTopRight_font': jQuery( "#WooCommerceBadgeFieldTopRight_font" ).val(),
				'WooCommerceBadgeFieldMiddleLeft_font': jQuery( "#WooCommerceBadgeFieldMiddleLeft_font" ).val(),
				'WooCommerceBadgeFieldMiddleMiddle_font': jQuery( "#WooCommerceBadgeFieldMiddleMiddle_font" ).val(),
				'WooCommerceBadgeFieldMiddleRight_font': jQuery( "#WooCommerceBadgeFieldMiddleRight_font" ).val(),
				'WooCommerceBadgeFieldBottomLeft_font': jQuery( "#WooCommerceBadgeFieldBottomLeft_font" ).val(),
				'WooCommerceBadgeFieldBottomMiddle_font': jQuery( "#WooCommerceBadgeFieldBottomMiddle_font" ).val(),
				'WooCommerceBadgeFieldBottomRight_font': jQuery( "#WooCommerceBadgeFieldBottomRight_font" ).val(),
				'WooCommerceBadgeFieldTopLeft_logo': jQuery( "#WooCommerceBadgeFieldTopLeft_logo" ).val(),
				'WooCommerceBadgeFieldTopMiddle_logo': jQuery( "#WooCommerceBadgeFieldTopMiddle_logo" ).val(),
				'WooCommerceBadgeFieldTopRight_logo': jQuery( "#WooCommerceBadgeFieldTopRight_logo" ).val(),
				'WooCommerceBadgeFieldMiddleLeft_logo': jQuery( "#WooCommerceBadgeFieldMiddleLeft_logo" ).val(),
				'WooCommerceBadgeFieldMiddleMiddle_logo': jQuery( "#WooCommerceBadgeFieldMiddleMiddle_logo" ).val(),
				'WooCommerceBadgeFieldMiddleRight_logo': jQuery( "#WooCommerceBadgeFieldMiddleRight_logo" ).val(),
				'WooCommerceBadgeFieldBottomLeft_logo': jQuery( "#WooCommerceBadgeFieldBottomLeft_logo" ).val(),
				'WooCommerceBadgeFieldBottomMiddle_logo': jQuery( "#WooCommerceBadgeFieldBottomMiddle_logo" ).val(),
				'WooCommerceBadgeFieldBottomRight_logo': jQuery( "#WooCommerceBadgeFieldBottomRight_logo" ).val(),
				'WooCommerceBadgeFieldTopLeft_custom': tinymce.get( 'WooCommerceBadgeFieldTopLeft_custom' ) !== null ? tinymce.get( 'WooCommerceBadgeFieldTopLeft_custom' ).getContent() : "",
				'WooCommerceBadgeFieldTopMiddle_custom': tinymce.get( 'WooCommerceBadgeFieldTopMiddle_custom' ) !== null ? tinymce.get( 'WooCommerceBadgeFieldTopMiddle_custom' ).getContent() : "",
				'WooCommerceBadgeFieldTopRight_custom': tinymce.get( 'WooCommerceBadgeFieldTopRight_custom' ) !== null ? tinymce.get( 'WooCommerceBadgeFieldTopRight_custom' ).getContent() : "",
				'WooCommerceBadgeFieldMiddleLeft_custom': tinymce.get( 'WooCommerceBadgeFieldMiddleLeft_custom' ) !== null ? tinymce.get( 'WooCommerceBadgeFieldMiddleLeft_custom' ).getContent() : "",
				'WooCommerceBadgeFieldMiddleMiddle_custom': tinymce.get( 'WooCommerceBadgeFieldMiddleMiddle_custom' ) !== null ? tinymce.get( 'WooCommerceBadgeFieldMiddleMiddle_custom' ).getContent() : "",
				'WooCommerceBadgeFieldMiddleRight_custom': tinymce.get( 'WooCommerceBadgeFieldMiddleRight_custom' ) !== null ? tinymce.get( 'WooCommerceBadgeFieldMiddleRight_custom' ).getContent() : "",
				'WooCommerceBadgeFieldBottomLeft_custom': tinymce.get( 'WooCommerceBadgeFieldBottomLeft_custom' ) !== null ? tinymce.get( 'WooCommerceBadgeFieldBottomLeft_custom' ).getContent() : "",
				'WooCommerceBadgeFieldBottomMiddle_custom': tinymce.get( 'WooCommerceBadgeFieldBottomMiddle_custom' ) !== null ? tinymce.get( 'WooCommerceBadgeFieldBottomMiddle_custom' ).getContent() : "",
				'WooCommerceBadgeFieldBottomRight_custom': tinymce.get( 'WooCommerceBadgeFieldBottomRight_custom' ) !== null ? tinymce.get( 'WooCommerceBadgeFieldBottomRight_custom' ).getContent() : "",
				'WooCommercePrintTicketSort': jQuery( "#WooCommercePrintTicketSort" ).val(),
				'WooCommercePrintTicketNumbers': jQuery( "#WooCommercePrintTicketNumbers" ).val(),
				'WooCommercePrintTicketOrders': jQuery( "#WooCommercePrintTicketOrders" ).val(),
				'WooCommerceEventsCutLinesPrintTicket': jQuery( "#WooCommerceEventsCutLinesPrintTicket" ).attr( "checked" ) ? "on" : "off"

			};

			jQuery.post(
				ajaxurl,
				data,
				function (response) {
					jQuery( '#fooevents_printing_save' ).prop( "disabled", false );

					var status = JSON.parse( response );

					if (status.status == "success") {
						alert( localObjPrint.ajaxSaveSuccess );
					} else {
						alert( localObjPrint.ajaxSaveError );
					}
				}
			);
		}

	}//end if

	function fooevents_enable_print_all_tickets_checkbox()
	{
		if (jQuery( "#WooCommercePrintTicketNumbers" ).val() == "" && jQuery( "#WooCommercePrintTicketOrders" ).val() == "") {
			jQuery( "#WooCommerceEventsPrintAllTickets" ).prop( 'checked', true );
		} else {
			jQuery( "#WooCommerceEventsPrintAllTickets" ).prop( 'checked', false );
		}

		jQuery( "#WooCommerceEventsPrintAllTickets" ).change();
	}

	function fooevents_expand_collapse_fields()
	{
		if (jQuery( "#fooevents_printing_widgets" ).is( ":visible" )) {
			jQuery( "#fooevents_printing_widgets" ).slideUp();
			jQuery( "#fooevents-add-printing-widgets" ).html( "+ Expand Fields" );
		} else {
			jQuery( "#fooevents_printing_widgets" ).slideDown();
			fooevents_set_init_widget_resized_width();
			jQuery( "#fooevents-add-printing-widgets" ).html( "- Hide Fields" );
		}
	}

	function fooevents_show_hide_widget_details(printingWidget)
	{
		if (printingWidget.next().css( "display" ) == "block") {
			printingWidget.find( ".fooevents_printing_arrow" ).addClass( "fooevents_printing_arrow_closed" );
			printingWidget.find( ".fooevents_printing_arrow" ).removeClass( "fooevents_printing_arrow_open" );
		} else {
			printingWidget.find( ".fooevents_printing_arrow" ).addClass( "fooevents_printing_arrow_open" );
			printingWidget.find( ".fooevents_printing_arrow" ).removeClass( "fooevents_printing_arrow_closed" );
		}

		printingWidget.next().slideToggle();
	}

	function fooevents_remove_printing_widget()
	{
		jQuery( '.fooevents_printing_widget_remove' ).off( "click" );

		jQuery( '.fooevents_printing_widget_remove' ).on(
			"click",
			function () {
				editor_id = jQuery( this ).parent().find( 'textarea' ).attr( "id" );

				if (editor_id != "WooCommerceEventsPrintTicketCustom") {
					tinymce.EditorManager.execCommand( 'mceRemoveEditor', false, editor_id );
				}

				jQuery( this ).parent().find( 'input.uploadfield' ).val( '' );

				var printSlotID = "#WooCommerceBadgeField" + jQuery( this ).parents( "td" ).attr( "id" );

				jQuery( printSlotID ).val( "" );

				jQuery( this ).parent().parent().remove();
			}
		);
	}

	function fooevents_calculate_widget_resized_width()
	{
		var setWidth = jQuery( "#fooevents_printing_layout_block" ).width();
		var nrCols   = parseInt( jQuery( "#WooCommercePrintTicketNrColumns" ).val() );
		setWidth     = (setWidth / nrCols) - 40;
		return setWidth;
	}

	function fooevents_set_layout_widget_resized_width()
	{
		jQuery( "#fooevents_printing_layout_block .fooevents_printing_widget" ).each(
			function () {
				jQuery( this ).css( "width", fooevents_calculate_widget_resized_width() + "px" );
			}
		);
	}

	function fooevents_set_init_widget_resized_width()
	{
		var setWidth = jQuery( ".fooevents_printing_widget_init" ).width();

		jQuery( ".fooevents_printing_widget_init" ).each(
			function () {
				jQuery( this ).css( "width", setWidth + "px" );
			}
		);
	}

	function fooevents_set_number_columns_rows(selectedSize)
	{
		switch (selectedSize) {
			case "tickets_avery_letter_10":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "3" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "3" ).change();
			break;

			case "tickets_letter_10":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "3" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "3" ).change();
			break;

			case "tickets_a4_10":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "2" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "2" ).change();
			break;

			case "tickets_a4_3":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "3" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "3" ).change();
			break;

			case "letter_6":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "2" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "2" ).change();
			break;

			case "letter_10":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "2" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "2" ).change();
			break;

			case "a4_12":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "1" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "3" ).change();
			break;

			case "a4_16":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "2" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "1" ).change();
			break;

			case "a4_24":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "1" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "2" ).change();
			break;

			case "letter_30":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "2" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "1" ).change();
			break;

			case "a4_39":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "2" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "1" ).change();
			break;

			case "a4_45":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "1" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "2" ).change();
			break;

			case "letter_labels_5":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "3" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "2" ).change();
			break;

			case "letter_labels_1":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "3" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "1" ).change();
			break;

			case "letter_certificate_portrait_1":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "3" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "3" ).change();
			break;

			case "letter_certificate_landscape_1":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "3" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "3" ).change();
			break;

			case "a4_certificate_portrait_1":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "3" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "3" ).change();
			break;

			case "a4_certificate_landscape_1":
				jQuery( "#WooCommercePrintTicketNrColumns" ).val( "3" ).change();
				jQuery( "#WooCommercePrintTicketNrRows" ).val( "3" ).change();
			break;
		}//end switch
	}

	function fooevents_check_print_all_tickets_button(checkbox)
	{
		if (checkbox.prop( 'checked' )) {
			jQuery( "#WooCommercePrintTicketNumbers" ).val( "" ).prop( "disabled", true );
			jQuery( "#WooCommercePrintTicketOrders" ).val( "" ).prop( "disabled", true );
			jQuery( "#WooCommercePrintTicketSort" ).prop( "disabled", false );
		} else {
			jQuery( "#WooCommercePrintTicketNumbers" ).prop( "disabled", false );
			jQuery( "#WooCommercePrintTicketOrders" ).prop( "disabled", false );
			jQuery( "#WooCommercePrintTicketSort" ).prop( "disabled", true );
		}
	}

	jQuery( window ).resize(
		function () {
			jQuery( "#fooevents_printing_layout_block .fooevents_printing_widget" ).each(
				function () {
					jQuery( this ).css( "width", "" );
				}
			);

			fooevents_set_layout_widget_resized_width();
			fooevents_set_init_widget_resized_width();
		}
	);

	fooevents_remove_printing_widget();
	fooevents_enable_print_all_tickets_checkbox();

	jQuery( "#WooCommercePrintTicketNrColumns" ).ready(
		function () {
			fooevents_set_layout_columns( jQuery( "#WooCommercePrintTicketNrColumns" ).val() );
		}
	);

	jQuery( "#WooCommercePrintTicketNrRows" ).ready(
		function () {
			fooevents_set_layout_rows( jQuery( "#WooCommercePrintTicketNrRows" ).val() );
		}
	);

	jQuery(
		function () {
			var origSlot = "";

			jQuery( ".fooevents_printing_widget" ).each(
				function () {
					var printingWidget = jQuery( this );
					var editor_id      = printingWidget.find( 'textarea' ).attr( "id" );

					if ((printingWidget.find( "span" ).attr( "data-name" ) == "custom")) {
						tinymce.init(
							{
								selector: "#" + jQuery( this ).find( 'textarea' ).attr( "id" ),
								branding: false,
								elementpath: false,
								menubar: false,
								plugins: "lists",
								toolbar: [
								"bold italic bullist numlist alignleft aligncenter alignright" ]
							}
						);
					}

					printingWidget.draggable(
						{

							revert: "invalid",
							helper: "clone",
							zIndex: 1000,
							appendTo: "body",

							start: function (e, ui) {
								printingWidget.parent( "#fooevents_printing_layout_block" ).addClass( "fooevents_printing_widget_layout_active" );
								tinymce.EditorManager.execCommand( 'mceRemoveEditor', false, editor_id );
								if ( ! printingWidget.hasClass( 'fooevents_printing_widget_init' )) {
									origSlot = "#WooCommerceBadgeField" + printingWidget.parents( "td" ).attr( "id" );
								} else {
									origSlot = "";
								}
							},

							stop: function (e, ui) {
								editor_id = printingWidget.find( 'textarea' ).attr( "id" );
								setTimeout(
									function () {
										tinymce.init(
											{
												selector: "#" + editor_id,
												branding: false,
												elementpath: false,
												menubar: false,
												plugins: "lists",
												toolbar: [ "bold italic bullist numlist alignleft aligncenter alignright" ]
											}
										);
									},
									500
								);
							}

						}
					);
				}
			);

			var dropOption = {

				accept: '.fooevents_printing_widget',
				hoverClass: "fooevents_printing_widget_hover",
				activeClass: "fooevents_printing_widget_active",
				tolerance: "pointer",
				greedy: true,
				drop: function (event, ui) {
					jQuery( ui.helper ).remove();
					fooevents_remove_printing_widget();

					if (jQuery( this ).is( ".fooevents_printing_slot" ) && ! jQuery( this ).has( ".fooevents_printing_widget" ).length) {
						var slotID      = "WooCommerceBadgeField" + jQuery( this ).attr( "id" );
						var printSlotID = "#" + slotID;

						if (jQuery( ui.draggable ).hasClass( 'fooevents_printing_widget_init' )) {
							var clonedItem = jQuery( ui.draggable ).clone();

							var clonedPosition = jQuery( ui.draggable ).attr( "data-order" );

							clonedItem.insertBefore( jQuery( "#fooevents_printing_widgets div[data-order='" + clonedPosition + "']" ) );

							clonedItem.draggable(
								{
									revert: "invalid",
									helper: "clone",
									zIndex: 1000,
									appendTo: "body",

									start: function (e, ui) {
										origSlot = "#WooCommerceBadgeField" + jQuery( this ).parents( "td" ).attr( "id" );
										tinymce.EditorManager.execCommand( 'mceRemoveEditor', false, jQuery( this ).find( 'textarea' ).attr( "id" ) );
									},

									stop: function (e, ui) {
										tinymce.init(
											{
												selector: "#" + jQuery( this ).find( 'textarea' ).attr( "id" ),
												branding: false,
												elementpath: false,
												menubar: false,
												plugins: "lists",
												toolbar: [ "bold italic bullist numlist alignleft aligncenter alignright" ]
											}
										);
									}

								}
							);

							jQuery( ui.draggable ).removeClass( 'fooevents_printing_widget_init' );

							if (jQuery( ui.draggable ).find( "textarea" ).attr( "id" ) == "WooCommerceEventsPrintTicketCustom") {
								jQuery( ui.draggable ).find( "textarea" ).attr( "id", slotID + "_custom" );
								jQuery( ui.draggable ).find( "textarea" ).attr( "name", slotID + "_custom" );
							}
						}//end if

						jQuery( this ).append(
							ui.draggable.css(
								{

									top: 0,
									left: 0

								}
							)
						);

						jQuery( ui.draggable ).css( "width", fooevents_calculate_widget_resized_width() + "px" );
						jQuery( ui.draggable ).find( ".fooevents_printing_ticket_select" ).attr( "name", slotID + "_font" );
						jQuery( ui.draggable ).find( ".fooevents_printing_ticket_select" ).attr( "id", slotID + "_font" );
						jQuery( ui.draggable ).find( ".fooevents_printing_widget_options input.uploadfield" ).attr( "name", slotID + "_logo" );
						jQuery( ui.draggable ).find( ".fooevents_printing_widget_options input.uploadfield" ).attr( "id", slotID + "_logo" );
						jQuery( ui.draggable ).find( ".fooevents_printing_widget_options textarea" ).attr( "name", slotID + "_custom" );
						jQuery( ui.draggable ).find( ".fooevents_printing_widget_options textarea" ).attr( "id", slotID + "_custom" );
						jQuery( printSlotID ).val( jQuery( this ).find( ".fooevents_printing_widget > span" ).attr( "data-name" ) );
						jQuery( origSlot ).val( "" );

						jQuery( this ).find( ".fooevents_printing_widget > span" ).unbind( 'click' ).on(
							"click",
							function () {
								fooevents_show_hide_widget_details( jQuery( this ) );
							}
						);
					} else {
						ui.draggable.animate(
							{
								top: 0,
								left: 0
							},
							"slow"
						);
					}//end if

					fooevents_validate_slot( jQuery( ".ui-selected" ).not( ui.draggable ) );
				}

			}

			jQuery( ".fooevents_printing_slot" ).droppable( dropOption );

			function fooevents_validate_slot($draggables)
			{
				$draggables.each(
					function () {
						var $target = jQuery( jQuery( this ).data( "target" ) ).filter(
							function (i, elm) {
								return jQuery( this ).is( ".fooevents_printing_slot" ) && ! jQuery( this ).has( ".fooevents_printing_widget" ).length;
							}
						);

						if ($target.length) {
							$target.append(
								$( this ).css(
									{
										top: 0,
										left: 0
									}
								)
							)
						} else {
							jQuery( this ).animate(
								{
									top: 0,
									left: 0
								},
								"slow"
							);
						}
					}
				);

				jQuery( ".ui-selected" ).data( "original", null ).data( "target", null ).removeClass( "ui-selected" );
			}
		}
	);

	function fooevents_set_layout_columns(nrCol)
	{
		switch (nrCol) {
			case "1":
				var tdWidth = "100%";
			break;

			case "2":
				var tdWidth = "50%";
			break;

			case "3":
				var tdWidth = "33.33%";
			break;
		}

		jQuery( ".fooevents_printing_slot" ).each(
			function () {
				jQuery( this ).css( "width", tdWidth );

				if (jQuery( this ).hasClass( "hide_col_" + nrCol )) {
					jQuery( this ).hide();
					jQuery( this ).prev().addClass( "no_border_right" );
				} else {
					if ( ! jQuery( this ).hasClass( "hide_row_" + jQuery( "#WooCommercePrintTicketNrRows" ).val() )) {
						jQuery( this ).show();
					}

					jQuery( this ).prev().removeClass( "no_border_right" );
				}
			}
		);
	}

	function fooevents_set_layout_rows(nrRow)
	{
		jQuery( ".fooevents_printing_slot" ).each(
			function () {
				if (jQuery( this ).hasClass( "hide_row_" + nrRow )) {
					jQuery( this ).hide();
					jQuery( this ).parent().hide();
					jQuery( this ).parent().prev().find( "td" ).addClass( "no_border_bottom" );
				} else {
					if ( ! jQuery( this ).hasClass( "hide_col_" + jQuery( "#WooCommercePrintTicketNrColumns" ).val() )) {
						jQuery( this ).show();
					}

					jQuery( this ).parent().show();
					jQuery( this ).parent().prev().find( "td" ).removeClass( "no_border_bottom" );
				}
			}
		);
	}
})( jQuery );

function enableCaptureAttendeeDetails()
{
	jQuery( 'input[name="WooCommerceEventsCaptureAttendeeDetails"]' ).prop( "checked",true );

	jQuery( "#fooevents_enable_attendee_details_note #fooevents_capture_attendee_details_disabled" ).hide();
	jQuery( "#fooevents_enable_attendee_details_note #fooevents_capture_attendee_details_enabled" ).show();

}
