<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>

<?php do_action('kmsp_accordion_before_content'); ?>
    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(array(
            'before' => '<div class="page-links">' . __('Pages:', 'twentyseventeen'),
            'after' => '</div>',
        ));
        ?>
    </div>
<?php do_action('kmsp_accordion_after_content'); ?>
<?php

?>