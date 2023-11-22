<?php
/**
 * WCFMu plugin core
 *
 * Plugin Vendor Badges Controler
 *
 * @author  WC Lovers
 * @package wcfmu/core
 * @version 3.5.3
 */

class WCFMu_Vendor_Badges
{

    public $wcfm_vendor_badges_options = [];


    public function __construct()
    {
        global $WCFM, $WCFMu;

        $this->wcfm_vendor_badges_options = get_option('wcfm_vendor_badges_options', []);

        // Badges Settings
        add_action('end_wcfm_settings', [ &$this, 'wcfmu_vendor_badges_settings' ], 17);
        add_action('wcfm_settings_update', [ &$this, 'wcfmu_vendor_badges_settings_update' ], 17);

        // Membership Badges Association
        add_action('wcfm_membership_badges', [ &$this, 'wcfmu_membership_badges_manage' ]);
        add_action('wcfm_memberships_manage_from_process', [ &$this, 'wcfmu_membership_badges_update' ], 10, 2);

        // Vendor Manager Badges Assign
        add_action('after_wcfm_vendor_membership_details', [ &$this, 'wcfmu_vendor_badges_manage' ]);

        // Show Badges with Membership Description
        add_action('after_wcfm_membership_description_content', [ &$this, 'show_wcfm_membership_badges' ]);

        // Show verified seller badge
        add_filter('wcfm_dashboard_after_username', [ &$this, 'after_wcfm_dashboard_user' ], 11);

        if ($WCFMu->is_marketplace == 'wcmarketplace') {
            add_action('before_wcmp_vendor_information', [ &$this, 'before_wcmp_vendor_information' ], 15);
            add_action('after_sold_by_text_shop_page', [ &$this, 'after_sold_by_text_shop_page' ], 15);
            // add_action( 'woocommerce_after_shop_loop_item', array( &$this, 'template_loop_seller_badges' ), 90 );
            add_action('after_wcmp_singleproductmultivendor_vendor_name', [ &$this, 'wcmp_singleproductmultivendor_table_name' ], 15, 2);
        } else if ($WCFMu->is_marketplace == 'wcvendors') {
            if (version_compare(WCV_VERSION, '2.0.0', '<')) {
                if (WC_Vendors::$pv_options->get_option('sold_by')) {
                    add_action('woocommerce_after_shop_loop_item', [ &$this, 'template_loop_seller_badges' ], 9);
                }
            } else {
                if (get_option('wcvendors_display_label_sold_by_enable')) {
                    add_action('woocommerce_after_shop_loop_item', [ &$this, 'template_loop_seller_badges' ], 9);
                }
            }

            // add_filter( 'wcvendors_cart_sold_by', array( &$this, 'after_wcv_cart_sold_by' ), 15, 3 );
            add_filter('wcvendors_cart_sold_by_meta', [ &$this, 'after_wcv_cart_sold_by' ], 15, 3);
            if (WCFM_Dependencies::wcvpro_plugin_active_check()) {
                add_action('wcv_after_vendor_store_title', [ &$this, 'after_wcv_pro_store_header' ], 15);
            } else {
                add_action('wcv_after_main_header', [ &$this, 'after_wcv_store_header' ], 15);
                add_action('wcv_after_mini_header', [ &$this, 'after_wcv_store_header' ], 15);
            }
        } else if ($WCFMu->is_marketplace == 'wcpvendors') {
            add_filter('wcpv_sold_by_link_name', [ &$this, 'wcpv_sold_by_link_name_seller_badges' ], 15, 3);
        } else if ($WCFMu->is_marketplace == 'dokan') {
            add_action('dokan_store_header_info_fields', [ &$this, 'after_dokan_store_header' ], 15);
            // add_filter( 'woocommerce_product_tabs', array( &$this, 'dokan_product_tab_seller_badges' ), 9 );
        } else if ($WCFMu->is_marketplace == 'wcfmmarketplace') {
            add_action('wcfmmp_single_product_sold_by_badges', [ &$this, 'after_wcfmmp_sold_by_label_product_page' ], 15);
            // add_action( 'after_wcfmmp_sold_by_label_product_page', array( &$this, 'after_wcfmmp_sold_by_label_product_page'), 15 );
            add_action('wcfmmp_store_mobile_badges', [ &$this, 'after_wcfmmp_sold_by_label_product_page' ], 15);
            add_action('wcfmmp_store_desktop_badges', [ &$this, 'after_wcfmmp_sold_by_label_product_page' ], 15);
            add_action('after_wcfmmp_store_list_rating', [ &$this, 'after_wcfmmp_sold_by_label_product_page' ], 15);
            // add_action( 'after_wcmp_singleproductmultivendor_vendor_name', array( &$this, 'wcmp_singleproductmultivendor_table_name' ), 15, 2 );
        }//end if

        // Conditional badges
        add_action('after_wcfm_vendor_badges', [ &$this, 'show_conditional_badges' ], 10, 2);

    }//end __construct()


    function wcfmu_vendor_badges_settings($wcfm_options)
    {
        global $WCFM, $WCFMu;
        $wcfm_vendor_badges_options    = get_option('wcfm_vendor_badges_options', []);
        $wcfm_conditional_badges_rules = get_option('wcfm_conditional_badges_rules', []);
        ?>
        <!-- collapsible -->
        <div class="page_collapsible" id="wcfm_settings_form_vendor_badges_head">
            <label class="wcfmfa fa-certificate"></label>
            <?php echo apply_filters('wcfm_sold_by_label', '', __('Vendor', 'wc-frontend-manager')).' '.__('Badges', 'wc-frontend-manager-ultimate'); ?><span></span>
        </div>
        <div class="wcfm-container">
            <div id="wcfm_settings_form_vendor_badges_expander" class="wcfm-content">
                <!-- Conditional badges settings start -->
                <h2><?php echo apply_filters('wcfm_conditional_badges_settings_label', __('Conditional Badges Settings', 'wc-frontend-manager-ultimate')); ?></h2>
                <div class="wcfm_clearfix"></div>
                <?php
                $WCFM->wcfm_fields->wcfm_generate_form_field(
                    apply_filters(
                        'wcfm_conditional_badges_settings_fields',
                        [
                            'wcfm_conditional_badges_rules' => [
                                'label'       => __('Conditional Badges Rule(s)', 'wc-frontend-manager-ultimate'),
                                'type'        => 'multiinput',
                                'class'       => 'wcfm-text wcfm_ele',
                                'label_class' => 'wcfm_title wcfm_ele wcfm_full_title',
                                'desc_class'  => 'instructions',
                                'value'       => $wcfm_conditional_badges_rules,
                                'desc'        => __('You may define any number of such rules. Please be sure, do not set conflicting rules.', 'wc-frontend-manager-ultimate'),
                                'options'     => [
                                    'is_active'  => [
                                        'label'       => __('Enable', 'wc-frontend-manager-ultimate'),
                                        'type'        => 'checkbox',
                                        'class'       => 'wcfm-checkbox wcfm_ele',
                                        'label_class' => 'wcfm_title checkbox_title wcfm_ele',
                                        'value'       => 'yes',
                                    ],
                                    'mode'       => [
                                        'label'       => __('Mode', 'wc-frontend-manager-ultimate'),
                                        'type'        => 'select',
                                        'options'     => get_conditional_badges_modes(),
                                        'class'       => 'wcfm-select wcfm_ele conditional_badges_mode',
                                        'label_class' => 'wcfm_title wcfm_ele',
                                        'value'       => '',
                                    ],
                                    'rule'       => [
                                        'label'       => __('Rule', 'wc-frontend-manager-ultimate'),
                                        'type'        => 'select',
                                        'class'       => 'wcfm-select wcfm_ele',
                                        'label_class' => 'wcfm_title wcfm_ele',
                                        'options'     => [
                                            'upto'    => __('Up to', 'wc-frontend-manager-ultimate'),
                                            'greater' => __('More than', 'wc-frontend-manager-ultimate'),
                                        ],
                                    ],
                                    'value'      => [
                                        'label'       => __('Value', 'wc-frontend-manager-ultimate'),
                                        'type'        => 'number',
                                        'class'       => 'wcfm-text wcfm_ele wcfm_non_negative_input',
                                        'label_class' => 'wcfm_title wcfm_non_negative_input wcfm_ele',
                                        'attributes'  => [
                                            'min'  => '1',
                                            'step' => '1',
                                        ],
                                    ],
                                    'badge_icon' => [
                                        'label'       => __('Badge Icon', 'wc-frontend-manager-ultimate'),
                                        'type'        => 'upload',
                                        'class'       => 'wcfm_ele',
                                        'prwidth'     => 64,
                                        'label_class' => 'wcfm_title wcfm_ele',
                                        'hints'       => __('Upload badge image 32x32 size for best view.', ''),
                                    ],
                                    'badge_name' => [
                                        'label'       => __('Badge Name', 'wc-frontend-manager-ultimate'),
                                        'type'        => 'text',
                                        'class'       => 'wcfm-text wcfm_ele',
                                        'label_class' => 'wcfm_title wcfm_ele',
                                        'hints'       => __('Name of the badge visible as tooltip.', 'wc-frontend-manager-ultimate'),
                                    ],
                                ],
                            ],
                        ]
                    )
                );
                ?>
                <!-- Conditional badges settings end -->
                
              <h2><?php echo apply_filters('wcfm_sold_by_label', '', __('Vendor', 'wc-frontend-manager')).' '.__('Badges', 'wc-frontend-manager-ultimate'); ?></h2>
                <?php wcfm_video_tutorial('https://wclovers.com/knowledgebase/wcfm-vendor-badges/'); ?>
                <div class="wcfm_clearfix"></div>
                <?php
                $WCFM->wcfm_fields->wcfm_generate_form_field(
                    apply_filters(
                        'wcfmu_settings_fields_vendor_badges',
                        [
                            'wcfm_vendor_badges_options' => [
                                'label'       => __('Badges', 'wc-frontend-manager-ultimate'),
                                'type'        => 'multiinput',
                                'class'       => 'wcfm-text wcfm_ele',
                                'label_class' => 'wcfm_title',
                                'value'       => $wcfm_vendor_badges_options,
                                // translators: 1) badges url
                                'desc'        => sprintf(__('You may create any type of custom badges for your vendors. <a target="_blank" href="%s">Know more.</a>', 'wc-frontend-manager-ultimate'), 'https://wclovers.com/knowledgebase/wcfm-vendor-badges/'),
                                'options'     => [
                                    'is_active'  => [
                                        'label'       => __('Enable', 'wc-frontend-manager-ultimate'),
                                        'type'        => 'checkbox',
                                        'class'       => 'wcfm-checkbox wcfm_ele',
                                        'label_class' => 'wcfm_title checkbox_title wcfm_ele',
                                        'value'       => 'yes',
                                    ],
                                    'badge_icon' => [
                                        'label'       => __('Badge Icon', 'wc-frontend-manager-ultimate'),
                                        'type'        => 'upload',
                                        'class'       => 'wcfm_ele',
                                        'prwidth'     => 64,
                                        'label_class' => 'wcfm_title wcfm_ele',
                                        'hints'       => __('Upload badge image 32x32 size for best view.', ''),
                                    ],
                                    'badge_name' => [
                                        'label'       => __('Badge Name', 'wc-frontend-manager-ultimate'),
                                        'type'        => 'text',
                                        'class'       => 'wcfm-text wcfm_ele',
                                        'label_class' => 'wcfm_title wcfm_ele',
                                        'hints'       => __('Name of the badge visible as tooltip.', 'wc-frontend-manager-ultimate'),
                                    ],
                                ],
                            ],
                        ]
                    )
                );
                ?>
            </div>
        </div>
        <div class="wcfm_clearfix"></div>
        <!-- end collapsible -->
        
        <?php

    }//end wcfmu_vendor_badges_settings()


    function wcfmu_vendor_badges_settings_update($wcfm_settings_form)
    {
        global $WCFM, $WCFMu, $_POST;

        if (isset($wcfm_settings_form['wcfm_vendor_badges_options'])) {
            $wcfm_vendor_badges_options = $wcfm_settings_form['wcfm_vendor_badges_options'];
            update_option('wcfm_vendor_badges_options', $wcfm_vendor_badges_options);
        }

        if (isset($wcfm_settings_form['wcfm_conditional_badges_rules'])) {
            $wcfm_conditional_badges_rules = $wcfm_settings_form['wcfm_conditional_badges_rules'];
            update_option('wcfm_conditional_badges_rules', $wcfm_conditional_badges_rules);
        }

    }//end wcfmu_vendor_badges_settings_update()


    /**
     * Membership Badges Manage
     */
    function wcfmu_membership_badges_manage($membership_id)
    {
        global $WCFM, $WCFMu;

        if (empty($this->wcfm_vendor_badges_options)) {
            // translators: 1) knowledgebase url
            printf(__('There is no badges yet to be configured! <a target="_blank" href="%s">Know more.</a>', 'wc-frontend-manager-ultimate'), 'https://wclovers.com/knowledgebase/wcfm-vendor-badges/');
        } else {
            $wcfm_membership_badges = [];
            if ($membership_id) {
                $wcfm_membership_badges = get_post_meta($membership_id, 'wcfm_membership_badges', true);
                if (! $wcfm_membership_badges) {
                    $wcfm_membership_badges = [];
                }
            }

            foreach ($this->wcfm_vendor_badges_options as $badge_key => $wcfm_vendor_badges_option) {
                if (isset($wcfm_vendor_badges_option['is_active']) && ! empty($wcfm_vendor_badges_option['badge_name'])) {
                    $WCFM->wcfm_fields->wcfm_generate_form_field(
                        [
                            'wcfm_membership_badges_'.$badge_key => [
                                'label'       => '<img src="'.wcfm_get_attachment_url($wcfm_vendor_badges_option['badge_icon']).'" style="width: 32px; margin-right: 5px; display: inline-block;">'.$wcfm_vendor_badges_option['badge_name'],
                                'name'        => 'wcfm_membership_badges['.$badge_key.']',
                                'type'        => 'checkbox',
                                'class'       => 'wcfm-checkbox wcfm_ele',
                                'label_class' => 'wcfm_title checkbox_title',
                                'value'       => 'yes',
                                'dfvalue'     => ( isset($wcfm_membership_badges[$badge_key]) ? 'yes' : 'no' ),
                            ],
                        ]
                    );
                }
            }
        }//end if

    }//end wcfmu_membership_badges_manage()


    /**
     * Membership Badges Update
     */
    function wcfmu_membership_badges_update($new_membership_id, $wcfm_membership_manager_form_data)
    {
        global $WCFM, $WCFMu;

        if (isset($wcfm_membership_manager_form_data['wcfm_membership_badges'])) {
            update_post_meta($new_membership_id, 'wcfm_membership_badges', $wcfm_membership_manager_form_data['wcfm_membership_badges']);
        } else {
            update_post_meta($new_membership_id, 'wcfm_membership_badges', []);
        }

    }//end wcfmu_membership_badges_update()


    function wcfmu_vendor_badges_manage($vendor_id)
    {
        global $WCFM, $WCFMu;

        $disable_vendor = get_user_meta($vendor_id, '_disable_vendor', true);
        if ($disable_vendor) {
            return;
        }

        if (empty($this->wcfm_vendor_badges_options)) {
            return;
        }

        $wcfm_vendor_badges = $this->get_wcfm_vendor_badges($vendor_id);
        ?>
        <!-- collapsible - Badges -->
        <div class="page_collapsible vendor_manage_badges" id="wcfm_vendor_manage_form_badges_head"><label class="wcfmfa fa-certificate"></label><?php _e('Badges', 'wc-frontend-manager-ultimate'); ?><span></span></div>
        <div class="wcfm-container">
            <div id="wcfm_vendor_manage_form_badges_expander" class="wcfm-content">
                <div class="wcfm_vendor_badges_show">
                <?php
                $this->show_wcfm_vendor_badges($vendor_id, true);
                if (empty($wcfm_vendor_badges)) {
                    _e('There is no custom badges yet for this vendor!', 'wc-frontend-manager-ultimate');
                }
                ?>
                <a href="#" class="wcfm_vendor_badges_manage_link">
                  <?php _e('Manage vendor badges!', 'wc-frontend-manager-ultimate'); ?>
                </a>
                </div>
                <div class="wcfm_vendor_badges_manage">
                  <form id="wcfm_vendor_manage_badges_form" class="wcfm">
                      <?php
                      foreach ($this->wcfm_vendor_badges_options as $badge_key => $wcfm_vendor_badges_option) {
                            if (isset($wcfm_vendor_badges_option['is_active']) && ! empty($wcfm_vendor_badges_option['badge_name'])) {
                                $WCFM->wcfm_fields->wcfm_generate_form_field(
                                    [
                                        'wcfm_vendor_badges_'.$badge_key => [
                                            'label'       => '<img src="'.wcfm_get_attachment_url($wcfm_vendor_badges_option['badge_icon']).'" style="width: 32px; margin-right: 5px; display: inline-block;">'.$wcfm_vendor_badges_option['badge_name'],
                                            'name'        => 'wcfm_vendor_badges['.$badge_key.']',
                                            'type'        => 'checkbox',
                                            'class'       => 'wcfm-checkbox wcfm_ele',
                                            'label_class' => 'wcfm_title checkbox_title',
                                            'value'       => 'yes',
                                            'dfvalue'     => ( isset($wcfm_vendor_badges[$badge_key]) ? 'yes' : 'no' ),
                                        ],
                                    ]
                                );
                            }
                      }

                        $WCFM->wcfm_fields->wcfm_generate_form_field(
                            [
                                'vendor_id' => [
                                    'type'  => 'hidden',
                                    'value' => $vendor_id,
                                ],
                            ]
                        );
                        ?>
                        <div class="wcfm-clearfix"></div>
                        <div class="wcfm-message" tabindex="-1"></div>
                        <div class="wcfm-clearfix"></div>
                        <div id="wcfm_badges_submit">
                            <input type="submit" name="save-data" value="<?php _e('Update', 'wc-frontend-manager'); ?>" id="wcfm_vendor_badges_save_button" class="wcfm_submit_button" />
                        </div>
                        <div class="wcfm-clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="wcfm_clearfix"></div><br />
        <!-- end collapsible - Badges -->
        <?php

    }//end wcfmu_vendor_badges_manage()


    /**
     * Return Badges for a Vendor
     */
    function get_wcfm_vendor_badges($vendor_id)
    {
        global $WCFM, $WCFMu;

        $wcfm_vendor_badges = [];
        if (! $vendor_id) {
            return $wcfm_vendor_badges;
        }

        $wcfm_membership_badges = [];
        $wcfm_membership_id     = get_user_meta($vendor_id, 'wcfm_membership', true);
        if ($wcfm_membership_id) {
            $wcfm_membership_badges = get_post_meta($wcfm_membership_id, 'wcfm_membership_badges', true);
            if (! $wcfm_membership_badges) {
                $wcfm_membership_badges = [];
            }
        }

        $wcfm_vendor_badges = get_user_meta($vendor_id, 'wcfm_vendor_badges', true);
        if (! $wcfm_vendor_badges) {
            $wcfm_vendor_badges = $wcfm_membership_badges;
        }

        return $wcfm_vendor_badges;

    }//end get_wcfm_vendor_badges()


    /**
     * Display vendor Badges
     */
    public function show_wcfm_vendor_badges($vendor_id=0, $is_large=false)
    {
        global $WCFM, $WCFMu;

        if (empty($this->wcfm_vendor_badges_options)) {
            return;
        }

        $is_large = apply_filters('wcfm_is_allow_vendor_badges_large', $is_large);

        if ($vendor_id) {
            $wcfm_vendor_badges = $this->get_wcfm_vendor_badges($vendor_id);
            $badge_classses     = 'wcfm_vendor_badge';
            if ($is_large) {
                $badge_classses .= ' wcfm_vendor_badge_large';
            }

            echo '<div class="wcfm_vendor_badges">';
            do_action('before_wcfm_vendor_badges', $vendor_id, $badge_classses);
            if (! empty($wcfm_vendor_badges)) {
                foreach ($this->wcfm_vendor_badges_options as $badge_key => $wcfm_vendor_badges_option) {
                    if (isset($wcfm_vendor_badges_option['is_active']) && ! empty($wcfm_vendor_badges_option['badge_name']) && isset($wcfm_vendor_badges[$badge_key])) {
                        echo '<div class="'.$badge_classses.' text_tip"  data-tip="'.$wcfm_vendor_badges_option['badge_name'].'"><img src="'.wcfm_get_attachment_url($wcfm_vendor_badges_option['badge_icon']).'" /></div>';
                    }
                }
            }

            do_action('after_wcfm_vendor_badges', $vendor_id, $badge_classses);
            echo '</div>';
        }

    }//end show_wcfm_vendor_badges()


    /**
     * Show Badges with Memebrship Description
     */
    function show_wcfm_membership_badges($membership_id)
    {
        if (apply_filters('wcfm_is_allow_badges_in_membership_box', true)) {
            $wcfm_vendor_badges_options = get_option('wcfm_vendor_badges_options', []);
            if (! empty($wcfm_vendor_badges_options)) {
                $wcfm_membership_badges = get_post_meta($membership_id, 'wcfm_membership_badges', true);
                if (! $wcfm_membership_badges) {
                    $wcfm_membership_badges = [];
                }

                if (! empty($wcfm_membership_badges)) {
                    echo '<div class="wcfm_vendor_badges">';
                    foreach ($wcfm_vendor_badges_options as $badge_key => $wcfm_vendor_badges_option) {
                        if (isset($wcfm_vendor_badges_option['is_active']) && ! empty($wcfm_vendor_badges_option['badge_name']) && isset($wcfm_membership_badges[$badge_key])) {
                            echo '<div class="wcfm_vendor_badge wcfm_vendor_badge_large text_tip"  data-tip="'.$wcfm_vendor_badges_option['badge_name'].'"><img src="'.wcfm_get_attachment_url($wcfm_vendor_badges_option['badge_icon']).'" /></div>';
                        }
                    }

                    echo '</div>';
                }
            }
        }

    }//end show_wcfm_membership_badges()


    function after_wcfm_dashboard_user($vendor_id)
    {
        global $WCFM, $WCFMu;
        if (empty($this->wcfm_vendor_badges_options)) {
            return;
        }

        if (! $vendor_id) {
            $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
        }

        $wcfm_vendor_badges = $this->get_wcfm_vendor_badges($vendor_id);
        if (! empty($wcfm_vendor_badges)) {
            foreach ($this->wcfm_vendor_badges_options as $badge_key => $wcfm_vendor_badges_option) {
                if (isset($wcfm_vendor_badges_option['is_active']) && ! empty($wcfm_vendor_badges_option['badge_name']) && isset($wcfm_vendor_badges[$badge_key])) {
                    echo '<img class="wcfm_vendor_badge text_tip"  data-tip="'.$wcfm_vendor_badges_option['badge_name'].'" src="'.wcfm_get_attachment_url($wcfm_vendor_badges_option['badge_icon']).'" />';
                }
            }
        }

    }//end after_wcfm_dashboard_user()


    function before_wcmp_vendor_information($vendor_id)
    {
        global $WCFM, $WCFMu;
        $this->show_wcfm_vendor_badges($vendor_id, true);

    }//end before_wcmp_vendor_information()


    function wcmp_singleproductmultivendor_table_name($product_id, $morevendor)
    {
        global $WCFM, $WCFMu;
        if ($product_id) {
            $vendor_id = wcfm_get_vendor_id_by_post($product_id);
            $this->show_wcfm_vendor_badges($vendor_id);
        }

    }//end wcmp_singleproductmultivendor_table_name()


    function after_sold_by_text_shop_page($vendor)
    {
        global $WCFM, $WCFMu;
        if ($vendor) {
            if ($vendor->id) {
                if (apply_filters('wcfm_is_allow_badges_in_loop', true)) {
                    $this->show_wcfm_vendor_badges($vendor->id);
                }
            }
        }

    }//end after_sold_by_text_shop_page()


    function template_loop_seller_badges($product_id)
    {
        global $WCFM, $WCFMu;
        if ($product_id) {
            if (apply_filters('wcfm_is_allow_badges_in_loop', true)) {
                $vendor_id = wcfm_get_vendor_id_by_post($product_id);
                $this->show_wcfm_vendor_badges($vendor_id);
            }
        }

    }//end template_loop_seller_badges()


    function after_wcv_pro_store_header()
    {
        global $WCFM, $WCFMu;

        $vendor_id = 0;
        if (WCV_Vendors::is_vendor_page()) {
            $vendor_shop = urldecode(get_query_var('vendor_shop'));
            $vendor_id   = WCV_Vendors::get_vendor_id($vendor_shop);
        } else {
            global $product;
            $post = get_post($product->get_id());
            if (WCV_Vendors::is_vendor_product_page($post->post_author)) {
                $vendor_id = $post->post_author;
            }
        }

        $this->show_wcfm_vendor_badges($vendor_id, true);

    }//end after_wcv_pro_store_header()


    function after_wcv_store_header($vendor_id)
    {
        global $WCFM, $WCFMu;
        $this->show_wcfm_vendor_badges($vendor_id, true);

    }//end after_wcv_store_header()


    function after_wcv_cart_sold_by($sold_by_label, $product_id, $vendor_id)
    {
        global $WCFM, $WCFMu;
        if (apply_filters('wcfm_is_allow_badges_in_loop', true)) {
            $this->show_wcfm_vendor_badges($vendor_id);
        }

        return $sold_by_label;

    }//end after_wcv_cart_sold_by()


    function dokan_product_tab_seller_badges($tabs)
    {
        global $WCFM, $WCFMu;

        if (empty($this->wcfm_vendor_badges_options)) {
            return $tabs;
        }

        remove_filter('woocommerce_product_tabs', 'dokan_seller_product_tab');

        $tabs['seller'] = [
            'title'    => __('Vendor Info', 'dokan-lite'),
            'priority' => 90,
            'callback' => [
                &$this,
                'wcfm_dokan_product_seller_tab',
            ],
        ];

        return $tabs;

    }//end dokan_product_tab_seller_badges()


    /**
     * Prints seller info in product single page
     *
     * @global WC_Product $product
     * @param  type $val
     */
    function wcfm_dokan_product_seller_tab($val)
    {
        global $product;

        $vendor_id  = get_post_field('post_author', $product->get_id());
        $author     = get_user_by('id', $vendor_id);
        $store_info = dokan_get_store_info($author->ID);

        if ($vendor_id) {
            $wcfm_vendor_badges    = $this->get_wcfm_vendor_badges($vendor_id);
            $author->display_name .= '<div class="wcfm_vendor_badges">';
            $author->display_name  = apply_filters('before_dokan_wcfm_vendor_badges', $author->display_name, $vendor_id, 'wcfm_vendor_badge wcfm_vendor_badge_large');
            if (! empty($wcfm_vendor_badges)) {
                foreach ($this->wcfm_vendor_badges_options as $badge_key => $wcfm_vendor_badges_option) {
                    if (isset($wcfm_vendor_badges_option['is_active']) && ! empty($wcfm_vendor_badges_option['badge_name']) && isset($wcfm_vendor_badges[$badge_key])) {
                        $author->display_name .= '<div class="wcfm_vendor_badge wcfm_vendor_badge_large text_tip"  data-tip="'.$wcfm_vendor_badges_option['badge_name'].'"><img src="'.wcfm_get_attachment_url($wcfm_vendor_badges_option['badge_icon']).'" /></div>';
                    }
                }
            }

            $author->display_name .= '</div>';
        }

        dokan_get_template_part(
            'global/product-tab',
            '',
            [
                'author'     => $author,
                'store_info' => $store_info,
            ]
        );

    }//end wcfm_dokan_product_seller_tab()


    function after_dokan_store_header($vendor_id)
    {
        global $WCFM, $WCFMu;
        echo '<li class="dokan-store-badges">';
        $this->show_wcfm_vendor_badges($vendor_id, true);
        echo '</li>';

    }//end after_dokan_store_header()


    function wcpv_sold_by_link_name_seller_badges($name, $product_id, $term)
    {
        global $WCFM, $WCFMu;

        if (empty($this->wcfm_vendor_badges_options)) {
            return $name;
        }

        $vendor_id = wcfm_get_vendor_id_by_post($product_id);
        if ($vendor_id) {
            $vendor_admin_id = 0;
            $vendor_data     = WC_Product_Vendors_Utils::get_vendor_data_by_id($vendor_id);

            if (is_array($vendor_data['admins'])) {
                $admin_ids = array_map('absint', $vendor_data['admins']);
            } else {
                $admin_ids = array_filter(array_map('absint', explode(',', $vendor_data['admins'])));
            }

            foreach ($admin_ids as $admin_id) {
                if ($admin_id) {
                    if (WC_Product_Vendors_Utils::is_admin_vendor($admin_id)) {
                        $vendor_admin_id = $admin_id;
                        break;
                    }
                }
            }

            if ($vendor_admin_id) {
                $wcfm_vendor_badges = $this->get_wcfm_vendor_badges($vendor_admin_id);
                $name              .= '<div class="wcfm_vendor_badges">';
                $name               = apply_filters('before_wcv_wcfm_vendor_badges', $name, $vendor_admin_id, 'wcfm_vendor_badge');
                if (! empty($wcfm_vendor_badges)) {
                    foreach ($this->wcfm_vendor_badges_options as $badge_key => $wcfm_vendor_badges_option) {
                        if (isset($wcfm_vendor_badges_option['is_active']) && ! empty($wcfm_vendor_badges_option['badge_name']) && isset($wcfm_vendor_badges[$badge_key])) {
                            $name .= '<div class="wcfm_vendor_badge text_tip"  data-tip="'.$wcfm_vendor_badges_option['badge_name'].'"><img src="'.wcfm_get_attachment_url($wcfm_vendor_badges_option['badge_icon']).'" /></div>';
                        }
                    }
                }

                $name .= '</div>';
            }
        }//end if

        return $name;

    }//end wcpv_sold_by_link_name_seller_badges()


    function after_wcfmmp_sold_by_label_product_page($vendor_id)
    {
        global $WCFM, $WCFMu;
        if ($vendor_id) {
            if (apply_filters('wcfm_is_allow_badges_in_loop', true)) {
                $this->show_wcfm_vendor_badges($vendor_id);
            }
        }

    }//end after_wcfmmp_sold_by_label_product_page()


    function show_conditional_badges($vendor_id, $badge_classses)
    {
        global $wpdb, $WCFM;
        $wcfm_conditional_badges_rules = get_option('wcfm_conditional_badges_rules', []);

        if (! empty($wcfm_conditional_badges_rules)) {
            foreach ($wcfm_conditional_badges_rules as $rule) {
                $show_badge = false;

                if (! isset($rule['is_active'], $rule['mode'], $rule['rule'], $rule['value'])) {
                    continue;
                }

                if ($rule['is_active']) {
                    switch ($rule['mode']) {
                        case 'sales':
                            $vendor_gross_sales = $WCFM->wcfm_vendor_support->wcfm_get_gross_sales_by_vendor($vendor_id, apply_filters('wcfmu_conditional_badges_vendor_gross_sales_duration', 'all', $vendor_id, $rule));

                            if ('upto' == $rule['rule'] && (float) $vendor_gross_sales <= (float) $rule['value']) {
                                $show_badge = true;
                            } else if ('greater' == $rule['rule'] && (float) $vendor_gross_sales > (float) $rule['value']) {
                                $show_badge = true;
                            }
                            break;

                        case 'orders':
                            $sql  = "SELECT commission.order_id, commission.order_status FROM {$wpdb->prefix}wcfm_marketplace_orders AS commission";
                            $sql .= ' WHERE 1=1';
                            $sql .= ' AND commission.vendor_id = %d';
                            $sql .= ' AND commission.order_status IN (%s)';
                            $sql .= ' AND `is_refunded` != 1 AND `is_trashed` != 1';
                            $sql .= ' GROUP BY commission.order_id';

                            $total_vendor_orders = count($wpdb->get_results($wpdb->prepare($sql, $vendor_id, apply_filters('wcfmu_conditional_badges_order_status', 'completed'))));

                            if ('upto' == $rule['rule'] && $total_vendor_orders <= $rule['value']) {
                                $show_badge = true;
                            } else if ('greater' == $rule['rule'] && $total_vendor_orders > $rule['value']) {
                                $show_badge = true;
                            }
                            break;

                        case 'registration_time':
                            $userdata = get_userdata($vendor_id);
                            $origin   = new DateTime($userdata->user_registered);
                            $target   = new DateTime();
                            $interval = $origin->diff($target);

                            if ('upto' == $rule['rule'] && $interval->days <= $rule['value']) {
                                $show_badge = true;
                            } else if ('greater' == $rule['rule'] && $interval->days > $rule['value']) {
                                $show_badge = true;
                            }
                            break;

                        default:
                            $show_badge = apply_filters('wcfm_show_conditional_badge', false, $rule, $vendor_id);
                            break;
                    }//end switch
                }//end if

                if ($show_badge) {
                    echo '<div class="'.$badge_classses.' text_tip"  data-tip="'.$rule['badge_name'].'"><img src="'.wcfm_get_attachment_url($rule['badge_icon']).'" /></div>';
                }
            }//end foreach
        }//end if

    }//end show_conditional_badges()


}//end class

