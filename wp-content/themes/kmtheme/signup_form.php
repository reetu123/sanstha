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
                                    <?php _e('First Name', ''); ?><span class="asterisk">*</span> </label>
                                    <input type="text" class="form-control" placeholder="Name" name="created_by" id="created_by" required>
                                    <!--<input type="text" tabindex="10" size="20" class="input" id="first_name"
                                    name="first_name" value="<?php echo @$user_first_name ?>"/> -->
                                </div>
                                <div class="ftxt">
                                    <label>Relation</label>
                                        <select name="relation" id="relation">
                                        <option value="self">Self</option>
                                        <option value="parents">Parents</option>
                                        <option value="siblings">Siblings</option>
                                        <option value="relatives">Relatives</option>
                                        <option value="friend">Friend</option>
                                    </select>
                                </div>
                                <div class="ftxt">
                                    <label>Are You</label>
                                    <input type="radio" id="nri" name="nation" value="NRI"><span>NRI</span>
                                    <input type="radio" id="indian" name="nation" value="Indian"><span>Indian</span>
                                </div>
                                <h4>Personal Information</h4>
                                <div class="ftxt">
                                    <label>Gender</label>
                                        <input type="radio" id="male" name="gender" value="Male" required><span>Male</span>
                                        <input type="radio" id="female" name="gender" value="Female"><span>Female</span>
                                </div>
                                <div class="ftxt half">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_Name">
                                </div>
                                <div class="ftxt half">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_Name" required>
                                </div>
                                <div class="ftxt">
                                    <label>Age</label>
                                    <input type="Number" class="form-control" placeholder="Age" name="age" id="age" required>
                                </div>
                                <div class="ftxt">
                                    <label>Complextion</label>
                                    <input type="text" class="form-control" placeholder="Complextion" name="complextion" id="complextion">
                                </div>
                                <div class="ftxt">
                                    <label>Height(feets & inches)</label>
                                    <input type="Number" class="form-control" placeholder="Feet" name="h_feet" id="feet">
                                    <input type="Number" class="form-control" placeholder="Inch" name="h_inches" id="inches">
                                </div>
                                <div class="ftxt">
                                    <label>Weight</label>
                                    <input type="Number" class="form-control" placeholder="Weight" name="weight" id="weight">kg
                                </div>
                                <h4>Religion & Social Background</h2>
                                <div class="ftxt">
                                    <label>Weight</label>
                                    <input type="Number" class="form-control" placeholder="Weight" name="weight" id="weight">kg
                                </div>
                                <div class="ftxt">
                                    <label>Religion</label>
                                    <input type="text" class="form-control" placeholder="Religion" name="religion" id="religion" required>
                                </div>
                                <div class="ftxt">
                                    <label>Caste </label>
                                    <input type="text" class="form-control" placeholder="Caste " name="caste" id="caste" required>
                                </div>
                                <div class="ftxt">
                                    <label>Sub caste</label>
                                    <input type="text" class="form-control" placeholder="Sub caste" name="sub_caste" id="sub_caste">
                                </div>
                                <div class="ftxt">
                                    <label>Gotra </label>
                                    <input type="text" class="form-control" placeholder="Gotra" name="gotra" id="gotra">
                                </div>
                                <div class="ftxt">
                                    <label>Marital Status</label>
                                        <select name="marital" id="marital">
                                        <option value="unmarried">Unmarried</option>
                                        <option value="divorcee">Divorcee</option>
                                        <option value="widow">Widow</option>
                                    </select>
                                </div>
                                <div class="ftxt">
                                    <label>Child (If any)</label>
                                    <input type="Number" class="form-control" placeholder="Child(If any)" name="child" id="child">
                                </div>
                                <div class="ftxt">
                                    <label>Personal Values</label>
                                    <textarea name="personal_values" required></textarea>
                                </div>
                                <h5>BASICS & LIFESTYLE </h5>
                                <div class="ftxt">
                                    <label>Mother Tongue</label>
                                    <select name="mothertongue" id="mothertongue">
                                        <option value="english">English</option>
                                        <option value="hindi">Hindi</option>
                                        <option value="punjabi">Punjabi</option>
                                        </select>
                                </div>
                                <div class="ftxt">
                                    <label>Blood Group</label>
                                    <select name="bloodgroup" id="bloodgroup">
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    </select>
                                </div>
                                <div class="ftxt">
                                    <label>Smoke</label>
                                    <input type="radio" id="s_yes" name="smoke" value="s_yes" required><span>Yes</span>
                                    <input type="radio" id="s_no" name="smoke" value="s_no"><span>No</span>
                                </div>
                                <div class="ftxt">
                                    <label>Drink</label>
                                    <input type="radio" id="d_yes" name="drink" value="d_yes" required><span>Yes</span>
                                    <input type="radio" id="d_no" name="drink" value="d_no"><span>No</span>
                                </div>
                                <div class="ftxt">
                                    <label>Diet</label>
                                    <input type="radio" id="dt_yes" name="diet" value="dt_yes" required><span>Yes</span>
                                    <input type="radio" id="dt_no" name="diet" value="dt_no"><span>No</span>
                                </div>
                                <div class="ftxt">
                                    <label>Body Type</label>
                                    <select name="bodytype" id="bodytype">
                                    <option value="slim+">Slim</option>
                                    <option value="fat">Fat</option>
                                    </select>
                                </div>
                                <div class="ftxt">
                                    <label>Physical Status</label>
                                    <input type="text" class="form-control" placeholder="Physical Status" name="physicalstatus" id="physicalstatus">
                                </div>
                                <h5>EDUCATION & PROFESSION</h5>
                                <div class="ftxt">
                                    <label>Educational Qualification</label>
                                    <input type="text" class="form-control" placeholder="Educational Qualification" name="qualification" id="qualification required">
                                </div>
                                <div class="ftxt">
                                    <label>Occupation/Profession Details</label>
                                    <input type="text" class="form-control" placeholder="Occupation/Profession Details" name="occupation" id="occupation" required>
                                </div>
                                <div class="ftxt">
                                    <label>Income </label>
                                    <input type="text" class="form-control" placeholder="Income" name="income" id="income" required>
                                </div>
                                <h4>FAMILY DETAILS</h4>
                                <div class="ftxt">
                                    <label>Father’s Name</label>
                                    <input type="text" class="form-control" placeholder="Father’s Name" name="fathername" id="fathername">
                                </div>
                                <div class="ftxt">
                                    <label>Father’s Occupation</label>
                                    <input type="text" class="form-control" placeholder="Father’s Occupation" name="fatheroccupation" id="fatheroccupation">
                                </div>
                                <div class="ftxt">
                                    <label>Mother’s Name</label>
                                    <input type="text" class="form-control" placeholder="Mother’s Name" name="mothername" id="mothername">
                                </div>
                                <div class="ftxt">
                                    <label>Mother’s Occupation</label>
                                    <input type="text" class="form-control" placeholder="Mother’s Occupation" name="motheroccupation" id="motheroccupation">
                                </div>
                                <div class="ftxt">
                                    <label>Siblings </label>
                                    <input type="number" class="form-control" placeholder="Brothers" name="brothers" id="brothers" >
                                    <input type="number" class="form-control" placeholder="Sisters" name="sisters" id="sisters" >
                                </div>
                                <h5>ASTRO  DETAILS</h5>
                                <div class="ftxt">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" placeholder="Date of Birth" name="dob" id="dob" required>
                                </div>
                                <div class="ftxt">
                                    <label>Time of Birth</label>
                                    <input type="time" class="form-control" placeholder="Time of Birth" name="tob" id="tob" >
                                </div>
                                <div class="ftxt">
                                    <label>Place of Birth</label>
                                    <input type="Text" class="form-control" placeholder="Place of Birth" name="pob" id="pob" required>
                                    <input type="radio" id="Manglik" name="manglik" value="Manglik"><span>Manglik</span>
                                    <input type="radio" id="Non-Manglik" name="manglik" value="Non-Manglik"><span>Non-Manglik</span>
                                </div>
                                <h4>Contact Details</h4>
                                <div class="ftxt">
                                    <label>Permanent Address</label>
                                    <textarea id="permanent-address" name="permanent_address" required></textarea>
                                </div>
                                <div class="ftxt">
                                    <label>Currently Living In</label>
                                    <input type="Text" class="form-control" placeholder="Currently Living In" name="cli" id="cli" required>
                                </div>
                                <div class="ftxt">
                                    <label>Email ID</label>
                                    <input type="email" class="form-control" placeholder="Email ID" name="email" id="email">            
                                </div>
                                <div class="ftxt">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                                </div>
                                <div class="ftxt">
                                    <label>*phone /Mobile Number</label>
                                    <input type="Text" class="form-control" placeholder="*phone /Mobile Number" name="phone" id="phone" required>
                                </div>

                                <h4>Additional Comments</h4>
                                <div class="ftxt">
                                    <label>Additional Comments</label>  
                                    <textarea name="additional_comments"></textarea>
                                </div>
                                <h4>Partner preferences </h4>
                                <div class="ftxt">
                                    <label>Age</label>
                                    <input type="Number" class="form-control" placeholder="Age" name="p_age" id="p_age">
                                </div>
                                <div class="ftxt">
                                    <label>Height</label>
                                    <input type="Number" class="form-control" placeholder="Height" name="p_height" id="p_height">
                                </div>
                                <div class="ftxt">
                                    <label>Drink</label>
                                        <input type="radio" id="dp_yes" name="p_drink" value="dp_yes"><span>Yes</span>
                                        <input type="radio" id="dp_no" name="p_drink" value="dp_no"><span>No</span>
                                </div>
                                <div class="ftxt">
                                    <label>Mother Tongue</label>
                                    <select name="p_mothertongue" id="p_mothertongue">
                                        <option value="">Select Language</option>
                                    <option value="english">English</option>
                                    <option value="hindi">Hindi</option>
                                    <option value="punjabi">Punjabi</option>
                                    </select>
                                    <input type="radio" id="p_Manglik" name="p_manglik" value="Manglik"><span>Manglik</span>
                                    <input type="radio" id="p_Non-Manglik" name="p_manglik" value="Non-Manglik"><span>Non-Manglik</span>
                                </div>
                                <div class="ftxt">
                                <label>Occupation/Profession Details</label>
        <input type="text" class="form-control" placeholder="Occupation/Profession Details" name="p_occupation" id="p_occupation">
                                </div>
                                <div class="ftxt">
                                <label>Currently Living In</label>
        <input type="Text" class="form-control" placeholder="Currently Living In" name="p_cli" id="p_cli">
                                </div>
                                <div class="ftxt">
                                <label>Marital Status</label>
        <select name="p_marital" id="p_marital">
            <option value="">Marital Status</option>
        <option value="unmarried">Unmarried</option>
        <option value="divorcee">Divorcee</option>
        <option value="widow">Widow</option>
        </select>
                                </div>
                                <div class="ftxt">
                                <label>Religion</label>
        <input type="text" class="form-control" placeholder="Religion" name="p_religion" id="p_religion">
      </li>
                                </div>
                                <div class="ftxt">
                                <label>Caste </label>
        <input type="text" class="form-control" placeholder="Caste" name="p_caste" id="p_caste">
                                </div>
                                <div class="ftxt">
                                <label>Sub caste</label>
        <input type="text" class="form-control" placeholder="Sub caste" name="p_sub_caste" id="p_sub_caste">
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