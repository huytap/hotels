<?php
$this->breadcrumbs = array(
    'Packages' => array('admin'),
    'Create package',
);?>
<div class="panel panel-default">
    <div class="panel-heading">Create package</div>
    <div class="panel-body">
    	<?php $this->renderPartial('_form', compact('model'));?>
    </div>
</div>
