<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>">
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->

    <!-- CSS Reset -->
    <style type="text/css">
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Forces Outlook.com to display emails full width. */
        .ExternalClass {
            width: 100%;
        }

        /* What is does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        /* & manages img max widths to ensure content body images don't exceed template width. */
        img {
            -ms-interpolation-mode: bicubic;
            height: auto;
            max-width: 100%;
        }

        /* What it does: Overrides styles added when Yahoo's auto-senses a link. */
        .yshortcuts a {
            border-bottom: none !important;
        }

        /* What it does: A work-around for iOS meddling in triggered links. */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: underline !important;
        }
    </style>

</head>
<body class="email_bg" width="100%" height="100%" style="margin: 0;">
<table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" style="border-collapse:collapse;" class="email_bg">
    <tr>
        <td valign="top">
            <center style="width: 100%;">


                <div style="max-width: 600px;">
                    <!--[if (gte mso 9)|(IE)]>
                    <table cellspacing="0" cellpadding="0" border="0" width="600" align="center">
                        <tr>
                            <td>
                    <![endif]-->

                    <!-- Email Header : BEGIN -->
                    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:
                    600px; border-top: 7px solid #D7D7D7;" class="header_bg">
                        <tr>
                            <td style="text-align: left; padding: 15px 0 15px 10px; font-family: sans-serif;
                            mso-height-rule: exactly; font-weight: bold; color: #D7D7D7; font-size: 12px"
                                class="header_text_color header_text_size">
                                <?php the_custom_logo(); ?>
                            </td>
                        </tr>
                    </table>
                    <!-- Email Header : END -->

                    <!-- Email Body : BEGIN -->
                    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width:
                    600px; border-radius: 5px;" class="body_bg">

                        <!-- 1 Column Text : BEGIN -->
                        <tr>
                            <td>
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td style="padding: 20px; font-family: sans-serif; mso-height-rule: exactly;
                                                line-height: <?php echo esc_attr(floor(12 * 1.618) . 'px') ?>; color:
                                                #D7D7D7; font-size: 12px"
                                            class="body_text_color body_text_size">
                                            <span style="font-weight: bold; font-size: <?php echo esc_attr(floor(12 *
                                                    1.35) . 'px'); ?>" class="welcome">Hi <?php echo $user_login ?> </span>
                                            <hr color="#D7D7D7">
                                            <br>
                                            <p>
                                                Someone has requested a password reset for the following account:
                                            </p>
                                            <p>
                                                <?php echo network_home_url('/') ?>
                                            </p>
                                            <p>
                                                If this was a mistake, just ignore this email and nothing will happen.
                                                To reset your password, visit the following address:
                                            </p>
                                            <p>
                                                <a href="<?php echo network_site_url("login?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ?>">Click Here</a>
                                            </p>


                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- 1 Column Text : BEGIN -->

                    </table>
                    <!-- Email Body : END -->

                    <!-- Email Footer : BEGIN -->
                    <br>
                    <table cellspacing="0" cellpadding="0" border="0" align="left" width="100%" style="max-width: 600px; border-radius: 5px;" class="footer_bg">
                        <tr>
                            <td style="padding: 20px; width: 100%; font-size:12px; font-family: sans-serif;mso-height-rule: exactly; line-height: <?php echo esc_attr(floor(12 * 1.618) . 'px') ?>; text-align: left; color: #d7d7d7;"
                                class="footer_text_color footer_text_size">
                                <!--                                <span class="footer_text">Testdaa</span>-->
                            </td>
                        </tr>
                    </table>
                    <!-- Email Footer : END -->

                    <!--[if (gte mso 9)|(IE)]>
                    </td>
                    </tr>
                    </table>
                    <![endif]-->
                </div>
            </center>
        </td>
    </tr>
</table>
<?php if (function_exists('is_customize_preview') && is_customize_preview()) wp_footer(); ?>
</body>
</html>
