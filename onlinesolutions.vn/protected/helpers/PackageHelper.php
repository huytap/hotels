<?php
class PackageHelper{
    public static function getRoomRate(&$params) {
        $params['rooms'] = Rooms::model()->getListByDate($params, $params['hotel']);
        $room_not_avai = $room_avai = array();
        foreach($params['rooms'] as $room){
            if($room['available']==0 || $room['close'] == 1){
                $room_not_avai[$room['roomtype_id']] = $room['roomtype_id'];
            }else{
                $room_avai[$room['roomtype_id']] = $room;
            }
        }
        if(count($room_not_avai)>0){
            foreach($room_not_avai as $not){
                if(isset($room_avai[$not])){
                    unset($room_avai[$not]);
                }
            }
        }

        if(count($room_avai)>0){
            $packages = Package::model()->getList($params['fromDate'], $params['toDate'], $params['bookedNights']);
            $pkage=array();

            //$params['bookedNights'] = ExtraHelper::date_diff($params['fromDate'], $params['toDate']);
            
            if(count($packages->getData())>0){
                foreach($packages->getData() as $package){
                    if(isset($room_avai[$package->roomtype_id])){
                        if ($package['type'] == 'early_bird') {
                            if ($params['today'] >= $package->night_to_book && 
                                $package['nights'] <= $params['bookedNights']){
                                $package['available'] = $room_avai[$package->roomtype_id]['available'];
                                $pkage[] = $package;

                            }
                        } elseif($package['type'] == 'last_minutes') {
                            if ($params['today'] <= $package->night_to_book && 
                                $package['nights'] <= $params['bookedNights']){
                                $package['available'] = $room_avai[$package->roomtype_id]['available'];
                                $pkage[] = $package;

                            }
                        }else{
                            $package['available'] = $room_avai[$package->roomtype_id]['available'];
                            $pkage[] = $package;

                        }
                    }
                }
                
                //$now = date('d-m-Y');
                //$params['today'] = ExtraHelper::date_diff($params['fromDate'], $now);
                
                return $pkage;
            }else{
                return array();
            }
        }else{
            return array();
        }
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
        //echo"<pre>";print_r($params['rooms']);
        $rtype_pr = explode(',', $promotion['roomtypes']);
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
            //$availableRooms[$roomType] = $roomType;
            if (in_array($roomType, $noAvailableRooms)) {
                unset($availableRooms[$roomType]);
            }
        }
        //echo"<pre>";print_r($availableRooms);die;
        /* check roomtype has exist in promotion? */
        
        $rtype_pr2=array();
        foreach ($rtype_pr as $key => $value) {
            $rtype_pr2[$value] = $value;
        }
            foreach ($params['rooms'] as $key => $value) {
                if(in_array($value['roomtype_id'], $availableRooms)){
                    //var_dump($value['roomtype_id']);
                    //if(in_array($value['roomtype_id'], $rtype_pr)){
                    $photos = Gallery::model()->getList(1, '', $value['roomtype_id']);
                    $photo = '';
                    if($photos){
                        $pt = $photos->getData();
                        $photo = $pt[0]['name'];
                    }
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
                                $date_rate=ExtraHelper::date_2_show($v->date);
                                $types[$order]['dailyRates'][$date_rate][1] = round($v->single * $params['exchangeRates'], 2);
                                $types[$order]['dailyRates'][$date_rate][2] = round($v->double * $params['exchangeRates'], 2);
                                $types[$order]['dailyRates'][$date_rate][3] = round($v->tripple * $params['exchangeRates'], 2);

                                /* promotion breakfast */
                                //if (in_array($value['roomtype_id'], $promotion_roomtypes)) {
                                    //$types[$order]['promos']['promos_' . $promotion_id]['breakfast'] = $v->breakfast;
                                //}
                            }
                            if ($tempCount !== 0){
                                $rateCount = $tempCount;
                            } 
                            $rateCount = count($rate)?count($rate):1;
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
                            $extrabed_price = Settings::model()->getSetting('extrabed');
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
                            $language = Yii::app()->language;
                            $description = json_decode($value['roomtype']['description'], true);
                            $types[$order]['close'] = $value['close'];
                            $types[$order]['description'] = $description[$language];
                            $types[$order]['maxPerRoom'] = $value['roomtype']['max_per_room'];
                            $types[$order]['amenities'] = $value['roomtype']['amenities'];
                            $types[$order]['roomSize'] = $value['roomtype']['size_of_room'];
                            $types[$order]['bed'] = $value['roomtype']['bed'];
                            $types[$order]['photos'] = $photo;
                            $types[$order]['roomSizeUnit'] = 'sqm';
                            $types[$order]['hotelslug'] = $value['hotel']['slug'];
                            $types[$order]['roomslug'] = $value['roomtype']['slug'];
                            $types[$order]['bookedNights'] = $params['bookedNights'];
                            

                            /* promotion */
                            if ($hasPromotion) {    
                                $promotion_name = json_decode($promotion['name'], true);  
                                $short_content = json_decode($promotion['short_content'], true); 
                                $lang = Yii::app()->language;
                                $types[$order]['promos']['promos_' . $promotion_id]['breakfast'] = $promotion['breakfast'];
                                $types[$order]['promos']['promos_' . $promotion_id]['bookedNights'] = $params['bookedNights'];
                                $types[$order]['promos']['promos_' . $promotion_id]['today'] = $params['today'];
                                $types[$order]['promos']['promos_' . $promotion_id]['cancel1'] = $promotion['cancel_1'];
                                $types[$order]['promos']['promos_' . $promotion_id]['cancel2'] = $promotion['cancel_2'];
                                $types[$order]['promos']['promos_' . $promotion_id]['cancel3'] = $promotion['cancel_3'];
                                $types[$order]['promos']['promos_' . $promotion_id]['promotion_id'] = $promotion_id;
                                $types[$order]['promos']['promos_' . $promotion_id]['promotion_name'] = $promotion_name[$lang];
                                $types[$order]['promos']['promos_' . $promotion_id]['promotion_type'] = $promotion['type'];
                                $types[$order]['promos']['promos_' . $promotion_id]['short_content'] = $short_content[$lang];
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
                                $types[$order]['promos']['promos_'.$promotion_id]['discount_type'] = $promotion['discount_type'];
                                if($promotion['end_deal_date'] !== '' && $promotion['end_deal_date'] !== '0000-00-00'){
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
                                    $increase=0;
                                    if(is_numeric($promotion['increase']) && $promotion['increase']!==0 && $promotion['package_type']=='per_night'){
                                        $increase = $promotion['increase']*$params['exchangeRates'];
                                    }elseif(is_numeric($promotion['increase']) && $promotion['increase']!==0 && $promotion['package_type']=='per_booking'){
                                        $increase = $promotion['increase']*$params['exchangeRates']/$params['nights'];
                                    }
                                    $member=0;
                                    $member_discount = '';
                                    if(strpos(Yii::app()->user->id, '@') && Yii::app()->user->getState('member')){
                                        $member_discount=Settings::model()->getSetting('member');
                                        $member_discount_type = Settings::model()->getSetting('member_discount_type');
                                        if($member_discount_type == 'percent_per_night'){
                                            $types[$order][1] = $types[$order][1] * (100 - $member_discount) / 100;
                                            $types[$order][2] = $types[$order][2] * (100 - $member_discount) / 100;
                                            $types[$order][3] = $types[$order][3] * (100 - $member_discount) / 100;
                                        }elseif($member_discount_type == 'amount_per_night'){
                                            $types[$order][1] = $types[$order][1] - $member_discount;
                                            $types[$order][2] = $types[$order][2] - $member_discount;
                                            $types[$order][3] = $types[$order][3] - $member_discount;
                                        }
                                    }

                                    if($promotion['discount_type'] == 'percent_per_night'){
                                        if($promotion['apply_on'] == 'every_night'){
                                            $discount=0;         
                                            $discountsingle = $discountdouble = $discounttripple=0;                               
                                            for($i=0;$i<$params['nights'];$i++){
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
                                            
                                            $discountsingle = $discountsingle/$params['nights'];
                                            $discountdouble = $discountdouble/$params['nights'];
                                            $discounttripple = $discounttripple/$params['nights'];
                                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                            $types[$order]['promos']['promos_' . $promotion_id]['prices'] = ($types[$order]['prices']* (100 - $promotion->discount) / 100) +($increase*2);;
                                        }elseif($promotion['apply_on'] == 'specific_day_of_week'){
                                            $pr_week = json_decode($promotion['specific_day_of_week'], true);
                                            $discount=0;
                                            $discountsingle = $discountdouble = $discounttripple=0;   
                                            for($i=0;$i<$params['nights'];$i++){
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
                                                    //$discount=$discount/$params['nights'];
                                                    $discountsingle += $types[$order][1]* (100 - $pr_week[$day]) / 100;
                                                    $discountdouble += $types[$order][2] * (100 - $pr_week[$day]) / 100;
                                                    $discounttripple += $types[$order][3] * (100 - $pr_week[$day]) / 100;
                                                    $discount += $pr_week[$day];
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][1] = round($types[$order][1] * (100 - $pr_week[$day]) / 100, 2)+($increase);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][2] = round($types[$order][2] * (100 - $pr_week[$day]) / 100, 2)+($increase*2);
                                                    $types[$order]['promos']['promos_' . $promotion_id]['dailyRates'][$date_pr][3] = round($types[$order][3] * (100 - $pr_week[$day]) / 100, 2)+($increase*3);
                                                }
                                            }
                                            
                                            /*$discountsingle = $types[$order][1]* (100 - $discount) / 100;
                                            $discountdouble = $types[$order][2] * (100 - $discount) / 100;
                                            $discounttripple = $types[$order][3] * (100 - $discount) / 100;*/
                                            $discountsingle = $discountsingle/$params['nights'];
                                            $discountdouble = $discountdouble/$params['nights'];
                                            $discounttripple = $discounttripple/$params['nights'];

                                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                            $types[$order]['promos']['promos_' . $promotion_id]['prices'] = $types[$order]['prices']- $promotion->discount+$increase;

                                        }
                                    }elseif($promotion['discount_type'] == 'amount_per_night'){
                                        if($promotion['apply_on'] == 'every_night'){
                                            $discount=0;
                                            $discountsingle = $discountdouble = $discounttripple=0;
                                            for($i=0;$i<$params['nights'];$i++){
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
                                            /*$discountsingle = $types[$order][1]- $promotion->discount;
                                            $discountdouble = $types[$order][2] - $promotion->discount;
                                            $discounttripple = $types[$order][3] -$promotion->discount;*/
                                            $discountsingle = $discountsingle/$params['nights'];
                                            $discountdouble = $discountdouble/$params['nights'];
                                            $discounttripple = $discounttripple/$params['nights'];
                                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                            $types[$order]['promos']['promos_' . $promotion_id]['prices'] = $types[$order]['prices']- $promotion->discount+$increase;
                                        }elseif($promotion['apply_on'] == 'specific_day_of_week'){
                                            $discountsingle = $discountdouble = $discounttripple=0;
                                            $pr_week = json_decode($promotion['specific_day_of_week'], true);
                                            $discount=0;
                                            for($i=0;$i<$params['nights'];$i++){
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
                                            /*$discount=$discount/$params['nights'];
                                            $discountsingle = $types[$order][1]- $discount;
                                            $discountdouble = $types[$order][2] - $discount;
                                            $discounttripple = $types[$order][3] - $discount;*/
                                            $discountsingle = $discountsingle/$params['nights'];
                                            $discountdouble = $discountdouble/$params['nights'];
                                            $discounttripple = $discounttripple/$params['nights'];
                                            $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                            $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                            $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                            $types[$order]['promos']['promos_' . $promotion_id]['prices'] = $types[$order]['prices']+($increase);
                                        }
                                    }else{//($promotion['discount_type'] == 'amount_per_booking'){
                                        $discountsingle = $types[$order][1];
                                        $discountdouble = $types[$order][2];
                                        $discounttripple = $types[$order][3];

                                        $types[$order]['promos']['promos_' . $promotion_id][1] = round($discountsingle, 2)+$increase;
                                        $types[$order]['promos']['promos_' . $promotion_id][2] = round($discountdouble, 2)+($increase*2);
                                        $types[$order]['promos']['promos_' . $promotion_id][3] = round($discounttripple, 2)+($increase*3);
                                        $types[$order]['promos']['promos_' . $promotion_id]['prices'] = $types[$order]['prices']+($increase);
                                    }
                                    //Cộng tiền children
                                    $types[$order]['promos']['promos_' . $promotion_id][1] = $types[$order]['promos']['promos_' . $promotion_id][1]+$params['child_price'];
                                    $types[$order]['promos']['promos_' . $promotion_id][2] = $types[$order]['promos']['promos_' . $promotion_id][2]+$params['child_price'];
                                    $types[$order]['promos']['promos_' . $promotion_id][3] = $types[$order]['promos']['promos_' . $promotion_id][3]+$params['child_price'];
                                }
                            }
                        }
                    }
                    ksort($types);
                }
            }
        //}
    }
}