<?php $lang = Yii::app()->language;?>

<section class="sc-header-slide">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
    
    <?php $this->widget('FormbookWidget');?>
    
</section>

<section class="sc-ourhotel wow fadeInUp">
    <div class="container">
        <div class="wrap-ourhotel">
            <h2 class="bg-ourhotel"><?php echo Yii::t('lang', 'Our <font>Hotel</font>')?></h2>
            <ul>
                <?php
                foreach($hotels->getData() as $dth){
                    $hname = json_decode($dth['other_name'], true);
                    $short = json_decode($dth['short_description'], true);
                    if($dth['display_order'] == 1){
                        
                        echo '
                        <li class="item-hotelVT">
                            <h3>'.$hname[$lang].'</h3>
                            <div class="txtDes">
                                '.$short[$lang].'
                                <span class="item-fi1">
                                    <img src="'.Yii::app()->baseUrl.'/images/ic-phone.png" alt="" title="Liên hệ"/>
                                    Tư vấn & Hỗ trợ
                                    <font>'.$dth['hotline'].'</font>
                                </span>
                                
                                <span class="item-fi2">
                                    <img src="'.Yii::app()->baseUrl.'/images/ic-air.png" alt="" title="Tân Sơn Nhất"/>
                                    Đi Tân Sơn Nhất
                                    <font>15 phút</font>
                                </span>
                                <span class="item-fi3">
                                    <img src="'.Yii::app()->baseUrl.'/images/ic-market.png" alt="" title="Chợ Bến Thành"/>
                                    Cách chợ Bến Thành
                                    <font>5 phút</font>
                                </span>
                            </div>
                            <div class="thumbs"><img src="'.Yii::app()->baseUrl.'/images/'.$dth['cover_photo'].'" alt="" title="'.$dth['name'].'"/></div>
                        </li>';
                    }else{
                        echo '
                        <li class="item-hotelSG">
                            <div class="thumbs"><img src="'.Yii::app()->baseUrl.'/images/'.$dth['cover_photo'].'" alt="" title="'.$dth['name'].'"/></div>
                            <h3>'.$hname[$lang].'</h3>                       
                            <div class="txtDes">
                                '.$short[$lang].'
                                <span class="item-fi1">
                                    <img src="'.Yii::app()->baseUrl.'/images/ic-phone.png" alt="" title="Liên hệ"/>
                                    Tư vấn & Hỗ trợ
                                    <font>'.$dth['hotline'].'</font>
                                </span>
                                <span class="item-fi2">
                                    <img src="'.Yii::app()->baseUrl.'/images/ic-sea.png" alt="" title="Bãi biển Vũng Tàu"/>
                                    Cách biển Vũng Tàu
                                    <font>5 phút</font>
                                </span>
                                <span class="item-fi3">
                                    <img src="'.Yii::app()->baseUrl.'/images/ic-market1.png" alt="" title="Chợ Vũng Tàu"/>
                                    Đến chợ Vũng Tàu
                                    <font>0,5 km</font>
                                </span>
                                
                            </div>
                        </li>';
                    }
                }?>
            </ul>
        </div>
    </div>
</section>

<section class="sc-facilities-group wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><span>Tiện nghi</span> khách sạn</font>
            <span>All rooms and suites are fully equipped with high quality facilities and amenities creating a life experience of utmost comfort and convenience.</span>
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
                            <div class="wrap-thumb"><img src="<?php echo Yii::app()->baseUrl?>/uploads/cover/<?php echo $service['cover_photo']?>" alt="<?php echo $title[$lang]?>" /></div>
                            <h4>
                                <font><?php echo $title[$lang]?></font>
                                <?php echo $short[$lang]?>
                            </h4>
                            <span class="likmores">Chi tiết</span>
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

<section class="sc-abouts-group">
    <div class="container">
        <h3 class="tlePortlets">
            <p><?php echo Yii::t('lang', 'Giới thiệu về');?></p>
            <font><span>Ambassador</span> Hotel Group</font>
        </h3>
        <div class="row">
            <div class="col-xs-8 txtcontent-about">
                <?php
                $a = Settings::model()->getSetting('aboutus');
                $str = json_decode($a, true);
                echo $str[$lang];
                ?>
            </div>
            <div class="col-xs-4 sendmail">
                Đăng ký để nhận ưu đãi đặc biệt:
                <form class="form-inline subcribe-form" role="form">
                    <input type="email" class="form-control" id="email" placeholder="Nhập email để đăng ký">
                    <button type="submit" class="btn btn-default"></button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/inout.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('slides', "
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
    });", CClientScript::POS_END);
?>