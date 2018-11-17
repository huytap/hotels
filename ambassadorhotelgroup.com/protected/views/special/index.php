<?php $lang  = Yii::app()->language;?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>
<section class="sc-title-page wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Special Offers');?></font>
            <?php
                $content = json_decode(Settings::model()->getSetting('special_offers'), true);
                echo $content[$lang];
            ?>
        </h3>
    </div>
</section>
<section class="sc-specials-page wow fadeInUp">
    <div class="container">
        <ul class="lst-item">
            <?php
                foreach($model->getData() as $key => $data){
                    $title = json_decode($data['title'], true);
                    $des = json_decode($data['short_description'], true);
                    echo '<li><a href="'.Yii::app()->baseUrl.'/'.$lang.'/'.$getHotel['slug'].'/special-offers/'.$data['slug'].'.html">';
                        echo '<div class="imthumbs">';
                        echo '<img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$data['cover_photo'].'" class="img-responsive">';
                        echo '<span class="tag">'.$data->hotel->name.'</span>';
                        echo '</div>';
                        echo '<h3>'.$title[$lang].'</h3>';
                        echo $des[$lang];
                        echo '<span class="likmores">'.Yii::t('lang', 'View Detail').'</span>';
                    echo '</a></li>';
                }
            ?>              
        </ul>
    </div>
</section>