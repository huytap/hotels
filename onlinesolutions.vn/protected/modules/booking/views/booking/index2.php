<?php $lang = Yii::app()->session['_lang'];?>
<?php if (isset($params['fromDate'])) { ?>
    <script type="text/javascript" charset="utf-8">
        var fromDate = "<?php echo $params["fromDate"] ?>";
        var toDate = "<?php echo $params["toDate"] ?>";
    </script>
<?php }
?>

<?php
if(count($available)>0){?>
    <div class="row currency-form">               
        <div class="col-md-6"></div>
        <div class="col-md-6 no-padding">
            <label class="col-md-5 text-rate"><?php echo Yii::t('lang', 'display_rate');?></label>
            <div class="col-md-7 no-padding">
            <?php
                echo CHtml::beginForm('', 'post', array('id' => 'formCurrency', "data-ajax" => "false", 'class'=>'form-inline td_select'));
                    echo CHtml::dropDownList('exchange_rate', Yii::app()->session['change_currency'], ExtraHelper::$currency, array('class' => 'number_select'));
                echo CHtml::endForm(); 
            ?>
            </div>
        </div>
    </div> 
    <div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12 booking-list" role="main">
            <div class="panel panel-default">
                <div class="panel-heading bg heading-title up"><?php echo Yii::t('lang', 'roomtype')?></div>
                <div class="panel-body" id="search">
                    <?php
                    foreach($available as $room){
                        $photo = explode(',', $room['photos']);
                        if(isset($room['promos']) && $room[1]>0 && 
                            $room['available'] > 0){
                            $rowspan = count($room['promos']);
                            $max = 2;
                            $this->renderPartial('_item2', compact(array('max', 'params','room', 'photo')));
                        }else{
                            $this->renderPartial('_item_not_available', compact(array('j', 'max', 'params','loop','room', 'photo')));
                        }
                    }
                    ?>
                    
                </div>
            </div>
            <!--cart-->
            <?php 
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'room-form',
                    'enableClientValidation' => true,
                    'htmlOptions' => array(
                        'action' => '',
                    ),
                ));?>
                    <div class="panel panel-default" id="cartBK" <?php if(!Yii::app()->session['_booked']) echo 'style="display:none"';?>>
                        <div class="panel-heading bg heading-title">CART</div>
                        <div class="panel-body list-promotion cart">
                            <div style="text-align: center; display: none;background:#c3e4f9" id="loading-cart">
                                <img src="<?php echo Yii::app()->baseUrl?>/images/loading.gif" style="width: 64px;">
                            </div>
                            <div id="carttable" >
                            <?php

                            
                            //$htmlContinue = '<button type="submit" class="btn btn-gray" name="btnContinue" id="btnContinue" disabled="disabled">' . Yii::t('lang', 'continue') . '</button>';
                            $htmlContinue = '';
                            if (Yii::app()->session['_booked']):
                                $cart = Yii::app()->session['_booked'];
                                $currency = Yii::app()->session['_currency'] ? : 'VND'; 
                                $totalRate = 0;
                                if ($cart != 0) :
                                    $i = 0; 
                                    foreach ($cart as $value) :
                                        $promotion = Promotion::model()->findByPk($value['promotion_id']);
                                        ?>
                                        <?php
                                        if ($value['benefits'] == 'free_airports') {
                                            $htmlFree = true;
                                        } else {
                                            $htmlFree = false;
                                        }
                                        $i++;
                                        $totalRate += round($value['rate'], 2);
                                        ?>
                                        <div class="row">
                                            <div class="col-md-5"><?php echo $i; ?>. <?php echo ucfirst($value['roomtype']); ?> - <?php echo $value['promotion_name']; ?></div>
                                            <div class="col-md-6">
                                                <?php echo $value['no_of_room']; ?> <?php echo Yii::t('lang', 'room') ?>&nbsp;&nbsp;
                                                <?php echo $value['adult']; ?> <?php echo Yii::t('lang', 'adult') ?>&nbsp;&nbsp;
                                                <?php echo $value['children']; ?> <?php echo Yii::t('lang', 'children') ?>&nbsp;&nbsp;
                                                <?= $value['currency']; ?> <?php echo number_format(round($value['rate'], 2), 2, '.', ','); ?>
                                            </div>
                                            <div class="col-md-1 no-padding-l right"><a href="javascript:void(0)" onclick="removecart(<?php echo $value['roomtype_id']; ?>, <?php echo $value['promotion_id']?>)"><?php echo Yii::t('lang', 'remove') ?></a></div>
                                        </div>

                                        <?php
                                    endforeach;
                                    $htmlContinue = '<button type="submit" class="btn btn-gray" name="btnContinue" id="btnContinue">' . Yii::t('lang', 'continue') . '</button>';
                                    $htmlContinue .= '<img src="' . Yii::app()->theme->baseUrl . '/images/loading.gif" class="continue_btn" style="float: right; display: none; width: 64px;" id="loading">';
                                    ?>
                                    <?php
                                else:
                                    $htmlContinue = '<button type="submit" class="btn btn-gray" name="btnContinue" id="btnContinue" disabled="disabled">' . Yii::t('lang', 'continue') . '</button>';
                                endif;
                            endif;
                            ?>
                            </div>
                            <div class="row bg cart-total">
                                <div class="col-md-6 col-xs-12 sub-total">
                                    <?php echo Yii::t('lang', 'sub_total') ?>: 
                                    <?php echo Yii::app()->session['change_currency'] ?> 
                                    <?php
                                    if (isset($totalRate)) {
                                        echo '<span id="term-amount-skip">'.number_format(round($totalRate, 2), 2, '.', ',').'</span>';
                                    } else {
                                        echo '<span id="term-amount-skip">0.00</span>';
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6 col-xs-12"><?php echo $htmlContinue ?></div>
                            </div>
                        </div>
                    </div>
            <?php $this->endWidget(); ?>
        </div>
        <!-- <div class="col-md-3 col-sm-12 col-xs-12 information">
            <div class="panel panel-default">
                <div class="panel-heading bg heading-title up"><?=Yii::t('lang', 'contact_info');?></div>
                <div class="panel-body">
                    <div class="hotel-details">
                        <?php
                            $address = json_decode($hotel->address, true);
                            $city = json_decode($hotel->city, true);
                            $country = json_decode($hotel->country, true);
                        ?>
                        <h5><?php echo $hotel['name'];?></h5>
                        <p>
                          <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
                          <span><?php echo $address[$lang].', '. $city[$lang].', '.$country[$lang];?></span>
                        </p>

                        <p>
                          <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                          <span><a href="tel:<?php echo $hotel['tel']?>"><?php echo $hotel['tel']?></a></span>
                          <span><?php echo $hotel['fax']?></span>
                        </p>

                        <p>
                          <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                          <span class="details-contact-txt"><a href="mailto:<?php echo $hotel['email_sales']?>"><?php echo $hotel['email_sales']?></a></span>
                        </p>

                        <div>
                          <a href="<?php echo $hotel['location']?>" target="_blank">
                            <img src="data:image/png;base64,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" alt="thumb-google-maps.png">
                            <span>View in Google Maps</span>
                          </a>
                        </div>

                      </div>
                </div>
            </div>
        </div> -->
    </div>
<?php
}else{
	echo '<div class="row" style="min-height:300px"><div class="col-md-12"><h2>We are available from 10 May 2016!</h2></div></div>';
}?>

<div class="show-tips">
    <p class="tip-message"><i class="glyphicon glyphicon-info-sign"></i> <span class="tip-message-content"> </span></p>
    <button class="tips-close">×</button>
</div>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery(".show-tips").fadeOut( "slow");
        setInterval(showtips, 12000);
        closetip();
    });

    function showtips() {
        var num = Math.floor(Math.random() * 99);
        if( num != 0){
            var tip01 = num + " travelers are looking at this property right now!";
            jQuery(".tip-message-content").html(tip01);
        }
       jQuery(".show-tips").toggle();
    }
    function closetip(){
        jQuery(".tips-close").click(function(){
            jQuery(".show-tips").fadeOut( "slow");
        });
    }
</script>