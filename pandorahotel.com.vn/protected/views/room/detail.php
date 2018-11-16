<?php
$lang=Yii::app()->language;?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>


<section class="sc-rooms wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?=$room['name']?></font>
            <?php 
                $des = json_decode($room['description'], true);
                echo $des[$lang];

                $photos = Gallery::model()->getList(1, $room['id']);
                $html_photo = '';
                if($photos){
                    $i=0;
                    foreach($photos->getData() as $key => $photo){
                        if($i==0)
                            $class="active";
                        else
                            $class="";
                        $html_photo .= '<div class="item '.$class.'">';
                            $html_photo .= '<img src="'.Yii::app()->baseUrl.'/uploads/slide/'.$photo['name'].'" alt="'.$room['name'].'" alt="'.$room['name'].'">';
                        $html_photo .= '</div>';    
                        $html_ol .= '<li data-target="#carousel-detail" data-slide-to="'.$i.'" class="'.$class.'"></li>';
                        $i++;
                    }
                }
            ?>
        </h3>
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-img">
                <div id="carousel-detail" class="carousel slide carousel-img" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php echo $html_ol;?>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <?php echo $html_photo;?>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-sm-12 col-xs-12 col-services">
                <h3 class="tleservices">Information</h3>
                Deluxe rooms measured on …… square meters has a wide window with night curtain, a nice view open up to the city street, a LCD TV, tea & coffee makers, a safety box, hair dryer, hot & cold shower and a bathtub.
            </div>
        </div> -->
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-uses col-services">
                <h3 class="tleservices"><?php echo Yii::t('lang','Amenities');?></h3>
                <ul>
                    <?php
                        /*$beds = explode(',', $room['bed']);
                        echo '<li>'.Yii::t('lang', 'size_room').': '.$room['size_of_room'].' '. Yii::t('lang','sqm').'</li>';
                        echo '<li>'. Yii::t('lang', 'view').': '.  Yii::t('lang',$room['view']).'</li>';
                        echo '<li>' . Yii::t('lang', 'bedding').': ';
                        $i=0;
                        foreach($beds as $bed){
                            echo Yii::t('lang',$bed);
                            if($i<count($beds)-1){
                                echo ' '. Yii::t('lang', 'or').' ';
                            }
                            $i++;
                        }
                        echo '</li>';*/

                        $amenities = explode(',', $room['amenities']);
                        foreach($amenities as $key => $amen){
                            echo '<li>'.ucfirst(Yii::t('lang', $amen)).'</li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12 col-others">
                <h3 class="tleservices"><?php echo Yii::t('lang', 'Other rooms');?></h3>
                <ul class="lst-item">
                    <?php
                        foreach($others->getData() as $room){
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
        </div>
    </div>
</section>