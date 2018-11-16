<?php $lang = Yii::app()->language;?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>
<section class="sc-rooms wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Rooms & Suites');?></font>
            <?php
                $content = json_decode(Settings::model()->getSetting('room'), true);
                echo $content[$lang];
            ?>
        </h3>
        <ul class="lst-item">
            <?php
                foreach($rooms->getData() as $room){
                    $description = json_decode($room['description'], true);?>  
                    <li>
                        <a href="<?php echo Yii::app()->params['link'].$lang.'/rooms/'.$room['slug']?>">
                            <img src="<?php echo Yii::app()->baseUrl?>/uploads/cover/<?php echo $room['cover_photo']?>" alt="<?php echo $room['name']?>">
                            <h4><font><?=$room['name']?></font>
                                <?php echo $description[$lang];?>
                            </h4>
                            <span class="likmores"><?=Yii::t('lang', 'more_detail');?></span>
                        </a>
                    </li>
            <?php }?>
        </ul>
    </div>
</section>