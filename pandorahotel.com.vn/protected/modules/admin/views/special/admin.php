<?php
$this->breadcrumbs = array(
    'Special Offers'
);
$this->menu=array(
	array('label'=>'Create new', 'url'=>array('create')),
);?>

<div class="panel panel-default">
    <div class="panel-heading">Special Offers</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid', compact('model'));?>
    </div>
</div>