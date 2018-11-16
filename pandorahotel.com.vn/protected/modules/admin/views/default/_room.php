<div class="panel panel-default">
	<div class="panel-heading">
		Compare room sold on today
	</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Roomtype</th>
				<th>Sold</th>
				<th>Sold (%)</th>
				<th></th>
				<th>Total room</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$array=array('', 'progress-bar-success', 'progress-bar-danger', 'progress-bar-warning','');
			foreach($rooms->getData() as $key => $room):?>
				<tr>
					<td><?php echo $room['roomtype']['name']?></td>
					<td><?php echo $room['used_total_allotments']?></td>
					<td>
						<div class="progress progress-striped active" style="height:8px; margin:5px 0 0 0;">
							<div class="progress-bar <?php echo $array[$key]?>" style="width: <?php echo $room['used_total_allotments']/$room['available']?>%">
								<span class="sr-only"><?php echo $room['used_total_allotments']/$room['available']?>% Complete</span>
							</div>
						</div>
					</td>
					<td><?php echo $room['used_total_allotments']/$room['available']?>%</td>
					<td><span class="badge badge-info"><?php echo $room['available']?></span></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div><!-- /panel -->