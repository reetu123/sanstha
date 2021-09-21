<?php

class kmlist
{
    public function __construct()
    {

        
        $this->add_shortcode('services', array($this, 'km_services'));
        $this->add_shortcode('user_profile', array($this, 'km_user_profile'));
        $this->add_shortcode('subscriber_profile', array($this, 'km_subscriber_profile'));
        $this->add_shortcode('tasker_slider', array($this, 'km_tasker_slider'));
        $this->add_shortcode('view_profile', array($this, 'km_view_profile'));
        $this->add_shortcode('tasker_contact', array($this, 'km_get_tasker_contact'));
        $this->add_shortcode('my_reviews', array($this, 'km_get_my_reviews'));


        add_action('init', array($this, 'km_add_raiting'));

        add_action('wp_ajax_km_post_search_ajax', array($this, 'km_post_search_ajax'));
        add_action('wp_ajax_nopriv_km_post_search_ajax', array($this, 'km_post_search_ajax'));


        add_action('wp_ajax_km_add_tasker_contact', array($this, 'km_add_tasker_contact'));
        add_action('wp_ajax_nopriv_km_add_tasker_contact', array($this, 'km_add_tasker_contact'));

        // search-tasker
    }

    public function add_shortcode($name, $callback)
    {
        add_shortcode($name, $callback);
    }

    /* services listing start */
    public function km_services()
    { ?>
        <div class="wrap">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

        <div class="community-box-wrapper">
        <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="click-card-wrapper">
                    <div class="click-card">
                    <a class="sanstha-anchor" href="/login.php?sanstha_id=1">Aggrawal Jaipur Sanstha </a>
                    </div>
                    <div class="click-card-content">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Contemnit enim disserendi elegantiam, confuse loquitur. Ergo id est convenienter naturae vivere, a natura discedere. Quid igitur dubitamus in tota eius natura quaerere quid sit effectum? Quae cum essent dicta, discessimus.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            <div class="click-card-wrapper">
                    <div class="click-card">
                    <a class="sanstha-anchor" href="/login.php?sanstha_id=2">Varvadhu Milaan Sanstha </a>
                    </div>
                    <div class="click-card-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Contemnit enim disserendi elegantiam, confuse loquitur. Ergo id est convenienter naturae vivere, a natura discedere. Quid igitur dubitamus in tota eius natura quaerere quid sit effectum? Quae cum essent dicta, discessimus.</p>
                    </div>
                </div>
</div> 
            </div>
        </div>
    </div>
  </div>
</div>
</main>
            </div>
        </div>
        <?php 
    }
    /* services listing end */

    /* user profile start */
    public function km_user_profile()
    {
        include 'templates/display_user_profile_form.php';
    }

    /* user profile end */
    public function km_post_search_ajax()
    {
        $res = "";
        $searcharray = [];
        global $wpdb;
        $res = $_POST['form_data'];
        parse_str($_POST['form_data'], $searcharray);
        /*user profile section start */
        // echo "<pre>";print_r($searcharray); die;
        $user_id = $searcharray['user_id'];
        $first_name = $searcharray['first_name'];
        $last_name = $searcharray['last_name'];
        $phone = $searcharray['user_phone'];
        // $mobile = $searcharray['user_mobile'];
        $email = $searcharray['email'];
        $postcode = $searcharray['postcode'];
        $about_services = $searcharray['about_services'];
        $author_profile_picture = $searcharray['author_profile_picture'];
        $type_of_dog = @$searcharray['type_of_dog'] ? $searcharray['type_of_dog'] : '';
        $weight_of_dog = @$searcharray['weight_of_dog'] ? $searcharray['weight_of_dog'] : '';
        $weight_into = @$searcharray['weight_into'] ? $searcharray['weight_into'] : '';

        $pet_preferences = @$searcharray['pet_preferences'] ? $searcharray['pet_preferences'] : '';
        $age_of_dog = @$searcharray['age_of_dog'] ? $searcharray['age_of_dog'] : '';
        $accept_puppies = @$searcharray['accept_puppies'] ? $searcharray['accept_puppies'] : '';

        $additional_information_for_tasker = @$searcharray['additional_information_for_tasker'] ? $searcharray['additional_information_for_tasker'] : '';
        $email = @$searcharray['email'] ? $searcharray['email'] : '';
        $password = @$searcharray['password'] ? $searcharray['password'] : '';
        $metas = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_phone' => $phone,
            'user_mobile' => $mobile,
            'billing_postcode' => $postcode,
            'about_services' => $about_services,
            'author_profile_picture' => $author_profile_picture,
            'type_of_dog' => $type_of_dog,
            'weight_of_dog' => $weight_of_dog,
            'weight_into' => $weight_into,
            'pet_preferences' => $pet_preferences,
            'age_of_dog' => $age_of_dog,
            'accept_puppies' => $accept_puppies,
            'additional_information_for_tasker' => $additional_information_for_tasker
        );
        if (!$user_id) {
            // if( null == username_exists( $email) && (null == email_exists($email))) {
            if (email_exists($email)) {
                echo $res = "This email already exists.";
                die;
            } else {
                $user_id = wp_create_user($email, $password, $email);
                $getUser = new WP_User($user_id);
                $getUser->set_role('tasker');
            }

            // }

        }

        foreach ($metas as $key => $value) {
            update_user_meta($user_id, $key, $value);
        }

        /*user profile section end */
        $service_id = $searcharray['service_id'];
        $service_price = $searcharray['service_price'];
        $service_combine = array_combine($service_id, $service_price);
        $detailTable = $wpdb->prefix . "user_services";
        $locationTable = $wpdb->prefix . "locations";

        $userSql = "select COUNT(user_id) as count from " . $detailTable . " where user_id =" . $user_id;
        // echo $userSql; die;
        $user_sql = $wpdb->get_results($userSql);
        // echo $user_sql[0]->count; die;
        foreach ($service_combine as $key => $value) {
            if ($value == '') {
                $value = 0;
            }
            if ($user_sql[0]->count > 0) {
                $sqlUpdate = "UPDATE " . $detailTable . " SET  price = " . trim($value) . " WHERE (user_id = " . $user_id . " AND service_id = " . $key . ");";
                $wpdb->query($sqlUpdate);
            } else {
                /*   $sqlQuery = "INSERT INTO ".$detailTable." (user_id,service_id,price) VALUES
                   (".$user_id.",".trim($key).",".trim($value).")";
      */
                   $sqlQuery = "INSERT INTO " . $detailTable . " (user_id,service_id,price) VALUES (" . $user_id . "," . $key . "," . $value . ")";
                   $wpdb->query($sqlQuery);
               }
           }
           $deleteLocationQuery = "DELETE FROM " . $locationTable . " WHERE user_id = " . $user_id;

           $wpdb->query($deleteLocationQuery);

           $locationAddress = $searcharray['areaaddress'];
           $latitude = $searcharray['latitude'];
           $longitude = $searcharray['longitude'];
           $city = $searcharray['city'];
           $state = $searcharray['state'];
           $country = $searcharray['country'];
           $pin = $searcharray['pincode'];
           $radius_length = $searcharray['radius_length'];
           $radius_type = $searcharray['radius_type'];

           foreach ($locationAddress as $key => $value) {
            $getCity = $city[$key];
            $getState = $state[$key];
            $getCountry = $country[$key];
            $getZip = $pin[$key];
            $getRadiusLength = $radius_length[$key];
            $getRadiusType = $radius_type[$key];

            $locationQuery = "INSERT INTO " . $locationTable . " (user_id,latitude,longitude,full_address,city,state,country,zip,radius_length,radius_type) VALUES (" . $user_id . "," . $latitude[$key] . "," . $longitude[$key] . ",'" . $value . "','" . $getCity . "','" . $getState . "','" . $getCountry . "','" . $getZip . "','" . $getRadiusLength . "','" . $getRadiusType . "')";
            $wpdb->query($locationQuery);
        }

        if (!is_wp_error($user_id)) {
            $res = "Success";

            if(!empty($password)){
                wp_mail($email, 'Welcome! ' . $first_name . ' ' . $last_name, 'Your account has been created successfully  and your password is : ' . $password);
            }
        }
        echo $res;
        exit;

    }


    /* start tasker slider */
    public function km_tasker_slider()
    {
        $res = '';
        $getTags = '';
        global $wpdb;
        $raitingTable = $wpdb->prefix . "review_raiting";
        $args = array(
            'role' => 'tasker',
            'orderby' => 'user_registered',
            'order' => 'DESC',
            'number' => 10
        );
        $users = get_users($args);
        // echo '<ul>';
        if ($users) {
            global $wpdb;
            $i = 1;
            $res .= '<div class="main"> <div class="slider slider-for">';
            foreach ($users as $user) {

                $record = "SELECT COUNT(*) as count from " . $raitingTable . " where tasker_id = " . $user->ID;
                $records = $wpdb->get_results($record);
                $count = $records[0]->count;
                $avg = "SELECT AVG(rating) AS avg FROM " . $raitingTable . " where tasker_id = " . $user->ID;
                // echo $avg;
                $avgRate = $wpdb->get_results($avg);
                $rate = round($avgRate[0]->avg, 1);
                $first_name = get_user_meta($user->ID, 'first_name', true);
                $last_name = get_user_meta($user->ID, 'last_name', true);
                // $image = get_user_meta($user->ID,'author_profile_picture',true);
                $city = get_user_meta($user->ID, 'billing_city', true);

                // $img_url = get_user_meta($user_id,'author_profile_picture',true);
                $img_name = km_get_show_user_avatar(array('item_id' => $user->ID, 'html' => false, 'type' => 'small'));


                $res .= '<div><div class="user-listing">';

                $res .= '<a href="' . site_url() . '/view-profile/?id=' . $user->ID . '"><img src="' . $img_name . '"></a>';
                $res .= '</div><div class="user-details">';
                $res .= '<a href="' . site_url() . '/view-profile/?id=' . $user->ID . '"><h4>' . ucfirst($first_name) . ' ' . ucfirst($last_name) . '</h4></a>';
                $res .= '<div class="city">' . $city . '</div>';
                $res .= '<div class="review-rating"><span class="tasker-rating-' . $i . '"></span>';
                $res .= '<span class="count-reviews">' . $count . ' reviews </span></div>';
                $res .= '</div></div>';
                ?>
                <script>
                    jQuery(document).ready(function () {
                        var count = "<?php echo $i ?>";
                        jQuery(".tasker-rating-" + count).starRating({
                            initialRating: <?php echo $rate ?>,
                            readOnly: true,
                            starSize: 20,
                            useGradient: false,
                            strokeWidth: 0,
                            activeColor: 'gold'
                        });
                    });

                </script>
                <?php $i++;
            }
            $res .= '</div></div>';

            /* $res .= '<div class="text-center"><a class="button button-primary" href="' . site_url() . '/our-services/' . '">Start a New Service</a> <a class="button" href="' . site_url() . '/listing/' . '">See All Taskers</a></div>';*/
            $res .= '<div class="text-center"><a class="button" href="' . site_url() . '/listing/' . '">See All Taskers</a></div>';
            ?>

            <?php
        }
        return $res;
        wp_reset_postdata();
    }
    /* end tasker slider */


    /* start view tasker profile */
    public function km_view_profile()
    {
        $user_id = @$_GET['id'];
        $getService = @$_GET['service'];
        global $wpdb;
        $first_name = get_user_meta($user_id, 'first_name', true);
        $last_name = get_user_meta($user_id, 'last_name', true);
        // $image = get_user_meta($user_id,'author_profile_picture',true);
        $about_services = get_user_meta($user_id, 'about_services', true);
        $phone = get_user_meta($user_id, 'user_phone', true);
        $mobile = get_user_meta($user_id, 'user_mobile', true);
        $current_user = get_user_by('id', $user_id);
        $user_email = @$current_user->data->user_email;
        $mylevels = pmpro_getMembershipLevelsForUser();

        /* start extra fields */
        $type_of_dog = @get_user_meta($user_id,'type_of_dog',true) ? '<b>Type Of Dog : </b>'.ucwords(str_replace('_',' ',get_user_meta($user_id,'type_of_dog',true))): '';

        $weight_of_dog = @get_user_meta($user_id,'weight_of_dog',true) ? ('<b>Weight Of Dog : </b>'.get_user_meta($user_id,'weight_of_dog',true)." ".get_user_meta($user_id,'weight_into',true)):'' ; 

        $pet_preferences = @get_user_meta($user_id,'pet_preferences',true) ? "<b> Pet Preferences : </b>".get_user_meta($user_id,'pet_preferences',true) : '';

        $age_of_dog =  @get_user_meta($user_id,'age_of_dog',true) ? "<b> Age Of Dog : </b>".get_user_meta($user_id,'age_of_dog',true) : '';

        $accept_puppies = @get_user_meta($user_id,'accept_puppies',true) ? "<b> Accept Puppies : </b>".ucfirst(get_user_meta($user_id,'accept_puppies',true)) : '';

        $additional_information_for_tasker = @get_user_meta($user_id,'additional_information_for_tasker',true) ? "<b> Additional Information : </b>".ucfirst(get_user_meta($user_id,'additional_information_for_tasker',true)) : '';
        /* end extra fields */ 

        // echo "<pre>"; print_r($mylevels);
        // $mylevels->name->enddate die;
        // echo date(get_option('date_format'), $mylevels[0]['enddate']);
        $ssorder = new MemberOrder();
        $ssorder->getLastMemberOrder();
        // echo "<pre>";print_r($ssorder); die;
        $current_user_id = get_current_user_id();
        $user_meta = get_userdata($current_user_id);

        $contact = "";

        $detailTable = $wpdb->prefix . "user_services";

        if (is_user_logged_in()) {
            // echo time();
            if ($user_meta->roles[0] == 'administrator' || $user_meta->roles[0] == 'subscriber') {
                if (isset($ssorder->status) && $ssorder->status != '') {
                    if ($ssorder->status == 'success') {
                        if (!$getService) {
                            $contact = "To get contact details, please select the <a href='" . site_url() . '/our-services/' . "'>service</a> first";
                        }
                    } else {
                        $contact = "Please do complete <a href=" . site_url() . '/pricing/' . ">payment</a> process before contact with tasker";
                    }
                } else {
                    $contact = "Without create <a href=" . site_url() . '/pricing/' . ">membership</a> you can't check tasker's email and phone number";
                }
            }
        } else {
            $contact = "Please <a href=" . site_url() . '/login' . ">login</a>/<a href=" . site_url() . '/become-a-member/' . ">signup</a> and procceed with payment first to get tasker email and phone";

            $contact = "Please subscribe to a plan by <a href=" . site_url() . '/login' . ">sign in</a>/<a href=" . site_url() . '/become-a-member/' . ">signup</a> to view tasker’s contact info";
        }
        ?>
        <div class="user-view-profile-wrap">
            <div class="user-view-wrap-left">
                <div class="user-listing">
                    <div class="user-avatar">
                        <?php
                        $imgName = km_get_show_user_avatar(array('item_id' => $user_id, 'html' => false, 'type' => 'large'));
                        echo '<img src="' . $imgName . '">';
                        ?>
                    </div>
                </div>
                <div class="services_list">

                    <?php

                    global $post;
                    $the_slug = $getService;
                    if ($the_slug) {
                        $args = array(
                            'name' => $the_slug,
                            'post_type' => 'km-services',
                            'post_status' => 'publish',
                            'numberposts' => 1
                        );

                        $service_id = get_posts($args);


                        if ($service_id[0]->ID) {
                            echo '<h4>Services List</h4>';
                            $sql = "select * from " . $detailTable . " where service_id =" . $service_id[0]->ID . " AND user_id =" . $user_id;
                            $service = $wpdb->get_results($sql);
                            $price = @$service[0]->price;
                            $title = @get_the_title($service[0]->service_id);
                            if ($price > 0) {
                                ?>
                                <div class="service-<?php echo $service[0]->id ?>">
                                    <div class="list-for-services"><span class="s-name"><?php echo $title ?></span>
                                        <span class="s-price"><b><sup>$</sup><?php echo $price ?></b> per hour</span>
                                    </div>
                                </div>
                            <?php }
                        }
                    } else {
                        $sqlServices = "select * from " . $detailTable . " where user_id =" . $user_id;
                        $services = $wpdb->get_results($sqlServices);

                        if ($services) {
                            $i = 0;
                            foreach ($services as $key => $val) {
                                $title = get_the_title($val->service_id);
                                $price = $val->price; ?>
                                <?php if ($price > 0) { ?>
                                    <?php if ($i == 0) { ?>
                                        <h4>Services List</h4>
                                    <?php } ?>
                                    <div class="services-"<?php echo get_the_ID() ?>>
                                        <div class="list-for-services"><span
                                            class="s-name"><?php echo $title ?></span><span
                                            class="s-price"><b><sup>$</sup><?php echo $price ?></b> per hour</span>
                                        </div>
                                    </div>
                                <?php }
                                $i++;
                            }
                        }
                    } ?>
                    </div>
                    </div>
                    <div class="user-view-wrap-right">
                    <div class="user-details">
                    <h3>
                    <?php echo ucfirst($first_name) . ' ' . ucfirst($last_name) ?></h3>
                    <?php if (!empty($about_services)) { ?>
                        <h5>About My Services</h5>

                        <p class="desc"><?php echo $about_services ?></p>

                        <h5>Additional Details</h5>
                        <p><?php echo $type_of_dog ?></p>
                        <p><?php echo $weight_of_dog ?></p>
                        <p><?php echo ucwords($pet_preferences) ?></p>
                        <p><?php echo $age_of_dog ?></p>
                        <p><?php echo ucwords($accept_puppies) ?></p>
                        <p><?php echo $additional_information_for_tasker ?></p>
                    <?php }
                    if (is_user_logged_in() && $user_meta->roles[0] == 'tasker') {
                        $contact_head = "";
                    } else {
                        $contact_head = "<h4>Contact Details</h4>";
                    }
                    echo $contact_head;
                    if (@$_GET['service'] && $_GET['service'] != '' && @$ssorder->membership_id != '' && @$ssorder->payment_type != '' && $ssorder->status == 'success') { ?>
                        <a href="#" class="button" data-popup-open="popup-profile">See Contact Details</a>
                        <div class="popup" data-popup="popup-profile">
                            <div class="popup-inner">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Contact Details</h4>
                                        <p class="status_res"></p>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" class="subscriber_id" name="subscriber_id"
                                        value=<?php echo $current_user_id ?>>
                                        <input type="hidden" class="user_service_id" name="user_service_id"
                                        value="<?php echo $service[0]->id ?>">
                                        <p><b style="color:red">Call : </b><?php echo $phone;
                                        ?></p>
                                        <p><b style="color:red">Email : </b><?php echo $user_email ?></p>

                                    </div>
                                </div>
                                <a class="popup-close" data-popup-close="popup-profile" href="#">x</a>
                            </div>
                        </div>

                    <?php } else {
                        echo '<p>' . $contact . '</p>';
                    } ?>
                </div>
                <?php $raitingTable = $wpdb->prefix . "review_raiting";
                $getUserCount = "SELECT COUNT(*) as count from " . $raitingTable . " where tasker_id = " . $user_id . " AND user_id =" . get_current_user_id();
                $countUsers = $wpdb->get_results($getUserCount);


                ?>
                <div class="review-wrap">
                    <div class="review">
                        <div>
                            <?php
                            if (is_user_logged_in()) {
                                if ($user_meta->roles[0] == 'administrator' || $user_meta->roles[0] == 'subscriber') {
                                    //if ($countUsers[0]->count == 0) {
                                    ?>

                                    <a class="reviewButton customReviewButton button" href="javascript:void(0);
                                    ">Write a Review</a>
                                    <?php // }
                                }
                            } else { ?>
                                <a class="button" href="<?php echo site_url() . '/login/' ?>">Login to Review</a>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="rating">
                        <h4>Reviews</h4>
                        <?php
                        $record = "SELECT COUNT(*) as count from " . $raitingTable . " where tasker_id = " . $user_id;
                        $records = $wpdb->get_results($record);
                        $count = $records[0]->count;
                        $avg = "SELECT AVG(rating) AS avg FROM " . $raitingTable . " where tasker_id = " . $user_id;
                        $avgRate = $wpdb->get_results($avg);
                        $rating = round($avgRate[0]->avg, 1);
                        echo '<div class=""><span></span> <span class="avg-rating"></span><span class="getRating">' . round($avgRate[0]->avg, 1) . ' (Rating)</span></div> ';
                        ?>
                    </div>
                </div>
                <?php
                if (is_user_logged_in()) {
                    if ($user_meta->roles[0] == 'administrator' || $user_meta->roles[0] == 'subscriber') {
                        // if ($countUsers[0]->count == 0) {
                        ?>
                        <div class="reviewForm" style="display: none;">
                            <span class="my-rating"></span>
                            <span class="live-rating"></span>
                            <form name='add_reviews' method="post" class='submitReviews' action="">
                                <div class="form-row">
                                    <input type="hidden" name="raiting" class="raiting" value="">
                                    <input type="hidden" name="tasker_id" value="<?php echo $user_id ?>">
                                    <!--  Review Headline<input type='text' required name='review_heading' placeholder='Review Headline' class='reviewHeading'> -->
                                </div>
                                <div class="form-row">
                                    Description<textarea class='add_reviews' required rows="5"
                                    name='add_reviews'></textarea>
                                    <input type="hidden" name="km_review_nonce"
                                    value="<?php echo wp_create_nonce('km-review-nonce'); ?>"/>
                                </div>
                                <input type='submit' name='review-submit' value="Submit">
                            </form>
                        </div>
                        <?php // }
                    }
                }
                ?>
                <div class="res">
                    <?php $sqlReview = "select * from " . $raitingTable . " where tasker_id =" . $user_id;
                    $reviews = $wpdb->get_results($sqlReview);
                    foreach ($reviews as $review => $rate) {

                        $before_string = substr($rate->review_description, 0, 200);
                        $after_string = substr($rate->review_description, 200);

                        if ($after_string) {
                            $before_string .= "<span style='display: none' class='more'>" . $after_string . "</span>";
                            $before_string .= "<a href='javascript:void()' style='cursor: pointer' class='reviewreadmore'>...Read More</a>";
                        }
                        // $reviewAll = $rate->review_description;
                        $imgName = km_get_show_user_avatar(array('item_id' => $rate->user_id, 'html' => false, 'type' => 'thumb'));

                        $imgUrl = '<img src="' . $imgName . '">';

                        echo '<div class="list_show_' . $rate->id . '">' . $imgUrl . '<p>' . $before_string . '</p></div>';

                        echo '<div class="list_hidden_' . $rate->id . '" style="display:none;">' . $imgUrl . '<p>' . $reviewAll . '</p></div>';
                    } ?>
                </div>

            </div>
            <script>
                jQuery(".reviewreadmore").on('click', function (e) {
                    e.preventDefault();
                    if (jQuery(this).hasClass('less')) {
                        jQuery(this).removeClass('less');
                        jQuery(this).html('...Read More');
                    } else {
                        jQuery(this).addClass('less')
                        jQuery(this).html(' Read Less');
                    }
                    jQuery(this).prev().toggle();
                });

                jQuery(".my-rating").starRating({
                    initialRating: 1,
                    minRating: 1,
                    disableAfterRate: false,
                    starSize: 20,
                    useGradient: false,
                    strokeWidth: 0,
                    activeColor: 'gold',
                    onHover: function (currentIndex, currentRating, $el) {
                        jQuery('.live-rating').text(currentIndex);
                    },
                    onLeave: function (currentIndex, currentRating, $el) {
                        jQuery('.live-rating').text(currentRating);
                        if (currentRating) {
                            jQuery('.raiting').val(currentRating);
                        } else {
                            jQuery('.raiting').val(1);
                        }
                    }
                });
                jQuery(document).ready(function () {
                    jQuery(".avg-rating").starRating({
                        initialRating: <?php echo $rating ?>,
                        readOnly: true,
                        starSize: 20,
                        useGradient: false,
                        strokeWidth: 0,
                        activeColor: 'gold'
                    });


                });

            </script>
        </div>
    </div>


    <?php
}
/* end view tasker profile  */

/*strat add reviews */
public function km_add_raiting()
{

    if (isset($_POST['review-submit']) && wp_verify_nonce($_POST['km_review_nonce'], 'km-review-nonce')) {
        global $wpdb;
        $reviewTable = $wpdb->prefix . "review_raiting";
        $user_id = get_current_user_id();
        $raiting = @$_POST['raiting'] ? $_POST['raiting'] : 1;
            // $title = $_POST['review_heading'];
        $desc = $_POST['add_reviews'];
        $tasker_id = $_POST['tasker_id'];
        $sqlQuery = "INSERT INTO " . $reviewTable . " (user_id,tasker_id,rating,review_description) VALUES (" . $user_id . "," . $tasker_id . "," . $raiting . ",'" . $desc . "')";
            // echo $sqlQuery; die;
        $wpdb->query($sqlQuery);
    }
}
/* end add reviews */
/* start add tasker contact */
public function km_add_tasker_contact()
{
    $subscriber_id = $_POST['subscriber_id'];
    $user_service_id = $_POST['user_service_id'];
    $args = array(
        'meta_key' => 'user_service_id',
        'meta_value' => $user_service_id,
        'meta_compare' => '='
    );
    $user_query = new WP_User_Query($args);
        // Get the results
    $user_service = $user_query->get_results();
        // Check for results
    if (!empty($user_service)) {
        $res = 'This tasker already added in your contact list';
    } else {
        add_user_meta($subscriber_id, 'user_service_id', $user_service_id);
        add_user_meta($subscriber_id, 'user_tasker_contact_date', time());
        $res = 'Tasker has been added in your contact list';
    }
    echo $res;
    die;
}
/*end add tasker contact */

/*start tasker contact*/
public function km_get_tasker_contact()
{ ?>
    <div id="pmpro_tasker-contact" class="pmpro_box">

        <h3>Tasker Contact</h3>
        <p>Everyday work is important, but it's also time consuming</p>
        <p>we can help.</p>

        <?php
        global $wpdb;
        $user_id = get_current_user_id();
        $taskers = get_user_meta($user_id, 'user_service_id', false);
        $detailTable = $wpdb->prefix . "user_services";
        $i = 1;
        if ($taskers){ ?>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Email Address</th>
                        <th>Contact Date</th>
                        <th>Service</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($taskers as $id) {
                        $sql = "select * from " . $detailTable . " where id = " . $id;
                        $service = $wpdb->get_results($sql);
                        if ($service) {
                            $price = $service[0]->price;
                            $serviceTitle = get_the_title($service[0]->service_id);
                            $service_user_id = $service[0]->user_id;
                            $userData = get_userdata($service_user_id);
                            $user_email = $userData->data->user_email;
                            $user_contact_date = get_user_meta($user_id, 'user_tasker_contact_date', true);
                            $date = date('M d, Y', $user_contact_date);
                            ?>
                            <tr>
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo ucwords(get_user_meta($service_user_id, 'first_name', true)) . " " . ucwords(get_user_meta($service_user_id, 'last_name', true));
                                    ?>
                                </td>
                                <td>
                                    <?php echo get_user_meta(@$service_user_id, 'user_mobile', true); ?>
                                </td>
                                <td>
                                    <?php echo $user_email; ?>
                                </td>
                                <td>
                                    <?php echo $date; ?>
                                </td>
                                <td>
                                    <?php echo $serviceTitle; ?>
                                </td>
                                <td>
                                    <?php echo "$" . $price; ?>
                                </td>
                            </tr>
                            <?php $i++;
                        }
                    }
                } else {
                    echo '<span class="error text-center">You have not contact to any tasker.</span>';
                } ?>

            </tbody>
        </table>
            <?php //Todo: If there are multiple levels defined that aren't all in the same group defined as upgrades/downgrades
            ?>

        </div> <!-- end pmpro_account-membership -->
    <?php }

    /* end tasker Contact*/
    public function km_get_my_reviews()
    {
        $res = '';
        global $wpdb;
        $current_user_id = get_current_user_id();
        $user_meta = get_userdata($current_user_id);
        if ($user_meta->roles[0] == 'tasker') {
            $i = 0;
            /* first part start pagination */
            $posts_per_page = get_option('posts_per_page');
            $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
            $offset = ($page - 1) * $posts_per_page;
            /* first part end pagination*/


            $raitingTable = $wpdb->prefix . "review_raiting";
            $records = "SELECT * from " . $raitingTable . " where tasker_id = " . $current_user_id;
            // echo "Query is".$records;
            // $getRes = $wpdb->get_results($records);
            $record_count = "SELECT COUNT(*) as count from " . $raitingTable . " where tasker_id = " . $current_user_id;
            $recordsCount = $wpdb->get_results($record_count);
            $count = $recordsCount[0]->count;
            // echo "counrterw".$count;
            $avg = "SELECT AVG(rating) AS avg FROM " . $raitingTable . " where tasker_id = " . $current_user_id;
            $avgRate = $wpdb->get_results($avg);
            $rating = round($avgRate[0]->avg, 1);
            if ($rating > 0) {
                echo '<div class="agg-rating text-center"><span><strong>Aggregate Rating:</strong></span> <span class="avg-rating"></span><span class="getRating">' . round($avgRate[0]->avg, 1) . ' (Rating)</span></div>';
            } else { ?>
                <span class="error text-center">You have not any review yet.
                </span>
            <?php }

            $sqlReview = "select * from " . $raitingTable . " where tasker_id =" . $current_user_id." LIMIT ".$offset.", ".$posts_per_page;
            $reviews = $wpdb->get_results($sqlReview);
            ?>
            <div class="users-main-section">
                <?php 
                foreach ($reviews as $review => $rate) {
                    $i++;
                    $first_name = get_user_meta($rate->user_id, 'first_name', true);
                    $last_name = get_user_meta($rate->user_id, 'last_name', true);
                    $full_name = ucfirst($first_name) . " " . ucfirst($last_name);
                    ?>

                    <div class="users-main-wrap">
                        <div class="user-listing">
                            <div class="user-avatar">
                                <?php
                                $imgName = km_get_show_user_avatar(array('item_id' => $rate->user_id, 'html' => false, 'type' => 'medium'));
                                ?>
                                <img src="<?php echo $imgName; ?>">
                            </div>
                        </div>
                        <div class="user-details">
                            <div class="user-inner-head">
                                <div class="name-sec">
                                    <h4><?php echo $full_name ?></h4>
                                    <div class="rating-wrap">
                                        <span class="avg-rating-<?php echo $i ?>"></span>
                                        <span class="getRating">
                                            <?php echo $rate->rating ?> Rating
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="user-inner-body">
                                <div class="review-sec">
                                    <?php
                                    $imgName = km_get_show_user_avatar(array('item_id' => $current_user_id,
                                        'html' => false, 'type' => 'thumb'));

                                        ?>
                                        <img src="<?php echo $imgName; ?>">
                                        <p><?php echo $rate->review_description ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <script>
                            jQuery(document).ready(function () {
                                var i = <?php echo $i ?>;
                                jQuery(".avg-rating-" + i).starRating({
                                    initialRating: <?php echo $rate->rating ?>,
                                    readOnly: true,
                                    starSize: 20,
                                    useGradient: false,
                                    strokeWidth: 0,
                                    activeColor: 'gold'
                                });
                            });
                        </script>
                    <?php } ?>
                    <script>
                        jQuery(".avg-rating").starRating({
                            initialRating: <?php echo $rating ?>,
                            readOnly: true,
                            starSize: 20,
                            useGradient: false,
                            strokeWidth: 0,
                            activeColor: 'gold'
                        });
                    </script>
                    <?php  
                    /* strat last part pagination */
                    echo '<div id="support-pagination" class="clearfix pagination">';
                    echo paginate_links( array(
                        'base' => add_query_arg( 'cpage', '%#%' ),
                        'format' => '',
                        'prev_next' => true,
                        'total' => ceil($count / $posts_per_page),
                        'current' => $page
                    )); 
                    echo '</div>';
                    /* end last part pagination */
                    ?>
                </div>
            <?php  } else {
                /* first part start pagination */
                $posts_per_page = get_option('posts_per_page');
                $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
                $offset = ($page - 1) * $posts_per_page;

                /* first part end pagination*/
                $raitingTable = $wpdb->prefix . "review_raiting";
                $records = "SELECT * from " . $raitingTable . " where user_id = " . $current_user_id." LIMIT ".$offset.", ".$posts_per_page;
                $count_records = "SELECT COUNT(*) as count from " . $raitingTable . " where user_id = " . $current_user_id;
                $countRec = $wpdb->get_results($count_records);
                $count = $countRec[0]->count;


                $getRes = $wpdb->get_results($records);
                if ($getRes) {
                    $i = 1; ?>
                    <div class="users-main-section">
                        <?php foreach ($getRes as $k => $v) {
                            $tasker_id = $v->tasker_id;
                            $first_name = get_user_meta($tasker_id, 'first_name', true);
                            $last_name = get_user_meta($tasker_id, 'last_name', true);
                            $full_name = ucfirst($first_name) . " " . ucfirst($last_name);
                            ?>

                            <div class="users-main-wrap">
                                <div class="user-listing">
                                    <div class="user-avatar">
                                        <?php
                                        $imgName = km_get_show_user_avatar(array('item_id' => $tasker_id, 'html' => false, 'type' => 'medium'));
                                        ?>
                                        <a href="<?php echo site_url() . '/view-profile/?id=' . $v->tasker_id ?>"
                                            > <img src="<?php echo $imgName; ?>"></a>
                                            <!-- <img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/default-img.png' ?>"> -->
                                        </div>
                                        <a href="<?php echo site_url() . '/view-profile/?id=' . $v->tasker_id ?>"
                                         class="button">View Profile</a>
                                     </div>
                                     <div class="user-details">
                                        <div class="user-inner-head">
                                            <div class="name-sec">
                                                <h4><?php echo $full_name ?></h4>
                                                <div class="rating-wrap">
                                                    <span class="review-rating-<?php echo $i ?>"></span><span
                                                    class="getRating"><?php echo $v->rating ?> Rating
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="user-inner-body">
                                        <div class="review-sec">
                                            <?php
                                            $imgName = km_get_show_user_avatar(array('item_id' => $current_user_id,
                                                'html' => false, 'type' => 'thumb'));
                                                ?>
                                                <img src="<?php echo $imgName; ?>">
                                                <p><?php echo $v->review_description ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    jQuery(document).ready(function () {
                                        jQuery(".review-rating-<?php echo $i ?>").starRating({
                                            initialRating: <?php  echo $v->rating ?>,
                                            readOnly: true,
                                            starSize: 20,
                                            useGradient: false,
                                            strokeWidth: 0,
                                            activeColor: 'gold'
                                        });
                                    });
                                </script>
                                <?php
                                $i++;
                            }
                            echo '<div id="support-pagination" class="clearfix pagination">';
                            echo paginate_links( array(
                                'base' => add_query_arg( 'cpage', '%#%' ),
                                'format' => '',
                                'prev_next' => true,
                                'total' => ceil($count / $posts_per_page),
                                'current' => $page
                            )); 
                            ?>
                        </div>
                        <?php 

                    }else{
                        echo '<span class="error text-center">You have not any review yet.</span>';
                    }
                }
                return $res;
            }
        }
        new kmlist();
