<?php
$this->widget('booster.widgets.TbJsonGridView', array(
    'type' => 'table table-bordered table-condensed table-hover table-striped',
    'id' => 'grid',
    'dataProvider' => $model->search(),
    'htmlOptions' => array('class' => 'table table-bordered table-condensed table-hover table-striped'),
    'filter' => $model,
    'enableSorting' => false,
    'columns' => array(
        array('name'=> 'name', 'value' => function($data){
            $title = json_decode($data->name, true);
            return $title['en'];
        }),
        array('header' => 'Category', 'value' => function($data){
            return $d['spa'][$data->name];
            },
            'filter' => CHtml::dropDownlist('Itemspa[category_spa]', '', array(''=>'All')+Categoryspa::model()->getList(), array('class'=>'form-control'))
        ),
        'display_order',
        array(
            'name'=>'status',
            'header' => 'Status',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => 'ExtraHelper::$status[$data->status]',
            'filter' => CHtml::dropDownlist('Itemspa[status]', '', array(''=>'All')+ExtraHelper::$status, array('class'=>' form-control'))
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