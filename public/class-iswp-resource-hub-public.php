<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       jmlunalopez.com/wordpress-plugins
 * @since      1.0.0
 *
 * @package    Iswp_Resource_Hub
 * @subpackage Iswp_Resource_Hub/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Iswp_Resource_Hub
 * @subpackage Iswp_Resource_Hub/public
 * @author     Juan M. Luna <lunalopezjm@gmail.com>
 */
class Iswp_Resource_Hub_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function register_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Iswp_Resource_Hub_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Iswp_Resource_Hub_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_register_style('iswp_reshub_css_public', plugin_dir_url(__FILE__) . 'css/iswp-resource-hub-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function register_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Iswp_Resource_Hub_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Iswp_Resource_Hub_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_register_script('iswp_reshub_js_public', plugin_dir_url(__FILE__) . 'js/iswp-resource-hub-public.js', array('jquery'), $this->version, false);

    }

    public function register_shortcodes()
    {
        add_shortcode('iswp_resource_hub', [$this, 'shortcode_render']);
    }


    public function shortcode_render($atts = [], $content = null, $tag = '')
    {
        // Enqueue styles/scripts only when shortcode is present
        wp_enqueue_style('iswp_reshub_css_public');
        wp_enqueue_script('iswp_reshub_js_public');

        // Handle IDs and convert to integers
        $ids = explode(',', trim($atts['show_ids']));
        $ids = array_map(function($n){return (int)$n;}, $ids);

        $a = "b";
        return "Lmao";
    }

}
