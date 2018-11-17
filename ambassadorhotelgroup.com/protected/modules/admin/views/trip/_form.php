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
        <div class="col-lg-2">
            <div class="form-group">
                <?php echo $form->label($model, 'display_order');?>
                <?php echo $form->textField($model, 'display_order', array('class' => 'form-control input-sm', 'placeholder' => 'Display Order'));?>
                <?php echo $form->error($model, 'display_order'); ?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <?php echo $form->label($model, 'author');?>
                <?php echo $form->textField($model, 'author', array('class' => 'form-control input-sm', 'placeholder' => 'Author'));?>
                <?php echo $form->error($model, 'author'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <?php echo $form->label($model, 'comment');?>
                <?php echo $form->textArea($model, "comment", array('class' => 'form-control ckeditor', 'rows'=>'6', 'placeholder' => 'Hotel Description')); ?>
            </div>
        </div>
    </div>
    <div class="section col-xs-12 p-none">
        <div class="col-sm-3 ws-nm">
            <h4>Status</h4>
            <p>Control of content this could be seen in your website or not.</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="form-group">
                <?php echo $form->dropDownlist($model, "status", ExtraHelper::$status, array('class'=>'form-control')); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
<?php $this->endWidget(); ?>