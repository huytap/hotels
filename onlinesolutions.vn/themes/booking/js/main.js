jQuery(document).ready(function(){
    /*jQuery('.date input').bootstrapMaterialDatePicker({ weekStart : 0, time: false,format : 'DD-MM-YYYY' });
    jQuery('#arrival-date').bootstrapMaterialDatePicker({ weekStart : 0, time: false,format : 'DD-MM-YYYY' });
    jQuery('#departure-date').bootstrapMaterialDatePicker({ weekStart : 0, time: false,format : 'DD-MM-YYYY' });
*/
    //Slider Room
    if(jQuery('#room').length){
        jQuery('#room').bxSlider({
            slideWidth: 380,
            minSlides: 1,
            maxSlides: 5,
            moveSlides: 1,
            slideMargin: 0,
            pager:false,
            nextText:'<span class="glyphicon glyphicon-chevron-right"></span>',
            prevText:'<span class="glyphicon glyphicon-chevron-left"></span>'
        });
    }
    popup();  
    getservices();
});

function popup(){
    //Poup Google Maps Hotel
    jQuery('.show-map, .show-room, .show-cancellation').magnificPopup({
      type: 'ajax'
    });
}
function getservices(){

    jQuery('#pickup').change(function(){
        if(jQuery(this).val()){
            jQuery('#pickup_info').show()
        }else{
            jQuery('#pickup_info').hide()
        }
    });

    jQuery('#dropoff').change(function(){
        if(jQuery(this).val()){
            jQuery('#drop_info').show()
        }else{
            jQuery('#drop_info').hide()
        }
    });

    /*jQuery('#pickup, #dropoff').change(function(){
        var pickup = jQuery('#pickup').val();
        var drop_off = jQuery('#dropoff').val();
        var data = {pickup:pickup,drop_off:drop_off}
        jQuery.ajax({
            url: rootUrl +'ajax/getservices',
            type:'post',
            sync:false,
            data:{data:data},
            beforeSend:function(){
                jQuery('#loading').show();
            },
            success:function(data){
                jQuery('#loading').hide();
                if(pickup !== ''){
                    jQuery('#pickup_info').show()
                }else{
                    jQuery('#pickup_info').hide()
                }

                if(drop_off !== ''){
                    jQuery('#drop_info').show()
                }else{
                    jQuery('#drop_info').hide()
                }

                jQuery('#card_detail').html(data);
            }
        });
    });*/
}