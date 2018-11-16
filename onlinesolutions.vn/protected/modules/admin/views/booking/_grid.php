<?php

$this->widget('booster.widgets.TbExtendedGridView', array(
    'filter'=>$model,
    //'fixedHeader' => true,
    'type' => 'striped bordered',
    'dataProvider' => $model->search($filter),
    'template' => "{summary}\n{pager}\n{items}\n{pager}\n{summary}\n{extendedSummary}",
    'enableSorting' => false,
    //'responsiveTable' => true,
    'columns' => array(
        array(
            'name' => 'short_id',
            'header' => '#BookingID',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle;text-decoration: underline;'),
            'value' => function($data){
                $span='';
                if($data->view==0){
                    $span='<span class="new">new</span>';
                }
                return '<a href="'.Yii::app()->createUrl("admin/booking/view",array("id"=>$data->id)).'">'.$span.strtoupper($data->short_id).'</a>';
            }
        ),
        array(
            'name' => 'first_name',
            'header' => 'First Name',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;', 'class'=>'hidden-xs'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle', 'class'=>'hidden-xs')
        ),
        array(
            'name' => 'last_name',
            'header' => 'Last Name',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;', 'class'=>'hidden-xs'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle', 'class'=>'hidden-xs')
        ),
	array(
            'name' => 'email',
            'header' => 'Email',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;', 'class'=>'hidden-xs'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle', 'class'=>'hidden-xs')
        ),
        array(
            'name' => 'request_date',
            'header' => 'Request Date',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;', 'class'=>'hidden-xs'),
            'htmlOptions' => array('width' => 100,'style' => 'text-align:center;vertical-align:middle', 'class'=>'hidden-xs'),
            'value' => function($data){
                return ExtraHelper::time_2_show($data->request_date);
            },
            //'filter'=>CHtml::activeTextField($model,'request_date', array('class'=>'datepicker form-control'))
            'filter' => false
        ),
        array(
            'name' => 'checkin',
            'header' => 'Check-in',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle'),
            'value' => function($data){
                return date('d M Y', strtotime($data['checkin']));
            },
            //'filter'=>CHtml::activeTextField($model,'checkin', array('class'=>'datepicker form-control'))
            'filter' => false
        ),
        array(
            'name' => 'checkout',
            'header' => 'Check-out',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle'),
            'value' => function($data){
                return date('d M Y', strtotime($data['checkout']));
            },

            //'filter'=>CHtml::activeTextField($model,'checkout', array('class'=>'datepicker form-control'))
            'filter' => false
        ),
         array(
            'name'=>'country',
            'header' => 'Country',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;width:100px', 'class'=>'hidden-xs'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order', 'class'=>'hidden-xs'),
            'value' => '$data->country',
            'footer'=>'<b>Total Revenue</b>',
            'filter' => CHtml::dropDownlist('Bookings[country_code]', '', array(''=>'All')+ExtraHelper::$country, array('class'=>' form-control'))
        ),
        array(
            'name' => 'rate',
            'header' => 'Revenue',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:right;vertical-align:middle','class'=>'revenue'),
            'value' =>  function($data){
                $total = ($data['rate_vnd']*$data['no_of_room'] + $data['no_of_extrabed']*$data['extrabed_price'])*$data['booked_nights'];
                if($data->pickup_price == 0 && 
                    isset($data['pickup_flight']) && 
                    $data['pickup_flight'] && isset($data['pickup_time']) && 
                    $data['pickup_time'] && isset($data['pickup_date']) && 
                    $data['pickup_date']){
                    
                }elseif($data['pickup_price']>0){
                    $total += $data['pickup_price'];
                }

                if($data->dropoff_price == 0 && isset($data['dropoff_flight']) && 
                    $data['dropoff_flight'] && isset($data['dropoff_date']) && 
                    $data['dropoff_date'] && isset($data['dropoff_time']) && 
                    $data['dropoff_time']){
                }elseif($data['dropoff_price']>0){
                    $total += $data['dropoff_price'];
                }
                $vat = $sc = 0;
                $vat_setting = Settings::model()->getSetting('include_vat', $data['hotel_id']);
                if($vat_setting == 'false'){
                    $vat = $sub_total*10/100;
                    $sc= ($sub_total+$vat)*5/100;
                }
                /*$vat += ($sub_total)*0.1;
                $sc += ($vat + $sub_total)*0.05;*/
                $sub = $total+$sc+$vat;

                /*$vat = $total*10/100;
                $sc= ($total+$vat)*5/100;
                $sub = $total+$vat+$sc;*/
                //$total = $total*1.155;
                $date = date('Y-m-d', strtotime($data->request_date));
                $exchangeRate = (array)ExchangeRate::model()->convertCurrencyToUSD2('USD',$date);
                $total = $sub/$exchangeRate['sell'];
                if($data->status == 'cancelled'){
                    return 0;
                }else{
                    return number_format($total,2);
                }
            },
            'filter' => false,
            'class'=>'booster.widgets.TbTotalSumColumn'
        ),
        array(
            'name'=>'status',
            'header' => 'Status',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px', 'class'=>'hidden-xs'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order', 'class'=>'hidden-xs'),
            'value' => function($data){
                if($data->status == 'confirmed'){
                    return '<span class="btn btn-default btn-xs" style="background:#3366cc;color:#fff;">Confirmed</span>';
                }elseif($data->status == 'amended'){
                    return '<span class="btn btn-default btn-xs" style="background:#ff9900;color:#fff;">Amended</span>';
                }else{
                    return '<span class="btn btn-default btn-xs" style="background:#dc3912;color:#fff;">Cancelled</span>';
                }
            },
            'filter' => CHtml::dropDownlist('Bookings[status]', '', array(''=>'All')+ExtraHelper::$bookingStatus, array('class'=>' form-control'))
        ),
        /*array(
            'name'=>'version',
            'header' => 'Version',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => '$data->version',
            'filter' => CHtml::dropDownlist('Bookings[version]', '', array(''=>'All','desktop'=>'Desktop','mobile'=>'Mobile'), array('class'=>' form-control'))
        ),*/
        array(
            'header' => 'Action',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle;width:80px;'),
            'class' => 'booster.widgets.TbButtonColumn',
            'template' => '{view} {delete}'
        ),
        
    ),
    'extendedSummary' => array(
        'title' => 'Summary',
        'displaySummary' => array('value' => 'rate', 'label' => 'USD'),
        'columns' => array(
            //'rate' => array('label'=>'Total Revenue (USD)', 'class'=>'TbSumOperation'),

            'status' => array(
                'label'=>'Total Expertise',
                'types' => array(
                    'Confirmed'=>array('label'=>'Confirmed'),
                    'Cancelled'=>array('label'=>'Cancelled'),
                    'Amended'=>array('label'=>'Amended')
                ),
                'class'=>'TbPercentOfTypeGooglePieOperation',
                'chartOptions' => array(
                    'barColor' => '#333',
                    'trackColor' => '#999',
                    'lineWidth' => 8 ,
                    'lineCap' => 'square'
                )
            )
        )
    ),
    'extendedSummaryOptions' => array(
        'class' => 'well pull-right',
        'style' => 'width:450px'
    ),
));