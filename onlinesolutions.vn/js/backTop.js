if($("#back-to-top").length){var scrollTrigger=100,backToTop=function(){var a=$(window).scrollTop();a>scrollTrigger?$("#back-to-top").addClass("show"):$("#back-to-top").removeClass("show")};backToTop(),$(window).on("scroll",function(){backToTop()}),$("#back-to-top").on("click",function(a){a.preventDefault(),$("html,body").animate({scrollTop:0},700)})}