<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Staples
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="shortcut icon" href="<?php echo bloginfo('template_url') ?>/assets/images/favicon.ico"
    type="image/x-icon">
    <link rel="icon" href="<?php echo bloginfo('template_url') ?>/assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo bloginfo('template_url') ?>/assets/css/style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
    <script type="text/javascript" src="<?php echo bloginfo('template_url') ?>/assets/js/main.js"></script>
    <script>var admin_ajax = "<?php echo admin_url('admin-ajax.php') ?>" </script>
    <script>var Markerdata = [];</script>
    <style>
        .gform_confirmation_message_2{
          color: green; 
          font-weight: bold;
      }
  </style>

</head>

<body <?php body_class(); ?>>

    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'Staples'); ?></a>

        <header id="masthead" class="site-header" role="banner">

            <?php get_template_part('template-parts/header/header', 'image'); ?>

            <?php if (has_nav_menu('top')) : ?>
                <div class="navigation-top">
                    <div class="wrap">
                        <?php get_template_part('template-parts/navigation/navigation', 'top'); ?>
                    </div><!-- .wrap -->
                </div><!-- .navigation-top -->
            <?php endif; ?>
        </header><!-- #masthead -->

        <?php

    /*
     * If a regular post or page, and not the front page, show the featured image.
     * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
     */
    if ((is_single('post') || (is_page() && !is_singular('recipe') && !twentyseventeen_is_frontpage())) && has_post_thumbnail(get_queried_object_id())) :
        /* echo '<div class="single-featured-image-header">';
     echo get_the_post_thumbnail(get_queried_object_id(), 'twentyseventeen-featured-image');
     echo '</div><!-- .single-featured-image-header -->';*/
 endif;
 ?>

 <!-- custom_breadcrumbs code start  -->
 <?php if (!is_front_page() && !is_search()) {
    ?>

    <?php
    if (is_single()) {

    } else if (is_home()) { ?>
        <div class="single-featured-image-header">
            <div class="custom_breadcrumbs">
                <h1><?php echo "Blog" ?></h1>
                <ul id="breadcrumbs" class="breadcrumbs">
                    <li class="item-home">
                        <a class="bread-link bread-home" href="<?php echo site_url(); ?>" title="Homepage">Home</a>
                    </li>
                    <li class="separator separator-home"> /</li>
                    <li class="item-current item-10"><p class="bread-current bread-10"> Blog</p></li>
                </ul>
            </div>
        </div>
    <?php } else {

        ?>

        <?php

        $image = get_the_post_thumbnail($post->ID, 'full', false);
            // echo $image;
            // $image  =  false;
        if ($image) {
            $getImage = $image;
        } else {
            $getImage = "";
        }

        if ($getImage):
            ?>
            <div class="single-featured-image-header">
                <?php echo $getImage; ?>
                <div class="wrap">
                    <div class="custom_breadcrumbs">
                        <?php if ((isset($_GET['action']) && $_GET['action'] == 'rp') && isset($_GET['login']) && !empty($_GET['login'])) { ?>
                            <h1>Reset Password</h1>
                        <?php } else { ?>
                            <h1><?php echo the_title(); ?></h1>
                        <?php } ?>
                        <p><?php $desc = get_post_meta(get_the_ID(), 'meta_box_featured_description', true);
                        echo substr(nl2br(esc_html($desc)), 0, 150); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php } ?>


<?php } ?>
<!-- custom_breadcrumbs code end -->


<div class="site-content-contain">
    <div id="content" class="site-content">



