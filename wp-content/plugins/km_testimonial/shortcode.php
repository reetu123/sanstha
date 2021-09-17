<?php
	/* Shortcode template used for display testimonials on user end based on shortcode.
		In this file we include templete layout file based on shorcode
		example we have 3 layout Grid,Listing,caousel
	*/
	function define_testimonial_shortcode($atts){
		extract(shortcode_atts(array(
			'id' => '',
		), $atts));

		$cat = array();
		$shortcode_fields = get_post_meta($id);
		$view = $shortcode_fields['view'][0];
		$category = $shortcode_fields['select_category'][0];
		$pagination_display = $shortcode_fields['pagination_show_hide'][0];
		
		if($category != '') {
			$categoryarray = unserialize($category); 
		}
		
		$args = array(
		    'post_type' => 'km_testimonial',
		);

		if($category != ''){
			$args['tax_query'] = array(
									array(
										'taxonomy' => 'testimonial_category',
										'field'    => 'slug',
										'terms'    => $categoryarray,
									),
								); 
		}
		$args['posts_per_page'] = ($shortcode_fields['per_page_item'][0] == 0) ? '12' : $shortcode_fields['per_page_item'][0];
		if($pagination_display == "true"  && $view != 'view_carousel'){
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;	
			$args['paged'] = $paged;
		}
		
		$query = new WP_Query($args);
		if($query->have_posts()){
			if($view == 'view_listing'){
				include 'template/template_listing.php';
				return $output;
			}else if($view == 'view_carousel'){
				include 'template/template_carousel.php';
				return $output;
			}else{
				include 'template/template_default.php';
				return $output;
			}
    	}
	}
	add_shortcode('km_testimonial','define_testimonial_shortcode');




/* start get latest testimonial from posts*/
function get_latest_testimonial()
{

    $args = array(
        'post_type' => 'km_testimonial',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby'	=> 'rand',
        'order' => 'DESC',
    );
    $recent_posts = new WP_Query($args);
    global $wp_query;

    ?>
    <div class="">
        <?php
        if ($recent_posts->have_posts()) {
            while ($recent_posts->have_posts()) {
                $recent_posts->the_post();
                global $post;
                $post_id = get_the_ID();
                $title = get_the_title();
                $content = get_the_content();
                // $recent_posts>the_post();
                $img_url = get_the_post_thumbnail_url();
                // $terms = get_the_terms($recent_posts->ID, 'category');

                $post = '<article class="post-' . $post_id . ' km_testimonial type-km_testimonial status-publish has-post-thumbnail hentry" id="post-' . $post_id . '" ><header class="entry-header">

                        <h2 class="entry-title"><a href="http://localhost/candian-holistics/km_testimonial/' . $title . '/" rel="bookmark">' . $title . '</a></h2>

                    </header><!-- .entry-header -->

                    <img width="106" height="106" src=' . $img_url . ' class="attachment-large size-large wp-post-image" alt="">
                    <div class="entry-content">

                        <p>' . $content . '</p>
                        <p><a href="http://localhost/candian-holistics/km_testimonial/' . str_replace(' ','-', $title) . '/">' . $title . '</a></p>
                    </div><!-- .entry-content -->

                </article>';
                echo $post;

            } ?>

            <?php
            wp_reset_postdata();
        }
        ?>
    </div>

    <?php
}
/* end get latest posts from posts*/
add_shortcode('latest_testimonial', 'get_latest_testimonial');
?>