$(document).ready(function(){
    if(jQuery('#dpd1').length){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var to = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate()+1, 0, 0, 0, 0);
        $('#dpd1').datepicker({
            dateFormat: 'dd M yy',
            minDate: now
        }).bind('change', function(ev) {
            var minValue = $(this).val();
            minValue = $.datepicker.parseDate("dd M yy", minValue);
            minValue.setDate(minValue.getDate()+1);
            $("#dpd2").datepicker( "option", "minDate", minValue );
        }).data('datepicker');


        $('#dpd2').datepicker({
            dateFormat: 'dd M yy',
            minDate: to
        }); 
    }

    $('.bxslider').bxSlider({
        auto: true,
        mode: 'fade',
        responsive: true,
        controls: false
    });
    $('#carouselRooms').carouFredSel({
        responsive: true,
        width: '100%',
        scroll: 1,
        auto: false,
        prev: '#prev1',
        next: '#next1', 
        items: {
            width: 480,
            visible: {
                min: 1,
                max: 6
            }
        }
    });
    $('#carouselFacilities').carouFredSel({
        responsive: true,
        width: '100%',
        scroll: 1,
        auto: false,
        prev: '#prev2',
        next: '#next2', 
        items: {
            width: 480,
            visible: {
                min: 1,
                max: 6
            }
        }
    });
    $('a[data-rel^=lightcase]').lightcase({
        swipe: true,
        showTitle: true,
        type: 'image'
    });
});