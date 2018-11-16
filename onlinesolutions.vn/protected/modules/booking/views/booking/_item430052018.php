<?php //Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/font-awesome.min.css');?>
<?php $lang=Yii::app()->session['_lang'];?>
<div class="per-room">
	<div class="row">
		<div class="col-xs-12">
			<h4><a class="show-room" href="<?php echo Yii::app()->params['booking']?>ajax/loadRoom?roomtype_id=<?php echo $room['roomType']?>"><?=$room['roomName']?></a></h4>
		</div>
	</div>
	<div class="row">
		<!-- <div class="col-md-3 col-sm-12 col-xs-12 no-padding-r m-no-padding"> -->
		<div class="col-md-3 col-sm-12 col-xs-12 roomtypes" rel="<?php echo $room['roomType']?>">
			<!-- <div class="roomtypes" rel="<?php //echo $room['roomType']?>">
			    <div class="child" rel="#room_<?php //echo $room['roomType']?>">			    	
			    	<div class="row"> -->
				    	<!-- <div class="col-md-12 col-xs-12 col-sm-7 m-no-padding"> -->
					    	
					    	<?php echo '<a class="show-room" href="'.Yii::app()->params['booking'].'ajax/loadRoom?roomtype_id='.$room['roomType'].'">';
					    	echo '<span class="r-detail">'.Yii::t('lang', 'see_photos').'</span>';
					    	echo '<img class="img-responsive" src="'.Yii::app()->baseUrl.'/uploads/slide/'.$room['photos'].'">';?>
					    	</a>
				    	<!-- </div> 
				    	<div class="col-md-12 col-xs-12 col-sm-5">-->
					        <!-- <h4><a class="show-room" href="<?php echo Yii::app()->params['booking']?>ajax/loadRoom?roomtype_id=<?php echo $room['roomType']?>"><?=$room['roomName']?></a></h4> -->
				            <p><?php //echo Yii::t('lang', 'size_room')?><span class="fa fa-th"></span> <?php echo $room['roomSize']?> sq.m</p>
				            <p><?php //echo Yii::t('lang', 'bedding')?><span class="fa fa-bed"></span> 
				            <?php 
				            $bed = explode(',', $room['bed']);
				            	$bb=0;
				            	foreach($bed as $b){
				            		echo Yii::t('lang', $b);
				            		if($bb<count($bed)-1){
				            			echo ', ';
				            		}
				            		$bb++;
				            	}
				            ?> 
				            </p>
				            <p><?php //echo Yii::t('lang', 'view')?><span class="fa fa-columns"></span> <?php echo Yii::t('lang', $room['view'])?></p>
				    	<!-- </div> -->
				    <!-- </div>
			    </div>
			</div> -->
		</div>
		<!-- <div class="col-md-9 col-sm-12 col-xs-12 paddingt15"> -->
		<div class="col-md-9 col-sm-12 col-xs-12 no-padding">
		<?php
		    //$this->renderPartial('_item_available', compact(array('room', 'params')));
		?>
			<?php
			$j = 1;
			$html_available = $html_no_available = '';
			//$notshow="m-not-vai";
			foreach ($room['promos'] as $promo){
				$p_des = json_decode($promo['short_content'], true);
			    ?>
	        	<div class="row promotions row-promos <?php //echo $notshow?>" rel="<?php echo $promo['promotion_id'] ?>">
			  		<div class="col-md-5 col-xs-12 col-sm-4 rate-result  <?php echo $notshow?>">
						<div class="best_deal time_early_bird">
							<?php
							if($promo["end_deal_date"]){?>
								<div class="col-h"><i class="glyphicon glyphicon-time"></i></div>
								<div class="col-h"><div class="hours">00</div><div><?=Yii::t('lang','hours');?></div></div>
								<div class="col-h"><div class="minutes">00</div><div><?=Yii::t('lang','minutes');?></div></div>
								<div class="col-h"><div class="seconds">00</div><div><?=Yii::t('lang','seconds');?></div></div>

								<?php 
								Yii::app()->clientScript->registerScript('deal',"
									$('.time_early_bird').downCount({
									    date: '".$promo["end_deal_date"]." 23:59:59',
									    offset: +10
									}, function () {
									    
									});");
							}?>
						</div>
						<div class="pr-name">
							<span class="hotdeal"><?php echo $promo['promotion_name'] ?></span>
							<a class="show-cancellation" href="<?php echo Yii::app()->params['booking']?>ajax/pr_condition?pr=<?=$promo['promotion_id'];?>&rtype=<?php echo $promo['roomtype_id']?>&adult=<?php echo $params['adult']?>"><i class="fa fa-external-link" aria-hidden="true"></i></a>
							<div class="p-des"><?php
							echo str_replace("\n", '<br>',$p_des[$lang]);
							?>
							</div>
						</div>
						
					</div>
					<div class="col-md-1 col-sm-1 col-xs-3 rate-result center">
						<?php 
						$adult = 2;
						if(isset($_GET['adult'])){
							$adult = $_GET['adult'];
						}elseif(isset($_POST['adult'])){
							$adult = $_POST['adult'];
						}
						if($adult <=$room['max']){
							for($i=0;$i<$adult;$i++){
								echo '<i class="glyphicon glyphicon-user"></i>';		
							}
							if($room['children']>0 && $params['children']>0){
								for($i=0;$i<$params['children'];$i++){
									echo '+';		
								}
							}
						}elseif($adult <= ($room['max']+$room['extraBed'])){
							for($i=0;$i<$room['max'];$i++){
								echo '<i class="glyphicon glyphicon-user"></i>';		
							}
							if($room['extraBed']>0){
								echo '<br>+'.Yii::t('lang', 'extrabed');
							}
						}?>
					</div>
					<div class="col-md-3 col-xs-9 col-sm-3 rate rate-result m-right">
						<span class="price-old">
							<?php 
								echo $room['currency'] .' <span class="old">';
								echo ExtraHelper::roundMoney3($room['currency'], $room[$params['adult']]);
							?>
						</span></span>
						<strong><?php echo $room['currency'] ?></strong>  
						<img  style="width: 20px;text-align: center; clear: both;display:none" class="loading" src="<?php echo Yii::app()->baseUrl?>/images/loading.gif">
						<span class="currency-txt">
							<?php 
								echo ExtraHelper::roundMoney3($room['currency'], $promo[$params['adult']]) ;
							?></span><br>
						(<?php echo Yii::t('lang', 'avg_daily') ?>)
					</div>
					<div class="col-md-1 col-sm-1 col-xs-3 rate-result center">
						<select class="rooms">
							<?php 
								for($i=0;$i<=$room['available'];$i++){
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							?>
						</select>
					</div>
			  		<div class="col-md-2 col-sm-3 col-xs-9 col rate-result right"><span class="btn-add-room"><?=Yii::t('lang', 'book_now');?></span></div>
			  	</div>
			<?php }?>
		</div>
	</div>
</div>