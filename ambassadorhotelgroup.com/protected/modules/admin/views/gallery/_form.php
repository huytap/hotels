<?php
$form = $this->beginWidget('CActiveForm', array(
'id' => 'category-form',
'enableClientValidation' => true,
'htmlOptions' => array(
    'class' => 'no-margin',
    'enctype' => 'multipart/form-data',
    ),
));?>
<?php

$arrType= Yii::app()->params['gallery_category'];
/*if($cate && count($cate->getData())>0)
foreach($cate->getData() as $ct){
    $name = json_decode($ct['name'], true);
    $arrType[$ct['slug']] = $name['en'];
}*/
?>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label>Gallery Category</label>
                <?php echo $form->dropDownlist($model, 'name', array('' => '--------------')+$arrType,array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo $form->labelEx($model, 'description', array('class' => 'control-label'));?>
                <?php echo $form->textField($model, 'description', array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">       
                <lebel>Photos (1110x750px)</lebel>
                <input multiple="" type="file" name="items[]" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <button class="btn btn-info" type="submit">
                <i class="icon-ok bigger-110"></i>
                Submit
            </button>
        </div>
    </div>
<?php $this->endWidget(); ?>