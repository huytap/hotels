<?php
$this->breadcrumbs = array(
    'User Privilges',
);
$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
);?>
<div class="panel panel-default">
    <div class="panel-heading">User Privilges</div>
    <div class="panel-body">
        <?php $this->renderPartial('_grid', compact('model'));?>
	</div>
</div>