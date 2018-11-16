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
            <p>Packages information</p>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'chain_name');?>
                <?php echo $form->textField($model, 'chain_name', array('class' => 'form-control input-sm', 'placeholder' => 'Chain Name'));?>
                <?php echo $form->error($model, 'chain_name'); ?>
            </div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'chain_id');?>
                <?php echo $form->textField($model, 'chain_id', array('class' => 'form-control input-sm', 'placeholder' => 'Chain ID'));?>
                <?php echo $form->error($model, 'chain_id'); ?>
            </div>
            <div class="col-sm-6 p-none-l form-group">
                <?php echo $form->label($model, 'domain');?>
                <?php echo $form->textField($model, 'domain', array('class' => 'form-control input-sm', 'placeholder' => 'Domain'));?>
                <?php echo $form->error($model, 'domain'); ?>
            </div>
        </div>
    </div>
    <?php
    if(Yii::app()->user->id=='1'){
        ?>
        <div class="basiccus section col-xs-12">
            <div class="col-sm-3 ws-nm">
                <h4>API</h4>
                <p>Used restful api service</p>
            </div>
            <div class="col-sm-9 wrapper-content p-t15">
                <div class="col-sm-12 p-none-l form-group">
                    <?php echo $form->label($model, 'api_key');?>
                    <?php echo $form->textArea($model, 'api_key', array('readonly' => 'readonly', 'class' => 'form-control input-sm', 'placeholder' => 'Api Key'));?>
                    <?php echo $form->error($model, 'api_key'); ?>
                </div>
                <div class="col-sm-12 p-none-l form-group">
                    <button type="button" onclick="generate()" class="btn btn-success">Generate API KEY</button>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function generate(){
                $.ajax({
                    url: '<?php echo Yii::app()->baseUrl."/admin/ajax/generate";?>',
                    type: 'post',
                    dataType: 'json',
                    data:{flag:'generate'},
                    success:function(data){
                        $('#Chain_api_key').val(data)
                    }
                })
            }   
        </script>
    <?php
    }?>
    <div class="basiccus section col-xs-12">
        <div class="col-sm-3 ws-nm">
            <h4>Status</h4>
        </div>
        <div class="col-sm-9 wrapper-content p-t15">
            <div class="col-sm-6 p-none-r form-group">
                <?php echo $form->dropDownlist($model, 'active', ExtraHelper::$status, array('class'=>'form-control')); ?>
                <?php echo $form->error($model, 'active'); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="footer-form">
            <a class="btn btn-default mr5" href="<?php Yii::app()->createUrl('admin/chain/admin');?>">Cancel</a>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        <div class="clear"></div>
    </div>
<?php $this->endWidget(); ?>