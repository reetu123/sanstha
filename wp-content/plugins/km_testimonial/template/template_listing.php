<?php

/* Template for LISTING */
$shortcode_fields = get_post_meta($id);
$container_class = $shortcode_fields['container_custom_class'][0];

$title = $shortcode_fields['title_show_hide'][0];
$title_position = $shortcode_fields['title_position'][0];
$link_on_title = $shortcode_fields['apply_link_on_title'][0];

$description = $shortcode_fields['description_show_hide'][0];
$description_count = $shortcode_fields['description_count'][0];
$readmore_show_hide = $shortcode_fields['readmore_show_hide'][0];
$readmore_bttn_text = $shortcode_fields['readmore_btn_text'][0];
if (empty($readmore_bttn_text)) {
    $readmore_bttn_text = "Read More";
}

$featuredimage = $shortcode_fields['featuredimage_show_hide'][0];
$link_on_featuredimage = $shortcode_fields['apply_link_on_featuered_image'][0];

// $designation_show_hide = $shortcode_fields['designation_show_hide'][0];
// $companyname_show_hide = $shortcode_fields['companyname_show_hide'][0];

$km_country_show_hide = $shortcode_fields['km_country_show_hide'][0];
$km_city_show_hide = $shortcode_fields['km_city_show_hide'][0];


$rating_show_hide = $shortcode_fields['rating_show_hide'][0];

$per_page_item = $shortcode_fields['per_page_item'][0];
$pagination_show_hide = $shortcode_fields['pagination_show_hide'][0];

$item_bg = $shortcode_fields['item_bg'][0];
$title_color = $shortcode_fields['title_color'][0];
$title_bg = $shortcode_fields['title_bg'][0];
$content_color = $shortcode_fields['content_color'][0];
$content_bg = $shortcode_fields['content_bg'][0];
$readmore_text_color = $shortcode_fields['readmore_text_color'][0];
$readmore_bg = $shortcode_fields['readmore_bg'][0];

$title_font_size = $shortcode_fields['title_font_size'][0];
$content_font_size = $shortcode_fields['content_font_size'][0];
$readmore_font_size = $shortcode_fields['readmore_font_size'][0];

$title_padding_top = $shortcode_fields['title_padding_top'][0];
$title_padding_right = $shortcode_fields['title_padding_right'][0];
$title_padding_bottom = $shortcode_fields['title_padding_bottom'][0];
$title_padding_left = $shortcode_fields['title_padding_left'][0];

$content_padding_top = $shortcode_fields['content_padding_top'][0];
$content_padding_right = $shortcode_fields['content_padding_right'][0];
$content_padding_bottom = $shortcode_fields['content_padding_bottom'][0];
$content_padding_left = $shortcode_fields['content_padding_left'][0];

$readmore_padding_top = $shortcode_fields['readmore_padding_top'][0];
$readmore_padding_right = $shortcode_fields['readmore_padding_right'][0];
$readmore_padding_bottom = $shortcode_fields['readmore_padding_bottom'][0];
$readmore_padding_left = $shortcode_fields['readmore_padding_left'][0];
if (empty($title_position)) {
    $title_position = "before_description";
} ?>

<style type="text/css">
#get_testimonial_data_<?php echo $id; ?> .grid_item {
    background-color: <?php echo $item_bg; ?>;
}

#get_testimonial_data_<?php echo $id; ?> h2.item_title a {
    color: <?php echo $title_color; ?>;
    display: block;
    width: 100%;
    font-size: <?php echo $title_font_size.'px'; ?>;
    background-color: <?php echo $title_bg; ?>;
    padding: <?php echo $title_padding_top.'px'; ?> <?php echo $title_padding_right.'px'; ?> <?php echo $title_padding_bottom.'px'; ?> <?php echo $title_padding_left.'px'; ?>
}

#get_testimonial_data_<?php echo $id; ?> .item_description {
    color: <?php echo $content_color; ?>;
    font-size: <?php echo $content_font_size.'px'; ?>;
    background-color: <?php echo $content_bg; ?>;
    padding: <?php echo $content_padding_top.'px'; ?> <?php echo $content_padding_right.'px'; ?> <?php echo $content_padding_bottom.'px'; ?> <?php echo $content_padding_left.'px'; ?>
}

#get_testimonial_data_<?php echo $id; ?> .readmore_button {
    color: <?php echo $readmore_text_color; ?>;
    font-size: <?php echo $readmore_font_size.'px'; ?>;
    background-color: <?php echo $readmore_bg; ?>;
    padding: <?php echo $readmore_padding_top.'px'; ?> <?php echo $readmore_padding_right.'px'; ?> <?php echo $readmore_padding_bottom.'px'; ?> <?php echo $readmore_padding_left.'px'; ?>
}
</style>

<?php $output = "";
if ($query->have_posts()) {
    if (!empty($container_class)) {
        $output .= "<div class='" . $container_class . "'>";
    }
    $output .= "<div class='' id='get_testimonial_data_" . $id . "'>";
    while ($query->have_posts()) {
        $query->the_post();
        global $post;
        $image_id = get_post_thumbnail_id($post->ID);
        $image_url = wp_get_attachment_url($image_id);
        $content = get_the_content();

        $output .= "<div class='col-xs-12 grid_item thumbnail'>";
        if ($featuredimage == 'true') {
            $output .= "<div class='item_image text-center thumbnail'>";
            if ($link_on_featuredimage == 'true') {
                $output .= "<a href='" . get_the_permalink() . "'><img src='" . $image_url . "' alt='' /></a>";
            } else {
                $output .= "<img src='" . $image_url . "' alt='' />";
            }
            $name = get_the_title();
            if ($name) {
                $output .= "<div class='name'>";
                $output .= "<span>" . $name . "</span>";
                $output .= "</div>";
            }
            $output .= "</div>";
        }

        if ($title == 'true' || $description == 'true') {
            $output .= "<div class='caption item_content'>";
            if ($title == 'true') {
                if ($title_position == 'before_description') {
                    $output .= "<h2 class='item_title'>";
                    if ($link_on_title == 'true') {
                        $output .= "<a href='" . get_the_permalink() . "'>" . get_the_title() . "</a>";
                    } else {
                        $output .= get_the_title();
                    }
                    $output .= "</h2>";
                }
            }

            if ($description == 'true') {
                $output .= "<div class='item_description'>";
                if ($description_count == "-1") {
                    $output .= $content;
                    if ($readmore_show_hide == 'true') {
                        $output .= "<div class='readmore_wrapper text-center'>";
                        $output .= "<a href='" . get_the_permalink() . "' class='readmore_button'>" . $readmore_bttn_text . "</a>";
                        $output .= "</div>";
                    }
                } else {
                    $output .= mb_strimwidth($content, 0, $description_count, '...');
                    if ($readmore_show_hide == 'true') {
                        $output .= "<div class='readmore_wrapper text-center'>";
                        $output .= "<a href='" . get_the_permalink() . "' class='readmore_button'>" . $readmore_bttn_text . "</a>";
                        $output .= "</div>";
                    }
                }
                $output .= "</div>";
            }

            if ($title == 'true') {
                if ($title_position == 'after_description') {
                    $output .= "<h2 class='item_title'>";
                    if ($link_on_title == 'true') {
                        $output .= "<a href='" . get_the_permalink() . "'>" . get_the_title() . "</a>";
                    } else {
                        $output .= get_the_title();
                    }
                    $output .= "</h2>";
                }
            }

            // if ($companyname_show_hide == 'true') {
            //     $output .= "<div class='conpanyname'>";
            //     $output .= esc_html(get_post_meta($post->ID, 'km_company_name', true));
            //     $output .= "</div>";
            // }

            // if ($designation_show_hide == 'true') {
            //     $output .= "<div class='designaiton'>";
            //     $output .= esc_html(get_post_meta($post->ID, 'km_author_designation', true));
            //     $output .= "</div>";
            // } /*  Designation end  */


            if ($km_country_show_hide == 'true') {
                $output .= "<div class='conpanyname'>";
                $output .= esc_html(get_post_meta($post->ID, 'km_country', true));
                $output .= "</div>";
            }

            if ($km_city_show_hide == 'true') {
                $output .= "<div class='designaiton'>";
                $output .= esc_html(get_post_meta($post->ID, 'km_city', true));
                $output .= "</div>";
            } /*  Designation end  */



            if ($rating_show_hide == 'true') {
                $output .= "<div class='rating'>";
                $countStar = esc_html(get_post_meta($post->ID, 'km_rating', true));
                for ($x = 1; $x <= $countStar; $x++) {
                    $output .= '<img src=' . plugins_url() . '/km_testimonial/assets/images/star.PNG>';
//                                        $output .=  'star'.$x;
                }
//                                    while ($x<=5) {
//                                        echo 'Start';
//                                        $x++;
//                                    }
//                                    $output .= esc_html(get_post_meta( $post->ID, 'km_rating', true));
                $output .= "</div>";
            }
            $output .= "</div>";
        }
        $output .= "</div>";

    }

    if (  $query->max_num_pages > 1 )
        $output .= '<div class="misha_loadmore">Load More</div>'; // you can use <a> as well



    $output .= do_shortcode( latest_testimonial);



    ?>
    <?php

    if ($pagination_show_hide == "true") {
        ?>
        <?php //$output .= testimonial_pagination($query->max_num_pages); ?>

        <?php $output .= '<div class="pagination_custom">';
        $output .= km_gallery_pagination($query->max_num_pages);
        $output .= '</div>';?>
    <?php }
    $output .= "</div>";
    if (!empty($container_class)) {
        $output .= "</div>";
    }
}