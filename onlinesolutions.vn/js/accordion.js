$(document).ready(function() {
    var cur_stus;

	var path = window.location.pathname;
	var path = path.replace(/phiphi\//g,"");

    //close all on default
    $('#accordion dd').hide();
    $('#accordion dt').attr('stus', '');

	
		//open default data
		$('#accordion dd:eq(0)').slideDown();
		$('#accordion dt:eq(0)').attr('stus', 'curr_dt');
		$('#accordion dt:eq(0)').addClass('curr_dt');
		$('#accordion dt:eq(0) a').addClass('curr_arr');
	
	
    $('#accordion dt').click(function(){
        cur_stus = $(this).attr('stus');
        if(cur_stus != "curr_dt")
        {
            //reset everthing - content and attribute
            $('#accordion dd').slideUp();
            $('#accordion dt').attr('stus', '');
            $('#accordion dt').removeClass('curr_dt');
			$('#accordion dt a').removeClass('curr_arr');
			
            //then open the clicked data
            $(this).next().slideDown();
            $(this).attr('stus', 'curr_dt');
            $(this).addClass('curr_dt');
			$('a', this).addClass('curr_arr');
			
        }
        //Remove else part if do not want to close the current opened data
        else
        {
            $(this).next().slideUp();
            $(this).attr('stus', '');
            $(this).removeClass('curr_dt');
			$('a', this).removeClass('curr_arr');
					
        }
        return false;
    });
});