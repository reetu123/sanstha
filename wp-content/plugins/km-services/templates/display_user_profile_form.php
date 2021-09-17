<?php
global $post;
global $wpdb;
$args = array(
    'post_type' => 'km-services',
    'post_status' => array('publish'),
    'posts_per_page' => -1,
    'orderby' => 'post_date',
    'order' => 'DESC',
);
$all_services = new WP_Query($args);
global $wp_query;
$counter = 1;
if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    /* start user details */
    $user = get_userdata($user_id);
// echo "<pre>"; print_r($user);
    $user_email = $user->data->user_email;
} else {
    $user_id = "";
}

// echo $user_email; die;
$phone = @get_user_meta($user_id, 'user_phone', true) ? get_user_meta($user_id, 'user_phone', true) : "";
$mobile = @get_user_meta($user_id, 'user_mobile', true) ? get_user_meta($user_id, 'user_mobile', true) : "";
$billing_postcode = @get_user_meta($user_id, 'billing_postcode', true) ? get_user_meta($user_id, 'billing_postcode', true) : "";
$about_services = @get_user_meta($user_id, 'about_services', true) ? get_user_meta($user_id, 'about_services', true) : "";
/* end user details */

/* User services get data start */
$detailTable = $wpdb->prefix . "user_services";
$sql = "select service_id,price from " . $detailTable . " where user_id =" . $user_id;
$data_sql = $wpdb->get_results($sql);
$service_array = array();
foreach ($data_sql as $ndata) {
    $service_array[] = $ndata->service_id;
}
/* User services get data end */
/* start locations */
$locationTable = $wpdb->prefix . "locations";
$locationsSql = "select * from " . $locationTable . " where user_id =" . $user_id;
$locations = $wpdb->get_results($locationsSql);
/* end locations */

?>
<script> var incnumber = 0;
var Markerdata = [];</script>
<div class="pippin_msg text-center">
    <?php if (@$_GET['status']) {
        if ($_GET['status'] == 'success') {
            echo '<span class="success text-center">You have successfully registered with wooffy. Please <a href=' . site_url() . '/login/>login</a> to proceed further.</span>';
        } else if ($_GET['status'] == 'update') {
            echo '<span class="success text-center">Your Profile has been updated successfully.</span>';
        }
    } ?>
</div>
<div class="form-profile">
    <?php if (is_user_logged_in()) {
        get_template_part('upload_profile');
    } ?>

    <form method="post" id="signupform" class="signup-form" action="javascript:void(0)" enctype="multipart/form-data">
        <fieldset>
            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
            <div class="form-row half">
                <label for="first_name">First Name <span class="asterisk">*</span></label>
                <input type="text" id="first_name" name="first_name"
                value="<?php echo get_user_meta($user_id, 'first_name', true) ?>" size="20">
            </div>
            <div class="form-row half">
                <label id="last_name">Last Name <span class="asterisk">*</span></label>
                <input type="text" id="last_name" name="last_name" size="25"
                value="<?php echo get_user_meta($user_id, 'last_name', true) ?>">
            </div>
            <div class="form-row half">
                <label id="user_phn">Phone <span class="asterisk">*</span></label>
                <input type="tel" required  id="user_phone"
                name="user_phone" size="25" value="<?php echo get_user_meta($user_id, 'user_phone', true) ?>">
            </div>
            <!-- <div class="form-row half">
                <label for="mobile">Mobile <span class="asterisk">*</span></label>
                <input type="text" id="user_mobile" name="user_mobile" size="25"
                value="<?php // echo get_user_meta($user_id, 'user_mobile', true) ?>">
            </div> -->
            <?php // if (!is_user_logged_in()) { ?>

                <div class="form-row half">
                    <label for="type_of_dog">Type Of Dog <span class="asterisk">*</span></label>
                    <input type="text" id="type_of_dog"
                    name="type_of_dog" size="25" value="<?php echo get_user_meta($user_id, 'type_of_dog', true) ?>">

                   <?php /* <select id="type_of_dog" name="type_of_dog">
                        <option <?php echo get_user_meta($user_id, 'type_of_dog', true) == 'pit_bull' ? 'selected' : ''; ?>
                        value="pit_bull">Pit Bull
                    </option>
                    <option <?php echo get_user_meta($user_id, 'type_of_dog', true) == 'american_staffordshire_terrier' ? 'selected' : ''; ?>
                    value="american_staffordshire_terrier">American Staffordshire Terrier
                </option>
                <option <?php echo get_user_meta($user_id, 'type_of_dog', true) == 'german_spaniel' ? 'selected' : ''; ?>
                value="german_spaniel">German Spaniel
            </option>
            <option <?php echo get_user_meta($user_id, 'type_of_dog', true) == 'pug' ? 'selected' : ''; ?>
            value="pug">Pug
        </option>
        </select> */ ?>
    </div>
    <div class="form-row half weight">
        <label for="weight_of_dog">Weight Of Dog <span class="asterisk">*</span></label>
        <input type="text" id="weight_of_dog" name="weight_of_dog" size="25"
        value="<?php echo @get_user_meta($user_id, 'weight_of_dog', true) ?>">
        <select name="weight_into">
            <option <?php echo get_user_meta($user_id, 'weight_into', true) == 'kg' ? 'selected' : ''; ?>
            value="kg">KG
        </option>
        <option <?php echo get_user_meta($user_id, 'weight_into', true) == 'lbs' ? 'selected' : ''; ?>
        value="lbs">LBS
    </option>
</select>
</div>
<div class="form-row half">
    <label for="pet_preferences">Pet Preferences <span class="asterisk">*</span></label>
    <select id="pet_preferences" name="pet_preferences">
        <option value="small">Small</option>
        <option value="medium">Medium</option>
        <option value="large">Large</option>
    </select>
    <!-- <input type="tel" id="pet_preferences"
        name="pet_preferences" size="25" value="<?php // echo get_user_meta($user_id, 'pet_preferences', true) ?>"> -->
    </div>
    <div class="form-row half">
        <label for="age_of_dog">Age of Dog <span class="asterisk">*</span></label>
        <input type="tel" id="age_of_dog"
        name="age_of_dog" size="25" value="<?php echo get_user_meta($user_id, 'age_of_dog', true) ?>">
    </div>
    <div class="form-row half">
        <label for="accept_puppies">Do you accept puppies? <span class="asterisk">*</span></label>
        <select id="accept_puppies" name="accept_puppies">
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
    </div>


    <div class="form-row additional_information">
        <label for="additional_information">Additional Information</label>
        <textarea id="additional_information_for_tasker"
        name="additional_information_for_tasker"><?php echo @get_user_meta($user_id, 'additional_information_for_tasker', true) ?></textarea>

    </div>
    <?php // } ?>
    <div class="form-row">
        <label for="email">Email <span class="asterisk">*</span></label>
        <input type="text" id="email" <?php echo is_user_logged_in() ? 'readonly' : '' ?>
        class="<?php echo is_user_logged_in() ? 'disabled' : '' ?>" name="email" size="25"
        value="<?php echo @$user_email ?>">
    </div>
    <?php if (!is_user_logged_in()) { ?>
        <div class="form-row">
            <label for="password">Password <span class="asterisk">*</span></label>
            <input type="password" id="password" name="password" size="25" value="">
        </div>
        <div class="form-row">
            <label for="password">Confirm Password <span class="asterisk">*</span></label>
            <input type="password" id="confirm_password" name="confirm_password" size="25" value="">
        </div>
    <?php } ?>
    <div class="form-row">
        <label for="postcode">Postal Code<span class="asterisk">*</span></label>
        <input type="text" id="postcode" name="postcode" size="25"
        value="<?php echo $billing_postcode ?>">
    </div>
    <div class="form-row">
        <label for="about_services">About My Services</label>
        <textarea id="about_services" name="about_services"><?php echo $about_services ?></textarea>
    </div>
    <div class="form-row">
        <label><strong>Services List</strong></label>
        <?php
        $cindex = 0;
        if ($all_services->have_posts()):
            while ($all_services->have_posts()):
                $all_services->the_post();
                global $post;
                $post_id = get_the_ID();
                $post_title = get_the_title();
                $priceSql = "select price from " . $detailTable . " where user_id =" . $user_id . " AND service_id =" . $post_id;
                $price_sql = $wpdb->get_results($priceSql);
                if (in_array($post_id, $service_array) && $price_sql[0]->price > 0) {
                    $price = $price_sql[0]->price;
                    $checked = 'checked';
                } else {
                    $price = "";
                    $checked = '';
                }
                ?>
                <div class="service-sec">
                    <div class="check">
                        <input data-attr="customcheck" type="checkbox" id="<?php echo $post_id ?>" value="<?php
                        echo
                        $post_id ?>"
                        name="service[]" <?php echo $checked ?>>
                        <label for="<?php echo $post_id ?>"><?php echo $post_title ?></label>
                        <input type="hidden" id="<?php echo $post_id ?>" name="service_id[]"
                        value="<?php echo $post_id ?>">
                    </div>
                    <div class="price">
                        <span>$</span>
                        <input type="text" name="service_price[]" width="60px" class="service-price"
                        value="<?php echo $price ?>">
                        <span>Per Hour</span>
                    </div>
                </div>
                <?php $cindex++; ?>
            <?php endwhile;
        endif; ?>
    </div>

    <div class="form-row">

        <div class="first-location-field">
            <div id="serve_area_wrapper" class="serve_area_wrapper serve_area_wrapper_child">
                <div class="area-finder">
                    <div class="address-bar">
                        <label for="areaaddress"><strong>What Locations do you serve?</strong></label>
                        <i class="far fa-map-marker-alt"></i>
                        <input type="text" name="area_areaaddress[]" class="areaaddress" id="areaaddress"
                        class="form-control address">
                        <input type="hidden" name="area_latitude[]" class="form-control" id="arealatitude"
                        value="">
                        <input type="hidden" name="area_longitude[]" class="form-control" id="arealongitude"
                        value="">
                        <input type="hidden" name="area_city[]" class="form-control" id="areacity" value="">
                        <input type="hidden" name="area_state[]" class="form-control" id="areastate" value="">
                        <input type="hidden" name="area_country[]" class="form-control" id="areacountry"
                        value="">
                        <input type="hidden" name="area_pincode[]" class="form-control" id="areapincode"
                        value="">
                    </div>
                    <div class="radius">
                        <label for="radius">Radius</label>
                        <!--    <input type="text" id="radiuslength" name="area_radius_length[]" class="radius_change" placeholder="Enter Radius"> -->

                        <select name="area_radius_length[]" id="radiuslength" class="form-control radius_update">
                            <option value="5">5 KM</option>
                            <option value="10">10 KM</option>
                            <option value="15">15 KM</option>
                            <option value="20">20 KM</option>
                            <option value="25">25 KM</option>
                            <option value="30">30 KM</option>
                        </select>
                    </div>
                    <input type="hidden" class="countLocation" name="counterLocation" value="1">
                </div>
                <a href="#" mapid="<?php echo $incnumber ?>" class="remove"><i class="fa fa-trash-alt"></i></a>

            </div>
            <a href="javascript:void(0)" id="addarea" class="button add_location_button">Add</a>

        </div>
        <div class="row-map">
            <div id="map" style="z-index:1000; height:270px; width:100%;"></div>
        </div>
        <div class="serve_area_append_wrapper">
            <?php
            $incnumber = 0;
            foreach ($locations as $key => $area): ?>
                <div class="serve_area_wrapper_child">
                    <div class="area-finder">
                        <div class="address-bar">
                            <i class="far fa-map-marker-alt"></i>
                            <input type="text" name="areaaddress[]" class="areaaddress"
                            id="areaaddress<?php echo $incnumber ?>" class="form-control address"
                            value="<?php echo $area->full_address ?>">
                            <input type="hidden" name="latitude[]" class="form-control"
                            id="arealatitude<?php echo $incnumber ?>"
                            value="<?php echo $area->latitude ?>">
                            <input type="hidden" name="longitude[]" class="form-control"
                            id="arealongitude<?php echo $incnumber ?>"
                            value="<?php echo $area->longitude ?>">
                            <input type="hidden" name="city[]" class="form-control"
                            id="areacity<?php echo $incnumber ?>" value="<?php echo $area->city ?>">
                            <input type="hidden" name="state[]" class="form-control"
                            id="areastate<?php echo $incnumber ?>" value="<?php echo $area->state ?>">
                            <input type="hidden" name="country[]" class="form-control"
                            id="areacountry<?php echo $incnumber ?>"
                            value="<?php echo $area->country ?>">
                            <input type="hidden" name="pincode[]" class="form-control"
                            id="areapincode<?php echo $incnumber ?>" value="<?php echo $area->zip ?>">
                        </div>
                        <div class="radius">
                            <label for="radius">Radius</label>
                     <?php /*   <input type="text" id="radiuslength" name="radius_length[]" value="<?php echo $area->radius_length ?>" class="radius_change" placeholder="Enter Radius">

                        <select name="radius_type[]" id="radius" class="form-control radius_update">
                            <option   <?php echo ($area->radius_type == 'miles') ? 'selected' :""?> value="miles">Miles</option>
                            <option <?php echo ($area->radius_type == 'km') ? 'selected' :""?>  value="km">KM</option>
                            </select> */ ?>


                            <select name="radius_length[]" id="radiuslength" class="form-control radius_update" mapid ="<?php echo $incnumber ?>" >
                                <option <?php echo $area->radius_length == 5 ? 'selected' : ''?> value="5">5 KM</option>
                                <option <?php echo $area->radius_length == 10 ? 'selected' : ''?> value="10">10 KM</option>
                                <option <?php echo $area->radius_length == 15 ? 'selected' : ''?> value="15">15 KM</option>
                                <option <?php echo $area->radius_length == 20 ? 'selected' : ''?> value="20">20 KM</option>
                                <option <?php echo $area->radius_length == 25 ? 'selected' : ''?> value="25">25 KM</option>
                                <option <?php echo $area->radius_length == 30 ? "selected" : "" ?> value="30">30 KM</option>
                            </select>
                        </div> 
                    </div>
                    <a href="#" mapid="<?php echo $incnumber ?>" class="remove"><i class="fa fa-trash-alt"></i></a>

                    <script>
                        var appendData = [];
                        appendData[0] = "<?php echo $area->latitude ?>";
                        appendData[1] = "<?php echo $area->longitude ?>";
                        appendData[2] = "<?php echo $area->radius_length ?>";
                        appendData[3] = "<?php echo $area->radius_type ?>";
                        Markerdata[<?php echo $incnumber ?>] = appendData;
                                // DrawMarkers();
                                // console.log("append data is" + appendData);
                            </script>
                        </div>
                        <?php
                        $incnumber++;
                    endforeach; ?>
                    <input type="hidden" name="incnumber" id="incnumber" value="<?php echo $incnumber ?>">

                </div>
            </div>
            <div class="form-row">

                <?php if (!(is_user_logged_in())) { ?>
                    <div class="check">
                        <input type="checkbox" name="accept_cond"
                        id="accept_cond" <?php echo is_user_logged_in() ? 'checked' : '' ?> >
                        <label for="accept_cond">I accept the <a href="<?php echo site_url('/term-and-conditions');
                        ?>">terms and conditions</a></label>
                    </div>
                <?php } ?>


                <!--  <div class="check">
                   <input type="checkbox" name="other_text1" id="other_text" class="other_text">
                   <label for="other_text">Other</label>
               </div> -->

                <!--  <div class="check">
                     <input type="checkbox" name="other_text1"  required id="other_text" class="other_text">
                     <label for="other_text">Other</label>
                 </div> -->
             </div>
             <div class="form-row">
                <input type="submit" value="Submit" class="submitForm" name="submit-form">
            </div>
        </form>
    </div>
    <?php ?>
    <script>

        jQuery(document).ready(function ($) {
        // $(function () {
        //     $(window).scrollTop($("input").offset().top - 100);
        // });

        $("input.service-price").each(function () {
            jQuery(this).keypress(function (e) {
                if (e.which < 0x20) {
                    // e.which < 0x20, then it's not a printable character
                    // e.which === 0 - Not a character
                    return;     // Do nothing
                }
                if (this.value.length == 5) {
                    alert('Price must be under 5 digits')
                    e.preventDefault();
                } else if (this.value.length > 5) {

                    this.value = this.value.substring(0, 5);
                }

            })

        });

        var formValidate = jQuery("#signupform").validate({
            errorElement: 'span',
            rules: {
                first_name: "required",
                last_name: "required",
                user_mobile: "required",
                type_of_dog: "required",
                weight_of_dog: "required",
                pet_preferences: "required",
                age_of_dog:"required",
                accept_puppies: "required",
                additional_information_for_tasker: {
                    required: "#other_text:checked",
                },
                "service[]": "required",

                accept_cond: "required",
                email: {
                    required: true,
                    email: true
                },
                postcode: {
                    required: true,
                    minlength: 5,
                },
                password: {
                    required: true,
                    minlength: 5,
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                }

            },
            messages: {
                first_name: "First Name is required",
                last_name: "Last Name is required",
                user_mobile: "Mobile number is required",
                type_of_dog: "Type of dog Required",
                weight_of_dog: "Weight of dog is required",
                pet_preferences: "Pet preferences is required",
                age_of_dog: "Age of dog is required",
                accept_puppies: "This field is required",
                additional_information_for_tasker: "Additional informaion is required",
                "service[]": "Select at least one service",
                accept_cond: "Please accept term and conditions",
                email: {
                    required: "Email is required",
                },
                postcode: {
                    required: "Postal code is required",
                    minlength: "Pleaes enter a valid postal code",
                },
                password: {
                    required: "Password is required",
                },
                confirm_password: {
                    required: "Confirm password is required",
                }

            },
            errorPlacement: function (error, element) {

                if (element.data("attr") == "customcheck") {
                    error.insertBefore(element.parent());
                } else {
                    element.parent().append(error)
                }

            },
            invalidHandler: function (form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    validator.errorList[0].element.focus();
                }
                $("input.service-price").each(function () {
                    if ($(this).parent().prev().find('input[type=checkbox]').is(':checked')) {
                        if ($(this).val() == "" && $(this).val().length < 1) {
                            $(this).addClass('error');
                        } else {
                            $(this).removeClass('error');
                            $(this).parent().find('label.error').remove();
                        }
                    } else {
                        $(this).parent().find('label.error').remove();
                    }
                });
            },

            submitHandler: function (form) {
                var isValid = true;
                $("input.service-price").each(function () {
                    if ($(this).parent().prev().find('input[type=checkbox]').is(':checked')) {
                        if ($(this).val() == "" && $(this).val().length < 1) {
                            $(this).addClass('error');
                            isValid = false;
                        } else {
                            $(this).removeClass('error');
                        }

                    }
                });

                if (isValid) {
                    form.submit();
                }
            }
        });


        // jQuery(document).on('click', '.other_text', function () {
        //     if (jQuery('.other_text').is(":checked")) {
        //         jQuery(".additional_information").show();
        //     } else {
        //         jQuery(".additional_information").hide();
        //     }
        // });

        $(".signup-form").on('submit', function () {
            var errors;

            var isValid = true;
            if (formValidate.valid()) {

                $("input.service-price").each(function () {
                    if ($(this).parent().prev().find('input[type=checkbox]').is(':checked')) {

                        if ($(this).val() == "" && $(this).val().length < 1) {
                            $(this).addClass('error');
                            isValid = false;
                        } else {
                            $(this).removeClass('error');
                        }

                    }
                });

                if (isValid) {
                    var serializeForm = jQuery(this).closest('form').serialize();

                    $.ajax({
                        url: "<?php echo admin_url('admin-ajax.php') ?>",
                        type: 'post',
                        data: {
                            action: 'km_post_search_ajax',
                            form_data: serializeForm,
                        },
                        success: function (res) {
                            if (res != '') {
                                if (res == "Success") {
                                    var loc = window.location.href + '../';

                                    window.location.replace(window.location.href);
                                    <?php if(is_user_logged_in()){ ?>
                                        window.location.replace(window.location.href + '?status=update');
                                    // jQuery(".pippin_msg").append("<span class='sucess text-center'>Your Profile has been updated successfully</span>");
                                <?php }else{ ?>
                                    window.location.replace(window.location.href + '?status=success');
                                    // jQuery(".pippin_msg").append("<span class='success text-center'>You have successfully registered with woofy. Please <a href='<?php echo site_url() . "/login/" ?>'>login</a> to proceed further</span>");
                                <?php } ?>
                            } else {
                             $('html, body').animate({
                                'scrollTop' : $("#signupform").position().top+20
                            }, (1000));
                             jQuery(".pippin_msg").html("<span class='error text-center'>" + res + "</span>");
                         }
                     }
                 }
             });
                } else {
                    $(window).scrollTop($("input.service-price").offset().top - 100);
                }


            }
        });

    });


</script>