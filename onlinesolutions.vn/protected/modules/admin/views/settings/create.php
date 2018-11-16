<?php
/* @var $this SystemSettingsController */
/* @var $model SystemSettings */

$this->breadcrumbs=array(
	'System Setting'=>array('admin'),
	'Create System Setting',
);

$this->menu=array(
	
);
?>

<h1>Create New System Setting</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>