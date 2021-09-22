<?php
/**
 * Template Name: Tasker search And Listing
 */

get_header();
global $wpdb;

$detailTable = $wpdb->prefix . "user_services";
$userstable = $wpdb->prefix . "users";
$locationsTable = $wpdb->prefix . "locations";
$raitingTable = $wpdb->prefix . "review_raiting";
?>
<div class="wrap">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php $page = get_queried_object();
            $urlSlug = $page->post_name;
            if ($urlSlug == 'listing') {

                ?>
                <!-- start form into listing page -->
                <div class="form-result list">
                    <form name="search_service" class="search_services" method="GET" action="<?php echo site_url() . '/search-tasker' ?>">
                        <?php
                        $services_args = array(
                            'post_type' => 'km-services',
                            'posts_per_page' => -1,
                            'order' => 'ASC',
                            'post_status' => 'publish'
                        );
                        $services_query = new WP_Query($services_args); ?>
                        adasd
                        <select id="get_service" name="service">
                            <option value="">Select service232</option>
                            <?php if ($services_query->have_posts()) {
                                while ($services_query->have_posts()):
                                    global $post;

                                    $services_query->the_post();
                                    $slug = $post->post_name;
                                    $service_id = get_the_ID();
                                    $service_name = get_the_title();
                                    echo '<option value=' . $slug . '>' . $service_name . '</option>';
                                endwhile;
                            } ?>
                        </select>
                        <input type="submit" value="Submit">
                    </form>
                    <span style="display:none;" class="validation-message-service error">
                            Please select service first
                        </span>
                </div>
                <!-- end form into listing page -->
            <?php } else if ($urlSlug == 'search-tasker') { ?>
                <div class="search-header text-center">
                    <h3>Search Result For: <?php echo str_replace('-', ' ', $_GET['service']) ?></h3>
                    <label>Find Your Location</label>
                </div>
                <?php $service_id = @($_GET['service']); ?>
                <!-- start form into searching page -->
                <div class="form-result">
                    <form name="search_service" class="search_locations" method="GET" action="<?php echo site_url() . '/search-tasker' ?>">
                        <label>Your Location</label>
                        <input type="hidden" name="service" value="<?php echo $service_id ?>">
                        <input type="text" required name="location" id="search_location" value=""
                        placeholder="Search Location">
                        <input type="hidden" name="latitude" class="form-control" id="arealatitude" value="">
                        <input type="hidden" name="longitude" class="form-control" id="arealongitude" value="">
                        <input type="hidden" name="city" class="form-control" id="areacity" value="">
                            <!-- <input type="hidden" name="state" class ="form-control" id="areastate" value="">
                            <input type="hidden" name="country" class ="form-control" id="areacountry" value="">
                            <input type="hidden" name="pincode" class ="form-control" id="areapincode" value=""> -->
                            <input type="submit" name="areaSearchSub" class= "areaSearchSub" id="areaSearchSub" value="Submit">
                        </form>
                        <span style="display:none;" class="validation-message error">
                            Please enter a valid address
                        </span>
                    </div>
                    <!-- end form into searching page -->
                <?php }
                $args = array();
                if ($urlSlug == 'listing' && @$_GET['service'] == '' && @$_GET['location'] == '') {
                    /*start pagination section*/
                     $number = get_option('posts_per_page'); //max display per page
                     $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; //current number of page
                     $offset = ($paged - 1) * $number; //page offset
                     $users = get_users(array('role' => 'tasker'));
                     /* end pagination secton */
                     $args = array(
                       'offset' => $offset,
                       'number' => $number,
                       'role' => 'tasker',
                       'orderby' => 'user_registered',
                       'order' => 'ASC'
                   );
                     $query = get_users($args);
                     $total_users = count($users);
                     $total_query = count($query);
                     $total_pages = ($total_users / $number);
                     $total_pages = is_float($total_pages) ? intval($total_users / $number) + 1 : intval($total_users / $number);

                     if(is_array($query )):
                        ?>
                        <div class="users-main-section">
                            <?php
                            foreach ($query as $user):
                                $first_name = get_user_meta($user->ID, 'first_name', true);
                                $last_name = get_user_meta($user->ID, 'last_name', true);
                                // $image = get_user_meta($user->ID,'author_profile_picture',true);
                                $about_services = get_user_meta($user->ID, 'about_services', true);
                                $record = "SELECT * from " . $raitingTable . " where tasker_id = " . $user->ID . " ORDER BY ID DESC LIMIT 1";
                                $records = $wpdb->get_results($record);

                                if (strlen($about_services) > 199) {
                                    $about = substr($about_services, 0, 200) . '...' . '<a href="' . site_url() . '/view-profile/?service=' . $_GET['service'] . '&id=' . $user->ID . '">Read More</a>';
                                } else {
                                    $about = $about_services;
                                }


                                // $img_url = get_user_meta($user_id,'author_profile_picture',true);
                                $imgName = km_get_show_user_avatar(array('item_id' => $user->ID, 'html' => false, 'type' => 'medium'));


                                // }
                                ?>
                                <div class="users-main-wrap">
                                    <div class="user-listing">
                                        <div class="user-avatar">
                                            <?php
                                            if ($imgName) {
                                                ?>
                                                <a href="<?php echo site_url() . '/view-profile/?id=' . $user->ID ?>">
                                                    <?php
                                                    echo '<img src="' . $imgName . '">';
                                                    ?>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <a href="<?php echo site_url() . '/view-profile/?id=' . $user->ID ?>"
                                         class="button">View Profile</a>
                                     </div>
                                     <div class="user-details">
                                        <div class="user-inner-head">
                                            <div class="name-sec">
                                                <h4><?php echo ucfirst($first_name) . ' ' . ucfirst($last_name) ?></h4>
                                                <div class="rating-wrap"></div>
                                            </div>
                                        </div>
                                        <div class="user-inner-body">
                                            <?php if (!empty($about_services)){ ?>
                                                <h5>About My Services</h5>
                                                <p class="desc">
                                                    <?php echo $about;
                                                } else {
                                                    echo "";
                                                } ?>
                                            </p>
                                            <div class="review-sec">
                                                <?php if (@$records[0]->review_description) {

                                                    $imgName = km_get_show_user_avatar(array('item_id' => $records[0]->user_id, 'html' => false, 'type' => 'thumb'));

                                                    echo '<img src="' . $imgName . '">';


                                                    if (strlen($records[0]->review_description) > 99) {
                                                        $review = substr($records[0]->review_description, 0, 100) . '...<a href="' . site_url() . '/view-profile/?id=' . $user->ID . '">Read More' . '</a>';
                                                    } else {
                                                        $review = $records[0]->review_description;
                                                    }

                                                    echo '<p>' . $review . '</p>';

                                                } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php  if ($total_users > $total_query) {
                                echo '<div id="support-pagination" class="clearfix pagination">';
                                $current_page = max(1, get_query_var('paged'));
                                echo paginate_links(array(
                                    'base' => get_pagenum_link(1) . '%_%',
                                    'format' => 'page/%#%/',
                                    'current' => $current_page,
                                    'total' => $total_pages,
                                    'prev_next' => true
                                ));
                                echo '</div>'; 
                            } ?>
                        </div>
                    <?php endif;
                } else if ($urlSlug == 'search-tasker' && @$_GET['service'] != '' && @$_GET['location'] == '') {
                    $service_slug = $_GET['service'];
                    $queried = get_page_by_path($service_slug, OBJECT, 'km-services');
                    $service_id = $queried->ID;
                    /*start here*/


                    $posts_per_page = get_option('posts_per_page');
                    $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
                    $offset = ($page - 1) * $posts_per_page;

                    $sql = "SELECT  DISTINCT service.user_id,service.price FROM " . $detailTable . " as service
                    INNER JOIN " . $userstable . " as u ON service.user_id =u.id where service.service_id =" . $service_id . " AND service.price > 0 LIMIT ".$offset.", ".$posts_per_page;
                    $data_sql = $wpdb->get_results($sql);
                    $countRec = "select  COUNT(DISTINCT service.user_id) as count from " . $detailTable . " as service INNER JOIN " . $userstable . " as u ON service.user_id =u.id where service_id =" . $service_id . "  AND service.price > 0";

                    $recSql = $wpdb->get_results($countRec);
                    $count = $recSql[0]->count; ?>
                    <div class="result-found-wrap">
                        <label>Search Results for "<?php echo @$queried->post_title ?>"</label>
                        <p class="results-text"><?php echo $count; ?> Result Found</p>
                    </div>
                    <?php if ($count == 0) { ?>
                        <div class="res">
                            <p>Oops! No Record Found. </p>
                        </div>
                    <?php } ?>

                    <div class="users-main-section">
                        <?php foreach ($data_sql as $k => $v) {
                            $user_id = $v->user_id;
                            if ($user_id != '') {
                                $record = "SELECT * from " . $raitingTable . " where tasker_id = " . $user_id . " ORDER BY ID DESC LIMIT 1 ";
                                $records = $wpdb->get_results($record);
                                $first_name = get_user_meta($user_id, 'first_name', true);
                                $last_name = get_user_meta($user_id, 'last_name', true);
                                $about_services = get_user_meta($user_id, 'about_services', true);
                                // $image = get_user_meta($user_id,'author_profile_picture',true);
                                $price = $v->price;

                                if (!empty($about_services)) {
                                    if (strlen($about_services) > 99) {
                                        $about = substr($about_services, 0, 100) . '...' . '<a href="' . site_url() . '/view-profile/?service=' . $_GET['service'] . '&id='.$user_id.'">Read More</a>';
                                    } else {
                                        $about = $about_services;
                                    }
                                }


                                $imgName = km_get_show_user_avatar(array('item_id' => $user_id, 'html' => false, 'type' => 'medium'));


                                ?>

                                <div class="users-main-wrap">
                                    <div class="user-listing">
                                        <div class="user-avatar">
                                            <?php if ($imgName) {
                                                ?>
                                                <a href="<?php echo site_url() . '/view-profile/?service=' . $_GET['service'] . '&id=' . $user_id ?>"
                                                    >
                                                    <?php
                                                    echo '<img src="' . $imgName . '">';
                                                    ?>
                                                </a>
                                                <?php
                                            } ?>
                                        </div>
                                        <a href="<?php echo site_url() . '/view-profile/?service=' . $_GET['service'] . '&id=' . $user_id ?>"
                                         class="button">View Profile</a>
                                     </div>
                                     <div class="user-details">
                                        <div class="user-inner-head">
                                            <div class="name-sec">
                                                <h4><?php echo ucfirst($first_name) . ' ' . ucfirst($last_name) ?></h4>
                                                <div class="rating-wrap"></div>
                                            </div>
                                            <div class="price-sec">
                                                <span>From</span>
                                                <label><?php echo "<sup>$</sup>" . @$price; ?></label>
                                                <span>per hour</span>
                                            </div>
                                        </div>
                                        <div class="user-inner-body">
                                            <?php if (!empty($about_services)) { ?>
                                                <h5>About My Services</h5>
                                                <p class="desc"><?php echo $about ?></p>
                                            <?php } ?>
                                            <div class="review-sec">
                                                <?php if (@$records[0]->review_description) {

                                                    $imgName = km_get_show_user_avatar(array('item_id' => $records[0]->user_id, 'html' => false, 'type' => 'thumb'));

                                                    echo '<img src="' . $imgName . '">';


                                                    if (strlen($records[0]->review_description) > 99) {
                                                        $review = substr($records[0]->review_description, 0, 100) . '...<a href="' . site_url() . '/view-profile/?service=' . $_GET['service'] . '&id=' . $user_id . '">Read More' . '</a>';
                                                    } else {
                                                        $review = $records[0]->review_description;
                                                    }

                                                    echo '<p>' . $review . '</p>';
                                                } ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } 
                        echo '<div id="support-pagination" class="clearfix pagination">';
                        echo paginate_links( array(
                            'base' => add_query_arg( 'cpage', '%#%' ),
                            'format' => '',
                            'prev_next' => true,
                            'total' => ceil($count / $posts_per_page),
                            'current' => $page
                        )); 
                        echo '</div>';?>
                    </div>
                    <?php
                } else if ($urlSlug == 'search-tasker' && @$_GET['service'] != '' && @$_GET['location'] != '') {
                    $city = $_GET['city'];
                    $service_slug = $_GET['service'];
                    $queried = get_page_by_path($service_slug, OBJECT, 'km-services');
                    $service_id = $queried->ID;

                    $posts_per_page = get_option('posts_per_page');
                    $page = isset( $_GET['lpage'] ) ? abs( (int) $_GET['lpage'] ) : 1;
                    $offset = ($page - 1) * $posts_per_page;


                    $loc = "SELECT DISTINCT l.user_id, u.id, d.user_id,d.price FROM wp_users u LEFT JOIN " . $locationsTable . " l ON l.user_id = u.id LEFT JOIN " . $detailTable . " d ON d.user_id = u.id WHERE d.user_id IS NOT NULL AND l.user_id IS NOT NULL AND l.city ='" . $_GET['city'] . "' AND d.price > 0 LIMIT ".$offset.", ".$posts_per_page;

                    $countRec = "select  COUNT(DISTINCT l.user_id, u.id, d.user_id) as count FROM " . $userstable . " u LEFT JOIN " . $locationsTable . " l ON l.user_id = u.id LEFT JOIN " . $detailTable . " d ON d.user_id = u.id WHERE d.user_id IS NOT NULL AND l.user_id IS NOT NULL AND l.city ='" . $_GET['city'] . "' AND d.price > 0";
                    $recSql = $wpdb->get_results($countRec);
                    $count = $recSql[0]->count;
                    $locations_sql = $wpdb->get_results($loc);
                    $uniqueLoc = uniqueAssocArray($locations_sql, 'id');
                    $countRec = count($uniqueLoc);
                    ?>
                    <div class="result-found-wrap">
                        <label>Search Results for '<?php echo $queried->post_title ?>' in
                            '<?php echo $_GET['location'] ?>' </label>
                            <p class="results-text"> <?php echo $countRec ?> Result Found</p>
                        </div>
                        <?php if ($countRec == 0) { ?>
                            <div class="res">
                                <p>Oops! No Record Found. </p>
                            </div>
                        <?php } ?>
                        <div class="users-main-section">
                            <?php foreach ($uniqueLoc as $k => $v) {
                                if ($v->user_id != '') {
                                    $user_id = $v->user_id;
                                    $record = "SELECT * from " . $raitingTable . " where tasker_id = " . $user_id . " ORDER BY ID DESC LIMIT 1 ";
                                    $records = $wpdb->get_results($record);
                                    $price = $v->price;
                                    $first_name = get_user_meta($user_id, 'first_name', true);
                                    $last_name = get_user_meta($user_id, 'last_name', true);
                                    $about_services = get_user_meta($user_id, 'about_services', true);
                                    $image = get_user_meta($user_id, 'author_profile_picture', true);
                                    $price = $v->price;
                                    $about = substr($about_services, 0, 200) . '...' . '<a href="' . site_url() . '/view-profile/?service=' . $_GET['service'] . '&id=' . $user_id  . '">Read More</a>';
                                // $dirName = dirname(__FILE__).'/../../uploads/profilepics/'.$user_id.'/medium/';
                                // $imageName = scandir($dirName,1);
                                // $imgName = $imageName[0];

                                    $imgName = km_get_show_user_avatar(array('item_id' => $user_id, 'html' => false, 'type' => 'medium'));

                                // echo '<img src="'.$imgName.'">';

                                    if (!empty($about_services)) {
                                        if (strlen($about_services) > 199) {
                                            $about = substr($about_services, 0, 200) . '...' . '<a href="' . site_url() . '/view-profile/?service=' . $_GET['service'] . '&id=' . $user_id .'">Read More</a>';
                                        } else {
                                            $about = $about_services;
                                        }
                                    }
                                    ?>

                                    <div class="users-main-wrap">
                                        <div class="user-listing">
                                        <!-- <img src="<?php // echo $image
                                        ?>"> -->
                                        <div class="user-avatar">
                                            <?php if ($imgName) {
                                                ?>
                                                <a href="<?php echo site_url() . '/view-profile/?service=' . $_GET['service'] . '&id=' . $user_id ?>"
                                                 class="">
                                                 <?php
                                                 echo '<img src="' . $imgName . '">';
                                                 ?>
                                             </a>
                                             <?php
                                         } ?>
                                     </div>
                                     <a href="<?php echo site_url() . '/view-profile/?service=' . $_GET['service'] . '&id=' . $user_id ?>"
                                         class="button">View Profile</a>
                                     </div>
                                     <div class="user-details">
                                        <div class="user-inner-head">
                                            <div class="name-sec">
                                                <h4><?php echo ucfirst($first_name) . ' ' . ucfirst($last_name) ?></h4>
                                                <div class="rating-wrap"></div>
                                            </div>
                                            <div class="price-sec">
                                                <span>From</span>
                                                <label><?php echo "$" . $price; ?></label>
                                                <span>per hour</span>
                                            </div>
                                        </div>
                                        <div class="user-inner-body">
                                            <?php if (@$about_services) { ?>
                                                <h5>About My Services</h5>
                                                <p class="desc"><?php echo $about ?></p>
                                            <?php } ?>
                                            <div class="review-sec">
                                                <?php if (@$records[0]->review_description) {

                                                    $imgName = km_get_show_user_avatar(array('item_id' => $records[0]->user_id, 'html' => false, 'type' => 'thumb'));

                                                    echo '<img src="' . $imgName . '">';


                                                    if (strlen($records[0]->review_description > 199)) {
                                                        $review = substr($records[0]->review_description, 0, 200) . '...<a href="' . site_url() . '/view-profile/?id=' . $user->ID . '">Read More' . '</a>';
                                                    } else {
                                                        $review = $records[0]->review_description;
                                                    }

                                                    echo '<p>' . $review . '</p>';
                                                } ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            <?php }
                        } 
                        ?>
                        <?php 
                        echo '<div id="support-pagination" class="clearfix pagination">';
                        echo paginate_links( array(
                            'base' => add_query_arg( 'lpage', '%#%' ),
                            'format' => '',
                            'prev_next' => true,
                            'total' => ceil($count / $posts_per_page),
                            'current' => $page
                        ));
                        echo '</div>'; 
                        ?>
                    </div>
                    <?php
                } ?>
            </main><!-- #main -->
        </div>
    </div><!-- .wrap -->
    <?php

    get_footer(); ?>