<?php $lang = Yii::app()->language;?>

<section class="sc-header-slide">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
    
    <?php $this->widget('FormbookWidget');?>
    
</section>

<section class="sc-aboutUs-home wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-xs-7">
                <div class="wp-aboutUs">
                    <h2 class="titleAbouts">
                        <p><?php echo Yii::t('lang', 'About us');?></p>
                        <font><span>Pandora</span> Hotel</font>
                    </h2>
                    <div class="descontents">
                        <?php
                        $des= json_decode($getHotel['short_description'], true);
                        echo $des[$lang];
                        ?>
                    </div>
                    <div class="desicons">
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
                    </div>
                </div>
            </div>
            <div class="col-xs-5">
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

<section class="sc-rooms-home wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Rooms & Suites');?></font>
            <?php 
                $roomdescription = json_decode(Settings::model()->getSetting('room_des'), true);
                echo $roomdescription[$lang];
             ?>
        </h3>
        <div class="list_carousel responsive">
            <ul id="carouselRooms">
                <?php
                foreach($rooms->getData() as $room){?>
                    <li>
                        <a href="<?php echo Yii::app()->baseUrl?>/<?php echo $lang?>/rooms/<?php echo $room['slug']?>" >
                            <div class="wrap-thumb"><img src="<?php echo Yii::app()->baseUrl?>/uploads/cover/<?php echo $room['cover_photo']?>" alt="<?php echo $room['name']?>" /></div>
                            <h4>
                                <font><?php echo $room['name']?></font>
                                <?php
                                    $roomdes = json_decode($room['description'], true);
                                    echo $roomdes[$lang];
                                ?>
                            </h4>
                            <span class="likmores"><?php echo Yii::t('lang', 'Check Details');?></span>
                        </a>
                    </li>
                <?php }?>
            </ul>
            <a id="prev1" class="prev"></a>
            <a id="next1" class="next"></a>
        </div>
    </div>
</section>

<section class="sc-galleries wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Our <span>Gallery</span>');?></font>
        </h3>
    </div>
    <div class="work">
        <?php
        $gallery_category = Yii::app()->params['gallery_category'];
        ?>
        <div class="category-buttons">
            <a href="#" class="active all" data-group="all"><?php echo Yii::t('lang', 'All');?></a>
            <?php 
                foreach($gallery_category as $key => $cate){
                    echo '<a href="#" data-group="'.$key.'">'.Yii::t('lang', $cate).'</a>';
                }?>
        </div>

        <div id="grid" class="grid">
            <?php
                foreach($gallery_category as $k => $ct){

                    $gallery = Gallery::model()->getGalleryByCate($k);
                    if($gallery){
                        $items = Item::model()->getListByCate($gallery['id']);

                        foreach($items->getData() as $gl){?>
                            <a class="card" data-groups="<?php echo $gl->gallery->gallery_categories?>," href="<?php echo Yii::app()->baseUrl?>/uploads/gallery/<?php echo $gl['name']?>" data-rel="lightcase:myCollection" title="<?php echo $gl->gallery->name?>">                    
                                <img src="<?php echo Yii::app()->baseUrl?>/uploads/gallery/<?php echo $gl['name']?>">
                                <div class="caption"><?php echo $gl->gallery->name;?></div>
                            </a>
                    <?php }
                }
                }?>
            <div class="guide"></div>
        </div>
    </div>
</section>

<section class="sc-facilities-home wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Hotel <span>Facilities</span>');?></font>
            <?php 
                $hotelfac = json_decode(Settings::model()->getSetting('facilites'), true);
                echo $hotelfac[$lang];
             ?>
        </h3>
        <div class="list_carousel responsive">
            <ul id="carouselFacilities">
                <?php
                $services = Cms::model()->getList('services');
                foreach($services->getData() as $service){
                    $title = json_decode($service['title'], true);
                    $short = json_decode($service['short'], true);?>
                    <li>
                        <a href="<?php echo Yii::app()->baseUrl.'/'.$lang.'/services/'.$service['slug']?>">
                            <img src="<?php echo Yii::app()->baseUrl?>/uploads/cover/<?php echo $service['icon']?>" alt="<?php echo $title[$lang]?>" />
                            <h4>
                                <font><?php echo $title[$lang]?></font>
                                <?php echo $short[$lang]?>
                            </h4>
                            <!-- <span class="likmores">Opening hours: 09:00 - 22:00</span> -->
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
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/inout.js', CClientScript::POS_END);
?>