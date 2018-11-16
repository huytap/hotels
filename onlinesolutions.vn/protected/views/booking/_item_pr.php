<?php 
if(count($available['rooms'])>0){
	$lang=Yii::app()->session['_lang'];
	$room = $available['promos'];
	$promos = $available['rooms'];
?>
<div class="per-room">
	<div class="row">
		<div class="col-md-3">
			<div class="roomtypes" rel="<?php echo $room['roomType']?>">
			    <div class="child" rel="#room_<?=$room['roomType']?>">
			    	<?php echo '<a class="show-room" href="'.Yii::app()->params['booking'].'ajax/pr_condition?pr='.$room['promotion_id'].'"><img class="img-responsive" src="'.Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/cover/'.$room['cover_photo'].'&w=248&h=140">';?>
			    	<span class="r-detail">[+] <?php echo Yii::t('lang', 'promotion_detail') ?></span></a>
			    	<h4><?=$room['promotion_name']?></h4>

			    </div>
			</div>
		</div>
		<div class="col-md-9 pr-list">
		<?php
		    $j = 1;
		    $html_available = $html_no_available = '';
		    $notshow="m-not-vai";
		    
			//$room['available'] = $available['rooms'][$params['roomtype']['order']]['available'];
			//$room['max'] = $params['roomtype']['max'];
			//echo"<pre>";print_r($room['available']);die;
		    foreach ($promos as $promo){$flag=true;
		    	?>
            	<div class="row promotions row-promos" rel="<?php echo $promo['promotion_id'] ?>">
			  		<?php $this->renderPartial('_pr_item', compact(array('promo', 'lang', 'params', 'flag', 'room')));?>
			  		<div class="col-md-3 col-xs-6 col rate-result right"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
			  	</div>
			<?php
		    }
		?>
		</div>
	</div>
</div>
<?php }else{
	echo '<div class="row" style="min-height:300px">'.
            '<div class="col-md-12"><h2>Customer Service</h2>' .
            '<p>The hotel is not available for your requested travel dates. It is either sold out or not yet open for reservations. Please choose other day or contact us via: <a href="mailto:reservations@ambassadorhotelgroup.com">reservations@ambassadorhotelgroup.com</a></div></div>';
}?>