document.addEventListener("touchstart", function() {},false);
jQuery(function() {
	jQuery('#wsnavtoggle').click(function () {
		jQuery(this).toggleClass('active-nav');
		jQuery('.wsmenucontainer').toggleClass('wsoffcanvasopener');
	});
	jQuery('.overlapblackbg').click(function () {
        jQuery('#wsnavtoggle').removeClass('active-nav');
	  jQuery('.wsmenucontainer').removeClass('wsoffcanvasopener');
	});
	
	jQuery('.wsmenu-list> li').has('.wsmenu-submenu').prepend('<span class="wsmenu-click"><i class="wsmenu-arrow fa fa-angle-down"></i></span>');
	jQuery('.wsmenu-list > li').has('.megamenu').prepend('<span class="wsmenu-click"><i class="wsmenu-arrow fa fa-angle-down"></i></span>');
	jQuery('.wsmenu-click').click(function(){
		jQuery(this).toggleClass('ws-activearrow')
		.parent().siblings().children().removeClass('ws-activearrow');
		jQuery(".wsmenu-submenu, .megamenu").not(jQuery(this).siblings('.wsmenu-submenu, .megamenu')).slideUp('slow');
		jQuery(this).siblings('.wsmenu-submenu').slideToggle('slow');
		jQuery(this).siblings('.megamenu').slideToggle('slow');	
	});
	
	jQuery('.wsmenu-list > li > ul > li').has('.wsmenu-submenu-sub').prepend('<span class="wsmenu-click02"><i class="wsmenu-arrow fa fa-angle-down"></i></span>');
	jQuery('.wsmenu-list > li > ul > li > ul > li').has('.wsmenu-submenu-sub-sub').prepend('<span class="wsmenu-click02"><i class="wsmenu-arrow fa fa-angle-down"></i></span>');
	
	jQuery('.wsmenu-click02').click(function(){
		jQuery(this).children('.wsmenu-arrow').toggleClass('wsmenu-rotate');
		jQuery(this).siblings('.wsmenu-submenu-sub').slideToggle('slow');
		jQuery(this).siblings('.wsmenu-submenu-sub-sub').slideToggle('slow');
	});

	jQuery('.wsmenu-list > li').has('.wsmenu-submenu').addClass('menu-arrow-1');
	jQuery('.wsmenu-list > li > .wsmenu-submenu > li').has('.wsmenu-submenu-sub').addClass('menu-arrow-2');
	jQuery('.wsmenu-list > li > .wsmenu-submenu > li > .wsmenu-submenu-sub > li').has('.wsmenu-submenu-sub-sub').addClass('menu-arrow-2');		
	jQuery('.wsmenu-list > li').has('.megamenu').addClass('menu-arrow-1');
	window.onresize = function(event) {
		console.log('window resize');
		if(jQuery(window).width() > 979){
			jQuery('.wsmenu-submenu').removeAttr("style");
 			jQuery('.wsmenu-list').removeAttr("style");
 		}
    };
	
});