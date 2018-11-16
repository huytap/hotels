var rootUrl='http://localhost/tokyohotel/';
$(document).ready( function() {
    jQuery('.payment').find('input[type="text"]').bind("cut copy paste",function(e) {
        e.preventDefault();
    });
    
    getservices();
    /*if($('.per-room').length){
        $('.per-room').each(function(j, row){
            if($(row).find('.roomname').length>0){
                $(row).find('.roomname').click(function(){
                    var roomtype = $(row).find('.roomname').attr('rel');
                    if(roomtype>0){
                        $.ajax({
                            url:rootUrl+'booking/getroomtype',
                            type: 'post',
                            data: {roomtype: roomtype},
                            sync: false,
                            success: function(data){
                                $('#modal').addClass('in');
                                $('#modal').show();
                                $('#detail').html(data);

                                $('.flexslider-thumb').flexslider({
                                    animation: "slide",
                                    animationLoop: false,
                                    prevText: "",
                                    nextText: "",
                                    controlNav: "thumbnails"
                                });
                            }
                        });
                    }
                })
            }
        })
    }*/

    if(jQuery('#check-in-date').length){
        var checkin = jQuery('#check-in-date').bootstrapMaterialDatePicker({minDate : new Date()}).on('change', function(e, date){
            var newDate = new Date(date)
            newDate.setDate(newDate.getDate() + 1);
            jQuery('#check-out-date').val('');
            jQuery('#check-out-date').bootstrapMaterialDatePicker('setDate', newDate);
            jQuery('#check-out-date').bootstrapMaterialDatePicker('setMinDate', newDate);
            //jQuery('#check-out-date')[0].focus();

        });

        if (typeof fromDate !== 'undefined') {
            jQuery('#check-in-date').val(fromDate);
            var fromDateArray = fromDate.split('-');
            jQuery('#check-in-date').bootstrapMaterialDatePicker('setMinDate', new Date());
        }
        if (typeof toDate !== 'undefined') {
            jQuery('#check-out-date').val(toDate);
        }
        var checkout = jQuery('#check-out-date').bootstrapMaterialDatePicker();

        
    }

    if($('#arrival-date').length){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        var pickup_date = $('#arrival-date').datepicker({
            format: 'dd-mm-yyyy',
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > dropoff_date.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                dropoff_date.setValue(newDate);
            }
            pickup_date.hide();
        }).data('datepicker');
    }
    if($('#departure-date').length){
        var dropoff_date = $('#departure-date').datepicker({
            format: 'dd-mm-yyyy',
            onRender: function(date) {
                return date.valueOf() <= pickup_date.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
            dropoff_date.hide();
        }).data('datepicker');

        //$('.date-flight').datepicker({format:'dd-mm-yyyy'});
        //$('.time-flight').timepicker({defaultTime: false});
    }
    /*change rate*/
	if(jQuery('#exchange_rate').length){
        jQuery('#exchange_rate').change(function(){
            var currency = jQuery('#exchange_rate');
            jQuery('#formCurrency').submit();
        });
    }

    $('#search').find('.per-room').each(function(i, row){
        /*change adult*/
        $(row).find('.adult-number').change(function(){
            var adult = $(this).val();
            var rt_id = $(row).find('.roomtypes').attr('rel');
            $.ajax({
                url: rootUrl +'ajax/changeattributes',
                data:{roomtype: rt_id, adult: adult},
                type: 'post',
                dataType: 'json',
                beforeSend: function(){
                    $(row).find('.promotions').find('.loading').show();
                    $(row).find('.promotions').find('.currency-txt').empty();
                },
                success: function(data){
                    $(row).find('.promotions').find('.loading').hide();
                    
                    if(data != 0){
                        $.each($(row).find('.promotions'), function(i, row2){
                            $(row2).find('.old').text(data.old);
                            $(row2).find('.currency-txt').text(data.promos[i]);
                        })
                    }else{

                    }
                }
            });
        });
        /*change room*/
    	$(row).find('.no_room').change(function(){
            var no_of_room = $(this).val();
    		$('.no_room').val(0);
    		$(row).find('.no_room').val(no_of_room);
    	});
        /*check select room*/
        $(row).find('.btn-add-room').click(function(){
            if($(row).find('.no_room').val() <=0){
                alert('Please select no. of rooms to continue');
                return false;
            }else{
                $(row).find('.extrabed').append('<input type="checkbox">')
                var no_of_room = $(row).find('.no_room').val();
                var roomtype_id = $(row).find('.roomtypes').attr('rel');
                var promotion_id = $(this).parent().parent().attr('rel');
                var no_of_adult = $(row).find('.adult-number').val();
                var children = $(row).find('.children-number').val();
                location.href= rootUrl+'prebook?no_room='+no_of_room+'&roomtype='+roomtype_id+'&promotion='+promotion_id +'&adult='+no_of_adult+'&children='+children;
            }
        });
    });
    if($('#extra').length){
        $('#extra').find('.col-sm-6').each(function(i, row){
            $(row).find('.input-checkbox').click(function(){
                var extrabed = $('#extrabed'+(i+1)).prop('checked') ? 1 : 0;
                var data = {extrabed:'extrabed'+(i+1), extra_value: extrabed};
                $.ajax({
                    url: rootUrl +'booking/getservices',
                    type:'post',
                    sync:false,
                    data:{data:data},
                    beforeSend:function(){
                        $('#loading').show();
                    },
                    success:function(data){
                        $('#loading').hide();
                        $('#card_detail').html(data);
                    }
                });
            })
        })
    }
    
});