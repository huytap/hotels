<?php
class MyUrlManager extends CUrlManager{

   public $dbTable = 'cms';

   protected function processRules(){
      $language = Yii::app()->params['language_configs'];
      $lang = '';
      $i=0;
      foreach ($language as $key => $value) {
         $lang .=$key;
         if($i<count($language)-1){
            $lang .= '|';
         }
         $i++;
      }
      //cms
      /*$rows = Yii::app()->db->createCommand()->select('*')->from($this->dbTable)->where('status=0')->queryAll();
      $string_parttern='';
      $j=0;
      foreach ($rows as $row){
         $string_parttern .= $row['slug'];
         if($j<count($rows)-1){
            $string_parttern .= '|';
         }
         $j++;
      }*/ 
      //hotel
      $hotels = Yii::app()->db->createCommand()->select('*')->from('hotels')->where('status=0')->queryAll();
      $hotel_parttern=$hotel_chain='';
      $j=0;
      foreach ($hotels as $hotel){
         //$hotel_parttern .= $hotel['slug'];
         $hotel_parttern .= $hotel['hotel_id'];
         $hotel_chain .= $hotel['chain_id'];
         if($j<count($hotels)-1){
            $hotel_parttern .= '|';
            $hotel_chain .= '|';
         }
         $j++;
      } 

      $this->rules = array(
	 'services/<hotel_id:\S+>/<hotel_chain:\S+>' => 'api/services/index',
         'admin' => 'admin/site/login',
	 'du-an.html' => 'site/project',
         'gioi-thieu.html' => 'site/about',
         'dich-vu.html' => 'site/service',
         'lien-he.html' => 'site/contact',
	'booking-engine.html' => 'site/booking',         //booking
	 //'http://secure.eratoboutiquehotel.com/<booking:booking>/<hotel_id:HCM-2016-09-00001>/<chain_id:CHAIN-2016-09-00001>' => 'booking/booking/index',
         '<booking:booking>/<hotel_id:'.$hotel_parttern.'>/<chain_id:'.$hotel_chain.'>' => 'booking/booking/index',
         'booknow' => 'booking/booking/prebook',
         'booking/<booking:option>' => 'booking/booking/option',
         'booking/<booking:payment>' => 'booking/booking/payment',
         //'booking/<booking:thankyou>' => 'booking/booking/thankyou',
         'booking/<hotel_id:'.$hotel_parttern.'>/<booking:thankyou>' => 'booking/booking/thankyou',
         //'booking//<booking:change>/<hotel_id:'.$hotel_parttern.'>/<chain_id:'.$hotel_chain.'>' => 'booking/booking/change',
         //end booking
         'booking/getservices' => 'booking/booking/getservices',
         'ajax/term' => 'ajax/term',
         'removecart' => 'ajax/removebooking',
         'booking/login/<hotel_id:'.$hotel_parttern.'>/<chain_id:'.$hotel_chain.'>' => 'booking/history/checkbooking',
         'history/<hotel_id:'.$hotel_parttern.'>/<chain_id:'.$hotel_chain.'>' => 'booking/history/index',
         'booking/cancel' => 'booking/history/cancel',
         'booking/modify/<token:\S+>' => 'booking/history/modify',
         '/' => 'site/index',
         
      );

      parent::processRules();

   }

}