<?php 
class BookingHelper{
    public static function completed_number($prefix, $length) {
        $ccnumber = $prefix;
        # generate digits
        while ( strlen($ccnumber) < ($length - 1) ) {
            $ccnumber .= rand(0,9);
        }
        # Calculate sum
        $sum = 0;
        $pos = 0;
        $reversedCCnumber = strrev( $ccnumber );
        while ( $pos < $length - 1 ) {
            $odd = $reversedCCnumber[ $pos ] * 2;
            if ( $odd > 9 ) {
                $odd -= 9;
            }
            $sum += $odd;
            if ( $pos != ($length - 2) ) {
                $sum += $reversedCCnumber[ $pos +1 ];
            }
            $pos += 2;
        }
        # Calculate check digit
        $checkdigit = (( floor($sum/10) + 1) * 10 - $sum) % 10;
        $ccnumber .= $checkdigit;
        return $ccnumber;
    }
    public static function updateAvailable($booked, $book){
        $condition = array('fromDate'=>$booked['checkin'],'toDate'=>$booked['checkout'],'hotel_id'=>$booked['hotel_id'], 'no_of_room' => $booked['no_of_room']);
        $updateRoom = Rooms::model()->checkRoom3($booked['roomtype_id'],$condition);
        $date_alert = $date_alert2 = array();
        foreach($updateRoom as $room){
            $room['used_total_allotments']=$room['used_total_allotments']+$booked['no_of_room'];
            $room['available'] = $room['available']-$booked['no_of_room'];
            if($room->update()){
                if($room['auto_fill']>0 && $room['available']<=0){
                    $room['available'] = $room['auto_fill'];
                    $date_alert['date'][$room['date']] = $room['date'];
                    $date_alert['alert'][$room['date']] = $room['auto_fill'];
                }
                if($room['available'] <= 0){
                    $date_alert2['date'][$room['date']] = $room['date'];
                }
            }
            
        }
            
        $email_alert = Settings::model()->getSetting('email_alert', $booked['hotel_id']);

        if(count($date_alert)>0){
            $subject = '(Alert) Auto Fill Allotment';
            $output = "";
            $template_file = "template/reminder_fillup.htm";
            
            $receiver_email = array($email_alert => $email_alert);
            $full_name = $book['hotel']['name'];
            $alert = array();
            $alert_string = '';
            foreach($date_alert['date'] as $key => $al){
                $alert_string .= '<p><strong>'.$book['hotel']['name'].'</strong></p>';
                $alert_string .= '<p>Hệ thống đã tự động fill up số phòng trống</p>';
                $alert_string .= '<p><strong>'. ExtraHelper::date_2_show($date_alert['date'][$key]) . '</strong>: +'. $date_alert['alert'][$key] .' alloment for roomtype '.$room['roomtype']['name'].'</p>';
            }
            $alert['content'] = $alert_string;
            $result_alert = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $alert, $receiver_email, array('admin@onlinesolutions.vn' => 'Online Solutions'), $output, false);
        }elseif(count($date_alert2)>0){
            $subject = '(Alert) Please fill up allotment';
            $output = "";
            $template_file = "template/reminder_fillup_allotment.htm";
            
            $receiver_email = array($email_alert => $email_alert);
            $full_name = $book['hotel']['name'];
            $alert = array();
            $alert_string = '';
            foreach($date_alert2['date'] as $key => $al){
                $alert_string .= '<p><strong>'.$book['hotel']['name'].'</strong></p>';
                $alert_string .= '<p>Vui lòng thêm số phòng trống cho các ngày:</p>';
                $alert_string .= '<p><strong>'. ExtraHelper::date_2_show($date_alert2['date'][$key]).'</strong> for roomtype '.$room['roomtype']['name'].'</p>';
            }
            $alert['content'] = $alert_string;
            $result_alert = Yii::app()->mailer->send_email($subject, $template_file, $full_name, $alert, $receiver_email, array('admin@onlinesolutions.vn' => 'Online Solutions'), $output, false);
        }
    }
    public static function getRoomRate(&$params) {
        if(isset($params['rtype'])){
            $rt_id = Roomtype::model()->getIdBySlug($params['rtype']);
            $params['roomtype'][$rt_id] = $rt_id;
        }else{
            /*get list roomtype*/
            $getRoomTypes = Roomtype::model()->getList(0, $params['hotel'], $params['adult'], $params['children']);
            foreach ($getRoomTypes->getData() as $roomType) {
                //$params['order'][$roomType['id']] = $roomType['display_order'];
                $params['roomtype'][$roomType['id']] = $roomType['id'];
                //$params['roomtype']['order'] = $roomType['display_order'];
                //$params['roomtype']['max'] = $roomType['max_per_room'];
            }
        }

        if($params['roomtype']){   
            $params['rooms'] = Rooms::model()->getListByDate($params, $params['hotel']);
            
            $params['matchPromotions'] = array();
            
            $now = date('d-m-Y');
            $params['today'] = ExtraHelper::date_diff($params['fromDate'], $now);
            

            /*get list promotion*/
            if(isset($params['rtype_pr'])){
                $promotions = Promotion::model()->getBySlug($params['hotel'], $params['rtype_pr']);
            }else{
                $promotions = Promotion::model()->getList($params);
            }

            $convert_day = array();
            $avai_promotions=array();
            $no_promotions=array();
            for($i=0;$i<$params['bookedNights'];$i++){
                $date=$params['fromDate'];
                $day = date('D', strtotime("$date +$i day"));
                $convert_day[$day] = $day;
                foreach ($promotions->getData() as $key => $value) {
                    $bo_on = explode(',', $value['book_on']);
                    if(!in_array($day,$bo_on)){
                        array_push($no_promotions, $value['id']);
                    }else{
                        $avai_promotions[$value['id']] = $value;
                    }
                }
            }
            $params[$promotion['id']]['black_out'] = array();
            foreach ($avai_promotions as $promotion) {
                if(!in_array($promotion['id'], $no_promotions)){
                    if($promotion['blackout_from'] !== '0000-00-00' && 
                        ExtraHelper::date_diff2($promotion['blackout_from'], date('d-m-Y'))){
                        $blackout_night= ExtraHelper::date_diff($promotion['blackout_from'], $promotion['blackout_to']);
                        for($i=0;$i<=$blackout_night;$i++){
                            $date_bl=$promotion['blackout_from'];
                            $day_bl = date('d-m-Y', strtotime("$date_bl +$i day"));
                            foreach ($promotions->getData() as $key => $value) {
                                $params[$promotion['id']]['black_out'][$day_bl] = $day_bl;
                            }
                        }
                    }

                    if(!isset($params[$promotion['id']]['black_out'][$params['fromDate']]) || 
                        !isset($params[$promotion['id']]['black_out'][$params['toDate']])){
                            //$params['matchPromotions'][] = $promotion;
                            if ($promotion['type'] == 'early_bird') {
                                if ($params['today'] >= $promotion->no_of_day && 
                                    $promotion['min_stay'] <= $params['bookedNights']){
                                    $params['matchPromotions'][] = $promotion;
                                }
                            } elseif($promotion['type'] == 'last_minutes') {
                                if ($params['today'] <= $promotion->no_of_day && $promotion['min_stay'] <= $params['bookedNights']){
                                    $params['matchPromotions'][] = $promotion;
                                }
                            }else{
                                $params['matchPromotions'][] = $promotion;
                            }
                    }
                }
            }
            
            //echo"<pre>";print_r($params['matchPromotions']);die;
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

        return $types = array();
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
        $rtype_pr = explode(',', $promotion['roomtypes']);
        /*get rooms is available*/
        foreach ($params['rooms'] as $room) {
            $roomType = $room['roomtype_id'];
            $allRooms[$roomType] = $roomType;
            if (!$room->available || $room->available <= 0 || $room->close == 1 || 
                 !in_array($roomType, $rtype_pr)) {
                $noAvailableRooms[$roomType] = $roomType;
            } elseif (!in_array($roomType, $noAvailableRooms) && 
                !in_array($roomType, $availableRooms) && in_array($roomType, $rtype_pr)) {
                $availableRooms[$roomType] = $roomType;
            }
            if (in_array($roomType, $noAvailableRooms)) {
                unset($availableRooms[$roomType]);
            }
        }

        /* check roomtype has exist in promotion? */
        $rtype_pr = explode(',', $promotion['roomtypes']);
        $rtype_pr2=array();
        foreach ($rtype_pr as $key => $value) {
            $rtype_pr2[$value] = $value;
        }
        //$promotion_roomtypes = array_intersect($rtype_pr2, $params['roomtype']);
        //echo"<pre>";print_r($promotion_roomtypes);
        /*phong trong*/
        if(isset($params['rtype_pr'])){
            /* promotion */
            if ($hasPromotion) {        
                $promotion_name = json_decode($promotion['name'], true);   
                $lang = Yii::app()->session['_lang'];
                $types['promos']['bookedNights'] = $params['bookedNights'];
                $types['promos']['today'] = $params['today'];
                $types['promos']['cancel1'] = $promotion['cancel_1'];
                $types['promos']['cancel2'] = $promotion['cancel_2'];
                $types['promos']['cancel3'] = $promotion['cancel_3'];
                $types['promos']['promotion_name'] = $promotion_name[$lang];
                $types['promos']['promotion_type'] = $promotion['type'];
                $types['promos']['promotion_id'] = $promotion['id'];
                $types['promos']['short_content'] = $promotion['short_content'];
                $types['promos']['discount'] = $promotion['discount'];
                $types['promos']['increase'] = $promotion['increase']*$params['exchangeRates'];
                $types['promos']['cover_photo'] = $promotion['cover_photo'];
                /*if($promotion['type'] == 'deal'){
                    $types['promos']['end_deal_date'] = $promotion['end_deal_date'];
                }*/
                
            }
            $flag_vat = Settings::model()->getSetting('include_vat', $params['hotel']);
            foreach ($params['rooms'] as $key => $value) {
                if(in_array($value['roomtype_id'], $rtype_pr)){
                    $order = $value['roomtype']['display_order'];
                    $singleRates=$singleRates=$singleRates=0;
                    $singlePrice = $doublePrice= $tripplePrice=0;
                    $rate = Rates::model()->getListByRoomtype2($value['roomtype_id'], $params);
                    $rateCount=1;
                    foreach ($rate as $r => $v) {
                        if($v->breakfast)
                            $breakfast = 1;
                        if($flag_vat == 'false'){
                            $singlePrice += $v->single;
                            $doublePrice += $v->double;
                            $tripplePrice += $v->tripple;
                        }else{
                            $singlePrice += $v->single_sell;
                            $doublePrice += $v->double_sell;
                            $tripplePrice += $v->tripple_sell;
                        }
                        $tempCount = ($r + 1);
                        $types['rooms'][$order]['roomtype_id'] = $value['roomtype_id'];
                        $types['rooms'][$order]['dailyRates'][$v->id]['date'] = ExtraHelper::date_2_show($v->date);
                        $types['rooms'][$order]['dailyRates'][$v->id][1] = round($v->single * $params['exchangeRates'], 2);
                        $types['rooms'][$order]['dailyRates'][$v->id][2] = round($v->double * $params['exchangeRates'], 2);
                        $types['rooms'][$order]['dailyRates'][$v->id][3] = round($v->tripple * $params['exchangeRates'], 2);
                    }
                    if ($tempCount !== 0){
                        $rateCount = $tempCount;
                    } 
                    /* tinh gia trung binh cong */                
                        $singleRates = $singlePrice*$params['exchangeRates'] / $rateCount;
                        $doubleRates = $doublePrice*$params['exchangeRates'] / $rateCount;
                        $trippleRates = $tripplePrice*$params['exchangeRates'] / $rateCount;

                    if ($value['close']=='1') {
                        $noPromo[$value['roomtype_id']] = $value['roomtype_id'];
                    } else if (!$value['close'] && !in_array($value['roomtype_id'], $noPromo)) {
                        /* discount per night by percentage */
                        $discountsingle = $singleRates* (100 - $promotion->discount) / 100;
                        $discountdouble = $doubleRates * (100 - $promotion->discount) / 100;
                        $discounttripple = $trippleRates * (100 - $promotion->discount) / 100;
                        $types['rooms'][$order][1] = round($discountsingle, 2);
                        $types['rooms'][$order][2] = round($discountdouble, 2);
                        $types['rooms'][$order][3] = round($discounttripple, 2);

                        $types['rooms'][$order]['price'][1] = round($singleRates, 2);
                        $types['rooms'][$order]['price'][2] = round($doubleRates, 2);
                        $types['rooms'][$order]['price'][3] = round($trippleRates, 2);
                    }
                    $types['rooms'][$order]['name'] = $value['roomtype']['name'];
                    $types['rooms'][$order]['available'] = $value['available'];
                    $types['rooms'][$order]['max'] = $value['roomtype']['no_of_adult'];
                    $types['rooms'][$order]['children'] = $value['roomtype']['no_of_child'];
                    $types['rooms'][$order]['extraBed'] = $value['roomtype']['no_of_extrabed'];
                    $types['rooms'][$order]['no_of_day'] = $promotion['no_of_day'];
                    $types['rooms'][$order]['min_stay'] = $promotion['min_stay'];
                    $types['rooms'][$order]['max_stay'] = $promotion['max_stay'];
                    //$getRoomType = Roomtype::model()->checkRoomtype($value['roomtype_id']);
                    $photos = Gallery::model()->getList(1, $params['hotel'], $value['roomtype_id']);
                    $photo = '';
                    if($photos){
                        $pt = $photos->getData();
                        $photo = $pt[0]['name'];
                    }
                    $types['rooms'][$order]['photos'] = $photo;
                    ksort($types);
                }
            }
        }else{
            foreach ($params['rooms'] as $key => $value) {
                if(in_array($value['roomtype_id'], $availableRooms)){
                    //$getRoomType = Roomtype::model()->checkRoomtype($value['roomtype_id']);
                    //hinh phong
                    $photos = Gallery::model()->getList(1, $params['hotel'], $value['roomtype_id']);
                    $photo = '';
                    if($photos){
                        $pt = $photos->getData();
                        $photo = $pt[0]['name'];
                    }
                    //$photo = $value['roomtype']['cover_photo'];
                    if ($value['roomtype']['max_per_room'] >= $params['adult']) {
                        $order = $value['roomtype']['display_order'];
                        /* get rates */                
                        $rate = Rates::model()->getListByRoomtype2($value['roomtype_id'], $params);
                        if(count($rate) == $params['bookedNights']){
                            $rateCount = 1;
                            $tempCount = 0;
                            $singlePrice = $doublePrice = $tripplePrice = 0;
                            $breakfast = 0;
                            foreach ($rate as $r => $v) {
                                if($v->breakfast){
                                    $breakfast = 1;
                                }
                                $singlePrice += $rate[$r]['single'];
                                $doublePrice += $rate[$r]['double'];
                                $tripplePrice += $rate[$r]['tripple'];
                                $tempCount = ($r + 1);

                                $types[$order]['dailyRates'][$v->id]['date'] = ExtraHelper::date_2_show($v->date);
                                $types[$order]['dailyRates'][$v->id][1] = round($v->single * $params['exchangeRates'], 2);
                                $types[$order]['dailyRates'][$v->id][2] = round($v->double * $params['exchangeRates'], 2);
                                $types[$order]['dailyRates'][$v->id][3] = round($v->tripple * $params['exchangeRates'], 2);

                                /* promotion breakfast */
                                //if (in_array($value['roomtype_id'], $promotion_roomtypes)) {
                                    $types[$order]['promos']['promos_' . $promotion_id]['breakfast'] = $v->breakfast;
                                //}
                            }
                            if ($tempCount !== 0){
                                $rateCount = $tempCount;
                            } 
                            /* tinh gia trung binh cong */                
                            $singleRates = ($singlePrice / $rateCount)*$params['exchangeRates'];
                            $doubleRates = ($doublePrice / $rateCount)*$params['exchangeRates'];
                            $trippleRates = ($tripplePrice / $rateCount)*$params['exchangeRates'];
                            if(Yii::app()->session['change_currency'] == 'VND'){
                                $singleRates = ExtraHelper::roundMoney2('VND', $singleRates);
                                $doubleRates = ExtraHelper::roundMoney2('VND', $doubleRates);
                                $trippleRates = ExtraHelper::roundMoney2('VND', $trippleRates);
                            }
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


                            $types[$order][1] = round($singleRates, 2);
                            $types[$order][2] = round($doubleRates, 2);
                            $types[$order][3] = round($trippleRates, 2);

                            $types[$order]['prices'] = $trippleRates;
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

                                //if($promotion['type'] == 'deal'){
                                if($promotion['end_deal_date'] !== '0000-00-00' && 
                                    strtotime($promotion['end_deal_date']) > strtotime(date('Y-m-d'))){
                                    //$types['promos']['end_deal_date'] = $promotion['end_deal_date'];
                                    $types[$order]['promos']['promos_' . $promotion_id]['end_deal_date'] = $promotion['end_deal_date'];
                                }

                                if ($value['close']) {
                                    $noPromo[$value['roomtype_id']] = $value['roomtype_id'];
                                //} else if (!$value['close'] && !isset($noPromo[$value['roomtype_id']])) {
                                } else if (!$value['close'] && !in_array($value['roomtype_id'], $noPromo)) {    
                                    $increase=0;
                                    if(is_numeric($promotion['increase']) && $promotion['increase']!==0 && 
                                        $promotion['package_type']=='per_night'){
                                        $increase = $promotion['increase']*$params['exchangeRates'];
                                    }elseif(is_numeric($promotion['increase']) && $promotion['increase']!==0 && 
                                        $promotion['package_type']=='per_booking'){
                                        $increase = $promotion['increase']*$params['exchangeRates']/$params['bookedNights'];
                                    }
                                    if($promotion['discount_type'] == 'percent_per_night'){
                                        if($promotion['apply_on'] == 'every_night'){
                                            $discount=0;         
                                            $discountsingle = $discountdouble = $discounttripple=0;                               
                                            for($i=0;$i<$params['bookedNights'];$i++){
                                                $date=$params['fromDate'];
                                                $date_pr = date('d-m-Y', strtotime("$date +$i day"));
                                                if(isset($params[$promotion_id]['black_out'][$date_pr])){
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][1] = $types[$order][1]+$increase;
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][2] = $types[$order][2]+($increase*2);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][3] = $types[$order][3]+($increase*3);
                                                    $discountsingle += $types[$order][1];
                                                    $discountdouble += $types[$order][2];
                                                    $discounttripple += $types[$order][3];
                                                }else{
                                                    $discountsingle += $types[$order][1]* (100 - $promotion->discount) / 100;
                                                    $discountdouble += $types[$order][2] * (100 - $promotion->discount) / 100;
                                                    $discounttripple += $types[$order][3] * (100 - $promotion->discount) / 100;
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][1] = round($types[$order][1] * (100 - $promotion['discount']) / 100, 2)+$increase;
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][2] = round($types[$order][2] * (100 - $promotion['discount']) / 100, 2)+($increase*2);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][3] = round($types[$order][3] * (100 - $promotion['discount']) / 100, 2)+($increase*3);
                                                }
                                            }
                                            
                                            $discountsingle = $discountsingle/$params['bookedNights'];
                                            $discountdouble = $discountdouble/$params['bookedNights'];
                                            $discounttripple = $discounttripple/$params['bookedNights'];
                                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                            $types[$order]['promos']['promos_' . $promotion_id]['prices'] = ($types[$order]['prices']* (100 - $promotion->discount) / 100) +($increase*2);;
                                        }elseif($promotion['apply_on'] == 'specific_day_of_week'){
                                            $pr_week = json_decode($promotion['specific_day_of_week'], true);
                                            $discount=0;
                                            $discountsingle = $discountdouble = $discounttripple=0;   
                                            for($i=0;$i<$params['bookedNights'];$i++){
                                                $date=$params['fromDate'];
                                                $day = date('D', strtotime("$date +$i day"));
                                                //day
                                                $date_pr = date('d-m-Y', strtotime("$date +$i day"));
                                                //date
                                                $p_date = date('d-m-Y', strtotime("$date +$i day"));
                                                if(isset($params[$promotion_id]['black_out'][$date_pr])){
                                                    $discountsingle += $types[$order][1];
                                                    $discountdouble += $types[$order][2];
                                                    $discounttripple += $types[$order][3];
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][1] = $types[$order][1]+$increase;
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][2] = $types[$order][2]+($increase*2);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][3] = $types[$order][3]+($increase*3);
                                                }else{
                                                    //$discount=$discount/$params['bookedNights'];
                                                    $discountsingle += $types[$order][1]* (100 - $pr_week[$day]) / 100;
                                                    $discountdouble += $types[$order][2] * (100 - $pr_week[$day]) / 100;
                                                    $discounttripple += $types[$order][3] * (100 - $pr_week[$day]) / 100;
                                                    $discount += $pr_week[$day];
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][1] = round($types[$order][1] * (100 - $pr_week[$day]) / 100, 2)+($increase);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][2] = round($types[$order][2] * (100 - $pr_week[$day]) / 100, 2)+($increase*2);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][3] = round($types[$order][3] * (100 - $pr_week[$day]) / 100, 2)+($increase*3);
                                                }
                                            }
                                            
                                            $discountsingle = $discountsingle/$params['bookedNights'];
                                            $discountdouble = $discountdouble/$params['bookedNights'];
                                            $discounttripple = $discounttripple/$params['bookedNights'];

                                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                            $types[$order]['promos']['promos_' . $promotion_id]['prices'] = $types[$order]['prices']- $promotion->discount+$increase;

                                        }
                                    }elseif($promotion['discount_type'] == 'amount_per_night'){
                                        if($promotion['apply_on'] == 'every_night'){
                                            $discount=0;
                                            $discountsingle = $discountdouble = $discounttripple=0;
                                            for($i=0;$i<$params['bookedNights'];$i++){
                                                $date=$params['fromDate'];
                                                $date_pr = date('d-m-Y', strtotime("$date +$i day"));
                                                if(isset($params['black_out'][$p_date])){
                                                    $discountsingle += $types[$order][1];
                                                    $discountdouble += $types[$order][2];
                                                    $discounttripple += $types[$order][3];
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][1] = $types[$order][1]+$increase;
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][2] = $types[$order][2]+($increase*2);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][3] = $types[$order][3]+($increase*3);
                                                }else{
                                                    $discountsingle += $types[$order][1]* (100 - $promotion->discount) / 100;
                                                    $discountdouble += $types[$order][2] * (100 - $promotion->discount) / 100;
                                                    $discounttripple += $types[$order][3] * (100 - $promotion->discount) / 100;
                                                    
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][1] = round($types[$order][1] -$promotion['discount'], 2)+$increase;
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][2] = round($types[$order][2] - $promotion['discount'], 2)+($increase*2);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][3] = round($types[$order][3] - $promotion['discount'], 2)+($increase*3);
                                                }
                                            }
                                            $discountsingle = $discountsingle/$params['bookedNights'];
                                            $discountdouble = $discountdouble/$params['bookedNights'];
                                            $discounttripple = $discounttripple/$params['bookedNights'];
                                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                            $types[$order]['promos']['promos_' . $promotion_id]['prices'] = $types[$order]['prices']- $promotion->discount+$increase;
                                        }elseif($promotion['apply_on'] == 'specific_day_of_week'){
                                            $discountsingle = $discountdouble = $discounttripple=0;
                                            $pr_week = json_decode($promotion['specific_day_of_week'], true);
                                            $discount=0;
                                            for($i=0;$i<$params['bookedNights'];$i++){
                                                $date=$params['fromDate'];
                                                $day = date('D', strtotime("$date +$i day"));
                                                //day
                                                $date_pr = date('d-m-Y', strtotime("$date +$i day"));
                                                //date
                                                $p_date = date('d-m-Y', strtotime("$date +$i day"));
                                                if(isset($params['black_out'][$p_date])){
                                                    $discountsingle += $types[$order][1];
                                                    $discountdouble += $types[$order][2];
                                                    $discounttripple += $types[$order][3];
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][1] = $types[$order][1]+$increase;
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][2] = $types[$order][2]+($increase*2);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][3] = $types[$order][3]+($increase*3);
                                                }else{
                                                    $discountsingle += $types[$order][1]* (100 - $promotion->discount) / 100;
                                                    $discountdouble += $types[$order][2] * (100 - $promotion->discount) / 100;
                                                    $discounttripple += $types[$order][3] * (100 - $promotion->discount) / 100;
                                                    
                                                    $discount += $pr_week[$day];
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][1] = round($types[$order][1] - $pr_week[$day], 2)+$increase;
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][2] = round($types[$order][2] - $pr_week[$day], 2)+($increase*2);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][3] = round($types[$order][3] - $pr_week[$day], 2)+($increase*3);
                                                }
                                            }
                                            $discountsingle = $discountsingle/$params['bookedNights'];
                                            $discountdouble = $discountdouble/$params['bookedNights'];
                                            $discounttripple = $discounttripple/$params['bookedNights'];
                                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                            $types[$order]['promos']['promos_' . $promotion_id]['prices'] = $types[$order]['prices']+($increase);
                                        }
                                    }else{
                                        $discountsingle = $types[$order][1];
                                        $discountdouble = $types[$order][2];
                                        $discounttripple = $types[$order][3];

                                        $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                        $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                        $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                        $types[$order]['promos']['promos_' . $promotion_id]['prices'] = $types[$order]['prices']+($increase);
                                    }
                                }
                            }
                        }
                    }
                    ksort($types);
                }
            }
        }
    }

    public static function country_zip() {
        return array(
            'PA7' => '93',
            'PA12' => '358',
            'PAL' => '355',
            'PDZ' => '213',
            'PAD' => '376',
            'PAO' => '244',
            'PA8' => '1264',
            'PAG' => '1268',
            'PAR' => '54',
            'PAM' => '374',
            'PA11' => '297',
            'PAU' => '61',
            'PAT' => '43',
            'PAZ' => '994',
            'PA2' => '1242',
            'PBH' => '973',
            'PBD' => '880',
            'PBB' => '1246',
            'PBY' => '375',
            'PBE' => '32',
            'PBZ' => '501',
            'PBJ' => '229',
            'PA13' => '1441',
            'PA14' => '975',
            'PBO' => '591',
            'PBA' => '387',
            'PBW' => '267',
            'PA27' => '47',
            'PBR' => '55',
            'PA32' => '246',
            'PA60' => '1284',
            'PBN' => '673',
            'PBG' => '359',
            'PBF' => '226',
            'PBI' => '257',
            'PKH' => '855',
            'PCM' => '237',
            'PCA' => '1',
            'PA17' => '238',
            'PA36' => '1345',
            'PCF' => '236',
            'PTD' => '235',
            'PCL' => '56',
            'PCN' => '86',
            'PA18' => '618',
            'PA15' => '61',
            'PCO' => '57',
            'PA35' => '269',
            'PCG' => '242',
            'PA16' => '682',
            'PCR' => '506',
            'PHR' => '385',
            'PCU' => '53',
            'PCY' => '357',
            'PCZ' => '420',
            'PCD' => '243',
            'PDK' => '45',
            'PDJ' => '253',
            'PDM' => '1767',
            'PDO' => '1',
            'PEC' => '593',
            'PEG' => '20',
            'PSV' => '503',
            'PGQ' => '240',
            'PER' => '291',
            'PEE' => '372',
            'PET' => '251',
            'PA20' => '500',
            'PA22' => '298',
            'PA1' => '679',
            'PFI' => '358',
            'PFR' => '33',
            'PGF' => '594',
            'PPF"' => '689',
            'PGA' => '241',
            'PGM' => '220',
            'PGE' => '995',
            'PDE' => '49',
            'PGH' => '233',
            'PGI' => '350',
            'PGR' => '30',
            'PA28' => '299',
            'PA23' => '1473',
            'PGP' => '590',
            'PA26' => '1671',
            'PGT' => '502',
            'PA24' => '44',
            'PGN' => '224',
            'PA29' => '245',
            'PGY' => '594',
            'PHT' => '509',
            'PA30' => '61',
            'PHN' => '504',
            'PA69' => '852',
            'PHU' => '36',
            'PIS' => '354',
            'PIN' => '91',
            'PID' => '62',
            'PIR' => '98',
            'PIQ' => '964',
            'PIE' => '353',
            'PA31' => '44',
            'PIL' => '972',
            'PIT' => '39',
            'PCI' => '225',
            'PJM' => '1876',
            'PJP' => '81',
            'PA33' => '44',
            'PJO' => '962',
            'PKZ' => '7',
            'PKE' => '254',
            'PA34' => '686',
            'PA71' => '381',
            'PKW' => '965',
            'PKG' => '996',
            'PLA' => '856',
            'PLV' => '371',
            'PLB' => '961',
            'PA40' => '266',
            'PA39' => '231',
            'PLY' => '218',
            'PA38' => '423',
            'PLT' => '370', 'PLU' => '352', 'PA70' => '853', 'PMK' => '389', 'PMG' => '261', 'PMW' => '265', 'PMY' => '60',
            'PA3' => '960', 'PML' => '223', 'PMT' => '356',
            'PA41' => '692', 'PMQ' => '596', 'PMR' => '222', 'PMU' => '230', 'PYT' => '262', 'PMX' => '52',
            'PA21' => '691', 'PMD' => '373', 'PMC' => '377', 'PMN' => '976', 'PA68' => '382', 'PA43' => '1664', 'PMA' => '212',
            'PMZ' => '258', 'PMM' => '95', 'PNA' => '264', 'PA44' => '674',
            'PNP' => '977', 'PNL' => '31', 'PA9' => '599', 'PNC' => '687', 'PNZ' => '64', 'PNI' => '505',
            'PNE' => '227', 'PNG' => '234',
            'PA45' => '683', 'PA6' => '672', 'PKP' => '850', 'PA42' => '1670', 'PNO' => '47', 'POM' => '968', 'PPK' => '926',
            'PA48' => '80', 'PA47' => '970', 'PPA' => '507', 'PPG' => '675', 'PPY' => '595', 'PPE' => '51',
            'PPH' => '63', 'PA46' => '672', 'PPL' => '48', 'PPT' => '351', 'PPR' => '1', 'PQA' => '974',
            'PRE' => '262', 'PRO' => '40', 'PRU' => '7', 'PRW' => '250', 'PSF' => '590', 'PA66' => '590', 'PKN' => '1869',
            'PA37' => '1758', 'PA65' => '590', 'PA10' => '684', 'PA64' => '685', 'PSM' => '378', 'PA52' => '239',
            'PSA' => '966', 'PSN' => '221', 'PA67' => '381', 'PA50' => '248', 'PSL' => '232', 'PSG' => '65', 'PSK' => '421', 'PSI' => '386',
            'PA49' => '677', 'PSO' => '252', 'PZA' => '27', 'PA25' => '54', 'PKR' => '82', 'PES' => '34', 'PLK' => '94', 'PPM' => '508',
            'PA59' => '1784', 'PSD' => '249', 'PSR' => '597', 'PA51' => '47', 'PA53' => '268', 'PSE' => '46', 'PCH' => '41', 'PSY' => '963',
            'PTW' => '886', 'PTJ' => '992', 'PTZ' => '255', 'PTH' => '66', 'PA55' => '670', 'PTG' => '228', 'PA54' => '690', 'PA56' => '676',
            'PTT' => '1868', 'PTN' => '216', 'PTR' => '90', 'PTM' => '993', 'PA4' => '1649', 'PA57' => '688', 'PUG' => '256',
            'PUA' => '380', 'PAE' => '971', 'PGB' => '44', 'PUS' => '1', 'PA58' => '1', 'PUY' => '598', 'PUZ' => '998', 'PA62' => '678',
            'PVA' => '379', 'PVE' => '58', 'PVN' => '84', 'PA61' => '1340', 'PA63' => '681', 'PA19' => '212', 'PYE' => '967', 'PZM' => '260',
            'PZW' => '263'
        );
    }

    public static function getRoomRate1(&$params) {        
        $params['matchPromotions'] = array();
        $params['bookedNights'] = ExtraHelper::date_diff($params['fromDate'], $params['toDate']);
        /*get list roomtype*/
        $getRoomTypes = Roomtype::model()->getList(0, Yii::app()->session['hotel']);
        $now = date('d-m-Y');
        $params['today'] = ExtraHelper::date_diff($params['fromDate'], $now);
        foreach ($getRoomTypes->getData() as $roomType) {
            $params['order'][$roomType['id']] = $roomType['display_order'];
        }

        /*get list promotion*/
        $promotions = Promotion::model()->getList($params);
        foreach ($promotions->getData() as $promotion) {
            if ($promotion['type'] === 'early_bird') {
                if ($params['today'] >= $promotion->no_of_day){
                    $params['matchPromotions'][] = $promotion;
                }
            } elseif($promotion['type'] == 'last_minute') {
                if ($params['today'] <= $promotion->no_of_day){
                    $params['matchPromotions'][] = $promotion;
                }
            } elseif($promotion['type'] == 'others') {
                $params['matchPromotions'][] = $promotion;
            }
        }
        /*get list room */
        $params['rooms'] = Rooms::model()->getListByDate($params);
        //echo "<pre>";print_r($params);
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

    public static function getAvailRoomType1(&$types, $params, $promotion = null) {
        $hasPromotion = $promotion ? true : false;
        if ($hasPromotion) {
            $promotion_id = $promotion['id'];
        }
        $noAvailableRooms = array();
        $noPromo = array();
        $availableRooms = array();
        $allRooms = array();
        /*get rooms is available*/
        foreach ($params['rooms'] as $room) {
            $roomType = $room['roomtype_id'];
            $allRooms[$roomType] = $roomType;
            if (!$room->available ||
                ($room->available <= $room->used_total_allotments) ||
                $room->close == 1) {
                $noAvailableRooms[$roomType] = $roomType;
            } elseif (!in_array($roomType, $noAvailableRooms) && 
                !in_array($roomType, $availableRooms)) {
                $availableRooms[$roomType] = $roomType;
            }
            if (in_array($roomType, $noAvailableRooms)) {
                unset($availableRooms[$roomType]);
            }
        }

        /* check roomtype has exist in promotion? */
        $promotion_roomtypes = explode(',', $promotion['roomtypes']);

        foreach ($allRooms as $key => $value) {
            $getRoomType = Roomtype::model()->checkRoomtype($key);
            if ($getRoomType && $getRoomType['max_per_room'] >= $params['adult']) {
                $order = $getRoomType['display_order'];
                /* get rates */                
                $rate = Rates::model()->getListByRoomtype2($key, $params);
                $room = Rooms::model()->checkRoom2($key, $params);

                $rateCount = 1;
                $tempCount = 0;
                $singlePrice = $doublePrice = 0;
                $breakfast = 0;
                foreach ($rate as $r => $v) {
                    if($v->breakfast)
                        $breakfast = 1;
                    $singlePrice += $rate[$r]['single'];
                    $doublePrice += $rate[$r]['double'];
                    $tripplePrice += $rate[$r]['tripple'];
                    $tempCount = ($r + 1);
                    /* promotion breakfast */
                    if (!in_array($key, $noAvailableRooms) && in_array($key, $promotion_roomtypes)) {
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
                $types[$order]['roomType'] = $key;
                $types[$order]['roomName'] = $getRoomType['name'];
                $types[$order]['roomTypeId'] = $getRoomType['id'];
                $types[$order]['fromDate'] = $params['fromDate'];
                $types[$order]['toDate'] = $params['toDate'];
                //var_dump($types[$order]['roomTypeId']);die;
                $types[$order][1] = round($singleRates * $params['exchangeRates'], 2);
                $types[$order][2] = round($doubleRates * $params['exchangeRates'], 2);
                $types[$order][3] = round($trippleRates * $params['exchangeRates'], 2);
                $types[$order]['roomTypeId'] = $getRoomType['id'];
                $types[$order]['view'] = $getRoomType['view'];
                if (!in_array($key, $noAvailableRooms)) {
                    $types[$order]['available'] = $room['available'] - $room['used_total_allotments'];
                } else {
                    $types[$order]['available'] = 0;
                }
                $language = Yii::app()->session['_lang'];
                $description = json_decode($getRoomType['description'], true);
                $types[$order]['close'] = $room['close'];
                $types[$order]['description'] = $description[$language];
                $types[$order]['maxPerRoom'] = $getRoomType['max_per_room'];
                $types[$order]['amenities'] = $getRoomType['amenities'];
                $types[$order]['roomSize'] = $getRoomType['size_of_room'];
                $types[$order]['photos'] = $getRoomType['photos'];
                $types[$order]['roomSizeUnit'] = 'sqm';
                $types[$order]['max'] = $getRoomType['no_of_adult'];
                $types[$order]['children'] = $getRoomType['no_of_child'];
                $types[$order]['extraBed'] = $getRoomType['no_of_extrabed'];
                $types[$order]['extrabed_price'] = round(Settings::model()->getSetting('extrabed', $getRoomType['hotel_id'])*$params['exchangeRates'],2);
                /* photo per room */
                $types[$order]['photos'] = $getRoomType['photos'];
                /* promotion */
                if ($hasPromotion &&
                        !in_array($key, $noAvailableRooms) &&
                        in_array($key, $promotion_roomtypes)) {                    
                    $types[$order]['promos']['promos_' . $promotion_id]['bookedNights'] = $params['bookedNights'];
                    $types[$order]['promos']['promos_' . $promotion_id]['today'] = $params['today'];
                    $types[$order]['promos']['promos_' . $promotion_id]['cancel1'] = $promotion['cancel_1'];
                    $types[$order]['promos']['promos_' . $promotion_id]['cancel2'] = $promotion['cancel_2'];
                    $types[$order]['promos']['promos_' . $promotion_id]['cancel3'] = $promotion['cancel_3'];
                    $types[$order]['promos']['promos_' . $promotion_id]['promotion_id'] = $promotion_id;
                    $types[$order]['promos']['promos_' . $promotion_id]['promotion_name'] = $promotion['name'];
                    $types[$order]['promos']['promos_' . $promotion_id]['promotion_type'] = $promotion['type'];
                    $types[$order]['promos']['promos_' . $promotion_id]['roomtype_id'] = $key;
                    $types[$order]['promos']['promos_' . $promotion_id]['available'] = $room['available'] - $room['used_total_allotments'];
                    $types[$order]['promos']['promos_' . $promotion_id]['max'] = $getRoomType['no_of_adult'];
                    $types[$order]['promos']['promos_' . $promotion_id]['extraBed'] = $getRoomType['no_of_extrabed'];
                    $types[$order]['promos']['promos_' . $promotion_id]['no_of_day'] = $promotion['no_of_day'];
                    $types[$order]['promos']['promos_' . $promotion_id]['min_stay'] = $promotion['min_stay'];
                    $types[$order]['promos']['promos_' . $promotion_id]['apply_on'] = $promotion['apply_on'];
                    $types[$order]['promos']['promos_' . $promotion_id]['specific_night'] = $promotion['specific_night'];
                    $types[$order]['promos']['promos_' . $promotion_id]['specific_day_of_week'] = $promotion['specific_day_of_week'];
                    $types[$order]['promos']['promos_' . $promotion_id]['every_night'] = $promotion['every_night'];
                    $types[$order]['promos']['promos_' . $promotion_id]['discount'] = $promotion['discount'];
                    if ($room['close']) {
                        $noPromo[$key] = $key;
                        /*if ($promotion->promotion_type == 'others') {
                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($types[$order]['single'], 2);
                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($types[$order]['double'], 2);
                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($types[$order]['tripple'], 2);
                        }*/
                    } else if (!$room['close'] && !in_array($key, $noPromo)) {
                        /* discount per night by percentage */
                        $discountsingle = $types[$order][1]* (100 - $promotion->discount) / 100;;
                        $discountdouble = $types[$order][2] * (100 - $promotion->discount) / 100;
                        $discounttripple = $types[$order][3] * (100 - $promotion->discount) / 100;
                        $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2);
                        $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2);
                        $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2);
                    }
                }
            }
            ksort($types);
        }
    }
}