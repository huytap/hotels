<?php 
    $lang  = Yii::app()->language;
    $title = json_decode($model->title, true);
    $content = json_decode($model->description, true);
?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>

<section class="sc-rooms wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo $title[$lang];?></font>
            <?php
                echo $content[$lang];
            ?>
        </h3>

        <div class="row">
            <div class="col-sm-12 col-xs-12 col-others">
                <h3 class="tleservices"><?php echo Yii::t('lang', 'Other Services');?></h3>
                <ul class="lst-item">
                    <?php
                    foreach($other->getData() as $key => $data){
                        if($data['slug'] !== $cms_slug){
                            $title = json_decode($data['title'], true);
                            $des = json_decode($data['short'], true);
                            echo '<li><a href="'.Yii::app()->baseUrl.'/'.$lang.'/services/'.$data->slug.'">';
                                echo '<img src="'.Yii::app()->baseUrl.'/uploads/cover/'.$data['cover_photo'].'">';
                                echo '<h4><font>'.$title[$lang].'</font>';
                                echo $des[$lang];
                                echo '</h4>';
                            echo '</a></li>';
                        }
                    }?>                           
                </ul>
            </div>
        </div>

    </div>
</section>