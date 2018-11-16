<?php
$this->breadcrumbs=array(
    'Gallery'=>array('admin'),
    'Update'
);?>
<div class="panel panel-default">
    <div class="panel-body">
    <div class="panel-heading">Gallery</div> 
        <?php $this->renderPartial('_form', compact('model'));?>
    </div>
</div>