<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>
<div class="wsmenucontainer clearfix">
    <div class="overlapblackbg"></div>
    

    <div class="header">
        <div class="wrapper clearfix">
            <nav id="site-navigation" class="wsmenu clearfix">
                <?php wp_nav_menu(array(

                    'theme_location' => 'top',
                    'menu_id' => 'top-menu',
                    'menu_class' => 'mobile-sub wsmenu-list',
                    'container' => 'span',
                    'walker' => new CSS_Menu_Maker_Walker()
                )); ?>
                <div class="head-right visible-mobile-7">




                    <?php if ((twentyseventeen_is_frontpage() || (is_home() && is_front_page())) && has_custom_header()) : ?>
                    <a href="#content"
                    class="menu-scroll-down"><?php echo twentyseventeen_get_svg(array('icon' => 'arrow-right')); ?>
                    <span class="screen-reader-text"><?php _e('Scroll down to content', 'twentyseventeen'); ?></span></a>
                <?php endif; ?>
                
            </div>
        </nav>
    </div>

</div>
</div>