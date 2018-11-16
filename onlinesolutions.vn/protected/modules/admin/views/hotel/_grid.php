<?php
$this->widget('booster.widgets.TbJsonGridView', array(
    'type' => 'table table-bordered table-condensed table-hover table-striped',
    'id' => 'grid',
    'dataProvider' => $model->search(),
    'template' => "{items}\n{pager}",
    'htmlOptions' => array('class' => 'table table-bordered table-condensed table-hover table-striped'),
    'filter' => $model,
    'enableSorting' => false,
    'columns' => array(
        'name',
        'chain_id',
        'hotel_id',
        'graded_star',
        'email_info',
        'email_sales',
        array(
            'name'=>'status',
            'header' => 'Status',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => 'ExtraHelper::$status[$data->status]',
            'filter' => CHtml::dropDownlist('Hotel[status]', '', array(''=>'All')+ExtraHelper::$status, array('class'=>' form-control'))
        ), 
        array(
            'header' => 'Action',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle;width:80px;'),
            'class' => 'booster.widgets.TbJsonButtonColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => array(
                    'update' => array(
                        'url' => 'Yii::app()->createUrl("admin/hotel/update", array("hotelid" => $data->hotel_id, "chainid" => $data->chain_id))',
                        'options'=>array(), //HTML options for the button tag.
                    ),
                    'view' => array(
                        'url' => 'Yii::app()->baseUrl."/booking/".$data->hotel_id."/".$data->chain_id',
                        'options'=>array('target' => '_blank'), //HTML options for the button tag.
                    )
            )
        ),
    )
));
?>