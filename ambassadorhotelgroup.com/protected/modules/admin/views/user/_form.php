<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'grid',
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => 'no-margin',
        'enctype' => 'multipart/form-data',
    ),
));?>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Genaral</h4>
            <p>User information</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model, 'username'); ?>
                <?php echo $form->textField($model, 'username', array('placeholder' =>'Username','class'=>'form-control')); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->labelEx($model, 'fullname'); ?>
                <?php echo $form->textField($model, 'fullname', array('placeholder' =>'Full name','class'=>'form-control')); ?>
                <?php echo $form->error($model, 'fullname'); ?>
            </div>

            <div class="clear"></div>            
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model, 'new_password'); ?>
                <input type="password" name="Users[new_password]" placeholder="Password" class="form-control">
                <?php echo $form->error($model, 'new_password'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->labelEx($model, 'cellphone'); ?>
                <?php echo $form->textField($model, 'cellphone', array('placeholder' =>'Cellphone','class'=>'form-control')); ?>
                <?php echo $form->error($model, 'cellphone'); ?>
            </div>
            <div class="clear"></div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model, 'email'); ?>
                <?php echo $form->textField($model, 'email', array('placeholder' =>'Email','class'=>'form-control')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->labelEx($model, 'gender'); ?>
                <?php echo $form->dropDownlist($model, 'gender',array('male' => 'Male', 'female'=>'Female'), array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'gender'); ?>
            </div>
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Hotel</h4>
            <p>Select hotel for user management</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-12 p-none-l form-group">
                <?php echo $form->dropDownlist($model, 'hotel_id', array('' => 'Manage all hotels')+Hotel::model()->getList2(),array('class'=>'chzn-select')); ?>
                <?php echo $form->error($model, 'hotel_id'); ?>
            </div>                         
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Roles</h4>
            <p>Set role for user</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <?php if(Yii::app()->user->id==1):?>
                <div class="col-sm-12 p-none-l form-group">
                    <?php  $arr_roles = Role::model()->getAllRoleName();
                    $roles=array();
                     foreach($arr_roles as $k => $v){
                        $roles[$k] = $k;                      
                     } 
                    ?>
                    <?php echo $form->dropDownlist($model, 'roles',$roles, array('class'=>'chzn-select','multiple'=>true)); ?>
                    <?php echo $form->error($model, 'roles'); ?>
                </div>
            <?php endif;?>
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Remarks</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-12 p-none form-group">
                <?php echo $form->textArea($model, 'remarks', array('placeholder'=>'Remarks','rows'=>5,'class'=>'form-control')); ?>
                <?php echo $form->error($model, 'remarks'); ?>
            </div>
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Status</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->dropDownlist($model, 'status', ExtraHelper::$user_status, array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-actions">
                    <button class="btn btn-info submit-form-create" type="submit">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>