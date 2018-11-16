<?php
$this->widget('booster.widgets.TbJsonGridView', array(
    'type' => 'table table-bordered table-condensed table-hover table-striped',
    'id' => 'grid',
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'table table-bordered table-condensed table-hover table-striped'),
    'filter' => $model,
    'enableSorting' => false,
    'columns' => array(
        array('header'=> 'Photo', 'type'=>'html', 'value' => function($data){
            return '<img src="'.Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/cover/'. $data['cover_photo'].'&h=100&w=100" alt="">';
        }),
        array('name'=> 'title', 'value' => function($data){
            $title = json_decode($data->title, true);
            return $title['en'];
        }),
        array('header' => 'Type', 'value' => function($data){
            $d = Yii::app()->params['special'];
            return $d[$data->type];
            },
            'filter' => CHtml::dropDownlist('Offer[type]', '', array(''=>'All')+Yii::app()->params['special'], array('class'=>'form-control'))
        ),
        'display_order',
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
            'template' => '{update} {delete}'
        ),
    )
));
?>