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
                                    <?php echo $form->textField($model, "name[$key]", array('class' => 'form-control', 'placeholder' => 'Title')); ?>
                                </div>

                                <div class="form-group">
                                    <?php echo $form->label($model, 'short_description');?>
                                    <?php echo $form->error($model, 'short_description'); ?>
                                    <?php
                                        $this->widget('ext.editMe.widgets.ExtEditMe', array(
                                            'id' => 'short_description_'.$key,
                                            'height' => '250px',
                                            'width' => '100%',
                                            'model' => $model,
                                            'attribute' => "short_description[$key]",
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
                                <div class="form-group">
                                    <?php echo $form->label($model, 'full_description');?>
                                    <?php echo $form->error($model, 'full_description'); ?>
                                    <?php
                                        $this->widget('ext.editMe.widgets.ExtEditMe', array(
                                            'id' => 'full_content_'.$key,
                                            'height' => '250px',
                                            'width' => '100%',
                                            'model' => $model,
                                            'attribute' => "full_description[$key]",
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
            </div><!-- /panel -->
        </div>
    </div>
    <div class="section col-xs-12 p-none">
        <div class="col-sm-1 ws-nm">
            <h4>Status</h4>
        </div>
        <div class="col-sm-5 wrapper-content p-t15">
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