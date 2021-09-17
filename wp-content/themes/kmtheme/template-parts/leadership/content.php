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

    $image =  get_field('image');

    ?>


    <?php if ( '' !== $image && ! is_single() ) : ?>
        <div class="post-thumbnail">

                <img src="<?php echo  $image['url']?>" alt="<?php echo $image['title'] ?>">

        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="entry-content">
        <header class="entry-header">
            <?php $image =  get_field('image'); ?>

            <?php if ( '' !== $image &&  is_single() ) : ?>
                <div class="post-thumbnail">

                    <img src="<?php echo  $image['url']?>" alt="<?php echo $image['title'] ?>">

                </div><!-- .post-thumbnail -->
            <?php endif; ?>

            <?php
            $designation =  get_field('designation');
            if($designation){
                $designation = " - ".$designation;
            }
            $department =  get_field('department');
            if($department){
                $department = ", ".$department;
            }
            if ( is_single() ) {
                the_title( '<h1 class="entry-title">', $designation.$department.'</h1>' );
            } elseif ( is_front_page() && is_home() ) {
                the_title( '<h3 class="entry-title">', $designation.$department.'</h3>' );
            } else {
                the_title( '<h2 class="entry-title">', $designation.$department.'</h2>' );
            }
            ?>
        </header><!-- .entry-header -->
        <?php


        /* translators: %s: Name of current post */


        if(!is_single()){
            $description = '';
            $short_description = get_field('short_description');




            if(!$short_description){
                $description  = get_field('description');
                $description = str_replace(']]>', ']]&gt;', $description);
                $excerpt_length = apply_filters( 'excerpt_length', 55 );
                $excerpt_more = apply_filters( 'kmsp_exccerpt_more', ' ' . '[&hellip;]' );
                $before = '&nbsp;<span class="readmore" id="content-'.get_the_ID().'" style="display:none">';
                $after = '</span>';
                echo $description = kmsp_trim_words( $description, $before,$after,$excerpt_length, $excerpt_more );
            }else{
                $description  = get_field('description');
                 $before = '&nbsp;<span class="readmore" id="content-'.get_the_ID().'" style="display:none">';
                $after = '</span>';
                $excerpt_more = apply_filters( 'kmsp_exccerpt_more', ' ' . '[&hellip;]' );
                echo $short_description.$excerpt_more.$before.$description.$after;
            }

        }else{
            echo $description  = get_field('description');
        }


        wp_link_pages( array(
            'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
            'after'       => '</div>',
            'link_before' => '<span class="page-number">',
            'link_after'  => '</span>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <?php
    if ( is_single() ) {
        twentyseventeen_entry_footer();
    }
    ?>

</article><!-- #post-## -->
