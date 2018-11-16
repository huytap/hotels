<?php
$j = 1;
$html_available = $html_no_available = '';
$notshow="m-not-vai";
foreach ($room['promos'] as $promo){
    $p_des = json_decode($promo['short_content'], true);
    if ($promo['promotion_type'] == 'early_bird') {
        if ($promo['today'] < $promo['no_of_day'] && 
            $promo['max_stay'] == 0) {$flag=0;?>
            <div class="row promotions row-promos <?php echo $notshow?>" rel="<?php echo $promo['promotion_id'] ?>">
                <?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                <div class="col-md-2 col-xs-6 col rate-result"><span class="right btn-disabled"><?php echo str_replace(0, $promo['no_of_day'], Yii::t('lang', 'require_checkin')); ?></span></div>
            </div>
        <?php
        } elseif($promo['max_stay']>$promo['min_stay'] && 
                $promo['max_stay']<$promo['bookedNights']) { $flag=1;?>
            <div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
                <?php $this->renderPartial('_promotion_item_max', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                <div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
            </div>
        <?php
        }else {$flag=1;?>
            <div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
                <?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                <div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
            </div>
        <?php
        }
    }
    elseif ($promo['promotion_type'] == 'last_minutes') {
        if ($promo['today'] > $promo['no_of_day']) {$flag=0;?>                  
            <div class="row promotions row-promos <?php echo $notshow?>" rel="<?php echo $promo['promotion_id'] ?>">
                <?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                <div class="col-md-2 col-xs-6 col rate-result"><span class="right btn-disabled"><?php echo str_replace(0, $promo['no_of_day'], Yii::t('lang', 'last_1')); ?></span></div>
            </div>
            <?php
        } else {$flag=1;?>
            <div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
                <?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                <div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
            </div>
        <?php
        }
    }elseif ($promo['promotion_type'] == 'others') {
        if ($promo['min_stay'] > 1) {
            if ($promo['bookedNights'] < $promo['min_stay'] || $promo['bookedNights'] < $promo['min_stay']) {
                $flag=0;?>
                <div class="row promotions row-promos <?php echo $notshow?>" rel="<?php echo $promo['promotion_id'] ?>">
                    <?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                    <div class="col-md-2 col-xs-6 col rate-result"><span class="right btn-disabled"><?php echo str_replace(0, $promo['min_stay'], Yii::t('lang', 'last_0')); ?></span></div>
                </div>
                
            <?php } elseif ($promo['bookedNights'] >= $promo['min_stay'] || 
                            $promo['bookedNights'] <= $promo['nightTo'] && $promo['bookedNights'] >= $promo['min_stay']) { 
                                $flag=1;?>
                <div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
                    <?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                    <div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
                </div>
            <?php
                
            }else {$flag=0;
                ?>
                <div class="row promotions row-promos <?php echo $notshow?>" rel="<?php echo $promo['promotion_id'] ?>">
                    <?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                    <div class="col-md-2 col-xs-12 col rate-result center"><?php echo str_replace(0, $promo['min_stay'], Yii::t('lang', 'last_1')); ?></div>
                </div>
                <?php
            }
        } else {
                $flag=1;
            ?>
            <div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
                <?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                <div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
            </div>
            <?php
        }
    }elseif ($promo['promotion_type'] == 'deal' && 
        strtotime($promo['start_deal_date'])<= strtotime(date('Y-m-d')) && 
        strtotime($promo['end_deal_date']) >= strtotime(date('Y-m-d'))){
        if ($promo['bookedNights'] >= $promo['min_stay']){ 
            $flag=1;?>
                <div class="row promotions row-promos deals" rel="<?php echo $promo['promotion_id'] ?>">
                    <?php $this->renderPartial('_promotion_deal', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                    <div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
                </div>                          
    <?php
        } 
    }elseif($promo['promotion_type'] == 'package'){
        if ($promo['min_stay'] > 1) {
            if ($promo['bookedNights'] < $promo['min_stay'] || $promo['bookedNights'] < $promo['min_stay']) {
                $flag=0;?>
                <div class="row promotions row-promos <?php echo $notshow?>" rel="<?php echo $promo['promotion_id'] ?>">
                    <?php $this->renderPartial('_package', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                    <div class="col-md-2 col-xs-6 col rate-result"><span class="right btn-disabled"><?php echo str_replace(0, $promo['min_stay'], Yii::t('lang', 'last_0')); ?></span></div>
                </div>
                
            <?php } elseif ($promo['bookedNights'] >= $promo['min_stay'] || 
                            $promo['bookedNights'] <= $promo['nightTo'] && $promo['bookedNights'] >= $promo['min_stay']) { 
                                $flag=1;?>
                <div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
                    <?php $this->renderPartial('_package', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                    <div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
                </div>
            <?php
                
            }else {$flag=0;
                ?>
                <div class="row promotions row-promos <?php echo $notshow?>" rel="<?php echo $promo['promotion_id'] ?>">
                    <?php $this->renderPartial('_package', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                    <div class="col-md-2 col-xs-12 col rate-result center"><?php echo str_replace(0, $promo['min_stay'], Yii::t('lang', 'last_1')); ?></div>
                </div>
                <?php
            }
        } else {
            $flag=1;
            ?>
            <div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
                <?php $this->renderPartial('_package', compact(array('promo', 'p_des', 'room', 'lang', 'params', 'flag')));?>
                <div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
            </div>
            <?php
        }
    }
    $j++;
}?>