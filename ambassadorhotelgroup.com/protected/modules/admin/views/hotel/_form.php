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
        <div class="col-sm-3 ws-nm">
            <h4>Genaral</h4>
            <p>Hotel information</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'name');?>
                <?php echo $form->textField($model, 'name', array('class' => 'form-control input-sm', 'placeholder' => 'Hotel name'));?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
            <div class="col-sm-6 form-group p-none-r">
                <?php echo $form->label($model, 'slug');?>
                <?php echo $form->textField($model, "slug", array('class' => 'form-control', 'placeholder' => 'url for support SEO')); ?>
                <?php echo $form->error($model, 'slug'); ?>
            </div>
            <div class="clear"></div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'display_order');?>
                <?php echo $form->textField($model, 'display_order', array('class'=>'form-control'));?>
                <?php echo $form->error($model, 'display_order'); ?>
            </div>
            <div class="col-sm-6 form-group p-none-r">
                <?php echo $form->label($model, 'graded_star');?>
                <?php echo $form->textField($model, "graded_star", array('class' => 'form-control', 'placeholder' => 'Graded stars')); ?>
                <?php echo $form->error($model, 'graded_star'); ?>
            </div>

            <div class="clear"></div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'email_info');?>
                <?php echo $form->textField($model, "email_info", array('class' => 'form-control', 'placeholder' => 'Email')); ?>
                <?php echo $form->error($model, 'email_info'); ?>
            </div>     
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->label($model, 'email_sales');?>
                <?php echo $form->textField($model, "email_sales", array('class' => 'form-control', 'placeholder' => 'Email receive booking')); ?>
                <?php echo $form->error($model, 'email_sales'); ?>
            </div> 
            <div class="clear"></div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'tel');?>
                <?php echo $form->textField($model, 'tel', array('class' => 'form-control', 'placeholder' => 'Hotline'));?>
                <?php echo $form->error($model, 'tel'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->label($model, 'no_of_rooms');?>
                <?php echo $form->textField($model, "no_of_rooms", array('class' => 'form-control', 'placeholder' => 'Number of room')); ?>
                <?php echo $form->error($model, 'no_of_rooms'); ?>
            </div>
            <div class="clear"></div>   
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'hotline');?>
                <?php echo $form->textField($model, 'hotline', array('class' => 'form-control', 'placeholder' => 'Hotline'));?>
                <?php echo $form->error($model, 'hotline'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->label($model, 'fax');?>
                <?php echo $form->textField($model, "fax", array('class' => 'form-control', 'placeholder' => 'Fax')); ?>
                <?php echo $form->error($model, 'fax'); ?>
            </div>
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Logo</h4>
            <p>Logo on header and footer</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'logo1');?>
                <?php echo $form->fileField($model, "logo1", array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'logo1'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->label($model, 'logo2');?>
                <?php echo $form->fileField($model, "logo2", array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'logo2'); ?>
            </div>
            <div class="clear"></div>
            <div class="col-sm-6 p-none-l form-group">
                <?php if($model->logo1){
                    echo '<img src="'.Yii::app()->baseUrl.'/images/'.$model->logo1.'">';
                    }
                ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php if($model->logo2){
                    echo '<img src="'.Yii::app()->baseUrl.'/images/'.$model->logo2.'">';
                    }
                ?>
            </div>
            <div class="col-sm-12 p-none-l form-group">
                <?php echo $form->label($model, 'cover_photo');?>
                <?php echo $form->fileField($model, "cover_photo", array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'cover_photo'); ?>
            </div>
            <div class="col-sm-12 p-none-l form-group">
                <?php if($model->cover_photo){
                    echo '<img src="'.Yii::app()->baseUrl.'/images/'.$model->cover_photo.'">';
                    }
                ?>
            </div>
        </div>
    </div>
     <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Map</h4>
            <p>Google map embed</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-12 p-none form-group">
                <?php echo $form->label($model, 'location');?>
                <?php echo $form->textArea($model, 'location', array('class' => 'form-control input-sm', 'placeholder' => 'Map location embed'));?>
                <?php echo $form->error($model, 'location'); ?>
            </div>
            <div class="clear"></div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'lat');?>
                <?php echo $form->textField($model, 'lat', array('class' => 'form-control input-sm', 'placeholder' => 'Lat'));?>
                <?php echo $form->error($model, 'lat'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->label($model, 'lng');?>
                <?php echo $form->textField($model, 'lng', array('class' => 'form-control input-sm', 'placeholder' => 'lng'));?>
                <?php echo $form->error($model, 'lng'); ?>
            </div>
        </div>
    </div>
    <!--div class="section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Facilities</h4>
            <p>Hotel facilites</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <?php
            $facilities_config = Yii::app()->params['facilities'];
            foreach ($facilities_config as $key1 => $value):
                $checked = '';
                if (isset($model['facilities']) && is_array($model['facilities'])){
                    //$fac = explode(',', $model['facilities']);
                    if(in_array($key1, $model['facilities'])){
                        $checked = 'checked';
                    }                            
                }
                ?>
                <div class="col-lg-6" style="margin-left:0%">
                    <div class="form-group">
                        <label class="label-checkbox inline">
                            <?php echo $form->checkbox($model, 'facilities['.$key1.']', array('checked' => $checked, 'value' => $key1));?>
                            <span class="custom-checkbox"></span> <?php echo ucwords($value) ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="section col-xs-12 p-none">
        <div class="col-sm-3 ws-nm">
            <h4>Sports</h4>
            <p>Hotel sports and recreation</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <?php
                $sports = Yii::app()->params['sports'];
                foreach ($sports as $key2 => $sport):
                    $checked = '';
                    if (isset($model['sports']) && is_array($model['sports'])){
                        //$sp = explode(',' , $model['sports']);
                        if(in_array($key2, $model['sports'])){
                            $checked = 'checked';
                        } 
                    }
                    ?>
                    <div class="col-lg-6" style="margin-left:0%">
                        <div class="form-group">
                            <label class="label-checkbox inline">
                                <?php echo $form->checkbox($model, 'sports['.$key2.']', array('checked' => $checked, 'value' => $key2));?>
                                <span class="custom-checkbox"></span> <?php echo $sport ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
        </div>
    </div-->
    <div class="section col-xs-12 p-none">
        <div class="col-sm-3 ws-nm"></div>
        <div class="col-sm-9 wrapper-content p-t15">
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
                                    <?php echo $form->label($model, 'other_name');?>
                                    <?php echo $form->textField($model, "other_name[$key]", array('class' => 'form-control', 'placeholder' => 'Hotel Name')); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->label($model, 'address');?>
                                    <?php echo $form->textField($model, "address[$key]", array('class' => 'form-control', 'placeholder' => 'Address')); ?>
                                </div>    
                                <div class="form-group">
                                    <?php echo $form->label($model, 'city');?>
                                    <?php echo $form->textField($model, "city[$key]", array('class' => 'form-control', 'placeholder' => 'City')); ?>
                                </div>       
                                <div class="form-group">
                                    <?php echo $form->label($model, 'country');?>
                                    <?php echo $form->textField($model, "country[$key]", array('class' => 'form-control', 'placeholder' => 'Country')); ?>
                                </div>
                                <!--div class="form-group">
                                    <?php //echo $form->label($model, 'promotion');?>
                                    <?php //echo $form->textArea($model, "promotion[$key]", array('class' => 'form-control', 'rows'=>'6', 'placeholder' => 'Promotion')); ?>
                                </div-->
                                
                                <div class="form-group">
                                    <?php echo $form->label($model, 'special_offer');?>
                                    <?php echo $form->textArea($model, "special_offer[$key]", array('class' => 'form-control ckeditor', 'rows'=>'6', 'placeholder' => 'Special Offer')); ?>
                                </div>
                                <div class="form-group">
                                    <?php echo $form->label($model, 'short_description');?>
                                    <?php echo $form->textArea($model, "short_description[$key]", array('class' => 'form-control ckeditor', 'rows'=>'6', 'placeholder' => 'Short Description')); ?>
                                </div>
                                <!-- <div class="form-group">
                                    <?php echo $form->label($model, 'home_description');?>
                                    <?php echo $form->textArea($model, "home_description[$key]", array('class' => 'form-control ckeditor', 'rows'=>'6', 'placeholder' => 'Home Description')); ?>
                                </div> -->
                                <div class="form-group">
                                    <?php echo $form->label($model, 'description');?>
                                    <?php echo $form->textArea($model, "description[$key]", array('class' => 'form-control ckeditor', 'rows'=>'6', 'placeholder' => 'Hotel Description')); ?>
                                </div>
                            </div>
                        <?php $i++;
                        }?>
                    </div>
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