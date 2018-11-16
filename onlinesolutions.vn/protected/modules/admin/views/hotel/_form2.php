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
            <div class="clear"></div>   
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'website');?>
                <?php echo $form->textField($model, 'website', array('class' => 'form-control', 'placeholder' => 'Website'));?>
                <?php echo $form->error($model, 'website'); ?>
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
            <div class="clear"></div>
            <div class="col-sm-6 p-none-l form-group">
                <?php if($model->logo1){
                    echo '<img src="'.Yii::app()->baseUrl.'/images/'.$model->logo1.'">';
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
        </div>
    </div>
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
                                <div class="form-group">
                                    <?php echo $form->label($model, 'term_condition');?>
                                    <?php echo $form->textArea($model, "term_condition[$key]", array('class' => 'form-control ckeditor', 'rows'=>'6', 'placeholder' => 'Terms & Conditions')); ?>
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