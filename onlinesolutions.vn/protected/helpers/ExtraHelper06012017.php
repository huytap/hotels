<?php

class ExtraHelper{
    public static function cardType($type){
        $arr = array(
            'visa' => 4, //13 or 16
            'mastercard' => 51, //16
            'amex' => 34, //15
            'jcb' => 35 //15
        );
        $length = array(
            'visa' => 16,
            'mastercard' => 16,
            'amex' => 15,
            'jcb' => 15
        );
        if(isset($arr[$type]))
            return array($arr[$type], $length[$type]);
        else
            return '';
    }

    public static function checkDevice(){
        return preg_match("/(android|webos|avantgo|iphone|ipad|ipod|blackbe‌​rry|iemobile|bolt|bo‌​ost|cricket|docomo|f‌​one|hiptop|mini|oper‌​a mini|kitkat|mobi|palm|phone|pie|tablet|up\.browser|up\.link|‌​webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
    public static function roundMoney($currency, $money){
        $exchangeRate = ExchangeRate::model()->exchangeRate2('USD', 'VND');
        $money = $money*$exchangeRate;
        $default = Settings::model()->getSetting('currency', 1);
        $exchangeRate = ExchangeRate::model()->exchangeRate2($default, $currency);
        if($currency == 'VND'){
            return number_format(round($money, -3),0);
        }else{
            return number_format($money,2);
        }
    }

    public static function roundMoney2($currency, $money){
        if($currency == 'VND'){
            return round($money,-3);
        }else{
            return $money;
        }
    }

    public static function roundMoney3($currency, $money){
        if($currency == 'VND'){
            return number_format(round($money,-3),0);
        }else{
            return number_format($money,2);
        }
    }

    public static function getEmail($emailString){
        $email = explode(';', $emailString);
        $string='';
        foreach($email as $e){
            $string .= $e;
            if($i<count($email)-1){
                $string .= '<br>';
            }
        }
        return $string;
    }

    public static function makeLink($theString=''){
        return strtolower(preg_replace(array('/[.\s+]/', '/[,\']/', '/&(amp;)?#?[a-z0-9]+;/i','/[&?*%\/]/'), array('-', ''), StringHelper::safeField($theString)));
    }

    public static function makeLinkBook($params){
        $params['checkin'] = date('d-m-Y',strtotime($params['checkin']));
        $params['checkout'] = date('d-m-Y', strtotime($params['checkout']));
        $url = '?checkindate='.$params['checkin'].'&checkoutdate='.$params['checkout'].'&adult='.$params['adult'].'&children='.$params['children'];
        if($params['currency']){
            $url .= '&currency=USD';            
        }
        if($params['roomtype']){
            $url .= '&rtype='.$params['roomtype'];
        }
        if($params['promo']){
            $url .= '&promo='.$params['promo'];
        }
        return Yii::app()->params['booking'].$params['lang'].'/search'.$url;
    }

    public function mailsend($to, $from, $from_name, $subject, $message)
    {
        $mail   = Yii::app()->Smtpmail;
        $mail->IsSMTP();
        $mail->SMTPAuth   = TRUE; 
        $mail->SetFrom($from,'No Reply');
        $mail->Subject  = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to, "");

        // Add CC
        // if(!empty($cc)){
        //  foreach($cc as $email){
        //      $mail->AddCC($email);
        //  }
        // }

        // // Add Attchments
        // if(!empty($attachment)){
        //  foreach($attachment as $attach){
        //  $mail->AddAttachment($attach);
        //  }
        // }

        if(!$mail->Send()) {
            //Yii::app()->user->setFlash('contact',$mail->ErrorInfo);
            $mail->ClearAddresses();
            return 0;
        }else {
            $mail->ClearAddresses();
            return 1;
        }
        
    }

    public function mail_confirm($booked, $hotel){
        $lang = 'en';
        $address = json_decode($hotel['address'], true);
        $city = json_decode($hotel['city'], true);
        $country = json_decode($hotel['country'], true);
        $special_offers = json_decode($hotel['special_offer'], true);
        $short_id = strtoupper($booked['short_id']);
        $first_name = ucfirst($booked['first_name']);
        $last_name = ucfirst($booked['last_name']);
        $promotion = json_decode($booked['promotion']['name'], true);

        $promtion_name = $promotion[$lang];

        $checkin = date('d M Y', strtotime($booked['checkin'])) ;
        $checkout = date('d M Y', strtotime($booked['checkout'])) ;

        $rate_vnd = number_format($booked['rate_vnd'], 2) ;
        $html = "<table style=\"font-size:12px;font-family:arial,sans-serif;width: 98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >
                <tr style=\"height:19.95pt;background: #0b1317;color: #fff\">
                    <td valign=top style=\"padding: 0 10px;height:19.95pt;font-size:12px\">
                        <a style=\"text-decoration:none;color:#fff;\" href=\"{Yii::app()->params['link']}\">
                        <img src=\"http://aristosaigonhotel.com/themes/aristosaigonhotel/images/logo_email.jpg\" alt=\"{$hotel['name']}\"></a>
                    </td>
                    <td style=\"line-height: 20px;padding:10px;height:19.95pt;font-size:12px;color:#fff;\" valign=\"top\">
                        <span style=\"font-family:arial,sans-serif;font-size:12px\">".Yii::t('lang', 'address_3').": ".$address[$lang].", ".$city[$lang].", ".$country[$lang]."</span>
                        <br>
                        Website: <u><span style=\"color:blue\">
                        <a target=\"_blank\" style=\"color:#fff\" href=\"http://aristosaigonhotel.com\">aristosaigonhotel.com</a>
                    </span></u> <br> 
                    Email: <u><span>
                            <a style=\"color:#fff\" href=\"mailto:".$hotel['email_info']."\">".$hotel['email_info']."</a></span></u><br>
                    ".Yii::t('lang', 'tel').": ".$hotel['tel']."<br>";

                    if ($hotel['hotline'] !== '') {
                        $html .= 'Hotline: ' . $hotel['hotline'];
                    }
                    $date = date('d M y H:m:i', strtotime($booked->request_date));
                $html .= "</td></tr>
            </table>

            <table style=\"width: 98%;border-collapse: collapse\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
                <tr><td align=\"center\" valign=\"middle\" style=\"font-size:12px;font-family:arial,sans-serif;padding:5px 3px\">
                        <h2 style=\"margin-top: 10px;text-align: center;\">RESERVATION LETTER</h2></td></tr>
                <tr><td align=\"right\" valign=\"middle\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">
                        Booking ID: <strong>{$short_id}</strong><br>
                        Request Date: {$date} Ho Chi Minh City Time</td></tr>
                <tr><td valign=\"middle\">
                        <table width=\"100%\" border=\"0\" style=\"border-collapse:collapse\" cellpadding=\"0\" cellspacing=\"0\"><tr>
                                <td align=\"left\" width=\"150px\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">Booker:</td>
                                <td align=\"left\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">
                                    {$first_name} 
                                    {$last_name}</td></tr>
                            <tr><td align=\"left\" width=\"150px\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">Email:</td>
                                <td align=\"left\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">
                                    <a href=\"mailto:{$booked['email'] }\" target=\"_blank\">
                                        {$booked['email'] }</a>
                                </td></tr></table>
                    </td></tr>
                <tr>
                    <td valign=\"middle\">
                        <table style=\"border-collapse:collapsewidth:100%\" border=\"1\" cellpadding=\"10\" cellspacing=\"0\">
                            <tbody>
                                <tr>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\"><strong>".Yii::t('lang', 'guestname')."</strong></td>
                                    
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\"><strong>".Yii::t('lang', 'promtion')."</strong></td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\"><strong>".Yii::t('lang', 'no_room')."</strong></td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\"><strong>".Yii::t('lang', 'no_adult')."</strong></td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\"><strong>".Yii::t('lang', 'no_of_child')."</strong></td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\"><strong>".Yii::t('lang', 'checkin')."</strong></td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\"><strong>".Yii::t('lang', 'checkout')."</strong></td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\"><strong>".Yii::t('lang', 'rate_per_night'). "({$booked['currency']})</strong></td>
                                </tr>

                                <tr>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">
                                        {$first_name} {$last_name}
                                    </td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">
                                        {$booked['roomtype']['name']}<br>
                                        {$promtion_name}
                                    </td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">{$booked['no_of_room'] }</td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">{$booked['no_of_adults'] }</td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">{$booked['no_of_child']}</td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">{$checkin}</td>
                                    <td align=\"center\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">{$checkout}</td>
                                    <td align=\"center\" style=\"font-size:12pxfont-family:arial,sans-serifpadding:5px 3pxtext-align: centerborder-collapse:collapseborder-bottom: 1px solid #000\">{$rate_vnd}</td>
                                </tr>";

                                if($booked['notes']):        
                                    $html .= "<tr>
                                        <td align=\"left\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\"><strong>Notes</strong></td>
                                        <td align=\"left\" colspan=\"8\" style=\"word-wrap:break-wordwidth:78%padding:10px;font-size:12px;font-family:arial,sans-seriftext-align:left\">
                                            {$booked['notes'] }
                                        </td>
                                    </tr>";
                                endif;
                            $html .= "</tbody>
                        </table>
                    </td>
                </tr>
                
                <tr>
                    <td valign=\"middle\" style=\"border-collapse:collapseborder:1px solid #000000\">
                        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
                            <tbody>

                                <tr>";
                                    if($booked['pickup_price']>0):
                                        $price_pickup = number_format($booked['pickup_price'],2);
                                        $html .= "<td align=\"left\" valign=\"middle\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serifwidth: 10%;border:1px soild #000\"><strong>Arrival airport:</strong></td>
                                        <td align=\"left\" style=\"border-right:1px soild #000word-wrap:break-wordpadding:10px;font-size:12px;font-family:arial,sans-serif;width: 30%\" valign=\"middle\">
                                            {$booked['pickup_flight'] } - {$booked['pickup_time']} {$booked['pickup_date']} - {$price_pickup} VND
                                        </td>";
                                    endif;
                                    
                                    if($booked['dropoff_price']>0):
                                        $price_drop = number_format($booked['dropoff_price'],2);
                                        $html .= "<td align=\"left\" valign=\"middle\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif;width: 15%\"><strong>Departure see off:</strong></td>
                                        <td align=\"left\" style=\"font-size:12px;word-wrap:break-word;padding:5px 3px;border-collapse:collapse;width: 30%;border-right:1px soild #000\">
                                            {$booked['dropoff_flight'] } - {$booked['dropoff_time']} {$booked['dropoff_date']} - {$price_drop} VND
                                        </td>";
                                    endif;
                                    $total_vnd = number_format($booked['total_vnd'], 2);
                                    $total_usd = number_format($booked['total']/$booked['change_currency_rate'],2);
                                $html .= "</tr>
                                <tr><td colspan=\"4\" align=\"left\" style=\"padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;border:1px soild #000\">
                                        For information, please contact: <strong>{$hotel['email_info']}</strong> Tel <strong>{$hotel['tel']}</strong><br></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align=\"left\" valign=\"middle\" style=\"padding:10px;font-size:12px;font-family:arial,sans-serif;border:1px solid #000000\">
                        <strong>Total to be paid in VND (include VAT & Service Charge Rate): {$total_vnd}</strong> (~ {$total_usd} USD)
                    </td>
                </tr>";
                
                if(isset($special_offers[$lang]) && $special_offers[$lang]):
                    $html .= "<tr>
                        <td valign=\"middle\" align=\"left\" style=\"padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;border:1px solid #000000\">
                            {$special_offers[$lang]}
                        </td>
                    </tr>";
                endif;

                $html .= "<tr>
                    <td valign=\"middle\" align=\"left\" style=\"padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;border:1px solid #000000\">
                        <p>Notes: kindly be informed that your booking has not been paid yet. Credit card verification and/or full payment should be requested in 7 days before check-in date.</p>
                    </td>
                </tr>
                <tr>
                    <td valign=\"middle\" align=\"left\" style=\"padding:5px 3px;font-size:12px;font-family:arial,sans-serif;border-collapse:collapse;border:1px solid #000000\">
                        Any cancellations received less than 168 hours (07 days) before 12.00 pm of arrival date will be subject to a cancellation fee, equal to the amount of 01 night room charge. Failure to arrive at your hotel will incur 100% of total amount of the booking.
                    </td>
                </tr>
                <tr>
                    <td style=\"padding:10px;font-size:12px;font-family:arial,sans-serif\">
                        <h3>Terms & Conditions</h3>";
                        $term = json_decode($hotel['term_condition'], true);

    $html .= $term[$lang]. "
                    </td>
                </tr>
            </table>";
        return $html;
    }
    public static $gender2 = array(
        'male' => 'Male',
        'female' => 'Female'
    );
    public static $gender = array(
        '' => 'Title',
        'Mr' => 'Mr',
        'Mrs' => 'Mrs',
        'Miss' => 'Miss'
    );
    public static $user_status=array('A'=>'Active','P'=>'Pendding','U'=>'Unactive');
    public static $bookingStatus=array(
        'confirmed'=>'Confirmed',
        'amended' => 'Amended',
        'failed' => 'Failed',
        'cancelled'=>'Cancelled'
    );

    public static function bookingStatus(){
        if(Yii::app()->user->id == 1){
            return array(
                'confirmed'=>'Confirmed',
                'amended' => 'Amended',
                'failed' => 'Failed',
                'cancelled'=>'Cancelled'
            );
        }else{
            return array(
                'confirmed'=>'Confirmed',
                'amended' => 'Amended',
                'cancelled'=>'Cancelled'
            );
        }
    }

    public static function generateRandomString($length = 10,$loop=1, $number=false) {
        $randomstring = '';
        if ($length > 32) {
            $multiplier = round($length / 32, 0, PHP_ROUND_HALF_DOWN);
            $remainder = $length % 32;
            for ($i = 0; $i < $multiplier; $i++) {
                $randomstring .= substr(str_shuffle(md5(rand())), 0, 32);
            }
            $randomstring .= substr(str_shuffle(md5(rand())), 0, $remainder);
        }
        else{
            if($number){
                //var_dump(mt_rand());
                for($i=0;$i<$loop;$i++){
                    //$randomstring .= mt_rand( 1000000000, 9999999999);    
                    $randomstring .= mt_rand();    
                }
                return $randomstring;
            }else{
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $randomstring = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomstring .= $characters[mt_rand(0, strlen($characters) - 1)];
                }     
                return $randomstring;
            }       
        }
        return $randomstring;
    }

    public static $cartType = array(
        'visa' => 'Visa',
        'mastercard' => 'Master Card',
        'amex' => 'Amex',
        'jcb' => 'JCB'
    );
    public static function year_to_now(){
        $default = 2015;
        $arr_year=array();
        if($default==date('Y')){
            $arr_year[$default]=$default;
        }else{
            for($i=$default;$i<date('Y');$i++){
                $arr_year[$i]=$i;
            }
        }
        return $arr_year;
    }
    public static function year(){
        $now = date('Y');
        $year=array();
        for($i=$now;$i<$now+10;$i++){
            $year[$i]=$i;
        }
        return $year;
    }
    public static function month(){
        $month = array();
        for($i=1;$i<=12;$i++){
            $add_zero=sprintf('%02d',$i);
            $month[$add_zero]= $add_zero;
        }
        return $month;
    }
    public static $currency = array(
        'VND' => 'Vietnamese Dong (VND)', //20
        'USD' => 'US Dollar (USD)', //1
        'EUR' => 'Euro (EUR)', //2
        'GBP' => 'British Pound (GBP)', //3
        'HKD' => 'Hong Kong Dollar (HKD)', //4
        'JPY' => 'Japanese Yen (JPY)', //5
        'CHF' => 'Swiss Franc (CHF)', //6
        'AUD' => 'Australian Dollar (AUD)', //7
        'CAD' => 'Canadian Dollar (CAD)', //8
        'SGD' => 'Singapore Dollar (SGD)', //9
        'THB' => 'Thai Baht (THB)', //10
        'DKK' => 'Danish Krone (DKK)', //11
        'INR' => 'Indian Rupee (INR)', //12
        'KRW' => 'Korean Won (KRW)', //13
        'MYR' => 'Malaysian Ringgit (MYR)', //14
        'KWD' => 'Kuwaiti Dinar (KWD)', //15
        'NOK' => 'Norwegian Krone (NOK)', //16
        'RUB' => 'Russian Ruble (RUB)', //17
        'SAR' => 'Saudi Riyal (SAR)', //18
        'SEK' => 'Swedish Krona (SEK)' //19
    );
    
    public static $status = array(
        0=> 'Publish',
        1=>'Unpublish'
    );

    public static function update_tracking_data(&$model, $update_type="") {
        $now = date('Y-m-d H:i:s');
        if (strtolower($update_type)=="create") {
            $model->added_date = $now;
        }
        $model->updated_date = $now;
        $model->updated_by = Yii::app()->user->id;
    }

    //write log 
    public static function writeLog($type, $object_type, $object_id, $object_name, $old_value, $new_value){
        
        if (Yii::app()->user->id<=0) {
            return FALSE;
        }

        $log = new Trackings;
            $log->type = $type;
            $log->object_id = $object_id;
            $log->object_type = $object_type;
            $log->object_name = $object_name;
            $old_value = ($old_value !== null ? $old_value->attributes : $old_value);
            $new_value = ($new_value !== null ? $new_value->attributes : $new_value);
        if($type !== 'delete'){         
            if($old_value !== null){
                $old_value = array_diff($new_value, $old_value);
                $new_ = '{';
                $i=0;
                foreach ($old_value as $key => $value) {
                    if(isset($new_value[$key])){
                        $new_ .= '"' . $key .'":' . '"' . $new_value[$key] .'"';
                        if($i>= count($old_value)-1){
                            $new_ .='';
                        }else{
                            $new_ .= ',';
                        }
                    }else{
                    }
                    $i++;
                }
                $new_ .= '}';
                $log->value = '{"old_value":['.json_encode($old_value).'], "new_value":[' .$new_ . ']}';
            }else{
                $log->value = '{"old_value":['.json_encode($old_value).'], "new_value":[' .json_encode($new_value) . ']}';
            }
        }else{
            $log->value = '{"old_value":['.json_encode($old_value).'], "new_value":[]}';
        }
        $log->date = date('Y-m-d H:i:s');
        $log->user_id = Yii::app()->user->id;       
        $log->save();

        return TRUE;    
    }
    
    public static function date_diff($date_1 , $date_2 , $format = '%a'){
        $date1=ExtraHelper::date_2_save($date_1);
        $date2=ExtraHelper::date_2_save($date_2);
        $datetime1 = date_create($date1['date']);
        $datetime2 = date_create($date2['date']);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($format);
    }

    public static function date_diff2($date_1, $date_2) {
        $date1=ExtraHelper::date_2_save($date_1);
        $date2=ExtraHelper::date_2_save($date_2);
        $datetime1 = date_create($date1['date']);
        $datetime2 = date_create($date2['date']);        
        $interval = date_diff($datetime1, $datetime2);
        if($datetime1 > $datetime2){
            return -1;
        }else{
            return 1;
        }
    }

    public static function date_2_save($str) {
        $str = strtolower(trim($str));
        $arr = $arr2 = array();
        if ($str) {
            $arr = explode("-", $str);
            $arr2 = explode("/", $str);
        }
        if (count($arr)<3 && count($arr2)<3) {
            return array('valid' => FALSE, 'error' => 'Invalid date format', 'date' => '');
        }
        if (count($arr)>=3) {
            $the_date = strtotime($arr[2] . "-" . $arr[1] . "-" . $arr[0]);
        } else {
            $the_date = strtotime($arr2[2] . "-" . $arr2[1] . "-" . $arr2[0]);
        }
        $date = date("Y-m-d", $the_date);
        if ($date=="1970-01-01") {
            if (count($arr)>=3) {
                if ((int)($arr[0])==1 && ((int)($arr[1])==1 || $arr[1]=='jan' || $arr[1]=='january')) {
                    return array('valid' => TRUE, 'error' => '', 'date' => $date);
                } else {
                    return array('valid' => FALSE, 'error' => 'Invalid date', 'date' => '');
                }
            } else {
                if ((int)($arr2[0])==1 && ((int)($arr2[1])==1 || $arr2[1]=='jan' || $arr2[1]=='january')) {
                    return array('valid' => TRUE, 'error' => '', 'date' => $date);
                } else {
                    return array('valid' => FALSE, 'error' => 'Invalid date', 'date' => '');
                }
            }       
        
        } else {
            return array('valid' => TRUE, 'error' => '', 'date' => $date);
        }
    }

    public static function time_2_show($date, $date_time_separator='', $format='') {
        $ret = '';
        if (!$date) {
            return '';
        }
        if ($date=='0000-00-00' || $date=='0000-00-00 00:00:00') {
            return '';
        }
        if (!$format) {
            $format = "d M Y H:i:s";
        }
        $ret = date($format, strtotime($date));
        if ($date_time_separator) {
            $ret = str_replace(' ', $date_time_separator, $ret);
        }
        return $ret;
    }   
    
    public static function expiry_time_2_show($date) {
        $ret = '';
        if (!$date) {
            return '';
        }
        if ($date=='0000-00-00 00:00:00') {
            return '';
        }
        
        $the_time = strtotime($date);
        $format = "H:i";
        $tmp = date($format, $the_time);
        if ($tmp=="00:00") {
            $format = "d M Y";
        } else {
            $format = "d M Y H:i";
        }
        
        $ret = date($format, $the_time);
        
        return $ret;
    }

    public static function date_2_show($date, $year='') {
        $ret = '';
        if (!$date) {
            return $year ? $year : '';
        }
        if ($date=='0000-00-00' || $date=='0000-00-00 00:00:00') {
            return $year ? $year : '';
        }
        return date("d-m-Y", strtotime($date));
    }

    public static function getListDistinct($object_name, $field_name, $condition=''){
        if (!$field_name) {
            return array();
        }
        $criteria=new CDbCriteria;
        $criteria->distinct = true;
        $criteria->select = array($field_name);
        
        if ($condition) {
            $criteria->addCondition($condition);
        }

        $dataProvider = new CActiveDataProvider($object_name, array(
            'criteria'=>$criteria,
        ));
        $dataProvider->setPagination(false);
        $arrTheList = array();
        $arrTheList = $dataProvider->getData();
        $arrCates = array();
        if(is_array($arrTheList)){
            foreach($arrTheList as $k => $v){
                $text = $v[$field_name];
                $tmp = trim($text);
                if ($tmp) {
                    $arrCates[$text] = $text;
                }
            }
        }
        asort($arrCates);
        return $arrCates;
    }
    
    public static $country = array(
        "PA7" => 'Afghanistan',
        "PA12" => 'Aland Islands',
        "PAL" => 'Albania',
        "PDZ" => 'Algeria',
        "PAD" => 'Andorra',
        "PAO" => 'Angola',
        "PA8" => 'Anguilla',
        "PAG" => 'Antigua and Barbuda',
        "PAR" => 'Argentina',
        "PAM" => 'Armenia',
        "PA11" => 'Aruba',
        "PAU" => 'Australia',
        "PAT" => 'Austria',
        "PAZ" => 'Azerbaijan', "PA2" => 'Bahamas', "PBH" => 'Bahrain', "PBD" => 'Bangladesh', "PBB" => 'Barbados',
        "PBY" => 'Belarus', "PBE" => 'Belgium', "PBZ" => 'Belize', "PBJ" => 'Benin', "PA13" => 'Bermuda', "PA14" => 'Bhutan',
        "PBO" => 'Bolivia', "PBA" => 'Bosnia And Hercegovina', "PBW" => 'Botswana', "PA27" => 'Bouvet Island',
        "PBR" => 'Brazil', "PA32" => 'British Indian Ocean Territory', "PA60" => 'British Virgin Islands', "PBN" => 'Brunei',
        "PBG" => 'Bulgaria', "PBF" => 'Burkina-Faso', "PBI" => 'Burundi', "PKH" => 'Cambodia', "PCM" => 'Cameroon', "PCA" => 'Canada',
        "PA17" => 'Cape Verde', "PA36" => 'Cayman Islands', "PCF" => 'Central African Republic', "PTD" => 'Chad', "PCL" => 'Chile',
        "PCN" => 'China', "PA18" => 'Christmas Island', "PA15" => 'Cocos - Keeling Islands',
        "PCO" => 'Colombia', "PA35" => 'Comoros', "PCG" => 'Congo-Brazzaville', "PA16" => 'Cook Islands', "PCR" => 'Costa Rica',
        "PHR" => 'Croatia', "PCU" => 'Cuba', "PCY" => 'Cyprus', "PCZ" => 'Czech Republic', "PCD" => 'Democratic Repub. of Congo',
        "PDK" => 'Denmark', "PDJ" => 'Djibouti', "PDM" => 'Dominica', "PDO" => 'Dominican Republic', "PEC" => 'Ecuador', "PEG" => 'Egypt',
        "PSV" => 'El Salvador', "PGQ" => 'Equatorial Guinea', "PER" => 'Eritrea', "PEE" => 'Estonia', "PET" => 'Ethiopia',
        "PA20" => 'Falkland Islands/Malvinas', "PA22" => 'Faroe Islands', "PA1" => 'Fiji Islands', "PFI" => 'Finland',
        "PFR" => 'France', "PGF" => 'French Guiana', "PPF" => 'French Polynesia', "PGA" => 'Gabon', "PGM" => 'Gambia', "PGE" => 'Georgia',
        "PDE" => 'Germany', "PGH" => 'Ghana', "PGI" => 'Gibraltar', "PGR" => 'Greece', "PA28" => 'Greenland', "PA23" => 'Grenada',
        "PGP" => 'Guadeloupe', "PA26" => 'Guam', "PGT" => 'Guatemala', "PA24" => 'Guernsey', "PGN" => 'Guinea', "PA29" => 'Guinea Bissau',
        "PGY" => 'Guyana', "PHT" => 'Haiti', "PA30" => 'Heard Island McDonald Islands', "PHN" => 'Honduras', "PA69" => 'Hong Kong',
        "PHU" => 'Hungary', "PIS" => 'Iceland', "PIN" => 'India', "PID" => 'Indonesia', "PIR" => 'Iran', "PIQ" => 'Iraq', "PIE" => 'Ireland',
        "PA31" => 'Isle of Man', "PIL" => 'Israel', "PIT" => 'Italy', "PCI" => 'Ivory  Coast', "PJM" => 'Jamaica', "PJP" => 'Japan',
        "PA33" => 'Jersey', "PJO" => 'Jordan', "PKZ" => 'Kazakhstan', "PKE" => 'Kenya', "PA34" => 'Kiribati', "PA71" => 'Kosovo',
        "PKW" => 'Kuwait', "PKG" => 'Kyrgyzstan', "PLA" => 'Lao people\'s democratic republic', "PLV" => 'Latvia', "PLB" => 'Lebanon',
        "PA40" => 'Lesotho', "PA39" => 'Liberia', "PLY" => 'Libya', "PA38" => 'Liechtenstein', "PLT" => 'Lithuania', "PLU" => 'Luxembourg',
        "PA70" => 'Macau', "PMK" => 'Macedonia', "PMG" => 'Madagascar', "PMW" => 'Malawi', "PMY" => 'Malaysia', "PA3" => 'Maldives',
        "PML" => 'Mali', "PMT" => 'Malta', "PA41" => 'Marshall Island Republic', "PMQ" => 'Martinique', "PMR" => 'Mauritania',
        "PMU" => 'Mauritius', "PYT" => 'Mayotte', "PMX" => 'Mexico', "PA21" => 'Micronesia Federated States Of', "PMD" => 'Moldova',
        "PMC" => 'Monaco', "PMN" => 'Mongolia', "PA68" => 'Montenegro', "PA43" => 'Montserrat', "PMA" => 'Morocco', "PMZ" => 'Mozambique',
        "PMM" => 'Myanmar', "PNA" => 'Namibia', "PA44" => 'Nauru', "PNP" => 'Nepal', "PNL" => 'Netherlands', "PA9" => 'Netherlands Antilles',
        "PNC" => 'New Caledonia', "PNZ" => 'New Zealand', "PNI" => 'Nicaragua', "PNE" => 'Niger', "PNG" => 'Nigeria', "PA45" => 'Niue',
        "PA6" => 'Norfolk Island', "PKP" => 'North Korea', "PA42" => 'Northern Mariana Islands', "PNO" => 'Norway', "POM" => 'Oman',
        "PPK" => 'Pakistan', "PA48" => 'Palau', "PA47" => 'Palestinian Territory', "PPA" => 'Panama', "PPG" => 'Papua new guinea',
        "PPY" => 'Paraguay', "PPE" => 'Peru', "PPH" => 'Philippines', "PA46" => 'Pitcairn', "PPL" => 'Poland', "PPT" => 'Portugal',
        "PPR" => 'Puerto Rico', "PQA" => 'Qatar', "PRE" => 'Reunion', "PRO" => 'Romania', "PRU" => 'Russia', "PRW" => 'Rwanda',
        "PSF" => 'Saint Barthelemy', "PA66" => 'Saint Helena', "PKN" => 'Saint Kitts and Nevis', "PA37" => 'Saint Lucia',
        "PA65" => 'Saint Martin', "PA10" => 'Samoa American', "PA64" => 'Samoa Western', "PSM" => 'San Marino',
        "PA52" => 'Sao Tome and Principe', "PSA" => 'Saudi Arabia', "PSN" => 'Senegal', "PA67" => 'Serbia', "PA50" => 'Seychelles Islands',
        "PSL" => 'Sierra Leone', "PSG" => 'Singapore', "PSK" => 'Slovakia', "PSI" => 'Slovenia', "PA49" => 'Solomon Islands',
        "PSO" => 'Somalia', "PZA" => 'South Africa', "PA25" => 'South Georgia South Sandwich Isl', "PKR" => 'South Korea',
        "PES" => 'Spain', "PLK" => 'Sri lanka', "PPM" => 'St Pierre and Miquelon', "PA59" => 'St Vincent and The Grenadines',
        "PSD" => 'Sudan', "PSR" => 'Suriname', "PA51" => 'Svalbard and Jan Mayen', "PA53" => 'Swaziland', "PSE" => 'Sweden',
        "PCH" => 'Switzerland', "PSY" => 'Syria', "PTW" => 'Taiwan', "PTJ" => 'Tajikistan', "PTZ" => 'Tanzania', "PTH" => 'Thailand',
        "PA55" => 'Timor Leste', "PTG" => 'Togo', "PA54" => 'Tokelau', "PA56" => 'Tonga', "PTT" => 'Trinidad and Tobago', "PTN" => 'Tunisia',
        "PTR" => 'Turkey', "PTM" => 'Turkmenistan', "PA4" => 'Turks and Caicos', "PA57" => 'Tuvalu', "PUG" => 'Uganda', "PUA" => 'Ukraine',
        "PAE" => 'United Arab Emirates', "PGB" => 'United Kingdom', "PUS" => 'United States', "PA58" => 'United States Minor Outlying Isl',
        "PUY" => 'Uruguay', "PUZ" => 'Uzbekistan', "PA62" => 'Vanuatu', "PVA" => 'Vatican', "PVE" => 'Venezuela', "PVN" => 'Vietnam',
        "PA61" => 'Virgin Islands US', "PA63" => 'Wallis and Futuna Islands', "PA19" => 'Western Sahara', "PYE" => 'Yemen', "PZM" => 'Zambia',
        "PZW" => 'Zimbabwe'
    );
}