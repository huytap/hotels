<?php
$this->breadcrumbs = array(
    'Users'=>Yii::app()->createAbsoluteUrl("admin/user/admin"),
    'Add new'
);
?>
    <div class="page-header position-relative">
        <h1>Add new user</h1>
    </div><!--/.page-header-->
<?php 
echo $this->renderPartial('_form', compact('model')); ?>