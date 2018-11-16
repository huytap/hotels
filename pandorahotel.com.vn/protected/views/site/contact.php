<?php $lang = Yii::app()->language;?>

<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>
<section class="sc-contacts wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-xs-7">
                <div class="wp-frm-contacts">
                    <h2 class="titleContacts">
                        <font><?php echo Yii::t('lang', '<span>Contact</span> Us');?></font>
                        <?php
                            $content = json_decode(Settings::model()->getSetting('contact2'), true);
                            echo $content[$lang];
                        ?>
                    </h2>
                    <?php 
                        if(Yii::app()->user->hasFlash('contact')){
                            $none='display:none;';
                            echo Yii::app()->user->getFlash('contact');
                        }else{?> 
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                "id"=>"ajax-contact-form",
                                'enableClientValidation'=>true,
                                'clientOptions'=>array(
                                  'validateOnSubmit'=>true,
                                  'afterValidate' => 'js:function(form, data, hasError) { 
                                      if(hasError) {
                                          for(var i in data) $("#"+i).parent().addClass("msg-error");
                                          return false;
                                      }
                                  }'
                              ),
                                'htmlOptions'=> array('style'=>$none, 'class'=>'frContact')));?>
                                    <div class="row">
                                        <div class="col-xs-6 col-firstname">
                                            <label class="txtlbel"><?=Yii::t('lang', 'first_name')?> <font>*</font></label>
                                            <?php echo $form->textField($model, 'first_name');?>
                                            <?php echo $form->error($model, 'first_name')?>
                                        </div>
                                        <div class="col-xs-6 col-lastname">
                                            <label class="txtlbel"><?=Yii::t('lang', 'last_name')?> <font>*</font></label>
                                            <?php echo $form->textField($model, 'last_name');?>
                                            <?php echo $form->error($model, 'last_name')?>
                                        </div>
                                        <div class="col-xs-6 col-email">
                                            <label class="txtlbel"><?=Yii::t('lang', 'Email')?> <font>*</font></label>
                                            <?php echo $form->textField($model, 'email');?>
                                            <?php echo $form->error($model, 'email')?>
                                        </div>
                                        <div class="col-xs-6 col-phonenumber">
                                            <label class="txtlbel"><?=Yii::t('lang', 'Phone number')?> <font>*</font></label>
                                            <?php echo $form->textField($model, 'phone');?>
                                            <?php echo $form->error($model, 'phone')?>
                                        </div>
                                        <div class="col-xs-12 col-subject">
                                            <label class="txtlbel"><?=Yii::t('lang', 'Subject')?> <font>*</font></label>
                                            <?php echo $form->textField($model, 'subject');?>
                                            <?php echo $form->error($model, 'subject')?>
                                        </div>
                                        <div class="col-xs-12 col-message">
                                            <label class="txtlbel"><?=Yii::t('lang', 'Message')?><font>*</font></label>
                                            <?php echo $form->textArea($model, 'body');?>
                                            <?php echo $form->error($model, 'body');?>
                                        </div>  
                                                
                                        <div class="col-xs-12 col-btncontact">
                                            <button class="btn btn-sending"><span class="glyphicon glyphicon-send"></span><?=Yii::t('lang', 'send');?></button>
                                        </div>
                                    </div>          
                        <?php $this->endWidget();?>
                        <?php }?>
                </div>
            </div>
            <div class="col-xs-5">
                <div class="wp-maps">
                    <div id="map_container"></div>
                    <div id="map"></div>                        
                    <?php 
                        Yii::app()->clientScript->registerScriptFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDUsJ9tg6_qAszwcsYqr6yrQV-MguhaplU&v=3.exp&sensor=false', CClientScript::POS_END);
                        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/maps.js', CClientScript::POS_END);
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>