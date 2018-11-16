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
	        <table style="width:100%;margin:0 auto;;border-collapse: collapse;" border="0" cellpadding="0" cellspacing="0">
			    <tr>
			        <td valign="middle">
			            <table width="100%" border="0" style="border-collapse:collapse;" cellpadding="0" cellspacing="0">
			                <tr>
			                    <td align="left" width="150px" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;"><strong>Attention to:</strong></td>
			                    <td align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
			                        <?php echo $booking['title'] .'. '.$booking['first_name'].' '.$booking['last_name'];?>
			                    </td>
			                </tr>
			                <tr>
			                    <td align="left" width="150px" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;"><strong>Contact Email:</strong></td>
			                    <td align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;;border-collapse:collapse;">
			                        <a href="mailto:~~booked_email~~" target="_blank"><?php echo $booking['email'] ?></a>
			                    </td>
			                </tr>
			                <tr>
			                    <td align="left" width="150px" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
			                        <strong>Reservation number:</strong>
			                    </td>
			                    <td align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
			                        <strong>#<?php echo strtoupper($booking['short_id'])?></strong>
			                    </td>
			                </tr>
			                <?php if($booking['phone']){?>
			                <tr>
			                    <td align="left" width="150px" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
			                        <strong>Tel:</strong>
			                    </td>
			                    <td align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
			                        <strong><?php echo $booking['phone'] ?></strong>
			                    </td>
			                </tr>
			                <?php }?>
			            </table>
			        </td>
			    </tr>
			</table>

			<table style="width: 100%;margin:0 auto;;border-collapse: collapse;" border="0" cellpadding="0" cellspacing="0">
			    <tr>
			        <td valign="middle" style="border-collapse:collapse;border:1px solid #000000;">
			            <table width="100%" border="0" cellpadding="10" cellspacing="0" style="font-size: 12px;font-family:arial,sans-serif;border-collapse:collapse;">
			                <tbody>
			                    
			                    <tr>
			                        <td colspan="9" style="padding:0">
			                        	<?php
			
											$total = ($booking['rate_vnd']*$booking['no_of_room'] + $booking['no_of_extrabed']*$booking['extrabed_price'])*$booking['booked_nights'];
											$hotel_list = '<tr>
									                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:40px;"><strong>No</strong></td>
									                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:300px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong>Room Type</strong></td>
									                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:100px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong>Number of rooms</strong></td>
									                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:110px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong>Max adult(s) per room</strong></td>
									                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:110px"><strong>Max child(ren) per room</strong></td>
									                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:110px"><strong>Max extra bed per room</strong></td>
									                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:150px"><strong>Check-in</strong></td>
									                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:150px"><strong>Check-out</strong></td>
									                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;width: 10%;border-right:0;border-left:0"><strong>Total price (VND)</strong></td>
									                    </tr>';
											$hotel_list .= '<tr><td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:40px;">1</td>';
											$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:300px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0">';
											$hotel_list .= $booked['roomtype'];
											$hotel_list .='</td>';
											$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:100px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0">';
											$hotel_list .= $booking['no_of_room'].'</td>';
											$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:60px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0">';
											$hotel_list .= $booking['no_of_adults'].'</td>';
											$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:60px">';
											$hotel_list .= $booking['no_of_child'].'</td>';
											$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:60px">';
											$hotel_list .= $booking['no_of_extrabed'].'x'.number_format($booking['extrabed_price'],2).'</td>';
											$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:150px">';
											$hotel_list .= ExtraHelper::date_2_show($booking['checkin']).'</td>';
											$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:150px">';
											$hotel_list .= ExtraHelper::date_2_show($booking['checkout']).'</td>';
											$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;width: 10%;border-right:0;border-left:0">';
											$hotel_list .= number_format(ExtraHelper::roundMoney2('VND', $booking['rate_vnd']*$booking['no_of_room']*$booking['booked_nights']), 2).'</td></tr>';
									        $promotion = Promotion::model()->findByPk($booking['promotion_id']);
									        $pk_pr = explode(',', $promotion->packages);
											$p_des = json_decode($promotion['short_content'], true);
									        $inclusion = '<strong>'.$booked['promotion_name'].'</strong>';
									        $inclusion .= '<br>'.str_replace("\n", '<br>',$p_des['en']);
									        $arr_booked['html_promotion'] = $inclusion;

									        $html_packages ='<tr>
										                        <td colspan="2" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-right:1px solid #000;border-bottom:1px solid #000;width:128px">
										                            <strong>Rate inclusion</strong>
										                        </td>
										                        <td colspan="7" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;">
										                            '.$arr_booked['html_promotion'].'
										                        </td>
										                    </tr>';
										    $html_packages .= '<tr>
						                        <td colspan="2" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-right:1px solid #000;border-bottom:1px solid #000;width:128px">
						                            <strong>Policy</strong>
						                        </td>
						                        <td colspan="7" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;">
								        				'.Yii::t('lang', $promotion['cancel_1']);

								        				if($promotion['cancel_2'] != 'nosecondrule'){
								        					$html_packages .= '<br>'.Yii::t('lang', $promotion['cancel_2']);
								        				}
								        				if($promotion['cancel_3'] != 'nothirdrule'){
								        					$html_packages .= '<br>'.Yii::t('lang', $promotion['cancel_3']);
								        				}
						                    $html_packages .'</td>
						                    </tr>';

									        if($booking->pickup_price == 0 && 
									        	isset($booking['pickup_flight']) && 
									        	$booking['pickup_flight'] && isset($booking['pickup_time']) && 
									        	$booking['pickup_time'] && isset($booking['pickup_date']) && 
									        	$booking['pickup_date']){
									        	$arr_booked['pickup_price'] = 'Free';
									        }elseif($booking['pickup_price']>0){
									        	$total += $booking['pickup_price'];
									        	$arr_booked['pickup_price'] = number_format(ExtraHelper::roundMoney2('VND', $booking['pickup_price']), 2);
									        }else{
									        	$arr_booked['pickup_price'] = '';
									        }
									        $arr_booked['dropoff']=$booking['dropoff_flight'].' - '.$booking['dropoff_time'].' '.($booking['dropoff_date']!='0000-00-00'?$booking['dropoff_date']:'');
									        
									        if($booking->dropoff_price == 0 && isset($booking['dropoff_flight']) && 
									        	$booking['dropoff_flight'] && isset($booking['dropoff_date']) && 
									        	$booking['dropoff_date'] && isset($booking['dropoff_time']) && 
									        	$booking['dropoff_time']){
									        	$arr_booked['dropoff_price'] = 'Free';
									        }elseif($booking['dropoff_price']>0){
									        	$total += $booking['dropoff_price'];
									        	$arr_booked['dropoff_price'] = ($booking['dropoff_price']>0?number_format(ExtraHelper::roundMoney2('VND', $booking['dropoff_price']), 2):'');
									        }else{
									        	$arr_booked['dropoff_price'] = '';
									        }
									        if($arr_booked['dropoff_price'] || $arr_booked['pickup_price']){
									        	$row=1;
									        }elseif($arr_booked['dropoff_price'] && $arr_booked['pickup_price']){
									        	$row=2;
									        }
									        if($arr_booked['dropoff_price'] || $arr_booked['pickup_price']){
									        $html_packages .= 	'<tr>
											                        <td rowspan="'.$row.'" colspan="2" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;">
											                            <strong>Other Services</strong>
											                        </td>';
											    if($arr_booked['pickup_price']){
											        $html_packages .= '<td align="left" colspan="3" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;border-left:1px solid #000;" valign="middle">
											                            Airport Pick-up
											                        </td>
											                        <td align="left" valign="middle" colspan="2" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;border-left:1px solid #000;border-right:1px solid #000;">
											                            '.$arr_booked['pickup'].'
											                        </td>
											                        <td align="left" colspan="2" style="font-size: 12px;word-wrap:break-word;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;">
											                            '.$arr_booked['pickup_price'].'
											                        </td>';
											    }
											       	$html_packages .= 	'
											                    </tr>';
											    if($arr_booked['dropoff_price']){
											        $html_packages .= '<tr>
											                        <td align="left" colspan="3" style="word-wrap:break-word;font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;border-left:1px solid #000;" valign="middle">
											                            Airport Drop-off
											                        </td>
											                        <td align="left" colspan="2" style="font-size: 12px;word-wrap:break-word;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;border-left:1px solid #000;">
											                            '.$arr_booked['dropoff'].'
											                        </td>
											                        <td align="left" colspan="2" style="font-size: 12px;word-wrap:break-word;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;border-left:1px solid #000;">
											                            '.$arr_booked['dropoff_price'].'
											                        </td>
											                    </tr>';
											    }
											}

									        $packages = BookPackage::model()->getList($booking['id']);
											$sum_packages = count($packages->getData());
											
											if($sum_packages>0){

												foreach($packages->getData() as $pkey => $pk){
													if($pkey==0){
														$html_packages .= '<tr>';
															$html_packages .= 	'<td rowspan="'.$sum_packages.'" colspan="2" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
														                            <strong>Packages</strong>
														                        </td>
														                        <td colspan="3" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-left:1px solid #000;border-bottom:1px solid #000;width:150px;">
														                            <strong>'.$pk->package->name.'</strong>
														                        </td>
														                        <td colspan="2" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-left:1px solid #000;border-bottom:1px solid #000;">
														                            '.$pk->adult.' adult(s), '. $pk->child.' child(ren)
														                        </td>
														                        <td colspan="2" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-left:1px solid #000;border-bottom:1px solid #000;">
														                            ';
														                            if($pk['adult'] == 0){
														                            	$html_packages .= 'Free';
														                            }else{
														                            	$total_p = ($pk->package->rate*$pk->adult+$pk->package->rate_child*$pk->child)*$booking['booked_nights']*$pk->exchange_rate;
														                            	$total += $total_p;

														                            	$html_packages .= number_format(ExtraHelper::roundMoney2('VND', $total_p), 2);
														                            }
														    $html_packages .= 	'
														                        </td>';
														$html_packages .= '</tr>';
													}else{
														$html_packages .= '<tr>';
															$html_packages .= 	'
														                        <td colspan="3" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-left:1px solid #000;">
														                            <strong>'.$pk->package->name.'</strong>
														                        </td>
														                        <td colspan="2" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-left:1px solid #000;">
														                            '.$pk->adult.' adult(s), '. $pk->child.' child(ren)
														                        </td>
														                        <td colspan="2" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-left:1px solid #000;">
														                            ';
														                            if($pk['adult'] == 0){
														                            	$html_packages .= 'Free';
														                            }else{
														                            	$total_p = ($pk->package->rate*$pk->adult+$pk->package->rate_child*$pk->child)*$booking['booked_nights']*$pk->exchange_rate;
														                            	$total += $total_p;
														                            	$html_packages .= number_format(ExtraHelper::roundMoney2('VND', $total_p), 2);
														                            }
														    $html_packages .= 	'
														                        </td>';
														$html_packages .= '</tr>';
													}
												}
												
											}

											$vat = $sc = 0;
									        $vat_setting = Settings::model()->getSetting('include_vat', $booked['hotel_id']);
									        if($vat_setting == 'false'){
									            $vat = $total*10/100;
												$sc= ($total+$vat)*5/100;
									        }
											
											$grand_total = $total + $vat+$sc;
											$arr_booked['total'] = number_format(ExtraHelper::roundMoney2('VND', $grand_total), 2);
									        if($booking['currency'] !== 'VND'){
									        	$exchange_currency_booked = (array)ExchangeRate::model()->convertCurrencyToUSD($booking['currency']);
									        	$arr_booked['total'] .= ' (~ '.$booking['currency'].' ' .number_format(ExtraHelper::roundMoney2($booking['currency'], $grand_total/$exchange_currency_booked['sell']), 2). ')';
									        }

											$html_packages .=	'<tr>
											                        <td align="right" colspan="7" style="border-right:1px solid #000;word-wrap:break-word;font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;" valign="middle">
											                            <strong>Total to be paid in VND<br></strong>
											                            (include 10% VAT &5% Service Charge Rate): 
											                        </td>
											                        <td align="left" colspan="2" style="word-wrap:break-word;border-top:1px solid #000;font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;border-top:1px solid #000;" valign="middle">
											                        '.$arr_booked['total'].'
											                        </td>
											                    </tr>';
										?>
										<table width="100%" style="padding:0" border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;font-family:arial,sans-serif;border-collapse:collapse;">
		                					<tbody>
		                						<?php echo $hotel_list.$html_packages;?>
		                					</tbody>
		                				</table>
			                        </td>
			                    </tr>
			                    <?php if($booking['notes']){?>
				                    <tr>
				                        <td colspan="9" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
				                            <?php echo $booking['notes'];?>
				                        </td>
				                    </tr>
			                    <?php }

			                    $term = json_decode($booking->hotel['term_condition'], true);
    							?>
    							<tr>
			                        <td colspan="9" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
			                           <?php echo $term['en'];?>
			                        </td>
			                    </tr>
			                </tbody>
			            </table>
			        </td>
			    </tr>
			</table>
			<?php if($booking['status'] == 'amended' || $booking['status'] == 'confirmed'){?>
		        <div class="row" style="margin-top:20px;">
		        	<div class="col-md-12">
		        		<button type="submit" name="updateBooking" class="btn btn-primary">Update</button>
		        	</div>
		        </div>
	        <?php }?>
	    </div>
	</div>
</div>
<?php $this->endWidget();?>
<?php
if(isset($_POST['updateBooking'])){?>
	<script type="text/javascript">
		alert('Amend successfull! Please check your email');
	</script>
<?php }?>