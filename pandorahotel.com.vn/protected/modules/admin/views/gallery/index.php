<?php
$this->breadcrumbs = array(
    'Gallery',
);
$this->menu=array(
    array('label'=>'Create album', 'url'=>array('create')),
);
?>
<div class="panel panel-default">
    <div class="panel-heading">Gallery Control</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid_2', compact('model'));?>
    </div>
</div>