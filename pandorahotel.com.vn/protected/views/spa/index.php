<?php 
    $lang  = Yii::app()->language;
?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>
<section class="sc-rooms wow fadeInUp">
	<div class="container">
		<h3 class="tlePortlets">
			<font><?php echo Yii::t('lang', 'Spa & Massage');?></font>
			<?php
				$content = json_decode(Settings::model()->getSetting('aspa'), true);
                echo $content[$lang];
            ?>
		</h3>

		<div class="row">
			<div class="col-sm-3 col-xs-4 colleft-services">
				<div class="img-thumbs">
					<img src="<?php echo Yii::app()->baseUrl?>/images/thumbnail.jpg" alt="" />
				</div>
			</div>
			<div class="col-sm-9 col-xs-8 colright-services">
				<div class="rightSpa">
					<table class="pricetbl">
						<tr>
							<th class="col1">Treatment in</th>
							<th class="col2">Time</th>
							<th class="col3">Price (VND)</th>
							<th class="col4">Price Promotion</th>
						</tr>
						<?php
						foreach($model->getData() as $data){
							$category = json_decode($data->name, true);?>

							<tr class="package">
								<td colspan="4"><?=$category[$lang]?></td>
							</tr>
							<?php 
							$items = Itemspa::model()->getList($category);
							foreach($items->getData() as $item){
								$itemname = json_decode($item->name, true);?>
								<tr>
									<td class="col1"><?=$itemname[$lang]?></td>
									<td class="col2"><?=$item['hours']?></td>
									<td class="col3 <?php if($item['price_discount']) echo 'hasprom';?>"><?=$item['price']?></td>
									<td class="col4"><?=$item['price_discount']?></td>
								</tr>
							<?php }
						}?>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>