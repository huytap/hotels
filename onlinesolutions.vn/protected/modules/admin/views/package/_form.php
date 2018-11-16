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
    <div class="basiccus section col-xs-12">
        <div class="row">
            <div class="col-lg-6 form-group">
                <?php echo $form->label($model, 'type');?>
                <?php echo $form->dropDownlist($model, 'type', Yii::app()->params['promotion_type'] , array('class' => 'form-control'));?>
                <?php echo $form->error($model, 'type'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                <?php echo $form->label($model, 'roomtype_id');?>
                <?php echo $form->dropDownlist($model, 'roomtype_id', array(''=>'Room type')+Roomtype::model()->getList2(0, Yii::app()->session['hotel']) , array('class' => 'form-control'));?>
                <?php echo $form->error($model, 'roomtype_id'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                <?php echo $form->label($model, 'display_order');?>
                <?php echo $form->textField($model, 'display_order', array('class'=>'form-control'));?>
                <?php echo $form->error($model, 'display_order'); ?>
            </div>       
        </div>     
        <div class="row">
            <div class="col-lg-6 form-group">
                <?php echo $form->label($model, 'rate');?>
                <?php echo $form->textField($model, "rate", array('class' => 'form-control', 'placeholder' => 'Rate')); ?>
                <?php echo $form->error($model, 'rate'); ?>
            </div>   
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                <?php echo $form->label($model, 'nights');?>
                <?php echo $form->textField($model, "nights", array('class' => 'form-control', 'placeholder' => 'Minimum Stay')); ?>
                <?php echo $form->error($model, 'nights'); ?>
            </div> 
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                <?php echo $form->label($model, 'max_nights');?>
                <?php echo $form->textField($model, "max_nights", array('class' => 'form-control', 'placeholder' => 'Maximum Stay')); ?>
                <?php echo $form->error($model, 'max_nights'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 form-group">
                <?php echo $form->label($model, 'night_to_book');?>
                <?php echo $form->textField($model, "night_to_book", array('class' => 'form-control', 'placeholder' => 'Number of nights')); ?>
                <?php echo $form->error($model, 'nights'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                <?php echo $form->labelEx($model, 'from_date');?>
                <?php echo $form->textField($model, 'from_date', array('class' => 'form-control datepicker', 'placeholder' => 'Start Date')); ?>
                <?php echo $form->error($model, 'from_date'); ?>
            </div>
        </div>
        <div class="row">            
            <div class="col-lg-6 form-group">
                <?php echo $form->labelEx($model, 'to_date');?>
                <?php echo $form->textField($model, 'to_date', array('class' => 'form-control datepicker', 'placeholder' => 'End Date')); ?>
                <?php echo $form->error($model, 'to_date'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1 form-group">
                <?php echo $form->labelEx($model, 'adult');?>
                <?php echo $form->textField($model, 'adult', array('class' => 'form-control', 'placeholder' => 'Adult')); ?>
                <?php echo $form->error($model, 'adult'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
                <?php echo $form->label($model, 'cover_photo');?>
                <?php echo $form->fileField($model, "cover_photo", array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'cover_photo'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 form-group">
            <?php if($model->cover_photo){
                echo '<img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$model->cover_photo.'">';
                }
            ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-1 col-sm-4 form-group">
                <label class="labelEx-checkbox inline">
                    <?php echo $form->checkbox($model, "pickup", array('class' => 'form-control')); ?>
                    <span class="custom-checkbox"></span> <?php echo $form->labelEx($model, 'pickup');?>
                </label>
            </div>
            <div class="col-lg-1 col-sm-4 form-group">
                <label class="labelEx-checkbox inline">
                    <?php echo $form->checkbox($model, "dropoff", array('class' => 'form-control')); ?>
                    <span class="custom-checkbox"></span> <?php echo $form->labelEx($model, 'dropoff');?>
                </label>
            </div>
        </div>
    
    <div class="row">
        <div class="col-lg-6 wrapper-content p-t15">
            <div class="form-group">
                <?php echo $form->label($model, 'name');?>
                <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => 'Package name'));?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
            <?php
                $language = Yii::app()->params['language_config'];?>
                <div class="panel-tab clearfix">
                    <ul class="tab-bar">
                        <?php
                        $i=0; 
                        foreach($language as $key => $lang){
                            $class='';
                            if($i==0){
                                $class="active";
                            }
                            $i++;
                            echo '<li class="'.$class.'"><a href="#'.$key.'" data-toggle="tab"> '.$lang.'</a></li>';
                        }?>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <?php
                        $i=0; 
                        foreach($language as $key => $lang){
                            $class='';
                            if($i==0)
                                $class='active';?>
                            <div class="tab-pane fade in <?php echo $class?>" id="<?php echo $key?>">
                                
                                <div class="form-group">
                                    <?php echo $form->label($model, 'short_description');?>
                                    <?php echo $form->textArea($model, "short_description[$key]", array('class' => 'form-control ckeditor', 'rows'=>'6', 'placeholder' => 'Short Description')); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->label($model, 'full_description');?>
                                    <?php echo $form->textArea($model, "full_description[$key]", array('class' => 'form-control ckeditor', 'rows'=>'6', 'placeholder' => 'Description')); ?>
                                </div>
                            </div>
                        <?php $i++;
                        }?>
                    </div>
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 wrapper-content p-t15">
            <div class="col-sm-6 form-group">
                <?php echo $form->labelEx($model, 'status');?>
                <?php echo $form->dropDownlist($model, 'status', ExtraHelper::$status, array('class' => 'form-control'));?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="footer-form">
            <a class="btn btn-default mr5" href="<?php Yii::app()->createUrl('admin/staticcontent/admin');?>">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        <div class="clear"></div>
    </div>
<?php $this->endWidget(); ?>