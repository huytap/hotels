<?php
$this->breadcrumbs = array(
    'Roomtypes' => array('admin'),
    'Create new roomtype'
);?>
<div class="panel panel-default">
    <div class="panel-heading">Roomtype</div>
    <div class="panel-body">
    	<?php $this->renderPartial('_form', compact('model'));?>
    </div>
</div>