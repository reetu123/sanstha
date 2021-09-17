<?php
/**
 * Created by PhpStorm.
 * User: Sarab
 * Date: 09-Feb-18
 * Time: 2:33 PM
 */

if (!is_active_sidebar('sidebar-shop')) return; ?>
<aside id="secondary" class="widget-area" role="complementary"
       aria-label="<?php esc_attr_e('Shop Sidebar', 'twentyseventeen'); ?>">
    <?php dynamic_sidebar('sidebar-shop'); ?>


