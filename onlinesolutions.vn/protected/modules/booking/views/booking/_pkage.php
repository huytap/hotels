<?php $lang=Yii::app()->session['_lang'];?>
<div class="per-room">
	<div class="row">
		<div class="col-xs-12">
			<h4><a href="#"><?php echo $package['name']?></a></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-sm-12 col-xs-12">
	    	<?php echo '<img class="img-responsive" src="'.Yii::app()->baseUrl.'/uploads/cover/'.$package['cover_photo'].'">';?>
		</div>
		<div class="col-md-9 col-sm-12 col-xs-12 no-padding">
        	<div class="row promotions row-promos <?php //echo $notshow?>" rel="<?php echo $promo['promotion_id'] ?>">
		  		<div class="col-md-5 col-xs-12 col-sm-4 rate-result  <?php echo $notshow?>">
					
					<div class="pr-name"><?php echo $short[$lang];?></div>
					
				</div>
				<div class="col-md-3 col-xs-6 col-sm-3 rate rate-result m-right">
					<strong><?php echo $params['currency'] ?></strong>
					<span class="currency-txt">
						<?php echo number_format(ExtraHelper::roundMoney2($params['currency'],$package['rate']*$params['exchangeRates']),2);?></span>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-2 rate-result center m-no-padding">
					Rooms
					<?php echo CHtml::dropDownlist('room', $params['no_of_room'], ExtraHelper::makeNumberArray($package['available']), array('class' => 'rooms'));?>
				</div>
		  		<div class="col-md-3 col-sm-3 col-xs-4 col rate-result right m-no-padding"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
		  	</div>
		</div>
	</div>
</div>