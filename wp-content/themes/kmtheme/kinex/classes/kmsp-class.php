<?php


if (!class_exists('KM_Main')) {
    global $KMtheme;

    class KM_Main
    {

        protected $_register_sidebars;

        protected $_custom_post;

        function __construct()
        {
            $this->_custom_post = array(
              
                'slider' =>
                array(
                    'labels' => array(
                        'name' => _x('Slider', 'slider', 'kmtheme'),
                        'singular_name' => _x('Slider', 'post type singular name', 'kmtheme'),
                        'menu_name' => _x('Sliders', 'admin menu', 'kmtheme'),
                        'name_admin_bar' => _x('Slider', 'add new on admin bar', 'kmtheme'),
                        'add_new' => _x('Add New Slider', 'slider', 'kmtheme'),
                        'add_new_item' => __('Add New Slider', 'kmtheme'),
                        'new_item' => __('New Slider', 'kmtheme'),
                        'edit_item' => __('Edit Slider', 'kmtheme'),
                        'view_item' => __('View Slider', 'kmtheme'),
                        'all_items' => __('All Sliders', 'kmtheme'),
                        'search_items' => __('Search Sliders', 'kmtheme'),
                        'parent_item_colon' => __('Parent Sliders:', 'kmtheme'),
                        'not_found' => __('No sliders found.', 'kmtheme'),
                        'not_found_in_trash' => __('No sliders found in Trash.', 'kmtheme')
                    ),
                    'description' => __('Description.', 'kmtheme'),
                    'public' => true,
                    'publicly_queryable' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'query_var' => true,
                    'rewrite' => array('slug' => 'slider'),
                    'capability_type' => 'post',
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => null,
                    'supports' => array('title')
                ),

                'leadership' =>
                array(
                    'labels' => array(
                        'name' => _x('Leadership', 'leadership', 'kmtheme'),
                        'singular_name' => _x('Leadership', 'leadership', 'kmtheme'),
                        'menu_name' => _x('Leaderships', 'leaderships', 'kmtheme'),
                        'name_admin_bar' => _x('Leadership', 'leadership', 'kmtheme'),
                        'add_new' => _x('Add New', 'leadership', 'kmtheme'),
                        'add_new_item' => __('Add New Leadership', 'kmtheme'),
                        'new_item' => __('New Leadership', 'kmtheme'),
                        'edit_item' => __('Edit Leadership', 'kmtheme'),
                        'view_item' => __('View Leadership', 'kmtheme'),
                        'all_items' => __('All Leaderships', 'kmtheme'),
                        'search_items' => __('Search Leadershipa', 'kmtheme'),
                        'parent_item_colon' => __('Parent Leadershipa:', 'kmtheme'),
                        'not_found' => __('No leadership found.', 'kmtheme'),
                        'not_found_in_trash' => __('No leadership found in Trash.', 'kmtheme')
                    ),
                    'description' => __('Description.', 'kmtheme'),
                    'public' => true,
                    'publicly_queryable' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'query_var' => true,
                    'rewrite' => array('slug' => 'leadership'),
                    'capability_type' => 'post',
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => null,
                    'supports' => array('title', 'editor', 'author', 'thumbnail')
                ),
                'event' =>
                array(
                    'labels' => array(
                        'name' => _x('Events', 'event', 'kmtheme'),
                        'singular_name' => _x('Events', 'event', 'kmtheme'),
                        'menu_name' => _x('Events', 'admin menu', 'kmtheme'),
                        'name_admin_bar' => _x('Event', 'add new on admin bar', 'kmtheme'),
                        'add_new' => _x('Add New', 'event', 'kmtheme'),
                        'add_new_item' => __('Add New Event', 'kmtheme'),
                        'new_item' => __('New Event', 'kmtheme'),
                        'edit_item' => __('Edit Event', 'kmtheme'),
                        'view_item' => __('View Event', 'kmtheme'),
                        'all_items' => __('All Events', 'kmtheme'),
                        'search_items' => __('Search Events', 'kmtheme'),
                        'parent_item_colon' => __('Parent Events:', 'kmtheme'),
                        'not_found' => __('No events found.', 'kmtheme'),
                        'not_found_in_trash' => __('No events found in Trash.', 'kmtheme')
                    ),
                    'description' => __('Description.', 'kmtheme'),
                    'public' => true,
                    'publicly_queryable' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'query_var' => true,
                    'rewrite' => array('slug' => 'event'),
                    'capability_type' => 'post',
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => null,
                    'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments')
                ),
                'advertisement' =>
                array(
                    'labels' => array(
                        'name' => _x('Advertisement', 'Advertisement', 'kmtheme'),
                        'singular_name' => _x('Advertisement', 'Advertisement', 'kmtheme'),
                        'menu_name' => _x('Advertisement', 'admin menu', 'kmtheme'),
                        'name_admin_bar' => _x('Advertisement', 'add new on admin bar', 'kmtheme'),
                        'add_new' => _x('Add New', 'Advertisement', 'kmtheme'),
                        'add_new_item' => __('Add New Advertisement', 'kmtheme'),
                        'new_item' => __('New Advertisement', 'kmtheme'),
                        'edit_item' => __('Edit Advertisement', 'kmtheme'),
                        'view_item' => __('View Advertisement', 'kmtheme'),
                        'all_items' => __('All Advertisement', 'kmtheme'),
                        'search_items' => __('Search Advertisements', 'kmtheme'),
                        'parent_item_colon' => __('Parent Advertisements:', 'kmtheme'),
                        'not_found' => __('No advertisements found.', 'kmtheme'),
                        'not_found_in_trash' => __('No advertisements found in Trash.', 'kmtheme')
                    ),
                    'description' => __('Description.', 'kmtheme'),
                    'public' => true,
                    'publicly_queryable' => true,
                    'show_ui' => true,
                    'show_in_menu' => true,
                    'query_var' => true,
                    'rewrite' => array('slug' => 'advertisement'),
                    'capability_type' => 'post',
                    'has_archive' => true,
                    'hierarchical' => false,
                    'menu_position' => null,
                    'supports' => array('title')
                )


            );
$this->_register_sidebars = apply_filters(
    'kmsp_register_sidebars', array(
        array(
            'name' => __('Main Sidebar', 'twentyseventeen'),
            'id' => 'sidebar-1',
            'description' => __('Add widgets here to appear in your sidebar on  archive pages.', 'twentyseventeen'),
        ),
        array(
            'name' => 'Top News Bar',
            'id' => 'sidebar-top',
            'description' => 'Widgets in this area will be shown on top.'
        ),
        array(
            'name' => 'Home SideBar',
            'id' => 'sidebar-home',
            'description' => 'Widgets in this area will be shown on home sidebar.'
        ),
        array(
            'name' => __('Blog Sidebar', 'twentyseventeen'),
            'id' => 'sidebar-blog',
            'description' => __('Add widgets here to appear in your sidebar on blog posts.', 'twentyseventeen'),
        ),
        array(
            'name' => __('Footer 1', 'twentyseventeen'),
            'id' => 'sidebar-2',
            'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        ),
        array(
            'name' => __('Footer 2', 'twentyseventeen'),
            'id' => 'sidebar-3',
            'description' => __('Add widgets here to appear in your footer.', 'twentyseventeen'),
        ),
        array(
            'name' => 'Footer 3',
            'id' => 'sidebar-4',
            'description' => 'Widgets in this area will be shown on footer.'
        ),
        array(
            'name' => 'Footer 4',
            'id' => 'sidebar-5',
            'description' => 'Widgets in this area will be shown on footer.'
        ),
        array(
            'name' => 'Footer 5',
            'id' => 'sidebar-6',
            'description' => 'Widgets in this area will be shown on footer.'
        )
    )
);


$this->init_hooks();
}

function init_hooks()
{


    add_action('init', array($this, 'kmsp_register_menu'));

    add_action('widgets_init', array($this, 'kmsp_register_sidebar'));

    add_action('init', array($this, 'kmsp_register_custom_post'));

    add_action('wp_enqueue_scripts', array($this, 'kmsp_register_scripts'));
    add_action('kmsp_accordion_add_action',array($this,'kmsp_accordion_add_action'));

}

        /**
         * Register Custom Post
         */

        function kmsp_register_custom_post()
        {


            foreach ($this->_custom_post as $key => $post) {
                register_post_type($key, $post);
            }
        }


        function kmsp_register_scripts()
        {
            wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/kinex/assets/css/fontawesome-all.min.css');
            wp_enqueue_script('owl-carousel-js', get_template_directory_uri() . '/assets/dist/owl.carousel.min.js', array('jquery'));
            wp_enqueue_script('accordion-js', get_template_directory_uri() . '/kinex/assets/accordion/dist/accordion.js', array('jquery'));
            wp_enqueue_script('custom-js', get_template_directory_uri() . '/kinex/assets/js/custom.js', array('jquery'));

        }


        function kmsp_register_menu()
        {
            register_nav_menus(array(
                'home' => __('Home Page Menu', 'kmtheme'),
            ));
        }

        /*
         * Register Sidebar
         */
        function kmsp_register_sidebar()
        {
            foreach ($this->_register_sidebars as $sidebar):

                register_sidebar(array(
                    'name' => __($sidebar['name'], 'kmtheme'),
                    'id' => $sidebar['id'],
                    'description' => __($sidebar['description'], 'kmtheme'),
                    'before_widget' => '<ul id="%1$s" class="widget %2$s">',
                    'after_widget' => '</ul>',
                    'before_title' => '<h2 class="widget-title">',
                    'after_title' => '</h2>',
                ));
            endforeach;
        }

        /**
         * Accordion Action Init
         */

        function kmsp_accordion_add_action(){

            $banner = get_field('banner');
            if($banner['show_banner']){
                add_action('kmsp_banner_'.$banner['banner_position'], array($this,'kmsp_banner'));
            }

            $banner = get_field('slider');
            if($banner['show_slider']){
                add_action('kmsp_slider_'.$banner['slider_position'], array($this,'kmsp_slider'));
            }

            $banner = get_field('accordion');

            if($banner['show_accordion']){
                add_action('kmsp_accordion_'.$banner['accordion_position'], array($this,'kmsp_accordion'));
            }

        }

        function kmsp_banner(){
         get_template_part('kinex/template-parts/accordion/banner');
     }

     function kmsp_slider(){
        get_template_part('kinex/template-parts/accordion/slider');
    }


    function kmsp_accordion(){
        get_template_part('kinex/template-parts/accordion/accordion');
    }
}

$KMtheme = new KM_Main();

}
