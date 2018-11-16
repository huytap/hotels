<?php
$this->breadcrumbs = array(
    'Booking'=>array('booking/admin'),
    'View'
);?>
<div class="padding-md">
<a class="btn btn-app btn-light btn-mini" onclick="PrintMe('booking_page')">
    <i class="icon-print bigger-160"></i>
    Print
</a>
<div id="booking_page">
    <?php 
    if(strtotime(date('d-m-Y', strtotime($model->request_date)))>=strtotime(date('23-06-2017'))){
        $cards = ExtraHelper::unzipCode($model->code);
        $card = explode('&', $cards);
    }else{
        $card[1] = base64_decode($mode->code);
        $card[3] = '';
    }
     $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            array('name' => 'hotel_id', 'value' => $model['hotel']['name']),
        	array('name' => 'short_id', 'header' => 'Reservation number', 'value' => strtoupper($model->short_id)),
            array(
                'label'=>'Attention to',
                'type'=>'html',
                'value'=> $model->first_name.' '. $model->last_name
            ),
            array(
                'name' => 'email', 
                'header'=>'Contact Email',
                'value'=>$model->email
            ),
            array(
                'name' => 'phone',
                'header' => 'Tel',
                'value' => $model->phone
            ),
            array('name' => 'country', 'header' => 'Country', 'value' => $model->country),
            'request_date',
            /*array(
                'label'=>'Check-in out',
                'type'=>'html',
                'value'=> '<b>Check-in:</b> '.date('d M Y', strtotime($model->checkin)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Check-out:</b> '. date('d M Y', strtotime($model->checkout))
            ),*/
            'status',
            /*array(
                'label'=>'Total VND',
                'value'=> number_format($model->total_vnd,2) .' VND'
            ),
            array(
                'label'=>'Total (Rate\'s Customer Booked)',
                'value'=> number_format($model->total,2) .' '. $model->currency
            ),*/
            'notes',
            array(
                'label'=>'Card type',
                'type'=>'html',
                'value'=> '<b>Card type:</b> '.$model->card_type .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Name on card:</b>'. $model->card_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Card Expired:</b>'. $model->card_expired.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>CVV Card:</b>'. $card[3]
            ),
            array(
                'label' => 'Card Number',
                'type'=>'raw',
                'value' => $card[1]
            ),
            /*array(
                'label' => 'Confirm CC',
                'type'=>'raw',
                'value' => function($data){
                    if(!$data['confirm_cvv'] && 
                    ($data['status'] == 'amended' || $data['status'] == 'confirmed')){
                        return '<button onclick="confirmCvv(\''.$data["short_id"].'\')" class="btn btn-primary" type="button">Confirm CC</button>';
                    }elseif($data['confirm_cvv'] == 1){
                        return '<button class="btn disabled" type="button">Confirmed</button>';
                    }
                }
                    //'<input id="confirmcvv" class="btn btn-primary" type="button" value="Confirm">'
            ),*/
            array(
                'label' => 'Email Sent Booking Confirmation',
                'type'=>'raw',
                'value' => function($data){
                    if(!$data->sent_mail){
                        return 'No';
                    }else{
                        return 'Yes';
                    }
                }
            ),
        ),  
    ));?>
    <div class="row-fluid sortable">        
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="fa-icon-sitemap"></i><span class="break"></span>Booking Detail</h2>
                <div class="box-icon">
                    <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
                </div>
            </div>
            <div class="">
                <table class="table table-striped table-bordered bootstrap-datatable">
                    <thead>
                        <tr>
                            <th>Roomtype</th>
                            <th>Number of rooms</th>
                            <th>Max adult(s) per room</th>
                            <th>Max child(ren) per room</th>
                            <th>Max extra bed(s) per room</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Price (VND)</th>
                        </tr>
                    </thead>   
                    <tbody>
                        <tr>
                            <?php

                            $extra_bed_rate=$model['extrabed_price']*$model['no_of_extrabed']*$model['booked_nights'];
                            $total = $extra_bed_rate + ($model['rate_vnd']*$model['no_of_room']*$model['booked_nights']);
                            ?>
                            <td><?php echo $model['roomtype']['name']?></td>
                            <td><?php echo $model['no_of_room']?></td>
                            <td><?php echo $model['no_of_adults']?></td>
                            <td><?php echo $model['no_of_child'];?></td>
                            <td><?php echo $model['no_of_extrabed'].' '.number_format($model['extrabed_price'],2);?></td>
                            <td><?php echo date('d M Y',strtotime($model['checkin']));?></td>
                            <td><?php echo date('d M Y',strtotime($model['checkout']));?></td>
                            <td><?php echo number_format(ExtraHelper::roundMoney2('VND', $model['rate_vnd']*$model['booked_nights']*$model['no_of_room']),2);?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Rate inclusion</td>
                            <td colspan="6">
                                <?php 
                                    $promotion = json_decode($model['promotion']['name'], true);
                                    echo '<strong>'.$promotion['en'].'</strong>';
                                ?>
                                <p>- <?php echo Yii::t('lang', $model->promotion->cancel_1);?></p>
                                <?php if($model->promotion->cancel_2 !== 'nosecondrule'){
                                    echo '<p>- '.Yii::t('lang', $model->promotion->cancel_2).'</p>';
                                }
                                if($model->promotion->cancel_3 !== 'nothirdrule'){
                                    echo '<p>- '.Yii::t('lang', $model->promotion->cancel_3).'</p>';
                                }?>
                            </td>
                        </tr>
                        <?php
                        $pickup=$model['pickup_flight'].' - '.$model['pickup_time'].' '.$model['pickup_date'];
                        if($model->pickup_price == 0 && $model['pickup_flight'] && $model['pickup_time'] && $model['pickup_date']){
                            $model['pickup_price'] = 'Free';
                        }elseif($model->pickup_price>0){
                            $total += $model['pickup_price'];
                            $model['pickup_price'] = number_format($model['pickup_price'], 2);
                        }else{
                            $model['pickup_price'] = '';
                        }

                        $dropoff=$model['dropoff_flight'].' - '.$model['dropoff_time'].' '.($model['dropoff_date']!='0000-00-00'?$model['dropoff_date']:'');
                        
                        if($model->dropoff_price == 0 && $model['dropoff_flight'] && $model['dropoff_time'] && $model['dropoff_date']){
                            $model['dropoff_price'] = 'Free';
                        }elseif($model->dropoff_price>0){
                            $total += $model['dropoff_price'];
                            $model['dropoff_price'] = ($model['dropoff_price']>0?number_format($model['dropoff_price'], 2):'');
                        }else{
                            $model['dropoff_price']='';
                        }

                        if($model['pickup_price'] && $model['dropoff_price']){
                            $row = 2;
                        }else{
                            $row = 1;
                        }
                        if($model['pickup_price'] || 
                            $model['dropoff_price']){
                        ?>
                        <tr>
                            <td rowspan="<?php echo $row?>" colspan="2" align="left" valign="middle">
                                Airport Transfer
                            </td>
                            <?php if($model['pickup_price']){?>
                            <td align="left" colspan="3">
                                Airport Pick-up
                            </td>
                            <td align="left" valign="middle" colspan="2">
                                <?php echo $pickup;?>
                            </td>
                            <td align="left" colspan="2">
                                <?php echo $model['pickup_price']?>
                            </td>
                            <?php }?>
                        </tr>
                        <?php if($model['dropoff_price']){?>
                        <tr>
                            <td align="left" colspan="3" valign="middle">
                                Airport Drop-off
                            </td>
                            <td align="left" colspan="2">
                                <?php echo $dropoff?>
                            </td>
                            <td align="left" colspan="2">
                                <?php echo $model['dropoff_price']?>
                            </td>
                        </tr>
                        <?php }?>
                        <?php }

                        $packages = BookPackage::model()->getList($model['id']);
                        $sum_packages = count($packages->getData());
                        
                        if($sum_packages>0){

                            foreach($packages->getData() as $pkey => $pk){
                                if($pkey==0){?>
                                    <tr>
                                        <td rowspan="<?php echo $sum_packages?>" colspan="2" align="left" valign="middle">
                                            Packages
                                        </td>
                                        <td colspan="3" align="left" valign="middle">
                                            <strong><?php echo $pk->package->name?></strong>
                                        </td>
                                        <td colspan="2" align="left" valign="middle">
                                            <?php echo $pk->adult.' adult(s), '. $pk->child.' child(ren)';?>
                                        </td>
                                        <td colspan="2" align="left" valign="middle">
                                            <?php
                                            if($pk['adult'] == 0){
                                                echo 'Free';
                                            }else{
                                                $total_p = ($pk->package->rate*$pk->adult+$pk->package->rate_child*$pk->child)*$pk->exchange_rate*$model['booked_nights'];
                                                $total += $total_p;
                                                echo number_format(ExtraHelper::roundMoney2('VND', $total_p), 2);
                                            }?>
                                        </td>
                                    </tr>
                                <?php
                                }else{?>
                                    <tr>
                                        <td colspan="3" align="left" valign="middle">
                                            <strong><?php echo $pk->package->name?></strong>
                                        </td>
                                        <td colspan="2" align="left" valign="middle">
                                            <?php echo $pk->adult.' adult(s), '. $pk->child.' child(ren)';?>
                                        </td>
                                        <td colspan="2" align="left" valign="middle">
                                        <?php
                                        if($pk['adult'] == 0){
                                            echo 'Free';
                                        }else{
                                            $total_p = ($pk->package->rate*$pk->adult+$pk->package->rate_child*$pk->child)*$pk->exchange_rate*$model['booked_nights'];
                                            echo number_format(ExtraHelper::roundMoney2('VND', $total_p), 2);
                                            $total += $total_p;
                                        }?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            
                        }
                        ?>
                        <tr>
                            <td align="right" colspan="7" valign="middle">
                                <strong>Total to be paid in VND<br></strong>
                                (include 10% VAT & 5% Service Charge Rate): 
                            </td>
                            <td align="left" colspan="2" valign="middle">
                            <?php 
                            $vat = $total*10/100;
                            $sc = ($vat+$total)*5/100;
                            echo number_format(ExtraHelper::roundMoney2('VND', $total + $vat + $sc), 2);?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php

        //if($model['status'] !== 'cancel' && $model['status'] !== 'failed' && $model['checkin']>date('Y-m-d')){
            ?>
            <!-- <div class="cancel">
            <h3>Cancel this booking (#<?php //echo strtoupper($model['short_id'])?>)?</h3>
            <div class="col-md-6">
                <label>Reason:</label>
                <input type="text" id="reason" class="form-control"> 
            </div>
            <div class="col-md-3" style="margin-top: 20px;"><label class="label-checkbox inline"><input type="checkbox"><span class="custom-checkbox"></span>Send email to customer?</label></div>
            <div class="col-md-3" style="margin-top: 20px;"><a href="javascript:void(0)" class="btn btn-danger" onclick="cancel('<?php echo $model->id?>')">Cancel</a></div>
            </div> -->
        <?php
       // }?>
</div>
</div>

<script type="text/javascript">
    function PrintMe(el){
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
    }
</script>
<script type="text/javascript">
    function cancel(id){
        var ask = confirm('Are you sure you want to delete booking ID <?php echo strtoupper($model->short_id);?>?');
        if(ask == true){
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("admin/booking/cancel");?>',
                type: 'post',
                dataType: 'json',
                data:{id:id,cancel_reason:$('#reason').val()},
                success:function(data){
                    if(data !== 0){
                        //$('#BookingStatus').html(data);
                        alert('Booking is cancelled');
                        location.reload()
                    }else{
                        alert('You can not cancel this booking')
                    }
                }
            })
        }
    }
</script>
<script type="text/javascript">
    function confirmCvv(id){
        if(id){
            $.ajax({
                url:'<?php echo Yii::app()->createAbsoluteUrl("admin/ajax/confirmcvv")?>',
                type:'post',
                data:{bookingid: id},
                dataType: 'json',
                beforeSend: function(){
                    $('#loading').show();
                },
                success: function(data){
                    if(data==1){
                        alert('Confirm!!!');
                        $('#loading').hide();
                        $('#confirmcvv').removeClass('btn-primary');
                        $('#confirmcvv').addClass('disabled');
                    }
                }
            });
        }
    }
</script>
<script type="text/javascript">
    function resendEmail(){
        $.ajax({
            url: '<?php echo Yii::app()->params["booking"]."/booking/thankyou.html?short_id=".$model["short_id"]?>',
            data:{flag:'sentmail', slug:'<?php echo $model["hotel_id"]?>'},
            type: 'get',
            async:false,
            beforeSend:function(){
                $('#loading').show();
            },
            success:function(data){
                //$('#loading').hide();
                //location.reload();
            }
        });
    }
</script> 