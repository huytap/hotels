<div class="panel panel-default">
	<div class="panel-heading">
		Compare room hotel
	</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Hotel</th>
				<th>Sold</th>
				<th>Sold (%)</th>
				<th></th>
				<th>Total rooms</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$array=array('', 'progress-bar-success', 'progress-bar-danger', 'progress-bar-warning','');
			$now = date('Y-m-d');
			$to = date('Y-m-d', strtotime("$now +1day"));
			foreach($hotels->getData() as $key => $hotel):
				$rooms = Rooms::model()->getTotalRoomByHotel($hotel['id'], $now, $to);
				$total=$totalUsed=$rateSold=0;
				foreach($rooms->getData() as $room){
					$total += $room['available'];
					$totalUsed += $room['used_total_allotments'];
					
				}
				if($total>0)
					$rateSold = number_format($totalUsed/$total,2);
			?>
				<tr>
					<td><?php echo $hotel['name']?></td>
					<td><?php echo $totalUsed;?></td>
					<td>
						<div class="progress progress-striped active" style="height:8px; margin:5px 0 0 0;">
							<div class="progress-bar <?php echo $array[$key]?>" style="width: <?php echo $rateSold;?>%">
								<span class="sr-only"><?php echo $rateSold;?>% Complete</span>
							</div>
						</div>
					</td>
					<td><?php echo $rateSold;?>%</td>
					<td><span class="badge badge-info"><?php echo $total;?></span></td>
				</tr>
			<?php 
			endforeach;?>
		</tbody>
	</table>
</div><!-- /panel -->