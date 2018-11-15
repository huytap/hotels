var numberFormat="#,##0.00";
var jNumberFormat={format:numberFormat};

jQuery(function(){
    /*update rate*/
    updateRate();
    flightInfo();
    theSameInfo();
    if (jQuery('.btn-add-room').length) {
        jQuery('.btn-add-room').click(addtocart);
    }

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
            
            /*
                var setDateTo = new Date(fromDateArray[2],fromDateArray[1]-1,fromDateArray[0]);
                setDateTo.setDate(setDateTo.getDate() + 1);
                jQuery('#check-out-date').bootstrapMaterialDatePicker('setMinDate', setDateTo);
            */
            jQuery('#check-in-date').bootstrapMaterialDatePicker('setMinDate', new Date());
        }
        if (typeof toDate !== 'undefined') {
            jQuery('#check-out-date').val(toDate);
        }
        var checkout = jQuery('#check-out-date').bootstrapMaterialDatePicker();

        
    }
    /*change currency*/
    if(jQuery('#exchange_rate').length){ 
        jQuery('#exchange_rate').change(function(){ 
            location.reload();
            jQuery('#formCurrency').submit(); 
        }); 
    }
    /*end change currency*/
    /*do not copy cut paste*/
    jQuery('.payment').find('input[type="text"]').bind("cut copy paste",function(e) {
        e.preventDefault();
    });

})

function removecart(roomtype_id, promotion_id) {
    /*var elem = jQuery(this).parent().closest('.row');
    jQuery.confirm({
        'title'     : 'Delete Confirmation',
        'message'   : 'You are about to delete this room. <br />It cannot be restored at a later time! Continue?',
        'buttons'   : {
            'Yes'   : {
                'class' : 'blue',
                'action': function(){
                    elem.slideUp();
                    jQuery.ajax({
                        url: 'removecart',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            roomtype_id: roomtype_id,
                            fromDate: fromDate,
                            toDate: toDate,
                            promotion_id: promotion_id
                        },
                        beforeSend: function() {
                            jQuery("#loading-cart").show();
                            jQuery('#carttable').empty()
                            jQuery('#term-amount-skip').empty();
                        },
                        success: function(data) {
                            jQuery('#carttable').html('');
                            var currency = jQuery('#change-currency').val();
                            var i = 0;
                            var temp = "";
                            var totalRate = 0;
                            var currency_unit = 'VND';
                            jQuery.each(data.cart, function(key, value) {
                                temp = data.cart;
                                var fromDates = new Date(parseInt(value.fromDate.sec, 10) * 1000);
                                var toDates = new Date(parseInt(value.toDate.sec, 10) * 1000);
                                var MongoFromDate = fromDates.getDate() + ' ' + monthofyear()[fromDates.getMonth()] + ' ' + fromDates.getFullYear();
                                var MongoToDate = toDates.getDate() + ' ' + monthofyear()[toDates.getMonth()] + ' ' + toDates.getFullYear();
                                var html = '<div class="row" rel=' + value.id + '>';
                                html += '<div class="col-md-5">'+(i+1)+'. '+ value.room_name + ' - ' + value.promotion_name +'</div>';
                                html += '<div class="col-md-6">' + value.no_room + ' ' + langStatic()[locate][37]+'&nbsp;&nbsp;'+value.adult*value.no_room + ' ' + langStatic()[locate][9] +'&nbsp;&nbsp;' + value.children*value.no_room + ' ' + langStatic()[locate][10]+ '&nbsp;&nbsp;';
                                html += value.currency + ' ' + addCommas(value.rate)+'</div>';
                                html += '<div class="col-md-1 no-padding-l right"><a href="javascript:void(0)" onclick="removecart(\'' + value.id + '\',\'' + value.fromDate.sec + '\',\'' + value.toDate.sec + '\', \''+value.promotion_id+'\')">' + langStatic()[locate][26] + '</a></div></div>';


                                
                                var newAvailable = value.no_room;
                                currency_unit = value.currency;
                                jQuery('#carttable').append(html);
                                totalRate += parseFloat(value.rate.toFixed(2));
                            });
                            if (temp === "") {
                                jQuery("#btnContinue").attr("disabled", "disabled")
                            }
                            jQuery('#term-amount-skip').append(currency_unit + ' ' + addCommas(totalRate));
                            jQuery("#loading-cart").hide()
                        },
                        error: function() {
                            jQuery("#loading-cart").hide();
                            jQuery('#carttable').show();
                            alert('System busy')
                        }
                    });
                }
            },
            'No'    : {
                'class' : 'gray',
                'action': function(){}  // Nothing to do in this case. You can as well omit the action property.
            }
        }
    });*/
    if(confirm("Are you sure to delete this room?")) {
        jQuery.ajax({
            url: rootUrl+'removecart',
            type: 'post',
            dataType: 'json',
            data: {
                roomtype_id: roomtype_id,
                promotion_id: promotion_id
            },
            beforeSend: function() {
                jQuery("#loading-cart").show();
                jQuery('#carttable').empty()
                jQuery('#term-amount-skip').empty();
            },
            success: function(data) {
                /*if (data.booked != undefined) {
                    updateAvailableRoom(data.booked);
                }*/
                jQuery('#carttable').html('');
                var currency = jQuery('#change-currency').val();
                var i = 0;
                var temp = "";
                var totalRate = 0;
                var currency_unit = 'VND';
                jQuery.each(data, function(key, value) {
                    temp = value;
                    i++;
                    var html = '<div class="row" rel=' + value.id + '>';
                    html += '<div class="col-md-5">'+(i)+'. '+ value.roomtype + ' - ' + value.promotion_name +'</div>';
                    html += '<div class="col-md-6">' + value.no_of_room + ' ' + langStatic()[locate][37]+'&nbsp;&nbsp;'+value.adult + ' ' + langStatic()[locate][9] +'&nbsp;&nbsp;' + value.children + ' ' + langStatic()[locate][10]+ '&nbsp;&nbsp;';
                    html += value.currency + ' ' + addCommas(value.rate)+'</div>';
                    html += '<div class="col-md-1 no-padding-l right"><a href="javascript:void(0)" onclick="removecart(\'' + value.id + '\',\'' + value.fromDate + '\',\'' + value.toDate + '\', \''+value.promotion_id+'\')">' + langStatic()[locate][26] + '</a></div></div>';


                    jQuery('#cartBK').show();
                    var newAvailable = value.no_room;
                    currency_unit = value.currency;
                    jQuery('#carttable').append(html);
                    totalRate += parseFloat(value.rate.toFixed(2));
                });
                if (temp === "") {
                    jQuery("#btnContinue").attr("disabled", "disabled")
                }
                jQuery('#term-amount-skip').append(currency_unit + ' ' + addCommas(totalRate));
                jQuery("#loading-cart").hide()
            },
            error: function() {
                jQuery("#loading-cart").hide();
                jQuery('#carttable').show();
                alert('System busy')
            }
        });
    }
}

function addtocart() {
    var btnAddtocart = jQuery(this);
    var promotion_id = jQuery(this).parent().parent().attr('rel');
    var roomtype_id = jQuery(this).parent().parent().parent().prev().find('.child').attr('rel').split("_")[1];
    var fromDate = jQuery("#check-in-date").val();
    var toDate = jQuery('#check-out-date').val();
    var adult = jQuery(this).parent().parent().parent().prev().find('select.adult-number').val();
    var children = jQuery(this).parent().parent().parent().prev().find('select.children-number').val();
    //var room_name = jQuery(this).parent().parent().parent().find('strong.roomtype-name').attr('rel');
    var no_room = jQuery(this).parent().parent().parent().prev().find('select.no_room').val();

    //console.log('children='+children+', room_name='+room_name+', no_room='+no_room+', toDate='+toDate+', adult='+adult)
    //var order = jQuery(this).parent().parent().parent().prev().attr('rel');
    var currency = jQuery('#exchange_rate').val();
    //var book_night = showTotalNight();
    //var childAge = (jQuery(this).parent().parent().parent().prev().find('.children-number').data('childAge') != undefined) ? jQuery(this).parent().parent().parent().prev().find('.children-number').data('childAge') : 0;
    //var extrabed = (jQuery(this).parent().parent().parent().prev().find('.children-number').data('adult') != undefined) ? jQuery(this).parent().parent().parent().prev().find('.children-number').data('adult') : 0;
    var jQuerytarget = jQuery('#carttable');
    var targetOffset = jQuerytarget.offset().top;
    
    jQuery('html, body').animate({
        scrollTop: targetOffset
    }, 400);
    var tagAvai = jQuery(this).parent().parent().parent().prev().find('.available').text();
    
    if (tagAvai > 0 && tagAvai-no_room>=0) {
        jQuery.ajax({
            url: rootUrl+'addtocart',
            type: 'post',
            dataType: 'json',
            data: {
                promotion_id: promotion_id,
                fromDate: fromDate,
                toDate: toDate,
                no_of_adult: adult,
                no_of_children: children,
                roomtype_id: roomtype_id,
                currency: currency,
                /*book_night: book_night,
                extrabed: extrabed,
                childAge:childAge,*/
                no_of_room: no_room
            },
            beforeSend: function() {
                jQuery('#carttable').empty();
                jQuery("#loading-cart").show();
                jQuery('#cartBK').show();
            },
            success: function(data) {
                /*if (data.booked != undefined) {
                    updateAvailableRoom(data.booked, btnAddtocart);
                }*/
                var i = 0;
                var totalRate = 0;
                var currency_unit = 'VND';
                jQuery.each(data.roomtype, function(key, value) {
                    i++;
                    var html = '<div class="row" rel=' + value.id + '>';
                    html += '<div class="col-md-5">'+(i)+'. '+ value.roomtype + ' - ' + value.promotion_name +'</div>';
                    html += '<div class="col-md-6">' + value.no_of_room + ' ' + langStatic()[locate][37]+'&nbsp;&nbsp;'+value.adult + ' ' + langStatic()[locate][9] +'&nbsp;&nbsp;' + value.children + ' ' + langStatic()[locate][10]+ '&nbsp;&nbsp;';
                    html += value.currency + ' ' + addCommas(value.rate)+'</div>';
                    html += '<div class="col-md-1 no-padding-l right"><a href="javascript:void(0)" onclick="removecart(' + value.roomtype_id + ', '+value.promotion_id+')">' + langStatic()[locate][26] + '</a></div></div>';


                    jQuery('#cartBK').show();
                    var newAvailable = value.no_of_room;
                    //currency_unit = value.currency;
                    jQuery('#carttable').append(html);
                    totalRate += parseFloat(value.rate.toFixed(2));
                });
                //jQuery('#cartBK').hide();
                jQuery("#btnContinue").removeAttr("disabled");
                jQuery('#term-amount-skip').empty();
                jQuery('#term-amount-skip').append(addCommas(totalRate));
                jQuery("#loading-cart").hide();
            },
            error: function() {
                console.log('error');
            }
        });
    }
    else {
        //jQueryparent = jQuery(this).parent().empty();
        //jQueryparent.append('<div class="require">Please Contact Us</div>');
        alert(langMess()[locate][29]);
    }
}
function reload() {
    if(jQuery.trim(jQuery("#carttable tbody").html())!=="") {
        var currency=jQuery('#change-currency').val();
        jQuery.ajax( {
            url:'reloadcart', type:'post', dataType:'json', data: {
                currency: currency
            }
            ,
            beforeSend:function() {
                jQuery('#carttable').empty();
                jQuery("#btnContinue").attr("disabled");
                jQuery("#loading-cart").show()
            }
            ,
            success:function(data) {
                var i = 0;
                var totalRate = 0;
                var currency_unit = 'VND';
                jQuery.each(data.roomtype, function(key, value) {
                    i++;
                    var html = '<div class="row" rel=' + value.id + '>';
                    html += '<div class="col-md-5">'+(i)+'. '+ value.roomtype + ' - ' + value.promotion_name +'</div>';
                    html += '<div class="col-md-6">' + value.no_of_room + ' ' + langStatic()[locate][37]+'&nbsp;&nbsp;'+value.adult + ' ' + langStatic()[locate][9] +'&nbsp;&nbsp;' + value.children + ' ' + langStatic()[locate][10]+ '&nbsp;&nbsp;';
                    html += value.currency + ' ' + addCommas(value.rate)+'</div>';
                    html += '<div class="col-md-1 no-padding-l right"><a href="javascript:void(0)" onclick="removecart(' + value.roomtype_id + ', '+value.promotion_id+')">' + langStatic()[locate][26] + '</a></div></div>';


                    jQuery('#cartBK').show();
                    var newAvailable = value.no_of_room;
                    currency_unit = value.currency;
                    jQuery('#carttable').append(html);
                    totalRate += parseFloat(value.rate.toFixed(2));
                });
                jQuery('#term-amount-skip').empty();
                jQuery('#term-amount-skip').append(currency_unit+' '+jQuery.formatNumber(total_rate,
                jNumberFormat));
                jQuery('#carttable').show();
                jQuery("#btnContinue").removeAttr("disabled");
                jQuery("#loading-cart").hide()
            }
            ,
            error:function() {
                jQuery("#loading-cart").hide();
                console.log('Error')
            }
        }
        )
    }
}
function updateRate() {
    jQuery.noConflict();
    jQuery(".roomtypes").each(function(index, row) {
        jQuery(row).find(".adult-number").change(function() {
            var roomtype = jQuery(row).children().attr('rel').split('_')[1];
            var adult = jQuery(row).find(".adult-number").val();
            var fromDate = jQuery('#check-in-date').val();
            var toDate = jQuery('#check-out-date').val();
            var currency = jQuery("#currency").val();
            var children = jQuery(row).find(".children-number").val();
            var tag = jQuery(row).children().attr('rel');
            var maxChildren = jQuery('.children-number option:last').val();
            var json = '[';
            for (var i = 0; i <= maxChildren; i++) {
                json += '{"value":' + i + ',"text":' + i + '}';
                if (i < maxChildren) {
                    json += ',';
                }
            }
            json += ']';

            jQuery(row).find('.children-number').val(0);
            jQuery.ajax({
                url: 'updaterate',
                data: {
                    adult: adult,
                    roomtype: roomtype,
                    fromDate: fromDate,
                    toDate: toDate,
                    currency: currency,
                    children: children
                },
                beforeSend: function() {
                    jQuery(tag).find('.row-promos').each(function(i, j) {
                        jQuery(j).find('.rate .currency-txt').empty();
                        jQuery(j).find('.loading').show();
                    })
                },
                dataType: 'json',
                type: "post",
                success: function(data) {
                    jQuery(tag).find('.row-promos').each(function(i, j) {
                        jQuery(j).find('.loading').hide();
                        if(data[jQuery(j).attr('rel')][adult]){
                            var price = addCommas(data[jQuery(j).attr('rel')][adult]);
                            jQuery(j).find('.rate .currency-txt').text(price);
                        }else{
                            jQuery(j).find('.rate span').text('Contact');
                        }
                        
                        
                    });
                    jQuery(row).find(".children-number").data("adult", 0);
                    jQuery(row).find(".children-number").data("adult", 0);
                }
            });
        });
        /*children change*/
        jQuery(row).find(".children-number").change(function() {
            var roomtype = jQuery(row).children().attr('rel').split('_')[1];
            var adult = jQuery(row).find(".adult-number").val();
            var children = jQuery(row).find(".children-number").val();

            var fromDate = jQuery('#check-in-date').val();
            var toDate = jQuery('#check-out-date').val();
            var currency = jQuery("#currency").val();
            var tag = jQuery(row).children().attr('rel');
            var extra_bed = jQuery(row).find('.children-number').attr('rel');
            if (children != 0 && extra_bed >0) {
                var extra = '';
                for (var j = 1; j <= children; j++) {
                    extra += '<div class="dialog">';
                    extra += langStatic()[locate][31] + ' <select class="number_select small age"><option value="12">11+</option>';
                    for (var k = 11; k >= 1; k--) {
                        extra += '<option value="' + k + '">' + k + '</option>';
                    }
                    extra += '</select><span name="extraBedWrapper" class="spanOption"> ' + langStatic()[locate][33];
                    // extra +='<input type="checkbox" id="optionExtra">';                            
                    extra += '</span>';
                    extra += '</div>';
                }
                jQuery("#choose_extrabed").html(extra);
                //jQuery("#box2").show();
                jQuery('#box2').modal('show');
                var countExtra = 0
                var childAge = []
                jQuery('.dialog').each(function(g, h) {
                    countExtra++;
                    childAge[g] = '11+';
                    jQuery(h).find('.age').change(function() {
                        if (jQuery(h).find('.age').val() > 11) {
                            jQuery(h).find('.spanOption').html(langStatic()[locate][33]);
                            childAge[g] = '11+'
                        } else {
                            jQuery(h).find('.spanOption').html(langStatic()[locate][32] + ' <input type="checkbox" class="optionExtra">');
                            if (countExtra > 0) {
                                countExtra--;
                            }
                            childAge[g] = jQuery(h).find('.age').val()
                        }
                        jQuery(h).find('.spanOption').find('.optionExtra').click(function() {
                            if (jQuery(this).is(":checked")) {
                                countExtra++;
                            } else {
                                if (countExtra > 0) {
                                    countExtra--;
                                }
                            }
                        });
                    });       
                });
                jQuery("#box2 .ChildOk").click(function() {
                    jQuery.ajax({
                        url: 'updaterate',
                        data: {
                            adult: adult,
                            roomtype: roomtype,
                            fromDate: fromDate,
                            toDate: toDate,
                            currency: currency,
                            children: children,
                            extrabed: countExtra
                        },
                        beforeSend: function() {
                            jQuery(tag).find('.row-promos').each(function(i, j) {
                                jQuery(j).find('.rate .currency-txt').empty();
                                jQuery(j).find('.loading').show();
                            });
                            jQuery("#box2").modal('hide');
                            jQuery("#box2 .modal-body").empty();
                        },
                        dataType: 'json',
                        type: "post",
                        success: function(data) {
                            jQuery(tag).find('.row-promos').each(function(i, j) {
                                jQuery(j).find('.loading').hide();
                                if(data[jQuery(j).attr('rel')][adult]){
                                    var price = addCommas(data[jQuery(j).attr('rel')][adult]);
                                    jQuery(j).find('.rate .currency-txt').text(price);
                                }else{
                                    jQuery(j).find('.rate span').text('Contact');
                                }

                            })
                            //countExtra=0;
                            jQuery(row).find(".children-number").data("adult", countExtra)
                            jQuery(row).find(".children-number").data("childAge", childAge)
                            console.log( jQuery(row).find(".children-number").data("adult"));
                        }
                    });
                })
            } else if(children != 0 && extra_bed <= 0){
                var extra = '';
                for (var j = 1; j <= children; j++) {
                    extra += '<div class="dialog">';
                    extra += langStatic()[locate][31] + ' <select class="number_select small age">';
                    for (var k = 11; k >= 1; k--) {
                        extra += '<option value="' + k + '">' + k + '</option>';
                    }
                    extra += '</select><span name="extraBedWrapper" class="spanOption">' + langStatic()[locate][35];                        
                    extra += '</span>';
                    extra += '</div>';
                }
                jQuery("#choose_extrabed").html(extra);
                //jQuery("#box2").show();
                jQuery('#box2').modal('show')
                var countExtra = 0
                var childAge = []
                jQuery('.dialog').each(function(gf, hf) {
                    countExtra=0;
                    childAge[gf] = '11';
                    jQuery(hf).find('.age').change(function() {
                        childAge[gf] = jQuery(hf).find('.age').val();                                
                    });       
                });

                jQuery("#box2").find(".ChildOk").click(function() {        
                    jQuery("#box2").modal('hide');
                    jQuery("#box2 .modal-body").empty();                
                    jQuery(row).find(".children-number").data("adult", countExtra)
                    jQuery(row).find(".children-number").data("childAge", childAge)
                })
            } else{
                jQuery.ajax({
                    url: 'updaterate',
                    data: {
                        adult: adult,
                        roomtype: roomtype,
                        fromDate: fromDate,
                        toDate: toDate,
                        currency: currency,
                        children: children
                    },
                    beforeSend: function() {
                        jQuery(tag).find('.row-promos').each(function(i, j) {
                            jQuery(j).find('.rate .currency-txt').empty();
                            jQuery(j).find('.loading').show();
                        })
                        jQuery("#box2").modal('hide');
                        jQuery("#box2 .modal-body").empty();
                    },
                    dataType: 'json',
                    type: "post",
                    success: function(data) {
                        jQuery(tag).find('.row-promos').each(function(i, j) {
                            jQuery(j).find('.loading').hide();
                            if(data[jQuery(j).attr('rel')][adult]){
                                var price = addCommas(data[jQuery(j).attr('rel')][adult]);
                                jQuery(j).find('.rate .currency-txt').text(price);
                            }else{
                                jQuery(j).find('.rate span').text('Contact');
                            }
                        })
                        countExtra = 0;
                        jQuery(row).find(".children-number").removeData("adult");
                        jQuery(row).find(".children-number").removeData("childAge", childAge)
                    }
                });
            }
        });
    });
}

function showTotalNight() {
    var fd = jQuery("#dpIn").find('input').val().split('-');
    var td = jQuery("#dpOut").find('input').val().split('-');
    var checkin = new Date(fd[1] + '/' + fd[0] +'/' + fd[2]);
    var checkout = new Date(td[1] + '/' + td[0] +'/' + td[2]);
    var offset = checkout.getTime() - checkin.getTime();
    var totalDays = Math.round(offset / 1000 / 60 / 60 / 24);
    return totalDays;
}
function updateAvailableRoom(room, btnAddtocart) {
    jQuery.each(room, function(index, row) {
        var available = index.split('_')[1];
        jQuery("#" + index).text(available - row)
        var wapper = jQuery(btnAddtocart).parent().parent().parent().parent().parent();
        jQuery(wapper).data('available', available - row)
        if (available - row == 0) {
            jQuery(wapper).data('available', 0)
            jQuery.each(jQuery(wapper).find('.btn-add-room'), function(k, h) {
                jQuery(h).val(langStatic()[locate][5]);
            });
        } else {
            var id = jQuery("#" + index).parent().parent().parent().parent().parent().parent().parent();
            if (jQuery(id).hasClass('request')) {
                jQuery.each(jQuery(jQuery(id).attr('rel')).find('.btn-add-room'), function(k, h) {
                    if(jQuery(h).hasClass('animation')){
                        jQuery(h).val(langStatic()[locate][11]);
                    }else{
                        jQuery(h).val(langStatic()[locate][36]);
                    }
                });
            }
        }
    })
}
function monthofyear() {
    var month = new Array(12);
    month[0] = 'Jan';
    month[1] = 'Feb';
    month[2] = 'Mar';
    month[3] = 'Apr';
    month[4] = 'May';
    month[5] = 'Jun';
    month[6] = 'Jul';
    month[7] = 'Aug';
    month[8] = 'Sep';
    month[9] = 'Oct';
    month[10] = 'Nov';
    month[11] = 'Dec';
    return month;
}
function addCommas(str) {
    var parts = (str + "").split("."),
        main = parts[0],
        len = main.length,
        output = "",
        first = main.charAt(0),
        i;

    if (first === '-') {
        main = main.slice(1);
        len = main.length;    
    } else {
        first = "";
    }
    i = len - 1;
    while(i >= 0) {
        output = main.charAt(i) + output;
        if ((len - i) % 3 === 0 && i > 0) {
            output = "," + output;
        }
        --i;
    }
    // put sign back
    output = first + output;
    // put decimal part back
    if (parts.length > 1) {
        output += "." + parts[1];
    }
    return output;
}
function flightInfo() {
    if (jQuery('#flight-info').length) {
        jQuery('#flight-info').find('.first').each(function(index, row) {
            jQuery(row).find('.from').find('.checkStatus').click(function() {
                if (jQuery(this).is(':checked')) {
                    jQuery(row).find('.fromair').show()
                } else {
                    jQuery(row).find('.fromair').hide()
                }
            })
            jQuery(row).find('.to').find('.checkStatus').click(function() {
                if (jQuery(this).is(':checked')) {
                    jQuery(row).find('.toair').show()
                } else {
                    jQuery(row).find('.toair').hide()
                }
            })
            /*date from*/
            jQuery(row).find('.from').find('.cars').change(function() {
                var car = jQuery(row).find('.from').find('.cars').val();
                var time = jQuery(row).find('.from').find('.pick-up-time').val();
                jQuery.ajax({
                    url: 'getprice_airport',
                    type: 'post',
                    data: {
                        id: car,
                        flag: time
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        jQuery(row).find('.from').find('.prices').empty();
                        jQuery(row).find('.from').find('.loading').show();
                    },
                    success: function(data) {
                        jQuery(row).find('.from').find('.prices').text(data);
                        jQuery(row).find('.from').find('.loading').hide();
                    }
                });
            });
            jQuery(row).find('.from').find('.pick-up-time').change(function() {
                var car = jQuery(row).find('.from').find('.cars').val();
                var time = jQuery(row).find('.from').find('.pick-up-time').val();
                jQuery.ajax({
                    url: 'getprice_airport',
                    type: 'post',
                    data: {
                        id: car,
                        flag: time
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        jQuery(row).find('.from').find('.prices').empty();
                        jQuery(row).find('.from').find('.loading').show();
                    },
                    success: function(data) {
                        jQuery(row).find('.from').find('.prices').text(data);
                        jQuery(row).find('.from').find('.loading').hide();
                    }
                });
            })
            /*date to*/
            jQuery(row).find('.to').find('.cars').change(function() {
                var car = jQuery(row).find('.to').find('.cars').val();
                jQuery.ajax({
                    url: 'getprice_airportto',
                    type: 'post',
                    data: {
                        id: car
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        jQuery(row).find('.to').find('.prices').empty();
                        jQuery(row).find('.to').find('.loading').show();
                    },
                    success: function(data) {
                        jQuery(row).find('.to').find('.prices').text(data);
                        jQuery(row).find('.to').find('.loading').hide();
                    }
                });
            })
            jQuery(row).find('.to').find('.pick-up-time').change(function() {
                var car = jQuery(row).find('.to').find('.cars').val();
                jQuery.ajax({
                    url: 'getprice_airportto',
                    type: 'post',
                    data: {
                        id: car
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        jQuery(row).find('.to').find('.prices').empty();
                        jQuery(row).find('.to').find('.loading').show();
                    },
                    success: function(data) {
                        jQuery(row).find('.to').find('.prices').text(data);
                        jQuery(row).find('.to').find('.loading').hide();
                    }
                });
            })
        })
    }
}
function theSameInfo() {
    if (jQuery(".sameinfo").length > 0) {
        jQuery(".sameinfo").click(function() {
            if (jQuery(this).is(":checked")) {
                jQuery(this).parent().parent().find('.first_same').val(jQuery("#PaymentForm_firstname").val());
                jQuery(this).parent().parent().find('.last_same').val(jQuery("#PaymentForm_lastname").val());
            } else {
                jQuery(this).parent().parent().find('.first_same').val("");
                jQuery(this).parent().parent().find('.last_same').val("");
            }
        })
    }
}