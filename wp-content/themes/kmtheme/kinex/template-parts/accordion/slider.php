<?php

do_action('kmsp_accordion_before_slider');

$banner = get_field('slider');
?>
<?php if ($banner['slider']) { ?>

    <?php $post = $banner['slider']; ?>

    <?php if ($post): setup_postdata($post); ?>

        <?php if (have_rows('slide')): ?>

            <div class="owl-carousel owl-theme km-carousel arrows-out">
                <?php while (have_rows('slide')) : the_row(); ?>

                    <?php $image = get_sub_field('image'); ?>

                    <div class="item">
                        <a href="<?php the_sub_field('image_link') ?>" title="<?php the_sub_field('title') ?>">
                            <?php

                            if (!empty($image)): ?>

                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>

                            <?php else :
                                echo "<h4>" . get_the_title() . "</h4>";
                            endif;
                            ?>
                        </a>

                    </div>
                <?php endwhile; ?>
            </div>

            <script>
                jQuery(document).ready(function ($) {
                    jQuery('.owl-carousel').owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: true,
                        dots: false,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 2
                            },
                            1000: {
                                items: 2
                            }
                        }
                    })
                })
            </script>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    <?php endif; ?>
    <?php
}


do_action('kmsp_accordion_after_slider');
?>