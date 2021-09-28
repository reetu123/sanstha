<?php
/**
 * Template Name: Login Form
 */
$issuccess = false;
@session_start();
if(isset($_SESSION['reset'])){
    $issuccess = true;
    unset($_SESSION['reset']);
}

get_header();
global $wpdb;
global $error;
do_action('login_init');



// do_action( "login_form_{$_GET['action']}" ); ?>

<div class="wrap">
    <div id="primary" class="content-area">
        <main id="main" class="site-main login-main" role="main">
            <?php if ((isset($_GET['action']) && $_GET['action'] == 'rp') && isset($_GET['login']) && !empty($_GET['login'])) {
                ?>
                <div class="form-d form-reset">
                    <div class="heading_profile text-center">
                        <h3>Reset Password</h3>
                    </div>
                    <div class="alar-login-form">
                        <form method="post" name="reset-password">
                            <fieldset>
                                <p>Please enter your new password.</p>
                                <?php km_show_error_messages(); ?>
                                <div class="form-row">
                                    <label for="user_password">New Password:</label>
                                    <?php $user_pass = isset($_POST['user_password']) ? $_POST['user_password'] : ''; ?>
                                    <input type="password" name="user_password" id="user_password"
                                    value="<?php echo $user_pass; ?>"/>
                                </div>
                                <div class="form-row">
                                    <label for="confirm_password">Confirm Password:</label>
                                    <?php $user_pass = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : ''; ?>
                                    <input type="password" name="confirm_password" id="confirm_password"
                                    value="<?php echo $user_pass; ?>"/>
                                </div>
                                <div class="form-row">
                                    <input type="hidden" name="key"
                                    value="<?php echo $_GET['key'] ?>"/>
                                    <input type="hidden" name="log"
                                    value="<?php echo $_GET['login'] ?>"/>
                                    <input type="hidden" name="km_set_password"
                                    value="<?php echo wp_create_nonce('km-set-password'); ?>"/>
                                    <input type="submit" value="Submit" name="km-set-password" class="button"
                                    id="submit"/>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>

                <?php


            } else if (!is_user_logged_in()) {
             

                if(@$_GET['sanstha_id'] == ""){ 
                    
                    echo do_shortcode("[services]");
              }else{

               wp_login_form();
                ?>
                <div class="login-wrap">
                    <div class="login-form-inner">

                        <?php
                        if($issuccess){
                           echo '<div class="pippin_errors">';
                           echo '<span class="success">Your password reset successfully</span>';
                           echo '</div>';
                       }


                       if ($error) {
                        echo '<div class="pippin_errors">';
                        if ($error == 'Activation email resent! Please check your inbox or spam folder.') {
                            echo '<span class="success">' . $error . '</span>';
                        } else {
                            echo '<span class="error">' . $error . '</span>';
                        }

                        echo '</div>';
                    }
                    ?>
                    <div class="heading_profile">
                        <h3>Sign In</h3>
                        <p> If You have an account, please sign in with your email address </p>
                    </div>
                    <div class="alar-login-form main_shadow_wrap clearfix">
                        <?php km_show_error_messages(); ?>
                        <div class="alar-login-heading">
                            <?php //  _e("Login Form",'');?>
                        </div>
                        <form method="post" id="loginform" name="loginform">
                            <div class="ftxt">
                                <label><?php _e('Your email address', ''); ?> </label>
                                <input type="text" tabindex="10" size="20" value="" class="input"
                                id="user_login"
                                required name="log"/>
                            </div>
                            <input type="hidden" name="redirect_to"
                            value="<?php echo (@$_GET['redirect_to']) ? $_GET['redirect_to'] : '' ?>">
                            <div class="ftxt">
                                <label><?php _e('Password', ''); ?> </label>
                                <input type="password" tabindex="20" size="20" value="" class="input"
                                id="user_pass" required name="pwd"/>
                            </div>
                            <div class="ftxt">
                                <div class="col-xs-7 no-padding">
                                            <!-- <label for="rememberme">
                                                <input name="rememberme" id="rememberme" value="forever" type="checkbox">&nbsp;Stay Signed
                                                in
                                            </label> -->
                                        </div>
                                        <div class="col-xs-5 text-right no-padding">
                                            <a href="<?php echo wp_lostpassword_url() ?>">Forgot Password?</a>
                                        </div>
                                    </div>
                                   
                                <div class="fbtn clearfix">
                                    <input type="submit" tabindex="100" value="Submit" class="button" id="wp-submit"
                                    name="km-login-submit"/>
                                    <input type="hidden" name="km_login_nonce"
                                    value="<?php echo wp_create_nonce('km-login-nonce'); ?>"/>
                   </div>
                    <div class="ftxt">
                        <div class="check">
                            <?php /*<input required type="checkbox" name="accept_cond"
                            id="accept_cond" <?php echo is_user_logged_in() ? 'checked' : '' ?> > */ ?>
                            <label for="accept_cond">By signing in, I
                                agree to site’s
                                <a href="<?php echo site_url('/term-and-conditions');
                                ?>"> Terms of Use and Privacy
                            Policy</a>, and confirm that I am
                        18 years of age or older. </label>
                    </div>
                </div>
               </form>
           </div>
       </div>
   </div>
   <div class="sidebar">
    <?php if (is_active_sidebar('become-a-member')): ?>
        <aside id="secondary" class="widget-area" role="complementary"
        aria-label="<?php esc_attr_e('Home Sidebar', 'twentyseventeen'); ?>">
       <p> By creating an account with our sanstha, you will be able to move through list users,get connected with them by using phone number and emails.</p>

<a class="button" href="<?php echo site_url().'/create-an-account/?sanstha_id='.@$_GET['sanstha_id'] ?>">Create an Account</a>

        <?php // htmlspecialchars(dynamic_sidebar('become-a-member')); ?>
    </aside><!-- #secondary -->
<?php endif; ?>

</div>
<?php
} } ?>


</main><!-- #main -->
</div>
</div><!-- .wrap -->
<?php

get_footer(); ?>