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
        <div class="col-md-6 col-sm-6"></div>
        <div class="col-md-6 col-sm-6 col-xs-12 no-padding right">
            <label class="text-rate"><?php echo Yii::t('lang', 'display_rate');?></label>
            <div class="td_select">
            <?php
                //echo CHtml::beginForm('', 'post', array('id' => 'formCurrency', "data-ajax" => "false", 'class'=>'form-inline td_select'));

                    echo CHtml::dropDownList('exchange_rate', Yii::app()->session['change_currency'], ExtraHelper::$currency, array('class' => 'number_select'));
                //echo CHtml::endForm(); 
            ?>
            </div>
        </div>
    </div> 
    <div class="row">
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
                <div class="panel-body" id="search">
                    <?php
                    if($params['rtype_pr']){
                        $this->renderPartial('_item_pr', compact(array('params','available')));
                    }else{
                        foreach($available as $room){
                            $photo = explode(',', $room['photos']);
                            //if(isset($room['promos']) && $room[1]>0 && 
                                //$room['available'] > 0){
                                $rowspan = count($room['promos']);
                                $max = 2;
                                $this->renderPartial('_item4', compact(array('max', 'params','room', 'photo')));
                        }
                    }
                    ?>
                </div>
            </div>                
        </div>
    </div>
<?php
}else{
    $this->renderPartial('_item_not_available');
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