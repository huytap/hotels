<?php
$this->widget('booster.widgets.TbJsonGridView', array(
    'type' => 'table table-striped table-bordered table-hover dataTable',
    'id' => 'grid',
    'dataProvider' => $model->search(),
    'template' => "{items}\n{pager}",
    'htmlOptions' => array('class' => 'table table-striped table-bordered table-hover dataTable'),
    'columns' => array(
        'username',        
        'fullname',
        'cellphone',
        'email',
        array(
            'header' => 'Status',
            'type' => 'raw',
            'value' => function($data){
                return ExtraHelper::$user_status[$data->status];
            },
            'headerHtmlOptions' => array('width' => 20,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle')
        ),
        'remarks',
        array(
            'header' => 'Hành động',
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle;width:150px;'),
            'class' => 'booster.widgets.TbJsonButtonColumn',
            'template' => '{update} {delete}',
        ),
    )
));
?>