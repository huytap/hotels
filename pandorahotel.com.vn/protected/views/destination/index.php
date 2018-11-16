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
                $content = json_decode(Settings::model()->getSetting('destination'), true);
                echo $content[$lang];
            ?>
        </h3>

        <?php
        //foreach($des_config as $tp => $type){?>
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <!--<h3 class="tleservices"><font><?php //echo Yii::t('lang', $type);?></font></h3>-->
                <ul class="lst-item">
                    <?php
                    foreach($model->getData() as $key => $data){
                        
                            $title = json_decode($data['title'], true);
                            $des = json_decode($data['short'], true);
                            echo '<li>';
                                echo '<img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$data['cover_photo'].'">';
                                echo '<h4><font>'.$title[$lang].'</font>';
                                echo strip_tags($des[$lang]);
                                echo '</h4>';
                            echo '</li>';
                        
                    }?>                 
                </ul>
            </div>
        </div>
        <?php //}?>
    </div>
</section>