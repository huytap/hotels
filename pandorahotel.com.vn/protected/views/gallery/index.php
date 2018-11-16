<?php 
$gallery_category = Yii::app()->params['gallery_category'];?>
<section class="sc-header-page">
    <?php $this->widget('HeaderWidget');?>
    <?php $this->widget('SliderWidget');?>
</section>
<section class="sc-galleries sc-galleries-page wow fadeInUp">
    <div class="container">
        <h3 class="tlePortlets">
            <font><?php echo Yii::t('lang', 'Our <span>Gallery</span>');?></font>
        </h3>
    </div>
    <div class="work">
        <div class="category-buttons">
            <a href="#" class="active all" data-group="all"><?php echo Yii::t('lang', 'All');?></a>
            <?php 
                foreach($gallery_category as $key => $cate){
                    echo '<a href="#" data-group="'.$key.'">'.Yii::t('lang', $cate).'</a>';
                }?>
        </div>

        <div id="grid" class="grid">
            <?php
                foreach($gallery_category as $k => $ct){

                    $gallery = Gallery::model()->getGalleryByCate($k);
                    if($gallery){
                        $items = Item::model()->getListByCate($gallery['id']);

                        foreach($items->getData() as $gl){?>
                            <a class="card" data-groups="<?php echo $gl->gallery->gallery_categories?>," href="<?php echo Yii::app()->baseUrl?>/uploads/gallery/<?php echo $gl['name']?>" data-rel="lightcase:myCollection" title="<?php echo $gl->gallery->name?>">                    
                                <img src="<?php echo Yii::app()->params['link']?>/timthumb.php?src=<?php echo Yii::app()->baseUrl?>/uploads/gallery/<?php echo $gl['name']?>&w=365&h=246">
                                <div class="caption"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $gl->gallery->name?></div>
                            </a>
                    <?php }
                }
                }?>
            <div class="guide"></div>
        </div>
    </div>
</section>
<?php Yii::app()->clientScript->registerScript('gallery', '
        $("a[data-rel^=lightcase]").lightcase({
            swipe: true,
            showTitle: true,
            type: "image"
        });
    ', CClientScript::POS_END);?>