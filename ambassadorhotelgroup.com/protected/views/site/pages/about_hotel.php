<?php 
	$lang = Yii::app()->language;
	$other_name = json_decode($getHotel['other_name'], true);
?>
<style type="text/css">
	.sc-ourhotel .wrap-ourhotel h3 font {
	    color: #ffc20e;
	    display: inline-block;
	}
	.sc-ourhotel .wrap-ourhotel h3{
		 font: 28px/30px SegoeUI-Semibold;
	    color: #000;
	    text-transform: uppercase;
	    padding: 10px 0;
	    margin: 0;
	}
	.wp-maps:before{
		border:0;
	}
	.wp-maps #map{
		height: 580px;
	}
</style>
<section class="sc-header-page">
	<?php $this->widget('HeaderWidget');?>
	<?php $this->widget('SliderWidget');?>
</section>
<section class="sc-ourhotel sc-title-page wow fadeInUp">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="wrap-ourhotel">
					<h3 class="tlePortlets">
						<?php
						echo $other_name[$lang];
						?>
					</h3>
					<div class="descontents">
						<?php 
							$des = json_decode($getHotel['description'], true);
							echo $des[$lang];
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="sc-rooms-page wow fadeInUp">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="wp-maps">												
					<div id="map_container"></div>
					<div id="map"></div>						
					<?php 
                        Yii::app()->clientScript->registerScriptFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDUsJ9tg6_qAszwcsYqr6yrQV-MguhaplU&v=3.exp&sensor=false', CClientScript::POS_END);

                        Yii::app()->clientScript->registerScript('map', "
                        	var MY_MAPTYPE_ID = 'custom_style';
							function initialize() {
									var myLatlng = new google.maps.LatLng(".$getHotel["lat"].",".$getHotel['lng'].");
									var imagePath = '".Yii::app()->baseUrl."/images/iconmaps.png'
									var featureOpts = [ { 'stylers': [ { 'saturation': -100 }, {'lightness': -5 } ] } ];
									var mapOptions = {
										zoom: 16,
										center: myLatlng,
										mapTypeId: MY_MAPTYPE_ID				
									}

								var map = new google.maps.Map(document.getElementById('map'), mapOptions);
								var customMapType = new google.maps.StyledMapType(featureOpts);
									map.mapTypes.set(MY_MAPTYPE_ID, customMapType);

								

								//Add Marker
								var marker = new google.maps.Marker({
									position: myLatlng,
									map: map,
									icon: imagePath
								});

								//Resize Function
								google.maps.event.addDomListener(window, 'resize', function() {
									var center = map.getCenter();
									google.maps.event.trigger(map, 'resize');
									map.setCenter(center);
								});
							}

							google.maps.event.addDomListener(window, 'load', initialize);",CClientScript::POS_END);
                    ?>

				</div>
			</div>
		</div>
	</div>
</section>