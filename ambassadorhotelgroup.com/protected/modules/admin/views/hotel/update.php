<?php
$this->breadcrumbs = array(
    'Hotel Settings'
);?>
<div class="panel panel-default">
    <div class="panel-heading">Hotel Configuration</div>
    <div class="panel-body">
    	<?php $this->renderPartial('_form', compact('model'));?>
    </div>
</div>