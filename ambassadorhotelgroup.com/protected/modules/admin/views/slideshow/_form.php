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
$types = Yii::app()->params['slide_type'];
if($type=2){
    $arrType = $types['hotel'];
}else{
    $arrType = $types['group'];
}
?>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo $form->labelEx($model, 'name', array('class' => 'control-label'));?>
                <?php echo $form->dropDownlist($model, 'name', array('' => '--------------')+$arrType,array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>
        <?php
        if(Yii::app()->session['hotel']){?>
        <div class="col-lg-4" style="<?php if(!$model['name']) echo 'display:none;'?>" id="roomtype">
            <div class="form-group">
                <?php echo $form->labelEx($model, 'roomtype_id', array('class' => 'control-label'));?>
                <?php echo $form->dropDownlist($model, 'roomtype_id', array('' => '--------------')+Roomtype::model()->getList2(0, Yii::app()->session['hotel']),array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'roomtype_id'); ?>
            </div>
        </div>
        <?php
        }
        ?>
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
                <lebel>Photos</lebel>
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
<?php Yii::app()->clientScript->registerScript('show',"
    $('#Gallery_name').change(function(){
        if($(this).val()=='rooms'){
            $('#roomtype').show()
        }else{
            $('#roomtype').hide();
            $('#Gallery_roomtype_id').val('')
        }
    })", CClientScript::POS_END);?>