<?php

class FormBook extends CFormModel{
	public $checkin;
	public $checkout;
	public $adult;
	public $children;
	public $hotel;
	public $no_room;

	public function rules(){
		return array(
			array('checkin, checkout, adult, children', 'required', 'message' => Yii::t('lang', 'please_enter').' {attribute}'),
			array('adult, children, hotel,no_room', 'numerical', 'integerOnly'=>true),
			array('checkin', 'checkDate'),
			array('hotel', 'checkHotel', 'on' => 'hotel'),
		);
	}

	public function checkHotel($attribute, $params){
		if($this->hotel == '' && !isset($_GET['hotel'])){
			$this->addError('hotel', Yii::t('lang', 'please_select_hotel'));
		}
	}
	public function checkDate($attribute, $params){
		$now = date('d-m-Y');
		if(ExtraHelper::date_diff2($this->checkin, $this->checkout) == -1){
			$this->addError('checkin', 'Arrival Date must be before Departure Date');
		}elseif(ExtraHelper::date_diff2($now, $this->checkin) == -1){
			$this->addError('checkin', 'Arrival Date must be before current date');
		}
	}

	public function attributeLabels(){
		return array(
			'checkin' => 'Arrival Date',
			'checkout' => 'Departure Date',
			'adult' => 'Adult',
			'children' => 'Children',
			'no_room' => 'Rooms'
		);
	}
}