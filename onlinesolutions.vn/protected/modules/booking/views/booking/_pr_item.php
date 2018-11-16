<?php
$room['max'] = $promo['max'];
$room['extraBed'] = $promo['extraBed'];?>
<div class="col-md-5 col-xs-10 col-sm-5 rate-result <?php echo $notshow?>">
	<div class="pr-name roomtypes" rel="<?php echo $promo['roomtype_id']?>">
		<span class="hotdeal"><?php echo $promo['name'] ?></span>
		<a class="show-cancellation" href="<?php echo Yii::app()->params['booking']?>ajax/loadRoom?roomtype_id=<?php echo $promo['roomtype_id']?>"><i class="glyphicon glyphicon-info-sign"></i></a>
	</div>
</div>
<?php $this->renderPartial('_people', compact(array('room', 'params')));?>
<div class="col-md-3 col-xs-6 rate rate-result">
	<span class="price-old">
		<?php 
			echo $promo['currency'] .' <span class="old">';
			echo number_format($promo['price'][$params['adult']],2 );
			//echo number_format($promo['prices'],2 );
		?>
	</span></span>
	<strong><?php echo $promo['currency'] ?></strong>  
	<img  style="width: 20px;text-align: center; clear: both;display:none" class="loading" src="<?php echo Yii::app()->baseUrl?>/images/loading.gif">
	<span class="currency-txt">
		<?php 
		if($room['increase']){
			echo number_format($promo[$params['adult']]+$room['increase'], 2) ;
		}else{
			echo number_format($promo[$params['adult']], 2);
		}
		?></span><br>
	(<?php echo Yii::t('lang', 'avg_daily') ?>)
</div>
<div class="col-md-1 col-sm-1 col-xs-3 rate-result center">
	<select class="rooms">
		<?php 
		if($flag){
			for($i=0;$i<=$promo['available'];$i++){
				echo '<option value="'.$i.'">'.$i.'</option>';
			}
		}else{
			echo '<option value="0">0</option>';
		}
		?>
	</select>
</div>