<?php
	/* Template for CAROUSEL */
	$shortcode_fields = get_post_meta($id);
	$container_class = $shortcode_fields['container_custom_class'][0];
	
	$title = $shortcode_fields['title_show_hide'][0];
	$title_position = $shortcode_fields['title_position'][0]; 
	$link_on_title = $shortcode_fields['apply_link_on_title'][0]; 

	$description = $shortcode_fields['description_show_hide'][0]; 
	$description_count = $shortcode_fields['description_count'][0];
	$readmore_show_hide = $shortcode_fields['readmore_show_hide'][0]; 
	$readmore_bttn_text = $shortcode_fields['readmore_btn_text'][0];
	if(empty($readmore_bttn_text)){
		$readmore_bttn_text = "Read More"; 
	}
	
	$featuredimage = $shortcode_fields['featuredimage_show_hide'][0]; 
	$link_on_featuredimage = $shortcode_fields['apply_link_on_featuered_image'][0]; 
	
	$designation_show_hide = $shortcode_fields['designation_show_hide'][0]; 
	$companyname_show_hide = $shortcode_fields['companyname_show_hide'][0];
	$rating_show_hide = $shortcode_fields['rating_show_hide'][0];
	$per_page_item = $shortcode_fields['per_page_item'][0];	
	
	$carousel_speed = $shortcode_fields['carousel_speed'][0];
	$carousel_speed_1024 = $shortcode_fields['carousel_speed_1024'][0];
	$carousel_speed_767 = $shortcode_fields['carousel_speed_767'][0];
	$carousel_speed_480 = $shortcode_fields['carousel_speed_480'][0];
	
	$slide_item = $shortcode_fields['slide_item'][0];
	$slide_item_1024 = $shortcode_fields['slide_item_1024'][0];
	$slide_item_767 = $shortcode_fields['slide_item_767'][0];
	$slide_item_480 = $shortcode_fields['slide_item_480'][0];
	
	$scroll_item = $shortcode_fields['scroll_item'][0];
	$scroll_item_1024 = $shortcode_fields['scroll_item_1024'][0];
	$scroll_item_767 = $shortcode_fields['scroll_item_767'][0];
	$scroll_item_480 = $shortcode_fields['scroll_item_480'][0];
	
	$arrows_show_hide = $shortcode_fields['arrows_show_hide'][0];
	$arrows_show_hide_1024 = $shortcode_fields['arrows_show_hide_1024'][0];
	$arrows_show_hide_767 = $shortcode_fields['arrows_show_hide_767'][0];
	$arrows_show_hide_480 = $shortcode_fields['arrows_show_hide_480'][0];
	
	$dots_show_hide = $shortcode_fields['dots_show_hide'][0];
	$dots_show_hide_1024 = $shortcode_fields['dots_show_hide_1024'][0];
	$dots_show_hide_767 = $shortcode_fields['dots_show_hide_767'][0];
	$dots_show_hide_480 = $shortcode_fields['dots_show_hide_480'][0];
	
	$autoplay = $shortcode_fields['autoplay'][0]; 
	$autoplay_1024 = $shortcode_fields['autoplay_1024'][0]; 
	$autoplay_767 = $shortcode_fields['autoplay_767'][0]; 
	$autoplay_480 = $shortcode_fields['autoplay_480'][0]; 
	
	$centermode = $shortcode_fields['centermode'][0]; 
	$centermode_1024 = $shortcode_fields['centermode_1024'][0]; 
	$centermode_767 = $shortcode_fields['centermode_767'][0]; 
	$centermode_480 = $shortcode_fields['centermode_480'][0]; 
	
	$infinite = $shortcode_fields['infinite'][0]; 
	$infinite_1024 = $shortcode_fields['infinite_1024'][0]; 
	$infinite_767 = $shortcode_fields['infinite_767'][0]; 
	$infinite_480 = $shortcode_fields['infinite_480'][0]; 
	
	$vertical = $shortcode_fields['vertical'][0]; 
	$vertical_1024 = $shortcode_fields['vertical_1024'][0]; 
	$vertical_767 = $shortcode_fields['vertical_767'][0]; 
	$vertical_480 = $shortcode_fields['vertical_480'][0]; 
	
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
	if(empty($title_position)){
		$title_position = "before_description";
	} ?>

	<style type="text/css">	
		#customtestimonial_<?php echo $id; ?> .grid_item {
			background-color: <?php echo $item_bg; ?>;
		}

		#customtestimonial_<?php echo $id; ?> h2.item_title a {
			color: <?php echo $title_color; ?>;
			display: block;
			width: 100%;
			font-size:<?php echo $title_font_size.'px'; ?>;
			background-color: <?php echo $title_bg; ?>;
			padding: <?php echo $title_padding_top.'px'; ?> <?php echo $title_padding_right.'px'; ?> <?php echo $title_padding_bottom.'px'; ?> <?php echo $title_padding_left.'px'; ?>
		}

		#customtestimonial_<?php echo $id; ?> .item_description {
			color: <?php echo $content_color; ?>;
			font-size:<?php echo $content_font_size.'px'; ?>;
			background-color: <?php echo $content_bg; ?>;
			padding: <?php echo $content_padding_top.'px'; ?> <?php echo $content_padding_right.'px'; ?> <?php echo $content_padding_bottom.'px'; ?> <?php echo $content_padding_left.'px'; ?>
		}

		#customtestimonial_<?php echo $id; ?> .readmore_button {
			color: <?php echo $readmore_text_color; ?>;
			font-size:<?php echo $readmore_font_size.'px'; ?>;
			background-color: <?php echo $readmore_bg; ?>;
			padding: <?php echo $readmore_padding_top.'px'; ?> <?php echo $readmore_padding_right.'px'; ?> <?php echo $readmore_padding_bottom.'px'; ?> <?php echo $readmore_padding_left.'px'; ?>
		}
	</style>
	
	<script>
		jQuery(document).ready(function() {
			jQuery('#customtestimonial_<?php echo $id; ?>').slick({
				vertical: <?php echo $vertical; ?>,
				speed: <?php echo $carousel_speed; ?>,
				infinite: <?php echo $infinite; ?>,
				autoplay: <?php echo $autoplay; ?>,
				slidesToShow: <?php echo $slide_item; ?>,
				slidesToScroll: <?php echo $scroll_item; ?>,
				centerMode: <?php echo $centermode; ?>,
				dots: <?php echo $dots_show_hide; ?>,
				arrows: <?php echo $arrows_show_hide; ?>,
				touchMove: true,
				responsive: [
				{
					breakpoint: 1024,
					settings: {
						vertical: <?php echo $vertical_1024; ?>,
						speed: <?php echo $carousel_speed_1024; ?>,
						infinite: <?php echo $infinite_1024; ?>,
						autoplay: <?php echo $autoplay_1024; ?>,
						slidesToShow: <?php echo $slide_item_1024; ?>,
						slidesToScroll: <?php echo $scroll_item_1024; ?>,
						centerMode: <?php echo $centermode_1024; ?>,
						dots: <?php echo $dots_show_hide_1024; ?>,
						arrows: <?php echo $arrows_show_hide_1024; ?>,
					}
				},
				{
					breakpoint: 767,
					settings: {
						vertical: <?php echo $vertical_767; ?>,
						speed: <?php echo $carousel_speed_767; ?>,
						infinite: <?php echo $infinite_767; ?>,
						autoplay: <?php echo $autoplay_767; ?>,
						slidesToShow: <?php echo $slide_item_767; ?>,
						slidesToScroll: <?php echo $scroll_item_767; ?>,
						centerMode: <?php echo $centermode_767; ?>,
						dots: <?php echo $dots_show_hide_767; ?>,
						arrows: <?php echo $arrows_show_hide_767; ?>,
					}
				},
				{
					breakpoint: 480,
					settings: {
						vertical: <?php echo $vertical_480; ?>,
						speed: <?php echo $carousel_speed_480; ?>,
						infinite: <?php echo $infinite_480; ?>,
						autoplay: <?php echo $autoplay_480; ?>,
						slidesToShow: <?php echo $slide_item_480; ?>,
						slidesToScroll: <?php echo $scroll_item_480; ?>,
						centerMode: <?php echo $centermode_480; ?>,
						dots: <?php echo $dots_show_hide_480; ?>,
						arrows: <?php echo $arrows_show_hide_480; ?>,
					}
				}
				]
			});
		});
	</script>
		
	<?php $output = "";
	if($query->have_posts()){
		if(!empty($container_class)){
			$output .= "<div class='".$container_class."'>";
		}
		$output .= "<div class='row customtestimonial' id='customtestimonial_".$id."'>";
			while($query->have_posts()){
				$query->the_post();
				global $post;
				$image_id = get_post_thumbnail_id($post->ID);
				$image_url = wp_get_attachment_url($image_id);
				$content = get_the_content();
				$output .= "<div class='col-md-3'>";
					$output .= "<div class='grid_item thumbnail'>";
						if($featuredimage == 'true'){
							$output .= "<div class='item_image text-center thumbnail'>";
								if($link_on_featuredimage == 'true'){
									$output .= "<a href='".get_the_permalink()."'><img src='".$image_url."' alt='' /></a>";
								}else{
									$output .= "<img src='".$image_url."' alt='' />";
								}
							$output .= "</div>";
						}

						if($title == 'true' || $description == 'true'){
							$output .= "<div class='caption item_content'>";
								if($title == 'true'){
									if($title_position == 'before_description'){
										$output .= "<h2 class='item_title'>";
											if($link_on_title == 'true'){
												$output .= "<a href='".get_the_permalink()."'>".get_the_title()."</a>";
											}else{
												$output .= get_the_title();
											}
										$output .= "</h2>";
									}
								}
	
								if($description == 'true'){
									$output .= "<div class='item_description'>";
										if($description_count == "-1"){
											$output .= $content;
											if($readmore_show_hide == 'true'){
												$output .= "<div class='readmore_wrapper text-center'>";
													$output .= "<a href='".get_the_permalink()."' class='readmore_button'>".$readmore_bttn_text."</a>";
												$output .= "</div>";
											}
										}else{
											$output .= mb_strimwidth($content, 0, $description_count, '...');
											if($readmore_show_hide == 'true'){
												$output .= "<div class='readmore_wrapper text-center'>";
													$output .= "<a href='".get_the_permalink()."' class='readmore_button'>".$readmore_bttn_text."</a>";
												$output .= "</div>";
											}
										}
									$output .= "</div>";
								} 

								if($title == 'true'){ 
									if($title_position == 'after_description'){
										$output .= "<h2 class='item_title'>";
											if($link_on_title == 'true'){
												$output .= "<a href='".get_the_permalink()."'>".get_the_title()."</a>";
											}else{
												$output .= get_the_title();
											}
										$output .= "</h2>";
									}
								}

								if($companyname_show_hide == 'true'){
									$output .= "<div class='conpanyname'>";
										$output .= esc_html(get_post_meta( $post->ID, 'km_company_name', true));
									$output .= "</div>";
								} 
							
								if($designation_show_hide == 'true'){
									$output .= "<div class='designaiton'>";
										$output .= esc_html(get_post_meta( $post->ID, 'km_author_designation', true));
									$output .= "</div>";
								} /*  Designation end  */

								if($rating_show_hide == 'true') {
									$output .= "<div class='rating'>";
										$output .= esc_html(get_post_meta( $post->ID, 'km_rating', true));
									$output .= "</div>";
								}
							$output .= "</div>";
						}
					$output .= "</div>";
				$output .= "</div>";
			}
		$output .= "</div>";
		if(!empty($container_class)){
			$output .= "</div>";
		}
	}
