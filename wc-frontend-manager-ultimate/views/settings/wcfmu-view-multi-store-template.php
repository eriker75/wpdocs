<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('WCFM')) return; // Exit if WCFM not installed

global $WCFM, $WCFMmp, $wp;

$branch_data = array();
if (isset($_POST['data']) && is_array($_POST['data'])) {
    $branch_data = $_POST['data'];
}
$vendor_id = 0;
if (wcfm_is_vendor()) {
    $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
} elseif (!empty($branch_data['store_id'])) {
    $vendor_id = absint($branch_data['store_id']); // for admin
}

if (!$vendor_id) {
    wp_send_json_error(esc_html__('No vendor found.', 'wc-frontend-manager-ultimate'));
}

// Default Location
$default_geolocation = isset($WCFMmp->wcfmmp_marketplace_options['default_geolocation']) ? $WCFMmp->wcfmmp_marketplace_options['default_geolocation'] : array();
$default_lat         = isset($default_geolocation['lat']) ? esc_attr($default_geolocation['lat']) : apply_filters('wcfmmp_map_default_lat', 30.0599153);
$default_lng         = isset($default_geolocation['lng']) ? esc_attr($default_geolocation['lng']) : apply_filters('wcfmmp_map_default_lng', 31.2620199);

$branch_id   = $branch_data['ID'] ?? '';
$branch_name = $branch_data['name'] ?? '';
$street_1    = $branch_data['address'] ?? '';
$street_2    = $branch_data['address2'] ?? '';
$city        = $branch_data['city'] ?? '';
$zip         = $branch_data['postal_code'] ?? '';
$country     = $branch_data['country'] ?? '';
$state       = $branch_data['state'] ?? '';

$map_address = $branch_data['map_address'] ?? '';
$latitude    = $branch_data['latitude'] ?? $default_lat;
$longitude   = $branch_data['longitude'] ?? $default_lng;

// GEO Locate Support
if (!$country) {
    $user_location = get_user_meta($vendor_id, 'wcfm_user_location', true);
    if ($user_location) {
        $country = $user_location['country'];
        $state   = $user_location['state'];
        $city    = $user_location['city'];
    }
}

if (apply_filters('wcfm_is_allow_wc_geolocate', true) && class_exists('WC_Geolocation') && !$country) {
    $user_location = WC_Geolocation::geolocate_ip();
    $country       = $user_location['country'];
    $state         = $user_location['state'];
}

// Country -> States
$country_obj   = new WC_Countries();
$countries     = $country_obj->countries;
$states        = $country_obj->states;
$state_options = array();
if ($state && isset($states[$country]) && is_array($states[$country])) {
    $state_options = $states[$country];
}
?>
<div class="branch-header-wrap" style="margin-bottom: 10px;">
    <a class="back" href="#">&larr; <?php _e('Back to branch list', 'wc-frontend-manager-ultimate'); ?></a>
    <?php $label = ($branch_id) ? __('Update branch', 'wc-frontend-manager-ultimate') : __('Add branch', 'wc-frontend-manager-ultimate'); ?>
    <a class="add_new_wcfm_ele_dashboard submit text_tip" href="#" data-tip="<?php echo $label; ?>"><span class="wcfmfa fa-map-marker-alt"></span><span class="text"><?php echo $label; ?></span></a>
</div>
<div class="wcfm_clearfix"></div><br /><br />
<?php
$WCFM->wcfm_fields->wcfm_generate_form_field(
    array(
        "branch_id"   => array('type' => 'hidden', 'name' => 'branch_id', 'class' => 'wcfm_branch_field', 'value' => $branch_id),
        "vendor_id"   => array('type' => 'hidden', 'name' => 'store_id', 'class' => 'wcfm_branch_field', 'value' => $vendor_id),
    )
);
$WCFM->wcfm_fields->wcfm_generate_form_field(
    apply_filters('wcfm_marketplace_settings_fields_branch_details', array(
        "branch_name" => array('label' => __('Branch Name', 'wc-frontend-manager-ultimate'), 'placeholder' => __('Type an address to find', 'wc-frontend-manager'), 'name' => 'branch_name', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele wcfm_branch_field', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $branch_name),
    ), $vendor_id, $branch_id)
);
?>
<div class="wcfm_clearfix"></div>
<h2><?php _e('Branch address', 'wc-frontend-manager-ultimate'); ?></h2>
<div class="wcfm_clearfix"></div>
<?php
$WCFM->wcfm_fields->wcfm_generate_form_field(
    apply_filters('wcfm_marketplace_settings_fields_branch_address', array(
        "b_street_1"    => array('label' => __('Street', 'wc-frontend-manager'), 'placeholder' => __('Street address', 'wc-frontend-manager'), 'name' => 'branch_street_1', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele wcfm_branch_field', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $street_1),
        "b_street_2"    => array('label' => __('Street 2', 'wc-frontend-manager'), 'placeholder' => __('Apartment, suite, unit etc. (optional)', 'wc-frontend-manager'), 'name' => 'branch_street_2', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele wcfm_branch_field', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $street_2),
        "b_city"        => array('label' => __('City/Town', 'wc-frontend-manager'), 'placeholder' => __('Town / City', 'wc-frontend-manager'), 'name' => 'branch_city', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele wcfm_branch_field', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $city),
        "b_zip"         => array('label' => __('Postcode/Zip', 'wc-frontend-manager'), 'placeholder' => __('Postcode / Zip', 'wc-frontend-manager'), 'name' => 'branch_zip', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele wcfm_branch_field', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $zip),
        "b_country"     => array('label' => __('Country', 'wc-frontend-manager'), 'name' => 'branch_country', 'type' => 'country', 'class' => 'wcfm-select wcfm_ele wcfm_branch_field', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $country),
        "b_state"       => array('label' => __('State/County', 'wc-frontend-manager'), 'name' => 'branch_state', 'type' => 'select', 'class' => 'wcfm-select wcfm_ele wcfm_branch_field', 'label_class' => 'wcfm_title wcfm_ele', 'options' => $state_options, 'value' => $state),
    ), $vendor_id, $branch_id)
);
?>
<h2><?php _e('Map location', 'wc-frontend-manager-ultimate'); ?></h2>
<div class="wcfm_clearfix"></div>
<div class="wcfm-branch-geolocation-wrapper">
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters('wcfm_marketplace_settings_fields_branch_map_location', array(
            "branch_find_address" => array('label' => __('Find Location', 'wc-frontend-manager'), 'placeholder' => __('Type an address to find', 'wc-frontend-manager'), 'name' => 'branch_find_address', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele wcfm_branch_field', 'label_class' => 'wcfm_title wcfm_ele', 'value' => $map_address),
            "branch_map_address"  => array('type' => 'hidden', 'name' => 'branch_map_address', 'class' => 'wcfm_branch_field', 'value' => $map_address),
            "store_branch_lat"    => array('type' => 'hidden', 'name' => 'branch_store_lat', 'class' => 'wcfm_branch_field', 'value' => $latitude),
            "store_branch_lng"    => array('type' => 'hidden', 'name' => 'branch_store_lng', 'class' => 'wcfm_branch_field', 'value' => $longitude),
        ), $vendor_id, $branch_id)
    );
    ?>
    <i class="wcfmfa fa-crosshairs wcfm-current-location"></i>
</div>
<div class="wcfm_clearfix"></div><br />
<div class="wcfm-marketplace-branch-map" id="wcfm-marketplace-branch-map"></div>
<div class="wcfm_clearfix"></div><br /><br />
<div class="branch-header-wrap" style="margin-bottom: 10px;">
    <a class="back" href="#">&larr; <?php _e('Back to branch list', 'wc-frontend-manager-ultimate'); ?></a>
    <?php $label = ($branch_id) ? __('Update branch', 'wc-frontend-manager-ultimate') : __('Add branch', 'wc-frontend-manager-ultimate'); ?>
    <a class="add_new_wcfm_ele_dashboard submit text_tip" href="#" data-tip="<?php echo $label; ?>"><span class="wcfmfa fa-map-marker-alt"></span><span class="text"><?php echo $label; ?></span></a>
</div>