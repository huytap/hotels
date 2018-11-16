<?php $lang=Yii::app()->session['_lang'];

$rowspan = count($room['promos']);
$max = 2;
?>
<div class="per-room">
	<div class="row roomtypes" rel="<?php echo $room['roomType']?>">
	    <div class="col-md-4 col-sm-6 col-xs-8 child" rel="#room_<?=$room['roomType']?>">
	        <h4><a class="show-room" href="<?php echo Yii::app()->params['booking']?>ajax/loadRoom?roomtype_id=<?php echo $room['roomType']?>"><?=$room['roomName']?></a></h4>
	        <span class="room-left">
	        <span class="available" id="<?php echo $room['roomName'] . '_' . $room['available'] . '_' . $room['fromDate'] ?>"><?php echo $room['available'] ?></span> 
	            <?php echo Yii::t('lang', 'room_left'); ?>
	        </span>
	    </div>
	    <div class="col-md-2 col-sm-6 col-xs-4 padding-t7"><a class="show-room romm-detail" href="<?php echo Yii::app()->params['booking']?>ajax/loadRoom?roomtype_id=<?php echo $room['roomType']?>">[+] <?php echo Yii::t('lang', 'room_detail') ?></a></div>
	    <div class="col-md-6 col-sm-12 col-xs-12 td_select padding-t7 number">
	        <?php echo Yii::t('lang', 'no_of_room') ?>	
            <select class="no_room">
            	<?php
                for ($i = 1; $i <= $room['available']; $i++) {
                    if ($i == 1)
                        echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
                    else
                        echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
            </select>
			<?php //echo Yii::t('lang', 'adult') ?>
            <!--<select class="adult-number">
            	<?php
                /*for ($i = 1; $i <= $room['max']; $i++) {
                    if ($i == ($room['max'] - 1))
                        echo '<option value="' . $i . '" selected="selected">' . $i . '</option>';
                    else
                        echo '<option value="' . $i . '">' . $i . '</option>';
                }*/
                ?>
            </select>
			<?php //echo Yii::t('lang', 'children') ?>
            <select class="children-number" rel="<?php //echo $value['extraBed'];?>">
            	<?php
                /*for ($i = 0; $i <= $room['children']; $i++) {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }*/
                ?>
            </select>-->
		</div>
	</div>
	<div class="pr">
	<?php
	    foreach ($room['promos'] as $promo){
	    	$p_des = json_decode($promo['short_content'], true);
	    	if ($promo['promotion_type'] == 'deal' && 
	            	strtotime($promo['start_deal_date'])<= strtotime(date('Y-m-d')) && 
	            	strtotime($promo['end_deal_date']) >= strtotime(date('Y-m-d'))){
	    		$this->renderPartial('_promotion_deal', compact(array('promo', 'p_des', 'room', 'lang')));
	    	}elseif($promo['promotion_type'] == 'package'){
	    		$this->renderPartial('_package', compact(array('promo', 'p_des', 'room', 'lang')));
	    	}else{
	    		$this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang')));
	    	}
	    }
	?>
	</div>
</div>