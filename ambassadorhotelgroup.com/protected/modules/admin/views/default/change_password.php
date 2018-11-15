<div class="padding-md">
    <div class="row">
    <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-form',
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'class' => 'no-margin'
            ),
        ));
        ?>
            <?php 
            $none='';
            if (Yii::app()->user->hasFlash('change_password')): $none='style="display:none"';?>
                <div class="clearfix">
                    <div class="pull-left alert alert-success inline no-margin" style="text-align: center;margin-bottom:20px;width:96%;">
                        <button data-dismiss="alert" class="close" type="button">
                                <i class="icon-remove"></i>
                        </button>
                        <i class="icon-umbrella bigger-120 blue"></i>
                        <?php echo Yii::app()->user->getFlash('change_password'); ?>
                    </div>
                </div>
            <?php endif; ?> 
            <div class="" <?php echo $none;?>>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'old_password', array('class' => 'control-label')); ?>
                            <?php echo $form->passwordField($model, 'old_password', array('placeholder' =>'Old password','class'=>'form-control')); ?>
                            <span class="help-inline"><?php echo $form->error($model, 'old_password'); ?>
                                </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'new_password', array('class' => 'control-label')); ?>
                            <?php echo $form->passwordField($model, 'new_password', array('placeholder' =>'New password','class'=>'form-control')); ?>
                            <span class="help-inline"><?php echo $form->error($model, 'new_password'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, 'confirm_new_password', array('class' => 'control-label')); ?>
                                <?php echo $form->passwordField($model, 'confirm_new_password', array('placeholder' =>'Confirm new password','class'=>'form-control')); ?>
                                <span class="help-inline"><?php echo $form->error($model, 'confirm_new_password'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button class="btn btn-info submit-form-create" type="submit">Update</button>
                </div>
            </div>
            <?php $this->endWidget(); ?>
    </div>
</div>