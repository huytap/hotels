if($('#BookingForm_card_number').length){
    document.getElementById('BookingForm_card_number').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
    });
}
$(document).ready( function() {
    $('#BookingForm_card_number').blur(function(){
    });
    //tracking
    //tracking();
    //research
    /*if($('.btn-booking').length){
        $('.btn-booking').click(search);
    }*/
    /*if(jQuery('#exchange_rate').length){
        jQuery('#exchange_rate').change(search);
    }*/
    //booknow
    booknow();
    $(window).scroll(function(){
        if ($(window).scrollTop() > $(".header").height() && $(window).width() >=992)
            $("#cart-payment").addClass("fixed-sidebar");
        else $("#cart-payment").removeClass("fixed-sidebar");
    });

    jQuery('.payment').find('input[type="text"]').bind("cut copy paste",function(e) {
        e.preventDefault();
    });
    packages();
    getservices();

    if($('#extra').length){
        $('#extra').find('.extra').each(function(i, row){
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
                        $('#room_extra').html(data);
                    }
                });
            })
        })
    }
    
});

function getservices(){
    $('#pickup, #dropoff').change(function(){
        var pickup = $('#pickup').val();
        var drop_off = $('#dropoff').val();
        var data = {pickup:pickup,drop_off:drop_off}
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
                if(pickup !== ''){
                    $('#pickup_info').show()
                }else{
                    $('#pickup_info').hide()
                }

                if(drop_off !== ''){
                    $('#drop_info').show()
                }else{
                    $('#drop_info').hide()
                }

                $('#room_extra').html(data);
            }
        });
    });
}

function packages(){
    $('.package').each(function(i, j){
        $(j).find('.pk').change(function(){
            var id = $(this).val();
            var checked = $(this).is(':checked');
            var adult = $(j).find('.pk_adult').val();
            var child = $(j).find('.pk_child').val();
            $.ajax({
                url: rootUrl +'booking/getservices',
                type:'post',
                sync:false,
                data:{pk_id:id, type:checked, pk_adult:adult, pk_child:child},
                beforeSend:function(){
                    $('#loading').show();
                },
                success:function(data){
                    if(checked){
                        $(j).find('.pklabel').show();
                        $(j).find('.pkprice').show();
                    }else{
                        $(j).find('.pklabel').hide();
                        $(j).find('.pkprice').hide();
                    }
                    $('#loading').hide();
                    $('#room_extra').html(data);
                }
            })
        });
        $(j).find('.pk_adult').change(function(){
            if($(j).find('.pk').is(':checked') == true){
                var id = $(j).find('.pk').val();
                var checked = $(j).find('.pk').is(':checked');
                var adult = $(this).val();
                var child = $(j).find('.pk_child').val();
                $.ajax({
                    url: rootUrl +'booking/getservices',
                    type:'post',
                    sync:false,
                    data:{pk_id:id, type:checked, pk_adult:adult, pk_child:child},
                    beforeSend:function(){
                        $('#loading').show();
                    },
                    success:function(data){
                        $('#loading').hide();
                        $('#room_extra').html(data);
                        $(j).find('.pkprice').text(pk_pr);
                    }
                })
            }
        });
        $(j).find('.pk_child').change(function(){
            if($(j).find('.pk').is(':checked') == true){
                var id = $(j).find('.pk').val();
                var checked = $(j).find('.pk').is(':checked');
                var child = $(this).val();
                var adult = $(j).find('.pk_adult').val();
                $.ajax({
                    url: rootUrl +'booking/getservices',
                    type:'post',
                    sync:false,
                    data:{pk_id:id, type:checked, pk_adult:adult, pk_child:child},
                    beforeSend:function(){
                        $('#loading').show();
                    },
                    success:function(data){
                        $('#loading').hide();
                        $('#room_extra').html(data);
                        $(j).find('.pkprice').text(pk_pr);
                    }
                })
            }
        })
    });
}

function tracking(){
    if(jQuery("#check-in-date").length && jQuery('#check-out-date').length){
        var fromDate = jQuery("#check-in-date").val();
        var toDate = jQuery('#check-out-date').val();
        jQuery.ajax({
            url:'http://localhost/bkengine/tracking',
            type: 'post',
            data:{fromDate:fromDate,toDate:toDate},
            success:function(data){

            }
        });
    }
}

function search(){
    var currency = $('#exchange_rate').val();
    var checkin = $('#check-in-date').val();
    var checkout = $('#check-out-date').val();
    var adult = $('#FormBook_adult').val();
    var child = $('#FormBook_children').val();
    
    var chain = $('#FormBook_chain').val();
    if($('#FormBook_hotel').length){
        var hotel = $('#FormBook_hotel').val();    
        window.location = rootUrl + 'booking/'+hotel+'/'+chain;
    }else{
        $.ajax({
            url: searchUrl,
            data:{flag:true, checkindate: checkin, currency:currency, checkoutdate:checkout, adult:adult, children:child},
            async: false,
            type: 'POST',
            beforeSend:function(){
                $('#loading').show();
                $('#search').empty()
            },
            success:function(data){
                $('#loading').hide();
                if(data){
                    /*if($('#search').length == 0){
                        location.reload();
                    }*/
                    var url = searchUrl+'?checkindate='+checkin+'&checkoutdate='+checkout+'&adult='+adult+'&children='+child;
                    //var url = rootUrl + 'booking/?checkindate='+checkin+'&checkoutdate='+checkout+'&adult='+adult+'&children='+child;
                    window.history.pushState("changeurl", "Title", url);
                    /*var url = rootUrl + 'booking/'+hotel+'/'+chain;
                    window.location = url;*/
                    
                    $('#search').html(data);
                    $("html, body").animate({ scrollTop: $('#step').offset().top }, 1000);
                    booknow();
                    popup();
                    
                }
            }
        })

    }
}

function booknow(){

    $('#search').find('.per-room').each(function(i, row){
        /*change adult*/
        /*$(row).find('.adult-number').change(function(){
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
        });*/
        /*change room*/
        /*$(row).find('.no_room').change(function(){
            var no_of_room = $(this).val();
            $('.no_room').val(0);
            $(row).find('.no_room').val(no_of_room);
        });*/
        /*check select room*/
        $(row).find('.btn-add-room').click(function(){
            /*if($(row).find('.no_room').val() <=0){
                alert('Please select no. of rooms to continue');
                return false;
            }else{*/
                //$(row).find('.extrabed').append('<input type="checkbox">')
                var no_of_room = $(this).parent().prev().find('.rooms').val();
                var roomtype_id = $(row).find('.roomtypes').attr('rel');
                var promotion_id = $(this).parent().parent().attr('rel');
                //var no_of_adult = $(row).find('.adult-number').val();
                //var children = $(row).find('.children-number').val();
                if(no_of_room>0){
                    $.ajax({
                        url:rootUrl+'booknow',
                        data: {
                            no_room:no_of_room,
                            roomtype:roomtype_id,
                            promotion:promotion_id,
                            //adult:no_of_adult,
                            //children:children
                        },
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function(){
                            $('#loading').show();
                        },
                        success:function(data){
                            //location.href=rootUrl+locate+'/payment';
                            location.href=rootUrl+'booking/option';
                        }
                    });
                }else{
                    alert('Please select number of rooms');
                }
        });
    });
}