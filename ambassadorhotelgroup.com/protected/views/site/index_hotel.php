<?php 
	$lang = Yii::app()->language;
	$other_name = json_decode($getHotel['other_name'], true);
    $specials = Offer::model()->getList($getHotel['id']);
    $services = Cms::model()->getList('services', $getHotel['id']);
?>
<style>
.sc-aboutUs-home .txtAbout-home .wp-aboutUs .titleAbouts font {
    color: #ffc20e;
}
.sc-aboutUs-home .txtAbout-home .wp-aboutUs .titleAbouts{
    color: #444;
    text-transform: uppercase;
    font:32px/32px SegoeUI-SemiBold;
}
.wp-aboutUs .titleAbouts p{
	font:20px/30px SegoeUI-Light;
	text-transform: none;
}
</style>
<section class="sc-header-slide">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
    
    <?php $this->widget('FormbookWidget');?>
    
</section>
<section class="sc-aboutUs-home wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 txtAbout-home">
                <div class="wp-aboutUs">
                    <h2 class="titleAbouts">
                        <p><?php echo Yii::t('lang', 'About us');?></p>
                        <?php echo $other_name[$lang];?>
                    </h2>
                    <div class="descontents">
                        <?php
                        $des= json_decode($getHotel['description'], true);
                        echo $des[$lang];
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 mapAbout-home">
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

<section class="sc-facilities-group wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Rooms & Suites');?></font>
            <?php 
                $roomdescription = json_decode(Settings::model()->getSetting('room_des'), true);
                echo $roomdescription[$lang];
             ?>
        </h3>
        <div class="list_carousel responsive">
            <ul id="carouselFacilities">
                <?php
                foreach($rooms->getData() as $room){?>
                    <li>
                        <a href="<?php echo Yii::app()->baseUrl?>/<?php echo $lang.'/'.$getHotel['slug']?>/rooms/<?php echo $room['slug']?>" >
                            <div class="wrap-thumb"><img src="<?php echo Yii::app()->baseUrl?>/uploads/cover/<?php echo $room['cover_photo']?>" alt="<?php echo $room['name']?>" /></div>
                            <h4>
                                <font><?php echo $room['name']?></font>
                                <?php
                                    $roomdes = json_decode($room['description'], true);
                                    echo $roomdes[$lang];
                                ?>
                            </h4>
                            <span class="likmores"><?php echo Yii::t('lang', 'View Detail');?></span>
                        </a>
                    </li>
                <?php }?>
            </ul>
            <a id="prev1" class="prev"></a>
            <a id="next1" class="next"></a>
        </div>
    </div>
</section>
<?php
if(count($services->getData())>0){?>
<section class="sc-rooms-group wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Hotel <span>Facilities</span>');?></font>
            <?php 
                $hotelfac = json_decode(Settings::model()->getSetting('facilites'), true);
                echo $hotelfac[$lang];
             ?>
        </h3>
        <div class="list_carousel responsive">
            <ul id="carouselRooms">
                <?php
                
                foreach($services->getData() as $service){
                    $title = json_decode($service['title'], true);
                    $short = json_decode($service['short'], true);?>
                    <li>
                        <a href="<?php echo Yii::app()->baseUrl.'/'.$lang.'/services/'.$service['slug']?>">
                            <div class="wrap-thumb"><img src="<?php echo Yii::app()->baseUrl?>/uploads/cover/<?php echo $service['cover_photo']?>" alt="<?php echo $title[$lang]?>" class="img-responsive"/>
                            </div>
                            <h4>
                                <font><?php echo $title[$lang]?></font>
                                <?php echo $short[$lang]?>
                            </h4>
                        </a>
                    </li>
                <?php }?>
            </ul>
            <a id="prev2" class="prev"></a>
            <a id="next2" class="next"></a>
        </div>
    </div>
</section>
<?php
}
if(count($specials->getData())>0){?>
<section class="sc-specials-group wow fadeInUp">
	<div class="container">
		<h3 class="tlePortlets">
			<?php echo Yii::t('lang', '<font><span>Special</span> offers</font>');?>
		</h3>
		<div class="list_carousel responsive">
			<ul id="carouselSpecials">
				<?php
                
                foreach($specials->getData() as $service){
                    $title = json_decode($service['title'], true);
                    $short = json_decode($service['short_description'], true);?>
                    <li>
                        <a href="<?php echo Yii::app()->baseUrl.'/'.$lang.'/services/'.$service['slug']?>">
                            <div class="wrap-thumb"><img src="<?php echo Yii::app()->baseUrl?>/uploads/cover/<?php echo $service['cover_photo']?>" alt="<?php echo $title[$lang]?>" class="img-responsive"/>
                            </div>
                            <h4>
                                <font><?php echo $title[$lang]?></font>
                                <?php echo $short[$lang]?>
                            </h4>
                            <span class="likmores">Đặt phòng</span>
                        </a>
                    </li>
                <?php }?>
			</ul>
			<a id="prev3" class="prev"></a>
			<a id="next3" class="next"></a>
		</div>
	</div>
</section>	
<?php
}
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/inout.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('slide', "
    $('.bxslider').bxSlider({
        auto: true,
        mode: 'fade',
        responsive: true,
        controls: false
    });
    $('#carouselFacilities').carouFredSel({
        responsive: true,
        width: '100%',
        scroll: 1,
        auto: false,
        prev: '#prev2',
        next: '#next2', 
        items: {
            width: 480,
            visible: {
                min: 1,
                max: 6
            }
        }
    });
	
		$('#carouselRooms').carouFredSel({
			responsive: true,
			width: '100%',
			scroll: 1,
			auto: false,
			prev: '#prev1',
			next: '#next1',	
			items: {
				width: 480,
				visible: {
					min: 1,
					max: 6
				}
			}
		});
		/*$('#carouselFacilities').carouFredSel({
			responsive: true,
			width: '100%',
			scroll: 1,
			auto: false,
			prev: '#prev2',
			next: '#next2',	
			items: {
				width: 480,
				visible: {
					min: 1,
					max: 6
				}
			}
		});*/
		$('#carouselSpecials').carouFredSel({
			responsive: true,
			width: '100%',
			scroll: 1,
			auto: false,
			prev: '#prev3',
			next: '#next3',	
			items: {
				width: 480,
				visible: {
					min: 1,
					max: 6
				}
			}
		});
		", CClientScript::POS_END);
?>