<?php
/**
 * WCFMu plugin views
 *
 * Plugin WC Booking Accommodation Products Manage Views
 *
 * @author  Squiz Pty Ltd <products@squiz.net>
 * @package wcfmu/views
 * @version 2.4.4
 */
global $wp, $WCFM, $WCFMu;

$product_id  = 0;
$booking_qty = 1;

$min_date      = 0;
$min_date_unit = '';
$max_date      = 12;
$max_date_unit = '';

$intervals = [];

$intervals['months'] = [
    '1'  => __('January', 'woocommerce-accommodation-bookings'),
    '2'  => __('February', 'woocommerce-accommodation-bookings'),
    '3'  => __('March', 'woocommerce-accommodation-bookings'),
    '4'  => __('April', 'woocommerce-accommodation-bookings'),
    '5'  => __('May', 'woocommerce-accommodation-bookings'),
    '6'  => __('June', 'woocommerce-accommodation-bookings'),
    '7'  => __('July', 'woocommerce-accommodation-bookings'),
    '8'  => __('August', 'woocommerce-accommodation-bookings'),
    '9'  => __('September', 'woocommerce-accommodation-bookings'),
    '10' => __('October', 'woocommerce-accommodation-bookings'),
    '11' => __('November', 'woocommerce-accommodation-bookings'),
    '12' => __('December', 'woocommerce-accommodation-bookings'),
];

$intervals['days'] = [
    '1' => __('Monday', 'woocommerce-accommodation-bookings'),
    '2' => __('Tuesday', 'woocommerce-accommodation-bookings'),
    '3' => __('Wednesday', 'woocommerce-accommodation-bookings'),
    '4' => __('Thursday', 'woocommerce-accommodation-bookings'),
    '5' => __('Friday', 'woocommerce-accommodation-bookings'),
    '6' => __('Saturday', 'woocommerce-accommodation-bookings'),
    '7' => __('Sunday', 'woocommerce-accommodation-bookings'),
];

for ($i = 1; $i <= 53; $i++) {
    $intervals['weeks'][$i] = sprintf(__('Week %s', 'woocommerce-accommodation-bookings'), $i);
}

$range_types = [
    'custom' => __('Custom date range', 'woocommerce-accommodation-bookings'),
    'months' => __('Range of months', 'woocommerce-accommodation-bookings'),
    'weeks'  => __('Range of weeks', 'woocommerce-accommodation-bookings'),
    'days'   => __('Range of days', 'woocommerce-accommodation-bookings'),
];

$has_restricted_days = 'no';
$restricted_days     = [];
$first_block_time    = '';

$availability_rule_values    = [];
$availability_default_rules  = [
    'type'        => 'custom',
    'from_custom' => '',
    'to_custom'   => '',
    'from_months' => '',
    'to_months'   => '',
    'from_weeks'  => '',
    'to_weeks'    => '',
    'from_days'   => '',
    'to_days'     => '',
    'bookable'    => '',
    'priority'    => 10,
];
$availability_rule_values[0] = $availability_default_rules;

$booking_base_cost = '';
$display_cost      = '';

$cost_range_types = [
    'custom' => __('Range of certain nights', 'woocommerce-accommodation-bookings'),
    'months' => __('Range of months', 'woocommerce-accommodation-bookings'),
    'weeks'  => __('Range of weeks', 'woocommerce-accommodation-bookings'),
    'days'   => __('Range of nights during the week', 'woocommerce-accommodation-bookings'),
];

$cost_rule_values    = [];
$cost_default_rules  = [
    'type'           => 'custom',
    'from_custom'    => '',
    'to_custom'      => '',
    'from_months'    => '',
    'to_months'      => '',
    'from_weeks'     => '',
    'to_weeks'       => '',
    'from_days'      => '',
    'to_days'        => '',
    'override_block' => '',
];
$cost_rule_values[0] = $cost_default_rules;

if (isset($wp->query_vars['wcfm-products-manage']) && ! empty($wp->query_vars['wcfm-products-manage'])) {
    $product_id = $wp->query_vars['wcfm-products-manage'];
    if ($product_id) {
        $booking_qty = max(absint(get_post_meta($product_id, '_wc_booking_qty', true)), 1);

        $min_date            = absint(get_post_meta($product_id, '_wc_booking_min_date', true));
        $min_date_unit       = get_post_meta($product_id, '_wc_booking_min_date_unit', true);
        $max_date            = max(absint(get_post_meta($product_id, '_wc_booking_max_date', true)), 1);
        $max_date_unit       = get_post_meta($product_id, '_wc_booking_max_date_unit', true);
        $has_restricted_days = get_post_meta($product_id, '_wc_booking_has_restricted_days', true) ? 'yes' : 'no';
        $restricted_days     = get_post_meta($product_id, '_wc_booking_restricted_days', true);
        if (! $restricted_days) {
            $restricted_days = [];
        }

        $availability_rules = get_post_meta($product_id, '_wc_booking_availability', true);

        if (! empty($availability_rules)) {
            foreach ($availability_rules as $a_index => $availability_rule) {
                $availability_rule_values[$a_index]         = $availability_default_rules;
                $availability_rule_values[$a_index]['type'] = $availability_rule['type'];
                if ($availability_rule['type'] == 'custom') {
                    $availability_rule_values[$a_index]['from_custom'] = $availability_rule['from'];
                    $availability_rule_values[$a_index]['to_custom']   = $availability_rule['to'];
                } else if ($availability_rule['type'] == 'months') {
                    $availability_rule_values[$a_index]['from_months'] = $availability_rule['from'];
                    $availability_rule_values[$a_index]['to_months']   = $availability_rule['to'];
                } else if ($availability_rule['type'] == 'weeks') {
                    $availability_rule_values[$a_index]['from_weeks'] = $availability_rule['from'];
                    $availability_rule_values[$a_index]['to_weeks']   = $availability_rule['to'];
                } else if ($availability_rule['type'] == 'days') {
                    $availability_rule_values[$a_index]['from_days'] = $availability_rule['from'];
                    $availability_rule_values[$a_index]['to_days']   = $availability_rule['to'];
                }

                $availability_rule_values[$a_index]['bookable'] = $availability_rule['bookable'];
                $availability_rule_values[$a_index]['priority'] = $availability_rule['priority'];
            }
        }//end if

        $booking_base_cost = get_post_meta($product_id, '_wc_booking_base_cost', true);
        $display_cost      = get_post_meta($product_id, '_wc_display_cost', true);

        $cost_rules = get_post_meta($product_id, '_wc_booking_pricing', true);

        if (! empty($cost_rules)) {
            foreach ($cost_rules as $a_index => $cost_rule) {
                $cost_rule_values[$a_index]         = $cost_default_rules;
                $cost_rule_values[$a_index]['type'] = $cost_rule['type'];
                if ($cost_rule['type'] == 'custom') {
                    $cost_rule_values[$a_index]['from_custom'] = $cost_rule['from'];
                    $cost_rule_values[$a_index]['to_custom']   = $cost_rule['to'];
                } else if ($cost_rule['type'] == 'months') {
                    $cost_rule_values[$a_index]['from_months'] = $cost_rule['from'];
                    $cost_rule_values[$a_index]['to_months']   = $cost_rule['to'];
                } else if ($cost_rule['type'] == 'weeks') {
                    $cost_rule_values[$a_index]['from_weeks'] = $cost_rule['from'];
                    $cost_rule_values[$a_index]['to_weeks']   = $cost_rule['to'];
                } else if ($cost_rule['type'] == 'days') {
                    $cost_rule_values[$a_index]['from_days'] = $cost_rule['from'];
                    $cost_rule_values[$a_index]['to_days']   = $cost_rule['to'];
                }

                if (isset($cost_rule['override_block'])) {
                    $cost_rule_values[$a_index]['override_block'] = $cost_rule['override_block'];
                } else if (isset($cost_rule['cost'])) {
                    if (! empty($cost_rule['modifier'])) {
                        if ('plus' == $cost_rule['modifier']) {
                            $cost_rule_values[$a_index]['override_block'] = ((float) $booking_base_cost + (float) $cost_rule['cost']);
                        } else {
                            $cost_rule_values[$a_index]['override_block'] = ((float) $booking_base_cost - (float) $cost_rule['cost']);
                        }
                    } else {
                        $cost_rule_values[$a_index]['override_block'] = (float) $cost_rule['cost'];
                    }
                } else {
                    $cost_rule_values[$a_index]['override_block'] = '';
                }
            }//end foreach
        }//end if
    }//end if
}//end if

?>

<!-- Collapsible Accommodation 2  -->
<div class="page_collapsible products_manage_accommodation_availability accommodation-booking" id="wcfm_products_manage_form_accommodation_availability_head"><label class="wcfmfa fa-clock"></label><?php _e('Availability', 'woocommerce-accommodation-bookings'); ?><span></span></div>
<div class="wcfm-container accommodation-booking">
    <div id="wcfm_products_manage_form_accommodation_availability_expander" class="wcfm-content">
        <?php
        $WCFM->wcfm_fields->wcfm_generate_form_field(
            apply_filters(
                'wcfm_wcaccommodation_availability_fields',
                [

                    '_wc_accommodation_booking_qty'                 => [
                        'label'       => __('Number of rooms available', 'woocommerce-accommodation-bookings'),
                        'type'        => 'number',
                        'class'       => 'wcfm-text wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'value'       => $booking_qty,
                        'hints'       => __('The maximum number of rooms available.', 'woocommerce-accommodation-bookings'),
                        'attributes'  => [
                            'min'  => '',
                            'step' => '1',
                        ],
                    ],
                    '_wc_accommodation_booking_min_date'            => [
                        'label'       => __('Bookings can be made starting', 'woocommerce-accommodation-bookings'),
                        'type'        => 'number',
                        'class'       => 'wcfm-text wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'value'       => $min_date,
                    ],
                    '_wc_accommodation_booking_min_date_unit'       => [
                        'type'        => 'select',
                        'options'     => [
                            'month'  => __('Month(s)', 'woocommerce-accommodation-bookings'),
                            'day'    => __('Day(s)', 'woocommerce-accommodation-bookings'),
                            'hour'   => __('Hour(s)', 'woocommerce-accommodation-bookings'),
                            'minute' => __('Minute(s)', 'woocommerce-accommodation-bookings'),
                        ],
                        'class'       => 'wcfm-select wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'value'       => $min_date_unit,
                        'desc_class'  => 'in_the_future',
                        'desc'        => __('in the future', 'woocommerce-bookings'),
                    ],
                    '_wc_accommodation_booking_max_date'            => [
                        'label'       => __('Bookings can only be made', 'woocommerce-accommodation-bookings'),
                        'type'        => 'number',
                        'class'       => 'wcfm-text wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'value'       => $max_date,
                    ],
                    '_wc_accommodation_booking_max_date_unit'       => [
                        'type'        => 'select',
                        'options'     => [
                            'month'  => __('Month(s)', 'woocommerce-accommodation-bookings'),
                            'day'    => __('Day(s)', 'woocommerce-accommodation-bookings'),
                            'hour'   => __('Hour(s)', 'woocommerce-accommodation-bookings'),
                            'minute' => __('Minute(s)', 'woocommerce-accommodation-bookings'),
                        ],
                        'class'       => 'wcfm-select wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'value'       => $max_date_unit,
                        'desc_class'  => 'in_the_future',
                        'desc'        => __('in the future', 'woocommerce-bookings'),
                    ],
                    '_wc_accommodation_booking_has_restricted_days' => [
                        'label'       => __('Restrict start days?', 'woocommerce-bookings'),
                        'type'        => 'checkbox',
                        'class'       => 'wcfm-checkbox wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title checkbox_title accommodation-booking',
                        'value'       => 'yes',
                        'dfvalue'     => $has_restricted_days,
                        'hints'       => __('Restrict bookings so that they can only start on certain days of the week. Does not affect availability.', 'woocommerce-bookings'),
                    ],
                    '_wc_accommodation_booking_restricted_days'     => [
                        'label'       => __('Restricted days', 'wc-frontend-manager-ultimate'),
                        'type'        => 'select',
                        'attributes'  => [
                            'multiple' => 'multiple',
                            'style'    => 'width: 60%;',
                        ],
                        'options'     => [
                            0 => __('Sunday', 'woocommerce-bookings'),
                            1 => __('Monday', 'woocommerce-bookings'),
                            2 => __('Tuesday', 'woocommerce-bookings'),
                            3 => __('Wednesday', 'woocommerce-bookings'),
                            4 => __('Thursday', 'woocommerce-bookings'),
                            5 => __('Friday', 'woocommerce-bookings'),
                            6 => __('Saturday', 'woocommerce-bookings'),
                        ],
                        'class'       => 'wcfm-select wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'value'       => $restricted_days,
                    ],
                    '_wc_accommodation_booking_availability_rules'  => [
                        'label'       => __('Rules', 'woocommerce-accommodation-bookings'),
                        'type'        => 'multiinput',
                        'class'       => 'wcfm-text wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'desc'        => __('Rules with lower priority numbers will override rules with a higher priority (e.g. 9 overrides 10 ). Ordering is only applied within the same priority and higher order overrides lower order.', 'woocommerce-accommodation-bookings'),
                        'desc_class'  => 'avail_rules_desc',
                        'value'       => $availability_rule_values,
                        'options'     => [
                            'type'        => [
                                'label'       => __('Type', 'wc-frontend-manager-ultimate'),
                                'type'        => 'select',
                                'options'     => $range_types,
                                'class'       => 'wcfm-select wcfm_ele avail_range_type accommodation-booking',
                                'label_class' => 'wcfm_title avail_rules_ele avail_rules_label accommodation-booking',
                            ],
                            'from_custom' => [
                                'label'             => __('From', 'wc-frontend-manager-ultimate'),
                                'type'              => 'text',
                                'placeholder'       => 'YYYY-MM-DD',
                                'custom_attributes' => [ 'date_format' => 'yy-mm-dd' ],
                                'class'             => 'wcfm-text wcfm_datepicker avail_rule_field avail_rule_custom avail_rules_ele avail_rules_text',
                                'label_class'       => 'wcfm_title avail_rule_field avail_rule_custom avail_rules_ele avail_rules_label',
                            ],
                            'to_custom'   => [
                                'label'             => __('To', 'wc-frontend-manager-ultimate'),
                                'type'              => 'text',
                                'placeholder'       => 'YYYY-MM-DD',
                                'custom_attributes' => [ 'date_format' => 'yy-mm-dd' ],
                                'class'             => 'wcfm-text wcfm_datepicker avail_rule_field avail_rule_custom avail_rules_ele avail_rules_text',
                                'label_class'       => 'wcfm_title avail_rule_field avail_rule_custom avail_rules_ele avail_rules_label',
                            ],
                            'from_months' => [
                                'label'       => __('From', 'wc-frontend-manager-ultimate'),
                                'type'        => 'select',
                                'options'     => $intervals['months'],
                                'class'       => 'wcfm-select avail_rule_field avail_rule_months avail_rules_ele avail_rules_text',
                                'label_class' => 'wcfm_title avail_rule_field avail_rule_months avail_rules_ele avail_rules_label',
                            ],
                            'to_months'   => [
                                'label'       => __('To', 'wc-frontend-manager-ultimate'),
                                'type'        => 'select',
                                'options'     => $intervals['months'],
                                'class'       => 'wcfm-select avail_rule_field avail_rule_months avail_rules_ele avail_rules_text',
                                'label_class' => 'wcfm_title avail_rule_field avail_rule_months avail_rules_ele avail_rules_label',
                            ],
                            'from_weeks'  => [
                                'label'       => __('From', 'wc-frontend-manager-ultimate'),
                                'type'        => 'select',
                                'options'     => $intervals['weeks'],
                                'class'       => 'wcfm-select avail_rule_field avail_rule_weeks avail_rules_ele avail_rules_text',
                                'label_class' => 'wcfm_title avail_rule_field avail_rule_weeks avail_rules_ele avail_rules_label',
                            ],
                            'to_weeks'    => [
                                'label'       => __('To', 'wc-frontend-manager-ultimate'),
                                'type'        => 'select',
                                'options'     => $intervals['weeks'],
                                'class'       => 'wcfm-select avail_rule_field avail_rule_weeks avail_rules_ele avail_rules_text',
                                'label_class' => 'wcfm_title avail_rule_field avail_rule_weeks avail_rules_ele avail_rules_label',
                            ],
                            'from_days'   => [
                                'label'       => __('From', 'wc-frontend-manager-ultimate'),
                                'type'        => 'select',
                                'options'     => $intervals['days'],
                                'class'       => 'wcfm-select avail_rule_field avail_rule_days avail_rules_ele avail_rules_text',
                                'label_class' => 'wcfm_title avail_rule_field avail_rule_days avail_rules_ele avail_rules_label',
                            ],
                            'to_days'     => [
                                'label'       => __('To', 'wc-frontend-manager-ultimate'),
                                'type'        => 'select',
                                'options'     => $intervals['days'],
                                'class'       => 'wcfm-select avail_rule_field avail_rule_days avail_rules_ele avail_rules_text',
                                'label_class' => 'wcfm_title avail_rule_field avail_rule_days avail_rules_ele avail_rules_label',
                            ],
                            'bookable'    => [
                                'label'       => __('Bookable', 'woocommerce-accommodation-bookings'),
                                'type'        => 'select',
                                'options'     => [
                                    'no'  => 'NO',
                                    'yes' => 'YES',
                                ],
                                'class'       => 'wcfm-select wcfm_ele avail_rules_ele avail_rules_text accommodation-booking',
                                'label_class' => 'wcfm_title avail_rules_ele avail_rules_label',
                                'hints'       => __('If not bookable, users won\'t be able to choose this block for their booking.', 'woocommerce-accommodation-bookings'),
                            ],
                            'priority'    => [
                                'label'       => __('Priority', 'woocommerce-accommodation-bookings'),
                                'type'        => 'number',
                                'class'       => 'wcfm-text wcfm_ele avail_rules_ele avail_rule_priority avail_rules_text accommodation-booking',
                                'label_class' => 'wcfm_title avail_rules_ele avail_rules_label accommodation-booking',
                                'hints'       => esc_attr(get_wc_booking_priority_explanation()),
                            ],
                        ],
                    ],
                ],
                $product_id
            )
        );
        ?>
    </div>
</div>
<!-- end collapsible Accommodation -->
<div class="wcfm_clearfix"></div>

<!-- Collapsible Accommodation 3  -->
<div class="page_collapsible products_manage_accommodation_costs accommodation-booking" id="wcfm_products_manage_form_accommodation_costs_head"><label class="wcfmfa fa-currency"><?php echo get_woocommerce_currency_symbol(); ?></label><?php _e('Rates', 'woocommerce-accommodation-bookings'); ?><span></span></div>
<div class="wcfm-container accommodation-booking">
    <div id="wcfm_products_manage_form_accommodation_costs_expander" class="wcfm-content">
        <?php
        $WCFM->wcfm_fields->wcfm_generate_form_field(
            apply_filters(
                'wcfm_wcaccommodation_cost_fields',
                [

                    '_wc_accommodation_booking_base_cost'    => [
                        'label'       => __('Standard room rate', 'woocommerce-accommodation-bookings'),
                        'type'        => 'number',
                        'class'       => 'wcfm-text wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'value'       => $booking_base_cost,
                        'hints'       => __('Standard cost for booking the room.', 'woocommerce-accommodation-bookings'),
                        'attributes'  => [
                            'min'  => '',
                            'step' => '0.01',
                        ],
                    ],
                    '_wc_accommodation_booking_display_cost' => [
                        'label'       => __('Display cost', 'woocommerce-accommodation-bookings'),
                        'type'        => 'number',
                        'class'       => 'wcfm-text wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'value'       => $display_cost,
                        'hints'       => __('The cost is displayed to the user on the frontend. Leave blank to have it calculated for you. If a booking has varying costs, this will be prefixed with the word `from:`.', 'woocommerce-accommodation-bookings'),
                        'attributes'  => [
                            'min'  => '',
                            'step' => '0.01',
                        ],
                    ],
                    '_wc_accommodation_booking_cost_rules'   => [
                        'label'       => __('Rules', 'woocommerce-accommodation-bookings'),
                        'type'        => 'multiinput',
                        'class'       => 'wcfm-text wcfm_ele accommodation-booking',
                        'label_class' => 'wcfm_title accommodation-booking',
                        'value'       => $cost_rule_values,
                        'options'     => [
                            'type'           => [
                                'label'       => __('Type', 'wc-frontend-manager-ultimate'),
                                'type'        => 'select',
                                'options'     => $cost_range_types,
                                'class'       => 'wcfm-select wcfm_ele cost_range_type accommodation-booking',
                                'label_class' => 'wcfm_title cost_rules_ele cost_rules_label accommodation-booking',
                            ],
                            'from_custom'    => [
                                'label'             => __('Starting', 'woocommerce-accommodation-bookings'),
                                'type'              => 'text',
                                'placeholder'       => 'YYYY-MM-DD',
                                'custom_attributes' => [ 'date_format' => 'yy-mm-dd' ],
                                'class'             => 'wcfm-text wcfm_datepicker cost_rule_field cost_rule_custom cost_rules_ele cost_rules_text',
                                'label_class'       => 'wcfm_title cost_rule_field cost_rule_custom cost_rules_ele cost_rules_label',
                            ],
                            'to_custom'      => [
                                'label'             => __('Ending', 'woocommerce-accommodation-bookings'),
                                'type'              => 'text',
                                'placeholder'       => 'YYYY-MM-DD',
                                'custom_attributes' => [ 'date_format' => 'yy-mm-dd' ],
                                'class'             => 'wcfm-text wcfm_datepicker cost_rule_field cost_rule_custom cost_rules_ele cost_rules_text',
                                'label_class'       => 'wcfm_title cost_rule_field cost_rule_custom cost_rules_ele cost_rules_label',
                            ],
                            'from_months'    => [
                                'label'       => __('Starting', 'woocommerce-accommodation-bookings'),
                                'type'        => 'select',
                                'options'     => $intervals['months'],
                                'class'       => 'wcfm-select cost_rule_field cost_rule_months cost_rules_ele cost_rules_text',
                                'label_class' => 'wcfm_title cost_rule_field cost_rule_months cost_rules_ele cost_rules_label',
                            ],
                            'to_months'      => [
                                'label'       => __('Ending', 'woocommerce-accommodation-bookings'),
                                'type'        => 'select',
                                'options'     => $intervals['months'],
                                'class'       => 'wcfm-select cost_rule_field cost_rule_months cost_rules_ele cost_rules_text',
                                'label_class' => 'wcfm_title cost_rule_field cost_rule_months cost_rules_ele cost_rules_label',
                            ],
                            'from_weeks'     => [
                                'label'       => __('Starting', 'woocommerce-accommodation-bookings'),
                                'type'        => 'select',
                                'options'     => $intervals['weeks'],
                                'class'       => 'wcfm-select cost_rule_field cost_rule_weeks cost_rules_ele cost_rules_text',
                                'label_class' => 'wcfm_title cost_rule_field cost_rule_weeks cost_rules_ele cost_rules_label',
                            ],
                            'to_weeks'       => [
                                'label'       => __('Ending', 'woocommerce-accommodation-bookings'),
                                'type'        => 'select',
                                'options'     => $intervals['weeks'],
                                'class'       => 'wcfm-select cost_rule_field cost_rule_weeks cost_rules_ele cost_rules_text',
                                'label_class' => 'wcfm_title cost_rule_field cost_rule_weeks cost_rules_ele cost_rules_label',
                            ],
                            'from_days'      => [
                                'label'       => __('Starting', 'woocommerce-accommodation-bookings'),
                                'type'        => 'select',
                                'options'     => $intervals['days'],
                                'class'       => 'wcfm-select cost_rule_field cost_rule_days cost_rules_ele cost_rules_text',
                                'label_class' => 'wcfm_title cost_rule_field cost_rule_days cost_rules_ele cost_rules_label',
                            ],
                            'to_days'        => [
                                'label'       => __('Ending', 'woocommerce-accommodation-bookings'),
                                'type'        => 'select',
                                'options'     => $intervals['days'],
                                'class'       => 'wcfm-select cost_rule_field cost_rule_days cost_rules_ele cost_rules_text',
                                'label_class' => 'wcfm_title cost_rule_field cost_rule_days cost_rules_ele cost_rules_label',
                            ],
                            'override_block' => [
                                'label'       => __('Cost', 'woocommerce-accommodation-bookings'),
                                'type'        => 'number',
                                'class'       => 'wcfm-text wcfm_ele cost_rules_ele cost_rules_text accommodation-booking',
                                'label_class' => 'wcfm_title cost_rules_ele cost_rules_label',
                                'hints'       => __('Cost for this time period.', 'woocommerce-accommodation-bookings'),
                            ],
                        ],
                    ],
                ],
                $product_id
            )
        );
        ?>
    </div>
</div>
<!-- end collapsible Accommodation -->
<div class="wcfm_clearfix"></div>
