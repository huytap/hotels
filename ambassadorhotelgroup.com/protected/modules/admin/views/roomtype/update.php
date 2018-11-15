<?php
$this->breadcrumbs = array(
    'Roomtypes' => array('admin'),
    'Update'
);?>
<div class="panel panel-default">
    <div class="panel-heading">Roomtype</div>
    <div class="panel-body">
    	<?php $this->renderPartial('_form', compact('model'));?>
    </div>
</div>