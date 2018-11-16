<?php
$this->widget('booster.widgets.TbJsonGridView', array(
    'type' => 'table table-bordered table-condensed table-hover table-striped',
    'id' => 'grid',
    'dataProvider' => $model->search($gallery['id']),
    'template' => "{items}\n{pager}",
    'htmlOptions' => array('class' => 'dataTables_wrapper'),
    'json' => true,
    'enableSorting' => false,
    'columns' => array(
        array(
            'header' => '#',
            'type' => 'raw',
            'value' => '$row+1',
            'headerHtmlOptions' => array('width' => 20,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle')
        ),
        'description',
        array(
            'name' => 'name',
            'header' => '',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 300,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle','class' => 'main_name'),
            'value' => function($data){
                return '<img src="'.Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/slide/'.$data['name'].'&h=90&w=200">';
            }
        ),
        'display_order',
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