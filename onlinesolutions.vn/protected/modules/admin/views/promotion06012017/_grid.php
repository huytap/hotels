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
        array(
            'header' => '#',
            'type' => 'raw',
            'value' => '$row+1',
            'headerHtmlOptions' => array('width' => 20,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle')
        ),
        array(
            'name' => 'name',
            'header' => 'Name',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 100,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle','class' => 'main_name'),
            'value' => function($data){
                $name = json_decode($data->name, true);
                return $name['en'];
            }
        ),
        array(
            'name' => 'name',
            'header' => 'Check in',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle'),
            'value' => function($data){
                return date('d-m-Y', strtotime($data->from_date));
            }
        ),
        array(
            'name' => 'name',
            'header' => 'Check out',
            'type' => 'raw',
            'filter' => false,
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle'),
            'value' => function($data){
                return date('d-m-Y', strtotime($data->to_date));
            }
        ),
        array(
            'header' => 'Roomtypes',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 120,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => function($data){
                $roomtypes = Roomtype::model()->getRoomtypeById($data->roomtypes);
                $i=0;
                $rt_html = '';
                foreach ($roomtypes as $key => $value) {
                    $rt_html .= $value['name'];
                    if($i < count($roomtypes) - 1){
                        $rt_html .= ',';
                    }
                    $i++;
                }
                return $rt_html;
            }
        ), 
        array(
            'header' => 'Type',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => function($data){
                $type = Yii::app()->params['promotion_type'];
                return $type[$data->type];
            }
        ),  
        array(
            'header' => 'Cancellation',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 280,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => function($data){
                $cacncel_config = Yii::app()->params['cancellation_configs'];
                $cancel = '- ' .$cacncel_config['cancel1'][$data->cancel_1];
                if($data->cancel_2 !== 'nosecondrule'){
                    $cancel .= '<br>- '.$cacncel_config['cancel2'][$data->cancel_2];
                }
                if($data->cancel_3 !== 'nothirdrule'){
                    $cancel .= '<br>- '.$cacncel_config['cancel3'][$data->cancel_3];
                }
                return $cancel;
            },
        ),      
        array(
            'name'=>'status',
            'header' => 'Status',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle','class'=>'order'),
            'value' => 'ExtraHelper::$status[$data->status]',
        ), 
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