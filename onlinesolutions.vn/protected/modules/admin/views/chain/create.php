<?php
$this->breadcrumbs = array(
    'Chain' => array('admin'),
    'Create new chain',
);?>
<div class="panel panel-default">
    <div class="panel-heading">Create Chain</div>
    <div class="panel-body">
    	<?php $this->renderPartial('_form', compact('model'));?>
    </div>
</div>
