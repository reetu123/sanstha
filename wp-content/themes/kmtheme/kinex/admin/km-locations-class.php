<?php
/**
 * Created by PhpStorm.
 * User: sarab
 * Date: 9/8/19
 * Time: 11:44 AM
 */

define("KM_LOCATION_URL", get_option('siteurl') . "/wp-admin/admin.php");

class KM_Locations
{

    public function __construct()
    {

        $this->km_includes_files();

        $this->km_setup_actions();

    }

    public function km_includes_files()
    {
        if (!class_exists('WP_List_Table')) {
            require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
        }
        require_once __DIR__ . "/lib/km-locations-table-class.php";

    }

    public function km_setup_actions()
    {
        add_action("admin_menu", array($this, "add_menu_item"));
    }

    public function add_menu_item()
    {

        add_menu_page("User Locations", "User Location", "manage_options", "km-locations", array
        ($this, "km_locations"), "dashicons-chart-pie", 27);
        add_submenu_page('km-locations', 'User Location', 'User Locations', 'manage_options', 'km-locations',
            array($this, "km_locations"));

    }

    function km_locations()
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . "user-locatiions-management.php";
    }


    public function km_delete_row_by_id($table, $ids)
    {
        global $wpdb;

        if (is_array($ids)) {
            foreach ($ids as $id) {
                $sql = 'delete from '.$wpdb->prefix . $table . ' where id = ' . $id;
                $result = $wpdb->get_results($sql);
                if (is_wp_error($result)) {
                    return false;
                }
            }
        } else {
            $sql = 'delete from ' . $wpdb->prefix . $table . ' where id = ' . $ids;

            $result = $wpdb->get_results($sql);
            if (is_wp_error($result)) {
                return false;
            }
        }

        return true;
    }

    public function  km_get_row_by_id($id){
        global $wpdb;

        if($id){
            return $wpdb->get_row('select * from ' . $wpdb->prefix . "locations where id=" . $id." limit 1");
        }
        return false;
    }

    public static function km_get_user_review_by_user_id($user_id)
    {
        global $wpdb;

        return $wpdb->get_row('select count(*) as c from ' . $wpdb->prefix . "locations where user_id=" . $user_id)->c;
    }

}

new KM_Locations;