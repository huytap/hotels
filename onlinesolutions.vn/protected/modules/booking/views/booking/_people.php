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