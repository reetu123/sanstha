<?php

do_action('kmsp_accordion_before_banner');

    $banner = get_field('banner');

    if($banner['banner_image']){
        echo "<img src='".$banner['banner_image']['url']."' alt='".$banner['banner_image']['title']."'>";
    }

do_action('kmsp_accordion_after_banner');
?>