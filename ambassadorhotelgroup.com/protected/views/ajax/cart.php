<?php
$vat = $sc = $total = 0;
foreach($booked as $bk){
    $total_per_night = $bk['rate']*$bk['no_of_room']*$bk['nights'];
    //$html = '<div class="col-xs-6">'.Yii::t('lang', 'rate_per_night').'</div>';
    //$html .= '<div class="col-xs-6">'.$bk['currency'] .' '.number_format($bk['rate'],2).'</div>';

    if(isset($bk['pickup'])){
        $total_per_night += $bk['pickup_price'];
        $html .= '<div class="col-xs-6">'.Yii::t('lang', 'airport_pickup').'</div>';
        $html .= '<div class="col-xs-6">'. $bk['currency'].' '.number_format($bk['pickup_price'],2).'</div>';
    }
    if(isset($bk['drop_off'])){
        $total_per_night += $bk['drop_off_price'];
        $html .= '<div class="col-xs-6">'.Yii::t('lang', 'airport_drop_off').'</div>';
        $html .= '<div class="col-xs-6">'. $bk['currency'].' '. number_format($bk['drop_off_price'],2).'</div>';
    }
    
    for($e=1;$e<=$bk['no_of_room'];$e++){
        if(isset($bk['extrabed'.$e])){
            $total_per_night += $bk['extrabed'.$e];
            $html .= '<div class="col-xs-6">Extrabed room '. $e.' per night</div>';
            $html .= '<div class="col-xs-6">'. $bk['currency'] .' '.number_format($bk['extrabed'.$e],2).'</div>';
        }
    }

    $vat += $total_per_night*0.1;
    $sc += ($total_per_night*0.1 + $total_per_night)*0.05;
    $total += $total_per_night*1.155;
}
?>
<?php echo $html;?>
<div class="col-xs-6 tax"><?php echo Yii::t('lang', 'sub_total');?></div>
<div class="col-xs-6 right"><?php echo $bk['currency']?> <?php echo number_format($total_per_night,2);?></div>
<div class="col-xs-6 tax"><?php echo Yii::t('lang', 'vat');?> 10%</div>
<div class="col-xs-6 right"><?php echo $bk['currency']?> <?php echo number_format($vat,2);?></div>
<div class="col-xs-6 tax"><?php echo Yii::t('lang', 'service_charge');?> 5%</div>
<div class="col-xs-6 right"><?php echo $bk['currency']?> <?php echo number_format($sc,2);?></div>
<div class="col-xs-6"><b><?php echo Yii::t('lang', 'grand_total');?></b></div>
<div class="col-xs-6 right"><b><?php echo $bk['currency']?> <?php echo number_format($total,2);?></b></div>