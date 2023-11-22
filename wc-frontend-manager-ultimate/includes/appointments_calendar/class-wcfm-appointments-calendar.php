<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * WC_Appointments_Admin_Calendar class.
 */
class WCFM_Appointments_Calendar 
{
	/**
	 * Stores Appointments.
	 *
	 * @var array
	 */
	private $appointments;

    /**
     * Output the calendar view
     */
    public function output() {
        $filter_view  = apply_filters( 'woocommerce_appointments_calendar_view', 'week' );
        $user_view    = get_user_meta( get_current_user_id(), 'calendar_view', true );
        $default_view = $user_view ? $user_view : $filter_view;
		$view         = $_REQUEST['view'] ?? $default_view;
		$staff_list   = WC_Appointments_Admin::get_appointment_staff();

		$product_filter = isset( $_REQUEST['filter_appointable_product'] ) ? absint( $_REQUEST['filter_appointable_product'] ) : '';
		$staff_filter   = isset( $_REQUEST['filter_appointable_staff'] ) ? absint( $_REQUEST['filter_appointable_staff'] ) : '';

		// Override to only show appointments for current staff member.
		if ( ! current_user_can( 'manage_others_appointments' ) ) {
			$staff_filter = get_current_user_id();
		}

		// Update calendar view seletion.
		if ( isset( $_REQUEST['view'] ) ) {
			update_user_meta( get_current_user_id(), 'calendar_view', $_REQUEST['view'] );
		}

		if ( in_array( $view, [ 'day', 'staff' ] ) ) {
			$day           = isset( $_REQUEST['calendar_day'] ) ? wc_clean( $_REQUEST['calendar_day'] ) : date_i18n( 'Y-m-d' );
			$day_formatted = date( 'Y-m-d', strtotime( $day ) );
			$prev_day      = date( 'Y-m-d', strtotime( '-1 day', strtotime( $day ) ) );
			$next_day      = date( 'Y-m-d', strtotime( '+1 day', strtotime( $day ) ) );

			$args_filters = [
				'strict'   => true,
				'order_by' => 'start_date',
				'order'    => 'ASC',
			];

            if (defined('WC_APPOINTMENTS_VERSION') && version_compare(WC_APPOINTMENTS_VERSION, '4.7.0', '>=')) {
                $this->appointments = WC_Appointments_Availability_Data_Store::get_events_in_date_range(
                    strtotime( 'midnight', strtotime( $day ) ),
                    strtotime( 'midnight +1 day', strtotime( $day ) ),
                    $product_filter,
                    $staff_filter,
                    false,
                    $args_filters
                );
            } else {
                $this->appointments = WC_Appointments_Controller::get_appointments_in_date_range(
                    strtotime('midnight', strtotime($day)),
                    strtotime('midnight +1 day', strtotime($day)),
                    $product_filter,
                    $staff_filter,
                    false,
                    $args_filters
                );
            }
        } else if ('week' === $view) {
            $day            = isset($_REQUEST['calendar_day']) ? wc_clean($_REQUEST['calendar_day']) : date_i18n('Y-m-d');
            $day_formatted  = date('Y-m-d', strtotime($day));
            $week           = date_i18n('w', strtotime($day));
            $start_of_week  = absint(get_option('start_of_week', 1));
            $week_start     = strtotime("previous sunday +{$start_of_week} day", strtotime($day));
            $week_end       = strtotime('+1 week -1 min', $week_start);
            $week_formatted = date_i18n(wc_appointments_date_format(), $week_start).' &mdash; '.date_i18n(wc_appointments_date_format(), $week_end);
            $prev_week      = date('Y-m-d', strtotime('-1 week', strtotime($day)));
            $next_week      = date('Y-m-d', strtotime('+1 week', strtotime($day)));

			#$prev_day = date_i18n( wc_appointments_date_format(), strtotime( '-1 day', strtotime( $day ) ) );

			$args_filters = [
				'strict'   => true,
				'order_by' => 'start_date',
				'order'    => 'ASC',
			];

            if (defined('WC_APPOINTMENTS_VERSION') && version_compare(WC_APPOINTMENTS_VERSION, '4.7.0', '>=')) {
                $this->appointments = WC_Appointments_Availability_Data_Store::get_events_in_date_range(
                    $week_start,
                    $week_end,
                    $product_filter,
                    $staff_filter,
                    false,
                    $args_filters
                );
            } else {
                $this->appointments = WC_Appointments_Controller::get_appointments_in_date_range(
                    $week_start,
                    $week_end,
                    $product_filter,
                    $staff_filter,
                    false,
                    $args_filters
                );
            }
        } else {
            $month = isset($_REQUEST['calendar_month']) ? absint($_REQUEST['calendar_month']) : date_i18n('n');
            $year  = isset($_REQUEST['calendar_year']) ? absint($_REQUEST['calendar_year']) : date_i18n('Y');

			if ( $year < ( date_i18n( 'Y' ) - 10 ) || $year > 2100 )
				$year = date_i18n( 'Y' );

			if ( $month > 12 ) {
				$month = 1;
				$year ++;
			}

			if ( $month < 1 ) {
				$month = 12;
				$year --;
			}

			$start_of_week = absint( get_option( 'start_of_week', 1 ) );
			$last_day      = date( 't', strtotime( "$year-$month-01" ) );
			$start_date_w  = absint( date( 'w', strtotime( "$year-$month-01" ) ) );
			$end_date_w    = absint( date( 'w', strtotime( "$year-$month-$last_day" ) ) );

			// Calc day offset
			$day_offset = $start_date_w - $start_of_week;
			$day_offset = $day_offset >= 0 ? $day_offset : 7 - abs( $day_offset );

			// Calc end day offset
			$end_day_offset = 7 - ( $last_day % 7 ) - $day_offset;
			$end_day_offset = $end_day_offset >= 0 && $end_day_offset < 7 ? $end_day_offset : 7 - abs( $end_day_offset );

			// We want to get the last minute of the day, so we will go forward one day to midnight and subtract a min
			$end_day_offset = $end_day_offset + 1;

			$start_time = strtotime( "-{$day_offset} day", strtotime( "$year-$month-01" ) );
			$end_time   = strtotime( "+{$end_day_offset} day midnight -1 min", strtotime( "$year-$month-$last_day" ) );

			$args_filters = [
				'strict'   => true,
				'order_by' => 'start_date',
				'order'    => 'ASC',
			];

            if (defined('WC_APPOINTMENTS_VERSION') && version_compare(WC_APPOINTMENTS_VERSION, '4.7.0', '>=')) {
                $this->appointments = WC_Appointments_Availability_Data_Store::get_events_in_date_range(
                    $start_time,
                    $end_time,
                    $product_filter,
                    $staff_filter,
                    false,
                    $args_filters
                );
            } else {
                $this->appointments = WC_Appointments_Controller::get_appointments_in_date_range(
                    $start_time,
                    $end_time,
                    $product_filter,
                    $staff_filter,
                    false,
                    $args_filters
                );
            }
        }//end if

		include 'views/html-calendar-' . $view . '.php';

    }//end output()


	/**
	 * List appointments for a day
	 *
	 * @param  [type] $day
	 * @param  [type] $month
	 * @param  [type] $year
	 * @return [type]
	 */
    public function list_appointments($day, $month, $year, $list = 'by_time', $staff_id = '' )
    {
		$date_start = strtotime( "$year-$month-$day midnight" ); // Midnight today.
		$date_end   = strtotime( "$year-$month-$day tomorrow" ); // Midnight next day.

        foreach ($this->appointments as $appointment) {
            $event_type       = is_a($appointment, 'WC_Appointment') ? 'appointment' : 'availability';
            $event_is_all_day = $appointment->is_all_day();
			// Get start and end timestamps.
			if ( 'appointment' === $event_type ) {
				$event_start = $appointment->get_start();
				$event_end   = $appointment->get_end();
            } else {
                $range = $appointment->get_time_range_for_date($date_start);
				if ( is_null( $range ) ) {
					continue;
				}
				$event_start      = $range['start'];
				$event_end        = $range['end'];
                $event_is_all_day = false; // Set all availability to be displayed as hourly.
            }

			if ( 'all_day' === $list && $event_is_all_day && $event_start < $date_end && $event_end > $date_start ) {
				if ( $staff_id && 'appointment' === $event_type ) {
                    $staff_ids = $appointment->get_staff_ids();
                    $staff_ids = ! is_array($staff_ids) ? [ $staff_ids ] : $staff_ids;
                    if (in_array($staff_id, $staff_ids)) {
                        $this->event_card($appointment, $event_start, $event_end, $list = 'all_day');
                    } else if (! $staff_ids && 'unassigned' === $staff_id) {
                        $this->event_card($appointment, $event_start, $event_end, $list = 'all_day');
                    }
                } else {
                    $this->event_card($appointment, $event_start, $list = 'all_day');
                }
            } else if ('by_time' === $list && ! $event_is_all_day && $event_start < $date_end && $event_end > $date_start) {
				if ( $staff_id && 'appointment' === $event_type ) {
                    $staff_ids = $appointment->get_staff_ids();
                    $staff_ids = ! is_array($staff_ids) ? [ $staff_ids ] : $staff_ids;
                    if (in_array($staff_id, $staff_ids)) {
                        $this->event_card($appointment, $event_start, $event_end, $list = 'by_time');
                    } else if (! $staff_ids && 'unassigned' === $staff_id) {
                        $this->event_card($appointment, $event_start, $event_end, $list = 'by_time');
                    }
                } else {
                    $this->event_card($appointment, $event_start, $event_end, $list = 'by_time');
                }
            } else if ('by_month' === $list && $event_start < $date_end && $event_end > $date_start) {
				if ( $staff_id && 'appointment' === $event_type ) {
                    $staff_ids = $appointment->get_staff_ids();
                    $staff_ids = ! is_array($staff_ids) ? [ $staff_ids ] : $staff_ids;
                    if (in_array($staff_id, $staff_ids)) {
                        $this->event_card($appointment, $event_start, $event_end, $list = 'by_month');
                    } else if (! $staff_ids && 'unassigned' === $staff_id) {
                        $this->event_card($appointment, $event_start, $event_end, $list = 'by_month');
                    }
                } else {
                    $this->event_card($appointment, $event_start, $event_end, $list = 'by_month');
                }
            }//end if
        }//end foreach

    }//end list_appointments()

    /**
	 * Event card.
	 */
	public function event_card( $event, $event_start, $event_end, $list = '' ) {
		// Event defaults.
		$datarray               = [];
		$datarray['id']         = $event->get_id();
		$datarray['classes']    = [ 'event_card' ];
		$datarray['type']       = is_a( $event, 'WC_Appointment' ) ? 'appointment' : 'availability';
		$datarray['start']      = $event_start;
		$datarray['end']        = $event_end;
		$datarray['is_all_day'] = $event->is_all_day();
		$datarray['when']       = wc_appointment_format_timestamp( $datarray['start'], $datarray['is_all_day'] ) . ' &mdash; ' . wc_appointment_format_timestamp( $datarray['end'], $datarray['is_all_day'] );
		if ( date_i18n( 'ymd', $datarray['start'] ) === date_i18n( 'ymd', $datarray['start'] ) && ! $datarray['is_all_day'] ) {
			$datarray['when'] = wc_appointment_format_timestamp( $datarray['start'], $datarray['is_all_day'] ) . ' &mdash; ' . date_i18n( wc_appointments_time_format(), $datarray['end'] );
		}
		$datarray['duration']       = wc_appointment_duration_in_minutes( $datarray['start'], $datarray['end'] );
		$datarray['duration_unit']  = 'minute';
		$datarray['event_customer'] = '';
		$datarray['event_status']   = '';
		$datarray['event_name']     = '';
		$datarray['addons']         = '';
		if ( $datarray['is_all_day'] ) {
			$datarray['event_datetime'] = '';
		} else {
			$datarray['event_datetime'] = date( wc_appointments_time_format(), $datarray['start'] );
		}
		if ( 'all_day' === $list ) {
			$datarray['start_time'] = date( 'Y-m-d', $datarray['start'] );
			$datarray['end_time']   = date( 'Y-m-d', $datarray['start'] );
		} else {
			$datarray['start_time'] = date( 'Hi', $datarray['start'] );
			$datarray['end_time']   = date( 'Hi', $datarray['end'] );
		}
		if ( 'appointment' === $datarray['type'] ) {
			$event_product        = $event->get_product();
			$datarray['status']   = $event->get_status();
			$datarray['order_id'] = wp_get_post_parent_id( $event->get_id() );
			$datarray['staff_id'] = $event->get_staff_ids();
			if ( ! is_array( $datarray['staff_id'] ) ) {
				$datarray['staff_id'] = [ $datarray['staff_id'] ];
			}
			$datarray['staff_name']    = $event->get_staff_members( true ) ? htmlentities( $event->get_staff_members( true, true ) ) : '';
			$datarray['duration']      = wc_appointment_duration_in_minutes( $datarray['start'], $datarray['end'], $event->get_duration_unit() );
			$datarray['duration_unit'] = $event->get_duration_unit();
			$datarray['event_qty']     = $event->get_qty();
			$datarray['order_id']      = wp_get_post_parent_id( $event->get_id() );
			if ( $datarray['order_id'] ) {
				$order                    = wc_get_order( $datarray['order_id'] );
				$datarray['order_status'] = is_a( $order, 'WC_Order' ) ? $order->get_status() : '';
			}
			$datarray['event_cost'] = esc_html( wc_price( (float) $event->get_cost() ) );
			if ( $datarray['order_id'] ) {
				$order                  = wc_get_order( $datarray['order_id'] );
				$datarray['event_cost'] = is_a( $order, 'WC_Order' ) ? esc_html( wc_price( (float) $order->get_total() ) ) : $datarray['event_cost'];
			}
			$datarray['event_status']       = $event->get_status();
			$datarray['classes'][]          = $datarray['event_status'];
			$datarray['event_status_label'] = wc_appointments_get_status_label( $event->get_status() );
			$customer_status                = $event->get_customer_status();
			$datarray['customer_status']    = $customer_status ? $customer_status : 'expected';
			$datarray['classes'][]          = $datarray['customer_status'];
			$customer                       = $event->get_customer();
			if ( $customer ) {
				$datarray['event_customer'] = $customer->full_name;
				$datarray['customer_name']  = $customer->full_name;
				$datarray['customer_phone'] = preg_replace( '/\s+/', '', $customer->phone );
				$datarray['customer_email'] = $customer->email;
				if ( $customer->user_id ) {
					$datarray['customer_id']     = $customer->user_id;
					$datarray['customer_url']    = get_edit_user_link( $customer->user_id );
					$datarray['customer_avatar'] = get_avatar_url(
						$customer->user_id,
						[
							'size'    => 110,
							'default' => 'mm',
						]
					);
				}
			}
			$datarray['product_id']    = $event->get_product_id();
			$datarray['product_title'] = is_object( $event_product ) ? $event_product->get_title() : '';
			$datarray['addons']        = esc_html( $event->get_addons() );
			$datarray['edit_link']     = esc_url( get_wcfm_view_appointment_url( $event->get_id() ) );
			$datarray['color']         = is_object( $event_product ) && $event_product->get_cal_color() ? $event_product->get_cal_color() : '#0073aa';
		} else {
			$is_rrule    = 'rrule' === $event->get_range_type();
			$is_google   = ! empty( $event->get_event_id() );
			$is_all_day  = false === strpos( $event->get_from_range(), ':' );
			$rrule_str   = wc_appointments_esc_rrule( $event->get_rrule(), $is_all_day );
			$date_format = $is_all_day ? 'Y-m-d' : 'Y-m-d g:i A';
			$from_date   = new WC_DateTime( $event->get_from_range() );
			$to_date     = new WC_DateTime( $event->get_to_range() );
			$timezone    = new DateTimeZone( wc_appointment_get_timezone_string() );
			$from_date->setTimezone( $timezone );
			$to_date->setTimezone( $timezone );
			$human_readable_options = [
				'date_formatter' => function( $date ) use ( $date_format ) {
					return $date->format( $date_format );
				},
				'locale'         => 'en',
			];
			$datarray['event_name'] = ! empty( $event->get_title() ) ? $event->get_title() . ' - ' : '';
			if ( $is_google ) {
				if ( $is_rrule ) {
					$datarray['event_name'] .= '<small>' . esc_html__( 'Google Recurring Event', 'woocommerce-appointments' ) . '</small>';
				} else {
					$datarray['event_name'] .= '<small>' . esc_html__( 'Google Event', 'woocommerce-appointments' ) . '</small>';
				}
			}
			if ( $is_rrule ) {
				$rset             = new \RRule\RSet( $rrule_str, $is_all_day ? $from_date->format( $date_format ) : $from_date );
				$datarray['when'] = esc_html__( 'Repeating ', 'woocommerce-appointments' );
				foreach ( $rset->getRRules() as $rrule ) {
					$datarray['when'] .= esc_html( $rrule->humanReadable( $human_readable_options ) );
				}
				if ( $rset->getExDates() ) {
					$datarray['when'] .= esc_html__( ', except ', 'woocommerce-appointments' );
					$datarray['when'] .= esc_html(
						join(
							' and ',
							array_map(
								function ( $date ) use ( $date_format ) {
									return $date->format( $date_format );
								},
								$rset->getExDates()
							)
						)
					);
				}
				$datarray['duration'] = '';
			}
			if ( $is_all_day ) {
				$datarray['duration']       = '';
				$datarray['event_datetime'] = '';
			}
			$datarray['edit_link'] = esc_url( admin_url( 'admin.php?page=wc-settings&tab=appointments&view=synced' ) );
			$datarray['color']     = '#555';
		}

		// Card -data attributes.
		$card_data_attr = '';
		foreach ( $datarray as $attribute => $value ) {
			if ( is_array( $value ) ) {
				$attrs = '';
				foreach ( $value as $attr_key => $attr_val ) {
					$attrs .= "{$attr_key}: {$attr_val};";
				}
				$value = $attrs;
			}

			$card_data_attr .= "data-{$attribute}=\"{$value}\" ";
		}
		$card_data_html = apply_filters( 'woocommerce_appointments_calendar_single_card_data', $card_data_attr, $datarray, $event );

		// Card style.
		$calendar_scale = apply_filters( 'woocommerce_appointments_calendar_view_day_scale', 60 );
		$event_top      = ( ( intval( substr( $datarray['start_time'], 0, 2 ) ) * 60 ) + intval( substr( $datarray['start_time'], -2 ) ) ) / 60 * $calendar_scale;
		$card_style     = '';
		if ( 'by_time' === $list ) {
			$duration_minutes = wc_appointment_duration_in_minutes( $datarray['start'], $datarray['end'], $datarray['duration_unit'], false );
			$height           = intval( ( $duration_minutes / 60 ) * $calendar_scale );
			$card_style      .= ' background: ' . $datarray['color'] . '; top: ' . $event_top . 'px; height: ' . $height . 'px;';
		} else {
			$card_style .= ' background: ' . $datarray['color'];
		}

		// Build card variables.
		$card_title     = __( 'View / Edit', 'woocommerce-appointments' );
		$card_classes   = implode( ' ', $datarray['classes'] );
		$card_edit_link = $datarray['edit_link'];
		#$card_header     = $datarray['event_datetime'] ? '<strong class="event_datetime">' . $datarray['event_datetime'] . '</strong>' : '';
		$card_header     = $datarray['event_customer'] && $datarray['customer_status'] ? '<strong class="event_customer status-' . $datarray['customer_status'] . '">' . $datarray['event_customer'] . '</strong>' : '';
		$card_content_li = '';
		if ( $datarray['event_datetime'] ) {
			$card_content_li .= '<li class="event_datetime">' . $datarray['event_datetime'] . '</li>';
		} elseif ( $datarray['event_name'] ) {
			$card_content_li .= '<li class="event_availability">' . $datarray['event_name'] . '</li>';
		}
		if ( $datarray['event_status'] && $datarray['event_status_label'] ) {
			$card_content_li .= '<li class="event_status status-' . $datarray['event_status'] . '" data-tip="' . wc_sanitize_tooltip( $datarray['event_status_label'] ) . '"></li>';
		}

		// Build card html.
		$card_html = "
			<div class='$card_classes' title='$card_title' $card_data_html style='$card_style'>
				<a href='$card_edit_link'>
					$card_header
					<ul>
					$card_content_li
					</ul>
				</a>
			</div>
		";

		echo apply_filters( 'woocommerce_appointments_calendar_view_single_card', $card_html, $datarray, $event );
	}


    /**
     * Filters products for narrowing search
     */
    public function product_filters()
    {
        $filters = [];

        foreach (WC_Appointments_Admin::get_appointment_products() as $product) {
            $filters[$product->get_id()] = $product->get_title();
        }

        return $filters;

    }//end product_filters()


	/**
	 * Filters staff for narrowing search
	 */
	public function staff_filters() {
		$filters = [];

		// Only show staff filter if current user can see other staff's appointments.
		if ( ! current_user_can( 'manage_others_appointments' ) ) {
			return $filters;
		}

		$staff = WC_Appointments_Admin::get_appointment_staff();

		foreach ( $staff as $staff_member ) {
			$filters[ $staff_member->ID ] = $staff_member->display_name;
		}

		return $filters;

    }//end staff_filters()

}//end class
