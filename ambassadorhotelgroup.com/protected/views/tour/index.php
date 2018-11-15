<?php 
    $lang  = Yii::app()->language;
    $des_config = Yii::app()->params['type_des'];
?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>

<section class="sc-destinations wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'WHAT\'S NEAR US IN');?></font>
            <?php
                $content = json_decode(Settings::model()->getSetting('destination', $getHotel['id']), true);
                echo $content[$lang];
            ?>
        </h3>
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-others">
                <ul class="lst-item">
                    <?php
                        foreach($listTour as $key => $data){
                            $title = json_decode($data['name'], true);
                            $des = json_decode($data['short_description'], true);
                            echo '<li><a href="'.Yii::app()->baseUrl.'/'.$lang.'/tours/'.$data['slug'].'.html">';
                                echo '<div class="imthumbs">';
                                echo '<img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$data['cover_photo'].'" class="img-responsive">';
                                //echo '<span class="tag" href="#">Ambassador Vungtau Hotel</span>';
                                echo '</div>';
                                echo '<h4><font>'.$title[$lang].'</font>';
                                echo strip_tags($des[$lang]);
                                echo '</h4>';
                                echo '<span class="likmores">'.Yii::t('lang', 'View Detail').'</span>';
                            echo '</a></li>';
                        }
                    ?>                 
                </ul>
            </div>
        </div>
    </div>
</section>