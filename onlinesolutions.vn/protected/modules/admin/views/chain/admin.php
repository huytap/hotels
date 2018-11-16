<?php
$this->breadcrumbs = array(
    'Chain'
);
$this->menu=array(
    array('label'=>'Create service', 'url'=>array('create')),
);?>

<div class="panel panel-default">
    <div class="panel-heading">Chain</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid', compact('model'));?>
    </div>
</div>