<?php
/**
 * Displays footer widgets if assigned
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */


$active_sidebar = 0;
$footer_sideabars = array('sidebar-2','sidebar-3','sidebar-4','sidebar-5','sidebar-6','sidebar-7');
foreach ($footer_sideabars as $footer_sideabar){
    if(is_active_sidebar($footer_sideabar)){
            $active_sidebar++;
    }
}

//echo $active_sidebar;
$class =  kmsp_footer_widget_classes($active_sidebar);

?>

<?php



if ( is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) ) :
?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'twentyseventeen' ); ?>">

        <?php dynamic_sidebar('footer_sidebar_text'); ?>
        <?php
        foreach ($footer_sideabars as $key => $footer_sideabar){
            if(is_active_sidebar($footer_sideabar)){
                ?>
                <div class="widget-column <?php echo $class; ?> footer-widget-<?php echo $key+1; ?>">
                    <?php dynamic_sidebar( $footer_sideabar ); ?>
                </div>
                <?php
            }
        }
        ?>
	</aside><!-- .widget-area -->

<?php endif; ?>
