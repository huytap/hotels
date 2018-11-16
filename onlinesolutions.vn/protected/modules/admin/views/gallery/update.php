<?php
$this->breadcrumbs=array(
    'Gallery' => array('admin'),
    'Update'
);?> 
<div class="panel panel-default">
    <div class="panel-heading">Gallery</div>
    <div class="panel-body">
        <?php $this->renderPartial('_form', compact('model'));?>
    </div>
</div>
<?php $this->renderPartial('view', array('gallery' => $model));?>