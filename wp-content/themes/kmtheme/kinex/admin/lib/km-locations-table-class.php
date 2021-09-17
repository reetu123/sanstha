<?php
/**
 * Created by PhpStorm.
 * User: sarab
 * Date: 9/8/19
 * Time: 12:05 PM
 */

class KM_Location_Tables extends WP_List_Table
{

    public function __construct()
    {
        parent::__construct(array(
            'singular' => 'wp_list_text_link', //Singular label
            'plural' => 'wp_list_test_links', //plural label, also this well be one of the table css class
            'ajax' => true //We won't support Ajax for this table
        ));
    }

    /**
     * Define the columns that are going to be used in the table
     * @return array $columns, the array of columns to use with the table
     */
    public function get_columns()
    {
        return $columns = array(
//            'cb' => '<input type="checkbox" />',
            'user_id' => __('User Name'),
            'latitude' => __('Latitude'),
            'longitude' => __('Longitude  '),
            'full_address' => __('Address'),
            'city' => __('City'),
            'state' => __('State'),
            'country' => __('Country'),
            'action' => __('Action'),
        );
    }

    /**
     * Decide which columns to activate the sorting functionality on
     * @return array $sortable, the array of columns that can be sorted by the user
     */
    public function get_sortable_columns()
    {
        return $sortable = array(
            'user_id' => array('user_id', true),
            'latitude' => array('latitude', true),
            'longitude' => array('longitude', true),
            'full_address' => array('full_address', true),
            'city' => array('city', true),
            'state' => array('state', true),
            'country' => array('country', true),
        );
    }


    public function prepare_items()
    {
        global $wpdb, $_wp_column_headers;
        $screen = get_current_screen();

        /* -- Preparing your query -- */
        $query = "SELECT * FROM {$wpdb->prefix}locations";

        $query .= (isset($_GET['s']) AND !empty($_GET['s'])) ? ' where `full_address` like "%'
            . $wpdb->_real_escape($_GET['s']) . '%"'
             .'or `city` like "%' . $wpdb->_real_escape($_GET['s']) . '%"'
            . 'or `state` like "%' . $wpdb->_real_escape($_GET['s']) . '%"'
            . 'or `country` like "%' . $wpdb->_real_escape($_GET['s']) . '%"'
            . 'or `latitude` like "%' . $wpdb->_real_escape($_GET['s']) . '%"'
            . 'or `longitude` like "%' . $wpdb->_real_escape($_GET['s']) . '%"'
            : ' ';

        /* -- Ordering parameters -- */
        //Parameters that are going to be used to order the result
        $orderby = !empty($_GET["orderby"]) ? $wpdb->_real_escape($_GET["orderby"]) : 'id';
        $order = !empty($_GET["order"]) ? $wpdb->_real_escape($_GET["order"]) : 'Desc';
        if (!empty($orderby) & !empty($order)) {
            $query .= ' ORDER BY ' . $orderby . ' ' . $order;
        }

        /* -- Pagination parameters -- */
        //Number of elements in your table?
        $totalitems = $wpdb->query($query); //return the total number of affected rows
        //How many to display per page?
        $perpage = 10;
        //Which page is this?
        $paged = !empty($_GET["paged"]) ? $wpdb->_real_escape($_GET["paged"]) : '';
        //Page Number
        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }
        //How many pages do we have in total?
        $totalpages = ceil($totalitems / $perpage);
        //adjust the query to take pagination into account
        if (!empty($paged) && !empty($perpage)) {
            $offset = ($paged - 1) * $perpage;
            $query .= ' LIMIT ' . (int)$offset . ',' . (int)$perpage;
        }

        /* -- Register the pagination -- */
        $this->set_pagination_args(array(
            "total_items" => $totalitems,
            "total_pages" => $totalpages,
            "per_page" => $perpage,
        ));
        //The pagination links are automatically built according to those parameters

        /* -- Register the Columns -- */
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, array(), $sortable);

        /* -- Fetch the items -- */
        $this->items = json_decode(json_encode($wpdb->get_results($query)), true);
    }


    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'user_id':
            case 'latitude':
            case 'longitude':
            case 'full_address':
            case 'city':
            case 'state':
            case 'country':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }


//    public function get_bulk_actions()
//    {
//        $actions = array(
//            'view' => 'view',
//        );
//        return $actions;
//    }


    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />', $item['id']
        );
    }

    public function column_user_id($item)
    {
        return sprintf(
            '<a target="_blank" href="%s">%s</a>', get_edit_user_link($item['user_id']), get_userdata($item['user_id'])->display_name
        );
    }



    public function column_action($item)
    {

        return $this->row_actions(
            array(
                'view' => '<a  class="btn btn-success" href="' . KM_REVIEW_URL . '?page=km-locations&action=view&id=' .
                    $item['id'] . '">
View</a>',

            ), true);
    }


    public function display_tablenav($which)
    {
        if ('top' == $which)
            ?>
            <div class="tablenav <?php echo esc_attr($which); ?>">

        <div class="alignleft actions bulkactions">
            <?php $this->bulk_actions($which); ?>
        </div>
        <?php
        $this->pagination($which);
        $this->extra_tablenav($which);
        ?>

        <br class="clear"/>
        </div>
        <?php
    }

    public function extra_tablenav($which)
    {
        if ('top' == $which) {
            $this->search_box('Search', 'question');
        }
    }


    public function search_box($text, $input_id)
    {
        if (empty($_REQUEST['s']) && !$this->has_items())
            return;

        $input_id = $input_id . '-search-input';

        if (!empty($_REQUEST['orderby']))
            echo '<input type="hidden" name="orderby" value="' . esc_attr($_REQUEST['orderby']) . '" />';
        if (!empty($_REQUEST['order']))
            echo '<input type="hidden" name="order" value="' . esc_attr($_REQUEST['order']) . '" />';
        if (!empty($_REQUEST['post_mime_type']))
            echo '<input type="hidden" name="post_mime_type" value="' . esc_attr($_REQUEST['post_mime_type']) . '" />';
        if (!empty($_REQUEST['detached']))
            echo '<input type="hidden" name="detached" value="' . esc_attr($_REQUEST['detached']) . '" />';
        ?>
        <p class="search-box poll_management_search">
            <label class="screen-reader-text" for="<?php echo $input_id ?>"><?php echo $text; ?>:</label>
            <input type="search" id="<?php echo $input_id ?>" name="s" value="<?php _admin_search_query(); ?>"/>
            <?php submit_button($text, 'button', '', false, array('id' => 'search-submit')); ?>
        </p>
        <?php
    }
}