<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'nearby-category-form',
    'enableClientValidation' => true,
    'enableAjaxValidation'=>true,
));?>
    <?php echo $form->errorSummary($model); ?>
    <div class="basiccus section col-xs-12">
        <div class="col-md-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->labelEx($model,'display_order'); ?>
                <?php echo $form->NumberField($model, 'display_order', array('class' => 'form-control input-sm', 'placeholder' => 'Display order','min'=>0));?>
                <?php echo $form->error($model, 'display_order'); ?>
            </div>
            <div class="form-group col-sm-6 p-none-l">
                <?php echo $form->labelEx($model,'status'); ?>
                <?php echo $form->dropDownlist($model, "status", ExtraHelper::$status, array('class'=>'form-control')); ?>
            </div>
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-md-3">
            <h4>Near hotels</h4>
        </div>
        <div class="col-md-9 wrapper-content p-t15">
            <div class="col-sm-12 p-none-l form-group">
                <?php 
                $hotels = array();
                foreach(Hotel::model()->getList2(Yii::app()->session['hotel']) as $key => $hotel){
                    if(count($hotels) > 0 && in_array($key, $hotels)){
                        $checked='checked="checked"';
                    }else{
                        $checked='';
                    }
                    ?>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="label-checkbox inline">
                                <input name="GalleryCategories[hotel_id][<?php echo $key?>]" type="checkbox" <?php echo $checked?> value="<?php echo $key?>">
                                <span class="custom-checkbox"></span> <?php echo ucwords($hotel) ?>
                            </label>
                        </div>
                    </div>
                    <?php
                }?>
                <?php //echo $form->dropDownlist($model, 'hotel_id', array('' => 'Hotels') + Hotel::model()->getList2(),array('class' => 'form-control', 'multiple' => true));?>
                <?php echo $form->error($model, 'hotel_id'); ?>
            </div>
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-md-12 wrapper-content p-t15">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Content for multiple language
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
                                    <?php echo $form->label($model, 'name');?>
                                    <?php echo $form->textField($model, "name[$key]", array('class' => 'form-control', 'placeholder' => 'name')); ?>
                                </div>  
                            </div>
                        <?php $i++;
                        }?>
                    </div>
                </div>
            </div><!-- /panel -->
        </div>
    </div>
    <div class="row">
        <div class="pull-right">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
<?php $this->endWidget(); ?>