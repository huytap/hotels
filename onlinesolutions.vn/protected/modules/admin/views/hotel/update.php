<?php
$this->breadcrumbs = array(
    'Hotel Update'
);?>
<div class="panel panel-default">
    <div class="panel-heading">Hotel Configuration</div>
    <div class="panel-body">
    	<?php 
    	if(Yii::app()->user->id == 1){
    		$this->renderPartial('_form', compact('model'));
    	}else{
    		$this->renderPartial('_form2', compact('model'));
    	}?>
    </div>
</div>
