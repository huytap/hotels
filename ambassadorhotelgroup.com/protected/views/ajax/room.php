<div class="ajax-rooms white-popup-block">
	<style>
		.ajax-rooms {
			max-width:800px; margin: 20px auto; 
			background: #FFF; padding: 15px; line-height: 0;
			position: relative;
		}
		.ajax-rooms h2,
		.ajax-rooms h3{
			font-weight: bold;
			margin: 0 0 5px 0;
			font-size: 16px;
		}
		.ajax-rooms h3{
			font-size: 14px;
		}
		.ajax-rooms:before,
		.ajax-rooms:after,
		#pop-pager:before,
		#pop-pager:after{
			content:'';
			clear: both;
			display: block;
		}
		.ajcol-l {
			width: 60%; float:left;
		}
		.ajcol-r {
			width: 38%;
	        float: right;
			padding: 10px;
			box-sizing: border-box;
			line-height: 18px;
			font-size: 13px;
		}
		.ajcol-r p {
			margin-bottom: 0;
		}
		#pop-pager img {
			width: 100%; height: auto;
		}
		#rooms-pop-slider li{
			padding: 5px;
			box-sizing: border-box;
			overflow: hidden;
		}
		#rooms-pop-slider img{
			width: 100%;
			height: auto;
		}
		.ajcol-r .des{
			margin-bottom: 15px;
		}
		#pop-pager a{
			width: 20%;
			float: left;
			padding: 5px;
			box-sizing: border-box;
		}
		.ajcol-r .amenity{
			margin: 0;
			padding: 0;
		}
		.ajcol-r .amenity li{
			float: left;
		    padding: 0 3px;
		    margin: 1px 0;
		}
		.ajcol-r .amenity li:nth-of-type(2n){
			background-color: #ddd;
		}

		    
		@media all and (max-width:640px) {
			.ajcol-r,
			.ajcol-l{ 
				width: 100%;
				float:none;
			}
		}
	</style>
	<div class="ajcol-l">
		<ul id="rooms-pop-slider">
			<?php 
				$lang = Yii::app()->session['_lang'];
                $thumb = '';
                if($photo){
                	foreach($photo->getData() as $key => $pt){
	                    $thumb .= '<a data-slide-index="'.$key.'" href="javascript:void(0);"><div class="cover"></div><img src="' . Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/slide/' . $pt['name'].'&h=104&w=144"></a>';
	                    echo '<li><img src="' . Yii::app()->baseUrl.'/timthumb.php?src='.Yii::app()->baseUrl.'/uploads/slide/' . $pt['name'].'&h=400&w=720"></li>';
	                }
	            }
            ?>
		</ul>

		<div id="pop-pager">
		 	<?php echo  $thumb;?>
		</div>

		

	</div>
	<div class="ajcol-r">
		<div>
			<h2><?php echo $room['name']?></h2>
		    <div class="room-desc">
                    <div class="des">
                        <?php $des = json_decode($room['description'], true); echo $des[$lang]?>
                        <ul>
	                        <li><?php echo Yii::t('lang', 'number_room') ?>: <?php echo $room['no_of_rooms'] ?></li>
	                        <li><?php echo Yii::t('lang', 'max_occupancy') ?>: <?php echo $room['max_per_room'] ?></li>
	                        <li><?php echo Yii::t('lang', 'size_room') ?>: <?php echo $room['size_of_room'] ?> sqm</li>
	                        <li><?php echo Yii::t('lang', 'view') ?>: <?php echo Yii::t('lang', $room['view']) ?></li>
	                        <li><?php echo Yii::t('lang', 'bedding') ?>: 
	                            <?php
	                            if($room['bed']){
	                            	$i=0;
		                            foreach (explode(',', $room['bed']) as $bed) {
		                                echo Yii::t('lang', $bed);
		                                if($i<count(explode(',', $room['bed']))-1){
		                                	echo ', ';
		                                }
		                                $i++;
		                            }
		                        }?>
	                        </li>
                        </ul>
                    </div>
                    <!-- <h3>Amenities</h3>
                    <ul class="amenity">
                    <?php
                       /* if ($room['amenities']) {
                            foreach (explode(',', $room['amenities']) as $key => $value) {
                                if ($value == "1" || $value == 'on') {
                                    echo '<li>' . ucwords(Yii::t('lang', $key)) . '</li>';
                                }
                            }
                        }*/?>
                    </ul> -->
                </div>

		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl?>/bk/js/jquery.bxslider.min.js"></script>
<script type="text/javascript">
	jQuery(function(){
		jQuery("#rooms-pop-slider").bxSlider({
			pagerCustom: '#pop-pager',
			auto: true,
			controls: false
		});
	});
</script>