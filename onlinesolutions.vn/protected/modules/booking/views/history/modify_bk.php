<?php $lang = Yii::app()->session['_lang'];?>
<?php
    $form = $this->beginWidget('CActiveForm', array(
        'enableClientValidation' => false,
        'htmlOptions' => array(
            'class' => '',
        ),
));?>
<div class="row payment">
    <div class="col-xs-12 history">
        <div class="panel-heading bg">Booking ID: #<?php echo strtoupper($booking['short_id'])?></div>
        <div class="panel-body white">
        	<div class="row">
	        	<div class="col-md-6">
	        		<div class="row">
		        		<div class="col-sm-3 col-xs-4">Full Name</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo $booking['title']?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Booking Status</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo $booking['status']?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Email</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo $booking['email']?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Room type</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo $booked['roomtype']?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Promotion</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo $booked['promotion_name'];?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Policy</div>
		        		<div class="col-sm-9 col-xs-8">
		        			<?php 
		        				echo Yii::t('lang', $booking['promotion']['cancel_1']);
		        				if($booking['promotion']['cancel_2'] != 'nosecondrule'){
		        					echo '<br>'.Yii::t('lang', $booking['promotion']['cancel_2']);
		        				}
		        				if($booking['promotion']['cancel_3'] != 'nothirdrule'){
		        					echo '<br>'.Yii::t('lang', $booking['promotion']['cancel_3']);
		        				}
		        			?>
		        		</div>
		        	</div>
	        	</div>
	        	<div class="col-md-6">
	        		<div class="row">
		        		<div class="col-sm-3 col-xs-4">Booking ID</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo strtoupper($booking['short_id']);?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Check-in</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo ExtraHelper::date_2_show($booking['checkin']);?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Check-out</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo ExtraHelper::date_2_show($booking['checkout']);?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Number of rooms</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo $booking['no_of_room']?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Adults</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo $booking['no_of_adults']?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Children</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo $booking['no_of_child']?></div>
		        	</div>
		        	<div class="row">
		        		<div class="col-sm-3 col-xs-4">Price per room/night</div>
		        		<div class="col-sm-9 col-xs-8"><?php echo number_format($booking['rate_vnd'], 2);?></div>
		        	</div>
	            </div>
	        </div>

	        <div class="row">
        		<?php 
        		$subtotal = $booking['rate_vnd']*$booking['booked_nights']*$booking['no_of_room'];
        			if($booking['pickup_vehicle']){
        				$subtotal += $booking['pickup_price'];
        				echo '<div class="col-md-6">';
        					echo '<strong>Airport Pickup</strong><br>';
        					echo 'Flight number: '.$booking['pickup_flight'].', Flight Date: '. ExtraHelper::date_2_show($booking['pickup_date']).', Flight Time: '.$booking['pickup_time'].', Fee: '.number_format($booking['pickup_price'], 2).' VND';
        				echo '</div>';
        			}		
        		?>
        		<?php 
        			if($booking['dropoff_vehicle']){
        				$subtotal += $booking['dropoff_price'];
        				echo '<div class="col-md-6">';
        					echo '<strong>Airport Drop-off</strong><br>';
        					echo 'Flight number: '.$booking['dropoff_flight'].', Flight Date: '. ExtraHelper::date_2_show($booking['dropoff_date']).', Flight Time: '.$booking['dropoff_time'].', Fee: '.number_format($booking['dropoff_price'], 2) .' VND';
        				echo '</div>';
        			}		
        		?>
	        </div>
	        <div class="row">
	        	<div class="col-md-6">&nbsp;</div>
	        	<div class="col-md-6">
	        		Sub total: <?php echo number_format($subtotal, 2) .' VND';?><br>
	        		<?php
	        			$vat = $subtotal * 0.1;
	        			$sc = ($vat+$subtotal)*0.05;
	        		?>
	        		VAT: <?php echo number_format($vat, 2);?> VND<br>
	        		Service Charge: <?php echo number_format($sc, 2);?> VND<br>
	        		<strong>Grand total: <?php echo number_format($subtotal + $vat + $sc,2)?> VND</strong>
	        	</div>
	        </div>
	        <?php if($booking == 'amended' || $booking['status'] == 'confirmed'){?>
		        <div class="row">
		        	<div class="col-md-12">
		        		<button type="submit" name="updateBooking" class="btn btn-primary">Update</button>
		        	</div>
		        </div>
	        <?php }?>
        </div>
    </div>
</div>
<?php $this->endWidget();?>