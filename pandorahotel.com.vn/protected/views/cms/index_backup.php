<?php $lang  = Yii::app()->session['_lang'];?>
<?php
$cms_category = Yii::app()->params['cms_type'];
$html ='';
$photo = '';
$category = '';

if(isset($_GET['cms_slug'])){
    $dt = Cms::model()->getBySlug($_GET['cms_slug']);
    $des = json_decode($dt['description'],true);
    $title = json_decode($dt['title'], true);
    $category = $cms_category[$dt['type']];

    $html_title = $title[$lang];
    $html .= $des[$lang];
    $photo = Yii::app()->baseUrl.'/uploads/cover/'.$dt['cover_photo'];
}elseif(count($model->getData())>0){
    $dt = $model->getData();
    $des = json_decode($dt[0]['description'],true);
    $title = json_decode($dt[0]['title'], true);
    $category = $cms_category[$dt[0]['type']];
    $html_title = $title[$lang];
    $html .= $des[$lang];
    $photo = Yii::app()->baseUrl.'/uploads/cover/'.$dt[0]['cover_photo'];
}else{
    $html_title = '';
    $html .= 'Comming soon!';
}
?>
<div class="content" id="booking-list"><!-- Content Section -->
    <div class="container">
        
        <div class="row">
            <div class="col-lg-4 col-sm-4 clearfix margint40"><!-- Sidebar -->
                <div class="col-md-12 col-sm-12 col-xs-12"><?php $this->widget('FormbookWidget');?></div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="luxen-widget news-widget">
                        <?php $this->widget('HotelWidget');?>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-sm-8 no-padding clearfix"><!-- Content Section -->
                <div class="col-lg-12"><h1 class="margint40 marginb40"><?php echo $html_title;?></h1></div>
                <?php if($photo){?>
                <div class="about-slider margint40">
                    <div class="col-lg-12"><!-- Slider -->
                        <div class="flexslider">
                            <ul class="slides">
                                <li><?php echo '<img class="img-responsive" alt="'.$html_title.'" src="'.$photo.'">';?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php }?>
                <div class="about-info clearfix"><!-- About Text -->
                    <div class="col-lg-12">
                        <?php echo $html?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>