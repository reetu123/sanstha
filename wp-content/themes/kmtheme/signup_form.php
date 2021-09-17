<?php
/**
 * Template Name: Signup Form
 */
get_header();
?>
<div class="wrap">
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php
            global $wpdb;
            global $error;
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                /* start user details */
                $user = get_userdata($user_id);
                    // echo $user_id;
                    // echo "<pre>"; print_r($user);
                $user_email = @$user->data->user_email ? $user->data->user_email : '';
                $user_first_name = get_user_meta($user_id, 'first_name', true);

                $user_last_name = @get_user_meta($user_id, 'last_name', true) ? get_user_meta($user_id, 'last_name', true) : '';
                $user_mobile = @get_user_meta($user_id, 'user_mobile', true) ? get_user_meta($user_id, 'user_mobile', true) : '';
                $user_phone = @get_user_meta($user_id, 'user_phone', true) ? get_user_meta($user_id, 'user_phone', true) : '';
                $zip_postal = @get_user_meta($user_id, 'zip_postal', true) ? get_user_meta($user_id, 'zip_postal', true) : '';
                $hear_about = @get_user_meta($user_id, 'hear_about', true) ? get_user_meta($user_id, 'hear_about',
                    true) : '';
                $other_hear_about = @get_user_meta($user_id, 'other_hear_about', true) ? get_user_meta($user_id, 'other_hear_about',
                    true) : '';


            } else {
                $user_id = "";
            }

                // if (!is_user_logged_in()) {

            ?>
            <div class="login-wrap signup">
                <div class="login-form-inner">
                    <div class="heading_profile">
                        <?php if (!is_user_logged_in()) { ?>
                            <h3>Sign Up For Wooffy</h3>
                        <?php } else { ?>
                            <h3>Update Profile</h3>
                        <?php } ?>
                    </div>
                    <div class="alar-login-form main_shadow_wrap clearfix">
                        <?php km_show_error_messages(); ?>
                        <div class="pippin_msg text-center">
                            <?php if (@$_GET['status']) {
                                if ($_GET['status'] == 'success') {
                                    echo '<span class="success text-center">You have successfully registered with woofy. Please <a href=' . site_url() . '/login/>login</a> to proceed further.</span>';
                                } else if ($_GET['status'] == 'update') {
                                    echo '<span class="success text-center">Your Profile has been updated successfully.</span>';
                                }
                            } ?>
                        </div>
                        <div class="form-profile">
                            <!-- start upload form -->
                            <?php if (is_user_logged_in()) {
                                get_template_part('upload_profile');
                            } ?>

                            <form method="post" id="signupform" name="signupform">
                                <input type="hidden" name="login_user_id" value="<?php echo $user_id ?>">
                                <div class="ftxt">
                                    <label><?php _e('First Name', ''); ?><span class="asterisk">*</span> </label>
                                    <input type="text" tabindex="10" size="20" class="input" id="first_name"
                                    name="first_name" value="<?php echo @$user_first_name ?>"/>
                                </div>
                                <div class="ftxt">
                                    <label><?php _e('Last Name', ''); ?> <span class="asterisk">*</span></label>
                                    <input type="text" tabindex="20" size="20"
                                    value="<?php echo @$user_last_name ?>" class="input" id="last_name"
                                    name="last_name"/>
                                </div>
                                <div class="ftxt half">
                                    <label><?php _e('Phone No.', ''); ?></label>
                                    <input type="text" name="user_phone" tabindex="20" size="20"
                                    value="<?php echo @$user_phone ?>" class="input" id="user_phone"/>
                                </div>
                                <!-- <div class="ftxt half">
                                    <label><?php _e('Mobile No.', ''); ?><span class="asterisk">*</span></label>
                                    <input type="text" name="user_mobile" tabindex="20" size="20"
                                    value="<?php echo @$user_mobile ?>" class="input" id="user_mobile"/>
                                </div> -->
                                <div class="ftxt half">
                                    <label><?php _e('Email', ''); ?><span class="asterisk">*</span> </label>
                                    <input type="email" tabindex="20" size="20" value="<?php echo @$user_email ?>"
                                    class="input <?php echo is_user_logged_in() ? 'disabled' : '' ?>"
                                    id="email" <?php echo is_user_logged_in() ? 'readonly' : '' ?>
                                    name="email"/>
                                </div>
                                <?php if (!is_user_logged_in()) { ?>

                                    <div class="ftxt">
                                        <label><?php _e('Create a password', ''); ?><span class="asterisk">*</span>
                                        </label>
                                        <input type="password" tabindex="20" size="20" value="" class="input"
                                        id="password" name="password"/>
                                    </div>

                                    <div class="ftxt">
                                        <label><?php _e('Confirm password', ''); ?><span class="asterisk">*</span>
                                        </label>
                                        <input type="password" tabindex="20" size="20" value="" class="input"
                                        id="confirm_password" name="confirm_password"/>
                                    </div>
                                <?php }
                                ?>
                                <div class="ftxt">
                                    <label><?php _e('Postal Code', ''); ?> <span
                                        class="asterisk">*</span></label>
                                        <input type="text" tabindex="20" size="20" name="zip_postal" class="input"
                                        id="zip_postal" value="<?php echo @$zip_postal ?>" />
                                    </div>


                                    <div class="ftxt">
                                        <label><?php _e('How did you hear about us?(Optional)', ''); ?> </label>
                                        <select name="hear_about" class="hear_about" id="hear_about">
                                            <option value="">Select an Option</option>
                                             <option <?php echo (($hear_about =='google')?'selected="selectd"':'')
                                            ?> value="friends_/_family">Friends/Family</option>
                                            <option <?php echo (($hear_about =='google')?'selected="selectd"':'')
                                            ?> value="google">Google</option>
                                            <option <?php echo (($hear_about =='social_media')?'selected="selectd"':'')
                                            ?> value="social_media">Social Media</option>
                                            <option <?php echo (($hear_about =='internet')?'selected="selectd"':'')
                                            ?> value="internet">Internet</option>
                                            <option <?php echo (($hear_about =='other')?'selected="selectd"':'')
                                            ?> value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="ftxt">

                                        <input type="text" tabindex="20" size="20" name="other_hear_about" class="input other_hear_about"
                                        id="other_hear_about" value="<?php echo @$other_hear_about ?>" />
                                    </div>

                                    <div class="fbtn clearfix">
                                        <input type="submit" tabindex="100" value="Submit" class="button" id="wp-submit"
                                        name="km-signup-submit"/>
                                        <input type="hidden" name="km_signup_nonce"
                                        value="<?php echo wp_create_nonce('km-signup-nonce'); ?>"/>
                                        <?php if (!is_user_logged_in()) {
                                            echo '<span>By signing up, I
                                            agree to
                                            Wooffy.ca’s
                                            <a href="'.site_url('/term-and-conditions/').'">Terms of Use
                                            and Privacy
                                            Policy</a>, and
                                            confirm that I am
                                            18 years of age
                                            or older.</span>';
                                        } ?>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function($){
                            $(function () {
                                $(window).scrollTop($("input").offset().top - 100);
                            });
                            var formValidate = jQuery("#signupform").validate({
                                errorElement: 'span',
                                rules: {
                                    first_name: "required",
                                    last_name: "required",
                                    user_mobile: "required",
                                    email: {
                                        required: true,
                                        email: true
                                    },
                                    zip_postal: "required",
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
                                    first_name: "First name is required",
                                    last_name: "Last name is required",
                                    user_mobile: "Mobile number is required",
                                    zip_postal: "Postal code is required",
                                    password: {
                                        required: "Password is required field",
                                    },
                                    confirm_password: {
                                        required: "Confirm password is required field",
                                    }
                                },
                                errorPlacement: function (error, element) {

                                    if (element.data("attr") == "customcheck") {
                                        error.insertBefore(element.parent());
                                    } else {
                                        element.parent().append(error)
                                    }

                                }
                            });


                            jQuery(".other_hear_about").hide();
                            jQuery('.hear_about').change(function(){
                                if($(this).val() == 'other'){
                                    jQuery(".other_hear_about").show();
                                }else{
                                    jQuery(".other_hear_about").hide();
                                }
                            });

                           /* jQuery(document).on('click', '.other_text', function () {
                                if (jQuery('.other_text').is(":checked")) {
                                    jQuery(".additional_information").show();
                                } else {
                                    jQuery(".additional_information").hide();
                                }
                            });*/
                        });
                    </script>
                    <?php
                    // } ?>
                </main>
            </div>
        </div>
        <?php
        get_footer(); ?>