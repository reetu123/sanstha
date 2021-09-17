<?php
/**
 * Created by PhpStorm.
 * User: Reetu
 * Date: 01-03-2018
 * Time: 10:37
 */


/**
 * @param $slug
 * @param string $name
 *
 * Get Template Part
 */
function KMCPT()
{

    return new KMCPT();
}


function kmcpt_get_template_part($slug, $name = '')
{
    $template = '';

    // Look in yourtheme/slug-name.php and yourtheme/woocommerce/slug-name.php
    if ($name) {
        $template = locate_template(array("{$slug}-{$name}.php", $this->get_template_path() . "{$slug}-{$name}.php"));
    }

    // Get default slug-name.php
    if (!$template && $name && file_exists($this->get_plugin_path() . "/templates/{$slug}-{$name}.php")) {
        $template = KMCPT()->get_plugin_path() . "/templates/{$slug}-{$name}.php";
    }

    // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/woocommerce/slug.php
    if (!$template) {
        $template = locate_template(array("{$slug}.php", KMCPT()->get_template_path() . "{$slug}.php"));
    }

    // Allow 3rd party plugins to filter template file from their plugin.
    $template = apply_filters('kmcpt_get_template_part', $template, $slug, $name);

    if ($template) {
        load_template($template, false);
    }
}

function kmcpt_get_template($template_name, $args = array(), $template_path = '', $default_path = '')
{
    if (!empty($args) && is_array($args)) {
        extract($args);
    }


    $located = kmcpt_locate_template($template_name, $template_path, $default_path);


    if (!file_exists($located)) {
        wc_doing_it_wrong(__FUNCTION__, sprintf(__('%s does not exist.', 'kmc'), '<code>' . $located . '</code>'), '2.1');
        return;
    }

    // Allow 3rd party plugin filter template file from their plugin.
    $located = apply_filters('kmcpt_get_template', $located, $template_name, $args, $template_path, $default_path);

    do_action('kmcpt_before_template_part', $template_name, $template_path, $located, $args);


    include($located);

    do_action('kmcpt_after_template_part', $template_name, $template_path, $located, $args);
}

function kmcpt_locate_template($template_name, $template_path = '', $default_path = '')
{
    if (!$template_path) {
        $template_path = KMCPT()->get_template_path();

    }

    if (!$default_path) {
        $default_path = KMCPT()->get_plugin_path() . '/template/';
    }


    // Look within passed path within the theme - this is priority.
    $template = locate_template(
        array(
            trailingslashit($template_path) . $template_name,
            $template_name,
        )
    );
    // Get default template/
    if (!$template) {
        $template = $default_path . $template_name;
    }
    // Return what we found.
    return apply_filters('kmcpt_locate_template', $template, $template_name, $template_path);
}

function instagramresults()
{
    $json_link = "https://api.instagram.com/v1/users/4003666719/media/recent/?";
    $json_link .= "access_token=4003666719.3d53a8d.3c544e2df76a494e999ee88daad0fdf4&count=6";
    // $json_link="https://api.instagram.com/v1/users/7156108469/media/recent/?";
    // $json_link .="access_token=7156108469.1677ed0.3f62c3d731804f57873a291c6ff1bd04&count=20";
    $json = file_get_contents($json_link);
    $expire_time = 5 * 60;
    $cache_file = 'api-instagram.json';
    $api_cache = json_decode(file_get_contents($cache_file), false);
    if (filesize($cache_file) == 0) {
        file_put_contents($cache_file, $json);
        return ($api_cache);
    } else {
        if (time() - filemtime($cache_file) > $expire_time) {
            file_put_contents($cache_file, $json);
            return ($api_cache);
        } else {
            return ($api_cache);
        }
    }
}

//function create_new_archive_post_status()
//{
//    $args = array(
//        'label' => _x('Comming Soon', 'post status'),
//        'public' => true,
//        'show_in_admin_all_list' => true,
//        'show_in_admin_status_list' => true,
//        'show_in_metabox_dropdown' => true,
//        'show_in_inline_dropdown' => true,
//        'label_count' => _n_noop('Comming Soon <span class="count">(%s)</span>', 'Coming Soon <span class="count">(%s)</span>'),
//    );
//    register_post_status('comming_soon', $args);
//}

//add_action('admin_init', 'create_new_archive_post_status');


//add_action( 'init', 'my_custom_post_status' );


function debug($data, $exit = false)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if ($exit) {
        exit;
    }
}

function create_plugin_database_table()
{
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $table_name = $wpdb->prefix . 'user_services';
    $sql = "CREATE TABLE $table_name (
      id mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
      user_id int(11) NULL,
      service_id int(11) NULL,
      price varchar(255) NULL,
      PRIMARY KEY  (id)
  );";
    dbDelta($sql);

    $table_name = $wpdb->prefix . 'locations';
    $location_sql = "CREATE TABLE $table_name (
    id mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
    user_id int(11) NULL,
    latitude text NULL,
    longitude text NULL,
    full_address text NULL,
    city text NULL,
    state text NULL,
    country text NULL,
    zip text NULL,
    radius text NULL,
    PRIMARY KEY  (id)
  )";
    dbDelta($location_sql);
}
