<?php
$lang = Yii::app()->session['_lang'];
?>
<div class="content">
    <div class="explore-rooms margint30 marginb40 clearfix">
        <div class="container" id="booking-list">
            <div class="row">
                <div class="col-lg-4 col-sm-4 clearfix margint40"><!-- Sidebar -->
                    <div class="col-md-12 col-sm-12 col-xs-12"><?php $this->widget('FormbookWidget');?></div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="luxen-widget news-widget">
                            <?php $this->widget('HotelWidget');?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-sm-8 no-padding clearfix">
                    <div class="col-lg-12">
                        <h1 class="margint40 marginb40"><?php echo Yii::t('lang','restaurants');?></h1>
                    </div>
                    <div class="about-info clearfix"><!-- About Text -->
                        <?php
                            foreach($model->getData() as $pr){?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="home-room-box">
                                        <div class="room-image">
                                            <a href="<?php echo Yii::app()->params['link'].'/'.$lang.'/'.$pr['hotel']['slug'].'/cms/'.$pr['slug']?>.html">
                                                <?php
                                                if($pr['cover_photo']){
                                                    $photo = Yii::app()->baseUrl.'/uploads/cover/'.$pr['cover_photo'];?>
                                                    
                                                        <img alt="<?php echo $name[$lang];?>" class="img-responsive" src="<?php echo $photo?>">
                                                    
                                                <?php }?>
                                                <div class="home-room-details">
                                                    <h5><?php echo $pr['hotel']['name'];?></h5>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="room-bottom">
                                            <div class="pull-right">
                                                <div class="button-style-1">
                                                    <a href="<?php echo Yii::app()->params['booking'].'/'.$lang.'/'.$pr['hotel']['slug'].'/cms/'.$pr['slug']?>.html"><?php echo Yii::t('lang', 'view_detail');?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>