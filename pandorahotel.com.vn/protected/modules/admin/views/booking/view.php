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
     $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            array('name' => 'hotel_id', 'value' => $model['hotel']['name']),
        	array('name' => 'short_id', 'value' => strtoupper($model->short_id)),
            array(
                'label'=>'Guest Info',
                'type'=>'html',
                'value'=> $model->first_name.' '. $model->last_name .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Email:</b> '.$model->email.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Phone:</b> '.$model->phone.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Country:</b> '.$model->country
            ),
            'request_date',
            /*array(
                'label'=>'Check-in out',
                'type'=>'html',
                'value'=> '<b>Check-in:</b> '.date('d M Y', strtotime($model->checkin)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Check-out:</b> '. date('d M Y', strtotime($model->checkout))
            ),*/
            'status',
            array(
                'label'=>'Total VND',
                'value'=> number_format($model->total_vnd,2) .' VND'
            ),
            array(
                'label'=>'Total (Rate\'s Customer Booked)',
                'value'=> number_format($model->total,2) .' '. $model->currency
            ),
            'notes',
            array(
                'label'=>'Card Info',
                'type'=>'html',
                'value'=> '<b>Card type:</b> '.$model->card_type .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Name on card:</b>'. $model->card_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Card Expired:</b>'. $model->card_expired.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>CVV Card:</b>'. $model->card_cvv
            ),
            array(
                'label' => 'Card Number',
                'type'=>'raw',
                'value' => base64_decode($model->code)
            )
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
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Nights</th>
                            <th>Roomtype</th>
                            <th>Promotion</th>
                            <th>No. Rooms</th>
                            <th>No. Adults</th>
                            <th>No. Children</th>
                           <!--  <th>No.extra bed</th>
                            <th>Extra bed per room per night</th> -->
                            <th>Rate per room per night</th>
                        </tr>
                    </thead>   
                    <tbody>
                        <tr>
                            <?php
                            $extra_bed_rate=$model['extrabed_price'];?>
                            <td><?php echo date('d M Y',strtotime($model['checkin']));?></td>
                            <td><?php echo date('d M Y',strtotime($model['checkout']));?></td>
                            <td><?php echo $model['booked_nights']?></td>
                            <td><?php echo $model['roomtype']['name']?></td>
                            <td>
                                <?php 
                                    $promotion = json_decode($model['promotion']['name'], true);

                                    echo $promotion['en'];
                                ?>
                            </td>
                            <td><?php echo $model['no_of_room']?></td>
                            <td><?php echo $model['no_of_adults']?></td>
                            <!-- <td><?php //echo $model['no_of_extrabed']?></td>
                            <td><?php //echo number_format($model['extrabed_price'],2);?></td> -->
                            <td><?php echo $model['no_of_child'];?></td>
                            <td><?php echo number_format($model['rate_vnd'],2)?></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <?php 
                                if($model['pickup_price'] > 0){
                                    echo '<p><b>Airport pickup:</b> '. $model['pickup_flight'].' '. $model['pickup_time'].' '.ExtraHelper::date_2_show($model['pickup_date']).' - '.number_format($model['pickup_price'],2) .'</p>';
                                }?>
                            </td>
                            <td colspan="5">
                                    <?php 
                                    if($model['dropoff_price'] > 0){
                                        echo '<p><b>'.Yii::t('lang', 'airport_drop_off').':</b> '. $model['dropoff_flight'].' '. $model['dropoff_time'].' '.ExtraHelper::date_2_show($model['dropoff_date']).' - '.number_format($model['dropoff_price'],2).'</p>';
                                    }?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align:right;">
                                
                                <p><strong>Grand total: VND <?php echo number_format($model['total_vnd'],2);?></strong></p>
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