jQuery(document).ready(function() {
		/* Select Multiple Categories Code Start */
	jQuery(".limitedNumbSelect2").select2({
        placeholder: "",
    });
		/* Select Multiple Categories Code End */

		/* Check Title Enable Code Start */
    if(jQuery("#title_show_hide").prop('checked') == true) {
        jQuery(".title_detail").show();
    }
	jQuery('#title_show_hide').change(function(){
		var ch = jQuery(this).prop('checked');
		if( ch == true ) {
			jQuery(".title_detail").show();
        }else{
			jQuery(".title_detail").hide();
        }
	});
		/* Check Title Enable Code End */

		/* Check Description Enable Code Start */
	if(jQuery("#description_show_hide").prop('checked') == true) {
        jQuery(".description_detail").show();
		if(jQuery("#readmore_show_hide").prop('checked') == true) {
			jQuery(".readmore_detail").show();
		}
    }
	jQuery('#description_show_hide').change(function(){
		var ch = jQuery(this).prop('checked');
		if( ch == true ) {
			jQuery(".description_detail").show();
			if(jQuery("#readmore_show_hide").prop('checked') == true) {
				jQuery(".readmore_detail").show();
			}
        }else{
			jQuery(".description_detail").hide();
			jQuery(".readmore_detail").hide();
        }
	});
		/* Check Description Enable Code End */	

		/* Check Read More Enable Code Start */	
	jQuery('#readmore_show_hide').change(function(){
		var ch = jQuery(this).prop('checked');
		if( ch == true ) {
			jQuery(".readmore_detail").show();
        }else{
			jQuery(".readmore_detail").hide();
        }
	});
		/* Check Description Enable Code End */	

		/* Check Featuered Image Enable Code start */		
	if(jQuery("#featuredimage_show_hide").prop('checked') == true) {
        jQuery(".featueredimg_detail").show();
    }
	jQuery('#featuredimage_show_hide').change(function(){
		var ch = jQuery(this).prop('checked');
		if( ch == true ) {
			jQuery(".featueredimg_detail").show();
        }else{
			jQuery(".featueredimg_detail").hide();
        }
	});
		/* Check Featuered Image Enable Code End */
	
		/* Check view code Start */
	jQuery('.carousel_setting').hide();
	if(jQuery('#view_carousel').closest('label').hasClass('active')) {
        jQuery('.per_row_item').hide();
		jQuery('.show_pagination').hide();
		jQuery('.per_page_item_outer').show();
		jQuery('.carousel_setting').show();	
    }

    if(jQuery('#view_listing').closest('label').hasClass('active')) {
		jQuery('.per_row_item').hide();
		jQuery('.carousel_setting').hide(); 
		jQuery('.show_pagination').show();
		jQuery('.per_page_item_outer').show();
    }
	
	jQuery('input[name="view"]').change(function(){
		if(jQuery(this).val() == 'view_listing'){
            jQuery('.per_row_item').hide();
			jQuery('.carousel_setting').hide(); 
			jQuery('.show_pagination').show();
			jQuery('.per_page_item_outer').show();
		}else if(jQuery(this).val() == 'view_carousel'){
 			jQuery('.per_row_item').hide();
			jQuery('.show_pagination').hide();
			jQuery('.per_page_item_outer').show();
            jQuery('.carousel_setting').show();	
		}else {
 			jQuery('.carousel_setting').hide();
			jQuery('.per_page_item_outer').show();
            jQuery('.show_pagination').show();
			jQuery('.per_row_item').show();
		}
    });
		/* Check view code End */
	
		/* Range value on Change Code Start*/
	jQuery("#description_count").change(function(){
	   var newval = jQuery(this).val();
	   jQuery('span.desc_count').text(newval);
	});
	jQuery("#per_row_item").change(function(){
	   var newval = jQuery(this).val();
	   jQuery('span.per_row_item_count').text(newval);
	});
	jQuery("#per_page_item").change(function(){
	   var newval = jQuery(this).val();
	   jQuery('span.per_page_item_count').text(newval);
	});
	jQuery("#carousel_speed").change(function(){
	   var newval = jQuery(this).val();
	   jQuery('span.carousel_speed_count').text(newval);
	});
	jQuery("#carousel_speed_1024").change(function(){
	   var newval = jQuery(this).val();
	   jQuery('span.carousel_speed_1024_count').text(newval);
	});
	jQuery("#carousel_speed_767").change(function(){
	   var newval = jQuery(this).val();
	   jQuery('span.carousel_speed_767_count').text(newval);
	});
	jQuery("#carousel_speed_480").change(function(){
	   var newval = jQuery(this).val();
	   jQuery('span.carousel_speed_480_count').text(newval);
	});
		/* Range value on Change Code End */
		
		/* WP color picker code Start */ 
    jQuery('.color_picker').wpColorPicker();
		/* WP color picker code End */ 
});