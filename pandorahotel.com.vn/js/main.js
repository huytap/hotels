jQuery(document).ready(function($) {
	$('.carousel').carousel();
	$('.material-menu > ul').materialmenu({
		showTitle: false
	});

	$(window).on("scroll",function(){
		if($(window).scrollTop()>100){
			$(".navMenu").addClass("stick-header");
		} else{
			$(".navMenu").removeClass("stick-header");
		}


		if($(window).scrollTop()>600){
			$(".HotelAffixs").addClass("stickHotel");
		} else{
			$(".HotelAffixs").removeClass("stickHotel");
		}


		if($(window).scrollTop()>300){
			$(".RoomAffixs").addClass("stickHotel");
		} else{
			$(".RoomAffixs").removeClass("stickHotel");
		}


		if($(window).scrollTop()>200){ 
			$(".back-top").css("opacity",1); 
		} else { 
			$(".back-top").css("opacity",0);
		}
	});	
		
});
