<?php
class Mailer {
	public $mailer;
    public function init()
    {
		require_once dirname(__FILE__).'/phpmailer/class.phpmailer.php';
		$this->mailer = new PHPMailer(); 
		$this->initialize_mailer_smtp($this->mailer, Yii::app()->params['mailer_config']['server'], Yii::app()->params['mailer_config']['user'], Yii::app()->params['mailer_config']['password'], Yii::app()->params['mailer_config']['email_from_name']);
    }

	function initialize_mailer_smtp(&$mail, $smtp_server, $smtp_email, $smtp_pass, $from_name) {
		
		$mail->IsSMTP();
		$mail->SMTPAuth   = TRUE;
		$mail->SMTPSecure = "ssl";
		$mail->Port       = 465;
		$mail->Host       = $smtp_server;
		$mail->Username   = $smtp_email;  
		$mail->Password   = $smtp_pass;  
		$mail->From       = $smtp_email;
		$mail->FromName   = $from_name;
		$mail->CharSet = "UTF-8";
	}

	public function template2content($template_file, $arr_content) {
		if (!file_exists($template_file)) {
			return FALSE;
		}
		$content = file_get_contents($template_file);
		if ($arr_content) {
			foreach ($arr_content as $key => $val) {
				$content = str_replace("~~$key~~", $val, $content);
			}
		}
		return $content;
	}

	public function template2content2($template_file, $arr_content) {
		if (!file_exists($template_file)) {
			return FALSE;
		}
		$content = file_get_contents($template_file);
		$arr_booked = array();
		$background_email_setting = Settings::model()->getSetting('background_email', $arr_content['hotel_id']);
		$arr_booked['background_email'] = '';
		if($background_email_setting){
			$arr_booked['background_email'] = 'background:'.$background_email_setting;
		}
		$arr_booked['logo'] = '<img width="120" src="https://onlinesolutions.vn/images/'.$arr_content->hotel['logo1'].'">';
		$arr_booked['hotel_name'] = $arr_content->hotel['name'];
		$address = json_decode($arr_content->hotel['address'], true);
		$city = json_decode($arr_content->hotel['city'], true);
		$country = json_decode($arr_content->hotel['country'], true);
		$arr_booked['address'] = $address['en'].', '.$city['en'].', '.$country['en'];
		$arr_booked['phone'] = $arr_content->hotel['tel'];
		$arr_booked['email'] = $arr_content->hotel['email_sales'];
		$arr_booked['link_text'] = $arr_content->hotel['website'];
		$arr_booked['link_website'] = $arr_content->hotel['website'];
		$arr_booked['gender'] = $arr_content['title'];
		$arr_booked['first_name']= $arr_content['first_name'];
		$arr_booked['last_name']=$arr_content['last_name'];
		$arr_booked['booked_email']=$arr_content['email'];
		$arr_booked['reservation_number'] = strtoupper($arr_content['short_id']);
		$arr_booked['booked_phone'] = $arr_content['phone'];
		$total = ($arr_content['rate_vnd']*$arr_content['no_of_room'] + $arr_content['no_of_extrabed']*$arr_content['extrabed_price'])*$arr_content['booked_nights'];
		$hotel_list = '<tr>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:40px;"><strong>No</strong></td>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:300px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong>Room Type</strong></td>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:100px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong>Number of rooms</strong></td>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:60px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0"><strong>Max adult(s) per room</strong></td>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:60px"><strong>Max child(ren) per room</strong></td>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:60px"><strong>Max extra bed per room</strong></td>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:150px"><strong>Check-in</strong></td>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:150px"><strong>Check-out</strong></td>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;width: 10%;border-right:1px solid #000;border-left:0"><strong>Price (VND) per room per night</strong></td>
                        <td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;width: 10%;border-right:0;border-left:0"><strong>Toal (VND)</strong></td>
                    </tr>';
		$hotel_list .= '<tr><td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:40px;">1</td>';
		$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:300px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0">';
		$hotel_list .= $arr_content->roomtype->name;
		$hotel_list .='</td>';
		$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:100px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0">';
		$hotel_list .= $arr_content['no_of_room'].'</td>';
		$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;width:60px;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0">';
		$hotel_list .= $arr_content['no_of_adults'].'</td>';
		$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:60px">';
		$hotel_list .= $arr_content['no_of_child'].'</td>';
		$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:60px">';
		$hotel_list .= $arr_content['no_of_extrabed'].'x'.number_format(ExtraHelper::roundMoney2('VND', $arr_content['extrabed_price']),2).'</td>';
		$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:150px">';
		$hotel_list .= ExtraHelper::date_2_show($arr_content['checkin']).'</td>';
		$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-right: 1px solid #000;border-bottom:1px solid #000;border-left:0;width:150px">';
		$hotel_list .= ExtraHelper::date_2_show($arr_content['checkout']).'</td>';
		$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;width: 10%;border-right:1px solid #000;border-left:0">';

		$hotel_list .= number_format(ExtraHelper::roundMoney2('VND', $arr_content['rate_vnd']), 2).'</td>';

		$hotel_list .= '<td align="center" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;text-align: center;border-collapse:collapse;border-bottom: 1px solid #000;width: 10%;border-right:0;border-left:0">';
		$hotel_list .= number_format(ExtraHelper::roundMoney2('VND', $arr_content['rate_vnd']*$arr_content['no_of_room']*$arr_content['booked_nights']), 2).'</td></tr>';
		
        $pr_name = json_decode($arr_content->promotion->name, true);
        $pk_pr = explode(',', $arr_content->promotion->packages);
		$p_des = json_decode($arr_content->promotion['short_content'], true);
        $inclusion = '<strong>'.$pr_name['en'].'</strong>';
        $inclusion .= '<br>'.str_replace("\n", '<br>',$p_des['en']);
        $arr_booked['html_promotion'] = $inclusion;

        $html_packages ='<tr>
	                        <td colspan="2" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-right:1px solid #000;border-bottom:1px solid #000;width:128px">
	                            <strong>Rate inclusion</strong>
	                        </td>
	                        <td colspan="8" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;">
	                            '.$arr_booked['html_promotion'].'
	                        </td>
	                    </tr>';
	    $html_packages .= '<tr>
            <td colspan="2" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-right:1px solid #000;border-bottom:1px solid #000;width:128px">
                <strong>Policy</strong>
            </td>
            <td colspan="8" align="left" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;">
    				'.Yii::t('lang', $arr_content->promotion['cancel_1']);

    				if($arr_content->promotion['cancel_2'] != 'nosecondrule'){
    					$html_packages .= '<br>'.Yii::t('lang', $arr_content->promotion['cancel_2']);
    				}
    				if($arr_content->promotion['cancel_3'] != 'nothirdrule'){
    					$html_packages .= '<br>'.Yii::t('lang', $arr_content->promotion['cancel_3']);
    				}
        $html_packages .'</td>
        </tr>';
        $arr_booked['pickup']=$arr_content['pickup_flight'].' - '.$arr_content['pickup_time'].' '.$arr_content['pickup_date'];
        if($arr_content->pickup_price == 0 && 
        	isset($arr_content['pickup_flight']) && 
        	$arr_content['pickup_flight'] && isset($arr_content['pickup_time']) && 
        	$arr_content['pickup_time'] && isset($arr_content['pickup_date']) && 
        	$arr_content['pickup_date']){
        	$arr_booked['pickup_price'] = 'Free';
        }elseif($arr_content['pickup_price']>0){
        	$total += $arr_content['pickup_price'];
        	$arr_booked['pickup_price'] = number_format(ExtraHelper::roundMoney2('VND', $arr_content['pickup_price']), 2);
        }else{
        	$arr_booked['pickup_price'] = '';
        }
        $arr_booked['dropoff']=$arr_content['dropoff_flight'].' - '.$arr_content['dropoff_time'].' '.($arr_content['dropoff_date']!='0000-00-00'?$arr_content['dropoff_date']:'');
        
        if($arr_content->dropoff_price == 0 && isset($arr_content['dropoff_flight']) && 
        	$arr_content['dropoff_flight'] && isset($arr_content['dropoff_date']) && 
        	$arr_content['dropoff_date'] && isset($arr_content['dropoff_time']) && 
        	$arr_content['dropoff_time']){
        	$arr_booked['dropoff_price'] = 'Free';
        }elseif($arr_content['dropoff_price']>0){
        	$total += $arr_content['dropoff_price'];
        	$arr_booked['dropoff_price'] = ($arr_content['dropoff_price']>0?number_format(ExtraHelper::roundMoney2('VND', $arr_content['dropoff_price']), 2):'');
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
		        $html_packages .= '<td align="left" colspan="4" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;border-left:1px solid #000;" valign="middle">
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
		                        <td align="left" colspan="4" style="word-wrap:break-word;font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;border-left:1px solid #000;" valign="middle">
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

        

        

      	$arr_booked['specialRequest'] = $arr_content['notes'];

        $term = json_decode($arr_content->hotel['term_condition'], true);
        $arr_booked['term'] = $term['en'];

        $packages = BookPackage::model()->getList($arr_content['id']);
		$sum_packages = count($packages->getData());
		
		if($sum_packages>0){

			foreach($packages->getData() as $pkey => $pk){
				if($pkey==0){
					$html_packages .= '<tr>';
						$html_packages .= 	'<td rowspan="'.$sum_packages.'" colspan="2" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;">
					                            <strong>Packages</strong>
					                        </td>
					                        <td colspan="4" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-left:1px solid #000;border-bottom:1px solid #000;width:150px;">
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
					                            	if($pk->package->is_book)
					                            		$total_p = ($pk->package->rate*$pk->adult+$pk->package->rate_child*$pk->child)*$arr_content['booked_nights']*$pk->exchange_rate;
					                            	else
					                            		$total_p = ($pk->package->rate*$pk->adult+$pk->package->rate_child*$pk->child)*$pk->exchange_rate;
					                            	$total += $total_p;

					                            	$html_packages .= number_format(ExtraHelper::roundMoney2('VND', $total_p), 2);
					                            }
					    $html_packages .= 	'
					                        </td>';
					$html_packages .= '</tr>';
				}else{
					$html_packages .= '<tr>';
						$html_packages .= 	'
					                        <td colspan="4" align="left" valign="middle" style="font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-left:1px solid #000;">
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
					                            	$total_p = ($pk->package->rate*$pk->adult+$pk->package->rate_child*$pk->child)*$arr_content['booked_nights']*$pk->exchange_rate;
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
        $vat_setting = Settings::model()->getSetting('include_vat', $arr_content['hotel_id']);
        if($vat_setting == 'false'){
            $vat = $total*10/100;
			$sc= ($total+$vat)*5/100;
        }
		
		$grand_total = $total + $vat+$sc;
		$arr_booked['total'] = number_format(ExtraHelper::roundMoney2('VND', $grand_total), 2);
        if($arr_content['currency'] !== 'VND'){
        	$exchange_currency_booked = (array)ExchangeRate::model()->convertCurrencyToUSD($arr_content['currency']);
        	$arr_booked['total'] .= ' (~ '.$arr_content['currency'].' ' .number_format(ExtraHelper::roundMoney2($arr_content['currency'], $grand_total/$exchange_currency_booked['sell']), 2). ')';
        }

		$html_packages .=	'<tr>
		                        <td align="right" colspan="7" style="border-right:1px solid #000;word-wrap:break-word;font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-right:1px solid #000;border-bottom:1px solid #000;border-top:1px solid #000;" valign="middle">
		                            <strong>Total to be paid in VND<br></strong>
		                            (include 10% VAT & 5% Service Charge Rate): 
		                        </td>
		                        <td align="left" colspan="3" style="word-wrap:break-word;border-top:1px solid #000;font-size: 12px;font-family:arial,sans-serif;padding:5px 3px;border-collapse:collapse;border-bottom:1px solid #000;border-top:1px solid #000;" valign="middle">
		                        '.$arr_booked['total'].'
		                        </td>
		                    </tr>';

		$arr_booked['html_list'] = '<table width="100%" style="padding:0" border="0" cellpadding="0" cellspacing="0" style="font-size: 12px;font-family:arial,sans-serif;border-collapse:collapse;">'.
                					'<tbody>'.$hotel_list.$html_packages.'</tbody></table>';
		if ($arr_booked) {
			foreach ($arr_booked as $key => $val) {
				$content = str_replace("~~$key~~", $val, $content);
			}
		}


		//var_dump($content);die;
		return $content;
	}
	
	function send_email($subject, $template_file, $full_name, $data, $arr_to, $arr_cc, &$output, $flag=true, $email_reply='') {
		
		$this->mailer->ClearAllRecipients();
		if (!$this->mailer->Host || !$this->mailer->Username || !$this->mailer->Password) {
			/* echo "NO SEND"; */
			return FALSE;
		}
		if (!$arr_to || count($arr_to)<=0) {
			return FALSE;
		} else {
			/*print_r($arr_to);*/
		}
		/* for testing at Kha's computer */
		/*$arr_to = array('nghuytap@gmail.com' => 'nghuytapptit@gmail.com');
		$arr_cc = array('huytapptit@yahoo.com' => 'huytapptit@yahoo.com');*/
		
		/* ************** */
		$output = array();
		if($flag){
			$email_content = $this->template2content2($template_file, $data);
		}else{
			$email_content = $this->template2content($template_file, $data);
		}
		//$email_content = $this->template2content2($template_file, $data);
		//$email_content = $template_file;
		$this->mailer->FromName   = $full_name;
		$this->mailer->Subject = $subject;
		$this->mailer->MsgHTML($email_content);
		$this->mailer->SMTPDebug  = 1;            // enables SMTP debug information (for testing)
		
		//$this->mailer->AddReplyTo(Yii::app()->params['email_sent'], 'No Reply');
		if($email_reply){
			$this->mailer->AddReplyTo($email_reply, 'Reservation');
		}else{
			$this->mailer->AddReplyTo(Yii::app()->params['email_sent'], 'No Reply');
		}
		foreach ($arr_to as $email => $name) {
			if ($email) {
				$this->mailer->AddAddress($email, $name);
			}
		}	
		if ($arr_cc) {
			foreach ($arr_cc as $email => $name) {
				if ($email) {
					$this->mailer->AddCC($email, $name);
				}
			}
		}
                $this->mailer->AddBCC('nghuytap@gmail.com', 'IT');
		$bRet = TRUE;
		$bRet = $this->mailer->Send();  
		if (!$bRet) {
			$output['error'] = $this->mailer->ErrorInfo;
			return FALSE;
		} else {
			$output['email_content'] = $email_content;
			return TRUE;
		}
	} 
}
?>