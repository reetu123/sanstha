<?php

/**
 * Template Name: Lost Password
**/

get_header();
?>

<div class="lost-password-wrap">
    <div class="text-center">
        <div id="losterror">
        </div>
        <div id="loader"></div>
        <div id="response_message">
            <h3><i class="fa fa-lock fa-4x"></i></h3>

            <h3 class="text-center">Forgot Your Password?</h3>
            <p>You can reset your password here.</p>
            <?php km_show_error_messages(); ?>
            <form class="form" method="post" id="reset_password" name="reset-password">
                <fieldset>
                    <?php wp_nonce_field('km-reset-password') ?>
                    <input type="hidden" name="action" value="km_reset_password">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i
                                class="glyphicon glyphicon-envelope color-blue"></i></span>

                                <input id="emailInput" placeholder="Email address"
                                class="form-control"
                                name="email"
                                oninvalid="setCustomValidity('Please enter a valid email address!')"
                                onchange="try{setCustomValidity('')}catch(e){}"
                                required="" type="email">
                            </div>
                        </div>


                        <div class="fbtn ">
                            <div class="submit">
                                <input name="submit" value="Send My Password" id="send" class="auto"
                                type="submit">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <?php 
    get_footer();
    ?>