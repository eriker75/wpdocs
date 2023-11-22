<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('WCFM')) return; // Exit if WCFM not installed

global $wpdb, $WCFM, $WCFMu;

if (apply_filters('wcfm_is_allow_store_address', true)) {
    $branches_query = "SELECT * FROM {$wpdb->prefix}wcfm_store_locations WHERE store_id = %d";
    $branch_list    = $wpdb->get_results($wpdb->prepare($branches_query, $user_id), ARRAY_A);
    $branch_meta_query = "SELECT branch_id FROM {$wpdb->prefix}wcfm_store_locations_meta WHERE store_id = %d AND meta_key = %s AND meta_value = %s";
    $main_branch_id = $wpdb->get_var($wpdb->prepare($branch_meta_query, $user_id, 'is_main_branch', 1));
    $is_allowed_shipping = false;
    $is_allowed_pickup = false;
    $shipping_branch_list = [];
    $pickup_branch_list = [];
    if (apply_filters('wcfm_is_allow_store_shipping', true)) {
        $wcfm_shipping_options = get_option( 'wcfm_shipping_options', array() );
        $wcfmmp_store_shipping_enabled = isset( $wcfm_shipping_options['enable_store_shipping'] ) ? $wcfm_shipping_options['enable_store_shipping'] : 'yes';
        if( $wcfmmp_store_shipping_enabled == 'yes' ) {
            $is_allowed_shipping = apply_filters('wcfm_is_allow_individual_branch_shipping', true);
            $shipping_branch_list = $wpdb->get_col($wpdb->prepare($branch_meta_query, $user_id, 'offers_shipping', 1));
            $is_allowed_pickup = apply_filters('wcfm_is_allow_individual_branch_pickup', true);
            $pickup_branch_list = $wpdb->get_col($wpdb->prepare($branch_meta_query, $user_id, 'offers_pickup', 1));
        }
    }
    ?>
    <div class="page_collapsible" id="wcfm_settings_multi_location_head">
        <label class="wcfmfa fa-globe"></label>
        <?php _e('Location', 'wc-frontend-manager'); ?><span></span>
    </div>
    <div class="wcfm-container wcfm_marketplace_store_multi_location_settings">
        <div id="wcfm_settings_form_store_multi_location_expander" class="wcfm-content">
            <div class="wcfm_clearfix"></div>
            <div class="wcfm_vendor_settings_heading">
                <h2><?php _e('Branch Locations', 'wc-frontend-manager-ultimate'); ?></h2>
                <a id="wcfm_add_branch" class="add_new_wcfm_ele_dashboard text_tip" href="#" data-vendor-id="<?php esc_attr_e($user_id);?>" data-tip="<?php esc_attr_e('Add branch', 'wc-frontend-manager-ultimate');?>"><span class="wcfmfa fa-map-marker-alt"></span><span class="text"><?php _e('New Branch', 'wc-frontend-manager-ultimate'); ?></span></a>
            </div>
            <div class="wcfm_clearfix"></div>
            <div class="branch_address branch_address_wrap">
                <div id="wcfmmp_settings_branch_list" class="wcfm-content wcfm-vendor-branch-container">
                    <table class="wcfmmp-table store-locations-table" data-vendor-id="<?php esc_attr_e($user_id);?>">
                        <thead>
                            <tr>
                                <th style="width:20%"><?php _e('Branch Name', 'wc-frontend-manager-ultimate'); ?></th>
                                <th style="width:5%"><span title="<?php esc_attr_e('Main branch', 'wc-frontend-manager-ultimate');?>">&#9733;</span></th>
                                <?php if ($is_allowed_shipping) { ?>
                                <th style="width:5%"><span title="<?php esc_attr_e('Shipping', 'wc-frontend-manager-ultimate');?>"><i class="wcfmfa fa-truck"></i></span></th>
                                <?php } ?>
                                <?php if ($is_allowed_pickup) { ?>
                                <th style="width:5%"><span title="<?php esc_attr_e('Pickup', 'wc-frontend-manager-ultimate');?>"><i class="wcfmfa fa-store"></i></span></th>
                                <?php } ?>
                                <th><?php _e('Address', 'wc-frontend-manager'); ?></th>
                                <th style="width:15%"><?php _e('Actions', 'wc-frontend-manager'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($branch_list)) {
                                foreach ($branch_list as $key => $branch_location) { 
                                    $branch_location = array_map('stripslashes_deep', $branch_location);
                                    ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($branch_location['name'])) {
                                                _e($branch_location['name'], 'wc-frontend-manager-ultimate');
                                            } else {
                                                _e('[BRANCH NAME]', 'wc-frontend-manager-ultimate');
                                            } ?>
                                        </td>
                                        <td>
                                            <a href="#" class="mark-main-branch <?php if ($main_branch_id == $branch_location['ID']) echo 'main-branch'; ?>" data-branch-id="<?php echo esc_attr($branch_location['ID']); ?>" title="<?php esc_attr_e('Mark this as main branch', 'wc-frontend-manager-ultimate');?>">
                                                <?php if ($main_branch_id == $branch_location['ID']) echo '&#9733;';
                                                else echo '&#9734;'; ?>
                                            </a>
                                        </td>
                                        <?php if ($is_allowed_shipping) { ?>
                                        <td>
                                            <input type="checkbox" class="wcfm-checkbox branch-offers-shipping input-checkbox" value="<?php echo esc_attr($branch_location['ID']); ?>" title="<?php esc_attr_e( 'branch offers shipping', "wc-frontend-manager-ultimate" )?>" <?php if(in_array($branch_location['ID'], $shipping_branch_list)) echo 'checked'; ?>>
                                        </td>
                                        <?php } ?>
                                        <?php if ($is_allowed_pickup) { ?>
                                        <td>
                                            <input type="checkbox" class="wcfm-checkbox branch-offers-pickup input-checkbox" value="<?php echo esc_attr($branch_location['ID']); ?>" title="<?php esc_attr_e( 'branch offers pickup', "wc-frontend-manager-ultimate" )?>" <?php if(in_array($branch_location['ID'], $pickup_branch_list)) echo 'checked'; ?>>
                                        </td>
                                        <?php } ?>
                                        <td>
                                            <?php _e($WCFMu->wcfmu_multi_store->formatted_store_address($branch_location), 'wc-frontend-manager-ultimate'); ?>
                                        </td>
                                        <td>
                                            <a class="wcfm-action-icon wcfm_store_branch_edit" href="#" data-branch="<?php echo esc_attr(json_encode($branch_location)); ?>"><span class="wcfmfa fa-edit text_tip" data-tip="<?php esc_attr_e('Edit', 'wc-frontend-manager-ultimate'); ?>"></span></a>
                                            <a class="wcfm-action-icon wcfm_store_branch_delete" href="#" data-branch-id="<?php echo esc_attr($branch_location['ID']); ?>"><span class="wcfmfa fa-trash-alt text_tip" data-tip="<?php esc_attr_e('Delete', 'wc-frontend-manager-ultimate'); ?>"></span></a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            <?php } else { ?>
                                <tr>
                                    <td colspan="3">
                                        <?php _e('No branch found.', 'wc-frontend-manager-ultimate') ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div id="vendor_edit_branch"></div>
                </div>
            </div>
            <?php if(!wcfm_is_vendor()) {?>
            <div class="wcfm-message" tabindex="-1" style="display: none;"></div>
            <?php } ?>
        </div>
    </div>
    <div class="wcfm_clearfix"></div>
<?php }