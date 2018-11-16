<?php $lang  = Yii::app()->language;?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>
<section class="sc-specials wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Special Offers');?></font>
            <?php
                $content = json_decode(Settings::model()->getSetting('special_offers'), true);
                echo $content[$lang];
            ?>
        </h3>
        <ul class="lst-item">
            <?php
                foreach($model->getData() as $key => $data){
                    $title = json_decode($data['title'], true);
                    $des = json_decode($data['short_description'], true);
                    echo '<li>';
                        echo '<img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$data['cover_photo'].'">';
                        echo '<h4><font>'.$title[$lang].'</font>';
                        //echo '<h4>'.$des[$lang];
                        echo '</h4>';
                        /*echo '<a href="mailto:'.$hotel['email_sales'].'"><span class="likmores">'.Yii::t('lang', 'Book now').'</span></a>';*/
                    echo '</li>';
                }
            ?>              
        </ul>
    </div>
</section>