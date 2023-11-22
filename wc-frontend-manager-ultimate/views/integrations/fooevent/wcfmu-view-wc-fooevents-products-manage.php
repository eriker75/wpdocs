<?php
/**
 * WCFM plugin view
 *
 * WCFM WC Foo Events Product Manage View
 *
 * @author  Squiz Pty Ltd <products@squiz.net>
 * @package wcfmu/views/thirdparty
 * @version 5.3.4
 */

global $wp, $WCFM, $WCFMu, $woocommerce;

if (! apply_filters('wcfm_is_allow_wc_fooevents', true)) {
    return;
}


function abc($woocommerce_events_ticket_add_calendar_reminders)
{
    ob_start();

    return ob_get_clean();

}//end abc()


$product_id = 0;

$WooCommerceEventsEvent                  = '';
$WooCommerceEventsDate                   = '';
$WooCommerceEventsHour                   = '';
$WooCommerceEventsPeriod                 = '';
$WooCommerceEventsMinutes                = '';
$WooCommerceEventsHourEnd                = '';
$WooCommerceEventsMinutesEnd             = '';
$WooCommerceEventsEndPeriod              = '';
$WooCommerceEventsLocation               = '';
$WooCommerceEventsTicketLogo             = '';
$WooCommerceEventsPrintTicketLogo        = '';
$WooCommerceEventsTicketHeaderImage      = '';
$WooCommerceEventsSupportContact         = '';
$WooCommerceEventsGPS                    = '';
$WooCommerceEventsGoogleMaps             = '';
$WooCommerceEventsDirections             = '';
$WooCommerceEventsEmail                  = '';
$WooCommerceEventsTicketBackgroundColor  = '';
$WooCommerceEventsTicketButtonColor      = '';
$WooCommerceEventsTicketTextColor        = '';
$WooCommerceEventsTicketPurchaserDetails = '';
$WooCommerceEventsTicketAddCalendar      = '';

$woocommerce_events_ticket_add_calendar_reminders = '';

$WooCommerceEventsTicketAttachICS       = '';
$WooCommerceEventsTicketDisplayDateTime = '';
$WooCommerceEventsTicketDisplayBarcode  = '';

$WooCommerceEventsTicketDisplayPrice         = '';
$WooCommerceEventsTicketDisplayBookings      = '';
$WooCommerceEventsTicketDisplayZoom          = '';
$WooCommerceEventsTicketDisplayMultiDay      = '';
$WooCommerceEventsTicketText                 = '';
$WooCommerceEventsThankYouText               = '';
$WooCommerceEventsEventDetailsText           = '';
$WooCommerceEventsCaptureAttendeeDetails     = '';
$WooCommerceEventsEmailAttendee              = '';
$WooCommerceEventsSendEmailTickets           = '';
$WooCommerceEventsCaptureAttendeeTelephone   = '';
$WooCommerceEventsCaptureAttendeeCompany     = '';
$WooCommerceEventsCaptureAttendeeDesignation = '';
$WooCommerceEventsUniqueEmail                = '';

$WooCommerceEventsViewSeatingOptions = '';
$WooCommerceEventsViewSeatingChart   = '';

$WooCommerceEventsEventDetailsNewOrder    = '';
$WooCommerceEventsDisplayAttendeeNewOrder = '';
$WooCommerceEventsDisplayBookingsNewOrder = '';
$WooCommerceEventsDisplaySeatingsNewOrder = '';
$WooCommerceEventsDisplayCustAttNewOrder  = '';

$WooCommerceEventsExportUnpaidTickets  = '';
$WooCommerceEventsExportBillingDetails = '';

$WooCommerceBadgeSize   = '';
$WooCommerceBadgeField1 = '';
$WooCommerceBadgeField2 = '';
$WooCommerceBadgeField3 = '';

$woocommerce_print_ticket_size     = '';
$WooCommercePrintTicketField1      = '';
$WooCommercePrintTicketField1_font = '';
$WooCommercePrintTicketField2      = '';
$WooCommercePrintTicketField2_font = '';
$WooCommercePrintTicketField3      = '';
$WooCommercePrintTicketField3_font = '';
$WooCommercePrintTicketField4      = '';
$WooCommercePrintTicketField4_font = '';
$WooCommercePrintTicketField5      = '';
$WooCommercePrintTicketField5_font = '';
$WooCommercePrintTicketField6      = '';
$WooCommercePrintTicketField6_font = '';

$WooCommerceEventsPrintTicketLogoOption = '';
$WooCommerceEventsCutLinesPrintTicket   = '';
$WooCommerceEventsTicketBackgroundImage = '';
$woocommerce_print_ticket_numbers       = '';
$woocommerce_print_ticket_orders        = '';
$woocommerce_print_ticket_sort          = '';
$woocommerce_print_ticket_nr_columns    = '';
$woocommerce_print_ticket_nr_rows       = '';

$woocommerce_badge_field_top_left      = '';
$woocommerce_badge_field_top_middle    = '';
$woocommerce_badge_field_top_right     = '';
$woocommerce_badge_field_middle_left   = '';
$woocommerce_badge_field_middle_middle = '';
$woocommerce_badge_field_middle_right  = '';
$woocommerce_badge_field_bottom_left   = '';
$woocommerce_badge_field_bottom_middle = '';
$woocommerce_badge_field_bottom_right  = '';

$woocommerce_badge_field_top_left_custom      = '';
$woocommerce_badge_field_top_middle_custom    = '';
$woocommerce_badge_field_top_right_custom     = '';
$woocommerce_badge_field_middle_left_custom   = '';
$woocommerce_badge_field_middle_middle_custom = '';
$woocommerce_badge_field_middle_right_custom  = '';
$woocommerce_badge_field_bottom_left_custom   = '';
$woocommerce_badge_field_bottom_middle_custom = '';
$woocommerce_badge_field_bottom_right_custom  = '';

$woocommerce_badge_field_top_left_font      = '';
$woocommerce_badge_field_top_middle_font    = '';
$woocommerce_badge_field_top_right_font     = '';
$woocommerce_badge_field_middle_left_font   = '';
$woocommerce_badge_field_middle_middle_font = '';
$woocommerce_badge_field_middle_right_font  = '';
$woocommerce_badge_field_bottom_left_font   = '';
$woocommerce_badge_field_bottom_middle_font = '';
$woocommerce_badge_field_bottom_right_font  = '';

$woocommerce_badge_field_top_left_logo      = '';
$woocommerce_badge_field_top_middle_logo    = '';
$woocommerce_badge_field_top_right_logo     = '';
$woocommerce_badge_field_middle_left_logo   = '';
$woocommerce_badge_field_middle_middle_logo = '';
$woocommerce_badge_field_middle_right_logo  = '';
$woocommerce_badge_field_bottom_left_logo   = '';
$woocommerce_badge_field_bottom_middle_logo = '';
$woocommerce_badge_field_bottom_right_logo  = '';

$WooCommerceEventsCutLines = '';

$WooCommerceEventsEmailSubjectSingle = '';
$WooCommerceEventsTicketTheme        = '';
$WooCommerceEventsPDFTicketTheme     = '';
$$pdf_ticket_themes                  = '';

$WooCommerceEventsAttendeeOverride       = '';
$WooCommerceEventsAttendeeOverridePlural = '';
$WooCommerceEventsTicketOverride         = '';
$WooCommerceEventsTicketOverridePlural   = '';


$globalWooCommerceEventsGoogleMapsAPIKey = '';

$WooCommerceEventsEmailSubjectSingle = __('{OrderNumber} Ticket', 'woocommerce-events');

$globalWooCommerceEventsTicketBackgroundColor = '';
$globalWooCommerceEventsTicketButtonColor     = '';
$globalWooCommerceEventsTicketTextColor       = '';
$globalWooCommerceEventsTicketLogo            = '';
$globalWooCommerceEventsTicketHeaderImage     = '';

$WooCommerceEventsEndDate           = '';
$WooCommerceEventsNumDays           = '';
$WooCommerceEventsMultiDayType      = '';
$WooCommerceEventsSelectDate        = '';
$WooCommerceEventsDayOverride       = '';
$WooCommerceEventsDayOverridePlural = '';

$WooCommerceEventsBookingsSlotOverride                 = '';
$WooCommerceEventsBookingsSlotOverridePlural           = '';
$WooCommerceEventsBookingsDateOverride                 = '';
$WooCommerceEventsBookingsDateOverridePlural           = '';
$WooCommerceEventsBookingsBookingDetailsOverride       = '';
$WooCommerceEventsBookingsBookingDetailsOverridePlural = '';


$WooCommerceEventsBackgroundColor = '';
$WooCommerceEventsTextColor       = '';
$eventbrite_option                = '';
$globalFooEventsEventbriteToken   = get_option('globalFooEventsEventbriteToken', '');
$WooCommerceEventsAddEventbrite   = '';

$WooCommerceEventsIncludeCustomAttendeeDetails       = '';
$fooevents_custom_attendee_fields_options            = [];
$fooevents_custom_attendee_fields_options_serialized = '';

$FooEventsPDFTicketsEmailText = '';
$FooEventsTicketFooterText    = '';

$WooCommerceEventsExpire                   = '';
$WooCommerceEventsExpireMessage            = '';
$WooCommerceEventsTicketExpirationType     = '';
$WooCommerceEventsTicketsExpireSelect      = '';
$WooCommerceEventsTicketsExpireValue       = '';
$WooCommerceEventsTicketsExpireUnit        = '';
$WooCommerceEventsBookingsExpirePassedDate = '';

$fooevents_seating_options_serialized = '';
$fooevents_seating_options            = [];

$woocommerce_events_expire         = '';
$woocommerce_events_expire_message = '';

$woocommerce_events_zoom_host              = '';
$woocommerce_events_zoom_type              = '';
$global_woocommerce_events_zoom_users      = json_decode(get_option('globalWooCommerceEventsZoomUsers', json_encode([])), true);
$global_woocommerce_events_zoom_api_key    = get_option('globalWooCommerceEventsZoomAPIKey', '');
$global_woocommerce_events_zoom_api_secret = get_option('globalWooCommerceEventsZoomAPISecret', '');
$woocommerce_events_zoom_multi_option      = '';
$woocommerce_events_zoom_webinar           = '';

$cf_array = [];

if (isset($wp->query_vars['wcfm-products-manage']) && ! empty($wp->query_vars['wcfm-products-manage'])) {
    $product_id = $wp->query_vars['wcfm-products-manage'];

    $product = wc_get_product($product_id);

    $event_post = get_post($product_id);

    if ($product && ! empty($product) && is_object($product)) {
        $WooCommerceEventsEvent                  = get_post_meta($product_id, 'WooCommerceEventsEvent', true);
        $WooCommerceEventsDate                   = get_post_meta($product_id, 'WooCommerceEventsDate', true);
        $WooCommerceEventsHour                   = get_post_meta($product_id, 'WooCommerceEventsHour', true);
        $WooCommerceEventsPeriod                 = get_post_meta($product_id, 'WooCommerceEventsPeriod', true);
        $WooCommerceEventsMinutes                = get_post_meta($product_id, 'WooCommerceEventsMinutes', true);
        $WooCommerceEventsHourEnd                = get_post_meta($product_id, 'WooCommerceEventsHourEnd', true);
        $WooCommerceEventsMinutesEnd             = get_post_meta($product_id, 'WooCommerceEventsMinutesEnd', true);
        $WooCommerceEventsEndPeriod              = get_post_meta($product_id, 'WooCommerceEventsEndPeriod', true);
        $woocommerce_events_timezone             = get_post_meta($product_id, 'WooCommerceEventsTimeZone', true);
        $WooCommerceEventsLocation               = get_post_meta($product_id, 'WooCommerceEventsLocation', true);
        $WooCommerceEventsTicketLogo             = get_post_meta($product_id, 'WooCommerceEventsTicketLogo', true);
        $WooCommerceEventsPrintTicketLogo        = get_post_meta($product_id, 'WooCommerceEventsPrintTicketLogo', true);
        $WooCommerceEventsTicketHeaderImage      = get_post_meta($product_id, 'WooCommerceEventsTicketHeaderImage', true);
        $WooCommerceEventsSupportContact         = get_post_meta($product_id, 'WooCommerceEventsSupportContact', true);
        $WooCommerceEventsGPS                    = get_post_meta($product_id, 'WooCommerceEventsGPS', true);
        $WooCommerceEventsGoogleMaps             = get_post_meta($product_id, 'WooCommerceEventsGoogleMaps', true);
        $WooCommerceEventsDirections             = get_post_meta($product_id, 'WooCommerceEventsDirections', true);
        $WooCommerceEventsEmail                  = get_post_meta($product_id, 'WooCommerceEventsEmail', true);
        $WooCommerceEventsTicketBackgroundColor  = get_post_meta($product_id, 'WooCommerceEventsTicketBackgroundColor', true);
        $WooCommerceEventsTicketButtonColor      = get_post_meta($product_id, 'WooCommerceEventsTicketButtonColor', true);
        $WooCommerceEventsTicketTextColor        = get_post_meta($product_id, 'WooCommerceEventsTicketTextColor', true);
        $WooCommerceEventsTicketPurchaserDetails = get_post_meta($product_id, 'WooCommerceEventsTicketPurchaserDetails', true);
        $WooCommerceEventsTicketAddCalendar      = get_post_meta($product_id, 'WooCommerceEventsTicketAddCalendar', true);
        $woocommerce_events_ticket_add_calendar_reminders = get_post_meta($product_id, 'WooCommerceEventsTicketAddCalendarReminders', true);
        $WooCommerceEventsTicketAttachICS                 = get_post_meta($product_id, 'WooCommerceEventsTicketAttachICS', true);
        $WooCommerceEventsTicketDisplayDateTime           = get_post_meta($product_id, 'WooCommerceEventsTicketDisplayDateTime', true);
        $WooCommerceEventsTicketDisplayBarcode            = get_post_meta($product_id, 'WooCommerceEventsTicketDisplayBarcode', true);
        $WooCommerceEventsTicketDisplayPrice              = get_post_meta($product_id, 'WooCommerceEventsTicketDisplayPrice', true);
        $WooCommerceEventsTicketDisplayBookings           = get_post_meta($product_id, 'WooCommerceEventsTicketDisplayBookings', true);
        $WooCommerceEventsTicketDisplayZoom               = get_post_meta($product_id, 'WooCommerceEventsTicketDisplayZoom', true);
        $WooCommerceEventsTicketDisplayMultiDay           = get_post_meta($product_id, 'WooCommerceEventsTicketDisplayMultiDay', true);
        $WooCommerceEventsTicketText                 = get_post_meta($product_id, 'WooCommerceEventsTicketText', true);
        $WooCommerceEventsThankYouText               = get_post_meta($product_id, 'WooCommerceEventsThankYouText', true);
        $WooCommerceEventsEventDetailsText           = get_post_meta($product_id, 'WooCommerceEventsEventDetailsText', true);
        $WooCommerceEventsCaptureAttendeeDetails     = get_post_meta($product_id, 'WooCommerceEventsCaptureAttendeeDetails', true);
        $WooCommerceEventsEmailAttendee              = get_post_meta($product_id, 'WooCommerceEventsEmailAttendee', true);
        $WooCommerceEventsSendEmailTickets           = get_post_meta($product_id, 'WooCommerceEventsSendEmailTickets', true);
        $WooCommerceEventsCaptureAttendeeTelephone   = get_post_meta($product_id, 'WooCommerceEventsCaptureAttendeeTelephone', true);
        $WooCommerceEventsCaptureAttendeeCompany     = get_post_meta($product_id, 'WooCommerceEventsCaptureAttendeeCompany', true);
        $WooCommerceEventsCaptureAttendeeDesignation = get_post_meta($product_id, 'WooCommerceEventsCaptureAttendeeDesignation', true);
        $WooCommerceEventsUniqueEmail                = get_post_meta($product_id, 'WooCommerceEventsUniqueEmail', true);

        $WooCommerceEventsViewSeatingOptions = get_post_meta($product_id, 'WooCommerceEventsViewSeatingOptions', true);
        $WooCommerceEventsViewSeatingChart   = get_post_meta($product_id, 'WooCommerceEventsViewSeatingChart', true);

        $WooCommerceEventsExportUnpaidTickets  = get_post_meta($product_id, 'WooCommerceEventsExportUnpaidTickets', true);
        $WooCommerceEventsExportBillingDetails = get_post_meta($product_id, 'WooCommerceEventsExportBillingDetails', true);

        $WooCommerceBadgeSize   = get_post_meta($product_id, 'WooCommerceBadgeSize', true);
        $WooCommerceBadgeField1 = get_post_meta($product_id, 'WooCommerceBadgeField1', true);
        $WooCommerceBadgeField2 = get_post_meta($product_id, 'WooCommerceBadgeField2', true);
        $WooCommerceBadgeField3 = get_post_meta($product_id, 'WooCommerceBadgeField3', true);

        $woocommerce_print_ticket_size     = get_post_meta($product_id, 'WooCommercePrintTicketSize', true);
        $WooCommercePrintTicketField1      = get_post_meta($product_id, 'WooCommercePrintTicketField1', true);
        $WooCommercePrintTicketField1_font = get_post_meta($product_id, 'WooCommercePrintTicketField1_font', true);
        $WooCommercePrintTicketField2      = get_post_meta($product_id, 'WooCommercePrintTicketField2', true);
        $WooCommercePrintTicketField2_font = get_post_meta($product_id, 'WooCommercePrintTicketField2_font', true);
        $WooCommercePrintTicketField3      = get_post_meta($product_id, 'WooCommercePrintTicketField3', true);
        $WooCommercePrintTicketField3_font = get_post_meta($product_id, 'WooCommercePrintTicketField3_font', true);
        $WooCommercePrintTicketField4      = get_post_meta($product_id, 'WooCommercePrintTicketField4', true);
        $WooCommercePrintTicketField4_font = get_post_meta($product_id, 'WooCommercePrintTicketField4_font', true);
        $WooCommercePrintTicketField5      = get_post_meta($product_id, 'WooCommercePrintTicketField5', true);
        $WooCommercePrintTicketField5_font = get_post_meta($product_id, 'WooCommercePrintTicketField5_font', true);
        $WooCommercePrintTicketField6      = get_post_meta($product_id, 'WooCommercePrintTicketField6', true);
        $WooCommercePrintTicketField6_font = get_post_meta($product_id, 'WooCommercePrintTicketField6_font', true);

        $WooCommerceEventsPrintTicketLogoOption = get_post_meta($product_id, 'WooCommerceEventsPrintTicketLogoOption', true);
        $WooCommerceEventsCutLinesPrintTicket   = get_post_meta($product_id, 'WooCommerceEventsCutLinesPrintTicket', true);
        $WooCommerceEventsTicketBackgroundImage = get_post_meta($product_id, 'WooCommerceEventsTicketBackgroundImage', true);
        $woocommerce_print_ticket_numbers       = get_post_meta($product_id, 'WooCommercePrintTicketNumbers', true);
        $woocommerce_print_ticket_orders        = get_post_meta($product_id, 'WooCommercePrintTicketOrders', true);
        $woocommerce_print_ticket_sort          = get_post_meta($product_id, 'WooCommercePrintTicketSort', true);
        $woocommerce_print_ticket_nr_columns    = get_post_meta($product_id, 'WooCommercePrintTicketNrColumns', true);
        $woocommerce_print_ticket_nr_rows       = get_post_meta($product_id, 'WooCommercePrintTicketNrRows', true);

        $woocommerce_badge_field_top_left      = get_post_meta($product_id, 'WooCommerceBadgeFieldTopLeft', true);
        $woocommerce_badge_field_top_middle    = get_post_meta($product_id, 'WooCommerceBadgeFieldTopMiddle', true);
        $woocommerce_badge_field_top_right     = get_post_meta($product_id, 'WooCommerceBadgeFieldTopRight', true);
        $woocommerce_badge_field_middle_left   = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleLeft', true);
        $woocommerce_badge_field_middle_middle = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleMiddle', true);
        $woocommerce_badge_field_middle_right  = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleRight', true);
        $woocommerce_badge_field_bottom_left   = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomLeft', true);
        $woocommerce_badge_field_bottom_middle = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomMiddle', true);
        $woocommerce_badge_field_bottom_right  = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomRight', true);

        $woocommerce_badge_field_top_left_custom      = get_post_meta($product_id, 'WooCommerceBadgeFieldTopLeft_custom', true);
        $woocommerce_badge_field_top_middle_custom    = get_post_meta($product_id, 'WooCommerceBadgeFieldTopMiddle_custom', true);
        $woocommerce_badge_field_top_right_custom     = get_post_meta($product_id, 'WooCommerceBadgeFieldTopRight_custom', true);
        $woocommerce_badge_field_middle_left_custom   = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleLeft_custom', true);
        $woocommerce_badge_field_middle_middle_custom = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleMiddle_custom', true);
        $woocommerce_badge_field_middle_right_custom  = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleRight_custom', true);
        $woocommerce_badge_field_bottom_left_custom   = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomLeft_custom', true);
        $woocommerce_badge_field_bottom_middle_custom = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomMiddle_custom', true);
        $woocommerce_badge_field_bottom_right_custom  = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomRight_custom', true);

        $woocommerce_badge_field_top_left_font      = get_post_meta($product_id, 'WooCommerceBadgeFieldTopLeft_font', true);
        $woocommerce_badge_field_top_middle_font    = get_post_meta($product_id, 'WooCommerceBadgeFieldTopMiddle_font', true);
        $woocommerce_badge_field_top_right_font     = get_post_meta($product_id, 'WooCommerceBadgeFieldTopRight_font', true);
        $woocommerce_badge_field_middle_left_font   = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleLeft_font', true);
        $woocommerce_badge_field_middle_middle_font = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleMiddle_font', true);
        $woocommerce_badge_field_middle_right_font  = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleRight_font', true);
        $woocommerce_badge_field_bottom_left_font   = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomLeft_font', true);
        $woocommerce_badge_field_bottom_middle_font = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomMiddle_font', true);
        $woocommerce_badge_field_bottom_right_font  = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomRight_font', true);

        $woocommerce_badge_field_top_left_logo      = get_post_meta($product_id, 'WooCommerceBadgeFieldTopLeft_logo', true);
        $woocommerce_badge_field_top_middle_logo    = get_post_meta($product_id, 'WooCommerceBadgeFieldTopMiddle_logo', true);
        $woocommerce_badge_field_top_right_logo     = get_post_meta($product_id, 'WooCommerceBadgeFieldTopRight_logo', true);
        $woocommerce_badge_field_middle_left_logo   = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleLeft_logo', true);
        $woocommerce_badge_field_middle_middle_logo = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleMiddle_logo', true);
        $woocommerce_badge_field_middle_right_logo  = get_post_meta($product_id, 'WooCommerceBadgeFieldMiddleRight_logo', true);
        $woocommerce_badge_field_bottom_left_logo   = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomLeft_logo', true);
        $woocommerce_badge_field_bottom_middle_logo = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomMiddle_logo', true);
        $woocommerce_badge_field_bottom_right_logo  = get_post_meta($product_id, 'WooCommerceBadgeFieldBottomRight_logo', true);

        $WooCommerceEventsCutLines = get_post_meta($product_id, 'WooCommerceEventsCutLines', true);

        $WooCommerceEventsEmailSubjectSingle = get_post_meta($product_id, 'WooCommerceEventsEmailSubjectSingle', true);
        $WooCommerceEventsTicketTheme        = get_post_meta($product_id, 'WooCommerceEventsTicketTheme', true);

        if (WCFMu_Dependencies::wcfm_wc_fooevents_pdfticket()) {
            $FooEvents_PDF_Tickets = new FooEvents_PDF_Tickets();
            $pdf_ticket_themes     = $FooEvents_PDF_Tickets->get_pdf_ticket_themes();

            $WooCommerceEventsPDFTicketTheme = get_post_meta($product_id, 'WooCommerceEventsPDFTicketTheme', true);

            if (empty($WooCommerceEventsPDFTicketTheme)) {
                $globalFooEventsPDFTicketsLayout = get_option('globalFooEventsPDFTicketsLayout');

                if ($globalFooEventsPDFTicketsLayout == 'multiple') {
                    $WooCommerceEventsPDFTicketTheme = $FooEvents_PDF_Tickets->Config->uploadsPath.'themes/default_pdf_multiple';
                } else {
                    $WooCommerceEventsPDFTicketTheme = $FooEvents_PDF_Tickets->Config->uploadsPath.'themes/default_pdf_single';
                }
            }
        }

        $WooCommerceEventsAttendeeOverride       = get_post_meta($product_id, 'WooCommerceEventsAttendeeOverride', true);
        $WooCommerceEventsAttendeeOverridePlural = get_post_meta($product_id, 'WooCommerceEventsAttendeeOverridePlural', true);
        $WooCommerceEventsTicketOverride         = get_post_meta($product_id, 'WooCommerceEventsTicketOverride', true);
        $WooCommerceEventsTicketOverridePlural   = get_post_meta($product_id, 'WooCommerceEventsTicketOverridePlural', true);


        $globalWooCommerceEventsGoogleMapsAPIKey = get_option('globalWooCommerceEventsGoogleMapsAPIKey', true);

        if ($globalWooCommerceEventsGoogleMapsAPIKey == 1) {
            $globalWooCommerceEventsGoogleMapsAPIKey = '';
        }

        if (empty($WooCommerceEventsEmailSubjectSingle)) {
            $WooCommerceEventsEmailSubjectSingle = __('{OrderNumber} Ticket', 'woocommerce-events');
        }

        $globalWooCommerceEventsTicketBackgroundColor = get_option('globalWooCommerceEventsTicketBackgroundColor', true);
        $globalWooCommerceEventsTicketButtonColor     = get_option('globalWooCommerceEventsTicketButtonColor', true);
        $globalWooCommerceEventsTicketTextColor       = get_option('globalWooCommerceEventsTicketTextColor', true);
        $globalWooCommerceEventsTicketLogo            = get_option('globalWooCommerceEventsTicketLogo', true);
        $globalWooCommerceEventsTicketHeaderImage     = get_option('globalWooCommerceEventsTicketHeaderImage', true);

        if (WCFMu_Dependencies::wcfm_wc_fooevents_multiday()) {
            $WooCommerceEventsEndDate           = get_post_meta($product_id, 'WooCommerceEventsEndDate', true);
            $WooCommerceEventsNumDays           = get_post_meta($product_id, 'WooCommerceEventsNumDays', true);
            $WooCommerceEventsMultiDayType      = get_post_meta($product_id, 'WooCommerceEventsMultiDayType', true);
            $WooCommerceEventsSelectDate        = get_post_meta($product_id, 'WooCommerceEventsSelectDate', true);
            $WooCommerceEventsDayOverride       = get_post_meta($product_id, 'WooCommerceEventsDayOverride', true);
            $WooCommerceEventsDayOverridePlural = get_post_meta($product_id, 'WooCommerceEventsDayOverridePlural', true);
        }

        if (WCFMu_Dependencies::wcfm_wc_fooevents_bookings()) {
            $WooCommerceEventsBookingsSlotOverride                 = get_post_meta($product_id, 'WooCommerceEventsDayOverridePlural', true);
            $WooCommerceEventsBookingsSlotOverridePlural           = get_post_meta($product_id, 'WooCommerceEventsBookingsSlotOverridePlural', true);
            $WooCommerceEventsBookingsDateOverride                 = get_post_meta($product_id, 'WooCommerceEventsBookingsDateOverride', true);
            $WooCommerceEventsBookingsDateOverridePlural           = get_post_meta($product_id, 'WooCommerceEventsBookingsDateOverridePlural', true);
            $WooCommerceEventsBookingsBookingDetailsOverride       = get_post_meta($product_id, 'WooCommerceEventsBookingsBookingDetailsOverride', true);
            $WooCommerceEventsBookingsBookingDetailsOverridePlural = get_post_meta($product_id, 'WooCommerceEventsBookingsBookingDetailsOverridePlural', true);
        }


        if (WCFMu_Dependencies::wcfm_wc_fooevents_calendar()) {
            $WooCommerceEventsBackgroundColor = get_post_meta($product_id, 'WooCommerceEventsBackgroundColor', true);
            $WooCommerceEventsTextColor       = get_post_meta($product_id, 'WooCommerceEventsTextColor', true);

            if (! empty($globalFooEventsEventbriteToken)) {
                $WooCommerceEventsAddEventbrite = get_post_meta($product_id, 'WooCommerceEventsAddEventbrite', true);
            }
        }

        if (WCFMu_Dependencies::wcfm_wc_fooevents_custom_atendee()) {
            $fooevents_custom_attendee_fields      = new Fooevents_Custom_Attendee_Fields(get_post($product_id));
            $events_include_custom_attendee_fields = $fooevents_custom_attendee_fields->generate_include_custom_attendee_options($event_post);

            $fooevents_custom_attendee_fields_options = $fooevents_custom_attendee_fields->display_tickets_meta_custom_options_array($product_id);

            if (! empty($fooevents_custom_attendee_fields_options['fooevents_custom_attendee_fields_options_serialized'])) {
                $custom_fields = json_decode($fooevents_custom_attendee_fields_options['fooevents_custom_attendee_fields_options_serialized'], true);

                foreach ($custom_fields as $key => $value) {
                    foreach ($value as $key_cf => $value_cf) {
                        if (strpos($key_cf, '_label') !== false) {
                            $cf_array['fooevents_custom_'.$key] = $value_cf;
                        }
                    }
                }
            }

            $fooevents_custom_attendee_fields_options_serialized = get_post_meta($product_id, 'fooevents_custom_attendee_fields_options_serialized', true);
            $fooevents_custom_attendee_fields_options            = json_decode($fooevents_custom_attendee_fields_options_serialized, true);

            $fooevents_custom_attendee_fields_options = $fooevents_custom_attendee_fields->correct_legacy_options($fooevents_custom_attendee_fields_options);

            if (empty($fooevents_custom_attendee_fields_options)) {
                $fooevents_custom_attendee_fields_options = [];
            }
        }//end if

        if (WCFMu_Dependencies::wcfm_wc_fooevents_seating()) {
            $fooevents_seating_options_serialized = get_post_meta($product_id, 'fooevents_seating_options_serialized', true);
            $fooevents_seating_options            = json_decode($fooevents_seating_options_serialized, true);

            if (empty($fooevents_seating_options)) {
                $fooevents_seating_options = [];
            }
        }

        if (WCFMu_Dependencies::wcfm_wc_fooevents_pdfticket()) {
            $FooEventsPDFTicketsEmailText = get_post_meta($product_id, 'FooEventsPDFTicketsEmailText', true);
            $FooEventsTicketFooterText    = get_post_meta($product_id, 'FooEventsTicketFooterText', true);

            if (empty($FooEventsPDFTicketsEmailText)) {
                $FooEventsPDFTicketsEmailText = __('Your tickets are attached. Please print them and bring them to the event. ', 'fooevents-pdf-tickets');
            }

            if (empty($FooEventsTicketFooterText)) {
                $FooEventsTicketFooterText = __("Cut out the tickets or keep them together. Don't forget to take them to the event. When printing please use a standard A4 portrait size. Incorrect sizing could effect the reading of the barcode.", 'fooevents-pdf-tickets');
            }
        }

        $WooCommerceEventsExpire                   = get_post_meta($product_id, 'WooCommerceEventsExpire', true);
        $WooCommerceEventsExpireMessage            = get_post_meta($product_id, 'WooCommerceEventsExpireMessage', true);
        $WooCommerceEventsTicketExpirationType     = get_post_meta($product_id, 'WooCommerceEventsTicketExpirationType', true);
        $WooCommerceEventsTicketsExpireSelect      = get_post_meta($product_id, 'WooCommerceEventsTicketsExpireSelect', true);
        $WooCommerceEventsTicketsExpireValue       = get_post_meta($product_id, 'WooCommerceEventsTicketsExpireValue', true);
        $WooCommerceEventsTicketsExpireUnit        = get_post_meta($product_id, 'WooCommerceEventsTicketsExpireUnit', true);
        $WooCommerceEventsBookingsExpirePassedDate = get_post_meta($product_id, 'WooCommerceEventsBookingsExpirePassedDate', true);

        $woocommerce_events_zoom_host         = get_post_meta($product_id, 'WooCommerceEventsZoomHost', true);
        $woocommerce_events_zoom_type         = get_post_meta($product_id, 'WooCommerceEventsZoomType', true);
        $woocommerce_events_zoom_multi_option = get_post_meta($product_id, 'WooCommerceEventsZoomMultiOption', true);
        $woocommerce_events_zoom_webinar      = get_post_meta($product_id, 'WooCommerceEventsZoomWebinar', true);

        $woocommerce_events_type = get_post_meta($product_id, 'WooCommerceEventsType', true);
        // LEGACY: 20201110.
        $woocommerce_events_multi_day_type = get_post_meta($product_id, 'WooCommerceEventsMultiDayType', true);
    }//end if

    $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
}//end if

if (empty($woocommerce_events_type) && ( 'sequential' === $woocommerce_events_multi_day_type || 'select' === $woocommerce_events_multi_day_type )) {
    $woocommerce_events_type = $woocommerce_events_multi_day_type;
    // ENDLEGACY: 20201110.
} else if (empty($woocommerce_events_type)) {
    $woocommerce_events_type = 'single';
}

if (! is_array($woocommerce_events_ticket_add_calendar_reminders)) {
    $woocommerce_events_ticket_add_calendar_reminders = [
        [
            'amount' => 1,
            'unit'   => 'weeks',
        ],
        [
            'amount' => 1,
            'unit'   => 'days',
        ],
        [
            'amount' => 1,
            'unit'   => 'hours',
        ],
        [
            'amount' => 15,
            'unit'   => 'minutes',
        ],
    ];
}

$fooevent_Config = new FooEvents_Config();

// Load WooHelper compatible version
if (isset($fooevent_Config->class_path) && file_exists($fooevent_Config->class_path.'class-fooevents-woo-helper.php')) {
    include_once $fooevent_Config->class_path.'class-fooevents-woo-helper.php';
} else {
    include_once $fooevent_Config->classPath.'woohelper.php';
}

// ZoomAPIHelper.
$zoom_api_helper = '';
if (isset($fooevent_Config->class_path) && file_exists($fooevent_Config->class_path.'class-fooevents-zoom-api-helper.php')) {
    include_once $fooevent_Config->class_path.'class-fooevents-zoom-api-helper.php';
    $zoom_api_helper = new FooEvents_Zoom_API_Helper($fooevent_Config);
}

$fooevent_WooHelper = new FooEvents_Woo_Helper($fooevent_Config);
$themes             = $fooevent_WooHelper->get_ticket_themes();

$zoom_webinars = $zoom_api_helper->fooevents_fetch_zoom_webinars();
$zoom_meetings = $zoom_api_helper->fooevents_fetch_zoom_meetings();

$dayTerm = __('Day', 'fooevents-multiday-events');

$rich_editor = apply_filters('wcfm_is_allow_rich_editor', 'rich_editor');
$wpeditor    = apply_filters('wcfm_is_allow_product_wpeditor', 'wpeditor');
if ($wpeditor && $rich_editor) {
    $rich_editor = 'wcfm_wpeditor';
} else {
    $wpeditor = 'textarea';
}

?>

<div class="page_collapsible products_manage_wc_fooevents <?php echo apply_filters('wcfm_pm_block_class_fooevents', 'simple variable'); ?>" id="wcfm_products_manage_form_wc_fooevents_head"><label class="wcfmfa fa-calendar-alt"></label><?php _e('Event', 'wc-frontend-manager-ultimate'); ?><span></span></div>
<div class="wcfm-container <?php echo apply_filters('wcfm_pm_block_class_fooevents', 'simple variable'); ?>">
    <div id="wcfm_products_manage_form_wc_fooevents_expander" class="wcfm-content">
          <h2><?php esc_attr_e('Event Settings', 'fooevents-custom-attendee-fields'); ?></h2>
          <div class="wcfm_clearfix"></div>
      
          <div id="woocommerce_events_data" class="panel woocommerce_options_panel">
    
            <div class="options_group">
                <p class="form-field">
                      <span class="wcfm_title"><strong><?php esc_attr_e('Is this product an event?', 'woocommerce-events'); ?></strong>
                          <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This option enables event and ticketing functionality.', 'woocommerce-events'); ?>"></span>
                    </span>
                    <select name="WooCommerceEventsEvent" id="WooCommerceEventsEvent" class="wcfm-select">
                          <option value="NotEvent" <?php echo ( $WooCommerceEventsEvent == 'NotEvent' ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('No', 'woocommerce-events'); ?></option>
                        <option value="Event" <?php echo ( $WooCommerceEventsEvent == 'Event' ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Yes', 'woocommerce-events'); ?></option>
                    </select>
                </p>
              </div>
    
              <div id="WooCommerceEventsForm" style="display:none;">
                <div class="options_group" id="WooCommerceEventsTypeHolder">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Event type:', 'woocommerce-events'); ?></strong></span>
                        <input type="radio" name="WooCommerceEventsType" value="single" <?php echo ( $woocommerce_events_type == 'single' ) ? 'CHECKED' : ''; ?>> <?php esc_attr_e('Single', 'woocommerce-events'); ?><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Standard one-day events.', 'woocommerce-events'); ?>"></span><br>
                        <span class="wcfm_title"><strong></strong></span>
                        <input type="radio" name="WooCommerceEventsType" value="sequential" <?php echo ( $woocommerce_events_type == 'sequential' ) ? 'CHECKED' : ''; ?> <?php echo( true === WCFMu_Dependencies::wcfm_wc_fooevents_multiday() ) ? '' : 'DISABLED'; ?>> <?php esc_attr_e('Sequential days', 'woocommerce-events'); ?><a href="https://www.fooevents.com/products/fooevents-multi-day/"><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Events that repeat over multiple calendar days. Note: Requires the FooEvents Multi-day plugin.', 'woocommerce-events'); ?>"></span></a><br>
                        <span class="wcfm_title"><strong></strong></span>
                        <input type="radio" name="WooCommerceEventsType" value="select" <?php echo ( $woocommerce_events_type == 'select' ) ? 'CHECKED' : ''; ?> <?php echo( true === WCFMu_Dependencies::wcfm_wc_fooevents_multiday() ) ? '' : 'DISABLED'; ?>> <?php esc_attr_e('Select days', 'woocommerce-events'); ?><a href="https://www.fooevents.com/products/fooevents-multi-day/"><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Events that occur over multiple days and repeat for a set number of sequential days. Note: Requires the FooEvents Multi-day plugin.', 'woocommerce-events'); ?>"></span></a><br>
                        <span class="wcfm_title"><strong></strong></span>
                        <input type="radio" name="WooCommerceEventsType" value="bookings" <?php echo ( $woocommerce_events_type == 'bookings' ) ? 'CHECKED' : ''; ?> <?php echo( true === WCFMu_Dependencies::wcfm_wc_fooevents_bookings() ) ? '' : 'DISABLED'; ?>> <?php esc_attr_e('Bookable', 'woocommerce-events'); ?><a href="https://www.fooevents.com/fooevents-bookings/"><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Events that require customers to select from available date and time slots (bookings and repeat events). Note: Requires the FooEvents Bookings plugin.', 'woocommerce-events'); ?>"></span></a><br>
                        <span class="wcfm_title"><strong></strong></span>
                        <input type="radio" name="WooCommerceEventsType" value="seating" <?php echo ( $woocommerce_events_type == 'seating' ) ? 'CHECKED' : ''; ?> <?php echo( true === WCFMu_Dependencies::wcfm_wc_fooevents_seating() ) ? '' : 'DISABLED'; ?>> <?php esc_attr_e('Seating', 'woocommerce-events'); ?><a href="https://www.fooevents.com/fooevents-seating/"><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Events that include the ability for customers to select row and seat numbers from a seating chart. Note: Requires the FooEvents Seating plugin.', 'woocommerce-events'); ?>"></span></a><br>
                    </p>
                </div>
                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_multiday()) { ?>
                    <div class="options_group" id="WooCommerceEventsNumDaysContainer">
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php _e('Number of days:', 'fooevents-multiday-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php _e('Select the number of days for multi-day events. This setting is used by the Event Check-ins apps to manage daily check-ins.', 'fooevents-multiday-events'); ?>"></span>
                            </span>
                            <select name="WooCommerceEventsNumDays" id="WooCommerceEventsNumDays" class="wcfm-select">
                                <?php for ($x = 1; $x <= 30; $x++) : ?>
                                    <option value="<?php echo $x; ?>" <?php echo ( $WooCommerceEventsNumDays == $x ) ? 'SELECTED' : ''; ?>><?php echo $x; ?></option>
                                <?php endfor; ?>
                            </select>
                        </p>
                    </div>
                    <div class="options_group" id ="WooCommerceEventsSelectDateContainer">
                        <?php if (! empty($WooCommerceEventsSelectDate)) : ?>
                            <?php $x = 1; ?>
                            <?php foreach ($WooCommerceEventsSelectDate as $eventDate) : ?>
                                <p class="form-field">
                                    <span class="wcfm_title"><strong><?php echo $dayTerm; ?> <?php echo $x; ?></strong></span>
                                    <input type="text" class="wcfm-text" class="WooCommerceEventsSelectDate" name="WooCommerceEventsSelectDate[]" value="<?php echo esc_attr($eventDate); ?>"/>
                                </p>
                                <?php $x++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <?php
                }//end if
                ?>
                <div class="options_group" id="WooCommerceEventsDateContainer">
                    <p class="form-field">
                        <span class="wcfm_title">
                            <strong><?php esc_attr_e('Start Date:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("The date that the event is scheduled to take place. This is used as a label on your website and it's also used by the FooEvents Calendar to display the event.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="text" class="wcfm-text" id="WooCommerceEventsDate" name="WooCommerceEventsDate" value="<?php echo esc_attr($WooCommerceEventsDate); ?>"/>
                    </p>
                </div>
                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_multiday()) { ?>
                    <div class="options_group" id="WooCommerceEventsEndDateContainer">
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php _e('End Date:', 'fooevents-multiday-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("The date that the event is scheduled to end. This is used as a label on your website and it's also used by the FooEvents Calendar to display a multi-day event.", 'fooevents-multiday-events'); ?>"></span>
                            </span>
                            <input type="text" class="wcfm-text" id="WooCommerceEventsEndDate" name="WooCommerceEventsEndDate" value="<?php echo esc_attr($WooCommerceEventsEndDate); ?>"/>
                        </p>
                    </div>
                <?php } ?>
                <div class="options_group" id="WooCommerceEventsTimeContainer">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Start time:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('The time that the event is scheduled to start.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <select name="WooCommerceEventsHour" id="WooCommerceEventsHour" class="wcfm-select width10">
                            <?php for ($x = 0; $x <= 23; $x++) : ?>
                                <?php $x = sprintf('%02d', $x); ?>
                                <option value="<?php echo esc_attr($x); ?>" <?php echo ( $WooCommerceEventsHour == $x ) ? 'SELECTED' : ''; ?>><?php echo esc_attr($x); ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="WooCommerceEventsMinutes" id="WooCommerceEventsMinutes" class="wcfm-select width10">
                            <?php for ($x = 0; $x <= 59; $x++) : ?>
                                <?php $x = sprintf('%02d', $x); ?>
                                <option value="<?php echo esc_attr($x); ?>" <?php echo ( $WooCommerceEventsMinutes == $x ) ? 'SELECTED' : ''; ?>><?php echo esc_attr($x); ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="WooCommerceEventsPeriod" id="WooCommerceEventsPeriod" class="wcfm-select width10" <?php echo ( $WooCommerceEventsHour > 12 || $WooCommerceEventsHourEnd > 12 ) ? 'disabled' : ''; ?>>
                            <option value="">-</option>
                            <option value="a.m." <?php echo ( $WooCommerceEventsPeriod == 'a.m.' ) ? 'SELECTED' : ''; ?>>a.m.</option>
                            <option value="p.m." <?php echo ( $WooCommerceEventsPeriod == 'p.m.' ) ? 'SELECTED' : ''; ?>>p.m.</option>
                        </select>
                    </p>
                </div>
                <div class="options_group" id="WooCommerceEventsEndTimeContainer">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('End time:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('The time that the event is scheduled to end.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <select name="WooCommerceEventsHourEnd" id="WooCommerceEventsHourEnd" class="wcfm-select width10">
                            <?php for ($x = 0; $x <= 23; $x++) : ?>
                                <?php $x = sprintf('%02d', $x); ?>
                                <option value="<?php echo esc_attr($x); ?>" <?php echo ( $WooCommerceEventsHourEnd == $x ) ? 'SELECTED' : ''; ?>><?php echo esc_attr($x); ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="WooCommerceEventsMinutesEnd" id="WooCommerceEventsMinutesEnd" class="wcfm-select width10">
                            <?php for ($x = 0; $x <= 59; $x++) : ?>
                                <?php $x = sprintf('%02d', $x); ?>
                                <option value="<?php echo esc_attr($x); ?>" <?php echo ( $WooCommerceEventsMinutesEnd == $x ) ? 'SELECTED' : ''; ?>><?php echo esc_attr($x); ?></option>
                            <?php endfor; ?>
                        </select>
                        <select name="WooCommerceEventsEndPeriod" id="WooCommerceEventsEndPeriod" class="wcfm-select width10" <?php echo ( $WooCommerceEventsHour > 12 || $WooCommerceEventsHourEnd > 12 ) ? 'disabled' : ''; ?>>
                            <option value="">-</option>
                            <option value="a.m." <?php echo ( $WooCommerceEventsEndPeriod == 'a.m.' ) ? 'SELECTED' : ''; ?>>a.m.</option>
                            <option value="p.m." <?php echo ( $WooCommerceEventsEndPeriod == 'p.m.' ) ? 'SELECTED' : ''; ?>>p.m.</option>
                        </select>
                    </p>
                </div>
                <div class="options_group" id="WooCommerceEventsTimezoneContainer">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Time zone:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("The time zone where the event is taking place. If no time zone is set then the attendee's local time zone will be used for the 'Add to Calendar' functionality in the ticket email.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <select name="WooCommerceEventsTimeZone" id="WooCommerceEventsTimeZone" class="wcfm-select">
                            <option value="" <?php echo ( '' === $woocommerce_events_timezone ) ? 'SELECTED' : ''; ?>>(Not set)</option>
                            <?php foreach ($tzlist as $tz) : ?>
                                <option value="<?php echo esc_attr($tz); ?>" <?php echo ( $woocommerce_events_timezone === $tz ) ? 'SELECTED' : ''; ?>><?php echo esc_attr(str_replace('_', ' ', str_replace('/', ' / ', $tz))); ?></option>
                            <?php endforeach; ?>     
                        </select>
                    </p>
                </div>
                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_calendar() && ! empty($globalFooEventsEventbriteToken)) { ?>
                    <div class="options_group">
                        <p class="form-field">
                            <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Add event to EventBrite', 'fooevents-calendar'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Checking this option will submit the event to Eventbrite.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input class="wcfm-checkbox" type="checkbox" id="WooCommerceEventsMetaBoxAddEventbrite" name="WooCommerceEventsAddEventbrite" value="1" <?php echo $WooCommerceEventsAddEventbrite ? esc_attr('checked="checked"') : ''; ?>/>
                        </p>
                    </div>
                <?php } ?>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Venue:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('The venue where the event will be hosted.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="text" class="wcfm-text" id="WooCommerceEventsLocation" name="WooCommerceEventsLocation" value="<?php echo esc_attr($WooCommerceEventsLocation); ?>"/>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('GPS Coordinates:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('GPS coordinates for the venue.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="text" class="wcfm-text" id="WooCommerceEventsGPS" name="WooCommerceEventsGPS" value="<?php echo esc_attr($WooCommerceEventsGPS); ?>"/>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Google Maps coordinates:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('GPS coordinates that are used to calculate the pin position for Google Maps on the event page. A valid Google Maps API key must first be saved in FooEvents settings.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="text" class="wcfm-text" id="WooCommerceEventsGoogleMaps" name="WooCommerceEventsGoogleMaps" value="<?php echo esc_attr($WooCommerceEventsGoogleMaps); ?>"/>
                        <?php if (! wcfm_is_vendor() && empty($globalWooCommerceEventsGoogleMapsAPIKey)) : ?>
                            <p class="description">
                            <?php esc_attr_e('Google Maps API key not set.', 'woocommerce-events'); ?> <a href="admin.php?page=wc-settings&tab=settings_woocommerce_events"><?php esc_attr_e('Please check the Event Integration settings.', 'woocommerce-events'); ?></a>
                            </p>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Directions:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Directions to the venue.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <textarea name="WooCommerceEventsDirections" id="WooCommerceEventsDirections" class="wcfm-textarea"><?php echo esc_attr($WooCommerceEventsDirections); ?></textarea>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Phone number:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Event organizer's contact number.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="text" class="wcfm-text" id="WooCommerceEventsSupportContact" name="WooCommerceEventsSupportContact" value="<?php echo esc_attr($WooCommerceEventsSupportContact); ?>"/>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Email address:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Event organizer's email address.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="text" class="wcfm-text" id="WooCommerceEventsEmail" name="WooCommerceEventsEmail" value="<?php echo esc_attr($WooCommerceEventsEmail); ?>"/>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <?php
                        $WCFM->wcfm_fields->wcfm_generate_form_field(
                            [
                                'WooCommerceEventsThankYouText' => [
                                    'label'       => __('Thank-you page text:', 'woocommerce-events'),
                                    'type'        => $wpeditor,
                                    'class'       => 'wcfm-textarea wcfm_ele wcfm_full_ele simple variable external grouped booking wcfm_custom_field_editor '.$rich_editor,
                                    'label_class' => 'wcfm_title wcfm_full_ele',
                                    'rows'        => 5,
                                    'value'       => $WooCommerceEventsThankYouText,
                                    'teeny'       => true,
                                ],
                            ]
                        );
                        ?>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <?php
                        $WCFM->wcfm_fields->wcfm_generate_form_field(
                            [
                                'WooCommerceEventsEventDetailsText' => [
                                    'label'       => __('Event details tab text:', 'woocommerce-events'),
                                    'type'        => $wpeditor,
                                    'class'       => 'wcfm-textarea wcfm_ele wcfm_full_ele simple variable external grouped booking wcfm_custom_field_editor '.$rich_editor,
                                    'label_class' => 'wcfm_title wcfm_full_ele',
                                    'rows'        => 5,
                                    'value'       => $WooCommerceEventsEventDetailsText,
                                    'teeny'       => true,
                                ],
                            ]
                        );
                        ?>
                    </p>
                </div>
                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_calendar()) { ?>
                    <div class="options_group">
                        <?php $globalWooCommerceEventsTicketTextColor = ( empty($globalWooCommerceEventsTicketTextColor) ) ? '' : $globalWooCommerceEventsTicketTextColor; ?>
                        <?php $WooCommerceEventsBackgroundColor = ( empty($WooCommerceEventsBackgroundColor) ) ? $globalWooCommerceEventsTicketTextColor : $WooCommerceEventsBackgroundColor; ?>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Calendar background color:', 'fooevents-calendar'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Color of the calendar background for the event. Also changes the background color of the date icon in the FooEvents Check-ins app.', 'fooevents-calendar'); ?>"></span>
                            </span>
                            <input class="woocommerce-events-color-field" type="text" name="WooCommerceEventsBackgroundColor" value="<?php echo esc_html($WooCommerceEventsBackgroundColor); ?>"/>
                        </p>
                    </div>
                    <div class="options_group">
                        <?php $globalWooCommerceEventsTicketTextColor = ( empty($globalWooCommerceEventsTicketTextColor) ) ? '' : $globalWooCommerceEventsTicketTextColor; ?>
                        <?php $WooCommerceEventsTextColor = ( empty($WooCommerceEventsTextColor) ) ? $globalWooCommerceEventsTicketTextColor : $WooCommerceEventsTextColor; ?>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Calendar text color:', 'fooevents-calendar'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Color of the calendar text for the event. Also changes the font color of the date icon in the FooEvents Check-ins app.', 'fooevents-calendar'); ?>"></span>
                            </span>
                            <input class="woocommerce-events-color-field" type="text" name="WooCommerceEventsTextColor" value="<?php echo esc_html($WooCommerceEventsTextColor); ?>"/>
                        </p>
                    </div>
                    <?php
                }//end if
                ?>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Capture attendee full name and email address? ', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This will add attendee capture fields on the checkout screen.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsCaptureAttendeeDetails" value="on" <?php echo ( $WooCommerceEventsCaptureAttendeeDetails === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Capture attendee phone number?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This will add a telephone number field to the attendee capture fields on the checkout screen.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsCaptureAttendeeTelephone" value="on" <?php echo ( $WooCommerceEventsCaptureAttendeeTelephone === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Capture attendee company name?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This will add a company field to the attendee capture fields on the checkout screen.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsCaptureAttendeeCompany" value="on" <?php echo ( $WooCommerceEventsCaptureAttendeeCompany === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Capture attendee designation?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This will add a designation field to the attendee capture fields on the checkout screen.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsCaptureAttendeeDesignation" value="on" <?php echo ( $WooCommerceEventsCaptureAttendeeDesignation === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Validate unique attendee email addresses at checkout?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("If enabled an unique email address which hasn't already been used to register for the event is required for all attendees before checkout can be completed.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsUniqueEmail" value="on" <?php echo ( $WooCommerceEventsUniqueEmail === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_seating()) : ?>
                    <div class="options_group">
                        <p class="form-field">
                            <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display seating options on product pages?', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This will display the seating options on the product page and make it required to select seats before proceeding to check out. Before enabling this option, please ensure that you have setup a seating chart on the Event Seating tab.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsViewSeatingOptions" value="on" <?php echo ( empty($WooCommerceEventsViewSeatingOptions) || $WooCommerceEventsViewSeatingOptions === 'off' ) ? '' : 'CHECKED'; ?>>
                        </p>
                    </div>
                    <div class="options_group">
                        <p class="form-field">
                            <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display seating chart on checkout page?', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("This will display a 'View seating chart' link on the checkout page. Before enabling this option, please ensure that you have setup a seating chart on the Event Seating tab.", 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsViewSeatingChart" value="on" <?php echo ( empty($WooCommerceEventsViewSeatingChart) || $WooCommerceEventsViewSeatingChart === 'on' ) ? 'CHECKED' : ''; ?>>
                        </p>
                    </div>
                <?php endif; ?>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display event details in New Order email?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("This will display the event details in the 'New Order' transactional email which WooCommerce sends to the store admin.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsEventDetailsNewOrder" value="on" <?php echo ( empty($WooCommerceEventsEventDetailsNewOrder) || $WooCommerceEventsEventDetailsNewOrder === 'off' ) ? '' : 'CHECKED'; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display attendee details in New Order email?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("This will display the attendee details in the 'New Order' transactional email which WooCommerce sends to the store admin.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsDisplayAttendeeNewOrder" value="on" <?php echo ( empty($WooCommerceEventsDisplayAttendeeNewOrder) || $WooCommerceEventsDisplayAttendeeNewOrder === 'off' ) ? '' : 'CHECKED'; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display booking details in New Order email?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("This will display the booking details in the 'New Order' transactional email which WooCommerce sends to the store admin.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsDisplayBookingsNewOrder" value="on" <?php echo ( empty($WooCommerceEventsDisplayBookingsNewOrder) || $WooCommerceEventsDisplayBookingsNewOrder === 'off' ) ? '' : 'CHECKED'; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display seating details in New Order email?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("This will display the seating details in the 'New Order' transactional email which WooCommerce sends to the store admin.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsDisplaySeatingsNewOrder" value="on" <?php echo ( empty($WooCommerceEventsDisplaySeatingsNewOrder) || $WooCommerceEventsDisplaySeatingsNewOrder === 'off' ) ? '' : 'CHECKED'; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display custom attendee details in New Order email?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("This will display the custom attendee details in the 'New Order' transactional email which WooCommerce sends to the store admin.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsDisplayCustAttNewOrder" value="on" <?php echo ( empty($WooCommerceEventsDisplayCustAttNewOrder) || $WooCommerceEventsDisplayCustAttNewOrder === 'off' ) ? '' : 'CHECKED'; ?>>
                    </p>
                </div>

                <!-- Ticket Settings -->
                <div class="options_group">
                    <p>
                        <h2><?php esc_attr_e('Ticket Settings', 'woocommerce-events'); ?></h2
                        ><div class="wcfm-clearfix"></div>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('HTML ticket theme:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Select the ticket theme that will be used to style the embedded HTML tickets within ticket emails.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <select name="WooCommerceEventsTicketTheme" id="WooCommerceEventsTicketTheme" class="wcfm-select">
                            <?php foreach ($themes as $theme => $theme_details) : ?>
                                <option value="<?php echo esc_attr($theme_details['path']); ?>" <?php echo ( $WooCommerceEventsTicketTheme == $theme_details['path'] ) ? 'SELECTED' : ''; ?>><?php echo esc_attr($theme_details['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p> 
                </div>
                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_pdfticket()) { ?>
                    <div class="options_group">
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('PDF ticket theme:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Select the PDF compatible ticket theme that will be used to style the PDF tickets that are attached to ticket emails.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <select name="WooCommerceEventsPDFTicketTheme" id="WooCommerceEventsPDFTicketTheme" class="wcfm-select">
                                <?php foreach ($pdf_ticket_themes as $theme => $theme_details) : ?>
                                    <option value="<?php echo esc_attr($theme_details['path']); ?>" <?php echo ( $WooCommerceEventsPDFTicketTheme == $theme_details['path'] ) ? 'SELECTED' : ''; ?>><?php echo esc_attr($theme_details['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p> 
                    </div>
                <?php } ?>
                <div class="options_group">
                    <?php $WooCommerceEventsTicketLogo = ( empty($WooCommerceEventsTicketLogo) ) ? $globalWooCommerceEventsTicketLogo : $WooCommerceEventsTicketLogo; ?>
                    <p class="form-field">
                        <?php
                        $WCFM->wcfm_fields->wcfm_generate_form_field(
                            [
                                'WooCommerceEventsTicketLogo' => [
                                    'label'                => esc_attr__('Ticket logo:', 'woocommerce-events'),
                                    'wcfm_uploader_by_url' => true,
                                    'type'                 => 'upload',
                                    'label_class'          => 'wcfm_title',
                                    'value'                => $WooCommerceEventsTicketLogo,
                                    'hints'                => esc_attr__('Full URL that links to the logo that will be used in the ticket (JPG or PNG format).', 'woocommerce-events'),
                                ],
                            ]
                        );
                        ?>
                    </p>
                </div>
                <div class="options_group">
                    <?php $WooCommerceEventsTicketHeaderImage = ( empty($WooCommerceEventsTicketHeaderImage) ) ? $globalWooCommerceEventsTicketHeaderImage : $WooCommerceEventsTicketHeaderImage; ?>
                    <p class="form-field">
                        <?php
                        $WCFM->wcfm_fields->wcfm_generate_form_field(
                            [
                                'WooCommerceEventsTicketHeaderImage' => [
                                    'label'                => esc_attr__('Ticket header image:', 'woocommerce-events'),
                                    'wcfm_uploader_by_url' => true,
                                    'type'                 => 'upload',
                                    'label_class'          => 'wcfm_title',
                                    'value'                => $WooCommerceEventsTicketHeaderImage,
                                    'hints'                => esc_attr__('Full URL that links to the image that will be used as the ticket header (JPG or PNG format).', 'woocommerce-events'),
                                ],
                            ]
                        );
                        ?>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Ticket email subject:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('The subject line used in ticket emails. Use {OrderNumber} to display the proper order number.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="text" class="wcfm-text" id="WooCommerceEventsEmailSubjectSingle" name="WooCommerceEventsEmailSubjectSingle" value="<?php echo esc_attr($WooCommerceEventsEmailSubjectSingle); ?>"/>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <?php
                        $WCFM->wcfm_fields->wcfm_generate_form_field(
                            [
                                'WooCommerceEventsTicketText' => [
                                    'label'       => esc_attr__('Ticket email body:', 'woocommerce-events'),
                                    'type'        => $wpeditor,
                                    'class'       => 'wcfm-textarea wcfm_ele wcfm_full_ele simple variable external grouped booking wcfm_custom_field_editor '.$rich_editor,
                                    'label_class' => 'wcfm_title wcfm_full_ele',
                                    'rows'        => 5,
                                    'value'       => $WooCommerceEventsTicketText,
                                    'teeny'       => true,
                                ],
                            ]
                        );
                        ?>
                    </p>
                </div>
                <div class="options_group">
                    <?php $globalWooCommerceEventsTicketBackgroundColor = ( empty($globalWooCommerceEventsTicketBackgroundColor) ) ? '' : $globalWooCommerceEventsTicketBackgroundColor; ?>
                    <?php $WooCommerceEventsTicketBackgroundColor = ( empty($WooCommerceEventsTicketBackgroundColor) ) ? $globalWooCommerceEventsTicketBackgroundColor : $WooCommerceEventsTicketBackgroundColor; ?>
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Ticket accent:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This color is used for the ticket border or background.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input class="woocommerce-events-color-field" type="text" name="WooCommerceEventsTicketBackgroundColor" value="<?php echo ''.$WooCommerceEventsTicketBackgroundColor; ?>"/>
                    </p>
                </div>
                <div class="options_group">
                    <?php $globalWooCommerceEventsTicketButtonColor = ( empty($globalWooCommerceEventsTicketButtonColor) ) ? '' : $globalWooCommerceEventsTicketButtonColor; ?>
                    <?php $WooCommerceEventsTicketButtonColor = ( empty($WooCommerceEventsTicketButtonColor) ) ? $globalWooCommerceEventsTicketButtonColor : $WooCommerceEventsTicketButtonColor; ?>
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Ticket button:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Color of the ticket button.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input class="woocommerce-events-color-field" type="text" name="WooCommerceEventsTicketButtonColor" value="<?php echo ''.$WooCommerceEventsTicketButtonColor; ?>"/>
                    </p>
                </div>
                <div class="options_group">
                    <?php $globalWooCommerceEventsTicketTextColor = ( empty($globalWooCommerceEventsTicketTextColor) ) ? '' : $globalWooCommerceEventsTicketTextColor; ?>
                    <?php $WooCommerceEventsTicketTextColor = ( empty($WooCommerceEventsTicketTextColor) ) ? $globalWooCommerceEventsTicketTextColor : $WooCommerceEventsTicketTextColor; ?>
                    <p class="form-field">
                        <span class="wcfm_title"><strong><?php esc_attr_e('Ticket button text:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Color of the ticket button text.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input class="woocommerce-events-color-field" type="text" name="WooCommerceEventsTicketTextColor" value="<?php echo ''.$WooCommerceEventsTicketTextColor; ?>"/>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display purchaser or attendee details on ticket?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Display the purchaser/attendee's name and details on the ticket.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsTicketPurchaserDetails" value="on" <?php echo ( empty($WooCommerceEventsTicketPurchaserDetails) || $WooCommerceEventsTicketPurchaserDetails === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display custom attendee details on ticket?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This will display custom attendee fields on the ticket.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" name="WooCommerceEventsIncludeCustomAttendeeDetails" value="on" <?php echo ( $WooCommerceEventsIncludeCustomAttendeeDetails == 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display "Add to calendar" option on ticket?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Display an 'Add to calendar' button on the ticket which will generate an ICS file containing the event details when clicked.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" id="WooCommerceEventsTicketAddCalendarMeta" name="WooCommerceEventsTicketAddCalendar" value="on" <?php echo ( empty($WooCommerceEventsTicketAddCalendar) || $WooCommerceEventsTicketAddCalendar == 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <div class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('"Add to calendar" reminder alerts:', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Add calendar alerts at specified intervals to remind attendees about the event. These alerts will automatically appear in the attendee's calendar client after clicking the 'Add to calendar' button on the ticket.", 'woocommerce-events'); ?>"></span>
                        </span>
                        <div class="wcfm-wrap">
                            <div id="fooevents_add_to_calendar_reminders_container">
                                <?php
                                for ($i = 0; $i < count($woocommerce_events_ticket_add_calendar_reminders); $i++) {
                                    $reminder = $woocommerce_events_ticket_add_calendar_reminders[$i];
                                    ?>
                                    <div class="fooevents-add-to-calendar-reminder-row">
                                        <input class="wcfm-text width25" type="number" min="0" step="1" name="WooCommerceEventsTicketAddCalendarReminderAmounts[]" value="<?php echo esc_attr($reminder['amount']); ?>" />
                                        <select class="wcfm-select width35" name="WooCommerceEventsTicketAddCalendarReminderUnits[]">
                                            <?php
                                            $units = [
                                                'minutes',
                                                'hours',
                                                'days',
                                                'weeks',
                                            ];
                                            foreach ($units as $unit) {
                                                ?>
                                                <option value="<?php echo esc_attr($unit); ?>" <?php echo $reminder['unit'] === $unit ? 'SELECTED' : ''; ?>><?php echo esc_attr($unit); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <a href="#" class="fooevents_add_to_calendar_reminders_remove">[X]</a>
                                        </div>
                                    <?php
                                }//end for
                                ?>
                            </div>
                            <a href="#" id="fooevents_add_to_calendar_reminders_new_field" class="button wcfm-button-primary wcfm_submit_button"><?php esc_attr_e('+ New reminder', 'woocommerce-events'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Attach calendar ICS file to the ticket email?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Attach an ICS file to the ticket email so that the event details automatically appear in certain calendar clients.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsTicketAttachICS" value="on" <?php echo ( empty($WooCommerceEventsTicketAttachICS) || $WooCommerceEventsTicketAttachICS == 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display date and time on ticket?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Display the time and date of the event on the ticket.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsTicketDisplayDateTime" value="on" <?php echo ( empty($WooCommerceEventsTicketDisplayDateTime) || $WooCommerceEventsTicketDisplayDateTime == 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display barcode on ticket?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Display a barcode on the ticket which is used for check-ins.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsTicketDisplayBarcode" value="on" <?php echo ( empty($WooCommerceEventsTicketDisplayBarcode) || $WooCommerceEventsTicketDisplayBarcode == 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display price on ticket?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Display the ticket price on the ticket.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsTicketDisplayPrice" value="on" <?php echo ( $WooCommerceEventsTicketDisplayPrice == 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display booking details on ticket?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Display the booking details on the ticket.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsTicketDisplayBookings" value="on" <?php echo ( $WooCommerceEventsTicketDisplayBookings === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display Zoom meeting/webinar details on ticket?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Display all the Zoom meeting/webinar details such as the Meeting ID and Join link on the ticket.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsTicketDisplayZoom" value="on" <?php echo ( $WooCommerceEventsTicketDisplayZoom === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_multiday()) { ?>
                    <div class="options_group">
                        <p class="form-field">
                            <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Display multi-day details on ticket?', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Display multi-day details on the ticket.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsTicketDisplayMultiDay" value="on" <?php echo ( $WooCommerceEventsTicketDisplayMultiDay === 'on' ) ? 'CHECKED' : ''; ?>>
                        </p>
                    </div>
                <?php } ?>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Email ticket to attendee rather than purchaser?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This will email the ticket to the attendee instead of the ticket purchaser.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsEmailAttendee" value="on" <?php echo ( $WooCommerceEventsEmailAttendee === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <div class="options_group">
                    <p class="form-field">
                        <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Email tickets?', 'woocommerce-events'); ?></strong>
                            <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('This will email the event tickets to the attendee or purchaser once the order has been completed.', 'woocommerce-events'); ?>"></span>
                        </span>
                        <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsSendEmailTickets" value="on" <?php echo ( empty($WooCommerceEventsSendEmailTickets) || $WooCommerceEventsSendEmailTickets === 'on' ) ? 'CHECKED' : ''; ?>>
                    </p>
                </div>
                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_pdfticket()) { ?>
                    <div id="fooevents_pdf_ticket_settings" class="panel woocommerce_options_panel">
                        <div class="wcfm-clearfix"></div><br />
                        <h2><?php _e('PDF settings', 'woocommerce-events'); ?></h2>
                        <div class="wcfm-clearfix"></div>
                        <div class="options_group">
                            <p class="form-field">
                                <?php
                                $WCFM->wcfm_fields->wcfm_generate_form_field(
                                    [
                                        'FooEventsPDFTicketsEmailText' => [
                                            'label'       => esc_attr__('Email text:', 'fooevents-pdf-tickets'),
                                            'type'        => $wpeditor,
                                            'class'       => 'wcfm-textarea wcfm_ele wcfm_full_ele simple variable external grouped booking wcfm_custom_field_editor '.$rich_editor,
                                            'label_class' => 'wcfm_title wcfm_full_ele',
                                            'rows'        => 5,
                                            'value'       => $FooEventsPDFTicketsEmailText,
                                            'teeny'       => true,
                                        ],
                                    ]
                                );
                                ?>
                            </p>
                        </div>
                        <div class="options_group">
                            <p class="form-field">
                                <span clas="wcfm_title wcfm_full_ele"><strong><?php _e('Ticket footer text:', 'fooevents-pdf-tickets'); ?></strong></span>
                                <textarea class="wcfm-textarea wcfm_full_ele" name="FooEventsTicketFooterText" id="FooEventsTicketFooterText"><?php echo $FooEventsTicketFooterText; ?></textarea>
                            </p>
                        </div>
                    </div>
                    <?php
                }//end if
                ?>
                
                <div id="fooevents_terminology" class="panel woocommerce_options_panel">
                    <div class="options_group">
                        <p>
                            <h2><?php esc_attr_e('Event Terminology', 'woocommerce-events'); ?></h2
                            ><div class="wcfm-clearfix"></div>
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title"></span>
                            <span class="wcfm_title width30"><?php esc_attr_e('Singular', 'woocommerce-events'); ?></span>
                            <span class="wcfm_title width30"><?php esc_attr_e('Plural', 'woocommerce-events'); ?></span>
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Attendee:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Change 'Attendee' to your own custom text for this event.", 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="text" class="wcfm-text width30" id="WooCommerceEventsAttendeeOverride" name="WooCommerceEventsAttendeeOverride" value="<?php echo esc_attr($WooCommerceEventsAttendeeOverride); ?>"/>
                            <input type="text" class="wcfm-text width30" id="WooCommerceEventsAttendeeOverridePlural" name="WooCommerceEventsAttendeeOverridePlural" value="<?php echo esc_attr($WooCommerceEventsAttendeeOverridePlural); ?>"/>
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Book ticket:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Change 'Book ticket' to your own custom text for this event.", 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="text" class="wcfm-text width30" id="WooCommerceEventsTicketOverride" name="WooCommerceEventsTicketOverride" value="<?php echo esc_attr($WooCommerceEventsTicketOverride); ?>"/>
                            <input type="text" class="wcfm-text width30" id="WooCommerceEventsTicketOverridePlural" name="WooCommerceEventsTicketOverridePlural" value="<?php echo esc_attr($WooCommerceEventsTicketOverridePlural); ?>"/>
                        </p>
                        <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_multiday()) { ?>
                            <p class="form-field">
                                <span class="wcfm_title"><strong><?php esc_attr_e('Day:', 'fooevents-multiday-events'); ?></strong>
                                    <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Change 'Day' to your own custom text for this event.", 'woocommerce-events'); ?>"></span>
                                </span>
                                <input type="text" class="wcfm-text width30" id="WooCommerceEventsDayOverride" name="WooCommerceEventsDayOverride" value="<?php echo esc_attr($WooCommerceEventsDayOverride); ?>"/>
                                <input type="text" class="wcfm-text width30" id="WooCommerceEventsDayOverridePlural" name="WooCommerceEventsDayOverridePlural" value="<?php echo esc_attr($WooCommerceEventsDayOverridePlural); ?>"/>
                            </p>
                        <?php } ?>
                        <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_bookings()) { ?>
                            <p class="form-field">
                                <span class="wcfm_title"><strong><?php esc_attr_e('Slot:', 'fooevents-bookings'); ?></strong>
                                    <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Change 'Slot' to your own custom text for this event.", 'fooevents-bookings'); ?>"></span>
                                </span>
                                <input type="text" class="wcfm-text width30" id="WooCommerceEventsBookingsSlotOverride" name="WooCommerceEventsBookingsSlotOverride" value="<?php echo esc_attr($WooCommerceEventsBookingsSlotOverride); ?>"/>
                                <input type="text" class="wcfm-text width30" id="WooCommerceEventsBookingsSlotOverridePlural" name="WooCommerceEventsBookingsSlotOverridePlural" value="<?php echo esc_attr($WooCommerceEventsBookingsSlotOverridePlural); ?>"/>
                            </p>
                            <p class="form-field">
                                <span class="wcfm_title"><strong><?php esc_attr_e('Date:', 'fooevents-bookings'); ?></strong>
                                    <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Change 'Date' to your own custom text for this event.", 'fooevents-bookings'); ?>"></span>
                                </span>
                                <input type="text" class="wcfm-text width30" id="WooCommerceEventsBookingsDateOverride" name="WooCommerceEventsBookingsDateOverride" value="<?php echo esc_attr($WooCommerceEventsBookingsDateOverride); ?>"/>
                                <input type="text" class="wcfm-text width30" id="WooCommerceEventsBookingsDateOverridePlural" name="WooCommerceEventsBookingsDateOverridePlural" value="<?php echo esc_attr($WooCommerceEventsBookingsDateOverridePlural); ?>"/>
                            </p>
                            <p class="form-field">
                                <span class="wcfm_title"><strong><?php esc_attr_e('Booking details:', 'fooevents-bookings'); ?></strong>
                                    <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e("Change the 'Booking details' label to your own custom text for this event.", 'fooevents-bookings'); ?>"></span>
                                </span>
                                <input type="text" class="wcfm-text width30" id="WooCommerceEventsBookingsBookingDetailsOverride" name="WooCommerceEventsBookingsBookingDetailsOverride" value="<?php echo esc_attr($WooCommerceEventsBookingsBookingDetailsOverride); ?>"/>
                                <input type="text" class="wcfm-text width30" id="WooCommerceEventsBookingsBookingDetailsOverridePlural" name="WooCommerceEventsBookingsBookingDetailsOverridePlural" value="<?php echo esc_attr($WooCommerceEventsBookingsBookingDetailsOverridePlural); ?>"/>
                            </p>
                            <?php
                        }//end if
                        ?>
                    </div>
                </div>

                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_custom_atendee()) { ?>
                    <div class="fooevents_custom_attendee_fields_wrap">
                        <div class="wcfm-clearfix"></div><br />
                        <div class="options_group">
                            <h2><?php _e('Custom Attendee Fields', 'woocommerce-events'); ?></h2>
                            <div class="wcfm-clearfix"></div>
                            <table id="fooevents_custom_attendee_fields_options_table" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th><?php _e('Label', 'fooevents-custom-attendee-fields'); ?></th>
                                        <th><?php _e('Type', 'fooevents-custom-attendee-fields'); ?></th>
                                        <th><?php _e('Options', 'fooevents-custom-attendee-fields'); ?></th>
                                        <th><?php _e('Default', 'fooevents-custom-attendee-fields'); ?></th>
                                        <th><?php _e('Required', 'fooevents-custom-attendee-fields'); ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($fooevents_custom_attendee_fields_options as $option_key => $option) : ?>
                                        <?php $option_ids = array_keys($option); ?>
                                        <?php $option_values = array_values($option); ?>
    <?php
                                        $x = 0;
                                        $num_option_ids    = count($option_ids);
                                        $num_option_values = count($option_values);
                                        ?>
                                        <?php if ($num_option_ids == $num_option_values) : ?>
                                            <tr id="<?php echo $option_key; ?>">
                                                <td><input type="text" id="<?php echo $option_key; ?>_label" name="<?php echo $option_key; ?>_label" class="fooevents_custom_attendee_fields_label" value="<?php echo $option[$option_key.'_label']; ?>" autocomplete="off" maxlength="150"/></td>
                                                <td>
                                                    <select id="<?php echo $option_key; ?>_type" name="<?php echo $option_key; ?>_type" class="fooevents_custom_attendee_fields_type" autocomplete="off">
                                                        <option value="text" <?php echo ( $option[$option_key.'_type'] == 'text' ) ? 'SELECTED' : ''; ?>><?php echo __('Text', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="textarea" <?php echo ( $option[$option_key.'_type'] == 'textarea' ) ? 'SELECTED' : ''; ?>><?php echo __('Textarea', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="select" <?php echo ( $option[$option_key.'_type'] == 'select' ) ? 'SELECTED' : ''; ?>><?php echo __('Select', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="checkbox" <?php echo ( $option[$option_key.'_type'] == 'checkbox' ) ? 'SELECTED' : ''; ?>><?php echo __('Checkbox', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="radio" <?php echo ( $option[$option_key.'_type'] == 'radio' ) ? 'SELECTED' : ''; ?>><?php echo __('Radio', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="country" <?php echo ( $option[$option_key.'_type'] == 'country' ) ? 'SELECTED' : ''; ?>><?php echo __('Country', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="date" <?php echo ( $option[$option_key.'_type'] == 'date' ) ? 'SELECTED' : ''; ?>><?php echo __('Date', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="time" <?php echo ( $option[$option_key.'_type'] == 'time' ) ? 'SELECTED' : ''; ?>><?php echo __('Time', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="email" <?php echo ( $option[$option_key.'_type'] == 'email' ) ? 'SELECTED' : ''; ?>><?php echo __('Email', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="url" <?php echo ( $option[$option_key.'_type'] == 'url' ) ? 'SELECTED' : ''; ?>><?php echo __('URL', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="numbers" <?php echo ( $option[$option_key.'_type'] == 'numbers' ) ? 'SELECTED' : ''; ?>><?php echo __('Numbers', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="alphabet" <?php echo ( $option[$option_key.'_type'] == 'alphabet' ) ? 'SELECTED' : ''; ?>><?php echo __('Alphabet', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="alphanumeric" <?php echo ( $option[$option_key.'_type'] == 'alphanumeric' ) ? 'SELECTED' : ''; ?>><?php echo __('Alphanumeric', 'fooevents-custom-attendee-fields'); ?></option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input id="<?php echo $option_key; ?>_options" name="<?php echo $option_key; ?>_options" class="fooevents_custom_attendee_fields_options" type="text" value="<?php echo $option[$option_key.'_options']; ?>" <?php echo ( $option[$option_key.'_type'] == 'select' || $option[$option_key.'_type'] == 'radio' ) ? '' : 'disabled'; ?> autocomplete="off" />    
                                                </td>
                                                <td>
                                                <input id="<?php echo $option_key; ?>_def" name="<?php echo $option_key; ?>_def" class="fooevents_custom_attendee_fields_def" type="text" value="<?php echo ( ! empty($option[$option_key.'_def']) ) ? $option[$option_key.'_def'] : ''; ?>" <?php echo ( $option[$option_key.'_type'] == 'select' || $option[$option_key.'_type'] == 'radio' ) ? '' : 'disabled'; ?> autocomplete="off" />    
                                                </td>
                                                <td>
                                                    <select id="<?php echo $option_key; ?>_req" name="<?php echo $option_key; ?>_req" class="fooevents_custom_attendee_fields_req" autocomplete="off">
                                                        <option value="true" <?php echo ( $option[$option_key.'_req'] == 'true' ) ? 'SELECTED' : ''; ?>><?php echo __('Yes', 'fooevents-custom-attendee-fields'); ?></option>
                                                        <option value="false" <?php echo ( $option[$option_key.'_req'] == 'false' ) ? 'SELECTED' : ''; ?>><?php echo __('No', 'fooevents-custom-attendee-fields'); ?></option>
                                                    </select>
                                                </td>
                                                <td><a href="#" class="fooevents_custom_attendee_fields_remove" class="fooevents_custom_attendee_fields_remove">[X]</a></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>    
                        </div>
                    </div>
                    <div id="fooevents_custom_attendee_fields_info">
                            <p><a href="#" id="fooevents_custom_attendee_fields_new_field" class='button button-primary'>+ <?php echo __('New field', 'fooevents-custom-attendee-fields'); ?></a></p>
                            <p class="description"><?php _e("When using the 'Select' or 'Radio' options, seperate the options using a pipe symbol. Example: Small|Medium|Large.", 'fooevents-custom-attendee-fields'); ?></p>
                    </div>
                    <input type="hidden" id="fooevents_custom_attendee_fields_options_serialized" name="fooevents_custom_attendee_fields_options_serialized" value="<?php echo $fooevents_custom_attendee_fields_options_serialized; ?>" autocomplete="off" />
                    <?php
                }//end if
                ?>

                <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_seating()) { ?>
                    <div class="fooevents_seating_wrap">
                        <div class="wcfm-clearfix"></div><br />
                        <div class="options_group">
                            <h2><?php _e('Event Seating', 'fooevents-seating'); ?></h2>
                            <div class="wcfm-clearfix"></div>
                            <table id="fooevents_seating_options_table" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th><?php _e('Area Name (e.g. Row 1, Table 1, etc.)', 'woocommerce-events'); ?></th>
                                        <th><?php _e('Available Seats / Spaces', 'woocommerce-events'); ?></th>
                                        <th><?php _e('Variation', 'woocommerce-events'); ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($fooevents_seating_options as $option_key => $option) : ?>
                                        <?php $option_ids = array_keys($option); ?>
                                        <?php $option_values = array_values($option); ?>
    <?php
                                        $x = 0;
                                        $num_option_ids    = count($option_ids);
                                        $num_option_values = count($option_values);
                                        ?>
                                        <?php if ($num_option_ids == $num_option_values) : ?>
                                            <tr id="<?php echo $option_key; ?>">
                                                <td><input type="text" id="<?php echo $option_ids[0]; ?>" name="<?php echo $option_ids[0]; ?>" class="fooevents_seating_row_name" value="<?php echo $option_values[0]; ?>" autocomplete="off" maxlength="70"/></td>
                                                <td>
                                                    <input type="number" min="1" max="50" id="<?php echo $option_ids[1]; ?>" name="<?php echo $option_ids[1]; ?>" class="fooevents_seating_number_seats"  value="<?php echo $option_values[1]; ?>" >
                                                </td>
                                                <td>
                                                    <select id="<?php echo $option_ids[2]; ?>" name="<?php echo $option_ids[2]; ?>" class="fooevents_seating_variations">
                                                        <?php
                                                        echo '<option value="default"';
                                                        echo ( $option_values[2] == 'default' ) ? ' SELECTED' : '';
                                                        echo '>Default</option>';
                                                        $handle      = new WC_Product_Variable($product_id);
                                                        $variations1 = $handle->get_children();
                                                        foreach ($variations1 as $value) {
                                                            $single_variation = new WC_Product_Variation($value);
                                                            // if (!empty($single_variation->get_price())) {
                                                                echo '<option  value="'.$value.'"';
                                                                echo ( $option_values[2] == $value ) ? ' SELECTED' : '';
                                                                echo '>'.implode(' / ', $single_variation->get_variation_attributes()).' - '.get_woocommerce_currency_symbol().$single_variation->get_price().'</option>';
                                                            // }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td><a href="#" class="fooevents_seating_remove" class="fooevents_seating_remove">[X]</a></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>    
                        </div>
                    </div>
                             
                    <div id="fooevents_seating_dialog" title="Seating Chart"></div>
            
                    <div id="fooevents_seating_info">
                        <p><a href="#" id="fooevents_seating_new_field" class='button button-primary'>+ New row</a><a id="fooevents_seating_chart" class='button button-primary'>View seating chart</a></p>
                    </div>
                    <input type="hidden" id="fooevents_seating_options_serialized" name="fooevents_seating_options_serialized" value="<?php echo $fooevents_seating_options_serialized; ?>" autocomplete="off" />
                    <input type="hidden" id="fooevents_seats_unavailable_serialized" name="fooevents_seats_unavailable_serialized" value="<?php echo get_post_meta($product_id, 'fooevents_seats_unavailable_serialized', true); ?>" autocomplete="off" />
                    <div id="fooevents_variations" style="display:none">
                        <?php
                        $handle      = new WC_Product_Variable($product_id);
                        $variations1 = $handle->get_children();
                        echo '<option value="default">Default</option>';
                        foreach ($variations1 as $value) {
                            $single_variation = new WC_Product_Variation($value);
                            // if (!empty($single_variation->get_price())) {
                                echo '<option  value="'.$value.'">'.implode(' / ', $single_variation->get_variation_attributes()).' - '.get_woocommerce_currency_symbol().$single_variation->get_price().'</option>';
                            // }
                        }
                        ?>
                    </div>
                    <?php
                }//end if
                ?>

                <?php if (! empty($product_id)) : ?>
                    <p><h2><?php esc_attr_e('Event Export', 'woocommerce-events'); ?></h2><div class="wcfm-clearfix"></div></p>
                    <div class="options_group">
                        <p><h2><?php esc_attr_e('Export attendees', 'woocommerce-events'); ?></h2><div class="wcfm-clearfix"></div></p>
                        <div id="WooCommerceEventsExportMessage"></div>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Include unpaid tickets:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Include unpaid tickets in exported file.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="checkbox" class="wcfm-checkbox" id="WooCommerceEventsExportUnpaidTickets" name="WooCommerceEventsExportUnpaidTickets" value="on" <?php echo ( $WooCommerceEventsExportUnpaidTickets === 'on' ) ? 'CHECKED' : ''; ?>><br />
                            <span class="wcfm_title"><strong><?php esc_attr_e('Include billing details:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Include billing details in exported file.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="checkbox" class="wcfm-checkbox" id="WooCommerceEventsExportBillingDetails" name="WooCommerceEventsExportBillingDetails" value="on" <?php echo ( $WooCommerceEventsExportBillingDetails === 'on' ) ? 'CHECKED' : ''; ?>><br /><br />
                            <a href="<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=woocommerce_events_csv&event=<?php echo $product_id; ?><?php echo ( $WooCommerceEventsExportUnpaidTickets === 'on' ) ? '&exportunpaidtickets=true' : ''; ?><?php echo ( $WooCommerceEventsExportBillingDetails === 'on' ) ? '&exportbillingdetails=true' : ''; ?>" class="button wcfm_submit_button" target="_BLANK"><?php _e('Download CSV of attendees', 'woocommerce-events'); ?></a>
                            <div class="wcfm-clearfix"></div>
                        </p>
                    </div>

                    <!-- Stationery Builder -->
                    <div class="options_group">
                        <p><h2><?php esc_attr_e('Stationery Builder', 'woocommerce-events'); ?></h2><div class="wcfm-clearfix"></div></p>
                        <div id="WooCommercePrintTicketMessage"></div>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Format:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('The number of items to print per sheet as well as the page format.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <select name="WooCommercePrintTicketSize" id="WooCommercePrintTicketSize" class="wcfm-select">
                                <optgroup label="Tickets">
                                    <option value="tickets_avery_letter_10"<?php echo ( 'tickets_avery_letter_10' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('10 tickets per sheet (Letter size)', 'woocommerce-events'); ?></option>
                                    <option value="tickets_letter_10"<?php echo ( 'tickets_letter_10' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('10 tickets per sheet 5.5in x 1.75in (Avery 16154 Tickets Letter size)', 'woocommerce-events'); ?></option>
                                    <option value="tickets_a4_10"<?php echo ( 'tickets_a4_10' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('10 tickets per sheet (A4 size)', 'woocommerce-events'); ?></option>
                                    <option value="tickets_a4_3"<?php echo ( 'tickets_a4_3' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('3 tickets per sheet (A4 size)', 'woocommerce-events'); ?></option>
                                </optgroup>
                                <br />
                                <optgroup label="Badges">
                                    <option value="letter_6"<?php echo ( 'letter_6' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('6 badges per sheet 4in x 3in (Avery 5392/5393 Letter size)', 'woocommerce-events'); ?></option>
                                    <option value="letter_10"<?php echo ( 'letter_10' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('10 badges per sheet 4.025in x 2in (Avery 5163/8163 Letter size)', 'woocommerce-events'); ?></option>
                                    <option value="a4_12" <?php echo ( 'a4_12' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('12 badges per sheet 63.5mm x 72mm (Microsoft W233 A4 size)', 'woocommerce-events'); ?></option>
                                    <option value="a4_16" <?php echo ( 'a4_16' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('16 badges per sheet 99mm x 33.9mm (Microsoft W121 A4 size)', 'woocommerce-events'); ?></option>
                                    <option value="a4_24" <?php echo ( 'a4_24' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('24 badges per sheet 35mm x 70mm (Microsoft W110 A4 size)', 'woocommerce-events'); ?></option>
                                    <option value="letter_30" <?php echo ( 'letter_30' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('30 badges per sheet 2.625in x 1in (Avery 5160/8160 Letter size)', 'woocommerce-events'); ?></option>
                                    <option value="a4_39" <?php echo ( 'a4_39' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('39 badges per sheet 66mm x 20.60mm (Microsoft W239 A4 size)', 'woocommerce-events'); ?></option>
                                    <option value="a4_45" <?php echo ( 'a4_45' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('45 badges per sheet 38.5mm x 29.9mm (Microsoft W115 A4 size)', 'woocommerce-events'); ?></option>
                                </optgroup>
                                <optgroup label="Wraparound Labels/Wristbands">
                                    <option value="letter_labels_5"<?php echo ( 'letter_labels_5' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('5 labels per sheet 9-3/4" x 1-1/4" (Avery 22845 Letter size)', 'woocommerce-events'); ?></option>
                                    <option value="letter_labels_1"<?php echo ( 'letter_labels_1' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('1 Z-band Fun/Splash wristband per sheet 10" x 1" for Zebra ZD510-HC printer', 'woocommerce-events'); ?></option>
                                </optgroup>
                                <optgroup label="Certificates">
                                    <option value="letter_certificate_portrait_1"<?php echo ( 'letter_certificate_portrait_1' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('1 certificate per sheet (Letter size/Portrait)', 'woocommerce-events'); ?></option>
                                    <option value="letter_certificate_landscape_1"<?php echo ( 'letter_certificate_landscape_1' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('1 certificate per sheet (Letter size/Landscape)', 'woocommerce-events'); ?></option>
                                    <option value="a4_certificate_portrait_1"<?php echo ( 'a4_certificate_portrait_1' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('1 certificate per sheet (A4 size/Portrait)', 'woocommerce-events'); ?></option>
                                    <option value="a4_certificate_landscape_1"<?php echo ( 'a4_certificate_landscape_1' === $woocommerce_print_ticket_size ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('1 certificate per sheet (A4 size/Landscape)', 'woocommerce-events'); ?></option>
                                </optgroup>
                            </select>
                        </p>
                        <p class="form-field">     
                            <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Include cut lines?', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Display ticket cut lines on page.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsCutLinesPrintTicket" value="on" <?php echo ( empty($WooCommerceEventsCutLinesPrintTicket) || $WooCommerceEventsCutLinesPrintTicket === 'on' ) ? ' checked="checked"' : ''; ?>>
                        </p>
                        <p class="form-field">
                            <?php
                            $WCFM->wcfm_fields->wcfm_generate_form_field(
                                [
                                    'WooCommerceEventsTicketBackgroundImage' => [
                                        'label'                => esc_attr__('Background image', 'woocommerce-events'),
                                        'wcfm_uploader_by_url' => true,
                                        'type'                 => 'upload',
                                        'label_class'          => 'wcfm_title',
                                        'value'                => $WooCommerceEventsTicketBackgroundImage,
                                        'hints'                => esc_attr__('Background image that will be displayed on each ticket, label or certificate page', 'woocommerce-events'),
                                    ],
                                ]
                            );
                            ?>
                        </p>
                    </div>
                    <div class="options_group">
                        <p class="form-field">
                            <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Include all attendees', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Include all the attendees for this event in the selected stationery.', 'woocommerce-events'); ?>"></span>
                            </span>          
                            <input type="checkbox" class="wcfm-checkbox" name="WooCommerceEventsPrintAllTickets" id="WooCommerceEventsPrintAllTickets">
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Specific ticket number(s):', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Enter the ticket number(s) that will be used to populate the selected stationery, separated by commas (,). If both the ticket number and order number fields are empty, then all the attendees for this event will be included.', 'woocommerce-events'); ?>"></span>
                            </span> 
                            <input type="text" class="wcfm-text" style="" name="WooCommercePrintTicketNumbers" id="WooCommercePrintTicketNumbers" value="<?php echo esc_attr($woocommerce_print_ticket_numbers); ?>">
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Specific order number(s):', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Enter the order number(s) that will be used to populate the selected stationery, separated by commas (,). If both the ticket number and order number fields are empty, then all the attendees for this event will be included.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="text" class="wcfm-text" style="" name="WooCommercePrintTicketOrders" id="WooCommercePrintTicketOrders" value="<?php echo esc_attr($woocommerce_print_ticket_orders); ?>">
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title checkbox_title"><strong><?php esc_attr_e('Sort order:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Choose the sort order for how the selected stationery will be arranged when printed.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <select class="wcfm-select" name="WooCommercePrintTicketSort" id="WooCommercePrintTicketSort">
                                <option value="most_recent"<?php echo ( 'most_recent' === $woocommerce_print_ticket_sort ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Most recent tickets first', 'woocommerce-events'); ?></option>
                                <option value="oldest"<?php echo ( 'oldest' === $woocommerce_print_ticket_sort ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Oldest tickets first', 'woocommerce-events'); ?></option>
                                <option value="a_z1"<?php echo ( 'a_z1' === $woocommerce_print_ticket_sort ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Alphabetical by Attendee First Name', 'woocommerce-events'); ?></option>
                                <option value="a_z2"<?php echo ( 'a_z2' === $woocommerce_print_ticket_sort ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Alphabetical by Attendee Last Name', 'woocommerce-events'); ?></option>
                            </select>
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Number of columns:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('The number of rows to display in the stationery layout area. The recommended number of rows will be set by default but this can be adjusted manually.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input class="wcfm-text width10" type="number" min="1" max="3" id="WooCommercePrintTicketNrColumns" name="WooCommercePrintTicketNrColumns" value="<?php echo ( empty($woocommerce_print_ticket_nr_columns) ) ? '3' : esc_attr($woocommerce_print_ticket_nr_columns); ?>" >
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Number of rows:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('The number of columns to display in the stationery layout area. The recommended number of columns will be set by default but this can be adjusted manually.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input class="wcfm-text width10" type="number" min="1" max="3" id="WooCommercePrintTicketNrRows" name="WooCommercePrintTicketNrRows" value="<?php echo ( empty($woocommerce_print_ticket_nr_rows) ) ? '3' : esc_attr($woocommerce_print_ticket_nr_rows); ?>" >
                        </p>
                    </div>

                    <?php if (! empty($product_id)) { ?>
                        <button type="button" class="button" id="fooevents-add-printing-widgets"><?php esc_attr_e('+ Expand Fields', 'woocommerce-events'); ?></button>
                        <div id="fooevents_printing_widgets">
                            <h3>General Fields</h3>
                            <div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="1">
                                    <span data-name="logo"><?php esc_attr_e('Logo/Image', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <input id="WooCommerceEventsPrintTicketLogo" class="text uploadfield" type="text" size="40" name="WooCommerceEventsPrintTicketLogo" value="" />                
                                        <span class="uploadbox">
                                            <input class="upload_image_button_woocommerce_events button" type="button" value="Upload file" />
                                            <img class="help_tip" data-tip="<?php esc_attr_e('Select the logo or other image that you would like to display in tickets.', 'woocommerce-events'); ?>" src="<?php echo esc_attr(plugins_url()); ?>/woocommerce/assets/images/help.png" height="16" width="16" />
                                            <div class="clearfix"></div>
                                        </span>
                                        <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="2">
                                    <span data-name="custom"><?php esc_attr_e('Custom Text', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>    
                                    <div class="fooevents_printing_widget_options">
                                        <textarea name="WooCommerceEventsPrintTicketCustom" id="WooCommerceEventsPrintTicketCustom"></textarea>
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>  
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="3">
                                    <span data-name="spacer"><?php esc_attr_e('Empty Spacer', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <h3>Event Fields</h3>
                            <div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="4">
                                    <span data-name="event"><?php esc_attr_e('Event Name Only', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>   
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="5">
                                    <span data-name="event_var"><?php esc_attr_e('Event Name/Variation', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>  
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="6">
                                    <span data-name="var_only"><?php esc_attr_e('Variation Only', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a> 
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="7">
                                    <span data-name="location"><?php esc_attr_e('Event Location', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>  
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <h3>Ticket Fields</h3>
                            <div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="8">
                                    <span data-name="barcode"><?php esc_attr_e('Barcode', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="9">
                                    <span data-name="ticketnr"><?php esc_attr_e('Ticket Number', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a> 
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <h3>Attendee Fields</h3>
                            <div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="10">
                                    <span data-name="name"><?php esc_attr_e('Attendee Name', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="11">
                                    <span data-name="email"><?php esc_attr_e('Attendee Email', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="12">
                                    <span data-name="phone"><?php esc_attr_e('Attendee Phone', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a> 
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="13">
                                    <span data-name="company"><?php esc_attr_e('Attendee Company', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="14">
                                    <span data-name="designation"><?php esc_attr_e('Attendee Designation', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="15">
                                    <span data-name="seat"><?php esc_attr_e('Attendee Seat', 'woocommerce-events'); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>  
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <h3>Custom Attendee Fields</h3>
                            <div>
                                <?php
                                $i = 16;
                                foreach ($cf_array as $key => $value) :
                                    ?>
                                    <div class="fooevents_printing_widget fooevents_printing_widget_init" data-order="<?php echo esc_attr($i); ?>">
                                    <span data-name="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?><span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span></span>
                                    <div class="fooevents_printing_widget_options">
                                        <select class="fooevents_printing_ticket_select">
                                            <option value="small"><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                            <option value="small_uppercase"><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="medium"><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                            <option value="medium_uppercase"><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                            <option value="large"><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                            <option value="large_uppercase"><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                        </select>
                                        <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>  
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                    <?php
                                    $i++;
                                endforeach;
                                ?>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <br /><br />
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Stationery layout:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Drag the desired fields from above into the layout blocks below.', 'woocommerce-events'); ?>"></span>
                            </span>
                        </p>
                        <table id="fooevents_printing_layout_block" cellpadding="0" cellspacing="0" align="center">
                            <tr>
                                <td class="fooevents_printing_slot" id="TopLeft">
                                    <?php if (! empty($woocommerce_badge_field_top_left)) : ?>
                                        <div class="fooevents_printing_widget">
                                            <span data-name="<?php echo esc_attr($woocommerce_badge_field_top_left); ?>">
                                                <?php echo esc_attr($fooevent_WooHelper->widget_label($woocommerce_badge_field_top_left, $cf_array)); ?>
                                                <span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span>
                                            </span>
                                            <div class="fooevents_printing_widget_options">
                                                <?php if ('barcode' !== $woocommerce_badge_field_top_left && 'logo' !== $woocommerce_badge_field_top_left && 'spacer' !== $woocommerce_badge_field_top_left) : ?>
                                                    <?php if ('custom' === $woocommerce_badge_field_top_left) : ?>
                                                        <textarea name="WooCommerceBadgeFieldTopLeft_custom" id="WooCommerceBadgeFieldTopLeft_custom"><?php echo esc_attr($woocommerce_badge_field_top_left_custom); ?></textarea>
                                                    <?php endif; ?>
                                                <select class="fooevents_printing_ticket_select" name="WooCommerceBadgeFieldTopLeft_font" id="WooCommerceBadgeFieldTopLeft_font">
                                                    <option value="small" <?php echo ( 'small' === $woocommerce_badge_field_top_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                                    <option value="small_uppercase" <?php echo ( 'small_uppercase' === $woocommerce_badge_field_top_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="medium" <?php echo ( 'medium' === $woocommerce_badge_field_top_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                                    <option value="medium_uppercase" <?php echo ( 'medium_uppercase' === $woocommerce_badge_field_top_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="large" <?php echo ( 'large' === $woocommerce_badge_field_top_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                                    <option value="large_uppercase" <?php echo ( 'large_uppercase' === $woocommerce_badge_field_top_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                                </select>
                                                <?php endif; ?>
                                                <?php if ('logo' === $woocommerce_badge_field_top_left) : ?>
                                                    <?php $woocommerce_badge_field_top_left_logo = ( empty($woocommerce_badge_field_top_left_logo) ) ? $globalWooCommerceEventsTicketLogo : $woocommerce_badge_field_top_left_logo; ?>           
                                                <input id="WooCommerceBadgeFieldTopLeft_logo" class="text uploadfield" type="text" size="40" name="WooCommerceBadgeFieldTopLeft_logo" value="<?php echo esc_attr($woocommerce_badge_field_top_left_logo); ?>" />                
                                                <span class="uploadbox">
                                                    <input class="upload_image_button_woocommerce_events button" type="button" value="Choose file" />
                                                    <div class="clearfix"></div>
                                                </span>
                                                <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fooevents_printing_slot hide_col_1" id="TopMiddle">
                                    <?php if (! empty($woocommerce_badge_field_top_middle)) : ?>
                                        <div class="fooevents_printing_widget">
                                            <span data-name="<?php echo esc_attr($woocommerce_badge_field_top_middle); ?>">
                                                <?php echo esc_attr($fooevent_WooHelper->widget_label($woocommerce_badge_field_top_middle, $cf_array)); ?>
                                                <span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span>
                                            </span>
                                            <div class="fooevents_printing_widget_options">
                                                <?php if ('barcode' !== $woocommerce_badge_field_top_middle && 'logo' !== $woocommerce_badge_field_top_middle && 'spacer' !== $woocommerce_badge_field_top_middle) : ?>
                                                    <?php if ('custom' === $woocommerce_badge_field_top_middle) : ?>
                                                        <textarea name="WooCommerceBadgeFieldTopMiddle_custom" id="WooCommerceBadgeFieldTopMiddle_custom"><?php echo esc_attr($woocommerce_badge_field_top_middle_custom); ?></textarea>
                                                    <?php endif; ?>
                                                <select class="fooevents_printing_ticket_select" name="WooCommerceBadgeFieldTopMiddle_font" id="WooCommerceBadgeFieldTopMiddle_font">
                                                    <option value="small" <?php echo ( 'small' === $woocommerce_badge_field_top_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                                    <option value="small_uppercase" <?php echo ( 'small_uppercase' === $woocommerce_badge_field_top_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="medium" <?php echo ( 'medium' === $woocommerce_badge_field_top_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                                    <option value="medium_uppercase" <?php echo ( 'medium_uppercase' === $woocommerce_badge_field_top_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="large" <?php echo ( 'large' === $woocommerce_badge_field_top_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                                    <option value="large_uppercase" <?php echo ( 'large_uppercase' === $woocommerce_badge_field_top_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                                </select>
                                                <?php endif; ?>
                                                <?php if ('logo' === $woocommerce_badge_field_top_middle) : ?>
                                                    <?php $woocommerce_badge_field_top_middle_logo = ( empty($woocommerce_badge_field_top_middle_logo) ) ? $globalWooCommerceEventsTicketLogo : $woocommerce_badge_field_top_middle_logo; ?>           
                                                <input id="WooCommerceBadgeFieldTopMiddle_logo" class="text uploadfield" type="text" size="40" name="WooCommerceBadgeFieldTopMiddle_logo" value="<?php echo esc_attr($woocommerce_badge_field_top_middle_logo); ?>" />                
                                                <span class="uploadbox">
                                                    <input class="upload_image_button_woocommerce_events button" type="button" value="Choose file" />
                                                    <div class="clearfix"></div>
                                                </span>
                                                <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                                <div class="clearfix"></div>
                                            </div>     
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fooevents_printing_slot hide_col_1 hide_col_2" id="TopRight">
                                    <?php if (! empty($woocommerce_badge_field_top_right)) : ?>
                                        <div class="fooevents_printing_widget">
                                            <span data-name="<?php echo esc_attr($woocommerce_badge_field_top_right); ?>">
                                                <?php echo esc_attr($fooevent_WooHelper->widget_label($woocommerce_badge_field_top_right, $cf_array)); ?>
                                                <span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span>
                                            </span>
                                            <div class="fooevents_printing_widget_options">
                                                <?php if ('barcode' !== $woocommerce_badge_field_top_right && 'logo' !== $woocommerce_badge_field_top_right && 'spacer' !== $woocommerce_badge_field_top_right) : ?>
                                                    <?php if ('custom' === $woocommerce_badge_field_top_right) : ?>
                                                        <textarea name="WooCommerceBadgeFieldTopRight_custom" id="WooCommerceBadgeFieldTopRight_custom"><?php echo esc_attr($woocommerce_badge_field_top_right_custom); ?></textarea>
                                                    <?php endif; ?>
                                                <select class="fooevents_printing_ticket_select" name="WooCommerceBadgeFieldTopRight_font" id="WooCommerceBadgeFieldTopRight_font">
                                                    <option value="small" <?php echo ( 'small' === $woocommerce_badge_field_top_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                                    <option value="small_uppercase" <?php echo ( 'small_uppercase' === $woocommerce_badge_field_top_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="medium" <?php echo ( 'medium' === $woocommerce_badge_field_top_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                                    <option value="medium_uppercase" <?php echo ( 'medium_uppercase' === $woocommerce_badge_field_top_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="large" <?php echo ( 'large' === $woocommerce_badge_field_top_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                                    <option value="large_uppercase" <?php echo ( 'large_uppercase' === $woocommerce_badge_field_top_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                                </select>
                                                <?php endif; ?>
                                                <?php if ('logo' === $woocommerce_badge_field_top_right) : ?>
                                                    <?php $woocommerce_badge_field_top_right_logo = ( empty($woocommerce_badge_field_top_right_logo) ) ? $globalWooCommerceEventsTicketLogo : $woocommerce_badge_field_top_right_logo; ?>           
                                                <input id="WooCommerceBadgeFieldTopRight_logo" class="text uploadfield" type="text" size="40" name="WooCommerceBadgeFieldTopRight_logo" value="<?php echo esc_attr($woocommerce_badge_field_top_right_logo); ?>" />                
                                                <span class="uploadbox">
                                                    <input class="upload_image_button_woocommerce_events button" type="button" value="Choose file" />
                                                    <div class="clearfix"></div>
                                                </span>
                                                <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="fooevents_printing_slot hide_row_1" id="MiddleLeft">
                                    <?php if (! empty($woocommerce_badge_field_middle_left)) : ?>
                                        <div class="fooevents_printing_widget">
                                            <span data-name="<?php echo esc_attr($woocommerce_badge_field_middle_left); ?>">
                                                <?php echo esc_attr($fooevent_WooHelper->widget_label($woocommerce_badge_field_middle_left, $cf_array)); ?>
                                                <span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span>
                                            </span>
                                            <div class="fooevents_printing_widget_options">
                                                <?php if ('barcode' !== $woocommerce_badge_field_middle_left && 'logo' !== $woocommerce_badge_field_middle_left && 'spacer' !== $woocommerce_badge_field_middle_left) : ?>
                                                    <?php if ('custom' === $woocommerce_badge_field_middle_left) : ?>
                                                        <textarea name="WooCommerceBadgeFieldMiddleLeft_custom" id="WooCommerceBadgeFieldMiddleLeft_custom"><?php echo esc_attr($woocommerce_badge_field_middle_left_custom); ?></textarea>
                                                    <?php endif; ?>
                                                <select class="fooevents_printing_ticket_select" name="WooCommerceBadgeFieldMiddleLeft_font" id="WooCommerceBadgeFieldMiddleLeft_font">
                                                    <option value="small" <?php echo ( 'small' === $woocommerce_badge_field_middle_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                                    <option value="small_uppercase" <?php echo ( 'small_uppercase' === $woocommerce_badge_field_middle_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="medium" <?php echo ( 'medium' === $woocommerce_badge_field_middle_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                                    <option value="medium_uppercase" <?php echo ( 'medium_uppercase' === $woocommerce_badge_field_middle_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="large" <?php echo ( 'large' === $woocommerce_badge_field_middle_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                                    <option value="large_uppercase" <?php echo ( 'large_uppercase' === $woocommerce_badge_field_middle_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                                </select>
                                                <?php endif; ?>
                                                <?php if ('logo' === $woocommerce_badge_field_middle_left) : ?>
                                                    <?php $woocommerce_badge_field_middle_left_logo = ( empty($woocommerce_badge_field_middle_left_logo) ) ? $globalWooCommerceEventsTicketLogo : $woocommerce_badge_field_middle_left_logo; ?>           
                                                <input id="WooCommerceBadgeFieldMiddleLeft_logo" class="text uploadfield" type="text" size="40" name="WooCommerceBadgeFieldMiddleLeft_logo" value="<?php echo esc_attr($woocommerce_badge_field_middle_left_logo); ?>" />                
                                                <span class="uploadbox">
                                                    <input class="upload_image_button_woocommerce_events button" type="button" value="Choose file" />
                                                    <div class="clearfix"></div>
                                                </span>
                                                <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fooevents_printing_slot hide_row_1 hide_col_1" id="MiddleMiddle">
                                    <?php if (! empty($woocommerce_badge_field_middle_middle)) : ?>
                                        <div class="fooevents_printing_widget">
                                            <span data-name="<?php echo esc_attr($woocommerce_badge_field_middle_middle); ?>">
                                                <?php echo esc_attr($fooevent_WooHelper->widget_label($woocommerce_badge_field_middle_middle, $cf_array)); ?>
                                                <span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span>
                                            </span>
                                            <div class="fooevents_printing_widget_options">
                                                <?php if ('barcode' !== $woocommerce_badge_field_middle_middle && 'logo' !== $woocommerce_badge_field_middle_middle && 'spacer' !== $woocommerce_badge_field_middle_middle) : ?>
                                                    <?php if ('custom' === $woocommerce_badge_field_middle_middle) : ?>
                                                        <textarea name="WooCommerceBadgeFieldMiddleMiddle_custom" id="WooCommerceBadgeFieldMiddleMiddle_custom"><?php echo esc_attr($woocommerce_badge_field_middle_middle_custom); ?></textarea>
                                                    <?php endif; ?>
                                                    <select class="fooevents_printing_ticket_select" name="WooCommerceBadgeFieldMiddleMiddle_font" id="WooCommerceBadgeFieldMiddleMiddle_font">
                                                        <option value="small" <?php echo ( 'small' === $woocommerce_badge_field_middle_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                                        <option value="small_uppercase" <?php echo ( 'small_uppercase' === $woocommerce_badge_field_middle_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                                        <option value="medium" <?php echo ( 'medium' === $woocommerce_badge_field_middle_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                                        <option value="medium_uppercase" <?php echo ( 'medium_uppercase' === $woocommerce_badge_field_middle_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                                        <option value="large" <?php echo ( 'large' === $woocommerce_badge_field_middle_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                                        <option value="large_uppercase" <?php echo ( 'large_uppercase' === $woocommerce_badge_field_middle_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                                    </select>
                                                <?php endif; ?>
                                                <?php if ('logo' === $woocommerce_badge_field_middle_middle) : ?>
                                                    <?php $woocommerce_badge_field_middle_middle_logo = ( empty($woocommerce_badge_field_middle_middle_logo) ) ? $globalWooCommerceEventsTicketLogo : $woocommerce_badge_field_middle_middle_logo; ?>           
                                                <input id="WooCommerceBadgeFieldMiddleMiddle_logo" class="text uploadfield" type="text" size="40" name="WooCommerceBadgeFieldMiddleMiddle_logo" value="<?php echo esc_attr($woocommerce_badge_field_middle_middle_logo); ?>" />                
                                                <span class="uploadbox">
                                                    <input class="upload_image_button_woocommerce_events button" type="button" value="Choose file" />
                                                    <div class="clearfix"></div>
                                                </span>
                                                <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fooevents_printing_slot hide_row_1 hide_col_1 hide_col_2" id="MiddleRight">
                                    <?php if (! empty($woocommerce_badge_field_middle_right)) : ?>
                                        <div class="fooevents_printing_widget">
                                            <span data-name="<?php echo esc_attr($woocommerce_badge_field_middle_right); ?>">
                                                <?php echo esc_attr($fooevent_WooHelper->widget_label($woocommerce_badge_field_middle_right, $cf_array)); ?>
                                                <span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span>
                                            </span>
                                            <div class="fooevents_printing_widget_options">
                                                <?php if ('barcode' !== $woocommerce_badge_field_middle_right && 'logo' !== $woocommerce_badge_field_middle_right && 'spacer' !== $woocommerce_badge_field_middle_right) : ?>
                                                    <?php if ('custom' === $woocommerce_badge_field_middle_right) : ?>
                                                        <textarea name="WooCommerceBadgeFieldMiddleRight_custom" id="WooCommerceBadgeFieldMiddleRight_custom"><?php echo esc_attr($woocommerce_badge_field_middle_right_custo); ?></textarea>
                                                    <?php endif; ?>
                                                <select class="fooevents_printing_ticket_select" name="WooCommerceBadgeFieldMiddleRight_font" id="WooCommerceBadgeFieldMiddleRight_font">
                                                    <option value="small" <?php echo ( 'small' === $woocommerce_badge_field_middle_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                                    <option value="small_uppercase" <?php echo ( 'small_uppercase' === $woocommerce_badge_field_middle_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="medium" <?php echo ( 'medium' === $woocommerce_badge_field_middle_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                                    <option value="medium_uppercase" <?php echo ( 'medium_uppercase' === $woocommerce_badge_field_middle_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="large" <?php echo ( 'large' === $woocommerce_badge_field_middle_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                                    <option value="large_uppercase" <?php echo ( 'large_uppercase' === $woocommerce_badge_field_middle_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                                </select>
                                                <?php endif; ?>
                                                <?php if ('logo' === $woocommerce_badge_field_middle_right) : ?>
                                                    <?php $woocommerce_badge_field_middle_right_logo = ( empty($woocommerce_badge_field_middle_right_logo) ) ? $globalWooCommerceEventsTicketLogo : $woocommerce_badge_field_middle_right_logo; ?>           
                                                <input id="WooCommerceBadgeFieldMiddleRight_logo" class="text uploadfield" type="text" size="40" name="WooCommerceBadgeFieldMiddleRight_logo" value="<?php echo esc_attr($woocommerce_badge_field_middle_right_logo); ?>" />                
                                                <span class="uploadbox">
                                                    <input class="upload_image_button_woocommerce_events button" type="button" value="Choose file" />
                                                    <div class="clearfix"></div>
                                                </span>
                                                <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                                <div class="clearfix"></div>
                                            </div>    
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>    
                                <td class="fooevents_printing_slot hide_row_1 hide_row_2" id="BottomLeft">
                                    <?php if (! empty($woocommerce_badge_field_bottom_left)) : ?>
                                        <div class="fooevents_printing_widget">
                                            <span data-name="<?php echo esc_attr($woocommerce_badge_field_bottom_left); ?>">
                                                <?php echo esc_attr($fooevent_WooHelper->widget_label($woocommerce_badge_field_bottom_left, $cf_array)); ?>
                                                <span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span>
                                            </span>
                                            <div class="fooevents_printing_widget_options">
                                                <?php if ('barcode' !== $woocommerce_badge_field_bottom_left && 'logo' !== $woocommerce_badge_field_bottom_left && 'spacer' !== $woocommerce_badge_field_bottom_left) : ?>
                                                    <?php if ('custom' === $woocommerce_badge_field_bottom_left) : ?>
                                                        <textarea name="WooCommerceBadgeFieldBottomLeft_custom" id="WooCommerceBadgeFieldBottomLeft_custom"><?php echo esc_attr($woocommerce_badge_field_bottom_left_custom); ?></textarea>
                                                    <?php endif; ?>
                                                    <select class="fooevents_printing_ticket_select" name="WooCommerceBadgeFieldBottomLeft_font" id="WooCommerceBadgeFieldBottomLeft_font">
                                                        <option value="small" <?php echo ( 'small' === $woocommerce_badge_field_bottom_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                                        <option value="small_uppercase" <?php echo ( 'small_uppercase' === $woocommerce_badge_field_bottom_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                                        <option value="medium" <?php echo ( 'medium' === $woocommerce_badge_field_bottom_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                                        <option value="medium_uppercase" <?php echo ( 'medium_uppercase' === $woocommerce_badge_field_bottom_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                                        <option value="large" <?php echo ( 'large' === $woocommerce_badge_field_bottom_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                                        <option value="large_uppercase" <?php echo ( 'large_uppercase' === $woocommerce_badge_field_bottom_left_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                                    </select>
                                                <?php endif; ?>
                                                <?php if ('logo' === $woocommerce_badge_field_bottom_left) : ?>
                                                    <?php $woocommerce_badge_field_bottom_left_logo = ( empty($woocommerce_badge_field_bottom_left_logo) ) ? $globalWooCommerceEventsTicketLogo : $woocommerce_badge_field_bottom_left_logo; ?>           
                                                <input id="WooCommerceBadgeFieldBottomLeft_logo" class="text uploadfield" type="text" size="40" name="WooCommerceBadgeFieldBottomLeft_logo" value="<?php echo esc_attr($woocommerce_badge_field_bottom_left_logo); ?>" />                
                                                <span class="uploadbox">
                                                    <input class="upload_image_button_woocommerce_events button" type="button" value="Choose file" />
                                                    <div class="clearfix"></div>
                                                </span>
                                                <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                                <div class="clearfix"></div>
                                            </div> 
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fooevents_printing_slot hide_row_1 hide_row_2 hide_col_1" id="BottomMiddle">
                                    <?php if (! empty($woocommerce_badge_field_bottom_middle)) : ?>
                                        <div class="fooevents_printing_widget">
                                            <span data-name="<?php echo esc_attr($woocommerce_badge_field_bottom_middle); ?>">
                                                <?php echo esc_attr($fooevent_WooHelper->widget_label($woocommerce_badge_field_bottom_middle, $cf_array)); ?>
                                                <span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span>
                                            </span>
                                            <div class="fooevents_printing_widget_options">
                                                <?php if ('barcode' !== $woocommerce_badge_field_bottom_middle && 'logo' !== $woocommerce_badge_field_bottom_middle && 'spacer' !== $woocommerce_badge_field_bottom_middle) : ?>
                                                    <?php if ('custom' === $woocommerce_badge_field_bottom_middle) : ?>
                                                        <textarea name="WooCommerceBadgeFieldBottomMiddle_custom" id="WooCommerceBadgeFieldBottomMiddle_custom"><?php echo esc_attr($woocommerce_badge_field_bottom_middle_custom); ?></textarea>
                                                    <?php endif; ?>
                                                <select class="fooevents_printing_ticket_select" name="WooCommerceBadgeFieldBottomMiddle_font" id="WooCommerceBadgeFieldBottomMiddle_font">
                                                    <option value="small" <?php echo ( 'small' === $woocommerce_badge_field_bottom_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                                    <option value="small_uppercase" <?php echo ( 'small_uppercase' === $woocommerce_badge_field_bottom_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="medium" <?php echo ( 'medium' === $woocommerce_badge_field_bottom_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                                    <option value="medium_uppercase" <?php echo ( 'medium_uppercase' === $woocommerce_badge_field_bottom_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="large" <?php echo ( 'large' === $woocommerce_badge_field_bottom_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                                    <option value="large_uppercase" <?php echo ( 'large_uppercase' === $woocommerce_badge_field_bottom_middle_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                                </select>
                                                <?php endif; ?>
                                                <?php if ('logo' === $woocommerce_badge_field_bottom_middle) : ?>
                                                    <?php $woocommerce_badge_field_bottom_middle_logo = ( empty($woocommerce_badge_field_bottom_middle_logo) ) ? $globalWooCommerceEventsTicketLogo : $woocommerce_badge_field_bottom_middle_logo; ?>           
                                                <input id="WooCommerceBadgeFieldBottomMiddle_logo" class="text uploadfield" type="text" size="40" name="WooCommerceBadgeFieldBottomMiddle_logo" value="<?php echo esc_attr($woocommerce_badge_field_bottom_middle_logo); ?>" />                
                                                <span class="uploadbox">
                                                    <input class="upload_image_button_woocommerce_events button" type="button" value="Choose file" />
                                                    <div class="clearfix"></div>
                                                </span>
                                                <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                                <div class="clearfix"></div>
                                            </div>     
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fooevents_printing_slot hide_row_1 hide_row_2 hide_col_1 hide_col_2" id="BottomRight">
                                    <?php if (! empty($woocommerce_badge_field_bottom_right)) : ?>
                                        <div class="fooevents_printing_widget">
                                            <span data-name="<?php echo esc_attr($woocommerce_badge_field_bottom_right); ?>">
                                                <?php echo esc_attr($fooevent_WooHelper->widget_label($woocommerce_badge_field_bottom_right, $cf_array)); ?>
                                                <span class="fooevents_printing_arrow fooevents_printing_arrow_closed"></span>
                                            </span>
                                            <div class="fooevents_printing_widget_options">
                                                <?php if ('barcode' !== $woocommerce_badge_field_bottom_right && 'logo' !== $woocommerce_badge_field_bottom_right && 'spacer' !== $woocommerce_badge_field_bottom_right) : ?>
                                                    <?php if ('custom' === $woocommerce_badge_field_bottom_right) : ?>
                                                        <textarea name="WooCommerceBadgeFieldBottomRight_custom" id="WooCommerceBadgeFieldBottomRight_custom"><?php echo esc_attr($woo_commerce_badge_field_bottom_right_custom); ?></textarea>
                                                    <?php endif; ?>
                                                <select class="fooevents_printing_ticket_select" name="WooCommerceBadgeFieldBottomRight_font" id="WooCommerceBadgeFieldBottomRight_font">
                                                    <option value="small" <?php echo ( 'small' === $woocommerce_badge_field_bottom_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small regular text', 'woocommerce-events'); ?></option>
                                                    <option value="small_uppercase" <?php echo ( 'small_uppercase' === $woocommerce_badge_field_bottom_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Small uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="medium" <?php echo ( 'medium' === $woocommerce_badge_field_bottom_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium regular text', 'woocommerce-events'); ?></option>
                                                    <option value="medium_uppercase" <?php echo ( 'medium_uppercase' === $woocommerce_badge_field_bottom_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Medium uppercase text', 'woocommerce-events'); ?></option>
                                                    <option value="large" <?php echo ( 'large' === $woocommerce_badge_field_bottom_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large regular text', 'woocommerce-events'); ?></option>       
                                                    <option value="large_uppercase" <?php echo ( 'large_uppercase' === $woocommerce_badge_field_bottom_right_font ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Large uppercase text', 'woocommerce-events'); ?></option>       
                                                </select>
                                                <?php endif; ?>
                                                <?php if ('logo' === $woocommerce_badge_field_bottom_right) : ?>
                                                    <?php $woocommerce_badge_field_bottom_right_logo = ( empty($woocommerce_badge_field_bottom_right_logo) ) ? $globalWooCommerceEventsTicketLogo : $woocommerce_badge_field_bottom_right_logo; ?>           
                                                <input id="WooCommerceBadgeFieldBottomRight_logo" class="text uploadfield" type="text" size="40" name="WooCommerceBadgeFieldBottomRight_logo" value="<?php echo esc_attr($woocommerce_badge_field_bottom_right_logo); ?>" />                
                                                <span class="uploadbox">
                                                    <input class="upload_image_button_woocommerce_events button" type="button" value="Choose file" />
                                                    <div class="clearfix"></div>
                                                </span>
                                                <a href="#" class="upload_reset"><?php esc_attr_e('Clear', 'woocommerce-events'); ?></a><span> | </span>
                                                <?php endif; ?>
                                                <a href="javascript:void(0);" class="fooevents_printing_widget_remove" name="fooevents_printing_widget_remove">Delete</a>
                                                <div class="clearfix"></div>
                                            </div>     
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="WooCommerceBadgeFieldTopLeft" id="WooCommerceBadgeFieldTopLeft" value="<?php echo esc_attr($woocommerce_badge_field_top_left); ?>" />
                        <input type="hidden" name="WooCommerceBadgeFieldTopMiddle" id="WooCommerceBadgeFieldTopMiddle" value="<?php echo esc_attr($woocommerce_badge_field_top_middle); ?>" />
                        <input type="hidden" name="WooCommerceBadgeFieldTopRight" id="WooCommerceBadgeFieldTopRight" value="<?php echo esc_attr($woocommerce_badge_field_top_right); ?>" />
                        <input type="hidden" name="WooCommerceBadgeFieldMiddleLeft" id="WooCommerceBadgeFieldMiddleLeft" value="<?php echo esc_attr($woocommerce_badge_field_middle_left); ?>" />
                        <input type="hidden" name="WooCommerceBadgeFieldMiddleMiddle" id="WooCommerceBadgeFieldMiddleMiddle" value="<?php echo esc_attr($woocommerce_badge_field_middle_middle); ?>" />
                        <input type="hidden" name="WooCommerceBadgeFieldMiddleRight" id="WooCommerceBadgeFieldMiddleRight" value="<?php echo esc_attr($woocommerce_badge_field_middle_right); ?>" />
                        <input type="hidden" name="WooCommerceBadgeFieldBottomLeft" id="WooCommerceBadgeFieldBottomLeft" value="<?php echo esc_attr($woocommerce_badge_field_bottom_left); ?>" />
                        <input type="hidden" name="WooCommerceBadgeFieldBottomMiddle" id="WooCommerceBadgeFieldBottomMiddle" value="<?php echo esc_attr($woocommerce_badge_field_bottom_middle); ?>" />
                        <input type="hidden" name="WooCommerceBadgeFieldBottomRight" id="WooCommerceBadgeFieldBottomRight" value="<?php echo esc_attr($woocommerce_badge_field_bottom_right); ?>" /> 
                        <input type="button" id="fooevents_printing_save" class='button button-primary' value='<?php esc_attr_e('Save Changes', 'woocommerce-events'); ?>' />
                        <a href="<?php echo esc_attr(site_url()); ?>/wp-admin/admin-ajax.php?action=woocommerce_events_attendee_badges&attendee_show=tickets&event=<?php echo esc_attr($product_id); ?>" id="fooevents_printing_print" class="button" target="_BLANK"><?php esc_attr_e('Print Items', 'woocommerce-events'); ?></a>
                        <?php
                    }//end if
                    ?>

                    <!-- Event Expiration -->
                    <div class="options_group">
                        <p><h2><?php esc_attr_e('Event Expiration', 'woocommerce-events'); ?></h2><div class="wcfm-clearfix"></div></p>
                        <div class="options_group">
                            <p class="form-field">
                                <span class="wcfm_title"><strong><?php esc_attr_e('Event expiration date:', 'woocommerce-events'); ?></strong>
                                    <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('The date when the event will automatically expire.', 'woocommerce-events'); ?>"></span>
                                </span>
                                <input type="text" class="wcfm-text" id="WooCommerceEventsExpire" name="WooCommerceEventsExpire" value="<?php echo esc_attr($WooCommerceEventsExpire); ?>"/>
                            </p>
                        </div>
                    </div>
                    <div class="options_group">
                        <p class="form-field">
                            <?php
                            $WCFM->wcfm_fields->wcfm_generate_form_field(
                                [
                                    'WooCommerceEventsExpireMessage' => [
                                        'label'       => esc_attr__('Expiration message:', 'woocommerce-events'),
                                        'type'        => $wpeditor,
                                        'class'       => 'wcfm-textarea wcfm_ele wcfm_full_ele simple variable external grouped booking wcfm_custom_field_editor '.$rich_editor,
                                        'label_class' => 'wcfm_title wcfm_full_ele',
                                        'rows'        => 5,
                                        'value'       => $WooCommerceEventsExpireMessage,
                                        'teeny'       => true,
                                        'hints'       => esc_attr__('The message that will be displayed on the product page when the event has expired.', 'woocommerce-events'),
                                    ],
                                ]
                            );
                            ?>
                        </p>
                    </div>
                    <p><h2><?php esc_attr_e('Ticket Expiration', 'woocommerce-events'); ?></h2><div class="wcfm-clearfix"></div></p>
                    <div class="options_group">
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Expiration type:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Select either a fixed date or elapsed time since the ticket was purchased to automatically expire tickets.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="radio" name="WooCommerceEventsTicketExpirationType" value="select" <?php echo ( $WooCommerceEventsTicketExpirationType !== 'time' ) ? 'CHECKED' : ''; ?>> <?php esc_html_e('Fixed date', 'woocommerce-events'); ?><br />
                            <span class="wcfm_title"><strong></strong></span>
                            <input type="radio" name="WooCommerceEventsTicketExpirationType" value="time" <?php echo ( $WooCommerceEventsTicketExpirationType === 'time' ) ? 'CHECKED' : ''; ?>> <?php esc_html_e('Elapsed time', 'woocommerce-events'); ?><br />
                            <span class="wcfm_title"><strong></strong></span>
                        </p>
                    </div>
                    <div class="options_group">
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Select fixed date:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Select the fixed ticket expiration date.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <input type="text" class="wcfm-text" id="WooCommerceEventsTicketsExpireSelect" name="WooCommerceEventsTicketsExpireSelect" value="<?php echo esc_attr($WooCommerceEventsTicketsExpireSelect); ?>"/>
                        </p>
                    </div>
                    <div class="options_group">
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e('Select elapsed time:', 'woocommerce-events'); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Select the unit of time to be used for elapsed time.', 'woocommerce-events'); ?>"></span>
                            </span>
                            <select name="WooCommerceEventsTicketsExpireValue" id="WooCommerceEventsTicketsExpireValue" class="wcfm-select width10">
                                <?php for ($x = 1; $x <= 60; $x++) : ?>
                                <option value="<?php echo esc_attr($x); ?>" <?php echo ( $WooCommerceEventsTicketsExpireValue == $x ) ? 'SELECTED' : ''; ?>><?php echo esc_attr($x); ?></option>
                                <?php endfor; ?>
                            </select>
                            <select name="WooCommerceEventsTicketsExpireUnit" id="WooCommerceEventsTicketsExpireUnit" class="wcfm-select width15">
                                <option value="year" <?php echo ( 'year' === $WooCommerceEventsTicketsExpireUnit ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Years', 'woocommerce-events'); ?></option>
                                <option value="month" <?php echo ( 'month' === $WooCommerceEventsTicketsExpireUnit ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Months', 'woocommerce-events'); ?></option>
                                <option value="week" <?php echo ( 'week' === $WooCommerceEventsTicketsExpireUnit ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Weeks', 'woocommerce-events'); ?></option>
                                <option value="day" <?php echo ( 'day' === $WooCommerceEventsTicketsExpireUnit ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Days', 'woocommerce-events'); ?></option>
                                <option value="hour" <?php echo ( 'hour' === $WooCommerceEventsTicketsExpireUnit ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Hours', 'woocommerce-events'); ?></option>
                                <option value="minute" <?php echo ( 'minute' === $WooCommerceEventsTicketsExpireUnit ) ? 'SELECTED' : ''; ?>><?php esc_attr_e('Minutes', 'woocommerce-events'); ?></option>
                            </select>
                        </p>
                    </div>
                    <?php if (WCFMu_Dependencies::wcfm_wc_fooevents_bookings()) { ?>
                        <p><h2><?php esc_attr_e('Bookings Expiration', 'fooevents-bookings'); ?></h2><div class="wcfm-clearfix"></div></p>
                        <div class="options_group">
                            <p class="form-field">
                                <span class="wcfm_title"><strong><?php esc_attr_e('Expire past dates', 'woocommerce-events'); ?></strong>
                                    <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e('Hides bookings if their dates have past.', 'woocommerce-events'); ?>"></span>
                                </span>
                                <input type="checkbox" class="wcfm-checkbox" id="WooCommerceEventsBookingsExpirePassedDate" name="WooCommerceEventsBookingsExpirePassedDate" value="yes" <?php echo ( $WooCommerceEventsBookingsExpirePassedDate === 'yes' ) ? 'CHECKED' : ''; ?>><br />
                            </p>
                        </div>
                    <?php } ?>

                    <!-- Event integration -->
                    <?php
                    /*
                        <div class="options_group">
                        <p><h2><?php esc_attr_e( 'Zoom Meetings and Webinars', 'woocommerce-events' ); ?></h2><div class="wcfm-clearfix"></div></p>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e( 'Attendee details', 'woocommerce-events' ); ?></strong></span>
                            <span class="wcfm_title"><?php esc_html_e( 'Note: Meeting and webinar registration requires attendee details to be captured at checkout.', 'woocommerce-events' ); ?></span>
                            <span class="wcfm_title"></span>
                            <span class="wcfm_title" id="fooevents_enable_attendee_details_note">
                                <span id="fooevents_capture_attendee_details_enabled"
                                <?php
                                if ( empty( $WooCommerceEventsCaptureAttendeeDetails ) || 'off' === $WooCommerceEventsCaptureAttendeeDetails ) :
                                    ?>
                                    style="display:none;"<?php endif; ?>>
                                    <mark class="yes fooevents-zoom-test-access-result" style="padding:0;"><span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Capture attendee details is currently enabled', 'woocommerce-events' ); ?></mark>
                                </span>
                                <span id="fooevents_capture_attendee_details_disabled"
                                <?php
                                if ( ! empty( $WooCommerceEventsCaptureAttendeeDetails ) && 'on' === $WooCommerceEventsCaptureAttendeeDetails ) :
                                    ?>
                                    style="display:none;"<?php endif; ?>>
                                    <mark class="error fooevents-zoom-test-access-result" style="padding:0;"><span class="dashicons dashicons-warning"></span> <?php esc_html_e( 'Capture attendee details is currently disabled', 'woocommerce-events' ); ?></mark>
                                    <br/>
                                    <a href="javascript:enableCaptureAttendeeDetails();"><?php esc_html_e( 'Enable attendee detail capture option', 'woocommerce-events' ); ?></a>
                                </span>
                            </span>
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e( 'Automatically generate', 'woocommerce-events' ); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e( 'Requires the Zoom Video Webinars service to be purchased in your Zoom account.', 'woocommerce-events' ); ?>"></span>
                            </span>
                            <input type="radio" name="WooCommerceEventsZoomType" value="meetings" <?php echo ( empty( $woocommerce_events_zoom_type ) || 'meetings' === $woocommerce_events_zoom_type )? 'CHECKED' : '' ?>> <?php esc_html_e( 'Meetings', 'woocommerce-events' ); ?><br />
                            <span class="wcfm_title"><strong></strong></span>
                            <input type="radio" name="WooCommerceEventsZoomType" value="webinars" <?php echo ( ! empty( $woocommerce_events_zoom_type ) && 'webinars' === $woocommerce_events_zoom_type )? 'CHECKED' : '' ?>> <?php esc_html_e( 'Webinars', 'woocommerce-events' ); ?><br />
                            <span class="wcfm_title"><strong></strong></span>
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e( 'Select meeting/webinar host', 'woocommerce-events' ); ?></strong>
                                <span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e( 'Select the host of Zoom meetings/webinars that get generated automatically.', 'woocommerce-events' ); ?>"></span>
                            </span>
                            <select name="WooCommerceEventsZoomHost" id="WooCommerceEventsZoomHost" class="wcfm-select">
                                <option value="">(<?php esc_html_e( 'Not set', 'woocommerce-events' ); ?>)</option>
                                <?php
                                if ( ! empty( $global_woocommerce_events_zoom_users ) ) :
                                    foreach ( $global_woocommerce_events_zoom_users as $user ) {
                                        ?>
                                        <option value="<?php echo esc_attr( $user['id'] ); ?>" <?php echo ( ! empty( $woocommerce_events_zoom_host ) && $woocommerce_events_zoom_host === $user['id'] ) ? 'SELECTED' : ''; ?>><?php echo esc_html( $user['first_name'] ) . ' ' . esc_html( $user['last_name'] ) . ' - ' . esc_html( $user['email'] ); ?></option>
                                        <?php
                                    }
                                endif;
                                ?>
                            </select>
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e( 'Current event type', 'woocommerce-events' ); ?></strong></span>
                            <span id="fooevents_zoom_current_event_type"></span>
                        </p>
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e( 'Zoom integration type', 'woocommerce-events' ); ?></strong></span>
                            <input type="radio" name="WooCommerceEventsZoomMultiOption" value="single" <?php echo ( empty( $woocommerce_events_zoom_multi_option ) || 'single' === $woocommerce_events_zoom_multi_option )? 'CHECKED' : '' ?>> <?php esc_html_e( 'Single meeting/webinar for this event', 'woocommerce-events' ); ?><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e( 'Select or automatically generate a Zoom meeting/webinar for this event which attendees will automatically be registered for when purchasing an event ticket.', 'woocommerce-events' ); ?>"></span><br />
                            <span class="wcfm_title"><strong></strong></span>
                            <input type="radio" name="WooCommerceEventsZoomMultiOption" value="multi" <?php echo ( ! empty( $woocommerce_events_zoom_multi_option ) && 'multi' === $woocommerce_events_zoom_multi_option )? 'CHECKED' : '' ?>> <?php esc_html_e( 'Separate meeting/webinar for each day', 'woocommerce-events' ); ?><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e( 'Select or automatically generate a Zoom meeting/webinar for each day of this multi-day event which attendees will automatically be registered for when purchasing an event ticket. Note: Requires the FooEvents Multi-day plugin.', 'woocommerce-events' ); ?>"></span><br />
                            <span class="wcfm_title"><strong></strong></span>
                            <input type="radio" name="WooCommerceEventsZoomMultiOption" value="bookings" <?php echo ( ! empty( $woocommerce_events_zoom_multi_option ) && 'bookings' === $woocommerce_events_zoom_multi_option )? 'CHECKED' : '' ?>> <?php esc_html_e( 'Separate meeting/webinar for each booking slot', 'woocommerce-events' ); ?><span class="img_tip wcfmfa fa-question" data-tip="<?php esc_attr_e( 'Select or automatically generate a Zoom meeting/webinar for each date/time slot of the bookable event which attendees will automatically be registered for when purchasing an event ticket. Note: Requires the FooEvents Bookings plugin.', 'woocommerce-events' ); ?>"></span><br />
                            <span class="wcfm_title"><strong></strong></span>
                        </p>
                        </div>
                        <div id ="fooevents_zoom_meeting_single" class="options_group zoom-integration-type-container">
                        <p class="form-field">
                            <span class="wcfm_title"><strong><?php esc_attr_e( 'Link the event to this meeting/webinar:', 'woocommerce-events' ); ?></strong></span>
                            <select name="WooCommerceEventsZoomWebinar" id="WooCommerceEventsZoomWebinar" class="wcfm-select WooCommerceEventsZoomSelect fooevents-search-list">
                                <option value="">(<?php esc_html_e( 'Not set', 'woocommerce-events' ); ?>)</option>
                                <option value="auto">(<?php esc_html_e( 'Auto-generate', 'woocommerce-events' ); ?>)</option>
                                <?php if ( 'success' === $zoom_webinars['status'] && ! empty( $zoom_webinars['data']['webinars'] ) ) : ?>
                                    <optgroup label="<?php esc_attr_e( 'Webinars', 'woocommerce-events' ); ?>">
                                    <?php foreach ( $zoom_webinars['data']['webinars'] as $zoom_webinar ) : ?>
                                        <option value="<?php echo esc_attr( $zoom_webinar['id'] ); ?>" data-zoom-type="<?php echo esc_attr( $zoom_webinar['type'] ); ?>" <?php echo ( str_replace( '_webinars', '', $woocommerce_events_zoom_webinar ) === str_replace( '_webinars', '', $zoom_webinar['id'] ) ) ? 'SELECTED' : ''; ?>><?php echo $zoom_webinars['user_count'] > 1 ? esc_html( $zoom_webinar['host']['first_name'] ) . ' ' . esc_html( $zoom_webinar['host']['last_name'] ) . ' - ' : ''; ?><?php echo esc_html( $zoom_webinar['topic'] ); ?> - <?php echo ! empty( $zoom_webinar['start_date_display'] ) && ! empty( $zoom_webinar['start_time_display'] ) ? esc_html( $zoom_webinar['start_date_display'] ) . ' ' . esc_html( $zoom_webinar['start_time_display'] ) : esc_html__( 'No fixed time', 'woocommerce-events' ); ?></option>
                                    <?php endforeach; ?>
                                    </optgroup>
                                <?php endif; ?>
                                <?php if ( 'success' === $zoom_meetings['status'] && ! empty( $zoom_meetings['data']['meetings'] ) ) : ?>
                                    <optgroup label="<?php esc_attr_e( 'Meetings', 'woocommerce-events' ); ?>">
                                    <?php foreach ( $zoom_meetings['data']['meetings'] as $zoom_meeting ) : ?>
                                        <option value="<?php echo esc_attr( $zoom_meeting['id'] ); ?>" data-zoom-type="<?php echo esc_attr( $zoom_meeting['type'] ); ?>" <?php echo ( str_replace( '_meetings', '', $woocommerce_events_zoom_webinar ) === str_replace( '_meetings', '', $zoom_meeting['id'] ) ) ? 'SELECTED' : ''; ?>><?php echo $zoom_meetings['user_count'] > 1 ? esc_html( $zoom_meeting['host']['first_name'] ) . ' ' . esc_html( $zoom_meeting['host']['last_name'] ) . ' - ' : ''; ?><?php echo esc_html( esc_html( $zoom_meeting['topic'] ) ); ?> - <?php echo ! empty( $zoom_meeting['start_date_display'] ) && ! empty( $zoom_meeting['start_time_display'] ) ? esc_html( $zoom_meeting['start_date_display'] ) . ' ' . esc_html( $zoom_meeting['start_time_display'] ) : esc_html__( 'No fixed time', 'woocommerce-events' ); ?></option>
                                    <?php endforeach; ?>
                                    </optgroup>
                                <?php endif; ?>
                            </select>
                            <?php if ( 'success' === $zoom_meetings['status'] && 'success' === $zoom_webinars['status'] && empty( $zoom_meetings['data']['meetings'] ) && empty( $zoom_webinars['data']['webinars'] ) ) : ?>
                            <br /><br />
                                <?php esc_html_e( 'No Zoom meetings/webinars found.', 'woocommerce-events' ); ?>
                            <br/>
                            <br/>
                            <a href="https://zoom.us/meeting" target="_blank"><?php esc_html_e( 'Create a Zoom meeting', 'woocommerce-events' ); ?></a>
                            <br/>
                            <a href="https://zoom.us/webinar/list" target="_blank"><?php esc_html_e( 'Create a Zoom webinar', 'woocommerce-events' ); ?></a>
                            <?php endif; ?>
                            <?php if ( empty( $global_woocommerce_events_zoom_api_key ) || empty( $global_woocommerce_events_zoom_api_secret ) ) : ?>
                            <br /><br />
                                <?php esc_html_e( 'The Zoom API Key and API Secret are not set.', 'woocommerce-events' ); ?> <a href="admin.php?page=fooevents-settings&tab=integration"><?php esc_html_e( 'Please check the Event Integration settings.', 'woocommerce-events' ); ?></a>
                            <?php endif; ?>
                        </p>
                        <p class="form-field">
                            <label><?php esc_html_e( 'Details:', 'woocommerce-events' ); ?></label>
                            <span id="WooCommerceEventsZoomWebinarDetails">(<?php esc_html_e( 'Not set', 'woocommerce-events' ); ?>)</span>
                        </p>
                        </div>
                    */
                    ?>
                <?php endif; ?>
              </div>
          </div>
    </div>
</div>
