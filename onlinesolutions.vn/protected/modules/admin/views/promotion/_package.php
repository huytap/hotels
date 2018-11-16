<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'grid',
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => 'no-margin'
    ),
));?>
<?php echo $form->errorSummary($model); ?>
<input type="hidden" name="Promotion[type]" value="package">
<div class="panel panel-default">
    <div class="panel-body">
    	<h3>Promotion General</h3>
    	<hr>
    	<div class="row">
    		<div class="col-md-12">
    			<div class="panel panel-default">
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
	                                    <?php echo $form->labelEx($model, 'name');?>
	                                    <?php echo $form->textField($model, 'name['.$key.']', array('class' => 'form-control', 'placeholder' => 'Promotion name'));?>
	                                    <?php echo $form->error($model, 'name'); ?>
	                                </div>
	                                <div class="form-group">
	                                    <?php echo $form->label($model, 'short_content');?>
	                                    <?php echo $form->textArea($model, "short_content[$key]", array('class' => 'form-control'));?>
	                                </div>
	                                <div class="form-group">
	                                    <?php echo $form->label($model, 'description');?>
	                                    <?php
                                        $this->widget('ext.editMe.widgets.ExtEditMe', array(
                                            'id' => 'description_'.$key,
                                            'height' => '250px',
                                            'width' => '100%',
                                            'model' => $model,
                                            'attribute' => "description[$key]",
                                            'toolbar' => Yii::app()->params['ckeditor'],
                                            'filebrowserBrowseUrl' => Yii::app()->baseUrl . '/ckfinder/ckfinder.html',
                                            'filebrowserImageBrowseUrl' => Yii::app()->baseUrl . '/ckfinder/ckfinder.html?type=Images',
                                            'filebrowserFlashBrowseUrl' => Yii::app()->baseUrl . '/ckfinder/ckfinder.html?type=Flash',
                                            'filebrowserUploadUrl' => Yii::app()->baseUrl . '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                            'filebrowserImageUploadUrl' => Yii::app()->baseUrl . '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                            'filebrowserFlashUploadUrl' => Yii::app()->baseUrl . '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                                        ));
                                        ?> 
	                                </div>
	                            </div>
	                        <?php $i++;
	                        }?>
	                    </div>
	                </div>
	            </div>
            </div>
        </div>
        <h3>Condition</h3>
        <hr>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'min_stay');?>
                    <?php echo $form->textField($model, 'min_stay', array('class' => 'form-control', 'value' => '1')); ?>
                    <?php echo $form->error($model, 'min_stay'); ?>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sale_start');?>
                    <?php echo $form->textField($model, 'sale_start', array('class' => 'form-control datepicker'));?>
                    <?php echo $form->error($model, 'sale_start'); ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'sale_end');?>
                    <?php echo $form->textField($model, 'sale_end', array('class' => 'form-control datepicker'));?>
                    <?php echo $form->error($model, 'sale_end'); ?>
                </div>
            </div>
        </div>
        <h3>Peak Off Date Promotion</h3>
        <hr>
        <div class="row">
        	<div class="col-lg-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'from_date');?>
                    <?php echo $form->textField($model, 'from_date', array('class' => 'form-control datepicker'));?>
                    <?php echo $form->error($model, 'from_date'); ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'to_date');?>
                    <?php echo $form->textField($model, 'to_date', array('class' => 'form-control datepicker'));?>
                    <?php echo $form->error($model, 'to_date'); ?>
                </div>
            </div>
        </div>
        <h3>Benefit</h3>
        <hr>
        <div class="row">
        	<div class="col-sm-4 p-none-l form-group">
                <label class="labelEx-checkbox inline">
                    <?php echo $form->checkbox($model, "pickup", array('class' => 'form-control')); ?>
                    <span class="custom-checkbox"></span> <?php echo $form->labelEx($model, 'pickup');?>
                </label>
            </div>
            <div class="col-sm-4 p-none-r form-group">
                <label class="labelEx-checkbox inline">
                    <?php echo $form->checkbox($model, "dropoff", array('class' => 'form-control')); ?>
                    <span class="custom-checkbox"></span> <?php echo $form->labelEx($model, 'dropoff');?>
                </label>
            </div>
            <div class="col-sm-4 p-none-r form-group">
                <label class="labelEx-checkbox inline">
                    <?php echo $form->checkbox($model, "breakfast", array('class' => 'form-control')); ?>
                    <span class="custom-checkbox"></span> <?php echo $form->labelEx($model, 'breakfast');?>
                </label>
            </div>
        	<div class="col-lg-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'discount_type'); ?>
                    <?php 
                        $discount_type = Yii::app()->params['discount_type'];
                        echo $form->dropDownlist($model, 'discount_type', $discount_type, array('id' => 'discount_type', 'class'=>'form-control'));
                        echo $form->error($model, 'discount_type'); 
                    ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'apply_on'); ?>
                    <?php 
                        $apply_on = Yii::app()->params['apply_on_config'];
                        echo $form->dropDownlist($model, 'apply_on', $apply_on, array('id' => 'applyOn', 'class'=>'form-control'));
                        echo $form->error($model, 'apply_on'); 
                    ?>
                </div>
            </div>

            <div class="col-lg-2" id="discount" style="<?php if($model['apply_on'] === 'every_night' || $model['apply_on'] === 'first_night' || $model['apply_on'] === 'last_night') echo 'display:block';else{echo 'display:none';}?>">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'discount');?>                    
                    <?php echo $form->textField($model, "discount", array('class' => 'form-control', 'placeholder' => '20')); ?>
                    <?php echo $form->error($model, 'discount'); ?>
                </div>    
	        </div>
        </div>
        <!-- <div class="row" id="specificNight" style="<?php if($model['apply_on'] === 'specific_night') echo 'display:block';else{echo 'display:none';}?>">
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % 1<sup>st</sup> night</label>
                    <?php echo $form->textField($model, 'specific_night[1]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % 2<sup>nd</sup> night</label>
                    <?php echo $form->textField($model, 'specific_night[2]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % 3<sup>rd</sup> night</label>
                    <?php echo $form->textField($model, 'specific_night[3]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % 4<sup>th</sup> night</label>
                    <?php echo $form->textField($model, 'specific_night[4]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % 5<sup>th</sup> night</label>
                    <?php echo $form->textField($model, 'specific_night[5]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % 6<sup>th</sup> night</label>                        
                    <?php echo $form->textField($model, 'specific_night[6]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % 7<sup>th</sup> night</label>                        
                    <?php echo $form->textField($model, 'specific_night[7]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
        </div> -->
        
        <div class="row" id="specificDay" style="<?php if($model['apply_on'] === 'specific_day_of_week') echo 'display:block';else{echo 'display:none';}?>">
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % on Monday</label>                        
                    <?php echo $form->textField($model, 'specific_day_of_week[mon]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % on Tuesday</label>                        
                    <?php echo $form->textField($model, 'specific_day_of_week[tue]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % on Wednesday</label>                        
                    <?php echo $form->textField($model, 'specific_day_of_week[wed]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % on Thurday</label>                        
                    <?php echo $form->textField($model, 'specific_day_of_week[thu]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % on Friday</label>                        
                    <?php echo $form->textField($model, 'specific_day_of_week[fri]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % on Saturday</label>                        
                    <?php echo $form->textField($model, 'specific_day_of_week[sat]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label>- % on Sunday</label>                        
                    <?php echo $form->textField($model, 'specific_day_of_week[sun]', array('class'=>'form-control', 'placeholder'=>'- %'));?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->label($model, 'increase', array('class'=>'control-label'));?>
                    <?php echo $form->textField($model, 'increase',array('class'=>'form-control'));?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <?php echo $form->label($model, 'package_type', array('class'=>'control-label'));?>
                    <?php echo $form->dropDownlist($model, 'package_type', array('per_night' => 'Increase Per Night','per_booking'=>'Increase Per Booking'), array('class'=>'form-control'));?>
                </div>
            </div>
        </div>
        <h3>Restrictions</h3>
        <hr>
        <div class="row">
        	<div class="col-lg-12"><?php echo $form->labelEx($model, 'roomtypes'); ?></div>
            <div class="col-lg-6">
                <div class="form-group">

                    <?php
                        foreach($roomtype as $key => $rt){?>
                            <labelEx class="labelEx-checkbox inline">                                    
                                <?php 
                                if(isset($Promotion['roomtypes'][$key])){
                                    echo CHtml::checkbox('Promotion[roomtypes]['.$key.']', $Promotion['roomtypes'][$key]);
                                }else{
                                    echo CHtml::checkbox('Promotion[roomtypes]['.$key.']');
                                }?>
                                <span class="custom-checkbox"></span> <?php echo $rt;?>
                            </labelEx>
                        <?php
                        }
                    ?>
                    <?php echo $form->error($model, 'roomtypes');?>
                </div>                
            </div>            
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <?php
                    $cancel_config = Yii::app()->params['cancellation_configs'];?>
                    <?php echo $form->labelEx($model, 'cancel_1');?>                    
                        <?php echo $form->dropDownlist($model, 'cancel_1', $cancel_config['cancel1'], array('class' => 'form-control'));?>
                        <?php echo $form->error($model, 'cancel_1'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'cancel_2');?>
                        <?php echo $form->dropDownlist($model, 'cancel_2', $cancel_config['cancel2'], array('class' => 'form-control'));?>
                        <?php echo $form->error($model, 'cancel_2'); ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'cancel_3');?>
                    <?php echo $form->dropDownlist($model, 'cancel_3', $cancel_config['cancel3'], array('class' => 'form-control'));?>
                    <?php echo $form->error($model, 'cancel_3'); ?>
                </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-lg-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'blackout_from');?>
                    <?php echo $form->textField($model, 'blackout_from', array('class' => 'form-control datepicker'));?>
                    <?php echo $form->error($model, 'blackout_from'); ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'blackout_to');?>
                    <?php echo $form->textField($model, 'blackout_to', array('class' => 'form-control datepicker'));?>
                    <?php echo $form->error($model, 'blackout_to'); ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <?php echo $form->labelEx($model, 'status');?>
                    <?php echo $form->dropDownlist($model, 'status', ExtraHelper::$status, array('class' => 'form-control'));?>
                    <?php echo $form->error($model, 'status'); ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row"><div class="col-lg-12"><div class="pull-right"><button type="submit" class="btn btn-primary">Save changes</button></div></div></div>
        <?php $this->endWidget(); ?>
    </div>
</div>
 
<script type="text/javascript">
    $(function(){
        $('#promotionType').change(function(){
            if($(this).val() == 'early_bird'){
                $('#noDays').show();
                $('#lblBird').show();
                $('#lblMinute').hide();
                $('#lblNoDays').text('Minimum no. of days to book in advance');
                $('#sales').hide();
            }else if($(this).val() == 'last_minutes'){
                $('#noDays').show();
                $('#sales').hide();
                $('#lblBird').hide();
                $('#lblMinute').show();
                $('#lblNoDays').text('Maximum no. of days to book before check-in');
            }else{
                $('#sales').show();
                $('#noDays').hide();
            }
        });

        $('#applyOn').change(function(){
            var applyON = $(this).val();
            if(applyON == 'every_night' || applyON == 'first_night' || applyON == 'last_night'){
                $('#discount').show();
                $('#specificNight').hide();
                $('#specificDay').hide();
            }
            else if(applyON == 'specific_night'){
                $('#discount').hide();
                $('#specificNight').show();
                $('#specificDay').hide();
            }else if(applyON == 'specific_day_of_week'){
                $('#discount').hide();
                $('#specificNight').hide();
                $('#specificDay').show();
            }
        })
    })
</script>