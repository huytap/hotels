<?php $lang = Yii::app()->language;?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>
<section class="sc-title-page wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Rooms & Suites');?></font>
            <?php
                $content = json_decode(Settings::model()->getSetting('room'), true);
                echo $content[$lang];
            ?>
        </h3>
    </div>
</section>
<section class="sc-rooms-page wow fadeInUp">
    <div class="container">
        <ul class="lst-item">
            <?php
                $k=1;
                foreach($rooms->getData() as $room){
                    $description = json_decode($room['description'], true);
                    $photos = Gallery::model()->getList(1, $room['id']);
                    $html_photo = $html_ol = '';
                    if($photos){
                        $i=0;
                        foreach($photos->getData() as $key => $photo){
                            if($i==0)
                                $class="active";
                            else
                                $class="";
                            $html_photo .= '<li>';
                                $html_photo .= '<img src="'.Yii::app()->baseUrl.'/uploads/slide/'.$photo['name'].'" alt="'.$room['name'].'" alt="'.$room['name'].'">';
                            $html_photo .= '</li>';    
                            $html_ol .= '<a data-slide-index="'.$i.'" href="#" class="'.(($i==0) ? 'active' : '').'">'.$i.'</a>';
                            $i++;
                        }
                    }?>  
                    <li>
                        <div class="images-preview">
                            <ul class="preview-slider<?php echo $k;?>">
                                <?php echo $html_photo;?>
                            </ul>   
                            <div id="slider-preview-custom<?php echo $k;?>" class="page-controls">
                                <?php echo $html_ol;?>
                            </div>
                        </div>
                        <div class="content-preview">
                            <h3><?=$room['name']?></h3>
                            <?php echo $description[$lang];?>
                            <ul class="meta-room">
                                <li class="meta-items-1">
                                    <?php echo Yii::t('lang', 'size');?>
                                    <span><?php echo $room['size_of_room']?> m<sup>2</sup></span>
                                </li>
                                <li class="meta-items-2">
                                    <?php echo Yii::t('lang', 'bedding');?>
                                    <span>
                                        <?php 
                                        $beds = explode(',',$room['bed']);
                                        $i=0;
                                        foreach($beds as $bed){
                                            echo Yii::t('lang', $bed);
                                            if(count($beds)-1>$i){
                                                echo ' '.Yii::t('lang', 'or').' ';
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </span>
                                </li>
                                <li class="meta-items-3">
                                    <?php echo Yii::t('lang', 'view');?>
                                    <span><?php echo Yii::t('lang', $room['view']);?></span>
                                </li>
                                <li class="meta-items-4">
                                    Sức chứa
                                    <span><?php echo $room['max_per_room']?></span>
                                </li>
                            </ul>
                            <a class="btn-booknow"><?php echo Yii::t('lang', 'Book Now');?></a>
                            <a class="btn-detail" href="<?php echo Yii::app()->baseUrl?>/<?php echo $lang.'/'.$getHotel['slug']?>/rooms/<?php echo $room['slug']?>.html"><?php echo Yii::t('lang', 'View Detail');?></a>
                        </div>
                    </li>
            <?php $k++; }?>
        </ul>
    </div>
</section>