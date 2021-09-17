<?php
/* Template show Accodion on Page */
?>

<?php
$accordion = get_field('accordion');

if ($accordion['accordion_page']) {
    ?>
    <div class="accordion-wrap accordion-with-showcase">
        <?php if($accordion['accordion_title']): ?>
        <h3 class="head"> <?php echo $accordion['accordion_title'] ?> </h3>
        <?php endif; ?>
        <?php
        $posts = $accordion['accordion_page'];
        if ($posts):
            ?>
            <div class="km-accordion">
                <?php
                foreach ($posts as $post) : setup_postdata($post); ?>
                    <?php $accordion_details = get_field('accordion_details'); ?>
                    <div class="accordion_in">
                        <div class="acc_head"><i class="icon-accordion"></i> <?php the_title() ?></div>
                        <div class="acc_content">
                            <?php the_excerpt() ?>
                            <?php if ($accordion_details['link']): ?>
                                <a href="<?php echo $accordion_details['link'] ?>"
                                   target="_blank" class="button button-primary"><?php echo ($accordion_details['link_button_text']) ? $accordion_details['link_button_text'] : 'View More'; ?></a>
                            <?php endif; ?>

                        </div>
                        <?php if ($accordion_details['banner']): ?>
                            <span class="bannersrc" data-src="<?php echo $accordion_details['banner']['url'] ?>"></span>
                        <?php endif; ?>

                    </div>
                <?php endforeach;
                wp_reset_postdata();
                ?>
            </div>
            <?php
        endif;
        ?>
        <div class="sidebanner" id="sidebanner">
            <img src="ffd.jpg" alt="Default Image"/>
        </div>
    </div>
    <?php
}
?>


<script>
    jQuery(document).ready(function () {
        jQuery(".km-accordion").accordionjs({
            showIcon: true,
            // The section open on first init.
            activeIndex: 1,

            // Closeable section.
            closeAble: false,

            // Close other sections.
            closeOther: true,

            // the speed of slide animation.
            slideSpeed: 200

        });
    })
</script>