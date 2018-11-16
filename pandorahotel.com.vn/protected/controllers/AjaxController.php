<?php
class AjaxController extends Controller{
	public $layout = false;
	public function actionAddtobooking(){
		if(isset($_POST['no_of_adult']) && 
			$_POST['no_of_adult']>0 && 
			isset($_POST['no_of_children']) && isset($_POST['roomtype_id']) &&
			isset($_POST['promotion_id']) && isset($_POST['no_of_room']) &&
			isset($_POST['currency']) && isset($_POST['fromDate']) && isset($_POST['toDate'])){
			$token = ExtraHelper::generateRandomString(28);
			$lang = Yii::app()->session['_lang'];
			$adults = $_POST['no_of_adult'];
			$children = $_POST['no_of_children'];
			$rooms = $_POST['no_of_room'];
			$roomtype_id = $_POST['roomtype_id'];
			$promotion_id = $_POST['promotion_id'];
			$fromDate = $_POST['fromDate'];
            $toDate = $_POST['toDate'];
			$hotel = Yii::app()->session['hotel'];
			$params = array(
				'hotel' => $hotel,
				'fromDate' => $fromDate,
				'toDate' => $toDate,
				'type' => $roomtype_id,
				'no_of_room' => $rooms
			);

            /*if (isset(Yii::app()->session['_booked']) && count(Hotel::model()->findAll())>1) {
                $book = Yii::app()->session['_booked'];
                $_hotel = '';
                foreach ($book as $bk) {
                    $_hotel = $bk['hotel_id'];
                }
                if (isset(Yii::app()->session['hotel']) && Yii::app()->session['hotel'] !== $_hotel) {
                    unset(Yii::app()->session['_booked']);
                }
            }*/

            
            
            /*$config_condition = new EMongoCriteria;
            $config_condition->hotel = $hotel;
            $config = Config::model()->find($config_condition);
            $adult_extrabed = $config->extraBed_adults;*/

            $currency = $_POST['currency'];
            $change_currency = ExchangeRate::model()->convertCurrencyToUSD($currency);
            $default_currency = ExchangeRate::model()->convertCurrencyToUSD('USD');
            $exchangeRates = $default_currency['sell'] / $change_currency['sell'];
            
            $checkRoom = Rooms::model()->checkRoom3($roomtype_id, $params);
            if(!$checkRoom){
            	echo json_encode(0);
            	return;
            }
            $flag = false;

            $carts = array();
            $point = $roomtype_id.'_'.$promotion_id;
            foreach($checkRoom as $room){
                if($room['available']<=0){
                    $flag=true;
                    echo json_encode(0);
                    return;
                }
            }


            if(!$flag){
                $available = Yii::app()->session['_available'];
                $adult = ($adults >= 1 && $adults <=3) ? $adults : 3;
                $getRoomtype = Roomtype::model()->checkRoomtype($roomtype_id);
                if(isset($available[$getRoomtype['display_order']]['promos']['promos_'.$promotion_id][$adult])){
                    
                    $rate = $available[$getRoomtype['display_order']]['promos']['promos_'.$promotion_id][$adult];

                	$old_rooms = (int)$available[$getRoomtype['display_order']]['available'];
                    $checkRate = Rates::model()->getList2($roomtype_id, $params);
                    $cart['roomtype'] = $getRoomtype['name'];
                    $cart['roomtype_id'] = $getRoomtype['id'];
                    $cart['hotel_id'] = $getRoomtype['hotel_id'];
                    $cart['rate'] = $rate;
                    $cart['no_of_room'] = $rooms;
                    $cart['children'] = $children;
                    $cart['exchangeRate'] = $exchangeRates;                    
                    $cart['nights'] = ExtraHelper::date_diff($fromDate, $toDate);
                    $cart['promotion_id'] = $promotion_id;
                    $cart['promotion_name'] = $available[$getRoomtype['display_order']]['promos']['promos_'.$promotion_id]['promotion_name'];
                    $cart['currency'] = $currency;
                    $cart['checkin'] = $fromDate;
                    $cart['checkout'] = $toDate;
                    $cart['adult'] = $adults;
                    $carts[$point] = $cart;

                    if(Yii::app()->session['_booked']){
						$booked = Yii::app()->session['_booked'];
						if(!isset($booked[$point])){
							$booked=$carts+$booked;
							Yii::app()->session['_booked'] = $booked;	
						}else{
							$new_rooms = (int)$booked[$point]['no_of_room']+(int)$rooms;
                            $new_adults = (int)$booked[$point]['adult'] + (int)$adults;
                            $new_child = (int)$booked[$point]['children'] + (int)$children;
                            $rates = $booked[$point]['rate'] + $rate;
                            
							if($old_rooms > $new_rooms){
                                $booked[$point]['rate']  = $rates;
								$booked[$point]['no_of_room'] = $new_rooms;
                                $booked[$point]['adult'] = $new_adults;
                                $booked[$point]['children'] = $new_child;
							}else{
								echo json_encode(array('status' => -1, 'roomtype' => $booked));
								return;
							}
							Yii::app()->session['_booked'] = $booked;
						}				
					}else{
						Yii::app()->session['_booked'] = $carts;
					}   
					$carts = Yii::app()->session['_booked'];
                    echo json_encode(array('status' => 1, 'roomtype' => $carts));             
                }else{
                    echo json_encode(-1);
                    return;
                }
            }
		}
	}

    public function actionRemovebooking() {
        if (Yii::app()->session['_booked'] && isset($_POST['roomtype_id']) && isset($_POST['promotion_id'])) {
            
            $cart = Yii::app()->session['_booked'];
            /*$available = 0;
            foreach ($cart as $key => $value) {
                if ($value['id'] == $roomtype_id && $value['fromDate']->sec == $fromDate && $value['toDate']->sec == $toDate) {
                    $available = $value['available'];
                    $no_room = $booked[$value['roomtype'] . '_' . $value['available'] . '_' . $value['fromDate']->sec];
                    if ($no_room > 0){
                        $no_room = $no_room-(int)$value['no_room'];
                        $booked[$value['roomtype'] . '_' . $value['available'] . '_' . $value['fromDate']->sec] = $no_room;
                    }             
                    break;
                } else {
                    $CheckInDate[] = $value['fromDate']->sec;
                }
            }*/
            $point = $_POST['roomtype_id'] . '_'.$_POST['promotion_id'];
            if(isset($cart[$point])){
                unset($cart[$point]);   
            }

            Yii::app()->session['_booked'] = $cart;
            $cart = Yii::app()->session['_booked'];
            echo CJSON::encode($cart);
        }
    }

	public function actionGetservices(){
        if(isset($_POST['data'])){
        	$pickup = array();
        	$change_currency = Yii::app()->session['change_currency'];
            /*USD is default currency*/
            $defaultRate = (array)ExchangeRate::model()->convertCurrencyToUSD('USD');
            /*submit change currency*/
            $changeRate = (array)ExchangeRate::model()->convertCurrencyToUSD($change_currency);
            $exchangeRate = $defaultRate['sell'] / $changeRate['sell'];
            
            //$booked = Yii::app()->session['_booked'];
            $hotel = Yii::app()->session['hotel'];
            $pickup_setting = json_decode(Settings::model()->getSetting('airport_pickup',$hotel), true);
            $drop_setting = json_decode(Settings::model()->getSetting('airport_dropoff',$hotel), true);

            if($_POST['data']['pickup'] !== '' && isset($pickup_setting[$_POST['data']['pickup']])){
                $pickup['pickup_price'] = $pickup_setting[$_POST['data']['pickup']]*$exchangeRate;
                $pickup['pickup'] = $_POST['data']['pickup'];
            }elseif(isset($_POST['data']['pickup']) && $_POST['data']['pickup'] == null){
                unset($pickup['pickup']);
                unset($pickup['pickup_price']);
            }

            if($_POST['data']['drop_off'] !== '' && isset($drop_setting[$_POST['data']['drop_off']])){
                $pickup['drop_off_price'] = $drop_setting[$_POST['data']['drop_off']]*$exchangeRate;
                $pickup['drop_off'] = $_POST['data']['drop_off'];
            }elseif(isset($_POST['data']['drop_off']) && $_POST['data']['drop_off'] == null){
                unset($pickup['drop_off']);
                unset($pickup['drop_off_price']);
            }
            
            for($e=1;$e<=$pickup['no_of_room'];$e++){
                if($_POST['data']['extrabed']=='extrabed'.$e && $_POST['data']['extra_value'] == 1){
                    $pickup['extrabed'.$e] = Settings::model()->getSetting('extrabed',$hotel)*$exchangeRate;
                }elseif(isset($pickup['extrabed'.$e]) && $_POST['data']['extra_value'] == 0 && $_POST['data']['extrabed']=='extrabed'.$e){
                    unset($pickup['extrabed'.$e]);
                }
            }
            Yii::app()->session['_pickup'] = $pickup;
            $this->layout=false;
            $this->render('cart', compact('pickup'));
        }
    }

    public function actionLoadRoom(){
        if(isset($_GET['roomtype_id'])){
            $this->layout = false;
            $room = Roomtype::model()->findByPk($_GET['roomtype_id']);
            if($room){
                $photo = Gallery::model()->getList(1, '', $_GET['roomtype_id']);
                $this->render('room', compact('photo', 'room'));
            }else{
                $this->render('//site/404');
            }
        }
    }

     public function actionTerm(){        
        $this->render('term');
    }

    public function actionChangeattributes(){
        if(isset($_POST['adult']) && 
            isset($_POST['roomtype'])){
            $adult = $_POST['adult'];
            $roomtype_id = $_POST['roomtype'];
            $available = Yii::app()->session['_available'];
            $roomtype = Roomtype::model()->checkRoomtype($roomtype_id);
            $rate = array();
            //echo"<pre>";print_r($available[$roomtype['display_order']]);
            if(isset($available[$roomtype['display_order']]['promos'])){
                $old_rate = number_format($available[$roomtype['display_order']][$adult], 2);
                foreach($available[$roomtype['display_order']]['promos'] as $promos){
                    $rate[] = number_format($promos[$adult],2);
                }
                echo json_encode(array('promos' => $rate, 'old' => $old_rate));
            }elseif(isset($available['rooms'][$roomtype['display_order']])){
                $old_rate = number_format($available['rooms'][$roomtype['display_order']][$adult], 2);
                foreach($available['rooms'] as $promos){
                    $rate[] = number_format($promos[$adult],2);
                }
                echo json_encode(array('promos' => $rate, 'old' => $old_rate));
            }
            /*if(isset($available[$roomtype['display_order']]['promos']['promos_'.$promotion_id][$adult])){
                $rate = $available[$roomtype['display_order']]['promos']['promos_'.$promotion_id][$adult];
                $currency = Yii::app()->session['change_currency'];
                echo json_encode(number_format($rate,2));   
            }*/else{
                echo json_encode(0);
            }
        }
    }

    public function actionGetemail(){
        if(isset($_POST['email'])){
            $email = strtolower($_POST['email']);
            $data = Email::model()->findByPk($email);
            if($data){
                echo json_encode(0);
            }else{
                $model=new Email;
                $model->email=$email;
                $model->request_date = date('Y-m-d H:m:i');
                $model->type = 0;
                if($model->save()){
                    echo json_encode(1);
                }
            }
        }
    }

    public function actionCurrency() {
        if ($file = file_get_contents('http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx')) {
            $url = "http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json = curl_exec($ch);
            curl_close($ch);
            $exchange_rates = array();
            $exchange = array();
            if ($json !== '' && preg_match_all('/Exrate CurrencyCode="(.*)" CurrencyName="(.*)" Buy="(.*)" Transfer="(.*)" Sell="(.*)"/', $json, $matches) && count($matches) > 0 && preg_match_all("/<DateTime>(.*)<\/DateTime>/", $json)) {
                $exchange_rates['rates'] = array(
                    'USD' => array(), //1
                    'EUR' => array(), //2
                    'GBP' => array(), //3
                    'HKD' => array(), //4
                    'JPY' => array(), //5
                    'CHF' => array(), //6
                    'AUD' => array(), //7
                    'CAD' => array(), //8
                    'SGD' => array(), //9
                    'THB' => array(), //10
                    'DKK' => array(), //11
                    'INR' => array(), //12
                    'KRW' => array(), //13
                    'MYR' => array(), //14
                    'KWD' => array(), //15
                    'NOK' => array(), //16
                    'RUB' => array(), //17
                    'SAR' => array(), //18
                    'SEK' => array(), //19
                    'VND' => array()//20
                );
                foreach ($matches[1] as $key => $value) {
                    if (isset($exchange_rates['rates'][$value])) {
                        $exchange[$value] = array(
                            'id' => $value,
                            'name' => $matches[2][$key],
                            'buy' => $matches[3][$key],
                            'transfer' => $matches[4][$key],
                            'sell' => $matches[5][$key]
                        );
                    }
                }
                $exchange['VND'] = array(
                    'id' => 'VND',
                    'name' => 'VIET NAM DONG',
                    'buy' => 1, //$exchange_rates['rates']['USD']['buy'],
                    'transfer' => 1, // $exchange_rates['rates']['USD']['sell'],
                    'sell' => 1//$exchange_rates['rates']['USD']['sell']
                );
                //the_date, exchange_rate, original_xml

                $now = date('Y-m-d');
                $model = new ExchangeRate;
                $model->the_date = $now;
                $model->exchange_rate = json_encode($exchange);
                $model->original_xml = $file;
                
                if ($model->save()) {               
                    echo 'Get data successfully';
                    die;
                }
            }
            die;
        }
    }
}