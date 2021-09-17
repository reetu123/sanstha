<?php


if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

if (function_exists('acf_verify_ajax')) {
    add_filter('acf/fields/post_object/result', 'kmsp_filter_title', 100);
    add_filter('acf/get_field_label', 'kmsp_filter_title', 100);


    function kmsp_filter_title($title)
    {
        $title = apply_filters('static_content_filter', $title);
        return $title;
    }

}


if (!function_exists('kmsp_excerpt_more')) {

    function kmsp_excerpt_more($more)
    {
        global $post;
        return '<span class="view-full-post">... <a href="' . get_permalink($post->ID) . '" class="view-full-post-btn">More Event Details</a></span>';
    }

}


if (!function_exists('kmsp_trim_words')) {


    function kmsp_trim_words($text, $before, $after, $num_words = 55, $more = null)
    {
        if (null === $more) {
            $more = __('&hellip;');
        }

        $original_text = $text;
        $text = wp_strip_all_tags($text);

        /*
         * translators: If your word count is based on single characters (e.g. East Asian characters),
         * enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
         * Do not translate into your own language.
         */
        if (strpos(_x('words', 'Word count type. Do not translate!'), 'characters') === 0 && preg_match('/^utf\-?8$/i', get_option('blog_charset'))) {
            $text = trim(preg_replace("/[\n\r\t ]+/", ' ', $text), ' ');
            preg_match_all('/./u', $text, $words_array);
            $words_array = array_slice($words_array[0], 0, $num_words + 1);
            $string_array = array_slice($words_array[0], $num_words);
            $sep = '';
        } else {
            $words_array = preg_split("/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY);

            $string_array = preg_split("/[\n\r\t ]+/", $text, -1, PREG_SPLIT_NO_EMPTY);
            $string_array = array_slice($string_array, $num_words);
            $sep = ' ';
        }
        if (count($words_array) > $num_words) {
            array_pop($words_array);
            $text = implode($sep, $words_array);
            $o_text = implode($sep, $string_array);
            $before_o =
            $text = $text . $before . $o_text . $after . $more;


        } else {
            $text = implode($sep, $words_array);
        }

        return apply_filters('kmsp_trim_words', $text, $num_words, $more, $original_text);
    }

}


if (!function_exists('kmsp_excerpt_readmore')) {

    add_filter('kmsp_exccerpt_more', 'kmsp_excerpt_readmore');
    function kmsp_excerpt_readmore($more)
    {
        global $post;
        $readmore = "[:en]Read More Here[:fr]En savoir plus[:]";
        return '<span class="view-full-post" ><a class="read-full-post" href="#content-' . $post->ID . '" class="view-full-post-btn">' . apply_filters('static_content_filter', $readmore) . '</a></span>';
    }

}


if (!function_exists('kmsp_footer_widget_classes')) {

    function kmsp_footer_widget_classes($count)
    {
        switch ($count) {
            case 1:
                return 'col-1';
                break;
            case 2:
                return 'col-2';
                break;
            case 3:
                return 'col-3';
                break;
            case 4:
                return 'col-4';
                break;
            case 5:
                return 'col-5';
                break;
            case 6:
                return 'col-6';
                break;
            default:
                return 'col-1';
                break;
        }
    }

}

function test(){

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( is_plugin_active('http://localhost/qps/wp-content/plugins/advanced-custom-fields-pro/acf.php')) {

        add_filter('wp_nav_menu_objects', 'kmsp_wp_nav_menu_objects', 10, 2);
    }


}
add_action('init','test');



function kmsp_wp_nav_menu_objects($items, $args)
{

    // loop
    foreach ($items as &$item) {
        // vars
        $icon = get_field('menu_banner', $item);
        // append icon
        if ($icon) {
            $item->title .= ' <span class="bannersrc" data-src="' . $icon['url'] . '"></span>';
        }
    }
    // return
    return $items;
}

add_filter('body_class', 'kmsp_body_classes');

function kmsp_body_classes($classes)
{
    if (is_active_sidebar('sidebar-home') && is_front_page()) {
        $classes[] = 'has-sidebar';
    }
	
    if (is_active_sidebar('sidebar-1') && is_page() &&  !is_front_page() && get_page_template() != 'Full Width') {
        $classes[] = 'has-sidebar';
    }

    return $classes;
}

function kmsp_load_widget()
{
    register_widget('KMSP_Advertisement');
}

add_action('widgets_init', 'kmsp_load_widget');


$GLOBALS['my_query_filters'] = array(
    'event_date' => 'event_date'
);


add_action('pre_get_posts', 'kmsp_leadership_sort_order');
function kmsp_leadership_sort_order($query)
{
    if (is_admin()) {
        return $query;
    }


    // only modify queries for 'event' post type
    if (isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'event') {

        $compare = ">";
        if (isset($_REQUEST['type']) && !empty($_REQUEST)) {

            if ($_REQUEST['type'] == 'past') {

                $compare = "<=";
                $query->set('order', 'DESC');
            } else {

                $compare = ">";
                $query->set('order', 'ASC');
            }
        }

        $meta_query = $query->get('meta_query');
        $today = date('Ymd');
        $meta_query[] = array(
            'key' => 'event_date',
            'compare' => $compare,
            'value' => $today,
        );
        $query->set('meta_query', $meta_query);

        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');

    } else if (isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'leadership') {
        $query->set('order', 'ASC');
        $query->set('orderby', 'ID');

    }
    // return
    return $query;

}




function js_script(){
    ?>
    <?php
}
add_action('wp_footer','js_script');



