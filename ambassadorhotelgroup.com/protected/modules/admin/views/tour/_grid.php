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
        array('name'=> 'name', 'value' => function($data){
            $title = json_decode($data->name, true);
            return $title['en'];
        }),
        array('header'=> 'Photo', 'type'=>'html', 'value' => function($data){
            return '<img src="'.Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/cover/'. $data['cover_photo'].'&h=100&w=100" alt="">';
        }),
        array('name'=> 'short_description', 'type'=>'html', 'value' => function($data){
            $title = json_decode($data->short_description, true);
            return $title['en'];
        }),
        array(
            'name'=>'status',
            'header' => 'Status',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => 'ExtraHelper::$status[$data->status]',
            'filter' => CHtml::dropDownlist('Tour[status]', '', array(''=>'All')+ExtraHelper::$status, array('class'=>' form-control'))
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