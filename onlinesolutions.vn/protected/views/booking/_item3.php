<?php $lang=Yii::app()->session['_lang'];?>
<div class="per-room">
	<div class="row">
		<div class="col-md-3 col-sm-6">
			<div class="roomtypes" rel="<?php echo $room['roomType']?>">
			    <div class="child" rel="#room_<?=$room['roomType']?>">
			    	
			    	<?php echo '<a class="show-room" href="'.Yii::app()->params['booking'].'ajax/loadRoom?roomtype_id='.$room['roomType'].'"><img class="img-responsive" src="'.Yii::app()->baseUrl.'/uploads/slide/'.$room['photos'].'">';?>
			    	<span class="r-detail">[+] <?php echo Yii::t('lang', 'room_detail') ?></span></a>
			        <h4><a class="show-room" href="<?php echo Yii::app()->params['booking']?>ajax/loadRoom?roomtype_id=<?php echo $room['roomType']?>"><?=$room['roomName']?></a></h4>
			        <p>
			        	<!-- <span class="available" id="<?php //echo $room['roomName'] . '_' . $room['available'] . '_' . $room['fromDate'] ?>"><?php echo $room['available'] ?></span> 
			            <?php //echo Yii::t('lang', 'room_left'); ?><br> -->
			            <?php echo Yii::t('lang', 'size_room')?>: <?php echo $room['roomSize']?></p>
			            <p><?php echo Yii::t('lang', 'bedding')?>: 
			            <?php 
			            $bed = explode(',', $room['bed']);
			            	$bb=0;
			            	foreach($bed as $b){
			            		echo Yii::t('lang', $b);
			            		if($bb<count($bed)-1){
			            			echo ', ';
			            		}
			            		$bb++;
			            	}
			            ?> </p>
			            <p><?php echo Yii::t('lang', 'view')?>: <?php echo Yii::t('lang', $room['view'])?></p>
			    </div>
			</div>
		</div>
		<div class="col-md-9 paddingt15">
			<!-- <div class="col-md-3">
				<img class="img-responsive" src="<?php echo Yii::app()->baseUrl?>/uploads/slide/<?php echo $room['photos']?>">
			</div> -->
		<?php
		    $j = 1;
		    $html_available = $html_no_available = '';
		    $notshow="m-not-vai";
		    foreach ($room['promos'] as $promo){
		    	$p_des = json_decode($promo['short_content'], true);
		        if (isset($promo['promotion_type']) && $promo['min_stay'] >= 1) {
		            if ($promo['promotion_type'] == 'early_bird') {
		                if($promo['max_stay']>$promo['min_stay'] && $promo['max_stay']<$promo['bookedNights']) {?>
							<div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
						  		<?php $this->renderPartial('_promotion_item_max', compact(array('promo', 'p_des', 'room', 'lang', 'params')));?>
						  		<div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
						  	</div>
	                    <?php
		                }else {?>
							<div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
						  		<?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params')));?>
						  		<div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
						  	</div>
	                    <?php
		                }
		            }
		            elseif ($promo['promotion_type'] == 'last_minutes') {
		                if ($promo['today'] > $promo['no_of_day']) {?>					
							
		                    <?php
		                } else {?>
							<div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
						  		<?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params')));?>
						  		<div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
						  	</div>
	                    <?php
		                }
		            }elseif ($promo['promotion_type'] == 'others') {
		                if ($promo['min_stay'] > 1) {
		                    if ($promo['bookedNights'] < $promo['min_stay'] || $promo['bookedNights'] < $promo['min_stay']) {
								
		                    } elseif ($promo['bookedNights'] >= $promo['min_stay'] || 
		                    				$promo['bookedNights'] <= $promo['nightTo'] && $promo['bookedNights'] >= $promo['min_stay']) { ?>
		                       	<div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
							  		<?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params')));?>
							  		<div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
							  	</div>
							<?php
								
		                    }else {
		                    }
		                } else {

		                    ?>
		                    <div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
						  		<?php $this->renderPartial('_promotion_item', compact(array('promo', 'p_des', 'room', 'lang', 'params')));?>
						  		<div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
						  	</div>
		                    <?php
		                }
		            }elseif ($promo['promotion_type'] == 'deal' && 
		            	strtotime($promo['start_deal_date'])<= strtotime(date('Y-m-d')) && 
		            	strtotime($promo['end_deal_date']) >= strtotime(date('Y-m-d'))){
						if ($promo['bookedNights'] >= $promo['min_stay']){ ?>
		                       	<div class="row promotions row-promos deals" rel="<?php echo $promo['promotion_id'] ?>">
							  		<?php $this->renderPartial('_promotion_deal', compact(array('promo', 'p_des', 'room', 'lang', 'params')));?>
							  		<div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
							  	</div>							
	                <?php
	                    } 
		            }elseif($promo['promotion_type'] == 'package'){
		            	if ($promo['min_stay'] > 1) {
		                    if ($promo['bookedNights'] < $promo['min_stay'] || $promo['bookedNights'] < $promo['min_stay']) {
		                    } elseif ($promo['bookedNights'] >= $promo['min_stay'] || 
		                    				$promo['bookedNights'] <= $promo['nightTo'] && $promo['bookedNights'] >= $promo['min_stay']) { ?>
		                       	<div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
							  		<?php $this->renderPartial('_package', compact(array('promo', 'p_des', 'room', 'lang', 'params')));?>
							  		<div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
							  	</div>
							<?php
								
		                    }else {
		                        
		                    }
		                } else {

		                    ?>
		                    <div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
						  		<?php $this->renderPartial('_package', compact(array('promo', 'p_des', 'room', 'lang', 'params')));?>
						  		<div class="col-md-2 col-xs-12 col rate-result center"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
						  	</div>
		                    <?php
		                }
		            }
		            $j++;
		        }
		    }
		?>
		</div>
	</div>
</div>