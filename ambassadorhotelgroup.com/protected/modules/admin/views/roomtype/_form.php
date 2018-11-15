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
            <p>Room information</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'name', array('class'=>'control-label'));?>
                <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'placeholder' => 'Roomtype name'));?>
                <?php echo $form->error($model, 'name'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->label($model, 'display_order', array('class'=>'control-label'));?>
                <?php echo $form->textField($model, "display_order", array('class' => 'form-control', 'placeholder' => 'Display order')); ?>
                <?php echo $form->error($model, 'display_order'); ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'size_of_room', array('class'=>'control-label'));?>
                <?php echo $form->textField($model, "size_of_room", array('class' => 'form-control', 'placeholder' => 'Size of room')); ?>
                <?php echo $form->error($model, 'size_of_room'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->label($model, 'no_of_rooms', array('class'=>'control-label'));?>
                <?php echo $form->textField($model, "no_of_rooms", array('class' => 'form-control', 'placeholder' => 'Number of room')); ?>
                <?php echo $form->error($model, 'no_of_rooms'); ?>
            </div>  
            <div class="clearfix"></div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'max_per_room', array('class'=>'control-label'));?>
                <?php echo $form->textField($model, "max_per_room", array('class' => 'form-control', 'placeholder' => 'Max per room')); ?>
                <?php echo $form->error($model, 'max_per_room'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <label class="control-label">View</label>
                <?php
                echo $form->dropDownlist($model, "view", array('-----' => '---Select View---') + Yii::app()->params['view'], array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'view'); ?>
            </div>
            <div class="col-sm-6 p-none-l form-group">
                 <label class="control-label">Cover Photo</label>
                <?php
                echo $form->fileField($model, "cover_photo", array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'cover_photo'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php
                if($model->cover_photo){
                    echo '<img src="'.Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/cover/'.$model->cover_photo.'&h=100">';
                }?>
            </div>
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Room configuration</h4>
            <p>Room information</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?= $form->label($model, 'no_of_adult');?>
                <?= $form->textField($model, 'no_of_adult', array('class'=>'form-control')); ?>
                <?= $form->error($model, 'no_of_adult');?>
            </div>
            <div class="col-sm-3 p-none form-group">
                <?= $form->label($model, 'no_of_child');?>
                <?= $form->textField($model, 'no_of_child', array('class'=>'form-control')); ?>
                <?= $form->error($model, 'no_of_child');?>
            </div>
            <div class="col-sm-3 p-none-r form-group">
                <?= $form->label($model, 'no_of_extrabed');?>
                <?= $form->textField($model, 'no_of_extrabed', array('class'=>'form-control')); ?>
                <?= $form->error($model, 'no_of_extrabed');?>
            </div>
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Room facilities</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <?php
            $amenities_config = Yii::app()->params['room_amenities'];
            foreach ($amenities_config as $key => $value):
                $checked = '';
                if (isset($model['amenities'])){
                    if(in_array($key, $model['amenities'])){
                        $checked = 'checked="checked"';
                    }                            
                }
                ?>
                <div class="col-sm-4" style="margin-left:0%">
                    <div class="form-group">
                        <label class="label-checkbox inline">
                            <input type="checkbox"  value="<?php echo $key;?>" name="Roomtype[amenities][<?php echo $key ?>]" <?php echo $checked ?>/>
                            <span class="custom-checkbox"></span> <?php echo ucwords($value) ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Bed configuration</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <?php
            $bed_config = Yii::app()->params['bed_configs'];
            foreach ($bed_config as $key => $bed):
                $checked = '';
                if (isset($model['bed'])){
                    //$beds = explode(',' , $model['bed']);
                    if(in_array($key, $model['bed'])){
                        $checked = 'checked="checked"';
                    } 
                }
                ?>
                <div class="col-lg-4" style="margin-left:0%">
                    <div class="form-group">
                        <label class="label-checkbox inline">
                            <input type="checkbox" value="<?php echo $key;?>" name="Roomtype[bed][<?php echo $key;?>]" <?php echo $checked ?>/>
                            <span class="custom-checkbox"></span> <?php echo $bed ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
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
    <div class="form-group">
        <div class="footer-form">
            <a class="btn btn-default mr5" href="<?php Yii::app()->createUrl('admin/roomtype/admin');?>">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        <div class="clear"></div>
    </div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
$(function(){
    var second_id = start=0;
    var arrItem = {}
    $.each($('#items').find('.col-md-2'), function(i, row){
                arrItem[$(row).attr('data-id')] = i+1;
            });

    $('#items').sortable({
        start: function(event, ui) {
            var tg2 = $(ui.item);
            start = ui.item.index();
            second_id = parseInt(tg2.attr('data-id'));
            console.log(arrItem)
        },
        update: function( event, ui ) {
            var $target = $(ui.item);
            // Extract the PK of the item just dragged
            var itemId = parseInt($target.attr('data-id'));
            var galleryId = <?php echo $model['id']?>;
            // Display order is 1-based in my database so add 1
            var index = $target.index() + 1;
            // Send REST call to server to update new display order
            var url = "<?php echo Yii::app()->createUrl('admin/ajax/update_photo_order')?>";
            //url += "?id="+ itemId.toString() + "&order=" + index.toString()+"&start="+start;
            $.each($('#items').find('.col-md-2'), function(i, row){
                arrItem[$(row).attr('data-id')] = i+1;
            });console.log(arrItem)
            $.ajax({
                url: url,
                type: "post",
                data:{arrItem: arrItem, id:itemId, neworder: index.toString(), gallery:galleryId, oldorder:(start+1)},
                beforeSend: function(){
                    $('#loading').show();
                },
                dataType:'json',                    
                success:function (data){
                    $('#loading').hide()
                }
            });
        }
    });
    $( "#image-upload-list" ).disableSelection();
});
</script>