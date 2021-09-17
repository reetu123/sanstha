<?php

function add_testimonial_custom_scripts($hook){
	global $post;
	if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
		if ( 'kmeasy_shortcode' === $post->post_type ) {  
			wp_enqueue_script('testimonial_admin_bootstrap_script','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
			wp_enqueue_script('testimonial_admin_custom_script',plugin_dir_url( __FILE__ ) .'assets/js/admin_custom_script.js');
			wp_enqueue_style('testimonial_admin_toggle_style', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css' );
			wp_enqueue_style('testimonial_admin_bootstrap_style', plugin_dir_url(  __FILE__ ).'assets/css/bootstrap.css');
			wp_enqueue_style('testimonial_admin_custom_style', plugin_dir_url( __FILE__ ) .'assets/css/admin_custom_style.css' );	

			wp_enqueue_script('testimonial_admin_toggle_script','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js');

				// font-awesome		
			wp_enqueue_style('testimonial_font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'); 
			
				// wp-color-picker library
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			
				// multiselect
			wp_enqueue_script('testimonial_admin_select2_script','https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js');
			wp_enqueue_style('testimonial_admin_select2_style', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css' );
		}
	}
}
add_action('admin_enqueue_scripts', 'add_testimonial_custom_scripts');

function add_header_testimonial_assets() { ?>		
	<link rel='stylesheet' id='slick-cdn-css-css'  href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css?ver=4.8.3' type='text/css' media='all' />
	<link rel='stylesheet' id='slicks-cdn-css-css'  href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css?ver=4.8.3' type='text/css' media='all' />
	<link rel='stylesheet' href='<?php echo plugin_dir_url( __FILE__ )."assets/css/custom_style.css"; ?>' type='text/css' />
<?php }	

function add_footer_testimonial_assets(){ ?>
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
	<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js?ver=4.8.3'></script>
	<script type='text/javascript' src='<?php echo plugin_dir_url( __FILE__ )."assets/js/custom_script.js"; ?>'></script>
	<script type='text/javascript' src='<?php echo plugin_dir_url( __FILE__ )."assets/js/myloadmore.js"; ?>'></script>

<?php }
add_action('wp_head', 'add_header_testimonial_assets');
add_action('wp_footer', 'add_footer_testimonial_assets');

function testimonial_pagination($pages = '', $range = 4){
	global $wpdb, $post;
	$showitems = ($range * 2)+1;
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == ''){
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages){
			$pages = 1;
		}
	}
	$paginate = "";
	if(1 != $pages){
		$paginate .= "<div class='pagination'>";
		$paginate .= "<span>Page ".$paged." of ".$pages."</span>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) $paginate .= "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
		if($paged > 1 && $showitems < $pages) $paginate .= "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
		for ($i=1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
				$paginate .= ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
			}
		}
		if ($paged < $pages && $showitems < $pages) $paginate .= "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $paginate .= "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
//            $paginate .= 'prev_text' => __('« prev');
//            $paginate .= "'next_text' => __('next »'),";
		$paginate .= "</div>\n";
	}
	return $paginate;
}

function km_gallery_pagination($pages = '', $range = 4){

	if (empty($range)) {
		$range = 4;
	}

	global $paged;

	if (empty($paged)) {
		$paged = 1;
	}

	if ($pages == '') {
		global $wp_query;
		$numpages = $wp_query->max_num_pages;

		if(!$pages) {
			$pages = 1;
		}
	}

	$pagination_args = array(
		'base'            => get_pagenum_link(1) . '%_%',
		'format'          => 'page/%#%',
		'total'           => $pages,
		'current'         => $paged,
		'show_all'        => False,
		'end_size'        => 1,
		'mid_size'        => $range,
		'prev_next'       => True,
		'prev_text'       => 'Prev',
		'next_text'       => 'Next',
		'type'            => 'list',
		'add_args'        => false,
		'add_fragment'    => ''
	);

	$paginate_links = paginate_links($pagination_args);

	return $paginate_links;
}

?>