<?php
$this->breadcrumbs=array(
	'Photos' => array('admin'),
	'Create'
);?> 
<div class="panel panel-default">
    <div class="panel-heading">Photos</div>
    <div class="panel-body">
    	<?php 
    	$flag = 'create';
    	$this->renderPartial('_form', compact(array('model', 'flag')));?>
    </div>
</div>