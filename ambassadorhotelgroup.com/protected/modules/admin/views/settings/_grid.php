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
        array('name' => 's_key',
            'type' => 'raw',
            'value' => function($data){
                return '<a href="'.Yii::app()->createUrl('admin/settings/update', array('id' => $data->id)).'">'.$data->s_key.'</a>';
            }
        ),
        /*array('name' =>'s_value', 'type'=>'raw', 'value' => '$data->s_value', 
            'htmlOptions' => array('style' => 'width:200px!important;'),
            'headerHtmlOptions' => array('width' => 280, 'style' => 'width:200px!important;'),
        ),*/
        'remarks',
        array(
            'header' => 'Actions',
            'headerHtmlOptions' => array('width' => 280,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle;width:80px;'),
            'class' => 'booster.widgets.TbJsonButtonColumn',
            'template' => '{update} {delete}'
        ),
    )
));
?>