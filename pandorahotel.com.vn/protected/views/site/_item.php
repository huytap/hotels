<?php
$photo = explode(',', $data->photos);
$description = json_decode($data->description, true);
$lang = Yii::app()->session['_lang'];
?>
<div class="row row-home">
    <article class="media">
        <figure class="media-image">
            <img src="<?php echo Yii::app()->baseUrl;?>/uploads/roomtype/<?php echo $photo[0]?>" alt="<?php echo $data->name?>" class="media-object">
        </figure>
        <section class="media-body">
            <h3 class="media-header media-header-big">
                <a href="<?php echo Yii::app()->params['link'].'/'.$lang.'/rooms/'.$data->id.'/'.$data->slug.'.html'?>"><?php echo $data->name?></a>
            </h3>
            <?php 
                if(isset($description[$lang])){
                    echo '<p class="media-content">'. $description[$lang].'<a href="'.Yii::app()->params['link'].'/'.$lang.'/rooms/'.$data->id.'/'.$data->slug.'.html" class="text-link link-direct">see more</a></p>';
                }
            ?>
        </section>
    </article>
</div>