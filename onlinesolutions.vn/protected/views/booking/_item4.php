<?php $lang=Yii::app()->session['_lang'];?>
<div class="per-room">
	<div class="row">
		<div class="col-md-3 col-sm-6 no-padding-r">
			<div class="roomtypes" rel="<?php echo $room['roomType']?>">
			    <div class="child" rel="#room_<?=$room['roomType']?>">
			    	
			    	<?php echo '<a class="show-room" href="'.Yii::app()->params['booking'].'ajax/loadRoom?roomtype_id='.$room['roomType'].'"><img class="img-responsive" src="'.Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/cover/'.$room['photos'].'&w=248&h=140">';?>
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
		<?php
		    $this->renderPartial('_item_available', compact(array('room', 'params')));
		?>
		</div>
	</div>
</div>