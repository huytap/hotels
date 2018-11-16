<?php
$this->breadcrumbs = array(
    'Gallery Control',
);
$this->menu=array(
    array('label'=>'Create slider', 'url'=>array('slideshow/create/type/'.$type)),
);
?>
<div class="panel panel-default">
    <div class="panel-heading">Gallery Control</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid_2', compact(array('model', 'type')));?>
    </div>
</div>