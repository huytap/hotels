<?php 
    $lang  = Yii::app()->language;
    $title = json_decode($data['title'], true);
    $short = json_decode($data['short_description'], true);
    $des = json_decode($data['description'], true);
?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>
<section class="sc-rooms wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo $title[$lang];?></font>
            <?php echo $des[$lang];?>
        </h3>
        <!-- <div class="row">
            <div class="col-sm-12 col-xs-12 col-services">
                <h3 class="tleservices">Information</h3>
                <?php //echo $des[$lang];?>
            </div>
        </div> -->

        <div class="row">
            <div class="col-sm-12 col-xs-12 col-others">
                <h3 class="tleservices">Other Special Offers</h3>
                <ul class="lst-item">
                    <?php
                        foreach($model->getData() as $key => $data){
                            $title = json_decode($data['title'], true);
                            $des = json_decode($data['short_description'], true);
                            echo '<li>';
                                echo '<a href="mailto:'.$hotel['email_sales'].'"><img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$data['cover_photo'].'">';
                                echo '<h4><font>'.$title[$lang].'</font>';
                                echo $des[$lang];
                                echo '</h4>';
                                echo '<span class="likmores">'.Yii::t('lang', 'Book now').'</span>';
                            echo '</li>';
                        }
                    ?>                               
                </ul>
            </div>
        </div>
    </div>
</section>