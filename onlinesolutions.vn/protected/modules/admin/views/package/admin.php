<?php
$this->breadcrumbs = array(
    'Packages'
);
$this->menu=array(
    array('label'=>'Create service', 'url'=>array('create')),
);?>

<div class="panel panel-default">
    <div class="panel-heading">Services</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid', compact('model'));?>
    </div>
</div>