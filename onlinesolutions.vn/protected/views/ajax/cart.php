<?php
$vat = $sc = $total = 0;
foreach($booked as $bk){
    $total_per_night = $bk['rate']*$bk['no_of_room']*$bk['nights'];
    //$html = '<div class="col-xs-6">'.Yii::t('lang', 'rate_per_night').'</div>';
    //$html .= '<div class="col-xs-6">'.$bk['currency'] .' '.ExtraHelper::roundMoney3('VND',$bk['rate']).'</div>';

    if(isset($bk['pickup'])){
        $total_per_night += $bk['pickup_price'];
        $html .= '<div class="col-xs-6">'.Yii::t('lang', 'airport_pickup').'</div>';
        $html .= '<div class="col-xs-6">'. $bk['currency'].' '.ExtraHelper::roundMoney3('VND',$bk['pickup_price']).'</div>';
    }
    if(isset($bk['drop_off'])){
        $total_per_night += $bk['drop_off_price'];
        $html .= '<div class="col-xs-6">'.Yii::t('lang', 'airport_drop_off').'</div>';
        $html .= '<div class="col-xs-6">'. $bk['currency'].' '. ExtraHelper::roundMoney3('VND',$bk['drop_off_price']).'</div>';
    }
    
    for($e=1;$e<=$bk['no_of_room'];$e++){
        if(isset($bk['extrabed'.$e])){
            $total_per_night += $bk['extrabed'.$e];
            $html .= '<div class="col-xs-6">Extrabed room '. $e.' per night</div>';
            $html .= '<div class="col-xs-6">'. $bk['currency'] .' '.ExtraHelper::roundMoney3('VND',$bk['extrabed'.$e]).'</div>';
        }
    }

    $vat += $total_per_night*0.1;
    $sc += ($total_per_night*0.1 + $total_per_night)*0.05;
    $total += $total_per_night*1.155;
}
?>
<?php echo $html;?>
<div class="col-xs-6 tax"><?php echo Yii::t('lang', 'sub_total');?></div>
<div class="col-xs-6 right"><?php echo $bk['currency']?> <?php echo ExtraHelper::roundMoney3('VND',$total_per_night);?></div>
<div class="col-xs-6 tax"><?php echo Yii::t('lang', 'vat');?> 10%</div>
<div class="col-xs-6 right"><?php echo $bk['currency']?> <?php echo ExtraHelper::roundMoney3('VND',$vat);?></div>
<div class="col-xs-6 tax"><?php echo Yii::t('lang', 'service_charge');?> 5%</div>
<div class="col-xs-6 right"><?php echo $bk['currency']?> <?php echo ExtraHelper::roundMoney3('VND',$sc);?></div>
<div class="col-xs-6"><b><?php echo Yii::t('lang', 'grand_total');?></b></div>
<div class="col-xs-6 right"><b><?php echo $bk['currency']?> <?php echo ExtraHelper::roundMoney3('VND',$total);?></b></div>