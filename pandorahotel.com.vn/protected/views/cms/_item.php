<div class="col-sm-6 col-md-3">
    <div class="content-box">
        <img src="<?php echo Yii::app()->baseUrl?>/timthumb.php?src=<?php echo Yii::app()->baseUrl?>/uploads/covers/<?php echo $data['cover']?>&h=200&w=310" class="img-centered img-responsive" data-animate="zoomIn" alt="<?php echo $data['name']?>">
        <div class="tri-up"></div>
        <h3 class="title"><?php echo $data['name']?></h3>
        <p class="content"><?php echo $data['short_description']?></p>
    </div>
</div>