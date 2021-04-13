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

        // Handle IDs passed in the shortcode and convert to integers
        $hub_id = $atts['id'];

        $post_ids = explode(',', trim($atts['resources']));
        $post_ids = array_map(function($n){return (int)$n;}, $post_ids);

        return $this->resource_hub_render($hub_id, $post_ids);
    }

    public function resource_hub_render(string $hub_id, array $post_ids = [])
    {
        // To avoid multiple network calls, this plugin is output as a single chunk of text
        ob_start();

        // First, we render the HTML + CSS structure that will be populated via JSON.
        $dir = plugin_dir_path( __FILE__ );
        $file_path = "partials/iswp-resource-hub-public-display.php";
        $this->include_with_variables($dir . $file_path, ['hub_id' => $hub_id]);

        // Then, the JSON payload is output
        $json_data = $this->get_resources_list($post_ids);
        echo "
        <script>
            if (window.reshub_json === undefined) {
                window.reshub_json = [];
            }
            window.reshub_json['{$hub_id}'] = {$json_data};
        </script>";

        // The rest of the JS is already output using wp_enqueue_script (somewhere else in this file).

        // Return everything
        return ob_get_clean();
    }

    function include_with_variables($filePath, $variables = array(), $print = true)
    {
        $output = NULL;
        if(file_exists($filePath)){
            extract($variables);
            ob_start();
            include $filePath;
            $output = ob_get_clean();
        }
        if ($print) {
            print $output;
        }
        return $output;
    }

    public function get_resources_list($post_ids)
    {
        // Find posts via WP_Query
        $query = new WP_Query([
            'post_type' => 'resources',
            'post__in'  => $post_ids,
            'orderby' => 'post_name__in', // Keep the given order
            'suppress_filters' => false,
            'posts_per_page' => 18,
        ]);
        $posts = $query->posts;

        // Iterate posts and create the JSON structure
        $data_all = [];
        foreach ($posts as $post) {

            // Basic data
            $data_post['id']     = $post->ID;
            $data_post['title']       = $post->post_title;
            $data_post['description'] = $post->post_content;
            $data_post['image']       = get_the_post_thumbnail_url($post->ID, 'full');
            $data_post['year']        = get_post_meta($post->ID, '_resource_year', true);
            $data_post['link']        = get_post_meta($post->ID, '_resource_link', true);

            // Keywords data
            $taxonomy_terms = wp_get_object_terms($post->ID, ['resource_keywords']);
            $keywords = [];
            foreach($taxonomy_terms as $taxonomy_term) {
                $keywords[] = $taxonomy_term->name;
            }
            $data_post['keywords'] = implode(', ', $keywords);

            // Add data to array
            $data_all[] = $data_post;
        }
        return json_encode($data_all);
    }

}
