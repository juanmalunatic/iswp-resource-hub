<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       jmlunalopez.com/wordpress-plugins
 * @since      1.0.0
 *
 * @package    Iswp_Resource_Hub
 * @subpackage Iswp_Resource_Hub/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iswp_Resource_Hub
 * @subpackage Iswp_Resource_Hub/admin
 * @author     Juan M. Luna <lunalopezjm@gmail.com>
 */
class Iswp_Resource_Hub_Admin
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
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/iswp-resource-hub-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/iswp-resource-hub-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * Create the Custom Post Type "Resource"
     */

    public function create_cpt_resource()
    {
        $labels = [
            'name'                => _x('Resource', 'Post Type General Name'),
            'singular_name'       => _x('Resource', 'Post Type Singular Name'),
            'menu_name'           => __('Resources'),
            'parent_item_colon'   => __('Parent Resource'),
            'all_items'           => __('All Resources'),
            'view_item'           => __('View Resource'),
            'add_new_item'        => __('Add New Resource'),
            'add_new'             => __('Add New'),
            'edit_item'           => __('Edit Resource'),
            'update_item'         => __('Update Resource'),
            'search_items'        => __('Search Resource'),
            'not_found'           => __('Not Found'),
            'not_found_in_trash'  => __('Not found in Trash'),
        ];

        $args = [
            'label'               => __('resources'),
            'description'         => __('Resources'),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            // You can associate this CPT with a taxonomy or custom taxonomy.
            // 'taxonomies'          => array('genres'),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'show_in_rest'        => true,
            'menu_icon'           => 'dashicons-book',
        ];

        // Registering your Custom Post Type
        register_post_type( 'resources', $args );

    }

}
