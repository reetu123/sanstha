<?php


class KMCPT
{
    private static $initiated = false;

    public $post_types;

    public function __construct()
    {
        $this->includes_files();
        add_action('init', array($this, 'init'));
    }

    public function init()
    {
        $this->init_hooks();

        $this->register_post();

        add_action('wp_enqueue_scripts', array($this, 'km_enqueue_style'));
        add_action('wp_enqueue_scripts', array($this, 'km_enqueue_script'));
        add_action('wp_ajax_km_load_upload_pics_ajax', array($this, 'km_load_profile_pics_ajax'));
        add_action('wp_ajax_nopriv_km_load_upload_pics_ajax', array($this, 'km_load_profile_pics_ajax'));
    }


    function km_load_profile_pics_ajax()
    {


        $current_user_id = get_current_user_id();

        if (!isset($current_user_id) || $current_user_id == '')
            $current_user_id = 'guest';
        new KMUploadHandler(null, $current_user_id, true, null);
        die();
    }

    function km_enqueue_style()
    {
        $style_path = plugin_dir_url(__FILE__) . "lib/fileupload/css/";

        wp_enqueue_style('blueimp-fileupload-ui-style', $style_path . 'jquery.fileupload-ui.css', array(), '');
        wp_enqueue_style('blueimp-gallery-style', $style_path . 'blueimp-gallery.min.css', array(), '');
        wp_enqueue_style('jquery.fileupload-style', $style_path . 'jquery.fileupload.css', array(), '');
    }

    public function km_enqueue_script()
    {
        $script_path = plugin_dir_url(__FILE__) . "lib/fileupload/js/";
        wp_enqueue_script('jquery-ui-script', '//code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), '', true);
        wp_enqueue_script('tmpl-script', $script_path . 'tmpl.min.js', array('jquery'), '', true);
        wp_enqueue_script('load-image-all-script', $script_path . 'load-image.all.min.js', array('jquery'), '', true);
        wp_enqueue_script('canvas-to-blob-script', $script_path . 'canvas-to-blob.min.js', array('jquery'), '', true);
        wp_enqueue_script('jquery-blueimp-gallery-script', $script_path . 'jquery.blueimp-gallery.min.js', array('jquery'), '', true);
        wp_enqueue_script('jquery-iframe-transport-script', $script_path . 'jquery.iframe-transport.js', array('jquery'), '', true);
        wp_enqueue_script('jquery-fileupload-script', $script_path . 'jquery.fileupload.js', array('jquery'), '', true);
        wp_enqueue_script('jquery-fileupload-process-script', $script_path . 'jquery.fileupload-process.js', array('jquery'), '', true);
        wp_enqueue_script('jquery-fileupload-image-script', $script_path . 'jquery.fileupload-image.js', array('jquery'), '', true);
        wp_enqueue_script('jquery-fileupload-validate-script', $script_path . 'jquery.fileupload-validate.js', array('jquery'), '', true);
        wp_enqueue_script('jquery-fileupload-ui-script', $script_path . 'jquery.fileupload-ui.js', array('jquery'), '', true);
    }


    public function includes_files()
    {
        require_once "inc/KMUploadHandler.php";
        require_once "global.functions.php";
        require_once "class.js.hooks.php";
        require_once "class.css.hooks.php";
        require_once "class.kmlist.php";
        require_once "km-custom-widget.php";
    }

    function get_plugin_path()
    {
        return untrailingslashit(plugin_dir_path(__FILE__));
    }


    public function init_hooks()
    {
        $this->post_types = apply_filters('kmpl_register_post_types',
            array(
                'km-services' => array(
                    'labels' => array(
                        'name' => 'Km Services',
                        'singular_name' => 'Km Services',
                        'add_new' => 'Add New',
                        'add_new_item' => 'Add New',
                        'edit_item' => 'Edit',
                        'new_item' => 'New',
                        'all_items' => 'All Services',
                        'view_item' => 'View Services',
                        'search_items' => 'Search Service',
                        'not_found' => 'No Service found',
                        'not_found_in_trash' => 'No Service found in the Trash',
                        'menu_name' => 'Km Services'
                    ),
                    'rewrite' => array('slug' => 'service'),
                    'public' => true,
                    'menu_position' => 16,
                    'supports' => array('title', 'editor', 'thumbnail'),
                    'has_archive' => true
                ),
            )
        );
    }

    public function register_post()
    {
        foreach ($this->post_types as $key => $post_type) {
            register_post_type($key, $post_type);
        }
    }

}

global $kmcpt;
$kmcpt = new KMCPT();
