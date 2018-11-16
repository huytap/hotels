<?php
$vat = $sc = $total = $extras = 0;
    $total_per_night = $booked['rate']*$booked['no_of_room']*$booked['nights'];
    //$html = '<div class="col-md-12 col-sm-12 col-xs-12">'.Yii::t('lang', 'rate_per_night').'</div>';
    //$html .= '<div class="col-md-12 col-sm-12 col-xs-12">'.$booked['currency'] .' '.number_format($booked['rate'],2).'</div>';

    if(isset($booked['pickup'])){
        //$total_per_night += $booked['pickup_price'];
        $extras += $booked['pickup_price'];
        /*$html .= '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><strong>'.Yii::t('lang', 'airport_pickup').': </strong>';
        $html .= '<span class="pull-right">'. $booked['currency'].' '.number_format($booked['pickup_price'],2).'</span>';
        $html .= '</div></div>';*/
    }
    if(isset($booked['drop_off'])){
       // $total_per_night += $booked['drop_off_price'];
        $extras += $booked['drop_off_price'];
        /*$html .= '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><strong>'.Yii::t('lang', 'airport_drop_off').': </strong>';
        $html .= '<span class="pull-right">'. $booked['currency'].' '. number_format($booked['drop_off_price'],2).'</span>';
        $html .= '</div></div>';*/
    }
    $room=Roomtype::model()->findByPk($booked['roomtype_id']);
    for($e=1;$e<=$booked['no_of_room']*$room['no_of_extrabed'];$e++){
        if(isset($booked['extrabed'.$e])){
            //$total_per_night += $booked['extrabed'];
            $extras += $booked['extrabed'.$e];
            //$html .= '<div class="row"><div class="col-md-12 col-sm-12 col-xs-12"><strong>'. Yii::t('lang', 'extrabed').': </strong>';
            //$html .= '<span class="pull-right">'. $booked['currency'] .' '.number_format($booked['extrabed'.$e],2).'</span></div>';
        }
    }

    if(isset($booked['packages'])){
        $pk_pr=0;
        $pr = Promotion::model()->findByPk($booked['promotion_id']);
        $p_pk = explode(',', $pr->packages);
        foreach($booked['packages'] as $pkey => $pk){
            $price_adult=$price_child=0;
            if(!in_array($pkey, $p_pk)){
                $pk_pr = $pk['price_adult']+$pk['price_child'];
                /*$price_adult = $_POST['pk_adult']*$p['rate']*$booked['exchangeRate'];
                $price_child = $_POST['pk_child']*$p['rate_child']*$booked['exchangeRate'];*/
                ?>
                <script type="text/javascript">
                    //var pk_pr = '<?php echo $booked["currency"] .' '. number_format($pk_pr, 2);?>';
                    $('.pack'+<?php echo $pkey?>).show();
                    $('.pack'+<?php echo $pkey?>).find('.pkprice').text('<?php echo number_format($pk_pr,2);?>')
                </script>
            <?php
            }
            //$pk_pr += ($price_adult+$price_child);
            $extras += $pk_pr;
        }
        ?>
        
        <?php
    }
    $vat += ($total_per_night+$extras)*0.1;
    $sc += (($total_per_night+$extras)*0.1 + ($total_per_night+$extras))*0.05;
    $total += ($total_per_night+$extras)*1.155;
    echo $html;?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"><strong><?php echo Yii::t('lang', 'room_extras');?>: </strong>
        <span class="pull-right"><?php echo $booked['currency']?> <?php echo number_format($extras,2);?></span>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"><strong><?php echo Yii::t('lang', 'sub_total');?>: </strong>
        <span class="pull-right"><?php echo $booked['currency']?> <?php echo number_format($total_per_night,2);?></span>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"><strong><?php echo Yii::t('lang', 'vat');?> 10%: </strong> <span class="pull-right"><?php echo $booked['currency']?> <?php echo number_format($vat,2);?></span></div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"><strong><?php echo Yii::t('lang', 'service_charge');?> 5%:</strong> <span class="pull-right"><?php echo $booked['currency']?> <?php echo number_format($sc,2);?></span></div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"><b><?php echo Yii::t('lang', 'grand_total');?></b>: <span class="pull-right"><b><?php echo $booked['currency']?> <?php echo number_format($total,2);?></b></span>    </div>
</div>