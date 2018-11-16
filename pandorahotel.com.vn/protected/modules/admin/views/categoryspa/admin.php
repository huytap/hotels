<?php
$this->breadcrumbs = array(
    'Spa Categories'
);
$this->menu=array(
	array('label'=>'Create new', 'url'=>array('create')),
);?>

<div class="panel panel-default">
    <div class="panel-heading">Spa Categories</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid', compact('model'));?>
    </div>
</div>