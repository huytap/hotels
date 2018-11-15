<?php $lang = Yii::app()->language;?>
<section class="sc-header-page">
	<?php $this->widget('HeaderWidget');?>
	<?php $this->widget('SliderWidget');?>
</section>
<section class="sc-title-page wow fadeInUp">
	<div class="container">
		<h3 class="tlePortlets">
			<font><span>Ambassador</span> Hotel Group</font>
			<?php 
				$des = json_decode(Settings::model()->getSetting('aboutus'), true);
				echo $des[$lang];
			?>
		</h3>
	</div>
</section>
<section class="sc-rooms-page wow fadeInUp">
	<div class="container">
		<ul class="lst-item">
			<?php
			foreach($hotels->getData() as $key => $hotel){
				$add = json_decode($hotel['address'], true);
				$city = json_decode($hotel['city'], true);
				$country = json_decode($hotel['country'], true);
				$offer = json_decode($hotel['special_offer'],true);?>
				<li <?php if($key==1) echo 'class="items-chan"';?>>
					<div class="images-preview">
						<ul class="preview-slider">
							<li><img src="<?php echo Yii::app()->baseUrl?>/uploads/cover/<?php echo $hotel['cover_photo'];?>" alt="" /></li>
						</ul>
					</div>
					<div class="content-preview">
						<h3><?php echo $hotel['name']?></h3>
						<div class="dv-infors">
							<p class="abr-map"><?php echo $add[$lang].', '.$city[$lang].', '.$country[$lang]?></p>
							<p class="abr-fone"><?php echo Yii::t('lang', 'Tel')?>: <?php echo $hotel['tel']?></p>
							<div class="abr-email">Email: <a href="mailto:<?php echo $hotel['email_sales']?>"><?php echo $hotel['email_sales']?></a></div>
						</div>
						<div class="dv-promotions">
							<?php echo $offer[$lang];?>
						</div>
						<div class="dv-tripadvisor">

						</div>
						
						<a class="btn-detail" href="<?php echo Yii::app()->baseUrl.'/'.$lang.'/'.$hotel['slug']?>.html">Go Website</a>
					</div>
				</li>
			<?php
			}?>
		</ul>
	</div>
</section>