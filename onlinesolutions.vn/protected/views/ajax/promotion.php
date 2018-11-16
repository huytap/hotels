<?php $lang = Yii::app()->session['_lang'];
	$booked = Yii::app()->session['_available'];
	$roomtype = Roomtype::model()->findByPk($_GET['rtype']);
	$dailyRates = $booked[$roomtype['display_order']]['dailyRates'];
	$discount = $booked[$roomtype['display_order']]['promos']['promos_'.$_GET['pr']]['discount'];
	$flag_vat = Settings::model()->getSetting('include_vat', $roomtype['hotel_id']);
	$vat = $flag_vat == 'true'?1.155:1;
	//$night = $booked[$roomtype['display_order']]['bookedNights'];
?>
<div class="ajax-rooms white-popup-block">
		<h2><?php $name = json_decode($pr['name'], true);echo $name[$lang]?></h2>
		<hr>
	<div class="row">
		<div class="col-md-8">
			<p><strong><?=Yii::t('lang', 'cancellation');?></strong></p> 	
			<p><?php echo Yii::t('lang', $pr['cancel_1']); ?></p>
			<?php if($pr['cancel_2'] !== 'nosecondrule'){
				echo '<p>'.Yii::t('lang', $pr['cancel_2']).'</p>';
			}
			if($pr['cancel_3'] !== 'nothirdrule'){
				echo '<p>'.Yii::t('lang', $pr['cancel_3']).'</p>';
			}?>
			<?php
			$lang = Yii::app()->session['_lang'];
			$des = json_decode($pr['short_content'], true);
			if(isset($des[$lang]) && $des[$lang]){
				echo '<p><strong>Description</strong></p>';
				echo '<p>'.str_replace("\n", '<br>', $des[$lang]).'</p>';
			}?>
		</div>
		<?php if($dailyRates){?>
			<div class="col-md-4">
				<p><strong><?php echo Yii::t('lang', 'daily_rate_break_down');?></strong></p>
				<table>
					<tr>
						<td><?php echo Yii::t('lang', 'date');?></td>
						<td><?php echo Yii::t('lang', 'rate');?></td>
					</tr>
					<?php $i=1;
					foreach($dailyRates as $dr){
						if($i<=$pr['max_stay'] || $pr['max_stay']==0){
							$price = ($dr[$_GET['adult']]*(100-$discount)/100)*$vat;

							echo '<tr>';
								echo '<td>'.$dr['date'].'</td>';
								echo '<td>'.ExtraHelper::roundMoney3('VND',$price).'</td>';
							echo '</tr>';
						}else{
							$price = $dr[$_GET['adult']]*$vat;
							echo '<tr>';
								echo '<td>'.$dr['date'].'</td>';
								echo '<td>'.ExtraHelper::roundMoney3('VND',$price).'</td>';
							echo '</tr>';
						}
						$i++;
					}?>
				</table>
			</div>
		<?php }?>
	</div>
</div>
<style>
	.ajax-rooms{line-height: 20px!important;}
	.ajax-rooms {
		max-width:600px; margin: 20px auto; 
		background: #FFF; padding: 15px; line-height: 0;
		position: relative;
	}
	.ajax-rooms h2{
		font-weight: bold;
		margin: 0 0 5px 0;
		font-size: 16px;
	}
	.ajax-rooms p{
	    line-height: 20px;
	}
	td{border: 1px solid #ddd;padding: 5px;}
</style>