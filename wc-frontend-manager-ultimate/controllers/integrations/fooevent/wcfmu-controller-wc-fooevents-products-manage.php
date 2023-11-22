<?php
/**
 * WCFM plugin controllers
 *
 * Plugin WC Foo Events Products Manage Controller
 *
 * @author  WC Lovers
 * @package wcfmu/controllers/thirdparty
 * @version 5.3.4
 */
class WCFMu_WC_Fooevents_Products_Manage_Controller
{


    public function __construct()
    {
        global $WCFM;

        // Third Party Product Meta Data Save
        add_action('after_wcfm_products_manage_meta_save', [ &$this, 'wcfm_wc_fooevents_products_manage_meta_save' ], 225, 2);

    }//end __construct()


    /**
     * WC Warranty Field Product Meta data save
     */
    function wcfm_wc_fooevents_products_manage_meta_save($new_product_id, $wcfm_products_manage_form_data)
    {
        global $WCFM;

        global $woocommerce_errors;
        global $wp_locale;

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEvent'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsEvent', $wcfm_products_manage_form_data['WooCommerceEventsEvent']);
        }

        $format = get_option('date_format');

        $min    = (60 * get_option('gmt_offset'));
        $sign   = $min < 0 ? '-' : '+';
        $absmin = abs($min);
        try {
            $tz = new DateTimeZone(sprintf('%s%02d%02d', $sign, ($absmin / 60), ($absmin % 60)));
        } catch (Exception $e) {
            $serverTimezone = date_default_timezone_get();
            $tz             = new DateTimeZone($serverTimezone);
        }

        $event_date = $wcfm_products_manage_form_data['WooCommerceEventsDate'];

        if (isset($event_date)) {
            if (isset($wcfm_products_manage_form_data['WooCommerceEventsSelectDate'][0]) && isset($wcfm_products_manage_form_data['WooCommerceEventsMultiDayType']) && $wcfm_products_manage_form_data['WooCommerceEventsMultiDayType'] == 'select') {
                $event_date = $wcfm_products_manage_form_data['WooCommerceEventsSelectDate'][0];
            }

            $event_date = str_replace('/', '-', $event_date);
            // $event_date = str_replace(',', '', $event_date);
            update_post_meta($new_product_id, 'WooCommerceEventsDate', $wcfm_products_manage_form_data['WooCommerceEventsDate']);

            $dtime     = DateTime::createFromFormat($format, $event_date, $tz);
            $timestamp = '';
            if ($dtime instanceof DateTime) {
                if (isset($wcfm_products_manage_form_data['WooCommerceEventsHour']) && isset($wcfm_products_manage_form_data['WooCommerceEventsMinutes'])) {
                    $dtime->setTime((int) $wcfm_products_manage_form_data['WooCommerceEventsHour'], (int) $wcfm_products_manage_form_data['WooCommerceEventsMinutes']);
                }

                $timestamp = $dtime->getTimestamp();
            } else {
                $timestamp = 0;
            }

            update_post_meta($new_product_id, 'WooCommerceEventsDateTimestamp', $timestamp);
        }//end if

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEndDate'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsEndDate', $wcfm_products_manage_form_data['WooCommerceEventsEndDate']);

            $dtime     = DateTime::createFromFormat($format, $wcfm_products_manage_form_data['WooCommerceEventsEndDate'], $tz);
            $timestamp = '';
            if ($dtime instanceof DateTime) {
                if (isset($wcfm_products_manage_form_data['WooCommerceEventsHourEnd']) && isset($wcfm_products_manage_form_data['WooCommerceEventsMinutesEnd'])) {
                    $dtime->setTime((int) $wcfm_products_manage_form_data['WooCommerceEventsHourEnd'], (int) $wcfm_products_manage_form_data['WooCommerceEventsMinutesEnd']);
                }

                $timestamp = $dtime->getTimestamp();
            } else {
                $timestamp = 0;
            }

            update_post_meta($new_product_id, 'WooCommerceEventsEndDateTimestamp', $timestamp);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsType'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsType', $wcfm_products_manage_form_data['WooCommerceEventsType']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsMultiDayType'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsMultiDayType', $wcfm_products_manage_form_data['WooCommerceEventsMultiDayType']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsSelectDate'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsSelectDate', $wcfm_products_manage_form_data['WooCommerceEventsSelectDate']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsNumDays'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsNumDays', $wcfm_products_manage_form_data['WooCommerceEventsNumDays']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsHour'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsHour', $wcfm_products_manage_form_data['WooCommerceEventsHour']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsMinutes'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsMinutes', $wcfm_products_manage_form_data['WooCommerceEventsMinutes']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsPeriod'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsPeriod', $wcfm_products_manage_form_data['WooCommerceEventsPeriod']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsLocation'])) {
            $WooCommerceEventsLocation = htmlentities(stripslashes($wcfm_products_manage_form_data['WooCommerceEventsLocation']));
            update_post_meta($new_product_id, 'WooCommerceEventsLocation', $WooCommerceEventsLocation);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketLogo'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketLogo', $wcfm_products_manage_form_data['WooCommerceEventsTicketLogo']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsPrintTicketLogo'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsPrintTicketLogo', $wcfm_products_manage_form_data['WooCommerceEventsPrintTicketLogo']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketHeaderImage'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketHeaderImage', $wcfm_products_manage_form_data['WooCommerceEventsTicketHeaderImage']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketText'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketText', $wcfm_products_manage_form_data['WooCommerceEventsTicketText']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsThankYouText'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsThankYouText', $wcfm_products_manage_form_data['WooCommerceEventsThankYouText']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEventDetailsText'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsEventDetailsText', $wcfm_products_manage_form_data['WooCommerceEventsEventDetailsText']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsSupportContact'])) {
            $WooCommerceEventsSupportContact = htmlentities(stripslashes($wcfm_products_manage_form_data['WooCommerceEventsSupportContact']));
            update_post_meta($new_product_id, 'WooCommerceEventsSupportContact', $WooCommerceEventsSupportContact);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsHourEnd'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsHourEnd', $wcfm_products_manage_form_data['WooCommerceEventsHourEnd']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsMinutesEnd'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsMinutesEnd', $wcfm_products_manage_form_data['WooCommerceEventsMinutesEnd']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEndPeriod'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsEndPeriod', $wcfm_products_manage_form_data['WooCommerceEventsEndPeriod']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTimeZone'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTimeZone', $wcfm_products_manage_form_data['WooCommerceEventsTimeZone']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsAddEventbrite'])) {
            if (WCFMu_Dependencies::wcfm_wc_fooevents_calendar()) {
                update_post_meta($new_product_id, 'WooCommerceEventsAddEventbrite', $wcfm_products_manage_form_data['WooCommerceEventsAddEventbrite']);
                $FooEvents_Calendar = new FooEvents_Calendar();
                $FooEvents_Calendar->process_eventbrite($new_product_id);
            }
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsGPS'])) {
            $WooCommerceEventsGPS = htmlentities(stripslashes($wcfm_products_manage_form_data['WooCommerceEventsGPS']));
            update_post_meta($new_product_id, 'WooCommerceEventsGPS', htmlentities(stripslashes($wcfm_products_manage_form_data['WooCommerceEventsGPS'])));
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDirections'])) {
            $WooCommerceEventsDirections = htmlentities(stripslashes($wcfm_products_manage_form_data['WooCommerceEventsDirections']));
            update_post_meta($new_product_id, 'WooCommerceEventsDirections', $WooCommerceEventsDirections);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEmail'])) {
            $WooCommerceEventsEmail = esc_textarea($wcfm_products_manage_form_data['WooCommerceEventsEmail']);
            update_post_meta($new_product_id, 'WooCommerceEventsEmail', $WooCommerceEventsEmail);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketBackgroundColor'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketBackgroundColor', $wcfm_products_manage_form_data['WooCommerceEventsTicketBackgroundColor']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketButtonColor'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketButtonColor', $wcfm_products_manage_form_data['WooCommerceEventsTicketButtonColor']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketTextColor'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketTextColor', $wcfm_products_manage_form_data['WooCommerceEventsTicketTextColor']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBackgroundColor'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBackgroundColor', $wcfm_products_manage_form_data['WooCommerceEventsBackgroundColor']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTextColor'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTextColor', $wcfm_products_manage_form_data['WooCommerceEventsTextColor']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsGoogleMaps'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsGoogleMaps', $wcfm_products_manage_form_data['WooCommerceEventsGoogleMaps']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketPurchaserDetails'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketPurchaserDetails', $wcfm_products_manage_form_data['WooCommerceEventsTicketPurchaserDetails']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketPurchaserDetails', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketAddCalendar'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketAddCalendar', $wcfm_products_manage_form_data['WooCommerceEventsTicketAddCalendar']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketAddCalendar', 'off');
        }

        $woocommerce_events_ticket_add_calendar_reminders = [];

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketAddCalendarReminderAmounts']) && isset($wcfm_products_manage_form_data['WooCommerceEventsTicketAddCalendarReminderUnits'])) {
            $woocommerce_events_ticket_add_calendar_reminder_amounts = array_map('sanitize_text_field', $wcfm_products_manage_form_data['WooCommerceEventsTicketAddCalendarReminderAmounts']);
            $woocommerce_events_ticket_add_calendar_reminder_units   = array_map('sanitize_text_field', $wcfm_products_manage_form_data['WooCommerceEventsTicketAddCalendarReminderUnits']);

            for ($i = 0; $i < count($woocommerce_events_ticket_add_calendar_reminder_amounts); $i++) {
                $woocommerce_events_ticket_add_calendar_reminders[] = [
                    'amount' => $woocommerce_events_ticket_add_calendar_reminder_amounts[$i],
                    'unit'   => $woocommerce_events_ticket_add_calendar_reminder_units[$i],
                ];
            }
        }

        update_post_meta($new_product_id, 'WooCommerceEventsTicketAddCalendarReminders', $woocommerce_events_ticket_add_calendar_reminders);

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketDisplayDateTime'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketDisplayDateTime', $wcfm_products_manage_form_data['WooCommerceEventsTicketDisplayDateTime']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketDisplayDateTime', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketDisplayBarcode'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketDisplayBarcode', $wcfm_products_manage_form_data['WooCommerceEventsTicketDisplayBarcode']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketDisplayBarcode', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketDisplayPrice'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketDisplayPrice', $wcfm_products_manage_form_data['WooCommerceEventsTicketDisplayPrice']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketDisplayPrice', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsIncludeCustomAttendeeDetails'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsIncludeCustomAttendeeDetails', $wcfm_products_manage_form_data['WooCommerceEventsIncludeCustomAttendeeDetails']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsIncludeCustomAttendeeDetails', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsCaptureAttendeeDetails'])) {
            $woocommerce_events_capture_attende_details = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsCaptureAttendeeDetails']));
            update_post_meta($new_product_id, 'WooCommerceEventsCaptureAttendeeDetails', $woocommerce_events_capture_attende_details);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsCaptureAttendeeDetails', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsZoomType'])) {
            $woocommerce_events_zoom_type = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsZoomType']));
            update_post_meta($new_product_id, 'WooCommerceEventsZoomType', $woocommerce_events_zoom_type);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsZoomHost'])) {
            $woocommerce_events_zoom_host = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsZoomHost']));
            update_post_meta($new_product_id, 'WooCommerceEventsZoomHost', $woocommerce_events_zoom_host);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsZoomMultiOption'])) {
            $woocommerce_events_zoom_multi_option = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsZoomMultiOption']));
            update_post_meta($new_product_id, 'WooCommerceEventsZoomMultiOption', $woocommerce_events_zoom_multi_option);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEmailAttendee'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsEmailAttendee', $wcfm_products_manage_form_data['WooCommerceEventsEmailAttendee']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsEmailAttendee', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsCaptureAttendeeTelephone'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsCaptureAttendeeTelephone', $wcfm_products_manage_form_data['WooCommerceEventsCaptureAttendeeTelephone']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsCaptureAttendeeTelephone', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsCaptureAttendeeCompany'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsCaptureAttendeeCompany', $wcfm_products_manage_form_data['WooCommerceEventsCaptureAttendeeCompany']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsCaptureAttendeeCompany', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsCaptureAttendeeDesignation'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsCaptureAttendeeDesignation', $wcfm_products_manage_form_data['WooCommerceEventsCaptureAttendeeDesignation']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsCaptureAttendeeDesignation', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsUniqueEmail'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsUniqueEmail', $wcfm_products_manage_form_data['WooCommerceEventsUniqueEmail']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsUniqueEmail', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsSendEmailTickets'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsSendEmailTickets', $wcfm_products_manage_form_data['WooCommerceEventsSendEmailTickets']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsSendEmailTickets', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEmailSubjectSingle'])) {
            $WooCommerceEventsEmailSubjectSingle = htmlentities($wcfm_products_manage_form_data['WooCommerceEventsEmailSubjectSingle']);
            // $WooCommerceEventsEmailSubjectSingle = sanitize_text_field($wcfm_products_manage_form_data['WooCommerceEventsEmailSubjectSingle']);
            update_post_meta($new_product_id, 'WooCommerceEventsEmailSubjectSingle', $WooCommerceEventsEmailSubjectSingle);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsEmailSubjectSingle', '{OrderNumber} Ticket');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsExportUnpaidTickets'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsExportUnpaidTickets', $wcfm_products_manage_form_data['WooCommerceEventsExportUnpaidTickets']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsExportUnpaidTickets', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsExportBillingDetails'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsExportBillingDetails', $wcfm_products_manage_form_data['WooCommerceEventsExportBillingDetails']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsExportBillingDetails', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeSize'])) {
            update_post_meta($new_product_id, 'WooCommerceBadgeSize', $wcfm_products_manage_form_data['WooCommerceBadgeSize']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeField1'])) {
            update_post_meta($new_product_id, 'WooCommerceBadgeField1', $wcfm_products_manage_form_data['WooCommerceBadgeField1']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeField2'])) {
            update_post_meta($new_product_id, 'WooCommerceBadgeField2', $wcfm_products_manage_form_data['WooCommerceBadgeField2']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeField3'])) {
            update_post_meta($new_product_id, 'WooCommerceBadgeField3', $wcfm_products_manage_form_data['WooCommerceBadgeField3']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsCutLines'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsCutLines', $wcfm_products_manage_form_data['WooCommerceEventsCutLines']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsCutLines', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketSize'])) {
            $woocommerce_print_ticket_size = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommercePrintTicketSize']));
            update_post_meta($new_product_id, 'WooCommercePrintTicketSize', $woocommerce_print_ticket_size);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField1'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField1', $wcfm_products_manage_form_data['WooCommercePrintTicketField1']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField1_font'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField1_font', $wcfm_products_manage_form_data['WooCommercePrintTicketField1_font']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField2'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField2', $wcfm_products_manage_form_data['WooCommercePrintTicketField2']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField2_font'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField2_font', $wcfm_products_manage_form_data['WooCommercePrintTicketField2_font']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField3'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField3', $wcfm_products_manage_form_data['WooCommercePrintTicketField3']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField3_font'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField3_font', $wcfm_products_manage_form_data['WooCommercePrintTicketField3_font']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField4'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField4', $wcfm_products_manage_form_data['WooCommercePrintTicketField4']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField4_font'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField4_font', $wcfm_products_manage_form_data['WooCommercePrintTicketField4_font']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField5'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField5', $wcfm_products_manage_form_data['WooCommercePrintTicketField5']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField5_font'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField5_font', $wcfm_products_manage_form_data['WooCommercePrintTicketField5_font']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField6'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField6', $wcfm_products_manage_form_data['WooCommercePrintTicketField6']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketField6_font'])) {
            update_post_meta($new_product_id, 'WooCommercePrintTicketField6_font', $wcfm_products_manage_form_data['WooCommercePrintTicketField6_font']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsPrintTicketLogoOption'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsPrintTicketLogoOption', $wcfm_products_manage_form_data['WooCommerceEventsPrintTicketLogoOption']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsCutLinesPrintTicket'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsCutLinesPrintTicket', $wcfm_products_manage_form_data['WooCommerceEventsCutLinesPrintTicket']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsCutLinesPrintTicket', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketBackgroundImage'])) {
            $woocommerce_events_ticket_background_image = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketBackgroundImage']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketBackgroundImage', $woocommerce_events_ticket_background_image);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketNumbers'])) {
            $woocommerce_print_ticket_numbers = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommercePrintTicketNumbers']));
            update_post_meta($new_product_id, 'WooCommercePrintTicketNumbers', $woocommerce_print_ticket_numbers);
        } else {
            update_post_meta($new_product_id, 'WooCommercePrintTicketNumbers', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketOrders'])) {
            $woocommerce_print_ticket_orders = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommercePrintTicketOrders']));
            update_post_meta($new_product_id, 'WooCommercePrintTicketOrders', $woocommerce_print_ticket_orders);
        } else {
            update_post_meta($new_product_id, 'WooCommercePrintTicketOrders', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketSort'])) {
            $woocommerce_print_ticket_sort = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommercePrintTicketSort']));
            update_post_meta($new_product_id, 'WooCommercePrintTicketSort', $woocommerce_print_ticket_sort);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketNrColumns'])) {
            $woocommerce_print_ticket_nr_columns = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommercePrintTicketNrColumns']));
            update_post_meta($new_product_id, 'WooCommercePrintTicketNrColumns', $woocommerce_print_ticket_nr_columns);
        }

        if (isset($wcfm_products_manage_form_data['WooCommercePrintTicketNrRows'])) {
            $woocommerce_print_ticket_nr_rows = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommercePrintTicketNrRows']));
            update_post_meta($new_product_id, 'WooCommercePrintTicketNrRows', $woocommerce_print_ticket_nr_rows);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopLeft'])) {
            $woocommerce_badge_field_top_left = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopLeft']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopLeft', $woocommerce_badge_field_top_left);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopMiddle'])) {
            $woocommerce_badge_field_top_middle = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopMiddle']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopMiddle', $woocommerce_badge_field_top_middle);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopRight'])) {
            $woocommerce_badge_field_top_right = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopRight']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopRight', $woocommerce_badge_field_top_right);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleLeft'])) {
            $woocommerce_badge_field_middle_left = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleLeft']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleLeft', $woocommerce_badge_field_middle_left);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleMiddle'])) {
            $woocommerce_badge_field_middle_middle = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleMiddle']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleMiddle', $woocommerce_badge_field_middle_middle);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleRight'])) {
            $woocommerce_badge_field_middle_right = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleRight']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleRight', $woocommerce_badge_field_middle_right);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomLeft'])) {
            $woocommerce_badge_field_bottom_left = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomLeft']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomLeft', $woocommerce_badge_field_bottom_left);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomMiddle'])) {
            $woocommerce_badge_field_bottom_middle = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomMiddle']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomMiddle', $woocommerce_badge_field_bottom_middle);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomRight'])) {
            $woocommerce_badge_field_bottom_right = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomRight']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomRight', $woocommerce_badge_field_bottom_right);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopLeft_custom'])) {
            $woocommerce_badge_field_top_left_custom = wp_kses_post(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopLeft_custom']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopLeft_custom', $woocommerce_badge_field_top_left_custom);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopLeft_custom', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopMiddle_custom'])) {
            $woocommerce_badge_field_top_middle_custom = wp_kses_post(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopMiddle_custom']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopMiddle_custom', $woocommerce_badge_field_top_middle_custom);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopMiddle_custom', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopRight_custom'])) {
            $woocommerce_badge_field_top_right_custom = wp_kses_post(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopRight_custom']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopRight_custom', $woocommerce_badge_field_top_right_custom);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopRight_custom', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleLeft_custom'])) {
            $woocommerce_badge_field_middle_left_custom = wp_kses_post(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleLeft_custom']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleLeft_custom', $woocommerce_badge_field_middle_left_custom);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleLeft_custom', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleMiddle_custom'])) {
            $woocommerce_badge_field_middle_middle_custom = wp_kses_post(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleMiddle_custom']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleMiddle_custom', $woocommerce_badge_field_middle_middle_custom);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleMiddle_custom', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleRight_custom'])) {
            $woocommerce_badge_field_middle_right_custom = wp_kses_post(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleRight_custom']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleRight_custom', $woocommerce_badge_field_middle_right_custom);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleRight_custom', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomLeft_custom'])) {
            $woocommerce_badge_field_bottom_left_custom = wp_kses_post(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomLeft_custom']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomLeft_custom', $woocommerce_badge_field_bottom_left_custom);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomLeft_custom', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomMiddle_custom'])) {
            $woocommerce_badge_field_bottom_middle_custom = wp_kses_post(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomMiddle_custom']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomMiddle_custom', $woocommerce_badge_field_bottom_middle_custom);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomMiddle_custom', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomRight_custom'])) {
            $woocommerce_badge_field_bottom_right_custom = wp_kses_post(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomRight_custom']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomRight_custom', $woocommerce_badge_field_bottom_right_custom);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomRight_custom', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopLeft_font'])) {
            $woocommerce_badge_field_top_left_font = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopLeft_font']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopLeft_font', $woocommerce_badge_field_top_left_font);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopMiddle_font'])) {
            $woocommerce_badge_field_top_middle_font = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopMiddle_font']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopMiddle_font', $woocommerce_badge_field_top_middle_font);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopRight_font'])) {
            $woocommerce_badge_field_top_right_font = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopRight_font']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopRight_font', $woocommerce_badge_field_top_right_font);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleLeft_font'])) {
            $woocommerce_badge_field_middle_left_font = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleLeft_font']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleLeft_font', $woocommerce_badge_field_middle_left_font);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleMiddle_font'])) {
            $woocommerce_badge_field_middle_middle_font = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleMiddle_font']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleMiddle_font', $woocommerce_badge_field_middle_middle_font);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleRight_font'])) {
            $woocommerce_badge_field_middle_right_font = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleRight_font']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleRight_font', $woocommerce_badge_field_middle_right_font);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomLeft_font'])) {
            $woocommerce_badge_field_bottom_left_font = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomLeft_font']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomLeft_font', $woocommerce_badge_field_bottom_left_font);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomMiddle_font'])) {
            $woocommerce_badge_field_bottom_middle_font = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomMiddle_font']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomMiddle_font', $woocommerce_badge_field_bottom_middle_font);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomRight_font'])) {
            $woocommerce_badge_field_bottom_right_font = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomRight_font']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomRight_font', $woocommerce_badge_field_bottom_right_font);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopLeft_logo'])) {
            $woocommerce_badge_field_top_left_logo = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopLeft_logo']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopLeft_logo', $woocommerce_badge_field_top_left_logo);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopLeft_logo', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopMiddle_logo'])) {
            $woocommerce_badge_field_top_middle_logo = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopMiddle_logo']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopMiddle_logo', $woocommerce_badge_field_top_middle_logo);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopMiddle_logo', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopRight_logo'])) {
            $woocommerce_badge_field_top_right_logo = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldTopRight_logo']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopRight_logo', $woocommerce_badge_field_top_right_logo);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldTopRight_logo', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleLeft_logo'])) {
            $woocommerce_badge_field_middle_left_logo = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleLeft_logo']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleLeft_logo', $woocommerce_badge_field_middle_left_logo);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleLeft_logo', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleMiddle_logo'])) {
            $woocommerce_badge_field_middle_middle_logo = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleMiddle_logo']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleMiddle_logo', $woocommerce_badge_field_middle_middle_logo);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleMiddle_logo', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleRight_logo'])) {
            $woocommerce_badge_field_middle_right_logo = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldMiddleRight_logo']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleRight_logo', $woocommerce_badge_field_middle_right_logo);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldMiddleRight_logo', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomLeft_logo'])) {
            $woocommerce_badge_field_bottom_left_logo = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomLeft_logo']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomLeft_logo', $woocommerce_badge_field_bottom_left_logo);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomLeft_logo', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomMiddle_logo'])) {
            $woocommerce_badge_field_bottom_middle_logo = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomMiddle_logo']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomMiddle_logo', $woocommerce_badge_field_bottom_middle_logo);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomMiddle_logo', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomRight_logo'])) {
            $woocommerce_badge_field_bottom_right_logo = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceBadgeFieldBottomRight_logo']));
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomRight_logo', $woocommerce_badge_field_bottom_right_logo);
        } else {
            update_post_meta($new_product_id, 'WooCommerceBadgeFieldBottomRight_logo', '');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketTheme'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketTheme', $wcfm_products_manage_form_data['WooCommerceEventsTicketTheme']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsAttendeeOverride', $wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsAttendeeOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketOverride', $wcfm_products_manage_form_data['WooCommerceEventsTicketOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsTicketOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDayOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDayOverride', $wcfm_products_manage_form_data['WooCommerceEventsDayOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDayOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDayOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsDayOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsSlotOverride', $wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsSlotOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsDateOverride', $wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsDateOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsBookingDetailsOverride', $wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsBookingDetailsOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsViewSeatingOptions'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingOptions', $wcfm_products_manage_form_data['WooCommerceEventsViewSeatingOptions']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingOptions', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsViewSeatingChart'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingChart', $wcfm_products_manage_form_data['WooCommerceEventsViewSeatingChart']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingChart', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEventDetailsNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsEventDetailsNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsEventDetailsNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsEventDetailsNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplayAttendeeNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayAttendeeNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplayAttendeeNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayAttendeeNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplayBookingsNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayBookingsNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplayBookingsNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayBookingsNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplaySeatingsNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplaySeatingsNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplaySeatingsNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplaySeatingsNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplayCustAttNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayCustAttNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplayCustAttNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayCustAttNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['fooevents_custom_attendee_fields_options_serialized'])) {
            $fooevents_custom_attendee_fields_options_serialized = $wcfm_products_manage_form_data['fooevents_custom_attendee_fields_options_serialized'];
            update_post_meta($new_product_id, 'fooevents_custom_attendee_fields_options_serialized', $fooevents_custom_attendee_fields_options_serialized);
        }

        if (isset($wcfm_products_manage_form_data['fooevents_seating_options_serialized'])) {
            $fooevents_seating_options_serialized = $wcfm_products_manage_form_data['fooevents_seating_options_serialized'];
            update_post_meta($new_product_id, 'fooevents_seating_options_serialized', $fooevents_seating_options_serialized);
        }

        if (isset($wcfm_products_manage_form_data['FooEventsTicketFooterText'])) {
            update_post_meta($new_product_id, 'FooEventsTicketFooterText', $wcfm_products_manage_form_data['FooEventsTicketFooterText']);
        }

        if (isset($wcfm_products_manage_form_data['FooEventsPDFTicketsEmailText'])) {
            update_post_meta($new_product_id, 'FooEventsPDFTicketsEmailText', $wcfm_products_manage_form_data['FooEventsPDFTicketsEmailText']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsExpire'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsExpire', $wcfm_products_manage_form_data['WooCommerceEventsExpire']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsExpireMessage'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsExpireMessage', $wcfm_products_manage_form_data['WooCommerceEventsExpireMessage']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketExpirationType'])) {
            $WooCommerceEventsTicketExpirationType = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketExpirationType']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketExpirationType', $WooCommerceEventsTicketExpirationType);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireSelect'])) {
            $expire_date = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireSelect']));
            $expire_date = str_replace('/', '-', $expire_date);
            $expire_date = str_replace(',', '', $expire_date);
            $expire_date = $this->convert_month_to_english($expire_date);

            $timestamp = strtotime($expire_date);

            $woocommerce_events_tickets_expire_select = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireSelect']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireSelect', $woocommerce_events_tickets_expire_select);
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireSelectTimestamp', $timestamp);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireValue'])) {
            $WooCommerceEventsTicketsExpireValue = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireValue']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireValue', $WooCommerceEventsTicketsExpireValue);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireUnit'])) {
            $WooCommerceEventsTicketsExpireUnit = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireUnit']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireUnit', $WooCommerceEventsTicketsExpireUnit);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsExpirePassedDate'])) {
            $woocommerce_events_bookings_expire_passed_date = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsBookingsExpirePassedDate']));
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsExpirePassedDate', $woocommerce_events_bookings_expire_passed_date);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsExpirePassedDate', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketTheme'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketTheme', $wcfm_products_manage_form_data['WooCommerceEventsTicketTheme']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsAttendeeOverride', $wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsAttendeeOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketOverride', $wcfm_products_manage_form_data['WooCommerceEventsTicketOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsTicketOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDayOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDayOverride', $wcfm_products_manage_form_data['WooCommerceEventsDayOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDayOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDayOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsDayOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsSlotOverride', $wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsSlotOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsDateOverride', $wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsDateOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsBookingDetailsOverride', $wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsBookingDetailsOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsViewSeatingOptions'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingOptions', $wcfm_products_manage_form_data['WooCommerceEventsViewSeatingOptions']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingOptions', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsViewSeatingChart'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingChart', $wcfm_products_manage_form_data['WooCommerceEventsViewSeatingChart']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingChart', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEventDetailsNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsEventDetailsNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsEventDetailsNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsEventDetailsNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplayAttendeeNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayAttendeeNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplayAttendeeNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayAttendeeNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplayBookingsNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayBookingsNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplayBookingsNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayBookingsNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplaySeatingsNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplaySeatingsNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplaySeatingsNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplaySeatingsNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplayCustAttNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayCustAttNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplayCustAttNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayCustAttNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['fooevents_seating_options_serialized'])) {
            $fooevents_seating_options_serialized = $wcfm_products_manage_form_data['fooevents_seating_options_serialized'];
            update_post_meta($new_product_id, 'fooevents_seating_options_serialized', $fooevents_seating_options_serialized);
        }

        if (isset($wcfm_products_manage_form_data['FooEventsTicketFooterText'])) {
            update_post_meta($new_product_id, 'FooEventsTicketFooterText', $wcfm_products_manage_form_data['FooEventsTicketFooterText']);
        }

        if (isset($wcfm_products_manage_form_data['FooEventsPDFTicketsEmailText'])) {
            update_post_meta($new_product_id, 'FooEventsPDFTicketsEmailText', $wcfm_products_manage_form_data['FooEventsPDFTicketsEmailText']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsExpire'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsExpire', $wcfm_products_manage_form_data['WooCommerceEventsExpire']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsExpireMessage'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsExpireMessage', $wcfm_products_manage_form_data['WooCommerceEventsExpireMessage']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketExpirationType'])) {
            $WooCommerceEventsTicketExpirationType = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketExpirationType']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketExpirationType', $WooCommerceEventsTicketExpirationType);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireSelect'])) {
            $expire_date = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireSelect']));
            $expire_date = str_replace('/', '-', $expire_date);
            $expire_date = str_replace(',', '', $expire_date);
            $expire_date = $this->convert_month_to_english($expire_date);

            $timestamp = strtotime($expire_date);

            $woocommerce_events_tickets_expire_select = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireSelect']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireSelect', $woocommerce_events_tickets_expire_select);
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireSelectTimestamp', $timestamp);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireValue'])) {
            $WooCommerceEventsTicketsExpireValue = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireValue']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireValue', $WooCommerceEventsTicketsExpireValue);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireUnit'])) {
            $WooCommerceEventsTicketsExpireUnit = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireUnit']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireUnit', $WooCommerceEventsTicketsExpireUnit);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsExpirePassedDate'])) {
            $woocommerce_events_bookings_expire_passed_date = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsBookingsExpirePassedDate']));
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsExpirePassedDate', $woocommerce_events_bookings_expire_passed_date);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsExpirePassedDate', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketTheme'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketTheme', $wcfm_products_manage_form_data['WooCommerceEventsTicketTheme']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsAttendeeOverride', $wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsAttendeeOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsAttendeeOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketOverride', $wcfm_products_manage_form_data['WooCommerceEventsTicketOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsTicketOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsTicketOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDayOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDayOverride', $wcfm_products_manage_form_data['WooCommerceEventsDayOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDayOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDayOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsDayOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsSlotOverride', $wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsSlotOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsBookingsSlotOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsDateOverride', $wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsDateOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsBookingsDateOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverride'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsBookingDetailsOverride', $wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverride']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverridePlural'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsBookingDetailsOverridePlural', $wcfm_products_manage_form_data['WooCommerceEventsBookingsBookingDetailsOverridePlural']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsViewSeatingOptions'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingOptions', $wcfm_products_manage_form_data['WooCommerceEventsViewSeatingOptions']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingOptions', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsViewSeatingChart'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingChart', $wcfm_products_manage_form_data['WooCommerceEventsViewSeatingChart']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsViewSeatingChart', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsEventDetailsNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsEventDetailsNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsEventDetailsNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsEventDetailsNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplayAttendeeNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayAttendeeNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplayAttendeeNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayAttendeeNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplayBookingsNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayBookingsNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplayBookingsNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayBookingsNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplaySeatingsNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplaySeatingsNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplaySeatingsNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplaySeatingsNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsDisplayCustAttNewOrder'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayCustAttNewOrder', $wcfm_products_manage_form_data['WooCommerceEventsDisplayCustAttNewOrder']);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsDisplayCustAttNewOrder', 'off');
        }

        if (isset($wcfm_products_manage_form_data['fooevents_seating_options_serialized'])) {
            $fooevents_seating_options_serialized = $wcfm_products_manage_form_data['fooevents_seating_options_serialized'];
            update_post_meta($new_product_id, 'fooevents_seating_options_serialized', $fooevents_seating_options_serialized);
        }

        if (isset($wcfm_products_manage_form_data['FooEventsTicketFooterText'])) {
            update_post_meta($new_product_id, 'FooEventsTicketFooterText', $wcfm_products_manage_form_data['FooEventsTicketFooterText']);
        }

        if (isset($wcfm_products_manage_form_data['FooEventsPDFTicketsEmailText'])) {
            update_post_meta($new_product_id, 'FooEventsPDFTicketsEmailText', $wcfm_products_manage_form_data['FooEventsPDFTicketsEmailText']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsExpire'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsExpire', $wcfm_products_manage_form_data['WooCommerceEventsExpire']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsExpireMessage'])) {
            update_post_meta($new_product_id, 'WooCommerceEventsExpireMessage', $wcfm_products_manage_form_data['WooCommerceEventsExpireMessage']);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketExpirationType'])) {
            $WooCommerceEventsTicketExpirationType = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketExpirationType']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketExpirationType', $WooCommerceEventsTicketExpirationType);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireSelect'])) {
            $expire_date = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireSelect']));
            $expire_date = str_replace('/', '-', $expire_date);
            $expire_date = str_replace(',', '', $expire_date);
            $expire_date = $this->convert_month_to_english($expire_date);

            $timestamp = strtotime($expire_date);

            $woocommerce_events_tickets_expire_select = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireSelect']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireSelect', $woocommerce_events_tickets_expire_select);
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireSelectTimestamp', $timestamp);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireValue'])) {
            $WooCommerceEventsTicketsExpireValue = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireValue']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireValue', $WooCommerceEventsTicketsExpireValue);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireUnit'])) {
            $WooCommerceEventsTicketsExpireUnit = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsTicketsExpireUnit']));
            update_post_meta($new_product_id, 'WooCommerceEventsTicketsExpireUnit', $WooCommerceEventsTicketsExpireUnit);
        }

        if (isset($wcfm_products_manage_form_data['WooCommerceEventsBookingsExpirePassedDate'])) {
            $woocommerce_events_bookings_expire_passed_date = sanitize_text_field(wp_unslash($wcfm_products_manage_form_data['WooCommerceEventsBookingsExpirePassedDate']));
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsExpirePassedDate', $woocommerce_events_bookings_expire_passed_date);
        } else {
            update_post_meta($new_product_id, 'WooCommerceEventsBookingsExpirePassedDate', 'off');
        }

    }//end wcfm_wc_fooevents_products_manage_meta_save()


    /**
     * Array of month names for translation to English
     *
     * @param  string $event_date event date.
     * @return string
     */
    private function convert_month_to_english($event_date)
    {
        $months = [
            // French.
            'janvier'     => 'January',
            'février'     => 'February',
            'mars'        => 'March',
            'avril'       => 'April',
            'mai'         => 'May',
            'juin'        => 'June',
            'juillet'     => 'July',
            'aout'        => 'August',
            'août'        => 'August',
            'septembre'   => 'September',
            'octobre'     => 'October',

            // German.
            'Januar'      => 'January',
            'Februar'     => 'February',
            'März'        => 'March',
            'Mai'         => 'May',
            'Juni'        => 'June',
            'Juli'        => 'July',
            'Oktober'     => 'October',
            'Dezember'    => 'December',

            // Spanish.
            'enero'       => 'January',
            'febrero'     => 'February',
            'marzo'       => 'March',
            'abril'       => 'April',
            'mayo'        => 'May',
            'junio'       => 'June',
            'julio'       => 'July',
            'agosto'      => 'August',
            'septiembre'  => 'September',
            'setiembre'   => 'September',
            'octubre'     => 'October',
            'noviembre'   => 'November',
            'diciembre'   => 'December',
            'novembre'    => 'November',
            'décembre'    => 'December',

            // Catalan - Spain.
            'gener'       => 'January',
            'febrer'      => 'February',
            'març'        => 'March',
            'abril'       => 'April',
            'maig'        => 'May',
            'juny'        => 'June',
            'juliol'      => 'July',
            'agost'       => 'August',
            'setembre'    => 'September',
            'octubre'     => 'October',
            'novembre'    => 'November',
            'desembre'    => 'December',

            // Dutch.
            'januari'     => 'January',
            'februari'    => 'February',
            'maart'       => 'March',
            'april'       => 'April',
            'mei'         => 'May',
            'juni'        => 'June',
            'juli'        => 'July',
            'augustus'    => 'August',
            'september'   => 'September',
            'oktober'     => 'October',
            'november'    => 'November',
            'december'    => 'December',

            // Italian.
            'Gennaio'     => 'January',
            'Febbraio'    => 'February',
            'Marzo'       => 'March',
            'Aprile'      => 'April',
            'Maggio'      => 'May',
            'Giugno'      => 'June',
            'Luglio'      => 'July',
            'Agosto'      => 'August',
            'Settembre'   => 'September',
            'Ottobre'     => 'October',
            'Novembre'    => 'November',
            'Dicembre'    => 'December',

            // Polish.
            'Styczeń'     => 'January',
            'Luty'        => 'February',
            'Marzec'      => 'March',
            'Kwiecień'    => 'April',
            'Maj'         => 'May',
            'Czerwiec'    => 'June',
            'Lipiec'      => 'July',
            'Sierpień'    => 'August',
            'Wrzesień'    => 'September',
            'Październik' => 'October',
            'Listopad'    => 'November',
            'Grudzień'    => 'December',

            // Afrikaans.
            'Januarie'    => 'January',
            'Februarie'   => 'February',
            'Maart'       => 'March',
            'Mei'         => 'May',
            'Junie'       => 'June',
            'Julie'       => 'July',
            'Augustus'    => 'August',
            'Oktober'     => 'October',
            'Desember'    => 'December',

            // Turkish.
            'Ocak'        => 'January',
            'Şubat'       => 'February',
            'Mart'        => 'March',
            'Nisan'       => 'April',
            'Mayıs'       => 'May',
            'Haziran'     => 'June',
            'Temmuz'      => 'July',
            'Ağustos'     => 'August',
            'Eylül'       => 'September',
            'Ekim'        => 'October',
            'Kasım'       => 'November',
            'Aralık'      => 'December',

            // Portuguese.
            'janeiro'     => 'January',
            'fevereiro'   => 'February',
            'março'       => 'March',
            'abril'       => 'April',
            'maio'        => 'May',
            'junho'       => 'June',
            'julho'       => 'July',
            'agosto'      => 'August',
            'setembro'    => 'September',
            'outubro'     => 'October',
            'novembro'    => 'November',
            'dezembro'    => 'December',

            // Swedish.
            'Januari'     => 'January',
            'Februari'    => 'February',
            'Mars'        => 'March',
            'April'       => 'April',
            'Maj'         => 'May',
            'Juni'        => 'June',
            'Juli'        => 'July',
            'Augusti'     => 'August',
            'September'   => 'September',
            'Oktober'     => 'October',
            'November'    => 'November',
            'December'    => 'December',

            // Czech.
            'leden'       => 'January',
            'únor'        => 'February',
            'březen'      => 'March',
            'duben'       => 'April',
            'květen'      => 'May',
            'červen'      => 'June',
            'červenec'    => 'July',
            'srpen'       => 'August',
            'září'        => 'September',
            'říjen'       => 'October',
            'listopad'    => 'November',
            'prosinec'    => 'December',

            // Norwegian.
            'januar'      => 'January',
            'februar'     => 'February',
            'mars'        => 'March',
            'april'       => 'April',
            'mai'         => 'May',
            'juni'        => 'June',
            'juli'        => 'July',
            'august'      => 'August',
            'september'   => 'September',
            'oktober'     => 'October',
            'november'    => 'November',
            'desember'    => 'December',

            // Danish.
            'januar'      => 'January',
            'februar'     => 'February',
            'marts'       => 'March',
            'april'       => 'April',
            'maj'         => 'May',
            'juni'        => 'June',
            'juli'        => 'July',
            'august'      => 'August',
            'september'   => 'September',
            'oktober'     => 'October',
            'november'    => 'November',
            'december'    => 'December',

            // Finnish.
            'tammikuu'    => 'January',
            'helmikuu'    => 'February',
            'maaliskuu'   => 'March',
            'huhtikuu'    => 'April',
            'toukokuu'    => 'May',
            'kesäkuu'     => 'June',
            'heinäkuu'    => 'July',
            'elokuu'      => 'August',
            'syyskuu'     => 'September',
            'lokakuu'     => 'October',
            'marraskuu'   => 'November',
            'joulukuu'    => 'December',

            // Russian.
            'Январь'      => 'January',
            'Февраль'     => 'February',
            'Март'        => 'March',
            'Апрель'      => 'April',
            'Май'         => 'May',
            'Июнь'        => 'June',
            'Июль'        => 'July',
            'Август'      => 'August',
            'Сентябрь'    => 'September',
            'Октябрь'     => 'October',
            'Ноябрь'      => 'November',
            'Декабрь'     => 'December',

            // Icelandic.
            'Janúar'      => 'January',
            'Febrúar'     => 'February',
            'Mars'        => 'March',
            'Apríl'       => 'April',
            'Maí'         => 'May',
            'Júní'        => 'June',
            'Júlí'        => 'July',
            'Ágúst'       => 'August',
            'September'   => 'September',
            'Oktober'     => 'October',
            'Nóvember'    => 'November',
            'Desember'    => 'December',

            // Latvian.
            'janvāris'    => 'January',
            'februāris'   => 'February',
            'marts'       => 'March',
            'aprīlis'     => 'April',
            'maijs'       => 'May',
            'jūnijs'      => 'June',
            'jūlijs'      => 'July',
            'augusts'     => 'August',
            'septembris'  => 'September',
            'oktobris'    => 'October',
            'novembris'   => 'November',
            'decembris'   => 'December',

            // Lithuanian.
            'Sausis'      => 'January',
            'Vasaris'     => 'February',
            'Kovas'       => 'March',
            'Balandis'    => 'April',
            'Gegužė'      => 'May',
            'Birželis'    => 'June',
            'Liepa'       => 'July',
            'Rugpjūtis'   => 'August',
            'Rugsėjis'    => 'September',
            'Spalis'      => 'October',
            'Lapkritis'   => 'November',
            'Gruodis'     => ' December',

            // Greek.
            'Ιανουάριος'  => 'January',
            'Φεβρουάριος' => 'February',
            'Μάρτιος'     => 'March',
            'Απρίλιος'    => 'April',
            'Μάιος'       => 'May',
            'Ιούνιος'     => 'June',
            'Ιούλιος'     => 'July',
            'Αύγουστος'   => 'August',
            'Σεπτέμβριος' => 'September',
            'Οκτώβριος'   => 'October',
            'Νοέμβριος'   => 'November',
            'Δεκέμβριος'  => 'December',

            // Slovak - Slovakia.
            'január'      => 'January',
            'február'     => 'February',
            'marec'       => 'March',
            'apríl'       => 'April',
            'máj'         => 'May',
            'jún'         => 'June',
            'júl'         => 'July',
            'august'      => 'August',
            'september'   => 'September',
            'október'     => 'October',
            'november'    => 'November',
            'december'    => 'December',

            // Slovenian - Slovenia.
            'januar'      => 'January',
            'februar'     => 'February',
            'marec'       => 'March',
            'april'       => 'April',
            'maj'         => 'May',
            'junij'       => 'June',
            'julij'       => 'July',
            'avgust'      => 'August',
            'september'   => 'September',
            'oktober'     => 'October',
            'november'    => 'November',
            'december'    => 'December',

            // Romanian - Romania.
            'ianuarie'    => 'January',
            'februarie'   => 'February',
            'martie'      => 'March',
            'aprilie'     => 'April',
            'mai'         => 'May',
            'iunie'       => 'June',
            'iulie'       => 'July',
            'august'      => 'August',
            'septembrie'  => 'September',
            'octombrie'   => 'October',
            'noiembrie'   => 'November',
            'decembrie'   => 'December',
        ];

        $pattern     = array_keys($months);
        $replacement = array_values($months);

        foreach ($pattern as $key => $value) {
            $pattern[$key] = '/\b'.$value.'\b/iu';
        }

        $replaced_event_date = preg_replace($pattern, $replacement, $event_date);

        $replaced_event_date = str_replace(' de ', ' ', $replaced_event_date);

        return $replaced_event_date;

    }//end convert_month_to_english()


}//end class
