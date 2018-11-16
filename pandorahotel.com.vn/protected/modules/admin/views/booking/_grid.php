<?php
$this->widget('booster.widgets.TbJsonGridView', array(
    'type' => 'table table-bordered table-condensed table-hover table-striped',
    'id' => 'grid',
    'dataProvider' => $model->search($filter),
    'template' => "{items}\n{pager}",
    'htmlOptions' => array('class' => 'table table-bordered table-condensed table-hover table-striped'),
    'filter' => $model,
    'enableSorting' => false,
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
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle'),
            'value' => '$data->first_name'
        ),
        array(
            'name' => 'last_name',
            'header' => 'Last Name',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle'),
            'value' => '$data->last_name'
        ),
        array(
            'name' => 'request_date',
            'header' => 'Request Date',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;'),
            'htmlOptions' => array('width' => 100,'style' => 'text-align:center;vertical-align:middle'),
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
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => '$data->country',
            'filter' => CHtml::dropDownlist('Bookings[country_code]', '', array(''=>'All')+ExtraHelper::$country, array('class'=>' form-control'))
        ),
        array(
            'header' => 'Booking Value (USD)',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 120,'style' => 'text-align:center;width:120px'),
            'htmlOptions' => array('style' => 'text-align:right;vertical-align:middle','class'=>'order'),
            'value' =>  function($data){
                $total = $data->total/$data['change_currency_rate'];                
                return number_format($total,2);
            },
            'filter' => false
        ),
        array(
            'name'=>'status',
            'header' => 'Status',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => '$data->status',
            'filter' => CHtml::dropDownlist('Bookings[status]', '', array(''=>'All')+ExtraHelper::$bookingStatus, array('class'=>' form-control'))
        ),
        array(
            'name'=>'version',
            'header' => 'Version',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => '$data->version',
            'filter' => CHtml::dropDownlist('Bookings[version]', '', array(''=>'All','desktop'=>'Desktop','mobile'=>'Mobile'), array('class'=>' form-control'))
        ),
        array(
            'header' => 'Action',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle;width:80px;'),
            'class' => 'booster.widgets.TbJsonButtonColumn',
            'template' => '{view} {delete}'
        ),
    )
));
?>