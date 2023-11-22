<?php
/**
 * WCFMu plugin Views
 *
 * Plugin Capability View
 *
 * @author  Squiz Pty Ltd <products@squiz.net>
 * @package wcfmu/views
 * @version 2.5.0
 */
?>

<?php
/**
 * WCFM advanced capability
 *
 * @since 2.3.1
 */
add_action('wcfm_capability_settings_product', 'wcfmu_capability_settings_product_advanced');


function wcfmu_capability_settings_product_advanced($wcfm_capability_options)
{
    global $WCFM, $WCFMu;

    $featured_img  = ( isset($wcfm_capability_options['featured_img']) ) ? $wcfm_capability_options['featured_img'] : 'no';
    $gallery_img   = ( isset($wcfm_capability_options['gallery_img']) ) ? $wcfm_capability_options['gallery_img'] : 'no';
    $category      = ( isset($wcfm_capability_options['category']) ) ? $wcfm_capability_options['category'] : 'no';
    $add_category  = ( isset($wcfm_capability_options['add_category']) ) ? $wcfm_capability_options['add_category'] : 'no';
    $tags          = ( isset($wcfm_capability_options['tags']) ) ? $wcfm_capability_options['tags'] : 'no';
    $addons        = ( isset($wcfm_capability_options['addons']) ) ? $wcfm_capability_options['addons'] : 'no';
    $toolset_types = ( isset($wcfm_capability_options['toolset_types']) ) ? $wcfm_capability_options['toolset_types'] : 'no';
    $acf_fields    = ( isset($wcfm_capability_options['acf_fields']) ) ? $wcfm_capability_options['acf_fields'] : 'no';
    $mappress      = ( isset($wcfm_capability_options['mappress']) ) ? $wcfm_capability_options['mappress'] : 'no';

    $add_attribute      = ( isset($wcfm_capability_options['add_attribute']) ) ? $wcfm_capability_options['add_attribute'] : 'no';
    $add_attribute_term = ( isset($wcfm_capability_options['add_attribute_term']) ) ? $wcfm_capability_options['add_attribute_term'] : 'no';
    $delete_media       = ( isset($wcfm_capability_options['delete_media']) ) ? $wcfm_capability_options['delete_media'] : 'no';
    $rich_editor        = ( isset($wcfm_capability_options['rich_editor']) ) ? $wcfm_capability_options['rich_editor'] : 'no';
    $featured_product   = ( isset($wcfm_capability_options['featured_product']) ) ? $wcfm_capability_options['featured_product'] : 'no';
    $duplicate_product  = ( isset($wcfm_capability_options['duplicate_product']) ) ? $wcfm_capability_options['duplicate_product'] : 'no';
    $product_import     = ( isset($wcfm_capability_options['product_import']) ) ? $wcfm_capability_options['product_import'] : 'no';
    $product_export     = ( isset($wcfm_capability_options['product_export']) ) ? $wcfm_capability_options['product_export'] : 'no';
    $product_quick_edit = ( isset($wcfm_capability_options['product_quick_edit']) ) ? $wcfm_capability_options['product_quick_edit'] : 'no';
    $product_bulk_edit  = ( isset($wcfm_capability_options['product_bulk_edit']) ) ? $wcfm_capability_options['product_bulk_edit'] : 'no';
    $stock_manager      = ( isset($wcfm_capability_options['stock_manager']) ) ? $wcfm_capability_options['stock_manager'] : 'no';

    $manage_sku              = ( isset($wcfm_capability_options['manage_sku']) ) ? $wcfm_capability_options['manage_sku'] : 'no';
    $manage_price            = ( isset($wcfm_capability_options['manage_price']) ) ? $wcfm_capability_options['manage_price'] : 'no';
    $manage_sales_price      = ( isset($wcfm_capability_options['manage_sales_price']) ) ? $wcfm_capability_options['manage_sales_price'] : 'no';
    $manage_sales_scheduling = ( isset($wcfm_capability_options['manage_sales_scheduling']) ) ? $wcfm_capability_options['manage_sales_scheduling'] : 'no';
    $manage_excerpt          = ( isset($wcfm_capability_options['manage_excerpt']) ) ? $wcfm_capability_options['manage_excerpt'] : 'no';
    $manage_description      = ( isset($wcfm_capability_options['manage_description']) ) ? $wcfm_capability_options['manage_description'] : 'no';

    $spacelimit             = ( ! empty($wcfm_capability_options['spacelimit']) ) ? $wcfm_capability_options['spacelimit'] : '';
    $articlelimit           = ( ! empty($wcfm_capability_options['articlelimit']) ) ? $wcfm_capability_options['articlelimit'] : '';
    $productlimit           = ( ! empty($wcfm_capability_options['productlimit']) ) ? $wcfm_capability_options['productlimit'] : '';
    $featured_product_limit = ( ! empty($wcfm_capability_options['featured_product_limit']) ) ? $wcfm_capability_options['featured_product_limit'] : '';
    $gallerylimit           = ( ! empty($wcfm_capability_options['gallerylimit']) ) ? $wcfm_capability_options['gallerylimit'] : '';

    $allowed_article_category = ( ! empty($wcfm_capability_options['allowed_article_category']) ) ? $wcfm_capability_options['allowed_article_category'] : [];
    $article_catlimit         = ( ! empty($wcfm_capability_options['article_catlimit']) ) ? $wcfm_capability_options['article_catlimit'] : '';
    $allowed_categories       = ( ! empty($wcfm_capability_options['allowed_categories']) ) ? $wcfm_capability_options['allowed_categories'] : [];
    $catlimit                 = ( ! empty($wcfm_capability_options['catlimit']) ) ? $wcfm_capability_options['catlimit'] : '';

    $allowed_attributes    = ( ! empty($wcfm_capability_options['allowed_attributes']) ) ? $wcfm_capability_options['allowed_attributes'] : [];
    $allowed_custom_fields = ( ! empty($wcfm_capability_options['allowed_custom_fields']) ) ? $wcfm_capability_options['allowed_custom_fields'] : [];

    $profile         = ( isset($wcfm_capability_options['profile']) ) ? $wcfm_capability_options['profile'] : 'no';
    $address         = ( isset($wcfm_capability_options['address']) ) ? $wcfm_capability_options['address'] : 'no';
    $social          = ( isset($wcfm_capability_options['social']) ) ? $wcfm_capability_options['social'] : 'no';
    $pm_verification = ( isset($wcfm_capability_options['pm_verification']) ) ? $wcfm_capability_options['pm_verification'] : 'no';
    $pm_membership   = ( isset($wcfm_capability_options['pm_membership']) ) ? $wcfm_capability_options['pm_membership'] : 'no';

    $brand           = ( isset($wcfm_capability_options['brand']) ) ? $wcfm_capability_options['brand'] : 'no';
    $visibility      = ( isset($wcfm_capability_options['visibility']) ) ? $wcfm_capability_options['visibility'] : 'no';
    $store_address   = ( isset($wcfm_capability_options['store_address']) ) ? $wcfm_capability_options['store_address'] : 'no';
    $billing         = ( isset($wcfm_capability_options['billing']) ) ? $wcfm_capability_options['billing'] : 'no';
    $vshipping       = ( isset($wcfm_capability_options['vshipping']) ) ? $wcfm_capability_options['vshipping'] : 'no';
    $store_seo       = ( isset($wcfm_capability_options['store_seo']) ) ? $wcfm_capability_options['store_seo'] : 'no';
    $policy          = ( isset($wcfm_capability_options['policy']) ) ? $wcfm_capability_options['policy'] : 'no';
    $support_setting = ( isset($wcfm_capability_options['support_setting']) ) ? $wcfm_capability_options['support_setting'] : 'no';
    $hours_setting   = ( isset($wcfm_capability_options['hours_setting']) ) ? $wcfm_capability_options['hours_setting'] : 'no';
    $vacation        = ( isset($wcfm_capability_options['vacation']) ) ? $wcfm_capability_options['vacation'] : 'no';

    $store_logo        = ( isset($wcfm_capability_options['store_logo']) ) ? $wcfm_capability_options['store_logo'] : 'no';
    $store_banner      = ( isset($wcfm_capability_options['store_banner']) ) ? $wcfm_capability_options['store_banner'] : 'no';
    $store_name        = ( isset($wcfm_capability_options['store_name']) ) ? $wcfm_capability_options['store_name'] : 'no';
    $store_phone       = ( isset($wcfm_capability_options['store_phone']) ) ? $wcfm_capability_options['store_phone'] : 'no';
    $store_description = ( isset($wcfm_capability_options['store_description']) ) ? $wcfm_capability_options['store_description'] : 'no';

    $chatbox = ( ! empty($wcfm_capability_options['chatbox']) ) ? $wcfm_capability_options['chatbox'] : '';

    // Remove WPML term filters - 3.4.1
    if (function_exists('icl_object_id')) {
        global $sitepress;
        remove_filter('get_terms_args', [ $sitepress, 'get_terms_args_filter' ]);
        remove_filter('get_term', [ $sitepress, 'get_term_adjust_id' ]);
        remove_filter('terms_clauses', [ $sitepress, 'terms_clauses' ]);

        $product_categories     = [];
        $product_category_lists = get_terms(
            [
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'parent'     => 0,
                'fields'     => 'id=>name',
            ]
        );
        if (! empty($product_category_lists)) {
            foreach ($product_category_lists as $product_category_id => $product_category_name) {
                $product_category_list                    = get_term($product_category_id);
                $product_category_list->term_id           = $product_category_id;
                $product_category_list->name              = $product_category_name;
                $product_categories[$product_category_id] = $product_category_list;
            }
        }

        $article_categories     = [];
        $article_category_lists = get_terms(
            [
                'taxonomy'   => 'category',
                'hide_empty' => false,
                'parent'     => 0,
                'fields'     => 'id=>name',
            ]
        );
        if (! empty($article_category_lists)) {
            foreach ($article_category_lists as $article_category_id => $article_category_name) {
                $article_category_list                    = get_term($article_category_id);
                $article_category_list->term_id           = $article_category_id;
                $article_category_list->name              = $article_category_name;
                $article_categories[$article_category_id] = $article_category_list;
            }
        }
    } else {
        $product_categories = get_terms('product_cat', 'orderby=name&hide_empty=0&parent=0');
        $article_categories = get_terms('category', 'orderby=name&hide_empty=0&parent=0');
    }//end if
    ?>
    <div class="wcfm_clearfix"></div>
    <div class="vendor_capability_sub_heading"><h3><?php _e('Sections', 'wc-frontend-manager-ultimate'); ?></h3></div>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_vendor_product_sections',
            [
                'featured_img' => [
                    'label'       => __('Featured Image', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[featured_img]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $featured_img,
                ],
                'gallery_img'  => [
                    'label'       => __('Gallery Image', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[gallery_img]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $gallery_img,
                ],
                'category'     => [
                    'label'       => __('Category', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[category]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $category,
                ],
                'add_category' => [
                    'label'       => __('Add Category', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[add_category]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $add_category,
                ],
            ]
        )
    );

    $product_taxonomies = get_object_taxonomies('product', 'objects');
    if (! empty($product_taxonomies)) {
        foreach ($product_taxonomies as $product_taxonomy) {
            if (! in_array($product_taxonomy->name, [ 'product_cat', 'product_tag', 'wcpv_product_vendors' ])) {
                if ($product_taxonomy->public && $product_taxonomy->show_ui && $product_taxonomy->meta_box_cb && $product_taxonomy->hierarchical) {
                    // Fetching Saved Values
                    $allow_custom_taxonomie = ( ! empty($wcfm_capability_options[$product_taxonomy->name]) ) ? $wcfm_capability_options[$product_taxonomy->name] : 'no';
                    $allow_add_taxonomie    = ( ! empty($wcfm_capability_options['add_'.$product_taxonomy->name]) ) ? $wcfm_capability_options['add_'.$product_taxonomy->name] : 'no';

                    $WCFM->wcfm_fields->wcfm_generate_form_field(
                        apply_filters(
                            'wcfm_capability_settings_fields_vendor_product_sections',
                            [
                                $product_taxonomy->name        => [
                                    'label'       => __($product_taxonomy->label, 'wc-frontend-manager-ultimate'),
                                    'name'        => 'wcfm_capability_options['.$product_taxonomy->name.']',
                                    'type'        => 'checkboxoffon',
                                    'class'       => 'wcfm-checkbox wcfm_ele',
                                    'value'       => 'yes',
                                    'label_class' => 'wcfm_title checkbox_title',
                                    'dfvalue'     => $allow_custom_taxonomie,
                                ],
                                'add_'.$product_taxonomy->name => [
                                    'label'       => __('Add', 'wc-frontend-manager-ultimate').' '.__($product_taxonomy->label, 'wc-frontend-manager-ultimate'),
                                    'name'        => 'wcfm_capability_options[add_'.$product_taxonomy->name.']',
                                    'type'        => 'checkboxoffon',
                                    'class'       => 'wcfm-checkbox wcfm_ele',
                                    'value'       => 'yes',
                                    'label_class' => 'wcfm_title checkbox_title',
                                    'dfvalue'     => $allow_add_taxonomie,
                                ],
                            ]
                        )
                    );
                }//end if
            }//end if
        }//end foreach
    }//end if

    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_vendor_product_sections',
            [
                'tags'          => [
                    'label'       => __('Tags', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[tags]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $tags,
                ],
                'addons'        => [
                    'label'       => __('Add-ons', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[addons]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $addons,
                ],
                'toolset_types' => [
                    'label'       => __('Toolset Fields', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[toolset_types]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $toolset_types,
                ],
                'acf_fields'    => [
                    'label'       => __('ACF Fields', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[acf_fields]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $acf_fields,
                ],
                'mappress'      => [
                    'label'       => __('Location', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[mappress]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $mappress,
                ],
            ]
        )
    );
    ?>
    <div class="wcfm_clearfix"></div>
    <div class="vendor_capability_sub_heading"><h3><?php _e('Insights', 'wc-frontend-manager-ultimate'); ?></h3></div>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_vendor_product_insights',
            [
                'add_attribute'      => [
                    'label'       => __('Add Attribute', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[add_attribute]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $add_attribute,
                ],
                'add_attribute_term' => [
                    'label'       => __('Add Attribute Term', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[add_attribute_term]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $add_attribute_term,
                ],
                'delete_media'       => [
                    'label'       => __('Delete Media', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[delete_media]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $delete_media,
                ],
                'rich_editor'        => [
                    'label'       => __('Rich Editor', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[rich_editor]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $rich_editor,
                ],
                'featured_product'   => [
                    'label'       => __('Featured Product', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[featured_product]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $featured_product,
                ],
                'duplicate_product'  => [
                    'label'       => __('Duplicate Product', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[duplicate_product]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $duplicate_product,
                ],
                'product_import'     => [
                    'label'       => __('Import', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[product_import]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $product_import,
                ],
                'product_export'     => [
                    'label'       => __('Export', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[product_export]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $product_export,
                ],
                'product_quick_edit' => [
                    'label'       => __('Quick Edit', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[product_quick_edit]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $product_quick_edit,
                ],
                'product_bulk_edit'  => [
                    'label'       => __('Bulk Edit', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[product_bulk_edit]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $product_bulk_edit,
                ],
                'stock_manager'      => [
                    'label'       => __('Stock Manager', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[stock_manager]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $stock_manager,
                ],
            ]
        )
    );
    ?>
    
    <div class="wcfm_clearfix"></div>
    <div class="vendor_capability_sub_heading"><h3><?php _e('Fields', 'wc-frontend-manager-ultimate'); ?></h3></div>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_vendor_product_insights',
            [
                'manage_sku'              => [
                    'label'       => __('SKU', 'wc-frontend-manager'),
                    'name'        => 'wcfm_capability_options[manage_sku]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $manage_sku,
                ],
                'manage_price'            => [
                    'label'       => __('Price', 'wc-frontend-manager'),
                    'name'        => 'wcfm_capability_options[manage_price]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $manage_price,
                ],
                'manage_sales_price'      => [
                    'label'       => __('Sale Price', 'wc-frontend-manager'),
                    'name'        => 'wcfm_capability_options[manage_sales_price]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $manage_sales_price,
                ],
                'manage_sales_scheduling' => [
                    'label'       => __('Sales Schedule', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[manage_sales_scheduling]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $manage_sales_scheduling,
                ],
                'manage_excerpt'          => [
                    'label'       => __('Short Description', 'wc-frontend-manager'),
                    'name'        => 'wcfm_capability_options[manage_excerpt]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $manage_excerpt,
                ],
                'manage_description'      => [
                    'label'       => __('Description', 'wc-frontend-manager'),
                    'name'        => 'wcfm_capability_options[manage_description]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $manage_description,
                ],
            ]
        )
    );
    ?>
    
    <div class="wcfm_clearfix"></div>
    <div class="vendor_capability_sub_heading"><h3><?php _e('Limits', 'wc-frontend-manager-ultimate'); ?></h3></div>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_vendor_product_limits',
            [
                'spacelimit'             => [
                    'label'       => __('Space Limit', 'wc-frontend-manager-ultimate'),
                    'placeholder' => __('Unlimited', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[spacelimit]',
                    'type'        => 'number',
                    'class'       => 'wcfm-text wcfm_ele gallerylimit_ele',
                    'label_class' => 'wcfm_title gallerylimit_title',
                    'value'       => $spacelimit,
                    'hints'       => __('Total disk space allow to use by an user. Disk space unit is in MB. e.g. set 100 to allocate 100 MB space for a vendor. Only attachments are considered in space calculation. ', 'wc-frontend-manager-ultimate'),
                ],
                'articlelimit'           => [
                    'label'       => __('Article Limit', 'wc-frontend-manager-ultimate'),
                    'placeholder' => __('Unlimited', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[articlelimit]',
                    'type'        => 'number',
                    'class'       => 'wcfm-text wcfm_ele gallerylimit_ele',
                    'label_class' => 'wcfm_title gallerylimit_title',
                    'value'       => $articlelimit,
                    'hints'       => __('No. of Articles allow to add by an user.', 'wc-frontend-manager-ultimate').' '.__('Set `-1` if you want to restrict limit at `0`.', 'wc-frontend-manager-ultimate'),
                ],
                'productlimit'           => [
                    'label'       => __('Product Limit', 'wc-frontend-manager-ultimate'),
                    'placeholder' => __('Unlimited', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[productlimit]',
                    'type'        => 'number',
                    'class'       => 'wcfm-text wcfm_ele gallerylimit_ele',
                    'label_class' => 'wcfm_title gallerylimit_title',
                    'value'       => $productlimit,
                    'hints'       => __('No. of Products allow to add by an user.', 'wc-frontend-manager-ultimate').' '.__('Set `-1` if you want to restrict limit at `0`.', 'wc-frontend-manager-ultimate'),
                ],
                'featured_product_limit' => [
                    'label'       => __('Featured Product Limit', 'wc-frontend-manager-ultimate'),
                    'placeholder' => __('Unlimited', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[featured_product_limit]',
                    'type'        => 'number',
                    'class'       => 'wcfm-text wcfm_ele gallerylimit_ele',
                    'label_class' => 'wcfm_title gallerylimit_title',
                    'value'       => $featured_product_limit,
                ],
                'gallerylimit'           => [
                    'label'       => __('Gallery Limit', 'wc-frontend-manager-ultimate'),
                    'placeholder' => __('Unlimited', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[gallerylimit]',
                    'type'        => 'number',
                    'class'       => 'wcfm-text wcfm_ele gallerylimit_ele',
                    'label_class' => 'wcfm_title gallerylimit_title',
                    'value'       => $gallerylimit,
                ],
            ]
        )
    );
    ?>
    
    <p class="wcfm_title catlimit_title"><strong><?php _e('Article Categories', 'wc-frontend-manager-ultimate'); ?></strong></p><label class="screen-reader-text" for="vendor_product_cats"><?php _e('Allowed Article Cats', 'wc-frontend-manager-ultimate'); ?></label>
    <select id="vendor_allowed_article_category" name="wcfm_capability_options[allowed_article_category][]" class="wcfm-select wcfm_ele" multiple="multiple" data-catlimit="-1" style="width: 44%; margin-bottom: 10px;">
        <?php
        if ($article_categories) {
            $WCFM->library->generateTaxonomyHTML('category', $article_categories, $allowed_article_category, '', false, false, false);
        }
        ?>
    </select>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        [
            'article_catlimit' => [
                'label'       => __('Article Categories Limit', 'wc-frontend-manager-ultimate'),
                'placeholder' => __('Unlimited', 'wc-frontend-manager-ultimate'),
                'name'        => 'wcfm_capability_options[article_catlimit]',
                'type'        => 'number',
                'class'       => 'wcfm-text wcfm_ele catlimit_ele',
                'label_class' => 'wcfm_title catlimit_title',
                'value'       => $article_catlimit,
            ],
        ]
    );
    ?>
    
    <p class="wcfm_title catlimit_title"><strong><?php _e('Product Categories', 'wc-frontend-manager-ultimate'); ?></strong></p><label class="screen-reader-text" for="vendor_product_cats"><?php _e('Allowed Product Cats', 'wc-frontend-manager-ultimate'); ?></label>
    <select id="vendor_allowed_categories" name="wcfm_capability_options[allowed_categories][]" class="wcfm-select wcfm_ele" multiple="multiple" data-catlimit="-1" style="width: 44%; margin-bottom: 10px;">
        <?php
        if ($product_categories) {
            $WCFM->library->generateTaxonomyHTML('product_cat', $product_categories, $allowed_categories, '', false, false, false);
        }
        ?>
    </select>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        [
            'catlimit' => [
                'label'       => __('Product Categories Limit', 'wc-frontend-manager-ultimate'),
                'placeholder' => __('Unlimited', 'wc-frontend-manager-ultimate'),
                'name'        => 'wcfm_capability_options[catlimit]',
                'type'        => 'number',
                'class'       => 'wcfm-text wcfm_ele catlimit_ele',
                'label_class' => 'wcfm_title catlimit_title',
                'value'       => $catlimit,
            ],
        ]
    );
    ?>
    
    <?php
    if (! empty($product_taxonomies)) {
        foreach ($product_taxonomies as $product_taxonomy) {
            if (! in_array($product_taxonomy->name, [ 'product_cat', 'product_tag', 'wcpv_product_vendors' ])) {
                if ($product_taxonomy->public && $product_taxonomy->show_ui && $product_taxonomy->meta_box_cb && $product_taxonomy->hierarchical) {
                    // Fetching Saved Values
                    $allowed_custom_taxonomies = ( ! empty($wcfm_capability_options['allowed_'.$product_taxonomy->name]) ) ? $wcfm_capability_options['allowed_'.$product_taxonomy->name] : [];
                    $allowed_limit_taxonomies  = ( ! empty($wcfm_capability_options[$product_taxonomy->name.'_limit']) ) ? $wcfm_capability_options[$product_taxonomy->name.'_limit'] : '';
                    ?>
                    <p class="wcfm_title catlimit_title"><strong><?php _e($product_taxonomy->label, 'wc-frontend-manager'); ?></strong></p><label class="screen-reader-text" for="<?php echo $product_taxonomy->name; ?>"><?php _e('Allowed ', 'wc-frontend-manager-ultimate'); ?> <?php _e($product_taxonomy->label, 'wc-frontend-manager'); ?></label>
                    <select id="vendor_allowed_<?php echo $product_taxonomy->name; ?>" name="wcfm_capability_options[allowed_<?php echo $product_taxonomy->name; ?>][]" class="wcfm-select wcfm_ele vendor_allowed_custom_taxonomies" multiple="multiple" style="width: 44%; margin-bottom: 10px;">
                        <?php
                        $product_taxonomy_terms = get_terms($product_taxonomy->name, 'orderby=name&hide_empty=0&parent=0');
                        if ($product_taxonomy_terms) {
                            $WCFM->library->generateTaxonomyHTML($product_taxonomy->name, $product_taxonomy_terms, $allowed_custom_taxonomies, '', false, false, false);
                        }
                        ?>
                    </select>
                    
                    <p class="wcfm_title catlimit_title"><strong><?php _e($product_taxonomy->label, 'wc-frontend-manager'); ?> <?php _e('Limit ', 'wc-frontend-manager-ultimate'); ?></strong></p><label class="screen-reader-text" for="<?php echo $product_taxonomy->name; ?>"><?php _e($product_taxonomy->label, 'wc-frontend-manager'); ?> <?php _e('Limit ', 'wc-frontend-manager-ultimate'); ?></label>
                    <input type="number" id="vendor_limit_<?php echo $product_taxonomy->name; ?>" placeholder="<?php _e('Unlimited', 'wc-frontend-manager-ultimate'); ?>" name="wcfm_capability_options[<?php echo $product_taxonomy->name; ?>_limit]" class="wcfm-text wcfm_ele vendor_limit_custom_taxonomies catlimit_ele" value="<?php echo $allowed_limit_taxonomies; ?>" />
                    <?php
                }
            }//end if
        }//end foreach
    }//end if
    ?>
    
    <?php
    $attribute_taxonomies = wc_get_attribute_taxonomies();
    if ($attribute_taxonomies) {
        ?>
        <p class="wcfm_title catlimit_title"><strong><?php _e('Product Attributes', 'wc-frontend-manager-ultimate'); ?></strong></p><label class="screen-reader-text" for="vendor_product_attributes"><?php _e('Allowed Product Attributes', 'wc-frontend-manager-ultimate'); ?></label>
        <select id="vendor_allowed_attributes" name="wcfm_capability_options[allowed_attributes][]" class="wcfm-select wcfm_ele" multiple="multiple" data-catlimit="-1" style="width: 44%; margin-bottom: 10px;">
            <?php
            foreach ($attribute_taxonomies as $attribute_taxonomy) {
                $att_taxonomy = wc_attribute_taxonomy_name($attribute_taxonomy->attribute_name);
                $is_checked   = '';
                if (in_array($att_taxonomy, $allowed_attributes)) {
                    $is_checked = 'selected';
                }

                echo '<option value="'.$att_taxonomy.'" '.$is_checked.'>'.wc_attribute_label($att_taxonomy).'</option>';
            }
            ?>
        </select>
    <?php } ?>
    
    <?php
    $wcfm_product_custom_fields = get_option('wcfm_product_custom_fields', []);
    if ($wcfm_product_custom_fields && is_array($wcfm_product_custom_fields) && ! empty($wcfm_product_custom_fields)) {
        ?>
        <p class="wcfm_title catlimit_title"><strong><?php _e('Custom Fields', 'wc-frontend-manager-ultimate'); ?></strong></p><label class="screen-reader-text" for="vendor_allowed_custom_fields"><?php _e('Allowed Product Custom Fields', 'wc-frontend-manager-ultimate'); ?></label>
        <select id="vendor_allowed_custom_fields" name="wcfm_capability_options[allowed_custom_fields][]" class="wcfm-select wcfm_ele" multiple="multiple" data-catlimit="-1" style="width: 44%; margin-bottom: 10px;">
            <?php
            foreach ($wcfm_product_custom_fields as $wpcf_index => $wcfm_product_custom_field) {
                if (! isset($wcfm_product_custom_field['enable'])) {
                    continue;
                }

                $block_name = ! empty($wcfm_product_custom_field['block_name']) ? $wcfm_product_custom_field['block_name'] : '';
                if (! $block_name) {
                    continue;
                }

                $sanitize_block_name = sanitize_title($block_name);

                $is_checked = '';
                if (in_array($sanitize_block_name, $allowed_custom_fields)) {
                    $is_checked = 'selected';
                }

                echo '<option value="'.$sanitize_block_name.'" '.$is_checked.'>'.$block_name.'</option>';
            }
            ?>
        </select>
        <?php
    }//end if
    ?>
    
    <div class="wcfm_clearfix"></div>
    <div class="vendor_capability_sub_heading"><h3><?php _e('Settings', 'wc-frontend-manager-ultimate'); ?></h3></div>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_vendor_settings',
            [
                'brand'           => [
                    'label'       => __('Store Branding', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[brand]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $brand,
                ],
                'store_address'   => [
                    'label'       => __('Location', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[store_address]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $store_address,
                ],
                'vshipping'       => [
                    'label'       => __('Shipping', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[vshipping]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $vshipping,
                ],
                'billing'         => [
                    'label'       => __('Payment', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[billing]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $billing,
                ],
                'store_seo'       => [
                    'label'       => __('SEO', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[store_seo]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $store_seo,
                ],
                'policy'          => [
                    'label'       => __('Policies', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[policy]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $policy,
                ],
                'support_setting' => [
                    'label'       => __('Customer Support', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[support_setting]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $support_setting,
                ],
                'hours_setting'   => [
                    'label'       => __('Store Hours', 'wc-frontend-manager'),
                    'name'        => 'wcfm_capability_options[hours_setting]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $hours_setting,
                ],
                'vacation'        => [
                    'label'       => __('Vacation', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[vacation]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $vacation,
                ],
            ]
        )
    );
    ?>
    
    <div class="wcfm_clearfix"></div>
    <div class="vendor_capability_sub_heading"><h3><?php _e('Settings Inside', 'wc-frontend-manager-groups-staffs'); ?></h3></div>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_settings_inside',
            [
                'store_logo'        => [
                    'label'       => __('Logo', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[store_logo]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $store_logo,
                ],
                'store_banner'      => [
                    'label'       => __('Banner', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[store_banner]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $store_banner,
                ],
                'store_name'        => [
                    'label'       => __('Name', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[store_name]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $store_name,
                ],
                'store_phone'       => [
                    'label'       => __('Phone', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[store_phone]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $store_phone,
                ],
                'store_description' => [
                    'label'       => __('Description', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[store_description]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $store_description,
                ],
            ]
        )
    );
    ?>
    
    <div class="wcfm_clearfix"></div>
    <div class="vendor_capability_sub_heading"><h3><?php _e('Profile', 'wc-frontend-manager-ultimate'); ?></h3></div>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_vendor_profile',
            [
                'profile'         => [
                    'label'       => __('Profile', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[profile]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $profile,
                ],
                'address'         => [
                    'label'       => __('Address', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[address]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $address,
                ],
                'social'          => [
                    'label'       => __('Social', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[social]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $social,
                ],
                'pm_verification' => [
                    'label'       => __('Verification', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[pm_verification]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $pm_verification,
                ],
                'pm_membership'   => [
                    'label'       => __('Membership', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[pm_membership]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $pm_membership,
                ],
            ]
        )
    );
    ?>
    
    <div class="wcfm_clearfix"></div>
    <div class="vendor_capability_sub_heading"><h3><?php _e('Chat Module', 'wc-frontend-manager-ultimate'); ?></h3></div>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_chatbox',
            [
                'chatbox' => [
                    'label'       => __('Chat Box', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[chatbox]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $chatbox,
                ],
            ]
        )
    );
    ?>
    
    <?php
    // restore WPML term filters
    if (function_exists('icl_object_id')) {
        global $sitepress;
        add_filter('terms_clauses', [ $sitepress, 'terms_clauses' ], 10, 3);
        add_filter('get_term', [ $sitepress, 'get_term_adjust_id' ]);
        add_filter('get_terms_args', [ $sitepress, 'get_terms_args_filter' ], 10, 2);
    }

}//end wcfmu_capability_settings_product_advanced()


add_action('wcfm_capability_settings_miscellaneous', 'wcfmu_capability_settings_miscellaneous_advanced');


function wcfmu_capability_settings_miscellaneous_advanced($wcfm_capability_options)
{
    global $WCFM, $WCFMu;

    $shipping_tracking = ( isset($wcfm_capability_options['shipping_tracking']) ) ? $wcfm_capability_options['shipping_tracking'] : 'no';

    $enquiry       = ( isset($wcfm_capability_options['enquiry']) ) ? $wcfm_capability_options['enquiry'] : 'no';
    $enquiry_reply = ( isset($wcfm_capability_options['enquiry_reply']) ) ? $wcfm_capability_options['enquiry_reply'] : 'no';

    $support_ticket        = ( isset($wcfm_capability_options['support_ticket']) ) ? $wcfm_capability_options['support_ticket'] : 'no';
    $support_ticket_manage = ( isset($wcfm_capability_options['support_ticket_manage']) ) ? $wcfm_capability_options['support_ticket_manage'] : 'no';

    $knowledgebase  = ( isset($wcfm_capability_options['knowledgebase']) ) ? $wcfm_capability_options['knowledgebase'] : 'no';
    $notice         = ( isset($wcfm_capability_options['notice']) ) ? $wcfm_capability_options['notice'] : 'no';
    $notice_reply   = ( isset($wcfm_capability_options['notice_reply']) ) ? $wcfm_capability_options['notice_reply'] : 'no';
    $notification   = ( isset($wcfm_capability_options['notification']) ) ? $wcfm_capability_options['notification'] : 'no';
    $direct_message = ( isset($wcfm_capability_options['direct_message']) ) ? $wcfm_capability_options['direct_message'] : 'no';
    ?>
    
    <?php if (apply_filters('wcfm_is_pref_shipment_tracking', true)) { ?>
        <div class="wcfm_clearfix"></div>
        <div class="vendor_capability_sub_heading"><h3><?php _e('Shipping Tracking', 'wc-frontend-manager-ultimate'); ?></h3></div>
        
        <?php
        $WCFM->wcfm_fields->wcfm_generate_form_field(
            apply_filters(
                'wcfm_capability_settings_fields_vendor_shipping_tracking',
                [
                    'shipping_tracking' => [
                        'label'       => __('Allow', 'wc-frontend-manager-ultimate'),
                        'name'        => 'wcfm_capability_options[shipping_tracking]',
                        'type'        => 'checkboxoffon',
                        'class'       => 'wcfm-checkbox wcfm_ele',
                        'value'       => 'yes',
                        'label_class' => 'wcfm_title checkbox_title',
                        'dfvalue'     => $shipping_tracking,
                    ],
                ]
            )
        );
        ?>
        <?php
    }//end if
    ?>
    
    <?php if (apply_filters('wcfm_is_pref_enquiry', true)) { ?>
        <div class="wcfm_clearfix"></div>
        <div class="vendor_capability_sub_heading"><h3><?php _e('Inquiry', 'wc-frontend-manager-ultimate'); ?></h3></div>
        
        <?php
        $WCFM->wcfm_fields->wcfm_generate_form_field(
            apply_filters(
                'wcfm_capability_settings_fields_vendor_enquiry',
                [
                    'enquiry'       => [
                        'label'       => __('Inquiry', 'wc-frontend-manager-ultimate'),
                        'name'        => 'wcfm_capability_options[enquiry]',
                        'type'        => 'checkboxoffon',
                        'class'       => 'wcfm-checkbox wcfm_ele',
                        'value'       => 'yes',
                        'label_class' => 'wcfm_title checkbox_title',
                        'dfvalue'     => $enquiry,
                    ],
                    'enquiry_reply' => [
                        'label'       => __('Inquiry Reply', 'wc-frontend-manager-ultimate'),
                        'name'        => 'wcfm_capability_options[enquiry_reply]',
                        'type'        => 'checkboxoffon',
                        'class'       => 'wcfm-checkbox wcfm_ele',
                        'value'       => 'yes',
                        'label_class' => 'wcfm_title checkbox_title',
                        'dfvalue'     => $enquiry_reply,
                    ],
                ]
            )
        );
        ?>
        <?php
    }//end if
    ?>
    
    <?php if (apply_filters('wcfm_is_pref_support', true)) { ?>
        <div class="wcfm_clearfix"></div>
        <div class="vendor_capability_sub_heading"><h3><?php _e('Support Ticket', 'wc-frontend-manager-ultimate'); ?></h3></div>
        
        <?php
        $WCFM->wcfm_fields->wcfm_generate_form_field(
            apply_filters(
                'wcfm_capability_settings_fields_vendor_support_ticket',
                [
                    'support_ticket'        => [
                        'label'       => __('View / Manage', 'wc-frontend-manager-ultimate'),
                        'name'        => 'wcfm_capability_options[support_ticket]',
                        'type'        => 'checkboxoffon',
                        'class'       => 'wcfm-checkbox wcfm_ele',
                        'value'       => 'yes',
                        'label_class' => 'wcfm_title checkbox_title',
                        'dfvalue'     => $support_ticket,
                    ],
                    'support_ticket_manage' => [
                        'label'       => __('Allow Reply', 'wc-frontend-manager-ultimate'),
                        'name'        => 'wcfm_capability_options[support_ticket_manage]',
                        'type'        => 'checkboxoffon',
                        'class'       => 'wcfm-checkbox wcfm_ele',
                        'value'       => 'yes',
                        'label_class' => 'wcfm_title checkbox_title',
                        'dfvalue'     => $support_ticket_manage,
                    ],
                ]
            )
        );
        ?>
        <?php
    }//end if
    ?>
    
    <?php if (apply_filters('wcfm_is_pref_notice', true)) { ?>
        <div class="wcfm_clearfix"></div>
        <div class="vendor_capability_sub_heading"><h3><?php _e('Notice', 'wc-frontend-manager-ultimate'); ?></h3></div>
        
        <?php
        $WCFM->wcfm_fields->wcfm_generate_form_field(
            apply_filters(
                'wcfm_capability_settings_fields_vendor_notice',
                [
                    'notice'       => [
                        'label'       => __('Notice', 'wc-frontend-manager-ultimate'),
                        'name'        => 'wcfm_capability_options[notice]',
                        'type'        => 'checkboxoffon',
                        'class'       => 'wcfm-checkbox wcfm_ele',
                        'value'       => 'yes',
                        'label_class' => 'wcfm_title checkbox_title',
                        'dfvalue'     => $notice,
                    ],
                    'notice_reply' => [
                        'label'       => __('Topic Reply', 'wc-frontend-manager-ultimate'),
                        'name'        => 'wcfm_capability_options[notice_reply]',
                        'type'        => 'checkboxoffon',
                        'class'       => 'wcfm-checkbox wcfm_ele',
                        'value'       => 'yes',
                        'label_class' => 'wcfm_title checkbox_title',
                        'dfvalue'     => $notice_reply,
                    ],
                ]
            )
        );
        ?>
        <?php
    }//end if
    ?>
    
    <div class="wcfm_clearfix"></div>
    <div class="vendor_capability_sub_heading"><h3><?php _e('Notification', 'wc-frontend-manager-ultimate'); ?></h3></div>
    
    <?php
    $WCFM->wcfm_fields->wcfm_generate_form_field(
        apply_filters(
            'wcfm_capability_settings_fields_header_panel',
            [
                'notification'   => [
                    'label'       => __('Notification', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[notification]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $notification,
                ],
                'direct_message' => [
                    'label'       => __('Direct Message', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[direct_message]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $direct_message,
                ],
                'knowledgebase'  => [
                    'label'       => __('Knowledgebase', 'wc-frontend-manager-ultimate'),
                    'name'        => 'wcfm_capability_options[knowledgebase]',
                    'type'        => 'checkboxoffon',
                    'class'       => 'wcfm-checkbox wcfm_ele',
                    'value'       => 'yes',
                    'label_class' => 'wcfm_title checkbox_title',
                    'dfvalue'     => $knowledgebase,
                ],
            ]
        )
    );

}//end wcfmu_capability_settings_miscellaneous_advanced()


