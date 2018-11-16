<?php $lang = Yii::app()->session['_lang'];?>
<?php if (isset($params['fromDate'])) { ?>
    <script type="text/javascript" charset="utf-8">
        var fromDate = "<?php echo date('d M Y', strtotime($params['fromDate'])) ?>";
        var toDate = "<?php echo date('d M Y', strtotime($params['toDate'])) ?>";
    </script>
<?php }
?>
<div class="<?=$class?>">
    <div class="">
    <?php 
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'grid',
        'enableClientValidation' => true,
        'htmlOptions' => array(
            'class' => 'form-book',
        ),
    ));?>
        <div class="container">
            <input type="hidden" value="<?php if($_GET['chain_id']) echo $_GET['chain_id'];?>" id="FormBook_chain">
            <div class="row form-bk">
                <?php
                if(isset($_GET['chain_id']) && $_GET['chain_id']){
                    $hotels = Hotel::model()->getListByChain($_GET['chain_id']);  
                    if(count($hotels)>1)  {
                ?>
                <div class="col-sm-3 no-padding-l">
                    <div class="form-groups">
                        <label>Hotels</label>
                        <div class="date"><?php echo $form->dropDownList($model, 'hotel', $hotels, array('class' => 'form-control'));?></div>
                    </div>
                </div>
                <?php
                    }
                }                
                ?>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'checkin');?></label>
                        <div class="date" id="dpIn">
                            <?php echo $form->textField($model, 'checkin', array('class'=>'form-control datepicker', 'id' => 'check-in-date'));?>
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-3 col-xs-6">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'checkout');?></label>
                        <div class="date" id="dpOut">
                            <?php echo $form->textField($model, 'checkout', array('class'=>'form-control datepicker', 'id' => 'check-out-date'));?>
                            <span class="fa fa-calendar"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-sm-2 col-xs-6">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'adult');?></label>
                        <div class="date">
                            <?php echo $form->dropDownlist($model, 'adult', array(1=>1,2,3), array('class'=>'form-control'));?>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-sm-2 col-xs-6">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'children');?></label>
                        <div class="date">
                            <?php echo $form->dropDownlist($model, 'children', array(0,1,2), array('class'=>'form-control'));?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <div class="form-groups">
                        <label><?php echo Yii::t('lang', 'display_rate');?></label>
                        <div class="date"><?php echo CHtml::dropDownList('currency', $params['currency'], ExtraHelper::$currency, array('class' => 'form-control'));?></div>
                    </div>
                </div> 
                <div class="col-sm-3 col-xs-12">
                    <div class="form-groups">
                        <label>&nbsp;</label>
                        <div>
                            <button class="btn btn-booking" type="submit"><?php echo Yii::t('lang', 'Search');?></button>
                            <?php
                            if(Yii::app()->session['_hotel']){
                                $hotel = Yii::app()->session['_hotel'];
                            }else{
                                $hotel = Hotel::model()->getHotelByHotelID($_GET['hotel_id'], $_GET['chain_id']);
                            }
                            ?>
                            <a class="btn btn-link" href="<?php echo Yii::app()->baseUrl.'/booking/login/'.$hotel['hotel_id'].'/'.$hotel['chain_id']?>">Modify/Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--</form>-->
        </div>
    <?php $this->endWidget();?>
</div>

<?php
if(count($available)>0){?>
    <div class="col-md-12 col-sm-12 col-xs-12 booking-list" role="main">
        <div class="panel panel-default">
            <div class="panel-heading bg heading-title m-not-vai">
                <div class="row">
                    <div class="col-md-3 center">
                        <?php echo Yii::t('lang', 'roomtype')?>
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-5 col-xs-10 col-sm-5 center">Offers</div>
                        <div class="col-md-1 col-sm-1 col-xs-1 center">Max</div>
                        <div class="col-md-3 col-xs-6 center">Price per night</div>
                        <div class="col-md-1 col-xs-6 center">Rooms</div>
                        <div class="col-md-2 col-xs-6 center"></div>
                    </div>
                </div>
            </div>
            <div id="search">
                <?php
                if($params['rtype_pr']){
                    echo '<div class="panel-body">';
                        $this->renderPartial('_item_pr', compact(array('params','available')));
                    echo '</div>';
                }else{
                    foreach($available as $room){
                        echo '<div class="panel-body">';
                        $photo = explode(',', $room['photos']);
                        //if(isset($room['promos']) && $room[1]>0 && 
                            //$room['available'] > 0){
                            $rowspan = count($room['promos']);
                            $max = 2;
                            $this->renderPartial('_item4', compact(array('max', 'params','room', 'photo')));
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>                
    </div>
<?php
}else{
    $this->renderPartial('_item_not_available', compact('hotel'));
}?>

<!-- <div class="show-tips">
    <p class="tip-message"><i class="glyphicon glyphicon-info-sign"></i> <span class="tip-message-content"> </span></p>
    <button class="tips-close">×</button>
</div> 
<script type="text/javascript">
//if(window.width()>640){
    /*jQuery(document).ready(function() {
        jQuery(".show-tips").fadeOut( "slow");
        setInterval(showtips, 12000);
        closetip();
    });*/
//}

    /*function showtips() {
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
    }*/
</script>-->