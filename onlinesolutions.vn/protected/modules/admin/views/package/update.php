<?php
$this->breadcrumbs = array(
    'Packages' => array('admin'),
    'Update package',
);?>
<div class="panel panel-default">
    <div class="panel-heading">Update package</div>
    <div class="panel-body">
    	<?php $this->renderPartial('_form', compact('model'));?>
    </div>
</div>