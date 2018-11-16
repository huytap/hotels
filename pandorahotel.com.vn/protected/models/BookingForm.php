<?php

class BookingForm extends CFormModel{
	public $first_name;
	public $last_name;
	public $email;
	public $email_confirm;
	public $country;
    public $phone;
    public $address;
    public $notes;
    public $card_number;
   	public $card_name;
   	public $card_expired_month;
   	public $card_expired_year;
   	public $card_type;
    public $card_cvv;
    public $pickup;
    public $pickup_flight;
    public $pickup_date;
    public $pickup_time;
    public $pickup_vehicle;
	public $dropoff;
	public $drop_flight;
	public $drop_date;
	public $drop_time;
	public $dropoff_vehicle;
	public $extrabed=array();
	public $tour_id, $tour_max_adult, $tour_name, $condition, $passport, $title;

	public function rules(){
		return array(
			array('condition,title, first_name, last_name, email, email_confirm, country,condition, card_number, card_name, card_expired_month, card_expired_year, card_cvv, card_type', 'required', 'message' => Yii::t('lang', 'please_enter').' {attribute}'),
			/*array('title, first_name, last_name, email, email_confirm, country', 'required', 'message' => 'Please enter {attribute}', 'on' => 'detail'),
			array('condition, card_number, card_name, card_expired_month, card_expired_year, card_cvv, card_type', 'required', 'message' => 'Please enter {attribute}', 'on'=>'payment'),*/
			array('tour_id, card_number, card_cvv', 'numerical', 'integerOnly'=>true),
			array('card_number', 'length', 'max'=>18),
			array('passport', 'length', 'max'=>32),
			array('first_name, last_name, phone', 'length', 'max'=>20),
			array('email, card_name', 'length', 'max'=>128),
			array('pickup,drop_time, drop_date, drop_flight, pickup_time, pickup_date, pickup_flight, dropoff,country', 'length', 'max'=>100),
			array('address, notes,extrabed, tour_name, tour_max_adult, pickup_vehicle, dropoff_vehicle', 'safe'),
			array('email, email_confirm', 'email', 'message' => 'Email not true'),
			array('email_confirm', 'compare', 'compareAttribute'=>'email', 'message' => Yii::t('lang', 'mess_email')),
			array('card_expired_year', 'compareExpiredCard'),
			array('card_number', 'checkCard'),
			array('pickup', 'checkairport'),
			array('condition', 'agreeCondition')
		);
	}

	public function agreeCondition($attribute, $params){
		if(!$this->condition){
			$this->addError('condition', Yii::t('lang', 'please_term'));
		}
	}
	public function compareExpiredCard($attribute, $params){
		$booked = Yii::app()->session['_booked'];
		$month = sprintf('%02d',$this->card_expired_month);
		$expire = '01-'.$month .'-'.$this->card_expired_year;
		$checkin = date('Y-m', strtotime($booked['checkin']));
		$checkCard = new ECCValidator;
		/*
		$checkexpire = $checkCard->validateDate($this->card_expired_month, $this->card_expired_year);
        if(!$checkexpire){
        	$this->addError('card_expired_month', Yii::t('lang','card_is_expired'));
        }*/
        $cardName = $checkCard->validateName($this->card_name);
        if(!$cardName){
        	$this->addError('card_name', Yii::t('lang', 'card_name_error'));
        }
		if(ExtraHelper::date_diff2($booked['checkin'], $expire) == -1){
			$this->addError('card_expired_month', Yii::t('lang', 'before_checkin'));
		}
	}

	public function checkairport($attribute, $params){
		if(($this->pickup_flight || $this->pickup_date || $this->pickup_time) && $this->pickup == ''){
			$this->addError('pickup', Yii::t('please_vehicle'));
		}
	}

	public function checkCard($attribute, $params){
        $card = $this->card_number;
        $card_type = $this->card_type;
        $checkCard = new ECCValidator;
        $checkCard->format = array(
            'mastercard' => ECCValidator::MASTERCARD,
            'visa' => ECCValidator::VISA,
            'amex' => ECCValidator::AMERICAN_EXPRESS,
            'jcb' => ECCValidator::JCB
        );
        if (!$checkCard->validateNumber($card)){
            $this->addError('card_number', Yii::t('lang', 'invalid_card'));
        }
	}
	public function attributeLabels(){
		return array(
			'title' => Yii::t('lang', 'title'),
			'passport' => 'Passport Number',
			'condition' => Yii::t('lang', 'term_condition'),
			'tour_id' => Yii::t('lang', 'tours'),
			'first_name' => Yii::t('lang', 'first_name'),
			'last_name' => Yii::t('lang', 'last_name'),
			'email' => Yii::t('lang', 'email_address'),
			'email_confirm' => Yii::t('lang', 're_email_address'),
			'pickup_flight' => Yii::t('lang', 'arrival_flight'),
    		'pickup_date' => Yii::t('lang', 'date'),
    		'pickup_time' => Yii::t('lang', 'time_flight'),
    		'drop_flight' => Yii::t('lang', 'departure_flight'),
    		'drop_date' => Yii::t('lang', 'date'),
    		'drop_time' => Yii::t('lang', 'time_flight'),
    		
			'pickup' => Yii::t('lang', 'vehicle_type').' '. Yii::t('lang','airport_pickup'),
			'dropoff' => Yii::t('lang', 'vehicle_type').' '. Yii::t('lang','airport_drop_off'),
			'country' => Yii::t('lang', 'country'),
			'phone' => Yii::t('lang', 'phonnumber'),
			'card_type'=> Yii::t('lang', 'card_detail'),
			'card_number' => Yii::t('lang', 'card_no'),
			'card_name' => Yii::t('lang', 'card_name'),
			'card_expired_month' => Yii::t('lang', 'card_month'),
			'card_expired_year' => Yii::t('lang', 'card_year'),
			'card_cvv' => Yii::t('lang', 'cvv'),
			'notes' => Yii::t('lang','special_request'),
			'extrabed' => 'Need extra bed?'
		);
	}

	public function gender(){
        return array(
        	'' => Yii::t('lang', 'title'),
        	'Mr' => Yii::t('lang', 'mr'),
        	'Mrs' => Yii::t('lang', 'mrs'),
        	'Ms' => Yii::t('lang', 'Ms'),
        	'Dr' => 'Dr'
        );
    }
}