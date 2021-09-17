<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 <?php
        $image = get_field('banner_image');
        $size = 'full'; // (thumbnail, medium, large, full or custom size)
        ?>
        <div class="upcoming-events">
            <div class="head"> <span class="date">
                <?php
                $date = get_field('event_date', false, false);
                $date = new DateTime($date);

                ?>
                <?php echo $date->format('j M'); ?>
            </span>
                <h3>
                    <?php if(!is_single()): ?> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php else : the_title(); endif; ?>
                </h3>
            </div>
            <?php if ( '' !== get_the_post_thumbnail()) : ?>
                <div class="post-thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail( 'twentyseventeen-featured-image' ); ?>
                    </a>
                </div><!-- .post-thumbnail -->
            <?php endif; ?>
            <?php
            if(is_single()){
                the_content();
            }else{
                add_filter('excerpt_more', 'kmsp_excerpt_more');

                the_excerpt();

                remove_filter('excerpt_more', 'kmsp_excerpt_more');
            }

            wp_link_pages( array(
                'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
                'after'       => '</div>',
                'link_before' => '<span class="page-number">',
                'link_after'  => '</span>',
            ) );
            ?>
        </div>


	<?php
	if ( is_single() ) {
		twentyseventeen_entry_footer();
	}
	?>

</article><!-- #post-## -->
