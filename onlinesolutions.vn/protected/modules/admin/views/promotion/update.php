<?php
$type = Yii::app()->params['promotion_type'];
$this->breadcrumbs = array(
    'Promotions' => array('admin'),
    $type[$_GET['type']]
);
if($_GET['type'] == 'early_bird'){
	$this->renderPartial('_earlybird', compact(array('model', 'roomtype','Promotion')));
}elseif($_GET['type'] == 'last_minutes'){
	$this->renderPartial('_lastminute', compact(array('model', 'roomtype','Promotion')));
}elseif($_GET['type'] == 'others'){
	$this->renderPartial('_others', compact(array('model', 'roomtype','Promotion')));
}elseif($_GET['type'] == 'deal'){
	$this->renderPartial('_deal', compact(array('model', 'roomtype','Promotion')));
}elseif($_GET['type'] == 'package'){
	$this->renderPartial('_package', compact(array('model', 'roomtype','Promotion')));
}