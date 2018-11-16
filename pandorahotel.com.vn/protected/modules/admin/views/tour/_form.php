<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'grid',
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => 'no-margin',
        'enctype' => 'multipart/form-data',
    ),
));?>
    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo $form->label($model, 'name');?>
                <?php echo $form->textField($model, "name", array('class' => 'form-control', 'placeholder' => 'Name')); ?>
            </div>  
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <?php echo $form->label($model, 'status');?>
                <?php
                    echo $form->dropDownlist($model, "status", ExtraHelper::$status, array('class'=>'form-control')); ?>
                    <?php echo $form->error($model, 'status'); ?>
            </div>    
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <?php echo $form->label($model, 'cover_photo');?>
                <?php echo $form->fileField($model, "cover_photo", array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'cover_photo'); ?>
            </div>   
        </div>
        <?php
        if(isset($model->cover_photo) && $model->cover_photo){
            ?>
            <div class="col-lg-2">
            <div class="form-group">
                <img src="<?php echo Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/cover/'. $model['cover_photo']?>&h=100&w=100" alt="">
            </div>   
        </div>
        <?php
        }?>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <?php echo $form->label($model, 'show_to_booking');?>
                <label class="label-checkbox inline">
                    <?php echo $form->checkbox($model, 'show_to_booking');?>
                    <span class="custom-checkbox"></span> 
                </label>
            </div>
        </div>
    </div>
    <hr>
    <h3>Group size / Price per person in USD</h3>
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <?php echo $form->label($model, 'max_2_adult');?>
                <?php echo $form->textField($model, "max_2_adult", array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <?php echo $form->label($model, 'max_4_adult');?>
                <?php echo $form->textField($model, "max_4_adult", array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <?php echo $form->label($model, 'max_6_adult');?>
                <?php echo $form->textField($model, "max_6_adult", array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <?php echo $form->label($model, 'max_9_adult');?>
                <?php echo $form->textField($model, "max_2_adult", array('class' => 'form-control')); ?>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <?php echo $form->label($model, 'above_10_adult');?>
                <?php echo $form->textField($model, "above_10_adult", array('class' => 'form-control')); ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $form->label($model, 'short_description');?>
                <?php echo $form->textArea($model, "short_description", array('class' => 'form-control', 'rows'=>'6', 'placeholder' => 'Short Description')); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $form->label($model, 'full_description');?>
                <?php echo $form->textArea($model, "full_description", array('class' => 'form-control ckeditor', 'rows'=>'6', 'placeholder' => 'Full Description')); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
<?php $this->endWidget(); ?>