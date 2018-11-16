<div class="col-md-1 col-sm-1 col-xs-3 rate-result center">
	<select class="rooms">
		<?php 
		if($flag){
			for($i=0;$i<=$room['available'];$i++){
				echo '<option value="'.$i.'">'.$i.'</option>';
			}
		}else{
			echo '<option value="0">0</option>';
		}
		?>
	</select>
</div>