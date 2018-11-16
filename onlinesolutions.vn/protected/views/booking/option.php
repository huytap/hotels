<?php 
    $lang = Yii::app()->session['_lang'];
    $booked = Yii::app()->session['_booked'];
    //echo"<pre>";print_r($booked);
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'options',
        'enableClientValidation' => false,
        'htmlOptions' => array(
            'class' => '',
        ),
));?>
<?php //echo $form->errorSummary($booking); ?>
    <div class="row payment">
        <div class="col-md-9 col-sm-8 col-xs-12">
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
                //$hotel = Hotel::model()->find();
                $promotion = Promotion::model()->findByPk($booked['promotion_id']);
                $pickups = json_decode(Settings::model()->getSetting('airport_pickup', $promotion['hotel_id']), true);
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
                            $selected = '';
                            if(isset($booked['pickup']) && $booked['pickup']){
                                $selected = $booked['pickup'];
                            }
                            foreach($pickups as $p => $pickup){
                                $arrThePickup[$p] = str_replace('_',' ',$p) .' - ' .number_format($pickup * $booked['exchangeRate'],2) .' ' .$booked['currency'];
                            }
                            ?>
                            <?php echo $form->dropDownlist($booking, 'pickup', array('' => '-------------')+$arrThePickup,array('id'=>'pickup', 'options' => array($selected => array('selected' => true))))?>
                        <?php }?>
                        </div>

                        <div class="col-sm-9 no-padding" id="pickup_info" style="<?php if((isset($booked['pickup']) && $booked['pickup'] !== NULL) || $promotion->pickup) echo 'display:block;'; else echo 'display:none;';?>">
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
                $dropoffs = json_decode(Settings::model()->getSetting('airport_dropoff', $promotion['hotel_id']), true);
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
            <div class="row">
                <div class="col-md-2 col-sm-4 col-xs-6 pull-right">
                    <button type="submit" name="option" class="btn btn-gray"><?php echo Yii::t('lang', 'next');?>
                    </button>
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
                    $vat += ($sub_total)*0.1;
                    $sc += ($vat + $sub_total)*0.05;
                    $total += $sub_total*1.155;
                    ?>
                    <div id="room_extra">
                        <div class="row">
                            <div class="col-md-12">
                                <strong><?=Yii::t('lang', 'room_extras')?></strong>
                                <span class="pull-right"><?=$booked['currency']?> <?=number_format($extras,2);?></span>
                            </div>
                        </div>
                        <div class="row">
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
                        </div>
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