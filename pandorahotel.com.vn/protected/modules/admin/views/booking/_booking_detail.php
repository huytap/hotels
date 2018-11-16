 <?php 
 $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'label'=>'Hotel Name',
            'type'=>'html',
            'value'=> Hotel::model()->getNameById($model->hotel_id)
        ),
        array(
            'label'=>'Room type',
            'value'=>Roomtypes::model()->getNameById($model->roomtype_id)
        ),
        'request_date',
        /*array(
            'label'=>'Check-in out',
            'type'=>'html',
            'value'=> '<b>Check-in:</b> '.date('d M Y', strtotime($model->checkin)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Check-out:</b> '. date('d M Y', strtotime($model->checkout))
        ),*/
        array(
            'label'=>'Check-in',
            'type'=>'html',
            'value'=> date('d M Y', strtotime($model->checkin)).'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Check-out:</b> '. date('d M Y', strtotime($model->checkout))
        ),
        array(
            'label'=>'Room Nights',
            'value'=>ExtraHelper::bookNight($model->checkin, $model->checkout)
        ),
        array(
            'label'=>'No.of Rooms',
            'type'=>'html',
            'value'=> $model->no_of_room.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Adults: </b> '.$model->no_of_adults.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Children:</b> '.$model->no_of_child.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Extra bed:</b> '.$model->no_of_extrabed
        ),
        array(
            'label' => 'Promotion',
            'type'=>'html',
            'value'=> $promotion = Promotion::model()->getNameById($model->promotion_id)
        ),
        array(
            'label'=>'Total',
            'value'=> number_format($model->total_vnd,2) .' VND'
        ),
        array(
            'label'=>'Total (Rate\'s Customer Booked)',
            'value'=> number_format($model->total,2) .' '. $model->currency
        ),
        
    ),  
));?>