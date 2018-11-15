<?php
$this->breadcrumbs=array(
	'Home slider' => array('admin')
);?> 
<div class="panel panel-default">
    <div class="panel-heading">Home slider</div>
    <div class="panel-body">
    	<?php $this->renderPartial('_form', compact(array('model', 'type')));?>
    </div>
</div>