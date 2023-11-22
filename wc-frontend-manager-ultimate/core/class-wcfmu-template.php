<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * @class WCFM Template Class
 *
 * @version 4.1.7
 * @package WC
 * @author  WC Lovers
 */
class WCFMu_Template
{

    public $template_url;


    public function __construct()
    {
            $this->template_url = 'wcfm/';

    }//end __construct()


    /**
     * Get other templates (e.g. product attributes) passing attributes and including the file.
     *
     * @access public
     * @param  mixed  $template_name
     * @param  array  $args          (default: array())
     * @param  string $template_path (default: '')
     * @param  string $default_path  (default: '')
     * @return void
     */
    public function get_template($template_name, $args=[], $template_path='', $default_path='')
    {
        if ($args && is_array($args)) {
                extract($args);
        }

            $located = $this->locate_template($template_name, $template_path, $default_path);

            include $located;

    }//end get_template()


    /**
     * Locate a template and return the path for inclusion.
     *
     * This is the load order:
     *
     *      yourtheme       /   $template_path  /   $template_name
     *      yourtheme       /   $template_name
     *      $default_path   /   $template_name
     *
     * @access public
     * @param  mixed  $template_name
     * @param  string $template_path (default: '')
     * @param  string $default_path  (default: '')
     * @return string
     */
    public function locate_template($template_name, $template_path='', $default_path='')
    {
            global $woocommerce, $WCFMu;
            $default_path = apply_filters('wcfm_template_path', $default_path);
        if (! $template_path) {
                $template_path = $this->template_url;
        }

        if (! $default_path) {
                $default_path = $WCFMu->plugin_path.'views/';
        }

            // Look within passed path within the theme - this is priority
            $template = locate_template([ trailingslashit($template_path).$template_name, $template_name ]);
            // Add support of third perty plugin
            $template = apply_filters('wcfm_locate_template', $template, $template_name, $template_path, $default_path);
            // Get default template
        if (! $template) {
                $template = $default_path.$template_name;
        }

            return $template;

    }//end locate_template()


    /**
     * Get template part (for templates like the shop-loop).
     *
     * @access public
     * @param  mixed  $slug
     * @param  string $name (default: '')
     * @return void
     */
    public function get_template_part($slug, $name='')
    {
            global $WCFMu;
            $template = '';

            // Look in yourtheme/slug-name.php and yourtheme/wcfm/slug-name.php
        if ($name) {
                $template = $this->locate_template([ "{$slug}-{$name}.php", "{$this->template_url}{$slug}-{$name}.php" ]);
        }

            // Get default slug-name.php
        if (! $template && $name && file_exists($WCFMu->plugin_path."views/{$slug}-{$name}.php")) {
                $template = $WCFMu->plugin_path."views/{$slug}-{$name}.php";
        }

            // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/wcfm/slug.php
        if (! $template) {
                $template = $this->locate_template([ "{$slug}.php", "{$this->template_url}{$slug}.php" ]);
        }

            echo $template;

        if ($template) {
                load_template($template, false);
        }

    }//end get_template_part()


    public function get_img_src($thumbnail_id=false)
    {
        if (! empty($thumbnail_id)) {
            $image = wp_get_attachment_thumb_url($thumbnail_id);
        } else {
            $wvs_version = defined( 'WVS_PRO_PLUGIN_VERSION' ) ? WVS_PRO_PLUGIN_VERSION : WOO_VARIATION_SWATCHES_PRO_PLUGIN_VERSION;

            if( version_compare( $wvs_version, '2.0', '<' ) ) {
                $image = woo_variation_swatches()->images_uri('placeholder.png');
            } else {
                $image = woo_variation_swatches()->images_url('/placeholder.png');
            }
        }

        return $image;

    }//end get_img_src()


    function select_array($search, $haystack, $type='selected')
    {
        if (in_array($search, $haystack)) {
            echo "$type='$type'";
        }

    }//end select_array()


}//end class
