var wndw = $(window);
	header = $('header');
	arrow = $('#arrow');
	titl = $('#title');

$(document).ready(function() {
	setHeader();
	equalHeight('.managertables', 768);

  jQuery('#arrow').click(function(e){
		var h = jQuery(this).attr('data-to');
    jQuery('html,body').animate({
			scrollTop: jQuery(h).offset().top
		}, 800);
		e.preventDefault();
	});
});

$(window).load(function(){
  jQuery('.slick').on('init', function(){
		jQuery(this).css('margin-bottom', '-' + jQuery(this).height()/2 +'px');
		jQuery(this).parents('section').next().css('margin-top', jQuery(this).height()/2 +'px');
	});
  jQuery('.slick').slick({
		infinite: true,
		arrows: true,
		slidesToShow: 4,
		autoplay: true,
		 responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
				}
			}
		]
	});
});

$(window).resize(function(){
	setHeader();
	equalHeight('.tab', 768);
});

function setHeader(){
	hr = (wndw.width() < 480) ? 2 : 1;
	headerW = 1600;
	headerH = 1045 * hr;
	header.height( header.width() * headerH / headerW );
	
	ar = (wndw.width() < 480) ? 0.7 : 1;
	arrow.removeAttr('style');
	oriArrowTop = 215 / ar;
	mt = header.height() * oriArrowTop / headerH;
	arrow.css('margin-top', mt +'px');
	
	ar = (wndw.width() < 480) ? 0.34 : 1;
	titl.removeAttr('style');
	oriTitlTop = 350 / ar;
	tt = '-' + (header.height() * oriTitlTop / headerH );
	titl.css('margin-top', tt +'px');
}

function equalHeight(group, size) {
	var tallest = 0;
  jQuery(group).each(function() {
    jQuery(this).css('height', 'auto');
		var thisHeight = jQuery(this).height();
		if(thisHeight > tallest) {
			tallest = thisHeight;
		}
	});
	if( jQuery(window).width() > size){
    jQuery(group).height(tallest);
	}
}
