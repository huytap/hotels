<?php
class BookingController extends Controller{
    public $layout='mainbk';
	public function actionIndex(){
        //try{
            unset(Yii::app()->session['_booked']);
            $model = new FormBook;
            $now = date('Y-m-d');
            $hotel = Hotel::model()->find();
            $params = array(
                'fromDate' => $now,
                'toDate' => date('d-m-Y', strtotime("$now +1day")),
                'adult' => 2,
                'children' => 0,
                'hotel' => $hotel['id'],
                'no_of_room' => 0
            );
            /*GET method*/
            if(isset($_GET['checkindate']) && strtotime($_GET['checkindate'])>=strtotime($now)){
                $params['fromDate'] = $_GET['checkindate'];
            }else{
                $params['fromDate'] = date('d-m-Y', strtotime($now));
            }

            if(isset($_GET['checkoutdate']) && 
                strtotime($_GET['checkoutdate'])>strtotime($now) && 
                strtotime($_GET['checkoutdate'])>strtotime($params['fromDate'])){
                $params['toDate'] = $_GET['checkoutdate'];   
            }else{
                $params['toDate'] = date('d-m-Y', strtotime($now ." +1day"));
            }

            if(isset($_GET['adult'])){
                $params['adult'] = $_GET['adult'];
            }

            if(isset($_GET['children'])){
                $params['children'] = $_GET['children'];
            }
            if(isset($_GET['rtype'])){
                $params['rtype'] = $_GET['rtype'];
            }
            if(isset($_GET['promo'])){
                $params['rtype_pr'] = $_GET['promo'];
            }
            /*if(isset($_GET['no_room'])){
                $params['no_of_room'] = $_GET['no_room'];
            }else{
                $params['no_of_room'] = 1;
            }*/

            /*post method*/
            if(isset($_POST['checkindate']) && 
                strtotime($_POST['checkindate'])>=strtotime($now)){
                $params['fromDate'] = $_POST['checkindate'];
            }

            if(isset($_POST['checkoutdate']) && 
                strtotime($_POST['checkoutdate'])>strtotime($now) && 
                strtotime($_POST['checkoutdate'])>strtotime($params['fromDate'])){
                $params['toDate'] = $_POST['checkoutdate'];   
            }

            if(isset($_POST['adult'])){
                $params['adult'] = $_POST['adult'];
            }

            if(isset($_POST['children'])){
                $params['children'] = $_POST['children'];
            }

            Yii::app()->session['_params'] = $params;
            if(!Yii::app()->session['change_currency']){
                Yii::app()->session['change_currency'] = 'VND';
            }
            /*if(isset($_POST['FormBook'])){
                $checkin = $_POST['FormBook']['checkin'];
                $checkout = $_POST['FormBook']['checkout'];
                $adult = $_POST['FormBook']['adult'];
                $children = $_POST['FormBook']['children'];
                $url = Yii::app()->params['booking'].'search?checkindate=' .$checkin. "&checkoutdate=" . $checkout.'&adult='.$adult.'&children='.$children;

                $params['fromDate'] = $checkin;
                $params['toDate'] = $checkout;
                $params['adult'] = $adult;
                $params['children'] = $children;

                $this->redirect($url);
            }*/
            /*if(isset($_POST['exchange_rate'])){
                Yii::app()->session['change_currency'] = $_POST['exchange_rate'];
            }*/
            $list_curr = ExchangeRate::model()->getList2();
            /*if(isset($_GET['currency']) && in_array($_GET['currency'], $list_curr)){
               Yii::app()->session['change_currency'] = $_GET['currency']; 
            }else{
                Yii::app()->session['change_currency'] = 'USD'; 
            }*/
            if(isset($_POST['currency'])){
                Yii::app()->session['change_currency'] = $_POST['currency'];
            }elseif(!Yii::app()->session['change_currency']){
                Yii::app()->session['change_currency'] = Settings::model()->getSetting('currency', $params['hotel']) ? Settings::model()->getSetting('currency', $params['hotel']) : 'USD'; 
            }
            $change_currency = Yii::app()->session['change_currency'];
            /*USD is default currency*/
            $defaultRate = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
            /*submit change currency*/
            $changeRate = (array)ExchangeRate::model()->convertCurrencyToUSD($change_currency);
            $exchangeRate = $defaultRate['sell'] / $changeRate['sell'];
            
            $params['exchangeRates'] = $exchangeRate;
            $params['currency'] = $change_currency;

            /*get room available*/
            $available = BookingHelper::getRoomRate($params);
            //echo"<pre>";print_r($available);die;
            Yii::app()->session['_available']=$available;

            /*book roomtype*/
            if(isset($_GET['flag']) && $_GET['flag']==true || 
                (isset($_POST['flag']) && $_POST['flag']==true)){
                $this->layout = false;
                $this->render('ajax', array(
                    'available' => $available, 
                    'params' => $params,
                    'model' => $model,
                    'hotel'=>$hotel));
            }else{
        		$this->render('index', array(
                    'available' => $available, 
                    'params' => $params,
                    'model' => $model,
                    'hotel'=>$hotel));
            }
        /*}catch(Exception $ex){
            $this->render('../site/error');
        }*/
	}

    public function actionPrebook(){
        $token = ExtraHelper::generateRandomString(28);
        Yii::app()->session['token'] = $token;
        $lang = Yii::app()->session['_lang'];
        if(Yii::app()->session['_params'] && 
            Yii::app()->session['change_currency'] && 
            isset($_POST['roomtype']) && $_POST['roomtype']> 0 && 
            isset($_POST['promotion']) && $_POST['promotion']>0 && 
            isset($_POST['no_room']) && $_POST['no_room']>0){
            $params = Yii::app()->session['_params'];
            $params['no_of_room'] = $_POST['no_room'];
            $params['currency'] = Yii::app()->session['change_currency'];
            $changeRate = (array)ExchangeRate::model()->convertCurrencyToUSD($params['currency']);
            $defaultRate = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
            $exchangeRate = $defaultRate['sell'] / $changeRate['sell'];
            $params['exchangeRates'] = $exchangeRate;
            $checkRoom = Rooms::model()->checkRoom3($_POST['roomtype'], $params);
            
            $flag = false;

            $cart = array();
            //echo"<pre>";print_r($checkRoom);
            foreach($checkRoom as $room){
                if($room['available']<=0 && $room['auto_fill'] <=0){
                    $flag=true;
                }
            }
            if(!$flag){
                $available = Yii::app()->session['_available'];
                $adult = $params['adult'];
                $children = $params['children'];
                $getRoomtype = Roomtype::model()->checkRoomtype($_POST['roomtype']);
                if(isset($available[$getRoomtype['display_order']]['promos']['promos_'.$_POST['promotion']][$adult])){
                    $checkRate = Rates::model()->getList2($_POST['roomtype'], $params);
                    $cart['roomtype'] = $getRoomtype['name'];
                    $cart['roomtype_id'] = $getRoomtype['id'];
                    $cart['hotel_id'] = $getRoomtype['hotel_id'];
                    $cart['promotion_name'] = $available[$getRoomtype['display_order']]['promos']['promos_'.$_POST['promotion']]['promotion_name'];
                    $cart['rate'] = $available[$getRoomtype['display_order']]['promos']['promos_'.$_POST['promotion']][$adult];
                    $cart['no_of_room'] = $params['no_of_room'];

                    $cart['exchangeRate'] = $exchangeRate;
                    
                    $cart['nights'] = ExtraHelper::date_diff($params['fromDate'], $params['toDate']);

                    $cart['promotion_id'] = $_POST['promotion'];

                    $cart['currency'] = $params['currency'];

                    $cart['checkin'] = $params['fromDate'];
                    $cart['checkout'] = $params['toDate'];
                    $cart['adult']=$adult;
                    $cart['children'] = $children;

                    $room=Roomtype::model()->findByPk($getRoomtype['id']);
                    for($e=1;$e<=$params['no_of_room'];$e++){
                        if($params['adult'] > $room['no_of_adult']){
                        /*if($_POST['data']['extrabed']=='extrabed'.$e && 
                            $_POST['data']['extra_value'] == 1){*/
                            $cart['extrabed'.$e] = Settings::model()->getSetting('extrabed',$params['hotel'])*$params['exchangeRates'];
                        }
                    }

                    $pr_pk = Promotion::model()->findByPk($_POST['promotion']);
                    $package = explode(',', $pr_pk->packages);
                    foreach($package as $p){
                        $pk = Package::model()->findByPk($p);
                        if($pk){
                            $cart['packages'][$p] = array(
                                'price_adult' => 0,
                                'price_child' => 0,
                                'adult' => 0,
                                'child' => 0
                            );
                        }
                    }

                    Yii::app()->session['_booked'] = $cart;
                    //$this->redirect(Yii::app()->params['booking'].$lang.'/payment');
                    echo json_encode(1);
                }else{
                    //$this->redirect(Yii::app()->params['booking'].'search');
                    echo json_encode(-1);
                }
            }else{
                echo json_encode(-2);
                //$this->redirect(Yii::app()->params['booking'].'search');
            }
        }else{
            echo json_encode(-3);
        }
    }

    public function actionOption(){
        $token = Yii::app()->session['token'];
        $booked = Yii::app()->session['_booked'];
        if($booked){
            $booking = new BookingForm;
            $booking->scenario = 'option';
            $booking->pickup = $booked['pickup'];
            $booking->pickup_flight = $booked['pickup_flight'];
            $booking->pickup_date = $booked['pickup_date'];
            $booking->pickup_time = $booked['pickup_time'];
            $booking->dropoff = $booked['drop_off'];
            $booking->drop_flight = $booked['drop_flight'];
            $booking->drop_date = $booked['drop_date'];
            $booking->drop_time = $booked['drop_time'];
            

            $book = Bookings::model()->getBooking('failed', $token);

            $changeRate_VND = (array)ExchangeRate::model()->convertCurrencyToUSD($book->currency);
            $usd_to_VND = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
            if(isset($_POST['BookingForm'])){
                $booking->attributes = $_POST['BookingForm'];
                $booking->validate();
                
                if(!$booking->hasErrors()){
                    $currency_setting = Settings::model()->getSetting('currency',$booked['hotel_id']);
                    if(!$book){
                        $book=new Bookings;
                        $book->status = 'failed';
                        $book->request_date = date('Y-m-d H:i:m');
                        $book->token = $token;
                        $book->ip_address=$_SERVER['REMOTE_ADDR'];
                        $book->change_currency_rate=$booked['exchangeRate'];
                        $book->currency = $booked['currency'];                        
                        //$book->srcFile=$book->short_id . '_' . date('dMY') . '.pdf';
                        $book->hotel_id = $booked['hotel_id'];
                        $book->roomtype_id=$booked['roomtype_id'];
                        $book->promotion_id=$booked['promotion_id'];     
                        $book->no_of_adults=$booked['adult'];
                        $book->no_of_room=$booked['no_of_room'];
                        $checkin = ExtraHelper::date_2_save($booked['checkin']);
                        $checkout = ExtraHelper::date_2_save($booked['checkout']);
                        $book->checkin = $checkin['date'];
                        $book->checkout = $checkout['date'];
                        $book->booked_nights = ExtraHelper::date_diff($book->checkin, $book->checkout);
                        $book->rate = $booked['rate'];
                        $book->rate_vnd=$booked['rate']*$changeRate_VND['sell'];


                    }
                    
                    /*if(!$booking->hasErrors()){
                        if(count($book)==0){
                            $book=new Bookings;
                        }
                    }*/
                    $total = $booked['rate']*$booked['nights']*$booked['no_of_room'];
                    $no_of_extrabed = 0;
                    for($e=1;$e<=$booked['no_of_room'];$e++){
                        if(isset($booked['extrabed'.$e])){
                            $no_of_extrabed++;
                            $total +=$booked['extrabed'.$e]*$booked['nights']*$booked['exchangeRate'];                            
                            $book->extrabed_price=Settings::model()->getSetting('extrabed',$booked['hotel_id'])*$booked['nights']*$booked['exchangeRate'];
                            //$total +=$book->extrabed_price/$changeRate_VND['sell'];
                        }
                    }                   

                    $book->no_of_extrabed=$no_of_extrabed;
                    $pickup_setting = json_decode(Settings::model()->getSetting('airport_pickup',$booked['hotel_id']), true);
                    $drop_setting = json_decode(Settings::model()->getSetting('airport_dropoff',$booked['hotel_id']), true);
                    $promotion = Promotion::model()->findByPk($booked['promotion_id']);
                    if($booked['pickup'] || $promotion->pickup || 
                        (isset($booking['pickup']) && isset($pickup_setting[$booking['pickup']]))){
                        
                        $booked['pickup_flight'] = $book->pickup_flight=$booking['pickup_flight'];
                        
                        //$p_datetime = explode(' - ', $booking['pickup_date']);
                        $pickup_date = ExtraHelper::date_2_save($booking['pickup_date']);
                        $booked['pickup_date'] = $book->pickup_date=$pickup_date['date'];
                        $booked['pickup_time'] = $book->pickup_time=$booking['pickup_time'];
                        //var_dump($book->pickup_price);die;
                        if(!$promotion->pickup){
                            $book->pickup_vehicle = $booking['pickup'];
                            //$total += $book->pickup_price/$changeRate_VND['sell'];
                            $total += $pickup_setting[$booking['pickup']]*$usd_to_VND['sell'];
                            $book->pickup_price=$pickup_setting[$booking['pickup']]*$usd_to_VND['sell'];
                        }else{
                            $booking->pickup=1;
                            $book->pickup_vehicle = '4_seats';
                            $book->pickup_price=0;
                        }
                    }

                    if($promotion->dropoff || (isset($booking['dropoff']) && isset($drop_setting[$booking['dropoff']]))){
                        
                        $book->dropoff_flight=$booking['drop_flight'];
                        //$d_datetime = explode(' - ', $booking['drop_date']);
                        $dropoff_date = ExtraHelper::date_2_save($booking['drop_date']);
                        $book->dropoff_date=$dropoff_date['date'];
                        $book->dropoff_time=$booking['drop_time'];
                        
                        if(!$promotion->dropoff){
                            $book->dropoff_vehicle = $booking['dropoff'];
                            $book->dropoff_price=$drop_setting[$booking['dropoff']]*$usd_to_VND['sell'];
                            $total += $book->dropoff_price/$changeRate_VND['sell'];
                        }else{
                            $booking->dropoff=1;
                            $book->dropoff_price= 0;
                            $book->dropoff_vehicle = '4_seats';
                            
                        }
                    }

                    $book->total_no_tax = $total;
                    $book->total_no_tax_vnd = $total *$changeRate_VND['sell'];
                    $book->total_no_tax_airport = $total;
                    $book->total_no_tax_vnd_airport = $total *$changeRate_VND['sell'];
                    
                    $book->total_vnd = $book->total*$changeRate_VND['sell'];
                    $tax = $service_charge = 0;
                    $vat_setting = Settings::model()->getSetting('include_vat', $booked['hotel_id']);
                    
                    if($vat_setting == 'false'){
                        $tax = $total*0.1;
                        $service_charge = ($total+$tax)*0.05;
                    }
                    
                    $book->tax=$tax;
                    $book->service_charge=$service_charge;
                    $book->total = ($total+$tax+$service_charge);
                    Yii::app()->session['_booked'] = $booked;
                    //echo"<pre>";print_r($book);die;
                    if($book->save()){
                        $this->redirect('payment');
                    }
                }
            }

            $this->render('option', compact(array('booked', 'booking')));
        }
    }

    public function actionPayment(){
        try{
            $token = Yii::app()->session['token'];
            $book = Bookings::model()->getBooking('failed', $token);

            if(Yii::app()->session['_booked'] && $book){
                $booked = Yii::app()->session['_booked'];
                $booking = new BookingForm;                
                $booking->scenario = 'payment';
                if(isset($_POST['BookingForm'])){
                    $booking->attributes = $_POST['BookingForm'];
                    $booking->validate();
                    if(!$booking->hasErrors()){
                        /*store to database*/
                        /*if(count($book)==0){
                            $book=new Bookings;
                        }*/
                        /*$book->token = $token;
                        $book->ip_address=$_SERVER['REMOTE_ADDR'];
                        $book->change_currency_rate=$booked['exchangeRate'];
                        $book->currency = $booked['currency'];
                        $total = $booked['rate']*$booked['nights']*$booked['no_of_room'];
                       
                        $changeRate_VND = (array)ExchangeRate::model()->convertCurrencyToUSD($book->currency);
                        $usd_to_VND = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
                        $book->total_no_tax = $total;
                        $book->total_no_tax_vnd = $total *$changeRate_VND['sell'];
                        
                        $book->total_no_tax_airport = $total;
                        $book->total_no_tax_vnd_airport = $total *$changeRate_VND['sell'];
                        $tax = $total*0.1;
                        $service_charge = ($total+$tax)*0.05;
                        $book->tax=$tax;
                        $book->service_charge=$service_charge;
                        $book->total = ($total+$tax+$service_charge);

                        
                        $book->total_vnd = $book->total*$changeRate_VND['sell'];*/
                        //$book->srcFile=$book->short_id . '_' . date('dMY') . '.pdf';
                        $book->status='failed';
                        $book->hotel_id = $booked['hotel_id'];
                        $book->roomtype_id=$booked['roomtype_id'];
                        $book->promotion_id=$booked['promotion_id'];     
                        $book->no_of_adults=$booked['adult'];
                        $book->no_of_room=$booked['no_of_room'];
                        $checkin=ExtraHelper::date_2_save($booked['checkin']);
                        $checkout=ExtraHelper::date_2_save($booked['checkout']);

                        $book->title = $booking['title'];
                        $book->first_name = $booking['first_name'];
                        $book->last_name = $booking['last_name'];
                        $book->short_id = ExtraHelper::generateRandomString(8);
                        $book->email = $booking['email'];
                        
                        $book->country = ExtraHelper::$country[$booking['country']];
                        $book->phone = $booking['phone'];
                        //$book->passport=$booking['passport'];
                        $book->notes = $booking['notes'];       

                        $book->checkin = $checkin['date'];
                        $book->checkout = $checkout['date'];
                        $book->booked_nights = ExtraHelper::date_diff($book->checkin, $book->checkout);
                        /*$book->rate = $booked['rate'];
                        $book->rate_vnd=$booked['rate']*$changeRate_VND['sell'];*/
                        $book->card_type = $booking['card_type'];
                        $book->card_name = $booking['card_name'];
                        $book->card_expired=$booking['card_expired_month'].'/'.$booking['card_expired_year'];
                        $book->card_cvv = $booking['card_cvv'];
                        $book->card_number = ExtraHelper::generateRandomString(12,2, true);
                        $book->code = base64_encode($booking['card_number']);

                        //$book->validate();

                        if($book->save()){    

                            if(isset($booked['packages'])){
                                $prs=explode(',', $book->promotion->packages);
                                foreach($booked['packages'] as $pKey => $pk){
                                    $b_p=new BookPackage;
                                    $b_p->booking_id = $book->getPrimaryKey();
                                    $b_p->package_id = $pKey;
                                    $b_p->adult = $pk['adult'];
                                    $b_p->child = $pk['child'];
                                    $b_p->exchange_rate=$usd_to_VND['sell'];
                                    if($prs && in_array($pKey, $prs)){
                                        $b_p->free=1;
                                    }else{
                                        $b_p->free=0;
                                    }
                                    $b_p->added_date = date('Y-m-d H:m:i');
                                    if($b_p->save()){
                                        
                                    }else{
                                        
                                    }
                                }
                            }
                            $book->status='confirmed';
                            if($book->update()){
                                $condition = array('fromDate'=>$booked['checkin'],'toDate'=>$booked['checkout'],'hotel_id'=>$booked['hotel_id'], 'no_of_room' => $booked['no_of_room']);
                                $updateRoom = Rooms::model()->checkRoom4($booked['roomtype_id'],$condition);
                                //echo"<pre>";print_r($updateRoom);die;
                                $date_alert = $date_alert2 = array();
                                foreach($updateRoom as $room){
                                    $room['used_total_allotments']=$room['used_total_allotments']+$booked['no_of_room'];
                                    $room['available'] = $room['available']-$booked['no_of_room'];
                                    if($room['auto_fill']>0 && $room['available']<=0){
                                        $room['available'] = $room['auto_fill'];
                                        $date_alert['date'][$room['date']] = $room['date'];
                                        $date_alert['alert'][$room['date']] = $room['auto_fill'];
                                    }
                                    $room->update();
                                    if($room['available'] <= 0){
                                        $date_alert2['date'][$room['date']] = $room['date'];
                                    }
                                }
                                if(count($date_alert)>0){

                                    $subject = '(Alert) Auto Fill Allotment';
                    
                                    $output = "";
                                    $template_file = "template/reminder_fillup.htm";
                                    $email_alert = Settings::model()->getSetting('email_alert', $booked['hotel_id']);
                                    $receiver_email = array($email_alert => $email_alert);
                                    $full_name = $book['hotel']['name'];
                                    $alert = array();
                                    $alert_string = '';
                                    foreach($date_alert['date'] as $key => $al){
                                        $alert_string .= '<p>Ngày '. ExtraHelper::date_2_show($date_alert['date'][$key]) . ' đã thêm '. $date_alert['alert'][$key] .' phòng cho loại phòng '.$room['roomtype']['name'].'</p>';
                                    }
                                    $alert['content'] = $alert_string;
                                    
                                    $result_alert = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $alert, $receiver_email, array('nghuytap@gmail.com' => 'Tap Nguyen'), $output, false);

                                }elseif(count($date_alert2)>0){
                                    $subject = '(Alert) Please fill up allotment';
                    
                                    $output = "";
                                    $template_file = "template/reminder_fillup_allotment.htm";
                                    $email_alert = Settings::model()->getSetting('email_alert', $booked['hotel_id']);
                                    $receiver_email = array($email_alert => $email_alert);
                                    $full_name = $book['hotel']['name'];
                                    $alert = array();
                                    $alert_string = '<p>Vui lòng thêm phòng trống cho ngày:</p>';

                                    foreach($date_alert['date'] as $key => $al){
                                        $alert_string .= '<p>'. ExtraHelper::date_2_show($date_alert['date'][$key]).' cho loại phòng '.$room['roomtype']['name'].'</p>';
                                    }
                                    $alert['content'] = $alert_string;
                                    
                                    $result_alert = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $alert, $receiver_email, array('nghuytap@gmail.com' => 'Tap Nguyen'), $output, false);
                                }
                                $lang  = Yii::app()->session['_lang'];
                                $this->redirect(Yii::app()->params['booking'].$lang.'/thankyou?short_id='.$book->short_id);        
                            }
                        }else{

                            
                            $hotel = Hotel::model()->find();
                            $message = new YiiMailMessage;
                            $message->view = "bk_fail_aristo";                        
                            $params = array('hotel' => $hotel['name']);
                            $message->subject = 'Booking Faild ' . strtoupper($book['short_id']);
                            $message->setBody($params, 'text/html');
                            $message->addTo($book['email']);                            
                            $message->addBcc('nghuytap@gmail.com');
                            $message->addReplyTo(Yii::app()->params['email_sent'], 'No Reply');
                            $message->addFrom(Yii::app()->params['email_sent'], 'Booking Faild - '. $book['first_name'].' '.$book['last_name']);
                            $message->cc = $hotel['email_sales'];
                            $result = Yii::app()->mail->send($message);
                        }
                    }
                }
                if(isset($booked['pickup'])){
                    $booking['pickup']=$booked['pickup'];
                }
                if(isset($booked['drop_off'])){
                    $booking['dropoff']=$booked['drop_off'];
                }

                $extra=0;
                $et=array();
                $room = Roomtype::model()->checkRoomtype($booked['roomtype_id']);
                for($e=1;$e<=$booked['no_of_room']*$room['no_of_extrabed'];$e++){
                    if(isset($booked['extrabed'.$e])){
                        $et[$e]=++$extra;
                    }
                }
                $booking['extrabed'] = $et;
                
                $this->render('payment', compact('booking','booked','room','book'));
            }else{
                $this->redirect(Yii::app()->createUrl('search'));
            }
        }catch(Exception $ex){
            $this->render('../site/error');
        }
    }

    public function actionThankyou(){
        if(isset($_GET['short_id'])){
            $criteria = new CDbCriteria;
            $criteria->compare('short_id', $_GET['short_id'], false);
            $criteria->compare('status', 'confirmed', false);
            $book = Bookings::model()->find($criteria);
            if($book){
                $this->render('thankyou', compact(array('book')));
                if($book->sent_mail == 0){
                    $hotel = Hotel::model()->findByPk($book['hotel_id']);  
                    $subject = 'Reservation Confirmation of #' . strtoupper($book['short_id']);
                    
                    $output = "";
                    //$content = ExtraHelper::mail_confirm($book, $hotel);
                    $template_file = "template/confirmation_letter.htm";
                    $full_name = 'Thank you for your booking - '. $book['first_name'].' '.$book['last_name'];

                    $result = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $book, array($book['email']=> $book['email']), array('nghuytap@gmail.com' => 'Sales'), $output);
                    
                    if($result){
                        $book->sent_mail = 1;
                        $book->update();                
                    }else{
                        echo 'Lỗi gửi email';
                        $book->sent_mail = 0;
                    }
                    $book->update();
                }
            }else{
                $this->render('../site/error');
            }
        }
    }

	public function getRoomRate(&$params) {
        $params['matchPromotions'] = array();
        $params['bookedNights'] = ExtraHelper::date_diff($params['fromDate'], $params['toDate']);
        /*get list roomtype*/
        $getRoomTypes = Roomtype::model()->getList(0, $params['hotel'], $params['adult'], $params['children']);
        $now = date('d-m-Y');
        $params['today'] = ExtraHelper::date_diff($params['fromDate'], $now);
        foreach ($getRoomTypes->getData() as $roomType) {
            //$params['order'][$roomType['id']] = $roomType['display_order'];
            $params['roomtype'][$roomType['id']] = $roomType['id'];
        }

        /*get list promotion*/
        $promotions = Promotion::model()->getList($params);
        if(count($promotions->getData())>0){
            $params['matchPromotions'] = $promotions->getData();
        }
        /*foreach ($promotions->getData() as $promotion) {
            if (((strtotime($promotion->from_date) <= strtotime($params['fromDate']) &&
                    strtotime($params['fromDate']) <= strtotime($promotion->to_date))
                     ||
                    (
                    strtotime($promotion->from_date) < strtotime($params['toDate']) &&
                    strtotime($params['toDate']) < strtotime($promotion->to_date)
                    )
                    )
            ) {
                if ($promotion['type'] === 'early_bird') {
                    //if ($params['today'] >= $promotion->no_of_day && $promotion['min_stay'] >= $params['bookedNights']){
                        $params['matchPromotions'][] = $promotion;
                    //}
                } elseif($promotion['type'] == 'last_minutes') {
                    //if ($params['today'] <= $promotion->no_of_day && $promotion['min_stay'] >= $params['bookedNights']){
                        $params['matchPromotions'][] = $promotion;
                    //}
                } elseif($promotion['type'] == 'deal' ){
                    $params['matchPromotions'][] = $promotion;
                }else{
                    $params['matchPromotions'][] = $promotion;
                }
            }
        }*/
        /*get list room available*/
        $params['rooms'] = Rooms::model()->getListByDate($params, $params['hotel']);
        //echo"<pre>";print_r($params['rooms']);die;
        $types = array();

        if ($params['matchPromotions']) {
            foreach ($params['matchPromotions'] as $promo) {
                self::getAvailRoomType($types, $params, $promo);
            }
        } else {
            self::getAvailRoomType($types, $params);
        }
        return $types;
    }

    public static function getAvailRoomType(&$types, $params, $promotion = null) {
        $hasPromotion = $promotion ? true : false;
        if ($hasPromotion) {
            $promotion_id = $promotion['id'];
        }
        $noAvailableRooms = array();
        $noPromo = array();
        $availableRooms = array();
        $allRooms = array();
        /*get rooms is available*/
        /*foreach ($params['rooms'] as $room) {
            $roomType = $room['roomtype_id'];
            $allRooms[$roomType] = $roomType;
            if (!$room->available || $room->available <= 0 || $room->close == 1) {
                $noAvailableRooms[$roomType] = $roomType;
            } elseif (!in_array($roomType, $noAvailableRooms) && 
                !in_array($roomType, $availableRooms)) {
                $availableRooms[$roomType] = $roomType;
            }
            if (in_array($roomType, $noAvailableRooms)) {
                unset($availableRooms[$roomType]);
            }
        }*/

        /* check roomtype has exist in promotion? */
        $rtype_pr = explode(',', $promotion['roomtypes']);
        $rtype_pr2=array();
        foreach ($rtype_pr as $key => $value) {
            $rtype_pr2[$value] = $value;
        }
        $promotion_roomtypes = array_intersect($rtype_pr2, $params['roomtype']);
        //var_dump($promotion_roomtypes);
        foreach ($params['rooms'] as $key => $value) {
            //$getRoomType = Roomtype::model()->checkRoomtype($value['roomtype_id']);
            $photos = Gallery::model()->getList(1, $params['hotel'], $value['roomtype_id']);
            $photo = '';
            if($photos){
                $pt = $photos->getData();
                $photo = $pt[0]['name'];
            }
            if ($value['roomtype']['max_per_room'] >= $params['adult']) {
                $order = $value['roomtype']['display_order'];
                /* get rates */                
                $rate = Rates::model()->getListByRoomtype2($value['roomtype_id'], $params);
                //$room = Rooms::model()->checkRoom2($value['roomtype_id'], $params);

                $rateCount = 1;
                $tempCount = 0;
                $singlePrice = $doublePrice = $tripplePrice = 0;
                $breakfast = 0;
                foreach ($rate as $r => $v) {
                    if($v->breakfast)
                        $breakfast = 1;
                    $singlePrice += $rate[$r]['single'];
                    $doublePrice += $rate[$r]['double'];
                    $tripplePrice += $rate[$r]['tripple'];
                    $tempCount = ($r + 1);

                    $types[$order]['dailyRates'][$v->id]['date'] = ExtraHelper::date_2_show($v->date);
                    $types[$order]['dailyRates'][$v->id][1] = round($v->single * $params['exchangeRates'], 2);
                    $types[$order]['dailyRates'][$v->id][2] = round($v->double * $params['exchangeRates'], 2);
                    $types[$order]['dailyRates'][$v->id][3] = round($v->tripple * $params['exchangeRates'], 2);

                    /* promotion breakfast */
                    if (in_array($value['roomtype_id'], $promotion_roomtypes)) {
                        $types[$order]['promos']['promos_' . $promotion_id]['breakfast'] = $v->breakfast;
                    }
                }
                if ($tempCount !== 0){
                    $rateCount = $tempCount;
                } 
                /* tinh gia trung binh cong */                
                $singleRates = $singlePrice / $rateCount;
                $doubleRates = $doublePrice / $rateCount;
                $trippleRates = $tripplePrice / $rateCount;
                /* ghi vao mang */
                $types[$order]['breakfast'] = $breakfast;
                $types[$order]['currency'] = $params['currency'];
                $types[$order]['roomType'] = $value['roomtype_id'];
                $types[$order]['roomName'] = $value['roomtype']['name'];
                $types[$order]['roomTypeId'] = $value['roomtype']['id'];
                $types[$order]['fromDate'] = $params['fromDate'];
                $types[$order]['toDate'] = $params['toDate'];
                //var_dump($types[$order]['roomTypeId']);die;

                $types[$order]['max'] = $value['roomtype']['no_of_adult'];
                $types[$order]['children'] = $value['roomtype']['no_of_child'];
                $types[$order]['extraBed'] = $value['roomtype']['no_of_extrabed'];
                $extrabed_price = Settings::model()->getSetting('extrabed', $getRoomType['hotel_id']);
                $types[$order]['extrabed_price'] = round($extrabed_price*$params['exchangeRates'],2);


                $types[$order][1] = round($singleRates * $params['exchangeRates'], 2);
                $types[$order][2] = round($doubleRates * $params['exchangeRates'], 2);
                $types[$order][3] = round($trippleRates * $params['exchangeRates'], 2);

                $types[$order]['prices'] = $trippleRates;
                /*if($params['adult']>=1 && $params['adult'] <= 3 && 
                    $params['children'] == 0 && 
                    $value['roomtype']['no_of_adult']>=$params['adult']){
                    //gia single hoac double hoac tripple
                    $types[$order]['prices'] = $types[$order][$params['adult']];
                }elseif($params['adult'] == 1 && $params['children'] == 1){
                    //gia double
                    $types[$order]['prices'] = $types[$order][2];
                }elseif($params['adult'] == 3 || 
                    ($params['adult'] == 2 && $params['children']==1) || 
                    ($params['adult'] == 1 && $params['children'] == 2) && 
                    $value['roomtype']['max_per_room'] >= 3){
                    //gia tripple
                    $types[$order]['prices'] = round($trippleRates * $params['exchangeRates'], 2);
                }elseif($value['roomtype']['max_per_room'] >2 && 
                    $params['adult'] == 3 && $params['children']  ==0 && 
                    $value['roomtype']['no_of_adult'] == 2 && 
                    $value['roomtype']['no_of_extrabed'] >=1){
                    $types[$order]['prices'] = round($trippleRates* $params['exchangeRates'], 2);
                }*/
                $types[$order]['roomTypeId'] = $value['roomtype']['id'];
                $types[$order]['view'] = $value['roomtype']['view'];
                //if (!in_array($key, $noAvailableRooms)) {
                    $types[$order]['available'] = $value['available'];
                /*} else {
                    $types[$order]['available'] = 0;
                }*/
                $language = Yii::app()->session['_lang'];
                $description = json_decode($value['roomtype']['description'], true);
                $types[$order]['close'] = $value['close'];
                $types[$order]['description'] = $description[$language];
                $types[$order]['maxPerRoom'] = $value['roomtype']['max_per_room'];
                $types[$order]['amenities'] = $value['roomtype']['amenities'];
                $types[$order]['roomSize'] = $value['roomtype']['size_of_room'];
                $types[$order]['bed'] = $value['roomtype']['bed'];
                $types[$order]['photos'] = $photo;
                $types[$order]['roomSizeUnit'] = 'sqm';
                $types[$order]['bookedNights'] = $params['bookedNights'];
                

                /* promotion */
                if ($hasPromotion) {        
                    $promotion_name = json_decode($promotion['name'], true);   
                    $lang = Yii::app()->session['_lang'];
                    $types[$order]['promos']['promos_' . $promotion_id]['bookedNights'] = $params['bookedNights'];
                    $types[$order]['promos']['promos_' . $promotion_id]['today'] = $params['today'];
                    $types[$order]['promos']['promos_' . $promotion_id]['cancel1'] = $promotion['cancel_1'];
                    $types[$order]['promos']['promos_' . $promotion_id]['cancel2'] = $promotion['cancel_2'];
                    $types[$order]['promos']['promos_' . $promotion_id]['cancel3'] = $promotion['cancel_3'];
                    $types[$order]['promos']['promos_' . $promotion_id]['promotion_id'] = $promotion_id;
                    $types[$order]['promos']['promos_' . $promotion_id]['promotion_name'] = $promotion_name[$lang];
                    $types[$order]['promos']['promos_' . $promotion_id]['promotion_type'] = $promotion['type'];
                    $types[$order]['promos']['promos_' . $promotion_id]['short_content'] = $promotion['short_content'];
                    $types[$order]['promos']['promos_' . $promotion_id]['roomtype_id'] = $value['roomtype_id'];
                    $types[$order]['promos']['promos_' . $promotion_id]['available'] = $room['available'];
                    $types[$order]['promos']['promos_' . $promotion_id]['max'] = $value['roomtype']['no_of_adult'];
                    $types[$order]['promos']['promos_' . $promotion_id]['children'] = $value['roomtype']['no_of_child'];
                    $types[$order]['promos']['promos_' . $promotion_id]['extraBed'] = $value['roomtype']['no_of_extrabed'];
                    $types[$order]['promos']['promos_' . $promotion_id]['no_of_day'] = $promotion['no_of_day'];
                    $types[$order]['promos']['promos_' . $promotion_id]['min_stay'] = $promotion['min_stay'];
                    $types[$order]['promos']['promos_' . $promotion_id]['max_stay'] = $promotion['max_stay'];
                    $types[$order]['promos']['promos_' . $promotion_id]['apply_on'] = $promotion['apply_on'];
                    $types[$order]['promos']['promos_' . $promotion_id]['specific_night'] = $promotion['specific_night'];
                    $types[$order]['promos']['promos_' . $promotion_id]['specific_day_of_week'] = $promotion['specific_day_of_week'];
                    $types[$order]['promos']['promos_' . $promotion_id]['every_night'] = $promotion['every_night'];
                    $types[$order]['promos']['promos_' . $promotion_id]['discount'] = $promotion['discount'];
                    $types[$order]['promos']['promos_' . $promotion_id]['increase'] = $promotion['increase']*$params['exchangeRates'];
                    if($promotion['type'] == 'deal'){
                        $types[$order]['promos']['promos_' . $promotion_id]['end_deal_date'] = $promotion['end_deal_date'];
                    }
                    if ($value['close']) {
                        $noPromo[$value['roomtype_id']] = $value['roomtype_id'];
                        /*if ($promotion->promotion_type == 'others') {
                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($types[$order]['single'], 2);
                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($types[$order]['double'], 2);
                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($types[$order]['tripple'], 2);
                        }*/
                    } else if (!$value['close'] && !in_array($value['roomtype_id'], $noPromo)) {
                        /* discount per night by percentage */
                        $discountsingle = $types[$order][1]* (100 - $promotion->discount) / 100;
                        $discountdouble = $types[$order][2] * (100 - $promotion->discount) / 100;
                        $discounttripple = $types[$order][3] * (100 - $promotion->discount) / 100;

                        $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2);
                        $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2);
                        $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2);
                        $types[$order]['promos']['promos_' . $promotion_id]['prices'] = $types[$order]['prices']* (100 - $promotion->discount) / 100;
                    }
                }
            }
            ksort($types);
        }
    }

    public function actionGetservices(){
        $booked = Yii::app()->session['_booked'];

        $this->layout=false;
        if(isset($_POST['data'])){
            
            $pickup_setting = json_decode(Settings::model()->getSetting('airport_pickup',$booked['hotel_id']), true);
            $drop_setting = json_decode(Settings::model()->getSetting('airport_dropoff',$booked['hotel_id']), true);
            if($_POST['data']['pickup'] !== '' && isset($pickup_setting[$_POST['data']['pickup']])){
                $booked['pickup_price'] = $pickup_setting[$_POST['data']['pickup']]*$booked['exchangeRate'];
                $booked['pickup'] = $_POST['data']['pickup'];
            }elseif(isset($_POST['data']['pickup']) && $_POST['data']['pickup'] == null){
                unset($booked['pickup']);
                unset($booked['pickup_price']);
            }
            if($_POST['data']['drop_off'] !== '' && isset($drop_setting[$_POST['data']['drop_off']])){
                $booked['drop_off_price'] = $drop_setting[$_POST['data']['drop_off']]*$booked['exchangeRate'];
                $booked['drop_off'] = $_POST['data']['drop_off'];
            }elseif(isset($_POST['data']['drop_off']) && $_POST['data']['drop_off'] == null){
                unset($booked['drop_off']);
                unset($booked['drop_off_price']);
            }
            $room=Roomtype::model()->findByPk($booked['roomtype_id']);
            for($e=1;$e<=$booked['no_of_room']*$room['no_of_extrabed'];$e++){
                if($_POST['data']['extrabed']=='extrabed'.$e && 
                    $_POST['data']['extra_value'] == 1){
                    $booked['extrabed'.$e] = Settings::model()->getSetting('extrabed',$booked['hotel_id'])*$booked['exchangeRate'];
                }elseif(isset($booked['extrabed'.$e]) && $_POST['data']['extra_value'] == 0 && $_POST['data']['extrabed']=='extrabed'.$e){
                    unset($booked['extrabed'.$e]);
                }
            }
            Yii::app()->session['_booked'] = $booked;
            
            $this->render('cart', compact('booked'));
        }
        if(isset($_POST['pk_id']) && isset($_POST['type'])){
            $package = Package::model()->findByPk($_POST['pk_id']);
            $pr = Promotion::model()->findByPk($booked['promotion_id']);
            $p_pk = explode(',', $pr->packages);
            if($_POST['type'] == 'true'){
                $price_adult=$price_child=0;
                if(!in_array($_POST['pk_id'], $p_pk)){
                    $price_adult = $_POST['pk_adult']*$package['rate']*$booked['exchangeRate'];
                    $price_child = $_POST['pk_child']*$package['rate_child']*$booked['exchangeRate'];
                }
                $booked['packages'][$_POST['pk_id']] = array(
                    'price_adult' => $price_adult,
                    'price_child' => $price_child,
                    'adult' => $_POST['pk_adult'],
                    'child' => $_POST['pk_child']
                );
            }else{
                unset($booked['packages'][$_POST['pk_id']]);
            }
            Yii::app()->session['_booked'] = $booked;
            $this->render('cart', compact('booked'));
        }
    }
    

    public function actionChecktype($status='failed'){
        if(isset($_POST['hotel']) && isset(Yii::app()->session['_owner'])){
            $requestDate = date('Y-m-d H:m:i');
            $exchangeRates = 0;
            $booking = Booking::model()->getBooking();

            if ($status=='confirmed') {
                $booking->delete();
                return;
            }
            $room = Yii::app()->session['roomtype'];
            $matchRoom = array();
            $i = 0;
            $arrDate = array();
            $total = 0;
            $vat = $service_charge = 0;
            $currency = 'VND';
            $checkout = new MongoDate();
            $date_to_airport = array();
            $air_point = 0;
            foreach ($room as $r) {
                $date_to_airport[$air_point] = (int) $r['bookedNights'];
                $air_point++;
                $checkout = $r['toDate'];
                $id = $r['fromDate']->sec . $r['toDate']->sec;
                $arrDate[$id] = $this->mongoDateDiff($r['fromDate'], $r['toDate']);
                $matchRoom[$id][$i]['promotion_id'] = $r['promotion_id'];
                $matchRoom[$id][$i]['promotion_name'] = $r['promotion_name'];
                $matchRoom[$id][$i]['promotion_type'] = $r['promotion_type'];
                $matchRoom[$id][$i]['roomType'] = $r['roomtype'];
                $matchRoom[$id][$i]['roomTypeName'] = $r['room_name'];
                $matchRoom[$id][$i]['promotion_id'] = $r['promotion_id'];
                $matchRoom[$id][$i]['extrabed'] = (int) $r['extrabedAdult'];
                $matchRoom[$id][$i]['bookNights'] = (int) $r['bookedNights'];
                $matchRoom[$id][$i]['amount_OR_percentage'] = (float) $r['amount_OR_percentage'];
                $matchRoom[$id][$i]['benefits'] = $r['benefits'];
                $matchRoom[$id][$i]['police'] = $r['police'];
                $matchRoom[$id][$i]['adult'] = $r['adult'];
                $matchRoom[$id][$i]['children'] = $r['children'];
                $matchRoom[$id][$i]['price'] = (float) $r['price'];
                $matchRoom[$id][$i]['currency'] = $r['currency'];
                $matchRoom[$id][$i]['fromDate'] = $r['fromDate'];
                $matchRoom[$id][$i]['toDate'] = $r['toDate'];
                $matchRoom[$id][$i]['rate'] = (float) $r['rate'];
                $matchRoom[$id][$i]['childAge'] = isset($r['childAge']) ? $r['childAge'] : '';
                $total += $r['rate'];
                $currency = $r['currency'];
                $i++;
            }
            $currencyArr = ExtraHelper::convert_currency();
            $change_currency = $currencyArr['rates'][$currency]['sell'];
            $default_currency = $currencyArr['rates']['USD']['sell'];
            $exchangeRates = $default_currency / $change_currency;
            if($booking){
                $booking->short_id = substr($booking->_id, 0, 8);
                $booking->contact['gender'] = $_POST['gender'];
                $booking->contact['email'] = $_POST['email'];
                $booking->contact['firstname'] = $_POST['firstname'];
                $booking->contact['lastname'] = $_POST['lastname'];
                $booking->contact['Country'] = $_POST['country'];
                $booking->contact['phone'] = $_POST['phone'];
                $booking->contact['address'] = $_POST['address'];
                $booking->payment['payment_detail'] = $_POST['cardtype'];
                $booking->code = base64_encode($_POST['card_number']);
                $booking->payment['name_on_card'] = $_POST['card_name'];    
                $booking->payment['cardmonth'] = $_POST['cardmonth'];
                $booking->payment['cardyear'] = $_POST['cardyear'];
                $booking->payment['cvv'] = $_POST['cvv'];
                $booking->specialRequest = $_POST['specialRequest'];
                $booking->ip = $_SERVER['REMOTE_ADDR'];
                if ($booking->update()) {
                    echo json_encode(1);
                }else{
                    echo json_encode(0);
                }
            }else{
                $model = new Booking;
                $model->checkout = $checkout;
                
                $booking->contact['gender'] = $_POST['gender'];
                $booking->contact['email'] = $_POST['email'];
                $booking->contact['firstname'] = $_POST['firstname'];
                $booking->contact['lastname'] = $_POST['lastname'];
                $booking->contact['Country'] = $_POST['country'];
                $booking->contact['phone'] = $_POST['phone'];
                $booking->contact['address'] = $_POST['address'];
                $booking->payment['payment_detail'] = $_POST['cardtype'];
                $booking->code = base64_encode($_POST['card_number']);
                $booking->payment['name_on_card'] = $_POST['card_name'];    
                $booking->payment['cardmonth'] = $_POST['cardmonth'];
                $booking->payment['cardyear'] = $_POST['cardyear'];
                $booking->payment['cvv'] = $_POST['cvv'];
                $booking->specialRequest = $_POST['specialRequest'];
                $model->hotel = $_POST['hotel'];
                $model->ip = $_SERVER['REMOTE_ADDR'];
                $model->browser = $_SERVER['HTTP_USER_AGENT'];
                $model->requestDate = MyFunctionCustom::getDate(date('d-m-Y'));
                $model->created = MyFunctionCustom::getDate(date('d-m-Y H:m:i'));
                $model->date_time_now = date('d-m-Y H:m:i');
                $model->bookingStatus = 'failed';
                $model->defaultCurrency = 'VND';
                $model->version = 'desktop';
                $model->active = true;
                $model->owner_id = Yii::app()->session['_owner'];
                $model->exchangeRates = $exchangeRates;
                $model->changeCurrency = $change_currency;
                $model->currency = $currency;
                $model->matchRoom = $matchRoom;
                $model->failed_notification = 1;
                if ($model->save()) {
                    echo json_encode(1);
                }else{
                    echo json_encode(0);
                }
            }            
        }
    }

    public function actionGetroomtype(){
        if(isset($_POST['roomtype'])){
            $this->layout = false;
            $data = Roomtype::model()->findByPk($_POST['roomtype']);
            $this->render('_popup', compact('data'));
        }
    }
}