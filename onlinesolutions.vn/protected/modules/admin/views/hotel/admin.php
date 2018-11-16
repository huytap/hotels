<?php
$this->breadcrumbs = array(
    'Hotel Settings'
);
$this->menu=array(
    array('label'=>'Create Hotel', 'url'=>array('create')),
);?>

<div class="panel panel-default">
    <div class="panel-heading">Hotel List</div>
    <div class="panel-body">
        <?php 
        	if(Yii::app()->user->id=='1'){
	        	$this->renderPartial('_grid', compact('model'));
	        }else{
	        	$this->renderPartial('_grid2', compact('model'));
	        }
        ?>
    </div>
</div>