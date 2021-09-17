<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

if (!is_active_sidebar('sidebar-1') || (is_front_page() && !is_active_sidebar('sidebar-home'))) {
    return;
}
?>

<?php if (is_front_page()): ?>
    <aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Home Sidebar', 'twentyseventeen' ); ?>">
        <?php dynamic_sidebar( 'sidebar-home' ); ?>
    </aside><!-- #secondary -->
<?php else : ?>
    <aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'twentyseventeen' ); ?>">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside><!-- #secondary -->
<?php endif; ?>

