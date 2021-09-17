
jQuery(document).ready(function () {
    jQuery('.read-full-post').click(function (e) {
        e.preventDefault();
        var id = jQuery(this).attr('href');

        var obj =  jQuery(this);


        jQuery(id).slideToggle(600,function () {
            jQuery(obj).toggleClass('icon-readmore')
        }).toggleClass('content-active');
    });

    
    jQuery(document).on('gform_post_render', function(){
        if(jQuery(".ginput_container_fileupload").find('input.gform_hidden').length){
           jQuery(".ginput_container_fileupload").addClass('hiddenform');
       }
       jQuery(document).on('click',".gform_delete",function(){

        if(jQuery(".ginput_container_fileupload").find('input.gform_hidden').length){
           jQuery(".ginput_container_fileupload").addClass('hiddenform');
       }else{
         jQuery(".ginput_container_fileupload").removeClass('hiddenform');
     }
 })
   });

    /**
     * Toggle Div With Data attr
     */

     jQuery(document).on('click', '.toggle-button', function () {
        jQuery(this).toggleClass('mobile-active')
        jQuery("#" + jQuery(this).data('toggleid')).toggleClass('mobile-active');
    });
     jQuery(document).on('click', '.hideshow-button', function () {
        jQuery(this).toggleClass('inactive')
        jQuery("#" + jQuery(this).data('toggleid')).slideToggle(400, 'linear');
    });

     jQuery('#menu-home-page-menu  li:first').addClass('active');
     jQuery('#menu-home-page-menu  li:first > a').siblings('ul').show();
     jQuery("#menu-home-page-menu > li.menu-item-has-children").each(function () {

        var srcurl = jQuery(this).find('span.bannersrc').data('src');
        if (jQuery(this).find('span.bannersrc')) {
            jQuery("#home-menu-banner").find('img').attr('src', srcurl);
            return false;
        }
    });


     jQuery("#menu-home-page-menu li.menu-item-has-children > a").on('click', function (e) {
        var srcurl = jQuery(this).find('span.bannersrc').data('src');
        if (jQuery(this).find('span.bannersrc').length > 0) {
            e.preventDefault();
            jQuery("#home-menu-banner").find('img').attr('src', srcurl);
        }


        jQuery(this).parent('li').toggleClass('active').siblings().removeClass('active').find('ul').slideUp(500, 'linear');
        jQuery(this).siblings('ul').slideToggle(500, 'linear');


    })


     jQuery(".accordion-wrap .accordion_in").each(function () {
        var srcurl = jQuery(this).find('span.bannersrc').data('src');

        if (jQuery(this).find('span.bannersrc').length > 0) {

            jQuery("#sidebanner").find('img').attr('src', srcurl);
            return false;
        }
    });

     jQuery(".accordion-wrap .accordion_in").on('click', function (e) {
        var srcurl = jQuery(this).find('span.bannersrc').data('src');
        if (jQuery(this).find('span.bannersrc')) {
            e.preventDefault();
            jQuery("#sidebanner").find('img').attr('src', srcurl);
        }
    })

     jQuery('footer .widget-title').on('click',function () {

        var hasclass = false;
        if(jQuery(this).hasClass('mobile-active')){
            hasclass = true;
        }
        jQuery('footer .widget-title').removeClass('mobile-active');
        if(!hasclass){
            jQuery(this).addClass('mobile-active');
        }

    })

    // input file upload code
    jQuery(".gform_wrapper").on("change", "input[type='file']", function(){ 
        jQuery(this).parent(".ginput_container_fileupload").attr("data-text", jQuery(this).val().replace(/.*(\/|\\)/, '') );
    });
});

// header scroll fixed
jQuery(window).scroll(function() {
    var scroll = jQuery(window).scrollTop();

    if (scroll >= 200) {
        jQuery("header.site-header").addClass("site-header-fixed");
    } else {
        jQuery("header.site-header").removeClass("site-header-fixed");
    }
});

jQuery(function($) {

// Dropdown toggle
jQuery('.toggler').click(function(){
    // alert("click");
    jQuery(this).toggleClass('ctoggle').next('.toggle_wrap').toggle().toggleClass('ctoggle');
    // alert(this);
});
jQuery(document).click(function(e) {
    var target = e.target;
    if (!$(target).is('.toggler') && !$(target).hasClass('ctoggle') && !$(target).parents().hasClass('ctoggle')) {
        jQuery('.toggle_wrap').hide().removeClass('ctoggle');
    }
});

});

jQuery(function($) {
    //----- OPEN
    jQuery('[data-popup-open]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        jQuery('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
        e.preventDefault();
        var user_service = jQuery(".user_service_id").val();
        var subscriber_id = jQuery(".subscriber_id").val();
        jQuery.ajax({
            url: admin_ajax,
            type: 'post',
            data: {
                action: 'km_add_tasker_contact',
                user_service_id: user_service,
                subscriber_id: subscriber_id
            },
            success: function (res) {
                if (res != '') {
                    jQuery(".status_res").text(res);
                }
            }
        });
    });
    //----- CLOSE
    jQuery('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        jQuery('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
        e.preventDefault();
    });
});

jQuery(document).scroll(function() {
  var y = jQuery(this).scrollTop();
  if (y > 300) {
    jQuery('.floater').fadeIn();
} else {
    jQuery('.floater').fadeOut();
}
});

// counter
jQuery(window).scroll(startCounter);
function startCounter() {
    if (jQuery(window).scrollTop() > 200) {
        jQuery(window).off("scroll", startCounter);
        jQuery('.counter-value').each(function () {
            var $this = jQuery(this);
            jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
                duration: 2500,
                easing: 'swing',
                step: function () {
                    $this.text(Math.ceil(this.Counter));
                }
            });
        });
    }
};

