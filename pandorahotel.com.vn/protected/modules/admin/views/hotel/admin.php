<?php
$this->breadcrumbs = array(
    'Hotel Settings'
);?>

<div class="panel panel-default">
    <div class="panel-heading">Hotel List</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid', compact('model'));?>
    </div>
</div>