<?php $lang  = Yii::app()->language;?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>

<section class="sc-title-page wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Services & Facilities');?></font>
            <?php
                $content = json_decode(Settings::model()->getSetting('services'), true);
                echo $content[$lang];
            ?>
        </h3>

        <!-- <div class="row">
            <div class="col-sm-12 col-xs-12 col-services">
                <h3 class="tleservices">Information</h3>
                Deluxe rooms measured on …… square meters has a wide window with night curtain, a nice view open up to the city street, a LCD TV, tea & coffee makers, a safety box, hair dryer, hot & cold shower and a bathtub.
            </div>
        </div> -->
    </div>
</section>
<section class="sc-specials-page wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <ul class="lst-item">
                    <?php
                    foreach($model->getData() as $key => $data){
                            $title = json_decode($data['title'], true);
                            $des = json_decode($data['short'], true);
                            echo '<li><a href="'.Yii::app()->baseUrl.'/'.$lang.'/'.$data->hotel->slug.'/services/'.$data->slug.'.html">';
                                echo '<img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$data['cover_photo'].'">';
                                echo '<h4><font>'.$title[$lang].'</font>';
                                echo $des[$lang];
                                echo '</h4>';
                            echo '</a></li>';
                        }?>                           
                </ul>
            </div>
        </div>

    </div>
</section>