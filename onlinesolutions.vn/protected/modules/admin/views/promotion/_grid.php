<?php
$this->widget('booster.widgets.TbJsonGridView', array(
    'type' => 'table table-bordered table-condensed table-hover table-striped',
    'id' => 'grid',
    'dataProvider' => $model->search(),
    'template' => "{items}\n{pager}",
    'htmlOptions' => array('class' => 'dataTables_wrapper'),
    'json' => true,
    'filter' => $model,
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
        	'name' => 'promotion_type',
            'header' => 'Type',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => function($data){
                $type = Yii::app()->params['promotion_type'];
                return $type[$data->type];
            },
            'filter' => CHtml::dropDownlist('Promotion[promotion_type]', '', array(''=>'All')+Yii::app()->params['promotion_type'], array('class'=>' form-control'))
        ),  
        array(
           // 'name' => 'name',
            'header' => 'Check in',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 80,'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle'),
            'value' => function($data){
                return date('d-m-Y', strtotime($data->from_date));
            },
            'filter' => false,
        ),
        array(
            //'name' => 'name',
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
            'header' => 'Discount',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 280,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => function($data){
            	if($data->apply_on == 'every_night'){
	            	if($data->discount_type == 'percent_per_night'){
	            		return $data->discount.'% per night';
	            	}elseif($data->discount_type == 'amount_per_night'){
	            		return $data->discount .'$ per night';
	            	}
	            }elseif($data->apply_on == 'specific_day_of_week'){
	            	$week='';
	            	if($data->discount_type == 'percent_per_night'){
	            		$spe = json_decode($data->specific_day_of_week, true);
	            		foreach($spe as $key => $s){
	            			$week .= $key.': '.$s.'%<br>';
	            		}
	            		return $week;
	            	}elseif($data->discount_type == 'amount_per_night'){
	            		$spe = json_decode($data->specific_day_of_week, true);
	            		foreach($spe as $key => $s){
	            			$week .= $key.': '.$s.'$<br>';
	            		}
	            		return $week;
	            	}
	            }
            }
        ),
		array(
            'header' => 'Benefit',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 280,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => function($data){
            	$html ='';
            	if($data->breakfast){
            		$html .= 'Free Breakfast<br>';
            	}
            	if($data->pickup){
            		$html .= 'Free Pick-up<br>';
            	}
            	if($data->dropoff){
            		$html .= 'Free Drop-off';
            	}
            	return $html;
            }
        ),
        array(
            'header' => 'Min Stay',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 60,'style' => 'text-align:center;width:60px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => '$data->min_stay'
        ),
		array(
            'header' => 'Condition',
            'type' => 'raw',
            'headerHtmlOptions' => array('width' => 280,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:left;vertical-align:middle','class'=>'order'),
            'value' => function($data){
            	if($data->type == 'others'){
            		return 'n/a';
            	}elseif($data->type == 'early_bird'){
            		return 'Before check-in date '. $data->no_of_day .' days';
            	}
            }
        ),
		array(
            'header' => 'Room types',
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
            'value' => function($data){
                if($data->status==1)
                    return '<span class="btn btn-default btn-xs" data-id="'.$data->id.'" style="background:#dc3912;color:#fff;">'.ExtraHelper::$status[$data->status].'</span>';
                else
                    return '<span class="btn btn-default btn-xs" data-id="'.$data->id.'" style="background:#3366cc;color:#fff;">'.ExtraHelper::$status[$data->status].'</span>';    
            },
            'filter' => CHtml::dropDownlist('Promotion[status]', '', array(''=>'All')+ExtraHelper::$status, array('class'=>' form-control'))
        ), 
        array(
            'header' => 'Actions',
            'headerHtmlOptions' => array('width' => 280,'style' => 'text-align:center;width:80px'),
            'htmlOptions' => array('style' => 'text-align:center;vertical-align:middle;width:80px;'),
            'class' => 'booster.widgets.TbJsonButtonColumn',
            'template' => '{copy} {updates}',
            'buttons' => array(
                'updates' => array(
                    'label' => '',
                    'options' => array(
                        'class' => 'glyphicon glyphicon-pencil', 'data-toggle' => 'Active', 'data-original-title' => 'Active'),
                    'htmlOptions' => array(),
                    'url' => 'Yii::app()->createUrl("admin/promotion/update", array("id"=>$data["id"], "type" => $data["type"]))',
                ),
                'copy' => array(
                    'label' => '',
                    'options' => array(
                        'style' => 'cursor:pointer;', 'class' => 'fa fa-files-o fa-lg', 'data-toggle' => 'Active', 'data-original-title' => 'Active'),
                    'htmlOptions' => array(),
                    'url' => '',
                    'click' => 'copy'
                ),
            )
            //'updateButtonUrl'=>'Yii::app()->createUrl("admin/promotion/update", array("id"=>$data["id"], "type" => $data["type"]))',
        ),
    )
));
?>