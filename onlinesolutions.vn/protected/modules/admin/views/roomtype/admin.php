<?php
$this->breadcrumbs = array(
    'Roomtypes',
);
$this->menu=array(
	array('label'=>'Create roomtype', 'url'=>array('create')),
);?>
<div class="panel panel-default">
    <div class="panel-heading">Roomtype Control</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid', compact('model'));?>
    </div>
</div>