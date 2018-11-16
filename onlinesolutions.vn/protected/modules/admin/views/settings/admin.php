<?php
$expiring = '';
if(isset($_GET['expiring']) && $_GET['expiring']=="yes") {
	$expiring = 'yes';
}?>
<?php
$this->breadcrumbs=array(
	'Settings'=>array('admin'),
	'Control',
);
/*$this->menu=array(
	array('label'=>'Create', 'url'=>array('create')),
);*/?>
<div class="row">
<?php
	if(isset($_GET['update']))
		echo 'Update';
?>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Settings Control</div>
    <div class="panel-body">
    	<?php 
    	if(Yii::app()->user->id==1){
    		echo $this->renderPartial('_grid', array('model'=>$model)); 
    	}else{
    		echo $this->renderPartial('_grid_2', array('model'=>$model)); 
    	}
    	?>
		
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#create').click(function(){
			$('#form-create').toggle();
		});
	})
</script>