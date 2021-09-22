<?php
/*
Plugin Name: Slider
Description: This Plugin Is used to displaying slider. add shortcode :- [slider]
Version: 0.0.1
Author: Kinex Media
*/

require('custom-post-type.php');


add_shortcode('slider','add_slider');
function add_slider(){
$args = array(
    'post_status' => 'publish',
    'post_type'   => 'slider',
    'posts_per_page' => '-1',
    'order' => 'ASC'

);
$query = new WP_Query( $args );

$out="";
if($query->have_posts()){
	$out .= '<div class="slideshow1">';
	while($query->have_posts()){
		$query->the_post();
		 $id = get_the_ID();
		 $thumb = get_the_post_thumbnail_url();		
		 $out .=  '<div class="sliders"><img src="'.$thumb.'" width="100%" height="100%" alt="Banner" loading="lazy" />'; 
		$out .= '<div class="slider-text">';
		$out .=  '<div class="sliders-content">'.get_the_content($id).'</div>';
		$out .=  '<div class="slider-title"><h1 class="slider-head">'.get_the_title($id).'</h1></div>';  			  
		$out .=  '<div class="btn-style">';
		if ( is_user_logged_in() ) { 
			$out .= '<a href="'.site_url().'/listing/">Get Started &nbsp;<i class="far fa-arrow-alt-circle-right"></i></a>
		</div>';
		}else{
			$out .= '<a href="'.site_url().'/login/">Get Started &nbsp;<i class="far fa-arrow-alt-circle-right"></i></a>
		</div>';
		}
		$out .= '</div>';
		$out .= '</div>';

	}	
	$out .= '</div>';
  }
  echo $out;
}
