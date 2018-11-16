<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'grid',
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => 'no-margin'
    ),
));?>
    <?php echo $form->errorSummary($model); ?>
    <div class="section col-xs-12 p-none">
        <div class="col-sm-3 ws-nm">
            <h4>Condition</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model, 'from_date');?>
                <?php echo $form->textField($model, 'from_date', array('class' => 'form-control datepicker'));?>
                <?php echo $form->error($model, 'from_date'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->labelEx($model, 'to_date');?>
                <?php echo $form->textField($model, 'to_date', array('class' => 'form-control datepicker'));?>
                <?php echo $form->error($model, 'to_date'); ?>
            </div>
            <div class="clearfix"></div>
            
            <div class="col-sm-6 p-none-l form-group">
                    <?php echo $form->labelEx($model, 'type');?>                    
                    <?php echo $form->dropDownlist($model, "type", array('' => '---Select promotion type---') + Yii::app()->params['promotion_type'], array('class' => 'form-control', 'id'=>'promotionType')); ?>
                    <?php echo $form->error($model, 'type'); ?>
            </div>
            <div class="col-sm-2 form-group">
                <?php echo $form->labelEx($model, 'min_stay');?>
                <?php echo $form->textField($model, 'min_stay', array('class' => 'form-control', 'placeholder' => 'Number of days')); ?>
                <?php echo $form->error($model, 'min_stay'); ?>
            </div>
            <div class="col-sm-4 p-none-r form-group">
                <label id="lblBird" style="<?php if($model['type'] == 'early_bird'){ echo 'display:block';} else echo 'display:none';?>" id="lblNoDays">Minimum no. of days to book in advance</label>
                <label id="lblMinute" style="<?php if($model['type'] == 'last_minutes'){ echo 'display:block';} else echo 'display:none';?>" id="lblNoDays">Maximum no. of days to book before check-in</label>
                
                <?php echo $form->textField($model, 'no_of_day', array('class' => 'form-control', 'placeholder' => 'Number of days')); ?>
                <?php echo $form->error($model, 'no_of_day'); ?>
            </div>
            <div class="clearfix"></div>
            <div id="deal" <?php if($model->type!=='deal') echo 'style="display:none;"'?>>
                <div class="col-sm-3 p-none-l form-group">
                    <?php echo $form->labelEx($model, 'start_deal_date');?>
                    <?php echo $form->textField($model, 'start_deal_date', array('class' => 'form-control datepicker', 'placeholder' => 'Start Deal Date')); ?>
                    <?php echo $form->error($model, 'start_deal_date'); ?>
                </div>
                <div class="col-sm-3 p-none-l form-group">
                    <?php echo $form->labelEx($model, 'end_deal_date');?>
                    <?php echo $form->textField($model, 'end_deal_date', array('class' => 'form-control datepicker', 'placeholder' => 'End Deal Date')); ?>
                    <?php echo $form->error($model, 'end_deal_date'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="section col-xs-12 p-none">
        <div class="col-sm-3 ws-nm">
            <h4>Benefit</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model, 'discount');?>                    
                <?php echo $form->textField($model, "discount", array('class' => 'form-control', 'placeholder' => 'Discount %')); ?>
                <?php echo $form->error($model, 'discount'); ?>
            </div>
            
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model, 'increase');?>                    
                <?php echo $form->textField($model, "increase", array('class' => 'form-control', 'placeholder' => 'Package increase $')); ?>
                <?php echo $form->error($model, 'increase'); ?>
            </div>
        </div>
    </div>
    <div class="section col-xs-12 p-none">
        <div class="col-sm-3 ws-nm">
            <h4>Room types</h4>
            <p>Roomtype will be apply for this promotion</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
                <?php
                    foreach($roomtype as $key => $rt){?>
                        <div class="col-sm-3 p-none-l form-group">
                            <label class="labelEx-checkbox inline">                                    
                                <?php 
                                if(isset($Promotion['roomtypes'][$key])){
                                    echo CHtml::checkbox('Promotion[roomtypes]['.$key.']', $Promotion['roomtypes'][$key]);
                                }else{
                                    echo CHtml::checkbox('Promotion[roomtypes]['.$key.']');
                                }?>
                                <span class="custom-checkbox"></span> <?php echo $rt;?>
                            </labe>
                        </div>
                    <?php
                    }
                ?>
                <?php echo $form->error($model, 'roomtypes');?>
        </div>
    </div>
    <div class="section col-xs-12 p-none">
        <div class="col-sm-3 ws-nm">
            <h4>Cancellation setup</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php
                $cancel_config = Yii::app()->params['cancellation_configs'];?>
                <?php echo $form->labelEx($model, 'cancel_1');?>                    
                <?php echo $form->dropDownlist($model, 'cancel_1', $cancel_config['cancel1'], array('class' => 'form-control'));?>
                <?php echo $form->error($model, 'cancel_1'); ?>
            </div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model, 'cancel_2');?>
                <?php echo $form->dropDownlist($model, 'cancel_2', $cancel_config['cancel2'], array('class' => 'form-control'));?>
                <?php echo $form->error($model, 'cancel_2'); ?>
            </div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model, 'cancel_3');?>
                <?php echo $form->dropDownlist($model, 'cancel_3', $cancel_config['cancel3'], array('class' => 'form-control'));?>
                <?php echo $form->error($model, 'cancel_3'); ?>
            </div>
        </div>
    </div>
    <div class="section col-xs-12 p-none">
        <div class="col-sm-3 ws-nm">
            <h4>Status</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model, 'status');?>
                <?php echo $form->dropDownlist($model, 'status', ExtraHelper::$status, array('class' => 'form-control'));?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>
    </div>

    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Content for multiple language</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
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
                                    <?php echo $form->textArea($model, "description[$key]", array('class' => 'form-control wysihtml5-textarea', 'rows'=>'6', 'placeholder' => 'Hotel Description')); ?>
                                </div>
                            </div>
                        <?php $i++;
                        }?>
                    </div>
                </div>
            </div><!-- /panel -->
        </div>
    </div>

    <div class="form-group">
        <div class="footer-form">
            <a class="btn btn-default mr5" href="<?php Yii::app()->createUrl('admin/promotion/admin');?>">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        <div class="clear"></div>
    </div>
<?php $this->endWidget(); ?>
 
<script type="text/javascript">
    $(function(){
        $('#promotionType').change(function(){
            if($(this).val() == 'early_bird'){
                $('#noDays').show();
                $('#lblBird').show();
                $('#lblMinute').hide();
                $('#lblNoDays').text('Minimum no. of days to book in advance');
                $('#sales').hide();
                $('#deal').hide()
                $('#Promotion_start_deal_date').val('')
                    $('#Promotion_end_deal_date').val('')
            }else if($(this).val() == 'last_minutes'){
                $('#noDays').show();
                $('#sales').hide();
                $('#lblBird').hide();
                $('#lblMinute').show();
                $('#lblNoDays').text('Maximum no. of days to book before check-in');
                $('#deal').hide()
                $('#Promotion_start_deal_date').val('')
                    $('#Promotion_end_deal_date').val('')
            }else{
                if($(this).val()=='deal'){
                    $('#deal').show()
                }else{
                    $('#deal').hide()
                    $('#Promotion_start_deal_date').val('')
                    $('#Promotion_end_deal_date').val('')
                }
                $('#noDays').hide();
                $('#lblBird').hide();
                $('#noDays').hide();
                $('#lblMinute').hide();

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