<?php
/* @var $this SystemSettingsController */
/* @var $model SystemSettings */

$this->breadcrumbs=array(
	'System setting'=>array('admin'),
	'Update System Setting',
);

$this->menu=array(
	//array('label'=>'All roles', 'url'=>array('admin')),
);

?>

<h1>Update System Setting</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>