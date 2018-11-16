<div class="col-md-5 col-xs-12 col-sm-4 rate-result">
	<div class="pr-name">
		<span class="hotdeal"><?php echo $promo['promotion_name'] ?></span>
		<a class="show-cancellation" href="<?php echo Yii::app()->params['booking']?>ajax/pr_condition?pr=<?=$promo['promotion_id'];?>&rtype=<?php echo $promo['roomtype_id']?>&adult=<?php echo $params['adult']?>"><i class="glyphicon glyphicon-info-sign"></i></a>
	</div>
</div>
<?php $this->renderPartial('_people', compact(array('room', 'params')));?>
<div class="col-md-3 col-xs-9 col-sm-3 rate rate-result">
	<span class="price-old">
		<?php 
			echo $room['currency'] .' <span class="old">';
			echo number_format($room[$params['adult']]+$promo['increase'],2 );
			//echo number_format($room['prices'],2 );
		?>
	</span></span>
	<strong><?php echo $room['currency'] ?></strong>  
	<img  style="width: 20px;text-align: center; clear: both;display:none" class="loading" src="<?php echo Yii::app()->baseUrl?>/images/loading.gif">
	<span class="currency-txt">
		<?php 
			echo number_format($promo[$params['adult']]+$promo['increase'], 2) ;
			//echo number_format($promo['prices']+$promo['increase'], 2)
		?>
	</span><br>
	(<?php echo Yii::t('lang', 'avg_daily') ?>)
</div>
<div class="col-md-1 col-sm-1 col-xs-3 rate-result center">
	<select class="rooms">
		<?php 
		if($flag){
			for($i=0;$i<=$room['available'];$i++){
				echo '<option value="'.$i.'">'.$i.'</option>';
			}
		}else{
			echo '<option value="0">0</option>';
		}
		?>
	</select>
</div>
	
