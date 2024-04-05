jQuery(function($){
 "use strict";
   jQuery('.main-menu-navigation > ul').superfish({
     delay:       0,                            
     animation:   {opacity:'show',height:'show'},  
     speed:       'fast'                        
   });

});

function advance_portfolio_resmenu_open() {
  document.getElementById("menu-sidebar").style.width = "100%";
}
function advance_portfolio_resMenu_close() {
  document.getElementById("menu-sidebar").style.width = "0";
}

// scroll
	jQuery(document).ready(function () {
		jQuery(window).scroll(function () {
		  if (jQuery(this).scrollTop() > 0) {
		      jQuery('#scroll-top').fadeIn();
		  } else {
		      jQuery('#scroll-top').fadeOut();
		  }
		});
		jQuery(window).on("scroll", function () {
		  document.getElementById("scroll-top").style.display = "block";
		});
		jQuery('#scroll-top').click(function () {
		  jQuery("html, body").animate({
		      scrollTop: 0
		  }, 600);
		  return false;
		});
	});

(function( $ ) {

	$(window).scroll(function(){
	  var sticky = $('.sticky-header'),
	      scroll = $(window).scrollTop();

	  if (scroll >= 100) sticky.addClass('fixed-header');
	  else sticky.removeClass('fixed-header');
	});

})( jQuery );

jQuery(function($){
  $(window).load(function() {
    $("#loader-wrapper").delay(1000).fadeOut("slow");
      $("#loader").delay(1000).fadeOut("slow");
  })
});
