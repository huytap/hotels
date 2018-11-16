<?php $lang = Yii::app()->session['_lang'];?>
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'paymentForm',
        'enableClientValidation' => false,
        'htmlOptions' => array(
            'class' => '',
        ),
));?>
<?php //echo $form->errorSummary($book); ?>
    <div class="row payment">
        <div class="col-md-9 col-sm-8 col-xs-12">
            <div class="panel panel-default promotion">
                <div class="panel-heading bg"><?=Yii::t('lang', 'contact_detail');?></div>
                <div class="panel-body white">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="title"><?=Yii::t('lang', 'title');?></div>
                            <?php echo $form->dropDownlist($booking, 'title', BookingForm::gender(), array('class'=>'required'));?>
                            <?php echo $form->error($booking, 'title', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="title"><?=Yii::t('lang','first_name');?></div>
                            <?php echo $form->textField($booking, 'first_name', array('class'=>'required', 'placeholder'=>Yii::t('lang','first_name')));?>
                            <?php echo $form->error($booking, 'first_name', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="title"><?=Yii::t('lang','last_name');?></div>
                            <?php echo $form->textField($booking, 'last_name', array('class'=>'required', 'placeholder'=>Yii::t('lang','last_name')));?>
                            <?php echo $form->error($booking, 'last_name', array('class'=>'error'));?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="title"><?=Yii::t('lang','email');?></div>
                            <?php echo $form->textField($booking, 'email', array('class'=>'required', 'placeholder'=>Yii::t('lang','email')));?>
                            <?php echo $form->error($booking, 'email', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="title"><?=Yii::t('lang','confirm_email');?></div>
                            <?php echo $form->textField($booking, 'email_confirm', array('class'=>'required', 'placeholder'=>Yii::t('lang','confirm_email')));?>
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
                            <?php echo $form->dropDownlist($booking, 'country', array(''=>'--------')+ExtraHelper::$country,array('class'=>'required'));?>
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

                <div class="panel-heading bg"><?php echo Yii::t('lang', 'room_extras'); ?></div>
                <div class="panel-body white">
                    <?php
                        $arr_time = array();
                        for ($ii=0; $ii<24; ++$ii) {
                            for ($jj=0; $jj<60; $jj+=5) {
                                $tmp_time = sprintf("%02d:%02d", $ii, $jj);
                                $arr_time[$tmp_time] = $tmp_time;
                            }
                        }
                    ?>
                    <?php 
                    $hotel = Hotel::model()->find();
                    $promotion = Promotion::model()->findByPk($booked['promotion_id']);
                    $pickups = json_decode(Settings::model()->getSetting('airport_pickup', $hotel['id']), true);
                    $arrThePickup = array();
                    if($pickups){?>
                        
                        <div class="row">
                            <div class="col-sm-3">
                            <?php
                            if($promotion->pickup){?>
                                <input type="checkbox" disabled="disabled"  checked="checked"> <strong><?php echo Yii::t('lang', 'free_pickup');?></strong>
                            <?php

                            }else{?>
                                <div class="title"><?=Yii::t('lang', 'vehicle_pickup');?></div>
                                <?php 
                                foreach($pickups as $p => $pickup){
                                    $arrThePickup[$p] = str_replace('_',' ',$p) .' - ' .number_format($pickup * $booked['exchangeRate'],2) .' ' .$booked['currency'];
                                }
                                ?>
                                <?php echo $form->dropDownlist($booking, 'pickup', array('' => '-------------')+$arrThePickup,array('id'=>'pickup'))?>
                            <?php }?>
                            </div>

                            <div class="col-sm-9 no-padding" id="pickup_info" style="<?php if((isset($booking['pickup']) && $booking['pickup'] !== NULL) || $promotion->pickup) echo 'display:block;'; else echo 'display:none;';?>">
                                <div class="col-sm-4">
                                    <div class="title"><?=Yii::t('lang', 'arrival_flight');?></div>
                                    <?php echo $form->textField($booking,'pickup_flight', array('placeholder'=>Yii::t('lang', 'arrival_flight')));?>
                                    <?php echo $form->error($booking, 'pickup_flight', array('class' => 'error'));?>
                                </div>
                                <div class="col-sm-4">
                                    <div class="title"><?=Yii::t('lang', 'date_flight');?></div>
                                    <?php echo $form->textField($booking, 'pickup_date', array('id'=>'arrival-date', 'placeholder'=>Yii::t('lang', 'date')));?>
                                    <?php echo $form->error($booking, 'pickup_date', array('class' => 'error'));?>
                                </div>
                                <div class="col-sm-4">
                                    <div class="title"><?php echo Yii::t('lang', 'time_flight');?></div>    
                                    <?php echo $form->dropDownlist($booking,'pickup_time', array('' => Yii::t('lang', 'time_flight'))+$arr_time);?>
                                    <?php echo $form->error($booking, 'pickup_time', array('class' => 'error'));?>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                    <?php 
                    $dropoffs = json_decode(Settings::model()->getSetting('airport_dropoff', $hotel['id']), true);
                    $arrTheDropoff = array();
                    if($dropoffs){?>
                        <div class="row">                        
                            <div class="col-sm-3">
                            <?php
                            if($promotion->dropoff){?>
                                <input type="checkbox" value="dropoff" disabled="disabled" checked="checked"> <strong><?php echo Yii::t('lang', 'free_drop');?></strong>
                            <?php

                            }else{?>
                                <div class="title"><?=Yii::t('lang', 'vehicle_drop');?></div>
                                <?php 
                                foreach($dropoffs as $d => $dropoff){
                                    $arrTheDropoff[$d] = str_replace('_',' ',$d) .' - ' .number_format($dropoff * $booked['exchangeRate'],2) .' ' .$booked['currency'];
                                }?>
                                <?php echo $form->dropDownlist($booking, 'dropoff', array('' => '-------------')+$arrTheDropoff,array('id'=>'dropoff'))?>
                            <?php }?>
                            </div>
                            <div class="col-sm-9 no-padding" id="drop_info" style="<?php if(isset($booking['dropoff']) && $booking['dropoff'] !== NULL) echo 'display:block;'; else echo 'display:none;';?>">
                                <div class="col-sm-4">
                                    <div class="title"><?=Yii::t('lang', 'departure_flight');?></div>
                                    <?php echo $form->textField($booking,'drop_flight', array('placeholder'=>Yii::t('lang', 'departure_flight')));?>
                                    <?php echo $form->error($booking, 'drop_flight', array('class'=>'error'));?>
                                </div>
                                <div class="col-sm-4">
                                    <div class="title"><?=Yii::t('lang', 'date_flight');?></div>
                                    <?php echo $form->textField($booking, 'drop_date', array('id'=>'departure-date', 'placeholder'=>Yii::t('lang', 'date')));?>
                                    <?php echo $form->error($booking, 'drop_date', array('class'=>'error'));?>
                                </div>
                                <div class="col-sm-4">
                                    <div class="title"><?php echo Yii::t('lang', 'time_flight');?></div>
                                    <?php echo $form->dropDownlist($booking,'drop_time', array('' => Yii::t('lang', 'time_flight')) + $arr_time);?>
                                    <?php echo $form->error($booking, 'drop_time', array('class'=>'error'));?>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    
                    <?php
                    if($room['no_of_extrabed']>0){
                        echo '<div id="extra">';
                        $et=1;
                        for($f=1;$f<=$booked['no_of_room'];$f++){
                            echo'<hr>';                            
                            echo '<div class="row"><div class="col-sm-12"><strong>'.Yii::t('lang', 'extrabed_room').' '.$f.'</strong></div></div>';
                                $checked='';
                                if($booked['extrabed'.$e]>0){
                                    $checked='checked="checked"';
                                }
                                if($booked['adult'] > $room['no_of_adult']){
                                    $checked='checked="checked" disabled="disabled"';
                                }?>
                                <div class="row extra">
                                    <div class="col-sm-12"><input <?php echo $checked;?> type="checkbox" id="extrabed<?php echo $et?>" class="input-checkbox" value="<?php echo $pk['id']?>" <?php echo $checked;?>> <?php echo ucfirst(Yii::t('lang', 'extrabed')).' ' .$booked['currency'] .' '.number_format(Settings::model()->getSetting('extrabed',$booked['hotel_id'])*$booked['exchangeRate'],2);?></div>
                                </div>
                        <?php
                        $et++; 
                        }
                        echo '</div>';
                    }
                    ?>
                    <?php
                    $from = ExtraHelper::date_2_save($booked['checkin']);
                    $to = ExtraHelper::date_2_save($booked['checkout']);
                    $package = Package::model()->getList($from['date'], $to['date']);
                    if(count($package->getData())>0){
                        
                        foreach($package->getData() as $pk){
                            $checked = '';
                            $pr = explode(',', $promotion['packages']);
                            $price=$price2=0;
                            $flag_pk=false;
                            $display="style='display:none'";
                            $price2 = $booked['currency'].' '.number_format($pk['rate']*$booked['exchangeRate'],2) .' per adult '.$booked['currency'].' '.number_format($pk['rate_child']*$booked['exchangeRate'], 2).' per child per night';
                            if(in_array($pk['id'], $pr)){
                                $checked='checked="checked" disabled="disabled"';
                                $price = $booked['currency'].' 0.00';
                                $price2 = $booked['currency'].' 0.00'. ' per adult '.$booked['currency'].' 0.00 per child per night';
                                $flag_pk=true;
                            }elseif(isset($booked['packages']) && array_key_exists($pk['id'], $booked['packages'])){
                                $checked='checked="checked"';
                                $display = '';
                                $price = $booked['currency'].' '.number_format(($booked['packages'][$pk['id']]['price_adult']+$booked['packages'][$pk['id']]['price_child']), 2);
                            }?>
                            <hr>
                            <div class="row package">
                                <div class="col-sm-3"><img src="<?php echo Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/cover/'.$pk['cover_photo'];?>&w=160&h=160"></div>
                                <div class="col-sm-9 pk-info">
                                    <?php
                                    //if($checked){?>
                                        <input type="hidden" name="extras_<?php echo $pk['id']?>" value="<?php echo $pk['id']?>">
                                        <div class="pull-right pack<?php echo $pk['id']?>" <?php echo $display;?>>
                                            <h5 class="pklabel"><?php echo Yii::t('lang', 'price');?></h5>
                                            <h4 class="pkprice">
                                                <?php echo $price;?>
                                            </h4>
                                        </div>
                                    <?php //}?>
                                    <input type="checkbox" class="pk" value="<?php echo $pk['id']?>" <?php echo $checked;?>> <strong><?php echo $pk['name']?></strong>
                                    <p><?php echo $price2;?></p>
                                    <p><?php $pk_des = json_decode($pk['short_description'], true);
                                    echo $pk_des[$lang];?></p>
                                    <div class="row">
                                    <?php
                                    if($flag_pk){?>
                                        <div class="col-md-3">
                                            <div class="title"><?php echo Yii::t('lang', 'adult');?></div>
                                            <select class="pk_adult">
                                                <option>0</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="title"><?php echo Yii::t('lang', 'children');?></div>
                                            <select class="pk_child">
                                                <option>0</option>
                                            </select>
                                        </div>
                                    <?php }else{?>
                                        <div class="col-md-3">
                                            <div class="title"><?php echo Yii::t('lang', 'adult');?></div>
                                            <select class="pk_adult" name="extras_adult_<?php echo $pk['id']?>">
                                                <?php for($a=1;$a<=10;$a++){
                                                    if($booked['packages'][$pk['id']]['adult'] == $a){
                                                        echo '<option selected="selected" value="'.$a.'">'.$a.'</option>';
                                                    }else{
                                                        echo '<option value="'.$a.'">'.$a.'</option>';
                                                    }
                                                    }?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="title"><?php echo Yii::t('lang', 'children');?></div>
                                            <select class="pk_child" name="extras_child_<?php echo $pk['id']?>">
                                                <?php for($b=0;$b<=10;$b++){
                                                    if($booked['packages'][$pk['id']]['child'] == $b){
                                                        echo '<option selected="selected" value="'.$b.'">'.$b.'</option>';
                                                    }else{
                                                        echo '<option value="'.$b.'">'.$b.'</option>';
                                                    }
                                                    }?>
                                            </select>
                                        </div>
                                    <?php }?>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <div class="panel-heading bg cards"><?=Yii::t('lang', 'payment_detail');?></div>
                <div class="panel-body white">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?php echo Yii::t('lang', 'card_detail');?>
                            <?php echo $form->dropDownlist($booking, 'card_type', array(''=>'--------')+ExtraHelper::$cartType,array('class'=>'required'));?>
                            <?php echo $form->error($booking, 'card_type', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?php echo Yii::t('lang', 'card_number');?> 
                            <?php echo $form->textField($booking, 'card_number', array('placeholder'=> Yii::t('lang', 'card_number'), 'class'=>'required'));?>
                            <?php echo $form->error($booking, 'card_number', array('class'=>'error'));?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <?=Yii::t('lang', 'card_name')?>
                            <?php echo $form->textField($booking, 'card_name', array('class'=>'required', 'placeholder'=>Yii::t('lang', 'card_name')));?>
                            <?php echo $form->error($booking, 'card_name', array('class'=>'error'));?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <span><?php echo Yii::t('lang', 'expiration_date');?></span>
                            <?php echo $form->dropDownlist($booking, 'card_expired_month', array(''=>'--------')+ExtraHelper::month(),array('class'=>'required','id'=>'card_expired_month'));?>
                            <?php echo $form->error($booking, 'card_expired_month', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <span>&nbsp;</span>
                            <?php echo $form->dropDownlist($booking, 'card_expired_year', array(''=>'--------')+ExtraHelper::year(),array('class'=>'required','id'=>'card_expired_year'));?>
                            <?php echo $form->error($booking, 'card_expired_year', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-3 col-sm-9 col-xs-9">
                            CVC/CVV
                            <?php echo $form->textField($booking, 'card_cvv', array('class'=>'required'));?>
                            <?php echo $form->error($booking, 'card_cvv', array('class'=>'error'));?>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 no-padding-l">
                            <label>&nbsp;</label>
                            <div><img src="<?=Yii::app()->baseUrl?>/images/cvc.png"></div>
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
                            <?=$booked['roomtype']?> - <?=$booked['promotion_name']?>, <?=$booked['no_of_room']?> <?=Yii::t('lang', 'room')?>, <?=$booked['adult']?> <?=Yii::t('lang', 'adult')?>, <?=$booked['children']?> <?=Yii::t('lang', 'children')?>:</strong><?=$booked['currency']?> <?=number_format($total_per_night*$booked['no_of_room']*$booked['nights'],2)?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <strong><?=Yii::t('lang', 'room_charge')?></strong>
                            <span class="pull-right"><?=$booked['currency']?> <?=number_format($total_per_night*$booked['no_of_room']*$booked['nights'],2);?></span>
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
                            $extras += ($bps['price_adult']+$bps['price_child'])*$booked['nights'];
                        }
                    }
                    $sub_total += $extras+($total_per_night*$booked['no_of_room']*$booked['nights']);
                    /*$vat += ($sub_total)*0.1;
                    $sc += ($vat + $sub_total)*0.05;
                    $total += $sub_total*1.155;*/
                    $total = $sub_total;
                    ?>
                    <div id="room_extra">
                        <div class="row">
                            <div class="col-md-12">
                                <strong><?=Yii::t('lang', 'room_extras')?></strong>
                                <span class="pull-right"><?=$booked['currency']?> <?=number_format($extras,2);?></span>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <strong><?=Yii::t('lang', 'sub_total')?></strong>
                                <span class="pull-right"><?=$booked['currency']?> <?=number_format($sub_total,2);?></span>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <strong><?=Yii::t('lang', 'vat')?> (10%):</strong>
                                <span class="pull-right"><?=number_format($vat,2) .' '.$currency?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <strong><?=Yii::t('lang', 'service_charge')?> (5%):</strong>
                                <span class="pull-right"><?=number_format($sc,2) .' '.$currency?></span>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <strong><?=Yii::t('lang','grand_total')?>:</strong>
                                <strong class="pull-right"><?=number_format($total,2) .' '.$currency?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endWidget();?>