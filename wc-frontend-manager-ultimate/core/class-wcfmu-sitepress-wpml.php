<?php

/**
 * WCFMu plugin core
 *
 * Plugin Sitepress WPML Controler
 *
 * @author  WC Lovers
 * @package wcfmu/core
 * @version 3.2.0
 */

class WCFMu_Sitepress_WPML extends WPML_WPDB_And_SP_User
{
    public function __construct()
    {
        global $WCFM, $WCFMu;

        if (defined('ICL_SITEPRESS_VERSION') && !ICL_PLUGIN_INACTIVE && class_exists('SitePress')) {
            add_filter('wcfm_get_endpoint_url', [&$this, 'wpml_wcfm_get_endpoint_url'], 500, 4);

            add_action('wcfm_load_scripts', [&$this, 'wpml_wcfm_load_scripts'], 80);
            add_action('after_wcfm_load_scripts', [&$this, 'wpml_wcfm_load_scripts'], 80);

            add_action('wp_ajax_wcfm_product_translations', [&$this, 'wpml_wcfm_product_translations']);

            add_action('wp_ajax_wcfm_product_new_translation', [&$this, 'wpml_wcfm_product_new_translation']);

            add_action('wcfm_product_manager_right_panel_after', [&$this, 'wpml_wcfm_product_manager_translations'], 200);

            add_filter('icl_ls_languages', [&$this, 'maybe_change_ls_urls']);

            add_filter('template_redirect', [&$this, 'maybe_translate_product']);
            
            add_filter('after_wcfm_products_manage_meta_save', [&$this, 'sync_product'], 511, 2);
        }
    } //end __construct()


    function wpml_wcfm_get_endpoint_url($url, $endpoint, $value, $permalink)
    {
        global $WCFM;

        switch ($endpoint) {
            case 'wcfm-products-manage':
                if ($value) {
                    $product_language_details = apply_filters('wpml_post_language_details', null, $value);
                    $language_code            = isset($product_language_details['language_code']) ? $product_language_details['language_code'] : '';
                    if ($language_code) {
                        $pages = get_option('wcfm_page_options');
                        if (isset($pages['wc_frontend_manager_page_id'])) {
                            $permalink = get_permalink(apply_filters( 'wpml_object_id', $pages['wc_frontend_manager_page_id'], 'page', false, $language_code ));
                            $permalink = apply_filters('wpml_permalink', $permalink, $language_code);
                            if (get_option('permalink_structure')) {
                                if (strstr($permalink, '?')) {
                                    $query_string = '?' . parse_url($permalink, PHP_URL_QUERY);
                                    $permalink    = current(explode('?', $permalink));
                                } else {
                                    $query_string = '';
                                }

                                $url = trailingslashit($permalink) . $endpoint . '/' . $value . $query_string;
                            } else {
                                $url = add_query_arg($endpoint, $value, $permalink);
                            }
                        }
                    }
                } //end if
                break;
        } //end switch

        return $url;
    } //end wpml_wcfm_get_endpoint_url()


    /**
     * WPML Scripts
     */
    public function wpml_wcfm_load_scripts($end_point)
    {
        global $WCFM, $WCFMu;

        switch ($end_point) {
            case 'wcfm-products-manage':
                wp_enqueue_script('wcfm_wpml_products_manage_js', $WCFMu->library->js_lib_url . 'integrations/wcfm-script-wpml-products-manage.js', ['jquery', 'wcfm_products_manage_js'], $WCFMu->version, true);
                break;
        }
    } //end wpml_wcfm_load_scripts()


    /**
     * Get Translations table content for Product manager
     *
     * @return string
     */
    function wpml_wcfm_product_translations()
    {
        global $WCFM, $WCFMu, $sitepress, $wpml_post_translations, $_POST;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        $translation_html = '';
        if (isset($_POST['proid']) && !empty($_POST['proid'])) {
            $product_id = $_POST['proid'];
            if ($product_id) {
                $active_languages = $this->get_filtered_active_lanugages();
                if (count($active_languages) <= 1) {
                    return;
                }

                $current_language = $sitepress->get_current_language();
                unset($active_languages[$current_language]);

                if (count($active_languages) > 0) {
                    foreach ($active_languages as $language_data) {
                        $translated_id        = $wpml_post_translations->element_id_in($product_id, $language_data['code']);
                        $trid                 = $wpml_post_translations->get_element_trid($product_id);
                        $translation_edit_url = '';
                        if ($translated_id) {
                            $translate_text = sprintf(__('Edit the %s translation', 'sitepress'), $language_data['display_name']);
                            // wcfm_log( $translated_id . ":aa:" . $language_data['code'] );
                            $translation_edit_url = '<a href="' . get_wcfm_edit_product_url($translated_id, [], $language_data['code']) . '" title="' . $translate_text . '"><img style="padding:1px;margin:2px;" border="0" src="' . ICL_PLUGIN_URL . '/res/img/edit_translation.png" alt="' . $translate_text . '" width="16" height="16" /></a>';
                        } else {
                            $translate_text       = sprintf(__('Add translation to %s', 'sitepress'), $language_data['display_name']);
                            $translation_edit_url = '<a href="#" class="wcfm_product_new_translation" data-trid="' . $trid . '" data-source_lang="' . $current_language . '" data-proid="' . $product_id . '" data-lang="' . $language_data['code'] . '" title="' . $translate_text . '"><img style="padding:1px;margin:2px;" border="0" src="' . ICL_PLUGIN_URL . '/res/img/add_translation.png" alt="' . $translate_text . '" width="16" height="16" /></a>';
                        }

                        $translation_html .= '<tr><td><img src="' . $sitepress->get_flag_url($language_data['code']) . '" width="18" height="12" alt="' . $language_data['display_name'] . '" title="' . $language_data['display_name'] . '" style="margin:2px" /></td>';
                        $translation_html .= '<td>' . $translation_edit_url . '</td></tr>';
                    }
                }
            } //end if
        } //end if

        echo $translation_html;
        die;
    } //end wpml_wcfm_product_translations()


    /**
     * Generate new Translation for WCFM Products
     */
    function wpml_wcfm_product_new_translation()
    {
        global $WCFM, $WCFMu, $sitepress, $wpml_post_translations, $_POST, $wpdb;

        if ( ! check_ajax_referer( 'wcfm_ajax_nonce', 'wcfm_ajax_nonce', false ) ) {
            wp_send_json_error( __( 'Invalid nonce! Refresh your page and try again.', 'wc-frontend-manager-ultimate' ) );
			wp_die();
		}

        if (isset($_POST['proid']) && !empty($_POST['proid'])) {
            $product_id = absint($_POST['proid']);
            if ($product_id) {
                if (isset($_POST['lang']) && !empty($_POST['lang'])) {
                    $lang_code  = $_POST['lang'];
                    $trid       = $_POST['trid'];
                    if ($lang_code && $trid) {
                        $response = $this->create_duplicate_product($product_id, $lang_code, $trid);

                        // Redirect to the edit screen for the new draft page
                        wp_send_json( $response );
                    } //end if
                } //end if
            } //end if
        } //end if
    } //end wpml_wcfm_product_new_translation()


    /**
     * Generate Translation block for WCFM Product manager
     */
    function wpml_wcfm_product_manager_translations($product_id)
    {
        global $WCFM, $WCFMu, $sitepress, $wpml_post_translations;

        if (!$product_id) {
            return;
        }

        if ( ! apply_filters( 'wcfmu_is_allow_wpml_product_manager_translations', true, $product_id ) ) {
            return;
        }

        $active_languages = $this->get_filtered_active_lanugages();
        if (count($active_languages) <= 1) {
            return;
        }

        $current_language = $sitepress->get_current_language();
        unset($active_languages[$current_language]);

        if (count($active_languages) > 0) {
            $translation_html = '';
            ?>
            <div style="max-width: 214px; margin: 0 auto;">
                <p class="product_translations wcfm_title wcfm_full_ele"><strong><?php _e('Translations', 'wc-frontend-manager-ultimate'); ?></strong></p>
                <label class="screen-reader-text" for="product_translations"><?php _e('Translations', 'wc-frontend-manager-ultimate'); ?></label>

                <table style="margin-top:0px;">
                    <tbody id="wcfm_product_translations" data-product_id="<?php echo $product_id; ?>">
                        <?php echo $translation_html; ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
    } //end wpml_wcfm_product_manager_translations()


    /**
     * Get list of active languages.
     *
     * @return array
     */
    private function get_filtered_active_lanugages()
    {
        global $sitepress;

        $active_languages = $sitepress->get_active_languages();
        return apply_filters('wpml_active_languages_access', $active_languages, ['action' => 'edit']);
    } //end get_filtered_active_lanugages()

    /**
     * Changes language switcher url's in product-manage page
     * 
     * @param array $languages
     * @return array $languages
     */
    public function maybe_change_ls_urls( $languages )
    {
        global $wp, $wpml_post_translations, $sitepress;

        $current_language = $sitepress->get_current_language();
        
        $product_id = 0;
        if (isset($wp->query_vars['wcfm-products-manage']) && !empty($wp->query_vars['wcfm-products-manage'])) {
            $product_id = $wp->query_vars['wcfm-products-manage'];

            foreach ($languages as $lang_code => $language) {

                if( $lang_code == $current_language ) continue;
                
                $translated_id = $wpml_post_translations->element_id_in( $product_id, $lang_code );

                $pages = get_option("wcfm_page_options");
                $store_manager_page = $pages['wc_frontend_manager_page_id'];

                if ($translated_id) {
                    $sitepress->switch_lang( $language['language_code'] );
                
                    $store_manager_page     = _get_page_link( $wpml_post_translations->element_id_in( $store_manager_page, $language['language_code']) );
                    $store_manager_page     = apply_filters( 'wpml_permalink', $store_manager_page, $language['language_code'] );
                    $wcfm_edit_product_url  = wcfm_get_endpoint_url( 'wcfm-products-manage', $translated_id, $store_manager_page, $language['language_code'] );
                    $wcfm_edit_product_url  = apply_filters( 'wcfm_edit_product_url',  $wcfm_edit_product_url, $translated_id );
                    
                    $sitepress->switch_lang();

                    $languages[$lang_code]['url'] = $wcfm_edit_product_url;
                } else {
                    $languages[$lang_code]['url'] = add_query_arg( array(
                        'wcfm_lang_code' => $lang_code,
                    ), $languages[$lang_code]['url'] );
                }
            }
        }
        return $languages;
    }

    /**
     * Creates translated product if not already translated
     */
    public function maybe_translate_product() {
        global $wp, $sitepress, $wpml_post_translations;
    
        $product_id = 0;
        $current_language = '';
        if (isset($wp->query_vars['wcfm-products-manage']) && !empty($wp->query_vars['wcfm-products-manage'])) {
            $product_id = $wp->query_vars['wcfm-products-manage'];

            if ( ! $product_id ) return;

            $current_language = isset( $_GET['wcfm_lang_code'] ) ? sanitize_text_field( $_GET['wcfm_lang_code'] ) : $current_language;
            
            if ( ! $current_language ) return;
            
            $translated_id = $wpml_post_translations->element_id_in( $product_id, $current_language );
            $trid = $wpml_post_translations->get_element_trid( $product_id );

            if (!$translated_id) {
                $response = $this->create_duplicate_product( $product_id, $current_language, $trid );
    
                if (isset($response['status']) && true == $response['status']) {
                    if (isset($response['redirect'])) {
                        if (wp_redirect($response['redirect'])) {
                            exit();
                        }
                    }
                }
            }
        }
    }

    /**
     * Creates duplicate product for new language
     * 
     * @param int $product_id
     * @param string $lang_code
     * @param int $trid
     * @return array
     */
    public function create_duplicate_product( $product_id, $lang_code, $trid )
    {
        global $sitepress, $wpdb;

        if ($product_id) {
            if ($lang_code) {
                $product = wc_get_product($product_id);
                if (false === $product) {
                    // translators: %s: product id
                    return [
                        'status'    => false,
                        'message'   => sprintf(__('Product creation failed, could not find original product: %s', 'woocommerce'), $product_id)
                    ];
                }

                if (!class_exists('WC_Admin_Duplicate_Product')) {
                    include WC_ABSPATH . 'includes/admin/class-wc-admin-duplicate-product.php';
                }

                $WC_Admin_Duplicate_Product = new WC_Admin_Duplicate_Product();
                $duplicate                  = $WC_Admin_Duplicate_Product->product_duplicate($product);

                // Hook rename to match other woocommerce_product_* hooks, and to move away from depending on a response from the wp_posts table.
                // do_action( 'woocommerce_product_duplicate', $duplicate, $product );
                // do_action( 'after_wcfm_product_duplicate', $duplicate->get_id(), $product );
                $vendor_id = wcfm_get_vendor_id_by_post($product_id);
                if (!$vendor_id) {
                    $vendor_id = apply_filters('wcfm_current_vendor_id', get_current_user_id());
                }

                // Update translated post to sete title/content empty
                $my_post = apply_filters(
                    'wcfm_translated_product_content_before_save',
                    [
                        'ID'           => $duplicate->get_id(),
                        'post_title'   => get_the_title($product_id) . ' (' . $lang_code . ' copy)',
                        'post_author'  => $vendor_id,
                        'post_content' => '',
                        'post_excerpt' => '',
                    ],
                    $product_id
                );
                wp_update_post($my_post);

                update_post_meta($duplicate->get_id(), '_wcfm_product_views', 0);

                // Connect Translations
                $original_element_language = $sitepress->get_default_language();
                $trid_elements             = $sitepress->get_element_translations($trid, 'post_product');
                if ($trid_elements) {
                    foreach ($trid_elements as $trid_element) {
                        if ($trid_element->original) {
                            $original_element_language = $trid_element->language_code;
                            break;
                        }
                    }
                }

                $wpdb->update(
                    $wpdb->prefix . 'icl_translations',
                    [
                        'source_language_code' => $original_element_language,
                        'trid'                 => $trid,
                    ],
                    [
                        'element_id'   => $duplicate->get_id(),
                        'element_type' => 'post_product',
                    ],
                    [
                        '%s',
                        '%d',
                        '%s',
                    ],
                    [
                        '%d',
                        '%s',
                    ]
                );

                do_action(
                    'wpml_translation_update',
                    [
                        'type'         => 'update',
                        'trid'         => $trid,
                        'element_id'   => $duplicate->get_id(),
                        'element_type' => 'post_product',
                        'context'      => 'post',
                    ]
                );

                // Product Custom Taxonomies - 6.0.3
                $product_taxonomies = get_object_taxonomies('product', 'objects');
                if (!empty($product_taxonomies)) {
                    foreach ($product_taxonomies as $product_taxonomy) {
                        if (!in_array($product_taxonomy->name, ['product_cat', 'product_tag', 'wcpv_product_vendors'])) {
                            if ($product_taxonomy->public && $product_taxonomy->show_ui && $product_taxonomy->meta_box_cb && $product_taxonomy->hierarchical) {
                                $taxonomy_values = get_the_terms($product->get_id(), $product_taxonomy->name);
                                $is_translated   = $sitepress->is_translated_taxonomy($product_taxonomy);
                                $is_first        = true;
                                if (!empty($taxonomy_values)) {
                                    foreach ($taxonomy_values as $pkey => $ptaxonomy) {
                                        if ($is_translated) {
                                            $term_id = apply_filters('translate_object_id', (int) $ptaxonomy->term_id, $product_taxonomy->name, false, $lang_code);
                                        } else {
                                            $term_id = (int) $ptaxonomy->term_id;
                                        }

                                        if ($is_first) {
                                            $is_first = false;
                                            wp_set_object_terms($duplicate->get_id(), $term_id, $product_taxonomy->name);
                                        } else {
                                            wp_set_object_terms($duplicate->get_id(), $term_id, $product_taxonomy->name, true);
                                        }
                                    }
                                }
                            } //end if
                        } //end if
                    } //end foreach
                } //end if

                do_action('wcfm_after_translated_new_product', $duplicate->get_id());

                // Redirect to the edit screen for the new draft page
                return [
                    'status'    => true,
                    'redirect'  => get_wcfm_edit_product_url($duplicate->get_id()),
                    'id'        => $duplicate->get_id()
                ];
            } //end if
        } //end if
    }

    public function sync_product( $post_id, $fields ) {
        global $wpml_post_translations, $woocommerce_wpml;

        if( method_exists( $wpml_post_translations, 'save_post_actions' ) ) {
		    $wpml_post_translations->save_post_actions( $post_id, null );
        }

        // Variable product translation
        if( WCFMu_Dependencies::is_woocommerce_multilingual_active() ) {
            if( isset( $woocommerce_wpml->sync_product_data ) ) {
                if( method_exists( $woocommerce_wpml->sync_product_data, 'synchronize_products' ) ) {
                    $woocommerce_wpml->sync_product_data->synchronize_products( $post_id, get_post( $post_id ), true );
                }
            }
        }
    }
}//end class
