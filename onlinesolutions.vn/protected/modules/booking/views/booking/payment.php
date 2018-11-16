<?php $lang = Yii::app()->session['_lang'];?>
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'paymentForm',
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'class' => '',
        ),
));?>
<?php echo $form->errorSummary($booking); ?>
    <div class="row payment">
        <div class="col-md-9 col-sm-8 col-xs-12">
            <div class="panel panel-default promotion">
                <div class="panel-heading bg"><?=Yii::t('lang', 'contact_detail');?></div>
                <div class="panel-body white">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="title"><?=Yii::t('lang', 'title');?></div>
                            <?php echo $form->dropDownlist($booking, 'title', BookingForm::gender(), array('class'=>'required form-control'));?>
                            <?php echo $form->error($booking, 'title', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="title"><?=Yii::t('lang','first_name');?></div>
                            <?php echo $form->textField($booking, 'first_name', array('class'=>'required form-control', 'placeholder'=>Yii::t('lang','first_name')));?>
                            <?php echo $form->error($booking, 'first_name', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="title"><?=Yii::t('lang','last_name');?></div>
                            <?php echo $form->textField($booking, 'last_name', array('class'=>'required form-control', 'placeholder'=>Yii::t('lang','last_name')));?>
                            <?php echo $form->error($booking, 'last_name', array('class'=>'error'));?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="title"><?=Yii::t('lang','email');?></div>
                            <?php echo $form->textField($booking, 'email', array('class'=>'required form-control', 'placeholder'=>Yii::t('lang','email')));?>
                            <?php echo $form->error($booking, 'email', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="title"><?=Yii::t('lang','confirm_email');?></div>
                            <?php echo $form->textField($booking, 'email_confirm', array('class'=>'required form-control', 'placeholder'=>Yii::t('lang','confirm_email')));?>
                            <?php echo $form->error($booking, 'email_confirm', array('class'=>'error'));?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="title"><?=Yii::t('lang', 'phone')?></div>
                            <?php echo $form->textField($booking, 'phone', array('placeholder'=>Yii::t('lang', 'phone')));?>
                            <?php echo $form->error($booking, 'phone', array('class'=>'error'));?>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="title"><?=Yii::t('lang', 'country')?></div>
                            <?php echo $form->dropDownlist($booking, 'country', array(''=>'--------')+ExtraHelper::$country,array('class'=>'required form-control'));?>
                            <?php echo $form->error($booking, 'country', array('class'=>'error'));?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="title"><?=Yii::t('lang', 'billing_address');?></div>
                            <?php echo $form->textField($booking, 'address', array('placeholder'=>Yii::t('lang', 'billing_address')));?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="title"><?=Yii::t('lang', 'special_request');?></div>
                            <?php echo $form->textArea($booking, 'notes', array('row'=>4));?>
                        </div>
                    </div>
                    <div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><?=Yii::t('lang', 'note');?></div></div>
                </div>
                <div class="panel-heading bg cards"><?=Yii::t('lang', 'payment_detail');?></div>
                <div class="panel-body white">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?php echo Yii::t('lang', 'card_detail');?>
                            <?php echo $form->dropDownlist($booking, 'card_type', array(''=>'--------')+ExtraHelper::$cartType,array('class'=>'required form-control'));?>
                            <?php echo $form->error($booking, 'card_type', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?php echo Yii::t('lang', 'card_number');?> 
                            <?php echo $form->textField($booking, 'card_number', array('placeholder'=> Yii::t('lang', 'card_number'), 'class'=>'required form-control'));?>
                            <?php echo $form->error($booking, 'card_number', array('class'=>'error'));?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <?php echo Yii::t('lang', 'card_name')?>
                            <?php echo $form->textField($booking, 'card_name', array('class'=>'required form-control', 'placeholder'=>Yii::t('lang', 'card_name')));?>
                            <?php echo $form->error($booking, 'card_name', array('class'=>'error'));?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <span><?php echo Yii::t('lang', 'expiration_date');?></span>
                            <?php echo $form->dropDownlist($booking, 'card_expired_month', array(''=>'--------')+ExtraHelper::month(),array('class'=>'required form-control','id'=>'card_expired_month'));?>
                            <?php echo $form->error($booking, 'card_expired_month', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <span>&nbsp;</span>
                            <?php echo $form->dropDownlist($booking, 'card_expired_year', array(''=>'--------')+ExtraHelper::year(),array('class'=>'required form-control','id'=>'card_expired_year'));?>
                            <?php echo $form->error($booking, 'card_expired_year', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-3 col-sm-9 col-xs-9">
                            CVC/CVV
                            <?php echo $form->textField($booking, 'card_cvv', array('class'=>'required form-control'));?>
                            <?php  echo $form->error($booking, 'card_cvv', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 no-padding-l">
                            <label>&nbsp;</label>
                            <div><img src="<?php  echo Yii::app()->baseUrl?>/images/cvc.png"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <p><strong>Notes:</strong> For your own security, we will send email separately to request your CVV number and expiry date.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <?php echo $form->checkbox($booking, 'condition', array("required"=>"required", 'id' => 'condition'));?>  
                            <?php echo Yii::t('lang', 'agree_read')?> <a href="<?=Yii::app()->params['booking']?>ajax/term" class="show-room"><?php echo Yii::t('lang', 'term_condition')?></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <button type="submit" class="btn btn-gray">
                                <span class="glyphicon glyphicon-lock"></span> <?php echo Yii::t('lang', 'confirm_reservation');?>
                            </button>
                        </div>
                        <div class="col-md-7">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/rapidssl_ssl_certificate.gif">
                            <img src="<?php echo Yii::app()->baseUrl?>/images/payment-card.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4 col-xs-12">
            <div id="cart-payment">
            <?php
                    $vat = $sc = $sub_total = $total = 0;
                    $currency = '';
                    //foreach($booked as $bk){
                        $currency = $booked['currency'];
                        $total_per_night = $booked['rate'];
                        
                        /*if(isset($booked['pickup'])){
                            $total_per_night += $booked['pickup_price'];
                        }
                        if(isset($booked['drop_off'])){
                            $total_per_night += $booked['drop_off_price'];
                        }
                        
                        for($e=1;$e<=$booked['no_of_room'];$e++){
                            if(isset($booked['extrabed'.$e])){
                                $total_per_night += $booked['extrabed'.$e];
                            }
                        }
                        if(isset($booked['packages'])){
                            $total_per_night += $booked['packages'][$pk['id']]['price_adult']+$booked['packages'][$pk['id']]['price_child'];
                        }*/
                        

                        
                    //}
                    ?>
                <div class="panel-heading bg"><?=Yii::t('lang', 'reservation_summary');?></div>    
                <div class="panel-body white">
                    <div class="row">
                        <div class="col-md-12">
                            <strong><?=Yii::t('lang', 'checkin')?></strong>
                            <span class="pull-right"><?=$booked['checkin']?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <strong><?=Yii::t('lang', 'checkout')?></strong>
                            <span class="pull-right"><?=$booked['checkout']?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <strong><?=Yii::t('lang', 'room_info');?></strong><br>
                            <?=$booked['roomtype']?> - <?=$booked['promotion_name']?>, <?=$booked['no_of_room']?> <?=Yii::t('lang', 'room')?>, <?=$booked['adult']?> <?=Yii::t('lang', 'adult')?>, <?=$booked['children']?> <?=Yii::t('lang', 'children')?>:</strong><?=$booked['currency']?> <?=ExtraHelper::roundMoney3('VND',$total_per_night*$booked['no_of_room']*$booked['nights'])?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <strong><?=Yii::t('lang', 'room_charge')?></strong>
                            <span class="pull-right"><?=$booked['currency']?> <?=ExtraHelper::roundMoney3('VND',$total_per_night*$booked['no_of_room']*$booked['nights']);?></span>
                        </div>
                    </div>
                    <?php
                    $extras=0;

                    if(isset($booked['pickup'])){
                        $extras += $booked['pickup_price'];
                    }
                    if(isset($booked['drop_off'])){
                        $extras += $booked['drop_off_price'];
                    }
    
                    for($e=1;$e<=$booked['no_of_room'];$e++){
                        if(isset($booked['extrabed'.$e])){
                            $extras += $booked['extrabed'.$e]*$booked['nights'];
                        }
                    }

                    if(isset($booked['packages'])){
                        foreach($booked['packages'] as $bps){
                            if($bps['is_book'])
                                $extras += ($bps['price_adult']+$bps['price_child'])*$booked['nights'];
                            else
                                $extras += ($bps['price_adult']+$bps['price_child']);
                        }
                    }
                    $sub_total += $extras+($total_per_night*$booked['no_of_room']*$booked['nights']);
                    
                    
                    /*$vat += ($sub_total)*0.1;
                    $sc += ($vat + $sub_total)*0.05;*/
                    
                    //$total = $sub_total;
                    ?>
                    <div id="room_extra">
                        <div class="row">
                            <div class="col-md-12">
                                <strong><?=Yii::t('lang', 'room_extras')?></strong>
                                <span class="pull-right"><?=$booked['currency']?> <?=ExtraHelper::roundMoney3('VND',$extras);?></span>
                            </div>
                        </div>
                        <?php
                        $vat = $sc = 0;
                        $vat_setting = Settings::model()->getSetting('include_vat', $booked['hotel_id']);
                        if($vat_setting == 'false'){
                            $vat = $sub_total*10/100;
                            $sc= ($sub_total+$vat)*5/100;
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <strong><?=Yii::t('lang', 'sub_total')?></strong>
                                    <span class="pull-right"><?=$booked['currency']?> <?=ExtraHelper::roundMoney3('VND',$sub_total);?></span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <strong><?=Yii::t('lang', 'vat')?> (10%):</strong>
                                    <span class="pull-right"><?=ExtraHelper::roundMoney3('VND',$vat) .' '.$currency?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <strong><?=Yii::t('lang', 'service_charge')?> (5%):</strong>
                                    <span class="pull-right"><?=ExtraHelper::roundMoney3('VND',$sc) .' '.$currency?></span>
                                </div>
                            </div>
                        <?php }
                        $total = $sub_total+$sc+$vat;?>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <strong><?=Yii::t('lang','grand_total')?>:</strong>
                                <strong class="pull-right"><?=ExtraHelper::roundMoney3('VND',$total) .' '.$currency?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endWidget();?>