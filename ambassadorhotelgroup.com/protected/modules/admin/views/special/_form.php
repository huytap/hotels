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
        <div class="col-md-3">
            <h4>Genaral Information</h4>
        </div>
        <div class="col-md-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'display_order');?>
                <?php echo $form->textField($model, 'display_order', array('class' => 'form-control input-sm', 'placeholder' => 'Display order'));?>
                <?php echo $form->error($model, 'display_order'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->label($model, 'type');?>
                <?php echo $form->dropDownlist($model, "type", array(''=>'-----Type-----') + Yii::app()->params['special'], array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'type'); ?>
            </div>
            <div class="clear"></div>
            <?php 
            $display='';
            if($model['type']!=='accommodation-offer'){
                $display='style="display:none;"';
            }?>
            <div class="col-sm-6 p-none-r form-group roomtype" <?php echo $display;?>>
                <?php echo $form->label($model, 'promotion_id');?>
                <?php echo $form->dropDownlist($model, "promotion_id", array(''=>'-----Promotion-----') + Promotion::model()->getList3(), array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'promotion_id'); ?>
            </div>
            
            <div class="col-sm-6 p-none-r form-group roomtype" <?php echo $display;?>>
                <?php echo $form->label($model, 'roomtype_id');?>
                <?php echo $form->dropDownlist($model, "roomtype_id", array(''=>'All') + Roomtype::model()->getList2(0), array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'roomtype_id'); ?>
            </div>
            <div class="col-sm-3 p-none-l form-group">
                <?php echo $form->label($model, 'cover_photo');?>
                <?php echo $form->fileField($model, "cover_photo", array('class' => 'form-control')); ?>
                <?php echo $form->error($model, 'cover_photo'); ?>
            </div>
            <?php
            if($model->cover_photo){?>
                <div class="col-sm-6 p-none-r form-group">
                    <?php echo '<img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$model->cover_photo.'" width="100">';?>
                </div>
            <?php
            }
            ?> 
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-md-3">
            <h4>Content for multilple language</h4>
        </div>
        <div class="col-md-9 wrapper-content p-t15">

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
                                    <?php echo $form->label($model, 'title');?>
                                    <?php echo $form->textField($model, "title[$key]", array('class' => 'form-control', 'placeholder' => 'Title')); ?>
                                </div> 
                                <div class="col-md-12 form-group">
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
                                <div class="col-md-12 form-group">
                                    <?php echo $form->label($model, 'description');?>
                                    <?php echo $form->error($model, 'description'); ?>
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
            </div><!-- /panel -->
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
<script type="text/javascript">
    $('#Cms_type').change(function(){
        if($(this).val() == 'destination'){
            $('#times').show();
        }else{
            $('#Cms_minute').val('');
            $('#times').hide();
        }
    });

    $('#Offer_type').change(function(){
        if($(this).val() == 'accommodation-offer'){
            $('.roomtype').show();
        }else{

        }
    })
</script>