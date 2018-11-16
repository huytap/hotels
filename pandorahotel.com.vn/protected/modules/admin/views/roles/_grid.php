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
        'role_name',
        array(
            'name' => 'name',
            'header' => 'Module',
            'type' => 'raw',
            'filter' => false,
            'headerHtmlOptions' => array('text-align:left;'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle'),
            'value' => function($data){
                return $data->showRight();
            }
        ),
        array(
            'header' => 'Actions',
            'headerHtmlOptions' => array('width' => 280,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle;width:80px;'),
            'class' => 'booster.widgets.TbJsonButtonColumn',
            'template' => '{view} {update} {delete}'
        ),
    )
));
?>