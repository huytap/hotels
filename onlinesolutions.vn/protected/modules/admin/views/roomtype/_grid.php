<?php
$this->widget('booster.widgets.TbJsonGridView', array(
    'type' => 'table table-bordered table-condensed table-hover table-striped',
    'id' => 'grid',
    'dataProvider' => $model->search(),
    'template' => "{items}\n{pager}",
    'htmlOptions' => array('class' => 'dataTables_wrapper'),
    'json' => true,
    'enableSorting' => false,
    'columns' => array(
        /*array(
            'name' => 'cover_photo',
            'type' => 'raw',
            'value' => function($data){
                if($data->cover_photo){
                    return '<img src="'.Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/cover/'.$data->cover_photo.'&h=100">';
                }else{
                    return '';
                }
            }
        ),*/
        'name',
        'size_of_room',
        'max_per_room',
        'no_of_adult',
        'no_of_child',
        array(
            'name'=>'status',
            'header' => 'Status',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => 'ExtraHelper::$status[$data->status]'
        ),  
        array(
            'header' => 'Action',
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle;width:150px;'),
            'class' => 'booster.widgets.TbJsonButtonColumn',
            'template' => '{update} {delete}'
        ),
    )
));
?>