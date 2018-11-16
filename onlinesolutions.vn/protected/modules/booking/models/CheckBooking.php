<?php
class CheckBooking extends CFormModel{
	public $email;
	public $bookingid;
	public function rules(){
		return array(
			array('email, bookingid', 'required'),
			//array('email, bookingid', 'authenticate'),
		);
	}

	public function attributeLabels(){
		return array(
			'email'=>'Email',
			'bookingid' => 'Booking ID'
		);
	}

	public function authenticate($attribute,$params){
		$check = Booking::model()->getByEmail_ShortID($this->email, $this->bookingid);

		if(!$check){
			$this->addError('Email or Booking ID incorrect');
		}
	}
}
