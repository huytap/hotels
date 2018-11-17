<?php 
    $lang  = Yii::app()->language;
    $title = json_decode($data['name'], true);
    $short = json_decode($data['short_description'], true);
    $des = json_decode($data['full_description'], true);
?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>
<section class="sc-title-page wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets tlePortlets-detail">
            <font><?php echo $title[$lang];?></font>
            <?php //echo $short[$lang];?>
        </h3>
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-services">
                <?php echo $des[$lang];?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-xs-12 col-others">
                <h3 class="tleservices"><?php echo Yii::t('lang', 'Others');?></h3>
                <ul class="lst-item">
                    <?php
                        foreach($otherTour as $key => $data){
                            $title = json_decode($data['name'], true);
                            $des = json_decode($data['short_description'], true);
                            echo '<li>';
                                echo '<a href="'.Yii::app()->baseUrl.'/'.$lang.'/tours/'.$data->slug.'.html"><img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$data['cover_photo'].'">';
                                echo '<h4><font>'.$title[$lang].'</font>';
                                echo strip_tags($des[$lang]);
                                echo '</h4>';
                                echo '<span class="likmores">'.Yii::t('lang', 'View Detail').'</span></a>';
                            echo '</li>';
                        }
                    ?>                               
                </ul>
            </div>
        </div>
    </div>
</section>