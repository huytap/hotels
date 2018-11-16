<?php 
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'grid',
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => 'no-margin',
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
                <?php echo $form->label($model, 'hours');?>
                <?php echo $form->textField($model, 'hours', array('class' => 'form-control input-sm', 'placeholder' => 'Time'));?>
                <?php echo $form->error($model, 'hours'); ?>
            </div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'price');?>
                <?php echo $form->textField($model, 'price', array('class' => 'form-control input-sm', 'placeholder' => 'Price'));?>
                <?php echo $form->error($model, 'price'); ?>
            </div>
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->label($model, 'price_discount');?>
                <?php echo $form->textField($model, 'price_discount', array('class' => 'form-control input-sm', 'placeholder' => 'Price Discount'));?>
                <?php echo $form->error($model, 'price_discount'); ?>
            </div>
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
                                    <?php echo $form->label($model, 'name');?>
                                    <?php echo $form->textField($model, "name[$key]", array('class' => 'form-control', 'placeholder' => 'Name')); ?>
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