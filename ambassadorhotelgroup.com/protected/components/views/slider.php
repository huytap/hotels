<?php
$controller = Yii::app()->getController();
$isHome = (($controller->action->id === 'index' && $controller->id == 'site') ? true : false);
if($isHome){?>
    <article class="ar-slide">
        <ul class="bxslider">
            <?php
            $sliders = Gallery::model()->getListbytype('home');
            foreach($sliders->getData() as $slide){
            ?>
                <li>
                    <div class="bx-images">                     
                        <img src="<?php echo Yii::app()->baseUrl.'/uploads/slide/'.$slide['name']?>" alt="Pandora Hotel">
                    </div>
                </li>
            <?php }?>
        </ul>
        <div class="scroll-downs">
            <div class="mousey">
                <div class="scroller"></div>
            </div>
        </div>
    </article>
<?php }else{?>
    <article class="ar-page">
        <div class="bg-image-page">
            <img src="<?php echo Yii::app()->baseUrl?>/images/slide2.jpg" alt="Pandora Hotel">
            <?php
                /*foreach($sliders->getData() as $slide){
                    echo '<img src="'.Yii::app()->baseUrl.'/uploads/slide/'.$slide['name'].'">';
                }*/
            ?>
        </div>
    </article>
<?php
}?>