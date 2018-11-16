<?php
class BookingController extends Controller{

    public $layout='mainbk';

	public function actionIndex(){
        //try{
            if(isset($_GET['hotel_id']) && $_GET['hotel_id'] && isset($_GET['chain_id']) && $_GET['chain_id']){
                $hotel_id = $_GET['hotel_id'];
                $chain_id = $_GET['chain_id'];
            }elseif(isset($_POST['hotel_id']) && $_POST['hotel_id'] && isset($_POST['chain_id']) && $_POST['chain_id']){
                $hotel_id = $_POST['hotel_id'];
                $chain_id = $_POST['chain_id'];
            }
            if(isset($hotel_id) && isset($chain_id)){
                $hotel = Hotel::model()->getHotelByHotelID($hotel_id, $chain_id);
                if($hotel){
                    Yii::app()->session['_hotel'] = $hotel;
                    /*Yii::app()->session['hotel_id'] = $hotel_id;
                    Yii::app()->session['chain_id'] = $chain_id;*/
                    unset(Yii::app()->session['_booked']);
                    $model = new FormBook;
                    if(isset($_POST['FormBook'])){
                        if(strtotime($_POST['FormBook']['checkin'])>=strtotime($now) && 
                            strtotime($_POST['FormBook']['checkout'])>strtotime($now) && 
                            strtotime($_POST['FormBook']['checkout'])>strtotime($params['fromDate']) && 
                            $_POST['FormBook']['adult']>0 && 
                            $_POST['FormBook']['children']>=0){
                                $list_curr = ExchangeRate::model()->getList2();
                                $currency='';
                                if(isset($_GET['currency']) && isset($_POST['currency']) && isset($list_curr[$_POST['currency']])){
                                    $currency = '&currency='.$_POST['currency'];
                                }
                                $fromDate = date('d-m-Y', strtotime($_POST['FormBook']['checkin']));
                                $toDate = date('d-m-Y', strtotime($_POST['FormBook']['checkout']));
                                header('Location: '. Yii::app()->params['link'].'booking/'.$hotel_id.'/'.$chain_id.'/?checkindate='.$fromDate.'&checkoutdate='.$toDate.'&adult='.$_POST['FormBook']['adult'].'&children='.$_POST['FormBook']['children'].$currency);
                            }
                    }
                    $now = date('d-m-Y');
                    
                    $params = array(
                        'fromDate' => $now,
                        'toDate' => date('d-m-Y', strtotime("$now +1day")),
                        'adult' => 2,
                        'children' => 0,
                        'hotel' => $hotel['id'],
                        'no_of_room' => 0
                    );
                    /*GET method*/
                    /*if(isset($_GET['rtype'])){
                        $params['rtype'] = $_GET['rtype'];
                    }
                    if(isset($_GET['promo'])){
                        $params['rtype_pr'] = $_GET['promo'];

                    }*/
                    /*post method*/
                    $flag=false;
                    /*if(isset($_POST['FormBook'])){
                        $model->attributes = $_POST['FormBook'];
                    }*/
                    if(isset($_POST['FormBook']['checkin']) && 
                        strtotime($_POST['FormBook']['checkin'])>=strtotime($now)){
                        $params['fromDate'] = date('d-m-Y', strtotime($_POST['FormBook']['checkin']));
                    }elseif(isset($_GET['checkindate']) && 
                        strtotime($_GET['checkindate'])>=strtotime($now)){
                        $params['fromDate'] = date('d-m-Y', strtotime($_GET['checkindate']));
                    }else{
                        $params['fromDate'] = date('d-m-Y', strtotime($now));
                    }
                    if(isset($_POST['FormBook']['checkout']) && 
                        strtotime($_POST['FormBook']['checkout'])>strtotime($now) && 
                        strtotime($_POST['FormBook']['checkout'])>strtotime($params['fromDate'])){
                        $params['toDate'] = date('d-m-Y', strtotime($_POST['FormBook']['checkout']));   
                    }elseif(isset($_GET['checkoutdate']) && 
                        strtotime($_GET['checkoutdate'])>strtotime($now) && 
                        strtotime($_GET['checkoutdate'])>strtotime($params['fromDate'])){
                        $params['toDate'] = date('d-m-Y', strtotime($_GET['checkoutdate']));   
                    }else{
                        $params['toDate'] = date('d-m-Y', strtotime($now ." +1day"));
                    }
                    if(isset($_POST['FormBook']['adult']) && $_POST['FormBook']['adult']>0){
                        $params['adult'] = $_POST['FormBook']['adult'];
                    }elseif(isset($_GET['adult']) && $_GET['adult']>0){
                        $params['adult'] = $_GET['adult'];
                    }
                    if(isset($_POST['FormBook']['children']) && $_POST['FormBook']['children']>=0){
                        $params['children'] = $_POST['FormBook']['children'];
                    }elseif(isset($_GET['children']) & $_GET['children']>=0){
                        $params['children'] = $_GET['children'];
                    }
                    $model['checkin'] = date('d M Y', strtotime($params['fromDate']));
                    $model['checkout'] = date('d M Y', strtotime($params['toDate']));
                    $model['adult'] = $params['adult'];
                    $model['children'] = $params['children'];
                    
                    
                    /*if(!Yii::app()->session['change_currency']){
                        Yii::app()->session['change_currency'] = 'VND';
                    }*/
                    
                    if(isset($_POST['currency']) && isset($list_curr[$_POST['currency']])){
                        Yii::app()->session['change_currency'] = $_POST['currency'];
                    }elseif(isset($_GET['currency']) && isset($list_curr[$_GET['currency']])){
                        Yii::app()->session['change_currency'] = $_GET['currency'];
                    }elseif(!Yii::app()->session['change_currency']){                    
                        Yii::app()->session['change_currency'] = 'VND';
                    }
                    $change_currency = Yii::app()->session['change_currency'];
                    /*USD is default currency*/

                    /*submit change currency*/
                    $changeRate = (array)ExchangeRate::model()->convertCurrencyToUSD($change_currency);
                    if(Settings::model()->getSetting('exchange_rate', $hotel['id'])){
                        $defaultRate = Settings::model()->getSetting('exchange_rate', $hotel['id']);
                    }else{
                        $defaultRate = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
                        $defaultRate = $defaultRate['sell'];
                    }
                    $exchangeRate = $defaultRate / $changeRate['sell'];
                    $params['exchangeRates'] = $exchangeRate;
                    $params['currency'] = $change_currency;
                    $params['bookedNights'] = ExtraHelper::date_diff($params['fromDate'], $params['toDate']);
                    $params['vat_setting'] = Settings::model()->getSetting('include_vat', $hotel['id']);
                    /*get room available*/
                    if($params['bookedNights']>0){
                        $available = BookingHelper::getRoomRate($params);
                        if(count($available)<=0){
                            $tracking=new SearchTracking;
                            $fromDate = date('Y-m-d', strtotime($params['fromDate']));
                            $toDate = date('Y-m-d', strtotime($params['toDate']));
                            $tracking->checkin = $fromDate;
                            $tracking->checkout=$toDate;
                            $tracking->ip_address=$_SERVER['REMOTE_ADDR'];
                            $tracking->hotel_id = $hotel['id'];
                            $tracking->request_date=date('Y-m-d H:m:i');
                            $checkTK = SearchTracking::model()->check($_SERVER['REMOTE_ADDR'], $fromDate, $toDate, $hotel['id']);
                            if(count($checkTK->getData())<=0){
                                $tracking->save();
                            }                            
                        }
                        Yii::app()->session['_params'] = $params;
                        
                        Yii::app()->session['_available']=$available;
                        //echo"<pre>";print_r($available);die;
                        /*book roomtype*/
                        if(isset($_GET['flag']) && $_GET['flag']==true || 
                            (isset($_POST['flag']) && $_POST['flag']==true)){
                            //$this->layout = false;
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
                    }else{
                        //$this->layout=false;
                        $this->render('index', array(
                            'available' => $available, 
                            'params' => $params,
                            'model' => $model,
                            'hotel'=>$hotel));
                        return;
                    }
                    //echo"<pre>";print_r($available);die;
                }else{
                    $this->render('../site/error');
                }
            }
        //}catch(Exception $ex){

            //$this->render('../site/error');

        //}

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
            //$params['currency'] = Yii::app()->session['change_currency'];
            $params['currency'] = 'VND';
            $changeRate = (array)ExchangeRate::model()->convertCurrencyToUSD($params['currency']);
            if(Settings::model()->getSetting('exchange_rate', $hotel['id'])){
                $defaultRate = Settings::model()->getSetting('exchange_rate', $hotel['id']);
            }else{
                $defaultRate = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
                $defaultRate = $defaultRate['sell'];
            }
            $exchangeRate = $defaultRate / $changeRate['sell'];
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
                //$available = Yii::app()->session['_available'];
                $available = BookingHelper::getRoomRate($params);
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
                    echo json_encode(1);
                }elseif($available){
                    $checkRate = Rates::model()->getList2($_POST['roomtype'], $params);
                    $cart['roomtype'] = $getRoomtype['name'];
                    $cart['roomtype_id'] = $getRoomtype['id'];
                    $cart['hotel_id'] = $getRoomtype['hotel_id'];
                    $cart['promotion_name'] = $available['promos']['promotion_name'];
                    $cart['rate'] = $available['rooms'][$getRoomtype['display_order']][$adult];
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
                    echo json_encode(1);
                }else{
                    echo json_encode(-1);
                }

            }else{
                echo json_encode(-2);
            }
        }else{
            echo json_encode(-3);
        }
    }
    public function actionOption(){
        $booked = Yii::app()->session['_booked'];
        if(Yii::app()->session['modify'] == true && Yii::app()->session['history']){
            $book = Yii::app()->session['history'];
            $token = $book['token'];
            /*$hotel_id = $bk['hotel']['hotel_id'];
            $chain_id = $bk['hotel']['chain_id'];
            $this->redirect(Yii::app()->createUrl('booking/modify/'.Yii::app()->session['token']));*/
        }else{
            $token = Yii::app()->session['token'];
            $book = Bookings::model()->getBooking('option', $token);
        }
        $currency_setting = Settings::model()->getSetting('currency',$booked['hotel_id']);
        if(!$book){
            $book=new Bookings;
            $book->status = 'option';
            $book->step = 'option';
            $book->token = $token;
            $book->ip_address=$_SERVER['REMOTE_ADDR'];
            $book->change_currency_rate=$booked['exchangeRate'];
            $book->currency = $booked['currency'];
            $total = $booked['rate']*$booked['nights']*$booked['no_of_room'];
            $book->request_date = date('Y-m-d H:m:i');
            $changeRate_VND = (array)ExchangeRate::model()->convertCurrencyToUSD($book->currency);
            $usd_to_VND = (array)ExchangeRate::model()->convertCurrencyToUSD(strtoupper($currency_setting));
            $book->total_no_tax = $total;
            $book->total_no_tax_vnd = $total *$changeRate_VND['sell'];
            $book->total_no_tax_airport = $total;
            $book->total_no_tax_vnd_airport = $total *$changeRate_VND['sell'];
            $tax = $service_charge = 0;
            $vat_setting = Settings::model()->getSetting('include_vat', $booked['hotel_id']);
            if($vat_setting == 'false'){
                $tax = $total*0.1;
                $service_charge = ($total+$tax)*0.05;
            }
            $book->tax=$tax;
            $book->service_charge=$service_charge;
            $book->total = ($total+$tax+$service_charge);
            $book->total_vnd = $book->total*$changeRate_VND['sell'];
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
            $book->save();
        }
        $pk_setting = Settings::model()->getSetting('airport_pickup', $booked['hotel_id']);
        $dr_setting = Settings::model()->getSetting('airport_dropoff', $booked['hotel_id']);
        
        $from = ExtraHelper::date_2_save($booked['checkin']);
        $to = ExtraHelper::date_2_save($booked['checkout']);
        $package = Package::model()->getList($from['date'], $to['date'], $booked['hotel_id']);
        if(!$pk_setting && !$dr_setting && ($package && count($package->getData())<=0)){
            $this->redirect(Yii::app()->createUrl('booking/payment'));
        }

        $pickups = json_decode($pk_setting, true);
        $dropoffs = json_decode($dr_setting, true);

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
            $usd_to_VND = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
            $changeRate_VND = (array)ExchangeRate::model()->convertCurrencyToUSD($book->currency);
            if(isset($_POST['BookingForm'])){
                $booking->attributes = $_POST['BookingForm'];
                $booking->validate();
                $airport = array();
                if(!$booking->hasErrors()){                        
                    $no_of_extrabed = 0;
                    for($e=1;$e<=$booked['no_of_room'];$e++){
                        if(isset($booked['extrabed'.$e])){
                            $no_of_extrabed++;
                            $total +=$booked['extrabed'.$e]*$booked['nights']*$booked['exchangeRate'];                            
                            $book->extrabed_price=Settings::model()->getSetting('extrabed',$booked['hotel_id'])*$booked['nights']*$booked['exchangeRate'];
                        }
                    }
                    $book->no_of_extrabed=$no_of_extrabed;
                    $pickup_setting = json_decode($pk_setting, true);
                    $drop_setting = json_decode($dr_setting, true);
                    $promotion = Promotion::model()->findByPk($booked['promotion_id']);
                    if($booked['pickup'] || $promotion->pickup || 
                        (isset($booking['pickup']) && 
                        isset($pickup_setting[$booking['pickup']]))){
                        $booked['pickup_flight'] = $book->pickup_flight=$booking['pickup_flight'];
                        $pickup_date = ExtraHelper::date_2_save($booking['pickup_date']);
                        $airport['pickup_date'] = $booked['pickup_date'] = $book->pickup_date=$pickup_date['date'];
                        $airport['pickup_time'] = $booked['pickup_time'] = $book->pickup_time=$booking['pickup_time'];
                        if((!$promotion->pickup || $booked['pickup_price']>0) && 
                            Settings::model()->getSetting('pickup_free')>$booked['nights']){
                            $airport['pickup_vehicle'] = $book->pickup_vehicle = $booking['pickup'];
                            $total += $pickup_setting[$booking['pickup']]*$usd_to_VND['sell'];
                            $airport['pickup_price'] = $book->pickup_price = $pickup_setting[$booking['pickup']]*$usd_to_VND['sell'];
                        }else{
                            $booking->pickup=1;
                            $airport['pickup_vehicle'] = $book->pickup_vehicle = '4_seats';
                            $airport['pickup_price'] = $book->pickup_price=0;
                        }
                    }
                    if($promotion->dropoff || (isset($booking['dropoff']) && 
                        isset($drop_setting[$booking['dropoff']]))){
                        $book->dropoff_flight=$booking['drop_flight'];
                        $dropoff_date = ExtraHelper::date_2_save($booking['drop_date']);
                        $airport['dropoff_date'] = $book->dropoff_date=$dropoff_date['date'];
                        $airport['dropoff_time'] = $book->dropoff_time=$booking['drop_time'];
                        if((!$promotion->dropoff || $booked['drop_off_price']>0) && 
                            Settings::model()->getSetting('dropoff_free')>$booked['nights']){
                            $airport['dropoff_vehicle'] = $book->dropoff_vehicle = $booking['dropoff'];
                            $airport['dropoff_price'] = $book->dropoff_price=$drop_setting[$booking['dropoff']]*$usd_to_VND['sell'];
                            $total += $book->dropoff_price/$changeRate_VND['sell'];
                        }else{
                            $booking->dropoff=1;
                            $airport['dropoff_price'] = $book->dropoff_price= 0;
                            $airport['dropoff_vehicle'] = $book->dropoff_vehicle = '4_seats';
                        }
                    }
                    if(Yii::app()->session['modify'] == true && Yii::app()->session['history']){
                        //$book = Yii::app()->session['history'];
                        //$token = $book['token'];
                        Yii::app()->session['airport']=$airport;
                        $hotel_id = $book['hotel']['hotel_id'];
                        $chain_id = $book['hotel']['chain_id'];
                        $this->redirect(Yii::app()->createUrl('booking/modify/'.$book['token']));
                    }else{
                        if($book->save()){
                            $this->redirect('payment');
                        }
                    }
                }
            }
            $this->render('option', compact(array('booked', 'booking', 'pickups', 'dropoffs', 'package')));
        }
    }
    public function actionPayment(){
        try{
            if(Yii::app()->session['_hotel']){
                $hotel = Yii::app()->session['_hotel'];
            }else{
                $hotel = Hotel::model()->getHotelByHotelID($_GET['hotel_id'], $_GET['chain_id']);
            }

            $token = Yii::app()->session['token'];
            if(Yii::app()->session['modify']){
                $modify = explode(',', Yii::app()->session['modify']);
                $book = Bookings::model()->getByEmail_ShortID($modify[0], $modify[1]);
            }else{
                $book = Bookings::model()->getBooking('option', $token);
                if(!$book){
                    $book = Bookings::model()->getBooking('failed', $token);
                    if(!$book){
                        $this->redirect(Yii::app()->baseUrl.'/booking/'.$hotel['hotel_id'].'/'.$hotel['chain_id']);
                    }
                }
            }
            if(count($book)==0){
                $book=new Bookings;
                //$book->status = 'payment';
                $book->token = $token;
            }
            $book->step = 'payment';
            if(Yii::app()->session['_booked'] && $book){
                $booked = Yii::app()->session['_booked'];
                $booking = new BookingForm;                
                $booking->scenario = 'payment';
                if(isset($_POST['BookingForm'])){
                    $booking->attributes = $_POST['BookingForm'];
                    $booking->validate();
                    if(!$booking->hasErrors()){                        
                        $book->token = $token;
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
                        $book->total_vnd = $book->total*$changeRate_VND['sell'];
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
                        $short_id = ExtraHelper::generateRandomString(10, 1, true);
                        $book->short_id = $short_id;
                        $book->email = $booking['email'];
                        //$book->request_date = date('Y-m-d H:i:m');
                        $book->country = ExtraHelper::$country[$booking['country']];
                        $book->phone = $booking['phone'];
                        //$book->passport=$booking['passport'];
                        $book->notes = $booking['notes'];       
                        $book->checkin = $checkin['date'];
                        $book->checkout = $checkout['date'];
                        $book->booked_nights = ExtraHelper::date_diff($book->checkin, $book->checkout);
                        $book->rate = $booked['rate'];
                        $book->rate_vnd=$booked['rate']*$changeRate_VND['sell'];
                        /*$book->card_name = $booking['card_name'];
                        $book->card_expired=$booking['card_expired_month'].'/'.$booking['card_expired_year'];
                        $book->card_cvv = $booking['card_cvv'];*/
                        $book->four = substr($booking['card_number'], -4);
                        //$book->card_number = ExtraHelper::generateRandomString(8,2, true);
                        //$book->code = base64_encode($booking['card_number']);
                        if(is_array(ExtraHelper::cardType($booking->card_type))){
                            $type = ExtraHelper::cardType($booking->card_type);
                            $book->card_number = BookingHelper::completed_number($type[0], $type[1]);
                        }

                        $book->code = ExtraHelper::zipCode($booking['card_type'].'&'.$booking['card_number'].'&'.$booking['card_name'].'&'.$booking['card_cvv'].'&'.$booking['card_expired_month'].'&'.$booking['card_expired_year']);

                        $book->card_cvv = ExtraHelper::generateRandomString(3, 1, true);
                        $book->card_name = $booking['card_name'];
                        $book->card_type = $booking['card_type'];
                        $book->card_expired = $booking['card_expired_month'].'/'.$booking['card_expired_year'];
                        
                        $book->validate();
                        //echo"<pre>";print_r($book);die;
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
                                BookingHelper::updateAvailable($booked, $book);
                                $lang  = Yii::app()->session['_lang'];
                                $this->redirect(Yii::app()->params['booking'].'booking/'.$book['hotel']['hotel_id'].'/thankyou?short_id='.$book->short_id);        
                            }

                        }else{
                        }
                    }

                }
                $this->render('payment', compact('booking','booked','room','book'));
            }else{
                $this->redirect(Yii::app()->baseUrl.'/booking/'.$hotel['hotel_id'].'/'.$hotel['chain_id']);
            }
        }catch(Exception $ex){
            $this->render('../site/error');
        }

    }
    public function actionThankyou(){
        $this->layout = false;
        if(isset($_GET['short_id'])){
            $criteria = new CDbCriteria;
            $criteria->compare('short_id', $_GET['short_id'], false);
            $criteria->addInCondition('status', array('confirmed', 'amended'));
            $book = Bookings::model()->find($criteria);
            if($book){
                $this->render('thankyou', compact(array('book')));
                //$book->sent_mail=0;
                if($book->sent_mail == 0){
                    $book->step = 'thankyou';
                    $hotel = Hotel::model()->findByPk($book['hotel_id']);  

                    $chain = Chain::model()->findByPk($hotel['chain_id']);
                    $email_sales = explode(';', $hotel['email_sales']);
                    $email_receive = array();
                    foreach($email_sales as $er){
                        $email_receive[$er] = $er;
                    }
                    $subject = 'Reservation Confirmation of #' . strtoupper($book['short_id']);                   
                    $output = "";
                    //$content = ExtraHelper::mail_confirm($book, $hotel);
                    $template_file = "template/confirmation_letter.htm";
                    $full_name = 'Thank you for your booking - '. $book['first_name'].' '.$book['last_name'];
                    $result = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $book, array($book['email']=> $book['email']), $email_receive, $output, true, $hotel['email_sales']);
                    //$result=1;
                    if($result){
                        $book->sent_mail = 1;
                        $book->update();
                        //sent email alert cvv
                        /*$now_checkin = date('d-m-Y');
                        $to_checkin = date('d-m-Y', strtotime($book->checkin));
                        $checkin_plug = date('d-m-Y', strtotime("$to_checkin - 9 days"));
                        //if(strtotime($checkin_plug) <= strtotime($now_checkin)){
                            $output = "";
                            $template_file = "template/reminder_cvv.htm";
                            $customer_email = $book['email'];
                            $receiver_email = array($customer_email => $customer_email);
                            $full_name = $chain['chain_name'];
                            $subject = $hotel['name']. ' – Credit Card Information Required for #'. strtoupper($book->short_id);
                            $data_alert = array(
                                'logo' => $hotel['logo1'],
                                'hotel' => $hotel['name'],
                                'hotelname' => $hotel['name'],
                                'chainname' => $full_name,
                                'fullname' => $book['title'] .'. '.$book['first_name'].' ' .$book['last_name'],
                                'cardnumber' => $book['four'],
                                'bookingid' => strtoupper($book['short_id']),
                                'checkin' => $to_checkin,
                                'email_reply' => $hotel['email_sales']
                            );
			    $background_email_setting = Settings::model()->getSetting('background_email', $book['hotel_id']);
                            $data_alert['background_email'] = '';
                            if($background_email_setting){
                                $data_alert['background_email'] = 'background:'.$background_email_setting;
                            }*/
                            //$arr_cc = array('nghuytap@gmail.com' => 'Tap Nguyen');
                            //$email_reply = 'huytaptit@gmail.com';
                            //$arr_cc = array($hotel['email_sales'] => 'Sales');
                            //$email_reply = $hotel['email_sales'];
                            
                            //$result_alert = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $data_alert, $receiver_email, $arr_cc, $output, false, $email_reply);
                            //$result_alert=1;
                            /*if($result_alert){
                                $book->sent_cvv = 1;
                                $book->update();
                            }*/
                       // }
                        //end cvv   
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

    public function actionChange($hotel_id, $chain_id){
        $this->render('change');
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
            if(Settings::model()->getSetting('exchange_rate', $_POST['hotel'])){
                $default_currency = Settings::model()->getSetting('exchange_rate', $_POST['hotel']);
            }else{
                $default_currency = $currencyArr['rates']['USD']['sell'];
            }            
            

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