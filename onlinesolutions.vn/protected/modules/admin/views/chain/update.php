<?php
$this->breadcrumbs = array(
    'Chain' => array('admin'),
    'Update',
);?>
<div class="panel panel-default">
    <div class="panel-heading">Update Chain</div>
    <div class="panel-body">
    	<?php $this->renderPartial('_form', compact('model'));?>
    </div>
</div>