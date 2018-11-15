<?php
$this->breadcrumbs=array(
	'Roles'=>array('admin'),
	'Update role',
);
?>
<?php 
 echo $this->renderPartial('_form', array('model'=>$model)); ?>