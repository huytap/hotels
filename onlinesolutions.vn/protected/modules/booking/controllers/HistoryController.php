<?php

class HistoryController extends Controller{
	public $layout = 'mainbk';
	public function actionIndex($hotel_id, $chain_id){
        try{
            if(Yii::app()->session['history']){
                $booking = Yii::app()->session['history'];
                $this->render('index', compact('booking'));
            }else{
                $this->redirect(Yii::app()->baseUrl.'/booking/login/'.$hotel_id.'/'.$chain_id);
            }
        }catch(Exception $ex){
            echo $ex;
        }
    }

    public function actionModify($token){
    	if(Yii::app()->session['history'] && Yii::app()->session['token'] === $token){
    		$booked = Yii::app()->session['_booked'];
    		//var_dump($booked);
    		$booking = Yii::app()->session['history'];
            $old_booking = Yii::app()->session['history'];
            $old['fromDate'] = $old_booking['checkin'];
            $old['toDate'] = $old_booking['checkout'];
            $old['hotel_id'] = $old_booking['hotel_id'];
            $old_roomtype = $old_booking['roomtype_id'];
            $old_no_of_room = $old_booking['no_of_room'];
    		$booking['roomtype_id'] = $booked['roomtype_id'];
    		$booking['promotion_id'] = $booked['promotion_id'];
    		$booking['rate_vnd'] = $booked['rate'];
    		$booking['no_of_room'] = $booked['no_of_room'];
		    $booking['change_currency_rate'] = $booked['exchangeRate'];
		    $booking['booked_nights'] = $booked['nights'];
		    $checkin = ExtraHelper::date_2_save($booked['checkin']);
		    $checkout = ExtraHelper::date_2_save($booked['checkout']);
		    $booking['checkin'] = $checkin['date'];
		    $booking['checkout'] = $checkout['date'];
		    $booing['no_of_adults'] = $booked['adult'];
		    $booking['no_of_child'] = $booked['children'];
    		//echo"<pre>";print_r($booking);
		    $currency_setting = Settings::model()->getSetting('currency',$booked['hotel_id']);
    		$total = $booked['rate']*$booked['nights']*$booked['no_of_room'];
            $booking->updated_date = date('Y-m-d H:m:i');
            $changeRate_VND = (array)ExchangeRate::model()->convertCurrencyToUSD($booked->currency);
            $usd_to_VND = (array)ExchangeRate::model()->convertCurrencyToUSD(strtoupper($currency_setting));
            $booking->total_no_tax = $total;
            $booking->total_no_tax_vnd = $total *$changeRate_VND['sell'];
            $booking->total_no_tax_airport = $total;
            $booking->total_no_tax_vnd_airport = $total *$changeRate_VND['sell'];
            $tax = $service_charge = 0;
            $vat_setting = Settings::model()->getSetting('include_vat', $booked['hotel_id']);
            $total += $booking['pickup_price'];
            $total += $booking['dropoff_price'];
            if($vat_setting == 'false'){
                $tax = $total*0.1;
                $service_charge = ($total+$tax)*0.05;
            }

            $booking->tax=$tax;
            $booking->service_charge=$service_charge;
            $booking->total = ($total+$tax+$service_charge);
            $booking->total_vnd = $booking->total;
            $booking->booked_nights = ExtraHelper::date_diff($booking->checkin, $booking->checkout);
            $booking->status = 'amended';
            $booking->token = $token;
    		if(isset($_POST['updateBooking'])){                
    			if($booking->update()){
    				Yii::app()->session['history'] = $booking;
                    $roomRefund = Rooms::model()->checkRoom4($old_roomtype, $old);
                    //echo"<pre>";print_r($roomRefund);die;
                    foreach($roomRefund as $r){
                        $r->available += $old_no_of_room;
                        $r->update();
                    }
                    $hotel = Hotel::model()->findByPk($booking['hotel_id']);  
                    $email_sales = explode(';', $hotel['email_sales']);
                    $email_receive = array();
                    foreach($email_sales as $er){
                        $email_receive[$er] = $er;
                    }
                    $subject = 'Reservation Amendment of #' . strtoupper($booking['short_id']);
                    $output = "";
                    $template_file = "template/amendment_letter.htm";
                    $full_name = 'Thank you for your booking - '. $booking['first_name'].' '.$booking['last_name'];
                    $result = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $booking, array($booking['email']=> $booking['email']), $email_receive, $output);

                    BookingHelper::updateAvailable($booked, $booking);
                    unset(Yii::app()->session['history']);
    				$this->redirect(Yii::app()->baseUrl.'/booking/login/'.$booking->hotel->hotel_id.'/'.$booking->hotel->chain_id);
    			}
    		}
    		$this->render('modify', compact(array('booking', 'booked')));
    	}
    }

    public function actionCancel(){
    	$this->layout = false;
        if(isset($_POST['bookingid']) && isset($_POST['email']) && isset($_POST['reason'])){

            $check = Bookings::model()->getByEmail_ShortID($_POST['email'], $_POST['bookingid']);
            if($check){
                $check->status = 'cancelled';
                $check->reason = $_POST['reason'];
                if($check->update()){
                	Yii::app()->session['history'] = $check;

                    $email_sales = explode(';', $check['hotel']['email_sales']);

                    $email_receive = array();

                    foreach($email_sales as $er){
                        $email_receive[$er] = $er;
                    }

                    $subject = 'Reservation Cancellation of #' . strtoupper($check['short_id']);

                    $output = "";

                    $template_file = "template/cancellation_letter.htm";

                    $full_name = 'Thank you for your booking - '. $check['first_name'].' '.$check['last_name'];

                    $result = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $check, array($check['email']=> $check['email']), $email_receive, $output);
                    unset(Yii::app()->session['history']);
                    echo json_encode(1);
                }else{
                    echo json_encode(0);
                }
            }else{
            	echo json_encode(0);
            }
        }
    }

    public function actionCheckbooking($hotel_id, $chain_id){
		try{
			$model=new CheckBooking;
			if(isset($_POST['CheckBooking'])){
				$model->attributes = $_POST['CheckBooking'];
				$model->validate();
				if(!$model->hasErrors()){
					$check = Bookings::model()->getByEmail_ShortID($_POST['CheckBooking']['email'], $_POST['CheckBooking']['bookingid']);
					if($check){
						Yii::app()->session['history'] = $check;
						$this->redirect(Yii::app()->baseUrl.'/history/'.$_GET['hotel_id'].'/'.$_GET['chain_id']);
					}else{
						Yii::app()->user->setFlash('error', 'Email address or Booking ID is wrong');
					}
				}
			}
			$this->render('checkbooking',array('model'=>$model));
		}catch(Exception $ex){

		}
	}
}