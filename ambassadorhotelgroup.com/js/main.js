jQuery(document).ready(function($) {
	$('.carousel').carousel();
	$('.material-menu > ul').materialmenu({
		showTitle: false
	});

	$(window).on("scroll",function(){
		if($(window).scrollTop()>100){
			$(".ar-header").addClass("stick-header");
		} else{
			$(".ar-header").removeClass("stick-header");
		}

		if($(window).scrollTop()>200){ 
			$(".back-top").css("opacity",1); 
		} else { 
			$(".back-top").css("opacity",0);
		}
	});	

	$('.preview-slider1').bxSlider({
		controls: false,
		captions: true,
		pagerCustom: '#slider-preview-custom1',
		mouseDrag: true	
	});
	$('.preview-slider2').bxSlider({
		controls: false,
		captions: true,
		pagerCustom: '#slider-preview-custom2',
		mouseDrag: true	
	});
	$('.preview-slider3').bxSlider({
		controls: false,
		captions: true,
		pagerCustom: '#slider-preview-custom3',
		mouseDrag: true	
	});
	$('.preview-slider4').bxSlider({
		controls: false,
		captions: true,
		pagerCustom: '#slider-preview-custom4',
		mouseDrag: true	
	});
	$('.preview-slider5').bxSlider({
		controls: false,
		captions: true,
		pagerCustom: '#slider-preview-custom5',
		mouseDrag: true	
	});
	$('.detail-slider').bxSlider({
		controls: false,
		captions: true,
		pagerCustom: '#slider-detail-custom',
		mouseDrag: true	
	});
		
});
