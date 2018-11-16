<?php $lang = Yii::app()->language;?>
<section class="sc-header-page">
	<?php $this->widget('HeaderWidget');?>
	<?php $this->widget('SliderWidget');?>
</section>
<section class="sc-aboutUs-pages wow fadeInUp">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="wp-aboutUs">
					<h3 class="tlePortlets">
						<font><span>Pandora</span> hotel</font>
					</h3>
					<h3 class="descontents">
						<?php 
							$des = json_decode($hotel['description'], true);
							echo $des[$lang];
						?>
					</h3>
					<!-- <div class="txt-location">
						<h3>Location:</h3>
						Carino Hotel Saigon is proudly situated in district 10 with easy access to Phu Tho Stadium, Tan Binh Exhibition and Convention Center (TBECC), China Town, Cao Thang Street Food Market and Satra Supermarket. The location is 2.8 away from Ben Thanh Market in downtown Saigon where almost all goods are sold for your shopping demands
					</div> -->
					<!--<div class="desicons">
						<p class="ct-wifis">
							Free
							<font>Wifi</font>
						</p>
						<p class="ct-friendlys">
							Welcoming
							<font>Friendly</font>
						</p>
						<p class="ct-meets">
							Meeting
							<font>Event space</font>
						</p>
						<p class="ct-fulls">
							Full
							<font>Facilities</font>
						</p>
					</div>-->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="wp-maps">												
					<div id="map_container"></div>
					<div id="map"></div>						
					<?php 
                        Yii::app()->clientScript->registerScriptFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDUsJ9tg6_qAszwcsYqr6yrQV-MguhaplU&v=3.exp&sensor=false', CClientScript::POS_END);
                        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/maps.js', CClientScript::POS_END);
                    ?>

				</div>
			</div>
		</div>
	</div>
</section>