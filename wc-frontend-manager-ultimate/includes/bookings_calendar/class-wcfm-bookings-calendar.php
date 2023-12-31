<?php
if (! defined('ABSPATH')) {
    exit;
}

/**
 * WC_Bookings_Calendar.
 */
class WCFM_Bookings_Calendar
{

    /**
     * Stores Bookings.
     *
     * @var array
     */
    private $bookings;


    /**
     * Output the calendar view.
     */
    public function output()
    {
        wp_enqueue_script('wc-enhanced-select');

        $product_filter = isset($_REQUEST['filter_bookings']) ? absint($_REQUEST['filter_bookings']) : '';
        $view           = isset($_REQUEST['view']) && 'day' === $_REQUEST['view'] ? 'day' : 'month';

        if ('day' === $view) {
            $day = isset($_REQUEST['calendar_day']) ? wc_clean($_REQUEST['calendar_day']) : date('Y-m-d');

            $this->bookings = WC_Bookings_Controller::get_bookings_in_date_range(
                strtotime('midnight', strtotime($day)),
                strtotime('midnight +1 day', strtotime($day)),
                $product_filter,
                false
            );
        } else {
            $month = isset($_REQUEST['calendar_month']) ? absint($_REQUEST['calendar_month']) : date('n');
            $year  = isset($_REQUEST['calendar_year']) ? absint($_REQUEST['calendar_year']) : date('Y');

            if ($year < ( date('Y') - 10 ) || $year > 2100) {
                $year = date('Y');
            }

            if ($month > 12) {
                $month = 1;
                $year++;
            }

            if ($month < 1) {
                $month = 12;
                $year--;
            }

            $start_of_week = absint(get_option('start_of_week', 1));
            $last_day      = date('t', strtotime("$year-$month-01"));
            $start_date_w  = absint(date('w', strtotime("$year-$month-01")));
            $end_date_w    = absint(date('w', strtotime("$year-$month-$last_day")));

            // Calc day offset
            $day_offset = ($start_date_w - $start_of_week);
            $day_offset = $day_offset >= 0 ? $day_offset : (7 - abs($day_offset));

            // Cald end day offset
            $end_day_offset = (7 - ( $last_day % 7 ) - $day_offset);
            $end_day_offset = $end_day_offset >= 0 && $end_day_offset < 7 ? $end_day_offset : (7 - abs($end_day_offset));

            // We want to get the last minute of the day, so we will go forward one day to midnight and subtract a min
            $end_day_offset = ($end_day_offset + 1);

            $start_time     = strtotime("-{$day_offset} day", strtotime("$year-$month-01"));
            $end_time       = strtotime("+{$end_day_offset} day midnight", strtotime("$year-$month-$last_day"));
            $this->bookings = WC_Bookings_Controller::get_bookings_in_date_range(
                $start_time,
                $end_time,
                $product_filter,
                false
            );
        }//end if

        include 'views/html-calendar-'.$view.'.php';

    }//end output()


    /**
     * List bookings for a day.
     */
    public function list_bookings($day, $month, $year)
    {
        $date_start = strtotime("$year-$month-$day midnight");
        // Midnight today.
        $date_end = strtotime("$year-$month-$day tomorrow");
        // Midnight next day.
        foreach ($this->bookings as $booking) {
            if ($booking->get_start() < $date_end && $booking->get_end() > $date_start) {
                echo '<li><a href="'.get_wcfm_view_booking_url($booking->get_id(), $booking).'">';
                    echo '<strong>#'.$booking->get_id().' - ';
                if ($product = $booking->get_product()) {
                    echo $product->get_title();
                }

                    echo '</strong>';
                    echo '<ul>';
                if (( $customer = $booking->get_customer() ) && ! empty($customer->name)) {
                    echo '<li>'.__('Booked by', 'woocommerce-bookings').' '.$customer->name.'</li>';
                }

                        echo '<li>';
                if ($booking->is_all_day()) {
                    echo __('All Day', 'woocommerce-bookings');
                } else {
                    echo $booking->get_start_date('', 'g:ia').'&mdash;'.$booking->get_end_date('', 'g:ia');
                }

                        echo '</li>';
                if ($resource = $booking->get_resource()) {
                    echo '<li>'.__('Resource #', 'woocommerce-bookings').$resource->ID.' - '.$resource->post_title.'</li>';
                }

                    echo '</ul></a>';
                echo '</li>';
            }//end if
        }//end foreach

    }//end list_bookings()


    /**
     * List bookings on a day.
     */
    public function list_bookings_for_day()
    {
        $bookings_by_time = [];
        $all_day_bookings = [];
        $unqiue_ids       = [];

        foreach ($this->bookings as $booking) {
            if ($booking->is_all_day()) {
                $all_day_bookings[] = $booking;
            } else {
                $start_time = $booking->get_start_date('', 'Gi');

                if (! isset($bookings_by_time[$start_time])) {
                    $bookings_by_time[$start_time] = [];
                }

                $bookings_by_time[$start_time][] = $booking;
            }

            $unqiue_ids[] = $booking->get_product_id().$booking->get_resource_id();
        }

        ksort($bookings_by_time);

        $unqiue_ids = array_flip($unqiue_ids);
        $index      = 0;
        $colours    = [
            '#3498db',
            '#34495e',
            '#1abc9c',
            '#2ecc71',
            '#f1c40f',
            '#e67e22',
            '#e74c3c',
            '#2980b9',
            '#8e44ad',
            '#2c3e50',
            '#16a085',
            '#27ae60',
            '#f39c12',
            '#d35400',
            '#c0392b',
        ];

        foreach ($unqiue_ids as $key => $value) {
            if (isset($colours[$index])) {
                $unqiue_ids[$key] = $colours[$index];
            } else {
                $unqiue_ids[$key] = $this->random_color();
            }

            $index++;
        }

        $column = 0;

        foreach ($all_day_bookings as $booking) {
            echo '<li data-tip="'.$this->get_tip($booking).'" style="background: '.$unqiue_ids[$booking->get_product_id().$booking->get_resource_id()].'; left:'.((100) * $column).'px; top: 0; bottom: 0;"><a href="'.get_wcfm_view_booking_url($booking->get_id(), $booking).'">#'.$booking->get_id().'</a></li>';
            $column++;
        }

        $start_column = $column;
        $last_end     = 0;

        foreach ($bookings_by_time as $bookings) {
            foreach ($bookings as $booking) {
                $start_time = $booking->get_start_date('', 'Gi');
                $end_time   = $booking->get_end_date('', 'Gi');

                $height = (( $end_time - $start_time ) / 1.66666667);

                if ($height < 30) {
                    $height = 30;
                }

                if ($last_end > $start_time) {
                    $column++;
                } else {
                    $column = $start_column;
                }

                echo '<li data-tip="'.$this->get_tip($booking).'" style="background: '.esc_attr($unqiue_ids[$booking->get_product_id().$booking->get_resource_id()]).'; left:'.esc_attr(100 * $column).'px; top: '.esc_attr(( $start_time * 60 ) / 100).'px; height: '.esc_attr($height).'px;"><a href="'.get_wcfm_view_booking_url($booking->get_id(), $booking).'">#'.esc_html($booking->get_id()).'</a></li>';

                if ($end_time > $last_end) {
                    $last_end = $end_time;
                }
            }//end foreach
        }//end foreach

    }//end list_bookings_for_day()


    /**
     * Get a random colour.
     */
    public function random_color()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));

    }//end random_color()


    /**
     * Get a tooltip in day view.
     *
     * @param  object $booking
     * @return string
     */
    public function get_tip($booking)
    {
        $return = '';

        $return .= '#'.$booking->get_id().' - ';
        if ($product = $booking->get_product()) {
            $return .= $product->get_title();
        }

        if (( $customer = $booking->get_customer() ) && ! empty($customer->name)) {
            $return .= '<br/>'.__('Booked by', 'woocommerce-bookings').' '.$customer->name;
        }

        if ($resource = $booking->get_resource()) {
            $return .= '<br/>'.__('Resource #', 'woocommerce-bookings').$resource->ID.' - '.$resource->post_title;
        }

        return esc_attr($return);

    }//end get_tip()


    /**
     * Filters products for narrowing search.
     */
    public function product_filters()
    {
        $filters  = [];
        $products = WC_Bookings_Admin::get_booking_products();

        foreach ($products as $product) {
            $filters[$product->get_id()] = $product->get_name();

            $resources = $product->get_resources();

            foreach ($resources as $resource) {
                $filters[$resource->get_id()] = '&nbsp;&nbsp;&nbsp;'.$resource->get_name();
            }
        }

        return $filters;

    }//end product_filters()


    /**
     * Filters resources for narrowing search.
     */
    public function resources_filters()
    {
        $filters   = [];
        $resources = WC_Bookings_Admin::get_booking_resources();

        foreach ($resources as $resource) {
            $filters[$resource->get_id()] = $resource->get_name();
        }

        return $filters;

    }//end resources_filters()


}//end class
