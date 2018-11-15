<?php 
    $lang  = Yii::app()->language;
    $title = json_decode($model->title, true);
    $content = json_decode($model->description, true);
?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>

<section class="sc-title-page wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets tlePortlets-detail">
            <font><?php echo $title[$lang];?></font>
            <?php
                echo $content[$lang];
            ?>
            <a class="btn-backs" href="javascript:window.history.back()">Quay lại</a>
        </h3>
    </div>
</section>
<section class="sc-detail-rooms-page wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-others">
                <h3 class="tleservices"><?php echo Yii::t('lang', 'Other Services');?></h3>
                <ul class="lst-item">
                    <?php
                    foreach($other->getData() as $key => $data){
                        if($data['slug'] !== $cms_slug){
                            $title = json_decode($data['title'], true);
                            $des = json_decode($data['short'], true);
                            echo '<li><a href="'.Yii::app()->baseUrl.'/'.$lang.'/'.$data->hotel->slug.'/services/'.$data->slug.'.html">';
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